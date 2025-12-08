<?php

namespace App\Services;

use App\Models\Role;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoleService
{
    protected $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * Get all roles with pagination.
     */
    public function getAllRoles(int $perPage = 10)
    {
        return $this->roleRepository->getAllPaginated($perPage);
    }

    /**
     * Get role by ID.
     */
    public function getRoleById(string $id): ?Role
    {
        return $this->roleRepository->findById($id);
    }

    /**
     * Create a new role.
     */
    public function createRole(array $data): Role
    {
        DB::beginTransaction();
        try {
            // Generate slug from name if not provided
            if (!isset($data['slug'])) {
                $data['slug'] = Str::slug($data['name']);
            }

            // Ensure slug is unique
            $originalSlug = $data['slug'];
            $counter = 1;
            while ($this->roleRepository->findBySlug($data['slug'])) {
                $data['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }

            $role = $this->roleRepository->create($data);

            DB::commit();
            return $role;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update role.
     */
    public function updateRole(string $id, array $data): bool
    {
        DB::beginTransaction();
        try {
            $role = $this->roleRepository->findById($id);

            if (!$role) {
                throw new \Exception('Role not found');
            }

            // Generate slug from name if slug is being updated
            if (isset($data['name']) && (!isset($data['slug']) || empty($data['slug']))) {
                $data['slug'] = Str::slug($data['name']);
            }

            // Ensure slug is unique (excluding current role)
            if (isset($data['slug'])) {
                $existingRole = $this->roleRepository->findBySlug($data['slug']);
                if ($existingRole && $existingRole->id !== $id) {
                    $originalSlug = $data['slug'];
                    $counter = 1;
                    while ($existingRole && $existingRole->id !== $id) {
                        $data['slug'] = $originalSlug . '-' . $counter;
                        $counter++;
                        $existingRole = $this->roleRepository->findBySlug($data['slug']);
                    }
                }
            }

            $result = $this->roleRepository->update($role, $data);

            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Delete role.
     */
    public function deleteRole(string $id): bool
    {
        DB::beginTransaction();
        try {
            $role = $this->roleRepository->findById($id);

            if (!$role) {
                throw new \Exception('Role not found');
            }

            // Check if role has users
            if ($role->users()->count() > 0) {
                throw new \Exception('Cannot delete role that has assigned users');
            }

            $result = $this->roleRepository->delete($role);

            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
