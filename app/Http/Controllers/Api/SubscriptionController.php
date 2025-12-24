<?php

namespace App\Http\Controllers\Api;

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
    /**
     * Endpoint untuk membuat pembayaran baru via Mayar.id
     * URL: POST /api/subscription/create
     */
    /**
     * Endpoint untuk membuat pembayaran baru via Mayar.id
     * URL: POST /api/subscription/create
     */
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

    /**
     * Endpoint untuk menerima callback dari Mayar.id
     * URL: POST /api/payment/mayar-callback
     */
    public function mayarCallback(Request $request)
    {
        // 1. Verifikasi Signature (Keamanan)
        $webhookToken = env('MAYAR_WEBHOOK_TOKEN');
        $payload = $request->getContent();
        $signature = $request->header('X-Mayar-Signature');

        if (empty($signature) || !hash_equals(hash_hmac('sha256', $payload, $webhookToken), $signature)) {
            return response('Forbidden: Invalid signature.', 403);
        }

        // 2. Parse Payload
        $data = $request->json('data');
        $invoiceId = $data['id'] ?? null;
        $status = strtoupper($data['status'] ?? null);

        if (!$invoiceId || !$status) {
            return response('Bad Request: Missing data.', 400);
        }

        // Gunakan Database Transaction
        DB::transaction(function () use ($invoiceId, $status) {
            // 3. Cari record payment
            $payment = DB::table('payments')->where('gateway_transaction_id', $invoiceId)->lockForUpdate()->first();

            if (!$payment || $payment->status === 'success') {
                // Jika tidak ada atau sudah sukses, tidak perlu diproses lagi
                return;
            }

            // 4. Update status payment
            DB::table('payments')->where('id', $payment->id)->update([
                'status' => strtolower($status),
                'paid_at' => ($status === 'PAID') ? now() : null,
                'updated_at' => now(),
            ]);

            // 5. Jika status PAID, aktifkan langganan
            if ($status === 'PAID') {
                // Ambil data plan untuk durasi
                $plan = DB::table('subscription_plans')->where('id', $payment->subscription_plan_id)->first();

                // Buat record subscription
                $subscriptionId = (string) Str::uuid();
                $subscriptionCode = 'SUB-' . time();
                $startDate = now()->toDateString();
                $endDate = now()->addDays($plan->duration_days)->toDateString();

                DB::table('subscriptions')->insert([
                    'id' => $subscriptionId,
                    'user_id' => $payment->user_id,
                    'subscription_plan_id' => $payment->subscription_plan_id,
                    'payment_id' => $payment->id,
                    'subscription_code' => $subscriptionCode,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'status' => 'active',
                    'total_amount' => $payment->amount,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Update payment dengan subscription_id
                DB::table('payments')->where('id', $payment->id)->update([
                    'subscription_id' => $subscriptionId,
                ]);
            }
        });

        // 6. Kirim response 200 OK ke Mayar
        return response('Webhook received successfully.', 200);
    }
}
