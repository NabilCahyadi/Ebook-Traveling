# Update: Subscription Management

## Perubahan yang Dilakukan

### 1. **Manual Subscriptions - Langsung ke Create**

-   Halaman Manual Subscriptions (`/admin/manual-subscriptions`) sekarang langsung redirect ke form Create Manual Subscription
-   Method `index()` di `ManualSubscriptionController` sekarang redirect ke `create()`

### 2. **Subscription Management List - Halaman Baru**

-   Ditambahkan halaman baru untuk melihat daftar semua subscription dari user
-   Route: `/admin/subscription-management`
-   Menu sidebar baru: **Subscription List**

## File yang Diubah

### Controllers

-   `app/Http/Controllers/Admin/ManualSubscriptionController.php`
    -   Method `index()` sekarang redirect ke `create()`
    -   Ditambahkan method baru `subscriptionsList()` untuk menampilkan daftar subscriptions
    -   Semua redirect ke `manual-subscriptions.index` diganti ke `subscription-management.list`

### Routes

-   `routes/modules/admin.php`
    -   Ditambahkan route baru: `GET /admin/subscription-management` → `subscription-management.list`

### Views

-   **Baru**: `resources/views/admin/subscription-management/list.blade.php`
    -   Halaman untuk melihat daftar semua subscriptions
    -   Pagination 15 items per page
-   `resources/views/layouts/partials/admin/sidebar.blade.php`
    -   Ditambahkan menu baru "Subscription List" dengan icon `ti-list-details`
-   `resources/views/admin/manual-subscriptions/create.blade.php`
    -   Button Cancel sekarang mengarah ke `subscription-management.list`
-   `resources/views/admin/manual-subscriptions/show.blade.php`
    -   Button "Back to List" sekarang mengarah ke `subscription-management.list`

## Cara Menggunakan

### Menu Sidebar

1. **Manual Subscriptions** - Langsung ke form create subscription baru
2. **Subscription List** - Melihat semua subscriptions yang ada

### Fitur di Subscription List

-   Search user by name, email, atau subscription code
-   View details subscription
-   Extend subscription (jika active)
-   Cancel subscription (jika active)
-   Delete subscription

## Route Summary

| Route                                | Name                                 | Action                   |
| ------------------------------------ | ------------------------------------ | ------------------------ |
| `/admin/manual-subscriptions`        | `admin.manual-subscriptions.index`   | Redirect ke create form  |
| `/admin/manual-subscriptions/create` | `admin.manual-subscriptions.create`  | Form create subscription |
| `/admin/subscription-management`     | `admin.subscription-management.list` | List semua subscriptions |
