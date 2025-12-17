# Pricing Benefits Management

## Overview
Fitur untuk mengelola konten "Why Choose Our MeatMap Guides?" di halaman pricing. Admin dapat melakukan CRUD benefits dengan icon, title, dan description.

## Features
- ✅ **Create** - Tambah benefit baru dengan icon, title, description
- ✅ **Read** - Lihat semua benefits dengan preview icon
- ✅ **Update** - Edit benefit yang sudah ada
- ✅ **Delete** - Hapus benefit
- ✅ **Drag & Drop** - Atur urutan tampilan dengan drag & drop
- ✅ **Toggle Status** - Aktifkan/nonaktifkan benefit dengan switch
- ✅ **Icon Preview** - Preview icon real-time saat input

## Database Structure

### Table: `pricing_benefits`
```
- id (primary key)
- icon (string) - Icon class (ti ti-world, fas fa-globe, dll)
- title (string) - Judul benefit
- description (text) - Deskripsi benefit
- status (boolean) - Status aktif/nonaktif
- sort_order (integer) - Urutan tampilan
- created_at
- updated_at
```

## Files Created/Modified

### Controllers
- `app/Http/Controllers/Admin/PricingBenefitController.php` - CRUD controller dengan 8 methods

### Services
- `app/Services/PricingBenefitService.php` - Business logic untuk pricing benefits

### Repositories
- `app/Repositories/PricingBenefitRepository.php` - Data access layer
- `app/Repositories/Interfaces/PricingBenefitRepositoryInterface.php` - Interface

### Models
- `app/Models/PricingBenefit.php` - Eloquent model dengan casts

### Views
- `resources/views/admin/pricing-benefits/index.blade.php` - List page dengan drag & drop
- `resources/views/admin/pricing-benefits/create.blade.php` - Form tambah benefit
- `resources/views/admin/pricing-benefits/edit.blade.php` - Form edit benefit

### Routes
- `routes/modules/admin.php` - Added pricing-benefits routes:
  - GET `/admin/pricing-benefits` - Index
  - GET `/admin/pricing-benefits/create` - Create form
  - POST `/admin/pricing-benefits` - Store
  - GET `/admin/pricing-benefits/{id}/edit` - Edit form
  - PUT `/admin/pricing-benefits/{id}` - Update
  - DELETE `/admin/pricing-benefits/{id}` - Delete
  - POST `/admin/pricing-benefits/{id}/toggle-status` - Toggle status
  - POST `/admin/pricing-benefits/update-order` - Update order via drag & drop

### Navigation
- `resources/views/layouts/partials/admin/sidebar.blade.php` - Added menu "Pricing Benefits" under "Website Setting"

## Usage

### Accessing the Page
1. Login as admin
2. Sidebar → Website Setting → Pricing Benefits

### Managing Benefits

#### Add New Benefit
1. Click "Tambah Benefit Baru" button
2. Fill in:
   - **Icon Class**: Icon class (e.g., `ti ti-world`, `fas fa-globe`, `bi bi-globe`)
     - Preview akan muncul secara real-time
     - Click pada icon example untuk menggunakannya
   - **Title**: Judul benefit (singkat, max 5 kata)
   - **Description**: Deskripsi benefit (1-2 kalimat)
   - **Status**: Toggle untuk mengaktifkan/nonaktifkan
   - **Sort Order**: Urutan tampilan (0 untuk otomatis di akhir)
3. Click "Simpan Benefit"

#### Edit Benefit
1. Click icon edit pada benefit yang ingin diubah
2. Update field yang diperlukan
3. Click "Update Benefit"

#### Delete Benefit
1. Click icon delete pada benefit yang ingin dihapus
2. Confirm deletion
3. Or use "Danger Zone" section di edit page

#### Reorder Benefits
1. Di halaman index, drag & drop icon grip (⋮⋮) pada benefit
2. Urutan akan tersimpan otomatis

#### Toggle Status
1. Di halaman index, gunakan switch toggle di kolom "Status"
2. Status akan berubah otomatis tanpa reload

## Icon Libraries Support

### Tabler Icons (Primary)
Format: `ti ti-[nama]`
Example: `ti ti-world`, `ti ti-book`, `ti ti-download`
Docs: https://tabler.io/icons

### Font Awesome
Format: `fas fa-[nama]` (solid), `far fa-[nama]` (regular), `fab fa-[nama]` (brands)
Example: `fas fa-globe`, `fas fa-book`, `fas fa-heart`
Docs: https://fontawesome.com/icons

### Bootstrap Icons
Format: `bi bi-[nama]`
Example: `bi bi-globe`, `bi bi-book`, `bi bi-download`
Docs: https://icons.getbootstrap.com/

## Frontend Display
Benefits ditampilkan di halaman pricing dengan section "Why Choose Our MeatMap Guides?"

File: `resources/views/pricing.blade.php`
```php
@foreach($benefits as $benefit)
    <div class="col-md-4">
        <div class="feature-icon">
            <i class="{{ $benefit->icon }}"></i>
        </div>
        <h3>{{ $benefit->title }}</h3>
        <p>{{ $benefit->description }}</p>
    </div>
@endforeach
```

Controller method yang menyediakan data:
```php
// PricingBenefitService::getActiveBenefitsForDisplay()
// Returns benefits where status = true, ordered by sort_order
```

## Tips & Best Practices
1. **Judul**: Singkat dan jelas (max 5 kata)
2. **Deskripsi**: 1-2 kalimat saja agar tidak terlalu panjang
3. **Icon**: Pilih icon yang sesuai dengan benefit yang direpresentasikan
4. **Jumlah**: Maksimal 6 benefit untuk tampilan terbaik (3 kolom x 2 baris)
5. **Status**: Matikan benefit yang sedang dalam review atau tidak relevan
6. **Urutan**: Atur benefit terpenting di urutan teratas

## Technical Details

### Service-Repository Pattern
```
Controller → Service → Repository → Model → Database
```

### Validation Rules
```php
'icon' => 'required|string|max:100',
'title' => 'required|string|max:255',
'description' => 'required|string',
'status' => 'nullable|boolean',
'sort_order' => 'nullable|integer|min:0',
```

### API Endpoints (AJAX)
- `POST /admin/pricing-benefits/{id}/toggle-status` - Toggle status via switch
- `POST /admin/pricing-benefits/update-order` - Update order via drag & drop

Returns JSON:
```json
{
    "success": true,
    "message": "Status berhasil diperbarui"
}
```

## Dependencies
- **SortableJS 1.15.0** - For drag & drop functionality
- **jQuery** - For AJAX requests
- **SweetAlert2** - For delete confirmation
- **Toastr** - For notification messages
- **Bootstrap 5** - UI framework
- **Tabler Icons** - Primary icon library

## Future Enhancements
- [ ] Add image upload for benefit icon (alternative to icon class)
- [ ] Add color customization for icon
- [ ] Add CTA button link for each benefit
- [ ] Export/Import benefits via CSV
- [ ] Preview mode before publishing
- [ ] Version history
- [ ] Multi-language support

---

**Created:** <?= date('Y-m-d H:i:s') ?>
**Author:** Admin
**Version:** 1.0.0
