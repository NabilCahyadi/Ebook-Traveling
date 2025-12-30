@extends('layouts.admin')

@section('title', __('admin.blog_categories.details'))

@section('content')

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold py-3 mb-2">
                <span class="text-muted fw-light">Admin / Content Management / Blog Categories /</span> {{ __('admin.blog_categories.details') }}
            </h4>
        </div>
        <div>
            <a href="{{ route('admin.blog-categories.index') }}" class="btn btn-secondary me-2">
                <i class="ti ti-arrow-left me-1"></i> {{ __('admin.blog_categories.back_to_list') }}
            </a>
            <a href="{{ route('admin.blog-categories.edit', $category->id) }}" class="btn btn-primary">
                <i class="ti ti-edit me-1"></i> {{ __('admin.blog_categories.edit_category') }}
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Category Info -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('admin.blog_categories.category_information') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <strong>{{ __('admin.blog_categories.name') }}:</strong>
                        </div>
                        <div class="col-md-9">
                            {{ $category->name }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <strong>{{ __('admin.blog_categories.slug') }}:</strong>
                        </div>
                        <div class="col-md-9">
                            <code>{{ $category->slug }}</code>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <strong>{{ __('admin.blog_categories.description') }}:</strong>
                        </div>
                        <div class="col-md-9">
                            {{ $category->description ?? '-' }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <strong>{{ __('admin.blog_categories.status') }}:</strong>
                        </div>
                        <div class="col-md-9">
                            @if ($category->is_active)
                                <span class="badge bg-success">{{ __('admin.blog_categories.active') }}</span>
                            @else
                                <span class="badge bg-secondary">{{ __('admin.blog_categories.inactive') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <strong>{{ __('admin.blog_categories.total_blogs') }}:</strong>
                        </div>
                        <div class="col-md-9">
                            <span class="badge bg-label-primary">{{ $category->blogs->count() }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <strong>{{ __('admin.blog_categories.created_at') }}:</strong>
                        </div>
                        <div class="col-md-9">
                            {{ $category->created_at->format('d M Y H:i:s') }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <strong>{{ __('admin.blog_categories.updated_at') }}:</strong>
                        </div>
                        <div class="col-md-9">
                            {{ $category->updated_at->format('d M Y H:i:s') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Associated Blogs -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('admin.blog_categories.blogs_in_category') }}</h5>
                </div>
                <div class="card-body">
                    @if ($category->blogs->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ __('admin.blog_categories.blog_title') }}</th>
                                        <th>{{ __('admin.blog_categories.author') }}</th>
                                        <th>{{ __('admin.blog_categories.status') }}</th>
                                        <th>{{ __('admin.blog_categories.created') }}</th>
                                        <th>{{ __('admin.blog_categories.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($category->blogs as $blog)
                                        <tr>
                                            <td>{{ $blog->title }}</td>
                                            <td>{{ $blog->author->name ?? '-' }}</td>
                                            <td>
                                                @if ($blog->status)
                                                    <span class="badge bg-success">{{ __('admin.blogs.published') }}</span>
                                                @else
                                                    <span class="badge bg-warning">{{ __('admin.blogs.draft') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ $blog->created_at->format('d M Y') }}</small>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="ti ti-edit"></i> {{ __('admin.blog_categories.edit') }}
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="ti ti-file-off" style="font-size: 2rem; opacity: 0.3;"></i>
                            <p class="text-muted mt-2">{{ __('admin.blog_categories.no_blogs_in_category') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Actions Sidebar -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('admin.blog_categories.actions') }}</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.blog-categories.edit', $category->id) }}" class="btn btn-primary">
                            <i class="ti ti-edit me-1"></i> {{ __('admin.blog_categories.edit_category') }}
                        </a>

                        <form action="{{ route('admin.blog-categories.destroy', $category->id) }}" method="POST"
                            onsubmit="return confirm('{{ __('admin.blog_categories.delete_confirm') }}');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="ti ti-trash me-1"></i> {{ __('admin.blog_categories.move_to_trash') }}
                            </button>
                        </form>
                    </div>

                    <hr>

                    <div class="alert alert-info mb-0">
                        <i class="ti ti-info-circle me-1"></i>
                        <small>
                            <strong>{{ __('admin.blog_categories.note') }}:</strong> {{ __('admin.blog_categories.delete_note') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

