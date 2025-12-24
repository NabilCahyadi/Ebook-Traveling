<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PromoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Promo API (requires authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/apply-promo', [PromoController::class, 'applyPromo'])->name('api.promo.apply');
});

// Public Promo API
Route::get('/promos/available', [PromoController::class, 'getAvailablePromos'])->name('api.promo.available');