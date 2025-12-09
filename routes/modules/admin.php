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
    Route::get('users-trashed', [\App\Http\Controllers\Admin\UserController::class, 'trashed'])->name('users.trashed');
    Route::patch('users/{id}/restore', [\App\Http\Controllers\Admin\UserController::class, 'restore'])->name('users.restore');
    Route::delete('users/{id}/force-delete', [\App\Http\Controllers\Admin\UserController::class, 'forceDelete'])->name('users.force-delete');

    // User Activity Logs (non-admin users only)
    Route::get('user-activity-logs', [\App\Http\Controllers\Admin\UserActivityLogController::class, 'index'])->name('user-activity-logs.index');
    Route::get('user-activity-logs/export', [\App\Http\Controllers\Admin\UserActivityLogController::class, 'export'])->name('user-activity-logs.export');
    Route::get('user-activity-logs/{id}', [\App\Http\Controllers\Admin\UserActivityLogController::class, 'show'])->name('user-activity-logs.show');

    // Role Management
    Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);
    Route::get('roles-trashed', [\App\Http\Controllers\Admin\RoleController::class, 'trashed'])->name('roles.trashed');
    Route::patch('roles/{id}/restore', [\App\Http\Controllers\Admin\RoleController::class, 'restore'])->name('roles.restore');
    Route::delete('roles/{id}/force-delete', [\App\Http\Controllers\Admin\RoleController::class, 'forceDelete'])->name('roles.force-delete');

    // Permission Management
    Route::resource('permissions', \App\Http\Controllers\Admin\PermissionController::class);

    // Ebook Management (All ebooks in system)
    Route::get('ebooks/pending-approval', [\App\Http\Controllers\Admin\EbookController::class, 'pendingApproval'])->name('ebooks.pending-approval');
    Route::get('ebooks/trashed', [\App\Http\Controllers\Admin\EbookController::class, 'trashed'])->name('ebooks.trashed');
    Route::patch('ebooks/{ebook}/restore', [\App\Http\Controllers\Admin\EbookController::class, 'restore'])->name('ebooks.restore');
    Route::delete('ebooks/{ebook}/force-delete', [\App\Http\Controllers\Admin\EbookController::class, 'forceDelete'])->name('ebooks.force-delete');
    Route::post('ebooks/{id}/approve', [\App\Http\Controllers\Admin\EbookController::class, 'approve'])->name('ebooks.approve');
    Route::post('ebooks/{id}/reject', [\App\Http\Controllers\Admin\EbookController::class, 'reject'])->name('ebooks.reject');
    Route::resource('ebooks', \App\Http\Controllers\Admin\EbookController::class);

    // System Settings
    Route::post('system-settings/update', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'update'])->name('system-settings.update');

    // Category Management
    Route::get('categories/trashed', [\App\Http\Controllers\Admin\CategoryController::class, 'trashed'])->name('categories.trashed');
    Route::patch('categories/{category}/restore', [\App\Http\Controllers\Admin\CategoryController::class, 'restore'])->name('categories.restore');
    Route::delete('categories/{category}/force-delete', [\App\Http\Controllers\Admin\CategoryController::class, 'forceDelete'])->name('categories.force-delete');
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);

    // City/Location Management
    Route::resource('cities', \App\Http\Controllers\Admin\CityController::class);

    // Subscription Plan Management
    Route::get('subscription-plans/trashed', [\App\Http\Controllers\Admin\SubscriptionPlanController::class, 'trashed'])->name('subscription-plans.trashed');
    Route::patch('subscription-plans/{subscription_plan}/restore', [\App\Http\Controllers\Admin\SubscriptionPlanController::class, 'restore'])->name('subscription-plans.restore');
    Route::delete('subscription-plans/{subscription_plan}/force-delete', [\App\Http\Controllers\Admin\SubscriptionPlanController::class, 'forceDelete'])->name('subscription-plans.force-delete');
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
    Route::get('blogs/trashed', [\App\Http\Controllers\Admin\BlogController::class, 'trashed'])->name('blogs.trashed');
    Route::patch('blogs/{blog}/restore', [\App\Http\Controllers\Admin\BlogController::class, 'restore'])->name('blogs.restore');
    Route::delete('blogs/{blog}/force-delete', [\App\Http\Controllers\Admin\BlogController::class, 'forceDelete'])->name('blogs.force-delete');
    Route::resource('blogs', \App\Http\Controllers\Admin\BlogController::class);

    // Blog Category Management
    Route::get('blog-categories/trashed', [\App\Http\Controllers\Admin\BlogCategoryController::class, 'trashed'])->name('blog-categories.trashed');
    Route::patch('blog-categories/{id}/restore', [\App\Http\Controllers\Admin\BlogCategoryController::class, 'restore'])->name('blog-categories.restore');
    Route::delete('blog-categories/{id}/force-delete', [\App\Http\Controllers\Admin\BlogCategoryController::class, 'forceDelete'])->name('blog-categories.force-delete');
    Route::resource('blog-categories', \App\Http\Controllers\Admin\BlogCategoryController::class);

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

    // Website Management - Landing Page Sections
    Route::get('landing-sections', [\App\Http\Controllers\Admin\WebsiteManagementController::class, 'landingSections'])->name('landing-sections');
    Route::get('landing-section/{id}/preview', [\App\Http\Controllers\Admin\WebsiteManagementController::class, 'previewSection'])->name('landing-section.preview');
    Route::post('landing-sections/update', [\App\Http\Controllers\Admin\WebsiteManagementController::class, 'updateLandingSections'])->name('landing-sections.update');
    Route::post('landing-sections/add', [\App\Http\Controllers\Admin\WebsiteManagementController::class, 'addCollectionSection'])->name('landing-sections.add');
    Route::post('landing-section/{id}/toggle-visibility', [\App\Http\Controllers\Admin\WebsiteManagementController::class, 'toggleSectionVisibility'])->name('landing-section.toggle-visibility');
    Route::delete('landing-section/{id}/delete', [\App\Http\Controllers\Admin\WebsiteManagementController::class, 'deleteCollectionSection'])->name('landing-section.delete');

    // FAQ Management
    // Route::resource('faqs', \App\Http\Controllers\Admin\FaqController::class);

    // Static Page Management
    // Route::resource('pages', \App\Http\Controllers\Admin\PageController::class);

    // Email Template Management
    // Route::resource('email-templates', \App\Http\Controllers\Admin\EmailTemplateController::class);
});
