@extends('layouts.admin')

@section('title', __('admin.blog_categories.trashed'))

@section('content')

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ __('admin.common.success') }}</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ __('admin.common.error') }}</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold py-3 mb-2">
                <span class="text-muted fw-light">{{ __('admin.menu.admin') }} / {{ __('admin.menu.content_management') }} / {{ __('admin.blog_categories.blog_categories') }} /</span> {{ __('admin.blog_categories.trashed') }}
                <span class="badge bg-label-danger ms-2">{{ $categories->total() }} {{ __('admin.blog_categories.trashed') }}</span>
            </h4>
        </div>
        <div>
            <a href="{{ route('admin.blog-categories.index') }}" class="btn btn-secondary">
                <i class="ti ti-arrow-left me-1"></i> {{ __('admin.blog_categories.back_to_active') }}
            </a>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.blog-categories.trashed') }}">
                <div class="row">
                    <div class="col-md-10">
                        <input type="text" name="search" class="form-control" placeholder="{{ __('admin.blog_categories.search_trashed') }}"
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

    <!-- Trashed Categories Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">{{ __('admin.blog_categories.trashed_blog_categories') }}</h5>
        </div>
        <div class="card-body">
            @if ($categories->count() > 0)
                <div class="alert alert-warning">
                    <i class="ti ti-alert-triangle me-1"></i>
                    {{ __('admin.blog_categories.trashed_warning') }}
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('admin.blog_categories.name') }}</th>
                                <th>{{ __('admin.blog_categories.slug') }}</th>
                                <th>{{ __('admin.blog_categories.description') }}</th>
                                <th>{{ __('admin.blog_categories.blogs') }}</th>
                                <th>{{ __('admin.blog_categories.deleted_at') }}</th>
                                <th>{{ __('admin.blog_categories.actions') }}</th>
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
                                                class="d-inline" onsubmit="return confirm('{{ __('admin.blog_categories.restore_confirm') }}');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-success" title="{{ __('admin.blog_categories.restore') }}">
                                                    <i class="ti ti-refresh"></i> {{ __('admin.blog_categories.restore') }}
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.blog-categories.force-delete', $category->id) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('{{ __('admin.blog_categories.force_delete_confirm') }}');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="{{ __('admin.blog_categories.delete_forever') }}">
                                                    <i class="ti ti-trash-x"></i> {{ __('admin.blog_categories.delete_forever') }}
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
                    <p class="text-muted mt-3">{{ __('admin.blog_categories.no_trashed') }}</p>
                </div>
            @endif
        </div>
    </div>

@endsection
