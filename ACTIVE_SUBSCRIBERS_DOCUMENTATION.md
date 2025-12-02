# Active Subscribers Feature - Repository-Service Pattern

## Overview
Fitur Active Subscribers menggunakan **Repository-Service Pattern** untuk memisahkan business logic dari data access layer.

## Architecture

### 1. **Repository Layer** (`app/Repositories`)
Bertanggung jawab untuk akses data dan query database.

**Interface**: `SubscriberRepositoryInterface.php`
```php
public function getFilteredSubscribers(array $filters, int $perPage = 15): LengthAwarePaginator;
```

**Implementation**: `SubscriberRepository.php`
- Menghandle semua query database untuk subscribers
- Filtering berdasarkan: role, subscription plan, date range, search
- Menggunakan Eloquent relationships (user.roles, plan)

### 2. **Service Layer** (`app/Services`)
Bertanggung jawab untuk business logic dan orchestration.

**Service**: `SubscriberService.php`
- Menggunakan dependency injection untuk repositories
- Menyediakan method untuk:
  - `getFilteredSubscribers()` - Get subscribers dengan filter
  - `getAllRoles()` - Get semua roles untuk dropdown filter
  - `getAllSubscriptionPlans()` - Get semua subscription plans untuk dropdown filter

### 3. **Controller Layer** (`app/Http/Controllers/Admin`)
Bertanggung jawab untuk HTTP request/response handling.

**Controller**: `SubscriberController.php`
- Thin controller yang hanya menghandle request dan response
- Semua business logic di-delegate ke Service layer
- Menggunakan dependency injection untuk SubscriberService

### 4. **View Layer** (`resources/views/admin/subscribers`)
Template Blade untuk UI.

**View**: `index.blade.php`
- Menggunakan Vuexy template styling
- Filter form dengan: search, role, subscription plan, date range
- Table dengan pagination
- Action buttons untuk setiap subscriber

## Dependency Injection

Semua dependencies di-register di `RepositoryServiceProvider.php`:

```php
$this->app->bind(SubscriberRepositoryInterface::class, SubscriberRepository::class);
```

## Benefits

1. **Separation of Concerns**: Setiap layer memiliki tanggung jawab yang jelas
2. **Testability**: Mudah untuk unit testing dengan mock repositories
3. **Maintainability**: Perubahan di satu layer tidak affect layer lain
4. **Reusability**: Repository dan Service bisa digunakan di controller lain
5. **SOLID Principles**: Mengikuti Dependency Inversion Principle

## Routes

```php
Route::get('active-subscribers', [SubscriberController::class, 'index'])
    ->name('active-subscribers.index');
```

## Navigation

Menu item ditambahkan di sidebar (`layouts/partials/admin/sidebar.blade.php`):
- Icon: `ti-users-group`
- Label: "Active Subscribers"
- Location: Under "Subscription Management" section

## Features

1. **Advanced Filtering**:
   - Search by name or email
   - Filter by user role
   - Filter by subscription plan
   - Filter by date range (start date)

2. **Data Display**:
   - User information with avatar
   - Email verification status
   - User roles
   - Subscription plan details
   - Subscription status (active/pending/expired)
   - Start and end dates
   - Total amount
   - Action dropdown menu

3. **Actions**:
   - View user details
   - View subscription details
   - Extend subscription (for active subscriptions)

## Database Relations

```
Subscription
├── belongsTo: User
│   └── belongsToMany: Roles
└── belongsTo: SubscriptionPlan
```
