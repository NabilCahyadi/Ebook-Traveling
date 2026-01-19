<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $roleSlug = $request->get('role');
        $userType = $request->get('user_type');
        $search = $request->get('search');
        $showTrashed = $request->get('show_trashed', false);
        $googleId = $request->get('google_id');
        $registered = $request->get('registered');

        // Get all roles for filter dropdown
        $roles = \App\Models\Role::all();

        // Validate role exists if provided
        if ($roleSlug && $roleSlug !== 'all') {
            $roleExists = \App\Models\Role::where('slug', $roleSlug)->exists();
            if (!$roleExists) {
                return redirect()->route('admin.users.index')
                    ->with('error', 'Role "' . $roleSlug . '" not found! Please select a valid role.');
            }
            $users = $this->userService->getUsersByRole($roleSlug, 10, $search, $showTrashed, $userType, $googleId, $registered);
        } else {
            $users = $this->userService->getAllUsers(10, $search, $showTrashed, $userType, $googleId, $registered);
        }

        return view('admin.users.index', compact('users', 'roleSlug', 'userType', 'search', 'showTrashed', 'roles', 'googleId', 'registered'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try {
            $roleSlug = $request->get('role');
            
            // Validate role exists if provided
            if ($roleSlug && $roleSlug !== '' && $roleSlug !== 'all') {
                $role = \App\Models\Role::where('slug', $roleSlug)->first();
                if (!$role) {
                    return redirect()->route('admin.users.index')
                        ->with('error', 'Role not found! Please select a valid role.');
                }
            }
            
            return view('admin.users.create', compact('roleSlug'));
        } catch (\Exception $e) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Failed to load create form: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|exists:roles,slug',
        ]);

        try {
            // Get role information
            $role = \App\Models\Role::where('slug', $validated['role'])->first();

            // Set user_type based on role
            $validated['user_type'] = $role->slug === 'admin' ? 'admin' : 'user';

            // Create user
            $user = $this->userService->createUser($validated);

            // Assign role to user
            if ($role) {
                $user->roles()->sync([$role->id]);
            }

            return redirect()->route('admin.users.index')
                ->with('success', 'User created successfully with role: ' . $role->name);
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Failed to create user: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = $this->userService->getUserById($id);

        if (!$user) {
            return back()->with('error', 'User not found!');
        }

        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = $this->userService->getUserById($id);

        if (!$user) {
            return back()->with('error', 'User not found!');
        }

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        try {
            $this->userService->updateUser($id, $validated);

            return redirect()->route('admin.users.index')
                ->with('success', 'User updated successfully!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Failed to update user: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->userService->deleteUser($id);

            return redirect()->route('admin.users.index')
                ->with('success', 'User moved to trash successfully!');
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
            $this->userService->restoreUser($id);

            return redirect()->route('admin.users.index')
                ->with('success', 'User restored successfully!');
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
            $this->userService->forceDeleteUser($id);

            return redirect()->route('admin.users.index')
                ->with('success', 'User permanently deleted!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display trashed users.
     */
    public function trashed(Request $request)
    {
        $search = $request->get('search');
        $users = $this->userService->getTrashedUsers(10, $search);

        return view('admin.users.trashed', compact('users', 'search'));
    }

    /**
     * Verify user email.
     */
    public function verifyEmail(string $id)
    {
        try {
            $this->userService->verifyUserEmail($id);

            return back()->with('success', 'User email verified successfully!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Unverify user email.
     */
    public function unverifyEmail(string $id)
    {
        try {
            $this->userService->unverifyUserEmail($id);

            return back()->with('success', 'User email unverified successfully!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
