<?php
// app/Services/WebsiteManagement/PricingBannerService.php

namespace App\Services\WebsiteManagement;

use App\Repositories\Interfaces\PricingBannerRepositoryInterface;

class PricingBannerService
{
    protected $pricingBannerRepository;

    // Dependency Injection dari Interface, bukan class konkret
    public function __construct(PricingBannerRepositoryInterface $pricingBannerRepository)
    {
        $this->pricingBannerRepository = $pricingBannerRepository;
    }

    public function getActiveBannerData()
    {
        // Logika bisnis bisa ditambahkan di sini
        // Contoh: caching
        // return Cache::remember('active_pricing_banner', 3600, function () {
        //     return $this->pricingBannerRepository->getActiveBanner();
        // });

        return $this->pricingBannerRepository->getActiveBanner();
    }
}
