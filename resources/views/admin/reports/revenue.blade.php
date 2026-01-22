@extends('layouts.admin')

@section('title', __('admin.reports.revenue_report'))

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
                        <li class="breadcrumb-item active">{{ __('admin.reports.revenue_report') }}</li>
                    </ol>
                </nav>
                <h4 class="mb-1">{{ __('admin.reports.revenue_report') }}</h4>
                <p class="text-muted mb-0">{{ __('admin.reports.revenue_report_subtitle') }}</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.reports.revenue') }}" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">{{ __('admin.reports.filter_type') }}</label>
                        <select name="filter" class="form-select" onchange="this.form.submit()">
                            <option value="day" {{ $filter === 'day' ? 'selected' : '' }}>{{ __('admin.reports.daily') }}</option>
                            <option value="week" {{ $filter === 'week' ? 'selected' : '' }}>{{ __('admin.reports.weekly') }}</option>
                            <option value="month" {{ $filter === 'month' ? 'selected' : '' }}>{{ __('admin.reports.monthly') }}</option>
                            <option value="year" {{ $filter === 'year' ? 'selected' : '' }}>{{ __('admin.reports.yearly') }}</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('admin.reports.start_date') }}</label>
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('admin.reports.end_date') }}</label>
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2 mt-2">
                            <i class="ti ti-filter me-1"></i> {{ __('admin.reports.apply_filter') }}
                        </button>
                        <a href="{{ route('admin.reports.revenue') }}" class="btn btn-outline-secondary">
                            {{ __('admin.reports.reset') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Total Revenue Card -->
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center">
                        <h2 class="text-primary mb-2">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
                        <p class="text-muted mb-0">{{ __('admin.reports.total_revenue') }}</p>
                        <small class="text-muted">
                            {{ $start->format('d M Y') }} - {{ $end->format('d M Y') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue Trend Chart -->
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{ __('admin.reports.revenue_trend') }}</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="revenueTrendChart" height="80"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue by Subscription Plan & Payment Method -->
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">Pendapatan per Subscription Plan</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="revenueByPlanChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">Pendapatan per Metode Pembayaran</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="revenueByPaymentMethodChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Methods -->
        <div class="row g-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{ __('admin.reports.payment_methods') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ __('admin.reports.payment_method') }}</th>
                                        <th>{{ __('admin.reports.transactions') }}</th>
                                        <th>{{ __('admin.reports.total_amount') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($paymentMethodsTable as $method)
                                        <tr>
                                            <td><strong>{{ $method->payment_method ?? 'N/A' }}</strong></td>
                                            <td>{{ $method->count }}</td>
                                            <td>Rp {{ number_format($method->total, 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">
                                                {{ __('admin.reports.no_data') }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        const locale = '{{ app()->getLocale() }}';
        const isIndonesian = locale === 'id';

        // Revenue Trend Chart
        const revenueTrendCtx = document.getElementById('revenueTrendChart').getContext('2d');
        const revenueTrendChart = new Chart(revenueTrendCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($revenueByDate->pluck('date')->map(fn($date) => \Carbon\Carbon::parse($date)->format('d M'))) !!},
                datasets: [{
                    label: '{{ __("admin.reports.revenue") }}',
                    data: {!! json_encode($revenueByDate->pluck('total')) !!},
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                if (value >= 1000000) {
                                    return 'Rp ' + (value / 1000000).toFixed(1) + (isIndonesian ? ' Jt' : 'M');
                                }
                                return 'Rp ' + (value / 1000).toFixed(0) + 'K';
                            }
                        }
                    }
                }
            }
        });

        // Revenue by Subscription Plan Chart
        const planCtx = document.getElementById('revenueByPlanChart').getContext('2d');
        const planChart = new Chart(planCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($revenueByPlan->pluck('name')) !!},
                datasets: [{
                    data: {!! json_encode($revenueByPlan->pluck('total')) !!},
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                        'rgba(255, 159, 64, 0.8)',
                        'rgba(99, 255, 132, 0.8)',
                        'rgba(235, 54, 162, 0.8)',
                        'rgba(86, 255, 206, 0.8)',
                        'rgba(192, 75, 192, 0.8)'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += 'Rp ' + context.parsed.toLocaleString('id-ID');
                                return label;
                            }
                        }
                    }
                }
            }
        });

        // Revenue by Payment Method Chart
        const paymentMethodCtx = document.getElementById('revenueByPaymentMethodChart').getContext('2d');
        const paymentMethodChart = new Chart(paymentMethodCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($revenueByPaymentMethod->pluck('payment_method')) !!},
                datasets: [{
                    data: {!! json_encode($revenueByPaymentMethod->pluck('total')) !!},
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                        'rgba(255, 159, 64, 0.8)',
                        'rgba(99, 255, 132, 0.8)',
                        'rgba(235, 54, 162, 0.8)',
                        'rgba(86, 255, 206, 0.8)',
                        'rgba(192, 75, 192, 0.8)'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += 'Rp ' + context.parsed.toLocaleString('id-ID');
                                return label;
                            }
                        }
                    }
                }
            }
        });
    </script>
@endpush
