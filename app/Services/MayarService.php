<?php

namespace App\Services;

use App\Models\PaymentLink;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MayarService
{
    protected $apiKey;
    protected $baseUrl;
    protected $callbackUrl;
    protected $returnUrl;

    public function __construct()
    {
        $this->apiKey = config('mayar.api_key');
        $this->baseUrl = config('mayar.base_url');
        $this->callbackUrl = config('mayar.callback_url');
        $this->returnUrl = config('mayar.return_url');
    }

    /**
     * Generate payment link for subscription
     */
    public function generatePaymentLink(User $user, SubscriptionPlan $plan, ?string $paymentId = null): PaymentLink
    {
        $invoiceNumber = $this->generateInvoiceNumber();
        $expiresAt = now()->addHours(24);

        $paymentLink = PaymentLink::create([
            'invoice_number' => $invoiceNumber,
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'amount' => $plan->price,
            'status' => 'pending',
            'expires_at' => $expiresAt,
            'notes' => $paymentId, // Simpan payment_id di notes
        ]);

        $params = [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone ? preg_replace('/\D/', '', $user->phone) : '628123456789',
            'external_id' => $paymentId, // ✅ INI YANG BARU!
        ];

        if (app()->environment('local')) {
            $params['is_test'] = 'true';
        }

        $url = $plan->mayar_payment_link . '?' . http_build_query($params);
        $paymentLink->update(['payment_url' => $url]);

        return $paymentLink->fresh();
    }

    /**
     * Create payment on Mayar.id API
     */
    protected function createPaymentOnMayar(PaymentLink $paymentLink, User $user, SubscriptionPlan $plan): array
    {
        try {
            $payload = [
                'external_id' => $paymentLink->invoice_number,
                'amount' => (int) $plan->price,
                'description' => "Subscription: {$plan->name}",
                'payer_name' => $user->name,
                'payer_email' => $user->email,
                'payer_phone' => $user->phone ?? '',
                'callback_url' => $this->callbackUrl,
                'return_url' => $this->returnUrl,
                'expired_at' => $paymentLink->expires_at->toIso8601String(),
                'is_test' => true, // ← INI KRUSIAL!
            ];

            Log::info('MayarService: URL yang akan dipanggil', [
                'url' => $this->baseUrl . '/v1/payment-links',
                'payload' => $payload
            ]);

            // Note: Adjust endpoint sesuai dokumentasi Mayar.id
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post($this->baseUrl . '/v1/payment-links', $payload);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => [
                        'payment_url' => $response->json('data.payment_url') ?? $response->json('payment_url'),
                        'payment_id' => $response->json('data.id') ?? $response->json('id'),
                    ],
                    'message' => 'Payment link created successfully'
                ];
            }

            // TAMBAHKAN LOG INI UNTUK DEBUGGING
            Log::error('MayarService: Response dari Mayar tidak successful', [
                'status' => $response->status(),
                'body' => $response->body(),
                'json' => $response->json()
            ]);

            return [
                'success' => false,
                'message' => $response->json('message') ?? 'Failed to create payment',
                'errors' => $response->json('errors') ?? []
            ];
        } catch (\Exception $e) {
            Log::error('Mayar API Error', [
                'invoice' => $paymentLink->invoice_number,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Check payment status from Mayar.id
     */
    public function checkPaymentStatus(string $mayarPaymentId): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Accept' => 'application/json',
            ])->get($this->baseUrl . "/v1/payment/{$mayarPaymentId}");

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json('data') ?? $response->json(),
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to check payment status'
            ];
        } catch (\Exception $e) {
            Log::error('Mayar Check Status Error', [
                'payment_id' => $mayarPaymentId,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Handle payment callback from Mayar.id
     */
    public function handleCallback(array $data): bool
    {
        try {
            // Ambil external_id dari payload
            $externalId = $data['external_id'] ?? ($data['metadata']['external_id'] ?? null);
            $status = strtoupper($data['status'] ?? '');

            if (!$externalId) {
                Log::warning('Mayar callback tanpa external_id', ['data' => $data]);
                return false;
            }

            $paymentLink = PaymentLink::where('invoice_number', $externalId)->first();
            if (!$paymentLink) {
                Log::warning("Payment link tidak ditemukan: {$externalId}");
                return false;
            }

            // Update status
            $newStatus = match ($status) {
                'PAID', 'SUCCESS' => 'paid',
                'EXPIRED' => 'expired',
                'CANCELLED' => 'cancelled',
                default => 'pending',
            };

            $paymentLink->update([
                'status' => $newStatus,
                'paid_at' => $newStatus === 'paid' ? now() : null,
                'mayar_response' => $data,
            ]);

            if ($newStatus === 'paid' && config('mayar.auto_activate_subscription')) {
                $this->activateSubscription($paymentLink);
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Mayar Callback Error', [
                'data' => $data,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Activate subscription after successful payment
     */
    protected function activateSubscription(PaymentLink $paymentLink): void
    {
        try {
            $subscriptionService = app(SubscriptionService::class);

            $subscriptionService->createManualSubscription([
                'user_id' => $paymentLink->user_id,
                'plan_id' => $paymentLink->plan_id,
            ]);

            Log::info('Subscription activated via Mayar payment', [
                'invoice' => $paymentLink->invoice_number,
                'user_id' => $paymentLink->user_id,
            ]);
        } catch (\Exception $e) {
            Log::error('Subscription Activation Failed', [
                'invoice' => $paymentLink->invoice_number,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Generate unique invoice number
     */
    protected function generateInvoiceNumber(): string
    {
        $prefix = 'INV';
        $date = now()->format('Ymd');
        $random = strtoupper(Str::random(6));

        return "{$prefix}-{$date}-{$random}";
    }

    /**
     * Cancel payment link
     */
    public function cancelPaymentLink(PaymentLink $paymentLink): bool
    {
        try {
            $paymentLink->update([
                'status' => 'cancelled',
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Cancel Payment Link Failed', [
                'invoice' => $paymentLink->invoice_number,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}
