<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\EbookController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ReaderController;
use App\Http\Controllers\FrontendCategoryController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactController as ControllersContactController;
use App\Http\Controllers\PromoDetailController;

/*
|--------------------------------------------------------------------------
| Public/Guest Routes
|--------------------------------------------------------------------------
| Routes yang bisa diakses tanpa login (landing page, info pages, dll)
*/

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Destinations Page
Route::get('/destinations', [DestinationController::class, 'index'])->name('destinations');
Route::get('/destinations/{slug}', [DestinationController::class, 'show'])->name('destination.show')->middleware('record.view');

// Help Center
Route::get('/help-center', function () {
    return view('help-center');
})->name('help-center');

// Terms & Conditions
Route::get('/terms-conditions', function () {
    return view('terms-conditions');
})->name('terms-conditions');

// Privacy Policy
Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy-policy');

// Shopping Policy
Route::get('/shopping-policy', function () {
    return view('shopping-policy');
})->name('shopping-policy');

// Payment Policy
Route::get('/payment-policy', function () {
    return view('payment-policy');
})->name('payment-policy');

// FAQ
Route::get('/faq', function () {
    return view('faq');
})->name('faq');

// Page Account (Public account page/info)
// Account Routes
Route::middleware('auth')->group(function () {
    Route::get('/page-account', [AccountController::class, 'index'])->name('page-account');
    Route::put('/profile/update', [AccountController::class, 'updateProfile'])->name('profile.update');
    Route::post('/account/update-avatar', [AccountController::class, 'updateAvatar'])->name('account.update.avatar');
    Route::put('/password/update', [AccountController::class, 'updatePassword'])->name('password.update');
});

// Route::put('/password/update', [AccountController::class, 'updatePassword'])->name('password.update')->middleware('auth');
Route::get('/help/content/{type}', [HelpController::class, 'loadContent'])->name('help.content');

Route::get('/collections/{collection:slug}', [CollectionController::class, 'show'])->name('collections.show');
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
Route::get('/blogs/tag/{tag}', [BlogController::class, 'byTag'])->name('blogs.by.tag');
Route::get('/blogs/{slug}', [BlogController::class, 'show'])->name('blogs.show');
Route::get('/ebooks/{slug}', [EbookController::class, 'show'])->name('ebooks.show');
Route::post('/ratings', [RatingController::class, 'store'])->name('ratings.store')->middleware('auth');
Route::get('/reader/{slug}', [ReaderController::class, 'show'])->name('reader.show')->middleware('premium');
Route::get('/category/{slug}', [FrontendCategoryController::class, 'show'])->name('category.show');
Route::get('/pricing', [PricingController::class, 'index'])->name('pricing');
Route::get('/promo', [PromoController::class, 'index'])->name('promo');
Route::get('/promo/{slug}', [PromoController::class, 'showDetail'])->name('promo.detail.show');
Route::post('/reader/update-progress', [ReaderController::class, 'updateProgress'])->name('reader.updateProgress');
Route::get('/about-us', [AboutController::class, 'index'])->name('about-us');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');

// Search Ebooks
Route::get('/search', [HomeController::class, 'search'])->name('search');

// Bungkus dengan prefix 'api'
Route::prefix('api')->group(function () {
    Route::post('/subscription/create', [SubscriptionController::class, 'create'])
        ->middleware('auth'); // Tetap gunakan middleware auth

    Route::post('/payment/mayar-callback', [SubscriptionController::class, 'mayarCallback']);
});
