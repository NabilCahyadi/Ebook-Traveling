# 📥 Invoice Download - Troubleshooting & Testing Guide

## Perubahan yang dilakukan:

### 1. **Controller Method** (`InvoiceController.php`)
- Menggunakan `Content-Disposition: inline` supaya PDF bisa di-render dan didownload
- Menambah header `Cache-Control` dan `Pragma` untuk compatibility
- Simplified error handling

```php
return response($pdfContent, 200, [
    'Content-Type' => 'application/pdf',
    'Content-Disposition' => 'inline; filename="' . $filename . '"',
    'Pragma' => 'no-cache',
    'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
]);
```

### 2. **Button HTML** (`page-account.blade.php` lines 1560-1567)
- Menambah `download` attribute ke link HTML5
- Ini memaksa browser untuk download daripada membuka di tab baru

```blade
<a href="{{ route('user.invoice.download', $payment) }}"
    download
    class="btn btn-sm"
    title="Download Invoice - Payment: {{ $payment->payment_code }}">
    <i class="bi bi-printer mt-1"></i>
</a>
```

## Sekarang Coba:

1. **Buka page**: `https://overangry-uncriticisably-debra.ngrok-free.dev/page-account?tab=subscription`
2. **Scroll ke** Payment History table
3. **Cari payment dengan status** "Paid" (warna hijau)
4. **Klik printer icon** di kolom Action
5. **Lihat hasil**:
   - ✅ PDF langsung download dengan nama file `Invoice-[CODE]-[DATE].pdf`
   - ❌ PDF tidak download / page blank
   - ❌ Error message muncul

## Jika Masih Tidak Work:

### Test 1: Direct URL Access
Coba akses URL ini langsung di browser (ganti ID dengan payment ID yang ada):
```
https://overangry-uncriticisably-debra.ngrok-free.dev/user/invoice/1f715339-62ff-4fb2-a289-215cc1a50950/download
```

**Expected Result**: PDF langsung render atau download

### Test 2: Check Browser Console
1. Buka DevTools (F12)
2. Klik Console tab
3. Coba klik button printer lagi
4. Lihat apakah ada error message
5. Lapor apa yang terlihat

### Test 3: Network Inspection
1. Buka DevTools (F12)
2. Klik Network tab
3. Refresh page
4. Clear network tab
5. Klik button printer
6. Lihat request ke `/user/invoice/.../download`
7. Lapor:
   - Status code (200, 404, 500, dll)
   - Content-Type di response
   - Response size

## Possible Issues & Solutions:

| Problem | Kemungkinan Penyebab | Solusi |
|---------|---------------------|--------|
| Page loading tapi tidak download | Content-Disposition setting tidak cocok | Sudah diubah ke `inline` |
| Blank page / PDF render di browser | `download` attribute hilang | Sudah ditambah kembali |
| 404 error | Route tidak ditemukan | Cek route di `routes/modules/user.php` |
| 500 error | Exception di controller | Cek Laravel logs |
| ngrok issue | Tunnel blocking PDF response | Coba test dengan direct localhost jika bisa |

## File yang Sudah Diubah:

1. ✅ `app/Http/Controllers/InvoiceController.php`
   - Method: `download()`
   - Changes: Header response & error handling

2. ✅ `resources/views/page-account.blade.php`
   - Lines: 1560-1567
   - Changes: Add `download` attribute to link

## Next Steps:

📝 **Coba dulu dengan setup sekarang**
- Klik button print di Payment History
- Laporkan hasilnya:
  - ✅ PDF berhasil download?
  - ❌ Apa yang muncul?
  - 🔍 Ada error di console / network tab?

🆘 **Jika masih error**:
- Buka DevTools (F12)
- Klik Network tab
- Klik printer icon
- Lihat status code & response
- Kirim screenshot atau lapor detailnya

---
**Last Updated**: 2026-01-29
**Status**: Testing & Ready for user feedback
