# Entity Relationship Diagram (ERD)

# Database: ebook_traveling

```
┌─────────────────┐
│     ROLES       │
├─────────────────┤
│ id (PK)         │
│ name            │
│ created_at      │
│ updated_at      │
└────────┬────────┘
         │
         │ 1:N
         │
┌────────▼────────┐          ┌──────────────────┐
│ ROLE_PERMISSIONS│          │ EBOOK_CATEGORIES │
├─────────────────┤          ├──────────────────┤
│ id (PK)         │          │ id (PK)          │
│ role_id (FK)    │          │ name             │
│ permission_key  │          │ slug (UNIQUE)    │
│ created_at      │          │ created_at       │
│ updated_at      │          │ updated_at       │
└─────────────────┘          └────────┬─────────┘
                                      │
                                      │ 1:N
         ┌─────────────────┐          │
         │     USERS       │          │
         ├─────────────────┤          │
         │ id (PK)         │◄─────┐   │
         │ name            │      │   │
         │ email (UNIQUE)  │      │   │
         │ password        │      │   │
         │ google_id       │      │   │
         │ phone           │      │   │
         │ avatar          │      │   │
         │ status          │      │   │
         │ role_id (FK)    │──────┘   │
         │ language_pref   │          │
         │ created_at      │          │
         │ updated_at      │          │
         └────┬────┬───┬───┘          │
              │    │   │              │
              │    │   │              │
      ┌───────┘    │   └────────┐     │
      │ 1:N        │ 1:N        │ 1:N │
      │            │            │     │
┌─────▼──────┐ ┌──▼──────┐ ┌───▼─────▼────┐    ┌──────────┐
│  RATINGS   │ │  BLOGS  │ │   EBOOKS     │    │  CITIES  │
├────────────┤ ├─────────┤ ├──────────────┤    ├──────────┤
│ id (PK)    │ │ id (PK) │ │ id (PK)      │    │ id (PK)  │
│ user_id(FK)│ │cat_id(FK│ │category_id(FK├────┤ name     │
│ ebook_id(FK├─┤author(FK│ │city_id (FK)  │◄───┤ country  │
│ rating     │ │ title   │ │ title        │    │created_at│
│ review     │ │ slug    │ │ slug (UNIQUE)│    │updated_at│
│ created_at │ │cover_img│ │ description  │    └──────────┘
│ updated_at │ │short_des│ │ cover_image  │
└────────────┘ │ content │ │ file_url     │
               │published│ │ preview_cont │
               │created_a│ │ is_active    │
               │updated_a│ │ created_at   │
               └─────────┘ │ updated_at   │
                           └──┬───┬───────┘
                              │   │
                   ┌──────────┘   └──────────┐
                   │ 1:N              1:N    │
                   │                         │
         ┌─────────▼──────────┐    ┌─────────▼──────────────┐
         │  EBOOK_SECTIONS    │    │ USER_EBOOK_ACCESS      │
         ├────────────────────┤    ├────────────────────────┤
         │ id (PK)            │    │ id (PK)                │
         │ ebook_id (FK)      │    │ user_id (FK)           │
         │ title              │    │ ebook_id (FK)          │
         │ content            │    │ source                 │
         │ order_number       │    │ expire_at              │
         │ created_at         │    │ created_at             │
         │ updated_at         │    │ updated_at             │
         └────────────────────┘    └────────────────────────┘


┌─────────────────────┐
│ SUBSCRIPTION_PLANS  │
├─────────────────────┤
│ id (PK)             │
│ name                │
│ price               │
│ duration_day        │
│ created_at          │
│ updated_at          │
└──────────┬──────────┘
           │
           │ 1:N
           │
┌──────────▼──────────┐          ┌──────────────────┐
│   SUBSCRIPTIONS     │          │    PAYMENTS      │
├─────────────────────┤          ├──────────────────┤
│ id (PK)             │◄────────┤│ id (PK)          │
│ user_id (FK)        │◄───┐    ││ user_id (FK)     │
│ plan_id (FK)        │    │    ││ subscription_id  │
│ start_date          │    │    ││ amount           │
│ end_date            │    │    ││ payment_method   │
│ status              │    │    ││ receipt_url      │
│ created_at          │    │    ││ status           │
│ updated_at          │    │    ││ created_at       │
└─────────────────────┘    │    ││ updated_at       │
                           │    │└──────────────────┘
                           │    │
                           └────┘ (from USERS table)


┌───────────────────┐
│ BLOG_CATEGORIES   │
├───────────────────┤
│ id (PK)           │
│ name              │
│ slug (UNIQUE)     │
│ created_at        │
│ updated_at        │
└─────────┬─────────┘
          │
          │ 1:N
          │
          └──────► (connects to BLOGS)


┌─────────────────┐
│   USER_LOGS     │
├─────────────────┤
│ id (PK)         │
│ user_id (FK)    │◄──── (from USERS table)
│ action          │
│ description     │
│ ip_address      │
│ user_agent      │
│ created_at      │
│ updated_at      │
└─────────────────┘


LEGEND:
PK  = Primary Key
FK  = Foreign Key
1:N = One to Many Relationship
──► = Relationship Direction
```

## Cascade Delete Rules

### ON DELETE CASCADE:

-   role_permissions → roles
-   ebook_categories → ebooks
-   cities → ebooks
-   ebooks → ebook_sections
-   ebooks → ratings
-   ebooks → user_ebook_access
-   users → ratings
-   users → user_ebook_access
-   users → subscriptions
-   users → payments
-   users → user_logs
-   subscription_plans → subscriptions
-   blog_categories → blogs
-   users (as author) → blogs

### ON DELETE SET NULL:

-   payments → subscriptions (nullable)
-   users → role_id (nullable)

## Unique Constraints

-   users.email
-   ebook_categories.slug
-   ebooks.slug
-   blog_categories.slug
-   blogs.slug
-   ratings (user_id + ebook_id combination)
