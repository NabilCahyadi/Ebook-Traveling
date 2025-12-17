<?php

// app/Repositories/PricingBenefitRepository.php

namespace App\Repositories;

use App\Models\PricingBenefit;
use App\Repositories\Interfaces\PricingBenefitRepositoryInterface;

class PricingBenefitRepository implements PricingBenefitRepositoryInterface
{
    protected $model;

    public function __construct(PricingBenefit $model)
    {
        $this->model = $model;
    }

    public function getAllActiveBenefits()
    {
        return $this->model->where('status', 'active')->orderBy('sort_order', 'asc')->get();
    }

    public function getAll()
    {
        return $this->model->orderBy('sort_order', 'asc')->get();
    }

    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $benefit = $this->findById($id);
        $benefit->update($data);
        return $benefit;
    }

    public function delete($id)
    {
        $benefit = $this->findById($id);
        return $benefit->delete();
    }

    public function updateOrder(array $benefitOrders)
    {
        foreach ($benefitOrders as $order) {
            $this->model->where('id', $order['id'])->update(['sort_order' => $order['sort_order']]);
        }
        return true;
    }

    public function toggleStatus($id)
    {
        $benefit = $this->findById($id);
        $benefit->status = !$benefit->status;
        $benefit->save();
        return $benefit;
    }
}
