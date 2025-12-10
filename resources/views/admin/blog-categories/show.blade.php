@extends('layouts.admin')

@section('title', 'Blog Category Details')

@section('content')

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold py-3 mb-2">
                <span class="text-muted fw-light">Admin / Content Management / Blog Categories /</span> Details
            </h4>
        </div>
        <div>
            <a href="{{ route('admin.blog-categories.index') }}" class="btn btn-secondary me-2">
                <i class="ti ti-arrow-left me-1"></i> Back to List
            </a>
            <a href="{{ route('admin.blog-categories.edit', $blogCategory->id) }}" class="btn btn-primary">
                <i class="ti ti-edit me-1"></i> Edit Category
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Category Info -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Category Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <strong>Name:</strong>
                        </div>
                        <div class="col-md-9">
                            {{ $blogCategory->name }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <strong>Slug:</strong>
                        </div>
                        <div class="col-md-9">
                            <code>{{ $blogCategory->slug }}</code>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <strong>Description:</strong>
                        </div>
                        <div class="col-md-9">
                            {{ $blogCategory->description ?? '-' }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <strong>Status:</strong>
                        </div>
                        <div class="col-md-9">
                            @if ($blogCategory->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <strong>Total Blogs:</strong>
                        </div>
                        <div class="col-md-9">
                            <span class="badge bg-label-primary">{{ $blogCategory->blogs->count() }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <strong>Created At:</strong>
                        </div>
                        <div class="col-md-9">
                            {{ $blogCategory->created_at->format('d M Y H:i:s') }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <strong>Updated At:</strong>
                        </div>
                        <div class="col-md-9">
                            {{ $blogCategory->updated_at->format('d M Y H:i:s') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Associated Blogs -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Blogs in This Category</h5>
                </div>
                <div class="card-body">
                    @if ($blogCategory->blogs->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($blogCategory->blogs as $blog)
                                        <tr>
                                            <td>{{ $blog->title }}</td>
                                            <td>{{ $blog->author ?? '-' }}</td>
                                            <td>
                                                @if ($blog->status)
                                                    <span class="badge bg-success">Published</span>
                                                @else
                                                    <span class="badge bg-warning">Draft</span>
                                                @endif
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ $blog->created_at->format('d M Y') }}</small>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="ti ti-edit"></i> Edit
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
                            <p class="text-muted mt-2">No blogs in this category yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Actions Sidebar -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.blog-categories.edit', $blogCategory->id) }}" class="btn btn-primary">
                            <i class="ti ti-edit me-1"></i> Edit Category
                        </a>

                        <form action="{{ route('admin.blog-categories.destroy', $blogCategory->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to move this category to trash?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="ti ti-trash me-1"></i> Move to Trash
                            </button>
                        </form>
                    </div>

                    <hr>

                    <div class="alert alert-info mb-0">
                        <i class="ti ti-info-circle me-1"></i>
                        <small>
                            <strong>Note:</strong> You cannot delete a category that has blogs associated with it.
                            Please reassign or delete the blogs first.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
