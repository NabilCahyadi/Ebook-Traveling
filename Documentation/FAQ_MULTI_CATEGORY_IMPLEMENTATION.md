# FAQ Multi-Category CRUD Implementation

## Overview
Successfully implemented CRUD functionality for 6 FAQ categories in the admin panel with dropdown navigation similar to FAQ > Pricing.

## Categories Implemented

1. **Pricing** (pricing)
2. **Subscription & Membership** (subscription)
3. **Payments & Transactions** (payment)
4. **eBook Access & Reading** (ebook-access)
5. **Account & Technical Support** (support)
6. **Content & Features** (content)

## Files Created

### 1. Migration
- `database/migrations/2026_01_15_000002_add_faq_all_categories_permissions.php`
  - Creates 24 permissions (4 per category: view, create, edit, delete)
  - Module: "Website Management"
  - Sub-module: "FAQ"

### 2. Views
- `resources/views/admin/faqs/index.blade.php` - Generic list view with drag-drop ordering
- `resources/views/admin/faqs/create.blade.php` - Generic create form
- `resources/views/admin/faqs/edit.blade.php` - Generic edit form

## Files Modified

### 1. Controller
- `app/Http/Controllers/Admin/FaqController.php`
  - Implemented dynamic method handling using PHP's `__call()` magic method
  - All categories share the same logic with different parameters
  - Methods: index, create, store, edit, update, destroy, toggleStatus, updateOrder, bulkDelete

### 2. Routes
- `routes/modules/admin.php`
  - Added dynamic route generation for all 6 categories
  - Total: 54 routes (9 routes × 6 categories)
  - Each category has its own permission-based middleware

### 3. Sidebar Navigation
- `resources/views/layouts/partials/admin/sidebar.blade.php`
  - Added all 6 FAQ categories to dropdown menu
  - Updated permission checks for Website Management section
  - Added conditional display based on user permissions

## Features Implemented

### For Each FAQ Category:
1. ✅ List view with search and pagination
2. ✅ Drag & drop ordering with SortableJS
3. ✅ Toggle active/inactive status (AJAX)
4. ✅ Create new FAQ
5. ✅ Edit existing FAQ
6. ✅ Delete FAQ (AJAX with confirmation)
7. ✅ Bulk delete (ready, UI can be added)
8. ✅ Permission-based access control
9. ✅ Responsive design
10. ✅ Dropdown actions menu (3-dot vertical icon)

## Database Structure

### Permissions Created (24 total)
Each category has 4 permissions:
- `website.faqs-{category}.view` - View FAQ list
- `website.faqs-{category}.create` - Create new FAQ
- `website.faqs-{category}.edit` - Edit FAQ & change order/status
- `website.faqs-{category}.delete` - Delete FAQ

### FAQs Table
Uses existing `faqs` table with columns:
- `id` (UUID)
- `question` (string, max 500)
- `answer` (text)
- `category` (string: pricing, subscription, payment, ebook-access, support, content)
- `order_index` (integer)
- `is_active` (boolean)
- `created_at`, `updated_at`, `deleted_at`

## Routes Summary

### Pattern for Each Category
```
GET    /admin/faqs/{category}                    - List
POST   /admin/faqs/{category}                    - Store
GET    /admin/faqs/{category}/create             - Create form
GET    /admin/faqs/{category}/{id}/edit          - Edit form
PUT    /admin/faqs/{category}/{id}               - Update
DELETE /admin/faqs/{category}/{id}               - Delete
POST   /admin/faqs/{category}/{id}/toggle-status - Toggle status
POST   /admin/faqs/{category}/update-order       - Update order
POST   /admin/faqs/{category}/bulk-delete        - Bulk delete
```

### Route Names
- `admin.faqs.{category}.index`
- `admin.faqs.{category}.create`
- `admin.faqs.{category}.store`
- `admin.faqs.{category}.edit`
- `admin.faqs.{category}.update`
- `admin.faqs.{category}.destroy`
- `admin.faqs.{category}.toggle-status`
- `admin.faqs.{category}.update-order`
- `admin.faqs.{category}.bulk-delete`

## Controller Logic

### Dynamic Method Handling
The FaqController uses PHP's magic `__call()` method to dynamically route calls like:
- `indexPricing()` → `indexCategory('pricing')`
- `createSubscription()` → `createCategory('subscription')`
- `updatePayment()` → `updateCategory('payment')`
- etc.

### Category Mapping
```php
protected $categoryMap = [
    'pricing' => 'pricing',
    'subscription' => 'subscription',
    'payment' => 'payment',
    'ebook-access' => 'ebook-access',
    'support' => 'support',
    'content' => 'content'
];

protected $categoryNames = [
    'pricing' => 'Pricing',
    'subscription' => 'Subscription & Membership',
    'payment' => 'Payments & Transactions',
    'ebook-access' => 'eBook Access & Reading',
    'support' => 'Account & Technical Support',
    'content' => 'Content & Features'
];
```

## Usage Instructions

### 1. Assign Permissions
Go to Admin Panel > Admin Management > Admin List > Edit Admin > Permissions
- Enable FAQ permissions for each category as needed
- Or assign to a role in Role Management

### 2. Access FAQ Management
Navigate to: **Web Setting > FAQ > [Category Name]**

### 3. Manage FAQs
- **Create**: Click "Add New FAQ" button
- **Edit**: Click 3-dot menu > Edit
- **Delete**: Click 3-dot menu > Delete
- **Reorder**: Drag the grip icon to reorder
- **Toggle Status**: Switch the toggle to activate/deactivate

### 4. Testing
Access each category at:
- `/admin/faqs/pricing`
- `/admin/faqs/subscription`
- `/admin/faqs/payment`
- `/admin/faqs/ebook-access`
- `/admin/faqs/support`
- `/admin/faqs/content`

## Frontend Display

### To Display FAQs on Frontend
Use the FaqRepository to fetch FAQs by category:

```php
// Example in a controller
use App\Repositories\Interfaces\FaqRepositoryInterface;

public function pricing(FaqRepositoryInterface $faqRepo)
{
    $faqs = $faqRepo->getActiveByCategory('pricing');
    return view('pricing', compact('faqs'));
}
```

## Technical Highlights

### 1. DRY Principle
- Single set of views for all categories
- Dynamic variables: `$categoryName`, `$categorySlug`
- Reusable controller methods

### 2. Security
- Permission-based middleware on all routes
- CSRF protection on all forms
- SQL injection protection via Eloquent ORM

### 3. UX Features
- SortableJS for smooth drag-drop
- AJAX for instant feedback (status toggle, delete)
- Toast notifications for actions
- Responsive design for mobile

### 4. Maintainability
- Adding new categories is straightforward:
  1. Add to migration
  2. Add to `$categoryMap` in controller
  3. Add to sidebar menu
  4. Routes auto-generate

## Verification

### Routes Created: ✅ 54 routes
```bash
php artisan route:list --path=faqs
```

### Permissions Created: ✅ 24 permissions
```bash
php artisan tinker --execute="var_dump(App\Models\AdminPermission::where('name', 'like', 'website.faqs-%')->count());"
# Output: int(24)
```

### No Syntax Errors: ✅
All files pass validation without errors.

## Next Steps (Optional)

1. **Seed Sample Data**: Create seeder for each category with sample FAQs
2. **Frontend Integration**: Display FAQs on respective pages
3. **Search Enhancement**: Add full-text search
4. **Export Feature**: Add CSV/Excel export for FAQs
5. **Import Feature**: Bulk import FAQs from CSV

## Rollback

If needed, rollback with:
```bash
php artisan migrate:rollback --step=1
```

This will remove all 24 FAQ permissions from the database.

---

**Implementation Date**: January 15, 2026  
**Status**: ✅ Completed & Tested  
**Total Routes**: 54  
**Total Permissions**: 24  
**Categories**: 6
