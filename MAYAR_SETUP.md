# Mayar.id Payment Gateway Integration

## Setup Guide

### 1. Dapatkan API Key dari Mayar.id

1. Daftar/Login ke dashboard Mayar.id: https://mayar.id/dashboard
2. Buka menu **Settings** atau **API Configuration**
3. Copy **API Key** Anda
4. Pilih environment: **Sandbox** (testing) atau **Production** (live)

### 2. Konfigurasi .env File

Buka file `.env` dan update konfigurasi berikut:

```env
# Mayar.id Payment Gateway Configuration
MAYAR_API_KEY=your_mayar_api_key_here
MAYAR_ENVIRONMENT=sandbox
MAYAR_CALLBACK_URL="${APP_URL}/api/mayar/callback"
MAYAR_RETURN_URL="${APP_URL}/payment/success"
```

**Penjelasan:**

-   `MAYAR_API_KEY`: API Key dari dashboard Mayar.id
-   `MAYAR_ENVIRONMENT`: `sandbox` untuk testing, `production` untuk live
-   `MAYAR_CALLBACK_URL`: URL webhook untuk notifikasi pembayaran
-   `MAYAR_RETURN_URL`: URL redirect setelah pembayaran selesai

### 3. Setup Webhook di Dashboard Mayar.id

#### Untuk Production (Domain Live)

1. Login ke dashboard Mayar.id
2. Masuk ke menu **Webhook Settings**
3. Tambahkan Callback URL: `https://your-domain.com/api/mayar/callback`
4. Save konfigurasi

#### Untuk Development (Localhost)

**Masalah:** Mayar.id tidak bisa akses `http://localhost:8000` karena hanya accessible dari komputer Anda.

**Solusi:** Gunakan **Tunneling Service** untuk expose localhost ke internet.

##### Option A: Menggunakan Ngrok (Recommended)

1. **Install Ngrok**

    - Download dari: https://ngrok.com/download
    - Extract file ngrok.exe
    - Atau install via chocolatey: `choco install ngrok`

2. **Jalankan Ngrok**

    ```bash
    ngrok http 8000
    ```

3. **Copy URL yang di-generate**

    ```
    Forwarding: https://abc123-random.ngrok-free.app -> http://localhost:8000
    ```

    Copy URL: `https://abc123-random.ngrok-free.app`

4. **Update .env File**

    ```env
    MAYAR_CALLBACK_URL="https://abc123-random.ngrok-free.app/api/mayar/callback"
    ```

5. **Setup di Dashboard Mayar.id**

    - Login ke dashboard Mayar.id
    - Webhook Settings
    - Callback URL: `https://abc123-random.ngrok-free.app/api/mayar/callback`
    - Save

6. **Test Payment**
    - Generate payment link via admin panel
    - Lakukan test payment
    - Cek log di `storage/logs/laravel.log` untuk webhook callback

**Note:** Ngrok URL berubah setiap kali restart (gratis version). Untuk permanent URL, upgrade ke ngrok premium atau gunakan alternatif.

##### Option B: Menggunakan LocalTunnel

1. **Install LocalTunnel**

    ```bash
    npm install -g localtunnel
    ```

2. **Jalankan LocalTunnel**

    ```bash
    lt --port 8000
    ```

3. **Copy URL**

    ```
    your url is: https://random-name-123.loca.lt
    ```

4. **Update .env**
    ```env
    MAYAR_CALLBACK_URL="https://random-name-123.loca.lt/api/mayar/callback"
    ```

##### Option C: Skip Webhook untuk Development

Jika hanya testing generate payment link (tanpa auto-activation):

1. **Generate payment link** via admin panel ✅
2. **User bayar** via Mayar.id ✅
3. **Webhook skip** (karena localhost tidak accessible) ❌
4. **Manual activation** oleh admin:
    - Cek payment status di dashboard Mayar.id
    - Jika sudah paid, buat subscription manual via admin panel

**Cara Manual Activation:**

1. Login admin → Manual Subscriptions
2. Klik "Create Manual Subscription"
3. Pilih user yang sudah bayar
4. Pilih plan sesuai payment
5. Create → Subscription aktif ✅

##### Option D: Testing dengan Mock Webhook

Untuk development testing tanpa payment real:

1. **Buat route testing** (tambahkan di `routes/web.php`):

    ```php
    Route::get('/test-webhook', function() {
        $data = [
            'external_id' => 'INV-20251127-TEST123',
            'status' => 'PAID',
            'payment_method' => ['type' => 'bank_transfer', 'bank' => 'BCA'],
            'paid_at' => now()->toIso8601String()
        ];

        app(App\Services\MayarService::class)->handleCallback($data);

        return 'Webhook processed!';
    });
    ```

2. **Test via browser**: `http://localhost:8000/test-webhook`

**Penting:**

-   Ngrok/LocalTunnel hanya untuk development
-   Untuk production, gunakan domain/IP public
-   Jangan lupa hapus test route sebelum deploy ke production

## Cara Menggunakan

### Option A: Generate Payment Link via Admin

1. **Login sebagai Admin**
2. **Buka menu "Payment Links"** di sidebar
3. **Klik "Generate Payment Link"**
4. **Isi form:**
    - Pilih User
    - Pilih Subscription Plan
    - Tambahkan notes (optional)
5. **Klik "Generate Payment Link"**
6. **Copy link pembayaran** yang sudah di-generate
7. **Kirim link ke user** via WhatsApp atau email

### Flow Pembayaran

```
Admin Generate Link → Admin Kirim Link ke User → User Klik Link →
User Bayar via Mayar.id → Mayar.id Send Webhook →
Subscription Otomatis Aktif ✅
```

## Fitur

### ✅ Generate Payment Link

-   Admin dapat generate link pembayaran untuk user tertentu
-   Link berlaku 24 jam
-   Generate invoice number otomatis (format: INV-YYYYMMDD-XXXXXX)

### ✅ Copy & Share Link

-   Copy link dengan 1 klik
-   Share langsung via WhatsApp (dengan template message)
-   Open link di browser baru

### ✅ Auto-Activation

-   Subscription otomatis aktif setelah pembayaran berhasil
-   Webhook dari Mayar.id trigger aktivasi subscription
-   No manual intervention needed

### ✅ Payment Status Tracking

-   Monitor status pembayaran real-time
-   Status: Pending, Paid, Expired, Cancelled
-   View payment method yang digunakan user

### ✅ Payment History

-   List semua payment links
-   Filter by user, invoice, status
-   View payment details

## API Endpoints Mayar.id

### Create Payment

```
POST https://api.mayar.id/v1/payment/create
```

**Request Body:**

```json
{
    "external_id": "INV-20251127-ABC123",
    "amount": 100000,
    "description": "Subscription: Premium Plan",
    "payer_name": "John Doe",
    "payer_email": "john@example.com",
    "payer_phone": "628123456789",
    "callback_url": "https://your-domain.com/api/mayar/callback",
    "return_url": "https://your-domain.com/payment/success",
    "expired_at": "2025-11-28T10:30:00Z"
}
```

**Response:**

```json
{
    "success": true,
    "data": {
        "id": "mayar_payment_id",
        "payment_url": "https://mayar.id/pay/xxxxxx",
        "status": "pending"
    }
}
```

### Check Payment Status

```
GET https://api.mayar.id/v1/payment/{payment_id}
```

### Webhook Callback

```
POST https://your-domain.com/api/mayar/callback
```

**Payload dari Mayar.id:**

```json
{
    "external_id": "INV-20251127-ABC123",
    "status": "PAID",
    "payment_method": {
        "type": "bank_transfer",
        "bank": "BCA"
    },
    "paid_at": "2025-11-27T12:30:00Z"
}
```

## Testing

### Testing di Sandbox

1. Set `MAYAR_ENVIRONMENT=sandbox` di `.env`
2. Gunakan test API key dari dashboard Mayar.id
3. Generate payment link
4. Gunakan test payment method yang disediakan Mayar.id
5. Cek webhook callback di log: `storage/logs/laravel.log`

### Testing Webhook Locally

Gunakan **ngrok** atau **localtunnel** untuk expose localhost:

```bash
# Install ngrok
ngrok http 8000

# Copy URL yang di-generate
https://abc123.ngrok.io

# Update MAYAR_CALLBACK_URL di .env
MAYAR_CALLBACK_URL="https://abc123.ngrok.io/api/mayar/callback"
```

## Troubleshooting

### Payment Link Tidak Ter-generate

**Problem:** Error "Failed to generate payment link"

**Solution:**

1. Cek API Key di `.env` sudah benar
2. Cek environment (sandbox/production)
3. Cek log di `storage/logs/laravel.log`
4. Pastikan koneksi internet tersedia

### Webhook Tidak Masuk

**Problem:** Payment sudah berhasil tapi subscription tidak aktif

**Solution:**

1. Cek URL webhook di dashboard Mayar.id sudah benar
2. Pastikan URL accessible dari internet (not localhost)
3. Cek log webhook di `storage/logs/laravel.log`
4. Test webhook manual via Postman

### Subscription Tidak Otomatis Aktif

**Problem:** Payment paid tapi subscription masih belum aktif

**Solution:**

1. Cek config `mayar.auto_activate_subscription` = true
2. Cek log error di `storage/logs/laravel.log`
3. Cek webhook callback berhasil diproses
4. Manual activate via admin panel jika perlu

## File Structure

```
app/
├── Http/Controllers/
│   ├── Admin/ManualSubscriptionController.php
│   └── Api/MayarWebhookController.php
├── Models/
│   └── PaymentLink.php
└── Services/
    └── MayarService.php

config/
└── mayar.php

database/migrations/
└── 2025_11_27_032224_create_payment_links_table.php

resources/views/admin/manual-subscriptions/
├── payment-link.blade.php
├── payment-link-detail.blade.php
└── payment-links-list.blade.php

routes/
├── web.php
└── api.php
```

## Database Schema

### Table: payment_links

| Column           | Type      | Description                          |
| ---------------- | --------- | ------------------------------------ |
| id               | uuid      | Primary key                          |
| invoice_number   | string    | Unique invoice (INV-YYYYMMDD-XXXXXX) |
| user_id          | uuid      | Foreign key to users                 |
| plan_id          | uuid      | Foreign key to subscription_plans    |
| payment_url      | string    | Link pembayaran dari Mayar.id        |
| mayar_payment_id | string    | Payment ID dari Mayar.id             |
| amount           | decimal   | Jumlah pembayaran                    |
| status           | string    | pending, paid, expired, cancelled    |
| expires_at       | timestamp | Waktu expired link                   |
| paid_at          | timestamp | Waktu pembayaran berhasil            |
| payment_method   | json      | Metode pembayaran yang digunakan     |
| mayar_response   | json      | Response lengkap dari Mayar.id       |
| notes            | text      | Catatan admin                        |

## Support

Jika ada pertanyaan atau issue:

1. Cek dokumentasi Mayar.id: https://docs.mayar.id
2. Contact support Mayar.id
3. Cek log di `storage/logs/laravel.log`

---

**Created:** November 27, 2025
**Version:** 1.0.0
