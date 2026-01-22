# Payment Gateway Mayar.id - Debugging Guide

## 🔍 Masalah yang Diperbaiki

**Gejala:** User sudah membayar tapi masih melihat menu non-premium di page-account/member area.

**Root Causes yang Ditemukan & Diperbaiki:**

### 1. ❌ Key Mismatch di MayarService (FIXED)
**File:** `app/Services/MayarService.php` (line 220)

**Problem:**
```php
// ❌ WRONG - Key tidak cocok dengan parameter yang expected
$subscriptionService->createManualSubscription([
    'user_id' => $paymentLink->user_id,
    'plan_id' => $paymentLink->plan_id,  // ← WRONG KEY
]);
```

**Expected by SubscriptionService:**
```php
public function createManualSubscription(array $data): Subscription
{
    $plan = $this->subscriptionPlanRepository->findById($data['subscription_plan_id']); // ← EXPECTS 'subscription_plan_id'
```

**Fix:**
```php
// ✅ CORRECT - Key sudah sesuai
$subscriptionService->createManualSubscription([
    'user_id' => $paymentLink->user_id,
    'subscription_plan_id' => $paymentLink->plan_id,  // ✅ FIXED KEY
]);
```

### 2. ❌ User Session Cache Not Refreshed (FIXED)
**File:** `app/Http/Controllers/AccountController.php` (line 28)

**Problem:** User object di-cache dari saat pertama kali request, tidak ter-refresh setelah subscription dibuat.

**Fix:**
```php
// ✅ FORCE REFRESH dari database
$user = auth()->user();
$user->refresh(); // ✅ CRITICAL: Refresh user dari database

$user->load([
    'currentSubscription.plan',
    'payments.plan',
    'payments.subscription.plan',
    'subscriptions.plan', // ✅ Load all subscriptions
]);
```

### 3. ✅ Enhanced Logging di SubscriptionProcessRepository
**File:** `app/Repositories/SubscriptionProcessRepository.php`

Added comprehensive logging untuk debugging:
- Subscription creation dengan timestamps dan status
- Payment callback processing dengan flow tracking
- Error cases dengan full context

---

## 🧪 Testing Checklist

### Test Flow:
1. **User Melakukan Payment:**
   - [ ] Klik "Upgrade to Premium"
   - [ ] Pilih paket
   - [ ] Redirect ke Mayar payment page
   - [ ] Selesaikan pembayaran (gunakan test credentials)

2. **Callback Diterima:**
   - [ ] Check Laravel logs: `storage/logs/laravel.log`
   - [ ] Cari pattern: `"Subscription created successfully"`
   - [ ] Verify subscription ada di database: `SELECT * FROM subscriptions WHERE user_id = '...';`

3. **User Redirect ke Success Page:**
   - [ ] `paymentSuccess()` di-trigger
   - [ ] Session refresh user
   - [ ] Status premium ditampilkan di view

4. **User Melihat Premium Dashboard:**
   - [ ] Logout & login kembali (atau clear session)
   - [ ] Visit `/account?tab=dashboard`
   - [ ] Check: `hasActiveSubscription()` returns TRUE
   - [ ] Menu menampilkan: Dashboard Member, Reading Area, My Subscription, Help Center
   - [ ] Menu TIDAK menampilkan: Payment History (payment history hanya untuk non-premium)

---

## 🔧 Debug Commands

### 1. Check User Subscription Status
```php
// Tintin di Tinker (php artisan tinker):
$user = User::find('user-uuid');
$user->hasActiveSubscription(); // Should return TRUE if paid
$user->subscriptions; // Should show active subscription
$user->currentSubscription; // Should show current active plan
```

### 2. Check Payment Status
```php
// Di Tinker:
$payment = DB::table('payments')->where('id', 'payment-uuid')->first();
// Status should be 'success' setelah callback
// subscription_id should be filled
```

### 3. Check Subscription Details
```php
// Di Tinker:
$subscription = DB::table('subscriptions')->where('id', 'sub-uuid')->first();
// status harus 'active'
// end_date harus >= now()
```

### 4. Check Logs
```bash
# Real-time log monitoring
tail -f storage/logs/laravel.log | grep -i "mayar\|subscription\|payment"

# Search for specific payment
grep "payment_id_atau_invoice_number" storage/logs/laravel.log
```

---

## 🚨 Common Issues & Solutions

### Issue 1: Subscription Tidak Ter-Create
**Symptoms:** Payment success tapi subscription tetap kosong

**Debug:**
```php
// Check logs untuk error saat createSubscription
grep "Subscription created successfully" storage/logs/laravel.log

// Check apakah plan_id valid
DB::table('subscription_plans')->where('id', 'plan-uuid')->first();
```

**Fix:**
- Pastikan `subscription_plan_id` di payments table sudah correct
- Pastikan subscription_plan masih `is_active = 1`

### Issue 2: User Masih Melihat Non-Premium Menu
**Symptoms:** User bayar tapi dashboard tetap non-premium

**Debug:**
```php
// Di Tinker:
$user = User::find('user-uuid');
$user->subscriptions; // Check apakah ada

// Force refresh
$user->refresh();
$user->hasActiveSubscription(); // Should now return TRUE
```

**Fix:**
- User perlu logout & login ulang
- Atau akses halaman yang melakukan `$user->refresh()`

### Issue 3: Callback Tidak Masuk/Webhook Error 401
**Symptoms:** Payment gateway bilang sukses tapi callback tidak diterima

**Debug:**
```bash
# Check webhook signature validation
grep "Invalid webhook signature" storage/logs/laravel.log

# Check callback URL config
php artisan config:show mayar
```

**Fix:**
- Pastikan `MAYAR_CALLBACK_URL` di .env benar dan accessible dari internet
- Pastikan `MAYAR_WEBHOOK_TOKEN` di .env match dengan Mayar.id dashboard
- Verify callback route di routes/web.php atau routes/api.php

---

## 📊 Database Schema Check

### subscriptions table harus punya:
```sql
- id (UUID)
- user_id (UUID) - foreign key to users
- subscription_plan_id (UUID) - foreign key to subscription_plans
- status (ENUM: 'active', 'expired', 'cancelled') - MUST BE 'active'
- start_date (TIMESTAMP)
- end_date (TIMESTAMP) - MUST BE >= NOW()
- payment_id (UUID) - nullable, foreign key to payments (optional)
```

### payments table harus punya:
```sql
- id (UUID) - primary key
- user_id (UUID) - foreign key to users
- subscription_plan_id (UUID) - foreign key to subscription_plans
- amount (DECIMAL)
- status (ENUM: 'pending', 'success', 'failed', 'expired')
- payment_method (VARCHAR: 'mayar', etc)
- gateway_transaction_id (VARCHAR) - transaction ID dari Mayar
- paid_at (TIMESTAMP) - waktu payment sukses
- subscription_id (UUID) - foreign key to subscriptions (nullable)
```

---

## 📝 Key Functions to Monitor

1. **MayarService::handleCallback()** 
   - Updates PaymentLink status
   - Calls activateSubscription()

2. **MayarService::activateSubscription()**
   - Calls SubscriptionService::createManualSubscription() ← **PERBAIKAN UTAMA**
   - Logs subscription creation

3. **SubscriptionController::mayarCallback()**
   - Receives webhook from Mayar.id
   - Updates payments table
   - Calls SubscriptionProcessRepository::handleMayarCallbackByPayment()

4. **SubscriptionProcessRepository::handleMayarCallbackByPayment()**
   - Creates subscription via createSubscription()
   - Links payment to subscription

5. **User::hasActiveSubscription()**
   - Checks if user has active subscription
   - Used in blade templates untuk conditional menu rendering

6. **AccountController::index()**
   - **NEW:** user->refresh() untuk get latest data
   - Load relationships untuk subscription status

---

## ✅ Final Verification

Setelah semua fix, gunakan checklist ini:

- [ ] `MayarService::activateSubscription()` menggunakan `'subscription_plan_id'` key
- [ ] `AccountController::index()` melakukan `$user->refresh()`
- [ ] `SubscriptionProcessRepository::createSubscription()` punya logging
- [ ] `SubscriptionProcessRepository::handleMayarCallbackByPayment()` punya logging
- [ ] Logs menunjukkan `"Subscription created successfully"`
- [ ] Database queries menunjukkan subscription dengan `status = 'active'`
- [ ] `hasActiveSubscription()` return TRUE setelah payment
- [ ] Dashboard menampilkan premium menus setelah refresh

---

## 🔗 Related Files

- `app/Services/MayarService.php`
- `app/Http/Controllers/SubscriptionController.php`
- `app/Http/Controllers/AccountController.php`
- `app/Repositories/SubscriptionProcessRepository.php`
- `app/Services/SubscriptionService.php`
- `app/Models/User.php`
- `config/mayar.php`
- `routes/web.php` atau `routes/api.php` (callback route)

---

**Last Updated:** 2026-01-18
**Status:** All Fixes Applied ✅
