# Landing Page Content Curation

## Deskripsi
Fitur ini memungkinkan admin untuk **mengkurasi konten** yang ditampilkan di section fixed landing page:
- **Top 10 Cities**: Pilih dan atur urutan kota yang ditampilkan (tidak otomatis)
- **Latest Blogs**: Pilih dan atur urutan blog yang ditampilkan (tidak otomatis)

Section fixed ini tetap ada di landing page, tapi kontennya bisa diatur oleh admin.

## Struktur File

### Backend

#### Controller
- **File**: `app/Http/Controllers/Admin/LandingPageContentController.php`
- **Methods**:
  - `index()` - Dashboard content management
  - `editTopCities()` - Form edit Top 10 Cities
  - `updateTopCities()` - Update Top 10 Cities content
  - `editLatestBlogs()` - Form edit Latest Blogs
  - `updateLatestBlogs()` - Update Latest Blogs content

#### Services
- **CityService**: `app/Services/CityService.php`
  - `getAllActiveCities()` - Get all cities for selection
  - `getCuratedCities($cityIds)` - Get cities by IDs in order

- **BlogService**: `app/Services/BlogService.php`
  - `getAllPublishedBlogs()` - Get all published blogs for selection
  - `getCuratedBlogs($blogIds, $limit)` - Get blogs by IDs in order

#### HomeController
- **File**: `app/Http/Controllers/HomeController.php`
- Updated to check for curated content first, fallback to automatic if not set

### Frontend (Views)

#### Admin Views
- **Dashboard**: `resources/views/admin/landing-page-content/index.blade.php`
  - Overview content management
  - Statistics per section
  - Quick access buttons

- **Top Cities**: `resources/views/admin/landing-page-content/top-cities.blade.php`
  - Drag & drop untuk reorder cities
  - Select cities from list
  - Max 10 cities
  - Toggle visibility

- **Latest Blogs**: `resources/views/admin/landing-page-content/latest-blogs.blade.php`
  - Drag & drop untuk reorder blogs
  - Select blogs from list
  - Set display count (1-12)
  - Toggle visibility

### Routes
File: `routes/modules/admin.php`

```php
Route::prefix('landing-page-content')->name('landing-page-content.')->group(function () {
    Route::get('/', [LandingPageContentController::class, 'index'])->name('index');
    Route::get('/top-cities', [LandingPageContentController::class, 'editTopCities'])->name('top-cities');
    Route::put('/top-cities', [LandingPageContentController::class, 'updateTopCities'])->name('top-cities.update');
    Route::get('/latest-blogs', [LandingPageContentController::class, 'editLatestBlogs'])->name('latest-blogs');
    Route::put('/latest-blogs', [LandingPageContentController::class, 'updateLatestBlogs'])->name('latest-blogs.update');
});
```

### Database Storage
Data disimpan di tabel `landing_page_sections` dengan struktur:

```php
[
    'section_type' => 'top_cities' | 'latest_blogs',
    'section_name' => 'Top 10 Cities' | 'Latest Blogs',
    'order' => integer,
    'is_visible' => boolean,
    'config' => [
        // For Top Cities:
        'selected_cities' => [uuid1, uuid2, ...] // Array of city IDs in order
        
        // For Latest Blogs:
        'selected_blogs' => [uuid1, uuid2, ...], // Array of blog IDs in order
        'display_count' => 4 // Number of blogs to display
    ]
]
```

## Cara Menggunakan

### 1. Akses Dashboard Content Management
- Login sebagai admin
- Navigasi ke: **Website Management** > **Landing Page Content**
- URL: `/admin/landing-page-content`
- Lihat overview dan statistik per section

### 2. Kelola Top 10 Cities

#### A. Akses Halaman
- Dari dashboard, klik tombol **"Kelola Konten"** pada card Top 10 Cities
- Atau URL langsung: `/admin/landing-page-content/top-cities`

#### B. Pilih Kota
1. Lihat daftar kota di panel kanan "Daftar Kota"
2. Gunakan search box untuk mencari kota tertentu
3. Klik pada kota yang ingin ditambahkan
4. Kota akan muncul di panel kiri "Kota Terpilih"
5. Maksimal 10 kota dapat dipilih

#### C. Atur Urutan
1. Drag & drop icon grip (☰) untuk mengatur urutan
2. Kota paling atas akan ditampilkan pertama di landing page

#### D. Hapus Kota
- Klik tombol ❌ pada kota yang ingin dihapus
- Kota akan kembali ke daftar kota yang tersedia

#### E. Toggle Visibility
- Aktifkan switch "Tampilkan di Landing Page" untuk menampilkan section
- Nonaktifkan jika ingin menyembunyikan section sementara

#### F. Simpan
- Klik tombol **"Simpan Perubahan"**
- Perubahan akan langsung terlihat di landing page

### 3. Kelola Latest Blogs

#### A. Akses Halaman
- Dari dashboard, klik tombol **"Kelola Konten"** pada card Latest Blogs
- Atau URL langsung: `/admin/landing-page-content/latest-blogs`

#### B. Pilih Blog
1. Lihat daftar blog published di panel kanan "Daftar Blog Published"
2. Gunakan search box untuk mencari blog tertentu
3. Klik pada blog yang ingin ditambahkan
4. Blog akan muncul di panel kiri "Blog Terpilih"
5. Tidak ada batasan jumlah blog yang dipilih

#### C. Set Jumlah Tampilan
1. Di bagian header panel kiri, set "Jumlah Blog yang Ditampilkan"
2. Range: 1-12 blog
3. Hanya sejumlah blog sesuai setting yang akan tampil di landing page
4. Urutan ditentukan dari drag & drop

#### D. Atur Urutan
1. Drag & drop icon grip (☰) untuk mengatur urutan
2. Blog paling atas akan ditampilkan pertama di landing page

#### E. Hapus Blog
- Klik tombol ❌ pada blog yang ingin dihapus
- Blog akan kembali ke daftar blog yang tersedia

#### F. Toggle Visibility
- Aktifkan switch "Tampilkan di Landing Page" untuk menampilkan section
- Nonaktifkan jika ingin menyembunyikan section sementara

#### G. Simpan
- Klik tombol **"Simpan Perubahan"**
- Perubahan akan langsung terlihat di landing page

## Fitur-Fitur

### Drag & Drop Interface
- **Library**: SortableJS 1.15.0
- **Fitur**: Smooth animation, touch support untuk mobile
- **Handle**: Icon grip (☰) untuk grab
- **Visual Feedback**: Ghost element saat dragging

### Search Functionality
- Real-time search untuk filter cities/blogs
- Case-insensitive
- Search by name untuk cities, title untuk blogs
- Hide/show hasil secara dinamis

### Validasi
- **Top Cities**: Minimal 1 kota, maksimal 10 kota
- **Latest Blogs**: Minimal 1 blog, display count 1-12
- Form validation di client-side dan server-side
- Error messages dalam Bahasa Indonesia

### Automatic Fallback
Jika admin belum set content atau section dinonaktifkan:
- **Top Cities**: Otomatis tampilkan 10 kota populer berdasarkan views
- **Latest Blogs**: Otomatis tampilkan 4 blog terbaru berdasarkan published date

## Logic Flow

### Top 10 Cities
```
Landing Page Load
    ↓
Check landing_page_sections table
    ↓
[Has curated content + is_visible = true?]
    ├─ YES → Use getCuratedCities($cityIds)
    │         └─ Get cities by IDs in order
    │             └─ Display on landing page
    │
    └─ NO → Use getHomepageCities(10)
              └─ Get top 10 cities by popularity
                  └─ Display on landing page
```

### Latest Blogs
```
Landing Page Load
    ↓
Check landing_page_sections table
    ↓
[Has curated content + is_visible = true?]
    ├─ YES → Use getCuratedBlogs($blogIds, $displayCount)
    │         └─ Get blogs by IDs in order
    │             └─ Take $displayCount blogs
    │                 └─ Display on landing page
    │
    └─ NO → Use getLatestForHomepage(4)
              └─ Get 4 latest published blogs
                  └─ Display on landing page
```

## API Endpoints

### Dashboard
- **URL**: `GET /admin/landing-page-content`
- **Response**: Overview page dengan statistik

### Top Cities Management
- **Edit**: `GET /admin/landing-page-content/top-cities`
- **Update**: `PUT /admin/landing-page-content/top-cities`
- **Body**:
  ```json
  {
    "selected_cities": ["uuid1", "uuid2", ...],
    "is_visible": true
  }
  ```

### Latest Blogs Management
- **Edit**: `GET /admin/landing-page-content/latest-blogs`
- **Update**: `PUT /admin/landing-page-content/latest-blogs`
- **Body**:
  ```json
  {
    "selected_blogs": ["uuid1", "uuid2", ...],
    "display_count": 4,
    "is_visible": true
  }
  ```

## JavaScript Dependencies

### SortableJS
- **Version**: 1.15.0
- **CDN**: `https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js`
- **Usage**: Drag & drop untuk reorder items
- **Config**:
  ```javascript
  new Sortable(element, {
      animation: 150,
      handle: '.ti-grip-vertical',
      ghostClass: 'sortable-ghost'
  });
  ```

### jQuery
- **Already included** in admin template
- **Usage**: Event handling, AJAX, DOM manipulation

## Styling

### Custom CSS
```css
.sortable-ghost {
    opacity: 0.4;
}

.available-city-item:hover,
.available-blog-item:hover {
    background-color: #f8f9fa;
    border-color: #007bff !important;
}

.sortable-item {
    transition: all 0.3s ease;
}
```

## Perbedaan dengan Landing Page Section Management

| Fitur | Section Management | Content Curation |
|-------|-------------------|------------------|
| **Tujuan** | Manage section (CRUD) | Manage isi section |
| **Scope** | Semua section types | Hanya Top Cities & Latest Blogs |
| **Action** | Add/Edit/Delete section | Select & order content |
| **URL** | `/admin/landing-page-sections` | `/admin/landing-page-content` |
| **Use Case** | Setup awal landing page | Daily content management |

## Tips Penggunaan

1. **Top 10 Cities**:
   - Pilih kota dengan ebook terbanyak untuk user experience terbaik
   - Update berkala sesuai tren destinasi
   - Gunakan kota yang berbeda-beda untuk variasi

2. **Latest Blogs**:
   - Pilih blog dengan konten terbaik, tidak harus yang terbaru
   - Mix blog dengan kategori berbeda
   - Update minimal seminggu sekali
   - Gunakan display_count sesuai design landing page

3. **General**:
   - Jangan lupa klik "Simpan Perubahan"
   - Test di landing page setelah update
   - Gunakan visibility toggle untuk A/B testing
   - Monitor engagement untuk optimasi konten

## Troubleshooting

### Konten tidak muncul di landing page
1. Cek apakah section visibility di-set **true**
2. Pastikan minimal 1 item terpilih
3. Clear cache browser
4. Cek apakah kota/blog masih aktif/published

### Urutan tidak sesuai
1. Pastikan sudah drag & drop dengan benar
2. Klik "Simpan Perubahan"
3. Refresh landing page
4. Clear browser cache

### Blog tidak muncul meski sudah dipilih
1. Cek "Jumlah Blog yang Ditampilkan"
2. Pastikan lebih besar dari 0
3. Blog harus dalam status "published"
4. Cek urutan, blog di urutan lebih tinggi akan tampil

## Future Enhancements

Fitur yang bisa ditambahkan:
- Preview section sebelum publish
- Schedule content change
- Analytics per content (CTR, views)
- Bulk select/deselect
- Content recommendation based on performance
- Import/export configuration
- Content versioning & rollback
