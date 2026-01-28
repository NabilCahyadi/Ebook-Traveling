<?php

namespace App\Http\Controllers\Admin\UserManagement;

use App\Http\Controllers\Controller;
use App\Services\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $showTrashed = $request->get('show_trashed', false);
        $roles = $this->roleService->getAllRoles(15, null, $showTrashed);
        return view('admin.user-management.roles.index', compact('roles', 'showTrashed'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user-management.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'nullable|string|max:100|unique:roles,slug',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        try {
            $this->roleService->createRole($validated);

            return redirect()->route('admin.roles.index')
                ->with('success', 'Role created successfully!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Failed to create role: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = $this->roleService->getRoleById($id);

        if (!$role) {
            return back()->with('error', 'Role not found!');
        }

        return view('admin.user-management.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = $this->roleService->getRoleById($id);

        if (!$role) {
            return back()->with('error', 'Role not found!');
        }

        return view('admin.user-management.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'nullable|string|max:100|unique:roles,slug,' . $id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        try {
            $this->roleService->updateRole($id, $validated);

            return redirect()->route('admin.roles.index')
                ->with('success', 'Role updated successfully!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Failed to update role: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->roleService->deleteRole($id);

            return redirect()->route('admin.roles.index')
                ->with('success', 'Role moved to trash successfully!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Restore the specified resource from trash.
     */
    public function restore(string $id)
    {
        try {
            $this->roleService->restoreRole($id);

            return redirect()->route('admin.roles.index')
                ->with('success', 'Role restored successfully!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Permanently delete the specified resource.
     */
    public function forceDelete(string $id)
    {
        try {
            $this->roleService->forceDeleteRole($id);

            return redirect()->route('admin.roles.index')
                ->with('success', 'Role permanently deleted!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display trashed roles.
     */
    public function trashed(Request $request)
    {
        $roles = $this->roleService->getTrashedRoles(15);
        return view('admin.user-management.roles.trashed', compact('roles'));
    }
}
