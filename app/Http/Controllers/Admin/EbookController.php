<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\EbookService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EbookController extends Controller
{
    protected $ebookService;

    public function __construct(EbookService $ebookService)
    {
        $this->ebookService = $ebookService;
    }

    /**
     * Display a listing of all ebooks.
     */
    public function index(Request $request)
    {
        // Default 8 for card view
        $perPage = $request->get('per_page', 8);
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        $ebooks = $this->ebookService->getAllEbooks($perPage, $sortBy, $sortOrder);
        return view('admin.ebooks.index', compact('ebooks'));
    }

    /**
     * Show the form for creating a new ebook.
     */
    public function create()
    {
        $categories = \App\Models\Category::all();
        $cities = \App\Models\City::all();
        $creators = \App\Models\User::where('user_type', 'creator')->get();
        return view('admin.ebooks.create', compact('categories', 'cities', 'creators'));
    }

    /**
     * Store a newly created ebook.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'category_ids' => 'required|array|min:1',
                'category_ids.*' => 'exists:categories,id',
                'city_id' => 'required|exists:cities,id',
                'creator_id' => 'required|exists:users,id',
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'cover_image_cropped' => 'nullable|string', // base64 dari auto crop
                'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
                'status' => 'required|in:draft,published,unpublished,archived',
            ]);

            // Check if user is admin
            $user = Auth::user();
            $isAdmin = $user->roles()->where('name', 'admin')->exists();

            // If user is not admin and tries to publish, change to waiting_approval
            if (!$isAdmin && $validated['status'] === 'published') {
                $validated['status'] = 'waiting_approval';
            }

            // Set creator_id
            $validated['creator_id'] = $user->id;

            // Extract category_ids for pivot table attachment
            $categoryIds = $validated['category_ids'];
            unset($validated['category_ids']);

            // Handle base64 cover image (dari hidden input hasil auto crop)
            if ($request->has('cover_image_cropped') && !empty($request->cover_image_cropped)) {
                $validated['cover_image'] = $this->saveBase64Image($request->cover_image_cropped);
                unset($validated['cover_image_cropped']); // Remove temporary field
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Ebook Validation Error:', [
                'errors' => $e->errors(),
                'input' => $request->except(['cover_image', 'pdf_file'])
            ]);
            return back()->withErrors($e->errors())->withInput();
        }

        try {
            Log::info('Creating ebook with data:', $validated);
            $ebook = $this->ebookService->createEbook($validated);
            
            // Attach categories to ebook (many-to-many)
            $ebook->categories()->attach($categoryIds);
            
            Log::info('Ebook created successfully:', ['id' => $ebook->id]);

            $message = 'Ebook created successfully!';
            if (!$isAdmin && $validated['status'] === 'waiting_approval') {
                $message = 'Ebook submitted for approval. Admin will review it soon.';
            }

            return redirect()->route('admin.ebooks.index')->with('success', $message);
        } catch (\Exception $e) {
            Log::error('Ebook Creation Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Failed to create ebook: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Save base64 image to storage
     */
    private function saveBase64Image($base64String)
    {
        // Extract image data from base64 string
        if (preg_match('/^data:image\/(\w+);base64,/', $base64String, $type)) {
            $base64String = substr($base64String, strpos($base64String, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif

            $base64String = str_replace(' ', '+', $base64String);
            $imageData = base64_decode($base64String);

            if ($imageData === false) {
                throw new \Exception('Base64 decode failed');
            }

            // Generate unique filename
            $filename = 'ebook_cover_' . time() . '_' . uniqid() . '.' . $type;
            $path = 'ebook_covers/' . $filename;

            // Save to storage
            Storage::disk('public')->put($path, $imageData);

            return $path;
        }

        throw new \Exception('Invalid base64 image format');
    }

    /**
     * Display the specified ebook.
     */
    public function show($id)
    {
        $ebook = $this->ebookService->getEbookById($id);
        return view('admin.ebooks.show', compact('ebook'));
    }

    /**
     * Show the form for editing the specified ebook.
     */
    public function edit($id)
    {
        $ebook = $this->ebookService->getEbookById($id);
        $categories = \App\Models\Category::all();
        $cities = \App\Models\City::all();
        $creators = \App\Models\User::where('user_type', 'creator')->get();
        return view('admin.ebooks.edit', compact('ebook', 'categories', 'cities', 'creators'));
    }

    /**
     * Update the specified ebook.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'category_ids' => 'required|array|min:1',
            'category_ids.*' => 'exists:categories,id',
            'city_id' => 'nullable|exists:cities,id',
            'creator_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'cover_image_cropped' => 'nullable|string', // base64 dari auto crop
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
            'status' => 'required|in:draft,published,unpublished,archived',
        ]);

        try {
            // Extract category_ids for pivot table sync
            $categoryIds = $validated['category_ids'];
            unset($validated['category_ids']);

            // Handle base64 cover image (dari hidden input hasil auto crop)
            if ($request->has('cover_image_cropped') && !empty($request->cover_image_cropped)) {
                $validated['cover_image'] = $this->saveBase64Image($request->cover_image_cropped);
                unset($validated['cover_image_cropped']); // Remove temporary field
            }

            $this->ebookService->updateEbook($id, $validated);
            
            // Sync categories (replaces old with new)
            $ebook = $this->ebookService->getEbookById($id);
            $ebook->categories()->sync($categoryIds);
            
            return redirect()->route('admin.ebooks.index')->with('success', 'Ebook updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update ebook: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified ebook (soft delete).
     */
    public function destroy($id)
    {
        try {
            $this->ebookService->deleteEbook($id);
            return redirect()->route('admin.ebooks.index')->with('success', 'Ebook moved to trash successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete ebook: ' . $e->getMessage());
        }
    }

    /**
     * Display trashed ebooks.
     */
    public function trashed()
    {
        try {
            $ebooks = $this->ebookService->getTrashedEbooks(15);
            return view('admin.ebooks.trashed', compact('ebooks'));
        } catch (\Exception $e) {
            return redirect()->route('admin.ebooks.index')
                ->with('error', 'Failed to load trashed ebooks: ' . $e->getMessage());
        }
    }

    /**
     * Restore a soft deleted ebook.
     */
    public function restore(string $id)
    {
        try {
            $this->ebookService->restoreEbook($id);
            return redirect()->route('admin.ebooks.trashed')
                ->with('success', 'Ebook restored successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to restore ebook: ' . $e->getMessage());
        }
    }

    /**
     * Permanently delete an ebook.
     */
    public function forceDelete(string $id)
    {
        try {
            $this->ebookService->forceDeleteEbook($id);
            return redirect()->route('admin.ebooks.trashed')
                ->with('success', 'Ebook permanently deleted!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to permanently delete ebook: ' . $e->getMessage());
        }
    }

    /**
     * Display ebooks pending approval.
     */
    public function pendingApproval()
    {
        $ebooks = \App\Models\Ebook::with(['category', 'city'])
            ->where('status', 'waiting_approval')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.ebooks.pending-approval', compact('ebooks'));
    }

    /**
     * Approve an ebook.
     */
    public function approve($id)
    {
        try {
            $ebook = \App\Models\Ebook::findOrFail($id);
            $ebook->update([
                'status' => 'published',
                'published_at' => now(),
            ]);

            return redirect()->route('admin.ebooks.pending-approval')
                ->with('success', 'Ebook approved and published successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to approve ebook: ' . $e->getMessage());
        }
    }

    /**
     * Reject an ebook.
     */
    public function reject($id)
    {
        try {
            $ebook = \App\Models\Ebook::findOrFail($id);
            $ebook->update(['status' => 'rejected']);

            return redirect()->route('admin.ebooks.pending-approval')
                ->with('success', 'Ebook rejected successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to reject ebook: ' . $e->getMessage());
        }
    }
}
