<?php

namespace App\Repositories;

use App\Models\RolePermission;
use App\Repositories\Interfaces\PermissionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class PermissionRepository implements PermissionRepositoryInterface
{
    /**
     * Get all permissions with pagination.
     */
    public function getAllPaginated(int $perPage = 15): mixed
    {
        return RolePermission::with('role')
            ->orderBy('role_id')
            ->orderBy('resource')
            ->paginate($perPage);
    }

    /**
     * Get permissions by role ID.
     */
    public function getByRoleId(string $roleId): Collection
    {
        return RolePermission::where('role_id', $roleId)
            ->orderBy('resource')
            ->get();
    }

    /**
     * Find permission by ID.
     */
    public function findById(string $id): mixed
    {
        return RolePermission::with('role')->find($id);
    }

    /**
     * Create new permission.
     */
    public function create(array $data): mixed
    {
        return RolePermission::create($data);
    }

    /**
     * Update permission.
     */
    public function update(string $id, array $data): bool
    {
        $permission = RolePermission::find($id);
        if ($permission) {
            return $permission->update($data);
        }
        return false;
    }

    /**
     * Delete permission.
     */
    public function delete(string $id): bool
    {
        $permission = RolePermission::find($id);
        if ($permission) {
            return $permission->delete();
        }
        return false;
    }

    /**
     * Sync permissions for a role.
     */
    public function syncRolePermissions(string $roleId, array $permissions): void
    {
        DB::transaction(function () use ($roleId, $permissions) {
            // Delete existing permissions for this role
            RolePermission::where('role_id', $roleId)->delete();

            // Insert new permissions
            foreach ($permissions as $permission) {
                if (!empty($permission['resource'])) {
                    RolePermission::create([
                        'role_id' => $roleId,
                        'resource' => $permission['resource'],
                        'action' => $permission['action'] ?? null,
                        'can_create' => $permission['can_create'] ?? false,
                        'can_read' => $permission['can_read'] ?? false,
                        'can_update' => $permission['can_update'] ?? false,
                        'can_delete' => $permission['can_delete'] ?? false,
                    ]);
                }
            }
        });
    }

    /**
     * Get all resources with their permissions grouped by role.
     */
    public function getAllGroupedByRole(): Collection
    {
        return RolePermission::with('role')
            ->get()
            ->groupBy('role_id');
    }
}
