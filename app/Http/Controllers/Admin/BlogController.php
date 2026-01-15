<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\BlogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;

class BlogController extends Controller
{
    protected $blogService;

    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->get('status');
        $category = $request->get('category');
        $search = $request->get('search');

        // Always exclude archived blogs from main listing
        $blogs = $this->blogService->getFilteredBlogs([
            'status' => $status,
            'category' => $category,
            'search' => $search,
            'exclude_archived' => true, // This ensures archived blogs never appear here
        ], 10);

        $categories = $this->blogService->getAllCategories();

        return view('admin.blogs.index', compact('blogs', 'status', 'category', 'search', 'categories'));
    }

    /**
     * Display archived blogs
     */
    public function archived(Request $request)
    {
        $search = $request->get('search');

        $blogs = $this->blogService->getArchivedBlogs($search, 15);

        return view('admin.blogs.archived', compact('blogs', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get blog categories from database
        $categories = Category::where('type', 'blog')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
        
        // Get all published ebooks with relationships
        $ebooks = \App\Models\Ebook::where('status', 'published')
            ->with(['city', 'categories', 'creator'])
            ->orderBy('title')
            ->get();
        
        // Get cities for filter
        $cities = \App\Models\City::where('is_active', true)
            ->orderBy('name')
            ->get();
        
        // Get ebook categories for filter (type = 'ebook')
        $ebookCategories = Category::where('type', 'ebook')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
            
        return view('admin.blogs.create', compact('categories', 'ebooks', 'cities', 'ebookCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'author_id' => 'required|exists:users,id',
            'status' => 'required|in:draft,published,unpublished,archived',
            'related_ebooks' => 'nullable|array',
            'related_ebooks.*' => 'exists:ebooks,id',
            'meta_title' => 'nullable|string|max:500',
            'meta_description' => 'nullable|string|max:1000',
            'meta_keywords' => 'nullable|string|max:500',
        ], [
            'title.required' => 'Judul blog wajib diisi.',
            'title.max' => 'Judul blog maksimal 255 karakter.',
            'content.required' => 'Konten blog wajib diisi.',
            'featured_image.image' => 'File harus berupa gambar.',
            'featured_image.mimes' => 'Format gambar harus JPEG, JPG, PNG, atau WebP.',
            'featured_image.max' => 'Ukuran gambar maksimal 2MB.',
            'categories.array' => 'Kategori harus berupa array.',
            'categories.*.exists' => 'Kategori yang dipilih tidak valid.',
            'author_id.required' => 'Author (Creator) wajib dipilih.',
            'author_id.exists' => 'Author (Creator) yang dipilih tidak valid.',
            'status.required' => 'Status publikasi wajib dipilih.',
            'status.in' => 'Status publikasi tidak valid.',
        ]);

        // Set published_at if status is published
        if ($validated['status'] === 'published' && !isset($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        try {
            $blog = $this->blogService->createBlog($validated);
            
            // Sync categories if provided
            if ($request->has('categories')) {
                $blog->categories()->sync($request->categories);
            }
            
            // Sync related ebooks if provided
            if ($request->has('related_ebooks')) {
                $blog->ebooks()->sync($request->related_ebooks);
            }
            
            return redirect()->route('admin.blogs.index')
                ->with('success', 'Blog created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create blog: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $blog = $this->blogService->getBlogById($id);
        return view('admin.blogs.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blog = $this->blogService->getBlogById($id);
        
        // Get blog categories from database
        $categories = Category::where('type', 'blog')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
        
        // Get all published ebooks with relationships
        $ebooks = \App\Models\Ebook::where('status', 'published')
            ->with(['city', 'categories', 'creator'])
            ->orderBy('title')
            ->get();
        
        // Get cities for filter
        $cities = \App\Models\City::where('is_active', true)
            ->orderBy('name')
            ->get();
        
        // Get ebook categories for filter (type = 'ebook')
        $ebookCategories = Category::where('type', 'ebook')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.blogs.edit', compact('blog', 'categories', 'ebooks', 'cities', 'ebookCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'status' => 'required|in:draft,published,unpublished,archived',
            'remove_image' => 'boolean',
            'related_ebooks' => 'nullable|array',
            'related_ebooks.*' => 'exists:ebooks,id',
            'meta_title' => 'nullable|string|max:500',
            'meta_description' => 'nullable|string|max:1000',
            'meta_keywords' => 'nullable|string|max:500',
        ], [
            'title.required' => 'Judul blog wajib diisi.',
            'title.max' => 'Judul blog maksimal 255 karakter.',
            'content.required' => 'Konten blog wajib diisi.',
            'featured_image.image' => 'File harus berupa gambar.',
            'featured_image.mimes' => 'Format gambar harus JPEG, JPG, PNG, atau WebP.',
            'featured_image.max' => 'Ukuran gambar maksimal 2MB.',
            'categories.array' => 'Kategori harus berupa array.',
            'categories.*.exists' => 'Kategori yang dipilih tidak valid.',
            'status.required' => 'Status publikasi wajib dipilih.',
            'status.in' => 'Status publikasi tidak valid.',
        ]);

        $validated['remove_image'] = $request->has('remove_image');

        // Set published_at if status is published and not already set
        $blog = $this->blogService->getBlogById($id);
        if ($validated['status'] === 'published' && !$blog->published_at) {
            $validated['published_at'] = now();
        }

        try {
            $blog = $this->blogService->updateBlog($id, $validated);
            
            // Sync categories if provided
            if ($request->has('categories')) {
                $blog->categories()->sync($request->categories);
            } else {
                // If no categories selected, detach all
                $blog->categories()->sync([]);
            }
            
            // Sync related ebooks if provided
            if ($request->has('related_ebooks')) {
                $blog->ebooks()->sync($request->related_ebooks);
            } else {
                // If no ebooks selected, detach all
                $blog->ebooks()->sync([]);
            }
            
            return redirect()->route('admin.blogs.index')
                ->with('success', 'Blog updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update blog: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage (soft delete).
     */
    public function destroy(string $id)
    {
        try {
            $this->blogService->deleteBlog($id);
            return redirect()->route('admin.blogs.index')
                ->with('success', 'Blog moved to trash successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete blog: ' . $e->getMessage());
        }
    }

    /**
     * Display trashed blogs.
     */
    public function trashed()
    {
        try {
            $blogs = $this->blogService->getTrashedBlogs(15);
            return view('admin.blogs.trashed', compact('blogs'));
        } catch (\Exception $e) {
            return redirect()->route('admin.blogs.index')
                ->with('error', 'Failed to load trashed blogs: ' . $e->getMessage());
        }
    }

    /**
     * Restore a soft deleted blog.
     */
    public function restore(string $id)
    {
        try {
            $this->blogService->restoreBlog($id);
            return redirect()->route('admin.blogs.trashed')
                ->with('success', 'Blog restored successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to restore blog: ' . $e->getMessage());
        }
    }

    /**
     * Permanently delete a blog.
     */
    public function forceDelete(string $id)
    {
        try {
            $this->blogService->forceDeleteBlog($id);
            return redirect()->route('admin.blogs.trashed')
                ->with('success', 'Blog permanently deleted!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to permanently delete blog: ' . $e->getMessage());
        }
    }

    /**
     * Search authors for autocomplete
     */
    public function searchAuthors(Request $request)
    {
        $query = $request->get('q', '');
        
        $authors = \App\Models\User::where('user_type', 'creator')
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('email', 'LIKE', "%{$query}%");
            })
            ->select('id', 'name', 'email')
            ->orderBy('name')
            ->limit(20)
            ->get();
        
        return response()->json($authors);
    }
}
