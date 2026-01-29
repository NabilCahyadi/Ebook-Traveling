# FAQ Pricing CRUD - Permission Setup Guide

## Permissions Required

Untuk menggunakan fitur FAQ Pricing Management, admin perlu menambahkan permission berikut ke database:

### Daftar Permission:

1. **website.faqs-pricing.view** - View FAQ Pricing list
2. **website.faqs-pricing.create** - Create new FAQ Pricing
3. **website.faqs-pricing.edit** - Edit FAQ Pricing
4. **website.faqs-pricing.delete** - Delete FAQ Pricing

## Cara Menambahkan Permission

### Opsi 1: Manual Insert ke Database

```sql
-- Insert permissions ke tabel admin_permissions
INSERT INTO admin_permissions (name, display_name, description, created_at, updated_at) VALUES
('website.faqs-pricing.view', 'View FAQ Pricing', 'Can view FAQ pricing list', NOW(), NOW()),
('website.faqs-pricing.create', 'Create FAQ Pricing', 'Can create new FAQ pricing', NOW(), NOW()),
('website.faqs-pricing.edit', 'Edit FAQ Pricing', 'Can edit FAQ pricing', NOW(), NOW()),
('website.faqs-pricing.delete', 'Delete FAQ Pricing', 'Can delete FAQ pricing', NOW(), NOW());
```

### Opsi 2: Via Tinker (Recommended)

```bash
php artisan tinker
```

```php
use App\Models\AdminPermission;

// Create FAQ Pricing permissions
AdminPermission::create([
    'name' => 'website.faqs-pricing.view',
    'display_name' => 'View FAQ Pricing',
    'description' => 'Can view FAQ pricing list'
]);

AdminPermission::create([
    'name' => 'website.faqs-pricing.create',
    'display_name' => 'Create FAQ Pricing',
    'description' => 'Can create new FAQ pricing'
]);

AdminPermission::create([
    'name' => 'website.faqs-pricing.edit',
    'display_name' => 'Edit FAQ Pricing',
    'description' => 'Can edit FAQ pricing'
]);

AdminPermission::create([
    'name' => 'website.faqs-pricing.delete',
    'display_name' => 'Delete FAQ Pricing',
    'description' => 'Can delete FAQ pricing'
]);
```

## Routes Created

### View Routes:
- GET `/admin/faqs/pricing` - List all pricing FAQs

### Create Routes:
- GET `/admin/faqs/pricing/create` - Show create form
- POST `/admin/faqs/pricing` - Store new FAQ

### Edit Routes:
- GET `/admin/faqs/pricing/{id}/edit` - Show edit form
- PUT `/admin/faqs/pricing/{id}` - Update FAQ
- POST `/admin/faqs/pricing/{id}/toggle-status` - Toggle active status
- POST `/admin/faqs/pricing/update-order` - Update FAQ order

### Delete Routes:
- DELETE `/admin/faqs/pricing/{id}` - Delete single FAQ
- POST `/admin/faqs/pricing/bulk-delete` - Bulk delete FAQs

## Features Implemented

1. ✅ **CRUD Operations** - Create, Read, Update, Delete
2. ✅ **Search Functionality** - Search by question or answer
3. ✅ **Sorting/Ordering** - Drag & drop to reorder FAQs
4. ✅ **Toggle Status** - Quick enable/disable FAQs
5. ✅ **Bulk Delete** - Delete multiple FAQs at once
6. ✅ **Permission-based Access** - Proper permission checks
7. ✅ **Responsive Design** - Mobile-friendly interface

## Navigation Structure

```
Web Setting (Website Management)
└── FAQ
    └── Pricing
```

## Files Created/Modified

### New Files:
1. `app/Http/Controllers/Admin/FaqController.php`
2. `resources/views/admin/faqs/pricing/index.blade.php`
3. `resources/views/admin/faqs/pricing/create.blade.php`
4. `resources/views/admin/faqs/pricing/edit.blade.php`

### Modified Files:
1. `app/Repositories/Interfaces/FaqRepositoryInterface.php`
2. `app/Repositories/FaqRepository.php`
3. `routes/modules/admin.php`
4. `resources/views/layouts/partials/admin/sidebar.blade.php`

## Testing Steps

1. **Add Permissions** - Run SQL or Tinker commands above
2. **Assign to Admin** - Assign permissions to your admin role
3. **Access Menu** - Navigate to Web Setting > FAQ > Pricing
4. **Test CRUD** - Create, edit, delete, and reorder FAQs
5. **Test on Frontend** - Check `/pricing` page to see FAQs display

## Notes

- FAQ category is automatically set to "pricing"
- Order index determines display order (lower numbers first)
- Only active FAQs (is_active = true) are displayed on frontend
- Drag & drop reordering works on index page
- SortableJS library is used for drag & drop functionality
