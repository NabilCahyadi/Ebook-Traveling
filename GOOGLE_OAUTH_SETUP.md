# Google OAuth Setup - Error Fix

## ❌ Masalah yang Terjadi:

# Google OAuth Setup - Error Fix

## ❌ Masalah yang Terjadi:

**Error 400: invalid_request - Missing required parameter: redirect_uri**

## ✅ Dua Cara Setup:

### 🔥 **Cara 1: Menggunakan Firebase (LEBIH MUDAH - RECOMMENDED)**

### ☁️ **Cara 2: Menggunakan Google Cloud Console (Manual)**

---

# 🔥 CARA 1: Setup dengan Firebase (Recommended)

Firebase menyediakan cara yang lebih mudah untuk setup Google OAuth tanpa ribet!

## Step 1: Buat Firebase Project

1. **Buka Firebase Console**: https://console.firebase.google.com/
2. **Klik "Add project"** atau "Create a project"
3. **Project name**: `Ebook-Traveling` (atau nama lain)
4. **Google Analytics**: Pilih "Not now" (tidak perlu untuk OAuth)
5. Klik **"Create project"** → tunggu beberapa detik
6. Klik **"Continue"** setelah selesai

## Step 2: Enable Google Sign-In di Firebase

1. Di Firebase Console, pilih project yang baru dibuat
2. Di sidebar kiri, klik **"Authentication"** (ikon kunci)
3. Klik tab **"Sign-in method"**
4. Cari **"Google"** di daftar providers
5. Klik **"Google"** untuk expand
6. Toggle **"Enable"** ke ON
7. **Project public-facing name**: `Ebook Traveling`
8. **Project support email**: Pilih email Anda dari dropdown
9. Klik **"Save"**

## Step 3: Dapatkan Web Client ID & Secret

### Opsi A: Dari Firebase Settings (Mudah)

1. Di Firebase sidebar, klik **⚙️ (Settings)** → **"Project settings"**
2. Scroll ke bawah, bagian **"Your apps"**
3. Klik icon **"Web"** (`</>`) untuk add web app
4. **App nickname**: `Ebook Traveling Web`
5. ❌ **JANGAN** centang "Firebase Hosting"
6. Klik **"Register app"**
7. Copy **API Key** dan **Project ID** (akan muncul config)
8. Klik **"Continue to console"**

### Opsi B: Dari Google Cloud Console (Lebih Detail)

Firebase otomatis membuat Google Cloud Project. Untuk mendapatkan Client Secret:

1. Di Firebase Settings, scroll ke bawah
2. Di bagian **"Service accounts"**, klik link **"Google Cloud Platform"**
3. Akan redirect ke Google Cloud Console
4. Di sidebar kiri, klik **"APIs & Services"** → **"Credentials"**
5. Cari **"Web client (auto created by Google Service)"**
6. Klik nama credential tersebut
7. **Copy Client ID & Client Secret**
8. Tambahkan **Authorized redirect URIs**:
    ```
    http://localhost:8000/login/google/callback
    http://127.0.0.1:8000/login/google/callback
    ```
9. Klik **"Save"**

## Step 4: Update `.env` File

```env
# Google OAuth Configuration (from Firebase)
GOOGLE_CLIENT_ID=123456789-abcdefg.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=GOCSPX-xxxxxxxxxxxxxxxxxxxxx
GOOGLE_REDIRECT_URI=http://localhost:8000/login/google/callback
```

**Cara dapat credentials:**

-   **Client ID**: Dari Google Cloud Console → Credentials
-   **Client Secret**: Dari Google Cloud Console → Credentials
-   **Redirect URI**: Harus tambahkan manual di Authorized redirect URIs

## Step 5: Tambahkan Authorized Domains (Penting!)

1. Kembali ke Firebase Console → **Authentication**
2. Tab **"Settings"** (bukan Sign-in method)
3. Scroll ke **"Authorized domains"**
4. Pastikan ada:

    - `localhost` (biasanya sudah ada default)

    Jika tidak ada, klik **"Add domain"** dan tambahkan `localhost`

## Step 6: Test Setup

```bash
# Clear cache
php artisan config:clear
php artisan cache:clear

# Restart server
php artisan serve
```

Buka http://localhost:8000/login dan klik **"Sign in with Google"**

## ✅ Keuntungan Pakai Firebase:

-   ✅ **Lebih mudah** setup OAuth
-   ✅ **Auto-configure** banyak settings
-   ✅ **Dashboard lebih user-friendly**
-   ✅ **Gratis** untuk development
-   ✅ Bisa pakai fitur Firebase lainnya (Firestore, Storage, dll) di masa depan
-   ✅ **Analytics** bawaan untuk tracking user login

---

# ☁️ CARA 2: Setup dengan Google Cloud Console (Manual)

Cara ini lebih manual tapi memberikan kontrol lebih:

## ✅ Solusi:

## ✅ Solusi:

### 1. **Tambahkan Konfigurasi Google OAuth di `.env`**

File `.env` sudah saya update dengan:

```env
GOOGLE_CLIENT_ID=your-google-client-id-here
GOOGLE_CLIENT_SECRET=your-google-client-secret-here
GOOGLE_REDIRECT_URI=http://localhost:8000/login/google/callback
```

### 2. **Cara Mendapatkan Google OAuth Credentials:**

#### Step 1: Buka Google Cloud Console

1. Buka: https://console.cloud.google.com/
2. Login dengan akun Google Anda

#### Step 2: Buat Project Baru (atau pilih yang sudah ada)

1. Klik dropdown project di bagian atas
2. Klik "New Project"
3. Nama project: **Ebook Traveling**
4. Klik "Create"

#### Step 3: Enable Google+ API

1. Di menu sebelah kiri, klik "APIs & Services" → "Library"
2. Cari: **"Google+ API"** atau **"Google Identity"**
3. Klik dan tekan tombol "Enable"

#### Step 4: Buat OAuth 2.0 Client ID

1. Di menu sebelah kiri, klik "APIs & Services" → "Credentials"
2. Klik "Create Credentials" → "OAuth client ID"
3. Jika muncul consent screen warning, setup dulu:
    - Klik "Configure Consent Screen"
    - Pilih "External"
    - App name: **Ebook Traveling**
    - User support email: pilih email Anda
    - Developer contact: masukkan email Anda
    - Klik "Save and Continue" sampai selesai

#### Step 5: Konfigurasi OAuth Client

1. Application type: **Web application**
2. Name: **Ebook Traveling Web**
3. **Authorized JavaScript origins:**
    ```
    http://localhost:8000
    http://127.0.0.1:8000
    ```
4. **Authorized redirect URIs:**
    ```
    http://localhost:8000/login/google/callback
    http://127.0.0.1:8000/login/google/callback
    ```
5. Klik "Create"

#### Step 6: Copy Credentials

1. Setelah dibuat, akan muncul popup dengan:
    - **Client ID** (panjang, seperti: xxxxx.apps.googleusercontent.com)
    - **Client Secret** (string acak)
2. **COPY kedua nilai ini!**

### 3. **Update File `.env`**

Buka file `.env` dan ganti:

```env
GOOGLE_CLIENT_ID=paste-client-id-disini
GOOGLE_CLIENT_SECRET=paste-client-secret-disini
GOOGLE_REDIRECT_URI=http://localhost:8000/login/google/callback
```

**Contoh:**

```env
GOOGLE_CLIENT_ID=123456789-abcdefghijklmnop.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=GOCSPX-aBcDeFgHiJkLmNoPqRsTuVwXyZ
GOOGLE_REDIRECT_URI=http://localhost:8000/login/google/callback
```

### 4. **Clear Cache Laravel**

Setelah update `.env`, jalankan:

```bash
php artisan config:clear
php artisan cache:clear
```

### 5. **Restart Server**

```bash
php artisan serve
```

### 6. **Test Login Google**

1. Buka: http://localhost:8000/login
2. Klik tombol "Sign in with Google"
3. Pilih akun Google
4. Authorize aplikasi
5. Selesai!

---

## 🔧 Troubleshooting

### Error: "redirect_uri_mismatch"

**Solusi:**

-   Pastikan URL di `.env` PERSIS SAMA dengan di Google Console
-   Termasuk http/https, localhost/127.0.0.1, port number

### Error: "invalid_client"

**Solusi:**

-   Client ID atau Client Secret salah
-   Copy ulang dari Google Console
-   Pastikan tidak ada spasi di awal/akhir

### Error: "access_denied"

**Solusi:**

-   User cancel authorization
-   Normal, coba lagi

### Error: "App not verified"

**Solusi:**

-   Untuk development: klik "Advanced" → "Go to Ebook Traveling (unsafe)"
-   Untuk production: harus submit app verification ke Google

---

## ⚠️ PENTING!

1. **Jangan commit file `.env` ke Git!**
    - File ini sudah ada di `.gitignore`
2. **Untuk Production:**

    - Ganti `APP_URL` ke domain real (contoh: https://ebooktraveling.com)
    - Update `GOOGLE_REDIRECT_URI` sesuai domain
    - Tambahkan URL production ke Google Console

3. **Keamanan:**
    - Jangan share Client Secret ke orang lain
    - Simpan credentials dengan aman

---

# 📝 Checklist Setup (Firebase):

### Setup Firebase:

-   [ ] Buat Firebase Project di https://console.firebase.google.com/
-   [ ] Enable Authentication → Google Sign-in method
-   [ ] Add Web App (icon `</>`)
-   [ ] Catat API Key & Project ID

### Dapatkan Credentials:

-   [ ] Buka Firebase Settings → klik link "Google Cloud Platform"
-   [ ] Di Google Cloud Console → APIs & Services → Credentials
-   [ ] Cari "Web client (auto created by Google Service)"
-   [ ] Copy Client ID & Client Secret
-   [ ] Tambahkan Authorized redirect URIs:
    -   `http://localhost:8000/login/google/callback`
    -   `http://127.0.0.1:8000/login/google/callback`
-   [ ] Save

### Update Laravel:

-   [ ] Paste credentials ke file `.env`
-   [ ] Run `php artisan config:clear`
-   [ ] Run `php artisan cache:clear`
-   [ ] Restart `php artisan serve`

### Test:

-   [ ] Buka http://localhost:8000/login
-   [ ] Klik "Sign in with Google"
-   [ ] Login dengan akun Google
-   [ ] Selesai! ✅

---

# 🆚 Perbandingan Firebase vs Google Cloud Console

| Fitur              | Firebase                 | Google Cloud Console    |
| ------------------ | ------------------------ | ----------------------- |
| **Setup**          | ⭐⭐⭐⭐⭐ Sangat mudah  | ⭐⭐⭐ Agak rumit       |
| **Dashboard**      | Modern & user-friendly   | Technical & kompleks    |
| **Auto-config**    | ✅ Banyak yang otomatis  | ❌ Harus manual semua   |
| **Dokumentasi**    | Lengkap dengan contoh    | Lengkap tapi teknikal   |
| **Gratis**         | ✅ Free tier besar       | ✅ Free tier standar    |
| **Fitur Tambahan** | Auth, DB, Storage, dll   | Hanya Cloud services    |
| **Analytics**      | ✅ Built-in              | ❌ Harus setup terpisah |
| **Recommended**    | ✅ **YA (untuk pemula)** | Untuk advance user      |

---

# 🎯 Kesimpulan

Untuk project **Ebook Traveling** ini, **gunakan Firebase** karena:

-   ✅ Setup lebih cepat (< 5 menit)
-   ✅ Dashboard lebih mudah dipahami
-   ✅ Bisa tambah fitur lain (database, storage) nanti
-   ✅ Perfect untuk development & production

---

Setelah setup selesai, coba klik tombol "Sign in with Google" lagi! 🚀
