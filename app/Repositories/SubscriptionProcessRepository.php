<?php

namespace App\Repositories;

use App\Repositories\Interfaces\SubscriptionProcessInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
        $data['subscription_code'] = 'SUB-' . time();
        $data['start_date'] = now()->toDateString();
        $data['end_date'] = now()->addDays($data['duration_days'])->toDateString();
        $data['status'] = 'active';
        $data['created_at'] = now();
        $data['updated_at'] = now();

        unset($data['duration_days']); // Hapus field yang tidak ada di tabel

        DB::table('subscriptions')->insert($data);
        return $data['id'];
    }
}
