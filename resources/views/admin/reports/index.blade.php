@extends('layouts.admin')

@section('title', __('admin.reports.title'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">{{ __('admin.reports.title') }}</h4>
                <p class="text-muted mb-0">{{ __('admin.reports.subtitle') }}</p>
            </div>
        </div>

        <!-- Report Cards -->
        <div class="row g-4">
            <!-- Revenue Report -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar avatar-lg me-3 bg-label-success">
                                <i class="ti ti-report-money ti-lg"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">{{ __('admin.reports.revenue_report') }}</h5>
                                <small class="text-muted">{{ __('admin.reports.revenue_report_desc') }}</small>
                            </div>
                        </div>
                        <p class="text-muted mb-3">
                            {{ __('admin.reports.revenue_report_detail') }}
                        </p>
                        <a href="{{ route('admin.reports.revenue') }}" class="btn btn-sm btn-primary w-100">
                            <i class="ti ti-eye me-1"></i> {{ __('admin.reports.view_report') }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Ebook Performance -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar avatar-lg me-3 bg-label-info">
                                <i class="ti ti-book ti-lg"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">{{ __('admin.reports.ebook_performance') }}</h5>
                                <small class="text-muted">{{ __('admin.reports.ebook_performance_desc') }}</small>
                            </div>
                        </div>
                        <p class="text-muted mb-3">
                            {{ __('admin.reports.ebook_performance_detail') }}
                        </p>
                        <a href="{{ route('admin.reports.ebook-performance') }}" class="btn btn-sm btn-primary w-100">
                            <i class="ti ti-eye me-1"></i> {{ __('admin.reports.view_report') }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- User Analytics -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar avatar-lg me-3 bg-label-warning">
                                <i class="ti ti-users ti-lg"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">{{ __('admin.reports.user_analytics') }}</h5>
                                <small class="text-muted">{{ __('admin.reports.user_analytics_desc') }}</small>
                            </div>
                        </div>
                        <p class="text-muted mb-3">
                            {{ __('admin.reports.user_analytics_detail') }}
                        </p>
                        <a href="{{ route('admin.reports.subscription-analytics') }}" class="btn btn-sm btn-primary w-100">
                            <i class="ti ti-eye me-1"></i> {{ __('admin.reports.view_report') }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sales Analytics -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar avatar-lg me-3 bg-label-primary">
                                <i class="ti ti-chart-line ti-lg"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">{{ __('admin.reports.sales_analytics') }}</h5>
                                <small class="text-muted">{{ __('admin.reports.sales_analytics_desc') }}</small>
                            </div>
                        </div>
                        <p class="text-muted mb-3">
                            {{ __('admin.reports.sales_analytics_detail') }}
                        </p>
                        <a href="{{ route('admin.reports.subscription-analytics') }}" class="btn btn-sm btn-primary w-100">
                            <i class="ti ti-eye me-1"></i> {{ __('admin.reports.view_report') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
