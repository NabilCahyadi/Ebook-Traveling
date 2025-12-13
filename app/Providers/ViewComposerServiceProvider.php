<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Services\CategoryService;
use App\Services\CityService;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // --- View Composer untuk Dropdown Kategori di Header ---
        // Ini akan berjalan untuk semua view di dalam folder 'layouts_lp'
        View::composer('layouts_lp.*', function ($view) {
            $categoryService = app(CategoryService::class);
            $categories = $categoryService->getHeaderCategories();

            $view->with('headerCategories', $categories);
        });

        // --- View Composer untuk Slider di Halaman Utama ---
        // Ini akan berjalan hanya untuk view 'welcome' (ganti jika perlu)
        View::composer('destinations', function ($view) {
            $cityService = app(CityService::class);
            $popularCities = $cityService->getPopularCitiesForSlider(10);

            $view->with('popularCities', $popularCities);
        });

        // Untuk kartu destinasi
        View::composer('destinations', function ($view) {
            $cityService = app(CityService::class);
            $allCities = $cityService->getAllCitiesForCards();

            $view->with('allCities', $allCities);
        });
    }
}
