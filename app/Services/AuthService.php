<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
     * Logout user.
     */
    public function logout(): void
    {
        Auth::logout();
    }
}
