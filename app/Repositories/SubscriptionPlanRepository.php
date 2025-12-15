<?php

namespace App\Repositories;

use App\Models\SubscriptionPlan;
use App\Repositories\Interfaces\SubscriptionPlanRepositoryInterface;
use Illuminate\Support\Collection;

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

    /**
     * Get all active plans, sorted for display on the pricing page.
     * Ini adalah SATU-SATUNYA method yang akan kita gunakan untuk mengambil data pricing.
     */
    public function getAllActivePlans()
    {
        // PASTIKAN MENGGUNAKAN 'sort_order' SESUAI MIGRATION DAN SEEDER
        return $this->model->where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get();
    }

    public function getActive()
    {
        return $this->model->where('is_active', true)
            ->orderBy('duration_days', 'asc') // Urutkan berbeda
            ->get();
    }
}
