<?php

namespace App\Http\Controllers\Admin\AdminManagement;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Services\AdminManagement\AdminService;
use App\Exports\AdminsExport;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    protected AdminService $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->adminService->authorizeSuperAdmin();

        $search = $request->input('search');
        $type = $request->input('type');

        $admins = $this->adminService->getAllAdmins($search, $type, 5);

        return view('admin.admin.admin-list.index', compact('admins', 'search', 'type'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->adminService->authorizeSuperAdmin();
        return view('admin.admin.admin-list.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->adminService->authorizeSuperAdmin();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'type' => ['required', Rule::in([Admin::TYPE_ADMIN, Admin::TYPE_SUPERADMIN])],
        ]);

        // Set status to active by default
        $validated['status'] = 'active';

        $admin = $this->adminService->createAdmin($validated);

        // If superadmin, redirect directly to admin list (superadmin has all permissions by default)
        if ($admin->type === Admin::TYPE_SUPERADMIN) {
            return redirect()->route('admin.admins.index')
                ->with('success', 'Super Admin berhasil ditambahkan!');
        }

        return redirect()->route('admin.admins.permissions.edit', $admin->id)
            ->with('success', 'Admin berhasil ditambahkan! Silakan atur permission untuk admin ini.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $this->adminService->authorizeSuperAdmin();
        $admin = $this->adminService->findOrFail($id);
        return view('admin.admin.admin-list.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->adminService->authorizeSuperAdmin();
        $admin = $this->adminService->findOrFail($id);
        return view('admin.admin.admin-list.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->adminService->authorizeSuperAdmin();
        $admin = $this->adminService->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('admins')->ignore($admin->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'type' => ['required', Rule::in([Admin::TYPE_ADMIN, Admin::TYPE_SUPERADMIN])],
            'status' => 'required|in:active,inactive',
        ]);

        $this->adminService->updateAdmin($admin, $validated);

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->adminService->authorizeSuperAdmin();
        
        $admin = $this->adminService->findOrFail($id);
        
        try {
            $this->adminService->deleteAdmin($admin);
            return redirect()->route('admin.admins.index')
                ->with('success', 'Admin berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('admin.admins.index')
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Export admins to Excel.
     */
    public function export(Request $request)
    {
        $this->adminService->authorizeSuperAdmin();

        $filters = [
            'search' => $request->get('search'),
            'is_active' => $request->get('is_active'),
            'date_from' => $request->get('date_from'),
            'date_to' => $request->get('date_to'),
        ];

        $filename = 'admins_' . now()->format('Y-m-d_His') . '.xlsx';
        
        return Excel::download(new AdminsExport($filters), $filename);
    }

    /**
     * Display a listing of trashed admins.
     */
    public function trashed(Request $request)
    {
        $this->adminService->authorizeSuperAdmin();

        $search = $request->input('search');
        $type = $request->input('type');

        $admins = $this->adminService->getTrashedAdmins($search, $type, 5);

        return view('admin.admin.admin-list.trashed', compact('admins', 'search', 'type'));
    }

    /**
     * Restore a trashed admin.
     */
    public function restore(string $id)
    {
        $this->adminService->authorizeSuperAdmin();

        try {
            $this->adminService->restoreAdmin($id);
            return redirect()->route('admin.admins.trashed')
                ->with('success', __('admin.admins.restore_success'));
        } catch (\Exception $e) {
            return redirect()->route('admin.admins.trashed')
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Permanently delete a trashed admin.
     */
    public function forceDelete(string $id)
    {
        $this->adminService->authorizeSuperAdmin();

        try {
            $this->adminService->forceDeleteAdmin($id);
            return redirect()->route('admin.admins.trashed')
                ->with('success', __('admin.admins.force_delete_success'));
        } catch (\Exception $e) {
            return redirect()->route('admin.admins.trashed')
                ->with('error', $e->getMessage());
        }
    }
}
