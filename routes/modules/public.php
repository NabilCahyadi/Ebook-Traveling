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
use App\Http\Controllers\PromoDetailController;

/*
|--------------------------------------------------------------------------
| Public/Guest Routes
|--------------------------------------------------------------------------
| Routes yang bisa diakses tanpa login (landing page, info pages, dll)
*/

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Pricing Page
// Route::get('/pricing', function () {
//     return view('pricing');
// })->name('pricing');

// Destinations Page
Route::get('/destinations', [DestinationController::class, 'index'])->name('destinations')->middleware('permission:access_destinations');
Route::get('/destinations/{slug}', [DestinationController::class, 'show'])->name('destination.show')->middleware(['permission:access_destinations', 'record.view']);

// Promo Page
// Route::get('/promo', function () {
//     return view('promo');
// })->name('promo');

// Contact Page
Route::get('/contact', function () {
    return view('contact');
})->name('contact')->middleware('permission:access_contact_us');

// Help Center
Route::get('/help-center', function () {
    return view('help-center');
})->name('help-center')->middleware('permission:access_help_center');

// About Us
Route::get('/about-us', function () {
    return view('about-us');
})->name('about-us')->middleware('permission:access_about_us');

// Terms & Conditions
Route::get('/terms-conditions', function () {
    return view('terms-conditions');
})->name('terms-conditions')->middleware('permission:access_terms_conditions');

// Privacy Policy
Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy-policy')->middleware('permission:access_privacy_policy');

// Shopping Policy
Route::get('/shopping-policy', function () {
    return view('shopping-policy');
})->name('shopping-policy')->middleware('permission:access_shopping_policy');

// Payment Policy
Route::get('/payment-policy', function () {
    return view('payment-policy');
})->name('payment-policy')->middleware('permission:access_payment_policy');

// FAQ
Route::get('/faq', function () {
    return view('faq');
})->name('faq')->middleware('permission:access_faq');

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
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index')->middleware('permission:access_blog');
Route::get('/blogs/tag/{tag}', [BlogController::class, 'byTag'])->name('blogs.by.tag')->middleware('permission:access_blog');
Route::get('/blogs/{slug}', [BlogController::class, 'show'])->name('blogs.show')->middleware('permission:access_blog');
Route::get('/ebooks/{slug}', [EbookController::class, 'show'])->name('ebooks.show');
Route::post('/ratings', [RatingController::class, 'store'])->name('ratings.store')->middleware('auth');
Route::get('/reader/{slug}', [ReaderController::class, 'show'])->name('reader.show')->middleware('premium');
Route::get('/category/{slug}', [FrontendCategoryController::class, 'show'])->name('category.show');
Route::get('/pricing', [PricingController::class, 'index'])->name('pricing')->middleware('permission:access_pricing');
Route::get('/promo', [PromoController::class, 'index'])->name('promo')->middleware('permission:access_promo');
Route::get('/promo/{slug}', [PromoController::class, 'showDetail'])->name('promo.detail.show')->middleware('permission:access_promo');








