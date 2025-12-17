<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CollectionService;
use App\Models\Category;
use App\Models\Ebook;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CollectionController extends Controller
{
    protected $collectionService;

    public function __construct(CollectionService $collectionService)
    {
        $this->collectionService = $collectionService;
    }

    /**
     * Display a listing of collections
     */
    public function index()
    {
        $collections = $this->collectionService->getAllCollections(15);
        
        return view('admin.collections.index', compact('collections'));
    }

    /**
     * Show the form for creating a new collection
     */
    public function create()
    {
        return view('admin.collections.create');
    }

    /**
     * Store a newly created collection
     */
    public function store(Request $request)
    {
        // Check if order already exists
        if ($request->filled('order')) {
            $existingOrder = \App\Models\Collection::where('order', $request->order)->first();
            if ($existingOrder) {
                $suggestions = $this->getSuggestedOrders($request->order);
                $message = "Display order {$request->order} is already taken by '{$existingOrder->name}'. ";
                
                $suggestionParts = [];
                if ($suggestions['lower'] !== null) {
                    $suggestionParts[] = "{$suggestions['lower']} (lower)";
                }
                if ($suggestions['higher'] !== null) {
                    $suggestionParts[] = "{$suggestions['higher']} (higher)";
                }
                
                if (!empty($suggestionParts)) {
                    $message .= "Suggested: " . implode(' or ', $suggestionParts) . ".";
                }
                
                return back()
                    ->withInput()
                    ->withErrors(['order' => $message]);
            }
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:collections,slug',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
            'selected_ebooks' => 'nullable|json',
        ]);

        // Generate slug jika kosong
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Set default values
        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $validated['order'] ?? 0;

        try {
            $collection = $this->collectionService->createCollection($validated);
            
            $ebookIds = [];

            // Attach selected ebooks if any
            if ($request->filled('selected_ebooks')) {
                \Log::info('Selected ebooks raw:', ['data' => $request->selected_ebooks]);
                
                $ebookIds = json_decode($request->selected_ebooks, true);
                
                \Log::info('Selected ebooks decoded:', ['ids' => $ebookIds, 'count' => count($ebookIds ?? [])]);
                
                if (is_array($ebookIds) && !empty($ebookIds)) {
                    \Log::info('Syncing ebooks to collection:', ['collection_id' => $collection->id, 'ebook_ids' => $ebookIds]);
                    
                    $this->collectionService->syncEbooksInCollection($collection->id, $ebookIds);
                    
                    \Log::info('Ebooks synced successfully');
                } else {
                    \Log::warning('Ebook IDs not valid array or empty');
                }
            } else {
                \Log::info('No selected_ebooks in request');
            }

            return redirect()
                ->route('admin.collections.index')
                ->with('success', 'Collection created successfully with ' . count($ebookIds) . ' ebooks');
        } catch (\Exception $e) {
            \Log::error('Collection creation error:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            
            return back()
                ->withInput()
                ->with('error', 'Failed to create collection: ' . $e->getMessage());
        }
    }

    /**
     * Get ebooks for selection (AJAX endpoint for create page)
     */
    public function getEbooksForSelection(Request $request)
    {
        $query = Ebook::with(['creator.user', 'categories'])
            ->where('status', 'published');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category_id')) {
            $query->whereHas('categories', function($q) use ($request) {
                $q->where('categories.id', $request->category_id);
            });
        }

        // Sorting
        $sort = $request->input('sort', 'created_at_desc');
        switch ($sort) {
            case 'created_at_asc':
                $query->orderBy('created_at', 'asc');
                break;
            case 'created_at_desc':
                $query->orderBy('created_at', 'desc');
                break;
            case 'view_count_asc':
                $query->orderBy('view_count', 'asc');
                break;
            case 'view_count_desc':
                $query->orderBy('view_count', 'desc');
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $perPage = $request->input('per_page', 20);
        $ebooks = $query->paginate($perPage);

        return response()->json($ebooks);
    }

    /**
     * Display the specified collection
     */
    public function show(string $id)
    {
        $collection = $this->collectionService->getCollectionById($id);
        
        if (!$collection) {
            return redirect()
                ->route('admin.collections.index')
                ->with('error', 'Collection not found');
        }

        return view('admin.collections.show', compact('collection'));
    }

    /**
     * Show the form for editing the specified collection
     */
    public function edit(string $id)
    {
        $collection = $this->collectionService->getCollectionById($id);
        
        if (!$collection) {
            return redirect()
                ->route('admin.collections.index')
                ->with('error', 'Collection not found');
        }

        return view('admin.collections.edit', compact('collection'));
    }

    /**
     * Update the specified collection
     */
    public function update(Request $request, string $id)
    {
        // Check if order already exists (excluding current collection)
        if ($request->filled('order')) {
            $existingOrder = \App\Models\Collection::where('order', $request->order)
                ->where('id', '!=', $id)
                ->first();
            if ($existingOrder) {
                $suggestions = $this->getSuggestedOrders($request->order, $id);
                $message = "Display order {$request->order} is already taken by '{$existingOrder->name}'. ";
                
                $suggestionParts = [];
                if ($suggestions['lower'] !== null) {
                    $suggestionParts[] = "{$suggestions['lower']} (lower)";
                }
                if ($suggestions['higher'] !== null) {
                    $suggestionParts[] = "{$suggestions['higher']} (higher)";
                }
                
                if (!empty($suggestionParts)) {
                    $message .= "Suggested: " . implode(' or ', $suggestionParts) . ".";
                }
                
                return back()
                    ->withInput()
                    ->withErrors(['order' => $message]);
            }
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:collections,slug,' . $id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        // Update slug jika kosong
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Set boolean values
        $validated['is_active'] = $request->has('is_active');

        try {
            $this->collectionService->updateCollection($id, $validated);

            return redirect()
                ->route('admin.collections.index')
                ->with('success', 'Collection updated successfully');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to update collection: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified collection
     */
    public function destroy(string $id)
    {
        try {
            $this->collectionService->deleteCollection($id);

            return redirect()
                ->route('admin.collections.index')
                ->with('success', 'Collection deleted successfully');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to delete collection: ' . $e->getMessage());
        }
    }

    /**
     * Show manage ebooks page for collection
     */
    public function manageEbooks(string $id)
    {
        $collection = $this->collectionService->getCollectionById($id);
        
        if (!$collection) {
            return redirect()
                ->route('admin.collections.index')
                ->with('error', 'Collection not found');
        }

        // Get filter parameters
        $categories = Category::all();
        
        return view('admin.collections.manage-ebooks', compact('collection', 'categories'));
    }

    /**
     * Get available ebooks for selection (AJAX)
     */
    public function getAvailableEbooks(Request $request)
    {
        $query = Ebook::select('ebooks.*')
            ->with(['categories', 'creator'])
            ->where('status', 'published');

        // Filter by search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->whereHas('categories', function($q) use ($request) {
                $q->where('categories.id', $request->category_id);
            });
        }

        // Sort by
        if ($request->filled('sort')) {
            $sort = $request->sort;
            switch ($sort) {
                case 'created_at_desc':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'created_at_asc':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'view_count_desc':
                    $query->orderBy('view_count', 'desc');
                    break;
                case 'view_count_asc':
                    $query->orderBy('view_count', 'asc');
                    break;
                case 'title_asc':
                    $query->orderBy('title', 'asc');
                    break;
                case 'title_desc':
                    $query->orderBy('title', 'desc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Exclude already added ebooks
        if ($request->filled('collection_id')) {
            $collection = $this->collectionService->getCollectionById($request->collection_id);
            if ($collection) {
                $existingIds = $collection->ebooks->pluck('id')->toArray();
                if (!empty($existingIds)) {
                    $query->whereNotIn('id', $existingIds);
                }
            }
        }

        $ebooks = $query->paginate(12);

        return response()->json($ebooks);
    }

    /**
     * Add ebooks to collection
     */
    public function addEbooks(Request $request, string $id)
    {
        $request->validate([
            'ebook_ids' => 'required|array',
            'ebook_ids.*' => 'exists:ebooks,id'
        ]);

        try {
            $this->collectionService->attachEbooksToCollection($id, $request->ebook_ids);

            return response()->json([
                'success' => true,
                'message' => 'Ebooks added to collection successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add ebooks: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove ebook from collection
     */
    public function removeEbook(Request $request, string $collectionId, string $ebookId)
    {
        try {
            $this->collectionService->detachEbooksFromCollection($collectionId, [$ebookId]);

            return response()->json([
                'success' => true,
                'message' => 'Ebook removed from collection successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove ebook: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update collections order via drag & drop
     */
    public function updateCollectionsOrder(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*' => 'integer'
        ]);

        try {
            foreach ($request->orders as $id => $order) {
                \App\Models\Collection::where('id', $id)->update(['order' => $order]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Collections order updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update order: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update ebook order in collection
     */
    public function updateEbookOrder(Request $request, string $id)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*' => 'integer'
        ]);

        try {
            $this->collectionService->updateEbookOrderInCollection($id, $request->orders);

            return response()->json([
                'success' => true,
                'message' => 'Ebook order updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update order: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check order availability (AJAX endpoint)
     */
    public function checkOrderAvailability(Request $request)
    {
        $order = $request->input('order');
        $excludeId = $request->input('exclude_id');
        
        $query = \App\Models\Collection::where('order', $order);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        $existingCollection = $query->first();
        
        if ($existingCollection) {
            $suggestions = $this->getSuggestedOrders($order, $excludeId);
            return response()->json([
                'available' => false,
                'collection_name' => $existingCollection->name,
                'suggestions' => $suggestions
            ]);
        }
        
        return response()->json(['available' => true]);
    }

    /**
     * Get suggested available orders (lower and higher)
     */
    private function getSuggestedOrders(int $inputOrder, ?string $excludeId = null): array
    {
        $query = \App\Models\Collection::orderBy('order', 'asc');
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        $usedOrders = $query->pluck('order')->toArray();
        
        // Find lower available order (closest to input)
        $lowerOrder = null;
        for ($i = $inputOrder - 1; $i >= 0; $i--) {
            if (!in_array($i, $usedOrders)) {
                $lowerOrder = $i;
                break;
            }
        }
        
        // If no lower order found from 0 to input, find the smallest available
        if ($lowerOrder === null) {
            for ($i = 0; $i < $inputOrder; $i++) {
                if (!in_array($i, $usedOrders)) {
                    $lowerOrder = $i;
                    break;
                }
            }
        }
        
        // Find higher available order (closest to input)
        $higherOrder = null;
        for ($i = $inputOrder + 1; $i <= max($usedOrders) + 10; $i++) {
            if (!in_array($i, $usedOrders)) {
                $higherOrder = $i;
                break;
            }
        }
        
        return [
            'lower' => $lowerOrder,
            'higher' => $higherOrder ?? ($inputOrder + 1)
        ];
    }
}
