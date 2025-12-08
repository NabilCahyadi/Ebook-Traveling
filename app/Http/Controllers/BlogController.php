<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BlogService;
use App\Models\Blog;

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
        // Ambil semua blog yang sudah dipublish dengan pagination
        $blogs = $this->blogService->getPublishedBlogs(10); // 9 blog per halaman

        // Ambil semua tags dari blog yang sudah dipublish untuk sidebar
        $allTags = Blog::where('is_published', 1)->pluck('tags')->flatten()->unique();

        return view('blogs', compact('blogs', 'allTags'));
    }

    /**
     * Menampilkan detail satu blog berdasarkan slug.
     */
    public function show($slug)
    {
        // Tambahkan 'ebooks' untuk eager loading
        // $blog = Blog::with('ebooks')->where('slug', $slug)->firstOrFail();
        $blog = $this->blogService->getBlogBySlug($slug);

        // Tambah view count
        $this->blogService->incrementViewCount($blog->id);

        return view('blog-detail', compact('blog'));
    }

    public function byTag($tag)
    {
        // Ambil blog berdasarkan tag yang dipilih
        $blogs = Blog::where('is_published', 1)
            ->whereJsonContains('tags', $tag)
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        // Ambil semua tags untuk sidebar
        $allTags = Blog::where('is_published', 1)->pluck('tags')->flatten()->unique();

        return view('blogs-index', compact('blogs', 'tag', 'allTags'));
    }
}
