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
use App\Models\City;

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
            // SIMPAN DI TABEL payments DULU
            $paymentData = [
                'id' => (string) Str::uuid(),
                'user_id' => $user->id,
                'subscription_plan_id' => $plan->id,
                'amount' => $plan->price,
                'status' => 'pending',
                'payment_method' => 'mayar',
                'gateway_transaction_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            DB::table('payments')->insert($paymentData);

            // ✅ KIRIM payment_id sebagai external_id
            $paymentLink = $this->mayarService->generatePaymentLink($user, $plan, $paymentData['id']);
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
                'plan_id' => $request->plan_id,
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

        $data = $request->json('tda');
        $transactionId = $data['transactionId'] ?? null;
        $status = strtoupper($data['status'] ?? 'failed');
        $externalId = $data['externalId'] ?? null; // ✅ AMBIL externalId

        if (!$transactionId || !$externalId) {
            Log::error('Missing transactionId or externalId', $data);
            return response('Bad Request', 400);
        }

        try {
            // ✅ UPDATE TABEL payments BERDASARKAN externalId (yang sebenarnya payment_id)
            DB::table('payments')
                ->where('id', $externalId)
                ->update([
                    'gateway_transaction_id' => $transactionId,
                    'status' => in_array($status, ['SUCCESS', 'PAID']) ? 'success' : 'failed',
                    'paid_at' => in_array($status, ['SUCCESS', 'PAID']) ? now() : null,
                    'updated_at' => now(),
                ]);

            // ✅ PROSES LANGGANAN JIKA SUKSES
            if (in_array($status, ['SUCCESS', 'PAID'])) {
                $payment = DB::table('payments')->where('id', $externalId)->first();
                if ($payment) {
                    // ✅ MODIFIKASI: handleMayarCallbackByPayment()
                    $this->subscriptionProcessRepository->handleMayarCallbackByPayment($payment);
                }
            }

            Log::info('Payment processed successfully', ['user_id' => $payment->user_id ?? 'unknown']);
            return response('OK', 200);
        } catch (\Exception $e) {
            Log::error('Callback processing failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response('Internal Error', 500);
        }
    }

    public function paymentSuccess()
    {
        // Simpan user yang sudah di-refresh
        $user = auth()->user();
        $user->load([
            'currentSubscription',
            'subscriptions.plan'
        ]);

        $citiesHeader = City::where('is_active', true)
            ->orderBy('order_index')
            ->orderBy('name')
            ->get();

        return view('payment.success', [
            'isPremium' => $user->hasActiveSubscription(),
            'citiesHeader' => $citiesHeader
        ]);
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
