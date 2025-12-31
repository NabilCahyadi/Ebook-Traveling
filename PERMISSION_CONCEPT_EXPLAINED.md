# 🎯 KONSEP PERMISSION SYSTEM - PENJELASAN LENGKAP

## ⚠️ PENTING: 2 MODE PERMISSION YANG BERBEDA!

Aplikasi ini menggunakan **2 MODE PERMISSION** yang **BERBEDA** dan **TIDAK DICAMPUR**:

---

## 📌 MODE 1: FRONT-END PERMISSION (Hardcoded)

### **Untuk Siapa?**
- 👤 **Member** (Premium user - sudah login, punya subscription)
- 👤 **Free User** (Registered user - sudah login, belum subscribe)
- 👻 **Guest** (NOT logged in - **TIDAK ADA DI DATABASE ROLES**)

### **Karakteristik:**
✅ Permission **TIDAK** disimpan di database  
✅ Permission **HARDCODE** di code (controller, middleware, view)  
✅ Check menggunakan logic biasa PHP:
- `auth()->check()` - Sudah login?
- `!auth()->check()` atau `@guest` - Guest (belum login)?
- `auth()->user()->isPremium()` - Premium member?
- `auth()->user()->hasActiveSubscription()` - Punya subscription aktif?
- `$user->subscription_status === 'active'` - Status subscription

### **⚠️ PENTING: Guest TIDAK ADA di Database Roles!**
```php
// ❌ SALAH: Cari Guest role di database
$guestRole = Role::where('slug', 'guest')->first();

// ✅ BENAR: Check guest via auth
if (!auth()->check()) {
    // This is a guest - no database lookup needed!
}

// ✅ BENAR: Di blade
@guest
    <a href="{{ route('login') }}">Login</a>
@endguest
```

**Kenapa Guest tidak perlu role database?**
- Guest = belum login → tidak ada user account
- Guest check = simple `!auth()->check()`
- Guest tidak bisa di-assign role karena tidak ada `user_id`

### **Contoh Implementasi:**

#### Di Controller:
```php
public function downloadEbook($id)
{
    // Hardcode check
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    if (!auth()->user()->isPremium()) {
        return redirect()->route('pricing')->with('error', 'Premium membership required');
    }
    
    // Allow download
}

public function readEbook($id)
{
    // Hardcode check
    if (!auth()->user()->hasActiveSubscription()) {
        abort(403, 'Active subscription required');
    }
    
    // Show ebook reader
}
```

#### Di Middleware:
```php
// app/Http/Middleware/PremiumOnly.php
public function handle($request, Closure $next)
{
    if (!auth()->user()->isPremium()) {
        abort(403, 'Premium membership required');
    }
    
    return $next($request);
}
```

#### Di Blade View:
```blade
{{-- Hardcode check --}}
@auth
    <button>Add to Cart</button>
@endauth

@if(auth()->user()->isPremium())
    <a href="{{ route('ebook.download', $ebook) }}">Download</a>
@else
    <a href="{{ route('pricing') }}">Upgrade to Premium</a>
@endif

@guest
    <a href="{{ route('login') }}">Login to Access</a>
@endguest
```

### **Kenapa Hardcode?**
1. ✅ **Lebih sederhana** - Tidak perlu maintain permission di database
2. ✅ **Lebih cepat** - Tidak query database untuk setiap check
3. ✅ **Lebih jelas** - Logic bisnis langsung terlihat di code
4. ✅ **Lebih stabil** - User tidak bisa ubah-ubah permission sendiri

### **Contoh Permission Hardcode:**

| Fitur | Guest (belum login) | Free User | Premium Member |
|-------|---------------------|-----------|----------------|
| Browse ebook | ✅ Yes | ✅ Yes | ✅ Yes |
| View ebook detail | ✅ Yes | ✅ Yes | ✅ Yes |
| Add to cart | ❌ **No** (redirect login) | ✅ Yes | ✅ Yes |
| Checkout | ❌ **No** (redirect login) | ✅ Yes | ✅ Yes |
| Read ebook online | ❌ **No** | ❌ No (upgrade needed) | ✅ **Yes** |
| Download ebook | ❌ **No** | ❌ No (upgrade needed) | ✅ **Yes** |
| Rate & review | ❌ **No** (must login) | ✅ Yes | ✅ Yes |
| Bookmark | ❌ **No** (must login) | ✅ Yes | ✅ Yes |

**Check Logic:**
```php
// Guest check
if (!auth()->check()) {
    return redirect()->route('login');
}

// Free User check  
if (auth()->check() && !auth()->user()->isPremium()) {
    return redirect()->route('pricing');
}

// Premium Member check
if (auth()->check() && auth()->user()->isPremium()) {
    // Allow download
}
```

---

## 📌 MODE 2: ADMIN PANEL PERMISSION (Dynamic Database)

### **Untuk Siapa?**
- 👨‍💼 **Admin** (Full access)
- 👨‍🎨 **Creator** (Limited access)
- *(Future: Moderator, Editor, dll)*

### **Karakteristik:**
✅ Permission **DISIMPAN** di database (tables: `permissions`, `role_permission`)  
✅ Permission **DINAMIS** - Bisa diubah via admin panel  
✅ Check menggunakan method `hasPermission()`:
- `auth('admin')->user()->hasPermission('admin.ebooks.approve')`
- Middleware: `->middleware('permission:admin.ebooks.view')`
- Blade: `@adminCan('admin.ebooks.edit')`

### **Contoh Implementasi:**

#### Di Route:
```php
// Protect route dengan middleware
Route::get('ebooks', [EbookController::class, 'index'])
    ->middleware('permission:admin.ebooks.view');

Route::post('ebooks/{id}/approve', [EbookController::class, 'approve'])
    ->middleware('permission:admin.ebooks.approve'); // Hanya Admin
```

#### Di Controller:
```php
public function approve($id)
{
    // Dynamic check dari database
    if (!auth('admin')->user()->hasPermission('admin.ebooks.approve')) {
        abort(403, 'You do not have permission to approve ebooks');
    }
    
    // Approve logic
}
```

#### Di Blade View:
```blade
{{-- Dynamic check dari database --}}
@adminCan('admin.ebooks.approve')
    <button class="btn-approve">Approve</button>
@endAdminCan

@adminCan('admin.users.view')
    <a href="{{ route('admin.users.index') }}">Manage Users</a>
@endAdminCan
```

### **Kenapa Database?**
1. ✅ **Fleksibel** - Bisa add/remove permission tanpa deploy code
2. ✅ **Granular** - Control akses per fitur
3. ✅ **Role-based** - Bisa buat role baru (Moderator, Editor, dll)
4. ✅ **Audit** - Bisa track siapa punya permission apa

### **Permission Distribution:**

| Role | Permissions | Can Access |
|------|-------------|------------|
| **Admin** | 46 permissions | ✅ Full admin panel |
| **Creator** | 9 permissions | ✅ Limited admin panel (own ebooks only) |

#### Admin Permissions (46):
- Dashboard: view
- Ebooks: view, create, edit, delete, **approve** ⭐
- Users: view, create, edit, delete ⭐
- Categories: view, create, edit, delete
- Cities: view, create, edit, delete
- Roles: view, create, edit, delete ⭐
- Permissions: view, assign ⭐
- Blogs: view, create, edit, delete
- Collections: view, create, edit, delete
- Banners: view, create, edit, delete
- Promos: view, create, edit, delete
- Subscriptions: view, manage ⭐
- Settings: view, edit ⭐
- Activity Logs: view ⭐

#### Creator Permissions (9):
- Panel access
- Dashboard: view
- Ebooks: view, create, edit, delete (own only)
- Categories: view (read-only)
- Cities: view (read-only)
- Collections: view (read-only)

---

## 🔄 PERBANDINGAN LENGKAP

| Aspek | Front-End (Hardcode) | Admin Panel (Database) |
|-------|---------------------|------------------------|
| **Users** | Guest (not logged in), Member, Free User | Admin, Creator |
| **Has Account?** | Member/Free: Yes, Guest: ❌ No | ✅ Yes (admins table) |
| **Has Role in DB?** | Member/Free: Yes (for mapping), Guest: ❌ **No** | ✅ Yes |
| **Storage** | ❌ No permission in DB | ✅ Database (`permissions` table) |
| **Check Method** | `auth()->check()`, `isPremium()`, `@guest` | `hasPermission('admin.xxx')` |
| **Blade Directive** | `@auth`, `@guest`, `@if()` | `@adminCan()`, `@hasPermission()` |
| **Middleware** | Custom logic middleware | `middleware('permission:xxx')` |
| **Flexibility** | Fixed (perlu deploy untuk ubah) | Dynamic (ubah via admin panel) |
| **Performance** | ⚡ Faster (no DB query) | 🐢 Slower (DB query) |
| **Use Case** | User-facing features | Admin panel features |
| **Example** | "Must login to download" | "Approve ebook submission" |

---

## ✅ IMPLEMENTASI YANG BENAR

### **Front-End Routes** (`routes/modules/public.php`, `routes/modules/user.php`):
```php
// Hardcode logic - NO database permission
Route::get('/ebooks/{slug}', [EbookController::class, 'show'])->name('ebooks.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/ebooks/{slug}/read', [EbookController::class, 'read'])
        ->middleware('premium'); // Custom middleware cek isPremium()
    
    Route::get('/ebooks/{slug}/download', [EbookController::class, 'download'])
        ->middleware('premium');
});
```

### **Admin Panel Routes** (`routes/modules/admin.php`):
```php
// Database permission
Route::prefix('admin')->middleware(['admin.session', 'auth:admin', 'admin'])->group(function () {
    
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->middleware('permission:admin.dashboard.view');
    
    Route::middleware('permission:admin.ebooks.view')->group(function () {
        Route::resource('ebooks', EbookController::class);
        
        Route::post('ebooks/{id}/approve', [EbookController::class, 'approve'])
            ->middleware('permission:admin.ebooks.approve'); // Hanya Admin
    });
    
    Route::resource('users', UserController::class)
        ->middleware('permission:admin.users.view'); // Hanya Admin
});
```

---

## 🚫 KESALAHAN UMUM

### ❌ **SALAH: Assign permission database ke Member/Free User**
```php
// JANGAN LAKUKAN INI!
$memberRole->permissions()->attach($permission);
```
**Kenapa salah?** Member/Free User tidak akses admin panel, tidak perlu permission database.

### ✅ **BENAR: Hardcode check untuk Member/Free User**
```php
// LAKUKAN INI!
if (auth()->user()->isPremium()) {
    // Allow download
}
```

---

### ❌ **SALAH: Hardcode check untuk Admin panel**
```php
// JANGAN LAKUKAN INI di admin panel!
if (auth('admin')->user()->email === 'superadmin@example.com') {
    // Allow approve
}
```
**Kenapa salah?** Admin panel harus flexible, bisa add admin baru tanpa ubah code.

### ✅ **BENAR: Database permission untuk Admin panel**
```php
// LAKUKAN INI!
if (auth('admin')->user()->hasPermission('admin.ebooks.approve')) {
    // Allow approve
}
```

---

## 📋 CHECKLIST IMPLEMENTASI

### Front-End Features:
- [ ] Premium download ebook → `auth()->user()->isPremium()`
- [ ] Read ebook online → `auth()->user()->hasActiveSubscription()`
- [ ] Add to cart → `auth()->check()`
- [ ] Checkout → `auth()->check()`
- [ ] Rate & review → `auth()->check()`
- [ ] View order history → `auth()->check()`

### Admin Panel Features:
- [x] Approve ebook → `hasPermission('admin.ebooks.approve')`
- [x] Manage users → `hasPermission('admin.users.view')`
- [x] Edit settings → `hasPermission('admin.settings.edit')`
- [x] View logs → `hasPermission('admin.activity_logs.view')`
- [x] Creator manage own ebooks → `hasPermission('admin.ebooks.edit')` + controller check

---

## 🎯 KESIMPULAN

1. **Front-End User (Member, Free, Guest):**
   - ❌ NO database permission
   - ✅ USE hardcoded logic
   - ✅ Check: `auth()`, `isPremium()`, subscription status

2. **Admin Panel User (Admin, Creator):**
   - ✅ USE database permission
   - ✅ Check: `hasPermission('admin.xxx')`
   - ✅ Flexible & granular control

**Jangan campur-campur kedua konsep ini!** 🚫
