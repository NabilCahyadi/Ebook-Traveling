@extends('layouts.admin')

@section('title', 'Active Subscribers')

@section('content')

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold py-3 mb-2">
                <span class="text-muted fw-light">Subscription /</span> Active Subscribers
            </h4>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="ti ti-filter me-2"></i>Filter Subscribers
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.active-subscribers.index') }}" method="GET" id="filterForm">
                <div class="row g-3">
                    <!-- Search -->
                    <div class="col-md-3">
                        <label for="search" class="form-label">Search</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Name or email...">
                    </div>

                    <!-- Role Filter -->
                    <div class="col-md-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role">
                            <option value="">All Roles</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->slug }}" 
                                    {{ request('role') == $role->slug ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Subscription Plan Filter -->
                    <div class="col-md-3">
                        <label for="subscription_plan" class="form-label">Subscription Plan</label>
                        <select class="form-select" id="subscription_plan" name="subscription_plan">
                            <option value="">All Plans</option>
                            @foreach ($subscriptionPlans as $plan)
                                <option value="{{ $plan->id }}" 
                                    {{ request('subscription_plan') == $plan->id ? 'selected' : '' }}>
                                    {{ $plan->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date From -->
                    <div class="col-md-3">
                        <label for="date_from" class="form-label">Start Date From</label>
                        <input type="date" class="form-control" id="date_from" name="date_from" 
                               value="{{ request('date_from') }}">
                    </div>

                    <!-- Date To -->
                    <div class="col-md-3">
                        <label for="date_to" class="form-label">Start Date To</label>
                        <input type="date" class="form-control" id="date_to" name="date_to" 
                               value="{{ request('date_to') }}">
                    </div>

                    <!-- Filter Buttons -->
                    <div class="col-md-9 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="ti ti-search me-1"></i> Apply Filters
                        </button>
                        <a href="{{ route('admin.active-subscribers.index') }}" class="btn btn-secondary">
                            <i class="ti ti-refresh me-1"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Subscribers Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Subscribers List</h5>
            <div class="text-muted">Total: {{ $subscriptions->total() }} subscribers</div>
        </div>
        <div class="card-body">
            @if ($subscriptions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Plan</th>
                                <th>Status</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Amount</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subscriptions as $subscription)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-2">
                                                <span class="avatar-initial rounded-circle bg-label-primary">
                                                    {{ substr($subscription->user->name ?? 'U', 0, 1) }}
                                                </span>
                                            </div>
                                            <div>
                                                <div class="fw-medium">{{ $subscription->user->name ?? 'N/A' }}</div>
                                                <small class="text-muted">#{{ $subscription->subscription_code }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>{{ $subscription->user->email ?? 'N/A' }}</div>
                                        @if ($subscription->user && $subscription->user->email_verified_at)
                                            <small class="text-success">
                                                <i class="ti ti-check ti-xs"></i> Verified
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($subscription->user && $subscription->user->roles && $subscription->user->roles->count() > 0)
                                            @foreach ($subscription->user->roles as $role)
                                                <span class="badge bg-label-primary mb-1">{{ $role->name }}</span>
                                            @endforeach
                                        @else
                                            <span class="badge bg-label-secondary">No Role</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($subscription->plan)
                                            <div class="fw-medium">{{ $subscription->plan->name }}</div>
                                            <small class="text-muted">
                                                {{ $subscription->plan->duration_days }} days
                                            </small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($subscription->status === 'active')
                                            <span class="badge bg-success">
                                                <i class="ti ti-check ti-xs"></i> Active
                                            </span>
                                        @elseif($subscription->status === 'pending')
                                            <span class="badge bg-warning">
                                                <i class="ti ti-clock ti-xs"></i> Pending
                                            </span>
                                        @elseif($subscription->status === 'expired')
                                            <span class="badge bg-danger">
                                                <i class="ti ti-x ti-xs"></i> Expired
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                {{ ucfirst($subscription->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $subscription->start_date ? $subscription->start_date->format('d M Y') : '-' }}<br>
                                            {{ $subscription->start_date ? $subscription->start_date->format('H:i') : '' }}
                                        </small>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $subscription->end_date ? $subscription->end_date->format('d M Y') : '-' }}<br>
                                            {{ $subscription->end_date ? $subscription->end_date->format('H:i') : '' }}
                                        </small>
                                        @if ($subscription->end_date && $subscription->end_date < now())
                                            <br><small class="text-danger"><i class="ti ti-alert-circle ti-xs"></i> Expired</small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-medium">
                                            Rp {{ number_format($subscription->total_amount ?? 0, 0, ',', '.') }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button"
                                                class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                @if($subscription->user)
                                                    <a class="dropdown-item" href="{{ route('admin.users.show', $subscription->user->id) }}">
                                                        <i class="ti ti-user me-2"></i>
                                                        <span>View User</span>
                                                    </a>
                                                @endif
                                                <a class="dropdown-item" href="{{ route('admin.manual-subscriptions.show', $subscription->id) }}">
                                                    <i class="ti ti-eye me-2"></i>
                                                    <span>View Subscription</span>
                                                </a>
                                                @if($subscription->status === 'active')
                                                    <a class="dropdown-item" href="{{ route('admin.manual-subscriptions.extend', $subscription->id) }}">
                                                        <i class="ti ti-calendar-plus me-2"></i>
                                                        <span>Extend</span>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $subscriptions->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="ti ti-users-off ti-xl text-muted mb-3"></i>
                    <h5 class="text-muted">No subscribers found</h5>
                    <p class="text-muted">
                        @if(request()->hasAny(['search', 'role', 'subscription_plan', 'date_from', 'date_to']))
                            Try adjusting your filters to find what you're looking for.
                        @else
                            There are no active subscribers yet.
                        @endif
                    </p>
                    @if(request()->hasAny(['search', 'role', 'subscription_plan', 'date_from', 'date_to']))
                        <a href="{{ route('admin.active-subscribers.index') }}" class="btn btn-primary mt-2">
                            <i class="ti ti-refresh me-1"></i> Clear Filters
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>

@endsection
