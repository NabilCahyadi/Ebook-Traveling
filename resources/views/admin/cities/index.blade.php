@extends('layouts.admin')

@section('title', 'Cities Management')

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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold py-3 mb-2">
                    <span class="text-muted fw-light">Master Data /</span> Cities
                </h4>
            </div>
            <div class="d-flex gap-2">
                <!-- View Toggle -->
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-primary" id="cardViewBtn" onclick="switchView('card')">
                        <i class="ti ti-layout-grid me-1"></i> Cards
                    </button>
                    <button type="button" class="btn btn-outline-primary" id="tableViewBtn" onclick="switchView('table')">
                        <i class="ti ti-table me-1"></i> Table
                    </button>
                </div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class="ti ti-plus me-1"></i> Add New City
                </button>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.cities.index') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="search" class="form-label">Search</label>
                            <input type="text" class="form-control" id="search" name="search"
                                value="{{ request('search') }}" placeholder="Search by city name or province...">
                        </div>
                        <div class="col-md-3">
                            <label for="province" class="form-label">Filter by Province</label>
                            <select class="form-select" id="province" name="province">
                                <option value="">All Provinces</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province }}"
                                        {{ request('province') == $province ? 'selected' : '' }}>
                                        {{ $province }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="sort_by" class="form-label">Sort By</label>
                            <select class="form-select" id="sort_by" name="sort_by">
                                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Date
                                </option>
                                <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Name</option>
                                <option value="province" {{ request('sort_by') == 'province' ? 'selected' : '' }}>Province
                                </option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="sort_order" class="form-label">Order</label>
                            <select class="form-select" id="sort_order" name="sort_order">
                                <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Ascending
                                </option>
                                <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Descending
                                </option>
                            </select>
                        </div>
                        <div class="col-md-1 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="ti ti-search"></i>
                            </button>
                        </div>
                        @if (request()->hasAny(['search', 'province', 'sort_by', 'sort_order']))
                            <div class="col-12">
                                <a href="{{ route('admin.cities.index') }}" class="btn btn-label-secondary">
                                    <i class="ti ti-x me-1"></i> Clear Filters
                                </a>
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Cities Cards -->
        @if ($cities->count() > 0)
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <div class="text-muted">Total: {{ $cities->total() }} cities</div>
                <div class="text-muted">
                    Showing {{ $cities->firstItem() }} to {{ $cities->lastItem() }} of {{ $cities->total() }} results
                </div>
            </div>

            <!-- Card View -->
            <div id="cardView" class="row g-4 mb-4">
                @foreach ($cities as $city)
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="card h-100 shadow-sm">
                            <!-- Image Header -->
                            <div class="position-relative"
                                style="height: 200px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); overflow: hidden;">
                                <div class="position-absolute top-0 end-0 m-2">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-icon btn-white" type="button"
                                            data-bs-toggle="dropdown">
                                            <i class="ti ti-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="javascript:void(0);"
                                                    onclick="editCity('{{ $city->id }}', '{{ $city->name }}', '{{ $city->province }}', '{{ $city->image ? asset($city->image) : '' }}')">
                                                    <i class="ti ti-pencil me-2"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.cities.destroy', $city->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this city?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="ti ti-trash me-2"></i> Delete
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- City Image -->
                                @if ($city->image)
                                    <img src="{{ asset($city->image) }}" alt="{{ $city->name }}"
                                        style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <div class="d-flex align-items-center justify-content-center h-100">
                                        <div class="text-center text-white">
                                            <i class="ti ti-map-pin" style="font-size: 64px; opacity: 0.3;"></i>
                                            <div class="mt-2"
                                                style="font-size: 24px; font-weight: 600; text-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                                                {{ $city->name }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Card Body -->
                            <div class="card-body">
                                <h5 class="card-title mb-2" style="font-weight: 600;">{{ $city->name }}</h5>
                                <p class="text-muted mb-2" style="font-size: 14px;">
                                    <i class="ti ti-map ti-xs me-1"></i>{{ $city->province }}
                                </p>
                                <small class="text-muted">
                                    <i class="ti ti-calendar ti-xs me-1"></i>{{ $city->created_at->format('d M Y') }}
                                </small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Table View -->
            <div id="tableView" class="card mb-4" style="display: none;">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>City Name</th>
                                    <th>Province</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cities as $city)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if ($city->image)
                                                    <div class="avatar avatar-sm me-2">
                                                        <img src="{{ asset($city->image) }}" alt="{{ $city->name }}"
                                                            class="rounded"
                                                            style="width: 38px; height: 38px; object-fit: cover;">
                                                    </div>
                                                @else
                                                    <div class="avatar avatar-sm me-2"
                                                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                                        <span class="avatar-initial rounded">
                                                            <i class="ti ti-map-pin text-white"></i>
                                                        </span>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="fw-medium">{{ $city->name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-label-primary">{{ $city->province }}</span>
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ $city->created_at->format('d M Y') }}</small>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button"
                                                    class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                        onclick="editCity('{{ $city->id }}', '{{ $city->name }}', '{{ $city->province }}', '{{ $city->image ? asset($city->image) : '' }}')">
                                                        <i class="ti ti-pencil me-2"></i> Edit
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <form action="{{ route('admin.cities.destroy', $city->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this city?');"
                                                        style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="ti ti-trash me-2"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $cities->links() }}
            </div>
        @else
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="ti ti-map-off ti-xl text-muted mb-3"></i>
                    <h5 class="text-muted">No cities found</h5>
                    <p class="text-muted">Start by creating your first city</p>
                    <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal"
                        data-bs-target="#createModal">
                        <i class="ti ti-plus me-1"></i> Add New City
                    </button>
                </div>
            </div>
        @endif
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admin.cities.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Create New City</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">City Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" placeholder="e.g. Bali" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="province" class="form-label">Province <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('province') is-invalid @enderror"
                                id="province" name="province" value="{{ old('province') }}"
                                placeholder="e.g. Jawa Barat" required>
                            @error('province')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="cityImageInput" class="form-label">City Image (Ratio 4:3)</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                id="cityImageInput" name="image" accept="image/*">
                            <small class="text-muted">Gambar akan otomatis di-crop ke rasio 4:3 (980x735px). Max
                                2MB.</small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Preview Area Create -->
                        <div id="cityPreviewArea" style="display: none;" class="mb-3">
                            <label class="form-label">Preview (Auto-cropped)</label>
                            <div style="max-width: 300px;">
                                <img id="cityPreviewImage" src="" alt="Preview"
                                    style="width: 100%; border: 2px solid #ddd; border-radius: 8px;">
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-secondary mt-2"
                                onclick="resetCityImage()">
                                <i class="ti ti-x me-1"></i> Hapus
                            </button>
                        </div>

                        <!-- Hidden input untuk menyimpan hasil crop -->
                        <input type="hidden" name="city_image_cropped" id="cityCroppedImageData">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-1"></i> Create City
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="editForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit City</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">City Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_name" name="name"
                                placeholder="e.g. Bali" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_province" class="form-label">Province <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_province" name="province"
                                placeholder="e.g. Jawa Barat" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Current Image</label>
                            <div id="edit_current_image" class="mb-2">
                                <!-- Will be populated by JavaScript -->
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editCityImageInput" class="form-label">Change City Image (Ratio 4:3)</label>
                            <input type="file" class="form-control" id="editCityImageInput" name="image"
                                accept="image/*">
                            <small class="text-muted">Gambar akan otomatis di-crop ke rasio 4:3 (980x735px). Max
                                2MB.</small>
                        </div>

                        <!-- Preview Area Edit -->
                        <div id="editCityPreviewArea" style="display: none;" class="mb-3">
                            <label class="form-label">Preview (Auto-cropped)</label>
                            <div style="max-width: 300px;">
                                <img id="editCityPreviewImage" src="" alt="Preview"
                                    style="width: 100%; border: 2px solid #ddd; border-radius: 8px;">
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-secondary mt-2"
                                onclick="resetEditCityImage()">
                                <i class="ti ti-x me-1"></i> Hapus
                            </button>
                        </div>

                        <!-- Hidden input untuk menyimpan hasil crop -->
                        <input type="hidden" name="city_image_cropped" id="editCityCroppedImageData">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-1"></i> Update City
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // View switcher
            let currentView = localStorage.getItem('citiesView') || 'card';

            function switchView(view) {
                currentView = view;
                localStorage.setItem('citiesView', view);

                if (view === 'card') {
                    document.getElementById('cardView').style.display = 'flex';
                    document.getElementById('tableView').style.display = 'none';
                    document.getElementById('cardViewBtn').classList.add('active');
                    document.getElementById('tableViewBtn').classList.remove('active');
                } else {
                    document.getElementById('cardView').style.display = 'none';
                    document.getElementById('tableView').style.display = 'block';
                    document.getElementById('cardViewBtn').classList.remove('active');
                    document.getElementById('tableViewBtn').classList.add('active');
                }
            }

            // Initialize view on page load
            document.addEventListener('DOMContentLoaded', function() {
                switchView(currentView);
            });

            function editCity(id, name, province, image = null) {
                document.getElementById('editForm').action = '/admin/cities/' + id;
                document.getElementById('edit_name').value = name;
                document.getElementById('edit_province').value = province;

                // Display current image
                const imageContainer = document.getElementById('edit_current_image');
                if (image) {
                    imageContainer.innerHTML = `
                        <img src="${image}" alt="${name}" style="max-width: 150px; border-radius: 8px; border: 2px solid #ddd;">
                    `;
                } else {
                    imageContainer.innerHTML = `
                        <div class="bg-label-secondary rounded d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                            <i class="ti ti-map-pin" style="font-size: 48px;"></i>
                        </div>
                    `;
                }

                new bootstrap.Modal(document.getElementById('editModal')).show();
            }

            // Show create modal if validation error exists
            @if ($errors->any())
                new bootstrap.Modal(document.getElementById('createModal')).show();
            @endif

            // ========================================
            // AUTO CROP FOR CITY IMAGES - RATIO 4:3 (980x735px)
            // ========================================
            (function() {
                const CITY_CROP_CONFIG = {
                    ratioWidth: 4,
                    ratioHeight: 3,
                    minWidth: 600,
                    minHeight: 450,
                    maxFileSize: 2 * 1024 * 1024,
                    outputWidth: 980,
                    outputHeight: 735,
                    quality: 0.90,
                    outputFormat: 'image/jpeg'
                };

                // CREATE MODAL - Auto Crop
                const cityImageInput = document.getElementById('cityImageInput');
                const cityCroppedImageData = document.getElementById('cityCroppedImageData');
                const cityPreviewArea = document.getElementById('cityPreviewArea');
                const cityPreviewImage = document.getElementById('cityPreviewImage');

                if (cityImageInput && cityCroppedImageData) {
                    cityImageInput.addEventListener('change', function(e) {
                        const file = e.target.files[0];
                        if (!file) return;

                        if (file.size > CITY_CROP_CONFIG.maxFileSize) {
                            alert('File terlalu besar. Maksimal 2MB.');
                            cityImageInput.value = '';
                            return;
                        }

                        if (!file.type.match('image.*')) {
                            alert('File harus berupa gambar (JPG, PNG, atau WEBP)');
                            cityImageInput.value = '';
                            return;
                        }

                        const reader = new FileReader();
                        reader.onload = function(event) {
                            const img = new Image();
                            img.onload = function() {
                                autoCropCityImage(img, cityCroppedImageData, cityPreviewImage,
                                    cityPreviewArea);
                            };
                            img.src = event.target.result;
                        };
                        reader.readAsDataURL(file);
                    });
                }

                // EDIT MODAL - Auto Crop
                const editCityImageInput = document.getElementById('editCityImageInput');
                const editCityCroppedImageData = document.getElementById('editCityCroppedImageData');
                const editCityPreviewArea = document.getElementById('editCityPreviewArea');
                const editCityPreviewImage = document.getElementById('editCityPreviewImage');

                if (editCityImageInput && editCityCroppedImageData) {
                    editCityImageInput.addEventListener('change', function(e) {
                        const file = e.target.files[0];
                        if (!file) return;

                        if (file.size > CITY_CROP_CONFIG.maxFileSize) {
                            alert('File terlalu besar. Maksimal 2MB.');
                            editCityImageInput.value = '';
                            return;
                        }

                        if (!file.type.match('image.*')) {
                            alert('File harus berupa gambar (JPG, PNG, atau WEBP)');
                            editCityImageInput.value = '';
                            return;
                        }

                        const reader = new FileReader();
                        reader.onload = function(event) {
                            const img = new Image();
                            img.onload = function() {
                                autoCropCityImage(img, editCityCroppedImageData, editCityPreviewImage,
                                    editCityPreviewArea);
                            };
                            img.src = event.target.result;
                        };
                        reader.readAsDataURL(file);
                    });
                }

                function autoCropCityImage(image, croppedDataElement, previewElement, previewAreaElement) {
                    const targetRatio = CITY_CROP_CONFIG.ratioWidth / CITY_CROP_CONFIG.ratioHeight;
                    const sourceWidth = image.width;
                    const sourceHeight = image.height;
                    const sourceRatio = sourceWidth / sourceHeight;

                    let cropWidth, cropHeight, cropX, cropY;

                    if (sourceRatio > targetRatio) {
                        // Image lebih lebar - crop width
                        cropHeight = sourceHeight;
                        cropWidth = sourceHeight * targetRatio;
                        cropX = (sourceWidth - cropWidth) / 2;
                        cropY = 0;
                    } else {
                        // Image lebih tinggi - crop height
                        cropWidth = sourceWidth;
                        cropHeight = sourceWidth / targetRatio;
                        cropX = 0;
                        cropY = (sourceHeight - cropHeight) / 2;
                    }

                    // TIDAK ada minimum size - gambar kecil akan diperbesar, besar akan dikompres
                    // Semua akan di-resize ke 980x735px

                    const canvas = document.createElement('canvas');
                    canvas.width = CITY_CROP_CONFIG.outputWidth;
                    canvas.height = CITY_CROP_CONFIG.outputHeight;

                    const ctx = canvas.getContext('2d');
                    ctx.imageSmoothingEnabled = true;
                    ctx.imageSmoothingQuality = 'high';

                    ctx.drawImage(
                        image,
                        cropX, cropY, cropWidth, cropHeight,
                        0, 0, CITY_CROP_CONFIG.outputWidth, CITY_CROP_CONFIG.outputHeight
                    );

                    canvas.toBlob(function(blob) {
                        const reader = new FileReader();
                        reader.onloadend = function() {
                            const base64Data = reader.result;
                            croppedDataElement.value = base64Data;

                            previewElement.src = base64Data;
                            previewAreaElement.style.display = 'block';

                            console.log('City image cropped to 980x735px (4:3 ratio)');
                        };
                        reader.readAsDataURL(blob);
                    }, CITY_CROP_CONFIG.outputFormat, CITY_CROP_CONFIG.quality);
                }

                window.resetCityImage = function() {
                    cityImageInput.value = '';
                    cityCroppedImageData.value = '';
                    cityPreviewArea.style.display = 'none';
                };

                window.resetEditCityImage = function() {
                    editCityImageInput.value = '';
                    editCityCroppedImageData.value = '';
                    editCityPreviewArea.style.display = 'none';
                };
            })();
        </script>
    @endpush

    @push('styles')
        <style>
            /* Fix pagination styling */
            .pagination {
                margin: 0;
            }

            .pagination .page-link {
                padding: 0.375rem 0.75rem;
                font-size: 0.9375rem;
            }
        </style>
    @endpush
@endsection
