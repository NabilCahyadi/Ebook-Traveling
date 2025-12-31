<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Panel\AuthController as PanelAuthController;

/*
|--------------------------------------------------------------------------
| Panel Authentication Routes
|--------------------------------------------------------------------------
| Routes untuk login & logout panel creator/user dengan permission
*/

// Panel Authentication (Guest Only)
Route::prefix('panel')->name('panel.')->middleware(['user.session'])->group(function () {
    Route::get('/login', [PanelAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [PanelAuthController::class, 'login'])->name('login.post');

    // Google OAuth Routes for Panel
    Route::get('/login/google', [PanelAuthController::class, 'redirectToGoogle'])->name('login.google');
    Route::get('/login/google/callback', [PanelAuthController::class, 'handleGoogleCallback'])->name('login.google.callback');
});

// Panel Logout (Authenticated)
Route::post('/panel/logout', [PanelAuthController::class, 'logout'])->name('panel.logout')->middleware(['user.session', 'auth']);
