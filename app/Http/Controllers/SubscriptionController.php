<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Repositories\Interfaces\SubscriptionProcessInterface;
use App\Services\MayarService;
use Carbon\Carbon;
use App\Models\SubscriptionPlan;

class SubscriptionController extends Controller
{
    protected $subscriptionProcessRepository; // <-- GANTI NAMA VARIABEL
    protected $mayarService;

    public function __construct(SubscriptionProcessInterface $subscriptionProcessRepository, MayarService $mayarService) // <-- GANTI INI
    {
        $this->subscriptionProcessRepository = $subscriptionProcessRepository; // <-- GANTI INI
        $this->mayarService = $mayarService;
    }
    /**
     * Endpoint untuk membuat pembayaran baru via Mayar.id
     * URL: POST /api/subscription/create
     */
    public function create(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 401);
        }

        $request->validate(['plan_id' => 'required|uuid|exists:subscription_plans,id']);

        $plan = SubscriptionPlan::where('id', $request->plan_id)->where('is_active', true)->first();
        if (!$plan) {
            return response()->json(['success' => false, 'message' => 'Subscription plan not found or inactive.'], 404);
        }

        try {
            // Gunakan MayarService → ini akan create PaymentLink & panggil Mayar API
            $paymentLink = $this->mayarService->generatePaymentLink($user, $plan);

            return response()->json([
                'success' => true,
                'data' => [
                    'payment_url' => $paymentLink->payment_url,
                    'invoice_number' => $paymentLink->invoice_number,
                    'expires_at' => $paymentLink->expires_at,
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Subscription create failed', [
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to create payment. Please try again later.',
            ], 500);
        }
    }

    private function validateMayarSignature(Request $request)
    {
        $signature = $request->header('X-Mayar-Signature');
        $payload = $request->getContent();
        $expected = hash_hmac('sha256', $payload, config('services.mayar.webhook_token'));

        if (!hash_equals($expected, $signature)) {
            throw new \Exception('Invalid signature');
        }
    }

    /**
     * Endpoint untuk menerima callback dari Mayar.id
     * URL: POST /api/payment/mayar-callback
     */
    public function mayarCallback(Request $request)
    {
        // ✅ Validasi signature
        $signature = $request->header('X-Mayar-Signature');
        $payload = $request->getContent();
        $expectedSignature = hash_hmac('sha256', $payload, config('services.mayar.webhook_token'));

        if (!hash_equals($expectedSignature, $signature)) {
            Log::warning('Invalid webhook signature');
            return response('Unauthorized', 401);
        }

        $data = $request->json('data');
        $transactionId = $data['transactionId'] ?? null;
        $status = strtoupper($data['status'] ?? 'failed');

        if (!$transactionId) {
            return response('Bad Request', 400);
        }

        try {
            // ✅ DELEGASI KE SERVICE
            $this->subscriptionProcessRepository->handleMayarCallback($transactionId, $status);
            return response('OK', 200);
        } catch (\Exception $e) {
            Log::error('Callback processing failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response('Internal Error', 500);
        }
    }

    public function simulateRenewal(Request $request, string $planSlug)
    {
        $user = $request->user();
        $plan = SubscriptionPlan::where('slug', $planSlug)->firstOrFail();

        // ✅ AMAN: Bandingkan di sisi database, hindari timezone conflict
        $activeSub = DB::table('subscriptions')
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->whereRaw('end_date >= NOW()')
            ->where('subscription_plan_id', $plan->id)
            ->orderBy('end_date', 'desc')
            ->limit(1)
            ->first();

        if (!$activeSub) {
            return redirect()->back()->with('error', 'No active subscription found to renew.');
        }

        // ✅ AMAN: Parse sebagai UTC dulu, lalu tambah hari
        $currentEndDate = Carbon::createFromFormat('Y-m-d H:i:s', $activeSub->end_date, 'UTC')
            ->setTimezone('Asia/Jakarta')
            ->addDays($plan->duration_days)
            ->setTimezone('UTC');

        DB::table('subscriptions')
            ->where('id', $activeSub->id)
            ->update([
                'end_date' => $currentEndDate->toDateTimeString(),
                'total_amount' => DB::raw("`total_amount` + {$plan->price}"),
                'updated_at' => now(),
                'notes' => DB::raw("CONCAT(IFNULL(`notes`, ''), '\nSimulated renewal @ " . now()->format('Y-m-d H:i:s') . "')"),
            ]);

        // Buat payment simulasi
        $paymentId = (string) Str::uuid();
        DB::table('payments')->insert([
            'id' => $paymentId,
            'user_id' => $user->id,
            'subscription_plan_id' => $plan->id,
            'subscription_id' => $activeSub->id,
            'amount' => $plan->price,
            'status' => 'success',
            'paid_at' => now(),
            'payment_method' => 'simulation',
            'gateway_transaction_id' => 'SIM-' . strtoupper(Str::random(8)),
            'invoice_number' => 'INV-SIM-' . strtoupper(Str::random(6)),
            'payment_code' => 'PAY-' . strtoupper(Str::random(8)),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('page-account', ['tab' => 'subscription'])
            ->with('success', 'Subscription successfully renewed (simulated).');
    }

    // SubscriptionController.php
    public function simulateUpgrade(Request $request, string $planSlug)
    {
        $user = $request->user();
        $plan = SubscriptionPlan::where('slug', $planSlug)->firstOrFail();

        // ✅ Cari subscription AKTIF saat ini
        $currentSub = DB::table('subscriptions')
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->where('end_date', '>=', now())
            ->first();

        if (!$currentSub) {
            return redirect()->back()->with('error', 'No active subscription to upgrade.');
        }

        // ✅ Pastikan upgrade ke paket LEBIH MAHAL
        $currentPlan = SubscriptionPlan::find($currentSub->subscription_plan_id);
        if ($currentPlan && $plan->price <= $currentPlan->price) {
            return redirect()->back()->with('error', 'Cannot downgrade.');
        }

        // ✅ 1. NONAKTIFKAN subscription lama
        DB::table('subscriptions')
            ->where('id', $currentSub->id)
            ->update(['status' => 'upgraded']);

        // ✅ 2. BUAT subscription BARU (mulai dari sekarang)
        $newSubId = (string) Str::uuid();
        $startDate = now();
        $endDate = $startDate->copy()->addDays($plan->duration_days);

        DB::table('subscriptions')->insert([
            'id' => $newSubId,
            'user_id' => $user->id,
            'subscription_plan_id' => $plan->id,
            'subscription_code' => 'SUB-' . strtoupper(Str::random(6)) . '-' . $startDate->timestamp,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => 'active',
            'total_amount' => $plan->price,
            'created_at' => $startDate,
            'updated_at' => $startDate,
        ]);

        // ✅ 3. Buat payment untuk upgrade
        $paymentId = (string) Str::uuid();
        DB::table('payments')->insert([
            'id' => $paymentId,
            'user_id' => $user->id,
            'subscription_plan_id' => $plan->id,
            'subscription_id' => $newSubId,
            'payment_code' => 'UPG-' . strtoupper(Str::random(8)),
            'invoice_number' => 'INV-UPG-' . strtoupper(Str::random(6)),
            'amount' => $plan->price,
            'status' => 'success',
            'paid_at' => now(),
            'payment_method' => 'simulation',
            'gateway_transaction_id' => 'UPG-' . strtoupper(Str::random(8)),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('page-account', ['tab' => 'subscription'])
            ->with('success', 'Upgraded to ' . $plan->name . '!');
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
