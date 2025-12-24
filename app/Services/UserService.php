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
    // Di dalam file app/Services/UserService.php

    // Di dalam file app/Services/UserService.php

    public function getAccountData(string $userId, Request $request): array
    {
        $user = User::with([
            'profile',
            'orders.items.ebook.categories',
            'savedBooks.ebook.categories',
            'readings.ebook',
            'subscriptions.plan',
            'ratings.ebook',
            'createdEbooks.categories',
            'blogs'
        ])->findOrFail($userId);

        // 1. Inisialisasi $allEbooks sebagai koleksi kosong
        $allEbooks = collect();

        // 2. JIKA USER PREMIUM, jalankan logika query dan filter
        if ($user->hasActiveSubscription()) {
            // 1. Buat query dasar dengan JOIN
            // 1. Buat query dasar dengan JOIN ke tabel yang dibutuhkan
            $query = Ebook::leftJoin('creators', 'ebooks.creator_id', '=', 'creators.id')
                ->leftJoin('users', 'creators.user_id', '=', 'users.id')
                ->leftJoin('cities', 'ebooks.city_id', '=', 'cities.id'); // <-- JOIN ke tabel cities

            // 2. Terapkan filter pencarian jika ada
            if ($request->filled('search')) {
                $searchTerm = '%' . $request->search . '%';
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('ebooks.title', 'LIKE', $searchTerm)
                        ->orWhere('ebooks.description', 'LIKE', $searchTerm)
                        ->orWhere('creators.pen_name', 'LIKE', $searchTerm)
                        ->orWhere('users.name', 'LIKE', $searchTerm);
                });
            }

            // 3. Terapkan filter status
            $query->where('ebooks.status', 'published');

            // 4. Terapkan filter kota (INI YANG DIPERBAIKI)
            if ($request->filled('city_slug')) {
                // Filter berdasarkan slug dari tabel 'cities' yang sudah di-join
                $query->where('cities.slug', $request->city_slug);
            }

            // 5. Pastikan SoftDeletes tetap berjalan
            $query->whereNull('ebooks.deleted_at');

            // 6. Ambil hasil query
            $allEbooks = $query->select('ebooks.*')->distinct()->get(); // Tambahkan distinct() untuk keamanan
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

        // 4. Kompilasi semua data ke dalam array
        $data = [
            'user' => $user,
            'allEbooks' => $allEbooks,
            'cities' => $cities,
            'ordersCount' => $user->orders->count(),
            'wishlistCount' => $user->savedBooks->count(),
            'wishlistItems' => $user->savedBooks,
            'orders' => $user->orders()->latest()->get(),

            // Ini untuk progress di tab My Library (tetap seperti ini)
            'userReadings' => $user->readings()->pluck('progress_percentage', 'ebook_id'),

            // TAMBAHKAN BARIS INI: Variabel baru untuk tabel Reading History
            'readingHistory' => $user->readings()->with('ebook.creator')->latest('last_read_at')->get(),

            'userRatings' => $user->ratings()->with('ebook')->latest()->get(),
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
