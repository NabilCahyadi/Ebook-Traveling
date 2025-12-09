<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $categories = BlogCategory::withCount('blogs');
        
        if ($search) {
            $categories->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }
        
        $categories = $categories->orderBy('name', 'asc')->paginate(15);
        
        return view('admin.blog-categories.index', compact('categories', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blog-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:blog_categories,name',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        
        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');
        
        BlogCategory::create($validated);
        
        return redirect()->route('admin.blog-categories.index')
            ->with('success', 'Blog category created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogCategory $blogCategory)
    {
        $blogCategory->load('blogs');
        return view('admin.blog-categories.show', compact('blogCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogCategory $blogCategory)
    {
        return view('admin.blog-categories.edit', compact('blogCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BlogCategory $blogCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:blog_categories,name,' . $blogCategory->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        
        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');
        
        $blogCategory->update($validated);
        
        return redirect()->route('admin.blog-categories.index')
            ->with('success', 'Blog category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogCategory $blogCategory)
    {
        // Check if category has blogs
        if ($blogCategory->blogs()->count() > 0) {
            return back()->with('error', 'Cannot delete category with existing blogs. Please reassign or delete the blogs first.');
        }
        
        $blogCategory->delete();
        
        return redirect()->route('admin.blog-categories.index')
            ->with('success', 'Blog category moved to trash successfully!');
    }

    /**
     * Restore soft deleted category.
     */
    public function restore($id)
    {
        $category = BlogCategory::withTrashed()->findOrFail($id);
        $category->restore();
        
        return redirect()->route('admin.blog-categories.index')
            ->with('success', 'Blog category restored successfully!');
    }

    /**
     * Permanently delete category.
     */
    public function forceDelete($id)
    {
        $category = BlogCategory::withTrashed()->findOrFail($id);
        
        if ($category->blogs()->count() > 0) {
            return back()->with('error', 'Cannot permanently delete category with existing blogs.');
        }
        
        $category->forceDelete();
        
        return redirect()->route('admin.blog-categories.index')
            ->with('success', 'Blog category permanently deleted!');
    }

    /**
     * Display trashed categories.
     */
    public function trashed(Request $request)
    {
        $search = $request->get('search');
        
        $categories = BlogCategory::onlyTrashed();
        
        if ($search) {
            $categories->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }
        
        $categories = $categories->orderBy('name', 'asc')->paginate(15);
        
        return view('admin.blog-categories.trashed', compact('categories', 'search'));
    }
}
