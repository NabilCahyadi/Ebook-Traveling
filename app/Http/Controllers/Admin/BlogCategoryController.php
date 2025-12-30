<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the blog categories.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $categories = Category::where('type', 'blog')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('slug', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate(15);

        return view('admin.blog-categories.index', compact('categories', 'search'));
    }

    /**
     * Show the form for creating a new blog category.
     */
    public function create()
    {
        return view('admin.blog-categories.create');
    }

    /**
     * Store a newly created blog category in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Ensure slug is unique
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (Category::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        $validated['type'] = 'blog';
        $validated['is_active'] = $request->has('is_active');

        Category::create($validated);

        return redirect()->route('admin.blog-categories.index')
            ->with('success', 'Blog category created successfully!');
    }

    /**
     * Display the specified blog category.
     */
    public function show(string $id)
    {
        $category = Category::where('type', 'blog')->findOrFail($id);
        return view('admin.blog-categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified blog category.
     */
    public function edit(string $id)
    {
        $category = Category::where('type', 'blog')->findOrFail($id);
        return view('admin.blog-categories.edit', compact('category'));
    }

    /**
     * Update the specified blog category in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::where('type', 'blog')->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['is_active'] = $request->has('is_active');

        $category->update($validated);

        return redirect()->route('admin.blog-categories.index')
            ->with('success', 'Blog category updated successfully!');
    }

    /**
     * Remove the specified blog category from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::where('type', 'blog')->findOrFail($id);
        
        // Check if category is used by any blogs
        $blogsCount = \App\Models\Blog::where('category', $category->name)->count();
        
        if ($blogsCount > 0) {
            return redirect()->route('admin.blog-categories.index')
                ->with('error', "Cannot delete category. It is used by {$blogsCount} blog(s).");
        }

        $category->delete();

        return redirect()->route('admin.blog-categories.index')
            ->with('success', 'Blog category deleted successfully!');
    }

    /**
     * Display a listing of trashed blog categories.
     */
    public function trashed(Request $request)
    {
        $search = $request->get('search');

        $categories = Category::where('type', 'blog')
            ->onlyTrashed()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('slug', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->orderBy('deleted_at', 'desc')
            ->paginate(15);

        return view('admin.blog-categories.trashed', compact('categories', 'search'));
    }

    /**
     * Restore the specified trashed blog category.
     */
    public function restore(string $id)
    {
        $category = Category::where('type', 'blog')->onlyTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('admin.blog-categories.trashed')
            ->with('success', 'Blog category restored successfully!');
    }

    /**
     * Permanently delete the specified blog category.
     */
    public function forceDelete(string $id)
    {
        $category = Category::where('type', 'blog')->onlyTrashed()->findOrFail($id);
        $category->forceDelete();

        return redirect()->route('admin.blog-categories.trashed')
            ->with('success', 'Blog category permanently deleted!');
    }
}
