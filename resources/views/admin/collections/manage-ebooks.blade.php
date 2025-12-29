@extends('layouts.admin')

@section('title', 'Manage Ebooks - ' . $collection->name)

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Page Header -->
        <div class="mb-4">
            <h4 class="fw-bold py-3 mb-2">
                <span class="text-muted fw-light">
                    <a href="{{ route('admin.collections.index') }}" class="text-muted">Collections</a> /
                </span> 
                Manage Ebooks: {{ $collection->name }}
            </h4>
        </div>

        <!-- Current Ebooks in Collection -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="ti ti-list me-2"></i>Current Ebooks in Collection
                        </h5>
                        <span class="badge bg-label-primary">{{ $collection->ebooks->count() }} ebooks</span>
                    </div>
                    <div class="card-body">
                        @if($collection->ebooks->isEmpty())
                            <div class="text-center py-5">
                                <i class="ti ti-book-off" style="font-size: 3rem; opacity: 0.3;"></i>
                                <p class="mt-3 text-muted">No ebooks in this collection yet</p>
                                <p class="text-muted small">Use the "Add Ebooks" panel to add ebooks</p>
                            </div>
                        @else
                            <div class="alert alert-info">
                                <i class="ti ti-info-circle me-2"></i>
                                <strong>Drag & Drop</strong> to reorder ebooks. Changes will be saved automatically.
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th width="50">Order</th>
                                            <th width="80">Cover</th>
                                            <th>Title</th>
                                            <th>Creator</th>
                                            <th>Category</th>
                                            <th>Views</th>
                                            <th width="100">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="sortable-ebooks">
                                        @foreach($collection->ebooks->sortBy('pivot.order_index') as $ebook)
                                            <tr data-ebook-id="{{ $ebook->id }}" style="cursor: move;">
                                                <td class="text-center">
                                                    <i class="ti ti-grip-vertical text-muted"></i>
                                                </td>
                                                <td>
                                                    <img src="{{ $ebook->cover_image_url }}" 
                                                         alt="{{ $ebook->title }}" 
                                                         class="cover-img">
                                                </td>
                                                <td>
                                                    <strong>{{ $ebook->title }}</strong>
                                                    @if($ebook->description)
                                                        <br><small class="text-muted">{{ Str::limit($ebook->description, 50) }}</small>
                                                    @endif
                                                </td>
                                                <td>{{ $ebook->creator->name ?? 'Unknown' }}</td>
                                                <td>
                                                    @if($ebook->categories->isNotEmpty())
                                                        <span class="badge bg-label-info">{{ $ebook->categories->first()->name }}</span>
                                                        @if($ebook->categories->count() > 1)
                                                            <span class="badge bg-label-secondary">+{{ $ebook->categories->count() - 1 }}</span>
                                                        @endif
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>{{ number_format($ebook->view_count ?? 0) }}</td>
                                                <td>
                                                    <button type="button" 
                                                            class="btn btn-sm btn-danger remove-ebook-btn" 
                                                            data-ebook-id="{{ $ebook->id }}"
                                                            data-ebook-title="{{ $ebook->title }}">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Ebooks Panel -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="ti ti-plus me-2"></i>Add Ebooks
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Filters -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label class="form-label">Search Ebooks</label>
                                <input type="text" 
                                       id="search-ebook" 
                                       class="form-control" 
                                       placeholder="Search by title...">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Filter by Category</label>
                                <select id="filter-category" class="form-select">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Sort By</label>
                                <select id="filter-sort" class="form-select">
                                    <option value="created_at_desc">Newest First</option>
                                    <option value="created_at_asc">Oldest First</option>
                                    <option value="view_count_desc">Most Viewed</option>
                                    <option value="view_count_asc">Least Viewed</option>
                                    <option value="title_asc">Title (A-Z)</option>
                                    <option value="title_desc">Title (Z-A)</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label d-block">&nbsp;</label>
                                <button type="button" id="btn-search-ebooks" class="btn btn-primary w-100">
                                    <i class="ti ti-search me-1"></i> Search
                                </button>
                            </div>
                        </div>

                        <!-- Selected Count & Add Button -->
                        <div id="selected-info" class="d-none mb-3">
                            <div class="alert alert-primary d-flex align-items-center justify-content-between mb-0">
                                <div>
                                    <i class="ti ti-checkbox me-2"></i>
                                    <span id="selected-count-text" class="fw-semibold">0 ebooks selected</span>
                                </div>
                                <button type="button" id="btn-add-selected" class="btn btn-primary btn-sm">
                                    <i class="ti ti-plus me-1"></i> Add Selected to Collection
                                </button>
                            </div>
                        </div>

                        <!-- Search Results Table -->
                        <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                            <table class="table table-hover">
                                <thead style="position: sticky; top: 0; background: white; z-index: 10; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                    <tr>
                                        <th width="50">
                                            <input type="checkbox" id="select-all-search" class="form-check-input">
                                        </th>
                                        <th width="80">Cover</th>
                                        <th>Title</th>
                                        <th width="150">Creator</th>
                                        <th width="150">Category</th>
                                        <th width="100">Views</th>
                                    </tr>
                                </thead>
                                <tbody id="search-results-body">
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <i class="ti ti-search" style="font-size: 3rem; opacity: 0.3;"></i>
                                            <p class="mt-3 mb-0">Use filters and click "Search Ebooks"</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('styles')
<style>
    .ebook-row {
        cursor: pointer;
        transition: background-color 0.2s;
    }
    .ebook-row:hover {
        background-color: #f8f9fa;
    }
    .ebook-row.table-primary {
        background-color: #e7f3ff !important;
    }
    .sortable-ghost {
        opacity: 0.4;
    }
    .sortable-drag {
        background: white;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .cover-img {
        width: 60px;
        height: 80px;
        object-fit: cover;
        border-radius: 4px;
    }
    #sortable-ebooks tr {
        transition: background-color 0.2s;
    }
    #sortable-ebooks tr:hover {
        background-color: #f8f9fa;
    }
</style>
@endpush

@push('scripts')
<!-- Sortable.js from CDN -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
    const collectionId = '{{ $collection->id }}';
    let selectedEbooks = [];

    // Select all checkbox
    const selectAllBtn = document.getElementById('select-all-search');
    if (selectAllBtn) {
        selectAllBtn.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.ebook-checkbox');
            checkboxes.forEach(cb => {
                cb.checked = this.checked;
                updateRowSelection(cb.closest('tr'));
            });
            updateSelectedCount();
        });
    }

    // Initialize Sortable for drag & drop
    const sortableList = document.getElementById('sortable-ebooks');
    if (sortableList) {
        new Sortable(sortableList, {
            animation: 150,
            ghostClass: 'sortable-ghost',
            dragClass: 'sortable-drag',
            onEnd: function(evt) {
                updateEbookOrder();
            }
        });
    }

    // Update ebook order after drag & drop
    function updateEbookOrder() {
        const items = document.querySelectorAll('#sortable-ebooks tr');
        const orders = {};
        
        items.forEach((item, index) => {
            const ebookId = item.dataset.ebookId;
            orders[ebookId] = index + 1;
        });

        fetch(`{{ route('admin.collections.update-ebook-order', $collection->id) }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ orders: orders })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Success', 'Ebook order updated successfully', 'success');
            } else {
                showToast('Error', data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Error', 'Failed to update order', 'error');
        });
    }

    // Search ebooks
    document.getElementById('btn-search-ebooks').addEventListener('click', function() {
        searchEbooks();
    });

    // Auto search when filter changes
    document.getElementById('filter-category').addEventListener('change', function() {
        searchEbooks();
    });

    document.getElementById('filter-sort').addEventListener('change', function() {
        searchEbooks();
    });

    // Allow Enter key to trigger search on text input
    document.getElementById('search-ebook').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            searchEbooks();
        }
    });

    function searchEbooks() {
        const search = document.getElementById('search-ebook').value;
        const category = document.getElementById('filter-category').value;
        const sort = document.getElementById('filter-sort').value;

        const params = new URLSearchParams({
            search: search,
            category_id: category,
            sort: sort,
            collection_id: collectionId
        });

        fetch(`{{ route('admin.collections.get-available-ebooks') }}?${params}`)
            .then(response => response.json())
            .then(data => {
                displaySearchResults(data.data);
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Error', 'Failed to search ebooks', 'error');
            });
    }

    function displaySearchResults(ebooks) {
        const tbody = document.getElementById('search-results-body');
        
        if (ebooks.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <i class="ti ti-book-off" style="font-size: 3rem; opacity: 0.3;"></i>
                        <p class="mt-3 mb-0 text-muted">No ebooks found matching your criteria</p>
                    </td>
                </tr>
            `;
            return;
        }

        tbody.innerHTML = ebooks.map(ebook => {
            const coverImage = ebook.cover_image_url || '/images/default-ebook.png';
            const creatorName = ebook.creator?.name || 'Unknown';
            const categories = ebook.categories?.map(c => c.name).join(', ') || '-';
            
            return `
                <tr class="ebook-row" data-ebook-id="${ebook.id}">
                    <td>
                        <input type="checkbox" class="form-check-input ebook-checkbox" 
                               data-ebook-id="${ebook.id}">
                    </td>
                    <td>
                        <img src="${coverImage}" alt="${ebook.title}" class="cover-img">
                    </td>
                    <td>
                        <strong>${ebook.title}</strong>
                        ${ebook.description ? `<br><small class="text-muted">${ebook.description.substring(0, 50)}...</small>` : ''}
                    </td>
                    <td>${creatorName}</td>
                    <td><span class="badge bg-label-info">${categories}</span></td>
                    <td>${formatNumber(ebook.view_count || 0)}</td>
                </tr>
            `;
        }).join('');

        // Add event listeners to checkboxes
        document.querySelectorAll('.ebook-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateSelectedCount();
                updateRowSelection(this.closest('tr'));
            });
        });

        // Click on row to toggle checkbox
        document.querySelectorAll('.ebook-row').forEach(row => {
            row.addEventListener('click', function(e) {
                if (e.target.type !== 'checkbox' && !e.target.classList.contains('form-check-input')) {
                    const checkbox = this.querySelector('.ebook-checkbox');
                    checkbox.checked = !checkbox.checked;
                    checkbox.dispatchEvent(new Event('change'));
                }
            });
        });
    }

    function updateRowSelection(row) {
        const checkbox = row.querySelector('.ebook-checkbox');
        row.classList.toggle('table-primary', checkbox.checked);
    }

    function formatNumber(num) {
        return new Intl.NumberFormat().format(num);
    }

    function updateSelectedCount() {
        selectedEbooks = Array.from(document.querySelectorAll('.ebook-checkbox:checked'))
            .map(cb => cb.dataset.ebookId);
        
        const infoDiv = document.getElementById('selected-info');
        const countText = document.getElementById('selected-count-text');
        
        if (selectedEbooks.length > 0) {
            infoDiv.classList.remove('d-none');
            countText.textContent = `${selectedEbooks.length} ebook${selectedEbooks.length > 1 ? 's' : ''} selected`;
        } else {
            infoDiv.classList.add('d-none');
        }
    }

    // Add selected ebooks to collection
    document.getElementById('btn-add-selected').addEventListener('click', function() {
        if (selectedEbooks.length === 0) {
            showToast('Warning', 'Please select at least one ebook', 'warning');
            return;
        }

        fetch(`{{ route('admin.collections.add-ebooks', $collection->id) }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ ebook_ids: selectedEbooks })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Success', 'Ebooks added to collection', 'success');
                // Reload page to show updated collection
                setTimeout(() => location.reload(), 1000);
            } else {
                showToast('Error', data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Error', 'Failed to add ebooks', 'error');
        });
    });

    // Remove ebook from collection
    document.querySelectorAll('.remove-ebook-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const ebookId = this.dataset.ebookId;
            const ebookTitle = this.dataset.ebookTitle;

            if (!confirm(`Remove "${ebookTitle}" from this collection?`)) {
                return;
            }

            fetch(`{{ route('admin.collections.remove-ebook', ['collectionId' => $collection->id, 'ebookId' => '__EBOOK_ID__']) }}`.replace('__EBOOK_ID__', ebookId), {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Success', 'Ebook removed from collection', 'success');
                    // Remove the item from table row (changed from li to tr)
                    this.closest('tr').remove();
                    // Update count
                    const countBadge = document.querySelector('.card-header .badge');
                    const currentCount = parseInt(countBadge.textContent);
                    countBadge.textContent = `${currentCount - 1} ebooks`;
                    
                    // Check if no more ebooks, show empty state
                    const tableBody = document.querySelector('#sortable-ebooks');
                    if (tableBody && tableBody.children.length === 0) {
                        location.reload();
                    }
                } else {
                    showToast('Error', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Error', 'Failed to remove ebook', 'error');
            });
        });
    });

    // Toast notification helper
    function showToast(title, message, type = 'info') {
        // You can integrate with your existing toast/notification system
        // For now, using simple alert
        const alertClass = type === 'success' ? 'alert-success' : 
                          type === 'error' ? 'alert-danger' : 
                          type === 'warning' ? 'alert-warning' : 'alert-info';
        
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show position-fixed top-0 end-0 m-3" 
                 role="alert" style="z-index: 9999;">
                <strong>${title}:</strong> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        document.body.insertAdjacentHTML('beforeend', alertHtml);
        
        // Auto-dismiss after 3 seconds
        setTimeout(() => {
            const alert = document.querySelector('.position-fixed.alert');
            if (alert) alert.remove();
        }, 3000);
    }
</script>
@endpush
