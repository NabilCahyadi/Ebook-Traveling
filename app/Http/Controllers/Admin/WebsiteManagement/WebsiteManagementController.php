<?php

namespace App\Http\Controllers\Admin\WebsiteManagement;

use App\Http\Controllers\Controller;
use App\Models\Collection;
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
            'collections.*.order' => 'required|integer'
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->collections as $collectionData) {
                Collection::where('id', $collectionData['id'])->update([
                    'order' => $collectionData['order']
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
     * Toggle collection visibility on landing page (deprecated)
     */
    public function toggleCollectionVisibility(Request $request, $id)
    {
        // Method deprecated - is_visible_on_landing column removed
        return response()->json([
            'success' => true,
            'message' => 'Feature no longer available'
        ]);
    }
}
