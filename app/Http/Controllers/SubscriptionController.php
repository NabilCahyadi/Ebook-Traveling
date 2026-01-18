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
use App\Models\SubscriptionPlan;
use App\Models\City;
use App\Repositories\SubscriptionProcessRepository;

class SubscriptionController extends Controller
{
    protected $subscriptionProcessRepository;
    protected $mayarService;

    public function __construct(SubscriptionProcessRepository $subscriptionProcessRepository, MayarService $mayarService) // <-- GANTI INI
    {
        $this->subscriptionProcessRepository = $subscriptionProcessRepository;
        $this->mayarService = $mayarService;
    }

    public function createPayment(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 401);
        }

        $request->validate([
            'plan_id' => 'required|exists:subscription_plans,id'
        ]);

        $plan = SubscriptionPlan::where('id', $request->plan_id)
            ->where('is_active', true)
            ->first();

        if (!$plan) {
            return response()->json(['success' => false, 'message' => 'Subscription plan not found or inactive.'], 404);
        }

        try {
            // Simpan payment record
            $paymentId = (string) Str::uuid();
            DB::table('payments')->insert([
                'id' => $paymentId,
                'user_id' => $user->id,
                'subscription_plan_id' => $plan->id,
                'amount' => $plan->price,
                'status' => 'pending',
                'payment_method' => 'mayar',
                'payment_code' => 'PAY-' . strtoupper(Str::random(8)),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Kirim ke Mayar API
            $response = Http::withToken(config('services.mayar.api_key'))
                ->timeout(30)
                ->post('https://api.mayar.id/v1/transactions', [
                    'amount' => (int) $plan->price,
                    'invoice_number' => 'INV-' . strtoupper(Str::random(8)) . '-' . time(),
                    'customer_name' => $user->name,
                    'customer_email' => $user->email,
                    'callback_url' => config('services.mayar.callback_url'),
                    'return_url' => config('services.mayar.return_url'),
                    'metadata' => [
                        'payment_id' => $paymentId,
                        'user_id' => $user->id,
                        'plan_id' => $plan->id,
                    ]
                ]);

            // LOG RESPONSE UNTUK DEBUG
            Log::info('Mayar API Response', [
                'status' => $response->status(),
                'body' => $response->json()
            ]);

            if (!$response->successful()) {
                $errorData = $response->json();
                $errorMessage = $errorData['message'] ?? 'Unknown Mayar API error';

                Log::error('Mayar API Failed', [
                    'error' => $errorMessage,
                    'response' => $errorData
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Payment gateway error: ' . $errorMessage
                ], 500);
            }

            $data = $response->json();

            if (!isset($data['data']['payment_url'])) {
                subsLog::error('Mayar API: Missing payment_url', $data);
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid response from payment gateway'
                ], 500);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'payment_url' => $data['data']['payment_url']
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Create Payment Exception', [
                'user_id' => $user->id,
                'plan_id' => $request->plan_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'System error: ' . $e->getMessage()
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
        // Validasi signature (pakai webhook token)
        $signature = $request->header('X-Mayar-Signature');
        $payload = $request->getContent();
        $expectedSignature = hash_hmac('sha256', $payload, config('services.mayar.webhook_token'));

        if (!hash_equals($expectedSignature, $signature)) {
            return response('Unauthorized', 401);
        }

        $data = $request->json('data'); // ✅ BUKAN 'tda'!
        $transactionId = $data['transactionId'] ?? null;
        $status = strtoupper($data['status'] ?? 'failed');
        $metadata = $data['metadata'] ?? [];
        $paymentId = $metadata['payment_id'] ?? null;

        if (!$transactionId || !$paymentId) {
            return response('Bad Request', 400);
        }

        // Update payment & buat subscription
        DB::table('payments')
            ->where('id', $paymentId)
            ->update([
                'gateway_transaction_id' => $transactionId,
                'status' => in_array($status, ['SUCCESS', 'PAID']) ? 'success' : 'failed',
                'paid_at' => in_array($status, ['SUCCESS', 'PAID']) ? now() : null,
                'updated_at' => now(),
            ]);

        if (in_array($status, ['SUCCESS', 'PAID'])) {
            $payment = DB::table('payments')->where('id', $paymentId)->first();
            if ($payment) {
                $this->subscriptionProcessRepository->handleMayarCallbackByPayment($payment);
            }
        }

        return response('OK', 200);
    }

    public function paymentSuccess()
    {
        // ✅ Cek apakah user masih login
        if (!auth()->check()) {
            // Redirect ke login jika session habis
            return redirect()->route('login')->with('message', 'Please log in to access your account.');
        }

        // ✅ Ambil user & force refresh relasi dari database
        $user = auth()->user();
        $user->load([
            'currentSubscription',
            'subscriptions.plan'
        ]);

        // ✅ CLEAR SESSION CACHE UNTUK STATUS PREMIUM
        session()->forget('user_premium_status');
        session()->put('user_premium_status', $user->hasActiveSubscription());

        $citiesHeader = City::where('is_active', true)
            ->orderBy('order_index')
            ->orderBy('name')
            ->get();

        return view('payment.success', [
            'isPremium' => $user->hasActiveSubscription(), // ✅ Gunakan $user, bukan auth()->user()
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
