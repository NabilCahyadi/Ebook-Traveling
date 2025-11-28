<?php

namespace App\Repositories;

use App\Models\SubscriptionPlan;
use App\Repositories\Interfaces\SubscriptionPlanRepositoryInterface;

class SubscriptionPlanRepository implements SubscriptionPlanRepositoryInterface
{
    protected $model;

    public function __construct(SubscriptionPlan $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->orderBy('duration_days', 'asc')->get();
    }

    public function getAllPaginated(int $perPage = 10)
    {
        return $this->model->orderBy('duration_days', 'asc')->paginate($perPage);
    }

    public function getActive()
    {
        return $this->model->where('is_active', true)
            ->orderBy('duration_days', 'asc')
            ->get();
    }

    public function getById(string $id)
    {
        return $this->model->findOrFail($id);
    }

    public function findById(string $id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(string $id, array $data)
    {
        $plan = $this->getById($id);
        $plan->update($data);
        return $plan;
    }

    public function delete(string $id)
    {
        $plan = $this->getById($id);
        return $plan->delete();
    }

    public function hasActiveSubscriptions(string $id): bool
    {
        $plan = $this->getById($id);
        return $plan->subscriptions()->count() > 0;
    }
}
