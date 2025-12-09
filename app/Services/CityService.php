<?php

namespace App\Services;

use App\Repositories\Interfaces\CityRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\Category;

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
            $cities = $this->getPopularCities($limit);

            // Karena ebook belum ada, kita beri nilai statis atau acak untuk demo
            return $cities->map(function ($city) {
                // Berikan nilai contoh, misalnya 10 items untuk setiap kota
                $city->items_count = (0); // atau angka statis seperti 10
                return $city;
            });
        } catch (\Exception $e) {
            // Fallback ke data statis jika ada error
            return $this->getFallbackCities()->take($limit);
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
            return $this->getFallbackCities()->take($limit);
        }
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

    /**
     * =================================================================
     *  METHOD BARU: Mengambil e-book berdasarkan nama kota (kategori)
     * =================================================================
     *
     * @param string $cityName
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getEbooksByCityName(string $cityName)
    {
        // Cari kategori yang namanya sama dengan nama kota
        $category = Category::where('name', $cityName)->first();

        // Jika kategori tidak ditemukan, kembalikan koleksi kosong
        if (!$category) {
            return collect([]);
        }

        // Ambil semua e-book yang terhubung dengan kategori ini
        // Eager load relasi 'creator' dan 'ratings' untuk menghindari N+1 problem
        // dan untuk ditampilkan di view
        return $category->ebooks()
            ->with(['creator', 'ratings'])
            ->where('status', 'published') // Opsional: Hanya ambil ebook yang sudah dipublish
            ->get();
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
