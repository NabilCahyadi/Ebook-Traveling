<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\ReaderController;
use App\Http\Controllers\User\EbookReaderController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\InvoiceController;

/* berada di routes/modules/user.php
|--------------------------------------------------------------------------
| User Routes (Customer/Pelanggan)
|--------------------------------------------------------------------------
| Routes untuk pelanggan yang membeli dan membaca ebook
*/

Route::prefix('user')->name('user.')->middleware(['user.session', 'auth'])->group(function () {
    // Invoice Routes
    Route::get('/invoice/{payment}/download', [InvoiceController::class, 'download'])->name('invoice.download');
    Route::get('/invoice/{payment}/preview', [InvoiceController::class, 'preview'])->name('invoice.preview');
    // Ebook Reader Routes
    Route::get('/reader/{slug}', [ReaderController::class, 'show'])->name('ebook.read');
    Route::post('/reader/update-progress', [ReaderController::class, 'updateProgress'])->name('reader.updateProgress');
    // Ebook Content API
    Route::post('/api/set-reader-token', function (\Illuminate\Http\Request $request) {
        session(['reader_token_' . $request->ebook_id => $request->token]);
        return response()->json(['success' => true]);
    });

    Route::get('/api/ebook/{id}/content', [EbookReaderController::class, 'getContent'])->name('ebook.content');

    // PDF Routes
    Route::post('/api/set-pdf-token', [EbookReaderController::class, 'setPdfToken']);
    Route::get('/api/ebook/{id}/pdf', [EbookReaderController::class, 'servePdf'])->name('ebook.pdf');

    // Perpanjang langganan (untuk paket aktif)
    Route::get('/subscription/extend/{planSlug}', [SubscriptionController::class, 'extend'])
        ->name('subscription.extend');

    // Upgrade/ganti paket (untuk paket lain)
    Route::get('/subscription/upgrade/{planSlug}', [SubscriptionController::class, 'upgrade'])
        ->name('subscription.upgrade');
    Route::post('/api/ebook/{id}/progress', [EbookReaderController::class, 'updateProgress'])
        ->name('ebook.progress');

    Route::put('/account/reviews/{rating}', [AccountController::class, 'updateReview'])
        ->name('account.reviews.update')
        ->middleware('auth');
});
