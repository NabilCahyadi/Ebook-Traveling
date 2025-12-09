<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\LandingPageSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebsiteManagementController extends Controller
{
    /**
     * Display collection order management page
     */
    public function collectionOrder()
    {
        $collections = Collection::orderBy('order', 'asc')->get();

        return view('admin.website-management.collection-order', compact('collections'));
    }

    /**
     * Update collection order
     */
    public function updateCollectionOrder(Request $request)
    {
        $request->validate([
            'collections' => 'required|array',
            'collections.*.id' => 'required|exists:collections,id',
            'collections.*.order' => 'required|integer',
            'collections.*.is_visible_on_landing' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->collections as $collectionData) {
                Collection::where('id', $collectionData['id'])->update([
                    'order' => $collectionData['order'],
                    'is_visible_on_landing' => $collectionData['is_visible_on_landing'] ?? true
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Collection order updated successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to update collection order: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle collection visibility on landing page
     */
    public function toggleCollectionVisibility(Request $request, $id)
    {
        $request->validate([
            'is_visible_on_landing' => 'required|boolean'
        ]);

        try {
            $collection = Collection::findOrFail($id);
            $collection->update([
                'is_visible_on_landing' => $request->is_visible_on_landing
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Collection visibility updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update collection visibility: ' . $e->getMessage()
            ], 500);
        }
    }

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
}
