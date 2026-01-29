# 🔄 Subscription Renewal & Upgrade Feature Guide

## 📋 Overview

Sistem renewal dan upgrade subscription telah berhasil diimplementasikan! User sekarang bisa:
1. **Renew Subscription**: Perpanjang paket yang sama (menambah durasi)
2. **Upgrade Subscription**: Upgrade ke paket yang lebih tinggi (ganti ke paket baru)

---

## 🎯 Business Logic

### Renew Subscription (Perpanjangan)
- User **perpanjang paket yang SAMA** yang sedang aktif
- **Tidak membuat subscription baru**, hanya **extend end_date**
- Contoh:
  - User punya Daily Plan (1 hari) yang expire besok
  - User klik "Renew Subscription" → bayar
  - `end_date` diperpanjang +1 hari lagi
  - Jadi total duration: 2 hari

**Kapan digunakan:**
- User puas dengan paket saat ini
- Ingin memperpanjang waktu akses tanpa upgrade

### Upgrade Subscription (Naik Tier)
- User **ganti ke paket LEBIH TINGGI** (durasi lebih panjang)
- **Membuat subscription baru**, subscription lama di-deactivate
- Contoh:
  - User punya Daily Plan (1 hari)
  - User upgrade ke Weekly Plan (7 hari) → bayar
  - Subscription lama status jadi `upgraded`
  - Subscription baru dibuat dengan 7 hari akses

**Kapan digunakan:**
- User ingin akses lebih lama
- User ingin fitur yang lebih baik di tier lebih tinggi

**Restriction:**
- ❌ Tidak bisa upgrade ke paket yang **lebih rendah** atau **sama**
- ✅ Hanya bisa upgrade ke paket dengan `duration_days` **lebih besar**
- 📝 Jika mau downgrade, hubungi admin

---

## 🛠️ Technical Implementation

### 1. Database Changes

#### Migration: `add_payment_type_to_payments_table`
```php
Schema::table('payments', function (Blueprint $table) {
    $table->enum('payment_type', ['new', 'renewal', 'upgrade'])
        ->default('new')
        ->after('status');
});
```

**Payment Types:**
- `new`: Subscription baru pertama kali
- `renewal`: Perpanjangan paket yang sama
- `upgrade`: Upgrade ke paket lebih tinggi

### 2. Routes Added

File: `routes/modules/public.php`

```php
Route::middleware('auth')->group(function () {
    Route::post('/subscription/renew', [SubscriptionController::class, 'renewSubscription'])
        ->name('subscription.renew');
    Route::post('/subscription/upgrade', [SubscriptionController::class, 'upgradeSubscription'])
        ->name('subscription.upgrade');
});
```

### 3. Controller Methods Added

File: `app/Http/Controllers/SubscriptionController.php`

#### `renewSubscription()` Method
**Flow:**
1. ✅ Get current active subscription
2. ✅ Get plan details
3. ✅ Create payment record dengan `payment_type = 'renewal'`
4. ✅ Redirect ke Mayar dengan `external_id = payment_id`
5. ✅ User bayar di Mayar
6. ✅ Mayar kirim webhook ke `/api/payment/mayar-callback`
7. ✅ System detect `payment_type = 'renewal'`
8. ✅ **UPDATE** `end_date += plan.duration_days` (perpanjang subscription)
9. ✅ Redirect ke page-account dengan popup sukses

**Logging Emoji:** 🔄

#### `upgradeSubscription()` Method
**Flow:**
1. ✅ Get current active subscription
2. ✅ Validate new plan has **higher** `duration_days`
3. ✅ Return error jika mencoba downgrade
4. ✅ Create payment record dengan `payment_type = 'upgrade'`
5. ✅ Redirect ke Mayar dengan `external_id = payment_id`
6. ✅ User bayar di Mayar
7. ✅ Mayar kirim webhook
8. ✅ System detect `payment_type = 'upgrade'`
9. ✅ **UPDATE** old subscription `status = 'upgraded'` (deactivate)
10. ✅ **CREATE** new subscription dengan plan baru
11. ✅ Redirect ke page-account dengan popup sukses

**Logging Emoji:** ⬆️

### 4. Updated `mayarCallback()` Method

Sekarang webhook handler bisa detect payment type dan proses accordingly:

```php
// Get payment type
$paymentType = 'new'; // default
if ($externalId) {
    $payment = DB::table('payments')->where('id', $externalId)->first();
    if ($payment) {
        $paymentType = $payment->payment_type ?? 'new';
    }
}

// Handle based on payment type
if ($paymentType === 'renewal') {
    // ✅ EXTEND existing subscription end_date
    $currentEndDate = new \DateTime($existingSubscription->end_date);
    $newEndDate = $currentEndDate->modify("+{$plan->duration_days} days");
    // Update subscription...
    
} elseif ($paymentType === 'upgrade') {
    // ✅ DEACTIVATE old subscription
    DB::table('subscriptions')->where('id', $oldSubscription->id)
        ->update(['status' => 'upgraded']);
    
    // ✅ CREATE new subscription
    Subscription::create([...]);
    
} else {
    // ✅ CREATE new subscription (existing logic)
    Subscription::create([...]);
}
```

### 5. UI Changes

File: `resources/views/page-account.blade.php`

#### Before (Masalah):
```blade
<!-- Button yang tidak berfungsi -->
<a href="{{ route('pricing') }}" class="...">
    Renew Subscription
</a>
```
❌ Hanya redirect ke pricing page, tidak ada backend logic

#### After (Fixed):
```blade
<!-- Renew Button (Current Plan) -->
<form action="{{ route('subscription.renew') }}" method="POST">
    @csrf
    <button type="submit" class="...">
        <i class="fi fi-rs-refresh me-1"></i> Renew Subscription
    </button>
</form>

<!-- Upgrade Options (Higher Tier Plans) -->
@foreach($subscriptionPlans as $upgradePlan)
    @if($upgradePlan->duration_days > $plan->duration_days)
        <form action="{{ route('subscription.upgrade') }}" method="POST">
            @csrf
            <input type="hidden" name="plan_slug" value="{{ $upgradePlan->slug }}">
            <button type="submit" class="...">
                <i class="fi fi-rs-arrow-up me-1"></i> Upgrade Now
            </button>
        </form>
    @endif
@endforeach
```

✅ Functional buttons dengan POST forms
✅ Upgrade hanya muncul untuk paket lebih tinggi
✅ CSRF protection

### 6. Controller Updates

File: `app/Http/Controllers/AccountController.php`

Added subscription plans to view:
```php
// ✅ GET ALL SUBSCRIPTION PLANS FOR UPGRADE OPTIONS
$subscriptionPlans = \App\Models\SubscriptionPlan::where('is_active', true)
    ->orderBy('duration_days', 'asc')
    ->get();
$accountData['subscriptionPlans'] = $subscriptionPlans;
```

---

## 🧪 Testing Checklist

### Test Renewal Flow
1. ✅ Login sebagai user dengan active subscription
2. ✅ Go to /page-account?tab=subscription
3. ✅ Klik "Renew Subscription"
4. ✅ Redirected ke Mayar payment page
5. ✅ Complete payment (sandbox mode)
6. ✅ Check webhook log: should see 🔄 emoji
7. ✅ Verify `end_date` extended by `duration_days`
8. ✅ Verify redirect to page-account dengan popup sukses

### Test Upgrade Flow
1. ✅ Login sebagai user dengan Daily Plan active
2. ✅ Go to /page-account?tab=subscription
3. ✅ See upgrade options untuk Weekly, Monthly plans
4. ✅ Klik "Upgrade Now" pada Weekly Plan
5. ✅ Redirected ke Mayar payment page
6. ✅ Complete payment (sandbox mode)
7. ✅ Check webhook log: should see ⬆️ emoji
8. ✅ Verify old subscription `status = 'upgraded'`
9. ✅ Verify new subscription created dengan Weekly Plan
10. ✅ Verify redirect to page-account dengan popup sukses

### Test Validation
1. ✅ Try to upgrade to same tier plan → Should get error
2. ✅ Try to upgrade to lower tier plan → Should get error message
3. ✅ Verify CSRF protection works on forms

---

## 📊 Database Schema

### Payments Table
```
id (uuid, PK)
user_id (uuid, FK)
subscription_id (uuid, FK) - links to existing subscription
subscription_plan_id (uuid, FK) - new or current plan
amount (decimal)
status (enum: pending, success, failed)
payment_type (enum: new, renewal, upgrade) ← NEW COLUMN
payment_code (string)
created_at, updated_at
```

### Subscriptions Table
```
id (uuid, PK)
user_id (uuid, FK)
subscription_plan_id (uuid, FK)
payment_id (uuid, FK)
status (enum: active, expired, cancelled, upgraded) ← upgraded untuk old subscription
start_date (timestamp)
end_date (timestamp) ← extended untuk renewal
subscription_code (string)
total_amount (decimal)
created_at, updated_at
```

---

## 🎉 Success Indicators

### Logs to Watch
```bash
# Renewal
🔄 Processing renewal payment
🎉 Subscription renewed successfully

# Upgrade
⬆️ Processing upgrade payment
📝 Old subscription deactivated
🎉 Subscription upgraded successfully

# General
🔔 Mayar Webhook Received
✅ Signature validated successfully
💳 Payment updated to success
```

### Database Checks
```sql
-- Check payment types
SELECT payment_type, COUNT(*) FROM payments GROUP BY payment_type;

-- Check subscription statuses
SELECT status, COUNT(*) FROM subscriptions GROUP BY status;

-- Check user's subscription history
SELECT u.email, s.status, s.start_date, s.end_date, sp.name 
FROM subscriptions s
JOIN users u ON s.user_id = u.id
JOIN subscription_plans sp ON s.subscription_plan_id = sp.id
WHERE u.email = 'user@example.com'
ORDER BY s.created_at DESC;
```

---

## 🔐 Security Features

1. ✅ **CSRF Protection**: Semua forms menggunakan `@csrf` token
2. ✅ **Authentication Required**: Routes protected dengan `auth` middleware
3. ✅ **Validation**: Cannot upgrade to lower tier plans
4. ✅ **Webhook Security**: X-Callback-Token verification
5. ✅ **UUID Primary Keys**: Mencegah sequential ID guessing

---

## 🚀 Future Enhancements

1. **Proration**: Hitung refund untuk sisa waktu saat upgrade
2. **Downgrade**: Allow admin to downgrade user subscriptions
3. **Auto-renewal**: Implement automatic renewal sebelum expire
4. **Email Notifications**: Kirim email saat renewal/upgrade success
5. **Discount Codes**: Apply discount untuk renewal
6. **Payment History**: Show renewal/upgrade transactions di invoice

---

## 📞 Support

Jika ada masalah:
1. Check logs di `storage/logs/laravel.log`
2. Search untuk emoji: 🔄 (renewal) atau ⬆️ (upgrade)
3. Verify payment record ada dan `payment_type` benar
4. Check webhook received dari Mayar
5. Verify MAYAR_WEBHOOK_TOKEN di `.env` correct

---

## 🎊 Celebration!

**ALHAMDULILLAH!** 🎉

Fitur subscription management sekarang **COMPLETE**:
- ✅ Payment Gateway Mayar.id (WORKING setelah 2 minggu debugging!)
- ✅ New Subscription
- ✅ Renew Subscription (baru diimplementasikan!)
- ✅ Upgrade Subscription (baru diimplementasikan!)
- ✅ Success Popup dengan animasi
- ✅ Comprehensive logging
- ✅ Full documentation

**Total Development Time**: ~2.5 weeks
**Major Breakthrough**: Payment gateway working
**New Features**: Renewal & Upgrade system

---

## 📝 Change Log

**2026-01-23**
- ✅ Created migration `add_payment_type_to_payments_table`
- ✅ Added `renewSubscription()` method to SubscriptionController
- ✅ Added `upgradeSubscription()` method to SubscriptionController
- ✅ Updated `mayarCallback()` to handle renewal and upgrade
- ✅ Added routes for `/subscription/renew` and `/subscription/upgrade`
- ✅ Updated `page-account.blade.php` with functional buttons
- ✅ Updated `AccountController` to pass subscription plans to view
- ✅ Created comprehensive documentation

**Status**: ✅ **FULLY FUNCTIONAL & TESTED**
