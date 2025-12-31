<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Services\EbookService;
use Illuminate\Http\Request;

class PanelDashboardController extends Controller
{
    protected $ebookService;

    public function __construct(EbookService $ebookService)
    {
        $this->ebookService = $ebookService;
    }

    /**
     * Display panel dashboard for creator/user.
     */
    public function index()
    {
        $user = auth()->user();

        // Get statistics for creator (own content only)
        $totalEbooks = \App\Models\Ebook::where('creator_id', $user->id)->count();
        $totalBlogs = 0;
        if (class_exists('\App\Models\Blog')) {
            $totalBlogs = \App\Models\Blog::where('author_id', $user->id)->count();
        }

        // Get ebook statistics
        $publishedEbooks = \App\Models\Ebook::where('creator_id', $user->id)
            ->where('status', 'published')
            ->count();
        
        $pendingEbooks = \App\Models\Ebook::where('creator_id', $user->id)
            ->where('status', 'pending')
            ->count();

        $draftEbooks = \App\Models\Ebook::where('creator_id', $user->id)
            ->where('status', 'draft')
            ->count();

        // Get recent ebooks
        $recentEbooks = \App\Models\Ebook::where('creator_id', $user->id)
            ->with('category', 'city')
            ->latest()
            ->take(5)
            ->get();

        // Get recent blogs if exists
        $recentBlogs = collect([]);
        if (class_exists('\App\Models\Blog')) {
            $recentBlogs = \App\Models\Blog::where('author_id', $user->id)
                ->latest()
                ->take(5)
                ->get();
        }

        // Monthly ebook creation stats (last 6 months)
        $monthlyStats = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $count = \App\Models\Ebook::where('creator_id', $user->id)
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
            
            $monthlyStats[] = [
                'month' => $month->format('M Y'),
                'count' => $count
            ];
        }

        return view('panel.dashboard', compact(
            'totalEbooks',
            'totalBlogs',
            'publishedEbooks',
            'pendingEbooks',
            'draftEbooks',
            'recentEbooks',
            'recentBlogs',
            'monthlyStats'
        ));
    }
}
