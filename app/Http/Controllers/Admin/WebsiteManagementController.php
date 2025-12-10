<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\LandingPageSection;
use App\Models\Ebook;
use App\Models\Category;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WebsiteManagementController extends Controller
{
    /**
     * Display landing page sections management page
     */
    public function landingSections()
    {
        $sections = LandingPageSection::with('collection')
            ->orderBy('order', 'asc')
            ->get();

        $collections = Collection::active()->get();

        return view('admin.website-management.landing-sections', compact('sections', 'collections'));
    }

    /**
     * Update landing page sections order
     */
    public function updateLandingSections(Request $request)
    {
        $request->validate([
            'sections' => 'required|array',
            'sections.*.id' => 'required|exists:landing_page_sections,id',
            'sections.*.order' => 'required|integer',
            'sections.*.is_visible' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->sections as $sectionData) {
                LandingPageSection::where('id', $sectionData['id'])->update([
                    'order' => $sectionData['order'],
                    'is_visible' => $sectionData['is_visible'] ?? true
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Landing page sections updated successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to update landing page sections: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle section visibility
     */
    public function toggleSectionVisibility(Request $request, $id)
    {
        $request->validate([
            'is_visible' => 'required|boolean'
        ]);

        try {
            $section = LandingPageSection::findOrFail($id);
            $section->update([
                'is_visible' => $request->is_visible
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Section visibility updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update section visibility: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add new collection section to landing page
     */
    public function addCollectionSection(Request $request)
    {
        $request->validate([
            'section_title' => 'required|string|max:255',
            'data_source' => 'required|in:collection,custom_ebooks',
            'card_template' => 'required|in:default,compact,grid,list',
            'collection_id' => 'required_if:data_source,collection|exists:collections,id',
            'filter_type' => 'required_if:data_source,custom_ebooks|in:latest,popular,top_rated,category,city,language',
            'ebook_limit' => 'nullable|integer|min:1|max:50',
            'category_id' => 'required_if:filter_type,category|exists:categories,id',
            'city_id' => 'required_if:filter_type,city|exists:cities,id',
            'language' => 'required_if:filter_type,language|in:id,en'
        ]);

        try {
            DB::beginTransaction();

            // Get max order number
            $maxOrder = LandingPageSection::max('order') ?? 0;

            $sectionData = [
                'section_name' => $request->section_title,
                'section_title' => $request->section_title,
                'section_type' => 'collection', // Always collection type for now
                'card_template' => $request->card_template,
                'order' => $maxOrder + 1,
                'is_visible' => true
            ];

            // Handle data source
            if ($request->data_source === 'collection') {
                $collection = Collection::findOrFail($request->collection_id);

                // Check if collection already exists
                $existingSection = LandingPageSection::where('section_type', 'collection')
                    ->where('reference_id', $collection->id)
                    ->whereNull('filter_config')
                    ->first();

                if ($existingSection) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'Collection "' . $collection->name . '" already exists in landing page'
                    ], 400);
                }

                $sectionData['reference_id'] = $collection->id;
            } else if ($request->data_source === 'custom_ebooks') {
                // Build filter config
                $filterConfig = [
                    'source' => 'custom',
                    'filter_type' => $request->filter_type,
                    'limit' => $request->ebook_limit ?? 10
                ];

                // Add conditional filters
                if ($request->filter_type === 'category' && $request->category_id) {
                    $filterConfig['category_id'] = $request->category_id;
                } else if ($request->filter_type === 'city' && $request->city_id) {
                    $filterConfig['city_id'] = $request->city_id;
                } else if ($request->filter_type === 'language' && $request->language) {
                    $filterConfig['language'] = $request->language;
                }

                $sectionData['filter_config'] = $filterConfig;
            }

            // Create new section
            LandingPageSection::create($sectionData);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Section added successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to add section: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete collection section from landing page
     */
    public function deleteCollectionSection($id)
    {
        try {
            $section = LandingPageSection::findOrFail($id);

            // Only allow deletion of collection type sections
            if ($section->section_type !== 'collection') {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete fixed sections (hero, cities, subscriptions, blogs)'
                ], 400);
            }

            $section->delete();

            return response()->json([
                'success' => true,
                'message' => 'Collection section deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete section: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Preview single landing page section
     */
    public function previewSection($id)
    {
        try {
            $section = LandingPageSection::with('collection.ebooks.creator', 'collection.ebooks.ratings')
                ->findOrFail($id);

            // Process section like in HomeController
            if ($section->filter_config && $section->filter_config['source'] === 'custom') {
                $section->custom_ebooks = $this->getEbooksByFilter($section->filter_config);
            }

            // Always return content view for modal
            return view('admin.website-management.preview-section-content', compact('section'));
        } catch (\Exception $e) {
            Log::error('Preview section error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get ebooks by filter configuration (same as HomeController)
     */
    private function getEbooksByFilter(array $filterConfig)
    {
        $query = Ebook::with(['creator', 'ratings'])
            ->where('status', 'published');

        $filterType = $filterConfig['filter_type'] ?? 'latest';
        $limit = $filterConfig['limit'] ?? 10;

        switch ($filterType) {
            case 'latest':
                $query->orderBy('created_at', 'desc');
                break;

            case 'popular':
                $query->withCount('orders')
                    ->orderBy('orders_count', 'desc');
                break;

            case 'top_rated':
                $query->withAvg('ratings', 'rating')
                    ->orderBy('ratings_avg_rating', 'desc');
                break;

            case 'category':
                if (isset($filterConfig['category_id'])) {
                    $query->whereHas('categories', function ($q) use ($filterConfig) {
                        $q->where('category_id', $filterConfig['category_id']);
                    });
                }
                $query->orderBy('created_at', 'desc');
                break;

            case 'city':
                if (isset($filterConfig['city_id'])) {
                    $query->where('city_id', $filterConfig['city_id']);
                }
                $query->orderBy('created_at', 'desc');
                break;

            case 'language':
                if (isset($filterConfig['language'])) {
                    $query->where('language', $filterConfig['language']);
                }
                $query->orderBy('created_at', 'desc');
                break;

            default:
                $query->orderBy('created_at', 'desc');
        }

        return $query->limit($limit)->get();
    }

    public function createSection()
    {
        $collections = Collection::where('is_active', true)->orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $cities = City::orderBy('name')->get();

        $sectionTypes = [
            'hero' => 'Hero Section',
            'about' => 'About Section',
            'features' => 'Features Section',
            'services' => 'Services Section',
            'testimonial' => 'Testimonial Section',
            'cta' => 'Call to Action',
            'faq' => 'FAQ Section',
            'gallery' => 'Gallery Section',
            'contact' => 'Contact Section',
            'collection' => 'Collection Section',
            'hero_banner' => 'Hero Banner',
            'top_cities' => 'Top Cities',
            'subscription_plans' => 'Subscription Plans',
            'latest_blogs' => 'Latest Blogs',
        ];

        return view('admin.website-management.create-section', compact('collections', 'categories', 'cities', 'sectionTypes'));
    }

    public function storeSection(Request $request)
    {
        $rules = [
            'section_type' => 'required|string',
            'section_name' => 'required|string|max:255',
            'section_title' => 'nullable|string|max:255',
        ];

        $validated = $request->validate($rules);

        try {
            $sectionType = $request->section_type;
            $sectionData = [];

            // Handle file uploads and build section_data based on type
            switch ($sectionType) {
                case 'hero':
                    if ($request->hasFile('image')) {
                        $imagePath = $request->file('image')->store('sections/hero', 'public');
                        $sectionData['image'] = $imagePath;
                    }
                    $sectionData['title'] = $request->input('title');
                    $sectionData['subtitle'] = $request->input('subtitle');
                    $sectionData['button_text'] = $request->input('button_text');
                    $sectionData['button_link'] = $request->input('button_link');
                    break;

                case 'about':
                    if ($request->hasFile('image')) {
                        $imagePath = $request->file('image')->store('sections/about', 'public');
                        $sectionData['image'] = $imagePath;
                    }
                    $sectionData['heading'] = $request->input('heading');
                    $sectionData['description'] = $request->input('description');
                    break;

                case 'features':
                case 'services':
                    $items = [];
                    foreach ($request->input('items', []) as $item) {
                        $items[] = [
                            'icon' => $item['icon'] ?? '',
                            'title' => $item['title'] ?? '',
                            'description' => $item['description'] ?? '',
                        ];
                    }
                    $sectionData['items'] = $items;
                    break;

                case 'testimonial':
                    $items = [];
                    foreach ($request->input('items', []) as $index => $item) {
                        $photoPath = null;
                        if ($request->hasFile("items.$index.photo")) {
                            $photoPath = $request->file("items.$index.photo")->store('sections/testimonials', 'public');
                        }
                        $items[] = [
                            'name' => $item['name'] ?? '',
                            'message' => $item['message'] ?? '',
                            'photo' => $photoPath ?? ($item['photo'] ?? ''),
                            'position' => $item['position'] ?? '',
                        ];
                    }
                    $sectionData['items'] = $items;
                    break;

                case 'cta':
                    $sectionData['text'] = $request->input('text');
                    $sectionData['button_text'] = $request->input('button_text');
                    $sectionData['button_link'] = $request->input('button_link');
                    break;

                case 'faq':
                    $items = [];
                    foreach ($request->input('items', []) as $item) {
                        $items[] = [
                            'question' => $item['question'] ?? '',
                            'answer' => $item['answer'] ?? '',
                        ];
                    }
                    $sectionData['items'] = $items;
                    break;

                case 'gallery':
                    $images = [];
                    if ($request->hasFile('images')) {
                        foreach ($request->file('images') as $image) {
                            $imagePath = $image->store('sections/gallery', 'public');
                            $images[] = $imagePath;
                        }
                    }
                    $sectionData['images'] = $images;
                    break;

                case 'contact':
                    $sectionData['address'] = $request->input('address');
                    $sectionData['email'] = $request->input('email');
                    $sectionData['phone'] = $request->input('phone');
                    $sectionData['map_embed'] = $request->input('map_embed');
                    break;

                case 'collection':
                    // For collection type, use existing filter_config structure
                    $validated['collection_id'] = $request->input('collection_id');
                    $validated['filter_config'] = [
                        'filter_type' => $request->input('filter_type'),
                        'category_id' => $request->input('category_id'),
                        'city_id' => $request->input('city_id'),
                        'language' => $request->input('language'),
                    ];
                    $validated['card_template'] = $request->input('card_template', 'default');
                    break;
            }

            if (!empty($sectionData)) {
                $validated['section_data'] = $sectionData;
            }

            // Get the highest order and increment
            $maxOrder = LandingPageSection::max('order') ?? 0;
            $validated['order'] = $maxOrder + 1;
            $validated['is_visible'] = $request->has('is_visible') ? true : false;

            LandingPageSection::create($validated);

            return redirect()->route('admin.landing-sections')
                ->with('success', 'Section created successfully!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Failed to create section: ' . $e->getMessage());
        }
    }
}
