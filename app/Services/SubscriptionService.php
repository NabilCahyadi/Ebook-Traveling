<?php
// Service ini untuk mengelola transaksi langganan 
//(misalnya membuat langganan baru, memperpanjang, membatalkan). 
//Ini juga untuk keperluan admin atau logika bisnis, bukan untuk menampilkan pricing.
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
     * 
     * Logic:
     * - If category_subscription is the SAME: Duration is accumulated (added to remaining days)
     * - If category_subscription is DIFFERENT: Duration is replaced (starts from now, old remaining days are lost)
     */
    public function extendSubscriptionByPlan(string $id, string $planId, int $quantity = 1): Subscription
    {
        DB::beginTransaction();
        try {
            $subscription = $this->subscriptionRepository->findById($id);
            if (!$subscription) {
                throw new \Exception('Subscription not found.');
            }

            $newPlan = $this->subscriptionPlanRepository->findById($planId);
            if (!$newPlan) {
                throw new \Exception('Subscription plan not found.');
            }

            // Get current plan to compare category_subscription
            $currentPlan = $subscription->plan;

            // Calculate total days and amount for new plan
            $totalDays = $newPlan->duration_days * $quantity;
            $totalAmount = $newPlan->price * $quantity;

            // Check if category_subscription is the same
            $isSameCategory = $currentPlan && 
                              $currentPlan->category_subscription === $newPlan->category_subscription;

            // ALWAYS ACCUMULATE: Add new days to existing end_date regardless of category
            $newEndDate = \Carbon\Carbon::parse($subscription->end_date)->addDays($totalDays);
            $newTotalAmount = $subscription->total_amount + $totalAmount;
            
            if ($isSameCategory) {
                // SAME CATEGORY: Accumulate duration, keep the same plan
                $this->subscriptionRepository->update($subscription, [
                    'end_date' => $newEndDate,
                    'status' => 'active',
                    'total_amount' => $newTotalAmount,
                ]);
            } else {
                // DIFFERENT CATEGORY: Accumulate duration, update to new plan
                $this->subscriptionRepository->update($subscription, [
                    'subscription_plan_id' => $newPlan->id,
                    'end_date' => $newEndDate,
                    'status' => 'active',
                    'total_amount' => $newTotalAmount,
                ]);
            }

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
