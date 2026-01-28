<?php

namespace App\Services\UserManagement;

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
    public function getAllRoles(int $perPage = 10, ?string $search = null, bool $withTrashed = false)
    {
        $query = Role::query()->withCount('users');

        if ($withTrashed) {
            $query->withTrashed();
        }

        // Hide guest role
        $query->where('slug', '!=', 'guest');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('slug', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        return $query->paginate($perPage);
    }

    /**
     * Get role by ID.
     */
    public function getRoleById(string $id, bool $withTrashed = false): ?Role
    {
        if ($withTrashed) {
            return Role::withTrashed()->find($id);
        }
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
     * Soft delete role.
     */
    public function deleteRole(string $id): bool
    {
        DB::beginTransaction();
        try {
            $role = $this->roleRepository->findById($id);

            if (!$role) {
                throw new \Exception('Role not found');
            }

            // Remove role from users before deleting (detach from pivot table)
            if ($role->users()->count() > 0) {
                // Detach all users from this role
                $role->users()->detach();
            }

            // Soft delete the role
            $result = $role->delete();

            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Restore soft deleted role.
     */
    public function restoreRole(string $id): bool
    {
        DB::beginTransaction();
        try {
            $role = Role::withTrashed()->find($id);

            if (!$role) {
                throw new \Exception('Role not found');
            }

            if (!$role->trashed()) {
                throw new \Exception('Role is not deleted');
            }

            $result = $role->restore();

            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Permanently delete role.
     */
    public function forceDeleteRole(string $id): bool
    {
        DB::beginTransaction();
        try {
            $role = Role::withTrashed()->find($id);

            if (!$role) {
                throw new \Exception('Role not found');
            }

            // Remove role from users before permanently deleting (detach from pivot table)
            if ($role->users()->count() > 0) {
                // Detach all users from this role
                $role->users()->detach();
            }

            $result = $role->forceDelete();

            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Get only trashed roles.
     */
    public function getTrashedRoles(int $perPage = 10, ?string $search = null)
    {
        $query = Role::onlyTrashed();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('slug', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        return $query->paginate($perPage);
    }
}
