@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-xl me-4">
                            <span class="avatar-initial rounded-circle bg-label-light">
                                {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                            </span>
                        </div>
                        <div>
                            <h4 class="text-white mb-1">Welcome back, {{ auth()->user()->name ?? 'Admin' }}! 👋</h4>
                            <p class="text-white mb-0 opacity-75">Here's what's happening with your ebook store today.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Ebooks -->
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="avatar">
                            <div class="avatar-initial bg-label-primary rounded">
                                <i class="ti ti-book ti-lg"></i>
                            </div>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow"
                                data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical ti-md"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="{{ route('admin.ebooks.index') }}">View All</a>
                                <a class="dropdown-item" href="{{ route('admin.ebooks.create') }}">Add New</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-info mt-4">
                        <h4 class="mb-1">{{ number_format($totalEbooks) }}</h4>
                        <p class="mb-0">Total Ebooks</p>
                        <a href="{{ route('admin.ebooks.index') }}" class="text-primary small">View all ebooks →</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="avatar">
                            <div class="avatar-initial bg-label-success rounded">
                                <i class="ti ti-users ti-lg"></i>
                            </div>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow"
                                data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical ti-md"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="{{ route('admin.users.index') }}">View All</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-info mt-4">
                        <h4 class="mb-1">{{ number_format($totalUsers) }}</h4>
                        <p class="mb-0">Total Users</p>
                        <a href="{{ route('admin.users.index') }}" class="text-success small">View all users →</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Categories -->
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="avatar">
                            <div class="avatar-initial bg-label-info rounded">
                                <i class="ti ti-tags ti-lg"></i>
                            </div>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow"
                                data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical ti-md"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="{{ route('admin.categories.index') }}">View All</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-info mt-4">
                        <h4 class="mb-1">{{ number_format($totalCategories) }}</h4>
                        <p class="mb-0">Total Categories</p>
                        <a href="{{ route('admin.categories.index') }}" class="text-info small">Manage categories →</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Cities -->
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="avatar">
                            <div class="avatar-initial bg-label-warning rounded">
                                <i class="ti ti-map-pin ti-lg"></i>
                            </div>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow"
                                data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical ti-md"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="{{ route('admin.cities.index') }}">View All</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-info mt-4">
                        <h4 class="mb-1">{{ number_format($totalCities) }}</h4>
                        <p class="mb-0">Total Cities</p>
                        <a href="{{ route('admin.cities.index') }}" class="text-warning small">Manage cities →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Ebooks -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Ebooks</h5>
                    <a href="{{ route('admin.ebooks.index') }}" class="btn btn-sm btn-primary">
                        <i class="ti ti-eye me-1"></i> View All
                    </a>
                </div>
                <div class="card-body">
                    @if ($recentEbooks->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Cover</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>City</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentEbooks as $ebook)
                                        <tr>
                                            <td>
                                                @if ($ebook->cover_image)
                                                    <img src="{{ Storage::url($ebook->cover_image) }}"
                                                        alt="{{ $ebook->title }}" class="rounded"
                                                        style="width: 40px; height: 56px; object-fit: cover;">
                                                @else
                                                    <div class="bg-label-secondary rounded d-flex align-items-center justify-content-center"
                                                        style="width: 40px; height: 56px;">
                                                        <i class="ti ti-book"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="fw-medium">{{ Str::limit($ebook->title, 40) }}</div>
                                            </td>
                                            <td>
                                                @if ($ebook->category)
                                                    <span class="badge bg-label-info">{{ $ebook->category->name }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($ebook->city)
                                                    <span class="badge bg-label-secondary">{{ $ebook->city->name }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($ebook->is_active)
                                                    <span class="badge bg-label-success">Active</span>
                                                @else
                                                    <span class="badge bg-label-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <small
                                                    class="text-muted">{{ $ebook->created_at->diffForHumans() }}</small>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.ebooks.edit', $ebook->id) }}"
                                                    class="btn btn-sm btn-icon btn-text-secondary rounded-pill">
                                                    <i class="ti ti-pencil"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="ti ti-book-off ti-xl text-muted mb-3 d-block" style="font-size: 3rem;"></i>
                            <h6 class="text-muted">No ebooks yet</h6>
                            <p class="text-muted mb-3">Start by creating your first ebook</p>
                            <a href="{{ route('admin.ebooks.create') }}" class="btn btn-primary">
                                <i class="ti ti-plus me-1"></i> Add New Ebook
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
