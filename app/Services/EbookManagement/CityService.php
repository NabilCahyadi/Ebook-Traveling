<?php

namespace App\Services\EbookManagement;

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
            $cities = $this->cityRepository->getPopularCities($limit);

            // Jika hasil kosong, gunakan fallback
            if ($cities->isEmpty()) {
                return $this->getRealTimeFallbackCities()->take($limit);
            }

            // Map items_count dari ebooks_count yang sudah di-load dari database
            return $cities->map(function ($city) {
                $city->items_count = $city->ebooks_count ?? 0;
                return $city;
            });
        } catch (\Exception $e) {
            // Fallback ke data real-time jika ada error
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

    public function getCityBySlugWithEbooks(string $slug)
    {
        // Delegate the query to the repository
        return $this->cityRepository->findBySlugWithEbooks($slug);
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

    public function getPopularCitiesForSlider(int $limit = 10)
    {
        return $this->cityRepository->getPopularCities($limit);
    }

    public function getAllCitiesForCards(): Collection
    {
        return $this->cityRepository->getAllCitiesWithRanking();
    }

    public function getFallbackCities(): Collection
    {
        return collect([
            [
                'name' => 'Bandung',
                'slug' => 'bandung',
                'image' => 'https://media.timeout.com/images/106211627/image.jpg',
                'items_count' => 26
            ],
            [
                'name' => 'Surabaya',
                'slug' => 'surabaya',
                'image' => 'https://lh3.googleusercontent.com/gps-cs-s/AG0ilSxn-83rEDG4n1j2nNcvioCxocV0t3oHJZwExGG5wM2txHf6h6lLAyRv-MH28zC95SwqgEwgaUQWVQMydTsSjihMeCEt9GNbIIJbaZIEeiUkSOtFNMDXsAuViBAZlzCsYV6skQU=w729-h421-n-k-no',
                'items_count' => 28
            ],
            [
                'name' => 'Semarang',
                'slug' => 'semarang',
                'image' => 'https://lh3.googleusercontent.com/gps-cs-s/AG0ilSzPm72y2UC4JLCmk9K91ByylfOaipR6aIqprnCZWANacIVei1r2ntMIw87qq1176Cuu5N5KpO6lVhU_bbsKesw4az99egiIs9aCAxHMgmfhNs9yEQh__h8WzFU8CPE71LU6ZTmb=w729-h421-n-k-no',
                'items_count' => 14
            ],
            [
                'name' => 'Jakarta',
                'slug' => 'jakarta',
                'image' => '/images/jkt.jpg',
                'items_count' => 54
            ],
            [
                'name' => 'Serang',
                'slug' => 'serang',
                'image' => '/images/ach.jpg',
                'items_count' => 56
            ],
            [
                'name' => 'Medan',
                'slug' => 'medan',
                'image' => '/images/mdn.jpg',
                'items_count' => 72
            ],
            [
                'name' => 'Makassar',
                'slug' => 'makassar',
                'image' => 'https://lh3.googleusercontent.com/gps-cs-s/AG0ilSxiCMilMCt3jvL8hIZ0lt4OQmQVHW1rJED8pcKSzu7dQFD08uj-ziGZKKtrhAZoQrsShZvVCIFtjz2v2gJfQL3BHbfrH9Ld8fbx2bUe34jc7vbcmsqlV-4SeogZBzTEThzpHrtz=w729-h421-n-k-no',
                'items_count' => 36
            ],
            [
                'name' => 'Yogyakarta',
                'slug' => 'yogyakarta',
                'image' => 'https://www.yogyes.com/id/yogyakarta-tourism-object/candi/prambanan/1.jpg',
                'items_count' => 123
            ],
            [
                'name' => 'Bandar Lampung',
                'slug' => 'bandar-lampung',
                'image' => 'https://ik.imagekit.io/tvlk/blog/2025/04/Open-Trip-One-Day-Pulau-Pahawang-Dermaga-Ketapang-Lampung-674f1082-d294-408d-b5c7-7b0a6034a480.jpeg-1024x768.webp?tr=q-70,c-at_max,w-1000,h-600',
                'items_count' => 34
            ],
            [
                'name' => 'Denpasar',
                'slug' => 'denpasar',
                'image' => 'https://bobobox.com/blog/wp-content//uploads/2023/10/Tempat-Wisata-di-Denpasar-1200x900.webp',
                'items_count' => 89
            ]
        ])->map(function ($item) {
            return (object) $item; // Convert array ke object untuk konsistensi
        });
    }

    /**
     * Get all active cities for admin selection
     * Ordered by number of ebooks (most ebooks first)
     */
    public function getAllActiveCities()
    {
        return \App\Models\City::where('is_active', true)
            ->withCount('ebooks')
            ->orderBy('ebooks_count', 'desc')
            ->orderBy('name', 'asc')
            ->get();
    }

    /**
     * Get curated cities for landing page
     */
    public function getCuratedCities(array $cityIds)
    {
        if (empty($cityIds)) {
            return collect();
        }

        // Get cities by IDs and maintain order
        $cities = \App\Models\City::whereIn('id', $cityIds)
            ->where('is_active', true)
            ->get()
            ->sortBy(function ($city) use ($cityIds) {
                return array_search($city->id, $cityIds);
            });

        return $cities;
    }
}
