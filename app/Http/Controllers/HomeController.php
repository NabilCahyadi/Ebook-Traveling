<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\City;
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
        private SubscriptionPlanService $SubscriptionPlanService,
        private CollectionService $collectionService,
        private BlogService $blogService
    ) {}

    public function index()
    {
        $homeSliders = $this->bannerService->getActiveHomeSliders();

        // Check if curated content exists for Top Cities
        $topCitiesSection = \App\Models\LandingPageSection::where('section_type', 'top_cities')
            ->where('is_visible', true)
            ->first();

        if ($topCitiesSection && isset($topCitiesSection->config['selected_cities']) && !empty($topCitiesSection->config['selected_cities'])) {
            // Use curated cities
            $topCities = $this->cityService->getCuratedCities($topCitiesSection->config['selected_cities']);
        } else {
            // Fallback to popular cities
            $topCities = $this->cityService->getHomepageCities(10);
        }

        // Check if curated content exists for Latest Blogs
        $latestBlogsSection = \App\Models\LandingPageSection::where('section_type', 'latest_blogs')
            ->where('is_visible', true)
            ->first();

        if ($latestBlogsSection && isset($latestBlogsSection->config['selected_blogs']) && !empty($latestBlogsSection->config['selected_blogs'])) {
            // Use curated blogs
            $displayCount = $latestBlogsSection->config['display_count'] ?? 4;
            $latestBlogs = $this->blogService->getCuratedBlogs($latestBlogsSection->config['selected_blogs'], $displayCount);
        } else {
            // Fallback to latest blogs
            $latestBlogs = $this->blogService->getLatestForHomepage(4);
        }
        $SubscriptionPlans = $this->SubscriptionPlanService->getActivePlans()->take(3);
        $groupedSubscriptionPlans = $this->SubscriptionPlanService->getPlansGroupedByCategory();

        // Tambahkan image property jika belum ada
        $SubscriptionPlans = $SubscriptionPlans->map(function ($plan, $index) {
            if (!isset($plan->image)) {
                $plan->image = $this->getPlanImage($plan->name, $index);
            }
            return $plan;
        });

        // $collections = $this->collectionService->getHomepageCollections();
        $collectionData = $this->collectionService->getHomepageCollectionsWithSubscriptionStatus();

        $citiesHeader = City::where('is_active', true)
            ->orderBy('order_index')
            ->orderBy('name')
            ->get();

        return view('index', [
            'homeSliders' => $homeSliders,
            'topCities' => $topCities,
            'SubscriptionPlans' => $SubscriptionPlans,
            'collections' => $collectionData['collections'],
            'isSubscribed' => $collectionData['isSubscribed'],
            'latestBlogs' => $latestBlogs,
            'groupedSubscriptionPlans' => $groupedSubscriptionPlans,
            'citiesHeader' => $citiesHeader,
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
