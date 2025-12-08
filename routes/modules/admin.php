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

    // Profile Management
    Route::get('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [\App\Http\Controllers\Admin\ProfileController::class, 'updatePassword'])->name('profile.password.update');

    // User Management (All users: admin, creator, customer)
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);

    // User Activity Logs (non-admin users only)
    Route::get('user-activity-logs', [\App\Http\Controllers\Admin\UserActivityLogController::class, 'index'])->name('user-activity-logs.index');
    Route::get('user-activity-logs/export', [\App\Http\Controllers\Admin\UserActivityLogController::class, 'export'])->name('user-activity-logs.export');
    Route::get('user-activity-logs/{id}', [\App\Http\Controllers\Admin\UserActivityLogController::class, 'show'])->name('user-activity-logs.show');

    // Role Management
    Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);

    // Permission Management
    Route::resource('permissions', \App\Http\Controllers\Admin\PermissionController::class);

    // Ebook Management (All ebooks in system)
    Route::get('ebooks/pending-approval', [\App\Http\Controllers\Admin\EbookController::class, 'pendingApproval'])->name('ebooks.pending-approval');
    Route::post('ebooks/{id}/approve', [\App\Http\Controllers\Admin\EbookController::class, 'approve'])->name('ebooks.approve');
    Route::post('ebooks/{id}/reject', [\App\Http\Controllers\Admin\EbookController::class, 'reject'])->name('ebooks.reject');
    Route::resource('ebooks', \App\Http\Controllers\Admin\EbookController::class);

    // Category Management
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);

    // City/Location Management
    Route::resource('cities', \App\Http\Controllers\Admin\CityController::class);

    // Subscription Plan Management
    Route::resource('subscription-plans', \App\Http\Controllers\Admin\SubscriptionPlanController::class);

    // Order Management
    Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class)->only(['index', 'show']);
    Route::post('orders/{id}/update-status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');

    // Subscription Management
    Route::resource('subscriptions', \App\Http\Controllers\Admin\SubscriptionController::class)->only(['index', 'show']);

    // Manual Subscription Management
    // AJAX endpoints - HARUS DI ATAS resource route
    Route::get('manual-subscriptions/search-users', [\App\Http\Controllers\Admin\ManualSubscriptionController::class, 'searchUsers'])->name('manual-subscriptions.search-users');

    Route::resource('manual-subscriptions', \App\Http\Controllers\Admin\ManualSubscriptionController::class);
    Route::get('manual-subscriptions/{id}/extend', [\App\Http\Controllers\Admin\ManualSubscriptionController::class, 'extend'])->name('manual-subscriptions.extend');
    Route::post('manual-subscriptions/{id}/extend', [\App\Http\Controllers\Admin\ManualSubscriptionController::class, 'processExtend'])->name('manual-subscriptions.process-extend');
    Route::post('manual-subscriptions/{id}/cancel', [\App\Http\Controllers\Admin\ManualSubscriptionController::class, 'cancel'])->name('manual-subscriptions.cancel');

    // Active Subscribers
    Route::get('active-subscribers', [\App\Http\Controllers\Admin\SubscriberController::class, 'index'])->name('active-subscribers.index');

    // Subscription History
    Route::get('subscription-history', [\App\Http\Controllers\Admin\SubscriptionHistoryController::class, 'index'])->name('subscription-history.index');
    Route::get('subscription-history/{id}', [\App\Http\Controllers\Admin\SubscriptionHistoryController::class, 'show'])->name('subscription-history.show');
    Route::get('subscription-history-export', [\App\Http\Controllers\Admin\SubscriptionHistoryController::class, 'export'])->name('subscription-history.export');

    // Blog Management
    Route::get('blogs/archived', [\App\Http\Controllers\Admin\BlogController::class, 'archived'])->name('blogs.archived');
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

    // Promo Management (Subscription Promos)
    Route::resource('promos', \App\Http\Controllers\Admin\PromoController::class);
    Route::post('promos/{id}/toggle-active', [\App\Http\Controllers\Admin\PromoController::class, 'toggleActive'])->name('promos.toggle-active');

    // FAQ Management
    // Route::resource('faqs', \App\Http\Controllers\Admin\FaqController::class);

    // Static Page Management
    // Route::resource('pages', \App\Http\Controllers\Admin\PageController::class);

    // Email Template Management
    // Route::resource('email-templates', \App\Http\Controllers\Admin\EmailTemplateController::class);
});
