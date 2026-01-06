@extends('layouts.panel')

@section('title', 'Dashboard')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Welcome back, {{ auth()->user()->name }}! 👋</h4>
            <p class="text-muted mb-0">Here's what's happening with your content today.</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Ebooks -->
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="card-info">
                            <p class="card-text text-muted mb-1">Total Ebooks</p>
                            <div class="d-flex align-items-center">
                                <h4 class="mb-0 me-2">{{ $totalEbooks }}</h4>
                            </div>
                        </div>
                        <div class="card-icon">
                            <span class="badge bg-label-primary rounded p-2">
                                <i class="ti ti-book ti-26px"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Published Ebooks -->
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="card-info">
                            <p class="card-text text-muted mb-1">Published</p>
                            <div class="d-flex align-items-center">
                                <h4 class="mb-0 me-2">{{ $publishedEbooks }}</h4>
                            </div>
                        </div>
                        <div class="card-icon">
                            <span class="badge bg-label-success rounded p-2">
                                <i class="ti ti-check ti-26px"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Ebooks -->
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="card-info">
                            <p class="card-text text-muted mb-1">Pending Review</p>
                            <div class="d-flex align-items-center">
                                <h4 class="mb-0 me-2">{{ $pendingEbooks }}</h4>
                            </div>
                        </div>
                        <div class="card-icon">
                            <span class="badge bg-label-warning rounded p-2">
                                <i class="ti ti-clock ti-26px"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Draft Ebooks -->
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="card-info">
                            <p class="card-text text-muted mb-1">Drafts</p>
                            <div class="d-flex align-items-center">
                                <h4 class="mb-0 me-2">{{ $draftEbooks }}</h4>
                            </div>
                        </div>
                        <div class="card-icon">
                            <span class="badge bg-label-secondary rounded p-2">
                                <i class="ti ti-file ti-26px"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Ebooks -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Recent Ebooks</h5>
                    @if($recentEbooks->count() > 0)
                        <a href="{{ route('panel.ebooks.index') }}" class="btn btn-sm btn-primary">View All</a>
                    @endif
                </div>
                <div class="card-body">
                    @if($recentEbooks->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentEbooks as $ebook)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($ebook->thumbnail)
                                                        <img src="{{ $ebook->thumbnail_url }}" alt="{{ $ebook->title }}" class="rounded me-2" style="width: 40px; height: 60px; object-fit: cover;">
                                                    @endif
                                                    <span>{{ Str::limit($ebook->title, 40) }}</span>
                                                </div>
                                            </td>
                                            <td>{{ $ebook->category->name ?? '-' }}</td>
                                            <td>
                                                @if($ebook->status === 'published')
                                                    <span class="badge bg-success">Published</span>
                                                @elseif($ebook->status === 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @else
                                                    <span class="badge bg-secondary">Draft</span>
                                                @endif
                                            </td>
                                            <td>{{ $ebook->created_at->diffForHumans() }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="ti ti-book-off ti-48px text-muted mb-3"></i>
                            <p class="text-muted mb-3">You haven't created any ebooks yet.</p>
                            <a href="{{ route('panel.ebooks.create') }}" class="btn btn-primary">
                                <i class="ti ti-plus me-1"></i>Create Your First Ebook
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Monthly Stats -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Ebook Creation (Last 6 Months)</h5>
                </div>
                <div class="card-body">
                    <canvas id="monthlyChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    @if($recentBlogs->count() > 0)
    <div class="row g-4 mt-2">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Recent Blogs</h5>
                    <a href="{{ route('panel.blogs.index') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentBlogs as $blog)
                                    <tr>
                                        <td>{{ Str::limit($blog->title, 60) }}</td>
                                        <td>
                                            @if($blog->status === 'published')
                                                <span class="badge bg-success">Published</span>
                                            @else
                                                <span class="badge bg-secondary">Draft</span>
                                            @endif
                                        </td>
                                        <td>{{ $blog->created_at->diffForHumans() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Monthly chart
    const monthlyCtx = document.getElementById('monthlyChart');
    if (monthlyCtx) {
        const monthlyData = @json($monthlyStats);
        
        new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: monthlyData.map(item => item.month),
                datasets: [{
                    label: 'Ebooks Created',
                    data: monthlyData.map(item => item.count),
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
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
    }
</script>
@endpush
@endsection

