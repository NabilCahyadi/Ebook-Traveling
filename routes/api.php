<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MayarWebhookController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Mayar.id Webhook
Route::post('/mayar/callback', [MayarWebhookController::class, 'handleCallback'])->name('mayar.callback');
