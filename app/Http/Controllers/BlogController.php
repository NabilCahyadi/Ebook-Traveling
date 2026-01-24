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
    public function index(Request $request)
    {
        // Get filter parameters
        $perPage = $request->input('per_page', 50);
        $sortBy = $request->input('sort_by', 'featured');

        // Validate per_page
        $validPerPage = ['50', '100', '150', '200', '250', '300', 'all'];
        if (!in_array(strtolower($perPage), $validPerPage)) {
            $perPage = 50;
        }

        // Build query
        $query = \App\Models\Blog::where('status', 'published')
            ->where('published_at', '<=', now());

        // Apply sorting
        switch ($sortBy) {
            case 'newest':
                $query->orderBy('published_at', 'desc');
                break;
            case 'release_date':
                $query->orderBy('published_at', 'asc'); // Oldest first
                break;
            case 'featured':
            default:
                // Featured: Sort by view_count DESC
                $query->orderBy('view_count', 'desc')
                      ->orderBy('published_at', 'desc');
                break;
        }

        // Get results with pagination or all
        if (strtolower($perPage) === 'all') {
            $blogs = $query->get();
            // Create a fake paginator for consistency
            $blogs = new \Illuminate\Pagination\LengthAwarePaginator(
                $blogs,
                $blogs->count(),
                $blogs->count(),
                1,
                ['path' => $request->url(), 'query' => $request->query()]
            );
        } else {
            $blogs = $query->paginate((int)$perPage)->appends([
                'per_page' => $perPage,
                'sort_by' => $sortBy
            ]);
        }

        $allTags = $this->blogService->getAllPublishedTags();
        $citiesHeader = City::where('is_active', true)
            ->orderBy('order_index')
            ->orderBy('name')
            ->get();

        return view('blogs', compact('blogs', 'allTags', 'citiesHeader', 'perPage', 'sortBy'));
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
    public function byTag(Request $request, $tag)
    {
        $perPage = $request->get('per_page', 20);
        $sortBy = $request->get('sort_by', 'newest');

        // Validate per_page - kelipatan 20
        if (!in_array($perPage, [20, 40, 60, 80, 100, 'all'])) {
            $perPage = 20;
        }

        // Get blogs with sorting
        $query = \App\Models\Blog::where('status', 'published')
            ->where('published_at', '<=', now())
            ->whereJsonContains('tags', $tag);

        // Apply sorting
        switch ($sortBy) {
            case 'newest':
                $query->orderBy('published_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('published_at', 'asc');
                break;
            case 'most_viewed':
                $query->orderBy('view_count', 'desc');
                break;
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            default:
                $query->orderBy('published_at', 'desc');
        }

        // Pagination or get all
        if ($perPage === 'all') {
            $blogs = $query->get();
            // Manually create paginator for consistency
            $blogs = new \Illuminate\Pagination\LengthAwarePaginator(
                $blogs,
                $blogs->count(),
                $blogs->count(),
                1,
                ['path' => $request->url(), 'query' => $request->query()]
            );
        } else {
            $blogs = $query->paginate($perPage)->appends($request->query());
        }

        $allTags = $this->blogService->getAllPublishedTags();
        $popularTags = $this->blogService->getPopularTags(10);
        $citiesHeader = City::where('is_active', true)
            ->orderBy('order_index')
            ->orderBy('name')
            ->get();

        return view('blogs-index', compact('blogs', 'tag', 'allTags', 'popularTags', 'citiesHeader'));
    }
}
