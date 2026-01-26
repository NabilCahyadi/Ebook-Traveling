<?php

namespace App\Repositories;

use App\Models\Subscription;
use App\Repositories\Interfaces\SubscriberRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class SubscriberRepository implements SubscriberRepositoryInterface
{
    protected $model;

    public function __construct(Subscription $subscription)
    {
        $this->model = $subscription;
    }

    /**
     * Get filtered subscribers with pagination
     */
    public function getFilteredSubscribers(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model
            ->with(['user.roles', 'plan'])
            ->whereIn('status', ['active', 'pending', 'expired']);

        // Additional check: For 'active' status, ensure end_date hasn't passed
        // This handles cases where automated task hasn't run yet
        $query->where(function ($q) {
            $q->where('status', '!=', 'active')
              ->orWhere(function ($subQ) {
                  $subQ->where('status', 'active')
                       ->where('end_date', '>=', now());
              });
        });

        // Filter by role
        if (!empty($filters['role'])) {
            $query->whereHas('user.roles', function ($q) use ($filters) {
                $q->where('slug', $filters['role']);
            });
        }

        // Filter by subscription plan
        if (!empty($filters['subscription_plan'])) {
            $query->where('subscription_plan_id', $filters['subscription_plan']);
        }

        // Filter by date range
        if (!empty($filters['date_from'])) {
            $query->whereDate('start_date', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate('start_date', '<=', $filters['date_to']);
        }

        // Search by user name or email
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        return $query->latest('created_at')->paginate($perPage);
    }
}
