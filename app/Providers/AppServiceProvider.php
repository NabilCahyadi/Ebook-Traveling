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
use App\Models\Ebook;
use App\Observers\EbookObserver;
use App\Models\User;
use App\Observers\UserObserver;
use App\Models\Role;
use App\Observers\RoleObserver;
use App\Models\Blog;
use App\Observers\BlogObserver;
use App\Models\Category;
use App\Observers\CategoryObserver;
use App\Models\Banner;
use App\Observers\BannerObserver;
use App\Models\SubscriptionPlan;
use App\Observers\SubscriptionPlanObserver;
use App\Repositories\Interfaces\RatingRepositoryInterface;
use App\Repositories\RatingRepository;
use App\Services\RatingService;
use App\Repositories\PricingBannerRepository;
use App\Repositories\Interfaces\PricingBannerRepositoryInterface;
use App\Repositories\Interfaces\PricingBenefitRepositoryInterface;
use App\Repositories\PricingBenefitRepository;
use App\Repositories\Interfaces\FaqRepositoryInterface;
use App\Repositories\FaqRepository;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
        $this->app->bind(RatingRepositoryInterface::class, RatingRepository::class);
        $this->app->singleton(RatingService::class, function ($app) {
            return new RatingService($app->make(RatingRepositoryInterface::class));
        });
        $this->app->bind(
            PricingBannerRepositoryInterface::class,
            PricingBannerRepository::class
        );
        $this->app->bind(
            PricingBenefitRepositoryInterface::class,
            PricingBenefitRepository::class
        );
        $this->app->bind(
            FaqRepositoryInterface::class,
            FaqRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register all observers
        Rating::observe(RatingObserver::class);
        Ebook::observe(EbookObserver::class);
        User::observe(UserObserver::class);
        Role::observe(RoleObserver::class);
        Blog::observe(BlogObserver::class);
        Category::observe(CategoryObserver::class);
        Banner::observe(BannerObserver::class);
        SubscriptionPlan::observe(SubscriptionPlanObserver::class);

        Paginator::useBootstrapFive();

        // Register View Composer for sidebar
        View::composer('layouts.partials.admin.sidebar', SidebarComposer::class);

        View::composer('*', function ($view) {
            $ctaBackground = '/images/default-bg.webp'; // Path default jika belum di-setting

            // Cek apakah tabel ada untuk menghindari error saat fresh install
            if (Schema::hasTable('system_settings')) {
                $setting = DB::table('system_settings')->where('key', 'default_cta_background_path')->first();
                if ($setting) {
                    $ctaBackground = $setting->value;
                }
            }

            // Bagikan variabel ke view
            $view->with('ctaBackground', $ctaBackground);
        });
    }
}
