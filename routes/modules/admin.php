<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
| Routes untuk admin yang mengelola seluruh sistem
*/

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
    // Route::get('/reports/sales', [\App\Http\Controllers\Admin\ReportController::class, 'sales'])->name('reports.sales');
    // Route::get('/reports/users', [\App\Http\Controllers\Admin\ReportController::class, 'users'])->name('reports.users');

    // Banner Management
    // Route::resource('banners', \App\Http\Controllers\Admin\BannerController::class);

    // Promo Management
    // Route::resource('promos', \App\Http\Controllers\Admin\PromoController::class);

    // FAQ Management
    // Route::resource('faqs', \App\Http\Controllers\Admin\FaqController::class);

    // Static Page Management
    // Route::resource('pages', \App\Http\Controllers\Admin\PageController::class);

    // Email Template Management
    // Route::resource('email-templates', \App\Http\Controllers\Admin\EmailTemplateController::class);
});
