<?php

namespace App\Services\AdminManagement;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class ProfileService
{
    /**
     * Get current admin profile
     */
    public function getCurrentAdmin(): ?Admin
    {
        return auth('admin')->user();
    }

    /**
     * Update admin profile
     */
    public function updateProfile(Admin $admin, array $data): bool
    {
        $updateData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? $admin->phone,
        ];

        // Handle avatar upload if present
        if (isset($data['avatar'])) {
            $updateData['avatar'] = $data['avatar'];
        }

        return $admin->update($updateData);
    }

    /**
     * Update admin password
     */
    public function updatePassword(Admin $admin, string $currentPassword, string $newPassword): array
    {
        // Verify current password
        if (!Hash::check($currentPassword, $admin->password)) {
            return [
                'success' => false,
                'message' => 'Password saat ini tidak valid.'
            ];
        }

        // Update password
        $admin->update([
            'password' => Hash::make($newPassword)
        ]);

        return [
            'success' => true,
            'message' => 'Password berhasil diperbarui.'
        ];
    }

    /**
     * Validate profile data
     */
    public function validateProfileData(array $data, int $adminId): array
    {
        $errors = [];

        // Check email uniqueness
        $emailExists = Admin::where('email', $data['email'])
            ->where('id', '!=', $adminId)
            ->exists();

        if ($emailExists) {
            $errors['email'] = 'Email sudah digunakan oleh admin lain.';
        }

        return $errors;
    }

    /**
     * Handle avatar upload
     */
    public function handleAvatarUpload($file, Admin $admin): ?string
    {
        if (!$file) {
            return null;
        }

        // Delete old avatar if exists
        if ($admin->avatar) {
            $oldPath = storage_path('app/public/' . $admin->avatar);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        // Store new avatar
        $path = $file->store('avatars/admins', 'public');
        
        return $path;
    }

    /**
     * Delete avatar
     */
    public function deleteAvatar(Admin $admin): bool
    {
        if ($admin->avatar) {
            $path = storage_path('app/public/' . $admin->avatar);
            if (file_exists($path)) {
                unlink($path);
            }
            
            return $admin->update(['avatar' => null]);
        }

        return true;
    }
}
