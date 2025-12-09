<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\LandingPageSection;
use App\Models\Ebook;
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
        // Get landing page sections ordered by order column and visible only
        $landingSections = LandingPageSection::visible()
            ->orderBy('order', 'asc')
            ->with('collection.ebooks')
            ->get();

        // Process sections with custom filters
        $landingSections = $landingSections->map(function ($section) {
            if ($section->filter_config && isset($section->filter_config['source']) && $section->filter_config['source'] === 'custom') {
                // Create a pseudo-collection object with filtered ebooks
                $ebooks = $this->getEbooksByFilter($section->filter_config);
                $section->custom_ebooks = $ebooks;
            }
            return $section;
        });

        // Prepare data for each section
        $homeSliders = $this->bannerService->getActiveHomeSliders();
        $topCities = $this->cityService->getHomepageCities(10);
        $subscriptionPlans = $this->subscriptionPlanService->getActivePlans()->take(3);
        $latestBlogs = $this->blogService->getLatestForHomepage(4);

        // Tambahkan image property jika belum ada
        $subscriptionPlans = $subscriptionPlans->map(function ($plan, $index) {
            if (!isset($plan->image)) {
                $plan->image = $this->getPlanImage($plan->name, $index);
            }
            return $plan;
        });

        $collectionData = $this->collectionService->getHomepageCollectionsWithSubscriptionStatus();

        return view('index', [
            'landingSections' => $landingSections,
            'homeSliders' => $homeSliders,
            'topCities' => $topCities,
            'subscriptionPlans' => $subscriptionPlans,
            'collections' => $collectionData['collections'],
            'isSubscribed' => $collectionData['isSubscribed'],
            'latestBlogs' => $latestBlogs,
        ]);
    }

    private function getEbooksByFilter(array $filterConfig)
    {
        $query = Ebook::where('status', 'published')
            ->with(['creator.user', 'ratings']);

        $filterType = $filterConfig['filter_type'] ?? 'latest';
        $limit = $filterConfig['limit'] ?? 10;

        switch ($filterType) {
            case 'latest':
                $query->orderBy('published_at', 'desc');
                break;

            case 'popular':
                $query->orderBy('view_count', 'desc');
                break;

            case 'top_rated':
                $query->withAvg('ratings', 'rating')
                    ->orderBy('ratings_avg_rating', 'desc');
                break;

            case 'category':
                if (isset($filterConfig['category_id'])) {
                    $query->where('category_id', $filterConfig['category_id']);
                }
                $query->orderBy('published_at', 'desc');
                break;

            case 'city':
                if (isset($filterConfig['city_id'])) {
                    $query->where('city_id', $filterConfig['city_id']);
                }
                $query->orderBy('published_at', 'desc');
                break;

            case 'language':
                if (isset($filterConfig['language'])) {
                    $query->where('language', $filterConfig['language']);
                }
                $query->orderBy('published_at', 'desc');
                break;
        }

        return $query->limit($limit)->get();
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
