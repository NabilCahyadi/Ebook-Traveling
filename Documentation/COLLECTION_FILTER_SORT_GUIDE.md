# COLLECTION FILTER & SORT IMPLEMENTATION GUIDE

## 📋 Overview
This guide documents the implementation of filter and sort functionality for Collection pages in the Ebook-Traveling application.

**Feature:** Users can filter ebooks per page (50-300 or All) and sort by Featured, Newest, or Oldest First.

**Location:** Collection Show Page (`/collections/{slug}`)

---

## 🎯 Implementation Details

### **1. Controller Update**

**File:** `app/Http/Controllers/CollectionController.php`

**Changes Made:**

```php
public function show(Request $request, Collection $collection)
{
    // ✅ Get filter parameters
    $perPage = $request->input('per_page', 50);
    $sortBy = $request->input('sort_by', 'featured');

    // ✅ Validate parameters
    $validPerPage = ['50', '100', '150', '200', '250', '300', 'all'];
    $validSortBy = ['featured', 'newest', 'release_date'];

    if (!in_array($perPage, $validPerPage)) {
        $perPage = 50;
    }

    if (!in_array($sortBy, $validSortBy)) {
        $sortBy = 'featured';
    }

    // Get collection with ebooks
    $detailedCollection = $this->collectionService->getCollectionDetailWithEbooks($collection);

    // ✅ Apply sorting
    $ebooks = $detailedCollection->ebooks;

    switch ($sortBy) {
        case 'newest':
            $ebooks = $ebooks->sortByDesc('created_at');
            break;
        case 'release_date':
            $ebooks = $ebooks->sortBy('release_date');
            break;
        case 'featured':
        default:
            $ebooks = $ebooks->sortByDesc('view_count');
            break;
    }

    // ✅ Apply pagination
    if ($perPage === 'all') {
        $paginatedEbooks = new \Illuminate\Pagination\LengthAwarePaginator(
            $ebooks->values(),
            $ebooks->count(),
            $ebooks->count(),
            1,
            ['path' => $request->url(), 'query' => $request->query()]
        );
    } else {
        $paginatedEbooks = new \Illuminate\Pagination\LengthAwarePaginator(
            $ebooks->forPage($request->input('page', 1), $perPage)->values(),
            $ebooks->count(),
            $perPage,
            $request->input('page', 1),
            ['path' => $request->url(), 'query' => $request->query()]
        );
    }

    // Update collection with paginated ebooks
    $detailedCollection->setRelation('ebooks', $paginatedEbooks);

    return view('collections.show', [
        'collection' => $detailedCollection,
        'citiesHeader' => $citiesHeader,
        'perPage' => $perPage,
        'sortBy' => $sortBy,
    ]);
}
```

---

### **2. View Update**

**File:** `resources/views/components/collections/show.blade.php`

**Filter Dropdowns (Lines 189-249):**

```blade
<div class="sort-by-product-area">
    <!-- SHOW DROPDOWN -->
    <div class="sort-by-cover mr-10">
        <div class="sort-by-product-wrap">
            <div class="sort-by">
                <span><i class="fi-rs-apps"></i>Show :</span>
            </div>
            <div class="sort-by-dropdown-wrap">
                <span>{{ $perPage === 'all' ? 'All' : $perPage }} 
                      <i class="fi-rs-angle-small-down"></i></span>
            </div>
        </div>
        <div class="sort-by-dropdown">
            <ul>
                <li><a class="{{ $perPage == '50' ? 'active' : '' }}"
                       href="?per_page=50&sort_by={{ $sortBy }}">50</a></li>
                <li><a class="{{ $perPage == '100' ? 'active' : '' }}"
                       href="?per_page=100&sort_by={{ $sortBy }}">100</a></li>
                <li><a class="{{ $perPage == '150' ? 'active' : '' }}"
                       href="?per_page=150&sort_by={{ $sortBy }}">150</a></li>
                <li><a class="{{ $perPage == '200' ? 'active' : '' }}"
                       href="?per_page=200&sort_by={{ $sortBy }}">200</a></li>
                <li><a class="{{ $perPage == '250' ? 'active' : '' }}"
                       href="?per_page=250&sort_by={{ $sortBy }}">250</a></li>
                <li><a class="{{ $perPage == '300' ? 'active' : '' }}"
                       href="?per_page=300&sort_by={{ $sortBy }}">300</a></li>
                <li><a class="{{ strtolower($perPage) == 'all' ? 'active' : '' }}"
                       href="?per_page=all&sort_by={{ $sortBy }}">All</a></li>
            </ul>
        </div>
    </div>

    <!-- SORT DROPDOWN -->
    <div class="sort-by-cover">
        <div class="sort-by-product-wrap">
            <div class="sort-by">
                <span><i class="fi-rs-apps-sort"></i>Sort :</span>
            </div>
            <div class="sort-by-dropdown-wrap">
                <span>
                    @if ($sortBy === 'newest')
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
                <li><a class="{{ $sortBy === 'featured' ? 'active' : '' }}"
                       href="?per_page={{ $perPage }}&sort_by=featured">Featured</a></li>
                <li><a class="{{ $sortBy === 'newest' ? 'active' : '' }}"
                       href="?per_page={{ $perPage }}&sort_by=newest">Newest</a></li>
                <li><a class="{{ $sortBy === 'release_date' ? 'active' : '' }}"
                       href="?per_page={{ $perPage }}&sort_by=release_date">Oldest First</a></li>
            </ul>
        </div>
    </div>
</div>
```

**Pagination Links:**

```blade
@if ($perPage !== 'all' && $collection->ebooks->hasPages())
    <div class="pagination-area mt-20 mb-20">
        <nav aria-label="Page navigation">
            {{ $collection->ebooks->appends(['per_page' => $perPage, 'sort_by' => $sortBy])->links() }}
        </nav>
    </div>
@endif
```

---

## 🔧 How It Works

### **Filter Options:**

#### **1. Show (Items Per Page)**
- **50** - Default (50 ebooks per page)
- **100** - 100 ebooks per page
- **150** - 150 ebooks per page
- **200** - 200 ebooks per page
- **250** - 250 ebooks per page
- **300** - 300 ebooks per page
- **All** - Show all ebooks (no pagination)

#### **2. Sort By**
- **Featured** (Default) - Sort by view count (most viewed first)
- **Newest** - Sort by created_at DESC (newest first)
- **Oldest First** - Sort by release_date ASC (oldest first)

---

## 📊 URL Parameter Examples

### **Default View:**
```
/collections/best-travel-guides
```
- Shows: 50 items per page
- Sort: Featured (by view count)

### **Custom Filter:**
```
/collections/best-travel-guides?per_page=100&sort_by=newest
```
- Shows: 100 items per page
- Sort: Newest first

### **Show All:**
```
/collections/best-travel-guides?per_page=all&sort_by=release_date
```
- Shows: All items (no pagination)
- Sort: Oldest first

### **Pagination with Filters:**
```
/collections/best-travel-guides?per_page=50&sort_by=newest&page=2
```
- Shows: 50 items per page
- Sort: Newest first
- Page: 2

---

## ✅ Features

1. **✅ URL-Based Filtering** - No JavaScript required, SEO-friendly
2. **✅ Parameter Validation** - Invalid values fallback to defaults
3. **✅ Active State Highlighting** - Current selection shown with `active` class
4. **✅ Parameter Preservation** - Filters persist across pagination
5. **✅ Pagination Support** - Only shows pagination if needed
6. **✅ "Show All" Option** - View entire collection at once
7. **✅ User-Friendly Labels** - Clear dropdown text

---

## 🧪 Testing Checklist

### **Show Filter:**
- [ ] Default shows 50 items
- [ ] Can select 100, 150, 200, 250, 300 items
- [ ] "All" option shows all ebooks without pagination
- [ ] Active item is highlighted
- [ ] URL updates correctly

### **Sort Filter:**
- [ ] Default sorts by Featured (view_count)
- [ ] "Newest" sorts by created_at DESC
- [ ] "Oldest First" sorts by release_date ASC
- [ ] Active sort option is highlighted
- [ ] URL updates correctly

### **Pagination:**
- [ ] Pagination appears when needed
- [ ] Pagination preserves filter parameters
- [ ] "All" option hides pagination
- [ ] Page numbers work correctly
- [ ] Next/Previous buttons work

### **Combined Filters:**
- [ ] Can change both Show and Sort at the same time
- [ ] Parameters persist when navigating pages
- [ ] URL reflects all active filters
- [ ] Filters reset properly when changed

---

## 🎨 UI/UX Notes

### **Dropdown Behavior:**
- Dropdowns use existing CSS from theme
- Active state uses `.active` class
- Icons: `fi-rs-apps` (Show), `fi-rs-apps-sort` (Sort)
- Responsive design maintained

### **Performance:**
- Sorting done in-memory (collection already loaded)
- Pagination creates custom paginator
- No additional database queries for sorting
- Efficient for collections under 1000 items

---

## 🚀 Future Enhancements

### **Possible Improvements:**
1. **Filter by Category** - Add category filter dropdown
2. **Filter by Language** - Filter ebooks by language
3. **Search Within Collection** - Add search box
4. **Rating Filter** - Filter by minimum rating
5. **Ajax Loading** - Dynamic updates without page reload
6. **Remember Preferences** - Save user's preferred view in session/cookie
7. **Sort by Rating** - Add rating as sort option
8. **Sort by Title** - Alphabetical sorting

---

## 📝 Related Files

### **Modified Files:**
```
app/
  Http/
    Controllers/
      CollectionController.php ✅ Added filter/sort logic

resources/
  views/
    components/
      collections/
        show.blade.php ✅ Updated dropdowns & pagination
```

### **Related Documentation:**
- `CATEGORY_FILTER_SORT_GUIDE.md` - Similar implementation for categories
- `BLOG_FILTER_SORT_GUIDE.md` - Similar implementation for blogs

---

## ⚠️ Important Notes

1. **Parameter Validation:** Always validate user input to prevent errors
2. **Default Values:** Provide sensible defaults (50 items, Featured sort)
3. **URL Encoding:** Laravel handles URL parameter encoding automatically
4. **Pagination Preservation:** Always use `appends()` to preserve query parameters
5. **Active Class:** Keep active state CSS consistent across site

---

## 🔍 Troubleshooting

### **Filters Not Working:**
- Check if `$perPage` and `$sortBy` are passed to view
- Verify parameter validation logic
- Ensure dropdowns use correct variable names

### **Pagination Missing:**
- Check if `$perPage !== 'all'`
- Verify `hasPages()` returns true
- Ensure `appends()` is called on paginator

### **Active State Not Showing:**
- Verify `active` class is applied correctly
- Check if comparison uses correct type (string vs int)
- Ensure CSS for `.active` class exists

### **Sort Not Working:**
- Verify switch statement cases match URL values
- Check if collection has the sort field (created_at, release_date, view_count)
- Ensure ebooks are reassigned after sorting

---

**Last Updated:** January 25, 2026
**Status:** ✅ Implemented & Functional
**Version:** 1.0.0
