# CATEGORY FILTER & SORT FUNCTIONALITY

## 📋 Overview
Fitur filter dan sort untuk halaman category yang memungkinkan user untuk:
- **Filter "Show"**: Mengatur jumlah ebook yang ditampilkan per halaman (50, 100, 150, 200, 250, 300, All)
- **Sort**: Mengurutkan ebook berdasarkan kriteria (Featured, Newest, Most Comments, Release Date)

## 🎯 Features Implemented

### 1. Show/Pagination Filter
- **50 items**: Default, menampilkan 50 ebook per halaman
- **100 items**: Menampilkan 100 ebook per halaman
- **150 items**: Menampilkan 150 ebook per halaman
- **200 items**: Menampilkan 200 ebook per halaman
- **250 items**: Menampilkan 250 ebook per halaman
- **300 items**: Menampilkan 300 ebook per halaman
- **All**: Menampilkan semua ebook tanpa pagination

### 2. Sort Options

#### Featured (Default)
```php
// Sort by: Average Rating (DESC) → View Count (DESC)
$query->orderBy('ebooks.average_rating', 'desc')
      ->orderBy('ebooks.view_count', 'desc');
```
Menampilkan ebook dengan rating tertinggi dan paling banyak dilihat.

#### Newest
```php
// Sort by: Created Date (DESC)
$query->orderBy('ebooks.created_at', 'desc');
```
Menampilkan ebook terbaru yang ditambahkan ke sistem.

#### Most Comments
```php
// Sort by: Comments Count (DESC)
$query->orderBy('ebooks.comments_count', 'desc');
```
Menampilkan ebook dengan komentar terbanyak.

#### Release Date
```php
// Sort by: Published Date (DESC)
$query->orderBy('ebooks.published_at', 'desc');
```
Menampilkan ebook berdasarkan tanggal publikasi terbaru.

## 🔧 Implementation Details

### Backend Controller

**File**: `app/Http/Controllers/FrontendCategoryController.php`

**Method**: `show(Request $request, $slug)`

```php
public function show(Request $request, $slug)
{
    // Get category
    $category = $this->categoryService->getCategoryBySlug($slug);

    // Get filter parameters
    $perPage = $request->input('per_page', 50); // Default: 50
    $sortBy = $request->input('sort_by', 'featured'); // Default: featured

    // Validate per_page
    $validPerPage = ['50', '100', '150', '200', '250', '300', 'all'];
    if (!in_array(strtolower($perPage), $validPerPage)) {
        $perPage = 50;
    }

    // Build query with joins
    $query = \App\Models\Ebook::select('ebooks.*')
        ->join('ebook_categories', 'ebooks.id', '=', 'ebook_categories.ebook_id')
        ->where('ebook_categories.category_id', $category->id)
        ->where('ebooks.status', 'published')
        ->whereNull('ebooks.deleted_at')
        ->with(['creator', 'city']);

    // Apply sorting
    switch ($sortBy) {
        case 'newest':
            $query->orderBy('ebooks.created_at', 'desc');
            break;
        case 'most_comments':
            $query->orderBy('ebooks.comments_count', 'desc');
            break;
        case 'release_date':
            $query->orderBy('ebooks.published_at', 'desc');
            break;
        case 'featured':
        default:
            $query->orderBy('ebooks.average_rating', 'desc')
                  ->orderBy('ebooks.view_count', 'desc');
            break;
    }

    // Get results with pagination or all
    if (strtolower($perPage) === 'all') {
        $ebooks = $query->get();
    } else {
        $ebooks = $query->paginate((int)$perPage)->appends([
            'per_page' => $perPage,
            'sort_by' => $sortBy
        ]);
    }

    // Attach to category
    $category->setRelation('ebooks', $ebooks);

    return view('components.categories.show', compact('category', 'citiesHeader', 'perPage', 'sortBy'));
}
```

### Frontend View

**File**: `resources/views/components/categories/show.blade.php`

#### Show Filter Dropdown
```blade
<div class="sort-by-cover mr-10">
    <div class="sort-by-product-wrap">
        <div class="sort-by">
            <span><i class="fi fi-rs-apps"></i>Show :</span>
        </div>
        <div class="sort-by-dropdown-wrap">
            <span> {{ $perPage === 'all' ? 'All' : $perPage }} <i class="fi fi-rs-angle-small-down"></i></span>
        </div>
    </div>
    <div class="sort-by-dropdown">
        <ul>
            <li><a class="{{ $perPage == '50' ? 'active' : '' }}" href="?per_page=50&sort_by={{ $sortBy }}">50</a></li>
            <li><a class="{{ $perPage == '100' ? 'active' : '' }}" href="?per_page=100&sort_by={{ $sortBy }}">100</a></li>
            <li><a class="{{ $perPage == '150' ? 'active' : '' }}" href="?per_page=150&sort_by={{ $sortBy }}">150</a></li>
            <li><a class="{{ $perPage == '200' ? 'active' : '' }}" href="?per_page=200&sort_by={{ $sortBy }}">200</a></li>
            <li><a class="{{ $perPage == '250' ? 'active' : '' }}" href="?per_page=250&sort_by={{ $sortBy }}">250</a></li>
            <li><a class="{{ $perPage == '300' ? 'active' : '' }}" href="?per_page=300&sort_by={{ $sortBy }}">300</a></li>
            <li><a class="{{ strtolower($perPage) == 'all' ? 'active' : '' }}" href="?per_page=all&sort_by={{ $sortBy }}">All</a></li>
        </ul>
    </div>
</div>
```

#### Sort By Dropdown
```blade
<div class="sort-by-cover">
    <div class="sort-by-product-wrap">
        <div class="sort-by">
            <span><i class="fi fi-rs-apps-sort"></i>Sort :</span>
        </div>
        <div class="sort-by-dropdown-wrap">
            <span>
                @if($sortBy === 'newest')
                    Newest
                @elseif($sortBy === 'most_comments')
                    Most Comments
                @elseif($sortBy === 'release_date')
                    Release Date
                @else
                    Featured
                @endif
                <i class="fi fi-rs-angle-small-down"></i>
            </span>
        </div>
    </div>
    <div class="sort-by-dropdown">
        <ul>
            <li><a class="{{ $sortBy === 'featured' ? 'active' : '' }}" href="?per_page={{ $perPage }}&sort_by=featured">Featured</a></li>
            <li><a class="{{ $sortBy === 'newest' ? 'active' : '' }}" href="?per_page={{ $perPage }}&sort_by=newest">Newest</a></li>
            <li><a class="{{ $sortBy === 'most_comments' ? 'active' : '' }}" href="?per_page={{ $perPage }}&sort_by=most_comments">Most Comments</a></li>
            <li><a class="{{ $sortBy === 'release_date' ? 'active' : '' }}" href="?per_page={{ $perPage }}&sort_by=release_date">Release Date</a></li>
        </ul>
    </div>
</div>
```

#### Pagination Links
```blade
{{-- Only show pagination if not "All" --}}
@if (strtolower($perPage) !== 'all' && method_exists($category->ebooks, 'links'))
    <div class="pagination-area mt-20 mb-20">
        <nav aria-label="Page navigation">
            {{ $category->ebooks->links() }}
        </nav>
    </div>
@endif
```

## 📊 URL Parameter System

### Query Parameters:
- `per_page`: Number of items per page or "all"
- `sort_by`: Sorting criteria

### Example URLs:

```
# Default (50 items, Featured sort)
/category/travel-guides

# Show 100 items, Featured sort
/category/travel-guides?per_page=100&sort_by=featured

# Show All items, Newest sort
/category/travel-guides?per_page=all&sort_by=newest

# Show 50 items, Most Comments sort
/category/travel-guides?per_page=50&sort_by=most_comments

# Show 200 items, Release Date sort
/category/travel-guides?per_page=200&sort_by=release_date
```

## 🎨 UI/UX Features

### Active State Highlighting
```blade
<a class="{{ $perPage == '50' ? 'active' : '' }}" href="?per_page=50&sort_by={{ $sortBy }}">50</a>
```
- Current selection is highlighted with `active` class
- Visual feedback untuk user

### Parameter Persistence
```blade
href="?per_page={{ $perPage }}&sort_by={{ $sortBy }}"
```
- Saat user mengubah sort, per_page tetap sama
- Saat user mengubah per_page, sort tetap sama
- Kombinasi filter tetap terjaga

### Dropdown Display
```blade
<span> {{ $perPage === 'all' ? 'All' : $perPage }} <i class="fi fi-rs-angle-small-down"></i></span>
```
- Menampilkan nilai current di dropdown
- Dynamic text berdasarkan selection

## 🔄 Data Flow

```
User selects filter/sort
         ↓
Browser sends GET request with parameters
         ↓
FrontendCategoryController receives request
         ↓
Validate and sanitize parameters
         ↓
Build query with filters and sorting
         ↓
Execute query (paginated or all)
         ↓
Return view with results
         ↓
View displays filtered/sorted ebooks
         ↓
Pagination links preserve parameters
```

## 🧪 Testing Scenarios

### Test 1: Default State
```
URL: /category/travel-guides
Expected:
- Shows 50 ebooks
- Sorted by Featured
- "50" active in Show dropdown
- "Featured" active in Sort dropdown
```

### Test 2: Change Show Filter
```
Action: Click "100" in Show dropdown
Expected:
- URL: /category/travel-guides?per_page=100&sort_by=featured
- Shows 100 ebooks per page
- "100" active in dropdown
- Sort remains "Featured"
- Pagination links include per_page=100
```

### Test 3: Change Sort
```
Action: Click "Newest" in Sort dropdown
Expected:
- URL: /category/travel-guides?per_page=50&sort_by=newest
- Shows newest ebooks first
- "Newest" active in dropdown
- Show remains "50"
- Ebooks ordered by created_at DESC
```

### Test 4: Show All
```
Action: Click "All" in Show dropdown
Expected:
- URL: /category/travel-guides?per_page=all&sort_by=featured
- All ebooks displayed
- No pagination links shown
- "All" active in dropdown
```

### Test 5: Combined Filters
```
Action: Select "200" + "Most Comments"
Expected:
- URL: /category/travel-guides?per_page=200&sort_by=most_comments
- Shows 200 ebooks per page
- Sorted by comments_count DESC
- Both selections active
```

### Test 6: Pagination Navigation
```
Action: Click page 2 in pagination
Expected:
- URL: /category/travel-guides?per_page=50&sort_by=featured&page=2
- Shows page 2 results
- Filters/sort preserved
```

### Test 7: Invalid Parameters
```
Test: /category/travel-guides?per_page=999&sort_by=invalid
Expected:
- Falls back to defaults (50, featured)
- No errors displayed
- Graceful handling
```

## 🐛 Troubleshooting

### Issue: Pagination not showing
**Cause:** `per_page` is set to "all" or ebooks count < per_page
**Fix:** Check `$perPage` value and total ebooks count

### Issue: Sort not working
**Cause:** Database column doesn't exist (e.g., comments_count)
**Fix:** Ensure all referenced columns exist in ebooks table:
```sql
ALTER TABLE ebooks ADD COLUMN comments_count INT DEFAULT 0;
```

### Issue: Active class not showing
**Cause:** Type mismatch (string vs int comparison)
**Fix:** Use loose comparison `==` instead of strict `===` for per_page

### Issue: Parameters lost on pagination
**Cause:** Pagination links not appending parameters
**Fix:** Ensure `.appends()` is used in controller:
```php
->paginate((int)$perPage)->appends([
    'per_page' => $perPage,
    'sort_by' => $sortBy
]);
```

## 📈 Performance Considerations

### Database Indexes
Ensure indexes exist for sorting columns:
```sql
CREATE INDEX idx_ebooks_created_at ON ebooks(created_at);
CREATE INDEX idx_ebooks_average_rating ON ebooks(average_rating);
CREATE INDEX idx_ebooks_view_count ON ebooks(view_count);
CREATE INDEX idx_ebooks_comments_count ON ebooks(comments_count);
CREATE INDEX idx_ebooks_published_at ON ebooks(published_at);
```

### Query Optimization
- Use `select('ebooks.*')` to avoid selecting duplicate columns from join
- Add `whereNull('ebooks.deleted_at')` for soft deletes
- Eager load relationships with `with(['creator', 'city'])`

### Pagination Benefits
- Reduces memory usage (doesn't load all records)
- Faster query execution
- Better user experience for large datasets

### "All" Option Consideration
- Use with caution for categories with many ebooks
- Consider disabling for categories with >1000 ebooks
- Monitor server memory usage

## 🎯 Future Enhancements

### 1. Additional Sort Options
```php
case 'highest_rated':
    $query->orderBy('ebooks.average_rating', 'desc');
    break;
case 'most_viewed':
    $query->orderBy('ebooks.view_count', 'desc');
    break;
case 'alphabetical':
    $query->orderBy('ebooks.title', 'asc');
    break;
```

### 2. Advanced Filters
- Filter by language
- Filter by author
- Filter by rating (4+ stars, 3+ stars)
- Filter by publish year

### 3. AJAX Loading
- Load results without page reload
- Smooth transitions
- Better UX

### 4. Remember User Preferences
```php
// Store in session or cookies
session(['category_filter_preferences' => [
    'per_page' => $perPage,
    'sort_by' => $sortBy
]]);
```

### 5. Mobile Optimization
- Responsive dropdown for mobile
- Touch-friendly interface
- Simplified options on small screens

## 📚 Related Files

```
Modified Files:
├── app/Http/Controllers/FrontendCategoryController.php
└── resources/views/components/categories/show.blade.php

Related Models:
├── app/Models/Ebook.php
├── app/Models/Category.php
└── app/Models/EbookCategory.php (pivot)

Database Tables:
├── ebooks
├── categories
└── ebook_categories
```

## ✅ Implementation Checklist

- [x] Update FrontendCategoryController with filter/sort logic
- [x] Add request parameter handling (per_page, sort_by)
- [x] Implement sorting switch cases
- [x] Add pagination with parameter preservation
- [x] Update Show dropdown with dynamic values
- [x] Update Sort dropdown with dynamic values
- [x] Add active class highlighting
- [x] Add pagination links (conditional)
- [x] Test all filter combinations
- [ ] Add database indexes for performance
- [ ] Test with large datasets
- [ ] Mobile responsive testing

---

**Last Updated:** January 25, 2026  
**Status:** ✅ Implemented & Ready for Testing
