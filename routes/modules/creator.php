<?php

use Illuminate\Support\Facades\Route;

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
    // Route::get('ebooks/{id}/preview', [\App\Http\Controllers\Creator\EbookController::class, 'preview'])->name('ebooks.preview');
    
    // Creator's Analytics & Statistics
    // Route::get('/analytics', [\App\Http\Controllers\Creator\AnalyticsController::class, 'index'])->name('analytics');
    // Route::get('/analytics/ebook/{id}', [\App\Http\Controllers\Creator\AnalyticsController::class, 'ebook'])->name('analytics.ebook');
    
    // Creator's Earnings & Revenue
    // Route::get('/earnings', [\App\Http\Controllers\Creator\EarningsController::class, 'index'])->name('earnings');
    // Route::get('/earnings/withdraw', [\App\Http\Controllers\Creator\EarningsController::class, 'withdraw'])->name('earnings.withdraw');
    // Route::post('/earnings/withdraw', [\App\Http\Controllers\Creator\EarningsController::class, 'processWithdraw'])->name('earnings.withdraw.process');
    
    // Creator Profile & Settings
    // Route::get('/profile', [\App\Http\Controllers\Creator\ProfileController::class, 'index'])->name('profile');
    // Route::put('/profile', [\App\Http\Controllers\Creator\ProfileController::class, 'update'])->name('profile.update');
    
    // Creator's Reviews & Ratings
    // Route::get('/reviews', [\App\Http\Controllers\Creator\ReviewController::class, 'index'])->name('reviews');
});
