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
        // Get only panel permissions (for /panel dynamic access)
        // Group by 'group' (module name) and sub-group by 'module' (page name)
        $permissions = \App\Models\Permission::where('name', 'like', 'panel.%')
            ->orderBy('group')
            ->orderBy('module')
            ->orderBy('display_name')
            ->get();
        
        $modules = [];
        
        // Group permissions by module (group column)
        foreach ($permissions->groupBy('group') as $groupName => $groupPermissions) {
            // Sub-group by page (module column) within each module
            $pages = [];
            foreach ($groupPermissions->groupBy('module') as $moduleName => $modulePermissions) {
                $pages[] = [
                    'name' => ucfirst(str_replace('_', ' ', $moduleName)),
                    'permissions' => $modulePermissions->map(function($permission) {
                        return [
                            'name' => $permission->name,
                            'label' => $permission->display_name,
                            'description' => $permission->description,
                        ];
                    })->toArray()
                ];
            }
            
            $modules[] = [
                'name' => $groupName,
                'pages' => $pages
            ];
        }
        
        return $modules;
    }
}
