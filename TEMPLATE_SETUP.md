# Template Setup Documentation

## Struktur Template yang Sudah Dikonfigurasi

Project ini menggunakan 3 template berbeda untuk kebutuhan yang berbeda:

### 1. **Auth Template** (Form Login)

-   **Lokasi Layout**: `resources/views/layouts/auth.blade.php`
-   **Assets**: `public/assets/auth/`
-   **Penggunaan**: Halaman login dan registrasi
-   **Route**:
    -   `/login`
    -   `/register`

### 2. **Front Template** (Nest - User Interface)

-   **Lokasi Layout**: `resources/views/layouts/front.blade.php`
-   **Assets**: `public/assets/front/`
-   **Penggunaan**: Semua halaman untuk user biasa (non-admin)
-   **Route Examples**:
    -   `/` (Home)
    -   `/shop` (Shop pages)
    -   `/blog` (Blog)
    -   `/page/about` (About)
    -   `/page/contact` (Contact)
    -   `/user/account` (User account - requires login)

**Partials:**

-   Header: `resources/views/layouts/partials/front/header.blade.php`
-   Footer: `resources/views/layouts/partials/front/footer.blade.php`

### 3. **Admin Template** (Vuexy - Admin Panel)

-   **Lokasi Layout**: `resources/views/layouts/admin.blade.php`
-   **Assets**: `public/assets/admin/`
-   **Penggunaan**: Semua halaman untuk admin saja
-   **Middleware**: `admin` (hanya user dengan role 'admin' yang bisa akses)
-   **Route Prefix**: `/admin`
-   **Route Examples**:
    -   `/admin/dashboard`
    -   `/admin/ebooks`
    -   `/admin/users`
    -   `/admin/orders`
    -   `/admin/settings`

**Partials:**

-   Sidebar: `resources/views/layouts/partials/admin/sidebar.blade.php`
-   Navbar: `resources/views/layouts/partials/admin/navbar.blade.php`
-   Footer: `resources/views/layouts/partials/admin/footer.blade.php`

## Cara Menggunakan Template

### Untuk Halaman Auth (Login/Register):

```blade
@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <!-- Your auth form here -->
@endsection
```

### Untuk Halaman Front (User):

```blade
@extends('layouts.front')

@section('title', 'Home')

@section('content')
    <!-- Your user content here -->
@endsection

@push('styles')
    <!-- Additional CSS if needed -->
@endpush

@push('scripts')
    <!-- Additional JS if needed -->
@endpush
```

### Untuk Halaman Admin:

```blade
@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <!-- Your admin content here -->
@endsection

@push('styles')
    <!-- Additional CSS if needed -->
@endpush

@push('scripts')
    <!-- Additional JS if needed -->
@endpush
```

## Middleware Setup

### Admin Middleware

File: `app/Http/Middleware/AdminMiddleware.php`

Middleware ini memastikan:

1. User sudah login
2. User memiliki role 'admin'

Jika tidak memenuhi syarat, user akan:

-   Redirect ke login (jika belum login)
-   Error 403 Forbidden (jika bukan admin)

### Registrasi Middleware

File: `bootstrap/app.php`

```php
$middleware->alias([
    'admin' => \App\Http\Middleware\AdminMiddleware::class,
]);
```

## Route Structure

### Public Routes (No Auth Required)

```php
/ (home)
/shop
/blog
/page/about
/page/contact
```

### Auth Routes

```php
/login
/register
/logout (POST)
```

### User Routes (Auth Required)

```php
/user/account
/user/* (protected by 'auth' middleware)
```

### Admin Routes (Auth + Admin Role Required)

```php
/admin/dashboard
/admin/ebooks
/admin/users
/admin/orders
/admin/* (protected by 'auth' and 'admin' middleware)
```

## Assets Structure

```
public/
├── assets/
│   ├── auth/          # Form login template assets
│   │   ├── style.css
│   │   ├── script.js
│   │   └── index.html (reference)
│   ├── front/         # Nest template assets (user facing)
│   │   ├── css/
│   │   ├── js/
│   │   ├── imgs/
│   │   └── fonts/
│   └── admin/         # Vuexy template assets (admin panel)
│       ├── css/
│       ├── js/
│       ├── img/
│       ├── vendor/
│       └── fonts/
```

## Template Features

### Auth Template Features:

-   Modern double slider design
-   Social login integration (Google)
-   Responsive form design
-   Smooth animations

### Front Template (Nest) Features:

-   E-commerce focused design
-   Shopping cart functionality
-   Product wishlist
-   Blog system
-   User account management
-   Newsletter subscription
-   Mobile responsive
-   SEO optimized

### Admin Template (Vuexy) Features:

-   Modern dashboard design
-   Vertical sidebar navigation
-   Dark/Light mode support
-   Notification system
-   User profile management
-   Multiple chart types (ApexCharts)
-   DataTables integration
-   Form validation
-   File upload
-   Fully responsive

## Cara Menambah Halaman Baru

### 1. Halaman User (Front Template):

```bash
# Buat file view
resources/views/front/your-page.blade.php
```

```php
// Tambah route di routes/web.php
Route::get('/your-page', function () {
    return view('front.your-page');
})->name('your.page');
```

### 2. Halaman Admin:

```bash
# Buat file view
resources/views/admin/your-page.blade.php
```

```php
// Tambah route di routes/web.php (dalam group admin)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/your-page', [YourController::class, 'index'])
        ->name('admin.your.page');
});
```

## Troubleshooting

### Template tidak muncul dengan benar?

1. Pastikan assets sudah di-copy ke folder `public/assets/`
2. Clear cache Laravel: `php artisan cache:clear`
3. Clear view cache: `php artisan view:clear`

### Error 403 Forbidden di halaman admin?

1. Pastikan user sudah login
2. Cek apakah user memiliki role 'admin'
3. Cek tabel `user_roles` dan `roles`

### Asset CSS/JS tidak load?

1. Cek path di layout blade file
2. Pastikan menggunakan `asset()` helper
3. Cek permission folder `public/assets/`

## Notes Penting

1. **Jangan edit file di folder `template/`** - Folder ini hanya untuk referensi template original
2. **Semua assets sudah di-copy ke `public/assets/`** - Edit assets di folder ini
3. **Template sudah terpisah dengan baik**:
    - Auth untuk login/register
    - Front untuk user interface
    - Admin untuk admin panel
4. **Middleware admin sudah aktif** - Hanya user dengan role 'admin' yang bisa akses `/admin/*`

## Testing

### Test Auth Template:

```
URL: http://localhost/login
```

### Test Front Template:

```
URL: http://localhost/
```

### Test Admin Template:

```
URL: http://localhost/admin/dashboard
(Requires login with admin role)
```

## Struktur View yang Disarankan

```
resources/views/
├── layouts/
│   ├── auth.blade.php          # Auth template layout
│   ├── front.blade.php         # Front template layout
│   ├── admin.blade.php         # Admin template layout
│   └── partials/
│       ├── front/
│       │   ├── header.blade.php
│       │   └── footer.blade.php
│       └── admin/
│           ├── sidebar.blade.php
│           ├── navbar.blade.php
│           └── footer.blade.php
├── auth/
│   ├── login.blade.php
│   └── register.blade.php
├── front/
│   ├── index.blade.php
│   ├── shop/
│   ├── blog/
│   └── page/
└── admin/
    ├── dashboard.blade.php
    ├── ebooks/
    ├── users/
    └── settings/
```

---

**Last Updated**: November 19, 2025
**Version**: 1.0
