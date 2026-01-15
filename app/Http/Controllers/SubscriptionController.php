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
            // ✅ Ambil data payment dari service
            $this->subscriptionProcessRepository->handleMayarCallback($transactionId, $status);

            // ✅ Cari payment untuk log
            $payment = DB::table('payments')
                ->where('gateway_transaction_id', $transactionId)
                ->first();

            if ($payment) {
                Log::info('Payment processed successfully', ['user_id' => $payment->user_id]);
            }

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
        $user = auth()->user();
        $user->load('currentSubscription');
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
