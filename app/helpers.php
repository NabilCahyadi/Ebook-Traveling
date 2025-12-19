<?php

if (!function_exists('formatNumber')) {
    /**
     * Format angka menjadi bentuk yang lebih ringkas (1k, 1M).
     *
     * @param int $number
     * @return string
     */
    function formatNumber($number)
    {
        if ($number >= 1000000) {
            return number_format($number / 1000000, 1) . 'M';
        } elseif ($number >= 1000) {
            return number_format($number / 1000, 1) . 'k';
        }

        return $number;
    }
}

if (!function_exists('hasPermission')) {
    /**
     * Check if current user has permission.
     * For guests, checks the "Guest" role permissions.
     *
     * @param string $permission
     * @return bool
     */
    function hasPermission($permission)
    {
        $user = auth()->user();

        // For guest users, check Guest role permissions
        if (!$user) {
            $guestRole = \App\Models\Role::where('slug', 'guest')
                ->with('permissions')
                ->first();
            
            if (!$guestRole) {
                return true; // Fallback: allow access if Guest role not configured
            }

            return $guestRole->hasPermission($permission);
        }

        // For logged in users, check their role permissions based on user_type
        try {
            // Get user type from users table
            $userType = $user->user_type ?? 'member';

            // Admin always has permission
            if ($userType === 'admin') {
                return true;
            }

            // Get role by slug (user_type)
            $role = \App\Models\Role::where('slug', $userType)->first();

            if (!$role) {
                \Illuminate\Support\Facades\Log::warning("Role not found for user_type: {$userType}");
                return false;
            }

            // Check if role has the permission
            $hasPermission = \Illuminate\Support\Facades\DB::table('role_permission')
                ->join('permissions', 'role_permission.permission_id', '=', 'permissions.id')
                ->where('role_permission.role_id', $role->id)
                ->where('permissions.name', $permission)
                ->exists();

            return $hasPermission;
            
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Permission check error: " . $e->getMessage());
            return false;
        }
    }
}

if (!function_exists('canAccess')) {
    /**
     * Check if current user can access a feature (alias for hasPermission).
     *
     * @param string $permission
     * @return bool
     */
    function canAccess($permission)
    {
        return hasPermission($permission);
    }
}
