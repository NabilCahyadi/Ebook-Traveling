# Database Structure - Ebook Traveling

## Tables Overview

### 1. **roles**

-   `id` - Primary key
-   `name` - Role name (admin, user, etc.)
-   `timestamps`

### 2. **role_permissions**

-   `id` - Primary key
-   `role_id` - Foreign key to roles
-   `permission_key` - Permission identifier
-   `timestamps`

### 3. **users** (Extended Laravel default)

-   `id` - Primary key
-   `name` - User name
-   `email` - User email (unique)
-   `password` - Hashed password
-   `google_id` - Google OAuth ID (nullable)
-   `phone` - Phone number (nullable)
-   `avatar` - Avatar image path (nullable)
-   `status` - User status (active, inactive, suspended)
-   `role_id` - Foreign key to roles
-   `language_pref` - Language preference (default: 'en')
-   `timestamps`

### 4. **ebook_categories**

-   `id` - Primary key
-   `name` - Category name
-   `slug` - URL-friendly slug (unique)
-   `timestamps`

### 5. **cities**

-   `id` - Primary key
-   `name` - City name
-   `country` - Country name
-   `timestamps`

### 6. **ebooks**

-   `id` - Primary key
-   `category_id` - Foreign key to ebook_categories
-   `city_id` - Foreign key to cities
-   `title` - Ebook title
-   `slug` - URL-friendly slug (unique)
-   `description` - Ebook description (nullable)
-   `cover_image` - Cover image path (nullable)
-   `file_url` - PDF/Ebook file URL (nullable)
-   `preview_content` - Preview text content (nullable)
-   `is_active` - Active status (boolean, default: true)
-   `timestamps`

### 7. **ebook_sections**

-   `id` - Primary key
-   `ebook_id` - Foreign key to ebooks
-   `title` - Section title
-   `content` - Section content
-   `order_number` - Display order (default: 0)
-   `timestamps`

### 8. **ratings**

-   `id` - Primary key
-   `user_id` - Foreign key to users
-   `ebook_id` - Foreign key to ebooks
-   `rating` - Rating value (integer)
-   `review` - Review text (nullable)
-   `timestamps`
-   **Unique constraint**: `user_id` + `ebook_id` (one rating per user per ebook)

### 9. **user_ebook_access**

-   `id` - Primary key
-   `user_id` - Foreign key to users
-   `ebook_id` - Foreign key to ebooks
-   `source` - Access source (subscription, purchase, free) (nullable)
-   `expire_at` - Access expiration date (nullable)
-   `timestamps`

### 10. **subscription_plans**

-   `id` - Primary key
-   `name` - Plan name
-   `price` - Plan price (decimal 10,2)
-   `duration_day` - Duration in days (integer)
-   `timestamps`

### 11. **subscriptions**

-   `id` - Primary key
-   `user_id` - Foreign key to users
-   `plan_id` - Foreign key to subscription_plans
-   `start_date` - Subscription start date
-   `end_date` - Subscription end date
-   `status` - Status (active, expired, cancelled)
-   `timestamps`

### 12. **payments**

-   `id` - Primary key
-   `user_id` - Foreign key to users
-   `subscription_id` - Foreign key to subscriptions (nullable)
-   `amount` - Payment amount (decimal 10,2)
-   `payment_method` - Payment method
-   `receipt_url` - Receipt URL (nullable)
-   `status` - Payment status (pending, completed, failed)
-   `timestamps`

### 13. **blog_categories**

-   `id` - Primary key
-   `name` - Category name
-   `slug` - URL-friendly slug (unique)
-   `timestamps`

### 14. **blogs**

-   `id` - Primary key
-   `category_id` - Foreign key to blog_categories
-   `title` - Blog title
-   `slug` - URL-friendly slug (unique)
-   `cover_image` - Cover image path (nullable)
-   `short_description` - Short description (nullable)
-   `content` - Full blog content (longText)
-   `author_id` - Foreign key to users
-   `published_at` - Publication date (nullable)
-   `timestamps`

### 15. **user_logs**

-   `id` - Primary key
-   `user_id` - Foreign key to users
-   `action` - Action performed
-   `description` - Action description (nullable)
-   `ip_address` - User IP address (nullable)
-   `user_agent` - User agent string (nullable)
-   `timestamps`

## Relationships

### Users

-   Has many: ratings, user_ebook_access, subscriptions, payments, blogs (as author), user_logs
-   Belongs to: role

### Ebooks

-   Belongs to: ebook_category, city
-   Has many: ebook_sections, ratings, user_ebook_access

### Subscriptions

-   Belongs to: user, subscription_plan
-   Has many: payments

### Blogs

-   Belongs to: blog_category, user (as author)

## Migration Order

1. roles
2. role_permissions
3. ebook_categories
4. cities
5. ebooks
6. ebook_sections
7. ratings
8. user_ebook_access
9. subscription_plans
10. subscriptions
11. payments
12. blog_categories
13. blogs
14. user_logs
15. add_additional_fields_to_users_table

## Notes

-   All foreign keys have cascade delete except:
    -   payments.subscription_id (set null)
    -   users.role_id (set null)
-   Unique constraints on slugs for SEO-friendly URLs
-   Timestamps included on all tables for audit trail
