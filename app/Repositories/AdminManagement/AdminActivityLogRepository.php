<?php

namespace App\Repositories\AdminManagement;

use App\Models\AdminActivityLog;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

class AdminActivityLogRepository
{
    /**
     * Get all activity logs with filters
     */
    public function getAllWithFilters(array $filters = [], int $perPage = 20): LengthAwarePaginator
    {
        $query = AdminActivityLog::with('admin');

        // Filter by admin
        if (!empty($filters['admin_id'])) {
            $query->where('admin_id', $filters['admin_id']);
        }

        // Filter by action type
        if (!empty($filters['action_type'])) {
            $query->where('action_type', $filters['action_type']);
        }

        // Filter by module
        if (!empty($filters['module'])) {
            $query->where('module', $filters['module']);
        }

        // Filter by date range
        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }
        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        // Search
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhereHas('admin', function ($adminQuery) use ($search) {
                      $adminQuery->where('name', 'like', "%{$search}%")
                                 ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        return $query->latest()->paginate($perPage);
    }

    /**
     * Find activity log by ID
     */
    public function findById(int $id): ?AdminActivityLog
    {
        return AdminActivityLog::with('admin')->find($id);
    }

    /**
     * Find activity log by ID or fail
     */
    public function findOrFail(int $id): AdminActivityLog
    {
        return AdminActivityLog::with('admin')->findOrFail($id);
    }

    /**
     * Create activity log
     */
    public function create(array $data): AdminActivityLog
    {
        return AdminActivityLog::create($data);
    }

    /**
     * Delete old logs (cleanup)
     */
    public function deleteOlderThan(Carbon $date): int
    {
        return AdminActivityLog::where('created_at', '<', $date)->delete();
    }

    /**
     * Get unique action types
     */
    public function getUniqueActionTypes(): Collection
    {
        return AdminActivityLog::distinct()->pluck('action_type');
    }

    /**
     * Get unique modules
     */
    public function getUniqueModules(): Collection
    {
        return AdminActivityLog::distinct()->pluck('module');
    }

    /**
     * Get logs for export
     */
    public function getAllForExport(array $filters = []): Collection
    {
        $query = AdminActivityLog::with('admin');

        if (!empty($filters['admin_id'])) {
            $query->where('admin_id', $filters['admin_id']);
        }

        if (!empty($filters['action_type'])) {
            $query->where('action_type', $filters['action_type']);
        }

        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        return $query->latest()->get();
    }

    /**
     * Get recent activity for dashboard
     */
    public function getRecentActivity(int $limit = 10): Collection
    {
        return AdminActivityLog::with('admin')
            ->latest()
            ->limit($limit)
            ->get();
    }
}
