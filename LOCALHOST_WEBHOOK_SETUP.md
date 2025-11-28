# Development Setup: Webhook di Localhost

## 🏠 Problem: Webhook di Localhost

Mayar.id tidak bisa kirim webhook ke `http://localhost:8000` karena localhost hanya accessible dari komputer Anda, bukan dari internet.

## 💡 Solusi

Ada beberapa cara untuk handle webhook di development:

---

## 1️⃣ Ngrok (Recommended - Paling Mudah)

### Install Ngrok

**Windows:**

1. Download dari: https://ngrok.com/downl oad
2. Extract `ngrok.exe`
3. (Optional) Tambahkan ke PATH

**Via Chocolatey:**

```bash
choco install ngrok
```

### Jalankan Ngrok

```bash
# Jalankan Laravel dev server
php artisan serve

# Di terminal baru, jalankan ngrok
ngrok http 8000
```

### Output Ngrok

```
ngrok by @inconshreveable

Session Status                online
Account                       Free
Version                       3.x.x
Region                        Asia Pacific (ap)
Forwarding                    https://abc123-random.ngrok-free.app -> http://localhost:8000

Connections                   ttl     opn     rt1     rt5     p50     p90
                              0       0       0.00    0.00    0.00    0.00
```

**Copy URL:** `https://abc123-random.ngrok-free.app`

### Update Laravel

1. **Update .env:**

```env
MAYAR_CALLBACK_URL="https://abc123-random.ngrok-free.app/api/mayar/callback"
```

2. **Restart Laravel (jika perlu):**

```bash
php artisan config:clear
php artisan serve
```

### Setup Webhook di Mayar.id

1. Login ke https://mayar.id/dashboard
2. Buka **Webhook Settings**
3. Callback URL: `https://abc123-random.ngrok-free.app/api/mayar/callback`
4. Save

### Test Webhook

1. Generate payment link via admin
2. Lakukan test payment
3. Cek terminal ngrok → ada request masuk
4. Cek Laravel log: `storage/logs/laravel.log`
5. Subscription otomatis aktif ✅

### Ngrok Tips

**Kelebihan:**

-   ✅ Gratis
-   ✅ Setup cepat (1 command)
-   ✅ HTTPS included
-   ✅ Web interface untuk monitoring requests

**Kekurangan:**

-   ❌ URL berubah setiap restart (free version)
-   ❌ Session timeout setelah 2 jam (free version)

**Fix URL Berubah:**

-   Upgrade ke ngrok Pro ($10/month) → permanent URL
-   Atau gunakan alternatif di bawah

---

## 2️⃣ LocalTunnel (Alternative)

### Install LocalTunnel

```bash
npm install -g localtunnel
```

### Jalankan

```bash
# Jalankan Laravel
php artisan serve

# Di terminal baru
lt --port 8000
```

### Output

```
your url is: https://random-name-123.loca.lt
```

### Setup

1. Update .env:

```env
MAYAR_CALLBACK_URL="https://random-name-123.loca.lt/api/mayar/callback"
```

2. Setup webhook di Mayar.id dashboard

**Note:** LocalTunnel kadang minta password di browser pertama kali. Klik "Click to Continue".

---

## 3️⃣ Manual Activation (No Tunnel Needed)

Jika tidak mau setup tunnel, bisa manual activation:

### Flow:

1. **Generate payment link** via admin ✅
2. **User bayar** via Mayar.id ✅
3. **Webhook tidak masuk** (karena localhost) ❌
4. **Admin cek payment status** di dashboard Mayar.id
5. **Manual create subscription** via admin panel

### Cara Manual Activation:

1. Login admin → `/admin/manual-subscriptions`
2. Klik **"Create Manual Subscription"**
3. Pilih user yang sudah bayar
4. Pilih plan sesuai payment
5. Klik Create
6. ✅ Subscription aktif!

**Kapan pakai cara ini:**

-   Quick testing tanpa setup tunnel
-   Development awal
-   Tidak butuh auto-activation

---

## 4️⃣ Mock Webhook untuk Testing

Untuk testing logic tanpa payment real:

### Tambahkan Test Route

Edit `routes/web.php`:

```php
// Test Webhook (Development Only)
if (config('app.debug')) {
    Route::get('/test-webhook/{invoice}', function($invoice) {
        $data = [
            'external_id' => $invoice,
            'status' => 'PAID',
            'payment_method' => [
                'type' => 'bank_transfer',
                'bank' => 'BCA'
            ],
            'paid_at' => now()->toIso8601String()
        ];

        $result = app(\App\Services\MayarService::class)->handleCallback($data);

        return response()->json([
            'success' => $result,
            'message' => $result ? 'Webhook processed!' : 'Failed to process webhook'
        ]);
    });
}
```

### Cara Test:

1. Generate payment link → dapat invoice: `INV-20251127-ABC123`
2. Buka browser: `http://localhost:8000/test-webhook/INV-20251127-ABC123`
3. ✅ Subscription otomatis aktif!

**Penting:** Hapus route ini sebelum production!

---

## 5️⃣ Expose.sh (Alternative)

### Install Expose

```bash
# Via Composer Global
composer global require beyondcode/expose

# Via NPM
npm install -g @beyondcode/expose
```

### Jalankan

```bash
expose share http://localhost:8000
```

### Setup di Mayar.id

Copy URL yang di-generate dan setup di webhook settings.

---

## 🎯 Recommendation

| Scenario             | Solution           | Effort |
| -------------------- | ------------------ | ------ |
| **Quick Testing**    | Manual Activation  | Low    |
| **Development**      | Ngrok Free         | Medium |
| **Team Development** | Ngrok Pro ($10/mo) | Medium |
| **Testing Logic**    | Mock Webhook       | Low    |
| **Production**       | Domain Public      | N/A    |

---

## 🔍 Monitoring Webhook

### 1. Ngrok Web Interface

Buka: `http://127.0.0.1:4040`

Features:

-   Request/Response history
-   Replay requests
-   Request inspector

### 2. Laravel Log

```bash
tail -f storage/logs/laravel.log
```

Search for: `Mayar Webhook Received`

### 3. Tinker Test

```bash
php artisan tinker

>>> $payment = \App\Models\PaymentLink::first();
>>> $payment->status; // cek status
>>> $payment->mayar_response; // cek response dari mayar
```

---

## ⚠️ Important Notes

1. **Jangan expose localhost untuk production** → security risk
2. **Tunnel services hanya untuk development**
3. **Production harus gunakan domain/IP public**
4. **Hapus test routes sebelum deploy**
5. **Ngrok URL berubah tiap restart** (free version)

---

## 📞 Need Help?

**Ngrok Issues:**

-   Dokumentasi: https://ngrok.com/docs
-   Status page: https://status.ngrok.com

**LocalTunnel Issues:**

-   GitHub: https://github.com/localtunnel/localtunnel

**Webhook Issues:**

-   Cek Laravel log: `storage/logs/laravel.log`
-   Test manual: Postman/Insomnia
-   Mayar.id support: support@mayar.id

---

## 🚀 Quick Start Command

```bash
# Terminal 1: Laravel
php artisan serve

# Terminal 2: Ngrok
ngrok http 8000

# Copy URL dari ngrok → Update .env → Setup webhook di Mayar.id
```

Done! 🎉
