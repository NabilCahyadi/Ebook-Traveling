@extends('layouts.admin')

@section('title', 'Blog Details')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">Admin / Blogs /</span> Details
            </h4>
            <div>
                <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-primary me-2">
                    <i class="bx bx-edit me-1"></i> Edit
                </a>
                <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">
                    <i class="bx bx-arrow-back me-1"></i> Back
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    @if ($blog->featured_image)
                        <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}"
                            class="card-img-top" style="max-height: 400px; object-fit: cover;">
                    @endif

                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h3 class="card-title mb-2">{{ $blog->title }}</h3>
                                <div class="text-muted mb-2">
                                    <i class="bx bx-user me-1"></i> {{ $blog->author->name ?? 'Unknown' }}
                                    <span class="mx-2">•</span>
                                    <i class="bx bx-calendar me-1"></i>
                                    @if ($blog->published_at)
                                        {{ $blog->published_at->format('d M Y') }}
                                    @else
                                        Not published
                                    @endif
                                    <span class="mx-2">•</span>
                                    <i class="bx bx-show me-1"></i> {{ number_format($blog->view_count) }} views
                                </div>
                            </div>
                            <span class="badge bg-{{ $blog->is_published ? 'success' : 'secondary' }}">
                                {{ $blog->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </div>

                        @if ($blog->category)
                            <div class="mb-3">
                                <span class="badge bg-label-info">{{ $blog->category }}</span>
                            </div>
                        @endif

                        @if ($blog->excerpt)
                            <div class="alert alert-info">
                                <strong>Excerpt:</strong> {{ $blog->excerpt }}
                            </div>
                        @endif

                        <hr>

                        <div class="blog-content">
                            {!! $blog->content !!}
                        </div>

                        @if ($blog->tags && count($blog->tags) > 0)
                            <hr>
                            <div class="mt-3">
                                <strong>Tags:</strong>
                                @foreach ($blog->tags as $tag)
                                    <span class="badge bg-label-secondary me-1">{{ $tag }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Blog Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Slug</small>
                            <code>{{ $blog->slug }}</code>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Author</small>
                            <p class="mb-0">{{ $blog->author->name ?? 'Unknown' }}</p>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Status</small>
                            <span class="badge bg-{{ $blog->is_published ? 'success' : 'secondary' }}">
                                {{ $blog->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </div>

                        @if ($blog->published_at)
                            <div class="mb-3">
                                <small class="text-muted d-block mb-1">Published At</small>
                                <p class="mb-0">{{ $blog->published_at->format('d M Y, H:i') }}</p>
                            </div>
                        @endif

                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Created At</small>
                            <p class="mb-0">{{ $blog->created_at->format('d M Y, H:i') }}</p>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Last Updated</small>
                            <p class="mb-0">{{ $blog->updated_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Statistics</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="badge bg-label-primary rounded p-2 me-3">
                                <i class="bx bx-show fs-4"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Total Views</small>
                                <h5 class="mb-0">{{ number_format($blog->view_count) }}</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-primary">
                                <i class="bx bx-edit me-1"></i> Edit Blog
                            </a>
                            <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this blog?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100">
                                    <i class="bx bx-trash me-1"></i> Delete Blog
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .blog-content {
                line-height: 1.8;
            }

            .blog-content img {
                max-width: 100%;
                height: auto;
            }

            .blog-content h1,
            .blog-content h2,
            .blog-content h3,
            .blog-content h4,
            .blog-content h5,
            .blog-content h6 {
                margin-top: 1.5rem;
                margin-bottom: 1rem;
            }

            .blog-content p {
                margin-bottom: 1rem;
            }

            .blog-content ul,
            .blog-content ol {
                margin-bottom: 1rem;
                padding-left: 2rem;
            }
        </style>
    @endpush
@endsection
