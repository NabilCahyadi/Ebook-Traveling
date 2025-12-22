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
     * 
     * @deprecated This controller is deprecated. Use RolePermissionController instead.
     */
    public function index()
    {
        // DISABLED: Redirect to new permission system
        return redirect()->route('admin.role-permissions.index')
            ->with('info', 'This permission management page has been replaced. Please use Role Permissions instead.');
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * @deprecated This controller is deprecated. Use RolePermissionController instead.
     */
    public function edit(string $roleId)
    {
        // DISABLED: Redirect to new permission system
        return redirect()->route('admin.role-permissions.index')
            ->with('info', 'This permission management page has been replaced. Please use Role Permissions instead.');
    }

    /**
     * Update the specified resource in storage.
     * 
     * @deprecated This controller is deprecated. Use RolePermissionController instead.
     */
    public function update(Request $request, string $roleId)
    {
        // DISABLED: Redirect to new permission system
        return redirect()->route('admin.role-permissions.index')
            ->with('error', 'This permission management page is deprecated. Please use Role Permissions instead.');
        
        /* OLD CODE - DISABLED
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
        */
    }
}
