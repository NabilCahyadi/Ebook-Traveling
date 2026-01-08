<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ebook;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\User;
use App\Models\Category;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function revenue(Request $request)
    {
        $filter = $request->get('filter', 'month'); // day, week, month, year
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        // Set date range based on filter
        if ($startDate && $endDate) {
            $start = Carbon::parse($startDate)->startOfDay();
            $end = Carbon::parse($endDate)->endOfDay();
        } else {
            switch ($filter) {
                case 'day':
                    $start = Carbon::now()->subDays(30);
                    $end = Carbon::now();
                    break;
                case 'week':
                    $start = Carbon::now()->subWeeks(12);
                    $end = Carbon::now();
                    break;
                case 'year':
                    $start = Carbon::now()->subYears(2);
                    $end = Carbon::now();
                    break;
                default: // month
                    $start = Carbon::now()->subMonths(12);
                    $end = Carbon::now();
            }
        }

        // Total revenue
        $totalRevenue = Payment::where('status', 'completed')
            ->whereBetween('created_at', [$start, $end])
            ->sum('amount');

        // Revenue by date
        $revenueByDate = Payment::where('status', 'completed')
            ->whereBetween('created_at', [$start, $end])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(amount) as total')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Revenue by subscription plan
        $revenueByPlan = \App\Models\Subscription::join('subscription_plans', 'subscriptions.subscription_plan_id', '=', 'subscription_plans.id')
            ->whereIn('subscriptions.status', ['active', 'expired'])
            ->whereBetween('subscriptions.created_at', [$start, $end])
            ->select(
                'subscription_plans.name',
                DB::raw('SUM(subscriptions.total_amount) as total'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('subscription_plans.id', 'subscription_plans.name')
            ->orderByDesc('total')
            ->get();

        // Revenue by payment method
        $revenueByPaymentMethod = Payment::where('status', 'completed')
            ->whereBetween('created_at', [$start, $end])
            ->select(
                'payment_method',
                DB::raw('SUM(amount) as total'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('payment_method')
            ->orderByDesc('total')
            ->get();

        // Keep payment methods table data for backward compatibility
        $paymentMethodsTable = $revenueByPaymentMethod;

        return view('admin.reports.revenue', compact(
            'totalRevenue',
            'revenueByDate',
            'revenueByPlan',
            'revenueByPaymentMethod',
            'paymentMethodsTable',
            'filter',
            'start',
            'end'
        ));
    }

    public function ebookPerformance(Request $request)
    {
        $filter = $request->get('filter', 'all'); // all, month, week
        $sortBy = $request->get('sort', 'reads'); // reads, views, rating

        // Top performing ebooks (pure subscription model - by reads/views)
        $topEbooksQuery = Ebook::where('status', 'published')
            ->with(['category', 'city'])
            ->withAvg('ratings', 'rating')
            ->withCount('ratings as total_ratings');

        if ($sortBy === 'rating') {
            $topEbooksQuery->orderByDesc('ratings_avg_rating')
                ->orderByDesc('total_ratings');
        } elseif ($sortBy === 'views') {
            $topEbooksQuery->orderByDesc('view_count');
        } else { // reads (default)
            $topEbooksQuery->orderByDesc('read_count');
        }

        $topEbooks = $topEbooksQuery->limit(20)->get();

        // Low performing ebooks (low reads)
        $lowPerformingEbooks = Ebook::where('status', 'published')
            ->where('read_count', '<', 10) // Threshold: less than 10 reads
            ->with(['category', 'city'])
            ->withAvg('ratings', 'rating')
            ->orderBy('read_count', 'asc')
            ->orderBy('view_count', 'asc')
            ->limit(10)
            ->get();

        // Ebook by creator (if creator_id exists)
        $ebooksByCreator = Ebook::select('creator_id', DB::raw('COUNT(*) as total_ebooks'), DB::raw('SUM(read_count) as total_reads'))
            ->with('creator')
            ->groupBy('creator_id')
            ->orderByDesc('total_reads')
            ->limit(10)
            ->get();

        // Total statistics
        $totalEbooks = Ebook::count();
        $activeEbooks = Ebook::where('status', 'published')->count();
        $totalReads = Ebook::sum('read_count');
        $totalViews = Ebook::sum('view_count');

        return view('admin.reports.ebook-performance', compact(
            'topEbooks',
            'lowPerformingEbooks',
            'ebooksByCreator',
            'totalEbooks',
            'activeEbooks',
            'totalReads',
            'totalViews',
            'filter',
            'sortBy'
        ));
    }

    public function userAnalytics(Request $request)
    {
        $filter = $request->get('filter', 'month');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        // Set date range based on filter
        if ($startDate && $endDate) {
            $start = Carbon::parse($startDate)->startOfDay();
            $end = Carbon::parse($endDate)->endOfDay();
        } else {
            switch ($filter) {
                case 'day':
                    $start = Carbon::now()->subDays(30);
                    $end = Carbon::now();
                    break;
                case 'week':
                    $start = Carbon::now()->subWeeks(12);
                    $end = Carbon::now();
                    break;
                case 'year':
                    $start = Carbon::now()->subYears(2);
                    $end = Carbon::now();
                    break;
                default: // month
                    $start = Carbon::now()->subMonths(12);
                    $end = Carbon::now();
            }
        }

        // User growth
        $userGrowth = User::whereBetween('created_at', [$start, $end])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Active vs Inactive users (users with orders vs without)
        $activeUsers = User::whereHas('orders')->count();
        $inactiveUsers = User::whereDoesntHave('orders')->count();

        // Premium vs Free users
        $premiumUsers = User::whereHas('subscriptions', function ($q) {
            $q->where('status', 'active');
        })->count();
        $freeUsers = User::whereDoesntHave('subscriptions', function ($q) {
            $q->where('status', 'active');
        })->count();

        // Users by registration date
        $recentUsers = User::with('subscriptions')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        $totalUsers = User::count();

        return view('admin.reports.user-analytics', compact(
            'userGrowth',
            'activeUsers',
            'inactiveUsers',
            'premiumUsers',
            'freeUsers',
            'recentUsers',
            'totalUsers',
            'filter',
            'start',
            'end'
        ));
    }

    public function getUserAnalyticsData(Request $request)
    {
        $filter = $request->get('filter', 'month');
        $count = $request->get('count', 6);

        // Calculate date range based on filter and count
        switch ($filter) {
            case 'day':
                $start = Carbon::now()->subDays($count);
                $end = Carbon::now();
                $dateFormat = 'd M';
                break;
            case 'year':
                $start = Carbon::now()->subYears($count);
                $end = Carbon::now();
                $dateFormat = 'M Y';
                break;
            default: // month
                $start = Carbon::now()->subMonths($count);
                $end = Carbon::now();
                $dateFormat = 'M Y';
        }

        // Get user growth data
        $userGrowth = User::whereBetween('created_at', [$start, $end])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json([
            'labels' => $userGrowth->pluck('date')->map(fn($date) => Carbon::parse($date)->format($dateFormat)),
            'data' => $userGrowth->pluck('count')
        ]);
    }

    public function salesAnalytics(Request $request)
    {
        // Total users
        $totalUsers = User::count();
        
        // Active Subscribers (status = active and end_date >= today)
        $activeSubscribers = DB::table('subscriptions')
            ->where('status', 'active')
            ->where('end_date', '>=', Carbon::now())
            ->count();

        // Subscription Rate (% users yang berlangganan)
        $subscriptionRate = $totalUsers > 0 ? ($activeSubscribers / $totalUsers) * 100 : 0;

        // Monthly Recurring Revenue (MRR) - revenue dari active subscriptions this month
        $mrr = DB::table('subscriptions')
            ->join('subscription_plans', 'subscriptions.subscription_plan_id', '=', 'subscription_plans.id')
            ->where('subscriptions.status', 'active')
            ->where('subscriptions.end_date', '>=', Carbon::now())
            ->sum('subscriptions.total_amount');

        // New subscribers this month
        $newSubscribersThisMonth = DB::table('subscriptions')
            ->where('status', 'active')
            ->whereMonth('start_date', Carbon::now()->month)
            ->whereYear('start_date', Carbon::now()->year)
            ->count();

        // Expired/Cancelled subscriptions this month (for churn rate)
        $expiredThisMonth = DB::table('subscriptions')
            ->where('status', 'expired')
            ->whereMonth('end_date', Carbon::now()->month)
            ->whereYear('end_date', Carbon::now()->year)
            ->count();

        // Churn Rate (% subscriber yang berhenti)
        $totalSubscribersLastMonth = $activeSubscribers + $expiredThisMonth;
        $churnRate = $totalSubscribersLastMonth > 0 ? ($expiredThisMonth / $totalSubscribersLastMonth) * 100 : 0;

        // Peak subscription hours (when users subscribe)
        $peakHours = DB::table('subscriptions')
            ->select(
                DB::raw('HOUR(created_at) as hour'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('hour')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        // Subscription by status
        $subscriptionsByStatus = DB::table('subscriptions')
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        // Subscription trend (last 30 days)
        $subscriptionTrend = DB::table('subscriptions')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.reports.subscription-analytics', compact(
            'subscriptionRate',
            'mrr',
            'peakHours',
            'subscriptionsByStatus',
            'subscriptionTrend',
            'totalUsers',
            'activeSubscribers',
            'newSubscribersThisMonth',
            'churnRate'
        ));
    }
}
