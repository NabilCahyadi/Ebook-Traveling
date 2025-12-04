<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PermissionService;
use App\Services\RoleService;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    protected $permissionService;
    protected $roleService;

    public function __construct(PermissionService $permissionService, RoleService $roleService)
    {
        $this->permissionService = $permissionService;
        $this->roleService = $roleService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = $this->roleService->getAllRoles(100);
        $resources = $this->permissionService->getAvailableResources();
        $permissions = $this->permissionService->getAllGroupedByRole();

        return view('admin.permissions.index', compact('roles', 'resources', 'permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $roleId)
    {
        $role = $this->roleService->getRoleById($roleId);
        $permissions = $this->permissionService->getPermissionsByRole($roleId);
        $resources = $this->permissionService->getAvailableResources();

        return view('admin.permissions.edit', compact('role', 'permissions', 'resources'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $roleId)
    {
        $validated = $request->validate([
            'permissions' => 'required|array',
            'permissions.*.resource' => 'required|string',
            'permissions.*.can_create' => 'boolean',
            'permissions.*.can_read' => 'boolean',
            'permissions.*.can_update' => 'boolean',
            'permissions.*.can_delete' => 'boolean',
        ]);

        try {
            $this->permissionService->syncRolePermissions($roleId, $validated['permissions']);

            return redirect()->route('admin.permissions.index')
                ->with('success', 'Permissions updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update permissions: ' . $e->getMessage());
        }
    }
}
