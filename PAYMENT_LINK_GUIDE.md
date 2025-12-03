# Quick Start: Generate Payment Link untuk Admin

## ⚠️ Setup Awal (Jika Development/Localhost)

**Jika Anda development di localhost, webhook Mayar.id tidak bisa langsung masuk.**

### Quick Setup dengan Ngrok:

1. **Download Ngrok:** https://ngrok.com/download
2. **Jalankan Ngrok:**
    ```bash
    ngrok http 8000
    ```
3. **Copy URL yang muncul** (contoh: `https://abc123.ngrok-free.app`)
4. **Update .env:**
    ```env
    MAYAR_CALLBACK_URL="https://abc123.ngrok-free.app/api/mayar/callback"
    ```
5. **Setup Webhook di Mayar.id Dashboard:**
    - Login ke dashboard Mayar.id
    - Webhook Settings → Callback URL: `https://abc123.ngrok-free.app/api/mayar/callback`

**Alternatif untuk Testing:**

-   Generate payment link seperti biasa ✅
-   User bayar via Mayar.id ✅
-   **Manual activate** subscription via admin panel (karena webhook skip)

**Untuk Production:** Tidak perlu ngrok, webhook langsung bisa masuk ke domain Anda.

---

## 🚀 Cara Generate Payment Link

### Step 1: Login sebagai Admin

1. Buka `http://localhost:8000/admin/login`
2. Login dengan akun admin

### Step 2: Buka Menu Payment Links

1. Di sidebar, klik **"Payment Links"**
2. Atau langsung ke: `http://localhost:8000/admin/payment-links`

### Step 3: Generate Link Baru

1. Klik tombol **"Generate Payment Link"**
2. Isi form:
    - **User**: Pilih user yang akan membeli subscription
    - **Plan**: Pilih subscription plan (contoh: Premium 30 hari)
    - **Notes**: (Optional) Contoh: "Request via WhatsApp, promo DISC10"
3. Klik **"Generate Payment Link"**

### Step 4: Copy & Share Link

Setelah link ter-generate, Anda akan melihat:

-   Invoice Number (contoh: INV-20251127-ABC123)
-   Payment URL (link pembayaran)
-   User info & Plan details

**Cara Share:**

**Option A: Copy Manual**

1. Klik tombol **"Copy"**
2. Paste link di WhatsApp/Email

**Option B: Share via WhatsApp**

1. Klik tombol **"Share via WhatsApp"**
2. Otomatis buka WhatsApp dengan template message
3. Send ke user

### Step 5: Monitor Payment Status

1. User akan terima link dan melakukan pembayaran
2. Sistem otomatis update status ketika user bayar
3. Subscription otomatis aktif setelah pembayaran berhasil ✅

---

## 📱 Template Message WhatsApp

```
Halo [Nama User],

Berikut link pembayaran untuk subscription [Nama Plan]:

Jumlah: Rp [Amount]
Link: [Payment URL]

Link berlaku selama 24 jam. Silakan segera lakukan pembayaran.

Terima kasih!
```

---

## 🔍 Cek Status Pembayaran

### Cara 1: Via Payment Links List

1. Buka menu **"Payment Links"**
2. Lihat status di kolom "Status":
    - 🟡 **Pending**: Belum dibayar
    - 🟢 **Paid**: Sudah dibayar (subscription aktif)
    - 🔴 **Expired**: Link expired (24 jam habis)

### Cara 2: Via Detail Payment

1. Klik icon **"⋮"** (three dots) di payment
2. Pilih **"View Details"**
3. Klik **"Check Status"** untuk refresh

---

## ✅ Payment Berhasil - Apa yang Terjadi?

Ketika user berhasil bayar:

1. ✅ Status payment berubah jadi **"Paid"**
2. ✅ Subscription otomatis dibuat untuk user
3. ✅ User dapat akses premium content
4. ✅ Email notifikasi dikirim ke user (jika sudah setup)

---

## ⚠️ Troubleshooting

### Problem: Link tidak bisa di-generate

**Solusi:**

1. Cek API Key Mayar.id di file `.env`
2. Pastikan `MAYAR_API_KEY` sudah diisi
3. Cek koneksi internet
4. Lihat log error di `storage/logs/laravel.log`

### Problem: Payment sudah berhasil tapi subscription tidak aktif

**Solusi:**

1. Cek webhook URL sudah di-setup di dashboard Mayar.id
2. Callback URL: `https://your-domain.com/api/mayar/callback`
3. Untuk localhost, gunakan ngrok untuk expose URL

### Problem: Link expired sebelum user bayar

**Solusi:**

1. Generate link baru untuk user
2. Link berlaku 24 jam, jadi generate ketika user siap bayar
3. User harus bayar dalam 24 jam

---

## 📊 View All Payments

Menu **"Payment Links"** menampilkan:

-   ✅ List semua payment links
-   ✅ Filter/search by user atau invoice
-   ✅ Status setiap payment (Pending/Paid/Expired)
-   ✅ Tanggal created & expired
-   ✅ Quick actions (Copy link, View detail)

---

## 💡 Tips

1. **Generate link ketika user siap bayar** (karena expired 24 jam)
2. **Tambahkan notes** untuk tracking (contoh: "Promo Black Friday")
3. **Share via WhatsApp** lebih cepat daripada copy-paste manual
4. **Monitor status** untuk follow-up ke user yang belum bayar
5. **Cek payment history** untuk laporan bulanan

---

## 🎯 Next Steps

Setelah payment link system jalan:

1. Setup **email notification** untuk user
2. Setup **reminder** untuk link yang akan expired
3. Setup **webhook logging** untuk debugging
4. Setup **payment report** untuk finance

---

**Need Help?**

-   Cek `MAYAR_SETUP.md` untuk technical setup
-   Contact Mayar.id support untuk API issues
-   Cek Laravel logs di `storage/logs/laravel.log`
