<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\BlogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BlogCategory;

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

        $blogs = $this->blogService->getFilteredBlogs([
            'status' => $status,
            'category' => $category,
            'search' => $search,
            'exclude_archived' => true,
        ], 15);

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
        $categories = BlogCategory::active()->orderBy('name')->get();
        return view('admin.blogs.create', compact('categories'));
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
            'blog_category_id' => 'nullable|exists:blog_categories,id',
            'status' => 'required|in:draft,published,unpublished,archived',
        ]);

        $validated['author_id'] = Auth::id();

        // Set published_at if status is published
        if ($validated['status'] === 'published' && !isset($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        try {
            $this->blogService->createBlog($validated);
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
        $categories = BlogCategory::active()->orderBy('name')->get();
        return view('admin.blogs.edit', compact('blog', 'categories'));
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
            'blog_category_id' => 'nullable|exists:blog_categories,id',
            'status' => 'required|in:draft,published,unpublished,archived',
            'remove_image' => 'boolean',
        ]);

        $validated['remove_image'] = $request->has('remove_image');

        // Set published_at if status is published and not already set
        $blog = $this->blogService->getBlogById($id);
        if ($validated['status'] === 'published' && !$blog->published_at) {
            $validated['published_at'] = now();
        }

        try {
            $this->blogService->updateBlog($id, $validated);
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
}
