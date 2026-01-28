<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminManagement\AdminDashboardController;

/*
|--------------------------------------------------------------------------
| Admin Routes (Admin/Creator/Manager)
|--------------------------------------------------------------------------
| Routes untuk management panel yang bisa diakses berdasarkan permission
*/

Route::prefix('admin')->name('admin.')->middleware(['admin.session', 'auth:admin', 'admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/revenue-data', [AdminDashboardController::class, 'getRevenueData'])->name('dashboard.revenue-data');
    
    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('index');
        Route::get('/revenue', [\App\Http\Controllers\Admin\ReportController::class, 'revenue'])->name('revenue');
        Route::get('/ebook-performance', [\App\Http\Controllers\Admin\ReportController::class, 'ebookPerformance'])->name('ebook-performance');
        Route::get('/user-analytics', [\App\Http\Controllers\Admin\ReportController::class, 'userAnalytics'])->name('user-analytics');
        Route::get('/user-analytics-data', [\App\Http\Controllers\Admin\ReportController::class, 'getUserAnalyticsData'])->name('user-analytics-data');
        Route::get('/subscription-analytics', [\App\Http\Controllers\Admin\ReportController::class, 'salesAnalytics'])->name('subscription-analytics');
    });
    
    // Language Switcher
    Route::post('/language/{locale}', [\App\Http\Controllers\Admin\LanguageController::class, 'switch'])->name('language.switch');

    // Notifications
    Route::get('/notifications', [\App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/recent', [\App\Http\Controllers\Admin\NotificationController::class, 'getRecent'])->name('notifications.recent');
    Route::get('/notifications/unread-count', [\App\Http\Controllers\Admin\NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
    Route::post('/notifications/{id}/mark-as-read', [\App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
    Route::post('/notifications/mark-all-as-read', [\App\Http\Controllers\Admin\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-as-read');
    Route::delete('/notifications/{id}', [\App\Http\Controllers\Admin\NotificationController::class, 'destroy'])->name('notifications.destroy');

    // Profile Management
    Route::get('/profile', [\App\Http\Controllers\Admin\AdminManagement\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\Admin\AdminManagement\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [\App\Http\Controllers\Admin\AdminManagement\ProfileController::class, 'updatePassword'])->name('profile.password.update');

    // Admin Management
    Route::get('admins-trashed', [\App\Http\Controllers\Admin\AdminManagement\AdminController::class, 'trashed'])->name('admins.trashed');
    Route::patch('admins/{id}/restore', [\App\Http\Controllers\Admin\AdminManagement\AdminController::class, 'restore'])->name('admins.restore');
    Route::delete('admins/{id}/force-delete', [\App\Http\Controllers\Admin\AdminManagement\AdminController::class, 'forceDelete'])->name('admins.force-delete');
    Route::resource('admins', \App\Http\Controllers\Admin\AdminManagement\AdminController::class);
    Route::get('admins-export', [\App\Http\Controllers\Admin\AdminManagement\AdminController::class, 'export'])->name('admins.export');
    Route::get('admins/{id}/permissions', [\App\Http\Controllers\Admin\AdminManagement\AdminPermissionController::class, 'edit'])->name('admins.permissions.edit');
    Route::put('admins/{id}/permissions', [\App\Http\Controllers\Admin\AdminManagement\AdminPermissionController::class, 'update'])->name('admins.permissions.update');
    
    // Admin Permissions Matrix
    Route::get('admin-permissions-matrix', [\App\Http\Controllers\Admin\AdminManagement\AdminPermissionMatrixController::class, 'index'])->name('admin-permissions-matrix.index');
    Route::post('admin-permissions-matrix/update-permission', [\App\Http\Controllers\Admin\AdminManagement\AdminPermissionMatrixController::class, 'updatePermission'])->name('admin-permissions-matrix.update-permission');
    Route::post('admin-permissions-matrix/bulk-update', [\App\Http\Controllers\Admin\AdminManagement\AdminPermissionMatrixController::class, 'bulkUpdate'])->name('admin-permissions-matrix.bulk-update');
    Route::post('admin-permissions-matrix/apply-template', [\App\Http\Controllers\Admin\AdminManagement\AdminPermissionMatrixController::class, 'applyTemplate'])->name('admin-permissions-matrix.apply-template');
    Route::get('admin-permissions-matrix/export', [\App\Http\Controllers\Admin\AdminManagement\AdminPermissionMatrixController::class, 'export'])->name('admin-permissions-matrix.export');

    // Admin Activity Logs
    Route::get('admin-activity-logs', [\App\Http\Controllers\Admin\AdminManagement\AdminActivityLogController::class, 'index'])->name('admin-activity-logs.index');
    Route::get('admin-activity-logs/export', [\App\Http\Controllers\Admin\AdminManagement\AdminActivityLogController::class, 'export'])->name('admin-activity-logs.export');
    Route::delete('admin-activity-logs/cleanup', [\App\Http\Controllers\Admin\AdminManagement\AdminActivityLogController::class, 'cleanup'])->name('admin-activity-logs.cleanup');
    Route::get('admin-activity-logs/{id}', [\App\Http\Controllers\Admin\AdminManagement\AdminActivityLogController::class, 'show'])->name('admin-activity-logs.show');

    // User Management (All users: admin, creator, customer)
    // NOTE: /users/create must be defined BEFORE /users/{user} to avoid route collision
    Route::middleware(['admin.permission:users.create'])->group(function () {
        Route::get('users/create', [\App\Http\Controllers\Admin\UserManagement\UserController::class, 'create'])->name('users.create');
        Route::post('users', [\App\Http\Controllers\Admin\UserManagement\UserController::class, 'store'])->name('users.store');
    });

    Route::middleware(['admin.permission:users.view'])->group(function () {
        Route::get('users', [\App\Http\Controllers\Admin\UserManagement\UserController::class, 'index'])->name('users.index');
        Route::get('users/export', [\App\Http\Controllers\Admin\UserManagement\UserController::class, 'export'])->name('users.export');
        Route::get('users-trashed', [\App\Http\Controllers\Admin\UserManagement\UserController::class, 'trashed'])->name('users.trashed');
        Route::get('users/{user}', [\App\Http\Controllers\Admin\UserManagement\UserController::class, 'show'])->name('users.show');
    });
    
    Route::middleware(['admin.permission:users.edit'])->group(function () {
        Route::get('users/{user}/edit', [\App\Http\Controllers\Admin\UserManagement\UserController::class, 'edit'])->name('users.edit');
        Route::put('users/{user}', [\App\Http\Controllers\Admin\UserManagement\UserController::class, 'update'])->name('users.update');
        Route::patch('users/{id}/restore', [\App\Http\Controllers\Admin\UserManagement\UserController::class, 'restore'])->name('users.restore');
        Route::patch('users/{id}/verify-email', [\App\Http\Controllers\Admin\UserManagement\UserController::class, 'verifyEmail'])->name('users.verify-email');
        Route::patch('users/{id}/unverify-email', [\App\Http\Controllers\Admin\UserManagement\UserController::class, 'unverifyEmail'])->name('users.unverify-email');
    });
    
    Route::middleware(['admin.permission:users.delete'])->group(function () {
        Route::delete('users/{user}', [\App\Http\Controllers\Admin\UserManagement\UserController::class, 'destroy'])->name('users.destroy');
        Route::delete('users/{id}/force-delete', [\App\Http\Controllers\Admin\UserManagement\UserController::class, 'forceDelete'])->name('users.force-delete');
        Route::post('users/bulk-delete', [\App\Http\Controllers\Admin\UserManagement\UserController::class, 'bulkDelete'])->name('users.bulk-delete');
    });

    // User Activity Logs (non-admin users only)
    Route::get('user-activity-logs', [\App\Http\Controllers\Admin\UserManagement\UserActivityLogController::class, 'index'])->name('user-activity-logs.index');
    Route::get('user-activity-logs/export', [\App\Http\Controllers\Admin\UserManagement\UserActivityLogController::class, 'export'])->name('user-activity-logs.export');
    Route::get('user-activity-logs/{id}', [\App\Http\Controllers\Admin\UserManagement\UserActivityLogController::class, 'show'])->name('user-activity-logs.show');
    Route::post('user-activity-logs/bulk-delete', [\App\Http\Controllers\Admin\UserManagement\UserActivityLogController::class, 'bulkDelete'])->name('user-activity-logs.bulk-delete');

    // Role Management
    // NOTE: Specific routes (create) must be defined BEFORE wildcard {role}
    Route::middleware(['admin.permission:roles.create'])->group(function () {
        Route::get('roles/create', [\App\Http\Controllers\Admin\UserManagement\RoleController::class, 'create'])->name('roles.create');
        Route::post('roles', [\App\Http\Controllers\Admin\UserManagement\RoleController::class, 'store'])->name('roles.store');
    });

    Route::middleware(['admin.permission:roles.view'])->group(function () {
        Route::get('roles', [\App\Http\Controllers\Admin\UserManagement\RoleController::class, 'index'])->name('roles.index');
        Route::get('roles-trashed', [\App\Http\Controllers\Admin\UserManagement\RoleController::class, 'trashed'])->name('roles.trashed');
        Route::get('roles/{role}', [\App\Http\Controllers\Admin\UserManagement\RoleController::class, 'show'])->name('roles.show');
    });
    
    Route::middleware(['admin.permission:roles.edit'])->group(function () {
        Route::get('roles/{role}/edit', [\App\Http\Controllers\Admin\UserManagement\RoleController::class, 'edit'])->name('roles.edit');
        Route::put('roles/{role}', [\App\Http\Controllers\Admin\UserManagement\RoleController::class, 'update'])->name('roles.update');
        Route::patch('roles/{id}/restore', [\App\Http\Controllers\Admin\UserManagement\RoleController::class, 'restore'])->name('roles.restore');
    });
    
    Route::middleware(['admin.permission:roles.delete'])->group(function () {
        Route::delete('roles/{role}', [\App\Http\Controllers\Admin\UserManagement\RoleController::class, 'destroy'])->name('roles.destroy');
        Route::delete('roles/{id}/force-delete', [\App\Http\Controllers\Admin\UserManagement\RoleController::class, 'forceDelete'])->name('roles.force-delete');
    });

    // Permission Management (OLD SYSTEM - DISABLED TO PREVENT CONFLICTS)
    // Route::resource('permissions', \App\Http\Controllers\Admin\PermissionController::class);

    // Role Permission Management (NEW SYSTEM - ACTIVE)
    Route::get('role-permissions', [\App\Http\Controllers\Admin\UserManagement\RolePermissionController::class, 'index'])->name('role-permissions.index');
    Route::get('role-permissions/{role}/edit', [\App\Http\Controllers\Admin\UserManagement\RolePermissionController::class, 'edit'])->name('role-permissions.edit');
    Route::put('role-permissions/{role}', [\App\Http\Controllers\Admin\UserManagement\RolePermissionController::class, 'update'])->name('role-permissions.update');

    // Ebook Management (All ebooks in system)
    // Note: Route create HARUS sebelum route {ebook} untuk menghindari conflict
    Route::middleware(['admin.permission:ebooks.create'])->group(function () {
        Route::get('ebooks/create', [\App\Http\Controllers\Admin\EbookManagement\EbookController::class, 'create'])->name('ebooks.create');
        Route::post('ebooks', [\App\Http\Controllers\Admin\EbookManagement\EbookController::class, 'store'])->name('ebooks.store');
        Route::get('ebooks/search-creators', [\App\Http\Controllers\Admin\EbookManagement\EbookController::class, 'searchCreators'])->name('ebooks.search-creators');
    });
    
    Route::middleware(['admin.permission:ebooks.view'])->group(function () {
        Route::get('ebooks', [\App\Http\Controllers\Admin\EbookManagement\EbookController::class, 'index'])->name('ebooks.index');
        Route::get('ebooks/export-data', [\App\Http\Controllers\Admin\EbookManagement\EbookController::class, 'export'])->name('ebooks.export');
        Route::get('ebooks/trash', [\App\Http\Controllers\Admin\EbookManagement\EbookController::class, 'trash'])->name('ebooks.trash');
        Route::get('ebooks/pending-approval', [\App\Http\Controllers\Admin\EbookManagement\EbookController::class, 'pendingApproval'])->name('ebooks.pending-approval');
        Route::get('ebooks/{ebook}', [\App\Http\Controllers\Admin\EbookManagement\EbookController::class, 'show'])->name('ebooks.show');
    });
    
    Route::middleware(['admin.permission:ebooks.edit'])->group(function () {
        Route::get('ebooks/{ebook}/edit', [\App\Http\Controllers\Admin\EbookManagement\EbookController::class, 'edit'])->name('ebooks.edit');
        Route::put('ebooks/{ebook}', [\App\Http\Controllers\Admin\EbookManagement\EbookController::class, 'update'])->name('ebooks.update');
        Route::patch('ebooks/{ebook}/restore', [\App\Http\Controllers\Admin\EbookManagement\EbookController::class, 'restore'])->name('ebooks.restore');
        Route::post('ebooks/toggle-download', [\App\Http\Controllers\Admin\EbookManagement\EbookController::class, 'toggleDownload'])->name('ebooks.toggle-download');
        // Bulk actions
        Route::post('ebooks/bulk-action', [\App\Http\Controllers\Admin\EbookManagement\EbookController::class, 'bulkAction'])->name('ebooks.bulk-action');
        Route::post('ebooks/bulk-restore', [\App\Http\Controllers\Admin\EbookManagement\EbookController::class, 'bulkRestore'])->name('ebooks.bulk-restore');
    });
    
    Route::middleware(['admin.permission:ebooks.delete'])->group(function () {
        Route::delete('ebooks/{ebook}', [\App\Http\Controllers\Admin\EbookManagement\EbookController::class, 'destroy'])->name('ebooks.destroy');
        Route::delete('ebooks/{ebook}/force-delete', [\App\Http\Controllers\Admin\EbookManagement\EbookController::class, 'forceDelete'])->name('ebooks.force-delete');
        // Bulk delete
        Route::post('ebooks/bulk-delete', [\App\Http\Controllers\Admin\EbookManagement\EbookController::class, 'bulkDelete'])->name('ebooks.bulk-delete');
        Route::post('ebooks/bulk-force-delete', [\App\Http\Controllers\Admin\EbookManagement\EbookController::class, 'bulkForceDelete'])->name('ebooks.bulk-force-delete');
    });
    
    Route::middleware(['admin.permission:ebooks.approve'])->group(function () {
        Route::post('ebooks/{id}/approve', [\App\Http\Controllers\Admin\EbookManagement\EbookController::class, 'approve'])->name('ebooks.approve');
        Route::post('ebooks/{id}/reject', [\App\Http\Controllers\Admin\EbookManagement\EbookController::class, 'reject'])->name('ebooks.reject');
    });

    // Ebook Ratings Management
    Route::middleware(['admin.permission:ebooks.edit'])->group(function () {
        Route::get('ebooks/{ebook}/ratings', [\App\Http\Controllers\Admin\EbookManagement\EbookRatingController::class, 'index'])->name('ebooks.ratings.index');
        Route::get('ebooks/{ebook}/ratings/create', [\App\Http\Controllers\Admin\EbookManagement\EbookRatingController::class, 'create'])->name('ebooks.ratings.create');
        Route::post('ebooks/{ebook}/ratings', [\App\Http\Controllers\Admin\EbookManagement\EbookRatingController::class, 'store'])->name('ebooks.ratings.store');
        Route::get('ebooks/{ebook}/ratings/{rating}/edit', [\App\Http\Controllers\Admin\EbookManagement\EbookRatingController::class, 'edit'])->name('ebooks.ratings.edit');
        Route::put('ebooks/{ebook}/ratings/{rating}', [\App\Http\Controllers\Admin\EbookManagement\EbookRatingController::class, 'update'])->name('ebooks.ratings.update');
        Route::delete('ebooks/{ebook}/ratings/{rating}', [\App\Http\Controllers\Admin\EbookManagement\EbookRatingController::class, 'destroy'])->name('ebooks.ratings.destroy');
        Route::patch('ebooks/{ebook}/ratings/{rating}/toggle-approval', [\App\Http\Controllers\Admin\EbookManagement\EbookRatingController::class, 'toggleApproval'])->name('ebooks.ratings.toggle-approval');
    });

    // Category Management
    Route::middleware(['admin.permission:categories.view'])->group(function () {
        Route::get('categories', [\App\Http\Controllers\Admin\EbookManagement\CategoryController::class, 'index'])->name('categories.index');
        Route::get('categories/trashed', [\App\Http\Controllers\Admin\EbookManagement\CategoryController::class, 'trashed'])->name('categories.trashed');
        Route::get('categories/{category}', [\App\Http\Controllers\Admin\EbookManagement\CategoryController::class, 'show'])->name('categories.show');
    });
    
    Route::middleware(['admin.permission:categories.create'])->group(function () {
        Route::get('categories/create', [\App\Http\Controllers\Admin\EbookManagement\CategoryController::class, 'create'])->name('categories.create');
        Route::post('categories', [\App\Http\Controllers\Admin\EbookManagement\CategoryController::class, 'store'])->name('categories.store');
    });
    
    Route::middleware(['admin.permission:categories.edit'])->group(function () {
        Route::get('categories/{category}/edit', [\App\Http\Controllers\Admin\EbookManagement\CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('categories/{category}', [\App\Http\Controllers\Admin\EbookManagement\CategoryController::class, 'update'])->name('categories.update');
        Route::patch('categories/{category}/restore', [\App\Http\Controllers\Admin\EbookManagement\CategoryController::class, 'restore'])->name('categories.restore');
    });
    
    Route::middleware(['admin.permission:categories.delete'])->group(function () {
        Route::delete('categories/{category}', [\App\Http\Controllers\Admin\EbookManagement\CategoryController::class, 'destroy'])->name('categories.destroy');
        Route::delete('categories/{category}/force-delete', [\App\Http\Controllers\Admin\EbookManagement\CategoryController::class, 'forceDelete'])->name('categories.force-delete');
    });

    // City/Location Management
    // NOTE: Specific routes (create) must be defined BEFORE wildcard {city}
    Route::middleware(['admin.permission:cities.create'])->group(function () {
        Route::get('cities/create', [\App\Http\Controllers\Admin\EbookManagement\CityController::class, 'create'])->name('cities.create');
        Route::post('cities', [\App\Http\Controllers\Admin\EbookManagement\CityController::class, 'store'])->name('cities.store');
    });

    Route::middleware(['admin.permission:cities.view'])->group(function () {
        Route::get('cities', [\App\Http\Controllers\Admin\EbookManagement\CityController::class, 'index'])->name('cities.index');
        Route::get('cities/{city}', [\App\Http\Controllers\Admin\EbookManagement\CityController::class, 'show'])->name('cities.show');
    });
    
    Route::middleware(['admin.permission:cities.edit'])->group(function () {
        Route::get('cities/{city}/edit', [\App\Http\Controllers\Admin\EbookManagement\CityController::class, 'edit'])->name('cities.edit');
        Route::put('cities/{city}', [\App\Http\Controllers\Admin\EbookManagement\CityController::class, 'update'])->name('cities.update');
    });
    
    Route::middleware(['admin.permission:cities.delete'])->group(function () {
        Route::delete('cities/{city}', [\App\Http\Controllers\Admin\EbookManagement\CityController::class, 'destroy'])->name('cities.destroy');
    });

    // Subscription Plan Management
    Route::middleware(['admin.permission:subscription-plans.view'])->group(function () {
        Route::get('subscription-plans', [\App\Http\Controllers\Admin\SubscriptionManagement\SubscriptionPlanController::class, 'index'])->name('subscription-plans.index');
        Route::get('subscription-plans/trashed', [\App\Http\Controllers\Admin\SubscriptionManagement\SubscriptionPlanController::class, 'trashed'])->name('subscription-plans.trashed');
    });
    
    Route::middleware(['admin.permission:subscription-plans.create'])->group(function () {
        Route::get('subscription-plans/create', [\App\Http\Controllers\Admin\SubscriptionManagement\SubscriptionPlanController::class, 'create'])->name('subscription-plans.create');
        Route::post('subscription-plans', [\App\Http\Controllers\Admin\SubscriptionManagement\SubscriptionPlanController::class, 'store'])->name('subscription-plans.store');
    });
    
    Route::middleware(['admin.permission:subscription-plans.edit'])->group(function () {
        Route::get('subscription-plans/{subscription_plan}/edit', [\App\Http\Controllers\Admin\SubscriptionManagement\SubscriptionPlanController::class, 'edit'])->name('subscription-plans.edit');
        Route::put('subscription-plans/{subscription_plan}', [\App\Http\Controllers\Admin\SubscriptionManagement\SubscriptionPlanController::class, 'update'])->name('subscription-plans.update');
        Route::patch('subscription-plans/{subscription_plan}/restore', [\App\Http\Controllers\Admin\SubscriptionManagement\SubscriptionPlanController::class, 'restore'])->name('subscription-plans.restore');
    });
    
    Route::middleware(['admin.permission:subscription-plans.view'])->group(function () {
        Route::get('subscription-plans/{subscription_plan}', [\App\Http\Controllers\Admin\SubscriptionManagement\SubscriptionPlanController::class, 'show'])->name('subscription-plans.show');
    });
    
    Route::middleware(['admin.permission:subscription-plans.delete'])->group(function () {
        Route::delete('subscription-plans/{subscription_plan}', [\App\Http\Controllers\Admin\SubscriptionManagement\SubscriptionPlanController::class, 'destroy'])->name('subscription-plans.destroy');
        Route::delete('subscription-plans/{subscription_plan}/force-delete', [\App\Http\Controllers\Admin\SubscriptionManagement\SubscriptionPlanController::class, 'forceDelete'])->name('subscription-plans.force-delete');
    });

    // Order Management
    Route::middleware(['admin.permission:orders.view'])->group(function () {
        Route::get('orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
    });
    
    Route::middleware(['admin.permission:orders.manage'])->group(function () {
        Route::post('orders/{id}/update-status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');
    });

    // Subscription Management
    Route::middleware(['admin.permission:subscriptions.view'])->group(function () {
        Route::get('subscriptions', [\App\Http\Controllers\Admin\SubscriptionManagement\SubscriptionController::class, 'index'])->name('subscriptions.index');
        Route::get('subscriptions/{subscription}', [\App\Http\Controllers\Admin\SubscriptionManagement\SubscriptionController::class, 'show'])->name('subscriptions.show');
    });

    // Manual Subscription Management
    Route::middleware(['admin.permission:subscriptions.view'])->group(function () {
        Route::get('manual-subscriptions', [\App\Http\Controllers\Admin\SubscriptionManagement\ManualSubscriptionController::class, 'index'])->name('manual-subscriptions.index');
        Route::get('manual-subscriptions/export-data', [\App\Http\Controllers\Admin\SubscriptionManagement\ManualSubscriptionController::class, 'export'])->name('manual-subscriptions.export');
    });
    
    Route::middleware(['admin.permission:subscriptions.create'])->group(function () {
        // AJAX endpoints - harus di atas {manual_subscription} route
        Route::get('manual-subscriptions/search-users', [\App\Http\Controllers\Admin\SubscriptionManagement\ManualSubscriptionController::class, 'searchUsers'])->name('manual-subscriptions.search-users');
        Route::get('manual-subscriptions/create', [\App\Http\Controllers\Admin\SubscriptionManagement\ManualSubscriptionController::class, 'create'])->name('manual-subscriptions.create');
        Route::post('manual-subscriptions', [\App\Http\Controllers\Admin\SubscriptionManagement\ManualSubscriptionController::class, 'store'])->name('manual-subscriptions.store');
    });
    
    Route::middleware(['admin.permission:subscriptions.view'])->group(function () {
        // Specific routes harus di bawah /create
        Route::get('manual-subscriptions/{manual_subscription}', [\App\Http\Controllers\Admin\SubscriptionManagement\ManualSubscriptionController::class, 'show'])->name('manual-subscriptions.show');
    });
    
    Route::middleware(['admin.permission:subscriptions.edit'])->group(function () {
        Route::get('manual-subscriptions/{id}/edit', [\App\Http\Controllers\Admin\SubscriptionManagement\ManualSubscriptionController::class, 'edit'])->name('manual-subscriptions.edit');
        Route::put('manual-subscriptions/{id}', [\App\Http\Controllers\Admin\SubscriptionManagement\ManualSubscriptionController::class, 'update'])->name('manual-subscriptions.update');
        Route::get('manual-subscriptions/{id}/extend', [\App\Http\Controllers\Admin\SubscriptionManagement\ManualSubscriptionController::class, 'extend'])->name('manual-subscriptions.extend');
        Route::post('manual-subscriptions/{id}/extend', [\App\Http\Controllers\Admin\SubscriptionManagement\ManualSubscriptionController::class, 'processExtend'])->name('manual-subscriptions.process-extend');
    });
    
    Route::middleware(['admin.permission:subscriptions.delete'])->group(function () {
        Route::delete('manual-subscriptions/{id}', [\App\Http\Controllers\Admin\SubscriptionManagement\ManualSubscriptionController::class, 'destroy'])->name('manual-subscriptions.destroy');
        Route::post('manual-subscriptions/{id}/cancel', [\App\Http\Controllers\Admin\SubscriptionManagement\ManualSubscriptionController::class, 'cancel'])->name('manual-subscriptions.cancel');
    });

    // Active Subscribers
    Route::middleware(['admin.permission:subscriptions.view'])->group(function () {
        Route::get('active-subscribers', [\App\Http\Controllers\Admin\SubscriptionManagement\SubscriberController::class, 'index'])->name('active-subscribers.index');
    });

    // Subscription History
    Route::middleware(['admin.permission:subscriptions.view'])->group(function () {
        Route::get('subscription-history', [\App\Http\Controllers\Admin\SubscriptionManagement\SubscriptionHistoryController::class, 'index'])->name('subscription-history.index');
        Route::get('subscription-history/{id}', [\App\Http\Controllers\Admin\SubscriptionManagement\SubscriptionHistoryController::class, 'show'])->name('subscription-history.show');
        Route::get('subscription-history/{id}/print', [\App\Http\Controllers\Admin\SubscriptionManagement\SubscriptionHistoryController::class, 'print'])->name('subscription-history.print');
        Route::get('subscription-history-export', [\App\Http\Controllers\Admin\SubscriptionManagement\SubscriptionHistoryController::class, 'export'])->name('subscription-history.export');
    });

    // Blog Management
    // IMPORTANT: Specific routes must come BEFORE wildcard routes
    Route::middleware(['admin.permission:blogs.create'])->group(function () {
        Route::get('blogs/create', [\App\Http\Controllers\Admin\BlogManagement\BlogController::class, 'create'])->name('blogs.create');
        Route::post('blogs', [\App\Http\Controllers\Admin\BlogManagement\BlogController::class, 'store'])->name('blogs.store');
        Route::get('blogs/search-authors', [\App\Http\Controllers\Admin\BlogManagement\BlogController::class, 'searchAuthors'])->name('blogs.search-authors');
    });

    Route::middleware(['admin.permission:blogs.view'])->group(function () {
        Route::get('blogs', [\App\Http\Controllers\Admin\BlogManagement\BlogController::class, 'index'])->name('blogs.index');
        Route::get('blogs/trash', [\App\Http\Controllers\Admin\BlogManagement\BlogController::class, 'trashed'])->name('blogs.trash');
        Route::get('blogs/{blog}', [\App\Http\Controllers\Admin\BlogManagement\BlogController::class, 'show'])->name('blogs.show');
    });
    
    Route::middleware(['admin.permission:blogs.edit'])->group(function () {
        Route::get('blogs/{blog}/edit', [\App\Http\Controllers\Admin\BlogManagement\BlogController::class, 'edit'])->name('blogs.edit');
        Route::put('blogs/{blog}', [\App\Http\Controllers\Admin\BlogManagement\BlogController::class, 'update'])->name('blogs.update');
        Route::post('blogs/{blog}/restore', [\App\Http\Controllers\Admin\BlogManagement\BlogController::class, 'restore'])->name('blogs.restore');
        // Bulk actions
        Route::post('blogs/bulk-action', [\App\Http\Controllers\Admin\BlogManagement\BlogController::class, 'bulkAction'])->name('blogs.bulk-action');
    });
    
    Route::middleware(['admin.permission:blogs.delete'])->group(function () {
        Route::delete('blogs/{blog}', [\App\Http\Controllers\Admin\BlogManagement\BlogController::class, 'destroy'])->name('blogs.destroy');
        Route::delete('blogs/{blog}/force-delete', [\App\Http\Controllers\Admin\BlogManagement\BlogController::class, 'forceDelete'])->name('blogs.force-delete');
        // Bulk delete
        Route::post('blogs/bulk-delete', [\App\Http\Controllers\Admin\BlogManagement\BlogController::class, 'bulkDelete'])->name('blogs.bulk-delete');
    });

    // Blog Category Management
    // NOTE: Specific routes (create, trashed) must be defined BEFORE wildcard {blog_category}
    Route::middleware(['admin.permission:blog-categories.create'])->group(function () {
        Route::get('blog-categories/create', [\App\Http\Controllers\Admin\BlogManagement\BlogCategoryController::class, 'create'])->name('blog-categories.create');
        Route::post('blog-categories', [\App\Http\Controllers\Admin\BlogManagement\BlogCategoryController::class, 'store'])->name('blog-categories.store');
    });

    Route::middleware(['admin.permission:blog-categories.view'])->group(function () {
        Route::get('blog-categories', [\App\Http\Controllers\Admin\BlogManagement\BlogCategoryController::class, 'index'])->name('blog-categories.index');
        Route::get('blog-categories/trashed', [\App\Http\Controllers\Admin\BlogManagement\BlogCategoryController::class, 'trashed'])->name('blog-categories.trashed');
        Route::get('blog-categories/{blog_category}', [\App\Http\Controllers\Admin\BlogManagement\BlogCategoryController::class, 'show'])->name('blog-categories.show');
    });
    
    Route::middleware(['admin.permission:blog-categories.edit'])->group(function () {
        Route::get('blog-categories/{blog_category}/edit', [\App\Http\Controllers\Admin\BlogManagement\BlogCategoryController::class, 'edit'])->name('blog-categories.edit');
        Route::put('blog-categories/{blog_category}', [\App\Http\Controllers\Admin\BlogManagement\BlogCategoryController::class, 'update'])->name('blog-categories.update');
        Route::patch('blog-categories/{id}/restore', [\App\Http\Controllers\Admin\BlogManagement\BlogCategoryController::class, 'restore'])->name('blog-categories.restore');
    });
    
    Route::middleware(['admin.permission:blog-categories.delete'])->group(function () {
        Route::delete('blog-categories/{blog_category}', [\App\Http\Controllers\Admin\BlogManagement\BlogCategoryController::class, 'destroy'])->name('blog-categories.destroy');
        Route::delete('blog-categories/{id}/force-delete', [\App\Http\Controllers\Admin\BlogManagement\BlogCategoryController::class, 'forceDelete'])->name('blog-categories.force-delete');
    });

    // System Settings
    // Route::get('/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings');
    // Route::put('/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('settings.update');

    // Reports & Analytics
    // Route::get('/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports');
    // Route::get('/reports/sales', [\App\Http\Controllers\Admin\ReportController::class, 'sales'])->name('reports.sales');
    // Route::get('/reports/users', [\App\Http\Controllers\Admin\ReportController::class, 'users'])->name('reports.users');

    // Banner Management
    // Hero Banners
    // NOTE: Specific routes (create) must be defined BEFORE wildcard {banner}
    Route::middleware(['admin.permission:website.banners.create'])->group(function () {
        Route::get('banners/create', [\App\Http\Controllers\Admin\WebsiteManagement\BannerController::class, 'create'])->name('banners.create');
        Route::post('banners', [\App\Http\Controllers\Admin\WebsiteManagement\BannerController::class, 'store'])->name('banners.store');
    });

    Route::middleware(['admin.permission:website.banners.view'])->group(function () {
        Route::get('banners', [\App\Http\Controllers\Admin\WebsiteManagement\BannerController::class, 'index'])->name('banners.index');
        Route::get('banners/{banner}', [\App\Http\Controllers\Admin\WebsiteManagement\BannerController::class, 'show'])->name('banners.show');
    });
    
    Route::middleware(['admin.permission:website.banners.edit'])->group(function () {
        Route::post('banners/check-order', [\App\Http\Controllers\Admin\WebsiteManagement\BannerController::class, 'checkOrder'])->name('banners.check-order');
        Route::post('banners/{id}/toggle-active', [\App\Http\Controllers\Admin\WebsiteManagement\BannerController::class, 'toggleActive'])->name('banners.toggle-active');
        Route::post('banners/update-order', [\App\Http\Controllers\Admin\WebsiteManagement\BannerController::class, 'updateOrder'])->name('banners.update-order');
        Route::get('banners/{banner}/edit', [\App\Http\Controllers\Admin\WebsiteManagement\BannerController::class, 'edit'])->name('banners.edit');
        Route::put('banners/{banner}', [\App\Http\Controllers\Admin\WebsiteManagement\BannerController::class, 'update'])->name('banners.update');
        Route::put('banners/default-background/update', [\App\Http\Controllers\Admin\WebsiteManagement\BannerController::class, 'updateDefaultBackground'])->name('banners.update-default-background');
    });
    
    Route::middleware(['admin.permission:website.banners.delete'])->group(function () {
        Route::delete('banners/{banner}', [\App\Http\Controllers\Admin\WebsiteManagement\BannerController::class, 'destroy'])->name('banners.destroy');
    });

    // Promo Management (Subscription Promos)
    Route::middleware(['admin.permission:promos.view'])->group(function () {
        Route::get('promos', [\App\Http\Controllers\Admin\SubscriptionManagement\PromoController::class, 'index'])->name('promos.index');
    });
    
    Route::middleware(['admin.permission:promos.create'])->group(function () {
        Route::get('promos/create', [\App\Http\Controllers\Admin\SubscriptionManagement\PromoController::class, 'create'])->name('promos.create');
        Route::post('promos', [\App\Http\Controllers\Admin\SubscriptionManagement\PromoController::class, 'store'])->name('promos.store');
    });
    
    Route::middleware(['admin.permission:promos.edit'])->group(function () {
        Route::get('promos/{promo}/edit', [\App\Http\Controllers\Admin\SubscriptionManagement\PromoController::class, 'edit'])->name('promos.edit');
        Route::put('promos/{promo}', [\App\Http\Controllers\Admin\SubscriptionManagement\PromoController::class, 'update'])->name('promos.update');
        Route::post('promos/{id}/toggle-active', [\App\Http\Controllers\Admin\SubscriptionManagement\PromoController::class, 'toggleActive'])->name('promos.toggle-active');
    });
    
    Route::middleware(['admin.permission:promos.delete'])->group(function () {
        Route::delete('promos/{promo}', [\App\Http\Controllers\Admin\SubscriptionManagement\PromoController::class, 'destroy'])->name('promos.destroy');
    });

    // Website Management - Collection CRUD
    Route::middleware(['admin.permission:website.collections.view'])->group(function () {
        Route::get('collections', [\App\Http\Controllers\Admin\WebsiteManagement\CollectionController::class, 'index'])->name('collections.index');
        Route::get('collection-order', [\App\Http\Controllers\Admin\WebsiteManagement\WebsiteManagementController::class, 'collectionOrder'])->name('collection-order');
    });
    
    Route::middleware(['admin.permission:website.collections.create'])->group(function () {
        Route::get('collections/create', [\App\Http\Controllers\Admin\WebsiteManagement\CollectionController::class, 'create'])->name('collections.create');
        Route::post('collections', [\App\Http\Controllers\Admin\WebsiteManagement\CollectionController::class, 'store'])->name('collections.store');
    });
    
    Route::middleware(['admin.permission:website.collections.edit'])->group(function () {
        Route::get('ebooks-for-selection', [\App\Http\Controllers\Admin\WebsiteManagement\CollectionController::class, 'getEbooksForSelection'])->name('ebooks-for-selection');
        Route::get('collections/check-order', [\App\Http\Controllers\Admin\WebsiteManagement\CollectionController::class, 'checkOrderAvailability'])->name('collections.check-order');
        Route::post('collections/update-order', [\App\Http\Controllers\Admin\WebsiteManagement\CollectionController::class, 'updateCollectionsOrder'])->name('collections.update-order');
        Route::get('collections/get-available-ebooks', [\App\Http\Controllers\Admin\WebsiteManagement\CollectionController::class, 'getAvailableEbooks'])->name('collections.get-available-ebooks');
        Route::get('collections/{id}/manage-ebooks', [\App\Http\Controllers\Admin\WebsiteManagement\CollectionController::class, 'manageEbooks'])->name('collections.manage-ebooks');
        Route::post('collections/{id}/add-ebooks', [\App\Http\Controllers\Admin\WebsiteManagement\CollectionController::class, 'addEbooks'])->name('collections.add-ebooks');
        Route::delete('collections/{collectionId}/remove-ebook/{ebookId}', [\App\Http\Controllers\Admin\WebsiteManagement\CollectionController::class, 'removeEbook'])->name('collections.remove-ebook');
        Route::post('collections/{id}/update-ebook-order', [\App\Http\Controllers\Admin\WebsiteManagement\CollectionController::class, 'updateEbookOrder'])->name('collections.update-ebook-order');
        Route::get('collections/{collection}/edit', [\App\Http\Controllers\Admin\WebsiteManagement\CollectionController::class, 'edit'])->name('collections.edit');
        Route::put('collections/{collection}', [\App\Http\Controllers\Admin\WebsiteManagement\CollectionController::class, 'update'])->name('collections.update');
        Route::post('collection-order/update', [\App\Http\Controllers\Admin\WebsiteManagement\WebsiteManagementController::class, 'updateCollectionOrder'])->name('collection-order.update');
        Route::post('collection/{id}/toggle-visibility', [\App\Http\Controllers\Admin\WebsiteManagement\WebsiteManagementController::class, 'toggleCollectionVisibility'])->name('collection.toggle-visibility');
    });
    
    Route::middleware(['admin.permission:website.collections.view'])->group(function () {
        Route::get('collections/{collection}', [\App\Http\Controllers\Admin\WebsiteManagement\CollectionController::class, 'show'])->name('collections.show');
    });
    
    Route::middleware(['admin.permission:website.collections.delete'])->group(function () {
        Route::delete('collections/{collection}', [\App\Http\Controllers\Admin\WebsiteManagement\CollectionController::class, 'destroy'])->name('collections.destroy');
    });

    // Policy Page Management - All Types (help, privacy, terms, shopping, payment)
    $policyTypes = [
        'help' => 'help',
        'privacy' => 'privacy',
        'terms' => 'terms',
        'shopping' => 'shopping',
        'payment' => 'payment'
    ];

    foreach ($policyTypes as $slug => $methodSuffix) {
        Route::middleware(["admin.permission:website.policies-{$slug}.view"])->group(function () use ($slug, $methodSuffix) {
            Route::get("policies/{$slug}", [\App\Http\Controllers\Admin\WebsiteManagement\PolicyController::class, 'index' . ucfirst($methodSuffix)])->name("policies.{$slug}.index");
        });
        
        Route::middleware(["admin.permission:website.policies-{$slug}.create"])->group(function () use ($slug, $methodSuffix) {
            Route::get("policies/{$slug}/create", [\App\Http\Controllers\Admin\WebsiteManagement\PolicyController::class, 'create' . ucfirst($methodSuffix)])->name("policies.{$slug}.create");
            Route::post("policies/{$slug}", [\App\Http\Controllers\Admin\WebsiteManagement\PolicyController::class, 'store' . ucfirst($methodSuffix)])->name("policies.{$slug}.store");
        });
        
        Route::middleware(["admin.permission:website.policies-{$slug}.edit"])->group(function () use ($slug, $methodSuffix) {
            Route::get("policies/{$slug}/{id}/edit", [\App\Http\Controllers\Admin\WebsiteManagement\PolicyController::class, 'edit' . ucfirst($methodSuffix)])->name("policies.{$slug}.edit");
            Route::put("policies/{$slug}/{id}", [\App\Http\Controllers\Admin\WebsiteManagement\PolicyController::class, 'update' . ucfirst($methodSuffix)])->name("policies.{$slug}.update");
            Route::post("policies/{$slug}/update-order", [\App\Http\Controllers\Admin\WebsiteManagement\PolicyController::class, 'updateOrder' . ucfirst($methodSuffix)])->name("policies.{$slug}.update-order");
        });
        
        Route::middleware(["admin.permission:website.policies-{$slug}.delete"])->group(function () use ($slug, $methodSuffix) {
            Route::delete("policies/{$slug}/{id}", [\App\Http\Controllers\Admin\WebsiteManagement\PolicyController::class, 'destroy' . ucfirst($methodSuffix)])->name("policies.{$slug}.destroy");
            Route::post("policies/{$slug}/bulk-delete", [\App\Http\Controllers\Admin\WebsiteManagement\PolicyController::class, 'bulkDelete' . ucfirst($methodSuffix)])->name("policies.{$slug}.bulk-delete");
        });
    }

    // FAQ Management - All Categories
    $faqCategories = [
        'pricing' => 'pricing',
        'subscription' => 'subscription',
        'payment' => 'payment',
        'ebook-access' => 'ebookAccess',
        'support' => 'support',
        'content' => 'content'
    ];

    foreach ($faqCategories as $slug => $methodSuffix) {
        Route::middleware(["admin.permission:website.faqs-{$slug}.view"])->group(function () use ($slug, $methodSuffix) {
            Route::get("faqs/{$slug}", [\App\Http\Controllers\Admin\WebsiteManagement\FaqController::class, 'index' . ucfirst($methodSuffix)])->name("faqs.{$slug}.index");
        });
        
        Route::middleware(["admin.permission:website.faqs-{$slug}.create"])->group(function () use ($slug, $methodSuffix) {
            Route::get("faqs/{$slug}/create", [\App\Http\Controllers\Admin\WebsiteManagement\FaqController::class, 'create' . ucfirst($methodSuffix)])->name("faqs.{$slug}.create");
            Route::post("faqs/{$slug}", [\App\Http\Controllers\Admin\WebsiteManagement\FaqController::class, 'store' . ucfirst($methodSuffix)])->name("faqs.{$slug}.store");
        });
        
        Route::middleware(["admin.permission:website.faqs-{$slug}.edit"])->group(function () use ($slug, $methodSuffix) {
            Route::get("faqs/{$slug}/{id}/edit", [\App\Http\Controllers\Admin\WebsiteManagement\FaqController::class, 'edit' . ucfirst($methodSuffix)])->name("faqs.{$slug}.edit");
            Route::put("faqs/{$slug}/{id}", [\App\Http\Controllers\Admin\WebsiteManagement\FaqController::class, 'update' . ucfirst($methodSuffix)])->name("faqs.{$slug}.update");
            Route::post("faqs/{$slug}/{id}/toggle-status", [\App\Http\Controllers\Admin\WebsiteManagement\FaqController::class, 'toggleStatus' . ucfirst($methodSuffix)])->name("faqs.{$slug}.toggle-status");
            Route::post("faqs/{$slug}/update-order", [\App\Http\Controllers\Admin\WebsiteManagement\FaqController::class, 'updateOrder' . ucfirst($methodSuffix)])->name("faqs.{$slug}.update-order");
        });
        
        Route::middleware(["admin.permission:website.faqs-{$slug}.delete"])->group(function () use ($slug, $methodSuffix) {
            Route::delete("faqs/{$slug}/{id}", [\App\Http\Controllers\Admin\WebsiteManagement\FaqController::class, 'destroy' . ucfirst($methodSuffix)])->name("faqs.{$slug}.destroy");
            Route::post("faqs/{$slug}/bulk-delete", [\App\Http\Controllers\Admin\WebsiteManagement\FaqController::class, 'bulkDelete' . ucfirst($methodSuffix)])->name("faqs.{$slug}.bulk-delete");
        });
    }

    // Static Page Management
    // Route::resource('pages', \App\Http\Controllers\Admin\PageController::class);

    // Email Template Management
    // Route::resource('email-templates', \App\Http\Controllers\Admin\EmailTemplateController::class);

    // Landing Page Content Curation
    Route::middleware(['admin.permission:website.landing-page'])->group(function () {
        Route::prefix('landing-page-content')->name('landing-page-content.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\WebsiteManagement\LandingPageContentController::class, 'index'])->name('index');
            Route::get('/top-cities', [\App\Http\Controllers\Admin\WebsiteManagement\LandingPageContentController::class, 'editTopCities'])->name('top-cities');
            Route::put('/top-cities', [\App\Http\Controllers\Admin\WebsiteManagement\LandingPageContentController::class, 'updateTopCities'])->name('top-cities.update');
            Route::get('/latest-blogs', [\App\Http\Controllers\Admin\WebsiteManagement\LandingPageContentController::class, 'editLatestBlogs'])->name('latest-blogs');
            Route::put('/latest-blogs', [\App\Http\Controllers\Admin\WebsiteManagement\LandingPageContentController::class, 'updateLatestBlogs'])->name('latest-blogs.update');
        });
    });

    // About Us Management
    // NOTE: Specific routes (create) must be defined BEFORE wildcard {about_us}
    Route::middleware(['admin.permission:website.about-us.create'])->group(function () {
        Route::get('about-us/create', [\App\Http\Controllers\Admin\SubscriptionManagement\PricingBenefitController::class, 'create'])->name('about-us.create');
        Route::post('about-us', [\App\Http\Controllers\Admin\SubscriptionManagement\PricingBenefitController::class, 'store'])->name('about-us.store');
    });

    Route::middleware(['admin.permission:website.about-us.view'])->group(function () {
        Route::get('about-us', [\App\Http\Controllers\Admin\SubscriptionManagement\PricingBenefitController::class, 'index'])->name('about-us.index');
        Route::get('about-us/{about_us}', [\App\Http\Controllers\Admin\SubscriptionManagement\PricingBenefitController::class, 'show'])->name('about-us.show');
    });
    
    Route::middleware(['admin.permission:website.about-us.edit'])->group(function () {
        Route::post('about-us/{id}/toggle-status', [\App\Http\Controllers\Admin\SubscriptionManagement\PricingBenefitController::class, 'toggleStatus'])->name('about-us.toggle-status');
        Route::post('about-us/update-order', [\App\Http\Controllers\Admin\SubscriptionManagement\PricingBenefitController::class, 'updateOrder'])->name('about-us.update-order');
        Route::get('about-us/{about_us}/edit', [\App\Http\Controllers\Admin\SubscriptionManagement\PricingBenefitController::class, 'edit'])->name('about-us.edit');
        Route::put('about-us/{about_us}', [\App\Http\Controllers\Admin\SubscriptionManagement\PricingBenefitController::class, 'update'])->name('about-us.update');
    });
    
    Route::middleware(['admin.permission:website.about-us.delete'])->group(function () {
        Route::delete('about-us/{about_us}', [\App\Http\Controllers\Admin\SubscriptionManagement\PricingBenefitController::class, 'destroy'])->name('about-us.destroy');
    });

    // About Us Sections Management (Welcome, Performance, About Details)
    Route::middleware(['admin.permission:website.about-us.view'])->group(function () {
        Route::get('about-us-sections', [\App\Http\Controllers\Admin\WebsiteManagement\AboutUsSectionController::class, 'index'])->name('about-us-sections.index');
        Route::get('about-us-sections/{sectionKey}/edit', [\App\Http\Controllers\Admin\WebsiteManagement\AboutUsSectionController::class, 'edit'])->name('about-us-sections.edit');
    });
    
    Route::middleware(['admin.permission:website.about-us.edit'])->group(function () {
        Route::put('about-us-sections/{sectionKey}', [\App\Http\Controllers\Admin\WebsiteManagement\AboutUsSectionController::class, 'update'])->name('about-us-sections.update');
        Route::post('about-us-sections/{sectionKey}/toggle-status', [\App\Http\Controllers\Admin\WebsiteManagement\AboutUsSectionController::class, 'toggleStatus'])->name('about-us-sections.toggle-status');
    });

    // Contact Info Management
    // NOTE: Specific routes (create) must be defined BEFORE wildcard {contact_info}
    Route::middleware(['admin.permission:website.contact-info.create'])->group(function () {
        Route::get('contact-info/create', [\App\Http\Controllers\Admin\WebsiteManagement\ContactInfoController::class, 'create'])->name('contact-info.create');
        Route::post('contact-info', [\App\Http\Controllers\Admin\WebsiteManagement\ContactInfoController::class, 'store'])->name('contact-info.store');
    });

    Route::middleware(['admin.permission:website.contact-info.view'])->group(function () {
        Route::get('contact-info', [\App\Http\Controllers\Admin\WebsiteManagement\ContactInfoController::class, 'index'])->name('contact-info.index');
        Route::get('contact-info/{contact_info}', [\App\Http\Controllers\Admin\WebsiteManagement\ContactInfoController::class, 'show'])->name('contact-info.show');
    });
    
    Route::middleware(['admin.permission:website.contact-info.edit'])->group(function () {
        Route::post('contact-info/{id}/toggle-active', [\App\Http\Controllers\Admin\WebsiteManagement\ContactInfoController::class, 'toggleActive'])->name('contact-info.toggle-active');
        Route::put('contact-info/update-all', [\App\Http\Controllers\Admin\WebsiteManagement\ContactInfoController::class, 'updateAll'])->name('contact-info.update-all');
        Route::get('contact-info/{contact_info}/edit', [\App\Http\Controllers\Admin\WebsiteManagement\ContactInfoController::class, 'edit'])->name('contact-info.edit');
        Route::put('contact-info/{contact_info}', [\App\Http\Controllers\Admin\WebsiteManagement\ContactInfoController::class, 'update'])->name('contact-info.update');
    });
    
    Route::middleware(['admin.permission:website.contact-info.delete'])->group(function () {
        Route::delete('contact-info/{contact_info}', [\App\Http\Controllers\Admin\WebsiteManagement\ContactInfoController::class, 'destroy'])->name('contact-info.destroy');
    });

    // Site Settings Management
    Route::middleware(['admin.permission:website.site-settings'])->group(function () {
        // Route::post('site-settings/store', [\App\Http\Controllers\Admin\WebsiteManagement\SiteSettingController::class, 'store'])->name('site-settings.store'); // Disabled
        // Route::delete('site-settings/{id}', [\App\Http\Controllers\Admin\WebsiteManagement\SiteSettingController::class, 'destroy'])->name('site-settings.destroy'); // Disabled
        Route::get('site-settings', [\App\Http\Controllers\Admin\WebsiteManagement\SiteSettingController::class, 'index'])->name('site-settings.index');
        Route::put('site-settings', [\App\Http\Controllers\Admin\WebsiteManagement\SiteSettingController::class, 'update'])->name('site-settings.update');
    });
});
