<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use App\View\Composers\SidebarComposer;
use App\Repositories\BannerRepository;
use App\Services\BannerService;
use App\Repositories\Interfaces\CollectionRepositoryInterface;
use App\Repositories\CollectionRepository;
use App\Models\Rating;
use App\Observers\RatingObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BannerRepository::class);
        $this->app->bind(BannerService::class);
        $this->app->bind(CollectionRepositoryInterface::class, CollectionRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Rating::observe(RatingObserver::class);
        Paginator::useBootstrapFive();

        // Register View Composer for sidebar
        View::composer('layouts.partials.admin.sidebar', SidebarComposer::class);
    }
}
