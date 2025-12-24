<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\EbookService;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    protected $ebookService;

    public function __construct(EbookService $ebookService)
    {
        $this->ebookService = $ebookService;
    }

    /**
     * Display admin dashboard.
     */
    public function index()
    {
        // Get statistics
        $totalEbooks = \App\Models\Ebook::count();
        $totalUsers = \App\Models\User::count();
        $totalCategories = \App\Models\Category::count();
        $totalCities = \App\Models\City::count();

        // Get sales statistics from subscriptions
        $totalOrders = 0;
        $totalRevenue = 0;
        $pendingOrders = 0;
        $monthlyRevenue = [];

        if (class_exists('\App\Models\Subscription')) {
            // Total subscriptions (all paid subscriptions)
            $totalOrders = \App\Models\Subscription::whereIn('status', ['active', 'expired'])->count();
            
            // Total revenue from all paid subscriptions
            $totalRevenue = \App\Models\Subscription::whereIn('status', ['active', 'expired'])->sum('total_amount');
            
            // Pending subscriptions (waiting for payment or approval)
            $pendingOrders = \App\Models\Subscription::where('status', 'pending')->count();

            // Get monthly revenue data for chart (last 6 months)
            for ($i = 5; $i >= 0; $i--) {
                $month = now()->subMonths($i);
                $revenue = \App\Models\Subscription::whereIn('status', ['active', 'expired'])
                    ->whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->sum('total_amount');
                $monthlyRevenue[] = [
                    'month' => $month->format('M Y'),
                    'revenue' => $revenue
                ];
            }
        } else {
            // Default empty data for chart
            for ($i = 5; $i >= 0; $i--) {
                $month = now()->subMonths($i);
                $monthlyRevenue[] = [
                    'month' => $month->format('M Y'),
                    'revenue' => 0
                ];
            }
        }

        // Get active subscribers (premium members)
        $activeSubscribers = 0;
        if (class_exists('\App\Models\Subscription')) {
            $activeSubscribers = \App\Models\Subscription::where('status', 'active')
                ->where('end_date', '>', now())
                ->count();
        }

        // Get category distribution for chart
        $categoryStats = \App\Models\Category::withCount('ebooks')
            ->orderBy('ebooks_count', 'desc')
            ->take(5)
            ->get();

        // Get recent data
        $recentEbooks = \App\Models\Ebook::with('category', 'city')
            ->latest()
            ->take(5)
            ->get();

        // Get recent activity logs
        $recentActivities = collect([]);
        if (class_exists('\App\Models\ActionLog')) {
            $recentActivities = \App\Models\ActionLog::with('user')
                ->latest()
                ->take(10)
                ->get();
        }

        return view('admin.dashboard', compact(
            'recentEbooks',
            'totalEbooks',
            'totalUsers',
            'totalCategories',
            'totalCities',
            'totalOrders',
            'totalRevenue',
            'pendingOrders',
            'activeSubscribers',
            'monthlyRevenue',
            'categoryStats',
            'recentActivities'
        ));
    }
}
