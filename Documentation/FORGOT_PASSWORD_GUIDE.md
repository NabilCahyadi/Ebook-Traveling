# Forgot Password System - Setup Guide

## Overview
Sistem forgot password dengan verifikasi kode 6 digit yang dikirim via email.

## Fitur
- ✅ Request kode verifikasi via email
- ✅ Verifikasi kode 6 digit
- ✅ Rate limiting (max 5 attempts, 1 menit cooldown)
- ✅ Kode expire dalam 15 menit
- ✅ Resend code functionality
- ✅ Secure token-based reset

## Alur Penggunaan

### 1. User Request Reset Password
- User mengklik "Forgot Password" di halaman login
- User memasukkan email yang terdaftar
- Sistem mengirim kode 6 digit ke email

### 2. Verifikasi Kode
- User menerima email dengan kode verifikasi
- User memasukkan kode di halaman verifikasi
- Sistem memvalidasi kode (max 5 attempts)
- Jika valid, user diarahkan ke halaman reset password

### 3. Reset Password
- User memasukkan password baru
- Sistem update password dan menghapus token reset
- User diarahkan ke halaman login

## Routes

```php
// Forgot Password Routes
GET  /forgot-password          -> Form request kode
POST /forgot-password          -> Kirim kode ke email
GET  /verify-code              -> Form verifikasi kode
POST /verify-code              -> Proses verifikasi
POST /resend-code              -> Kirim ulang kode
GET  /reset-password           -> Form reset password
POST /reset-password           -> Update password
```

## Email Configuration

### Development (Log Driver)
Untuk testing lokal, email akan di-log ke `storage/logs/laravel.log`:

```env
MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
```

### Production (SMTP)
Untuk production, gunakan SMTP (Gmail, Mailtrap, SendGrid, dll):

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=nicm mvph eqhu lspi
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### Gmail App Password
1. Buka Google Account Settings
2. Security → 2-Step Verification
3. App passwords → Generate password
4. Gunakan password tersebut di `MAIL_PASSWORD`

### Mailtrap (Testing)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
```

## Database Schema

Migration menambahkan kolom ke `password_reset_tokens`:
- `verification_code` (string, 6 digit)
- `expires_at` (timestamp)
- `attempts` (integer, tracking failed attempts)

## Security Features

### Rate Limiting
- Max 5 attempts untuk verifikasi kode
- Cooldown 1 menit untuk request kode baru
- Auto-delete token setelah 5 failed attempts

### Expiration
- Kode expire setelah 15 menit
- Token dihapus setelah password berhasil direset
- Old tokens dihapus saat request kode baru

### Code Generation
- 6 digit random number (000000-999999)
- Zero-padded untuk konsistensi format
- Unique per email address

## Testing

### 1. Test Email Sending (Log)
```bash
php artisan tinker
>>> use App\Models\User;
>>> $user = User::first();
>>> $user->notify(new \App\Notifications\ResetPasswordCodeNotification('123456'));
>>> exit
```

Check log: `tail -f storage/logs/laravel.log`

### 2. Manual Testing
1. Akses `/forgot-password`
2. Masukkan email yang valid
3. Check email/log untuk kode
4. Masukkan kode di `/verify-code`
5. Reset password di `/reset-password`

### 3. Test Cases
- ✅ Valid email → receive code
- ✅ Invalid email → error message
- ✅ Expired code → redirect to request new
- ✅ Wrong code (5x) → token deleted
- ✅ Resend code → new code generated
- ✅ Successful reset → password updated

## Troubleshooting

### Email Not Sending
```bash
# Check queue
php artisan queue:work

# Check mail config
php artisan config:clear
php artisan config:cache

# Test mail
php artisan tinker
>>> Mail::raw('Test', function($message) {
>>>   $message->to('test@example.com')->subject('Test');
>>> });
```

### Code Not Found
- Check if migration ran: `php artisan migrate:status`
- Clear cache: `php artisan cache:clear`
- Check database: `SELECT * FROM password_reset_tokens;`

### Session Issues
```bash
php artisan session:table
php artisan migrate
php artisan config:clear
```

## Production Checklist

- [ ] Configure production SMTP credentials
- [ ] Set `QUEUE_CONNECTION=redis` or `database`
- [ ] Run queue worker: `php artisan queue:work --daemon`
- [ ] Setup supervisor for queue worker
- [ ] Test email delivery
- [ ] Monitor failed jobs
- [ ] Setup email notification for failed resets

## Files Created

```
database/migrations/
  └── 2026_01_08_000001_add_verification_code_to_password_resets.php

app/Http/Controllers/Auth/
  └── ForgotPasswordController.php

app/Notifications/
  └── ResetPasswordCodeNotification.php

resources/views/auth/
  ├── forgot-password.blade.php
  ├── verify-code.blade.php
  └── reset-password.blade.php

routes/modules/
  └── auth.php (updated)
```

## API Endpoints (Optional)

Jika perlu API endpoints untuk mobile app:

```php
// routes/api.php
Route::post('/forgot-password', [ApiForgotPasswordController::class, 'sendCode']);
Route::post('/verify-code', [ApiForgotPasswordController::class, 'verifyCode']);
Route::post('/reset-password', [ApiForgotPasswordController::class, 'reset']);
```

## Customization

### Change Code Length
Edit `ForgotPasswordController.php`:
```php
// Generate 4 digit code instead
$code = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);
```

### Change Expiration Time
```php
'expires_at' => now()->addMinutes(30), // 30 minutes instead of 15
```

### Custom Email Template
Edit `app/Notifications/ResetPasswordCodeNotification.php`

## Support

Untuk pertanyaan atau issues:
- Check Laravel logs: `storage/logs/laravel.log`
- Queue logs: `php artisan queue:failed`
- Database: `SELECT * FROM password_reset_tokens;`
