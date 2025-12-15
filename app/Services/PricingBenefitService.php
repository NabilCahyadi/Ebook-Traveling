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
}
