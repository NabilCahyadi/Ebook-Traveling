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
use App\Models\BlogCategory;
use App\Observers\BlogCategoryObserver;

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
        // Register all observers
        Rating::observe(RatingObserver::class);
        Ebook::observe(EbookObserver::class);
        User::observe(UserObserver::class);
        Role::observe(RoleObserver::class);
        Blog::observe(BlogObserver::class);
        Category::observe(CategoryObserver::class);
        Banner::observe(BannerObserver::class);
        SubscriptionPlan::observe(SubscriptionPlanObserver::class);
        BlogCategory::observe(BlogCategoryObserver::class);

        Paginator::useBootstrapFive();

        // Register View Composer for sidebar
        View::composer('layouts.partials.admin.sidebar', SidebarComposer::class);
    }
}
