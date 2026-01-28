<?php

namespace App\Repositories\AdminManagement;

use App\Models\Admin;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminRepository
{
    /**
     * Get all admins with filters
     */
    public function getAllWithFilters(?string $search = null, ?string $type = null, int $perPage = 15): LengthAwarePaginator
    {
        return Admin::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->when($type, function ($query, $type) {
                $query->where('type', $type);
            })
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Find admin by ID
     */
    public function findById(string $id): ?Admin
    {
        return Admin::find($id);
    }

    /**
     * Find admin by ID or fail
     */
    public function findOrFail(string $id): Admin
    {
        return Admin::findOrFail($id);
    }

    /**
     * Find admin by email
     */
    public function findByEmail(string $email): ?Admin
    {
        return Admin::where('email', $email)->first();
    }

    /**
     * Create new admin
     */
    public function create(array $data): Admin
    {
        return Admin::create($data);
    }

    /**
     * Update admin
     */
    public function update(Admin $admin, array $data): bool
    {
        return $admin->update($data);
    }

    /**
     * Delete admin
     */
    public function delete(Admin $admin): bool
    {
        return $admin->delete();
    }

    /**
     * Check if email exists (excluding specific admin)
     */
    public function emailExists(string $email, ?int $excludeId = null): bool
    {
        return Admin::where('email', $email)
            ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
            ->exists();
    }

    /**
     * Get admin count by type
     */
    public function getCountByType(?string $type = null): int
    {
        return Admin::when($type, fn($q) => $q->where('type', $type))->count();
    }

    /**
     * Get all admins for export
     */
    public function getAllForExport(?string $search = null, ?string $type = null)
    {
        return Admin::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->when($type, function ($query, $type) {
                $query->where('type', $type);
            })
            ->latest()
            ->get();
    }

    /**
     * Get all trashed admins with filters
     */
    public function getTrashedWithFilters(?string $search = null, ?string $type = null, int $perPage = 5): LengthAwarePaginator
    {
        return Admin::onlyTrashed()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->when($type, function ($query, $type) {
                $query->where('type', $type);
            })
            ->latest('deleted_at')
            ->paginate($perPage);
    }

    /**
     * Find trashed admin by ID or fail
     */
    public function findTrashedOrFail(string $id): Admin
    {
        return Admin::onlyTrashed()->findOrFail($id);
    }

    /**
     * Restore trashed admin
     */
    public function restore(Admin $admin): bool
    {
        return $admin->restore();
    }

    /**
     * Force delete admin permanently
     */
    public function forceDelete(Admin $admin): bool
    {
        return $admin->forceDelete();
    }

    /**
     * Get trashed admins count
     */
    public function getTrashedCount(): int
    {
        return Admin::onlyTrashed()->count();
    }
}
