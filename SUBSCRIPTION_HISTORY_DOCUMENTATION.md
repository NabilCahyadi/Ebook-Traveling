# Subscription History Documentation

## Overview

Halaman **Subscription History** adalah fitur admin untuk melihat riwayat lengkap semua transaksi subscription, baik yang dibuat secara manual oleh admin maupun melalui payment gateway.

## Features

### 1. Statistics Dashboard

-   **Total Subscriptions**: Total semua subscription dalam sistem
-   **Manual**: Jumlah subscription yang dibuat manual oleh admin
-   **Payment Gateway**: Jumlah subscription melalui payment gateway
-   **Total Revenue**: Total pendapatan dari semua subscription

### 2. Advanced Filtering

-   **Search**: Cari berdasarkan nama user, email, atau subscription code
-   **Type Filter**: Filter berdasarkan tipe (Manual / Payment Gateway)
-   **Status Filter**: Filter berdasarkan status (Active, Cancelled, Expired)
-   **Date Range**: Filter berdasarkan tanggal start_date

### 3. Subscription List Table

Menampilkan informasi lengkap untuk setiap subscription:

-   Subscription Code
-   User Information (name & email)
-   Plan Name
-   **Type Badge**:
    -   🟡 Payment Gateway (dengan icon credit card)
    -   ⚪ Manual (dengan icon hand click)
-   Start Date & End Date
-   Status Badge (Active, Expired, Cancelled)
-   Amount
-   Actions (View Details)

### 4. Detail Page

Halaman detail menampilkan:

-   **Subscription Information**
    -   Code, Status, Auto Renew
    -   Plan details
    -   Dates & timestamps
-   **Payment Information** (jika ada)
    -   Transaction ID
    -   Payment Method
    -   Payment Status
    -   Paid At
    -   Payment Details (JSON)
-   **User Information**
    -   Avatar & Name
    -   Email & Phone
    -   User Since
    -   Total Subscriptions
    -   Link to User Profile

## Routes

```php
// List semua subscription history dengan filter
GET /admin/subscription-history

// Detail subscription
GET /admin/subscription-history/{id}

// Export data (coming soon)
GET /admin/subscription-history-export
```

## Database Structure

### Migration: add_payment_id_to_subscriptions_table

Menambahkan kolom `payment_id` ke tabel `subscriptions`:

-   `payment_id` (UUID, nullable)
-   Foreign key ke tabel `payments`
-   Indexed untuk performa query

### Relationship

-   Subscription **belongsTo** Payment
-   Jika `payment_id` NULL = Manual Subscription
-   Jika `payment_id` NOT NULL = Payment Gateway Subscription

## Controller Methods

### SubscriptionHistoryController

**index(Request $request)**

-   Menampilkan list subscription dengan pagination
-   Support filtering (type, status, search, date range)
-   Menghitung statistics

**show($id)**

-   Menampilkan detail subscription lengkap
-   Eager load user, plan, dan payment

**export(Request $request)**

-   Feature untuk export data (placeholder untuk pengembangan future)

## Usage Examples

### Filter Manual Subscriptions Only

```
/admin/subscription-history?type=manual
```

### Filter Payment Gateway Only

```
/admin/subscription-history?type=payment_gateway
```

### Search User

```
/admin/subscription-history?search=john@example.com
```

### Filter by Status

```
/admin/subscription-history?status=active
```

### Combined Filters

```
/admin/subscription-history?type=payment_gateway&status=active&start_date=2025-01-01
```

## Navigation

Menu sidebar sudah diupdate dengan item:

-   Icon: History (ti-history)
-   Label: "Subscription History"
-   Location: Subscription Management section

## UI/UX Features

-   Responsive design
-   Bootstrap 5 components
-   Tabler Icons
-   Tooltips on action buttons
-   Pagination with page info
-   Empty state messages
-   Color-coded badges for status dan type

## Future Enhancements

1. Export to CSV/Excel
2. Advanced analytics & charts
3. Bulk actions
4. Email notifications
5. Revenue reports by period
6. Subscription renewal predictions

## Notes

-   Semua subscription yang sudah ada sebelum migration akan memiliki `payment_id = NULL` (dianggap Manual)
-   Untuk subscription baru melalui payment gateway, pastikan `payment_id` diisi saat create subscription
-   Status "Expired" ditampilkan otomatis jika subscription masih "active" tapi `end_date` sudah lewat

---

Created: December 2, 2025
Version: 1.0.0
