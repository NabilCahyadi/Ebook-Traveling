# User Role System

## Overview
Sistem role untuk user telah diubah untuk mendukung multiple roles per user dan memisahkan status subscription dari role.

## Perubahan Utama

### 1. User Type
Column `user_type` di tabel `users` sekarang **hanya** untuk membedakan status subscription:
- `free_user`: User yang belum berlangganan (gratis)
- `member`: User yang sudah berlangganan (paid)

### 2. User Roles
Role user sekarang disimpan di tabel terpisah menggunakan many-to-many relationship:
- Tabel: `roles`, `user_roles`
- User bisa memiliki **multiple roles**
- Role examples: `Member`, `Creator`, `Admin`, `Super Admin`

## Model Methods

### Checking Subscription Status
```php
// Check if user is paid member
$user->isMember(); // true if user_type = 'member'

// Check if user is free user
$user->isFreeUser(); // true if user_type = 'free_user'
```

### Checking Roles
```php
// Check if user has specific role
$user->hasRole('Creator');
$user->isCreator(); // Helper method

$user->hasRole('Admin');
$user->isAdmin(); // Helper method

$user->isSuperAdmin(); // Check super admin role

// Check if user has any of given roles
$user->hasAnyRole(['Admin', 'Creator']);
```

### Checking Permissions
```php
// Check specific permission
$user->hasPermission('ebook.create');

// Check any permission
$user->hasAnyPermission(['ebook.create', 'ebook.edit']);

// Check all permissions
$user->hasAllPermissions(['ebook.create', 'ebook.edit']);

// Check panel access
$user->canAccessPanel();
```

### Getting User Roles
```php
// Get all roles
$user->roles; // Collection of roles

// Get first role (backward compatibility)
$user->role(); // Single Role instance

// Get role names
$user->roles->pluck('name'); // ['Creator', 'Admin']
```

## Scopes

```php
// Query free users
User::freeUsers()->get();

// Query members (paid)
User::members()->get();

// Query users with creator role
User::creators()->get();

// Query users with admin role
User::admins()->get();
```

## Migration

Migration telah dijalankan untuk:
1. Mengubah nilai `user_type` yang lama:
   - `member`, `creator`, `admin` → menjadi `member`
   - `free_user` tetap `free_user`
2. Role sekarang disimpan di tabel `user_roles`

## Backward Compatibility

Method berikut masih berfungsi untuk backward compatibility:
- `$user->role()` - Returns first role
- `$user->isCreator()` - Checks creator role (not user_type)
- `$user->isAdmin()` - Checks admin role (not user_type)

## Best Practices

1. **Jangan gunakan** `user_type` untuk cek role/permission
2. **Gunakan** `user_type` hanya untuk cek subscription status
3. **Gunakan** role system untuk permission checks
4. **Assign multiple roles** jika user memiliki banyak fungsi

## Example Usage

```php
// User with multiple roles
$user->roles()->attach([
    Role::where('slug', 'creator')->first()->id,
    Role::where('slug', 'member')->first()->id,
]);

// Check capabilities
if ($user->isCreator()) {
    // Can create ebooks
}

if ($user->isMember()) {
    // Has paid subscription features
}

if ($user->hasPermission('ebook.publish')) {
    // Can publish ebooks
}
```
