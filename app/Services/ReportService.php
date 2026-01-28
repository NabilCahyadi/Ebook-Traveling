<?php

namespace App\Services;

use App\Repositories\ReportRepository;
use Carbon\Carbon;

class ReportService
{
    protected ReportRepository $repository;

    public function __construct(ReportRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get date range based on filter
     */
    public function getDateRange(string $filter, ?string $startDate = null, ?string $endDate = null): array
    {
        if ($startDate && $endDate) {
            return [
                'start' => Carbon::parse($startDate)->startOfDay(),
                'end' => Carbon::parse($endDate)->endOfDay(),
            ];
        }

        switch ($filter) {
            case 'day':
                return [
                    'start' => Carbon::now()->subDays(30),
                    'end' => Carbon::now(),
                ];
            case 'week':
                return [
                    'start' => Carbon::now()->subWeeks(12),
                    'end' => Carbon::now(),
                ];
            case 'year':
                return [
                    'start' => Carbon::now()->subYears(2),
                    'end' => Carbon::now(),
                ];
            default: // month
                return [
                    'start' => Carbon::now()->subMonths(12),
                    'end' => Carbon::now(),
                ];
        }
    }

    /**
     * Get revenue report data
     */
    public function getRevenueReport(string $filter, ?string $startDate = null, ?string $endDate = null): array
    {
        $dateRange = $this->getDateRange($filter, $startDate, $endDate);
        $start = $dateRange['start'];
        $end = $dateRange['end'];

        return [
            'totalRevenue' => $this->repository->getTotalRevenue($start, $end),
            'revenueByDate' => $this->repository->getRevenueByDate($start, $end),
            'revenueByPlan' => $this->repository->getRevenueByPlan($start, $end),
            'revenueByPaymentMethod' => $this->repository->getRevenueByPaymentMethod($start, $end),
            'paymentMethodsTable' => $this->repository->getRevenueByPaymentMethod($start, $end),
            'filter' => $filter,
            'start' => $start,
            'end' => $end,
        ];
    }

    /**
     * Get ebook performance report
     */
    public function getEbookPerformanceReport(string $sortBy = 'reads'): array
    {
        return [
            'topEbooks' => $this->repository->getTopPerformingEbooks($sortBy, 20),
            'lowPerformingEbooks' => $this->repository->getLowPerformingEbooks(10, 10),
            'ebooksByCreator' => $this->repository->getEbooksByCreator(10),
            ...$this->repository->getEbookStatistics(),
            'sortBy' => $sortBy,
        ];
    }

    /**
     * Get user analytics report
     */
    public function getUserAnalyticsReport(string $filter, ?string $startDate = null, ?string $endDate = null): array
    {
        $dateRange = $this->getDateRange($filter, $startDate, $endDate);
        $start = $dateRange['start'];
        $end = $dateRange['end'];

        return [
            'userGrowth' => $this->repository->getUserGrowth($start, $end),
            ...$this->repository->getUserStatistics(),
            'filter' => $filter,
            'start' => $start,
            'end' => $end,
        ];
    }

    /**
     * Get subscription report
     */
    public function getSubscriptionReport(string $filter, ?string $startDate = null, ?string $endDate = null): array
    {
        $dateRange = $this->getDateRange($filter, $startDate, $endDate);
        $start = $dateRange['start'];
        $end = $dateRange['end'];

        return [
            ...$this->repository->getSubscriptionStatistics($start, $end),
            'revenueByPlan' => $this->repository->getRevenueByPlan($start, $end),
            'filter' => $filter,
            'start' => $start,
            'end' => $end,
        ];
    }

    /**
     * Get category distribution
     */
    public function getCategoryDistribution()
    {
        return $this->repository->getCategoryDistribution();
    }

    /**
     * Get city distribution
     */
    public function getCityDistribution()
    {
        return $this->repository->getCityDistribution();
    }

    /**
     * Get dashboard summary
     */
    public function getDashboardSummary(): array
    {
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        return [
            'ebook_stats' => $this->repository->getEbookStatistics(),
            'user_stats' => $this->repository->getUserStatistics(),
            'monthly_revenue' => $this->repository->getTotalRevenue($startOfMonth, $endOfMonth),
            'today_revenue' => $this->repository->getTotalRevenue($today, $today->copy()->endOfDay()),
        ];
    }
}
