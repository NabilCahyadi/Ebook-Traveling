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
        // Validasi signature
        $signature = $request->header('X-Mayar-Signature');
        $payload = $request->getContent();
        $webhookToken = config('services.mayar.webhook_token');

        if (!$webhookToken || !hash_equals(hash_hmac('sha256', $payload, $webhookToken), $signature)) {
            Log::warning('Webhook: Invalid signature');
            return response('Unauthorized', 401);
        }

        $data = $request->json('data', []);
        $event = $request->json('event', '');

        if ($event !== 'payment.received' || ($data['status'] ?? '') !== 'SUCCESS') {
            return response('OK', 200);
        }

        $email = $data['customerEmail'] ?? '';
        $productName = $data['productName'] ?? '';
        $amount = $data['amount'] ?? 0;

        Log::info('Webhook processing', [
            'email' => $email,
            'product_name' => $productName,
            'amount' => $amount
        ]);

        // Cari user
        $user = DB::table('users')->where('email', $email)->first();
        if (!$user) {
            Log::warning('Webhook: User not found', ['email' => $email]);
            return response('OK', 200);
        }

        // Cari plan berdasarkan nama produk (exact match)
        $plan = DB::table('subscription_plans')
            ->where('name', $productName)
            ->first();

        // Fallback: cek dengan TRIM jika tidak ketemu
        if (!$plan) {
            $plan = DB::table('subscription_plans')
                ->whereRaw('TRIM(name) = ?', [trim($productName)])
                ->first();
        }

        // Fallback akhir: pakai durasi berdasarkan amount
        if (!$plan) {
            if ($amount == 2000) {
                $plan = DB::table('subscription_plans')->where('duration_days', 2)->first(); // Harian simulasi
            } elseif ($amount == 1000) {
                $plan = DB::table('subscription_plans')->where('duration_days', 1)->first(); // Starter daily
            } elseif ($amount == 10000) {
                $plan = DB::table('subscription_plans')->where('duration_days', 7)->first(); // Mingguan
            }
        }

        if ($plan) {
            try {
                DB::table('subscriptions')->insert([
                    'user_id' => $user->id,
                    'subscription_plan_id' => $plan->id,
                    'status' => 'active',
                    'end_date' => now()->addDays($plan->duration_days),
                    'created_at' => now(),
                ]);
                Log::info('✅ USER BERHASIL DIJADIKAN PREMIUM', [
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'email' => $email
                ]);
            } catch (\Exception $e) {
                Log::error('Webhook: Gagal insert subscription', [
                    'error' => $e->getMessage(),
                    'user_id' => $user->id
                ]);
            }
        } else {
            Log::warning('Webhook: Plan not found', [
                'product_name' => $productName,
                'amount' => $amount
            ]);
        }

        return response('OK', 200);
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
