<?php

namespace App\Repositories\UserManagement;

use App\Models\Role;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class RoleRepository implements RoleRepositoryInterface
{
    public function getAll()
    {
        return Role::orderBy('name')->get();
    }

    public function getAllPaginated(int $perPage = 10): LengthAwarePaginator
    {
        return Role::withCount('users')->orderBy('name')->paginate($perPage);
    }

    public function findById(string $id): ?Role
    {
        return Role::find($id);
    }

    public function create(array $data): Role
    {
        return Role::create($data);
    }

    public function update(Role $role, array $data): bool
    {
        return $role->update($data);
    }

    public function delete(Role $role): bool
    {
        return $role->delete();
    }

    public function findBySlug(string $slug): ?Role
    {
        return Role::where('slug', $slug)->first();
    }
}
