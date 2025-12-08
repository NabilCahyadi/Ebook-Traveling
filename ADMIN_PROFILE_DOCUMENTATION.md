# Admin Profile Management Documentation

## Overview

Halaman profile admin memungkinkan administrator untuk mengelola informasi profil mereka sendiri dan mengubah password.

## Features

### 1. Profile Information

Admin dapat mengubah informasi berikut:

-   **Name** - Nama lengkap admin
-   **Email** - Alamat email (harus unik)
-   **Phone** - Nomor telepon dengan kode negara Indonesia (+62)
-   **City** - Kota tempat tinggal
-   **Address** - Alamat lengkap
-   **Country** - Negara (default: Indonesia)
-   **Bio** - Deskripsi singkat tentang admin (maksimal 1000 karakter)
-   **Avatar** - Foto profil (JPG, PNG, GIF - maksimal 2MB)

### 2. Change Password

Admin dapat mengubah password dengan validasi:

-   Current password harus benar
-   Password baru minimal 8 karakter
-   Konfirmasi password harus sama

## File Structure

### Controller

```
app/Http/Controllers/Admin/ProfileController.php
```

Methods:

-   `edit()` - Menampilkan form edit profile
-   `update()` - Mengupdate informasi profile
-   `updatePassword()` - Mengubah password

### View

```
resources/views/admin/profile/edit.blade.php
```

Fitur:

-   Form edit profile dengan preview avatar
-   Form change password
-   Upload avatar dengan preview real-time
-   Reset avatar button

### Routes

```php
// routes/modules/admin.php
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
```

## Database

### Table: profiles

Fields:

-   `id` (uuid, primary key)
-   `user_id` (uuid, foreign key to users)
-   `bio` (text, nullable)
-   `address` (text, nullable)
-   `city` (varchar 100, nullable)
-   `country` (varchar 100, default: Indonesia)
-   `total_books` (integer, default: 0)
-   `total_saved` (integer, default: 0)
-   `subscription_status` (varchar 20, default: inactive)
-   `created_at`, `updated_at`

## Access Points

### Navbar Dropdown

1. Klik avatar di pojok kanan atas
2. Pilih "My Profile"

### Sidebar Menu

1. Menu "My Profile" tersedia di sidebar setelah Dashboard

## Validation Rules

### Profile Update

-   name: required, string, max 255 characters
-   email: required, email, unique (except current user)
-   phone: optional, string, max 20 characters
-   bio: optional, string, max 1000 characters
-   address: optional, string, max 500 characters
-   city: optional, string, max 100 characters
-   country: optional, string, max 100 characters
-   avatar: optional, image (jpeg, png, jpg, gif), max 2MB

### Password Update

-   current_password: required, must match current password
-   password: required, confirmed, minimum 8 characters
-   password_confirmation: required, must match password

## Storage

Avatar disimpan di:

```
storage/app/public/avatars/
```

Diakses melalui:

```
public/storage/avatars/
```

## Features

### Avatar Upload

1. Klik "Upload new photo"
2. Pilih gambar (JPG, PNG, GIF - max 2MB)
3. Preview otomatis muncul
4. Klik "Save changes" untuk menyimpan
5. Avatar lama akan otomatis terhapus

### Reset Avatar

Tombol "Reset" akan mengembalikan preview ke avatar saat ini tanpa menghapus file.

## Success Messages

-   "Profile updated successfully!" - Ketika profile berhasil diupdate
-   "Password updated successfully!" - Ketika password berhasil diubah

## Error Handling

-   Validasi otomatis untuk semua field
-   Error message ditampilkan di bawah field yang bermasalah
-   Avatar yang terlalu besar akan ditolak
-   Current password yang salah akan ditolak
-   Email yang sudah digunakan user lain akan ditolak
