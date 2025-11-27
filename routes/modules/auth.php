<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
| Routes untuk login, register, dan OAuth
*/

// User Authentication (Guest Only)
Route::middleware('guest')->group(function () {
    // Login Routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    // Register Routes
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    // Google OAuth Routes (User)
    Route::get('/login/google', [LoginController::class, 'redirectToGoogle'])->name('login.google');
    Route::get('/login/google/callback', [LoginController::class, 'handleGoogleCallback']);

    // Google Registration Routes
    Route::get('/register/google', [RegisterController::class, 'showGoogleRegistrationForm'])->name('register.google');
    Route::post('/register/google', [RegisterController::class, 'completeGoogleRegistration'])->name('register.google.complete');
});

// Admin Authentication (Guest Only)
Route::prefix('admin')->name('admin.')->middleware('guest')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    
    // Google OAuth Routes for Admin
    Route::get('/login/google', [AdminAuthController::class, 'redirectToGoogle'])->name('login.google');
    Route::get('/login/google/callback', [AdminAuthController::class, 'handleGoogleCallback'])->name('login.google.callback');
});

// Logout Routes (Authenticated)
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout')->middleware('auth');

// Dashboard Redirect (Auto-redirect based on user type)
Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if ($user->user_type === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->user_type === 'creator') {
        return redirect()->route('creator.dashboard');
    }
    
    return redirect()->route('user.dashboard');
})->middleware('auth')->name('dashboard');
