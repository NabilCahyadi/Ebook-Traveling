<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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
    public function getAllUsers(int $perPage = 10, ?string $search = null, bool $withTrashed = false)
    {
        $query = User::with('roles');

        if ($withTrashed) {
            $query->withTrashed();
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        return $query->paginate($perPage);
    }

    /**
     * Get users by role slug with pagination.
     */
    public function getUsersByRole(string $roleSlug, int $perPage = 10, ?string $search = null, bool $withTrashed = false)
    {
        $query = User::where(function ($query) use ($roleSlug) {
            // Check if user has role in user_roles table
            $query->whereHas('roles', function ($q) use ($roleSlug) {
                $q->where('slug', $roleSlug);
            })
                // OR check user_type column (fallback for users without role assignment)
                ->orWhere('user_type', $roleSlug);
        });

        if ($withTrashed) {
            $query->withTrashed();
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        return $query->with('roles')->paginate($perPage);
    }

    /**
     * Get user by ID.
     */
    public function getUserById(string $id, bool $withTrashed = false): ?User // UBAH int jadi string
    {
        if ($withTrashed) {
            return User::withTrashed()->find($id);
        }
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
    public function updateUser(string $id, array $data): bool
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
     * Soft delete user.
     */
    public function deleteUser(string $id): bool // UBAH int jadi string
    {
        DB::beginTransaction();
        try {
            $user = $this->userRepository->findById($id);

            if (!$user) {
                throw new \Exception('User not found');
            }

            // Prevent deleting current logged in user
            if (Auth::id() && $user->id === Auth::id()) {
                throw new \Exception('You cannot delete your own account');
            }

            // Soft delete the user
            $result = $user->delete();

            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Restore soft deleted user.
     */
    public function restoreUser(string $id): bool
    {
        DB::beginTransaction();
        try {
            $user = User::withTrashed()->find($id);

            if (!$user) {
                throw new \Exception('User not found');
            }

            if (!$user->trashed()) {
                throw new \Exception('User is not deleted');
            }

            $result = $user->restore();

            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Permanently delete user.
     */
    public function forceDeleteUser(string $id): bool
    {
        DB::beginTransaction();
        try {
            $user = User::withTrashed()->find($id);

            if (!$user) {
                throw new \Exception('User not found');
            }

            // Prevent force deleting current logged in user
            if (Auth::id() && $user->id === Auth::id()) {
                throw new \Exception('You cannot permanently delete your own account');
            }

            $result = $user->forceDelete();

            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Get only trashed users.
     */
    public function getTrashedUsers(int $perPage = 10, ?string $search = null)
    {
        $query = User::onlyTrashed()->with('roles');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        return $query->paginate($perPage);
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

    /**
     * Get user account data for dashboard (NEW METHOD)
     */
    public function getAccountData(string $userId): array
    {
        $user = User::with([
            'profile',
            'orders.items.ebook.categories',
            'savedBooks.ebook.categories',
            'readings.ebook',
            'subscriptions.plan',
            'ratings.ebook',
            'createdEbooks.categories', // Untuk creator
            'blogs' // Untuk creator blog posts
        ])->findOrFail($userId);

        $data = [
            'user' => $user,
            'ordersCount' => $user->orders->count(),
            'wishlistCount' => $user->savedBooks->count(),
            'readingProgressCount' => $user->readings->count(),
            'wishlistItems' => $user->savedBooks,
            'orders' => $user->orders()->latest()->get(),
            'userReadings' => $user->readings()->with('ebook')->latest()->get(),
            'userRatings' => $user->ratings()->with('ebook')->latest()->get(),
            'createdEbooks' => $user->createdEbooks()->with('categories')->get(),
        ];

        // Data untuk premium users
        if ($user->hasActiveSubscription()) {
            $data['activeSubscription'] = $user->subscriptions()
                ->where('status', 'active')
                ->where('end_date', '>=', now())
                ->with('plan')
                ->first();

            // Ebooks yang sudah dibeli/diakses
            $data['purchasedEbooks'] = $user->orders()
                ->where('status', 'completed')
                ->with('items.ebook.categories')
                ->get()
                ->pluck('items')
                ->flatten()
                ->pluck('ebook')
                ->unique('id');

            // Reading statistics
            $data['readingStats'] = [
                'total_books_read' => $user->readings->count(),
                'total_pages_read' => $user->readings->sum('last_page'),
                'average_progress' => $user->readings->avg('progress_percentage'),
                'currently_reading' => $user->readings()
                    ->where('progress_percentage', '<', 100)
                    ->with('ebook')
                    ->latest('last_read_at')
                    ->get()
            ];

            // Creator data jika user adalah creator
            if ($user->isCreator()) {
                $data['createdEbooks'] = $user->createdEbooks()->with('categories')->get();
                $data['creatorBlogs'] = $user->blogs()->where('status', true)->get();
            }
        }

        return $data;
    }

    /**
     * Update user profile (NEW METHOD)
     */
    public function updateProfile(string $userId, array $data): array // UBAH jadi string
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail($userId);

            // Update user basic info
            $userData = [
                'name' => $data['name'],
                'phone' => $data['phone'] ?? $user->phone,
                'preferred_language' => $data['preferred_language'] ?? $user->preferred_language,
            ];

            // Update password if provided and confirmed
            if (!empty($data['new_password']) && !empty($data['new_password_confirmation'])) {
                if ($data['new_password'] === $data['new_password_confirmation']) {
                    $userData['password'] = Hash::make($data['new_password']);
                }
            }

            $this->userRepository->update($user, $userData);

            // Update or create profile
            if ($user->profile) {
                $user->profile->update([
                    'bio' => $data['bio'] ?? null,
                    'country' => $data['country'] ?? 'Indonesia',
                ]);
            } else {
                $user->profile()->create([
                    'bio' => $data['bio'] ?? null,
                    'country' => $data['country'] ?? 'Indonesia',
                ]);
            }

            DB::commit();

            return [
                'success' => true,
                'user' => $user,
                'message' => 'Profile updated successfully'
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}
