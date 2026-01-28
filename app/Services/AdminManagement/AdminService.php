<?php

namespace App\Services\AdminManagement;

use App\Repositories\AdminManagement\AdminRepository;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminService
{
    protected AdminRepository $adminRepository;

    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    /**
     * Get all admins with filters
     */
    public function getAllAdmins(?string $search = null, ?string $type = null, int $perPage = 15): LengthAwarePaginator
    {
        return $this->adminRepository->getAllWithFilters($search, $type, $perPage);
    }

    /**
     * Find admin by ID
     */
    public function findById(string $id): ?Admin
    {
        return $this->adminRepository->findById($id);
    }

    /**
     * Find admin by ID or fail
     */
    public function findOrFail(string $id): Admin
    {
        return $this->adminRepository->findOrFail($id);
    }

    /**
     * Create new admin
     */
    public function createAdmin(array $data): Admin
    {
        // Hash password if provided
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        // Set default values
        $data['is_active'] = $data['is_active'] ?? true;

        return $this->adminRepository->create($data);
    }

    /**
     * Update admin
     */
    public function updateAdmin(Admin $admin, array $data): bool
    {
        // Hash password if provided and not empty
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        return $this->adminRepository->update($admin, $data);
    }

    /**
     * Delete admin
     */
    public function deleteAdmin(Admin $admin): bool
    {
        // Prevent deleting self
        if (auth('admin')->id() === $admin->id) {
            throw new \Exception('Anda tidak dapat menghapus akun Anda sendiri.');
        }

        return $this->adminRepository->delete($admin);
    }

    /**
     * Check if email is unique
     */
    public function isEmailUnique(string $email, ?int $excludeId = null): bool
    {
        return !$this->adminRepository->emailExists($email, $excludeId);
    }

    /**
     * Get admin statistics
     */
    public function getStatistics(): array
    {
        return [
            'total' => $this->adminRepository->getCountByType(),
            'superadmin' => $this->adminRepository->getCountByType('superadmin'),
            'admin' => $this->adminRepository->getCountByType('admin'),
        ];
    }

    /**
     * Get all admins for export
     */
    public function getAdminsForExport(?string $search = null, ?string $type = null)
    {
        return $this->adminRepository->getAllForExport($search, $type);
    }

    /**
     * Check if current admin is superadmin
     */
    public function isSuperAdmin(): bool
    {
        return auth('admin')->check() && auth('admin')->user()->type === 'superadmin';
    }

    /**
     * Authorize superadmin access
     */
    public function authorizeSuperAdmin(): void
    {
        if (!$this->isSuperAdmin()) {
            abort(403, 'Hanya Super Admin yang dapat mengakses halaman ini.');
        }
    }

    /**
     * Get all trashed admins with filters
     */
    public function getTrashedAdmins(?string $search = null, ?string $type = null, int $perPage = 5): LengthAwarePaginator
    {
        return $this->adminRepository->getTrashedWithFilters($search, $type, $perPage);
    }

    /**
     * Find trashed admin by ID or fail
     */
    public function findTrashedOrFail(string $id): Admin
    {
        return $this->adminRepository->findTrashedOrFail($id);
    }

    /**
     * Restore trashed admin
     */
    public function restoreAdmin(string $id): bool
    {
        $admin = $this->adminRepository->findTrashedOrFail($id);
        return $this->adminRepository->restore($admin);
    }

    /**
     * Force delete admin permanently
     */
    public function forceDeleteAdmin(string $id): bool
    {
        $admin = $this->adminRepository->findTrashedOrFail($id);
        return $this->adminRepository->forceDelete($admin);
    }

    /**
     * Get trashed admins count
     */
    public function getTrashedCount(): int
    {
        return $this->adminRepository->getTrashedCount();
    }
}
