# Admin Landing Page Content Management

Dokumentasi untuk mengelola content di halaman landing page/homepage.

## Fitur yang Tersedia

### 1. Landing Page Sections Manager
**Path:** `/admin/landing-sections`

Halaman ini menampilkan semua section yang ada di landing page dengan fitur:
- ✅ Toggle visibility (Show/Hide section)
- ✅ Quick link ke halaman manage content untuk setiap section
- ℹ️ **Urutan section fixed/tetap** (tidak bisa diubah)

**Section yang tersedia (Urutan Fixed):**
1. **Hero Banner** - Slider banner di bagian atas homepage
2. **Top Cities** - Daftar 10 kota populer
3. **Collections** - Koleksi ebook berdasarkan tema
4. **Subscription Plans** - Paket berlangganan
5. **Latest Blogs** - Blog terbaru

> **Note:** Urutan section sudah diatur di sistem. Yang bisa diatur admin adalah **visibility** dan **isi content** dari masing-masing section.

### 2. Hero Banner Management
**Path:** `/admin/banners`

Kelola banner yang tampil di slider homepage dengan fitur lengkap:

#### Fitur Banner:
- ✅ **CRUD Operations** - Create, Read, Update, Delete banner
- ✅ **Image Upload** - Upload banner image (Recommended: 1920x600px)
- ✅ **Drag & Drop Order** - Atur urutan tampilan banner di slider
- ✅ **Toggle Active/Inactive** - Aktifkan/nonaktifkan banner tanpa menghapus
- ✅ **Schedule Display** - Set tanggal mulai dan berakhir
- ✅ **Link URL** - Tambahkan link tujuan ketika banner diklik
- ✅ **Banner Types** - Hero, Promo, Announcement

> **Note:** Urutan banner **bisa diatur** dengan drag & drop. Ini berbeda dengan urutan section yang fixed.

#### Spesifikasi Image:
- **Format:** JPEG, PNG, WebP
- **Ukuran maksimal:** 2MB
- **Dimensi recommended:** 1920x600px (landscape)
- **Contoh:** `public/images/slider-1.webp`, `slider-2.webp`

#### Cara Menambah Banner:
1. Buka `/admin/banners`
2. Klik tombol **"Add New Banner"**
3. Isi form:
   - **Title**: Judul banner
   - **Description**: Deskripsi singkat (optional)
   - **Banner Image**: Upload foto (wajib, max 2MB)
   - **Target URL**: Link tujuan (optional)
   - **Type**: Pilih tipe banner
   - **Order**: Urutan tampilan (0 = pertama)
   - **Start/End Date**: Jadwal tampil (optional)
   - **Active**: Centang untuk langsung aktif
4. Klik **"Create Banner"**

### 3. Top 10 Cities Management
**Path:** `/admin/cities`

Kelola daftar kota/destinasi yang ditampilkan di homepage:
- Edit informasi kota (nama, deskripsi, gambar)
- Toggle visibility
- Atur urutan tampilan
- Menambah/menghapus kota

### 4. Latest Blogs Management
**Path:** `/admin/blogs`

Kelola blog yang ditampilkan di homepage:
- Buat blog baru
- Edit/hapus blog
- Publish/unpublish
- Blog terbaru otomatis muncul di homepage

### 5. Collections Management
**Path:** `/admin/collections`

Kelola koleksi ebook bertema:
- Buat koleksi baru (misal: "Beach Destinations", "Mountain Getaways")
- Tambah/hapus ebook ke koleksi
- Atur urutan ebook dalam koleksi
- Toggle visibility di landing page

## Quick Access

### Dari Landing Sections Page:
Setiap section memiliki button **"Manage Content"** yang langsung mengarah ke halaman pengelolaan content section tersebut.

### Menu Navigasi Admin:
```
Website Management
├── Landing Page Sections  → Overview semua section
├── Hero Banners          → Kelola banner slider
└── Collection Ebook      → Kelola koleksi ebook
```

## Running Seeders

Untuk populate data awal:

```bash
# Seed semua data landing page
php artisan db:seed --class=LandingPageSectionsSeeder

# Seed banner examples
php artisan db:seed --class=BannerSeeder
```

## Tips & Best Practices

### Banner Images:
1. Gunakan format WebP untuk file size lebih kecil
2. Compress image sebelum upload
3. Test tampilan di mobile dan desktop
4. Gunakan text overlay yang readable
5. Simpan file di `storage/app/public/banners/`

### Content Organization:
1. Maximum 3-5 banner aktif untuk loading speed optimal
2. Atur schedule untuk banner seasonal/promo
3. Test visibility setiap section sebelum publish
4. Update content secara berkala

### Performance:
1. Banner akan otomatis di-cache
2. Inactive banner tidak dimuat di frontend
3. Images di-serve dari storage dengan symlink

## Storage Setup

Pastikan storage symlink sudah dibuat:

```bash
php artisan storage:link
```

Banner images akan disimpan di:
- **Storage path:** `storage/app/public/banners/`
- **Public path:** `public/storage/banners/`
- **URL:** `https://domain.com/storage/banners/filename.webp`

## Troubleshooting

### Banner tidak muncul di homepage:
- ✅ Cek apakah banner `is_active = true`
- ✅ Cek schedule start_date dan end_date
- ✅ Cek section "Hero Banner" di Landing Sections adalah visible
- ✅ Clear cache: `php artisan cache:clear`

### Image tidak tampil:
- ✅ Pastikan storage link sudah dibuat
- ✅ Cek permissions folder storage
- ✅ Cek path image di database

### Drag & drop tidak bekerja:
- ✅ Pastikan JavaScript library SortableJS ter-load
- ✅ Clear browser cache
- ✅ Cek console browser untuk error

## Support

Jika ada pertanyaan atau issue, hubungi tim development.
