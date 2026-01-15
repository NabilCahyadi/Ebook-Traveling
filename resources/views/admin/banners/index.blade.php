@extends('layouts.admin')

@section('title', __('admin.banners.title'))

@push('styles')
    <style>
        .banner-preview {
            position: relative;
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
        }

        .cursor-move {
            cursor: move;
        }

        .sortable-ghost {
            opacity: 0.4;
            background-color: #e3f2fd;
        }

        .action-buttons {
            gap: 0.25rem;
        }
    </style>
@endpush

@section('content')
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <span class="text-muted fw-light">{{ __('admin.menu.website_management') }} /</span> {{ __('admin.banners.hero_banners') }}
            </h4>
            <p class="mb-0">{{ __('admin.banners.description') }}</p>
        </div>
        <div>
            @if($activeTab === 'home-slider')
                <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">
                    <i class="ti ti-plus me-1"></i> {{ __('admin.banners.add_banner') }}
                </a>
            @elseif($activeTab === 'banner-pricing')
                @if($bannerPricing)
                    <button class="btn btn-secondary" disabled title="{{ __('admin.banners.banner_exists') }}">
                        <i class="ti ti-plus me-1"></i> {{ __('admin.banners.add_banner') }}
                    </button>
                @else
                    <a href="{{ route('admin.banners.create') }}?type=banner-pricing" class="btn btn-primary">
                        <i class="ti ti-plus me-1"></i> {{ __('admin.banners.add_banner') }}
                    </a>
                @endif
            @endif
        </div>
    </div>

    <!-- Tab Navigation -->
    <ul class="nav nav-tabs mb-4" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link {{ $activeTab === 'home-slider' ? 'active' : '' }}" 
               href="{{ route('admin.banners.index', ['tab' => 'home-slider']) }}">
                <i class="ti ti-photo me-1"></i> {{ __('admin.banners.home_slider') }}
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link {{ $activeTab === 'banner-pricing' ? 'active' : '' }}" 
               href="{{ route('admin.banners.index', ['tab' => 'banner-pricing']) }}">
                <i class="ti ti-tag me-1"></i> {{ __('admin.banners.banner_pricing') }}
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link {{ $activeTab === 'default-background' ? 'active' : '' }}" 
               href="{{ route('admin.banners.index', ['tab' => 'default-background']) }}">
                <i class="ti ti-photo-filled me-1"></i> Default Background
            </a>
        </li>
    </ul>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($activeTab === 'home-slider')
        <!-- Info Alert -->
        <div class="alert alert-info d-flex align-items-center" role="alert">
            <i class="ti ti-info-circle me-2"></i>
            <div>
                <strong>Tips:</strong> Banner dengan dimensi 1920x600px (3.2:1) akan terlihat sempurna. Format: JPEG, PNG,
                atau WebP.
            </div>
        </div>

        <!-- Banners Card -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Hero Banners List</h5>
                @if ($banners->count() > 1)
                    <div class="text-muted small">
                        <i class="ti ti-arrows-sort me-1"></i> Drag and drop to reorder
                    </div>
                @endif
            </div>
            <div class="card-body p-0">
                @if ($banners->isEmpty())
                <div class="text-center py-5">
                    <i class="ti ti-photo-off display-4 text-muted"></i>
                    <p class="mt-3 mb-2">No banners available</p>
                    <p class="text-muted mb-3">Create your first banner to display on homepage</p>
                    <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">
                        <i class="ti ti-plus me-1"></i> Create Banner
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="50">#</th>
                                <th width="150">Banner Image</th>
                                <th>Title</th>
                                <th width="150">Status</th>
                                <th width="100">Order</th>
                                <th width="200" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="sortable-banners">
                            @foreach ($banners as $banner)
                                <tr data-id="{{ $banner->id }}">
                                    <td>
                                        <i class="ti ti-grip-vertical cursor-move text-muted"></i>
                                    </td>
                                    <td>
                                        <img src="{{ $banner->image_url }}" alt="{{ $banner->title }}"
                                            class="banner-preview">
                                    </td>
                                    <td>
                                        <div>
                                            <h6 class="mb-1">{{ $banner->title }}</h6>
                                            @if ($banner->description)
                                                <small class="text-muted">{{ Str::limit($banner->description, 60) }}</small>
                                            @endif
                                            @if ($banner->target_url)
                                                <div class="mt-1">
                                                    <small class="text-primary">
                                                        <i class="ti ti-link ti-xs"></i>
                                                        {{ Str::limit($banner->target_url, 40) }}
                                                    </small>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input status-toggle" type="checkbox"
                                                data-id="{{ $banner->id }}" {{ $banner->is_active ? 'checked' : '' }}>
                                            <label class="form-check-label">
                                                <span class="badge {{ $banner->is_active ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $banner->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </label>
                                        </div>
                                        @if ($banner->start_date || $banner->end_date)
                                            <small class="text-muted d-block mt-1">
                                                @if ($banner->start_date)
                                                    From: {{ $banner->start_date->format('d M Y') }}<br>
                                                @endif
                                                @if ($banner->end_date)
                                                    Until: {{ $banner->end_date->format('d M Y') }}
                                                @endif
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-label-secondary order-badge">{{ $banner->order_index }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center action-buttons">
                                            <a href="{{ route('admin.banners.edit', $banner->id) }}"
                                                class="btn btn-sm btn-icon btn-label-primary" data-bs-toggle="tooltip"
                                                title="Edit">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-icon btn-label-danger"
                                                onclick="confirmDelete('{{ $banner->id }}')" data-bs-toggle="tooltip"
                                                title="Delete">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Delete Form (Hidden) -->
    <form id="delete-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
    @endif

@push('scripts')
    @if($activeTab === 'home-slider')
    <!-- SortableJS -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Sortable
            const sortableElement = document.getElementById('sortable-banners');

            if (sortableElement) {
                const sortable = new Sortable(sortableElement, {
                    handle: '.ti-grip-vertical',
                    animation: 150,
                    ghostClass: 'sortable-ghost',
                    onEnd: function(evt) {
                        updateBannerOrder();
                    }
                });
            }

            // Update banner order
            function updateBannerOrder() {
                const rows = document.querySelectorAll('#sortable-banners tr');
                const banners = [];

                rows.forEach(function(row, index) {
                    const badge = row.querySelector('.order-badge');
                    if (badge) {
                        badge.textContent = index;
                    }

                    banners.push({
                        id: row.dataset.id,
                        order_index: index
                    });
                });

                // Save to server
                fetch("{{ route('admin.banners.update-order') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            banners: banners
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast('success', data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('error', 'Failed to update order');
                    });
            }

            // Toggle status
            const statusToggles = document.querySelectorAll('.status-toggle');
            statusToggles.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const bannerId = this.dataset.id;
                    const badge = this.closest('td').querySelector('.badge');

                    fetch(`/admin/banners/${bannerId}/toggle-active`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                badge.textContent = data.is_active ? 'Active' : 'Inactive';
                                badge.className = data.is_active ? 'badge bg-success' :
                                    'badge bg-secondary';
                                showToast('success', data.message);
                            }
                        })
                        .catch(error => {
                            checkbox.checked = !checkbox.checked;
                            showToast('error', 'Failed to update status');
                        });
                });
            });

            // Show toast notification
            function showToast(type, message) {
                // Simple alert for now, can be replaced with toast library
                const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
                const alertHtml = `
                    <div class="alert ${alertClass} alert-dismissible fade show position-fixed top-0 end-0 m-3" role="alert" style="z-index: 9999;">
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `;
                document.body.insertAdjacentHTML('beforeend', alertHtml);

                setTimeout(() => {
                    const alert = document.querySelector('.alert');
                    if (alert) alert.remove();
                }, 3000);
            }
        });

        // Confirm delete
        function confirmDelete(bannerId) {
            if (confirm('Are you sure you want to delete this banner?')) {
                const form = document.getElementById('delete-form');
                form.action = `/admin/banners/${bannerId}`;
                form.submit();
            }
        }
    </script>
    @endif
@endpush

@if($activeTab === 'banner-pricing')
<!-- Banner Pricing Section -->
<div class="alert alert-info d-flex align-items-center" role="alert">
    <i class="ti ti-info-circle me-2"></i>
    <div>
        <strong>Info:</strong> Banner Pricing hanya boleh ada 1 banner. Dimensi yang disarankan: 1500x600px (2.5:1).
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Banner Pricing</h5>
    </div>
    <div class="card-body">
        @if($bannerPricing)
            <!-- Existing Banner -->
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="position-relative">
                        <img src="{{ asset('storage/' . $bannerPricing->image) }}" 
                             alt="{{ $bannerPricing->title }}" 
                             class="img-fluid rounded shadow-sm"
                             style="width: 100%; aspect-ratio: 2.5/1; object-fit: cover;">
                        <span class="badge position-absolute top-0 end-0 m-2 {{ $bannerPricing->is_active ? 'bg-success' : 'bg-secondary' }}">
                            {{ $bannerPricing->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <h4 class="mb-3">{{ $bannerPricing->title }}</h4>
                    @if($bannerPricing->description)
                    <p class="text-muted mb-3">{{ $bannerPricing->description }}</p>
                    @endif
                    
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1"><i class="ti ti-calendar me-1"></i> Period</small>
                        @if($bannerPricing->start_date || $bannerPricing->end_date)
                        <div class="d-flex gap-2 align-items-center">
                            <span class="badge bg-label-primary">{{ $bannerPricing->start_date ? $bannerPricing->start_date->format('d M Y') : 'Immediate' }}</span>
                            <i class="ti ti-arrow-right"></i>
                            <span class="badge bg-label-primary">{{ $bannerPricing->end_date ? $bannerPricing->end_date->format('d M Y') : 'No end' }}</span>
                        </div>
                        @else
                        <span class="text-muted">Always active</span>
                        @endif
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted"><i class="ti ti-photo me-1"></i> Image: {{ basename($bannerPricing->image) }}</small>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted"><i class="ti ti-clock me-1"></i> Last updated: {{ $bannerPricing->updated_at->diffForHumans() }}</small>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="d-flex gap-2 mt-4">
                        <a href="{{ route('admin.banners.edit', $bannerPricing->id) }}" class="btn btn-primary btn-sm">
                            <i class="ti ti-edit me-1"></i> Edit
                        </a>
                        <form action="{{ route('admin.banners.destroy', $bannerPricing->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus banner pricing ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="ti ti-trash me-1"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <!-- No Banner -->
            <div class="text-center py-5">
                <i class="ti ti-photo-off" style="font-size: 3rem; opacity: 0.3;"></i>
                <h5 class="mt-3 mb-2">Belum Ada Banner Pricing</h5>
                <p class="text-muted mb-4">Buat banner pricing untuk ditampilkan di halaman pricing</p>
                <a href="{{ route('admin.banners.create') }}?type=banner-pricing" class="btn btn-primary">
                    <i class="ti ti-plus me-1"></i> Buat Banner Pricing
                </a>
            </div>
        @endif
    </div>
@endif

<!-- Default Background Tab Content -->
@if($activeTab === 'default-background')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="ti ti-photo-filled me-2"></i>Default CTA Background</h5>
            <p class="text-muted mb-0 mt-2">Manage default background image for CTA sections</p>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.banners.update-default-background') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Current Background Preview -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">Current Background</label>
                    <div class="border rounded p-3 bg-light">
                        @php
                            $currentBg = \App\Models\SystemSetting::get('default_cta_background_path');
                            $bgUrl = $currentBg ? asset($currentBg) : asset('images/bg-default.webp');
                        @endphp
                        <img src="{{ $bgUrl }}" alt="Current Background" class="img-fluid rounded" 
                            style="max-height: 300px; width: 100%; object-fit: cover;" id="currentBgPreview">
                        <div class="mt-2">
                            <small class="text-muted">
                                <i class="ti ti-info-circle me-1"></i>
                                Current: <strong>{{ $currentBg ?: 'images/bg-default.webp' }}</strong>
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Upload New Background -->
                <div class="mb-4">
                    <label for="background_image" class="form-label fw-semibold">
                        Upload New Background <span class="text-danger">*</span>
                    </label>
                    <input type="file" class="form-control @error('background_image') is-invalid @enderror" 
                        id="background_image" name="background_image" accept="image/*" required>
                    @error('background_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">
                        <i class="ti ti-info-circle me-1"></i>
                        Recommended dimensions same as bg-default.webp. Max file size: 2MB. Image will be auto-compressed.
                    </div>
                </div>

                <!-- Preview New Image -->
                <div class="mb-4" id="newPreviewContainer" style="display: none;">
                    <label class="form-label fw-semibold">Preview New Background</label>
                    <div class="border rounded p-3">
                        <img id="newBgPreview" src="" alt="New Background Preview" class="img-fluid rounded" 
                            style="max-height: 300px; width: 100%; object-fit: cover;">
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-device-floppy me-1"></i> Save Background
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="document.getElementById('background_image').value=''; document.getElementById('newPreviewContainer').style.display='none';">
                        <i class="ti ti-x me-1"></i> Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
@endif
@endsection

@push('scripts')
<script>
    // Preview new background image before upload
    document.getElementById('background_image')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('newBgPreview').src = event.target.result;
                document.getElementById('newPreviewContainer').style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
