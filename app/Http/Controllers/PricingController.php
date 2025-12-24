<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PricingBenefitService;
use App\Services\SubscriptionPlanService;
use App\Services\FaqService;
use App\Repositories\BannerRepository;

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

    public function index()
    {
        // Get banner pricing from banners table
        $bannerData = $this->bannerRepository->getActiveBannerPricing();
        $benefits = $this->pricingBenefitService->getActiveBenefitsForDisplay();
        // $plans = $this->subscriptionPlanService->getActivePlansForDisplay();
        $groupedSubscriptionPlans = $this->subscriptionPlanService->getPlansGroupedByCategory();
        $faqs = $this->faqService->getPricingFaqs();

        return view('pricing', compact('bannerData', 'benefits', 'groupedSubscriptionPlans', 'faqs'));
    }

    public function about()
    {
        // Hanya ambil data benefits yang diperlukan
        $benefits = $this->pricingBenefitService->getActiveBenefitsForDisplay();

        // Kirim ke view about-us
        return view('about-us', compact('benefits'));
    }
}
