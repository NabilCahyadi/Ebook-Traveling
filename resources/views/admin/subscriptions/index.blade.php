@extends('layouts.admin')

@section('title', __('admin.subscriptions.title'))

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin.menu.dashboard') }}</a></li>
            <li class="breadcrumb-item active">{{ __('admin.subscriptions.title') }}</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><span class="text-muted fw-light">{{ __('admin.subscriptions.title') }} /</span> {{ __('admin.subscriptions.list_title') }}</h4>
            <p class="text-muted mb-0">{{ __('admin.subscriptions.manage_description') }}</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.subscriptions.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">{{ __('admin.common.status') }}</label>
                    <select name="status" class="form-select">
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{ __('admin.subscriptions.date_from') }}</label>
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{ __('admin.subscriptions.date_to') }}</label>
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{ __('admin.common.search') }}</label>
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="{{ __('admin.subscriptions.search_placeholder') }}" value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">
                            <i class="bx bx-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Subscriptions List -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>{{ __('admin.common.user') }}</th>
                            <th>{{ __('admin.common.plan') }}</th>
                            <th>{{ __('admin.common.status') }}</th>
                            <th>{{ __('admin.subscriptions.start') }}</th>
                            <th>{{ __('admin.subscriptions.end') }}</th>
                            <th width="100">{{ __('admin.common.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subscriptions as $index => $subscription)
                            <tr>
                                <td>{{ $subscriptions->firstItem() + $index }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-2">
                                            <span class="avatar-initial rounded-circle bg-primary">
                                                {{ strtoupper(substr($subscription->user->name ?? 'U', 0, 1)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <span class="fw-semibold">{{ $subscription->user->name ?? __('admin.common.unknown') }}</span>
                                            <br>
                                            <small class="text-muted">{{ $subscription->user->email ?? '-' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $subscription->subscriptionPlan->name ?? '-' }}</td>
                                <td>
                                    @php
                                        $isExpired = $subscription->status === 'active' && $subscription->end_date && $subscription->end_date->isPast();
                                        $statusClass = $isExpired ? 'warning' : ($subscription->status === 'active' ? 'success' : 'secondary');
                                        $statusText = $isExpired ? __('admin.status.expired') : ucfirst($subscription->status);
                                    @endphp
                                    <span class="badge bg-{{ $statusClass }}">{{ $statusText }}</span>
                                </td>
                                <td>{{ $subscription->start_date ? $subscription->start_date->format('d M Y') : '-' }}</td>
                                <td>{{ $subscription->end_date ? $subscription->end_date->format('d M Y') : '-' }}</td>
                                <td>
                                    <a href="{{ route('admin.subscriptions.show', $subscription->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bx bx-show"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="bx bx-info-circle fs-1 text-muted mb-2"></i>
                                    <p class="mb-0 text-muted">{{ __('admin.subscriptions.no_subscriptions_found') }}</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($subscriptions->hasPages())
                <div class="mt-4">
                    {{ $subscriptions->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
