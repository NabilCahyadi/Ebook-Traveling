@extends('layouts.admin')

@section('title', 'Create New Banner')

@push('styles')
    <style>
        .preview-container {
            position: relative;
            margin-bottom: 1rem;
            min-height: 50px;
        }

        .image-preview {
            width: 100%;
            max-height: 300px;
            object-fit: cover;
            border-radius: 8px;
        }

        .image-preview.home-slider {
            aspect-ratio: 3.2 / 1;
            max-height: none;
        }

        .image-preview.banner-pricing {
            aspect-ratio: 2.5 / 1;
            max-height: none;
        }

        .remove-preview {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 1;
        }
    </style>
@endpush

@section('content')
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <span class="text-muted fw-light">Website Management / Banners /</span> Create New Banner
            </h4>
            <p class="mb-0">Tambah banner baru untuk ditampilkan di homepage</p>
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

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Form Card -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Banner Information</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <!-- Type -->
                    <div class="col-md-6 mb-3">
                        <label for="type" class="form-label">Banner Type</label>
                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type">
                            @php
                                $selectedType = old('type', request('type', 'home-slider'));
                            @endphp
                            <option value="home-slider" {{ $selectedType == 'home-slider' ? 'selected' : '' }}>Home Slider</option>
                            <option value="banner-pricing" {{ $selectedType == 'banner-pricing' ? 'selected' : '' }} {{ isset($hasBannerPricing) && $hasBannerPricing ? 'disabled' : '' }}>Banner Pricing {{ isset($hasBannerPricing) && $hasBannerPricing ? '(Sudah ada)' : '' }}</option>
                        </select>
                        @if(isset($hasBannerPricing) && $hasBannerPricing)
                        <small class="form-text text-muted">Banner Pricing sudah ada, hanya boleh 1 banner pricing</small>
                        @endif
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Title -->
                    <div class="col-md-12 mb-3">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                            name="title" value="{{ old('title') }}" placeholder="Enter banner title" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="col-md-12 mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                            rows="3" placeholder="Enter banner description (optional)">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Banner Image -->
                    <div class="col-md-12 mb-3">
                        <label for="image" class="form-label">Banner Image <span class="text-danger">*</span></label>
                        <div class="preview-container" id="previewContainer" style="display: none; position: relative;">
                            <img id="imagePreview" class="image-preview" src="" alt="Preview">
                            <button type="button" class="btn btn-sm btn-danger remove-preview" id="removePreview">
                                <i class="ti ti-x"></i>
                            </button>
                        </div>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                            name="image" accept="image/jpeg,image/jpg,image/png,image/webp" required>
                        <small class="form-text text-muted" id="image-size-hint">
                            Recommended size: 1920x600px (3.2:1). Max size: 2MB. Format: JPEG, PNG, WebP
                        </small>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Target URL -->
                    <div class="col-md-12 mb-3" id="target_url_field">
                        <label for="target_url" class="form-label">Target URL (Link)</label>
                        <input type="text" class="form-control @error('target_url') is-invalid @enderror"
                            id="target_url" name="target_url" value="{{ old('target_url') }}"
                            placeholder="/pricing atau https://example.com">
                        <small class="form-text text-muted">URL tujuan ketika banner diklik. Bisa relative (/pricing) atau absolute (https://...)</small>
                        @error('target_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Order Index -->
                    <div class="col-md-6 mb-3" id="order_index_field">
                        <label for="order_index" class="form-label">Display Order</label>
                        <input type="number" class="form-control @error('order_index') is-invalid @enderror"
                            id="order_index" name="order_index" value="{{ old('order_index', 0) }}" min="0">
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
                            id="start_date" name="start_date" value="{{ old('start_date') }}">
                        <small class="form-text text-muted">Leave empty for immediate display</small>
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- End Date -->
                    <div class="col-md-6 mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="datetime-local" class="form-control @error('end_date') is-invalid @enderror"
                            id="end_date" name="end_date" value="{{ old('end_date') }}">
                        <small class="form-text text-muted">Leave empty for no expiry</small>
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Is Active -->
                    <div class="col-md-12 mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                {{ old('is_active', true) ? 'checked' : '' }}>
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
                        <i class="ti ti-check me-1"></i> Create Banner
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
            const imagePreview = document.getElementById('imagePreview');
            const removePreview = document.getElementById('removePreview');
            const previewContainer = document.getElementById('previewContainer');

            // Preview image
            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        previewContainer.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Remove preview
            removePreview.addEventListener('click', function() {
                imageInput.value = '';
                imagePreview.src = '';
                previewContainer.style.display = 'none';
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
                    
                    imageSizeHint.textContent = 'Recommended size: 1500x600px (2.5:1). Max size: 2MB. Format: JPEG, PNG, WebP';
                    imagePreview.classList.remove('home-slider');
                    imagePreview.classList.add('banner-pricing');
                } else {
                    targetUrlField.style.display = 'block';
                    orderIndexField.style.display = 'block';
                    
                    imageSizeHint.textContent = 'Recommended size: 1920x600px (3.2:1). Max size: 2MB. Format: JPEG, PNG, WebP';
                    imagePreview.classList.remove('banner-pricing');
                    imagePreview.classList.add('home-slider');
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
                            type: bannerType
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
