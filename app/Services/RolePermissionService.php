<?php

namespace App\Services;

use App\Models\Role;
use App\Repositories\Interfaces\PermissionRepositoryInterface;

class RolePermissionService
{
    protected $permissionRepository;

    public function __construct(PermissionRepositoryInterface $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    public function getAllRolesWithPermissions()
    {
        return Role::with('permissions')
            ->whereNotIn('slug', ['admin'])
            ->orderByRaw("CASE WHEN slug = 'guest' THEN 0 ELSE 1 END")
            ->orderBy('name')
            ->get();
    }

    public function updateRolePermissions(Role $role, array $permissionNames)
    {
        $permissions = $this->permissionRepository->findByNames($permissionNames);
        $role->permissions()->sync($permissions->pluck('id'));
    }

    public function getPermissionModules()
    {
        // Get permissions from database, grouped by 'group' column
        $permissions = \App\Models\Permission::orderBy('group')->orderBy('display_name')->get();
        
        $modules = [];
        
        foreach ($permissions->groupBy('group') as $groupName => $groupPermissions) {
            $modules[] = [
                'name' => $groupName,
                'permissions' => $groupPermissions->map(function($permission) {
                    return [
                        'name' => $permission->name,
                        'label' => $permission->display_name,
                        'description' => $permission->description,
                    ];
                })->toArray()
            ];
        }
        
        return $modules;
    }
}
