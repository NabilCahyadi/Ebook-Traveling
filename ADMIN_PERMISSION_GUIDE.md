# Admin Permission System

## Fitur yang Telah Dibuat

### 1. Database Structure
- Tabel `admin_permission` (pivot table) untuk relasi many-to-many antara admin dan permissions
- Migration: `2026_01_06_030602_create_admin_permission_pivot_table.php`

### 2. Model & Relationships
**Admin Model** telah ditambahkan:
- `permissions()` - Relasi many-to-many dengan Permission
- `hasPermission($permissionName)` - Cek single permission
- `hasAnyPermission($permissions)` - Cek salah satu dari beberapa permissions
- `hasAllPermissions($permissions)` - Cek semua permissions
- `syncPermissions($permissionIds)` - Sync permissions

### 3. Controller
**AdminPermissionController** (`app/Http/Controllers/Admin/AdminPermissionController.php`)
- `edit($id)` - Menampilkan form permission untuk admin
- `update($id)` - Update permissions admin
- Hanya bisa diakses oleh superadmin

### 4. Views
**resources/views/admin/admins/permissions.blade.php**
- Form untuk mengelola permissions per admin
- Permissions dikelompokkan berdasarkan module
- Fitur "Select All" per module
- Tidak bisa edit permission untuk superadmin

### 5. Routes
**routes/modules/admin.php**
```php
Route::get('admins/{id}/permissions', [AdminPermissionController::class, 'edit'])->name('admins.permissions.edit');
Route::put('admins/{id}/permissions', [AdminPermissionController::class, 'update'])->name('admins.permissions.update');
```

### 6. Middleware
**CheckAdminPermission** (`app/Http/Middleware/CheckAdminPermission.php`)
- Alias: `admin.permission`
- Registered di `bootstrap/app.php`

### 7. Navigation
**Admin Management Index** telah ditambahkan menu "Kelola Permission" di dropdown actions untuk admin biasa (tidak tampil untuk superadmin karena superadmin punya semua akses).

### 8. Permissions Seeder
**AdminPermissionsSeeder** telah dibuat dengan 30+ permissions default yang mencakup:
- Dashboard & Analytics
- User Management
- Ebook Management
- Category Management
- Blog Management
- Order & Payment Management
- Promo Management
- Banner Management
- Subscription Management
- Website Settings
- Landing Page Management
- Reports & Logs
- Creator Management

## Cara Menggunakan

### 1. Mengatur Permission untuk Admin
1. Login sebagai **superadmin**
2. Buka menu **Pengaturan > Manajemen Admin**
3. Pada daftar admin, klik tombol **actions** (3 titik) pada admin yang ingin diatur
4. Pilih **"Kelola Permission"**
5. Centang permission yang ingin diberikan
6. Klik **"Simpan Permission"**

### 2. Menggunakan Middleware di Routes
```php
// Contoh: Hanya admin dengan permission 'ebooks.view' yang bisa akses
Route::get('/ebooks', [EbookController::class, 'index'])
    ->middleware(['auth:admin', 'admin.permission:ebooks.view']);

// Contoh dengan multiple middleware
Route::group(['middleware' => ['auth:admin', 'admin.permission:users.manage']], function () {
    Route::resource('users', UserController::class);
});
```

### 3. Cek Permission di Controller
```php
public function index()
{
    $admin = auth('admin')->user();
    
    // Cek single permission
    if ($admin->hasPermission('ebooks.view')) {
        // Admin punya permission
    }
    
    // Cek any permission (salah satu)
    if ($admin->hasAnyPermission(['ebooks.view', 'ebooks.create'])) {
        // Admin punya salah satu permission
    }
    
    // Cek all permissions
    if ($admin->hasAllPermissions(['ebooks.view', 'ebooks.edit'])) {
        // Admin punya semua permission
    }
}
```

### 4. Cek Permission di Blade View
```blade
@if(auth('admin')->user()->hasPermission('ebooks.create'))
    <a href="{{ route('admin.ebooks.create') }}" class="btn btn-primary">
        Tambah Ebook
    </a>
@endif

@if(auth('admin')->user()->hasAnyPermission(['users.view', 'users.manage']))
    <li class="menu-item">
        <a href="{{ route('admin.users.index') }}">
            <i class="menu-icon ti ti-users"></i>
            <span>Users</span>
        </a>
    </li>
@endif
```

### 5. Menambah Permission Baru
Edit file `database/seeders/AdminPermissionsSeeder.php` dan tambahkan permission baru:
```php
[
    'name' => 'module.action',
    'display_name' => 'Display Name',
    'description' => 'Description of permission',
    'module' => 'module_name',
    'group' => 'group_name',
],
```

Kemudian jalankan seeder:
```bash
php artisan db:seed --class=AdminPermissionsSeeder
```

## Catatan Penting

1. **Superadmin** memiliki semua permission secara otomatis tanpa perlu diatur
2. **Regular Admin** perlu diatur permissionnya satu per satu oleh superadmin
3. Jika admin tidak punya permission yang diperlukan, akan muncul error 403
4. Permission dikelompokkan berdasarkan **module** untuk memudahkan pengelolaan
5. Gunakan format nama permission: `module.action` (contoh: `ebooks.view`, `users.create`)

## Permission List

Berikut daftar permissions yang tersedia:

### Dashboard
- `dashboard.view` - Lihat Dashboard

### Users
- `users.view` - Lihat Daftar User
- `users.create` - Tambah User
- `users.edit` - Edit User
- `users.delete` - Hapus User

### Ebooks
- `ebooks.view` - Lihat Daftar Ebook
- `ebooks.create` - Tambah Ebook
- `ebooks.edit` - Edit Ebook
- `ebooks.delete` - Hapus Ebook
- `ebooks.approve` - Approve Ebook

### Categories
- `categories.view` - Lihat Kategori
- `categories.manage` - Kelola Kategori

### Blogs
- `blogs.view` - Lihat Blog
- `blogs.manage` - Kelola Blog

### Orders & Payments
- `orders.view` - Lihat Order
- `orders.manage` - Kelola Order
- `payments.view` - Lihat Payment

### Promos & Banners
- `promos.view` - Lihat Promo
- `promos.manage` - Kelola Promo
- `banners.view` - Lihat Banner
- `banners.manage` - Kelola Banner

### Subscriptions
- `subscriptions.view` - Lihat Subscription
- `subscriptions.manage` - Kelola Subscription

### Settings & Landing Page
- `settings.view` - Lihat Pengaturan
- `settings.manage` - Kelola Pengaturan
- `landing-page.view` - Lihat Landing Page
- `landing-page.manage` - Kelola Landing Page

### Reports & Logs
- `reports.view` - Lihat Laporan
- `activity-logs.view` - Lihat Activity Logs

### Creators
- `creators.view` - Lihat Creator
- `creators.manage` - Kelola Creator

## Contoh Implementasi di Routes

```php
// routes/modules/admin.php

Route::prefix('admin')->name('admin.')->middleware(['auth:admin'])->group(function () {
    
    // Ebooks - Dengan permission check
    Route::middleware(['admin.permission:ebooks.view'])->group(function () {
        Route::get('/ebooks', [EbookController::class, 'index'])->name('ebooks.index');
    });
    
    Route::middleware(['admin.permission:ebooks.create'])->group(function () {
        Route::get('/ebooks/create', [EbookController::class, 'create'])->name('ebooks.create');
        Route::post('/ebooks', [EbookController::class, 'store'])->name('ebooks.store');
    });
    
    Route::middleware(['admin.permission:ebooks.edit'])->group(function () {
        Route::get('/ebooks/{id}/edit', [EbookController::class, 'edit'])->name('ebooks.edit');
        Route::put('/ebooks/{id}', [EbookController::class, 'update'])->name('ebooks.update');
    });
    
    Route::middleware(['admin.permission:ebooks.delete'])->group(function () {
        Route::delete('/ebooks/{id}', [EbookController::class, 'destroy'])->name('ebooks.destroy');
    });
});
```
