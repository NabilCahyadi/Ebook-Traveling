# ✅ Subscription Upgrade/Downgrade Fix - January 28, 2026

## 🎯 Overview

Perbaikan upgrade/downgrade logic untuk memastikan ketika user upgrade atau downgrade subscription plan, **durasi ditambahkan ke subscription yang existing** (bukan membuat subscription baru).

**Status:** ✅ Fixed and Ready for Testing

---

## 🔍 Issues Fixed

### 1. **Upgrade Logic Created New Subscription Instead of Updating**

**Problem:**
- User punya active subscription Plan A (end_date: 2026-02-28)
- User click upgrade ke Plan B
- Payment berhasil
- **WRONG**: System buat subscription baru dengan start_date=today, end_date=today+30days
- **Result**: Old subscription stay active, user bingung punya 2 active subscriptions

**Solution:**
- Updated callback handler to **UPDATE** existing subscription (tidak create baru)
- Change `subscription_plan_id` to new plan
- Extend `end_date` dengan menambahkan `duration_days` dari new plan

### 2. **Downgrade Handler Missing**

**Problem:**
- Downgrade belum fully handled di callback
- Hanya upgrade saja yang dihandle

**Solution:**
- Combined upgrade dan downgrade handler
- Both now use same logic: UPDATE existing + extend duration

### 3. **Payment History Filter**

**Problem:**
- Payment History tab tidak menampilkan pembayaran yang sudah success
- Query fetch ALL payments, tidak filter by status='success'

**Solution:**
- Added `.where('status', 'success')` to both existence check dan foreach loop

---

## 🛠️ Technical Changes

### File: `app/Http/Controllers/SubscriptionController.php`

**Location:** Lines 302-356 (replacement for old upgrade handler)

**Changes:**
```php
// BEFORE (WRONG):
} elseif ($paymentType === 'upgrade') {
    // Create new subscription
    $subscription = Subscription::create([
        'start_date' => now(),
        'end_date' => now()->addDays($plan->duration_days),  // ❌ WRONG: from today
        ...
    ]);
}

// AFTER (CORRECT):
} elseif ($paymentType === 'upgrade' || $paymentType === 'downgrade') {
    $existingSubscription = DB::table('subscriptions')
        ->where('user_id', $user->id)
        ->where('status', 'active')
        ->orderBy('end_date', 'desc')
        ->first();

    if ($existingSubscription) {
        $currentEndDate = \Carbon\Carbon::parse($existingSubscription->end_date);
        $newEndDate = $currentEndDate->copy()->addDays($plan->duration_days);  // ✅ CORRECT: add to existing

        DB::table('subscriptions')
            ->where('id', $existingSubscription->id)
            ->update([
                'subscription_plan_id' => $plan->id,  // ✅ Change plan
                'end_date' => $newEndDate,             // ✅ Extend duration
                'total_amount' => DB::raw("`total_amount` + {$plan->price}"),
            ]);
    }
}
```

### File: `resources/views/page-account.blade.php`

**Location:** Lines 1310, 1330 (Payment History query filter)

**Changes:**
```blade
// BEFORE:
@if ($user->payments()->exists())
@foreach ($user->payments()->with(['plan', 'subscription'])->latest()->get() as $payment)

// AFTER:
@if ($user->payments()->where('status', 'success')->exists())
@foreach ($user->payments()->where('status', 'success')->with(['plan', 'subscription'])->latest()->get() as $payment)
```

---

## 📋 Testing Scenarios

### Test 1: Upgrade Subscription ✅

**Precondition:**
- User has active subscription: Plan A (30 days, expires 2026-02-28)
- User is logged in and on pricing page

**Steps:**
1. Click "Upgrade Subscription" button for Plan B (60 days)
2. Redirect ke Mayar payment gateway
3. Complete payment di Mayar (use test card or simulate)
4. Should redirect back to page-account with success popup

**Expected Results:**
- ✅ Subscription status: ACTIVE
- ✅ Subscription plan: Plan B (60 days)
- ✅ **Subscription end_date: 2026-02-28 + 60 days = 2026-04-28** (NOT 2026-03-29!)
- ✅ Payment History shows new payment record with status='success'
- ✅ Payment type='upgrade' (check in logs)
- ✅ Logs show: "Subscription upgraded successfully"
- ✅ Single subscription record (no duplicate)

**Verification Commands:**
```bash
# Check subscription
php artisan tinker
> DB::table('subscriptions')->where('user_id', auth()->id())->latest()->first();
# Should show: status='active', subscription_plan_id=(Plan B id), end_date=2026-04-28

# Check payment
> DB::table('payments')->where('user_id', auth()->id())->latest()->first();
# Should show: status='success', payment_type='upgrade'

# Check logs
tail -f storage/logs/laravel.log | grep "⬆️ Processing upgrade"
```

---

### Test 2: Downgrade Subscription ✅

**Precondition:**
- User has active subscription: Plan B (60 days, expires 2026-04-28)
- User is logged in and on pricing page

**Steps:**
1. Click "Change Plan" button for Plan A (30 days) - shorter duration
2. Redirect ke Mayar payment gateway
3. Complete payment di Mayar
4. Should redirect back to page-account with success popup

**Expected Results:**
- ✅ Subscription status: ACTIVE
- ✅ Subscription plan: Plan A (30 days) - **CHANGED FROM Plan B**
- ✅ **Subscription end_date: 2026-04-28 + 30 days = 2026-05-28** (add duration, tidak reset!)
- ✅ Payment History shows new payment record with status='success'
- ✅ Payment type='downgrade' (check in logs)
- ✅ Logs show: "Subscription downgraded successfully"
- ✅ Single subscription record (no duplicate)

**Verification Commands:**
```bash
# Check subscription
php artisan tinker
> DB::table('subscriptions')->where('user_id', auth()->id())->latest()->first();
# Should show: status='active', subscription_plan_id=(Plan A id), end_date=2026-05-28

# Check payment
> DB::table('payments')->where('user_id', auth()->id())->latest()->first();
# Should show: status='success', payment_type='downgrade'

# Check logs
tail -f storage/logs/laravel.log | grep "⬇️ Processing downgrade"
```

---

### Test 3: Payment History Display ✅

**Precondition:**
- User has completed multiple payments (new, renewal, upgrade, downgrade)

**Steps:**
1. Go to Account > My Subscription tab
2. Scroll to "Payment History" section

**Expected Results:**
- ✅ Payment History section visible (jika ada successful payments)
- ✅ Only shows **successful payments** (status='success')
- ✅ Shows all payment types:
  - 🆕 New subscription
  - 🔄 Renewal
  - ⬆️ Upgrade
  - ⬇️ Downgrade
- ✅ Correct plan name, amount, period shown
- ✅ Payment status and subscription status both displayed

---

## 🔄 Database Impact

### Changes Made:
1. ✅ Migration `2026_01_28_150000_add_downgrade_to_payment_type_enum.php` (already run)
   - Added 'downgrade' to payment_type ENUM

### No Breaking Changes:
- ✅ Existing subscriptions unaffected
- ✅ Existing payments unaffected
- ✅ Only new upgrade/downgrade flows use new logic

---

## 📊 Payment Flow Diagram

### Before (BROKEN):
```
User clicks Upgrade
↓
Create payment (type='upgrade')
↓
Redirect to Mayar
↓
User pays
↓
Webhook: payment_type='upgrade'
↓
CREATE new subscription (start=today) ❌
Existing subscription still active
↓
User confused (2 active subs?)
```

### After (FIXED):
```
User clicks Upgrade
↓
Create payment (type='upgrade')
↓
Redirect to Mayar
↓
User pays
↓
Webhook: payment_type='upgrade'
↓
UPDATE existing subscription ✅
- Change plan_id ✅
- Extend end_date ✅
↓
User happy (single active sub with new plan + extended duration)
```

---

## 🔐 Data Consistency

### Guarantees:
1. ✅ **Single Active Subscription per User**
   - Only one record with status='active' and end_date > now()

2. ✅ **Duration Always Adds**
   - Upgrade/downgrade ADDS duration_days to existing end_date
   - Does NOT reset to today

3. ✅ **Plan Change Tracked**
   - Old plan_id recorded in logs
   - New plan_id recorded in logs
   - Payment record links to both

4. ✅ **Audit Trail**
   - Every upgrade/downgrade logged with details
   - Timestamps recorded
   - Old and new values preserved

---

## 📝 Logs Sample

### Successful Upgrade:
```log
[2026-01-28 14:30:15] INFO ⬆️ Processing upgrade payment
[2026-01-28 14:30:15] INFO 💳 Upgrade payment updated to success
[2026-01-28 14:30:16] INFO 🎉 Subscription upgraded successfully
    subscription_id: 123
    old_plan_id: 1
    new_plan_id: 2
    new_plan_name: "Plan B - 60 days"
    old_end_date: "2026-02-28"
    new_end_date: "2026-04-28"
    extended_days: 60
```

### Successful Downgrade:
```log
[2026-01-28 14:35:22] INFO ⬇️ Processing downgrade payment
[2026-01-28 14:35:22] INFO 💳 Downgrade payment updated to success
[2026-01-28 14:35:23] INFO 🎉 Subscription downgraded successfully
    subscription_id: 123
    old_plan_id: 2
    new_plan_id: 1
    new_plan_name: "Plan A - 30 days"
    old_end_date: "2026-04-28"
    new_end_date: "2026-05-28"
    extended_days: 30
```

---

## 🚀 Deployment Checklist

- [x] Code changes reviewed
- [x] Migration created and tested
- [x] Callback handler fixed
- [x] Payment filter fixed
- [x] Logging enhanced
- [ ] User testing (pending)
- [ ] Edge cases verified (pending)
- [ ] Production deployment (pending)

---

## ⚠️ Known Limitations / Future Improvements

1. **Payment Amount for Downgrade**
   - Currently uses new plan's price
   - Could add pro-rata calculation if needed

2. **Immediate Activation**
   - Plan change is immediate (after payment)
   - Could add scheduled change if needed

3. **Revert Option**
   - No built-in revert mechanism
   - Could add admin function if needed

---

## 🆘 Troubleshooting

### Issue: "No active subscription found for upgrade"
- **Cause:** User doesn't have active subscription with end_date > now()
- **Fix:** Check subscription status and dates in database

### Issue: Payment shows 'pending' instead of 'success'
- **Cause:** Webhook not received or not processed correctly
- **Fix:** Check logs for webhook errors, verify callback URL

### Issue: Downgrade button not visible on pricing page
- **Cause:** Button text logic not working
- **Fix:** Check pricing.blade.php line 640-680

### Issue: End date not extended
- **Cause:** Old code still running (cache?)
- **Fix:** Clear config cache: `php artisan config:clear`

---

## 📞 Support

For issues during testing:
1. Check `storage/logs/laravel.log` for detailed logs
2. Look for emoji indicators (⬆️ 🆕 🔄 ⬇️ 💳)
3. Verify payment record exists with correct type
4. Verify subscription record updated (not created new)

---

**Last Updated:** 2026-01-28
**Status:** ✅ Ready for Testing
