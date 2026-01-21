<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;

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

        Log::info('Login attempt', [
            'field_type' => $fieldType,
            'login_field' => $loginField,
            'credentials' => [$fieldType => $loginField]
        ]);

        // Check if user exists
        $user = \App\Models\User::where($fieldType, $loginField)->first();
        Log::info('User found', ['user' => $user ? $user->toArray() : 'null']);

        if (Auth::attempt([$fieldType => $loginField, 'password' => $password], $remember)) {
            // $request->session()->regenerate(); DIHAPUS SOALNYA INI CONFLICT yang bikin session user tidak terbaca

            $user = Auth::user();

            Log::info('Login successful', ['user_type' => $user->user_type]);

            // Redirect based on user type/role
            $redirectRoute = $this->getRedirectRoute($user);

            Log::info('Redirecting to', ['route' => $redirectRoute]);

            return redirect()->intended(route($redirectRoute))
                ->with('success', 'Welcome back, ' . $user->name . '!');
        }

        Log::warning('Login failed', ['field' => $loginField]);

        throw ValidationException::withMessages([
            'email' => __('The provided credentials do not match our records.'),
        ]);
    }

    /**
     * Get redirect route based on user type/role.
     * For user login form, always redirect to home even if user is admin.
     */
    protected function getRedirectRoute($user)
    {
        // Always redirect to home for user login form
        // Admin should use /admin/login to access admin dashboard
        return 'home';
    }

    /**
     * Logout the user.
     */
    // public function logout(Request $request)
    // {
    //     $this->authService->logout();

    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     return redirect()->route('login')
    //         ->with('success', 'You have been successfully logged out.');
    // }

    /**
     * Logout untuk user regular.
     */
    public function userLogout(Request $request)
    {
        Log::info('=== LOGIN CONTROLLER USER LOGOUT START ===', [
            'user_id' => Auth::id(),
            'session_id' => session()->getId()
        ]);

        // Gunakan AuthService untuk logout business logic
        $logoutResult = $this->authService->logoutUser();

        if ($logoutResult['success']) {
            // Invalidate session
            $request->session()->invalidate();

            // Regenerate CSRF token
            $request->session()->regenerateToken();

            Log::info('=== LOGIN CONTROLLER USER LOGOUT COMPLETE ===', [
                'user_id' => $logoutResult['user_id'],
                'redirect_to' => 'home'
            ]);

            return redirect()->route('home')
                ->with('success', 'You have been successfully logged out.');
        }

        Log::error('=== LOGIN CONTROLLER USER LOGOUT FAILED ===', [
            'error' => $logoutResult['error']
        ]);

        return redirect()->back()
            ->with('error', 'Logout failed: ' . $logoutResult['error']);
    }

    /**
     * Redirect to Google OAuth.
     */
    public function redirectToGoogle()
    {
        $callbackUrl = config('app.url') . '/login/google/callback';
        
        Log::info('Google Login Redirect', [
            'app_url' => config('app.url'),
            'callback_url' => $callbackUrl,
            'request_url' => request()->url(),
            'full_url' => request()->fullUrl()
        ]);
        
        return Socialite::driver('google')
            ->redirectUrl($callbackUrl)
            ->stateless()
            ->redirect();
    }

    /**
     * Handle Google OAuth callback.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $result = $this->authService->handleGoogleCallback($googleUser);

            if ($result['exists']) {
                Auth::login($result['user'], true);

                // Redirect to home (user dashboard) for Google login from user form
                return redirect()->route('home')
                    ->with('success', 'Welcome back, ' . $result['user']->name . '!');
            } else {
                // User doesn't exist - redirect to login with clear message
                return redirect()->route('login', ['form' => 'register'])
                    ->with('error', 'Akun Google Anda (' . $googleUser->getEmail() . ') belum terdaftar. Silakan daftar terlebih dahulu menggunakan form di bawah ini.');
            }
        } catch (\Exception $e) {
            $callbackUrl = config('app.url') . '/login/google/callback';
            
            Log::error('Google OAuth Error: ' . $e->getMessage(), [
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'callback_url_used' => $callbackUrl,
                'app_url' => config('app.url'),
                'request_url' => request()->url()
            ]);
            
            // User-friendly error messages
            $errorMessage = 'Maaf, terjadi kesalahan saat login dengan Google.';
            
            if (strpos($e->getMessage(), 'redirect_uri_mismatch') !== false) {
                $errorMessage = 'Konfigurasi Google belum sesuai. URL yang digunakan: ' . $callbackUrl . '. Pastikan URL ini sudah terdaftar di Google Cloud Console, atau coba lagi dalam beberapa menit.';
            } elseif (strpos($e->getMessage(), 'invalid_client') !== false) {
                $errorMessage = 'Konfigurasi Google OAuth tidak valid. Silakan hubungi administrator.';
            } elseif (strpos($e->getMessage(), 'access_denied') !== false) {
                $errorMessage = 'Anda membatalkan proses login dengan Google.';
            }
            
            return redirect()->route('login')
                ->with('error', $errorMessage);
        }
    }
}
