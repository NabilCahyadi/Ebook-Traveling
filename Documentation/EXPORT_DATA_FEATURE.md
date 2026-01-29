# Export Data Feature - Implementation Guide

## Overview
Fitur Export Data memungkinkan admin untuk mengekspor data ke format Excel (.xlsx) untuk keperluan reporting, analisis, dan backup.

## Implemented Modules

### 1. **Users Export** ✅
- **Route**: `GET /admin/users/export`
- **File**: `app/Exports/UsersExport.php`
- **Button Location**: Users Management page header
- **Exported Data**:
  - ID, Name, Email, Phone
  - City, Gender, Status
  - Email Verified status
  - Active Subscription info
  - Registered Date, Last Login

**Filters Applied**:
- Search (name, email, phone)
- City filter
- Active/Inactive status
- Date range (from - to)

---

### 2. **Ebooks Export** ✅
- **Route**: `GET /admin/ebooks/export-data`
- **File**: `app/Exports/EbooksExport.php`
- **Button Location**: Ebooks Management page header
- **Exported Data**:
  - ID, Title, Author, Publisher, ISBN
  - Categories, Pages, File Size
  - Average Rating, Total Ratings, Total Views
  - Status, Created By, Upload Date

**Filters Applied**:
- Search (title, author, publisher)
- Category filter
- Active/Inactive status
- Date range

---

### 3. **Admins Export** ✅
- **Route**: `GET /admin/admins-export`
- **File**: `app/Exports/AdminsExport.php`
- **Button Location**: Admin Management page header
- **Exported Data**:
  - ID, Name, Email, Role
  - Permissions (formatted)
  - Status, Last Login, Created At

**Filters Applied**:
- Search (name, email)
- Active/Inactive status
- Date range

**Note**: Only Super Admin can export admin data

---

### 4. **Subscriptions Export** ✅
- **Route**: `GET /admin/manual-subscriptions/export-data`
- **File**: `app/Exports/SubscriptionsExport.php`
- **Button Location**: Manual Subscriptions page header
- **Exported Data**:
  - ID, User Name, User Email
  - Subscription Type, Status
  - Start Date, End Date, Price
  - Payment Method, Created By, Created At

**Filters Applied**:
- Search (user name, email)
- Status filter (active, expired, cancelled)
- Subscription type filter
- Date range

---

## Technical Implementation

### Package Used
```bash
composer require maatwebsite/excel
```

### Export Class Structure
All export classes implement:
- `FromCollection` - Data source
- `WithHeadings` - Column headers
- `WithMapping` - Data transformation
- `WithStyles` - Styling (bold header)
- `ShouldAutoSize` - Auto-width columns

### Export Flow
1. User clicks "Export" button
2. Current filters are passed as query parameters
3. Controller receives request and filters
4. Export class applies filters to query
5. Data is transformed and formatted
6. Excel file is generated and downloaded
7. Filename format: `{module}_{date}_{time}.xlsx`

### Example Filename
```
users_2026-01-20_143025.xlsx
ebooks_2026-01-20_143130.xlsx
admins_2026-01-20_143215.xlsx
subscriptions_2026-01-20_143300.xlsx
```

---

## Usage Instructions

### For Admin Users:

1. **Navigate to desired module** (Users, Ebooks, Admins, or Subscriptions)
2. **Apply filters** (optional):
   - Use search box
   - Select category/city/status filters
   - Set date range
3. **Click "Export" button** (green button with download icon)
4. **Excel file will download automatically**
5. **Open file** in Microsoft Excel, Google Sheets, or LibreOffice

### Benefits:
- ✅ **Offline Analysis**: Work with data without internet
- ✅ **Advanced Filtering**: Use Excel's powerful filter/sort features
- ✅ **Data Backup**: Regular exports serve as backup
- ✅ **Reports**: Create custom reports and charts
- ✅ **Data Sharing**: Share data with stakeholders securely

---

## Translation Support

Export button supports bilingual (EN/ID):
- **English**: "Export"
- **Indonesian**: "Ekspor"

Key used: `__('admin.common.export')`

---

## Permissions

Export functionality respects existing view permissions:
- **Users**: `users.view` permission required
- **Ebooks**: `ebooks.view` permission required
- **Admins**: Super Admin only
- **Subscriptions**: `subscriptions.view` permission required

---

## File Location Reference

### Export Classes:
```
app/Exports/
├── UsersExport.php
├── EbooksExport.php
├── AdminsExport.php
└── SubscriptionsExport.php
```

### Controllers Updated:
```
app/Http/Controllers/Admin/
├── UserController.php (added export method)
├── EbookController.php (added export method)
├── AdminController.php (added export method)
└── ManualSubscriptionController.php (added export method)
```

### Routes:
```
routes/modules/admin.php
```

### Views Updated:
```
resources/views/admin/
├── users/index.blade.php
├── ebooks/index.blade.php
├── admins/index.blade.php
└── manual-subscriptions/index.blade.php
```

---

## Future Enhancements (Optional)

Potential improvements:
1. **Export to CSV** format option
2. **Export to PDF** for printable reports
3. **Scheduled Exports** (daily/weekly automated exports)
4. **Custom Column Selection** (choose which columns to export)
5. **Email Export** (send exported file via email)
6. **Export Templates** (save filter presets)
7. **Bulk Export** (export multiple modules at once)

---

## Troubleshooting

**Issue**: Export button not visible
- **Solution**: Check user permissions

**Issue**: Export returns empty file
- **Solution**: Check if there's data matching the applied filters

**Issue**: Excel file corrupted
- **Solution**: Ensure PHP zip extension is enabled

**Issue**: Memory limit error on large exports
- **Solution**: Increase PHP memory_limit in php.ini

---

## Summary

Fitur Export Data telah berhasil diimplementasikan untuk 4 modul utama:
✅ Users Management
✅ Ebooks Management  
✅ Admin Management
✅ Subscriptions Management

Semua data dapat diekspor dengan filter yang diterapkan, dan file akan otomatis terdownload dalam format Excel (.xlsx) dengan nama file yang mencantumkan tanggal dan waktu export.
