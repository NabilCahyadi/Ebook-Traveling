<?php

namespace App\Repositories;

use App\Models\Ebook;
use App\Models\Payment;
use App\Models\User;
use App\Models\Subscription;
use App\Models\Category;
use App\Models\City;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportRepository
{
    /**
     * Get total revenue
     */
    public function getTotalRevenue(Carbon $start, Carbon $end): float
    {
        return Payment::where('status', 'completed')
            ->whereBetween('created_at', [$start, $end])
            ->sum('amount');
    }

    /**
     * Get revenue by date
     */
    public function getRevenueByDate(Carbon $start, Carbon $end)
    {
        return Payment::where('status', 'completed')
            ->whereBetween('created_at', [$start, $end])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(amount) as total')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    /**
     * Get revenue by subscription plan
     */
    public function getRevenueByPlan(Carbon $start, Carbon $end)
    {
        return Subscription::join('subscription_plans', 'subscriptions.subscription_plan_id', '=', 'subscription_plans.id')
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
    }

    /**
     * Get revenue by payment method
     */
    public function getRevenueByPaymentMethod(Carbon $start, Carbon $end)
    {
        return Payment::where('status', 'completed')
            ->whereBetween('created_at', [$start, $end])
            ->select(
                'payment_method',
                DB::raw('SUM(amount) as total'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('payment_method')
            ->orderByDesc('total')
            ->get();
    }

    /**
     * Get top performing ebooks
     */
    public function getTopPerformingEbooks(string $sortBy = 'reads', int $limit = 20)
    {
        $query = Ebook::where('status', 'published')
            ->with(['category', 'city'])
            ->withAvg('ratings', 'rating')
            ->withCount('ratings as total_ratings');

        if ($sortBy === 'rating') {
            $query->orderByDesc('ratings_avg_rating')
                ->orderByDesc('total_ratings');
        } elseif ($sortBy === 'views') {
            $query->orderByDesc('view_count');
        } else {
            $query->orderByDesc('read_count');
        }

        return $query->limit($limit)->get();
    }

    /**
     * Get low performing ebooks
     */
    public function getLowPerformingEbooks(int $threshold = 10, int $limit = 10)
    {
        return Ebook::where('status', 'published')
            ->where('read_count', '<', $threshold)
            ->with(['category', 'city'])
            ->withAvg('ratings', 'rating')
            ->orderBy('read_count', 'asc')
            ->orderBy('view_count', 'asc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get ebooks by creator
     */
    public function getEbooksByCreator(int $limit = 10)
    {
        return Ebook::select('creator_id', DB::raw('COUNT(*) as total_ebooks'), DB::raw('SUM(read_count) as total_reads'))
            ->with('creator')
            ->groupBy('creator_id')
            ->orderByDesc('total_reads')
            ->limit($limit)
            ->get();
    }

    /**
     * Get ebook statistics
     */
    public function getEbookStatistics(): array
    {
        return [
            'total_ebooks' => Ebook::count(),
            'active_ebooks' => Ebook::where('status', 'published')->count(),
            'total_reads' => Ebook::sum('read_count'),
            'total_views' => Ebook::sum('view_count'),
        ];
    }

    /**
     * Get user growth
     */
    public function getUserGrowth(Carbon $start, Carbon $end)
    {
        return User::whereBetween('created_at', [$start, $end])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    /**
     * Get user statistics
     */
    public function getUserStatistics(): array
    {
        return [
            'total_users' => User::count(),
            'active_subscribers' => Subscription::where('status', 'active')
                ->where('end_date', '>', now())
                ->distinct('user_id')
                ->count('user_id'),
            'new_users_today' => User::whereDate('created_at', today())->count(),
            'new_users_this_month' => User::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];
    }

    /**
     * Get subscription statistics
     */
    public function getSubscriptionStatistics(Carbon $start, Carbon $end): array
    {
        return [
            'total_subscriptions' => Subscription::whereBetween('created_at', [$start, $end])->count(),
            'active_subscriptions' => Subscription::where('status', 'active')
                ->where('end_date', '>', now())
                ->count(),
            'cancelled_subscriptions' => Subscription::where('status', 'cancelled')
                ->whereBetween('updated_at', [$start, $end])
                ->count(),
            'revenue' => Subscription::whereIn('status', ['active', 'expired'])
                ->whereBetween('created_at', [$start, $end])
                ->sum('total_amount'),
        ];
    }

    /**
     * Get category distribution
     */
    public function getCategoryDistribution()
    {
        return Category::withCount(['ebooks' => function ($query) {
            $query->where('status', 'published');
        }])
            ->orderByDesc('ebooks_count')
            ->get();
    }

    /**
     * Get city distribution
     */
    public function getCityDistribution()
    {
        return City::withCount(['ebooks' => function ($query) {
            $query->where('status', 'published');
        }])
            ->orderByDesc('ebooks_count')
            ->get();
    }
}
