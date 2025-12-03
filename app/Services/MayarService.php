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
    public function generatePaymentLink(User $user, SubscriptionPlan $plan, ?string $notes = null): PaymentLink
    {
        try {
            // Generate invoice number
            $invoiceNumber = $this->generateInvoiceNumber();

            // Calculate expiry time
            $expiresAt = now()->addHours(config('mayar.link_expiry_hours', 24));

            // Create payment link record
            $paymentLink = PaymentLink::create([
                'invoice_number' => $invoiceNumber,
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'amount' => $plan->price,
                'status' => 'pending',
                'expires_at' => $expiresAt,
                'notes' => $notes,
            ]);

            // Call Mayar.id API to create payment
            $response = $this->createPaymentOnMayar($paymentLink, $user, $plan);

            if ($response['success']) {
                $paymentLink->update([
                    'payment_url' => $response['data']['payment_url'] ?? null,
                    'mayar_payment_id' => $response['data']['payment_id'] ?? null,
                    'mayar_response' => $response['data'],
                ]);
            } else {
                throw new \Exception($response['message'] ?? 'Failed to create payment link');
            }

            return $paymentLink->fresh();
        } catch (\Exception $e) {
            Log::error('Mayar Payment Link Generation Failed', [
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
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
            ];

            // Note: Adjust endpoint sesuai dokumentasi Mayar.id
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post($this->baseUrl . '/v1/payment/create', $payload);

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
            $externalId = $data['external_id'] ?? null;
            $status = $data['status'] ?? null;

            if (!$externalId) {
                throw new \Exception('External ID not found in callback data');
            }

            $paymentLink = PaymentLink::where('invoice_number', $externalId)->first();

            if (!$paymentLink) {
                throw new \Exception("Payment link not found: {$externalId}");
            }

            // Update payment link status
            if ($status === 'PAID' || $status === 'SUCCESS' || $status === 'paid' || $status === 'success') {
                $paymentLink->update([
                    'status' => 'paid',
                    'paid_at' => now(),
                    'payment_method' => $data['payment_method'] ?? null,
                    'mayar_response' => $data,
                ]);

                // Auto activate subscription if enabled
                if (config('mayar.auto_activate_subscription')) {
                    $this->activateSubscription($paymentLink);
                }

                return true;
            } elseif ($status === 'EXPIRED' || $status === 'expired') {
                $paymentLink->update([
                    'status' => 'expired',
                    'mayar_response' => $data,
                ]);
            } elseif ($status === 'CANCELLED' || $status === 'cancelled') {
                $paymentLink->update([
                    'status' => 'cancelled',
                    'mayar_response' => $data,
                ]);
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Mayar Callback Error', [
                'data' => $data,
                'error' => $e->getMessage()
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
