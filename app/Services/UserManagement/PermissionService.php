<?php

namespace App\Services\UserManagement;

use App\Repositories\Interfaces\PermissionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PermissionService
{
    protected $permissionRepository;

    public function __construct(PermissionRepositoryInterface $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Get all permissions with pagination.
     */
    public function getAllPermissions(int $perPage = 15): mixed
    {
        return $this->permissionRepository->getAllPaginated($perPage);
    }

    /**
     * Get permissions by role ID.
     */
    public function getPermissionsByRole(string $roleId): Collection
    {
        return $this->permissionRepository->getByRoleId($roleId);
    }

    /**
     * Get permission by ID.
     */
    public function getPermissionById(string $id): mixed
    {
        return $this->permissionRepository->findById($id);
    }

    /**
     * Create new permission.
     */
    public function createPermission(array $data): mixed
    {
        return $this->permissionRepository->create($data);
    }

    /**
     * Update permission.
     */
    public function updatePermission(string $id, array $data): bool
    {
        return $this->permissionRepository->update($id, $data);
    }

    /**
     * Delete permission.
     */
    public function deletePermission(string $id): bool
    {
        return $this->permissionRepository->delete($id);
    }

    /**
     * Sync permissions for a role.
     */
    public function syncRolePermissions(string $roleId, array $permissions): void
    {
        $this->permissionRepository->syncRolePermissions($roleId, $permissions);
    }

    /**
     * Get all permissions grouped by role.
     */
    public function getAllGroupedByRole(): Collection
    {
        return $this->permissionRepository->getAllGroupedByRole();
    }

    /**
     * Get available resources for permissions.
     */
    public function getAvailableResources(): array
    {
        return [
            'users' => 'User Management',
            'roles' => 'Role Management',
            'permissions' => 'Permission Management',
            'ebooks' => 'Ebook Management',
            'categories' => 'Category Management',
            'cities' => 'City Management',
            'subscriptions' => 'Subscription Management',
            'subscription_plans' => 'Subscription Plan Management',
            'orders' => 'Order Management',
            'payments' => 'Payment Management',
            'blogs' => 'Blog Management',
            'banners' => 'Banner Management',
            'promos' => 'Promo Management',
            'settings' => 'System Settings',
            'reports' => 'Reports & Analytics',
        ];
    }
}
