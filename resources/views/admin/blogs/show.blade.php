@extends('layouts.admin')

@section('title', __('admin.blogs.details'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">Admin / Blogs /</span> {{ __('admin.blogs.details') }}
            </h4>
            <div>
                <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-primary me-2">
                    <i class="bx bx-edit me-1"></i> {{ __('admin.blogs.edit') }}
                </a>
                <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">
                    <i class="bx bx-arrow-back me-1"></i> {{ __('admin.blogs.back') }}
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    @if ($blog->featured_image)
                        @php
                            // Check if image is external URL or local storage
                            $imageUrl = filter_var($blog->featured_image, FILTER_VALIDATE_URL) 
                                ? $blog->featured_image 
                                : asset('storage/' . $blog->featured_image);
                        @endphp
                        <img src="{{ $imageUrl }}" alt="{{ $blog->title }}"
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
                                        {{ __('admin.blogs.not_published') }}
                                    @endif
                                    <span class="mx-2">•</span>
                                    <i class="bx bx-show me-1"></i> {{ number_format($blog->view_count) }} {{ __('admin.blogs.views') }}
                                </div>
                            </div>
                            @if ($blog->status === 'published')
                                <span class="badge bg-success">Published</span>
                            @elseif($blog->status === 'draft')
                                <span class="badge bg-warning">Draft</span>
                            @elseif($blog->status === 'unpublished')
                                <span class="badge bg-secondary">Unpublished</span>
                            @elseif($blog->status === 'archived')
                                <span class="badge bg-dark">Archived</span>
                            @else
                                <span class="badge bg-danger">{{ $blog->status ?: 'Unknown' }}</span>
                            @endif
                        </div>

                        @if ($blog->category)
                            <div class="mb-3">
                                <span class="badge bg-label-info">{{ $blog->category }}</span>
                            </div>
                        @endif

                        @if ($blog->excerpt)
                            <div class="alert alert-info">
                                <strong>{{ __('admin.blogs.excerpt') }}:</strong> {{ $blog->excerpt }}
                            </div>
                        @endif

                        <hr>

                        <div class="blog-content">
                            {!! $blog->content !!}
                        </div>

                        @if ($blog->tags && (is_array($blog->tags) ? count($blog->tags) > 0 : !empty($blog->tags)))
                            <hr>
                            <div class="mt-3">
                                <strong>{{ __('admin.blogs.tags') }}:</strong>
                                @if (is_array($blog->tags))
                                    @foreach ($blog->tags as $tag)
                                        <span class="badge bg-label-secondary me-1">{{ $tag }}</span>
                                    @endforeach
                                @else
                                    @foreach (explode(',', $blog->tags) as $tag)
                                        <span class="badge bg-label-secondary me-1">{{ trim($tag) }}</span>
                                    @endforeach
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">{{ __('admin.blogs.blog_information') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">{{ __('admin.blogs.slug') }}</small>
                            <code>{{ $blog->slug }}</code>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">{{ __('admin.blogs.author') }}</small>
                            <p class="mb-0">{{ $blog->author->name ?? __('admin.blogs.unknown') }}</p>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">{{ __('admin.blogs.category') }}</small>
                            @if ($blog->category)
                                <span class="badge bg-label-info">{{ $blog->category }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">{{ __('admin.blogs.status') }}</small>
                            @if ($blog->status === 'published')
                                <span class="badge bg-success">{{ __('admin.blogs.published') }}</span>
                            @elseif($blog->status === 'draft')
                                <span class="badge bg-warning">{{ __('admin.blogs.draft') }}</span>
                            @elseif($blog->status === 'unpublished')
                                <span class="badge bg-secondary">{{ __('admin.blogs.unpublished') }}</span>
                            @elseif($blog->status === 'archived')
                                <span class="badge bg-dark">{{ __('admin.blogs.archived') }}</span>
                            @else
                                <span class="badge bg-danger">{{ $blog->status ?: __('admin.blogs.unknown') }}</span>
                            @endif
                        </div>

                        @if ($blog->published_at)
                            <div class="mb-3">
                                <small class="text-muted d-block mb-1">{{ __('admin.blogs.published_at') }}</small>
                                <p class="mb-0">{{ $blog->published_at->format('d M Y, H:i') }}</p>
                            </div>
                        @endif

                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">{{ __('admin.blogs.created_at') }}</small>
                            <p class="mb-0">{{ $blog->created_at->format('d M Y, H:i') }}</p>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">{{ __('admin.blogs.last_updated') }}</small>
                            <p class="mb-0">{{ $blog->updated_at->format('d M Y, H:i') }}</p>
                        </div>

                        @if ($blog->tags && (is_array($blog->tags) ? count($blog->tags) > 0 : !empty($blog->tags)))
                            <div class="mb-3">
                                <small class="text-muted d-block mb-1">{{ __('admin.blogs.tags') }}</small>
                                <div>
                                    @if (is_array($blog->tags))
                                        @foreach ($blog->tags as $tag)
                                            <span class="badge bg-label-secondary me-1 mb-1">{{ $tag }}</span>
                                        @endforeach
                                    @else
                                        @foreach (explode(',', $blog->tags) as $tag)
                                            <span class="badge bg-label-secondary me-1 mb-1">{{ trim($tag) }}</span>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">{{ __('admin.blogs.statistics') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="badge bg-label-primary rounded p-2 me-3">
                                <i class="bx bx-show fs-4"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">{{ __('admin.blogs.total_views') }}</small>
                                <h5 class="mb-0">{{ number_format($blog->view_count) }}</h5>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex align-items-center mb-3">
                            <div class="badge bg-label-info rounded p-2 me-3">
                                <i class="bx bx-file fs-4"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">{{ __('admin.blogs.content_length') }}</small>
                                <h6 class="mb-0">{{ number_format(strlen(strip_tags($blog->content))) }} {{ __('admin.blogs.characters') }}</h6>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="badge bg-label-success rounded p-2 me-3">
                                <i class="bx bx-time fs-4"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">{{ __('admin.blogs.reading_time') }}</small>
                                <h6 class="mb-0">{{ ceil(str_word_count(strip_tags($blog->content)) / 200) }} {{ __('admin.blogs.min_read') }}
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{ __('admin.blogs.actions') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-primary">
                                <i class="bx bx-edit me-1"></i> {{ __('admin.blogs.edit_blog') }}
                            </a>
                            <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST"
                                onsubmit="return confirm('{{ __('admin.blogs.delete_confirm') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100">
                                <i class="bx bx-trash me-1"></i> {{ __('admin.blogs.delete_blog') }}
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
