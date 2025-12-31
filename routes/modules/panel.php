<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Panel\PanelDashboardController;

/*
|--------------------------------------------------------------------------
| Panel Routes (Creator/Dynamic User Panel)
|--------------------------------------------------------------------------
| Routes untuk panel yang bisa diakses user biasa dengan permission dinamis
| Template sama dengan admin, tapi menggunakan 'web' guard
*/

Route::prefix('panel')->name('panel.')->middleware(['user.session', 'auth', 'panel'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [PanelDashboardController::class, 'index'])
        ->middleware('permission:panel.dashboard.view')
        ->name('dashboard');
    
    // Language Switcher
    Route::post('/language/{locale}', [\App\Http\Controllers\Panel\LanguageController::class, 'switch'])->name('language.switch');

    // Notifications
    Route::get('/notifications', [\App\Http\Controllers\Panel\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/recent', [\App\Http\Controllers\Panel\NotificationController::class, 'getRecent'])->name('notifications.recent');
    Route::get('/notifications/unread-count', [\App\Http\Controllers\Panel\NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
    Route::post('/notifications/{id}/mark-as-read', [\App\Http\Controllers\Panel\NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
    Route::post('/notifications/mark-all-as-read', [\App\Http\Controllers\Panel\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-as-read');
    Route::delete('/notifications/{id}', [\App\Http\Controllers\Panel\NotificationController::class, 'destroy'])->name('notifications.destroy');

    // Profile Management
    Route::get('/profile', [\App\Http\Controllers\Panel\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\Panel\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [\App\Http\Controllers\Panel\ProfileController::class, 'updatePassword'])->name('profile.password.update');

    // User Management
    Route::middleware('permission:panel.users.view')->group(function () {
        Route::resource('users', \App\Http\Controllers\Panel\UserController::class);
    });

    // Role Permission Management
    Route::middleware('permission:panel.roles.view')->group(function () {
        Route::get('role-permissions', [\App\Http\Controllers\Admin\RolePermissionController::class, 'index'])->name('role-permissions.index');
        Route::get('role-permissions/{role}/edit', [\App\Http\Controllers\Admin\RolePermissionController::class, 'edit'])->name('role-permissions.edit');
        Route::put('role-permissions/{role}', [\App\Http\Controllers\Admin\RolePermissionController::class, 'update'])->name('role-permissions.update');
    });

    // Ebook Management (Creator's own ebooks)
    Route::middleware('permission:panel.ebooks.view')->group(function () {
        Route::get('ebooks/search-creators', [\App\Http\Controllers\Panel\EbookController::class, 'searchCreators'])->name('ebooks.search-creators');
        Route::get('ebooks/pending-approval', [\App\Http\Controllers\Panel\EbookController::class, 'pendingApproval'])->name('ebooks.pending-approval');
        Route::get('ebooks/trashed', [\App\Http\Controllers\Panel\EbookController::class, 'trashed'])->name('ebooks.trashed');
        Route::patch('ebooks/{ebook}/restore', [\App\Http\Controllers\Panel\EbookController::class, 'restore'])->name('ebooks.restore');
        Route::delete('ebooks/{ebook}/force-delete', [\App\Http\Controllers\Panel\EbookController::class, 'forceDelete'])->name('ebooks.force-delete');
        Route::post('ebooks/toggle-download', [\App\Http\Controllers\Panel\EbookController::class, 'toggleDownload'])->name('ebooks.toggle-download');
        Route::resource('ebooks', \App\Http\Controllers\Panel\EbookController::class);
    });

    // Category Management (View only for creator)
    Route::middleware('permission:panel.categories.view')->group(function () {
        Route::get('categories', [\App\Http\Controllers\Panel\CategoryController::class, 'index'])->name('categories.index');
    });

    // City/Location Management (View only for creator)
    Route::middleware('permission:panel.cities.view')->group(function () {
        Route::get('cities', [\App\Http\Controllers\Panel\CityController::class, 'index'])->name('cities.index');
    });

    // Blog Management (Creator's own blogs)
    Route::middleware('permission:panel.blogs.view')->group(function () {
        Route::get('blogs/archived', [\App\Http\Controllers\Panel\BlogController::class, 'archived'])->name('blogs.archived');
        Route::get('blogs/trashed', [\App\Http\Controllers\Panel\BlogController::class, 'trashed'])->name('blogs.trashed');
        Route::patch('blogs/{blog}/restore', [\App\Http\Controllers\Panel\BlogController::class, 'restore'])->name('blogs.restore');
        Route::delete('blogs/{blog}/force-delete', [\App\Http\Controllers\Panel\BlogController::class, 'forceDelete'])->name('blogs.force-delete');
        Route::get('blogs/search-authors', [\App\Http\Controllers\Panel\BlogController::class, 'searchAuthors'])->name('blogs.search-authors');
        Route::resource('blogs', \App\Http\Controllers\Panel\BlogController::class);
    });

    // Blog Category Management (View only for creator)
    Route::middleware('permission:panel.blogs.view')->group(function () {
        Route::get('blog-categories', [\App\Http\Controllers\Panel\BlogCategoryController::class, 'index'])->name('blog-categories.index');
    });
});
