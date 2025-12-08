<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use App\Services\BannerService;
use App\Services\CityService;
use App\Services\SubscriptionPlanService;
use App\Services\CollectionService;
use App\Services\BlogService;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct(
        private BannerService $bannerService,
        private CityService $cityService,
        private SubscriptionPlanService $subscriptionPlanService,
        private CollectionService $collectionService,
        private BlogService $blogService
    ) {}

    public function index()
    {
        $homeSliders = $this->bannerService->getActiveHomeSliders();
        $topCities = $this->cityService->getHomepageCities(10);
        // $subscriptionPlans = $this->subscriptionPlanService->getHomepagePlans(5);
        $subscriptionPlans = $this->subscriptionPlanService->getActivePlans()->take(3);
        $latestBlogs = $this->blogService->getLatestForHomepage(4);

        // Tambahkan image property jika belum ada
        $subscriptionPlans = $subscriptionPlans->map(function ($plan, $index) {
            if (!isset($plan->image)) {
                $plan->image = $this->getPlanImage($plan->name, $index);
            }
            return $plan;
        });

        // $collections = $this->collectionService->getHomepageCollections();
        $collectionData = $this->collectionService->getHomepageCollectionsWithSubscriptionStatus();


        return view('index', [
            'homeSliders' => $homeSliders,
            'topCities' => $topCities,
            'subscriptionPlans' => $subscriptionPlans,
            'collections' => $collectionData['collections'],
            'isSubscribed' => $collectionData['isSubscribed'],
            'latestBlogs' => $latestBlogs,
        ]);
    }

    private function getPlanImage(string $name, int $index): string
    {
        $imageMap = [
            'Basic Plan' => 'images/banner-subs-1.webp',
            'Premium Plan' => 'images/banner-subs-2.webp',
            'Pro Plan' => 'images/banner-subs-3.webp',
        ];

        if (isset($imageMap[$name])) {
            return $imageMap[$name];
        }

        $defaultImages = [
            'images/banner-subs-1.webp',
            'images/banner-subs-2.webp',
            'images/banner-subs-3.webp'
        ];

        return $defaultImages[$index % count($defaultImages)] ?? 'images/banner-subs-1.webp';
    }
}
