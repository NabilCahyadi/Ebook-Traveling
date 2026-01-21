<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class RegisterController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Show the registration form.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'terms' => ['required', 'accepted'],
        ], [
            'name.required' => 'Full name is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'Password is required.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.min' => 'Password must be at least 8 characters.',
            'terms.required' => 'You must accept the terms and conditions.',
            'terms.accepted' => 'You must accept the terms and conditions.',
        ]);

        try {
            // Create new user using service
            $user = $this->authService->register($validated);

            // Log the user in
            Auth::login($user);

            return redirect()->route('dashboard')
                ->with('success', 'Welcome to Ebook Traveling, ' . $user->name . '! Your account has been created successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Registration failed. Please try again.');
        }
    }

    /**
     * Redirect to Google for registration.
     */
    public function redirectToGoogleRegister()
    {
        $callbackUrl = config('services.google.redirect_register') ?: config('app.url') . '/register/google/callback';
        
        Log::info('Google Register Redirect', [
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
     * Handle Google callback for registration.
     */
    public function handleGoogleRegisterCallback()
    {
        try {
            $callbackUrl = config('services.google.redirect_register') ?: config('app.url') . '/register/google/callback';
            
            $googleUser = Socialite::driver('google')
                ->redirectUrl($callbackUrl)
                ->stateless()
                ->user();

            $result = $this->authService->handleGoogleCallback($googleUser);

            if ($result['exists']) {
                // Check if account is soft deleted
                if (isset($result['soft_deleted']) && $result['soft_deleted']) {
                    return redirect()->route('login')
                        ->with('error', $result['message'] ?? 'Your account has been deactivated. Please <a href="/contact" style="color: #FF416C; text-decoration: underline;">contact support</a>.');
                }
                
                // User already exists - redirect to login page with instruction
                return redirect()->route('login')
                    ->with('info', 'Akun Google Anda (' . $googleUser->getEmail() . ') sudah terdaftar. Silakan login menggunakan tombol Google di bawah ini.');
            } else {
                // User doesn't exist - proceed with registration
                // Store Google user data in session for registration
                session(['google_user' => $result['google_data']]);

                // Redirect to registration form
                return redirect()->route('register.google.form')
                    ->with('info', 'Silakan lengkapi data Anda untuk menyelesaikan pendaftaran.');
            }
        } catch (\Exception $e) {
            $callbackUrl = config('services.google.redirect_register') ?: config('app.url') . '/register/google/callback';
            
            Log::error('Google Registration Error: ' . $e->getMessage(), [
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'callback_url_used' => $callbackUrl,
                'config_redirect_register' => config('services.google.redirect_register'),
                'app_url' => config('app.url'),
                'request_url' => request()->url(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // User-friendly error messages
            $errorMessage = 'Maaf, terjadi kesalahan saat registrasi dengan Google.';
            
            if (strpos($e->getMessage(), 'redirect_uri_mismatch') !== false) {
                $errorMessage = 'Konfigurasi Google belum sesuai. URL yang digunakan: ' . $callbackUrl . '. Pastikan URL ini sudah terdaftar di Google Cloud Console, atau coba lagi dalam beberapa menit.';
            } elseif (strpos($e->getMessage(), 'invalid_client') !== false) {
                $errorMessage = 'Konfigurasi Google OAuth tidak valid. Silakan hubungi administrator.';
            } elseif (strpos($e->getMessage(), 'access_denied') !== false) {
                $errorMessage = 'Anda membatalkan proses login dengan Google.';
            }
            
            return redirect()->route('login', ['form' => 'register'])
                ->with('error', $errorMessage);
        }
    }

    /**
     * Show Google registration form.
     */
    public function showGoogleRegistrationForm()
    {
        if (!session('google_user')) {
            return redirect()->route('login')
                ->with('error', 'Session expired. Please login with Google again.');
        }

        return view('auth.register-google');
    }

    /**
     * Complete Google registration.
     */
    public function completeGoogleRegistration(Request $request)
    {
        if (!session('google_user')) {
            return redirect()->route('login')
                ->with('error', 'Session expired. Please login with Google again.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'language_pref' => ['required', 'in:en,id'],
            'terms' => ['required', 'accepted'],
        ], [
            'name.required' => 'Full name is required.',
            'password.required' => 'Password is required.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.min' => 'Password must be at least 8 characters.',
            'language_pref.required' => 'Please select your preferred language.',
            'terms.required' => 'You must accept the terms and conditions.',
            'terms.accepted' => 'You must accept the terms and conditions.',
        ]);

        $googleUser = session('google_user');

        try {
            // Create new user with Google using service
            $user = $this->authService->registerWithGoogle($validated, $googleUser);

            // Clear Google user session
            session()->forget('google_user');

            // Log the user in
            Auth::login($user, true);

            return redirect()->route('dashboard')
                ->with('success', 'Welcome to Ebook Traveling, ' . $user->name . '! Your account has been created successfully.');
        } catch (\Exception $e) {
            Log::error('Google Registration Error: ' . $e->getMessage());
            return back()->with('error', 'Registration failed: ' . $e->getMessage());
        }
    }
}
