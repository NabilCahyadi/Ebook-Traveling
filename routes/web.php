<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\AdminDashboardController;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    // Login Routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    // Register Routes
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    // Google OAuth Routes
    Route::get('/login/google', [LoginController::class, 'redirectToGoogle'])->name('login.google');
    Route::get('/login/google/callback', [LoginController::class, 'handleGoogleCallback']);

    // Google Registration Routes
    Route::get('/register/google', [RegisterController::class, 'showGoogleRegistrationForm'])->name('register.google');
    Route::post('/register/google', [RegisterController::class, 'completeGoogleRegistration'])->name('register.google.complete');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Dashboard (protected route) - redirects based on user type
Route::get('/dashboard', function () {
    if (auth()->user()->user_type === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return view('user.dashboard');
})->middleware('auth')->name('dashboard');

// User Routes - Ebook Reader
Route::middleware('auth')->group(function () {
    Route::get('/read/{slug}', [\App\Http\Controllers\User\EbookReaderController::class, 'read'])->name('ebook.read');
    
    // Text content
    Route::post('/api/set-reader-token', function(\Illuminate\Http\Request $request) {
        session(['reader_token_' . $request->ebook_id => $request->token]);
        return response()->json(['success' => true]);
    });
    Route::get('/api/ebook/{id}/content', [\App\Http\Controllers\User\EbookReaderController::class, 'getContent'])->name('ebook.content');
    
    // PDF handling
    Route::post('/api/set-pdf-token', [\App\Http\Controllers\User\EbookReaderController::class, 'setPdfToken']);
    Route::get('/api/ebook/{id}/pdf', [\App\Http\Controllers\User\EbookReaderController::class, 'servePdf'])->name('ebook.pdf');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // User Management Routes
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);

    // Ebook Routes
    Route::resource('ebooks', \App\Http\Controllers\Admin\EbookController::class);

    // Category Routes
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);

    // City Routes
    Route::resource('cities', \App\Http\Controllers\Admin\CityController::class);
});
