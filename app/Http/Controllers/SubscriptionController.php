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

            // Update payment status if external_id exists
            if ($externalId) {
                $payment = DB::table('payments')->where('id', $externalId)->first();

                if ($payment) {
                    DB::table('payments')
                        ->where('id', $externalId)
                        ->update([
                            'status' => 'success',
                            'updated_at' => now(),
                        ]);
                    Log::info('💳 Payment updated to success', [
                        'payment_id' => $externalId,
                        'old_status' => $payment->status,
                        'new_status' => 'success',
                    ]);
                } else {
                    Log::warning('⚠️ Payment record not found', ['external_id' => $externalId]);
                }
            }

            // Find plan
            $productName = $data['productName'] ?? '';
            $plan = DB::table('subscription_plans')
                ->where('name', $productName)
                ->first();

            if (!$plan) {
                Log::warning('⚠️ Plan not found by name, trying fallback', ['product_name' => $productName]);
                $plan = DB::table('subscription_plans')
                    ->where('slug', 'starter-daily-30788')
                    ->first();
            }

            if (!$plan) {
                Log::error('❌ No plan found - cannot create subscription');
                return response('Plan not found', 400);
            }

            Log::info('📦 Plan found', [
                'plan_id' => $plan->id,
                'plan_name' => $plan->name,
                'duration_days' => $plan->duration_days,
                'price' => $plan->price,
            ]);

            // ✅ Check for existing active subscription to prevent duplicates
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
            'payment_code' => 'PAY-' . strtoupper(Str::random(8)),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Kirim externalId = payment_id
        $queryParams = http_build_query([
            'external_id' => $paymentId,
            'customer_name' => $user->name ?? 'Customer',
            'customer_email' => $user->email ?? 'user@example.com',
        ]);

        $url = $plan->mayar_payment_link;
        $url .= (str_contains($url, '?') ? '&' : '?') . $queryParams;

        return redirect($url);
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

        // Redirect ke page-account tab dashboard dengan popup sukses
        return redirect('/page-account?tab=dashboard')->with('payment_success', true);
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
}
