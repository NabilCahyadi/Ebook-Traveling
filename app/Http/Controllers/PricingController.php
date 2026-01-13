<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PricingBenefitService;
use App\Services\SubscriptionPlanService;
use App\Services\FaqService;
use App\Repositories\BannerRepository;
use Illuminate\Support\Facades\Auth;
use App\Models\City;

class PricingController extends Controller
{
    protected $bannerRepository;
    protected $pricingBenefitService;
    protected $subscriptionPlanService;
    protected $faqService;

    // Inject services
    public function __construct(
        BannerRepository $bannerRepository,
        PricingBenefitService $pricingBenefitService,
        SubscriptionPlanService $subscriptionPlanService,
        FaqService $faqService,
    ) {
        $this->bannerRepository = $bannerRepository;
        $this->pricingBenefitService = $pricingBenefitService;
        $this->subscriptionPlanService = $subscriptionPlanService;
        // $groupedSubscriptionPlans = $this->subscriptionPlanService->getPlansGroupedByCategory();
        $this->faqService = $faqService;
    }

    public function index(Request $request)
    {
        // Get banner pricing from banners table
        $bannerData = $this->bannerRepository->getActiveBannerPricing();
        $benefits = $this->pricingBenefitService->getActiveBenefitsForDisplay();
        $groupedSubscriptionPlans = $this->subscriptionPlanService->getPlansGroupedByCategory();
        $faqs = $this->faqService->getPricingFaqs();

        $user = Auth::user();
        $citiesHeader = City::where('is_active', true)
            ->orderBy('order_index')
            ->orderBy('name')
            ->get();

        return view('pricing', compact('bannerData', 'benefits', 'groupedSubscriptionPlans', 'faqs', 'user', 'citiesHeader'));
    }

    public function about()
    {
        // Hanya ambil data benefits yang diperlukan
        $benefits = $this->pricingBenefitService->getActiveBenefitsForDisplay();

        // Kirim ke view about-us
        return view('about-us', compact('benefits'));
    }
}
