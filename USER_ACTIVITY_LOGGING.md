# User Activity Logging

Dokumentasi sistem logging aktivitas user (non-admin) di aplikasi E-book Traveling.

## Status Implementasi

✅ **SUDAH DIIMPLEMENTASIKAN**

Sistem Activity Logging sekarang mencatat aktivitas **SEMUA USER** (admin, creator, dan customer), bukan hanya admin.

## Aktivitas yang Dicatat

### 1. Authentication Activities (Sudah Ada Sebelumnya)
- **Login** - Saat user login ke sistem
- **Logout** - Saat user logout dari sistem

📁 File: `app/Listeners/AuthActivityListener.php`

### 2. Rating & Review Activities (✅ Baru Ditambahkan)
- **create** - User membuat rating/review baru untuk ebook
- **update** - User mengupdate rating/review yang sudah ada
- **delete** - User menghapus rating/review

📁 File: `app/Observers/RatingObserver.php`

**Data yang dicatat:**
- ID ebook yang di-rating
- Judul ebook
- Nilai rating (1-5)
- Ada/tidaknya review text
- Perubahan data (untuk update)

### 3. Order Activities (✅ Baru Ditambahkan)
- **create** - User membuat order baru
- **paid_order** - Order berhasil dibayar
- **complete_order** - Order selesai/completed
- **cancel_order** - Order dibatalkan
- **update** - Perubahan lainnya pada order
- **delete** - Order dihapus

📁 File: `app/Observers/OrderObserver.php`

**Data yang dicatat:**
- Nomor order
- Total amount
- Status order
- Metode pembayaran
- Perubahan yang terjadi

### 4. Subscription Activities (✅ Baru Ditambahkan)
- **create** - User membuat subscription baru
- **activate_subscription** - Subscription diaktifkan
- **cancel_subscription** - Subscription dibatalkan
- **expire_subscription** - Subscription expired
- **update** - Perubahan lainnya pada subscription
- **delete** - Subscription dihapus

📁 File: `app/Observers/SubscriptionObserver.php`

**Data yang dicatat:**
- ID subscription plan
- Nama plan
- Status subscription
- Tanggal mulai dan berakhir
- Perubahan yang terjadi

### 5. Ebook View/Read Activities (✅ Baru Ditambahkan)
- **view** - User membuka dan membaca ebook

📁 File: `app/Http/Controllers/User/EbookReaderController.php`

**Data yang dicatat:**
- ID ebook
- Judul ebook
- Slug ebook
- Tipe konten (PDF atau text)

### 6. Ebook CRUD Activities (Sudah Ada Sebelumnya)
Mencatat aktivitas creator ketika mengelola ebook mereka:
- **create** - Creator membuat ebook baru
- **update** - Creator mengupdate ebook
- **delete** - Creator menghapus ebook (soft delete)
- **restore** - Creator restore ebook yang dihapus
- **force_delete** - Ebook dihapus permanen

📁 File: `app/Observers/EbookObserver.php`

### 7. User Management Activities (Sudah Ada Sebelumnya)
- **create** - User baru dibuat
- **update** - Data user diupdate
- **delete** - User dihapus
- **restore** - User dipulihkan
- **force_delete** - User dihapus permanen

📁 File: `app/Observers/UserObserver.php`

## Data yang Disimpan di ActionLog

Setiap aktivitas mencatat informasi berikut:

| Field | Deskripsi |
|-------|-----------|
| `user_id` | ID user yang melakukan aktivitas |
| `action_type` | Jenis aktivitas (create, update, delete, login, view, dll) |
| `table_name` | Nama tabel yang terkait |
| `record_id` | ID record yang terkait |
| `ip_address` | IP address user |
| `user_agent` | Browser/device user |
| `url` | URL yang diakses |
| `method` | HTTP method (GET, POST, PUT, DELETE) |
| `new_values` | Data tambahan dalam format JSON |
| `created_at` | Timestamp aktivitas |

## Melihat Activity Logs

### Admin Panel
Admin dapat melihat semua activity logs melalui:
- **URL**: `/admin/user-activity-logs`
- **Menu**: Admin Dashboard → User Management → Activity Logs

### Filter yang Tersedia
- Filter berdasarkan user
- Filter berdasarkan jenis aktivitas
- Filter berdasarkan rentang tanggal
- Search berdasarkan nama user, email, table, atau URL
- Export ke CSV

## Konfigurasi di AppServiceProvider

Semua observer didaftarkan di `app/Providers/AppServiceProvider.php`:

```php
public function boot(): void
{
    // Register all observers
    Rating::observe(RatingObserver::class);
    Ebook::observe(EbookObserver::class);
    User::observe(UserObserver::class);
    Order::observe(OrderObserver::class);
    Subscription::observe(SubscriptionObserver::class);
    // ... dan lainnya
}
```

## Keamanan & Privacy

- Activity logs hanya dapat diakses oleh admin
- Tidak menyimpan data sensitif seperti password
- Data disimpan dengan UUID untuk keamanan
- IP address dan user agent dicatat untuk audit trail

## Maintenance

### Membersihkan Log Lama
Untuk performa optimal, pertimbangkan untuk menghapus log lama secara berkala:

```bash
# Contoh: Hapus log lebih dari 6 bulan
DELETE FROM action_logs WHERE created_at < DATE_SUB(NOW(), INTERVAL 6 MONTH);
```

Atau buat scheduled task di `app/Console/Kernel.php`:

```php
$schedule->command('activitylog:clean')->monthly();
```

## Troubleshooting

### Log tidak muncul
1. Pastikan observer sudah terdaftar di AppServiceProvider
2. Clear cache: `php artisan optimize:clear`
3. Cek apakah user sudah login (Auth::check())
4. Cek database apakah tabel action_logs ada

### Performance Issues
Jika tabel action_logs terlalu besar:
1. Tambahkan index pada kolom yang sering di-query
2. Archieve atau delete log lama
3. Pertimbangkan menggunakan queue untuk logging

## Update History

- **22 Dec 2025**: Menambahkan logging untuk Rating, Order, Subscription, dan Ebook View activities
- **Sebelumnya**: Logging untuk Authentication, Ebook CRUD, User Management sudah ada
