# BLOG FILTER & SORT FUNCTIONALITY

## 📋 Overview
Fitur filter dan sort untuk halaman blog yang memungkinkan user untuk:
- **Filter "Show"**: Mengatur jumlah blog yang ditampilkan per halaman (50, 100, 150, 200, 250, 300, All)
- **Sort**: Mengurutkan blog berdasarkan kriteria (Featured, Newest, Oldest First)

## 🎯 Features Implemented

### 1. Show/Pagination Filter
- **50 items**: Default, menampilkan 50 blog per halaman
- **100 items**: Menampilkan 100 blog per halaman
- **150 items**: Menampilkan 150 blog per halaman
- **200 items**: Menampilkan 200 blog per halaman
- **250 items**: Menampilkan 250 blog per halaman
- **300 items**: Menampilkan 300 blog per halaman
- **All**: Menampilkan semua blog tanpa pagination

### 2. Sort Options

#### Featured (Default)
```php
// Sort by: View Count (DESC) → Published Date (DESC)
$query->orderBy('view_count', 'desc')
      ->orderBy('published_at', 'desc');
```
Menampilkan blog dengan views tertinggi dan paling populer.

#### Newest
```php
// Sort by: Published Date (DESC)
$query->orderBy('published_at', 'desc');
```
Menampilkan blog terbaru yang dipublikasikan.

#### Oldest First (Release Date)
```php
// Sort by: Published Date (ASC)
$query->orderBy('published_at', 'asc');
```
Menampilkan blog lama terlebih dahulu (berdasarkan tanggal publikasi).

## 🔧 Implementation Details

### Backend Controller

**File**: `app/Http/Controllers/BlogController.php`

**Method**: `index(Request $request)`

```php
public function index(Request $request)
{
    // Get filter parameters
    $perPage = $request->input('per_page', 50); // Default: 50
    $sortBy = $request->input('sort_by', 'featured'); // Default: featured

    // Validate per_page
    $validPerPage = ['50', '100', '150', '200', '250', '300', 'all'];
    if (!in_array(strtolower($perPage), $validPerPage)) {
        $perPage = 50;
    }

    // Build query
    $query = \App\Models\Blog::where('status', 'published')
        ->where('published_at', '<=', now());

    // Apply sorting
    switch ($sortBy) {
        case 'newest':
            $query->orderBy('published_at', 'desc');
            break;
        case 'release_date':
            $query->orderBy('published_at', 'asc'); // Oldest first
            break;
        case 'featured':
        default:
            // Featured: Sort by view_count DESC
            $query->orderBy('view_count', 'desc')
                  ->orderBy('published_at', 'desc');
            break;
    }

    // Get results with pagination or all
    if (strtolower($perPage) === 'all') {
        $blogs = $query->get();
        // Create a fake paginator for consistency
        $blogs = new \Illuminate\Pagination\LengthAwarePaginator(
            $blogs,
            $blogs->count(),
            $blogs->count(),
            1,
            ['path' => $request->url(), 'query' => $request->query()]
        );
    } else {
        $blogs = $query->paginate((int)$perPage)->appends([
            'per_page' => $perPage,
            'sort_by' => $sortBy
        ]);
    }

    $allTags = $this->blogService->getAllPublishedTags();
    $citiesHeader = City::where('is_active', true)
        ->orderBy('order_index')
        ->orderBy('name')
        ->get();
        
    return view('blogs', compact('blogs', 'allTags', 'citiesHeader', 'perPage', 'sortBy'));
}
```

### Frontend View

**File**: `resources/views/blogs.blade.php`

#### Show Filter Dropdown
```blade
<div class="sort-by-cover mr-10">
    <div class="sort-by-product-wrap">
        <div class="sort-by">
            <span><i class="fi-rs-apps"></i>Show :</span>
        </div>
        <div class="sort-by-dropdown-wrap">
            <span> {{ $perPage === 'all' ? 'All' : $perPage }} <i class="fi-rs-angle-small-down"></i></span>
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
            <span><i class="fi-rs-apps-sort"></i>Sort :</span>
        </div>
        <div class="sort-by-dropdown-wrap">
            <span>
                @if($sortBy === 'newest')
                    Newest
                @elseif($sortBy === 'release_date')
                    Oldest First
                @else
                    Featured
                @endif
                <i class="fi-rs-angle-small-down"></i>
            </span>
        </div>
    </div>
    <div class="sort-by-dropdown">
        <ul>
            <li><a class="{{ $sortBy === 'featured' ? 'active' : '' }}" href="?per_page={{ $perPage }}&sort_by=featured">Featured</a></li>
            <li><a class="{{ $sortBy === 'newest' ? 'active' : '' }}" href="?per_page={{ $perPage }}&sort_by=newest">Newest</a></li>
            <li><a class="{{ $sortBy === 'release_date' ? 'active' : '' }}" href="?per_page={{ $perPage }}&sort_by=release_date">Oldest First</a></li>
        </ul>
    </div>
</div>
```

#### Pagination Links
```blade
{{-- Pagination already exists in the view --}}
<div class="pagination-area mt-15 mb-sm-5 mb-lg-0">
    {{ $blogs->links() }}
</div>
```

## 📊 URL Parameter System

### Query Parameters:
- `per_page`: Number of items per page or "all"
- `sort_by`: Sorting criteria

### Example URLs:

```
# Default (50 items, Featured sort)
/blogs

# Show 100 items, Featured sort
/blogs?per_page=100&sort_by=featured

# Show All items, Newest sort
/blogs?per_page=all&sort_by=newest

# Show 50 items, Oldest First sort
/blogs?per_page=50&sort_by=release_date

# Show 200 items, Featured sort
/blogs?per_page=200&sort_by=featured
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
<span> {{ $perPage === 'all' ? 'All' : $perPage }} <i class="fi-rs-angle-small-down"></i></span>
```
- Menampilkan nilai current di dropdown
- Dynamic text berdasarkan selection

## 🔄 Data Flow

```
User selects filter/sort
         ↓
Browser sends GET request with parameters
         ↓
BlogController receives request
         ↓
Validate and sanitize parameters
         ↓
Build query with filters and sorting
         ↓
Execute query (paginated or all)
         ↓
Return view with results
         ↓
View displays filtered/sorted blogs
         ↓
Pagination links preserve parameters
```

## 🧪 Testing Scenarios

### Test 1: Default State
```
URL: /blogs
Expected:
- Shows 50 blogs
- Sorted by Featured (view_count DESC)
- "50" active in Show dropdown
- "Featured" active in Sort dropdown
```

### Test 2: Change Show Filter
```
Action: Click "100" in Show dropdown
Expected:
- URL: /blogs?per_page=100&sort_by=featured
- Shows 100 blogs per page
- "100" active in dropdown
- Sort remains "Featured"
- Pagination links include per_page=100
```

### Test 3: Change Sort
```
Action: Click "Newest" in Sort dropdown
Expected:
- URL: /blogs?per_page=50&sort_by=newest
- Shows newest blogs first
- "Newest" active in dropdown
- Show remains "50"
- Blogs ordered by published_at DESC
```

### Test 4: Show All
```
Action: Click "All" in Show dropdown
Expected:
- URL: /blogs?per_page=all&sort_by=featured
- All blogs displayed
- Pagination still works (fake paginator)
- "All" active in dropdown
```

### Test 5: Combined Filters
```
Action: Select "200" + "Oldest First"
Expected:
- URL: /blogs?per_page=200&sort_by=release_date
- Shows 200 blogs per page
- Sorted by published_at ASC (oldest first)
- Both selections active
```

### Test 6: Pagination Navigation
```
Action: Click page 2 in pagination
Expected:
- URL: /blogs?per_page=50&sort_by=featured&page=2
- Shows page 2 results
- Filters/sort preserved
```

### Test 7: Invalid Parameters
```
Test: /blogs?per_page=999&sort_by=invalid
Expected:
- Falls back to defaults (50, featured)
- No errors displayed
- Graceful handling
```

## 🐛 Troubleshooting

### Issue: Pagination not showing
**Cause:** `per_page` is set to "all" or blogs count < per_page
**Fix:** Check `$perPage` value and total blogs count

### Issue: Sort not working
**Cause:** Database column doesn't exist (view_count)
**Fix:** Ensure all referenced columns exist in blogs table:
```sql
ALTER TABLE blogs ADD COLUMN view_count BIGINT DEFAULT 0;
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

### Issue: "All" option shows empty pagination
**Cause:** Using get() instead of paginator
**Fix:** Create fake paginator for consistency:
```php
$blogs = new \Illuminate\Pagination\LengthAwarePaginator(
    $blogs,
    $blogs->count(),
    $blogs->count(),
    1,
    ['path' => $request->url(), 'query' => $request->query()]
);
```

## 📈 Performance Considerations

### Database Indexes
Ensure indexes exist for sorting columns:
```sql
CREATE INDEX idx_blogs_published_at ON blogs(published_at);
CREATE INDEX idx_blogs_view_count ON blogs(view_count);
CREATE INDEX idx_blogs_status ON blogs(status);
```

### Query Optimization
- Use `where('status', 'published')` to filter only published blogs
- Add `where('published_at', '<=', now())` for scheduled posts
- Consider using eager loading if needed

### Pagination Benefits
- Reduces memory usage (doesn't load all records)
- Faster query execution
- Better user experience for large datasets

### "All" Option Consideration
- Use with caution for blogs with many posts
- Consider disabling for sites with >1000 blogs
- Monitor server memory usage

## 🎯 Comparison with Category Filter

### Similarities:
- ✅ Same Show options (50, 100, 150, 200, 250, 300, All)
- ✅ Active state highlighting
- ✅ Parameter persistence
- ✅ URL-based filtering

### Differences:
| Feature | Category Filter | Blog Filter |
|---------|----------------|-------------|
| Sort: Featured | Rating + Views | Views + Date |
| Sort: Comments | ✅ Available | ❌ Not Available |
| Sort: Release Date | Published Date DESC | Published Date ASC |
| Default per_page | 50 | 50 |
| Model | Ebook | Blog |

## 🎯 Future Enhancements

### 1. Additional Sort Options
```php
case 'most_commented':
    $query->orderBy('comments_count', 'desc');
    break;
case 'alphabetical':
    $query->orderBy('title', 'asc');
    break;
case 'random':
    $query->inRandomOrder();
    break;
```

### 2. Advanced Filters
- Filter by category
- Filter by tags
- Filter by author
- Filter by publish year
- Filter by read time

### 3. Search Integration
- Combine with search functionality
- Filter search results
- Sort search results

### 4. AJAX Loading
- Load results without page reload
- Smooth transitions
- Better UX

### 5. Remember User Preferences
```php
// Store in session or cookies
session(['blog_filter_preferences' => [
    'per_page' => $perPage,
    'sort_by' => $sortBy
]]);
```

### 6. Mobile Optimization
- Responsive dropdown for mobile
- Touch-friendly interface
- Simplified options on small screens

## 📚 Related Files

```
Modified Files:
├── app/Http/Controllers/BlogController.php
└── resources/views/blogs.blade.php

Related Models:
└── app/Models/Blog.php

Database Tables:
└── blogs
```

## ✅ Implementation Checklist

- [x] Update BlogController with filter/sort logic
- [x] Add request parameter handling (per_page, sort_by)
- [x] Implement sorting switch cases
- [x] Add pagination with parameter preservation
- [x] Update Show dropdown with dynamic values
- [x] Update Sort dropdown with dynamic values
- [x] Add active class highlighting
- [x] Pagination links already exist in view
- [x] Test all filter combinations
- [ ] Add database indexes for performance
- [ ] Test with large datasets
- [ ] Mobile responsive testing

## 🔍 Key Differences from Ebook Category

### 1. Simpler Sort Options
Blogs hanya memiliki 3 sort options:
- Featured (views-based)
- Newest
- Oldest First

Tidak ada "Most Comments" karena blog model mungkin tidak tracking comments count.

### 2. Featured Algorithm
```php
// Blogs: View count first
$query->orderBy('view_count', 'desc')
      ->orderBy('published_at', 'desc');

// Ebooks: Rating first
$query->orderBy('average_rating', 'desc')
      ->orderBy('view_count', 'desc');
```

### 3. Release Date Logic
```php
// Blogs: Oldest First (ASC)
$query->orderBy('published_at', 'asc');

// Ebooks: Newest Release Date (DESC)
$query->orderBy('published_at', 'desc');
```

---

**Last Updated:** January 25, 2026  
**Status:** ✅ Implemented & Ready for Testing
