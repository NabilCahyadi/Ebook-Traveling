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

        // ✅ LOG SETELAH $user ADA
        Log::info('=== CREATE PAYMENT START ===', [
            'plan_id' => $request->plan_id,
            'user_id' => $user->id,
            'api_key_present' => !empty(config('services.mayar.api_key')),
            'callback_url' => config('services.mayar.callback_url'),
        ]);

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

            // ✅ HAPUS SPASI DI URL (INI JUGA KRITIS!)
            $response = Http::withToken(config('services.mayar.api_key'))
                ->timeout(30)
                ->post('https://api.mayar.id/v1/transactions', [ // ← hapus spasi di akhir!
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
                Log::error('Mayar API: Missing payment_url', $data); // ✅ Perbaiki typo "subsLog"
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
        // === 1. Validasi Signature (WAJIB) ===
        $signature = $request->header('X-Mayar-Signature');
        $payload = $request->getContent();

        // Ambil webhook token dari .env
        $webhookToken = config('services.mayar.webhook_token');
        if (!$webhookToken) {
            Log::error('MAYAR_WEBHOOK_TOKEN not set in .env');
            return response('Unauthorized', 401);
        }

        $expectedSignature = hash_hmac('sha256', $payload, $webhookToken);
        if (!hash_equals($expectedSignature, $signature)) {
            Log::warning('Invalid webhook signature', [
                'received' => $signature,
                'expected' => $expectedSignature
            ]);
            return response('Unauthorized', 401);
        }

        // === 2. Ambil Data dari Request ===
        $requestData = $request->all();
        Log::info('Mayar Webhook Received', $requestData);

        // Deteksi format request
        if (isset($requestData['event']) && $requestData['event'] === 'testing') {
            // Ini hanya test webhook → respons sukses
            return response('OK', 200);
        }

        // Format produksi: cari externalId
        $externalId = null;
        $status = null;
        $transactionId = null;

        // Coba format baru (eventType)
        if (isset($requestData['eventType']) && $requestData['eventType'] === 'paymentReceived') {
            $transaction = $requestData['transaction'] ?? [];
            $externalId = $transaction['externalId'] ?? null;
            $status = $transaction['status'] ?? null;
            $transactionId = $transaction['id'] ?? null;
        }
        // Coba format lama (data)
        elseif (isset($requestData['data'])) {
            $data = $requestData['data'];
            $externalId = $data['externalId'] ?? $data['invoiceNumber'] ?? null;
            $status = strtoupper($data['status'] ?? 'failed');
            $transactionId = $data['id'] ?? null;
        }

        // === 3. Validasi Data Penting ===
        if (!$externalId || !$status) {
            Log::warning('Missing externalId or status in webhook', $requestData);
            return response('Bad Request', 400);
        }

        // === 4. Proses Pembayaran Sukses ===
        if (in_array($status, ['PAID', 'SUCCESS', 'COMPLETED'])) {
            // Cari payment berdasarkan externalId
            $payment = DB::table('payments')->where('id', $externalId)->first();

            if ($payment) {
                // Update status payment
                DB::table('payments')->where('id', $externalId)->update([
                    'status' => 'success',
                    'gateway_transaction_id' => $transactionId,
                    'paid_at' => now(),
                    'updated_at' => now(),
                ]);

                // Buat subscription
                $this->subscriptionProcessRepository->handleMayarCallbackByPayment($payment);

                Log::info('Payment processed successfully', [
                    'payment_id' => $externalId,
                    'user_id' => $payment->user_id
                ]);
            } else {
                Log::warning('Payment not found for externalId', ['externalId' => $externalId]);
            }
        } else {
            Log::info('Payment failed or pending', [
                'externalId' => $externalId,
                'status' => $status
            ]);
        }

        return response('OK', 200);
    }

    public function redirectToMayar(string $slug)
    {
        $user = auth()->user();
        $plan = SubscriptionPlan::where('slug', $slug)->firstOrFail();

        $paymentId = (string) Str::uuid();

        // ✅ Generate payment code
        $paymentCode = 'PAY-' . strtoupper(Str::random(8));

        DB::table('payments')->insert([
            'id' => $paymentId,
            'user_id' => $user->id,
            'subscription_plan_id' => $plan->id,
            'amount' => $plan->price,
            'status' => 'pending',
            'payment_method' => 'mayar',
            'payment_code' => $paymentCode, // ✅ TAMBAHKAN INI!
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Deteksi platform berdasarkan slug
        $isSimulation = str_contains($slug, 'simulasi');

        if ($isSimulation) {
            $queryParams = http_build_query([
                'external_id' => $paymentId,
                'customer_name' => $user->name,
                'customer_email' => $user->email,
            ]);
        } else {
            $queryParams = http_build_query([
                'external_id' => $paymentId,
                'customerName' => $user->name,
                'customerEmail' => $user->email,
            ]);
        }

        return redirect($plan->mayar_payment_link . '?' . $queryParams);
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
