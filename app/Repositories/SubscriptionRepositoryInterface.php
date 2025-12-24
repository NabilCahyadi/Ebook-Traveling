<?php

namespace App\Repositories\Contracts;

interface SubscriptionRepositoryInterface
{
    public function findPlanById(string $planId);
    public function createPayment(array $data);
    public function findPaymentByGatewayId(string $gatewayId);
    public function updatePayment(string $paymentId, array $data);
    public function createSubscription(array $data);
}
