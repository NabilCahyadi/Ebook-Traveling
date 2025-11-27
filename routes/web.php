<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;

Route::get('/', function () {
    return view('index');
});
Route::get('/pricing', function () {
    return view('pricing');
})->name('pricing');
Route::get('/destinations', function () {
    return view('destinations');
})->name('destinations');
route::get('/blogs', function () {
    return view('blogs');
})->name('blogs');
route::get('/promo', function () {
    return view('promo');
})->name('promo');
route::get('/contact', function () {
    return view('contact');
})->name('contact');
route::get('/help-center', function () {
    return view('help-center');
})->name('help-center');
route::get('/about-us', function () {
    return view('about-us');
})->name('about-us');
route::get('/terms-conditions', function () {
    return view('terms-conditions');
})->name('terms-conditions');
route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy-policy');
route::get('/shopping-policy', function () {
    return view('shopping-policy');
})->name('shopping-policy');
route::get('/payment-policy', function () {
    return view('payment-policy');
})->name('payment-policy');
route::get('/faq', function () {
    return view('faq');
})->name('faq');
route::get('/page-account', function () {
    return view('page-account');
})->name('page-account');

// Admin Authentication Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
        
        // Google OAuth Routes for Admin
        Route::get('/login/google', [AdminAuthController::class, 'redirectToGoogle'])->name('login.google');
        Route::get('/login/google/callback', [AdminAuthController::class, 'handleGoogleCallback'])->name('login.google.callback');
    });

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    });
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
    return redirect()->route('user.dashboard');
})->middleware('auth')->name('dashboard');

// User Dashboard
Route::get('/user/dashboard', function () {
    return view('user.dashboard');
})->middleware('auth')->name('user.dashboard');

// User Routes - Ebook Reader
Route::middleware('auth')->group(function () {
    Route::get('/read/{slug}', [\App\Http\Controllers\User\EbookReaderController::class, 'read'])->name('ebook.read');

    // Text content
    Route::post('/api/set-reader-token', function (\Illuminate\Http\Request $request) {
        session(['reader_token_' . $request->ebook_id => $request->token]);
        return response()->json(['success' => true]);
    });
    Route::get('/api/ebook/{id}/content', [\App\Http\Controllers\User\EbookReaderController::class, 'getContent'])->name('ebook.content');

    // PDF handling
    Route::post('/api/set-pdf-token', [\App\Http\Controllers\User\EbookReaderController::class, 'setPdfToken']);
    Route::get('/api/ebook/{id}/pdf', [\App\Http\Controllers\User\EbookReaderController::class, 'servePdf'])->name('ebook.pdf');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // User Management Routes
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);

    // Ebook Routes
    Route::resource('ebooks', \App\Http\Controllers\Admin\EbookController::class);

    // Category Routes
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);

    // City Routes
    Route::resource('cities', \App\Http\Controllers\Admin\CityController::class);

    // Subscription Plan Routes
    Route::resource('subscription-plans', \App\Http\Controllers\Admin\SubscriptionPlanController::class);

    // Manual Subscription Routes
    Route::resource('manual-subscriptions', \App\Http\Controllers\Admin\ManualSubscriptionController::class);
    Route::get('manual-subscriptions/{id}/extend', [\App\Http\Controllers\Admin\ManualSubscriptionController::class, 'extend'])->name('manual-subscriptions.extend');
    Route::post('manual-subscriptions/{id}/extend', [\App\Http\Controllers\Admin\ManualSubscriptionController::class, 'processExtend'])->name('manual-subscriptions.process-extend');
    Route::post('manual-subscriptions/{id}/cancel', [\App\Http\Controllers\Admin\ManualSubscriptionController::class, 'cancel'])->name('manual-subscriptions.cancel');

    // Payment Link Routes
    Route::get('payment-links', [\App\Http\Controllers\Admin\ManualSubscriptionController::class, 'paymentLinks'])->name('payment-links.index');
    Route::get('payment-links/create', [\App\Http\Controllers\Admin\ManualSubscriptionController::class, 'showPaymentLinkForm'])->name('payment-links.create');
    Route::post('payment-links/generate', [\App\Http\Controllers\Admin\ManualSubscriptionController::class, 'generatePaymentLink'])->name('payment-links.generate');
    Route::get('payment-links/{id}', [\App\Http\Controllers\Admin\ManualSubscriptionController::class, 'showPaymentLink'])->name('manual-subscriptions.payment-link.show');

    // Blog Routes
    Route::resource('blogs', \App\Http\Controllers\Admin\BlogController::class);
});
