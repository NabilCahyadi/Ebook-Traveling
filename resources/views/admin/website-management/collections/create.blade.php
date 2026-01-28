@extends('layouts.admin')

@section('title', __('admin.collections.create_new'))

@push('styles')
<meta http-equiv="cache-control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="expires" content="0">
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Page Header -->
        <div class="mb-4">
            <h4 class="fw-bold py-3 mb-2">
                <span class="text-muted fw-light">
                    <a href="{{ route('admin.collections.index') }}" class="text-muted">{{ __('admin.website_settings') }}</a> / 
                    <a href="{{ route('admin.collections.index') }}" class="text-muted">{{ __('admin.collections.title') }}</a> /
                </span> 
                {{ __('admin.collections.create_new') }}
            </h4>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ __('admin.collections.validation_error') }}</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Create Form -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ __('admin.collections.collection_information') }}</h5>
            </div>
            <div class="card-body">
                <form id="collection-form" action="{{ url('/admin/collections') }}" method="POST" data-route="{{ route('admin.collections.store') }}" onsubmit="console.log('Form onsubmit triggered');">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <!-- Name -->
                            <div class="mb-3">
                                <label class="form-label" for="name">{{ __('admin.collections.collection_name') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" 
                                       placeholder="e.g., Trending This Week" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Slug -->
                            <div class="mb-3">
                                <label class="form-label" for="slug">{{ __('admin.collections.slug') }}</label>
                                <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                       id="slug" name="slug" value="{{ old('slug') }}" 
                                       placeholder="e.g., trending-this-week">
                                <small class="form-text text-muted">{{ __('admin.collections.slug_hint') }}</small>
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Order -->
                            <div class="mb-3">
                                <label class="form-label" for="order">{{ __('admin.collections.display_order') }}</label>
                                <input type="number" class="form-control @error('order') is-invalid @enderror" 
                                       id="order" name="order" value="{{ old('order', 0) }}" min="0">
                                <small class="form-text text-muted">{{ __('admin.collections.order_hint') }}</small>
                                @error('order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <!-- Description -->
                            <div class="mb-3">
                                <label class="form-label" for="description">{{ __('admin.collections.description') }}</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="4" 
                                          placeholder="{{ __('admin.collections.description_placeholder') }}">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status Checkboxes -->
                            <div class="mb-3">
                                <label class="form-label d-block">{{ __('admin.collections.visibility_settings') }}</label>
                                
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" 
                                           name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        {{ __('admin.collections.active') }}
                                        <small class="text-muted d-block">{{ __('admin.collections.active_hint') }}</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden input for selected ebooks -->
                    <input type="hidden" name="selected_ebooks" id="selected_ebooks" value="">

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.collections.index') }}" class="btn btn-label-secondary">
                            <i class="ti ti-arrow-left me-1"></i> {{ __('admin.collections.cancel') }}
                        </a>
                        <button type="button" class="btn btn-primary" id="btn-submit">
                            <i class="ti ti-device-floppy me-1"></i> {{ __('admin.collections.create_collection') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Ebook Selection Panel -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="ti ti-books me-2"></i>{{ __('admin.collections.select_ebooks') }}
                        </h5>
                        <span class="badge bg-label-primary" id="selected-count-badge">{{ __('admin.collections.selected_count', ['count' => 0]) }}</span>
                    </div>
                    <div class="card-body">
                        <!-- Filters -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">{{ __('admin.collections.search') }}</label>
                                <input type="text" id="filter-search" class="form-control" placeholder="{{ __('admin.collections.search_placeholder') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">{{ __('admin.collections.category') }}</label>
                                <select id="filter-category" class="form-select">
                                    <option value="">{{ __('admin.collections.all_categories') }}</option>
                                    @foreach(\App\Models\Category::all() as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">{{ __('admin.collections.sort_by') }}</label>
                                <select id="filter-sort" class="form-select">
                                    <option value="created_at_desc">{{ __('admin.collections.newest_first') }}</option>
                                    <option value="created_at_asc">{{ __('admin.collections.oldest_first') }}</option>
                                    <option value="view_count_desc">{{ __('admin.collections.most_viewed') }}</option>
                                    <option value="view_count_asc">{{ __('admin.collections.least_viewed') }}</option>
                                    <option value="title_asc">{{ __('admin.collections.title_asc') }}</option>
                                    <option value="title_desc">{{ __('admin.collections.title_desc') }}</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">&nbsp;</label>
                                <div class="text-muted small">
                                    {{ __('admin.collections.select_hint') }}
                                </div>
                            </div>
                        </div>

                        <!-- Ebooks Table -->
                        <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                            <table class="table table-hover">
                                <thead style="position: sticky; top: 0; background: white; z-index: 10; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                    <tr>
                                        <th width="50">
                                            <input type="checkbox" id="select-all" class="form-check-input">
                                        </th>
                                        <th width="80">Cover</th>
                                        <th>Title</th>
                                        <th width="150">Creator</th>
                                        <th width="150">Category</th>
                                        <th width="100">Views</th>
                                        <th width="100">Status</th>
                                    </tr>
                                </thead>
                                <tbody id="ebooks-table-body">
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            <p class="mt-2 mb-0">Loading ebooks...</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div id="pagination-container" class="mt-3"></div>
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
    .ebook-row.selected {
        background-color: #e7f3ff;
    }
    .cover-img {
        width: 60px;
        height: 80px;
        object-fit: cover;
        border-radius: 4px;
    }
</style>
@endpush

@push('scripts')
<script>
    let selectedEbooks = new Set();
    let currentPage = 1;

    // Auto-generate slug from name
    document.getElementById('name').addEventListener('input', function() {
        const slug = document.getElementById('slug');
        if (!slug.dataset.manuallyEdited) {
            slug.value = this.value
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '');
        }
    });

    // Mark slug as manually edited when user types in it
    document.getElementById('slug').addEventListener('input', function() {
        this.dataset.manuallyEdited = 'true';
    });

    // Check display order availability
    let orderCheckTimeout;
    document.getElementById('order').addEventListener('input', function() {
        clearTimeout(orderCheckTimeout);
        const orderInput = this;
        const orderValue = parseInt(orderInput.value);
        
        if (isNaN(orderValue) || orderValue < 0) return;
        
        orderCheckTimeout = setTimeout(() => {
            fetch(`/admin/collections/check-order?order=${orderValue}`)
                .then(response => response.json())
                .then(data => {
                    const feedback = orderInput.parentElement.querySelector('.order-feedback');
                    if (feedback) feedback.remove();
                    
                    if (!data.available) {
                        orderInput.classList.add('is-invalid');
                        const div = document.createElement('div');
                        div.className = 'invalid-feedback order-feedback';
                        div.style.display = 'block';
                        
                        let message = `Display order ${orderValue} sudah terisi oleh <strong>${data.collection_name}</strong>.`;
                        let suggestions = [];
                        
                        if (data.suggestions.lower !== null) {
                            suggestions.push(`<strong>${data.suggestions.lower}</strong> (lebih rendah)`);
                        }
                        if (data.suggestions.higher !== null) {
                            suggestions.push(`<strong>${data.suggestions.higher}</strong> (lebih tinggi)`);
                        }
                        
                        if (suggestions.length > 0) {
                            message += `<br><small>Disarankan: ${suggestions.join(' atau ')}</small>`;
                        }
                        
                        div.innerHTML = message;
                        orderInput.parentElement.appendChild(div);
                    } else {
                        orderInput.classList.remove('is-invalid');
                    }
                })
                .catch(error => console.error('Error checking order:', error));
        }, 500);
    });

    // Load ebooks on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadEbooks();

        // Filter change events
        ['filter-search', 'filter-category', 'filter-sort'].forEach(id => {
            document.getElementById(id).addEventListener('change', () => {
                currentPage = 1;
                loadEbooks();
            });
        });

        // Search with debounce
        let searchTimeout;
        document.getElementById('filter-search').addEventListener('keyup', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                currentPage = 1;
                loadEbooks();
            }, 500);
        });

        // Select all checkbox
        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.ebook-checkbox');
            checkboxes.forEach(cb => {
                cb.checked = this.checked;
                if (this.checked) {
                    selectedEbooks.add(cb.value);
                } else {
                    selectedEbooks.delete(cb.value);
                }
                updateRowSelection(cb.closest('tr'));
            });
            updateSelectedCount();
        });

        // Form submit
        document.getElementById('btn-submit').addEventListener('click', function(e) {
            console.log('=== Form Submit Debug ===');
            console.log('Selected ebooks:', selectedEbooks);
            console.log('Selected ebooks count:', selectedEbooks.size);
            
            // Get form by ID
            const form = document.getElementById('collection-form');
            
            // Validate required fields
            const name = document.getElementById('name').value.trim();
            if (!name) {
                alert('Please enter collection name');
                document.getElementById('name').focus();
                return false;
            }
            
            console.log('Collection name:', name);
            console.log('CSRF Token:', $('meta[name="csrf-token"]').attr('content'));
            
            // Set selected ebooks value
            const selectedArray = [...selectedEbooks];
            document.getElementById('selected_ebooks').value = JSON.stringify(selectedArray);
            console.log('Selected ebooks JSON:', document.getElementById('selected_ebooks').value);
            
            // Check form details
            console.log('Form element:', form);
            console.log('Form action:', form.action);
            console.log('Form method:', form.method);
            
            // Force correct action if needed
            const correctAction = '{{ url("/admin/collections") }}';
            if (!form.action.includes('admin/collections')) {
                console.warn('Fixing form action from:', form.action, 'to:', correctAction);
                form.action = correctAction;
            }
            
            console.log('Final form action:', form.action);
            console.log('=== Submitting Form ===');
            
            // Disable button to prevent double submit
            this.disabled = true;
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Creating...';
            
            // Submit form
            try {
                form.submit();
            } catch (error) {
                console.error('Form submit error:', error);
                this.disabled = false;
                this.innerHTML = '<i class="ti ti-device-floppy me-1"></i> Create Collection';
                alert('Error submitting form. Please try again.');
            }
        });
    });

    function loadEbooks(page = 1) {
        const search = document.getElementById('filter-search').value;
        const category = document.getElementById('filter-category').value;
        const sort = document.getElementById('filter-sort').value;

        const params = new URLSearchParams({
            search: search,
            category_id: category,
            sort: sort,
            page: page,
            per_page: 20
        });

        fetch(`/admin/ebooks-for-selection?${params}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            displayEbooks(data.data);
            displayPagination(data);
            currentPage = data.current_page;
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('ebooks-table-body').innerHTML = `
                <tr>
                    <td colspan="7" class="text-center py-4 text-danger">
                        <i class="ti ti-alert-circle"></i> Failed to load ebooks
                    </td>
                </tr>
            `;
        });
    }

    function displayEbooks(ebooks) {
        const tbody = document.getElementById('ebooks-table-body');
        
        if (ebooks.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center py-4">
                        <i class="ti ti-book-off" style="font-size: 2rem; opacity: 0.3;"></i>
                        <p class="mt-2 mb-0 text-muted">No ebooks found</p>
                    </td>
                </tr>
            `;
            return;
        }

        tbody.innerHTML = ebooks.map(ebook => {
            const isSelected = selectedEbooks.has(ebook.id);
            const coverImage = ebook.cover_image || '/images/default-ebook.png';
            const creatorName = ebook.creator?.name || 'Unknown';
            const categories = ebook.categories?.map(c => c.name).join(', ') || '-';
            
            return `
                <tr class="ebook-row ${isSelected ? 'selected' : ''}" data-ebook-id="${ebook.id}">
                    <td>
                        <input type="checkbox" class="form-check-input ebook-checkbox" 
                               value="${ebook.id}" ${isSelected ? 'checked' : ''}>
                    </td>
                    <td>
                        <img src="${coverImage}" alt="${ebook.title}" class="cover-img">
                    </td>
                    <td>
                        <strong>${ebook.title}</strong>
                        ${ebook.short_description ? `<br><small class="text-muted">${ebook.short_description.substring(0, 50)}...</small>` : ''}
                    </td>
                    <td>${creatorName}</td>
                    <td><span class="badge bg-label-info">${categories}</span></td>
                    <td>${formatNumber(ebook.view_count || 0)}</td>
                    <td>
                        <span class="badge bg-${getStatusColor(ebook.status)}">${ebook.status}</span>
                    </td>
                </tr>
            `;
        }).join('');

        // Add event listeners to checkboxes
        document.querySelectorAll('.ebook-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    selectedEbooks.add(this.value);
                } else {
                    selectedEbooks.delete(this.value);
                }
                updateRowSelection(this.closest('tr'));
                updateSelectedCount();
            });
        });

        // Add click event to rows
        document.querySelectorAll('.ebook-row').forEach(row => {
            row.addEventListener('click', function(e) {
                if (e.target.type !== 'checkbox') {
                    const checkbox = this.querySelector('.ebook-checkbox');
                    checkbox.checked = !checkbox.checked;
                    checkbox.dispatchEvent(new Event('change'));
                }
            });
        });
    }

    function displayPagination(data) {
        const container = document.getElementById('pagination-container');
        
        if (data.last_page <= 1) {
            container.innerHTML = '';
            return;
        }

        let html = '<nav><ul class="pagination justify-content-center">';
        
        // Previous
        html += `<li class="page-item ${data.current_page === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" data-page="${data.current_page - 1}">Previous</a>
        </li>`;

        // Pages
        for (let i = 1; i <= data.last_page; i++) {
            if (i === 1 || i === data.last_page || (i >= data.current_page - 2 && i <= data.current_page + 2)) {
                html += `<li class="page-item ${i === data.current_page ? 'active' : ''}">
                    <a class="page-link" href="#" data-page="${i}">${i}</a>
                </li>`;
            } else if (i === data.current_page - 3 || i === data.current_page + 3) {
                html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
            }
        }

        // Next
        html += `<li class="page-item ${data.current_page === data.last_page ? 'disabled' : ''}">
            <a class="page-link" href="#" data-page="${data.current_page + 1}">Next</a>
        </li>`;
        
        html += '</ul></nav>';
        container.innerHTML = html;

        // Add click events
        container.querySelectorAll('.page-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                if (!this.closest('.page-item').classList.contains('disabled')) {
                    loadEbooks(parseInt(this.dataset.page));
                }
            });
        });
    }

    function updateRowSelection(row) {
        if (row.querySelector('.ebook-checkbox').checked) {
            row.classList.add('selected');
        } else {
            row.classList.remove('selected');
        }
    }

    function updateSelectedCount() {
        const count = selectedEbooks.size;
        const text = '{{ __("admin.collections.selected_count", ["count" => "COUNT_PLACEHOLDER"]) }}'.replace('COUNT_PLACEHOLDER', count);
        document.getElementById('selected-count-badge').textContent = text;
    }

    function formatNumber(num) {
        if (num >= 1000000) return (num / 1000000).toFixed(1) + 'M';
        if (num >= 1000) return (num / 1000).toFixed(1) + 'K';
        return num.toString();
    }

    function getStatusColor(status) {
        const colors = {
            'published': 'success',
            'draft': 'secondary',
            'pending': 'warning',
            'rejected': 'danger'
        };
        return colors[status] || 'secondary';
    }
</script>
@endpush
