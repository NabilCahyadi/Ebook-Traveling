@extends('layouts.admin')

@section('title', 'Edit Collection')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Page Header -->
        <div class="mb-4">
            <h4 class="fw-bold py-3 mb-2">
                <span class="text-muted fw-light">
                    <a href="{{ route('admin.collections.index') }}" class="text-muted">Website Management</a> / 
                    <a href="{{ route('admin.collections.index') }}" class="text-muted">Collections</a> /
                </span> 
                Edit Collection
            </h4>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Validation Error!</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Edit Form -->
        <div class="row">
            <div class="col-xl-8">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Edit Collection: {{ $collection->name }}</h5>
                        <a href="{{ route('admin.collections.manage-ebooks', $collection->id) }}" class="btn btn-sm btn-primary">
                            <i class="ti ti-books me-1"></i> Manage Ebooks
                        </a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.collections.update', $collection->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Name -->
                            <div class="mb-3">
                                <label class="form-label" for="name">Collection Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $collection->name) }}" 
                                       placeholder="e.g., Trending This Week" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Slug -->
                            <div class="mb-3">
                                <label class="form-label" for="slug">Slug <small class="text-muted">(optional, will be auto-generated)</small></label>
                                <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                       id="slug" name="slug" value="{{ old('slug', $collection->slug) }}" 
                                       placeholder="e.g., trending-this-week">
                                <small class="form-text text-muted">URL-friendly version of the name.</small>
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label class="form-label" for="description">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="4" 
                                          placeholder="Brief description of this collection...">{{ old('description', $collection->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Order -->
                            <div class="mb-3">
                                <label class="form-label" for="order">Display Order</label>
                                <input type="number" class="form-control @error('order') is-invalid @enderror" 
                                       id="order" name="order" value="{{ old('order', $collection->order) }}" min="0">
                                <small class="form-text text-muted">Lower numbers appear first</small>
                                @error('order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status Checkboxes -->
                            <div class="mb-3">
                                <label class="form-label d-block">Visibility Settings</label>
                                
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" id="is_active" 
                                           name="is_active" value="1" 
                                           {{ old('is_active', $collection->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Active
                                        <small class="text-muted d-block">Collection is active and visible</small>
                                    </label>
                                </div>

                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" id="show_in_homepage" 
                                           name="show_in_homepage" value="1" 
                                           {{ old('show_in_homepage', $collection->show_in_homepage) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="show_in_homepage">
                                        Show in Homepage
                                        <small class="text-muted d-block">Display this collection on the homepage</small>
                                    </label>
                                </div>

                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_visible_on_landing" 
                                           name="is_visible_on_landing" value="1" 
                                           {{ old('is_visible_on_landing', $collection->is_visible_on_landing) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_visible_on_landing">
                                        Visible on Landing Page
                                        <small class="text-muted d-block">Show this collection on the landing page</small>
                                    </label>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.collections.index') }}" class="btn btn-label-secondary">
                                    <i class="ti ti-arrow-left me-1"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy me-1"></i> Update Collection
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Info Panel -->
            <div class="col-xl-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="card-title mb-3">
                            <i class="ti ti-info-circle me-2"></i>Collection Statistics
                        </h6>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Ebooks:</span>
                            <strong>{{ $collection->ebooks->count() }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Status:</span>
                            @if($collection->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Homepage:</span>
                            @if($collection->show_in_homepage)
                                <span class="badge bg-success">Visible</span>
                            @else
                                <span class="badge bg-secondary">Hidden</span>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Landing Page:</span>
                            @if($collection->is_visible_on_landing)
                                <span class="badge bg-success">Visible</span>
                            @else
                                <span class="badge bg-secondary">Hidden</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title mb-3">
                            <i class="ti ti-help me-2"></i>Quick Actions
                        </h6>
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.collections.manage-ebooks', $collection->id) }}" 
                               class="btn btn-outline-primary">
                                <i class="ti ti-books me-1"></i> Manage Ebooks
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
<script>
    // Auto-generate slug from name (only if slug is empty initially)
    const slugInput = document.getElementById('slug');
    const initialSlug = slugInput.value;
    
    // Check display order availability
    let orderCheckTimeout;
    document.getElementById('order').addEventListener('input', function() {
        clearTimeout(orderCheckTimeout);
        const orderInput = this;
        const orderValue = parseInt(orderInput.value);
        
        if (isNaN(orderValue) || orderValue < 0) return;
        
        orderCheckTimeout = setTimeout(() => {
            fetch(`/admin/collections/check-order?order=${orderValue}&exclude_id={{ $collection->id }}`)
                .then(response => response.json())
                .then(data => {
                    const feedback = orderInput.parentElement.querySelector('.order-feedback');
                    if (feedback) feedback.remove();
                    
                    if (!data.available) {
                        orderInput.classList.add('is-invalid');
                        const div = document.createElement('div');
                        div.className = 'invalid-feedback order-feedback';
                        div.style.display = 'block';
                        
                        let message = `Display order ${orderValue} is already taken by <strong>${data.collection_name}</strong>.`;
                        let suggestions = [];
                        
                        if (data.suggestions.lower !== null) {
                            suggestions.push(`<strong>${data.suggestions.lower}</strong> (lower)`);
                        }
                        if (data.suggestions.higher !== null) {
                            suggestions.push(`<strong>${data.suggestions.higher}</strong> (higher)`);
                        }
                        
                        if (suggestions.length > 0) {
                            message += `<br><small>Suggested: ${suggestions.join(' or ')}</small>`;
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
    
    document.getElementById('name').addEventListener('input', function() {
        if (!slugInput.dataset.manuallyEdited) {
            slugInput.value = this.value
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '');
        }
    });

    // Mark slug as manually edited when user types in it
    slugInput.addEventListener('input', function() {
        this.dataset.manuallyEdited = 'true';
    });
</script>
@endpush
