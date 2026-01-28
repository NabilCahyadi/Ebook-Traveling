<?php

namespace App\Http\Controllers\Admin\AdminManagement;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPermissionMatrixController extends Controller
{
    /**
     * Display the permissions matrix.
     */
    public function index(Request $request)
    {
        // Get all admins with their permissions
        $admins = Admin::with('permissions')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->get();

        // Get all permissions grouped by group
        $permissions = AdminPermission::orderBy('group')
            ->orderBy('name')
            ->get()
            ->groupBy('group');

        // Get permission templates/presets
        $templates = $this->getPermissionTemplates();

        return view('admin.admin-permissions-matrix.index', compact('admins', 'permissions', 'templates'));
    }

    /**
     * Update admin permissions via AJAX.
     */
    public function updatePermission(Request $request)
    {
        $request->validate([
            'admin_id' => 'required|exists:admins,id',
            'permission_id' => 'required|exists:admin_permissions,id',
            'action' => 'required|in:attach,detach'
        ]);

        $admin = Admin::findOrFail($request->admin_id);
        $permission = AdminPermission::findOrFail($request->permission_id);

        if ($request->action === 'attach') {
            $admin->permissions()->syncWithoutDetaching([$request->permission_id]);
            $message = "Permission '{$permission->name}' granted to {$admin->name}";
        } else {
            $admin->permissions()->detach($request->permission_id);
            $message = "Permission '{$permission->name}' revoked from {$admin->name}";
        }

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    /**
     * Bulk update permissions for multiple admins.
     */
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'admin_ids' => 'required|array',
            'admin_ids.*' => 'exists:admins,id',
            'permission_ids' => 'required|array',
            'permission_ids.*' => 'exists:admin_permissions,id',
            'action' => 'required|in:attach,detach'
        ]);

        $affected = 0;

        DB::beginTransaction();
        try {
            foreach ($request->admin_ids as $adminId) {
                $admin = Admin::findOrFail($adminId);

                if ($request->action === 'attach') {
                    $admin->permissions()->syncWithoutDetaching($request->permission_ids);
                } else {
                    $admin->permissions()->detach($request->permission_ids);
                }
                $affected++;
            }

            DB::commit();

            $action = $request->action === 'attach' ? 'granted to' : 'revoked from';
            $message = count($request->permission_ids) . " permission(s) {$action} {$affected} admin(s)";

            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update permissions: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Apply permission template to admin(s).
     */
    public function applyTemplate(Request $request)
    {
        $request->validate([
            'admin_ids' => 'required|array',
            'admin_ids.*' => 'exists:admins,id',
            'template' => 'required|string'
        ]);

        $templates = $this->getPermissionTemplates();

        if (!isset($templates[$request->template])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid template'
            ], 400);
        }

        $template = $templates[$request->template];
        $permissionNames = $template['permissions'];

        // Get permission IDs from names
        $permissions = AdminPermission::whereIn('name', $permissionNames)->pluck('id')->toArray();

        if (empty($permissions)) {
            return response()->json([
                'success' => false,
                'message' => 'No valid permissions found for this template'
            ], 400);
        }

        DB::beginTransaction();
        try {
            foreach ($request->admin_ids as $adminId) {
                $admin = Admin::findOrFail($adminId);

                if ($template['mode'] === 'replace') {
                    // Replace all permissions
                    $admin->permissions()->sync($permissions);
                } else {
                    // Add to existing permissions
                    $admin->permissions()->syncWithoutDetaching($permissions);
                }
            }

            DB::commit();

            $message = "Template '{$template['name']}' applied to " . count($request->admin_ids) . " admin(s)";

            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to apply template: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Copy permissions from one admin to another.
     */
    public function copyPermissions(Request $request)
    {
        $request->validate([
            'source_admin_id' => 'required|exists:admins,id',
            'target_admin_ids' => 'required|array',
            'target_admin_ids.*' => 'exists:admins,id',
            'mode' => 'required|in:replace,merge'
        ]);

        $sourceAdmin = Admin::with('permissions')->findOrFail($request->source_admin_id);
        $permissionIds = $sourceAdmin->permissions->pluck('id')->toArray();

        DB::beginTransaction();
        try {
            foreach ($request->target_admin_ids as $targetAdminId) {
                $targetAdmin = Admin::findOrFail($targetAdminId);

                if ($request->mode === 'replace') {
                    $targetAdmin->permissions()->sync($permissionIds);
                } else {
                    $targetAdmin->permissions()->syncWithoutDetaching($permissionIds);
                }
            }

            DB::commit();

            $message = "Permissions copied from {$sourceAdmin->name} to " . count($request->target_admin_ids) . " admin(s)";

            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to copy permissions: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get permission templates/presets.
     */
    private function getPermissionTemplates()
    {
        return [
            'content_manager' => [
                'name' => 'Content Manager',
                'description' => 'Can manage ebooks, categories, and blogs',
                'icon' => 'ti-book',
                'mode' => 'replace',
                'permissions' => [
                    'access_ebooks',
                    'create_ebooks',
                    'edit_ebooks',
                    'delete_ebooks',
                    'access_categories',
                    'manage_categories',
                    'access_blog',
                    'manage_blog',
                ]
            ],
            'user_manager' => [
                'name' => 'User Manager',
                'description' => 'Can manage users and subscriptions',
                'icon' => 'ti-users',
                'mode' => 'replace',
                'permissions' => [
                    'access_users',
                    'create_users',
                    'edit_users',
                    'delete_users',
                    'access_subscriptions',
                    'manage_subscriptions',
                    'access_orders',
                ]
            ],
            'financial_manager' => [
                'name' => 'Financial Manager',
                'description' => 'Can manage orders, payments, and subscriptions',
                'icon' => 'ti-currency-dollar',
                'mode' => 'replace',
                'permissions' => [
                    'access_orders',
                    'manage_orders',
                    'access_payments',
                    'access_subscriptions',
                    'manage_subscriptions',
                    'access_promos',
                    'manage_promos',
                ]
            ],
            'readonly_access' => [
                'name' => 'Read-Only Access',
                'description' => 'View-only access to all modules',
                'icon' => 'ti-eye',
                'mode' => 'replace',
                'permissions' => [
                    'access_ebooks',
                    'access_users',
                    'access_categories',
                    'access_blog',
                    'access_destinations',
                    'access_orders',
                    'access_subscriptions',
                ]
            ],
            'full_access' => [
                'name' => 'Full Access',
                'description' => 'Complete access to all features',
                'icon' => 'ti-lock-open',
                'mode' => 'replace',
                'permissions' => 'all' // Special case: all permissions
            ]
        ];
    }

    /**
     * Export permissions matrix to CSV.
     */
    public function export()
    {
        $admins = Admin::with('permissions')->orderBy('name')->get();
        $allPermissions = AdminPermission::orderBy('group')->orderBy('name')->get();

        $filename = 'admin-permissions-matrix-' . now()->format('Y-m-d-His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($admins, $allPermissions) {
            $file = fopen('php://output', 'w');

            // CSV headers
            $headerRow = ['Admin Name', 'Email'];
            foreach ($allPermissions as $permission) {
                $headerRow[] = $permission->name;
            }
            fputcsv($file, $headerRow);

            // Data rows
            foreach ($admins as $admin) {
                $row = [$admin->name, $admin->email];
                foreach ($allPermissions as $permission) {
                    $hasPermission = $admin->permissions->contains('id', $permission->id);
                    $row[] = $hasPermission ? 'Yes' : 'No';
                }
                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
