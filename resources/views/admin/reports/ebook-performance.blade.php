@extends('layouts.admin')

@section('title', __('admin.reports.ebook_performance'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mb-2">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.reports.index') }}">{{ __('admin.reports.title') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('admin.reports.ebook_performance') }}</li>
                    </ol>
                </nav>
                <h4 class="mb-1">{{ __('admin.reports.ebook_performance') }}</h4>
                <p class="text-muted mb-0">{{ __('admin.reports.ebook_performance_subtitle') }}</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.reports.ebook-performance') }}" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">{{ __('admin.reports.time_period') }}</label>
                        <select name="filter" class="form-select" onchange="this.form.submit()">
                            <option value="all" {{ $filter === 'all' ? 'selected' : '' }}>{{ __('admin.reports.all_time') }}</option>
                            <option value="month" {{ $filter === 'month' ? 'selected' : '' }}>{{ __('admin.reports.last_30_days') }}</option>
                            <option value="week" {{ $filter === 'week' ? 'selected' : '' }}>{{ __('admin.reports.last_7_days') }}</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">{{ __('admin.reports.sort_by') }}</label>
                        <select name="sort" class="form-select" onchange="this.form.submit()">
                            <option value="reads" {{ $sortBy === 'reads' ? 'selected' : '' }}>{{ __('admin.reports.most_read') }}</option>
                            <option value="views" {{ $sortBy === 'views' ? 'selected' : '' }}>{{ __('admin.reports.most_viewed') }}</option>
                            <option value="rating" {{ $sortBy === 'rating' ? 'selected' : '' }}>{{ __('admin.reports.highest_rated') }}</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <a href="{{ route('admin.reports.ebook-performance') }}" class="btn btn-outline-secondary">
                            {{ __('admin.reports.reset') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="text-primary mb-2">{{ number_format($totalEbooks) }}</h3>
                        <p class="text-muted mb-0">{{ __('admin.reports.total_ebooks') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="text-success mb-2">{{ number_format($activeEbooks) }}</h3>
                        <p class="text-muted mb-0">{{ __('admin.reports.active_ebooks') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="text-info mb-2">{{ number_format($totalReads) }}</h3>
                        <p class="text-muted mb-0">{{ __('admin.reports.total_reads') }}</p>
                        <small class="text-muted">{{ number_format($totalViews) }} {{ __('admin.reports.views') }}</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Performing Ebooks -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">{{ __('admin.reports.most_popular_ebooks') }}</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('admin.reports.ebook') }}</th>
                                <th>{{ __('admin.reports.category') }}</th>
                                <th>{{ __('admin.reports.city') }}</th>
                                <th>{{ __('admin.reports.reads') }}</th>
                                <th>{{ __('admin.reports.views') }}</th>
                                <th>{{ __('admin.reports.rating') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topEbooks as $index => $ebook)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($ebook->cover_image)
                                                <img src="{{ $ebook->cover_image_url }}" 
                                                     alt="{{ $ebook->title }}" 
                                                     class="rounded me-2"
                                                     style="width: 40px; height: 60px; object-fit: cover;">
                                            @endif
                                            <div>
                                                <strong>{{ Str::limit($ebook->title, 30) }}</strong>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $ebook->category->name ?? '-' }}</td>
                                    <td>{{ $ebook->city->name ?? '-' }}</td>
                                    <td><strong>{{ number_format($ebook->read_count ?? 0) }}</strong></td>
                                    <td>{{ number_format($ebook->view_count ?? 0) }}</td>
                                    <td>
                                        @php
                                            $avgRating = $ebook->ratings_avg_rating ?? 0;
                                        @endphp
                                        <span class="badge bg-label-{{ $avgRating >= 4 ? 'success' : ($avgRating >= 3 ? 'warning' : 'danger') }}">
                                            ⭐ {{ number_format($avgRating, 1) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">
                                        {{ __('admin.reports.no_data') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Low Performing Ebooks (Active but No Sales) -->
        @if($lowPerformingEbooks->count() > 0)
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('admin.reports.low_engagement_ebooks') }}</h5>
                    <small class="text-muted">{{ __('admin.reports.low_views_desc') }}</small>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>{{ __('admin.reports.ebook') }}</th>
                                    <th>{{ __('admin.reports.category') }}</th>
                                    <th>{{ __('admin.reports.city') }}</th>
                                    <th>{{ __('admin.reports.reads') }}</th>
                                    <th>{{ __('admin.reports.views') }}</th>
                                    <th>{{ __('admin.reports.rating') }}</th>
                                    <th>{{ __('admin.reports.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lowPerformingEbooks as $ebook)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($ebook->cover_image)
                                                    <img src="{{ $ebook->cover_image_url }}" 
                                                         alt="{{ $ebook->title }}" 
                                                         class="rounded me-2"
                                                         style="width: 40px; height: 60px; object-fit: cover;">
                                                @endif
                                                <div>
                                                    <strong>{{ Str::limit($ebook->title, 30) }}</strong>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $ebook->category->name ?? '-' }}</td>
                                        <td>{{ $ebook->city->name ?? '-' }}</td>
                                        <td><strong>{{ number_format($ebook->read_count ?? 0) }}</strong></td>
                                        <td>{{ number_format($ebook->view_count ?? 0) }}</td>
                                        <td>
                                            @php
                                                $avgRating = $ebook->ratings_avg_rating ?? 0;
                                            @endphp
                                            @if($avgRating > 0)
                                                <span class="badge bg-label-warning">⭐ {{ number_format($avgRating, 1) }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.ebooks.edit', $ebook->id) }}" 
                                               class="btn btn-sm btn-icon btn-text-secondary">
                                                <i class="ti ti-pencil"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
