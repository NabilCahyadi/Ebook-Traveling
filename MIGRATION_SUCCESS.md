# Migrasi Database Ebook Traveling - Berhasil! ✅

## Status Migrasi

✅ Semua migrasi berhasil dijalankan pada: 17 November 2025

## Tabel yang Dibuat

### Tabel Utama (15 tabel custom + 8 tabel Laravel default)

#### 1. **roles** - Peran pengguna

-   Menyimpan role seperti admin, user, editor, dll
-   Direlasikan dengan users

#### 2. **role_permissions** - Hak akses role

-   Menyimpan permission untuk setiap role
-   Foreign key ke `roles`

#### 3. **users** - Pengguna (Extended)

-   Tabel user Laravel yang sudah ditambahkan field:
    -   `google_id` - untuk Google OAuth
    -   `phone` - nomor telepon
    -   `avatar` - foto profil
    -   `status` - status user (active/inactive/suspended)
    -   `role_id` - relasi ke roles
    -   `language_pref` - preferensi bahasa

#### 4. **ebook_categories** - Kategori ebook

-   Kategori untuk mengorganisir ebook
-   Memiliki slug untuk SEO-friendly URL

#### 5. **cities** - Kota

-   Daftar kota untuk ebook traveling
-   Menyimpan nama kota dan negara

#### 6. **ebooks** - Ebook utama

-   Data ebook dengan relasi ke:
    -   `category_id` → ebook_categories
    -   `city_id` → cities
-   Fields: title, slug, description, cover_image, file_url, preview_content, is_active

#### 7. **ebook_sections** - Bab/section ebook

-   Bagian-bagian dari ebook
-   Diurutkan dengan `order_number`
-   Foreign key ke `ebooks`

#### 8. **ratings** - Rating & review ebook

-   User bisa memberikan rating dan review untuk ebook
-   Unique constraint: satu user hanya bisa rating sekali per ebook
-   Foreign keys: `user_id`, `ebook_id`

#### 9. **user_ebook_access** - Akses user ke ebook

-   Tracking akses user ke ebook
-   Source: subscription, purchase, atau free
-   Ada expire_at untuk akses berbatas waktu

#### 10. **subscription_plans** - Paket langganan

-   Rencana subscription dengan harga dan durasi
-   Fields: name, price, duration_day

#### 11. **subscriptions** - Langganan user

-   Subscription aktif user
-   Status: active, expired, cancelled
-   Foreign keys: `user_id`, `plan_id`

#### 12. **payments** - Pembayaran

-   Record pembayaran user
-   Status: pending, completed, failed
-   Terhubung dengan subscription dan user

#### 13. **blog_categories** - Kategori blog

-   Kategori untuk blog posts
-   Slug untuk URL yang SEO-friendly

#### 14. **blogs** - Blog posts

-   Artikel blog dengan relasi ke:
    -   `category_id` → blog_categories
    -   `author_id` → users
-   Fields lengkap untuk content management

#### 15. **user_logs** - Log aktivitas user

-   Tracking semua aktivitas user
-   Menyimpan: action, description, ip_address, user_agent

## Cara Penggunaan

### Rollback Migrations

Jika perlu rollback semua migrasi:

```bash
php artisan migrate:rollback
```

### Rollback dan Migrate Ulang

```bash
php artisan migrate:refresh
```

### Rollback dan Migrate dengan Seeder

```bash
php artisan migrate:refresh --seed
```

### Melihat Status Migrasi

```bash
php artisan migrate:status
```

## Relasi Database

### User Relations

-   User → Role (Many to One)
-   User → Ratings (One to Many)
-   User → User Ebook Access (One to Many)
-   User → Subscriptions (One to Many)
-   User → Payments (One to Many)
-   User → Blogs as Author (One to Many)
-   User → User Logs (One to Many)

### Ebook Relations

-   Ebook → Category (Many to One)
-   Ebook → City (Many to One)
-   Ebook → Sections (One to Many)
-   Ebook → Ratings (One to Many)
-   Ebook → User Access (One to Many)

### Subscription Relations

-   Subscription → User (Many to One)
-   Subscription → Plan (Many to One)
-   Subscription → Payments (One to Many)

### Blog Relations

-   Blog → Category (Many to One)
-   Blog → Author/User (Many to One)

## Next Steps

1. **Buat Model Eloquent** untuk setiap tabel
2. **Buat Seeder** untuk data dummy
3. **Buat Factory** untuk testing
4. **Buat Controller** untuk business logic
5. **Setup Authentication** dengan Sanctum/Passport
6. **Implementasi Authorization** dengan Policies/Gates

## File Migrations

Semua file migration tersimpan di:
`database/migrations/`

## Database Configuration

-   Database: MySQL
-   Database Name: ebook_traveling
-   Connection: mysql
-   Host: 127.0.0.1
-   Port: 3306
-   Username: root

## Catatan Penting

⚠️ Tabel `admin` sengaja diabaikan sesuai permintaan karena salah di desain.
✅ Semua foreign keys sudah dikonfigurasi dengan cascade delete yang tepat.
✅ Unique constraints sudah diterapkan untuk mencegah duplikasi data.
