<?php

namespace App\Http\Controllers;

use App\Services\BlogService;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function __construct(
        private BlogService $blogService
    ) {}

    /**
     * Display a listing of published blogs.
     */
    public function index()
    {
        $blogs = $this->blogService->getPublishedBlogs(12);

        return view('blogs', [
            'blogs' => $blogs
        ]);
    }

    /**
     * Display the specified blog.
     */
    public function show(string $slug)
    {
        $blog = $this->blogService->getBlogBySlug($slug);

        if (!$blog || $blog->status !== 'published') {
            abort(404, 'Blog not found');
        }

        // Increment view count
        $this->blogService->incrementViewCount($blog->id);

        // Get related blogs (same category, exclude current)
        $relatedBlogs = \App\Models\Blog::where('status', 'published')
            ->where('category', $blog->category)
            ->where('id', '!=', $blog->id)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        return view('blog-detail', [
            'blog' => $blog,
            'relatedBlogs' => $relatedBlogs
        ]);
    }
}
