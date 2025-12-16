@extends('layouts.admin')

@section('title', 'View Ebook')

@section('styles')
    <style>
        /* Cover Image Card - Fixed untuk auto-crop ratio 1:1.6 */
        .ebook-cover-container {
            position: relative;
            width: 100%;
            max-width: 280px;
            margin: 0 auto 1.5rem;
        }

        .ebook-cover-card {
            background: #fff;
            border-radius: 16px;
            padding: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .ebook-cover-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.12);
        }

        .ebook-cover-wrapper {
            position: relative;
            width: 100%;
            height: 0;
            padding-bottom: 160%;
            /* Rasio 1:1.6 (100/1.6 * 100 = 160%) */
            background: #f2f2f2;
            border-radius: 12px;
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
            display: block !important;
            max-width: none !important;
            max-height: none !important;
        }

        .ebook-cover-wrapper .no-image-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 64px;
            color: #cbd5e1;
        }

        /* Header Section */
        .ebook-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            padding: 2rem;
            color: white;
            margin-bottom: 1.5rem;
        }

        .ebook-title {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: white;
        }

        .ebook-author {
            font-size: 1.1rem;
            opacity: 0.95;
            margin-bottom: 1rem;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-item {
            background: white;
            border-radius: 12px;
            padding: 1.25rem;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            border: 1px solid #f1f5f9;
            transition: all 0.3s ease;
        }

        .stat-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.75rem;
            font-size: 24px;
        }

        .stat-icon.views {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .stat-icon.reads {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }

        .stat-icon.rating {
            background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
            color: #d97706;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.875rem;
            color: #64748b;
            font-weight: 500;
        }

        /* Info Table */
        .info-table {
            /* width: 100%; */
            border-collapse: separate;
            border-spacing: 10 10px;

        }

        .info-table tr {
            border-bottom: 1px solid #f1f5f9;
        }

        .info-table tr:last-child {
            border-bottom: none;
        }

        .info-table td {
            padding: 1rem 0;
            vertical-align: top;
        }

        .info-label {
            font-weight: 600;
            color: #64748b;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            width: 35%;
        }

        .info-value {
            color: #1e293b;
            font-size: 0.95rem;
            font-weight: 500;
        }

        /* Card Enhancements */
        .card {
            border: none;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
            border-radius: 12px;
            overflow: hidden;
        }

        .card-header {
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            padding: 1.25rem 1.5rem;
        }

        .card-header h5 {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 600;
            color: #1e293b;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Status Badge */
        .status-badge-large {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
        }

        /* File Download */
        .file-download-box {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .file-download-box:hover {
            border-color: #667eea;
            background: linear-gradient(135deg, #f8fafc 0%, #e8eef5 100%);
        }

        .file-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 32px;
            color: white;
        }

        /* Description Box */
        .description-text {
            line-height: 1.8;
            color: #475569;
            font-size: 0.95rem;
        }

        /* Action Buttons */
        .btn-action {
            padding: 0.625rem 1.25rem;
            border-radius: 8px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Responsive */
        @media (max-width: 991px) {

            /* Reorder layout on mobile using flexbox */
            .row {
                display: flex;
                flex-wrap: wrap;
            }

            .mobile-order-1 {
                order: 1;
            }

            .mobile-order-2 {
                order: 2;
            }

            .mobile-order-3 {
                order: 3;
            }

            .ebook-header {
                padding: 1.5rem;
            }

            .ebook-title {
                font-size: 1.5rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .info-label {
                width: 100%;
                display: block;
                margin-bottom: 0.25rem;
            }

            .info-value {
                display: block;
            }

            .ebook-cover-container {
                max-width: 200px;
            }

            /* Breadcrumb responsive */
            .d-flex.justify-content-between {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 1rem;
            }

            .d-flex.gap-2 {
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .ebook-header {
                padding: 1rem;
            }

            .ebook-title {
                font-size: 1.25rem;
            }

            .ebook-author {
                font-size: 0.95rem;
            }

            .card-body {
                padding: 1rem;
            }

            .btn-action {
                padding: 0.5rem 1rem;
                font-size: 0.875rem;
            }

            .d-flex.gap-2 {
                flex-direction: column;
                gap: 0.5rem !important;
            }

            .d-flex.gap-2 .btn-action {
                width: 100%;
                justify-content: center;
            }

            .badge {
                font-size: 0.75rem !important;
                padding: 0.4rem 0.8rem !important;
            }
        }
    </style>
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h4 class="fw-bold mb-1">Ebook Details</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.ebooks.index') }}">Ebooks</a></li>
                            <li class="breadcrumb-item active">{{ Str::limit($ebook->title, 30) }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.ebooks.edit', $ebook->id) }}" class="btn btn-primary btn-action">
                        <i class="bx bx-edit-alt"></i> Edit
                    </a>
                    <a href="{{ route('admin.ebooks.index') }}" class="btn btn-secondary btn-action">
                        <i class="bx bx-arrow-back"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Header Card - Show first on mobile -->
        <div class="col-12 mobile-order-1 mb-4">
            <div class="ebook-header">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                    <div class="grow">
                        <h2 class="ebook-title">{{ $ebook->title }}</h2>
                        <p class="ebook-author mb-0">
                            Written by {{ $ebook->author ?? 'Unknown Author' }}
                        </p>
                    </div>
                    @if ($ebook->category)
                        <span class="badge bg-white text-primary px-3 py-2" style="font-size: 0.9rem;">
                            <i class="bx bx-category me-1"></i>{{ $ebook->category->name }}
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Left Sidebar - Cover and Stats -->
        <div class="col-lg-4 mobile-order-2">
            <!-- Cover Image -->
            <div class="card mb-4">
                <div class="card-body text-center">
                    <div class="ebook-cover-container">
                        <div class="ebook-cover-card">
                            <div class="ebook-cover-wrapper">
                                @if ($ebook->cover_image_url)
                                    <img src="{{ $ebook->cover_image_url }}" alt="{{ $ebook->title }}" class="ebook-cover-img">
                                @else
                                    <i class="bx bx-book no-image-icon"></i>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="mt-2">
                        @if ($ebook->status === 'published')
                            <span class="status-badge-large bg-success text-white p-2 rounded-2">
                                <i class="bx bx-check-circle"></i> Published
                            </span>
                        @elseif($ebook->status === 'draft')
                            <span class="status-badge-large bg-warning text-white p-1 rounded-2">
                                <i class="bx bx-time"></i> Draft
                            </span>
                        @else
                            <span class="status-badge-large bg-danger text-white p-1 rounded-2">
                                <i class="bx bx-archive"></i> Archived
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="card">
                <div class="card-header">
                    <h5><i class="ti ti-chart-bar me-2"></i>Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3 d-flex align-items-center">
                        <strong class="me-2">View :</strong>
                        <span>{{ number_format($ebook->view_count ?? 0) }}</span>
                    </div>

                    <div class="mb-3 d-flex align-items-center">
                        <strong class="me-2">Reads :</strong>
                        <span>{{ number_format($ebook->read_count ?? 0) }}</span>
                    </div>
                    <div class="mb-0 d-flex align-items-center">
                        <strong class="me-2">Rating :</strong>
                        <div class="ms-3">
                            @if (($ebook->average_rating ?? 0) > 0)
                                {{ number_format($ebook->average_rating, 1) }}
                                @if (($ebook->total_reviews ?? 0) > 0)
                                    <small class="text-muted">({{ $ebook->total_reviews }} reviews)</small>
                                @endif
                            @else
                                N/A
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Content -->
        <div class="col-lg-8 mobile-order-3">

            <!-- Ebook Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5><i class="bx bx-info-circle me-2"></i>Ebook Information</h5>
                </div>
                <div class="card-body">
                    <table class="info-table">
                        <tr class="">
                            <td class="info-label">Category</td>
                            <td class="info-value"> :
                                @if ($ebook->category)
                                    <span class="badge bg-label-info">{{ $ebook->category->name }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="info-label">City</td>
                            <td class="info-value">
                                @if ($ebook->city)
                                    : <span class="badge bg-label-primary">
                                        <i class="bx bx-map me-1"></i>{{ $ebook->city->name }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="info-label">Page Count</td>

                            <td class="info-value"> :
                                <i class="bx bx-file me-1"></i>{{ $ebook->page_count ?? '-' }} pages
                            </td>
                        </tr>
                        <tr>
                            <td class="info-label">Creator</td>
                            <td class="info-value">:
                                <i class="bx bx-user me-1"></i>{{ $ebook->creator->name ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="info-label">Published At</td>
                            <td class="info-value">
                                <i class="bx bx-calendar me-1"></i>
                                {{ $ebook->published_at ? $ebook->published_at->format('d M Y, H:i') : '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="info-label">Created At</td>
                            <td class="info-value">
                                <i class="bx bx-time me-1"></i>{{ $ebook->created_at->format('d M Y, H:i') }}
                            </td>
                        </tr>
                        <tr>
                            <td class="info-label">Last Updated</td>
                            <td class="info-value">
                                <i class="bx bx-refresh me-1"></i>{{ $ebook->updated_at->format('d M Y, H:i') }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Description -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5><i class="bx bx-detail me-2"></i>Description</h5>
                </div>
                <div class="card-body">
                    <p class="description-text">
                        {{ $ebook->description ?? 'No description available for this ebook.' }}
                    </p>
                </div>
            </div>

            <!-- Ebook File -->
            @if ($ebook->file_url)
                <div class="card">
                    <div class="card-header">
                        <h5><i class="bx bx-file me-2"></i>Ebook File</h5>
                    </div>
                    <div class="card-body">
                        <div class="file-download-box">
                            <div class="file-icon">
                                <i class="bx bxs-file-pdf"></i>
                            </div>
                            <h6 class="fw-bold mb-1">{{ basename($ebook->file_url) }}</h6>
                            <p class="text-muted mb-3">PDF Document</p>
                            <a href="{{ asset('storage/' . $ebook->file_url) }}" target="_blank"
                                class="btn btn-primary btn-action">
                                <i class="bx bx-download"></i> Download File
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection