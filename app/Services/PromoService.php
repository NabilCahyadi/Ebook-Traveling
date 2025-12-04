<?php

namespace App\Services;

use App\Models\User;
use App\Models\Subscription;
use App\Repositories\Interfaces\PromoRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PromoService
{
    protected $promoRepository;

    public function __construct(PromoRepositoryInterface $promoRepository)
    {
        $this->promoRepository = $promoRepository;
    }

    /**
     * Apply promo code and calculate final price.
     * 
     * @param string $promoCode
     * @param string $userId
     * @param string $subscriptionType
     * @param float $price
     * @return array ['success' => bool, 'message' => string, 'data' => array]
     */
    public function applyPromo(string $promoCode, string $userId, string $subscriptionType, float $price): array
    {
        try {
            // Get promo by code with conditions
            $promo = $this->promoRepository->getPromoByCodeWithConditions($promoCode);

            if (!$promo) {
                return [
                    'success' => false,
                    'message' => 'Promo code not found',
                    'data' => null
                ];
            }

            // Validate promo
            $validation = $this->validatePromo($promo, $userId, $subscriptionType, $price);

            if (!$validation['valid']) {
                return [
                    'success' => false,
                    'message' => $validation['reason'],
                    'data' => null
                ];
            }

            // Calculate final price
            $result = $this->calculatePrice($promo, $price);

            return [
                'success' => true,
                'message' => 'Promo applied successfully',
                'data' => [
                    'promo_id' => $promo->id,
                    'promo_name' => $promo->name,
                    'promo_type' => $promo->type,
                    'original_price' => $price,
                    'discount_amount' => $result['discount_amount'],
                    'final_price' => $result['final_price'],
                    'free_trial_days' => $result['free_trial_days'] ?? null,
                ]
            ];
        } catch (\Exception $e) {
            Log::error('Promo apply error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'An error occurred while applying promo',
                'data' => null
            ];
        }
    }

    /**
     * Validate if promo can be used by user.
     * 
     * @param \App\Models\Promo $promo
     * @param string $userId
     * @param string $subscriptionType
     * @param float $price
     * @return array ['valid' => bool, 'reason' => string|null]
     */
    public function validatePromo($promo, string $userId, string $subscriptionType, float $price): array
    {
        // 1. Check if promo is active
        if (!$promo->is_active) {
            return ['valid' => false, 'reason' => 'Promo is not active'];
        }

        // 2. Check date range
        $now = Carbon::now();
        if ($now->lt($promo->start_date)) {
            return ['valid' => false, 'reason' => 'Promo has not started yet'];
        }

        if ($now->gt($promo->end_date)) {
            return ['valid' => false, 'reason' => 'Promo has expired'];
        }

        // 3. Check max usage limit
        if ($promo->hasReachedMaxUsage()) {
            return ['valid' => false, 'reason' => 'Promo usage limit has been reached'];
        }

        // 4. Check user usage limit
        if ($promo->userHasReachedMaxUsage($userId)) {
            return ['valid' => false, 'reason' => 'You have already used this promo maximum times'];
        }

        // 5. Check all conditions
        $conditionsCheck = $this->checkConditions($promo, $userId, $subscriptionType, $price);

        if (!$conditionsCheck['valid']) {
            return $conditionsCheck;
        }

        return ['valid' => true, 'reason' => null];
    }

    /**
     * Check if user meets all promo conditions.
     * 
     * @param \App\Models\Promo $promo
     * @param string $userId
     * @param string $subscriptionType
     * @param float $price
     * @return array ['valid' => bool, 'reason' => string|null]
     */
    protected function checkConditions($promo, string $userId, string $subscriptionType, float $price): array
    {
        $user = User::find($userId);

        if (!$user) {
            return ['valid' => false, 'reason' => 'User not found'];
        }

        foreach ($promo->conditions as $condition) {
            switch ($condition->condition_type) {
                case 'new_user':
                    // User must be registered within last 7 days
                    $daysSinceRegistration = Carbon::parse($user->created_at)->diffInDays(Carbon::now());
                    if ($daysSinceRegistration > 7) {
                        return [
                            'valid' => false,
                            'reason' => 'This promo is only for new users (registered within 7 days)'
                        ];
                    }
                    break;

                case 'first_subscription':
                    // User must not have any previous subscriptions
                    $hasSubscription = Subscription::where('user_id', $userId)->exists();
                    if ($hasSubscription) {
                        return [
                            'valid' => false,
                            'reason' => 'This promo is only for first-time subscribers'
                        ];
                    }
                    break;

                case 'subscription_type':
                    // Subscription type must match
                    $allowedTypes = explode(',', $condition->condition_value);
                    if (!in_array($subscriptionType, $allowedTypes)) {
                        return [
                            'valid' => false,
                            'reason' => 'This promo is not valid for ' . $subscriptionType . ' subscription'
                        ];
                    }
                    break;

                case 'min_price':
                    // Price must be >= minimum price
                    if ($price < floatval($condition->condition_value)) {
                        return [
                            'valid' => false,
                            'reason' => 'Minimum subscription price is $' . $condition->condition_value
                        ];
                    }
                    break;
            }
        }

        return ['valid' => true, 'reason' => null];
    }

    /**
     * Calculate final price after applying promo.
     * 
     * @param \App\Models\Promo $promo
     * @param float $price
     * @return array ['final_price' => float, 'discount_amount' => float, 'free_trial_days' => int|null]
     */
    protected function calculatePrice($promo, float $price): array
    {
        $finalPrice = $price;
        $discountAmount = 0;
        $freeTrialDays = null;

        switch ($promo->type) {
            case 'percentage':
                $discountAmount = $price * ($promo->value / 100);
                $finalPrice = $price - $discountAmount;
                break;

            case 'fixed_amount':
                $discountAmount = min($promo->value, $price); // Can't discount more than price
                $finalPrice = $price - $discountAmount;
                break;

            case 'free_trial':
                $freeTrialDays = intval($promo->value);
                $finalPrice = 0; // Free during trial
                $discountAmount = $price;
                break;
        }

        return [
            'final_price' => max(0, round($finalPrice, 2)), // Never negative
            'discount_amount' => round($discountAmount, 2),
            'free_trial_days' => $freeTrialDays,
        ];
    }

    /**
     * Record promo usage after successful subscription.
     * 
     * @param string $promoId
     * @param string $userId
     * @param string|null $subscriptionId
     * @param float $originalPrice
     * @param float $finalPrice
     * @param float $discountAmount
     * @return \App\Models\PromoUserUsage
     */
    public function recordUsage(
        string $promoId,
        string $userId,
        ?string $subscriptionId,
        float $originalPrice,
        float $finalPrice,
        float $discountAmount
    ) {
        // Record usage
        $usage = $this->promoRepository->recordUsage([
            'promo_id' => $promoId,
            'user_id' => $userId,
            'subscription_id' => $subscriptionId,
            'original_price' => $originalPrice,
            'final_price' => $finalPrice,
            'discount_amount' => $discountAmount,
        ]);

        // Increment promo usage counter
        $this->promoRepository->incrementUsage($promoId);

        return $usage;
    }

    /**
     * Get all active promos for admin.
     */
    public function getAllPromos(int $perPage = 10)
    {
        return $this->promoRepository->getAllPaginated($perPage);
    }

    /**
     * Get promo by ID with conditions.
     */
    public function getPromoById(string $id)
    {
        return $this->promoRepository->getPromoWithConditions($id);
    }

    /**
     * Create new promo.
     */
    public function createPromo(array $data)
    {
        return $this->promoRepository->create($data);
    }

    /**
     * Update existing promo.
     */
    public function updatePromo(string $id, array $data)
    {
        return $this->promoRepository->update($id, $data);
    }

    /**
     * Delete promo.
     */
    public function deletePromo(string $id)
    {
        return $this->promoRepository->delete($id);
    }

    /**
     * Toggle promo active status.
     */
    public function toggleActive(string $id)
    {
        return $this->promoRepository->toggleActive($id);
    }
}
