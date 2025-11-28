<?php

namespace App\Services;

use App\Repositories\Interfaces\SubscriptionPlanRepositoryInterface;
use Illuminate\Support\Str;

class SubscriptionPlanService
{
    protected $subscriptionPlanRepository;

    public function __construct(SubscriptionPlanRepositoryInterface $subscriptionPlanRepository)
    {
        $this->subscriptionPlanRepository = $subscriptionPlanRepository;
    }

    /**
     * Get all subscription plans
     */
    public function getAllPlans()
    {
        return $this->subscriptionPlanRepository->getAll();
    }

    /**
     * Get paginated subscription plans
     */
    public function getPaginatedPlans(int $perPage = 10)
    {
        return $this->subscriptionPlanRepository->getAllPaginated($perPage);
    }

    /**
     * Get active subscription plans
     */
    public function getActivePlans()
    {
        return $this->subscriptionPlanRepository->getActive();
    }

    /**
     * Get subscription plan by ID
     */
    public function getPlanById(string $id)
    {
        return $this->subscriptionPlanRepository->getById($id);
    }

    /**
     * Create a new subscription plan
     */
    public function createPlan(array $data)
    {
        // Process data
        $processedData = $this->processData($data);

        return $this->subscriptionPlanRepository->create($processedData);
    }

    /**
     * Update subscription plan
     */
    public function updatePlan(string $id, array $data)
    {
        // Process data
        $processedData = $this->processData($data);

        return $this->subscriptionPlanRepository->update($id, $processedData);
    }

    /**
     * Delete subscription plan
     */
    public function deletePlan(string $id)
    {
        // Check if plan has active subscriptions
        if ($this->subscriptionPlanRepository->hasActiveSubscriptions($id)) {
            throw new \Exception('Cannot delete plan with active subscriptions');
        }

        return $this->subscriptionPlanRepository->delete($id);
    }

    /**
     * Process input data
     */
    protected function processData(array $data)
    {
        // Generate slug from name
        if (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        // Convert features from textarea to array
        if (isset($data['features'])) {
            if (is_string($data['features'])) {
                $data['features'] = array_filter(array_map('trim', explode("\n", $data['features'])));
            }
        } else {
            $data['features'] = [];
        }

        return $data;
    }

    /**
     * Format duration for display
     */
    public function formatDuration(int $days)
    {
        if ($days == 30) {
            return '1 Month';
        } elseif ($days == 180) {
            return '6 Months';
        } elseif ($days == 365) {
            return '1 Year';
        }

        return $days . ' Days';
    }
}
