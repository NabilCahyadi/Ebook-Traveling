<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Ebook;
use App\Models\City;
use Illuminate\Http\Request;

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
    public function getAllUsers(int $perPage = 10, ?string $search = null, bool $withTrashed = false, ?string $userType = null, ?string $googleId = null, ?string $registered = null)
    {
        $query = User::with('roles');

        if ($withTrashed) {
            $query->withTrashed();
        }

        if ($userType) {
            $query->where('user_type', $userType);
        }

        // Filter by Google ID
        if ($googleId) {
            if ($googleId === 'linked') {
                $query->whereNotNull('google_id');
            } elseif ($googleId === 'regular') {
                $query->whereNull('google_id');
            }
        }

        // Filter by registered time
        if ($registered) {
            switch ($registered) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'week':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('created_at', now()->month)
                          ->whereYear('created_at', now()->year);
                    break;
                case 'year':
                    $query->whereYear('created_at', now()->year);
                    break;
            }
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
    public function getUsersByRole(string $roleSlug, int $perPage = 10, ?string $search = null, bool $withTrashed = false, ?string $userType = null, ?string $googleId = null, ?string $registered = null)
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

        if ($userType) {
            $query->where('user_type', $userType);
        }

        // Filter by Google ID
        if ($googleId) {
            if ($googleId === 'linked') {
                $query->whereNotNull('google_id');
            } elseif ($googleId === 'regular') {
                $query->whereNull('google_id');
            }
        }

        // Filter by registered time
        if ($registered) {
            switch ($registered) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'week':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('created_at', now()->month)
                          ->whereYear('created_at', now()->year);
                    break;
                case 'year':
                    $query->whereYear('created_at', now()->year);
                    break;
            }
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
     * Verify user email.
     */
    public function verifyUserEmail(string $id): bool
    {
        DB::beginTransaction();
        try {
            $user = User::find($id);

            if (!$user) {
                throw new \Exception('User not found');
            }

            if ($user->email_verified_at) {
                throw new \Exception('User email is already verified');
            }

            $result = $this->userRepository->update($user, [
                'email_verified_at' => now()
            ]);

            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Unverify user email.
     */
    public function unverifyUserEmail(string $id): bool
    {
        DB::beginTransaction();
        try {
            $user = User::find($id);

            if (!$user) {
                throw new \Exception('User not found');
            }

            if (!$user->email_verified_at) {
                throw new \Exception('User email is already unverified');
            }

            $result = $this->userRepository->update($user, [
                'email_verified_at' => null
            ]);

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

    public function getAccountData(string $userId, Request $request): array
    {
        $user = User::with([
            'profile',
            'orders.items.ebook.categories',
            'savedBooks.categories',
            'readings.ebook.city',
            'subscriptions.plan',
            'ratings.ebook.city',
            'createdEbooks.categories',
            'blogs'
        ])->findOrFail($userId);

        // 1. Inisialisasi $allEbooks sebagai koleksi kosong
        $allEbooks = collect();

        // 2. JIKA USER PREMIUM, jalankan logika query dan filter
        if ($user->hasActiveSubscription()) {
            // Query untuk My Library
            $query = Ebook::leftJoin('creators', 'ebooks.creator_id', '=', 'creators.id')
                ->leftJoin('users', 'creators.user_id', '=', 'users.id')
                ->leftJoin('cities', 'ebooks.city_id', '=', 'cities.id');

            if ($request->filled('search')) {
                $searchTerm = '%' . $request->search . '%';
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('ebooks.title', 'LIKE', $searchTerm)
                        ->orWhere('ebooks.description', 'LIKE', $searchTerm)
                        ->orWhere('creators.pen_name', 'LIKE', $searchTerm)
                        ->orWhere('users.name', 'LIKE', $searchTerm);
                });
            }

            $query->where('ebooks.status', 'published');

            if ($request->filled('city_slug')) {
                $query->where('cities.slug', $request->city_slug);
            }

            $query->whereNull('ebooks.deleted_at');
            $allEbooks = $query->select('ebooks.*')->distinct()->get();

            // Data premium lainnya
            $data['activeSubscription'] = $user->subscriptions()
                ->where('status', 'active')
                ->where('end_date', '>=', now())
                ->with('plan')
                ->first();

            $data['readingStats'] = [
                'total_books_read' => $user->readings->where('is_completed', true)->count(),
                'currently_reading' => $user->readings()
                    ->where('progress_percentage', '>', 0)
                    ->where('progress_percentage', '<', 100)
                    ->with('ebook')
                    ->latest('last_read_at')
                    ->get(),
            ];

            if ($user->isCreator()) {
                $data['createdEbooks'] = $user->createdEbooks()->with('categories')->get();
                $data['creatorBlogs'] = $user->blogs()->where('status', true)->get();
            }
        }

        // 3. Ambil semua kota untuk dropdown filter (selalu diambil)
        $cities = City::orderBy('name')->get();

        // === FILTER UNTUK READING HISTORY ===
        $readingHistoryQuery = $user->readings()->with('ebook.city', 'ebook.creator');
        if ($request->filled('search')) {
            $readingHistoryQuery->whereHas('ebook', function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->filled('city_slug')) {
            $readingHistoryQuery->whereHas('ebook.city', function ($q) use ($request) {
                $q->where('slug', $request->city_slug);
            });
        }
        $readingHistory = $readingHistoryQuery->latest('last_read_at')->get();

        // === FILTER UNTUK USER RATINGS ===
        $ratingsQuery = $user->ratings()->with('ebook.city');
        if ($request->filled('search')) {
            $ratingsQuery->whereHas('ebook', function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->filled('city_slug')) {
            $ratingsQuery->whereHas('ebook.city', function ($q) use ($request) {
                $q->where('slug', $request->city_slug);
            });
        }
        $userRatings = $ratingsQuery->latest()->get();

        // 4. Kompilasi semua data
        $data = [
            'user' => $user,
            'allEbooks' => $allEbooks,
            'cities' => $cities,
            'ordersCount' => $user->orders->count(),
            'wishlistCount' => $user->savedBooks->count(),
            'wishlistItems' => $user->savedBooks,
            'orders' => $user->orders()->latest()->get(),
            'ebooks' => $allEbooks,
            'userReadings' => $user->readings()->with('ebook')->get()->keyBy('ebook_id'),
            'readingHistory' => $readingHistory,
            'userRatings' => $userRatings,
            'createdEbooks' => $user->createdEbooks()->with('categories')->get(),
        ];

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
