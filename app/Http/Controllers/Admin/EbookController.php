<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\EbookService;
use App\Exports\EbooksExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Smalot\PdfParser\Parser as PdfParser;
use Maatwebsite\Excel\Facades\Excel;

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
        // Default 10 items per page, user can select 10, 20, 30, 40, 50, 100
        $perPage = $request->get('per_page', 10);
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $search = $request->get('search');
        $status = $request->get('status');
        $categoryId = $request->get('category_id');
        $cityId = $request->get('city_id');

        $ebooks = $this->ebookService->getAllEbooks($perPage, $sortBy, $sortOrder, $search, $status, $categoryId, $cityId);
        $categories = \App\Models\Category::orderBy('name')->get();
        $cities = \App\Models\City::orderBy('name')->get();
        
        return view('admin.ebooks.index', compact('ebooks', 'categories', 'cities'));
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
                'city_id' => 'nullable|exists:cities,id',
                'creator_id' => 'required|exists:users,id',
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'cover_image_cropped' => 'nullable|string', // base64 dari auto crop
                'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
                'status' => 'required|in:draft,published,scheduled,unpublished',
                'published_at' => 'nullable|date|after:now',
            ], [
                'category_ids.required' => 'Kategori ebook wajib dipilih minimal 1.',
                'category_ids.array' => 'Format kategori tidak valid.',
                'category_ids.min' => 'Pilih minimal 1 kategori untuk ebook.',
                'category_ids.*.exists' => 'Kategori yang dipilih tidak valid.',
                'city_id.exists' => 'Kota/destinasi yang dipilih tidak valid.',
                'creator_id.required' => 'Pembuat ebook wajib dipilih.',
                'creator_id.exists' => 'Pembuat ebook tidak ditemukan.',
                'title.required' => 'Judul ebook wajib diisi.',
                'title.max' => 'Judul ebook maksimal 255 karakter.',
                'description.required' => 'Deskripsi ebook wajib diisi.',
                'pdf_file.file' => 'File PDF tidak valid.',
                'pdf_file.mimes' => 'File harus berformat PDF.',
                'pdf_file.max' => 'Ukuran file PDF maksimal 10MB.',
                'status.required' => 'Status publikasi wajib dipilih.',
                'status.in' => 'Status publikasi tidak valid.',
                'published_at.after' => 'Tanggal publish harus di masa depan.',
            ]);

            // Require published_at for scheduled status
            if ($validated['status'] === 'scheduled' && empty($validated['published_at'])) {
                return back()->withErrors(['published_at' => 'Tanggal publish wajib diisi untuk status Scheduled.'])->withInput();
            }

            // Check if user is admin (using admin guard)
            $admin = Auth::guard('admin')->user();
            $isAdmin = $admin ? true : false;

            // Get current authenticated user (try both guards)
            $user = Auth::guard('admin')->user() ?? Auth::user();
            
            // If user is not admin and tries to publish, change to waiting_approval
            if (!$isAdmin && $validated['status'] === 'published') {
                $validated['status'] = 'waiting_approval';
            }

            // Set creator_id - if not admin, force use logged in user
            // If admin, use the selected creator from form
            if (!$isAdmin && $user) {
                $validated['creator_id'] = $user->id;
            }
            // Admin harus sudah input creator_id di form (sudah divalidasi required)

            // Extract category_ids for pivot table attachment
            $categoryIds = $validated['category_ids'];
            unset($validated['category_ids']);

            // Handle base64 cover image (dari hidden input hasil auto crop)
            if ($request->has('cover_image_cropped') && !empty($request->cover_image_cropped)) {
                $validated['cover_image'] = $this->saveBase64Image($request->cover_image_cropped);
                unset($validated['cover_image_cropped']); // Remove temporary field
            }

            // Handle PDF file upload
            if ($request->hasFile('pdf_file')) {
                $pdfPath = $this->savePdfFile($request->file('pdf_file'));
                $validated['pdf_file'] = $pdfPath;
                
                // Auto detect total pages from PDF
                $totalPages = $this->getPdfPageCount($pdfPath);
                if ($totalPages !== null) {
                    $validated['total_pages'] = $totalPages;
                }
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

            // Attach categories using DB::table to avoid timestamp issues
            $insertData = [];
            foreach ($categoryIds as $categoryId) {
                $insertData[] = [
                    'id' => \Illuminate\Support\Str::uuid()->toString(),
                    'ebook_id' => $ebook->id,
                    'category_id' => $categoryId,
                    'created_at' => now()
                ];
            }
            \DB::table('ebook_categories')->insert($insertData);

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
     * Save base64 image to storage with auto-compression
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

            // Load image dengan Intervention Image
            $manager = new ImageManager(new Driver());
            $image = $manager->read($imageData);
            
            // Get original dimensions
            $originalWidth = $image->width();
            $originalHeight = $image->height();
            
            // Calculate original size
            $originalSize = strlen($imageData);
            
            // ========================================
            // 📸 STEP 1: RESIZE TO OPTIMAL DIMENSIONS
            // ========================================
            // Target width untuk cover ebook (balance antara kualitas & size)
            $targetWidth = 1200;
            
            // Resize hanya jika gambar lebih besar dari target
            if ($originalWidth > $targetWidth) {
                $targetHeight = (int) ($originalHeight * ($targetWidth / $originalWidth));
                $image->scale(width: $targetWidth, height: $targetHeight);
                
                Log::info('Image resized', [
                    'from' => $originalWidth . 'x' . $originalHeight,
                    'to' => $image->width() . 'x' . $image->height()
                ]);
            }
            
            // ========================================
            // 🛠️ STEP 2: SMART COMPRESSION
            // ========================================
            // Quality setting untuk WebP (70-85 = sweet spot)
            $quality = 75; // Default: balance perfect antara size & visual quality
            
            // Adjust quality based on original size
            if ($originalSize > 8 * 1024 * 1024) {
                // > 8MB: Aggressive compression (60-65)
                $quality = 60;
            } elseif ($originalSize > 5 * 1024 * 1024) {
                // 5-8MB: Strong compression (65-70)
                $quality = 65;
            } elseif ($originalSize > 3 * 1024 * 1024) {
                // 3-5MB: Medium compression (70-75)
                $quality = 70;
            } elseif ($originalSize > 1 * 1024 * 1024) {
                // 1-3MB: Light compression (75-80)
                $quality = 75;
            } else {
                // < 1MB: Minimal compression (80-85)
                $quality = 80;
            }

            // Generate unique filename
            $filename = 'ebook_cover_' . time() . '_' . uniqid() . '.webp';
            $path = 'ebook_covers/' . $filename;

            // ========================================
            // 🌐 STEP 3: ENCODE TO WEBP & SAVE
            // ========================================
            // WebP memberikan compression terbaik dengan visual quality tinggi
            $encodedImage = (string) $image->encode(
                new \Intervention\Image\Encoders\WebpEncoder(quality: $quality)
            );

            // Save to storage
            Storage::disk('public')->put($path, $encodedImage);
            
            // Get final file size
            $finalSize = Storage::disk('public')->size($path);
            $compressionRatio = round((1 - ($finalSize / $originalSize)) * 100, 1);
            
            // Log compression result
            Log::info('✅ Cover image optimized', [
                'original_size' => round($originalSize / 1024, 2) . ' KB',
                'final_size' => round($finalSize / 1024, 2) . ' KB',
                'saved' => round(($originalSize - $finalSize) / 1024, 2) . ' KB',
                'compression_ratio' => $compressionRatio . '%',
                'quality' => $quality,
                'dimensions' => $image->width() . 'x' . $image->height(),
                'format' => 'WebP'
            ]);

            return $path;
        }

        throw new \Exception('Invalid base64 image format');
    }

    /**
     * Save uploaded PDF file to storage
     */
    private function savePdfFile($file)
    {
        // Generate unique filename
        $filename = 'ebook_' . time() . '_' . uniqid() . '.pdf';
        $path = 'pdf/' . $filename;

        // Save to storage/app/public/pdf/
        $file->storeAs('pdf', $filename, 'public');

        Log::info('PDF uploaded', [
            'filename' => $filename,
            'size' => round($file->getSize() / 1024 / 1024, 2) . 'MB',
            'path' => $path
        ]);

        return $path;
    }

    /**
     * Get total pages from PDF file
     */
    private function getPdfPageCount($pdfPath)
    {
        try {
            // Get full path to PDF file
            $fullPath = storage_path('app/public/' . $pdfPath);
            
            if (!file_exists($fullPath)) {
                Log::warning('PDF file not found for page count', ['path' => $fullPath]);
                return null;
            }

            // Parse PDF and get page count
            $parser = new PdfParser();
            $pdf = $parser->parseFile($fullPath);
            $pages = count($pdf->getPages());
            
            Log::info('PDF page count detected', [
                'path' => $pdfPath,
                'total_pages' => $pages
            ]);
            
            return $pages;
        } catch (\Exception $e) {
            Log::error('Error reading PDF page count', [
                'path' => $pdfPath,
                'error' => $e->getMessage()
            ]);
            return null;
        }
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
            'status' => 'required|in:draft,published,scheduled,unpublished',
            'published_at' => 'nullable|date',
        ], [
            'category_ids.required' => 'Kategori ebook wajib dipilih minimal 1.',
            'category_ids.array' => 'Format kategori tidak valid.',
            'category_ids.min' => 'Pilih minimal 1 kategori untuk ebook.',
            'category_ids.*.exists' => 'Kategori yang dipilih tidak valid.',
            'city_id.exists' => 'Kota/destinasi yang dipilih tidak valid.',
            'creator_id.required' => 'Pembuat ebook wajib dipilih.',
            'creator_id.exists' => 'Pembuat ebook tidak ditemukan.',
            'title.required' => 'Judul ebook wajib diisi.',
            'title.max' => 'Judul ebook maksimal 255 karakter.',
            'description.required' => 'Deskripsi ebook wajib diisi.',
            'pdf_file.file' => 'File PDF tidak valid.',
            'pdf_file.mimes' => 'File harus berformat PDF.',
            'pdf_file.max' => 'Ukuran file PDF maksimal 10MB.',
            'status.required' => 'Status publikasi wajib dipilih.',
            'status.in' => 'Status publikasi tidak valid.',
        ]);

        // Require published_at for scheduled status
        if ($validated['status'] === 'scheduled' && empty($validated['published_at'])) {
            return back()->withErrors(['published_at' => 'Tanggal publish wajib diisi untuk status Scheduled.'])->withInput();
        }

        try {
            // Extract category_ids for pivot table sync
            $categoryIds = $validated['category_ids'];
            unset($validated['category_ids']);

            // Handle base64 cover image (dari hidden input hasil auto crop)
            if ($request->has('cover_image_cropped') && !empty($request->cover_image_cropped)) {
                $validated['cover_image'] = $this->saveBase64Image($request->cover_image_cropped);
                unset($validated['cover_image_cropped']); // Remove temporary field
            }

            // Handle PDF file upload
            if ($request->hasFile('pdf_file')) {
                // Delete old PDF if exists
                $ebook = $this->ebookService->getEbookById($id);
                if ($ebook->pdf_file && Storage::disk('public')->exists($ebook->pdf_file)) {
                    Storage::disk('public')->delete($ebook->pdf_file);
                }
                $pdfPath = $this->savePdfFile($request->file('pdf_file'));
                $validated['pdf_file'] = $pdfPath;
                
                // Auto detect total pages from PDF
                $totalPages = $this->getPdfPageCount($pdfPath);
                if ($totalPages !== null) {
                    $validated['total_pages'] = $totalPages;
                }
            }

            $this->ebookService->updateEbook($id, $validated);

            // Sync categories using DB::table to avoid timestamp issues
            $ebook = $this->ebookService->getEbookById($id);

            // Delete old categories
            \DB::table('ebook_categories')->where('ebook_id', $ebook->id)->delete();

            // Insert new categories
            $insertData = [];
            foreach ($categoryIds as $categoryId) {
                $insertData[] = [
                    'id' => \Illuminate\Support\Str::uuid()->toString(),
                    'ebook_id' => $ebook->id,
                    'category_id' => $categoryId,
                    'created_at' => now()
                ];
            }
            \DB::table('ebook_categories')->insert($insertData);

            return redirect()->route('admin.ebooks.index')->with('success', 'Ebook updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update ebook: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Search creators by name or email for autocomplete
     */
    public function searchCreators(Request $request)
    {
        $query = $request->get('q', '');
        
        // Build base query
        $creatorsQuery = \App\Models\User::where('user_type', 'creator');
        
        // Add search filter if query is provided
        if (strlen($query) >= 1) {
            $creatorsQuery->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('email', 'LIKE', "%{$query}%");
            });
            $limit = 50; // More results when searching
        } else {
            $limit = 10; // Only 10 for initial load
        }
        
        $creators = $creatorsQuery
            ->select('id', 'name', 'email')
            ->orderBy('name', 'asc')
            ->limit($limit)
            ->get();

        return response()->json($creators);
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
    public function trash(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 10);
            $ebooks = $this->ebookService->getTrashedEbooks($perPage);
            return view('admin.ebooks.trash', compact('ebooks'));
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
            return redirect()->route('admin.ebooks.trash')
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
            return redirect()->route('admin.ebooks.trash')
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

    /**
     * Toggle ebook download setting for all ebooks.
     */
    public function toggleDownload(Request $request)
    {
        try {
            $enable = $request->input('enable', '1');
            
            Log::info('Toggle Download Request', [
                'enable' => $enable,
                'user' => auth()->id()
            ]);
            
            $setting = \App\Models\SystemSetting::updateOrCreate(
                ['key' => 'enable_ebook_download'],
                [
                    'value' => $enable,
                    'description' => 'Enable or disable ebook download globally for all ebooks (1=enabled, 0=disabled)'
                ]
            );
            
            Log::info('Setting Updated', ['setting' => $setting]);

            $message = $enable == '1' 
                ? 'Download ebook berhasil diaktifkan untuk semua buku' 
                : 'Download ebook berhasil dinonaktifkan untuk semua buku';

            return response()->json([
                'success' => true,
                'message' => $message,
                'enabled' => $enable == '1',
                'value' => $enable
            ]);
        } catch (\Exception $e) {
            Log::error('Toggle Download Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah setting: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export ebooks to Excel.
     */
    public function export(Request $request)
    {
        $filters = [
            'search' => $request->get('search'),
            'category_id' => $request->get('category_id'),
            'is_active' => $request->get('is_active'),
            'date_from' => $request->get('date_from'),
            'date_to' => $request->get('date_to'),
        ];

        $filename = 'ebooks_' . now()->format('Y-m-d_His') . '.xlsx';
        
        return Excel::download(new EbooksExport($filters), $filename);
    }

    /**
     * Bulk action for changing status
     */
    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'required|string',
            'action' => 'required|in:draft,published,scheduled,unpublished',
        ]);

        try {
            $updateData = [
                'status' => $validated['action'],
            ];
            
            // Set published_at based on action
            if ($validated['action'] === 'published') {
                $updateData['published_at'] = now();
            }

            $count = \App\Models\Ebook::whereIn('id', $validated['ids'])
                ->update($updateData);

            $statusLabel = ucfirst($validated['action']);
            return redirect()->back()
                ->with('success', "{$count} ebook(s) status changed to {$statusLabel}!");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to perform bulk action: ' . $e->getMessage());
        }
    }

    /**
     * Bulk delete (soft delete)
     */
    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'required|string',
        ]);

        try {
            $count = \App\Models\Ebook::whereIn('id', $validated['ids'])->delete();

            return redirect()->back()
                ->with('success', "{$count} ebook(s) moved to trash!");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete ebooks: ' . $e->getMessage());
        }
    }
}
