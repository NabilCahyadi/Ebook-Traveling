@extends('layouts.admin')

@section('title', 'Blogs')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">Admin /</span> Blogs
            </h4>
            <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">
                <i class="bx bx-plus me-1"></i> Create New Blog
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">All Blogs</h5>
                <span class="badge bg-primary">{{ $blogs->total() }} Total</span>
            </div>
            <div class="card-body">
                @if ($blogs->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Category</th>
                                    <th>Views</th>
                                    <th>Status</th>
                                    <th>Published</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($blogs as $blog)
                                    <tr>
                                        <td>
                                            @if ($blog->featured_image)
                                                <img src="{{ asset('storage/' . $blog->featured_image) }}"
                                                    alt="{{ $blog->title }}" class="rounded"
                                                    style="width: 60px; height: 60px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                    style="width: 60px; height: 60px;">
                                                    <i class="bx bx-image text-muted fs-4"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <div>
                                                <strong>{{ Str::limit($blog->title, 50) }}</strong>
                                            </div>
                                            <small class="text-muted">{{ $blog->slug }}</small>
                                        </td>
                                        <td>{{ $blog->author->name ?? 'Unknown' }}</td>
                                        <td>
                                            @if ($blog->category)
                                                <span class="badge bg-label-info">{{ $blog->category }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <i class="bx bx-show me-1"></i>{{ number_format($blog->view_count) }}
                                        </td>
                                        <td>
                                            @if ($blog->is_published)
                                                <span class="badge bg-success">Published</span>
                                            @else
                                                <span class="badge bg-secondary">Draft</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($blog->published_at)
                                                {{ $blog->published_at->format('d M Y') }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-sm btn-icon"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.blogs.show', $blog->id) }}">
                                                        <i class="bx bx-show me-2"></i> View
                                                    </a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.blogs.edit', $blog->id) }}">
                                                        <i class="bx bx-edit me-2"></i> Edit
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <form action="{{ route('admin.blogs.destroy', $blog->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this blog?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="bx bx-trash me-2"></i> Delete
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

                    <div class="mt-3">
                        {{ $blogs->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bx bx-news display-1 text-muted"></i>
                        <p class="mt-3 text-muted">No blogs found. Create your first blog!</p>
                        <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">
                            <i class="bx bx-plus me-1"></i> Create New Blog
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
