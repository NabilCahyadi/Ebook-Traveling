<?php
// app/Repositories/WebsiteManagement/PricingBannerRepository.php

namespace App\Repositories\WebsiteManagement;

use App\Models\PricingBanner;
use App\Repositories\Interfaces\PricingBannerRepositoryInterface;

class PricingBannerRepository implements PricingBannerRepositoryInterface
{
    protected $model;

    public function __construct(PricingBanner $model)
    {
        $this->model = $model;
    }

    public function getActiveBanner()
    {
        return $this->model->where('status', 'active')->first();
    }
}
