<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PricingBenefit;
use App\Services\PricingBenefitService;
use App\Models\AboutUsSection;
use App\Models\Blog;
use App\Models\City;

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
        // Ambil data benefits
        $benefits = PricingBenefit::where('status', 'active')->orderBy('sort_order')->get();
        $benefits = $this->pricingBenefitService->getActiveBenefitsForDisplay();
        // Ambil data section About Us
        $aboutSections = AboutUsSection::where('is_active', true)
            ->orderBy('order_index', 'asc')
            ->get()
            ->keyBy('section_key'); // Ubah menjadi array asosiatif
        
        // Ambil latest blog images dengan validasi
        $latestBlogImages = Blog::latest()
            ->take(4)
            ->pluck('featured_image')
            ->filter(function($image) {
                // Validasi bahwa image file benar-benar ada
                if (empty($image)) {
                    return false;
                }
                // Cek apakah file ada di storage
                $filePath = storage_path('app/public/' . $image);
                return file_exists($filePath);
            })
            ->values(); // Re-index array
        
        $citiesHeader = City::where('is_active', true)
            ->orderBy('order_index')
            ->orderBy('name')
            ->get();
        return view('about-us', compact('benefits', 'aboutSections', 'latestBlogImages', 'citiesHeader'));
    }
}
