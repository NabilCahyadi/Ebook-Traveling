# Dynamic Frontend Permission System

Sistem permission dinamis untuk mengontrol akses menu navigasi dan fitur di frontend user berdasarkan role.

## Cara Kerja

1. **Admin** mengatur permission untuk setiap role (member, creator, dll) melalui panel admin
2. **Permission** mengontrol:
   - Menu navigasi yang terlihat
   - Akses ke halaman/fitur
   - UI elements yang bisa digunakan
3. Jika user tidak punya permission, menu/fitur **otomatis hilang** dari tampilan mereka

## Permission Modules Frontend

### 1. Navigation & Pages
- `access_home` - Akses Home Page
- `access_destinations` - Akses Destinations Page  
- `access_blog` - Akses Blog Page
- `access_pricing` - Akses Pricing Page
- `access_promo` - Akses Promo Page

### 2. Ebook Features
- `view_ebook_library` - Browse Ebook Library
- `read_ebook` - Read Ebooks Online
- `download_ebook` - Download Ebooks
- `rate_ebook` - Rate & Review Ebooks
- `bookmark_ebook` - Bookmark Ebooks

### 3. Creator Features
- `upload_ebook` - Upload New Ebook
- `edit_own_ebook` - Edit Own Ebooks
- `delete_own_ebook` - Delete Own Ebooks
- `view_ebook_analytics` - View Analytics

### 4. Shopping & Payment
- `add_to_cart` - Add to Cart
- `checkout` - Checkout & Payment
- `use_promo_code` - Use Promo Codes
- `view_order_history` - View Orders

### 5. Subscription Features
- `subscribe` - Subscribe to Plans
- `manage_subscription` - Manage Subscription
- `cancel_subscription` - Cancel Subscription
- `upgrade_subscription` - Upgrade Plan

### 6. Profile & Settings
- `edit_profile` - Edit Profile
- `change_password` - Change Password
- `delete_account` - Delete Account
- `view_notifications` - View Notifications

### 7. Social Features
- `comment_blog` - Comment on Blogs
- `share_content` - Share Content
- `follow_creators` - Follow Creators

### 8. Collections
- `view_collections` - View Collections
- `create_collection` - Create Collections
- `add_to_collection` - Add to Collections

## Cara Implementasi

### 1. Di Blade Template (Navbar/Menu)

```blade
{{-- Check permission untuk show/hide menu --}}
@if(hasPermission('access_home'))
    <li><a href="{{ route('home') }}">Home</a></li>
@endif

@if(hasPermission('access_blog'))
    <li><a href="{{ route('blog.index') }}">Blog</a></li>
@endif

{{-- Untuk guest user (tidak login), tampilkan semua --}}
@if(!auth()->check() || hasPermission('view_ebook_library'))
    <li><a href="{{ route('shop.index') }}">Shop</a></li>
@endif
```

### 2. Di Blade Template (Buttons/Features)

```blade
{{-- Hide/show button berdasarkan permission --}}
@if(hasPermission('add_to_cart'))
    <button class="btn-add-cart">Add to Cart</button>
@endif

@if(hasPermission('download_ebook'))
    <a href="{{ route('ebook.download', $ebook) }}" class="btn-download">
        <i class="ti ti-download"></i> Download
    </a>
@endif

@if(hasPermission('rate_ebook'))
    <div class="rating-section">
        <!-- Rating form -->
    </div>
@endif
```

### 3. Di Controller (Protect Routes)

**Option A: Middleware di Route**
```php
// routes/web.php
Route::middleware(['auth', 'permission:access_home'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
});

Route::middleware(['auth', 'permission:view_ebook_library'])->group(function () {
    Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
});

Route::middleware(['auth', 'permission:upload_ebook'])->group(function () {
    Route::post('/creator/ebook', [CreatorController::class, 'store'])->name('creator.ebook.store');
});
```

**Option B: Check di Controller**
```php
public function index()
{
    // Check permission
    if (!hasPermission('access_home')) {
        abort(403, 'You do not have permission to access this page.');
    }
    
    return view('home');
}
```

### 4. Di Controller dengan Dynamic Content

```php
public function dashboard()
{
    $data = [];
    
    // Show different content based on permissions
    if (hasPermission('view_ebook_analytics')) {
        $data['analytics'] = $this->getAnalytics();
    }
    
    if (hasPermission('upload_ebook')) {
        $data['uploadForm'] = true;
    }
    
    return view('dashboard', $data);
}
```

## Helper Functions

### hasPermission($permission)
Check apakah user punya permission tertentu.

```php
// Contoh penggunaan
if (hasPermission('access_home')) {
    // User bisa akses home
}
```

### canAccess($permission)
Alias untuk hasPermission.

```php
// Contoh penggunaan  
if (canAccess('download_ebook')) {
    // User bisa download ebook
}
```

## Mengatur Permission via Admin Panel

1. Login sebagai **Admin**
2. Buka menu **User Management → Role Permissions**
3. Pilih role yang ingin diatur (Member, Creator, dll)
4. Klik **Configure**
5. Centang permission yang ingin diberikan per module
6. Gunakan **Select All** per module untuk cepat
7. Klik **Save Permissions**

## Contoh Use Case

### Use Case 1: Member Tidak Boleh Upload Ebook

**Admin Action:**
- Buka Role Permissions → Member
- Di module "Creator Features", **jangan centang** `upload_ebook`
- Save

**Result:**
- Member tidak melihat menu/button "Upload Ebook"
- Jika member coba akses route upload, dapat error 403

### Use Case 2: Creator Tidak Boleh Akses Home Page

**Admin Action:**
- Buka Role Permissions → Creator
- Di module "Navigation & Pages", **jangan centang** `access_home`
- Save

**Result:**
- Di navbar Creator, menu "Home" **hilang**
- Jika Creator coba akses `/`, dapat error 403

### Use Case 3: Premium Member Bisa Download, Free Member Tidak

**Admin Action:**
1. Buka Role Permissions → Free Member
   - Di "Ebook Features", **jangan centang** `download_ebook`
   
2. Buka Role Permissions → Premium Member
   - Di "Ebook Features", **centang** `download_ebook`
   
**Result:**
- Free Member: Button download **tidak muncul**
- Premium Member: Button download **muncul** dan bisa digunakan

## Notes

- **Admin** role selalu punya akses ke semua permission (bypass check)
- **Guest** user (belum login) sebaiknya bisa akses basic pages (Home, Blog, Shop)
- Permission bersifat **hide/show**, bukan disable
- Gunakan middleware untuk **security** di route level
- Gunakan helper function untuk **UI** di blade level

## Database

Permissions disimpan di:
- Table `permissions` - Daftar semua permission
- Table `role_permission` - Pivot table role & permission
- Relationship: Role belongsToMany Permission

## Testing

Test permission system:
1. Create 2 role berbeda (misal Member & Creator)
2. Set permission berbeda untuk masing-masing
3. Login sebagai Member → check navbar
4. Login sebagai Creator → check navbar
5. Pastikan menu yang tidak ada permission **tidak muncul**
