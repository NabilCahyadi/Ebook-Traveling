<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;

/*
|--------------------------------------------------------------------------
| Public Routes (Guest)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/pricing', function () {
    return view('pricing');
})->name('pricing');

Route::get('/destinations', function () {
    return view('destinations');
})->name('destinations');

Route::get('/blogs', function () {
    return view('blogs');
})->name('blogs');

Route::get('/promo', function () {
    return view('promo');
})->name('promo');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/help-center', function () {
    return view('help-center');
})->name('help-center');

Route::get('/about-us', function () {
    return view('about-us');
})->name('about-us');

Route::get('/terms-conditions', function () {
    return view('terms-conditions');
})->name('terms-conditions');

Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy-policy');

Route::get('/shopping-policy', function () {
    return view('shopping-policy');
})->name('shopping-policy');

Route::get('/payment-policy', function () {
    return view('payment-policy');
})->name('payment-policy');

Route::get('/faq', function () {
    return view('faq');
})->name('faq');

Route::get('/page-account', function () {
    return view('page-account');
})->name('page-account');

/*
|--------------------------------------------------------------------------
| Authentication Routes (Guest Only)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    // User Login Routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    // User Register Routes
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    // Google OAuth Routes (User)
    Route::get('/login/google', [LoginController::class, 'redirectToGoogle'])->name('login.google');
    Route::get('/login/google/callback', [LoginController::class, 'handleGoogleCallback']);

    // Google Registration Routes
    Route::get('/register/google', [RegisterController::class, 'showGoogleRegistrationForm'])->name('register.google');
    Route::post('/register/google', [RegisterController::class, 'completeGoogleRegistration'])->name('register.google.complete');
});

// Logout Route (All authenticated users)
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

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

/*
|--------------------------------------------------------------------------
| User Routes (Customer/Pelanggan)
|--------------------------------------------------------------------------
| Routes untuk pelanggan yang membeli dan membaca ebook
*/

Route::prefix('user')->name('user.')->middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('dashboard');

    // Ebook Reader Routes
    Route::get('/read/{slug}', [\App\Http\Controllers\User\EbookReaderController::class, 'read'])->name('ebook.read');
    
    // Ebook Content API
    Route::post('/api/set-reader-token', function (\Illuminate\Http\Request $request) {
        session(['reader_token_' . $request->ebook_id => $request->token]);
        return response()->json(['success' => true]);
    });
    
    Route::get('/api/ebook/{id}/content', [\App\Http\Controllers\User\EbookReaderController::class, 'getContent'])->name('ebook.content');
    
    // PDF Routes
    Route::post('/api/set-pdf-token', [\App\Http\Controllers\User\EbookReaderController::class, 'setPdfToken']);
    Route::get('/api/ebook/{id}/pdf', [\App\Http\Controllers\User\EbookReaderController::class, 'servePdf'])->name('ebook.pdf');

    // User Profile & Settings
    // Route::get('/profile', [UserProfileController::class, 'index'])->name('profile');
    // Route::put('/profile', [UserProfileController::class, 'update'])->name('profile.update');
    
    // User Library (Ebooks yang sudah dibeli)
    // Route::get('/library', [UserLibraryController::class, 'index'])->name('library');
    
    // User Subscriptions
    // Route::get('/subscriptions', [UserSubscriptionController::class, 'index'])->name('subscriptions');
    
    // User Wishlist/Saved Books
    // Route::get('/wishlist', [UserWishlistController::class, 'index'])->name('wishlist');
});

/*
|--------------------------------------------------------------------------
| Creator Routes
|--------------------------------------------------------------------------
| Routes untuk content creator yang membuat dan mengelola ebook mereka sendiri
*/

Route::prefix('creator')->name('creator.')->middleware(['auth', 'creator'])->group(function () {
    // Creator Dashboard
    Route::get('/dashboard', function () {
        return view('creator.dashboard');
    })->name('dashboard');

    // Creator's Ebook Management (hanya ebook milik mereka sendiri)
    // Route::resource('ebooks', \App\Http\Controllers\Creator\EbookController::class);
    
    // Creator's Analytics
    // Route::get('/analytics', [\App\Http\Controllers\Creator\AnalyticsController::class, 'index'])->name('analytics');
    
    // Creator's Earnings
    // Route::get('/earnings', [\App\Http\Controllers\Creator\EarningsController::class, 'index'])->name('earnings');
    
    // Creator Profile & Settings
    // Route::get('/profile', [\App\Http\Controllers\Creator\ProfileController::class, 'index'])->name('profile');
    // Route::put('/profile', [\App\Http\Controllers\Creator\ProfileController::class, 'update'])->name('profile.update');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
| Routes untuk admin yang mengelola seluruh sistem (users, content, settings)
*/

// Admin Authentication Routes (Separate from user auth)
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

// Admin Protected Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // User Management (All users: admin, creator, customer)
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);

    // Ebook Management (All ebooks in system)
    Route::resource('ebooks', \App\Http\Controllers\Admin\EbookController::class);

    // Category Management
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);

    // City/Location Management
    Route::resource('cities', \App\Http\Controllers\Admin\CityController::class);

    // Subscription Plan Management
    Route::resource('subscription-plans', \App\Http\Controllers\Admin\SubscriptionPlanController::class);

    // Manual Subscription Management
    Route::resource('manual-subscriptions', \App\Http\Controllers\Admin\ManualSubscriptionController::class);
    Route::get('manual-subscriptions/{id}/extend', [\App\Http\Controllers\Admin\ManualSubscriptionController::class, 'extend'])->name('manual-subscriptions.extend');
    Route::post('manual-subscriptions/{id}/extend', [\App\Http\Controllers\Admin\ManualSubscriptionController::class, 'processExtend'])->name('manual-subscriptions.process-extend');
    Route::post('manual-subscriptions/{id}/cancel', [\App\Http\Controllers\Admin\ManualSubscriptionController::class, 'cancel'])->name('manual-subscriptions.cancel');

    // Payment Link Management (Mayar.id Integration)
    Route::get('payment-links', [\App\Http\Controllers\Admin\ManualSubscriptionController::class, 'paymentLinks'])->name('payment-links.index');
    Route::get('payment-links/create', [\App\Http\Controllers\Admin\ManualSubscriptionController::class, 'showPaymentLinkForm'])->name('payment-links.create');
    Route::post('payment-links/generate', [\App\Http\Controllers\Admin\ManualSubscriptionController::class, 'generatePaymentLink'])->name('payment-links.generate');
    Route::get('payment-links/{id}', [\App\Http\Controllers\Admin\ManualSubscriptionController::class, 'showPaymentLink'])->name('manual-subscriptions.payment-link.show');

    // Blog Management
    Route::resource('blogs', \App\Http\Controllers\Admin\BlogController::class);

    // System Settings
    // Route::get('/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings');
    // Route::put('/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('settings.update');
    
    // Reports & Analytics
    // Route::get('/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports');
    
    // Banner Management
    // Route::resource('banners', \App\Http\Controllers\Admin\BannerController::class);
    
    // Promo Management
    // Route::resource('promos', \App\Http\Controllers\Admin\PromoController::class);
    
    // FAQ Management
    // Route::resource('faqs', \App\Http\Controllers\Admin\FaqController::class);
});
