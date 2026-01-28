# Folder Restructuring Guide

> **Last Updated:** January 27, 2026
> **Status:** ✅ COMPLETED

## Summary

This document outlines the complete restructuring of the admin panel codebase to organize files by module for better maintainability.

### What Was Changed
1. **Views** - Reorganized from flat structure to module-based hierarchy
2. **Controllers** - Moved to module folders with updated namespaces
3. **Services** - Organized by module
4. **Repositories** - Organized by module
5. **Routes** - Updated to use new controller namespaces

---

## 1. Views Structure (resources/views/admin/)

### Admin Module ✅
```
admin/
├── admin-list/        # Admin List (from: admins/)
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   ├── show.blade.php
│   └── permissions.blade.php
└── activity-logs/     # Activity Logs (from: admin-activity-logs/)
    ├── index.blade.php
    └── show.blade.php
```

### User Management Module ✅
```
user-management/
├── users/             # Users (from: users/)
├── roles/             # Roles (from: roles/)
└── activity-logs/     # User Activity Logs (from: user-activity-logs/)
```

### Ebook Management Module ✅
```
ebook-management/
├── ebooks/            # Ebooks (from: ebooks/)
├── categories/        # Categories (from: categories/)
└── cities/            # Cities (from: cities/)
```

### Blog Management Module ✅
```
blog-management/
├── blogs/             # Blogs (from: blogs/)
└── categories/        # Blog Categories (from: blog-categories/)
```

### Subscription Management Module ✅
```
subscription-management/
├── plans/                  # Subscription Plans (from: subscription-plans/)
├── manual-subscriptions/   # Manual Subscriptions (from: manual-subscriptions/)
├── active-subscribers/     # Active Subscribers (from: subscribers/)
├── history/               # Payment History (from: subscription-history/)
└── promos/                # Promos (from: promos/)
```

### Website Management Module ✅
```
website-management/
├── landing-page/      # Landing Page (from: landing-page-content/)
├── about-us/          # About Us (from: about-us-sections/)
├── banners/           # Banners (from: banners/)
├── collections/       # Collections (from: collections/)
├── contact-info/      # Contact Info (from: contact-info/)
├── site-settings/     # Site Settings (from: site-settings/)
├── faqs/             # FAQ views
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
└── policies/         # Policy views
    ├── index.blade.php
    ├── create.blade.php
    └── edit.blade.php
```

---

## 2. Controllers Structure (app/Http/Controllers/Admin/)

### AdminManagement/ ✅
```
AdminManagement/
├── AdminController.php
├── AdminActivityLogController.php
├── AdminDashboardController.php
├── AdminForgotPasswordController.php
├── AdminPermissionController.php
├── AdminPermissionMatrixController.php
├── AuthController.php
└── ProfileController.php
```

### UserManagement/ ✅
```
UserManagement/
├── UserController.php
├── RoleController.php
├── UserActivityLogController.php
├── PermissionController.php
└── RolePermissionController.php
```

### EbookManagement/ ✅
```
EbookManagement/
├── EbookController.php
├── CategoryController.php
├── CityController.php
└── EbookRatingController.php
```

### BlogManagement/ ✅
```
BlogManagement/
├── BlogController.php
└── BlogCategoryController.php
```

### SubscriptionManagement/ ✅
```
SubscriptionManagement/
├── SubscriptionController.php
├── SubscriptionPlanController.php
├── ManualSubscriptionController.php
├── SubscriberController.php
├── SubscriptionHistoryController.php
├── PromoController.php
└── PricingBenefitController.php
```

### WebsiteManagement/ ✅
```
WebsiteManagement/
├── BannerController.php
├── CollectionController.php
├── LandingPageContentController.php
├── AboutUsSectionController.php
├── ContactInfoController.php
├── SiteSettingController.php
├── FaqController.php
├── PolicyController.php
└── WebsiteManagementController.php
```

---

## 3. Services Structure (app/Services/)

### UserManagement/ ✅
```
UserManagement/
├── UserService.php
├── RoleService.php
├── PermissionService.php
├── RolePermissionService.php
└── AuthService.php
```

### EbookManagement/ ✅
```
EbookManagement/
├── EbookService.php
├── CategoryService.php
├── CityService.php
└── RatingService.php
```

### BlogManagement/ ✅
```
BlogManagement/
└── BlogService.php
```

### SubscriptionManagement/ ✅
```
SubscriptionManagement/
├── SubscriptionService.php
├── SubscriptionPlanService.php
├── SubscriberService.php
├── PromoService.php
├── PricingBenefitService.php
└── MayarService.php
```

### WebsiteManagement/ ✅
```
WebsiteManagement/
├── BannerService.php
├── CollectionService.php
├── FaqService.php
├── SettingService.php
└── PricingBannerService.php
```

### AdminManagement/ ✅
```
AdminManagement/
└── AdminPasswordResetService.php
```

---

## 4. Repositories Structure (app/Repositories/)

### UserManagement/ ✅
```
UserManagement/
├── UserRepository.php
├── RoleRepository.php
└── PermissionRepository.php
```

### EbookManagement/ ✅
```
EbookManagement/
├── EbookRepository.php
├── CategoryRepository.php
├── CityRepository.php
└── RatingRepository.php
```

### BlogManagement/ ✅
```
BlogManagement/
└── BlogRepository.php
```

### SubscriptionManagement/ ✅
```
SubscriptionManagement/
├── SubscriptionRepository.php
├── SubscriptionRepositoryInterface.php
├── SubscriptionPlanRepository.php
├── SubscriberRepository.php
├── PromoRepository.php
├── PricingBenefitRepository.php
└── SubscriptionProcessRepository.php
```

### WebsiteManagement/ ✅
```
WebsiteManagement/
├── BannerRepository.php
├── CollectionRepository.php
├── FaqRepository.php
└── PricingBannerRepository.php
```

---

## 5. View Path Mappings (All Updated ✅)

| Old View Path | New View Path | Status |
|--------------|---------------|--------|
| admin.admins.* | admin.admin.admin-list.* | ✅ |
| admin.admin-activity-logs.* | admin.admin.activity-logs.* | ✅ |
| admin.users.* | admin.user-management.users.* | ✅ |
| admin.roles.* | admin.user-management.roles.* | ✅ |
| admin.user-activity-logs.* | admin.user-management.activity-logs.* | ✅ |
| admin.ebooks.* | admin.ebook-management.ebooks.* | ✅ |
| admin.categories.* | admin.ebook-management.categories.* | ✅ |
| admin.cities.* | admin.ebook-management.cities.* | ✅ |
| admin.blogs.* | admin.blog-management.blogs.* | ✅ |
| admin.blog-categories.* | admin.blog-management.categories.* | ✅ |
| admin.subscription-plans.* | admin.subscription-management.plans.* | ✅ |
| admin.manual-subscriptions.* | admin.subscription-management.manual-subscriptions.* | ✅ |
| admin.subscribers.* | admin.subscription-management.active-subscribers.* | ✅ |
| admin.subscription-history.* | admin.subscription-management.history.* | ✅ |
| admin.promos.* | admin.subscription-management.promos.* | ✅ |
| admin.landing-page-content.* | admin.website-management.landing-page.* | ✅ |
| admin.about-us-sections.* | admin.website-management.about-us.* | ✅ |
| admin.banners.* | admin.website-management.banners.* | ✅ |
| admin.collections.* | admin.website-management.collections.* | ✅ |
| admin.contact-info.* | admin.website-management.contact-info.* | ✅ |
| admin.site-settings.* | admin.website-management.site-settings.* | ✅ |
| admin.faqs.* | admin.website-management.faqs.* | ✅ |
| admin.policies.* | admin.website-management.policies.* | ✅ |

---

## 6. Route Namespace Updates (All Updated ✅)

| Module | Old Namespace | New Namespace |
|--------|---------------|---------------|
| Admin | `\App\Http\Controllers\Admin\AdminController` | `\App\Http\Controllers\Admin\AdminManagement\AdminController` |
| User | `\App\Http\Controllers\Admin\UserController` | `\App\Http\Controllers\Admin\UserManagement\UserController` |
| Ebook | `\App\Http\Controllers\Admin\EbookController` | `\App\Http\Controllers\Admin\EbookManagement\EbookController` |
| Blog | `\App\Http\Controllers\Admin\BlogController` | `\App\Http\Controllers\Admin\BlogManagement\BlogController` |
| Subscription | `\App\Http\Controllers\Admin\SubscriptionPlanController` | `\App\Http\Controllers\Admin\SubscriptionManagement\SubscriptionPlanController` |
| Website | `\App\Http\Controllers\Admin\BannerController` | `\App\Http\Controllers\Admin\WebsiteManagement\BannerController` |

---

## 7. Cleanup Instructions

### Files to Keep (New Structure)
```
app/Http/Controllers/Admin/
├── AdminManagement/     ← NEW (Keep)
├── BlogManagement/      ← NEW (Keep)  
├── EbookManagement/     ← NEW (Keep)
├── SubscriptionManagement/ ← NEW (Keep)
├── UserManagement/      ← NEW (Keep)
├── WebsiteManagement/   ← NEW (Keep)
├── ReportController.php ← Keep (not moved)
├── LanguageController.php ← Keep (not moved)
├── NotificationController.php ← Keep (not moved)
├── OrderController.php  ← Keep (not moved)
└── DashboardSectionController.php ← Keep (not moved)
```

### Original Files to Delete (After Testing)
The original controller files in `app/Http/Controllers/Admin/` can be deleted AFTER verifying the application works correctly:
- AdminController.php, AdminActivityLogController.php, etc.
- UserController.php, RoleController.php, etc.
- EbookController.php, CategoryController.php, etc.
- BlogController.php, BlogCategoryController.php
- SubscriptionPlanController.php, ManualSubscriptionController.php, etc.
- BannerController.php, CollectionController.php, etc.

### Original Service Files to Delete (After Testing)
Files in `app/Services/` root folder that have been copied to module folders.

### Original Repository Files to Delete (After Testing)
Files in `app/Repositories/` root folder that have been copied to module folders.

### Original View Folders to Delete (After Testing)
```
resources/views/admin/
├── admins/              ← DELETE (moved to admin/admin-list/)
├── users/               ← DELETE (moved to user-management/users/)
├── roles/               ← DELETE (moved to user-management/roles/)
├── ebooks/              ← DELETE (moved to ebook-management/ebooks/)
├── categories/          ← DELETE (moved to ebook-management/categories/)
├── cities/              ← DELETE (moved to ebook-management/cities/)
├── blogs/               ← DELETE (moved to blog-management/blogs/)
├── blog-categories/     ← DELETE (moved to blog-management/categories/)
├── subscription-plans/  ← DELETE (moved to subscription-management/plans/)
├── subscribers/         ← DELETE (moved to subscription-management/active-subscribers/)
├── subscription-history/← DELETE (moved to subscription-management/history/)
├── promos/              ← DELETE (moved to subscription-management/promos/)
├── landing-page-content/← DELETE (moved to website-management/landing-page/)
├── about-us-sections/   ← DELETE (moved to website-management/about-us/)
├── banners/             ← DELETE (moved to website-management/banners/)
├── collections/         ← DELETE (moved to website-management/collections/)
├── contact-info/        ← DELETE (moved to website-management/contact-info/)
├── site-settings/       ← DELETE (moved to website-management/site-settings/)
├── faqs/                ← DELETE (moved to website-management/faqs/)
└── policies/            ← DELETE (moved to website-management/policies/)
```

---

## 8. Testing Checklist

Before deleting original files, test each module:

- [ ] **Admin Management**
  - [ ] Admin list CRUD works
  - [ ] Admin activity logs works
  - [ ] Admin permissions works

- [ ] **User Management**
  - [ ] User list CRUD works
  - [ ] Role management works
  - [ ] User activity logs works

- [ ] **Ebook Management**
  - [ ] Ebook CRUD works
  - [ ] Category management works
  - [ ] City management works

- [ ] **Blog Management**
  - [ ] Blog CRUD works
  - [ ] Blog category management works

- [ ] **Subscription Management**
  - [ ] Subscription plans CRUD works
  - [ ] Manual subscriptions works
  - [ ] Active subscribers works
  - [ ] Subscription history works
  - [ ] Promo management works

- [ ] **Website Management**
  - [ ] Landing page content works
  - [ ] About us sections works
  - [ ] Banner management works
  - [ ] Collection management works
  - [ ] Contact info works
  - [ ] Site settings works
  - [ ] FAQ management works
  - [ ] Policy management works

---

## Notes

- **Routes remain unchanged** - Route names stay the same (admin.users.index, etc.)
- **Sidebar remains unchanged** - Uses route names, not controller namespaces
- **Original files preserved** - Old files kept until testing complete
- **Incremental migration** - Test each module before moving to next

---

**Created:** January 27, 2026  
**Status:** COMPLETED ✅
