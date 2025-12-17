<?php

// app/Services/PricingBenefitService.php

namespace App\Services;

use App\Repositories\Interfaces\PricingBenefitRepositoryInterface;

class PricingBenefitService
{
    protected $repository;

    public function __construct(PricingBenefitRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getActiveBenefitsForDisplay()
    {
        // Logika bisnis bisa ditambahkan di sini, misalnya caching
        return $this->repository->getAllActiveBenefits();
    }

    public function getAllBenefits()
    {
        return $this->repository->getAll();
    }

    public function getBenefitById($id)
    {
        return $this->repository->findById($id);
    }

    public function createBenefit(array $data)
    {
        // Set default sort_order if not provided
        if (!isset($data['sort_order']) || $data['sort_order'] == 0) {
            $maxOrder = $this->repository->getAll()->max('sort_order') ?? 0;
            $data['sort_order'] = $maxOrder + 1;
        }

        // Convert status to boolean
        $data['status'] = isset($data['status']) && $data['status'] == 1;

        return $this->repository->create($data);
    }

    public function updateBenefit($id, array $data)
    {
        // Convert status to boolean
        $data['status'] = isset($data['status']) && $data['status'] == 1;

        return $this->repository->update($id, $data);
    }

    public function deleteBenefit($id)
    {
        return $this->repository->delete($id);
    }

    public function toggleStatus($id)
    {
        return $this->repository->toggleStatus($id);
    }

    public function updateOrder(array $benefitOrders)
    {
        return $this->repository->updateOrder($benefitOrders);
    }
}
