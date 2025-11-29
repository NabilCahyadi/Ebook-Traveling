<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public/Guest Routes
|--------------------------------------------------------------------------
| Routes yang bisa diakses tanpa login (landing page, info pages, dll)
*/

// Homepage
Route::get('/', function () {
    return view('index');
})->name('home');

// Pricing Page
Route::get('/pricing', function () {
    return view('pricing');
})->name('pricing');

// Destinations Page
Route::get('/destinations', function () {
    return view('destinations');
})->name('destinations');

// Blog List
Route::get('/blogs', function () {
    return view('blogs');
})->name('blogs');

// Promo Page
Route::get('/promo', function () {
    return view('promo');
})->name('promo');

// Contact Page
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Help Center
Route::get('/help-center', function () {
    return view('help-center');
})->name('help-center');

// About Us
Route::get('/about-us', function () {
    return view('about-us');
})->name('about-us');

// Terms & Conditions
Route::get('/terms-conditions', function () {
    return view('terms-conditions');
})->name('terms-conditions');

// Privacy Policy
Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy-policy');

// Shopping Policy
Route::get('/shopping-policy', function () {
    return view('shopping-policy');
})->name('shopping-policy');

// Payment Policy
Route::get('/payment-policy', function () {
    return view('payment-policy');
})->name('payment-policy');

// FAQ
Route::get('/faq', function () {
    return view('faq');
})->name('faq');

// Page Account (Public account page/info)
Route::get('/page-account', function () {
    return view('page-account');
})->name('page-account')->middleware('auth');
