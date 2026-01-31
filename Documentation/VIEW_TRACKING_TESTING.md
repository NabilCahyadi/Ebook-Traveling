# 📊 View Tracking Testing Guide

## Deskripsi Fitur
View tracking system menghitung jumlah view untuk setiap ebook dengan aturan:
- **1 view per user per 1 jam** (rolling window)
- User login di-track by user ID
- Guest user di-track by session ID (device/browser)
- View count disimpan di kolom `view_count` di tabel `ebooks`

## Testing Steps

### Test 1: Command Line Test (Verify Database)
```bash
# Clear session data terlebih dahulu
php artisan session:table  # Jika menggunakan database sessions

# Test direct increment (ensure database works)
php artisan test:view-tracking --title="Pesona Wisata"
```

**Expected Output:**
```
Ebook: Pesona Wisata Alam Sumatera Barat
Current view_count: X
New view_count: X+1
View tracking test completed!
```

---

### Test 2: Manual Testing via Browser

#### Prerequisites
1. Clear session files:
   ```bash
   rm -r storage/framework/sessions/*  # Linux/Mac
   # or
   Remove-Item storage/framework/sessions/* -Force  # PowerShell Windows
   ```

2. Clear cache:
   ```bash
   php artisan cache:clear
   php artisan view:clear
   ```

3. Make sure app is running:
   ```bash
   php artisan serve
   ```

#### Test Case A: Authenticated User
1. **Login** dengan akun pengguna
2. **Buka ebook detail page** → `/ebooks/pesona-wisata-alam-sumatera-barat`
3. **Check logs:**
   ```bash
   tail -f storage/logs/laravel.log  # Linux/Mac
   # or
   Get-Content storage/logs/laravel.log -Wait -Tail 20  # PowerShell
   ```
   
   **Look for lines containing:**
   ```
   📖 [VIEW TRACKING] Started
   ✅ [VIEW TRACKING] View count incremented
   ```

4. **Verify in database:**
   ```bash
   mysql -u root -p"lala_kahla30" ebook_traveling -e "SELECT id, title, view_count FROM ebooks WHERE title LIKE '%Pesona%';"
   ```
   
   **Expected:** `view_count` increased by 1

5. **Refresh page 5 times within 10 minutes** → view_count should **NOT** increase
   - Check logs for:
   ```
   📖 [VIEW TRACKING] Reason: Within 1 hour - skip counting
   ```

6. **Wait 1 hour**, then refresh → view_count should increase again
   - Or for testing, modify the code to use minutes instead of seconds (see below)

#### Test Case B: Guest User
1. **Clear browser cookies/session**
2. **Don't login** - stay as guest
3. Open ebook detail page
4. Check logs and database
5. Expected behavior same as authenticated user (tracked by session ID)

---

### Test 3: Logs Analysis

#### Log Locations
```
storage/logs/laravel.log  # Main application logs
```

#### Expected Log Patterns

**✅ First view (always increment):**
```
📖 [VIEW TRACKING] Started
  ebook_id: "...",
  tracking_type: "authenticated_user",
  last_view_time: null,
  current_view_count: 0

📖 [VIEW TRACKING] Reason: First view - no session data found

✅ [VIEW TRACKING] View count incremented
  new_view_count: 1

💾 [VIEW TRACKING] Session updated
```

**⏭️ Refresh within 1 hour (skip):**
```
📖 [VIEW TRACKING] Started
  last_view_time: "2026-01-27 16:00:00",
  minutes_elapsed: 5

📖 [VIEW TRACKING] Reason: Within 1 hour - skip counting
  minutes_elapsed: 5,
  minutes_remaining: 55
```

**✅ After 1 hour (increment again):**
```
📖 [VIEW TRACKING] Started
  minutes_elapsed: 61

📖 [VIEW TRACKING] Reason: 1 hour passed - can count again
  minutes_elapsed: 61

✅ [VIEW TRACKING] View count incremented
  new_view_count: 2
```

---

### Test 4: Database Verification

Check view_count progression:

```bash
# Watch specific ebook
mysql -u root -p"lala_kahla30" ebook_traveling -e \
  "SELECT id, title, view_count, updated_at FROM ebooks WHERE title LIKE '%Pesona%';"
```

### Test 5: Session Files Verification

Session data is stored in files. Check if session key is saved:

```bash
# List session files
ls -la storage/framework/sessions/

# Search for session content
grep -l "viewed_ebook_" storage/framework/sessions/*

# View session content (requires decryption if encrypted)
cat storage/framework/sessions/SESSIONID
```

---

## Troubleshooting

### Issue: view_count tidak bertambah
**Checklist:**
1. ✅ Sudah login? (cek dengan `auth()->check()` di logs)
2. ✅ Session folder writable? → `chmod 777 storage/framework/sessions/`
3. ✅ Laravel debug mode on? → `APP_DEBUG=true` di `.env`
4. ✅ Cache cleared? → `php artisan cache:clear`
5. ✅ Browser cookies cleared?
6. ✅ Check logs untuk error messages

### Issue: Session tidak tersimpan
**Solution:**
- Change SESSION_DRIVER to database:
  ```bash
  php artisan session:table
  php artisan migrate
  ```
  Edit `.env`: `SESSION_DRIVER=database`

### Issue: view_count bertambah untuk setiap refresh
**Problem:** Timeout window terlalu pendek
**Check:**
- Verify condition: `$now->diffInMinutes($lastViewTime) >= 60`
- Ensure `session()->save()` is called

---

## Quick Debugging Commands

```bash
# 1. Test database increment
php artisan test:view-tracking --title="Pesona Wisata"

# 2. Clear all caches
php artisan cache:clear && php artisan view:clear

# 3. Clear all sessions
php artisan session:garbage

# 4. Check logs in real-time
tail -f storage/logs/laravel.log

# 5. Query database
mysql -u root -p"lala_kahla30" ebook_traveling
  > SELECT id, title, view_count, updated_at FROM ebooks WHERE view_count > 0 ORDER BY view_count DESC;
```

---

## Session Configuration

**Current Setup:**
- Driver: `file` (from `.env`: `SESSION_DRIVER=file`)
- Location: `storage/framework/sessions/`
- Lifetime: 120 minutes (from `config/session.php`)

**For Production, Consider:**
```bash
# Database-backed sessions (more reliable)
SESSION_DRIVER=database
php artisan session:table
php artisan migrate

# Or Redis (if available)
SESSION_DRIVER=redis
```

---

## Expected Results

After implementation, when user (logged in) opens `/ebooks/pesona-wisata-alam-sumatera-barat`:

| Action | Expected Result | View Count |
|--------|-----------------|-----------|
| First open | view_count increments | 1 |
| Refresh after 5 min | skipped (within 1 hour) | 1 |
| Refresh after 10 min | skipped | 1 |
| After 1 hour + refresh | increments | 2 |
| Different ebook | increments (separate tracking) | 1 |

---

## Implementation Details

### Code Location
- File: `app/Http/Controllers/EbookController.php`
- Method: `show($slug)` (lines 54-142)

### Session Keys Used
```
Authenticated: viewed_ebook_{ebook_id}_user_{user_id}
Guest: viewed_ebook_{ebook_id}_guest_{session_id}
```

### Database Operations
```php
$ebook->increment('view_count');  // Atomic increment
$ebook->refresh();                 // Get latest value from DB
```

---

## Notes

- ⏱️ **Timing:** Each user gets exactly 1 increment per 60-minute rolling window
- 📱 **Device-specific:** Guest tracking is per device/browser (session ID based)
- 🔐 **Authenticated:** Logged-in users tracked by user ID (not device)
- 💾 **Persistent:** View count stored in database `ebooks.view_count`
- 📝 **Logging:** Detailed logs in `storage/logs/laravel.log` for debugging
