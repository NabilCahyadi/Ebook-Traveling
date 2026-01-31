<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BlogService;
use App\Models\City;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

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

        // ✅ VIEW TRACKING: Count only 1 view per 1 hour per session
        $now = now();
        $sessionKey = 'blog_view_' . $blog->id;
        $lastViewTime = session($sessionKey) ? Carbon::parse(session($sessionKey)) : null;

        Log::info("📝 [BLOG VIEW TRACKING] Started", [
            'blog_id' => $blog->id,
            'blog_title' => $blog->title,
            'session_key' => $sessionKey,
            'last_view_time' => $lastViewTime ? $lastViewTime->toDateTimeString() : null,
            'now' => $now->toDateTimeString(),
            'current_view_count' => $blog->view_count,
            'session_id' => session()->getId(),
        ]);

        // Jika belum ada di session atau sudah lebih dari 60 menit
        $shouldIncrement = false;
        $minutesElapsed = 0;

        if ($lastViewTime === null) {
            $shouldIncrement = true;
            Log::info("📝 [BLOG VIEW TRACKING] Reason: First view - no session data found");
        } else {
            $minutesElapsed = $now->diffInMinutes($lastViewTime);
            if ($minutesElapsed >= 60) {
                $shouldIncrement = true;
                Log::info("📝 [BLOG VIEW TRACKING] Reason: 1 hour passed - can count again", [
                    'minutes_elapsed' => $minutesElapsed,
                ]);
            } else {
                Log::info("📝 [BLOG VIEW TRACKING] Reason: Within 1 hour - skip counting", [
                    'minutes_elapsed' => $minutesElapsed,
                    'minutes_remaining' => (60 - $minutesElapsed),
                ]);
            }
        }

        if ($shouldIncrement) {
            try {
                // Increment view_count di database
                $blog->increment('view_count');

                // Refresh untuk mendapatkan nilai terbaru
                $blog->refresh();

                Log::info("✅ [BLOG VIEW TRACKING] View count incremented", [
                    'blog_id' => $blog->id,
                    'blog_title' => $blog->title,
                    'new_view_count' => $blog->view_count,
                    'session_key' => $sessionKey,
                ]);

                // Simpan waktu view sekarang ke session (berlaku 1 jam)
                session()->put($sessionKey, $now);
                session()->save(); // Force save session

                Log::info("💾 [BLOG VIEW TRACKING] Session updated", [
                    'session_key' => $sessionKey,
                    'saved_time' => $now->toDateTimeString(),
                ]);
            } catch (\Exception $e) {
                Log::error("❌ [BLOG VIEW TRACKING] Error during increment", [
                    'blog_id' => $blog->id,
                    'error_message' => $e->getMessage(),
                    'error_trace' => $e->getTraceAsString(),
                ]);
            }
        }

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
