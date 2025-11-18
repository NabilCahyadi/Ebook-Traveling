<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

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
            'language_pref' => ['required', 'in:en,id'],
            'terms' => ['required', 'accepted'],
        ], [
            'name.required' => 'Full name is required.',
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
            return back()->with('error', 'Registration failed. Please try again.');
        }
    }
}
