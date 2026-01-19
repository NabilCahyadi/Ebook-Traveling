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
        // Validasi signature...
        $signature = $request->header('X-Mayar-Signature');
        $payload = $request->getContent();
        $webhookToken = config('services.mayar.webhook_token');

        if (!$webhookToken || !hash_equals(hash_hmac('sha256', $payload, $webhookToken), $signature)) {
            return response('Unauthorized', 401);
        }

        $data = $request->json('data', []);
        $event = $request->json('event', '');

        if ($event !== 'payment.received' || ($data['status'] ?? '') !== 'SUCCESS') {
            return response('OK', 200);
        }

        // Ambil externalId (payment_id)
        $externalId = $data['externalId'] ?? null;
        if (!$externalId) {
            return response('OK', 200);
        }

        // Cari payment berdasarkan externalId
        $payment = DB::table('payments')->where('id', $externalId)->first();
        if (!$payment) {
            return response('OK', 200);
        }

        // Ambil user & plan dari payment
        $user = DB::table('users')->where('id', $payment->user_id)->first();
        $plan = DB::table('subscription_plans')->where('id', $payment->subscription_plan_id)->first();

        if ($user && $plan) {
            DB::table('subscriptions')->insert([
                'user_id' => $user->id,
                'subscription_plan_id' => $plan->id, // UUID langsung
                'status' => 'active',
                'end_date' => now()->addDays($plan->duration_days),
                'created_at' => now(),
            ]);

            // Update status payment
            DB::table('payments')->where('id', $externalId)->update(['status' => 'success']);
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
