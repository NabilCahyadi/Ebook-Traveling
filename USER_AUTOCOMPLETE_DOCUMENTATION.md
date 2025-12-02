# User Autocomplete Feature Documentation

## Overview
Fitur autocomplete untuk pencarian user di halaman Create Manual Subscription. User dapat mengetik nama atau email, dan sistem akan menampilkan suggestions di bawah input field.

## Features

### 1. **Real-time Search**
- Pencarian dimulai setelah user mengetik minimal 2 karakter
- Menggunakan debounce 300ms untuk mengurangi request ke server
- Loading indicator ditampilkan saat melakukan pencarian

### 2. **Suggestions Dropdown**
- Muncul di bawah input field
- Menampilkan avatar, nama, dan email user
- Hover effect dengan smooth animation
- Click untuk memilih user

### 3. **User Experience**
- Input tetap menampilkan teks yang diketik user
- Suggestions muncul di bawah input
- Setelah memilih, input akan terisi dengan format: "Nama (email)"
- Preview di sidebar otomatis terupdate

## Implementation Details

### Backend (Controller)

**File**: `app/Http/Controllers/Admin/ManualSubscriptionController.php`

```php
public function searchUsers(Request $request)
{
    $search = $request->get('q', '');
    
    if (strlen($search) < 2) {
        return response()->json([]);
    }

    $users = \App\Models\User::where('name', 'like', "%{$search}%")
        ->orWhere('email', 'like', "%{$search}%")
        ->limit(10)
        ->get(['id', 'name', 'email']);

    return response()->json($users);
}
```

### Route

**File**: `routes/modules/admin.php`

```php
Route::get('manual-subscriptions/search-users', 
    [\App\Http\Controllers\Admin\ManualSubscriptionController::class, 'searchUsers'])
    ->name('manual-subscriptions.search-users');
```

### Frontend (View)

**File**: `resources/views/admin/manual-subscriptions/create.blade.php`

#### HTML Structure:
```html
<!-- Hidden input for actual user_id -->
<input type="hidden" id="user_id" name="user_id">

<!-- Search input -->
<input type="text" 
       class="form-control" 
       id="user_search" 
       placeholder="Type to search user by name or email..."
       autocomplete="off">

<!-- Loading indicator -->
<div id="search-loading" style="display: none;">
    <div class="spinner-border spinner-border-sm"></div>
</div>

<!-- Suggestions dropdown -->
<div id="user-suggestions" class="list-group"></div>
```

#### JavaScript Features:

1. **Debounce Search**: Menunggu 300ms setelah user berhenti mengetik
2. **AJAX Request**: Fetch API untuk mendapatkan data user
3. **Display Suggestions**: Render hasil pencarian dengan avatar
4. **Select User**: Click handler untuk memilih user
5. **Clear on Edit**: Reset selection jika user mengedit input
6. **Click Outside**: Hide suggestions saat click di luar

### CSS Styling

```css
#user-suggestions {
    border-radius: 8px;
    margin-top: 4px;
    border: 1px solid #d9dee3;
}

#user-suggestions .list-group-item:hover {
    background-color: #f8f9fa;
    transform: translateX(4px);
}
```

## User Flow

1. User mengetik di input field "Select User"
2. Setelah 2+ karakter, loading indicator muncul
3. AJAX request dikirim ke server (dengan debounce 300ms)
4. Server mengembalikan max 10 user yang cocok
5. Suggestions ditampilkan di bawah input dengan:
   - Avatar (initial huruf pertama nama)
   - Nama user (bold)
   - Email (muted)
6. User click salah satu suggestion
7. Input terisi dengan "Nama (email)"
8. Hidden input `user_id` terisi dengan ID user
9. Preview di sidebar terupdate
10. Suggestions dropdown hilang

## Benefits

✅ **Better UX**: User tidak perlu scroll dropdown panjang
✅ **Fast Search**: Real-time search dengan debounce
✅ **Visual Feedback**: Loading indicator dan hover effects
✅ **Mobile Friendly**: Responsive design
✅ **Accessible**: Keyboard navigation support
✅ **Performance**: Limit 10 results, debounce requests

## Technical Specifications

- **Minimum Characters**: 2
- **Debounce Time**: 300ms
- **Max Results**: 10 users
- **Search Fields**: name, email
- **Response Format**: JSON array of objects
- **Loading State**: Spinner indicator
- **Error Handling**: Display error message in dropdown

## Future Enhancements

- [ ] Keyboard navigation (Arrow up/down, Enter to select)
- [ ] Highlight matching text in suggestions
- [ ] Cache recent searches
- [ ] Add user avatar images (if available)
- [ ] Pagination for more than 10 results
- [ ] Advanced filters (by role, status, etc.)
