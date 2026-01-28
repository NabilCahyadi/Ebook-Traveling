<?php

namespace App\Repositories\SubscriptionManagement;

use App\Repositories\Interfaces\SubscriptionProcessInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class SubscriptionProcessRepository implements SubscriptionProcessInterface
{
    public function findPlanById(string $planId)
    {
        return DB::table('subscription_plans')->where('id', $planId)->first();
    }

    public function createPayment(array $data)
    {
        $data['id'] = (string) Str::uuid();
        $data['created_at'] = now();
        $data['updated_at'] = now();

        DB::table('payments')->insert($data);
        return $data['id'];
    }

    public function findPaymentByGatewayId(string $gatewayId)
    {
        return DB::table('payments')->where('gateway_transaction_id', $gatewayId)->lockForUpdate()->first();
    }

    public function updatePayment(string $paymentId, array $data)
    {
        $data['updated_at'] = now();
        return DB::table('payments')->where('id', $paymentId)->update($data);
    }

    public function createSubscription(array $data)
    {
        $data['id'] = (string) Str::uuid();
        $data['subscription_code'] = 'SUB-' . strtoupper(Str::random(6)) . '-' . time();
        $startDate = now();
        $endDate = $startDate->copy()->addDays($data['duration_days']);

        $data['start_date'] = $startDate;
        $data['end_date'] = $endDate;
        $data['status'] = 'active'; // ✅ ENSURE status is 'active'
        $data['created_at'] = $startDate;
        $data['updated_at'] = $startDate;

        unset($data['duration_days']);

        DB::table('subscriptions')->insert($data);
        
        // ✅ LOG untuk debugging
        Log::info('Subscription created successfully', [
            'subscription_id' => $data['id'],
            'user_id' => $data['user_id'] ?? 'unknown',
            'status' => $data['status'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
        ]);
        
        return $data['id'];
    }

    public function handleMayarCallback(string $transactionId, string $status): void
    {
        DB::transaction(function () use ($transactionId, $status) {
            // Cari payment
            $payment = $this->findPaymentByGatewayId($transactionId);
            if (!$payment) {
                Log::warning("Payment not found for transactionId: $transactionId");
                return;
            }

            if ($payment->status === 'success') {
                Log::info("Payment already processed: $transactionId");
                return;
            }

            // Update status payment
            $newStatus = in_array($status, ['SUCCESS', 'PAID']) ? 'success' : 'failed';
            $this->updatePayment($payment->id, [
                'status' => $newStatus,
                'paid_at' => $newStatus === 'success' ? now() : null,
            ]);

            // Jika sukses, proses langganan
            if ($newStatus === 'success') {
                $plan = $this->findPlanById($payment->subscription_plan_id);
                if (!$plan) {
                    Log::error("Plan not found", ['plan_id' => $payment->subscription_plan_id]);
                    return;
                }

                // Cek langganan aktif user
                $activeSub = DB::table('subscriptions')
                    ->where('user_id', $payment->user_id)
                    ->where('status', 'active')
                    ->where('end_date', '>=', now())
                    ->orderBy('end_date', 'desc')
                    ->first();

                if ($activeSub) {
                    // Perpanjang langganan
                    $newEndDate = \Carbon\Carbon::parse($activeSub->end_date)->addDays($plan->duration_days);

                    DB::table('subscriptions')
                        ->where('id', $activeSub->id)
                        ->update([
                            'end_date' => $newEndDate,
                            'total_amount' => DB::raw("`total_amount` + {$plan->price}"),
                            'updated_at' => now(),
                            'notes' => DB::raw("CONCAT(IFNULL(`notes`, ''), '\nPerpanjang via {$payment->payment_code} @ " . now()->format('Y-m-d H:i:s') . "')"),
                        ]);

                    $this->updatePayment($payment->id, ['subscription_id' => $activeSub->id]);
                } else {
                    // Buat langganan baru
                    $subscriptionData = [
                        'user_id' => $payment->user_id,
                        'subscription_plan_id' => $payment->subscription_plan_id,
                        'payment_id' => $payment->id,
                        'duration_days' => $plan->duration_days,
                        'total_amount' => $payment->amount,
                    ];

                    $subscriptionId = $this->createSubscription($subscriptionData);
                    $this->updatePayment($payment->id, ['subscription_id' => $subscriptionId]);
                }
            }
        });
    }

    public function handleMayarCallbackByPayment($payment)
    {
        DB::transaction(function () use ($payment) {
            // Cek apakah payment valid
            if (!$payment || !isset($payment->user_id) || !isset($payment->subscription_plan_id)) {
                Log::warning('Invalid payment data in handleMayarCallbackByPayment', (array) $payment);
                return;
            }

            Log::info('Processing Mayar callback for payment', [
                'payment_id' => $payment->id,
                'user_id' => $payment->user_id,
                'plan_id' => $payment->subscription_plan_id,
            ]);

            // Cari plan
            $plan = $this->findPlanById($payment->subscription_plan_id);
            if (!$plan) {
                Log::error("Plan not found for payment", ['plan_id' => $payment->subscription_plan_id]);
                return;
            }

            // Cek langganan aktif user
            $activeSub = DB::table('subscriptions')
                ->where('user_id', $payment->user_id)
                ->where('status', 'active')
                ->where('end_date', '>=', now()) // ✅ ENSURE correct date comparison
                ->orderBy('end_date', 'desc')
                ->first();

            if ($activeSub) {
                // Perpanjang langganan
                $newEndDate = \Carbon\Carbon::parse($activeSub->end_date)->addDays($plan->duration_days);

                DB::table('subscriptions')
                    ->where('id', $activeSub->id)
                    ->update([
                        'end_date' => $newEndDate,
                        'total_amount' => DB::raw("`total_amount` + {$plan->price}"),
                        'updated_at' => now(),
                        'notes' => DB::raw("CONCAT(IFNULL(`notes`, ''), '\nPerpanjang via {$payment->id} @ " . now()->format('Y-m-d H:i:s') . "')"),
                    ]);

                // Update payment dengan subscription_id
                $this->updatePayment($payment->id, ['subscription_id' => $activeSub->id]);
                
                Log::info('Subscription extended via payment', [
                    'subscription_id' => $activeSub->id,
                    'new_end_date' => $newEndDate,
                ]);
            } else {
                // Buat langganan baru
                $subscriptionData = [
                    'user_id' => $payment->user_id,
                    'subscription_plan_id' => $payment->subscription_plan_id,
                    'payment_id' => $payment->id,
                    'duration_days' => $plan->duration_days,
                    'total_amount' => $payment->amount ?? $plan->price,
                ];

                $subscriptionId = $this->createSubscription($subscriptionData);
                $this->updatePayment($payment->id, ['subscription_id' => $subscriptionId]);
                
                Log::info('New subscription created via Mayar payment', [
                    'subscription_id' => $subscriptionId,
                    'user_id' => $payment->user_id,
                ]);
            }
        });
    }
}
