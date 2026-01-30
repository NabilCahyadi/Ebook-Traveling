<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use App\Services\MayarService;
use App\Models\SubscriptionPlan;
use App\Models\City;
use App\Repositories\SubscriptionProcessRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class SubscriptionController extends Controller
{
    protected $subscriptionProcessRepository;
    protected $mayarService;

    public function __construct(SubscriptionProcessRepository $subscriptionProcessRepository, MayarService $mayarService) // <-- GANTI INI
    {
        $this->subscriptionProcessRepository = $subscriptionProcessRepository;
        $this->mayarService = $mayarService;
    }

    /**
     * Endpoint untuk menerima callback dari Mayar.id
     * URL: POST /api/payment/mayar-callback
     */
    public function mayarCallback(Request $request)
    {
        // ✅ LOG 1: Webhook received
        Log::info('🔔 Mayar Webhook Received', [
            'headers' => $request->headers->all(),
            'ip' => $request->ip(),
            'method' => $request->method(),
        ]);

        try {
            // ✅ LOG 2: Raw payload
            $payload = $request->getContent();
            Log::info('📦 Webhook Payload', [
                'raw' => $payload,
                'json' => $request->json()->all(),
            ]);

            // Validasi signature - Mayar sends webhook token directly in X-Callback-Token header
            $receivedToken = $request->header('X-Callback-Token');
            $webhookToken = config('services.mayar.webhook_token');

            // ✅ LOG 3: Signature validation
            Log::info('🔐 Signature Validation', [
                'received_token' => $receivedToken,
                'webhook_token_exists' => !empty($webhookToken),
                'tokens_match' => $receivedToken === $webhookToken,
            ]);

            if (!$webhookToken) {
                Log::error('❌ MAYAR_WEBHOOK_TOKEN not configured in .env');
                return response('Webhook token not configured', 500);
            }

            // Mayar sends the webhook token directly, not HMAC signature
            if ($receivedToken !== $webhookToken) {
                Log::error('❌ Invalid webhook token', [
                    'received' => $receivedToken,
                    'expected' => $webhookToken,
                ]);
                return response('Unauthorized', 401);
            }

            Log::info('✅ Signature validated successfully');

            // Parse data
            $data = $request->json('data', []);
            $event = $request->json('event', '');

            // ✅ LOG 4: Event info
            Log::info('📋 Webhook Event', [
                'event' => $event,
                'status' => $data['status'] ?? 'N/A',
                'external_id' => $data['externalId'] ?? 'N/A',
                'product_name' => $data['productName'] ?? 'N/A',
                'amount' => $data['amount'] ?? 'N/A',
            ]);

            // Check event type
            if ($event !== 'payment.received' || ($data['status'] ?? '') !== 'SUCCESS') {
                Log::info('⏭️ Skipping webhook - not a successful payment event', [
                    'event' => $event,
                    'status' => $data['status'] ?? 'N/A',
                ]);
                return response('OK', 200);
            }

            // Get user by email
            $email = $data['customerEmail'] ?? '';
            $externalId = $data['externalId'] ?? null;

            Log::info('🔍 Looking for user', [
                'email' => $email,
                'external_id' => $externalId,
            ]);

            $user = DB::table('users')->where('email', $email)->first();

            if (!$user) {
                Log::warning('⚠️ User not found', ['email' => $email]);
                return response('OK', 200);
            }

            Log::info('✅ User found', [
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]);

            // ✅ Get payment record and detect payment type FIRST
            $paymentType = 'new'; // default
            $payment = null;
            $planFromPayment = null;

            if ($externalId) {
                // ✅ CASE 1: Mayar mengirim external_id (IDEAL)
                $payment = DB::table('payments')->where('id', $externalId)->first();

                if ($payment) {
                    $paymentType = $payment->payment_type ?? 'new';

                    // ✅ Get plan from payment record (more reliable)
                    if ($payment->subscription_plan_id) {
                        $planFromPayment = DB::table('subscription_plans')
                            ->where('id', $payment->subscription_plan_id)
                            ->first();
                    }

                    Log::info('💳 Payment record found by external_id', [
                        'payment_id' => $externalId,
                        'payment_type' => $paymentType,
                        'payment_status' => $payment->status,
                        'plan_id_from_payment' => $payment->subscription_plan_id,
                    ]);
                } else {
                    Log::warning('⚠️ Payment record not found by external_id', ['external_id' => $externalId]);
                }
            } else {
                // ✅ CASE 2: Mayar TIDAK mengirim external_id (FALLBACK)
                // Cari payment terbaru dari user ini yang masih pending
                Log::warning('⚠️ No external_id from Mayar, searching by user email and plan');

                $payment = DB::table('payments')
                    ->where('user_id', $user->id)
                    ->where('status', 'pending')
                    ->orderBy('created_at', 'desc')
                    ->first();

                if ($payment) {
                    $paymentType = $payment->payment_type ?? 'new';
                    $externalId = $payment->id; // Set external_id dari payment yang ditemukan

                    // ✅ Get plan from payment record
                    if ($payment->subscription_plan_id) {
                        $planFromPayment = DB::table('subscription_plans')
                            ->where('id', $payment->subscription_plan_id)
                            ->first();
                    }

                    Log::info('💳 Payment record found by user (fallback)', [
                        'payment_id' => $payment->id,
                        'payment_type' => $paymentType,
                        'payment_status' => $payment->status,
                        'plan_id_from_payment' => $payment->subscription_plan_id,
                        'created_at' => $payment->created_at,
                    ]);
                } else {
                    Log::warning('⚠️ No pending payment found for user', ['user_id' => $user->id]);
                }
            }

            // ✅ Get plan (from payment record OR from Mayar productName)
            $plan = $planFromPayment;

            if (!$plan) {
                // Fallback: Find plan by Mayar productName
                $productName = trim($data['productName'] ?? '');

                // Try exact match first
                $plan = DB::table('subscription_plans')
                    ->where('name', $productName)
                    ->where('is_active', true)
                    ->first();

                // Try case-insensitive match if exact match fails
                if (!$plan) {
                    $plan = DB::table('subscription_plans')
                        ->whereRaw('LOWER(name) = ?', [strtolower($productName)])
                        ->where('is_active', true)
                        ->first();
                }

                if (!$plan) {
                    Log::warning('⚠️ Plan not found by name', [
                        'product_name' => $productName,
                        'product_name_lower' => strtolower($productName),
                    ]);

                    // Last fallback: get any active plan
                    $plan = DB::table('subscription_plans')
                        ->where('is_active', true)
                        ->orderBy('duration_days', 'asc')
                        ->first();

                    if ($plan) {
                        Log::info('⚠️ Using first active plan as fallback', [
                            'plan_id' => $plan->id,
                            'plan_name' => $plan->name,
                        ]);
                    }
                }
            }

            if (!$plan) {
                Log::error('❌ No plan found - cannot process subscription', [
                    'product_name_from_mayar' => $data['productName'] ?? 'N/A',
                    'user_email' => $user->email,
                    'user_id' => $user->id,
                    'available_plans' => DB::table('subscription_plans')
                        ->where('is_active', true)
                        ->select('name')
                        ->get()
                        ->pluck('name')
                        ->toArray(),
                ]);
                return response('Plan not found', 400);
            }

            Log::info('📦 Plan found', [
                'plan_id' => $plan->id,
                'plan_name' => $plan->name,
                'duration_days' => $plan->duration_days,
                'price' => $plan->price,
                'payment_type' => $paymentType,
            ]);

            // Handle different payment types
            if ($paymentType === 'renewal') {
                // ✅ RENEWAL: Extend existing subscription end_date
                Log::info('🔄 Processing renewal payment');

                // ✅ UPDATE PAYMENT STATUS TO SUCCESS
                if ($externalId && $payment) {
                    DB::table('payments')
                        ->where('id', $externalId)
                        ->update([
                            'status' => 'success',
                            'paid_at' => now(),
                            'updated_at' => now(),
                        ]);
                    Log::info('💳 Renewal payment updated to success', [
                        'payment_id' => $externalId,
                        'old_status' => $payment->status,
                        'new_status' => 'success',
                    ]);
                }

                $existingSubscription = DB::table('subscriptions')
                    ->where('user_id', $user->id)
                    ->where('status', 'active')
                    ->first();

                if (!$existingSubscription) {
                    Log::error('❌ No active subscription found for renewal');
                    return response('No active subscription to renew', 400);
                }

                // ✅ Extend end_date: current end_date + plan duration_days
                // IMPORTANT: Use Carbon for proper date calculation
                $currentEndDate = \Carbon\Carbon::parse($existingSubscription->end_date);
                $newEndDate = $currentEndDate->copy()->addDays($plan->duration_days);

                DB::table('subscriptions')
                    ->where('id', $existingSubscription->id)
                    ->update([
                        'end_date' => $newEndDate->format('Y-m-d H:i:s'),
                        'updated_at' => now(),
                    ]);

                Log::info('🎉 Subscription renewed successfully', [
                    'subscription_id' => $existingSubscription->id,
                    'subscription_code' => $existingSubscription->subscription_code,
                    'old_end_date' => $existingSubscription->end_date,
                    'new_end_date' => $newEndDate->format('Y-m-d H:i:s'),
                    'extended_days' => $plan->duration_days,
                    'plan_name' => $plan->name,
                ]);

                return response('OK', 200);

            } elseif ($paymentType === 'upgrade' || $paymentType === 'downgrade') {
                // ✅ UPGRADE/DOWNGRADE: Update plan + extend duration (DO NOT DELETE OLD DURATION)
                Log::info($paymentType === 'upgrade' ? '⬆️ Processing upgrade payment' : '⬇️ Processing downgrade payment');

                // ✅ UPDATE PAYMENT STATUS TO SUCCESS
                if ($externalId && $payment) {
                    DB::table('payments')
                        ->where('id', $externalId)
                        ->update([
                            'status' => 'success',
                            'paid_at' => now(),
                            'updated_at' => now(),
                        ]);
                    Log::info('💳 ' . ucfirst($paymentType) . ' payment updated to success', [
                        'payment_id' => $externalId,
                        'old_status' => $payment->status,
                        'new_status' => 'success',
                    ]);
                }

                $existingSubscription = DB::table('subscriptions')
                    ->where('user_id', $user->id)
                    ->where('status', 'active')
                    ->where('end_date', '>=', now())
                    ->orderBy('end_date', 'desc')
                    ->first();

                if ($existingSubscription) {
                    // ✅ UPDATE existing subscription: change plan + extend duration
                    $oldPlanId = $existingSubscription->subscription_plan_id;
                    $currentEndDate = \Carbon\Carbon::parse($existingSubscription->end_date);
                    $newEndDate = $currentEndDate->copy()->addDays($plan->duration_days);

                    DB::table('subscriptions')
                        ->where('id', $existingSubscription->id)
                        ->update([
                            'subscription_plan_id' => $plan->id,
                            'end_date' => $newEndDate->format('Y-m-d H:i:s'),
                            'total_amount' => DB::raw("`total_amount` + {$plan->price}"),
                            'updated_at' => now(),
                        ]);

                    Log::info('🎉 Subscription ' . $paymentType . ' successfully', [
                        'subscription_id' => $existingSubscription->id,
                        'subscription_code' => $existingSubscription->subscription_code,
                        'old_plan_id' => $oldPlanId,
                        'new_plan_id' => $plan->id,
                        'new_plan_name' => $plan->name,
                        'old_end_date' => $existingSubscription->end_date,
                        'new_end_date' => $newEndDate->format('Y-m-d H:i:s'),
                        'extended_days' => $plan->duration_days,
                        'operation' => $paymentType,
                    ]);
                } else {
                    Log::error('❌ No active subscription found for ' . $paymentType);
                    return response('No active subscription to ' . $paymentType, 400);
                }

                return response('OK', 200);

            } else {
                // ✅ NEW SUBSCRIPTION: Create new subscription (existing logic)
                Log::info('🆕 Processing new subscription payment');

                // ✅ UPDATE PAYMENT STATUS TO SUCCESS + SET PAYMENT_TYPE
                if ($externalId && $payment) {
                    DB::table('payments')
                        ->where('id', $externalId)
                        ->update([
                            'status' => 'success',
                            'payment_type' => 'new', // ✅ Ensure payment_type is 'new'
                            'paid_at' => now(),
                            'updated_at' => now(),
                        ]);
                    Log::info('💳 New subscription payment updated to success', [
                        'payment_id' => $externalId,
                        'old_status' => $payment->status,
                        'new_status' => 'success',
                        'payment_type' => 'new',
                    ]);
                }

                // Check for existing active subscription to prevent duplicates
                $existingSubscription = DB::table('subscriptions')
                    ->where('user_id', $user->id)
                    ->where('status', 'active')
                    ->where('end_date', '>', now())
                    ->first();

                if ($existingSubscription) {
                    Log::info('ℹ️ User already has active subscription, skipping creation', [
                        'existing_sub_id' => $existingSubscription->id,
                        'end_date' => $existingSubscription->end_date,
                    ]);
                    return response('OK', 200);
                }

                // Create subscription
                $subscription = Subscription::create([
                    'user_id' => $user->id,
                    'subscription_plan_id' => $plan->id,
                    'payment_id' => $externalId, // Link to payment
                    'status' => 'active',
                    'start_date' => now(),
                    'end_date' => now()->addDays($plan->duration_days),
                    'subscription_code' => 'SUB-' . strtoupper(Str::random(8)),
                    'total_amount' => $plan->price,
                    'auto_renew' => false,
                ]);

                Log::info('🎉 Subscription created successfully', [
                    'subscription_id' => $subscription->id,
                    'subscription_code' => $subscription->subscription_code,
                    'user_id' => $user->id,
                    'user_email' => $user->email,
                    'plan_id' => $plan->id,
                    'plan_name' => $plan->name,
                    'start_date' => $subscription->start_date->toDateTimeString(),
                    'end_date' => $subscription->end_date->toDateTimeString(),
                    'status' => $subscription->status,
                    'total_amount' => $subscription->total_amount,
                ]);

                return response('OK', 200);
            }

        } catch (\Exception $e) {
            // ✅ LOG ERROR with full details
            Log::error('❌ Mayar Webhook Error', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Simpan error ke session untuk ditampilkan di success page
            session(['webhook_error' => $e->getMessage()]);

            return response('OK', 200); // Still return 200 to prevent Mayar retry
        }
    }

    public function redirectToPaymentLink(string $slug): RedirectResponse
    {
        $user = auth()->user();
        $plan = SubscriptionPlan::where('slug', $slug)->firstOrFail();

        // Simpan payment record
        $paymentId = (string) Str::uuid();
        DB::table('payments')->insert([
            'id' => $paymentId,
            'user_id' => $user->id,
            'subscription_plan_id' => $plan->id, // UUID plan
            'amount' => $plan->price,
            'status' => 'pending',
            'payment_method' => 'mayar',
            'payment_type' => 'new', // ✅ Set payment_type untuk new subscription
            'payment_code' => 'PAY-' . strtoupper(Str::random(8)),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ✅ PERBAIKAN: Gunakan MayarService untuk create payment link via API
        // Ini memastikan return_url correct dan auto-fill parameters terintegrasi
        $mayarService = new \App\Services\MayarService();
        $response = $mayarService->createPaymentLinkViaMayarAPI($user, $plan, $paymentId);

        if (!$response['success']) {
            Log::error('Failed to create payment link', [
                'payment_id' => $paymentId,
                'plan' => $plan->slug,
                'error' => $response['message']
            ]);
            return redirect()->back()->with('error', 'Failed to create payment link. Please try again.');
        }

        $paymentUrl = $response['data']['payment_url'];

        Log::info('Redirecting to Mayar payment', [
            'payment_id' => $paymentId,
            'url' => $paymentUrl
        ]);

        return redirect($paymentUrl);
    }

    public function paymentSuccess()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('message', 'Please log in to access your account.');
        }

        $user = auth()->user();
        $user->load(['currentSubscription', 'subscriptions.plan']);

        // Refresh premium status in session
        session()->forget('user_premium_status');
        session()->put('user_premium_status', $user->hasActiveSubscription());

        // ✅ Redirect ke page-account dengan query string yang clean (tanpa external_id)
        return redirect()->route('page-account', ['tab' => 'dashboard'])->with('payment_success', true);
    }

    /**
     * Tampilkan halaman perpanjangan langganan
     */
    public function extend(Request $request, string $planSlug)
    {
        $plan = SubscriptionPlan::where('slug', $planSlug)->firstOrFail();
        $user = $request->user();

        // Validasi: pastikan ini paket aktif
        $currentSub = $user->currentSubscription;
        if (!$currentSub || $currentSub->subscription_plan_id !== $plan->id) {
            return redirect()->route('pricing')
                ->with('error', 'Only active plan can be extended.');
        }

        return view('subscription.extend', compact('plan', 'currentSub'));
    }

    /**
     * Tampilkan halaman upgrade paket
     */
    public function upgrade(Request $request, string $planSlug)
    {
        $plan = SubscriptionPlan::where('slug', $planSlug)->firstOrFail();
        $user = $request->user();

        // Validasi: tidak boleh downgrade ke paket lebih murah
        $currentPlan = $user->currentPlan;
        if ($currentPlan && $plan->price < $currentPlan->price) {
            return redirect()->route('pricing')
                ->with('warning', 'Cannot downgrade to a cheaper plan.');
        }

        return view('subscription.upgrade', compact('plan', 'currentPlan'));
    }

    /**
     * Process subscription renewal (extends current plan)
     * Renews the SAME plan the user currently has
     */
    public function renewSubscription(Request $request): RedirectResponse
    {
        $user = auth()->user();

        // ✅ LOG: Renew request started
        Log::info('🔄 Renewal request started', [
            'user_id' => $user->id,
            'user_email' => $user->email,
        ]);

        // Get current active subscription
        $currentSubscription = DB::table('subscriptions')
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->first();

        if (!$currentSubscription) {
            Log::warning('⚠️ No active subscription found for renewal', [
                'user_id' => $user->id,
            ]);
            return redirect()->back()->with('error', 'No active subscription to renew.');
        }

        // Get the plan
        $plan = SubscriptionPlan::find($currentSubscription->subscription_plan_id);

        if (!$plan) {
            Log::error('❌ Plan not found for renewal', [
                'plan_id' => $currentSubscription->subscription_plan_id,
            ]);
            return redirect()->back()->with('error', 'Subscription plan not found.');
        }

        Log::info('📦 Plan found for renewal', [
            'plan_id' => $plan->id,
            'plan_name' => $plan->name,
            'duration_days' => $plan->duration_days,
            'price' => $plan->price,
        ]);

        // Create payment record with payment_type = 'renewal'
        $paymentId = (string) Str::uuid();
        DB::table('payments')->insert([
            'id' => $paymentId,
            'user_id' => $user->id,
            'subscription_id' => $currentSubscription->id,
            'subscription_plan_id' => $plan->id,
            'amount' => $plan->price,
            'status' => 'pending',
            'payment_method' => 'mayar',
            'payment_type' => 'renewal', // ✅ Mark as renewal
            'payment_code' => 'RENEW-' . strtoupper(Str::random(8)),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Log::info('💳 Renewal payment record created', [
            'payment_id' => $paymentId,
            'subscription_id' => $currentSubscription->id,
            'payment_type' => 'renewal',
        ]);

        // Build Mayar payment URL with query params
        $baseUrl = rtrim($plan->mayar_payment_link, '?');
        $queryParams = http_build_query([
            'external_id' => $paymentId,
            'name' => $user->name,
            'email' => $user->email,
        ]);

        $url = $baseUrl . '?' . $queryParams;

        Log::info('🔗 Redirecting to Mayar for renewal', [
            'url' => $url,
            'payment_id' => $paymentId,
        ]);

        return redirect($url);
    }

    /**
     * Process subscription upgrade (changes to higher tier plan)
     * User switches from current plan to a HIGHER tier plan
     */
    public function upgradeSubscription(Request $request): RedirectResponse
    {
        $user = auth()->user();
        $newPlanSlug = $request->input('plan_slug');

        // ✅ LOG: Upgrade request started
        Log::info('⬆️ Upgrade request started', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'new_plan_slug' => $newPlanSlug,
        ]);

        if (!$newPlanSlug) {
            Log::warning('⚠️ No plan slug provided for upgrade');
            return redirect()->back()->with('error', 'Please select a plan to upgrade to.');
        }

        // Get current active subscription
        $currentSubscription = DB::table('subscriptions')
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->first();

        if (!$currentSubscription) {
            Log::warning('⚠️ No active subscription found for upgrade', [
                'user_id' => $user->id,
            ]);
            return redirect()->back()->with('error', 'No active subscription to upgrade.');
        }

        // Get current and new plans
        $currentPlan = SubscriptionPlan::find($currentSubscription->subscription_plan_id);
        $newPlan = SubscriptionPlan::where('slug', $newPlanSlug)->first();

        if (!$currentPlan || !$newPlan) {
            Log::error('❌ Plan not found for upgrade', [
                'current_plan_id' => $currentSubscription->subscription_plan_id,
                'new_plan_slug' => $newPlanSlug,
            ]);
            return redirect()->back()->with('error', 'Subscription plan not found.');
        }

        // ✅ Validate: new plan must have longer duration (higher tier)
        if ($newPlan->duration_days <= $currentPlan->duration_days) {
            Log::warning('⚠️ Cannot upgrade to lower or same tier plan', [
                'current_duration' => $currentPlan->duration_days,
                'new_duration' => $newPlan->duration_days,
            ]);
            return redirect()->back()->with('error', 'Can only upgrade to a higher tier plan with longer duration. Contact admin to change to a lower tier.');
        }

        Log::info('📦 Plans found for upgrade', [
            'current_plan' => [
                'id' => $currentPlan->id,
                'name' => $currentPlan->name,
                'duration_days' => $currentPlan->duration_days,
            ],
            'new_plan' => [
                'id' => $newPlan->id,
                'name' => $newPlan->name,
                'duration_days' => $newPlan->duration_days,
            ],
        ]);

        // Create payment record with payment_type = 'upgrade'
        $paymentId = (string) Str::uuid();
        DB::table('payments')->insert([
            'id' => $paymentId,
            'user_id' => $user->id,
            'subscription_id' => $currentSubscription->id, // Link to old subscription
            'subscription_plan_id' => $newPlan->id, // New plan
            'amount' => $newPlan->price,
            'status' => 'pending',
            'payment_method' => 'mayar',
            'payment_type' => 'upgrade', // ✅ Mark as upgrade
            'payment_code' => 'UPG-' . strtoupper(Str::random(8)),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Log::info('💳 Upgrade payment record created', [
            'payment_id' => $paymentId,
            'old_subscription_id' => $currentSubscription->id,
            'new_plan_id' => $newPlan->id,
            'payment_type' => 'upgrade',
        ]);

        // Build Mayar payment URL with query params
        $baseUrl = rtrim($newPlan->mayar_payment_link, '?');
        $queryParams = http_build_query([
            'external_id' => $paymentId,
            'name' => $user->name,
            'email' => $user->email,
        ]);

        $url = $baseUrl . '?' . $queryParams;

        Log::info('🔗 Redirecting to Mayar for upgrade', [
            'url' => $url,
            'payment_id' => $paymentId,
        ]);

        return redirect($url);
    }

    /**
     * Downgrade subscription to lower tier
     * Similar to upgrade but allows downgrades (plan with lower duration_days)
     */
    public function downgradeSubscription(Request $request): RedirectResponse
    {
        $user = auth()->user();
        $newPlanSlug = $request->input('plan_slug');

        // ✅ LOG: Downgrade request started
        Log::info('⬇️ Downgrade request started', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'new_plan_slug' => $newPlanSlug,
        ]);

        if (!$newPlanSlug) {
            Log::warning('⚠️ No plan slug provided for downgrade');
            return redirect()->back()->with('error', 'Please select a plan to downgrade to.');
        }

        // Get current active subscription
        $currentSubscription = DB::table('subscriptions')
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->first();

        if (!$currentSubscription) {
            Log::warning('⚠️ No active subscription found for downgrade', [
                'user_id' => $user->id,
            ]);
            return redirect()->back()->with('error', 'No active subscription to downgrade.');
        }

        // Get current and new plans
        $currentPlan = SubscriptionPlan::find($currentSubscription->subscription_plan_id);
        $newPlan = SubscriptionPlan::where('slug', $newPlanSlug)->first();

        if (!$currentPlan || !$newPlan) {
            Log::error('❌ Plan not found for downgrade', [
                'current_plan_id' => $currentSubscription->subscription_plan_id,
                'new_plan_slug' => $newPlanSlug,
            ]);
            return redirect()->back()->with('error', 'Subscription plan not found.');
        }

        // ✅ Validate: new plan must have lower duration (lower tier) - OPPOSITE of upgrade
        if ($newPlan->duration_days >= $currentPlan->duration_days) {
            Log::warning('⚠️ Cannot downgrade to higher or same tier plan', [
                'current_duration' => $currentPlan->duration_days,
                'new_duration' => $newPlan->duration_days,
            ]);
            return redirect()->back()->with('error', 'Can only downgrade to a lower tier plan. For upgrades, use the upgrade option.');
        }

        Log::info('📦 Plans found for downgrade', [
            'current_plan' => [
                'id' => $currentPlan->id,
                'name' => $currentPlan->name,
                'duration_days' => $currentPlan->duration_days,
            ],
            'new_plan' => [
                'id' => $newPlan->id,
                'name' => $newPlan->name,
                'duration_days' => $newPlan->duration_days,
            ],
        ]);

        // Create payment record with payment_type = 'downgrade'
        $paymentId = (string) Str::uuid();
        DB::table('payments')->insert([
            'id' => $paymentId,
            'user_id' => $user->id,
            'subscription_id' => $currentSubscription->id, // Link to old subscription
            'subscription_plan_id' => $newPlan->id, // New plan
            'amount' => $newPlan->price,
            'status' => 'pending',
            'payment_method' => 'mayar',
            'payment_type' => 'downgrade', // ✅ Mark as downgrade
            'payment_code' => 'DWN-' . strtoupper(Str::random(8)),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Log::info('💳 Downgrade payment record created', [
            'payment_id' => $paymentId,
            'old_subscription_id' => $currentSubscription->id,
            'new_plan_id' => $newPlan->id,
            'payment_type' => 'downgrade',
        ]);

        // Build Mayar payment URL with query params
        $baseUrl = rtrim($newPlan->mayar_payment_link, '?');
        $queryParams = http_build_query([
            'external_id' => $paymentId,
            'name' => $user->name,
            'email' => $user->email,
        ]);

        $url = $baseUrl . '?' . $queryParams;

        Log::info('🔗 Redirecting to Mayar for downgrade', [
            'url' => $url,
            'payment_id' => $paymentId,
        ]);

        return redirect($url);
    }
}
