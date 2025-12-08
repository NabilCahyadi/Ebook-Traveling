<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BlogService;
use App\Models\Blog;

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
        // Get published blogs with pagination
        $blogs = $this->blogService->getPublishedBlogs(12);

        // Get all tags from published blogs for sidebar
        $allTags = Blog::where('status', 'published')
            ->whereNotNull('tags')
            ->pluck('tags')
            ->flatten()
            ->unique()
            ->filter();

        return view('blogs', [
            'blogs' => $blogs,
            'allTags' => $allTags
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
        $relatedBlogs = Blog::where('status', 'published')
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

    /**
     * Display blogs filtered by tag.
     */
    public function byTag($tag)
    {
        // Get blogs by selected tag
        $blogs = Blog::where('status', 'published')
            ->whereJsonContains('tags', $tag)
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        // Get all tags for sidebar
        $allTags = Blog::where('status', 'published')
            ->whereNotNull('tags')
            ->pluck('tags')
            ->flatten()
            ->unique()
            ->filter();

        return view('blogs', compact('blogs', 'tag', 'allTags'));
    }
}
