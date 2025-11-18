<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    /**
     * Get all users with pagination.
     */
    public function getAllPaginated(int $perPage = 15): mixed;

    /**
     * Find user by ID.
     */
    public function findById(int $id): ?User;

    /**
     * Find user by email.
     */
    public function findByEmail(string $email): ?User;

    /**
     * Find user by Google ID.
     */
    public function findByGoogleId(string $googleId): ?User;

    /**
     * Create a new user.
     */
    public function create(array $data): User;

    /**
     * Update user data.
     */
    public function update(User $user, array $data): bool;

    /**
     * Delete user.
     */
    public function delete(User $user): bool;

    /**
     * Search users by name or email.
     */
    public function search(string $query): Collection;
}
