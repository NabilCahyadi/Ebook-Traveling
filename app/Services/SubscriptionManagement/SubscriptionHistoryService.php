<?php

namespace App\Services\SubscriptionManagement;

use App\Repositories\SubscriptionManagement\SubscriptionHistoryRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class SubscriptionHistoryService
{
    protected SubscriptionHistoryRepository $repository;

    public function __construct(SubscriptionHistoryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get subscription history with filters
     */
    public function getHistory(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->getAllWithFilters($filters, $perPage);
    }

    /**
     * Get user subscription history
     */
    public function getUserHistory(int $userId, int $perPage = 10): LengthAwarePaginator
    {
        return $this->repository->getUserHistory($userId, $perPage);
    }

    /**
     * Find subscription by code
     */
    public function findByCode(string $code)
    {
        return $this->repository->findByCode($code);
    }

    /**
     * Get statistics
     */
    public function getStatistics(array $dateRange = []): array
    {
        return $this->repository->getStatistics($dateRange);
    }

    /**
     * Get for export
     */
    public function getForExport(array $filters = []): Collection
    {
        return $this->repository->getAllForExport($filters);
    }

    /**
     * Get filter options
     */
    public function getFilterOptions(): array
    {
        return [
            'statuses' => ['all', 'active', 'expired', 'cancelled', 'pending'],
            'plans' => \App\Models\SubscriptionPlan::select('id', 'name')
                ->where('is_active', true)
                ->orderBy('name')
                ->get(),
        ];
    }
}
