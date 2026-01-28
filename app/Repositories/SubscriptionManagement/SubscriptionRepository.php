<?php

namespace App\Repositories\SubscriptionManagement;

use App\Models\Subscription;
use App\Repositories\Interfaces\SubscriptionRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class SubscriptionRepository implements SubscriptionRepositoryInterface
{
    protected $model;

    public function __construct(Subscription $subscription)
    {
        $this->model = $subscription;
    }

    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->with(['user', 'plan'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function findById(string $id): ?Subscription
    {
        return $this->model->with(['user', 'plan'])->find($id);
    }

    public function create(array $data): Subscription
    {
        return $this->model->create($data);
    }

    public function update(Subscription $subscription, array $data): bool
    {
        return $subscription->update($data);
    }

    public function delete(Subscription $subscription): bool
    {
        return $subscription->delete();
    }

    public function getActiveSubscriptions(): Collection
    {
        return $this->model
            ->with(['user', 'plan'])
            ->where('status', 'active')
            ->where('end_date', '>', now())
            ->get();
    }

    public function getUserActiveSubscription(string $userId): ?Subscription
    {
        return $this->model
            ->with(['plan'])
            ->where('user_id', $userId)
            ->where('status', 'active')
            ->where('end_date', '>', now())
            ->first();
    }

    public function searchByUser(string $search, int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->with(['user', 'plan'])
            ->whereHas('user', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->orWhere('subscription_code', 'like', "%{$search}%")
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }
}
