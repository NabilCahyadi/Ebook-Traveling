<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface PermissionRepositoryInterface
{
    /**
     * Get all permissions with pagination.
     */
    public function getAllPaginated(int $perPage = 15): mixed;

    /**
     * Get permissions by role ID.
     */
    public function getByRoleId(string $roleId): Collection;

    /**
     * Find permission by ID.
     */
    public function findById(string $id): mixed;

    /**
     * Create new permission.
     */
    public function create(array $data): mixed;

    /**
     * Update permission.
     */
    public function update(string $id, array $data): bool;

    /**
     * Delete permission.
     */
    public function delete(string $id): bool;

    /**
     * Sync permissions for a role.
     */
    public function syncRolePermissions(string $roleId, array $permissions): void;

    /**
     * Get all resources with their permissions grouped by role.
     */
    public function getAllGroupedByRole(): Collection;
}
