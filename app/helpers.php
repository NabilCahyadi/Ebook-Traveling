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

if (!function_exists('getInitials')) {
    /**
     * Get initials from name.
     * Single word: first 2 letters (e.g., "Nabil" -> "NA")
     * Multiple words: first letter of each word (e.g., "Nabil Cahyadi" -> "NC")
     *
     * @param string $name
     * @return string
     */
    function getInitials($name)
    {
        if (empty($name)) {
            return '';
        }

        $words = explode(' ', trim($name));
        
        // If single word, take first 2 letters
        if (count($words) === 1) {
            return strtoupper(substr($words[0], 0, 2));
        }
        
        // If multiple words, take first letter of first 2 words
        $initials = '';
        for ($i = 0; $i < min(2, count($words)); $i++) {
            $initials .= strtoupper(substr($words[$i], 0, 1));
        }
        
        return $initials;
    }
}

if (!function_exists('translateCategorySubscription')) {
    /**
     * Translate category subscription from Indonesian to current locale.
     * Value tetap bahasa Indonesia, tapi display sesuai locale.
     *
     * @param string $category Indonesian category (harian, mingguan, bulanan, tahunan)
     * @return string Translated category
     */
    function translateCategorySubscription($category)
    {
        if (empty($category)) {
            return 'N/A';
        }

        return __('admin.category_subscription.' . $category, [], app()->getLocale());
    }
}

if (!function_exists('formatPhoneNumber')) {
    /**
     * Format nomor telepon Indonesia dari format 62x menjadi 08x.
     *
     * @param string $phone
     * @return string
     */
    function formatPhoneNumber($phone)
    {
        if (empty($phone)) {
            return $phone;
        }

        // Hapus semua karakter non-digit
        $phone = preg_replace('/\D/', '', $phone);

        // Jika dimulai dengan 62, ubah menjadi 0
        if (strpos($phone, '62') === 0) {
            $phone = '0' . substr($phone, 2);
        }
        // Jika hanya angka tanpa 62 atau 0, asumsikan dimulai dengan 0
        elseif (strpos($phone, '0') !== 0 && strpos($phone, '62') !== 0) {
            $phone = '0' . $phone;
        }

        return $phone;
    }
}
