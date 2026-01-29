# 🔍 Debugging View Count - Pesona Wisata Alam Sumatera Barat

## Masalah
View count untuk ebook "Pesona Wisata Alam Sumatera Barat" masih 0 setelah implementasi view tracking.

## Solusi Cepat

### Step 1: Pastikan Session Driver Aktif
```bash
cd "d:\PROJEK PROJEK\Ebook-Traveling"

# Clear session
rm storage/framework/sessions/* -Force

# Clear cache
php artisan cache:clear
```

### Step 2: Test Database (Pastikan Database Bekerja)
```bash
php artisan test:view-tracking --title="Pesona Wisata"
```

**Output yang diharapkan:**
```
Ebook: Pesona Wisata Alam Sumatera Barat
Current view_count: 0
New view_count: 1
View tracking test completed!
```

Jika ini berhasil = **Database OK ✅**

### Step 3: Test via Browser

1. **Login dulu** ke aplikasi (PENTING!)
2. **Buka ebook detail:** https://dev-new.mappy.id/ebooks/pesona-wisata-alam-sumatera-barat
3. **Check logs:**
   ```bash
   Get-Content storage/logs/laravel.log -Tail 30
   ```
   
   Cari baris yang mengandung: `📖 [VIEW TRACKING]` atau `✅ [VIEW TRACKING]`

4. **Check database:**
   ```bash
   mysql -h 127.0.0.1 -u root -p"lala_kahla30" ebook_traveling ^
     -e "SELECT id, title, view_count, updated_at FROM ebooks WHERE title LIKE '%Pesona%';"
   ```

### Step 4: Interpretasi Hasil

**Jika view_count bertambah di database:**
✅ **View tracking BERHASIL!**

**Jika view_count masih 0:**
🔴 Ada masalah. Cek checklist:

- [ ] Sudah login?
- [ ] Session folder writable? `attrib storage/framework/sessions`
- [ ] Logs ada pesan error? `Get-Content storage/logs/laravel.log -Tail 50 | Select-String "ERROR|ERROR"`
- [ ] Browser cache? Tekan `Ctrl+Shift+Del` clear cache
- [ ] Refresh halaman ebook

## Kemungkinan Masalah & Solusi

### 1. Session tidak tersimpan
**Solusi:** Gunakan database sessions instead:
```bash
php artisan session:table
php artisan migrate

# Edit .env:
# SESSION_DRIVER=database
```

### 2. User tidak login saat view tracking
**Solusi:** 
- Pastikan sudah login sebelum buka ebook
- Cek logs apakah `tracking_type: "authenticated_user"`

### 3. Route cache membuat perubahan tidak aktif
**Solusi:**
```bash
php artisan route:clear
php artisan cache:clear
php artisan config:cache
```

### 4. Timeout terlalu pendek untuk testing
**Solusi:** Edit timeout jadi 1 menit untuk testing:
```php
// di app/Http/Controllers/EbookController.php, line ~107
if ($minutesElapsed >= 1) {  // Change dari 60 ke 1 untuk testing
```

## Test Scenario

1. Login → Open ebook → view_count = 1 ✅
2. Refresh 5x dalam 10 menit → view_count tetap 1 ✅
3. Tunggu 1 jam → Refresh → view_count = 2 ✅

## Emergency Reset

Jika ingin reset dan testing ulang:

```bash
# 1. Reset view count ke 0
mysql -h 127.0.0.1 -u root -p"lala_kahla30" ebook_traveling -e \
  "UPDATE ebooks SET view_count = 0 WHERE title LIKE '%Pesona%';"

# 2. Clear semua session
Remove-Item storage/framework/sessions/* -Force

# 3. Clear cache
php artisan cache:clear
php artisan view:clear
php artisan config:cache

# 4. Verify
mysql -h 127.0.0.1 -u root -p"lala_kahla30" ebook_traveling -e \
  "SELECT title, view_count FROM ebooks WHERE title LIKE '%Pesona%';"
```

## Log Analysis

### Good Log (view bertambah)
```
[2026-01-27 16:30:00] local.INFO: 📖 [VIEW TRACKING] Started
[2026-01-27 16:30:00] local.INFO: 📖 [VIEW TRACKING] Reason: First view - no session data found
[2026-01-27 16:30:00] local.INFO: ✅ [VIEW TRACKING] View count incremented
[2026-01-27 16:30:00] local.INFO: 💾 [VIEW TRACKING] Session updated
```

### Bad Log (view tidak bertambah dalam 1 jam)
```
[2026-01-27 16:30:00] local.INFO: 📖 [VIEW TRACKING] Started
[2026-01-27 16:30:00] local.INFO: 📖 [VIEW TRACKING] Reason: Within 1 hour - skip counting
```

Ini NORMAL - jangan increment lebih dari 1x per jam!

### Error Log (database error)
```
[2026-01-27 16:30:00] local.ERROR: ❌ [VIEW TRACKING] Error during increment
```

Jika ada error ini, problem di database connection. Cek MySQL running.

## Contact

Jika masalah tidak teratasi, cek:
1. `storage/logs/laravel.log` - full error details
2. `storage/framework/sessions/` - cek session file ada/tidak
3. Database connection - test dengan `php artisan tinker`

---

**Last Updated:** 2026-01-27
**Status:** 🟢 Implementation Complete, Testing Phase
