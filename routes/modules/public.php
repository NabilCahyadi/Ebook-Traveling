<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\EbookController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ReaderController;
use App\Http\Controllers\FrontendCategoryController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\PolicyController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\ContactController as ControllersContactController;
use App\Http\Controllers\PromoDetailController;


/*
|--------------------------------------------------------------------------
| Public/Guest Routes
|--------------------------------------------------------------------------
| Routes yang bisa diakses tanpa login (landing page, info pages, dll)
*/

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Destinations Page
Route::get('/destinations', [DestinationController::class, 'index'])->name('destinations');
Route::get('/destinations/{slug}', [DestinationController::class, 'show'])->name('destination.show')->middleware('record.view');

Route::get('/help-center', [PolicyController::class, 'show'])->defaults('type', 'help')->name('help-center');
Route::get('/privacy-policy', [PolicyController::class, 'show'])->defaults('type', 'privacy')->name('privacy-policy');
Route::get('/terms-conditions', [PolicyController::class, 'show'])->defaults('type', 'terms')->name('terms-conditions');
Route::get('/shopping-policy', [PolicyController::class, 'show'])->defaults('type', 'shopping')->name('shopping-policy');
Route::get('/payment-policy', [PolicyController::class, 'show'])->defaults('type', 'payment')->name('payment-policy');

// // Help Center
// Route::get('/help-center', function () {
//     return view('help-center');
// })->name('help-center');

// // Terms & Conditions
// Route::get('/terms-conditions', function () {
//     return view('terms-conditions');
// })->name('terms-conditions');

// // Privacy Policy
// Route::get('/privacy-policy', function () {
//     return view('privacy-policy');
// })->name('privacy-policy');

// // Shopping Policy
// Route::get('/shopping-policy', function () {
//     return view('shopping-policy');
// })->name('shopping-policy');

// // Payment Policy
// Route::get('/payment-policy', function () {
//     return view('payment-policy');
// })->name('payment-policy');

// Page Account (Public account page/info)
// Account Routes
Route::middleware('auth')->group(function () {
    Route::get('/page-account', [AccountController::class, 'index'])->name('page-account');
    Route::put('/profile/update', [AccountController::class, 'updateProfile'])->name('profile.update');
    Route::post('/account/update-avatar', [AccountController::class, 'updateAvatar'])->name('account.update.avatar');
    Route::put('/password/update', [AccountController::class, 'updatePassword'])->name('password.update');
});

// Route::put('/password/update', [AccountController::class, 'updatePassword'])->name('password.update')->middleware('auth');
Route::get('/help/content/{type}', [HelpController::class, 'loadContent'])->name('help.content');

Route::get('/collections/{collection:slug}', [CollectionController::class, 'show'])->name('collections.show');
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
Route::get('/blogs/tag/{tag}', [BlogController::class, 'byTag'])->name('blogs.by.tag');
Route::get('/blogs/{slug}', [BlogController::class, 'show'])->name('blogs.show');
Route::get('/ebooks/{slug}', [EbookController::class, 'show'])->name('ebooks.show');
Route::post('/ratings', [RatingController::class, 'store'])->name('ratings.store')->middleware('auth');
// Route::get('/reader/{slug}', [ReaderController::class, 'show'])->name('reader.show')->middleware('premium');
Route::get('/category/{slug}', [FrontendCategoryController::class, 'show'])->name('category.show');
Route::get('/pricing', [PricingController::class, 'index'])->name('pricing');
Route::get('/promo', [PromoController::class, 'index'])->name('promo');
Route::get('/promo/{slug}', [PromoController::class, 'showDetail'])->name('promo.detail.show');
// Route::post('/reader/update-progress', [ReaderController::class, 'updateProgress'])->name('reader.updateProgress');
Route::get('/about-us', [AboutController::class, 'index'])->name('about-us');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/simulate/renew/{planSlug}', [SubscriptionController::class, 'simulateRenewal'])->name('simulate.renew')->middleware('auth');
Route::get('/simulate/upgrade/{planSlug}', [SubscriptionController::class, 'simulateUpgrade'])->name('simulate.upgrade')->middleware('auth');
Route::get('/faq', [FaqController::class, 'faqs'])->name('faq');

Route::post('/ebooks/{id}/save', [EbookController::class, 'toggleSaved'])
    ->name('ebooks.save.toggle')
    ->middleware('auth');
Route::post('/toggle-favorite', function (Request $request) {
    if (!auth()->check()) {
        return response()->json(['success' => false, 'message' => 'Login required']);
    }

    $userId = auth()->id();
    $ebookId = $request->input('ebook_id');

    $exists = DB::table('user_saved_books')
        ->where('user_id', $userId)
        ->where('ebook_id', $ebookId)
        ->exists();

    if ($exists) {
        DB::table('user_saved_books')
            ->where('user_id', $userId)
            ->where('ebook_id', $ebookId)
            ->delete();
        return response()->json(['success' => true, 'message' => 'Removed from saved books']);
    } else {
        DB::table('user_saved_books')->insert([
            'user_id' => $userId,
            'ebook_id' => $ebookId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return response()->json(['success' => true, 'message' => 'Added to saved books']);
    }
})->middleware('auth');

// Bungkus dengan prefix 'api'
Route::prefix('api')->group(function () {
    Route::post('/subscription/create', [SubscriptionController::class, 'create'])
        ->middleware('auth'); // Tetap gunakan middleware auth
});

Route::post('/api/payment/mayar-callback', [SubscriptionController::class, 'mayarCallback']);

Route::get('/simulate-pay/{planSlug}', function ($planSlug) {
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    $user = auth()->user();
    $plan = \App\Models\SubscriptionPlan::where('slug', $planSlug)->firstOrFail();

    // ✅ Generate data wajib
    $paymentCode = 'PAY-' . strtoupper(Str::random(8));
    $gatewayTxId = 'TXN-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(4));

    // ✅ Insert dengan SEMUA kolom wajib
    $payment = \App\Models\Payment::create([
        'user_id' => $user->id,
        'subscription_plan_id' => $plan->id,
        'payment_code' => $paymentCode,
        'amount' => $plan->price,
        'payment_method' => 'qris', // ✅ wajib: 'qris', 'dana', 'va_bca', dll
        'status' => 'success',      // ✅ override default 'pending'
        'payment_gateway' => 'mayar_mock',
        'gateway_transaction_id' => $gatewayTxId,
        'paid_at' => now(),
    ]);

    // ✅ Buat langganan
    $subscription = \App\Models\Subscription::create([
        'user_id' => $user->id,
        'subscription_plan_id' => $plan->id,
        'payment_id' => $payment->id,
        'subscription_code' => 'SUB-' . now()->timestamp,
        'start_date' => now(),
        'end_date' => now()->addDays($plan->duration_days),
        'status' => 'active',
        'total_amount' => $plan->price,
    ]);

    // ✅ Update payment dengan subscription_id
    $payment->update(['subscription_id' => $subscription->id]);

    return redirect()->route('page-account')
        ->with('success', "✅ Berhasil berlangganan <strong>{$plan->name}</strong>!");
})->name('simulate.pay');
