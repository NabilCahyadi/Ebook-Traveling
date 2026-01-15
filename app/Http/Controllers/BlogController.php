<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BlogService;
use App\Models\City;

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
        $citiesHeader = City::where('is_active', true)
            ->orderBy('order_index')
            ->orderBy('name')
            ->get();
        return view('blogs', compact('blogs', 'allTags', 'citiesHeader'));
    }

    /**
     * Menampilkan detail satu blog berdasarkan slug.
     */
    public function show($slug)
    {
        $blog = $this->blogService->getBlogBySlug($slug);
        $citiesHeader = City::where('is_active', true)
            ->orderBy('order_index')
            ->orderBy('name')
            ->get();
        $this->blogService->incrementViewCount($blog->id);

        return view('blog-detail', compact('blog', 'citiesHeader'));
    }

    /**
     * Menampilkan blog berdasarkan tag tertentu.
     */
    public function byTag($tag)
    {
        $blogs = $this->blogService->getPublishedBlogsByTag($tag, 10);
        $allTags = $this->blogService->getAllPublishedTags();
        $popularTags = $this->blogService->getPopularTags(10);
        $citiesHeader = City::where('is_active', true)
            ->orderBy('order_index')
            ->orderBy('name')
            ->get();

        return view('blogs-index', compact('blogs', 'tag', 'allTags', 'popularTags', 'citiesHeader'));
    }
}
