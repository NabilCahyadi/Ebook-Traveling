<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
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

    /**
     * Endpoint untuk menerima callback dari Mayar.id
     * URL: POST /api/payment/mayar-callback
     */
    public function mayarCallback(Request $request)
    {
        // === 1. Validasi Signature ===
        $signature = $request->header('X-Mayar-Signature');
        $payload = $request->getContent();
        $webhookToken = config('services.mayar.webhook_token');

        if (!$webhookToken) {
            Log::error('MAYAR_WEBHOOK_TOKEN not set');
            return response('Unauthorized', 401);
        }

        $expectedSignature = hash_hmac('sha256', $payload, $webhookToken);
        if (!hash_equals($expectedSignature, $signature)) {
            Log::warning('Invalid webhook signature');
            return response('Unauthorized', 401);
        }

        // === 2. Ambil Data ===
        $requestData = $request->all();
        Log::info('Webhook received', $requestData);

        // Cek event type
        if (($requestData['event'] ?? '') !== 'payment.received') {
            return response('OK', 200);
        }

        $data = $requestData['data'] ?? [];

        // === 3. Deteksi Status Pembayaran ===
        $isSuccess = in_array(
            ($data['status'] ?? ''),
            ['SUCCESS', 'PAID', true]
        );

        $customerEmail = $data['customerEmail'] ?? null;
        $productName = $data['productName'] ?? '';

        if (!$isSuccess || !$customerEmail) {
            Log::info('Payment not successful or no email', $data);
            return response('OK', 200);
        }

        // === 4. Cari User ===
        $user = DB::table('users')->where('email', $customerEmail)->first();
        if (!$user) {
            Log::warning('User not found for email', ['email' => $customerEmail]);
            return response('OK', 200);
        }

        // === 5. Cari Plan Berdasarkan Nama Produk ===
        $plan = DB::table('subscription_plans')
            ->where('name', 'LIKE', "%{$productName}%")
            ->orWhere('slug', 'LIKE', "%{$productName}%")
            ->first();

        // Fallback ke plan default jika tidak ketemu
        if (!$plan) {
            $plan = DB::table('subscription_plans')
                ->where('slug', 'harian-untuk-simulasi')
                ->first();
        }

        if ($plan) {
            // Cek apakah sudah punya subscription aktif
            $existing = DB::table('subscriptions')
                ->where('user_id', $user->id)
                ->where('status', 'active')
                ->where('end_date', '>=', now())
                ->first();

            if ($existing) {
                // Perpanjang
                DB::table('subscriptions')
                    ->where('id', $existing->id)
                    ->update([
                        'end_date' => now()->addDays($plan->duration_days),
                        'updated_at' => now(),
                    ]);
            } else {
                // Buat baru
                DB::table('subscriptions')->insert([
                    'user_id' => $user->id,
                    'subscription_plan_id' => $plan->id,
                    'status' => 'active',
                    'end_date' => now()->addDays($plan->duration_days),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            Log::info('User upgraded to premium', [
                'user_id' => $user->id,
                'plan' => $plan->name
            ]);
        }

        return response('OK', 200);
    }

    public function redirectToPaymentLink(string $slug): RedirectResponse
    {
        $user = auth()->user();
        $plan = SubscriptionPlan::where('slug', $slug)->firstOrFail();

        // HANYA untuk mayar.id (live)
        if (str_contains($plan->mayar_payment_link, 'mayar.id')) {
            $queryParams = http_build_query([
                'customerName' => $user->name ?? 'Customer',
                'customerEmail' => $user->email ?? 'user@example.com',
            ]);
            return redirect($plan->mayar_payment_link . '?' . $queryParams);
        }

        // Untuk simulasi, seharusnya tidak pernah masuk sini
        return redirect($plan->mayar_payment_link);
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
