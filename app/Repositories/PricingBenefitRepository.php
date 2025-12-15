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
}
