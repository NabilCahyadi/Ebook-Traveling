@extends('layouts.admin')

@section('title', 'Categories Management')

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
                    <span class="text-muted fw-light">Master Data /</span> Categories
                </h4>
            </div>
            <div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class="ti ti-plus me-1"></i> Add New Category
                </button>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.categories.index') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-5">
                            <label for="search" class="form-label">Search</label>
                            <input type="text" class="form-control" id="search" name="search"
                                value="{{ request('search') }}" placeholder="Search by category name or slug...">
                        </div>
                        <div class="col-md-3">
                            <label for="sort_by" class="form-label">Sort By</label>
                            <select class="form-select" id="sort_by" name="sort_by">
                                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Date
                                    Created</option>
                                <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Name</option>
                                <option value="ebooks_count" {{ request('sort_by') == 'ebooks_count' ? 'selected' : '' }}>
                                    Ebooks Count</option>
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
                <h5 class="mb-0">Ebook Categories</h5>
                <div class="text-muted">Total: {{ $categories->total() }} categories</div>
            </div>
            <div class="card-body">
                @if ($categories->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Total Ebooks</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
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
                                                        onclick="editCategory('{{ $category->id }}', '{{ $category->name }}')">
                                                        <i class="ti ti-pencil me-2"></i>
                                                        <span>Edit</span>
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item text-danger" href="javascript:void(0);"
                                                        onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this category?')) document.getElementById('delete-category-{{ $category->id }}').submit();">
                                                        <i class="ti ti-trash me-2"></i>
                                                        <span>Delete</span>
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
                        <h5 class="text-muted">No categories found</h5>
                        <p class="text-muted">Start by creating your first category</p>
                        <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal"
                            data-bs-target="#createModal">
                            <i class="ti ti-plus me-1"></i> Add New Category
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
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Create New Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Category Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" placeholder="e.g. Travel Guide" required>
                            <small class="text-muted">Slug will be auto-generated</small>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-1"></i> Create Category
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
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Category Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_name" name="name"
                                placeholder="e.g. Travel Guide" required>
                            <small class="text-muted">Slug will be auto-generated</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-1"></i> Update Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function editCategory(id, name) {
                document.getElementById('editForm').action = '/admin/categories/' + id;
                document.getElementById('edit_name').value = name;
                new bootstrap.Modal(document.getElementById('editModal')).show();
            }

            // Show create modal if validation error exists
            @if ($errors->any() && !$errors->has('edit_name'))
                new bootstrap.Modal(document.getElementById('createModal')).show();
            @endif
        </script>
    @endpush
@endsection
