<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Exports\AdminsExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
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
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->checkSuperAdmin();

        $search = $request->input('search');
        $type = $request->input('type');

        $admins = Admin::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->when($type, function ($query, $type) {
                $query->where('type', $type);
            })
            ->latest()
            ->paginate(15);

        return view('admin.admins.index', compact('admins', 'search', 'type'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->checkSuperAdmin();
        return view('admin.admins.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->checkSuperAdmin();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'type' => ['required', Rule::in([Admin::TYPE_ADMIN])],
            'status' => 'required|in:active,inactive',
        ]);

        // Force type to admin only
        $validated['type'] = Admin::TYPE_ADMIN;
        $validated['password'] = Hash::make($validated['password']);

        $admin = Admin::create($validated);

        return redirect()->route('admin.admins.permissions.edit', $admin->id)
            ->with('success', 'Admin berhasil ditambahkan! Silakan atur permission untuk admin ini.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $this->checkSuperAdmin();
        $admin = Admin::findOrFail($id);
        return view('admin.admins.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->checkSuperAdmin();
        $admin = Admin::findOrFail($id);
        return view('admin.admins.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->checkSuperAdmin();
        $admin = Admin::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('admins')->ignore($admin->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'type' => ['required', Rule::in([Admin::TYPE_ADMIN, Admin::TYPE_SUPERADMIN])],
            'status' => 'required|in:active,inactive',
        ]);

        // Prevent changing type to superadmin if currently not superadmin
        if ($admin->type !== Admin::TYPE_SUPERADMIN && $validated['type'] === Admin::TYPE_SUPERADMIN) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Cannot change admin type to Super Admin.');
        }

        // Keep the original type (don't allow type changes)
        $validated['type'] = $admin->type;

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $admin->update($validated);

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->checkSuperAdmin();
        
        $admin = Admin::findOrFail($id);
        
        // Prevent deleting yourself
        if (auth('admin')->id() === $admin->id) {
            return redirect()->route('admin.admins.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        $admin->delete();

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin berhasil dihapus!');
    }

    /**
     * Export admins to Excel.
     */
    public function export(Request $request)
    {
        $this->checkSuperAdmin();

        $filters = [
            'search' => $request->get('search'),
            'is_active' => $request->get('is_active'),
            'date_from' => $request->get('date_from'),
            'date_to' => $request->get('date_to'),
        ];

        $filename = 'admins_' . now()->format('Y-m-d_His') . '.xlsx';
        
        return Excel::download(new AdminsExport($filters), $filename);
    }
}
