<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\LandingPageSection;
use App\Models\Ebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $section = LandingPageSection::with('collection.ebooks.creator', 'collection.ebooks.ratings')
            ->findOrFail($id);

        // Process section like in HomeController
        if ($section->filter_config && $section->filter_config['source'] === 'custom') {
            $section->custom_ebooks = $this->getEbooksByFilter($section->filter_config);
        }

        return view('admin.website-management.preview-section', compact('section'));
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
}
