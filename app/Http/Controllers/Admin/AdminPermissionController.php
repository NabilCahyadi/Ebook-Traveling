<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminPermission;
use Illuminate\Http\Request;

class AdminPermissionController extends Controller
{
    /**
     * Check if current admin is superadmin
     */
    private function checkSuperAdmin()
    {
        if (!auth('admin')->check() || auth('admin')->user()->type !== 'superadmin') {
            abort(403, 'Hanya Super Admin yang dapat mengakses halaman ini.');
        }
    }

    /**
     * Show the form for managing admin permissions.
     */
    public function edit(string $id)
    {
        $this->checkSuperAdmin();

        $admin = Admin::with('permissions')->findOrFail($id);
        
        // Prevent editing superadmin permissions
        if ($admin->isSuperAdmin()) {
            return redirect()->route('admin.admins.index')
                ->with('error', 'Tidak dapat mengatur permission untuk Super Admin. Super Admin memiliki semua akses.');
        }

        // Get all permissions grouped by module and sub_module
        $permissions = AdminPermission::orderBy('sort_order')
            ->orderBy('module')
            ->orderBy('sub_module')
            ->orderBy('display_name')
            ->get()
            ->groupBy('module')
            ->map(function ($modulePermissions) {
                return $modulePermissions->groupBy('sub_module');
            });
        
        // Get current admin permission IDs
        $adminPermissions = $admin->permissions->pluck('id')->toArray();

        return view('admin.admins.permissions', compact('admin', 'permissions', 'adminPermissions'));
    }

    /**
     * Update the admin permissions.
     */
    public function update(Request $request, string $id)
    {
        $this->checkSuperAdmin();

        $admin = Admin::findOrFail($id);

        // Prevent editing superadmin permissions
        if ($admin->isSuperAdmin()) {
            return redirect()->route('admin.admins.index')
                ->with('error', 'Tidak dapat mengatur permission untuk Super Admin.');
        }

        $validated = $request->validate([
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:admin_permissions,id',
        ]);

        // Sync permissions (empty array if none selected)
        $admin->syncPermissions($validated['permissions'] ?? []);

        return redirect()->route('admin.admins.index')
            ->with('success', 'Permission admin berhasil diperbarui!');
    }
}
