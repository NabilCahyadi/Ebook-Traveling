<?php

namespace App\Repositories\Interfaces;

use App\Models\Subscription;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface SubscriptionRepositoryInterface
{
    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator;
    public function findById(string $id): ?Subscription;
    public function create(array $data): Subscription;
    public function update(Subscription $subscription, array $data): bool;
    public function delete(Subscription $subscription): bool;
    public function getActiveSubscriptions(): Collection;
    public function getUserActiveSubscription(string $userId): ?Subscription;
    public function searchByUser(string $search, int $perPage = 15): LengthAwarePaginator;
}
