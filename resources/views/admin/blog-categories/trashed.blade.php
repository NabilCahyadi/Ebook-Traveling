@extends('layouts.admin')

@section('title', 'Trashed Blog Categories')

@section('content')

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
                <span class="text-muted fw-light">Admin / Content Management / Blog Categories /</span> Trashed
                <span class="badge bg-label-danger ms-2">{{ $categories->total() }} Trashed</span>
            </h4>
        </div>
        <div>
            <a href="{{ route('admin.blog-categories.index') }}" class="btn btn-secondary">
                <i class="ti ti-arrow-left me-1"></i> Back to Active Categories
            </a>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.blog-categories.trashed') }}">
                <div class="row">
                    <div class="col-md-10">
                        <input type="text" name="search" class="form-control" placeholder="Search trashed categories..."
                            value="{{ $search ?? '' }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="ti ti-search me-1"></i> Search
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Trashed Categories Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Trashed Blog Categories</h5>
        </div>
        <div class="card-body">
            @if ($categories->count() > 0)
                <div class="alert alert-warning">
                    <i class="ti ti-alert-triangle me-1"></i>
                    These categories are in trash. You can restore them or permanently delete them.
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Description</th>
                                <th>Blogs</th>
                                <th>Deleted At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-2 bg-label-danger">
                                                <span class="avatar-initial rounded-circle">
                                                    <i class="ti ti-folder-off"></i>
                                                </span>
                                            </div>
                                            <strong>{{ $category->name }}</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <code>{{ $category->slug }}</code>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ Str::limit($category->description ?? '-', 50) }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-label-primary">{{ $category->blogs()->count() }}</span>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $category->deleted_at->format('d M Y H:i') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <form action="{{ route('admin.blog-categories.restore', $category->id) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Are you sure you want to restore this category?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-success" title="Restore">
                                                    <i class="ti ti-refresh"></i> Restore
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.blog-categories.force-delete', $category->id) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Are you sure you want to PERMANENTLY delete this category? This action cannot be undone!');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Delete Permanently">
                                                    <i class="ti ti-trash-x"></i> Delete Forever
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $categories->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="ti ti-folder-check" style="font-size: 3rem; opacity: 0.3;"></i>
                    <p class="text-muted mt-3">No trashed blog categories found.</p>
                </div>
            @endif
        </div>
    </div>

@endsection
