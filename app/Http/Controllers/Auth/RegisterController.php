<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
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

        // Create new user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'status' => 'active',
            'language_pref' => 'en',
            'email_verified_at' => now(), // Auto verify for now
        ]);

        // Log the user in
        Auth::login($user);

        return redirect()->route('dashboard')
            ->with('success', 'Welcome to Ebook Traveling, ' . $user->name . '! Your account has been created successfully.');
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

        // Create new user with Google data
        $user = User::create([
            'name' => $validated['name'],
            'email' => $googleUser['email'],
            'google_id' => $googleUser['google_id'],
            'avatar' => $googleUser['avatar'],
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make(Str::random(32)), // Random password for Google users
            'status' => 'active',
            'language_pref' => $validated['language_pref'],
            'email_verified_at' => now(), // Google accounts are pre-verified
        ]);

        // Clear Google user session
        session()->forget('google_user');

        // Log the user in
        Auth::login($user, true);

        return redirect()->route('dashboard')
            ->with('success', 'Welcome to Ebook Traveling, ' . $user->name . '! Your account has been created successfully.');
    }
}
