<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');
        $remember = $request->boolean('remember');

        if ($this->authService->login($email, $password, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            // Redirect based on user type/role
            $redirectRoute = $this->getRedirectRoute($user);

            return redirect()->intended(route($redirectRoute))
                ->with('success', 'Welcome back, ' . $user->name . '!');
        }

        throw ValidationException::withMessages([
            'email' => __('The provided credentials do not match our records.'),
        ]);
    }

    /**
     * Get redirect route based on user type/role.
     */
    protected function getRedirectRoute($user)
    {
        // Check user_type field (if exists in User model)
        if (isset($user->user_type)) {
            switch ($user->user_type) {
                case 'admin':
                case 'superadmin':
                    return 'admin.dashboard';
                case 'customer':
                case 'user':
                default:
                    return 'user.dashboard';
            }
        }

        // Fallback: Check email domain or other criteria
        if (str_contains($user->email, '@admin.')) {
            return 'admin.dashboard';
        }

        // Default to user dashboard
        return 'user.dashboard';
    }

    /**
     * Logout the user.
     */
    public function logout(Request $request)
    {
        $this->authService->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'You have been successfully logged out.');
    }

    /**
     * Redirect to Google OAuth.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $result = $this->authService->handleGoogleCallback($googleUser);

            if ($result['exists']) {
                Auth::login($result['user'], true);

                return redirect()->route('dashboard')
                    ->with('success', 'Welcome back, ' . $result['user']->name . '!');
            } else {
                // Store Google user data in session for registration
                session(['google_user' => $result['google_data']]);

                // Redirect to registration page with Google data
                return redirect()->route('register.google')
                    ->with('info', 'Please complete your registration to continue.');
            }

        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Unable to login with Google. Please try again.');
        }
    }
}
