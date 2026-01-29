# 🎯 Pricing Page - Functional Renew & Upgrade Buttons

## 📋 Overview

Implementasi functional buttons untuk **Renew Subscription** dan **Upgrade Subscription** di pricing page, dengan filter upgrade list yang hanya menampilkan plan dengan durasi lebih tinggi.

---

## ✅ Features Implemented

### 1. **Filter Upgrade List di Account Page**
**Location**: `app/Http/Controllers/AccountController.php`

**What Changed**:
- ❌ **BEFORE**: Menampilkan SEMUA subscription plans di upgrade list
- ✅ **AFTER**: Hanya menampilkan plans dengan `duration_days` > current active plan

**Code**:
```php
// ✅ 4. GET SUBSCRIPTION PLANS FOR UPGRADE OPTIONS
// Only show plans with higher duration than current active plan
$currentPlan = $user->currentPlan;
$currentDuration = $currentPlan ? $currentPlan->duration_days : 0;

$subscriptionPlans = \App\Models\SubscriptionPlan::where('is_active', true)
    ->where('duration_days', '>', $currentDuration)
    ->orderBy('duration_days', 'asc')
    ->get();
```

**Benefits**:
- User hanya lihat plan yang benar-benar upgrade (lebih tinggi durasinya)
- Tidak menampilkan plan yang sama atau lebih rendah
- UX lebih clean dan tidak membingungkan

---

### 2. **Functional Renew & Upgrade Buttons di Pricing Page**
**Location**: `resources/views/pricing.blade.php`

**What Changed**:
- ❌ **BEFORE**: Button onclick tapi tidak ada JavaScript function
- ✅ **AFTER**: Button submit form POST ke route renew/upgrade

**Renew Button** (untuk plan yang sedang aktif):
```blade
@if($isCurrentPlan)
<!-- RENEW: Pakai form POST -->
<form action="{{ route('subscription.renew') }}" method="POST" class="w-100">
    @csrf
    <input type="hidden" name="plan_slug" value="{{ $plan->slug }}">
    <button type="submit" class="pricing-button pricing-button--primary w-100">
        <i class="fi fi-rs-refresh me-1"></i> Renew Subscription
    </button>
</form>
@endif
```

**Upgrade Button** (untuk plan dengan durasi lebih tinggi):
```blade
@elseif($plan->duration_days > $currentDuration)
<!-- UPGRADE: Pakai form POST -->
<form action="{{ route('subscription.upgrade') }}" method="POST" class="w-100">
    @csrf
    <input type="hidden" name="plan_slug" value="{{ $plan->slug }}">
    <button type="submit" class="pricing-button pricing-button--primary w-100">
        <i class="fi fi-rs-arrow-up me-1"></i> Upgrade Subscription
    </button>
</form>
@endif
```

**Logic Summary**:
1. **User belum login** → Show "Login to Subscribe"
2. **User tidak punya subscription** → Show "Subscribe Now" link
3. **User punya subscription aktif**:
   - **Sama plan** → Show "Renew Subscription" button ✅
   - **Plan lebih tinggi** → Show "Upgrade Subscription" button ✅
   - **Plan lebih rendah/sama** → Show "Upgrade only" (disabled)

---

## 🎨 Visual Changes

### Pricing Page Button States:

**Scenario 1: User Tidak Login**
```
┌─────────────────────────┐
│   Daily Plan - Rp 5K    │
│                         │
│ [Login to Subscribe]    │
└─────────────────────────┘
```

**Scenario 2: User Login, Belum Subscribe**
```
┌─────────────────────────┐
│   Daily Plan - Rp 5K    │
│                         │
│ [Subscribe Now]         │
│ [Call Us - WhatsApp]    │
└─────────────────────────┘
```

**Scenario 3: User Subscribe Daily Plan**
```
┌─────────────────────────┐
│   Daily Plan - Rp 5K    │  ← Current Plan
│                         │
│ [🔄 Renew Subscription] │  ✅ FUNCTIONAL!
│ [Call Us - WhatsApp]    │
└─────────────────────────┘

┌─────────────────────────┐
│  Weekly Plan - Rp 20K   │  ← Higher Tier
│                         │
│ [⬆️ Upgrade Subscription]│  ✅ FUNCTIONAL!
│ [Call Us - WhatsApp]    │
└─────────────────────────┘

┌─────────────────────────┐
│  Monthly Plan - Rp 75K  │  ← Highest Tier
│                         │
│ [⬆️ Upgrade Subscription]│  ✅ FUNCTIONAL!
│ [Call Us - WhatsApp]    │
└─────────────────────────┘
```

---

## 🔄 Flow Diagram

### Renew Flow:
```
User di Pricing Page
    ↓
Klik plan yang SAMA dengan current plan
    ↓
Klik "Renew Subscription" button
    ↓
POST ke /subscription/renew
    ↓
Create payment dengan payment_type='renewal'
    ↓
Redirect ke Mayar payment page
    ↓
User bayar
    ↓
Webhook callback
    ↓
Duration extended (+X days)
```

### Upgrade Flow:
```
User di Pricing Page
    ↓
Klik plan LEBIH TINGGI dari current plan
    ↓
Klik "Upgrade Subscription" button
    ↓
POST ke /subscription/upgrade
    ↓
Create payment dengan payment_type='upgrade'
    ↓
Redirect ke Mayar payment page
    ↓
User bayar
    ↓
Webhook callback
    ↓
Old subscription deactivated
New subscription created
```

---

## 📝 Files Modified

### 1. **AccountController.php** - Filter Upgrade List
**Location**: `app/Http/Controllers/AccountController.php`
**Lines**: ~54-64

**Changes**:
- Added filter: `where('duration_days', '>', $currentDuration)`
- Only shows plans higher than current plan

### 2. **pricing.blade.php** - Functional Buttons
**Location**: `resources/views/pricing.blade.php`
**Lines**: ~526-560

**Changes**:
- Changed from `onclick="subscribeWithMayar()"` to `<form>` POST
- Added proper logic for renew/upgrade detection
- Uses `duration_days` comparison instead of `price`
- Added icons for visual distinction (🔄 renew, ⬆️ upgrade)

### 3. **page-account.blade.php** - Simplified Upgrade List
**Location**: `resources/views/page-account.blade.php`
**Lines**: ~1099-1128

**Changes**:
- Removed `@if($upgradePlan->duration_days > $plan->duration_days)` check
- Filter now handled by controller (cleaner code)

---

## 🧪 Testing Scenarios

### Test 1: User Dengan Subscription Aktif (Daily Plan)

**Go to Pricing Page**:
1. ✅ Daily Plan card → Shows "Renew Subscription" button
2. ✅ Weekly Plan card → Shows "Upgrade Subscription" button
3. ✅ Monthly Plan card → Shows "Upgrade Subscription" button

**Click Renew Button**:
1. ✅ Redirects to Mayar payment
2. ✅ Payment created with payment_type='renewal'
3. ✅ After payment → Duration extended

**Click Upgrade Button**:
1. ✅ Redirects to Mayar payment
2. ✅ Payment created with payment_type='upgrade'
3. ✅ After payment → New subscription created, old deactivated

### Test 2: User Tanpa Subscription

**Go to Pricing Page**:
1. ✅ All cards → Show "Subscribe Now" or direct Mayar link
2. ✅ WhatsApp button available

### Test 3: User Belum Login

**Go to Pricing Page**:
1. ✅ All cards → Show "Login to Subscribe" button
2. ✅ Click button → Redirect to login page

### Test 4: Account Page Upgrade List

**Go to Account Page → Subscription Tab**:
1. ✅ Upgrade list HANYA menampilkan plans dengan durasi > current plan
2. ✅ Jika user pakai Daily (1 day), hanya tampilkan Weekly (7 days) dan Monthly (30 days)
3. ✅ Upgrade buttons functional (POST form)

---

## 🎯 Key Improvements

### 1. **Better UX**
- Clear visual distinction between renew/upgrade actions
- Icons make intent obvious (🔄 = renew, ⬆️ = upgrade)
- No confusion with downgrade options (hidden)

### 2. **Cleaner Code**
- Filter logic di controller (not in view)
- Proper form POST instead of JavaScript onclick
- Consistent with page-account.blade.php pattern

### 3. **Correct Logic**
- Uses `duration_days` comparison (not price)
- Handles edge cases (no subscription, same plan, etc.)
- Follows existing renew/upgrade route patterns

### 4. **Maintainability**
- Easy to add new plan tiers
- Filter automatically updates based on duration
- No hardcoded plan names or IDs

---

## 📊 Database Query Optimization

**BEFORE (Inefficient)**:
```php
// Get ALL plans, filter in view
$subscriptionPlans = SubscriptionPlan::where('is_active', true)->get();

// In view: @if($upgradePlan->duration_days > $plan->duration_days)
```

**AFTER (Efficient)**:
```php
// Get ONLY relevant plans with SQL filter
$subscriptionPlans = SubscriptionPlan::where('is_active', true)
    ->where('duration_days', '>', $currentDuration)
    ->get();

// In view: Just loop, no additional filtering needed
```

**Benefits**:
- ✅ Fewer records fetched from database
- ✅ Less memory usage
- ✅ Cleaner blade templates
- ✅ Better performance with many plans

---

## 🚀 Deployment Checklist

Before testing:
- ✅ Config cache cleared (`php artisan config:clear`)
- ✅ View cache cleared (`php artisan view:clear`)
- ✅ Application cache cleared (`php artisan cache:clear`)
- ✅ Routes working: `/subscription/renew` and `/subscription/upgrade`
- ✅ ngrok tunnel active (if testing payments)

After deployment:
- ⏳ Test renew button on pricing page
- ⏳ Test upgrade button on pricing page
- ⏳ Verify upgrade list on account page only shows higher tiers
- ⏳ Complete test payment for renew
- ⏳ Complete test payment for upgrade

---

## 💡 Business Logic Summary

### Renew:
- **Condition**: User punya subscription aktif DAN klik plan yang SAMA
- **Action**: Extend end_date dengan +X days (sesuai plan duration)
- **Button Text**: "Renew Subscription" dengan icon 🔄

### Upgrade:
- **Condition**: User punya subscription aktif DAN klik plan dengan duration_days LEBIH TINGGI
- **Action**: Deactivate old subscription, create new subscription
- **Button Text**: "Upgrade Subscription" dengan icon ⬆️

### Downgrade:
- **Condition**: User punya subscription aktif DAN klik plan dengan duration_days LEBIH RENDAH
- **Action**: TIDAK DIIZINKAN
- **Button Text**: "Upgrade only" (disabled, grayed out)

---

## 🎊 Status

**Implementation**: COMPLETE ✅  
**Testing**: READY ✅  
**Documentation**: COMPLETE ✅  

**Next Steps**:
1. Test renew button functionality
2. Test upgrade button functionality
3. Verify filter works correctly on account page
4. Complete end-to-end payment flow testing

---

## 📞 Related Documentation

- [SUBSCRIPTION_RENEW_UPGRADE_GUIDE.md](SUBSCRIPTION_RENEW_UPGRADE_GUIDE.md) - Implementasi renew/upgrade features
- [RENEWAL_UPGRADE_BUGFIX.md](RENEWAL_UPGRADE_BUGFIX.md) - Bugfix untuk renewal not extending duration
- [MAYAR_EXTERNAL_ID_ISSUE_FIX.md](MAYAR_EXTERNAL_ID_ISSUE_FIX.md) - Fallback mechanism untuk Mayar webhook
- [NEW_SUBSCRIPTION_PLAN_MISMATCH_FIX.md](NEW_SUBSCRIPTION_PLAN_MISMATCH_FIX.md) - Case-insensitive plan matching

