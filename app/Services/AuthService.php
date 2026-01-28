<?php

namespace App\Services;

use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * Attempt to authenticate admin
     */
    public function attemptLogin(array $credentials, bool $remember = false): bool
    {
        return Auth::guard('admin')->attempt($credentials, $remember);
    }

    /**
     * Logout admin
     */
    public function logout(): void
    {
        Auth::guard('admin')->logout();
    }

    /**
     * Get current authenticated admin
     */
    public function getCurrentAdmin(): ?Admin
    {
        return Auth::guard('admin')->user();
    }

    /**
     * Check if admin is authenticated
     */
    public function isAuthenticated(): bool
    {
        return Auth::guard('admin')->check();
    }

    /**
     * Update admin's last login timestamp
     */
    public function updateLastLogin(Admin $admin): void
    {
        $admin->updateLastLogin();
    }

    /**
     * Validate admin credentials
     */
    public function validateCredentials(string $email, string $password): ?Admin
    {
        $admin = Admin::where('email', $email)
            ->where('status', 'active')
            ->first();

        if ($admin && Hash::check($password, $admin->password)) {
            return $admin;
        }

        return null;
    }
}
