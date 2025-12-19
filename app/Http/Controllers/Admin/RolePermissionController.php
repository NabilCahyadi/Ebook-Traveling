<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Services\RolePermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolePermissionController extends Controller
{
    protected $rolePermissionService;

    public function __construct(RolePermissionService $rolePermissionService)
    {
        $this->rolePermissionService = $rolePermissionService;
    }

    public function index()
    {
        $roles = $this->rolePermissionService->getAllRolesWithPermissions();

        return view('admin.role-permissions.index', compact('roles'));
    }

    public function edit(Role $role)
    {
        // Prevent editing admin role permissions
        if ($role->slug === 'admin') {
            return redirect()
                ->route('admin.role-permissions.index')
                ->with('error', 'Cannot edit admin role permissions');
        }

        $permissionModules = $this->rolePermissionService->getPermissionModules();
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        
        // Add special note for Guest role
        $isGuestRole = $role->slug === 'guest';

        return view('admin.role-permissions.edit', compact('role', 'permissionModules', 'rolePermissions', 'isGuestRole'));
    }

    public function update(Request $request, Role $role)
    {
        // Prevent editing admin role permissions
        if ($role->slug === 'admin') {
            return redirect()
                ->route('admin.role-permissions.index')
                ->with('error', 'Cannot edit admin role permissions');
        }

        $permissions = $request->input('permissions', []);

        try {
            DB::beginTransaction();

            $this->rolePermissionService->updateRolePermissions($role, $permissions);

            DB::commit();

            return redirect()
                ->back()
                ->with('success', 'Role permissions updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', 'Failed to update role permissions: ' . $e->getMessage());
        }
    }
}
