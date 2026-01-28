<?php

namespace App\Repositories\SubscriptionManagement;

use App\Models\Subscription;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class SubscriptionHistoryRepository
{
    /**
     * Get subscription history with filters
     */
    public function getAllWithFilters(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Subscription::with(['user', 'subscriptionPlan', 'payment']);

        // Filter by user
        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        // Filter by status
        if (!empty($filters['status']) && $filters['status'] !== 'all') {
            $query->where('status', $filters['status']);
        }

        // Filter by plan
        if (!empty($filters['plan_id'])) {
            $query->where('subscription_plan_id', $filters['plan_id']);
        }

        // Filter by date range
        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }
        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        // Search
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('subscription_code', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        return $query->latest()->paginate($perPage);
    }

    /**
     * Get user subscription history
     */
    public function getUserHistory(int $userId, int $perPage = 10): LengthAwarePaginator
    {
        return Subscription::with(['subscriptionPlan', 'payment'])
            ->where('user_id', $userId)
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get subscription history by subscription code
     */
    public function findByCode(string $code): ?Subscription
    {
        return Subscription::with(['user', 'subscriptionPlan', 'payment'])
            ->where('subscription_code', $code)
            ->first();
    }

    /**
     * Get statistics
     */
    public function getStatistics(array $dateRange = []): array
    {
        $query = Subscription::query();

        if (!empty($dateRange['from'])) {
            $query->whereDate('created_at', '>=', $dateRange['from']);
        }
        if (!empty($dateRange['to'])) {
            $query->whereDate('created_at', '<=', $dateRange['to']);
        }

        return [
            'total' => (clone $query)->count(),
            'active' => (clone $query)->where('status', 'active')->where('end_date', '>', now())->count(),
            'expired' => (clone $query)->where('status', 'active')->where('end_date', '<=', now())->count(),
            'cancelled' => (clone $query)->where('status', 'cancelled')->count(),
            'total_revenue' => (clone $query)->whereIn('status', ['active', 'expired'])->sum('total_amount'),
        ];
    }

    /**
     * Get for export
     */
    public function getAllForExport(array $filters = []): Collection
    {
        $query = Subscription::with(['user', 'subscriptionPlan', 'payment']);

        if (!empty($filters['status']) && $filters['status'] !== 'all') {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        return $query->latest()->get();
    }
}
