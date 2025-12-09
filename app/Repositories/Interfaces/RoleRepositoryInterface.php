<?php

namespace App\Repositories\Interfaces;

use App\Models\Role;
use Illuminate\Pagination\LengthAwarePaginator;

interface RoleRepositoryInterface
{
    public function getAll();

    public function getAllPaginated(int $perPage = 10): LengthAwarePaginator;

    public function findById(string $id): ?Role;

    public function create(array $data): Role;

    public function update(Role $role, array $data): bool;

    public function delete(Role $role): bool;

    public function findBySlug(string $slug): ?Role;
}
