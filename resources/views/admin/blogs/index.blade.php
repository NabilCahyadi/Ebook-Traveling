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
            <div class="card-header">
                <h5 class="mb-3">All Blogs</h5>

                <!-- Filter Section -->
                <form method="GET" action="{{ route('admin.blogs.index') }}" class="row g-3">
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">All Status</option>
                            <option value="draft" {{ $status == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ $status == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="unpublished" {{ $status == 'unpublished' ? 'selected' : '' }}>Unpublished
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" id="category" name="category">
                            <option value="">All Categories</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat }}" {{ $category == $cat ? 'selected' : '' }}>
                                    {{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="search" class="form-label">Search</label>
                        <input type="text" class="form-control" id="search" name="search"
                            placeholder="Search by title, content..." value="{{ $search ?? '' }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-search-alt me-1"></i> Filter
                            </button>
                            @if ($status || $category || $search)
                                <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-secondary">
                                    <i class="bx bx-x"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </form>

                <!-- Stats -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <span class="badge bg-primary">{{ $blogs->total() }} Total</span>
                    <a href="{{ route('admin.blogs.archived') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bx bx-archive me-1"></i> View Archived
                    </a>
                </div>
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
                                            @if ($blog->status === 'published')
                                                <span class="badge bg-success">Published</span>
                                            @elseif($blog->status === 'draft')
                                                <span class="badge bg-warning">Draft</span>
                                            @elseif($blog->status === 'unpublished')
                                                <span class="badge bg-secondary">Unpublished</span>
                                            @else
                                                <span class="badge bg-dark">Archived</span>
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
                                                <button type="button"
                                                    class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.blogs.show', $blog->id) }}">
                                                        <i class="ti ti-eye me-2"></i> View
                                                    </a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.blogs.edit', $blog->id) }}">
                                                        <i class="ti ti-pencil me-2"></i> Edit
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <form action="{{ route('admin.blogs.destroy', $blog->id) }}"
                                                        method="POST" style="display: none;"
                                                        id="delete-blog-{{ $blog->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <a class="dropdown-item text-danger" href="javascript:void(0);"
                                                        onclick="if(confirm('Are you sure you want to delete this blog?')) document.getElementById('delete-blog-{{ $blog->id }}').submit();">
                                                        <i class="ti ti-trash me-2"></i> Delete
                                                    </a>
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
                        {{ $blogs->appends(['status' => $status, 'category' => $category, 'search' => $search])->links() }}
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
