@extends('layouts.admin')

@section('title', __('admin.subscribers.title'))

@section('content')

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ __('admin.messages.success_title') }}</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ __('admin.messages.error_title') }}</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold py-3 mb-2">
                <span class="text-muted fw-light">{{ __('admin.menu.subscription') }} /</span> {{ __('admin.subscribers.title') }}
            </h4>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="ti ti-filter me-2"></i>{{ __('admin.subscribers.filter_subscribers') }}
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.active-subscribers.index') }}" method="GET" id="filterForm">
                <div class="row g-3">
                    <!-- Search -->
                    <div class="col-md-3">
                        <label for="search" class="form-label">{{ __('admin.common.search') }}</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ request('search') }}" 
                               placeholder="{{ __('admin.subscribers.search_placeholder') }}">
                    </div>

                    <!-- Role Filter -->
                    <div class="col-md-3">
                        <label for="role" class="form-label">{{ __('admin.users.role') }}</label>
                        <select class="form-select" id="role" name="role">
                            <option value="">{{ __('admin.users.all_roles') }}</option>
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
                        <label for="subscription_plan" class="form-label">{{ __('admin.subscribers.subscription_plan') }}</label>
                        <select class="form-select" id="subscription_plan" name="subscription_plan">
                            <option value="">{{ __('admin.subscribers.all_plans') }}</option>
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
                        <label for="date_from" class="form-label">{{ __('admin.subscribers.start_date_from') }}</label>
                        <input type="date" class="form-control" id="date_from" name="date_from" 
                               value="{{ request('date_from') }}">
                    </div>

                    <!-- Date To -->
                    <div class="col-md-3">
                        <label for="date_to" class="form-label">{{ __('admin.subscribers.start_date_to') }}</label>
                        <input type="date" class="form-control" id="date_to" name="date_to" 
                               value="{{ request('date_to') }}">
                    </div>

                    <!-- Filter Buttons -->
                    <div class="col-md-9 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="ti ti-search me-1"></i> {{ __('admin.actions.apply_filters') }}
                        </button>
                        <a href="{{ route('admin.active-subscribers.index') }}" class="btn btn-secondary">
                            <i class="ti ti-refresh me-1"></i> {{ __('admin.actions.reset') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Subscribers Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ __('admin.subscribers.list') }}</h5>
            <div class="text-muted">{{ __('admin.common.total') }}: {{ $subscriptions->total() }} {{ __('admin.subscribers.subscribers') }}</div>
        </div>
        <div class="card-body">
            @if ($subscriptions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('admin.subscribers.user') }}</th>
                                <th>{{ __('admin.subscribers.email') }}</th>
                                <th>{{ __('admin.subscribers.role') }}</th>
                                <th>{{ __('admin.subscribers.plan') }}</th>
                                <th>{{ __('admin.subscribers.status') }}</th>
                                <th>{{ __('admin.subscribers.start_date') }}</th>
                                <th>{{ __('admin.subscribers.end_date') }}</th>
                                <th>{{ __('admin.subscribers.amount') }}</th>
                                <th>{{ __('admin.actions.actions') }}</th>
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
                                                <i class="ti ti-check ti-xs"></i> {{ __('admin.status.verified') }}
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($subscription->user && $subscription->user->roles && $subscription->user->roles->count() > 0)
                                            @foreach ($subscription->user->roles as $role)
                                                <span class="badge bg-label-primary mb-1">{{ $role->name }}</span>
                                            @endforeach
                                        @else
                                            <span class="badge bg-label-secondary">{{ __('admin.users.no_role') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($subscription->plan)
                                            <div class="fw-medium">{{ $subscription->plan->name }}</div>
                                            <small class="text-muted">
                                                {{ $subscription->plan->duration_days }} {{ __('admin.subscribers.days') }}
                                            </small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($subscription->status === 'active')
                                            <span class="badge bg-success">
                                                <i class="ti ti-check ti-xs"></i> {{ __('admin.status.active') }}
                                            </span>
                                        @elseif($subscription->status === 'pending')
                                            <span class="badge bg-warning">
                                                <i class="ti ti-clock ti-xs"></i> {{ __('admin.status.pending') }}
                                            </span>
                                        @elseif($subscription->status === 'expired')
                                            <span class="badge bg-danger">
                                                <i class="ti ti-x ti-xs"></i> {{ __('admin.status.expired') }}
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
                                            <br><small class="text-danger"><i class="ti ti-alert-circle ti-xs"></i> {{ __('admin.status.expired') }}</small>
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
                                                        <span>{{ __('admin.actions.view_user') }}</span>
                                                    </a>
                                                @endif
                                                <a class="dropdown-item" href="{{ route('admin.manual-subscriptions.show', $subscription->id) }}">
                                                    <i class="ti ti-eye me-2"></i>
                                                    <span>{{ __('admin.actions.view_subscription') }}</span>
                                                </a>
                                                @if($subscription->status === 'active')
                                                    <a class="dropdown-item" href="{{ route('admin.manual-subscriptions.extend', $subscription->id) }}">
                                                        <i class="ti ti-calendar-plus me-2"></i>
                                                        <span>{{ __('admin.actions.extend') }}</span>
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
                    <h5 class="text-muted">{{ __('admin.subscribers.no_subscribers') }}</h5>
                    <p class="text-muted">
                        @if(request()->hasAny(['search', 'role', 'subscription_plan', 'date_from', 'date_to']))
                            {{ __('admin.subscribers.try_adjusting') }}
                        @else
                            {{ __('admin.subscribers.no_active_yet') }}
                        @endif
                    </p>
                    @if(request()->hasAny(['search', 'role', 'subscription_plan', 'date_from', 'date_to']))
                        <a href="{{ route('admin.active-subscribers.index') }}" class="btn btn-primary mt-2">
                            <i class="ti ti-refresh me-1"></i> {{ __('admin.actions.clear_filters') }}
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>

@endsection
