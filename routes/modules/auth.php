<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
| Routes untuk login, register, dan OAuth
*/

// User Authentication (Guest Only)
Route::middleware(['user.session', 'guest:web'])->group(function () {
    // Login Routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    // Forgot Password Routes
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendCode'])->name('password.send-code');
    Route::get('/verify-code', [ForgotPasswordController::class, 'showVerifyForm'])->name('password.verify-code');
    Route::post('/verify-code', [ForgotPasswordController::class, 'verifyCode'])->name('password.verify');
    Route::post('/resend-code', [ForgotPasswordController::class, 'resendCode'])->name('password.resend-code');
    Route::get('/reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');

    // Register Routes
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    // Google OAuth Routes (User)
    Route::get('/login/google', [LoginController::class, 'redirectToGoogle'])->name('login.google');
    Route::get('/login/google/callback', [LoginController::class, 'handleGoogleCallback']);

    // Google Registration Routes
    Route::get('/register/google', [RegisterController::class, 'redirectToGoogleRegister'])->name('register.google');
    Route::get('/register/google/callback', [RegisterController::class, 'handleGoogleRegisterCallback'])->name('register.google.callback');
    Route::get('/register/google/form', [RegisterController::class, 'showGoogleRegistrationForm'])->name('register.google.form');
    Route::post('/register/google', [RegisterController::class, 'completeGoogleRegistration'])->name('register.google.complete');
});

// Admin Authentication (Guest Only)
Route::prefix('admin')->name('admin.')->middleware(['admin.session'])->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');

    // Google OAuth Routes for Admin
    Route::get('/login/google', [AdminAuthController::class, 'redirectToGoogle'])->name('login.google');
    Route::get('/login/google/callback', [AdminAuthController::class, 'handleGoogleCallback'])->name('login.google.callback');
});

// Logout Routes (Authenticated)
Route::post('/logout', [LoginController::class, 'userLogout'])->name('user.logout')->middleware(['user.session', 'auth']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout')->middleware(['admin.session', 'auth:admin']);

// Dashboard Redirect (Auto-redirect based on user type)
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->user_type === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->user_type === 'creator') {
        return redirect()->route('creator.dashboard');
    }

    return redirect()->route('home');
})->middleware('auth')->name('dashboard');
