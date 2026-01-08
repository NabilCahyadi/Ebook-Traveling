@extends('layouts.admin')

@section('title', __('admin.reports.subscription_analytics'))

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
                        <li class="breadcrumb-item active">{{ __('admin.reports.subscription_analytics') }}</li>
                    </ol>
                </nav>
                <h4 class="mb-1">{{ __('admin.reports.subscription_analytics') }}</h4>
                <p class="text-muted mb-0">{{ __('admin.reports.subscription_analytics_subtitle') }}</p>
            </div>
        </div>

        <!-- Key Metrics -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="text-primary mb-2">{{ number_format($subscriptionRate, 1) }}%</h3>
                        <p class="text-muted mb-0">{{ __('admin.reports.subscription_rate') }}</p>
                        <small class="text-muted">{{ $activeSubscribers }} / {{ $totalUsers }} users</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="text-success mb-2">{{ number_format($activeSubscribers) }}</h3>
                        <p class="text-muted mb-0">{{ __('admin.reports.active_subscribers') }}</p>
                        <small class="text-muted">&nbsp;</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="text-info mb-2">Rp {{ number_format($mrr, 0, ',', '.') }}</h3>
                        <p class="text-muted mb-0">{{ __('admin.reports.mrr') }}</p>
                        <small class="text-muted">{{ __('admin.reports.monthly_recurring_revenue') }}</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="text-warning mb-2">{{ number_format($churnRate, 1) }}%</h3>
                        <p class="text-muted mb-0">{{ __('admin.reports.churn_rate') }}</p>
                        <small class="text-muted">+{{ $newSubscribersThisMonth }} {{ __('admin.reports.new_this_month') }}</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subscription Trend -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">{{ __('admin.reports.subscription_trend') }}</h5>
            </div>
            <div class="card-body">
                <canvas id="subscriptionTrendChart" height="80"></canvas>
            </div>
        </div>

        <!-- Peak Hours & Subscription Status -->
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">{{ __('admin.reports.peak_subscription_hours') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ __('admin.reports.hour') }}</th>
                                        <th>{{ __('admin.reports.subscriptions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($peakHours as $peak)
                                        <tr>
                                            <td><strong>{{ $peak->hour }}:00 - {{ $peak->hour + 1 }}:00</strong></td>
                                            <td>{{ $peak->count }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center text-muted">
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
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">{{ __('admin.reports.subscription_status') }}</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="subscriptionStatusChart"></canvas>
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

        // Subscription Trend Chart
        const subscriptionTrendCtx = document.getElementById('subscriptionTrendChart').getContext('2d');
        const subscriptionTrendChart = new Chart(subscriptionTrendCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($subscriptionTrend->pluck('date')->map(fn($date) => \Carbon\Carbon::parse($date)->format('d M'))) !!},
                datasets: [{
                    label: isIndonesian ? 'Subscription Baru' : 'New Subscriptions',
                    data: {!! json_encode($subscriptionTrend->pluck('count')) !!},
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
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Subscription Status Chart
        const subscriptionStatusCtx = document.getElementById('subscriptionStatusChart').getContext('2d');
        const subscriptionStatusChart = new Chart(subscriptionStatusCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($subscriptionsByStatus->pluck('status')->map(fn($s) => ucfirst($s))) !!},
                datasets: [{
                    data: {!! json_encode($subscriptionsByStatus->pluck('count')) !!},
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.8)',   // active - green
                        'rgba(255, 206, 86, 0.8)',   // pending - yellow
                        'rgba(255, 99, 132, 0.8)',   // expired - red
                        'rgba(153, 102, 255, 0.8)',  // cancelled - purple
                        'rgba(54, 162, 235, 0.8)'    // other - blue
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
@endpush
