<?php

namespace App\Repositories\Interfaces;
use Illuminate\Support\Collection;

interface SubscriptionPlanRepositoryInterface
{
    public function getAll();

    public function getAllPaginated(int $perPage = 10);

    public function getActive();

    public function getById(string $id);

    public function findById(string $id);

    public function create(array $data);

    public function update(string $id, array $data);

    public function delete(string $id);

    public function hasActiveSubscriptions(string $id): bool;

    public function getActivePlans(int $limit = null): Collection;
    public function getAllActive();
}
