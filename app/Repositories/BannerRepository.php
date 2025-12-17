<?php

namespace App\Repositories;

use App\Models\Banner;
use Illuminate\Support\Collection;

class BannerRepository
{
    public function getActiveHomeSliders(): Collection
    {
        return Banner::where('type', 'home-slider')
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('start_date')
                    ->orWhere('start_date', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            })
            ->orderBy('order_index', 'asc')
            ->get();
    }

    public function getByType(string $type): Collection
    {
        return Banner::where('type', $type)
            ->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->orderBy('order_index', 'asc')
            ->get();
    }

    public function getActiveBannerPricing(): ?Banner
    {
        return Banner::where('type', 'banner-pricing')
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('start_date')
                    ->orWhere('start_date', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            })
            ->first();
    }

    public function create(array $data): Banner
    {
        return Banner::create($data);
    }

    public function update(Banner $banner, array $data): bool
    {
        return $banner->update($data);
    }

    public function delete(Banner $banner): bool
    {
        return $banner->delete();
    }
}
