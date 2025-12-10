# Storage Troubleshooting - Image Not Showing in Production

## Masalah
Foto cover ebook tidak muncul di production setelah deploy dan upload ebook baru.

## Penyebab Utama
1. **Symlink storage belum dibuat** - Laravel memerlukan symlink dari `public/storage` ke `storage/app/public`
2. **Permission folder storage** tidak sesuai
3. **URL storage tidak dikonfigurasi dengan benar**

## Solusi yang Sudah Diterapkan

### 1. Deploy Script (`deploy.sh`)
Deploy script sudah diupdate dengan perintah berikut:
```bash
# Create storage symlink
php artisan storage:link

# Set permissions
chmod -R 775 storage bootstrap/cache
chown -R $USER:$USER storage bootstrap/cache
```

### 2. Manual Fix di Server Production

Jika masih bermasalah, jalankan manual di server:

```bash
# SSH ke server
ssh u778058510@yourdomain.com

# Masuk ke folder project
cd /home/u778058510/domains/mappy.id/ebook_traveling_core

# Hapus symlink lama jika ada
rm -f public/storage

# Buat symlink baru
php artisan storage:link

# Set permission
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Pastikan ownership benar (sesuaikan dengan user hosting)
chown -R u778058510:u778058510 storage
chown -R u778058510:u778058510 bootstrap/cache

# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### 3. Cek di Server

Pastikan folder dan file ada:
```bash
# Cek apakah symlink sudah ada
ls -la public/storage

# Cek isi folder storage
ls -la storage/app/public/ebook_covers/

# Cek permission
ls -ld storage/app/public/
```

### 4. Cek File .env di Production

Pastikan `APP_URL` sesuai dengan domain production:
```env
APP_URL=https://yourdomain.com
```

## Cara Kerja Storage di Laravel

1. **Upload file**: Disimpan di `storage/app/public/ebook_covers/`
2. **Symlink**: `public/storage` → `storage/app/public/`
3. **URL akses**: `https://domain.com/storage/ebook_covers/filename.jpg`
4. **Di Blade**: `Storage::url($ebook->cover_image)` → `/storage/ebook_covers/filename.jpg`

## Testing

Setelah deploy, test dengan:
1. Upload ebook baru dengan cover image
2. Cek di database apakah `cover_image` terisi dengan path yang benar (e.g., `ebook_covers/filename.jpg`)
3. Akses langsung URL: `https://yourdomain.com/storage/ebook_covers/filename.jpg`
4. Jika URL langsung tidak bisa diakses, berarti symlink atau permission bermasalah

## Catatan Penting untuk Shared Hosting

Beberapa shared hosting (seperti Hostinger) memiliki struktur khusus:
- Kadang `public_html` adalah root public, bukan `public/`
- Symlink mungkin perlu dibuat manual via File Manager atau SSH
- Permission mungkin harus diset via cPanel File Manager

Jika menggunakan cPanel:
1. Masuk ke File Manager
2. Pastikan symlink `public_html/storage` ada dan mengarah ke `../storage/app/public`
3. Set permission folder `storage` ke 755 atau 775
