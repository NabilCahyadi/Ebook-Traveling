<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Get all users with pagination.
     */
    public function getAllUsers(int $perPage = 10)
    {
        return $this->userRepository->getAllPaginated($perPage);
    }

    /**
     * Get user by ID.
     */
    public function getUserById(int $id): ?User
    {
        return $this->userRepository->findById($id);
    }

    /**
     * Create a new user.
     */
    public function createUser(array $data): User
    {
        DB::beginTransaction();
        try {
            $user = $this->userRepository->create($data);

            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update user.
     */
    public function updateUser(int $id, array $data): bool
    {
        DB::beginTransaction();
        try {
            $user = $this->userRepository->findById($id);

            if (!$user) {
                throw new \Exception('User not found');
            }

            $result = $this->userRepository->update($user, $data);

            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Delete user.
     */
    public function deleteUser(int $id): bool
    {
        DB::beginTransaction();
        try {
            $user = $this->userRepository->findById($id);

            if (!$user) {
                throw new \Exception('User not found');
            }

            // Prevent deleting current logged in user
            if (auth()->check() && $user->id === auth()->id()) {
                throw new \Exception('You cannot delete your own account');
            }

            $result = $this->userRepository->delete($user);

            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Search users.
     */
    public function searchUsers(string $query)
    {
        return $this->userRepository->search($query);
    }

    /**
     * Find user by email.
     */
    public function findUserByEmail(string $email): ?User
    {
        return $this->userRepository->findByEmail($email);
    }

    /**
     * Find user by Google ID.
     */
    public function findUserByGoogleId(string $googleId): ?User
    {
        return $this->userRepository->findByGoogleId($googleId);
    }
}
