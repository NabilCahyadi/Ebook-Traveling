<?php

namespace App\Http\Controllers\Panel;

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
     * Show panel login form
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('panel.dashboard');
        }

        return view('panel.auth.login');
    }

    /**
     * Handle panel login
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'remember' => 'boolean',
        ]);

        try {
            $credentials = [
                'email' => $validated['email'],
                'password' => $validated['password'],
                'status' => 'active',
            ];

            if (Auth::attempt($credentials, $request->filled('remember'))) {
                $request->session()->regenerate();
                
                $user = Auth::user();

                // Check if user has panel access permission
                if (!$user->hasPermission('panel.access')) {
                    Auth::logout();
                    throw new \Exception('You do not have access to this panel.');
                }

                return redirect()->route('panel.dashboard')
                    ->with('success', 'Welcome back, ' . $user->name);
            }

            throw new \Exception('Invalid email or password.');
        } catch (\Exception $e) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Redirect to Google for panel authentication
     */
    public function redirectToGoogle()
    {
        $callbackUrl = request()->getSchemeAndHttpHost() . '/panel/login/google/callback';
        
        return \Laravel\Socialite\Facades\Socialite::driver('google')
            ->redirectUrl($callbackUrl)
            ->stateless()
            ->redirect();
    }

    /**
     * Handle Google callback for panel
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = \Laravel\Socialite\Facades\Socialite::driver('google')->stateless()->user();
            
            $user = \App\Models\User::where('email', $googleUser->getEmail())
                ->where('status', 'active')
                ->first();

            if (!$user) {
                throw new \Exception('User account not found or inactive.');
            }

            // Check if user has panel access permission
            if (!$user->hasPermission('panel.access')) {
                throw new \Exception('You do not have access to this panel.');
            }

            Auth::login($user, true);

            return redirect()->route('panel.dashboard')
                ->with('success', 'Welcome back, ' . $user->name);
        } catch (\Exception $e) {
            return redirect()->route('panel.login')
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Handle panel logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('panel.login')
            ->with('success', 'You have been logged out successfully.');
    }
}
