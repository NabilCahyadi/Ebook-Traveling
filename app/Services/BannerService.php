<?php

namespace App\Services;

use App\Repositories\BannerRepository;
use Illuminate\Support\Collection;

class BannerService
{
    public function __construct(
        private BannerRepository $bannerRepository
    ) {}

    public function getActiveHomeSliders(): Collection
    {
        return $this->bannerRepository->getActiveHomeSliders();
    }

    public function createHomeSlider(array $data)
    {
        // Validasi business logic
        $data['type'] = 'home_slider';

        return $this->bannerRepository->create($data);
    }

    public function getAvailableBannerTypes(): array
    {
        return [
            'home_slider' => 'Homepage Slider',
            'promo' => 'Promo Banner',
            'announcement' => 'Announcement',
            'sidebar' => 'Sidebar Banner'
        ];
    }

    public function validateBannerDates($startDate, $endDate): bool
    {
        return $startDate < $endDate;
    }
}
