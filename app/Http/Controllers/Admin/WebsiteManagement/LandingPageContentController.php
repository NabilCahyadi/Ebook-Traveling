<?php

namespace App\Http\Controllers\Admin\WebsiteManagement;

use App\Http\Controllers\Controller;
use App\Services\CityService;
use App\Services\BlogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LandingPageContentController extends Controller
{
    protected $cityService;
    protected $blogService;

    public function __construct(
        CityService $cityService,
        BlogService $blogService
    ) {
        $this->cityService = $cityService;
        $this->blogService = $blogService;
    }

    /**
     * Show form to curate Top 10 Cities content
     */
    public function editTopCities()
    {
        // Get or create Top 10 Cities section
        $section = \App\Models\LandingPageSection::firstOrCreate(
            ['section_type' => 'top_cities'],
            [
                'section_name' => 'Top 10 Cities',
                'order' => 1,
                'is_visible' => true,
                'config' => ['selected_cities' => []]
            ]
        );

        // Get all active cities
        $allCities = $this->cityService->getAllActiveCities();
        
        // Get selected city IDs from config
        $selectedCityIds = $section->config['selected_cities'] ?? [];
        
        // Get selected cities in order
        $selectedCities = collect();
        if (!empty($selectedCityIds)) {
            foreach ($selectedCityIds as $cityId) {
                $city = $allCities->firstWhere('id', $cityId);
                if ($city) {
                    $selectedCities->push($city);
                }
            }
        }

        return view('admin.website-management.landing-page.top-cities', compact('section', 'allCities', 'selectedCities'));
    }

    /**
     * Update Top 10 Cities content
     */
    public function updateTopCities(Request $request)
    {
        $validated = $request->validate([
            'selected_cities' => 'required|array|min:1|max:10',
            'selected_cities.*' => 'required|exists:cities,id',
            'is_visible' => 'nullable|boolean'
        ], [
            'selected_cities.required' => 'Pilih minimal 1 kota',
            'selected_cities.max' => 'Maksimal 10 kota',
            'selected_cities.*.exists' => 'Kota tidak valid'
        ]);

        try {
            DB::beginTransaction();

            $section = \App\Models\LandingPageSection::firstOrCreate(
                ['section_type' => 'top_cities'],
                [
                    'section_name' => 'Top 10 Cities',
                    'order' => 1,
                    'is_visible' => true
                ]
            );

            $section->update([
                'config' => [
                    'selected_cities' => $validated['selected_cities']
                ],
                'is_visible' => $request->has('is_visible') ? 1 : 0
            ]);

            DB::commit();

            return redirect()->route('admin.landing-page-content.top-cities')
                ->with('success', 'Top 10 Cities berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate: ' . $e->getMessage());
        }
    }

    /**
     * Show form to curate Latest Blogs content
     */
    public function editLatestBlogs()
    {
        // Get or create Latest Blogs section
        $section = \App\Models\LandingPageSection::firstOrCreate(
            ['section_type' => 'latest_blogs'],
            [
                'section_name' => 'Latest Blogs',
                'order' => 10,
                'is_visible' => true,
                'config' => ['selected_blogs' => [], 'display_count' => 4]
            ]
        );

        // Get all published blogs
        $allBlogs = $this->blogService->getAllPublishedBlogs();
        
        // Get selected blog IDs from config
        $selectedBlogIds = $section->config['selected_blogs'] ?? [];
        $displayCount = $section->config['display_count'] ?? 4;
        
        // Get selected blogs in order
        $selectedBlogs = collect();
        if (!empty($selectedBlogIds)) {
            foreach ($selectedBlogIds as $blogId) {
                $blog = $allBlogs->firstWhere('id', $blogId);
                if ($blog) {
                    $selectedBlogs->push($blog);
                }
            }
        }

        return view('admin.website-management.landing-page.latest-blogs', compact('section', 'allBlogs', 'selectedBlogs', 'displayCount'));
    }

    /**
     * Update Latest Blogs content
     */
    public function updateLatestBlogs(Request $request)
    {
        $validated = $request->validate([
            'selected_blogs' => 'required|array|min:1',
            'selected_blogs.*' => 'required|exists:blogs,id',
            'display_count' => 'required|integer|min:1|max:12',
            'is_visible' => 'nullable|boolean'
        ], [
            'selected_blogs.required' => 'Pilih minimal 1 blog',
            'selected_blogs.*.exists' => 'Blog tidak valid',
            'display_count.required' => 'Jumlah tampilan wajib diisi',
            'display_count.min' => 'Minimal 1 blog',
            'display_count.max' => 'Maksimal 12 blog'
        ]);

        try {
            DB::beginTransaction();

            $section = \App\Models\LandingPageSection::firstOrCreate(
                ['section_type' => 'latest_blogs'],
                [
                    'section_name' => 'Latest Blogs',
                    'order' => 10,
                    'is_visible' => true
                ]
            );

            $section->update([
                'config' => [
                    'selected_blogs' => $validated['selected_blogs'],
                    'display_count' => $validated['display_count']
                ],
                'is_visible' => $request->has('is_visible') ? 1 : 0
            ]);

            DB::commit();

            return redirect()->route('admin.landing-page-content.latest-blogs')
                ->with('success', 'Latest Blogs berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate: ' . $e->getMessage());
        }
    }

    /**
     * Dashboard/Index untuk content management
     */
    public function index()
    {
        $topCitiesSection = \App\Models\LandingPageSection::where('section_type', 'top_cities')->first();
        $latestBlogsSection = \App\Models\LandingPageSection::where('section_type', 'latest_blogs')->first();

        $topCitiesCount = $topCitiesSection && isset($topCitiesSection->config['selected_cities']) 
            ? count($topCitiesSection->config['selected_cities']) 
            : 0;

        $latestBlogsCount = $latestBlogsSection && isset($latestBlogsSection->config['selected_blogs']) 
            ? count($latestBlogsSection->config['selected_blogs']) 
            : 0;

        return view('admin.website-management.landing-page.index', compact(
            'topCitiesSection',
            'latestBlogsSection',
            'topCitiesCount',
            'latestBlogsCount'
        ));
    }
}
