<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\EbookService;
use Illuminate\Http\Request;

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
        // Default 6 for table, 8 for card view
        $perPage = $request->get('per_page', 6);
        $ebooks = $this->ebookService->getAllEbooks($perPage);
        return view('admin.ebooks.index', compact('ebooks'));
    }

    /**
     * Show the form for creating a new ebook.
     */
    public function create()
    {
        $categories = \App\Models\Category::all();
        $cities = \App\Models\City::all();
        return view('admin.ebooks.create', compact('categories', 'cities'));
    }

    /**
     * Store a newly created ebook.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'category_id' => 'required|exists:categories,id',
                'city_id' => 'required|exists:cities,id',
                'title' => 'required|string|max:255',
                'author' => 'required|string|max:255',
                'description' => 'required|string',
                'cover_image' => 'nullable|string', // Changed to string for base64
                'file_url' => 'nullable|file|mimes:pdf|max:10240',
                'status' => 'required|in:draft,published,unpublished,archived',
                'page_count' => 'nullable|integer|min:1',
            ]);

            // Check if user is admin
            $user = auth()->user();
            $isAdmin = $user->roles()->where('name', 'admin')->exists();

            // If user is not admin and tries to publish, change to waiting_approval
            if (!$isAdmin && $validated['status'] === 'published') {
                $validated['status'] = 'waiting_approval';
            }

            // Set creator_id
            $validated['creator_id'] = $user->id;

            // Handle base64 cover image
            if ($request->has('cover_image') && !empty($request->cover_image)) {
                $validated['cover_image'] = $this->saveBase64Image($request->cover_image);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Ebook Validation Error:', [
                'errors' => $e->errors(),
                'input' => $request->except(['cover_image', 'file_url', 'pdf_file'])
            ]);
            return back()->withErrors($e->errors())->withInput();
        }

        try {
            \Log::info('Creating ebook with data:', $validated);
            $ebook = $this->ebookService->createEbook($validated);
            \Log::info('Ebook created successfully:', ['id' => $ebook->id]);

            $message = 'Ebook created successfully!';
            if (!$isAdmin && $validated['status'] === 'waiting_approval') {
                $message = 'Ebook submitted for approval. Admin will review it soon.';
            }

            return redirect()->route('admin.ebooks.index')->with('success', $message);
        } catch (\Exception $e) {
            \Log::error('Ebook Creation Error:', [
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
            \Storage::disk('public')->put($path, $imageData);

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
        return view('admin.ebooks.edit', compact('ebook'));
    }

    /**
     * Update the specified ebook.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'city_id' => 'required|exists:cities,id',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'required|string',
            'cover_image' => 'nullable|image|max:2048',
            'file_url' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        try {
            $this->ebookService->updateEbook($id, $validated);
            return redirect()->route('admin.ebooks.index')->with('success', 'Ebook updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update ebook: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified ebook.
     */
    public function destroy($id)
    {
        try {
            $this->ebookService->deleteEbook($id);
            return redirect()->route('admin.ebooks.index')->with('success', 'Ebook deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete ebook: ' . $e->getMessage());
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
