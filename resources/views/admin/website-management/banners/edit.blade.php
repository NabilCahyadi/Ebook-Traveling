@extends('layouts.admin')

@section('title', 'Edit Banner')

@push('styles')
    <style>
        .image-preview {
            width: 100%;
            max-height: 300px;
            object-fit: cover;
            border-radius: 8px;
        }

        .preview-container {
            position: relative;
            margin-bottom: 1rem;
        }

        .remove-preview {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 1;
        }

        .current-image {
            border: 2px solid #e0e0e0;
            padding: 0.5rem;
            border-radius: 8px;
        }
    </style>
@endpush

@section('content')
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <span class="text-muted fw-light">Website Management / Banners /</span> Edit Banner
            </h4>
            <p class="mb-0">Update banner information</p>
        </div>
        <a href="{{ route('admin.banners.index') }}" class="btn btn-label-secondary">
            <i class="ti ti-arrow-left me-1"></i> Back to List
        </a>
    </div>

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> Please check the form below.
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Form Card -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Banner Information</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Type -->
                    <div class="col-md-6 mb-3">
                        <label for="type" class="form-label">Banner Type</label>
                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" {{ $banner->type === 'banner-pricing' ? 'disabled' : '' }}>
                            <option value="hero" {{ old('type', $banner->type) == 'hero' ? 'selected' : '' }}>Hero Banner</option>
                            <option value="home-slider" {{ old('type', $banner->type) == 'home-slider' ? 'selected' : '' }}>Home Slider</option>
                            <option value="banner-pricing" {{ old('type', $banner->type) == 'banner-pricing' ? 'selected' : '' }}>Banner Pricing</option>
                            <option value="promo" {{ old('type', $banner->type) == 'promo' ? 'selected' : '' }}>Promo Banner</option>
                            <option value="announcement" {{ old('type', $banner->type) == 'announcement' ? 'selected' : '' }}>Announcement</option>
                        </select>
                        @if($banner->type === 'banner-pricing')
                        <input type="hidden" name="type" value="banner-pricing">
                        <small class="form-text text-muted">Banner type tidak bisa diubah untuk Banner Pricing</small>
                        @endif
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Title -->
                    <div class="col-md-12 mb-3">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                            name="title" value="{{ old('title', $banner->title) }}" placeholder="Enter banner title"
                            required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="col-md-12 mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                            rows="3" placeholder="Enter banner description (optional)">{{ old('description', $banner->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Current Banner Image -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Current Banner Image</label>
                        <div class="current-image">
                            <img src="{{ $banner->image_url }}" alt="{{ $banner->title }}"
                                class="image-preview {{ $banner->type === 'banner-pricing' ? 'banner-pricing' : 'home-slider' }}" id="currentImage">
                        </div>
                    </div>

                    <!-- New Banner Image -->
                    <div class="col-md-12 mb-3">
                        <label for="image" class="form-label">Change Banner Image</label>
                        <div class="preview-container">
                            <img id="newImagePreview" class="image-preview" src="" alt="Preview"
                                style="display: none;">
                            <button type="button" class="btn btn-sm btn-danger remove-preview" id="removePreview"
                                style="display: none;">
                                <i class="ti ti-x"></i>
                            </button>
                        </div>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                            name="image" accept="image/jpeg,image/jpg,image/png,image/webp">
                        <small class="form-text text-muted" id="image-size-hint">
                            Leave empty to keep current image. Recommended size: {{ $banner->type === 'banner-pricing' ? '1500x600px (2.5:1)' : '1920x600px (3.2:1)' }}. Max size: 2MB
                        </small>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Target URL -->
                    <div class="col-md-12 mb-3" id="target_url_field" style="{{ $banner->type === 'banner-pricing' ? 'display: none;' : '' }}">
                        <label for="target_url" class="form-label">Target URL (Link)</label>
                        <input type="text" class="form-control @error('target_url') is-invalid @enderror"
                            id="target_url" name="target_url" value="{{ old('target_url', $banner->target_url) }}"
                            placeholder="/pricing atau https://example.com">
                        <small class="form-text text-muted">URL tujuan ketika banner diklik. Bisa relative (/pricing) atau absolute (https://...)</small>
                        @error('target_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Order Index -->
                    <div class="col-md-6 mb-3" id="order_index_field" style="{{ $banner->type === 'banner-pricing' ? 'display: none;' : '' }}">
                        <label for="order_index" class="form-label">Display Order</label>
                        <input type="number" class="form-control @error('order_index') is-invalid @enderror"
                            id="order_index" name="order_index" value="{{ old('order_index', $banner->order_index) }}"
                            min="0">
                        <div id="order-warning" class="mt-2" style="display: none;"></div>
                        <small class="form-text text-muted">Lower number appears first</small>
                        @error('order_index')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Start Date -->
                    <div class="col-md-6 mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="datetime-local" class="form-control @error('start_date') is-invalid @enderror"
                            id="start_date" name="start_date"
                            value="{{ old('start_date', $banner->start_date?->format('Y-m-d\TH:i')) }}">
                        <small class="form-text text-muted">Leave empty for immediate display</small>
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- End Date -->
                    <div class="col-md-6 mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="datetime-local" class="form-control @error('end_date') is-invalid @enderror"
                            id="end_date" name="end_date"
                            value="{{ old('end_date', $banner->end_date?->format('Y-m-d\TH:i')) }}">
                        <small class="form-text text-muted">Leave empty for no expiry</small>
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Is Active -->
                    <div class="col-md-12 mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                {{ old('is_active', $banner->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active (Display this banner)
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.banners.index') }}" class="btn btn-label-secondary">
                        <i class="ti ti-x me-1"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-check me-1"></i> Update Banner
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('image');
            const newImagePreview = document.getElementById('newImagePreview');
            const currentImage = document.getElementById('currentImage');
            const removePreview = document.getElementById('removePreview');

            // Preview new image
            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        newImagePreview.src = e.target.result;
                        newImagePreview.style.display = 'block';
                        removePreview.style.display = 'block';
                        currentImage.style.opacity = '0.3';
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Remove new preview
            removePreview.addEventListener('click', function() {
                imageInput.value = '';
                newImagePreview.src = '';
                newImagePreview.style.display = 'none';
                removePreview.style.display = 'none';
                currentImage.style.opacity = '1';
            });

            // Validate dates
            const startDate = document.getElementById('start_date');
            const endDate = document.getElementById('end_date');

            endDate.addEventListener('change', function() {
                if (startDate.value && endDate.value) {
                    if (new Date(endDate.value) < new Date(startDate.value)) {
                        alert('End date must be after start date');
                        endDate.value = '';
                    }
                }
            });

            // Handle target URL and display order visibility based on banner type
            const typeSelect = document.getElementById('type');
            const targetUrlField = document.getElementById('target_url_field');
            const targetUrlInput = document.getElementById('target_url');
            const orderIndexField = document.getElementById('order_index_field');
            const orderIndexInput = document.getElementById('order_index');
            const imageSizeHint = document.getElementById('image-size-hint');

            function toggleFields() {
                if (typeSelect.value === 'banner-pricing') {
                    targetUrlField.style.display = 'none';
                    targetUrlInput.value = '';
                    targetUrlInput.removeAttribute('required');
                    
                    orderIndexField.style.display = 'none';
                    orderIndexInput.value = '0';
                    
                    imageSizeHint.innerHTML = 'Leave empty to keep current image. Recommended size: 1500x600px (2.5:1). Max size: 2MB';
                    newImagePreview.classList.remove('home-slider');
                    newImagePreview.classList.add('banner-pricing');
                    if (currentImage) {
                        currentImage.classList.remove('home-slider');
                        currentImage.classList.add('banner-pricing');
                    }
                } else {
                    targetUrlField.style.display = 'block';
                    orderIndexField.style.display = 'block';
                    
                    imageSizeHint.innerHTML = 'Leave empty to keep current image. Recommended size: 1920x600px (3.2:1). Max size: 2MB';
                    newImagePreview.classList.remove('banner-pricing');
                    newImagePreview.classList.add('home-slider');
                    if (currentImage) {
                        currentImage.classList.remove('banner-pricing');
                        currentImage.classList.add('home-slider');
                    }
                }
            }

            // Initial check
            toggleFields();

            // Listen for changes
            typeSelect.addEventListener('change', toggleFields);

            // Check display order via AJAX
            const orderInput = document.getElementById('order_index');
            const orderWarning = document.getElementById('order-warning');
            let checkTimeout;

            orderInput.addEventListener('input', function() {
                clearTimeout(checkTimeout);
                orderWarning.style.display = 'none';

                const orderValue = this.value;
                const bannerType = typeSelect.value;

                if (!orderValue || bannerType === 'banner-pricing') {
                    return;
                }

                checkTimeout = setTimeout(() => {
                    fetch('{{ route('admin.banners.check-order') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            order: orderValue,
                            type: bannerType,
                            banner_id: '{{ $banner->id }}'
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.exists) {
                            orderWarning.innerHTML = `
                                <div class="alert alert-warning alert-sm mb-0">
                                    <i class="ti ti-alert-triangle me-1"></i>
                                    <strong>Peringatan:</strong> ${data.message}
                                    ${data.suggestion ? `<br><small>${data.suggestion}</small>` : ''}
                                </div>
                            `;
                            orderWarning.style.display = 'block';
                        }
                    })
                    .catch(error => console.error('Error:', error));
                }, 500);
            });
        });
    </script>
@endpush
