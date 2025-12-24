<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PricingBenefit;
use App\Services\PricingBenefitService; 

class AboutController extends Controller
{
    // Inject Service ke constructor
    protected $pricingBenefitService;

    public function __construct(PricingBenefitService $pricingBenefitService)
    {
        $this->pricingBenefitService = $pricingBenefitService;
    }

    /**
     * Display about us page.
     */
    public function index()
    {
        // Panggil method dari Service untuk mendapatkan data
        $benefits = $this->pricingBenefitService->getActiveBenefitsForDisplay();

        // Kirim data ke view
        return view('about-us', compact('benefits'));
    }
}
