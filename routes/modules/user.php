<?php

use Illuminate\Support\Facades\Route;

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
    // Route::get('/profile', [\App\Http\Controllers\User\ProfileController::class, 'index'])->name('profile');
    // Route::put('/profile', [\App\Http\Controllers\User\ProfileController::class, 'update'])->name('profile.update');
    
    // User Library (Ebooks yang sudah dibeli)
    // Route::get('/library', [\App\Http\Controllers\User\LibraryController::class, 'index'])->name('library');
    
    // User Subscriptions
    // Route::get('/subscriptions', [\App\Http\Controllers\User\SubscriptionController::class, 'index'])->name('subscriptions');
    
    // User Wishlist/Saved Books
    // Route::get('/wishlist', [\App\Http\Controllers\User\WishlistController::class, 'index'])->name('wishlist');
    
    // User Orders & Payments
    // Route::get('/orders', [\App\Http\Controllers\User\OrderController::class, 'index'])->name('orders');
    // Route::get('/orders/{id}', [\App\Http\Controllers\User\OrderController::class, 'show'])->name('orders.show');
});
