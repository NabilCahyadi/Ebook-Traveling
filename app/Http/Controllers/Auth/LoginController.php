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
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginField = $request->input('email');
        $password = $request->input('password');
        $remember = $request->boolean('remember');

        // Determine if login field is email or phone
        $fieldType = filter_var($loginField, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        \Log::info('Login attempt', [
            'field_type' => $fieldType,
            'login_field' => $loginField,
            'credentials' => [$fieldType => $loginField]
        ]);

        // Check if user exists
        $user = \App\Models\User::where($fieldType, $loginField)->first();
        \Log::info('User found', ['user' => $user ? $user->toArray() : 'null']);

        if (Auth::attempt([$fieldType => $loginField, 'password' => $password], $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            \Log::info('Login successful', ['user_type' => $user->user_type]);

            // Redirect based on user type/role
            $redirectRoute = $this->getRedirectRoute($user);

            \Log::info('Redirecting to', ['route' => $redirectRoute]);

            return redirect()->intended(route($redirectRoute))
                ->with('success', 'Welcome back, ' . $user->name . '!');
        }

        \Log::warning('Login failed', ['field' => $loginField]);

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
            \Log::error('Google OAuth Error: ' . $e->getMessage());
            return redirect()->route('login')
                ->with('error', 'Unable to login with Google: ' . $e->getMessage());
        }
    }
}
