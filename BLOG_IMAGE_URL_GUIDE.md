# Blog Image URL Support Guide

## Overview
Model Blog sekarang mendukung 2 jenis URL untuk `featured_image`:
1. **External URL** - URL lengkap dari sumber eksternal (e.g., https://example.com/image.jpg)
2. **Local Storage** - Path relatif dari storage Laravel (e.g., blogs/image.jpg)

## Cara Kerja

### 1. Model Blog (app/Models/Blog.php)
Model Blog memiliki accessor `featured_image_url` yang otomatis mendeteksi jenis URL:

```php
public function getFeaturedImageUrlAttribute()
{
    if (empty($this->featured_image)) {
        return asset('images/no-blog-image.png');
    }

    // Cek apakah URL eksternal
    if (filter_var($this->featured_image, FILTER_VALIDATE_URL)) {
        return $this->featured_image;
    }

    if (\Illuminate\Support\Str::startsWith($this->featured_image, ['http://', 'https://'])) {
        return $this->featured_image;
    }

    // Jika bukan URL eksternal, anggap sebagai local storage
    return asset('storage/' . $this->featured_image);
}
```

### 2. Cara Penyimpanan

#### External URL
Simpan langsung URL lengkap ke kolom `featured_image`:
```php
$blog->featured_image = 'https://example.com/images/blog-image.jpg';
$blog->save();
```

#### Local Storage
Simpan path relatif dari storage/app/public:
```php
// Upload file
$path = $request->file('featured_image')->store('blogs', 'public');
$blog->featured_image = $path; // Contoh: blogs/abc123.jpg
$blog->save();
```

### 3. Cara Menampilkan di View

Gunakan accessor `featured_image_url` untuk menampilkan gambar:

```blade
<!-- Sederhana -->
<img src="{{ $blog->featured_image_url }}" alt="{{ $blog->title }}">

<!-- Dengan fallback manual (optional) -->
<img src="{{ $blog->featured_image_url ?? asset('images/default.png') }}" alt="{{ $blog->title }}">
```

### 4. View yang Sudah Diupdate

Semua view berikut sudah menggunakan accessor `featured_image_url`:
- `resources/views/blog-detail.blade.php` - Meta tags, JSON-LD schema, dan gambar content
- `resources/views/index.blade.php` - Blog cards di homepage
- `resources/views/blogs.blade.php` - Blog listing page
- `resources/views/blogs-index.blade.php` - Blog index page
- `resources/views/admin/blogs/edit.blade.php` - Preview di admin edit page

## Contoh Penggunaan

### Contoh 1: Upload dari Form (Local Storage)
```php
public function store(Request $request)
{
    $blog = new Blog();
    
    if ($request->hasFile('featured_image')) {
        $path = $request->file('featured_image')->store('blogs', 'public');
        $blog->featured_image = $path;
    }
    
    $blog->save();
}
```

### Contoh 2: Menggunakan URL Eksternal
```php
public function store(Request $request)
{
    $blog = new Blog();
    $blog->featured_image = $request->input('external_image_url');
    $blog->save();
}
```

### Contoh 3: Opsi Upload atau URL Eksternal
```php
public function store(Request $request)
{
    $blog = new Blog();
    
    // Prioritaskan file upload
    if ($request->hasFile('featured_image')) {
        $path = $request->file('featured_image')->store('blogs', 'public');
        $blog->featured_image = $path;
    } 
    // Jika tidak ada file, cek URL eksternal
    elseif ($request->filled('external_image_url')) {
        $blog->featured_image = $request->input('external_image_url');
    }
    
    $blog->save();
}
```

## Benefits

✅ **Fleksibel** - Support dua jenis sumber gambar dalam satu field
✅ **Clean Code** - View lebih simple dengan menggunakan accessor
✅ **Konsisten** - Semua view menggunakan cara yang sama
✅ **Backward Compatible** - Data lama tetap berfungsi
✅ **No Database Changes** - Tidak perlu migrasi baru

## Testing

### Test External URL
```php
$blog = Blog::create([
    'title' => 'Test Blog',
    'featured_image' => 'https://picsum.photos/800/600',
    // ... other fields
]);

echo $blog->featured_image_url; // Output: https://picsum.photos/800/600
```

### Test Local Storage
```php
$blog = Blog::create([
    'title' => 'Test Blog',
    'featured_image' => 'blogs/test-image.jpg',
    // ... other fields
]);

echo $blog->featured_image_url; // Output: http://localhost/storage/blogs/test-image.jpg
```

### Test Empty Image
```php
$blog = Blog::create([
    'title' => 'Test Blog',
    'featured_image' => null,
    // ... other fields
]);

echo $blog->featured_image_url; // Output: http://localhost/images/no-blog-image.png
```
