<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Show admin login form
     */
    public function showLoginForm()
    {
        if (Auth::check() && Auth::user()->user_type === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    /**
     * Handle admin login
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'remember' => 'boolean',
        ]);

        try {
            $user = $this->authService->attemptAdminLogin(
                $validated['email'],
                $validated['password'],
                $request->filled('remember')
            );

            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Welcome back, ' . $user->name);
        } catch (\Exception $e) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Redirect to Google for admin authentication
     */
    public function redirectToGoogle()
    {
        return \Laravel\Socialite\Facades\Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google callback for admin
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = \Laravel\Socialite\Facades\Socialite::driver('google')->user();
            
            $user = $this->authService->handleAdminGoogleCallback($googleUser);

            return redirect()->route('admin.dashboard')
                ->with('success', 'Welcome back, ' . $user->name);
        } catch (\Exception $e) {
            return redirect()->route('admin.login')
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Handle admin logout
     */
    public function logout(Request $request)
    {
        $this->authService->logout();

        return redirect()->route('admin.login')
            ->with('success', 'You have been logged out successfully.');
    }
}
