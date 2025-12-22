<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuthService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Register a new user.
     */
    public function register(array $data): User
    {
        DB::beginTransaction();
        try {
            $user = $this->userRepository->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'password' => $data['password'],
                'status' => 'active',
                'language_pref' => 'en',
                'email_verified_at' => now(),
            ]);

            // Assign member role automatically
            $memberRole = \App\Models\Role::where('slug', 'member')->first();
            if ($memberRole) {
                $user->roles()->attach($memberRole->id);
            }

            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Register user with Google OAuth.
     */
    public function registerWithGoogle(array $data, array $googleData): User
    {
        DB::beginTransaction();
        try {
            $user = $this->userRepository->create([
                'name' => $data['name'],
                'email' => $googleData['email'],
                'google_id' => $googleData['google_id'],
                'avatar' => $googleData['avatar'],
                'phone' => $data['phone'] ?? null,
                'password' => $data['password'],
                'status' => 'active',
                'language_pref' => $data['language_pref'] ?? 'en',
                'email_verified_at' => now(),
            ]);

            // Assign member role automatically
            $memberRole = \App\Models\Role::where('slug', 'member')->first();
            if ($memberRole) {
                $user->roles()->attach($memberRole->id);
            }

            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Attempt to login user.
     */
    public function login(string $email, string $password, bool $remember = false): bool
    {
        return Auth::attempt(['email' => $email, 'password' => $password], $remember);
    }

    /**
     * Attempt to login admin user.
     */
    public function attemptAdminLogin(string $email, string $password, bool $remember = false): User
    {
        $credentials = [
            'email' => $email,
            'password' => $password,
            'user_type' => 'admin',
            'status' => 'active'
        ];

        if (!Auth::attempt($credentials, $remember)) {
            throw new \Exception('Invalid credentials or you do not have admin access.');
        }

        $user = Auth::user();

        // Update last login
        $this->userRepository->update($user, [
            'last_login_at' => now()
        ]);

        return $user;
    }

    /**
     * Handle Google OAuth callback.
     */
    public function handleGoogleCallback($googleUser): array
    {
        $user = $this->userRepository->findByEmail($googleUser->getEmail());

        if ($user) {
            // Update Google ID if not set
            if (!$user->google_id) {
                $this->userRepository->update($user, [
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                ]);
            }

            return ['exists' => true, 'user' => $user];
        }

        // User doesn't exist, return Google data for registration
        return [
            'exists' => false,
            'google_data' => [
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
            ]
        ];
    }

    /**
     * Handle Google OAuth callback for admin.
     */
    public function handleAdminGoogleCallback($googleUser): User
    {
        $user = $this->userRepository->findByEmail($googleUser->getEmail());

        if (!$user) {
            throw new \Exception('No admin account found with this Google email.');
        }

        if ($user->user_type !== 'admin' || $user->status !== 'active') {
            throw new \Exception('You do not have admin access.');
        }

        // Update Google ID if not set
        if (!$user->google_id) {
            $this->userRepository->update($user, [
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
            ]);
        }

        // Update last login
        $this->userRepository->update($user, [
            'last_login_at' => now()
        ]);

        // Login the admin user
        Auth::login($user);

        return $user;
    }

    /**
     * Logout user.
     */
    public function logout(): void
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }

    /**
     * Logout user dengan redirect ke home page.
     */
    public function logoutUser(): array
    {
        try {
            $user = Auth::user();
            $userId = $user ? $user->id : null;
            $userEmail = $user ? $user->email : 'Unknown';

            Log::info('=== USER LOGOUT START ===', [
                'user_id' => $userId,
                'email' => $userEmail,
                'user_type' => $user->user_type ?? 'user',
                'session_id' => session()->getId()
            ]);

            // Logout dari Auth
            Auth::logout();

            // Clear session untuk memastikan
            session()->flush();

            Log::info('=== USER LOGOUT SUCCESS ===', [
                'user_id' => $userId,
                'auth_check_after' => Auth::check() ? 'TRUE' : 'FALSE'
            ]);

            return [
                'success' => true,
                'user_id' => $userId,
                'redirect_to' => 'home',
                'message' => 'User logged out successfully'
            ];
        } catch (\Exception $e) {
            Log::error('=== USER LOGOUT FAILED ===', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id() ?? 'Unknown'
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'message' => 'Logout failed'
            ];
        }
    }
}
