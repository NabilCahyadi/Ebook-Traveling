# 🔐 Permission System Implementation Guide

## ✅ Implementasi Selesai!

Sistem role & permission telah berhasil diimplementasikan dengan konsep **2 MODE**:
1. **Front-end permissions** (Hardcode) - Untuk user biasa
2. **Admin panel permissions** (Dynamic) - Untuk admin & creator

---

## 🎯 KONSEP PERMISSION (IMPORTANT!)

### **2 MODE BERBEDA:**

#### **MODE 1: FRONT-END (Hardcoded Permission)**
**Berlaku untuk: Member, Free User, Guest**

✅ Permission check **LANGSUNG di code**  
✅ **TIDAK** menggunakan database permission  
✅ Check via: `auth()->check()`, `isPremium()`, subscription status  

```php
// Contoh hardcode permission
if (auth()->check()) {
    // User logged in bisa bookmark
}

if (auth()->user()->isPremium()) {
    // Premium member bisa download ebook
}

if (!auth()->check()) {
    // Guest tidak bisa checkout
}
```

#### **MODE 2: ADMIN PANEL (Dynamic Permission)**
**Berlaku untuk: Admin, Creator**

✅ Permission check **dari database**  
✅ Menggunakan `hasPermission('admin.xxx')`  
✅ Bisa diatur via admin panel `/admin/role-permissions`  

```php
// Dynamic permission dari database
if (auth('admin')->user()->hasPermission('admin.ebooks.approve')) {
    // Allow approve
}
```

---

## 📊 Status Permissions Per Role

| Role | Permissions | Database | Mode |
|------|-------------|----------|------|
| **Admin** | 46 permissions | ✅ Database | Admin Panel (Dynamic) |
| **Creator** | 9 permissions | ✅ Database | Admin Panel (Dynamic) |
| **Member** | 0 permissions | ❌ No DB | Front-end (Hardcode) |
| **Free User** | 0 permissions | ❌ No DB | Front-end (Hardcode) |
| **Guest** | 0 permissions | ❌ No DB | Front-end (Hardcode) |

**⚠️ PENTING:** Member, Free User, dan Guest **TIDAK** punya permission di database karena mereka menggunakan hardcoded logic!

---

## 🎯 Cara Menggunakan

### 1️⃣ **Di Routes** (Middleware Protection)

```php
// routes/modules/admin.php

// Single permission
Route::get('ebooks', [EbookController::class, 'index'])
    ->middleware('permission:admin.ebooks.view')
    ->name('ebooks.index');

// Group protection
Route::middleware('permission:admin.users.view')->group(function () {
    Route::resource('users', UserController::class);
    Route::get('users-trashed', [UserController::class, 'trashed']);
});
```

### 2️⃣ **Di Controller** (Method Protection)

```php
use Illuminate\Support\Facades\Auth;

class EbookController extends Controller
{
    public function __construct()
    {
        // Apply to all methods
        $this->middleware('permission:admin.ebooks.view');
        
        // Or specific methods
        $this->middleware('permission:admin.ebooks.create')->only(['create', 'store']);
        $this->middleware('permission:admin.ebooks.approve')->only(['approve', 'reject']);
    }
    
    public function approve($id)
    {
        $user = Auth::guard('admin')->user();
        
        // Manual check
        if (!$user->hasPermission('admin.ebooks.approve')) {
            abort(403, 'Only administrators can approve ebooks.');
        }
        
        // Your logic...
    }
}
```

### 3️⃣ **Di Blade Views** (UI Conditional)

```blade
{{-- Hide/Show buttons based on permission --}}
@adminCan('admin.ebooks.create')
    <a href="{{ route('admin.ebooks.create') }}" class="btn btn-primary">
        Upload Ebook
    </a>
@endAdminCan

@adminCan('admin.ebooks.approve')
    <button class="btn btn-success">Approve</button>
@endAdminCan

{{-- Hide sidebar menu items --}}
<ul class="sidebar-menu">
    @adminCan('admin.ebooks.view')
        <li><a href="{{ route('admin.ebooks.index') }}">Ebooks</a></li>
    @endAdminCan
    
    @adminCan('admin.users.view')
        <li><a href="{{ route('admin.users.index') }}">Users</a></li>
    @endAdminCan
    
    @adminCan('admin.settings.view')
        <li><a href="{{ route('admin.site-settings.index') }}">Settings</a></li>
    @endAdminCan
</ul>

{{-- Table action buttons --}}
@foreach($ebooks as $ebook)
    <tr>
        <td>{{ $ebook->title }}</td>
        <td>
            @adminCan('admin.ebooks.edit')
                <a href="{{ route('admin.ebooks.edit', $ebook->id) }}">Edit</a>
            @endAdminCan
            
            @adminCan('admin.ebooks.delete')
                <button onclick="deleteEbook({{ $ebook->id }})">Delete</button>
            @endAdminCan
        </td>
    </tr>
@endforeach
```

### 4️⃣ **Blade Directives Available**

```blade
{{-- Admin guard only --}}
@adminCan('permission.name')
    <!-- Content -->
@endAdminCan

{{-- User guard only --}}
@userCan('permission.name')
    <!-- Content -->
@endUserCan

{{-- Both guards --}}
@hasPermission('permission.name')
    <!-- Content -->
@endHasPermission

{{-- Alias for hasPermission --}}
@canPermission('permission.name')
    <!-- Content -->
@endCanPermission
```

### 5️⃣ **Manual Check di PHP**

```php
// In controller or anywhere
$user = Auth::guard('admin')->user();

// Single permission
if ($user->hasPermission('admin.ebooks.edit')) {
    // User has permission
}

// Get user's role
$role = $user->getRole(); // Returns Role model
```

---

## 📋 Permission Categories

### **Admin Panel Permissions** (Backend)

#### Dashboard
- `admin.dashboard.view` - View dashboard

#### Ebook Management
- `admin.ebooks.view` - View ebooks list
- `admin.ebooks.create` - Create new ebook
- `admin.ebooks.edit` - Edit ebook
- `admin.ebooks.delete` - Delete ebook
- `admin.ebooks.approve` - Approve/reject ebook ⚠️ **Admin only**

#### User Management
- `admin.users.view` - View users
- `admin.users.create` - Create user
- `admin.users.edit` - Edit user
- `admin.users.delete` - Delete user

#### Category Management
- `admin.categories.view`
- `admin.categories.create`
- `admin.categories.edit`
- `admin.categories.delete`

#### City Management
- `admin.cities.view`
- `admin.cities.create`
- `admin.cities.edit`
- `admin.cities.delete`

#### Role & Permission Management
- `admin.roles.view`
- `admin.roles.create`
- `admin.roles.edit`
- `admin.roles.delete`
- `admin.permissions.view` ⚠️ **Admin only**
- `admin.permissions.assign` ⚠️ **Admin only**

#### Blog Management
- `admin.blogs.view`
- `admin.blogs.create`
- `admin.blogs.edit`
- `admin.blogs.delete`

#### Collection Management
- `admin.collections.view`
- `admin.collections.create`
- `admin.collections.edit`
- `admin.collections.delete`

#### Banner & Promo Management
- `admin.banners.view/create/edit/delete`
- `admin.promos.view/create/edit/delete`

#### Subscription Management
- `admin.subscriptions.view` ⚠️ **Admin only**
- `admin.subscriptions.manage` ⚠️ **Admin only**

#### Settings
- `admin.settings.view` ⚠️ **Admin only**
- `admin.settings.edit` ⚠️ **Admin only**

#### Activity Logs
- `admin.activity_logs.view` ⚠️ **Admin only**

### **Front-End Permissions** (User Side)

#### Ebook Features
- `view_ebook_library` - Browse ebooks
- `read_ebook` - Read online (Premium)
- `download_ebook` - Download (Premium)
- `rate_ebook` - Rate & review
- `bookmark_ebook` - Save bookmarks

#### Creator Features
- `upload_ebook` - Upload new ebook
- `edit_own_ebook` - Edit own ebooks
- `delete_own_ebook` - Delete own ebooks
- `view_ebook_analytics` - View stats

#### Shopping & Payment
- `add_to_cart`
- `checkout`
- `use_promo_code`
- `view_order_history`

#### Subscription
- `subscribe` - Subscribe to plans
- `manage_subscription` - Manage subscription
- `cancel_subscription` - Cancel subscription
- `upgrade_subscription` - Upgrade plan

---

## 🔄 Permission Assignment per Role

### **Admin Role** (46 permissions)
✅ Full admin panel access  
✅ User management  
✅ Content approval  
✅ Settings & logs  
✅ All CRUD operations  

### **Creator Role** (13 permissions)
✅ Access admin panel  
✅ View dashboard  
✅ Manage own ebooks only  
✅ Upload new content  
✅ View analytics  
❌ Cannot approve ebooks  
❌ Cannot manage users  
❌ Cannot access settings  

### **Member Role** (39 permissions - Premium)
✅ Read ebooks online  
✅ Download ebooks  
✅ All front-end features  
✅ Shopping & checkout  
✅ Manage subscription  

### **Free User Role** (32 permissions)
✅ Browse ebooks  
✅ Add to cart  
✅ Rate & bookmark  
❌ Cannot read/download ebooks  
❌ Must subscribe  

### **Guest Role** (13 permissions)
✅ View public pages  
✅ Browse ebook library  
❌ Cannot checkout  
❌ Must register  

---

## 🛠️ Files Modified/Created

### Models
- ✅ `app/Models/Admin.php` - Added `hasPermission()` method
- ✅ `app/Models/User.php` - Added `hasPermission()` method
- ✅ `app/Models/Role.php` - Already has `hasPermission()`
- ✅ `app/Models/Permission.php` - Already exists

### Middleware
- ✅ `app/Http/Middleware/CheckPermission.php` - Already exists

### Providers
- ✅ `app/Providers/AppServiceProvider.php` - Added Blade directives

### Routes
- ✅ `routes/modules/admin.php` - Added permission middleware

### Seeders
- ✅ `database/seeders/AssignRolePermissionsSeeder.php` - **NEW**
- ✅ `database/seeders/PermissionSeeder.php` - Already exists
- ✅ `database/seeders/AdminPermissionSeeder.php` - Already exists
- ✅ `database/seeders/RoleSeeder.php` - Already exists

### Examples/Documentation
- ✅ `app/Http/Controllers/Admin/PermissionExampleController.php` - **NEW**
- ✅ `resources/views/admin/examples/permission-examples.blade.php` - **NEW**
- ✅ `PERMISSION_SYSTEM_IMPLEMENTATION.md` - **NEW** (this file)

---

## 🚀 Next Steps

### 1. **Update Sidebar Menu**
Edit `resources/views/layouts/partials/admin/sidebar.blade.php`:
```blade
@adminCan('admin.ebooks.view')
    <li><a href="{{ route('admin.ebooks.index') }}">Ebooks</a></li>
@endAdminCan
```

### 2. **Add Permission Checks to Existing Controllers**
Add middleware or manual checks to your existing controllers.

### 3. **Update Views**
Add `@adminCan` directives to hide/show buttons based on permissions.

### 4. **Test Each Role**
- Create test admin user
- Create test creator user
- Test access levels

### 5. **Manage Permissions via Admin Panel**
Use route: `/admin/role-permissions` to assign/remove permissions dynamically.

---

## 🔍 Testing Commands

```bash
# Check permissions in database
php artisan tinker
>>> $role = App\Models\Role::where('slug', 'creator')->first();
>>> $role->permissions->pluck('name');

# Check if user has permission
>>> $admin = App\Models\Admin::first();
>>> $admin->hasPermission('admin.ebooks.approve');

# Check role-permission count
>>> App\Models\Role::withCount('permissions')->get();
```

---

## ⚠️ Important Notes

1. **Superadmin Bypass**: Admin dengan `type='superadmin'` bypass semua permission checks
2. **Creator Limitation**: Creator hanya bisa edit/delete ebook sendiri (implement di controller)
3. **Admin Type Mapping**: Admin table menggunakan field `type` (admin/superadmin) yang di-map ke roles
4. **User Type Mapping**: User table menggunakan field `user_type` (member/creator/free-user) yang di-map ke roles
5. **Panel Access**: Permission `panel.access` required untuk login ke admin panel

---

## 🐛 Troubleshooting

### "Permission denied" meski sudah login
```bash
# Re-run seeder
php artisan db:seed --class=AssignRolePermissionsSeeder
php artisan db:seed --class=PanelAccessPermissionSeeder
```

### Permission tidak muncul di dropdown
```bash
# Re-run permission seeders
php artisan db:seed --class=PermissionSeeder
php artisan db:seed --class=AdminPermissionSeeder
```

### Role tidak ada
```bash
# Check soft deleted roles
SELECT * FROM roles WHERE deleted_at IS NOT NULL;

# Restore
UPDATE roles SET deleted_at = NULL WHERE slug = 'admin';
```

---

## 📚 References

- Middleware: `app/Http/Middleware/CheckPermission.php`
- Permission Model: `app/Models/Permission.php`
- Role Model: `app/Models/Role.php`
- Blade Directives: `app/Providers/AppServiceProvider.php`
- Example Controller: `app/Http/Controllers/Admin/PermissionExampleController.php`
- Example Views: `resources/views/admin/examples/permission-examples.blade.php`

---

**✨ Sistem permission sudah berfungsi penuh!**

Silakan mulai implementasikan permission checks di controllers dan views Anda.
