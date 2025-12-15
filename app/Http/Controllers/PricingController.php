<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PricingBannerService;
use App\Services\PricingBenefitService;
use App\Services\SubscriptionPlanService;
use App\Services\FaqService;

class PricingController extends Controller
{
    protected $pricingBannerService;
    protected $pricingBenefitService;
    protected $subscriptionPlanService;
    protected $faqService;

    // Inject kedua service
    public function __construct(
        PricingBannerService $pricingBannerService,
        PricingBenefitService $pricingBenefitService,
        SubscriptionPlanService $subscriptionPlanService,
        FaqService $faqService,
    ) {
        $this->pricingBannerService = $pricingBannerService;
        $this->pricingBenefitService = $pricingBenefitService;
        $this->subscriptionPlanService = $subscriptionPlanService;
        $this->faqService = $faqService;
    }

    public function index()
    {
        $bannerData = $this->pricingBannerService->getActiveBannerData();
        $benefits = $this->pricingBenefitService->getActiveBenefitsForDisplay(); // Panggil service baru
        $plans = $this->subscriptionPlanService->getActivePlansForDisplay();
        $faqs = $this->faqService->getPricingFaqs();

        // 5. Kirim variabel $plans ke view menggunakan compact()
        return view('pricing', compact('bannerData', 'benefits', 'plans', 'faqs'));
    }
}
