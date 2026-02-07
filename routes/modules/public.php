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
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\LanguageController;
use App\Models\SubscriptionPlan;


/*
|--------------------------------------------------------------------------
| Public/Guest Routes
|--------------------------------------------------------------------------
| Routes yang bisa diakses tanpa login (landing page, info pages, dll)
*/

// Sitemap (outside middleware for better SEO crawling)
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Homepage
Route::middleware(['user.session'])->group(function () {
    // Language Switch Route - harus di dalam middleware untuk session berjalan
    Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Destinations Page
    Route::get('/destinations', [DestinationController::class, 'index'])->name('destinations');
    Route::get('/destinations/{slug}', [DestinationController::class, 'show'])->name('destination.show')->middleware('record.view');


    Route::get('/help-center', [PolicyController::class, 'show'])->defaults('type', 'help')->name('help-center');
    Route::get('/privacy-policy', [PolicyController::class, 'show'])->defaults('type', 'privacy')->name('privacy-policy');
    Route::get('/terms-conditions', [PolicyController::class, 'show'])->defaults('type', 'terms')->name('terms-conditions');
    Route::get('/shopping-policy', [PolicyController::class, 'show'])->defaults('type', 'shopping')->name('shopping-policy');
    Route::get('/payment-policy', [PolicyController::class, 'show'])->defaults('type', 'payment')->name('payment-policy');

    // Page Account (Public account page/info)
    // Account Routes
    Route::middleware('auth')->group(function () {
        Route::get('/page-account', [AccountController::class, 'index'])->name('page-account');
        Route::put('/profile/update', [AccountController::class, 'updateProfile'])->name('profile.update');
        Route::post('/account/update-avatar', [AccountController::class, 'updateAvatar'])->name('account.update.avatar');
        Route::put('/password/update', [AccountController::class, 'updatePassword'])->name('account.password.update');
    });

    // Route::put('/password/update', [AccountController::class, 'updatePassword'])->name('password.update')->middleware('auth');
    Route::get('/help/content/{type}', [HelpController::class, 'loadContent'])->name('help.content');

    Route::get('/collections/{collection:slug}', [CollectionController::class, 'show'])->name('collections.show');
    Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
    Route::get('/blogs/tag/{tag}', [BlogController::class, 'byTag'])->name('blogs.by.tag');
    Route::get('/blogs/{slug}', [BlogController::class, 'show'])->name('blogs.show');
    Route::get('/ebooks/{slug}', [EbookController::class, 'show'])->name('ebooks.show');
    Route::post('/ratings', [RatingController::class, 'store'])->name('ratings.store')->middleware('auth');
    // Route::get('/reader/{slug}', [ReaderController::class, 'show'])->name('reader.show')->middleware('premium');
    Route::get('/category/{slug}', [FrontendCategoryController::class, 'show'])->name('category.show');
    Route::get('/pricing', [PricingController::class, 'index'])->name('pricing');
    Route::get('/promo', [PromoController::class, 'index'])->name('promo');
    Route::get('/promo/{slug}', [PromoController::class, 'showDetail'])->name('promo.detail.show');
    // Route::post('/reader/update-progress', [ReaderController::class, 'updateProgress'])->name('reader.updateProgress');
    Route::get('/about-us', [AboutController::class, 'index'])->name('about-us');
    Route::get('/contact', [ContactController::class, 'index'])->name('contact');
    Route::get('/faq', [FaqController::class, 'faqs'])->name('faq');
    Route::get('/search', [HomeController::class, 'search'])->name('search');
    Route::get('/payment/success', [SubscriptionController::class, 'paymentSuccess'])->name('payment.success');
    Route::post('/ebooks/{id}/save', [EbookController::class, 'toggleSaved'])
        ->name('ebooks.save.toggle')
        ->middleware('auth');
    Route::get('/filter-by-city/{slug}', [HomeController::class, 'filterByCity'])
        ->name('city-filter');

    // Untuk webhook Mayar (tidak perlu login)
    // Route::post('/api/payment/mayar-callback', [SubscriptionController::class, 'mayarCallback'])
    //     ->name('api.payment.mayar-callback');
    // routes/web.php
    Route::post('/api/payment/mayar-callback', [SubscriptionController::class, 'mayarCallback'])
        ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
    Route::match(['get', 'post'], '/subscribe/{slug}', [SubscriptionController::class, 'redirectToPaymentLink'])
        ->middleware('auth')
        ->name('subscribe.redirect');

    // Subscription management routes (require authentication)
    Route::middleware('auth')->group(function () {
        Route::post('/subscription/renew', [SubscriptionController::class, 'renewSubscription'])
            ->name('subscription.renew');
        Route::post('/subscription/upgrade', [SubscriptionController::class, 'upgradeSubscription'])
            ->name('subscription.upgrade');
        Route::post('/subscription/downgrade', [SubscriptionController::class, 'downgradeSubscription'])
            ->name('subscription.downgrade');
    });

    Route::post('/subscription/create', [SubscriptionController::class, 'create'])
        ->name('api.subscription.create');
});
