@extends('layouts.admin')

@section('title', __('admin.ebooks.ebook_details'))

@push('styles')
    <style>
        /* Cover Image - Fixed ratio 1:1.6 untuk ebook */
        .ebook-cover-wrapper {
            position: relative;
            width: 100%;
            height: 0;
            padding-bottom: 160%; /* Ratio 1:1.6 */
            background: #f5f5f9;
            border-radius: 8px;
            overflow: hidden;
        }

        .ebook-cover-img {
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
            object-position: center !important;
        }

        .no-image-placeholder {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: #a8aaae;
            font-size: 48px;
        }
    </style>
@endpush

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h4 class="fw-bold mb-1">{{ __('admin.ebooks.ebook_details') }}</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.ebooks.index') }}">{{ __('admin.ebooks.title') }}</a></li>
                            <li class="breadcrumb-item active">{{ Str::limit($ebook->title, 30) }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.ebooks.edit', $ebook->id) }}" class="btn btn-primary">
                        <i class="bx bx-edit-alt me-1"></i> {{ __('admin.ebooks.edit') }}
                    </a>
                    <a href="{{ route('admin.ebooks.index') }}" class="btn btn-secondary">
                        <i class="bx bx-arrow-back me-1"></i> {{ __('admin.ebooks.back') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Ebook Title Card -->
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                        <div>
                            <h3 class="card-title mb-2">{{ $ebook->title }}</h3>
                            <p class="text-muted mb-0">
                                <i class="bx bx-user me-1"></i> {{ $ebook->author ?? __('admin.ebooks.unknown_author') }}
                            </p>
                        </div>
                        <div>
                            @if ($ebook->status === 'published')
                                <span class="badge bg-success">
                                    <i class="bx bx-check-circle"></i> {{ __('admin.ebooks.published') }}
                                </span>
                            @elseif($ebook->status === 'draft')
                                <span class="badge bg-warning">
                                    <i class="bx bx-time"></i> {{ __('admin.ebooks.draft') }}
                                </span>
                            @elseif($ebook->status === 'scheduled')
                                <span class="badge bg-info">
                                    <i class="ti ti-clock"></i> {{ __('admin.ebooks.scheduled') }}
                                    @if($ebook->published_at)
                                        <small class="ms-1">({{ $ebook->published_at->format('d M Y, H:i') }})</small>
                                    @endif
                                </span>
                            @elseif($ebook->status === 'unpublished')
                                <span class="badge bg-secondary">
                                    <i class="bx bx-eye-off"></i> {{ __('admin.ebooks.unpublished') }}
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    <i class="bx bx-help-circle"></i> {{ ucfirst($ebook->status) }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Left Sidebar - Cover and Stats -->
        <div class="col-lg-4">
            <!-- Cover Image -->
            <div class="card mb-3">
                <div class="card-body text-center">
                    <div style="max-width: 280px; margin: 0 auto;">
                        <div class="ebook-cover-wrapper">
                            @if ($ebook->cover_image_url)
                                <img src="{{ $ebook->cover_image_url }}" alt="{{ $ebook->title }}" class="ebook-cover-img">
                            @else
                                <div class="no-image-placeholder">
                                    <i class="bx bx-book"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <i class="bx bx-bar-chart-alt-2 me-2"></i>
                    <h5 class="mb-0">{{ __('admin.ebooks.statistics') }}</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="text-muted"><i class="bx bx-show me-1"></i> {{ __('admin.ebooks.views') }}</span>
                            <strong>{{ number_format($ebook->view_count ?? 0) }}</strong>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="text-muted"><i class="bx bx-book-reader me-1"></i> Reads</span>
                            <strong>{{ number_format($ebook->read_count ?? 0) }}</strong>
                        </div>
                    </div>

                    <div class="mb-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="text-muted"><i class="bx bx-star me-1"></i> Rating</span>
                            <div>
                                @if (($ebook->average_rating ?? 0) > 0)
                                    <strong>{{ number_format($ebook->average_rating, 1) }}</strong>
                                    @if (($ebook->total_reviews ?? 0) > 0)
                                        <small class="text-muted">({{ $ebook->total_reviews }})</small>
                                    @endif
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Content -->
        <div class="col-lg-8">

            <!-- Ebook Information -->
            <div class="card mb-3">
                <div class="card-header d-flex align-items-center">
                    <i class="bx bx-info-circle me-2"></i>
                    <h5 class="mb-0">{{ __('admin.ebooks.ebook_info') }}</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td class="fw-semibold" style="width: 200px;">{{ __('admin.ebooks.category') }}</td>
                            <td>
                                @if ($ebook->categories && $ebook->categories->count() > 0)
                                    @foreach ($ebook->categories as $category)
                                        <span class="badge bg-label-info">{{ $category->name }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">{{ __('admin.ebooks.city') }}</td>
                            <td>
                                @if ($ebook->city)
                                    <span class="badge bg-label-primary">
                                        <i class="bx bx-map me-1"></i>{{ $ebook->city->name }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">{{ __('admin.ebooks.total_pages') }} (PDF)</td>
                            <td>
                                @if($ebook->total_pages)
                                    <span class="badge bg-label-success">
                                        <i class="bx bx-file-blank me-1"></i>{{ $ebook->total_pages }} {{ __('admin.ebooks.pages') }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Page Count</td>
                            <td>
                                <i class="bx bx-file me-1"></i>{{ $ebook->page_count ?? '-' }} {{ __('admin.ebooks.pages') }}
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">{{ __('admin.ebooks.creator') }}</td>
                            <td>
                                <i class="bx bx-user me-1"></i>{{ $ebook->creator->name ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Published At</td>
                            <td>
                                <i class="bx bx-calendar me-1"></i>
                                {{ $ebook->published_at ? $ebook->published_at->format('d M Y, H:i') : '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">{{ __('admin.ebooks.created_date') }}</td>
                            <td>
                                <i class="bx bx-time me-1"></i>{{ $ebook->created_at->format('d M Y, H:i') }}
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">{{ __('admin.ebooks.last_update') }}</td>
                            <td>
                                <i class="bx bx-refresh me-1"></i>{{ $ebook->updated_at->format('d M Y, H:i') }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Description -->
            <div class="card mb-3">
                <div class="card-header d-flex align-items-center">
                    <i class="bx bx-detail me-2"></i>
                    <h5 class="mb-0">{{ __('admin.ebooks.description') }}</h5>
                </div>
                <div class="card-body">
                    <div class="mb-0">
                        {!! $ebook->description ?? '<p class="text-muted">' . __('admin.ebooks.no_data') . '</p>' !!}
                    </div>
                </div>
            </div>

            <!-- Ebook File -->
            @if ($ebook->file_url)
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <i class="bx bx-file me-2"></i>
                        <h5 class="mb-0">{{ __('admin.ebooks.file_pdf') }}</h5>
                    </div>
                    <div class="card-body text-center">
                        <i class="bx bxs-file-pdf text-danger mb-2" style="font-size: 48px;"></i>
                        <h6 class="fw-bold mb-1">{{ basename($ebook->file_url) }}</h6>
                        <p class="text-muted mb-3">PDF Document</p>
                        <a href="{{ asset('storage/' . $ebook->file_url) }}" target="_blank" class="btn btn-primary">
                            <i class="bx bx-download me-1"></i> {{ __('admin.ebooks.download') }}
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection