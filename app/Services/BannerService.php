<?php

namespace App\Services;

use App\Models\Banner;
use App\Repositories\BannerRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

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
    
    public function getAllBanners(int $perPage = 10)
    {
        return Banner::orderBy('created_at', 'desc')->paginate($perPage);
    }
    
    public function getBannerById(string $id)
    {
        return Banner::find($id);
    }
    
    public function createBanner(array $data)
    {
        return Banner::create($data);
    }
    
    public function updateBanner(string $id, array $data)
    {
        $banner = $this->getBannerById($id);
        if (!$banner) {
            return false;
        }
        
        return $banner->update($data);
    }
    
    public function deleteBanner(string $id)
    {
        $banner = $this->getBannerById($id);
        
        if (!$banner) {
            return false;
        }
        
        return $banner->delete(); // Soft delete
    }
    
    public function restoreBanner(string $id)
    {
        $banner = Banner::onlyTrashed()->find($id);
        
        if (!$banner) {
            return false;
        }
        
        return $banner->restore();
    }
    
    public function forceDeleteBanner(string $id)
    {
        $banner = Banner::onlyTrashed()->find($id);
        
        if (!$banner) {
            return false;
        }
        
        // Delete image if exists
        if ($banner->image_path) {
            Storage::disk('public')->delete($banner->image_path);
        }
        
        return $banner->forceDelete();
    }
    
    public function getTrashedBanners(int $perPage = 10)
    {
        return Banner::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate($perPage);
    }
}
