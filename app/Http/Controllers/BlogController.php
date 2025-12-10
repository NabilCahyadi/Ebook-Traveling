<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BlogService;
// use App\Models\Blog;

class BlogController extends Controller
{
    protected $blogService;

    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }

    /**
     * Menampilkan halaman daftar semua blog.
     */
    public function index()
    {
        $blogs = $this->blogService->getPublishedBlogs(10);
        $allTags = $this->blogService->getAllPublishedTags();
        // $popularTags = $this->blogService->getPopularTags(10);

        return view('blogs', compact('blogs', 'allTags'));
    }

    /**
     * Menampilkan detail satu blog berdasarkan slug.
     */
    public function show($slug)
    {
        $blog = $this->blogService->getBlogBySlug($slug);
        $this->blogService->incrementViewCount($blog->id);

        return view('blog-detail', compact('blog'));
    }

    /**
     * Menampilkan blog berdasarkan tag tertentu.
     */
    public function byTag($tag)
    {
        $blogs = $this->blogService->getPublishedBlogsByTag($tag, 10);
        $allTags = $this->blogService->getAllPublishedTags();
        $popularTags = $this->blogService->getPopularTags(10);

        return view('blogs-index', compact('blogs', 'tag', 'allTags','popularTags'));
    }
}
