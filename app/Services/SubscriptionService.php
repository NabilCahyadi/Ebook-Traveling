<?php

namespace App\Services;

use App\Models\Subscription;
use App\Repositories\Interfaces\SubscriptionRepositoryInterface;
use App\Repositories\Interfaces\SubscriptionPlanRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SubscriptionService
{
    protected $subscriptionRepository;
    protected $subscriptionPlanRepository;
    protected $userRepository;

    public function __construct(
        SubscriptionRepositoryInterface $subscriptionRepository,
        SubscriptionPlanRepositoryInterface $subscriptionPlanRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->subscriptionRepository = $subscriptionRepository;
        $this->subscriptionPlanRepository = $subscriptionPlanRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Get all subscriptions with pagination
     */
    public function getAllSubscriptions(int $perPage = 15)
    {
        return $this->subscriptionRepository->getAllPaginated($perPage);
    }

    /**
     * Search subscriptions by user
     */
    public function searchSubscriptions(string $search, int $perPage = 15)
    {
        return $this->subscriptionRepository->searchByUser($search, $perPage);
    }

    /**
     * Get subscription by ID
     */
    public function getSubscriptionById(string $id): ?Subscription
    {
        return $this->subscriptionRepository->findById($id);
    }

    /**
     * Create manual subscription
     */
    public function createManualSubscription(array $data): Subscription
    {
        DB::beginTransaction();
        try {
            // Get plan details
            $plan = $this->subscriptionPlanRepository->findById($data['subscription_plan_id']);
            if (!$plan) {
                throw new \Exception('Subscription plan not found.');
            }

            // Verify user exists
            $user = $this->userRepository->findById($data['user_id']);
            if (!$user) {
                throw new \Exception('User not found.');
            }

            // Generate subscription code
            $subscriptionCode = 'SUB-' . strtoupper(Str::random(10));

            // Calculate dates with quantity
            $quantity = $data['quantity'] ?? 1;
            $totalDays = $plan->duration_days * $quantity;
            $totalAmount = $plan->price * $quantity;

            $startDate = now();
            $endDate = now()->addDays($totalDays);

            // Create subscription
            $subscription = $this->subscriptionRepository->create([
                'user_id' => $data['user_id'],
                'subscription_plan_id' => $plan->id,
                'subscription_code' => $subscriptionCode,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => 'active',
                'total_amount' => $totalAmount,
                'auto_renew' => false,
            ]);

            DB::commit();
            return $subscription;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update subscription
     */
    public function updateSubscription(string $id, array $data): bool
    {
        $subscription = $this->subscriptionRepository->findById($id);
        if (!$subscription) {
            throw new \Exception('Subscription not found.');
        }

        return $this->subscriptionRepository->update($subscription, $data);
    }

    /**
     * Extend subscription
     */
    public function extendSubscription(string $id, int $days): Subscription
    {
        DB::beginTransaction();
        try {
            $subscription = $this->subscriptionRepository->findById($id);
            if (!$subscription) {
                throw new \Exception('Subscription not found.');
            }

            // Extend end date
            $newEndDate = \Carbon\Carbon::parse($subscription->end_date)->addDays($days);

            $this->subscriptionRepository->update($subscription, [
                'end_date' => $newEndDate,
                'status' => 'active',
            ]);

            DB::commit();
            return $subscription->fresh();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Extend subscription by plan with quantity
     */
    public function extendSubscriptionByPlan(string $id, string $planId, int $quantity = 1): Subscription
    {
        DB::beginTransaction();
        try {
            $subscription = $this->subscriptionRepository->findById($id);
            if (!$subscription) {
                throw new \Exception('Subscription not found.');
            }

            $plan = $this->subscriptionPlanRepository->findById($planId);
            if (!$plan) {
                throw new \Exception('Subscription plan not found.');
            }

            // Calculate total days and amount
            $totalDays = $plan->duration_days * $quantity;
            $totalAmount = $plan->price * $quantity;

            // Extend end date
            $newEndDate = \Carbon\Carbon::parse($subscription->end_date)->addDays($totalDays);

            // Update subscription
            $this->subscriptionRepository->update($subscription, [
                'end_date' => $newEndDate,
                'status' => 'active',
                'total_amount' => $subscription->total_amount + $totalAmount,
            ]);

            DB::commit();
            return $subscription->fresh();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Cancel subscription
     */
    public function cancelSubscription(string $id): bool
    {
        $subscription = $this->subscriptionRepository->findById($id);
        if (!$subscription) {
            throw new \Exception('Subscription not found.');
        }

        return $this->subscriptionRepository->update($subscription, [
            'status' => 'cancelled',
            'auto_renew' => false,
        ]);
    }

    /**
     * Delete subscription
     */
    public function deleteSubscription(string $id): bool
    {
        $subscription = $this->subscriptionRepository->findById($id);
        if (!$subscription) {
            throw new \Exception('Subscription not found.');
        }

        return $this->subscriptionRepository->delete($subscription);
    }

    /**
     * Get active subscription plans
     */
    public function getActivePlans()
    {
        return $this->subscriptionPlanRepository->getActive();
    }

    /**
     * Get all users
     */
    public function getAllUsers()
    {
        return $this->userRepository->getAll();
    }

    /**
     * Get user's active subscription
     */
    public function getUserActiveSubscription(string $userId): ?Subscription
    {
        return $this->subscriptionRepository->getUserActiveSubscription($userId);
    }
}
