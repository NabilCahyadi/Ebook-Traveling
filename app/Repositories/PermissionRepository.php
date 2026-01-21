<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Models\RolePermission;
use App\Repositories\Interfaces\PermissionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
     * 
     * WARNING: This method is for the OLD permission system (role_permissions table).
     * The NEW permission system uses role_permission pivot table.
     * This method is DEPRECATED and should not be used.
     * 
     * @deprecated Use RolePermissionService::updateRolePermissions() instead
     */
    public function syncRolePermissions(string $roleId, array $permissions): void
    {
        // DISABLED: This method is deprecated to prevent conflicts with the new permission system
        // If you need to manage permissions, please use the Role Permissions page
        // at /admin/role-permissions instead of /admin/permissions
        
        Log::warning('Deprecated method syncRolePermissions called', [
            'role_id' => $roleId,
            'permissions_count' => count($permissions),
            'stack_trace' => debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 5)
        ]);
        
        throw new \Exception('This permission management method is deprecated. Please use /admin/role-permissions instead.');
        
        /* OLD CODE - COMMENTED OUT TO PREVENT DATA LOSS
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
        */
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

    /**
     * Find permissions by names.
     */
    public function findByNames(array $names): Collection
    {
        return Permission::whereIn('name', $names)->get();
    }
}
