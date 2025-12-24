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
        if (Auth::guard('admin')->check()) {
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
            $credentials = [
                'email' => $validated['email'],
                'password' => $validated['password'],
                'status' => 'active',
            ];

            if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
                $request->session()->regenerate();
                
                $admin = Auth::guard('admin')->user();
                $admin->updateLastLogin();

                return redirect()->route('admin.dashboard')
                    ->with('success', 'Welcome back, ' . $admin->name);
            }

            throw new \Exception('Invalid email or password.');
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
        $callbackUrl = request()->getSchemeAndHttpHost() . '/admin/login/google/callback';
        
        return \Laravel\Socialite\Facades\Socialite::driver('google')
            ->redirectUrl($callbackUrl)
            ->stateless()
            ->redirect();
    }

    /**
     * Handle Google callback for admin
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = \Laravel\Socialite\Facades\Socialite::driver('google')->stateless()->user();
            
            $admin = \App\Models\Admin::where('email', $googleUser->getEmail())
                ->where('status', 'active')
                ->first();

            if (!$admin) {
                throw new \Exception('Admin account not found or inactive.');
            }

            Auth::guard('admin')->login($admin, true);
            $admin->updateLastLogin();

            return redirect()->route('admin.dashboard')
                ->with('success', 'Welcome back, ' . $admin->name);
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
        Auth::guard('admin')->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', 'You have been logged out successfully.');
    }
}
