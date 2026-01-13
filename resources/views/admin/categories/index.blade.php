@extends('layouts.admin')

@section('title', __('admin.categories.title'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ __('admin.messages.success_title') }}</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ __('admin.messages.error_title') }}</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold py-3 mb-2">
                    <span class="text-muted fw-light">Master Data /</span> {{ __('admin.menu.categories') }}
                </h4>
            </div>
            <div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class="ti ti-plus me-1"></i> {{ __('admin.categories.add_category') }}
                </button>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.categories.index') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-5">
                            <label for="search" class="form-label">{{ __('admin.common.search') }}</label>
                            <input type="text" class="form-control" id="search" name="search"
                                value="{{ request('search') }}" placeholder="Search by category name or slug...">
                        </div>
                        <div class="col-md-3">
                            <label for="sort_by" class="form-label">{{ __('admin.common.sort') }} By</label>
                            <select class="form-select" id="sort_by" name="sort_by">
                                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>{{ __('admin.common.date') }}
                                    Created</option>
                                <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>{{ __('admin.form.name') }}</option>
                                <option value="ebooks_count" {{ request('sort_by') == 'ebooks_count' ? 'selected' : '' }}>
                                    Ebooks Count</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="sort_order" class="form-label">{{ __('admin.form.order') }}</label>
                            <select class="form-select" id="sort_order" name="sort_order">
                                <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Ascending
                                </option>
                                <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Descending
                                </option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <i class="ti ti-search"></i>
                            </button>
                            @if (request()->hasAny(['search', 'sort_by', 'sort_order']))
                                <a href="{{ route('admin.categories.index') }}" class="btn btn-label-secondary"
                                    title="Clear Filters">
                                    <i class="ti ti-x"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Categories Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ __('admin.menu.categories') }}</h5>
                <div class="text-muted">Total: {{ $categories->total() }} {{ __('admin.menu.categories') }}</div>
            </div>
            <div class="card-body">
                @if ($categories->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>{{ __('admin.form.image') }}</th>
                                    <th>{{ __('admin.form.name') }}</th>
                                    <th>Total Ebooks</th>
                                    <th>{{ __('admin.common.created_at') }}</th>
                                    <th>{{ __('admin.users.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td>
                                            <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                        </td>
                                        <td>
                                            <div class="fw-medium">{{ $category->name }}</div>
                                        </td>
                                        <td>
                                            <span class="badge bg-label-info">{{ $category->ebooks_count }} ebooks</span>
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ $category->created_at->format('d M Y') }}</small>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button"
                                                    class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                        onclick="editCategory('{{ $category->id }}', '{{ addslashes($category->name) }}', '{{ $category->image_url }}')">
                                                        <i class="ti ti-pencil me-2"></i>
                                                        <span>{{ __('admin.actions.edit') }}</span>
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item text-danger" href="javascript:void(0);"
                                                        onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this category?')) document.getElementById('delete-category-{{ $category->id }}').submit();">
                                                        <i class="ti ti-trash me-2"></i>
                                                        <span>{{ __('admin.actions.delete') }}</span>
                                                    </a>
                                                    <form id="delete-category-{{ $category->id }}"
                                                        action="{{ route('admin.categories.destroy', $category->id) }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $categories->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="ti ti-folder-off ti-xl text-muted mb-3"></i>
                        <h5 class="text-muted">{{ __('admin.categories.no_categories') }}</h5>
                        <p class="text-muted">Start by creating your first category</p>
                        <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal"
                            data-bs-target="#createModal">
                            <i class="ti ti-plus me-1"></i> {{ __('admin.categories.add_category') }}
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('admin.categories.add_category') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('admin.categories.category_name') }} <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" placeholder="e.g. Travel Guide" required>
                            <small class="text-muted">Slug will be auto-generated</small>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">{{ __('admin.categories.image') }}</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                                name="image" accept="image/*">
                            <small class="text-muted">Recommended size: 200x200px (JPG, PNG, max 2MB)</small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="mt-2" id="imagePreview"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('admin.actions.cancel') }}</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-1"></i> {{ __('admin.actions.add') }} {{ __('admin.categories.category_name') }}
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
                        <h5 class="modal-title">{{ __('admin.categories.edit_category') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">{{ __('admin.categories.category_name') }} <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_name" name="name"
                                placeholder="e.g. Travel Guide" required>
                            <small class="text-muted">Slug will be auto-generated</small>
                        </div>
                        <div class="mb-3">
                            <label for="edit_image" class="form-label">{{ __('admin.categories.image') }}</label>
                            <div id="currentImagePreview" class="mb-2"></div>
                            <input type="file" class="form-control" id="edit_image"
                                name="image" accept="image/*">
                            <small class="text-muted">Leave empty to keep current image. Recommended size: 200x200px (JPG, PNG, max 2MB)</small>
                            <div class="mt-2" id="editImagePreview"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('admin.actions.cancel') }}</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-1"></i> {{ __('admin.actions.save') }} {{ __('admin.categories.category_name') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function editCategory(id, name, image = null) {
                document.getElementById('editForm').action = '/admin/categories/' + id;
                document.getElementById('edit_name').value = name;
                
                // Show current image if exists
                const currentImagePreview = document.getElementById('currentImagePreview');
                if (image) {
                    currentImagePreview.innerHTML = `
                        <div class="mb-2">
                            <label class="form-label text-muted">Current Image:</label>
                            <div>
                                <img src="${image}" alt="${name}" class="rounded" style="width: 100px; height: 100px; object-fit: cover;">
                            </div>
                        </div>
                    `;
                } else {
                    currentImagePreview.innerHTML = '<small class="text-muted">No image uploaded</small>';
                }
                
                new bootstrap.Modal(document.getElementById('editModal')).show();
            }

            // Image preview for create form
            document.getElementById('image')?.addEventListener('change', function(e) {
                const file = e.target.files[0];
                const preview = document.getElementById('imagePreview');
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.innerHTML = `<img src="${e.target.result}" class="rounded" style="width: 100px; height: 100px; object-fit: cover;">`;
                    }
                    reader.readAsDataURL(file);
                } else {
                    preview.innerHTML = '';
                }
            });

            // Image preview for edit form
            document.getElementById('edit_image')?.addEventListener('change', function(e) {
                const file = e.target.files[0];
                const preview = document.getElementById('editImagePreview');
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.innerHTML = `<img src="${e.target.result}" class="rounded" style="width: 100px; height: 100px; object-fit: cover;">`;
                    }
                    reader.readAsDataURL(file);
                } else {
                    preview.innerHTML = '';
                }
            });

            // Show create modal if validation error exists
            @if ($errors->any() && !$errors->has('edit_name'))
                new bootstrap.Modal(document.getElementById('createModal')).show();
            @endif
        </script>
    @endpush
@endsection
