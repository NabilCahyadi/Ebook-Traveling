<?php

namespace App\Services;

use App\Repositories\Interfaces\CityRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class CityService
{
    protected $cityRepository;

    public function __construct(CityRepositoryInterface $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    public function getAllCities(int $perPage = 10)
    {
        return $this->cityRepository->paginate($perPage);
    }

    public function getCityById(string $id)
    {
        return $this->cityRepository->find($id);
    }

    public function createCity(array $data)
    {
        return $this->cityRepository->create($data);
    }

    public function updateCity(string $id, array $data)
    {
        return $this->cityRepository->update($id, $data);
    }

    public function deleteCity(string $id)
    {
        // For now, allow deletion since city-ebook relationship is not implemented yet
        return $this->cityRepository->delete($id);
    }

    public function getCitiesByCountry(string $country)
    {
        return $this->cityRepository->findByCountry($country);
    }

    public function getPopularCities(int $limit = 10): Collection
    {
        try {
            $cities = $this->cityRepository->getPopularCities($limit);

            // Jika hasil kosong, gunakan fallback
            if ($cities->isEmpty()) {
                return $this->getFallbackCities()->take($limit);
            }

            return $cities;
        } catch (\Exception $e) {
            // Fallback jika repository error
            return $this->getFallbackCities()->take($limit);
        }
    }

    public function getPopularCitiesWithEbookCount(int $limit = 10): Collection
    {
        try {
            $cities = $this->cityRepository->getPopularCities($limit);

            // If results are empty, use fallback
            if ($cities->isEmpty()) {
                return $this->getRealTimeFallbackCities()->take($limit);
            }

            // Map items_count from ebooks_count that's already loaded from database
            return $cities->map(function ($city) {
                $city->items_count = $city->ebooks_count ?? 0;
                return $city;
            });
        } catch (\Exception $e) {
            // Fallback to real-time data if there's an error
            return $this->getRealTimeFallbackCities()->take($limit);
        }
    }

    public function getHomepageCities(int $limit = 10): Collection
    {
        // Method khusus untuk homepage dengan fallback yang robust
        try {
            $cities = $this->getPopularCitiesWithEbookCount($limit);

            // Pastikan semua city punya items_count
            return $cities->map(function ($city) {
                $city->items_count = $city->items_count ?? 0;
                return $city;
            });
        } catch (\Exception $e) {
            // Ultimate fallback
            return $this->getRealTimeFallbackCities()->take($limit);
        }
    }

    /**
     * Get real-time fallback cities dengan count ebook dari database
     */
    public function getRealTimeFallbackCities(): Collection
    {
        // Ambil semua cities dari database dengan ebook count
        $cities = \App\Models\City::withCount('ebooks')
            ->where('is_active', true)
            ->orderBy('ebooks_count', 'desc')
            ->take(10)
            ->get();

        // Jika database kosong, gunakan fallback statis
        if ($cities->isEmpty()) {
            return $this->getFallbackCities();
        }

        // Map ke format yang konsisten
        return $cities->map(function ($city) {
            $city->items_count = $city->ebooks_count ?? 0;
            return $city;
        });
    }

    public function getCityBySlug(string $slug)
    {
        try {
            $city = $this->cityRepository->findBySlug($slug);

            if ($city) {
                // Increment views
                $this->cityRepository->incrementViews($city->id);
                return $city;
            }
        } catch (\Exception $e) {
            Log::error("Error getting city by slug: {$e->getMessage()}");
        }

        return null;
    }

    public function getFallbackCities(): Collection
    {
        return collect([
            [
                'name' => 'Bandung',
                'slug' => 'bandung',
                'image' => 'images/ach.jpg',
                'items_count' => 26
            ],
            [
                'name' => 'Surabaya',
                'slug' => 'surabaya',
                'image' => 'images/mdn.jpg',
                'items_count' => 28
            ],
            [
                'name' => 'Semarang',
                'slug' => 'semarang',
                'image' => 'images/pdg.jpg',
                'items_count' => 14
            ],
            [
                'name' => 'Jakarta',
                'slug' => 'jakarta',
                'image' => 'images/jkt.jpg',
                'items_count' => 54
            ],
            [
                'name' => 'Serang',
                'slug' => 'serang',
                'image' => 'images/ach.jpg',
                'items_count' => 56
            ],
            [
                'name' => 'Medan',
                'slug' => 'medan',
                'image' => 'images/mdn.jpg',
                'items_count' => 72
            ],
            [
                'name' => 'Makassar',
                'slug' => 'makassar',
                'image' => 'images/pdg.jpg',
                'items_count' => 36
            ],
            [
                'name' => 'Yogyakarta',
                'slug' => 'yogyakarta',
                'image' => 'images/jkt.jpg',
                'items_count' => 123
            ],
            [
                'name' => 'Bandar Lampung',
                'slug' => 'bandar-lampung',
                'image' => 'images/ach.jpg',
                'items_count' => 34
            ],
            [
                'name' => 'Denpasar',
                'slug' => 'denpasar',
                'image' => 'images/mdn.jpg',
                'items_count' => 89
            ]
        ])->map(function ($item) {
            return (object) $item; // Convert array ke object untuk konsistensi
        });
    }
}
