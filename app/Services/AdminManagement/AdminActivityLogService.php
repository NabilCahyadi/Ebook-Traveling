<?php

namespace App\Services\AdminManagement;

use App\Repositories\AdminManagement\AdminActivityLogRepository;
use App\Models\Admin;
use App\Models\AdminActivityLog;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

class AdminActivityLogService
{
    protected AdminActivityLogRepository $repository;

    public function __construct(AdminActivityLogRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get all activity logs with filters
     */
    public function getActivityLogs(array $filters = [], int $perPage = 20): LengthAwarePaginator
    {
        return $this->repository->getAllWithFilters($filters, $perPage);
    }

    /**
     * Get activity log by ID
     */
    public function findById(int $id): ?AdminActivityLog
    {
        return $this->repository->findById($id);
    }

    /**
     * Get activity log by ID or fail
     */
    public function findOrFail(int $id): AdminActivityLog
    {
        return $this->repository->findOrFail($id);
    }

    /**
     * Log admin activity
     */
    public function logActivity(
        int $adminId,
        string $actionType,
        string $module,
        string $description,
        ?array $oldData = null,
        ?array $newData = null,
        ?string $ipAddress = null,
        ?string $userAgent = null
    ): AdminActivityLog {
        return $this->repository->create([
            'admin_id' => $adminId,
            'action_type' => $actionType,
            'module' => $module,
            'description' => $description,
            'old_data' => $oldData ? json_encode($oldData) : null,
            'new_data' => $newData ? json_encode($newData) : null,
            'ip_address' => $ipAddress ?? request()->ip(),
            'user_agent' => $userAgent ?? request()->userAgent(),
        ]);
    }

    /**
     * Cleanup old logs
     */
    public function cleanupOldLogs(int $daysToKeep = 90): int
    {
        $cutoffDate = Carbon::now()->subDays($daysToKeep);
        return $this->repository->deleteOlderThan($cutoffDate);
    }

    /**
     * Get filter options
     */
    public function getFilterOptions(): array
    {
        return [
            'action_types' => $this->repository->getUniqueActionTypes(),
            'modules' => $this->repository->getUniqueModules(),
            'admins' => Admin::select('id', 'name')->orderBy('name')->get(),
        ];
    }

    /**
     * Get logs for export
     */
    public function getLogsForExport(array $filters = []): Collection
    {
        return $this->repository->getAllForExport($filters);
    }

    /**
     * Get recent activity for dashboard
     */
    public function getRecentActivity(int $limit = 10): Collection
    {
        return $this->repository->getRecentActivity($limit);
    }
}
