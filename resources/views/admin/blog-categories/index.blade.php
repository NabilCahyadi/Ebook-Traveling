@extends('layouts.admin')

@section('title', __('admin.blog_categories.blog_categories'))

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
                <span class="text-muted fw-light">Admin / Content Management /</span> {{ __('admin.blog_categories.blog_categories') }}
            </h4>
        </div>
        <div>
            <a href="{{ route('admin.blog-categories.trashed') }}" class="btn btn-outline-danger me-2">
                <i class="ti ti-trash me-1"></i> {{ __('admin.blog_categories.view_trashed') }}
            </a>
            <a href="{{ route('admin.blog-categories.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i> {{ __('admin.blog_categories.add_new_category') }}
            </a>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.blog-categories.index') }}">
                <div class="row">
                    <div class="col-md-10">
                        <input type="text" name="search" class="form-control" placeholder="{{ __('admin.blog_categories.search_placeholder') }}"
                            value="{{ $search ?? '' }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="ti ti-search me-1"></i> {{ __('admin.blog_categories.search') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Categories Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ __('admin.blog_categories.blog_categories') }}</h5>
            <div class="text-muted">{{ __('admin.blog_categories.total') }}: {{ $categories->total() }} {{ __('admin.blog_categories.categories') }}</div>
        </div>
        <div class="card-body">
            @if ($categories->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('admin.blog_categories.name') }}</th>
                                <th>{{ __('admin.blog_categories.slug') }}</th>
                                <th>{{ __('admin.blog_categories.description') }}</th>
                                <th>{{ __('admin.blog_categories.status') }}</th>
                                <th>{{ __('admin.blog_categories.blogs') }}</th>
                                <th>{{ __('admin.blog_categories.created') }}</th>
                                <th>{{ __('admin.blog_categories.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-2 bg-label-primary">
                                                <span class="avatar-initial rounded-circle">
                                                    <i class="ti ti-folder"></i>
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
                                        @if ($category->is_active)
                                            <span class="badge bg-success">{{ __('admin.blog_categories.active') }}</span>
                                        @else
                                            <span class="badge bg-secondary">{{ __('admin.blog_categories.inactive') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-label-primary">{{ $category->blogs_count ?? 0 }}</span>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $category->created_at->format('d M Y') }}</small>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a href="{{ route('admin.blog-categories.edit', $category->id) }}" class="dropdown-item">
                                                    <i class="ti ti-edit me-1"></i> {{ __('admin.blog_categories.edit') }}
                                                </a>
                                                <a href="{{ route('admin.blog-categories.show', $category->id) }}" class="dropdown-item">
                                                    <i class="ti ti-eye me-1"></i> {{ __('admin.blog_categories.view_details') }}
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <form action="{{ route('admin.blog-categories.destroy', $category->id) }}" method="POST"
                                                    onsubmit="return confirm('{{ __('admin.blog_categories.delete_confirm') }}');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="ti ti-trash me-1"></i> {{ __('admin.blog_categories.move_to_trash') }}
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

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $categories->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="ti ti-folder-off" style="font-size: 3rem; opacity: 0.3;"></i>
                    <p class="text-muted mt-3">{{ __('admin.blog_categories.no_categories_found') }}</p>
                    <a href="{{ route('admin.blog-categories.create') }}" class="btn btn-primary">
                        <i class="ti ti-plus me-1"></i> {{ __('admin.blog_categories.add_first_category') }}
                    </a>
                </div>
            @endif
        </div>
    </div>

@endsection
