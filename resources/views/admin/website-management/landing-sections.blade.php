@extends('layouts.admin')

@section('title', 'Manage Landing Page Sections')

@push('styles')
    <style>
        .cursor-move {
            cursor: move;
        }

        .sortable-ghost {
            opacity: 0.4;
            background-color: #e3f2fd;
        }

        .sortable-drag {
            opacity: 0.8;
        }

        .section-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-size: 20px;
        }
    </style>
@endpush

@section('content')
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <span class="text-muted fw-light">Website Management /</span> Landing Page Sections
            </h4>
            <p class="mb-0">Atur urutan dan visibility semua section di landing page</p>
        </div>
        <div>
            <a href="{{ route('admin.landing-section.create') }}" class="btn btn-success me-2">
                <i class="ti ti-plus me-1"></i> Add New Section
            </a>
            <button type="button" class="btn btn-primary" id="saveOrder">
                <i class="ti ti-device-floppy me-1"></i> Save Changes
            </button>
        </div>
    </div>

    <!-- Success/Error Messages -->
    <div id="alert-container"></div>

    <!-- Sections List Card -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Landing Page Sections</h5>
            <div class="text-muted small">
                <i class="ti ti-arrows-sort me-1"></i> Drag and drop to reorder
            </div>
        </div>
        <div class="card-body">
            @if ($sections->isEmpty())
                <div class="text-center py-5">
                    <i class="ti ti-box-off display-4 text-muted"></i>
                    <p class="mt-3 mb-0">No sections available. Please run seeder to initialize sections.</p>
                    <button class="btn btn-primary mt-3" onclick="window.location.reload()">
                        <i class="ti ti-refresh me-1"></i> Refresh
                    </button>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th width="50">#</th>
                                <th width="80">Order</th>
                                <th width="60">Icon</th>
                                <th>Section Name</th>
                                <th>Type</th>
                                <th>Template</th>
                                <th width="150">Visibility</th>
                                <th width="120" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="sortable-sections">
                            @foreach ($sections as $section)
                                <tr data-id="{{ $section->id }}" data-order="{{ $section->order }}" class="section-row">
                                    <td>
                                        <i class="ti ti-grip-vertical cursor-move text-muted"></i>
                                    </td>
                                    <td>
                                        <span class="badge bg-label-secondary order-badge">{{ $section->order }}</span>
                                    </td>
                                    <td>
                                        <div
                                            class="section-icon {{ $section->is_visible ? 'bg-label-primary' : 'bg-label-secondary' }}">
                                            @switch($section->section_type)
                                                @case('hero_banner')
                                                    <i class="ti ti-photo"></i>
                                                @break

                                                @case('top_cities')
                                                    <i class="ti ti-map-pin"></i>
                                                @break

                                                @case('subscription_plans')
                                                    <i class="ti ti-crown"></i>
                                                @break

                                                @case('collection')
                                                    <i class="ti ti-books"></i>
                                                @break

                                                @case('latest_blogs')
                                                    <i class="ti ti-article"></i>
                                                @break

                                                @default
                                                    <i class="ti ti-box"></i>
                                            @endswitch
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-0">{{ $section->section_title ?: $section->section_name }}</h6>
                                            @if ($section->section_type === 'collection' && $section->collection)
                                                <small class="text-muted">Collection:
                                                    {{ $section->collection->name }}</small>
                                            @elseif ($section->filter_config)
                                                <small class="text-muted">Filter:
                                                    {{ ucwords(str_replace('_', ' ', $section->filter_config['filter_type'] ?? 'custom')) }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-label-info">
                                            {{ str_replace('_', ' ', ucwords($section->section_type)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-label-secondary">
                                            {{ ucwords($section->card_template ?? 'default') }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input visibility-toggle" type="checkbox"
                                                data-id="{{ $section->id }}" {{ $section->is_visible ? 'checked' : '' }}>
                                            <label class="form-check-label">
                                                <span class="visibility-text">
                                                    {{ $section->is_visible ? 'Visible' : 'Hidden' }}
                                                </span>
                                            </label>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-icon btn-text-primary preview-section"
                                            data-id="{{ $section->id }}" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Preview Section">
                                            <i class="ti ti-eye"></i>
                                        </button>
                                        @if ($section->section_type === 'collection')
                                            <button type="button"
                                                class="btn btn-sm btn-icon btn-text-danger delete-section"
                                                data-id="{{ $section->id }}" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Delete Section">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Add Section Modal -->
    <div class="modal fade" id="addSectionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Custom Section</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Section Title -->
                    <div class="mb-3">
                        <label for="sectionTitle" class="form-label">Section Title <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="sectionTitle"
                            placeholder="e.g., Best Seller Ebooks, New Releases">
                        <div class="form-text">Judul yang akan ditampilkan di landing page</div>
                    </div>

                    <!-- Data Source -->
                    <div class="mb-3">
                        <label for="dataSource" class="form-label">Data Source <span class="text-danger">*</span></label>
                        <select class="form-select" id="dataSource">
                            <option value="">-- Select Data Source --</option>
                            <option value="collection">Collection (Existing)</option>
                            <option value="custom_ebooks">Custom Ebooks Filter</option>
                        </select>
                        <div class="form-text">Pilih sumber data untuk section ini</div>
                    </div>

                    <!-- Collection Selection (if data source = collection) -->
                    <div class="mb-3" id="collectionSelectWrapper" style="display: none;">
                        <label for="collectionSelect" class="form-label">Select Collection</label>
                        <select class="form-select" id="collectionSelect">
                            <option value="">-- Choose Collection --</option>
                            @foreach ($collections as $collection)
                                <option value="{{ $collection->id }}">{{ $collection->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Custom Filter (if data source = custom_ebooks) -->
                    <div id="customFilterWrapper" style="display: none;">
                        <div class="row">
                            <!-- Filter Type -->
                            <div class="col-md-6 mb-3">
                                <label for="filterType" class="form-label">Filter By</label>
                                <select class="form-select" id="filterType">
                                    <option value="latest">Latest Ebooks</option>
                                    <option value="popular">Most Popular (by views)</option>
                                    <option value="top_rated">Top Rated</option>
                                    <option value="category">By Category</option>
                                    <option value="city">By City</option>
                                    <option value="language">By Language</option>
                                </select>
                            </div>

                            <!-- Limit -->
                            <div class="col-md-6 mb-3">
                                <label for="ebookLimit" class="form-label">Number of Ebooks</label>
                                <input type="number" class="form-control" id="ebookLimit" value="10"
                                    min="1" max="50">
                            </div>
                        </div>

                        <!-- Category Filter (conditional) -->
                        <div class="mb-3" id="categoryFilterWrapper" style="display: none;">
                            <label for="categoryFilter" class="form-label">Select Category</label>
                            <select class="form-select" id="categoryFilter">
                                <option value="">-- Choose Category --</option>
                                @foreach (\App\Models\Category::where('is_active', true)->orderBy('name')->get() as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- City Filter (conditional) -->
                        <div class="mb-3" id="cityFilterWrapper" style="display: none;">
                            <label for="cityFilter" class="form-label">Select City</label>
                            <select class="form-select" id="cityFilter">
                                <option value="">-- Choose City --</option>
                                @foreach (\App\Models\City::where('is_active', true)->orderBy('name')->get() as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Language Filter (conditional) -->
                        <div class="mb-3" id="languageFilterWrapper" style="display: none;">
                            <label for="languageFilter" class="form-label">Select Language</label>
                            <select class="form-select" id="languageFilter">
                                <option value="">-- Choose Language --</option>
                                <option value="id">Indonesian</option>
                                <option value="en">English</option>
                            </select>
                        </div>

                        <!-- Card Template Selection -->
                        <div class="mb-3">
                            <label for="cardTemplate" class="form-label">Card Template <span
                                    class="text-danger">*</span></label>
                            <select class="form-select" id="cardTemplate">
                                <option value="default" selected>Default - Standard card dengan gambar & info lengkap
                                </option>
                                <option value="compact">Compact - Card lebih kecil untuk tampilan padat</option>
                                <option value="grid">Grid - Layout grid 3 kolom dengan emphasis pada cover</option>
                                <option value="list">List - Tampilan list horizontal dengan detail lengkap</option>
                            </select>
                            <div class="form-text">Pilih template tampilan card untuk section ini</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="addSectionBtn">
                        <i class="ti ti-plus me-1"></i> Add Section
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Preview Modal -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewModalLabel">
                        <i class="ti ti-eye me-2"></i>Section Preview
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0" id="previewContent">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-3 text-muted">Loading preview...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- SortableJS -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Sortable
            const sortableElement = document.getElementById('sortable-sections');

            if (sortableElement) {
                const sortable = new Sortable(sortableElement, {
                    handle: '.cursor-move',
                    animation: 150,
                    ghostClass: 'sortable-ghost',
                    dragClass: 'sortable-drag',
                    onEnd: function(evt) {
                        updateOrderNumbers();
                    }
                });
            }

            // Update order numbers after drag and drop (bukan saat page load)
            function updateOrderNumbers() {
                const rows = document.querySelectorAll('#sortable-sections tr');
                rows.forEach(function(row, index) {
                    const badge = row.querySelector('.order-badge');
                    if (badge) {
                        badge.textContent = index;
                    }
                });
            }

            // Save order button
            const saveButton = document.getElementById('saveOrder');
            if (saveButton) {
                saveButton.addEventListener('click', function() {
                    const sections = [];
                    const rows = document.querySelectorAll('#sortable-sections tr');

                    rows.forEach(function(row, index) {
                        const checkbox = row.querySelector('.visibility-toggle');
                        sections.push({
                            id: row.dataset.id,
                            order: index,
                            is_visible: checkbox ? checkbox.checked : true
                        });
                    });

                    // Show loading
                    saveButton.disabled = true;
                    saveButton.innerHTML =
                        '<span class="spinner-border spinner-border-sm me-1"></span> Saving...';

                    fetch("{{ route('admin.landing-sections.update') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                sections: sections
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            showAlert('success', data.message);
                            saveButton.disabled = false;
                            saveButton.innerHTML =
                                '<i class="ti ti-device-floppy me-1"></i> Save Changes';
                        })
                        .catch(error => {
                            showAlert('danger', 'Failed to save landing page sections');
                            saveButton.disabled = false;
                            saveButton.innerHTML =
                                '<i class="ti ti-device-floppy me-1"></i> Save Changes';
                        });
                });
            }

            // Preview section handler
            document.querySelectorAll('.preview-section').forEach(button => {
                button.addEventListener('click', function() {
                    const sectionId = this.dataset.id;
                    const previewModal = new bootstrap.Modal(document.getElementById(
                        'previewModal'));
                    const previewContent = document.getElementById('previewContent');

                    // Reset content with loading state
                    previewContent.innerHTML = `
                        <div class="text-center py-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-3 text-muted">Loading preview...</p>
                        </div>
                    `;

                    // Show modal
                    previewModal.show();

                    // Load preview content with AJAX headers
                    fetch(`{{ url('/admin/landing-section') }}/${sectionId}/preview`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'text/html'
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.text();
                        })
                        .then(html => {
                            previewContent.innerHTML = html;
                        })
                        .catch(error => {
                            console.error('Preview error:', error);
                            previewContent.innerHTML = `
                                <div class="text-center py-5">
                                    <i class="ti ti-alert-circle display-4 text-danger"></i>
                                    <p class="mt-3 text-danger">Failed to load preview: ${error.message}</p>
                                    <button class="btn btn-sm btn-primary" onclick="location.reload()">
                                        <i class="ti ti-refresh me-1"></i>Retry
                                    </button>
                                </div>
                            `;
                        });
                });
            });

            // Toggle visibility
            const visibilityToggles = document.querySelectorAll('.visibility-toggle');
            visibilityToggles.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const sectionId = this.dataset.id;
                    const isVisible = this.checked;
                    const visibilityText = this.closest('td').querySelector('.visibility-text');
                    const icon = this.closest('tr').querySelector('.section-icon');

                    fetch(`/admin/landing-section/${sectionId}/toggle-visibility`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                is_visible: isVisible
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (visibilityText) {
                                visibilityText.textContent = isVisible ? 'Visible' : 'Hidden';
                            }
                            if (icon) {
                                icon.classList.toggle('bg-label-primary', isVisible);
                                icon.classList.toggle('bg-label-secondary', !isVisible);
                            }
                            showAlert('success', data.message, 3000);
                        })
                        .catch(error => {
                            // Revert checkbox state
                            checkbox.checked = !isVisible;
                            showAlert('danger', 'Failed to update visibility');
                        });
                });
            });

            // Data source change handler
            const dataSourceSelect = document.getElementById('dataSource');
            const collectionSelectWrapper = document.getElementById('collectionSelectWrapper');
            const customFilterWrapper = document.getElementById('customFilterWrapper');

            if (dataSourceSelect) {
                dataSourceSelect.addEventListener('change', function() {
                    const value = this.value;
                    if (value === 'collection') {
                        collectionSelectWrapper.style.display = 'block';
                        customFilterWrapper.style.display = 'none';
                    } else if (value === 'custom_ebooks') {
                        collectionSelectWrapper.style.display = 'none';
                        customFilterWrapper.style.display = 'block';
                    } else {
                        collectionSelectWrapper.style.display = 'none';
                        customFilterWrapper.style.display = 'none';
                    }
                });
            }

            // Filter type change handler
            const filterTypeSelect = document.getElementById('filterType');
            const categoryFilterWrapper = document.getElementById('categoryFilterWrapper');
            const cityFilterWrapper = document.getElementById('cityFilterWrapper');
            const languageFilterWrapper = document.getElementById('languageFilterWrapper');

            if (filterTypeSelect) {
                filterTypeSelect.addEventListener('change', function() {
                    const value = this.value;
                    categoryFilterWrapper.style.display = value === 'category' ? 'block' : 'none';
                    cityFilterWrapper.style.display = value === 'city' ? 'block' : 'none';
                    languageFilterWrapper.style.display = value === 'language' ? 'block' : 'none';
                });
            }

            // Add new collection section
            const addSectionBtn = document.getElementById('addSectionBtn');
            if (addSectionBtn) {
                addSectionBtn.addEventListener('click', function() {
                    const sectionTitle = document.getElementById('sectionTitle').value.trim();
                    const dataSource = document.getElementById('dataSource').value;
                    const cardTemplate = document.getElementById('cardTemplate').value;

                    // Validation
                    if (!sectionTitle) {
                        showAlert('warning', 'Please enter a section title');
                        return;
                    }

                    if (!dataSource) {
                        showAlert('warning', 'Please select a data source');
                        return;
                    }

                    const requestData = {
                        section_title: sectionTitle,
                        data_source: dataSource,
                        card_template: cardTemplate
                    };

                    // Add data based on source type
                    if (dataSource === 'collection') {
                        const collectionId = document.getElementById('collectionSelect').value;
                        if (!collectionId) {
                            showAlert('warning', 'Please select a collection');
                            return;
                        }
                        requestData.collection_id = collectionId;
                    } else if (dataSource === 'custom_ebooks') {
                        const filterType = document.getElementById('filterType').value;
                        const ebookLimit = document.getElementById('ebookLimit').value;

                        requestData.filter_type = filterType;
                        requestData.ebook_limit = ebookLimit;

                        // Add conditional filters
                        if (filterType === 'category') {
                            const categoryId = document.getElementById('categoryFilter').value;
                            if (!categoryId) {
                                showAlert('warning', 'Please select a category');
                                return;
                            }
                            requestData.category_id = categoryId;
                        } else if (filterType === 'city') {
                            const cityId = document.getElementById('cityFilter').value;
                            if (!cityId) {
                                showAlert('warning', 'Please select a city');
                                return;
                            }
                            requestData.city_id = cityId;
                        } else if (filterType === 'language') {
                            const language = document.getElementById('languageFilter').value;
                            if (!language) {
                                showAlert('warning', 'Please select a language');
                                return;
                            }
                            requestData.language = language;
                        }
                    }

                    // Show loading
                    addSectionBtn.disabled = true;
                    addSectionBtn.innerHTML =
                        '<span class="spinner-border spinner-border-sm me-1"></span> Adding...';

                    fetch('{{ route('admin.landing-sections.add') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify(requestData)
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showAlert('success', data.message);
                                // Reload page after 1 second
                                setTimeout(() => window.location.reload(), 1000);
                            } else {
                                showAlert('danger', data.message);
                                addSectionBtn.disabled = false;
                                addSectionBtn.innerHTML = '<i class="ti ti-plus me-1"></i> Add Section';
                            }
                        })
                        .catch(error => {
                            showAlert('danger', 'Failed to add section');
                            addSectionBtn.disabled = false;
                            addSectionBtn.innerHTML = '<i class="ti ti-plus me-1"></i> Add Section';
                        });
                });
            }

            // Delete collection section
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('delete-section') || e.target.closest('.delete-section')) {
                    const button = e.target.classList.contains('delete-section') ? e.target : e.target
                        .closest('.delete-section');
                    const sectionId = button.dataset.id;

                    if (!confirm('Are you sure you want to delete this collection section?')) {
                        return;
                    }

                    fetch(`/admin/landing-section/${sectionId}/delete`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showAlert('success', data.message);
                                // Remove row from table
                                button.closest('tr').remove();
                                // Update order numbers
                                updateOrderNumbers();
                            } else {
                                showAlert('danger', data.message);
                            }
                        })
                        .catch(error => {
                            showAlert('danger', 'Failed to delete section');
                        });
                }
            });

            // Show alert helper
            function showAlert(type, message, duration = 5000) {
                const alertContainer = document.getElementById('alert-container');
                const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
                alertContainer.innerHTML = alertHtml;

                setTimeout(function() {
                    const alert = alertContainer.querySelector('.alert');
                    if (alert) {
                        alert.classList.remove('show');
                        setTimeout(() => alert.remove(), 150);
                    }
                }, duration);
            }
        });
    </script>
@endpush
