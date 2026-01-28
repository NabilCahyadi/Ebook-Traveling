@extends('layouts.admin')

@section('title', __('admin.subscriptions.detail_title'))

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin.menu.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.subscriptions.index') }}">{{ __('admin.subscriptions.title') }}</a></li>
            <li class="breadcrumb-item active">{{ __('admin.common.detail') }}</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><span class="text-muted fw-light">{{ __('admin.subscriptions.title') }} /</span> {{ __('admin.subscriptions.detail_title') }}</h4>
            <p class="text-muted mb-0">{{ __('admin.common.detail') }} #{{ $subscription->id }}</p>
        </div>
        <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-outline-secondary">
            <i class="bx bx-arrow-back me-1"></i> {{ __('admin.common.back') }}
        </a>
    </div>

    <div class="row">
        <!-- Subscription Info -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('admin.subscriptions.subscription_info') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">{{ __('admin.common.plan') }}</label>
                            <p class="fw-semibold mb-0">{{ $subscription->subscriptionPlan->name ?? '-' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">{{ __('admin.common.status') }}</label>
                            <p class="mb-0">
                                @php
                                    $isExpired = $subscription->status === 'active' && $subscription->end_date && $subscription->end_date->isPast();
                                    $statusClass = $isExpired ? 'warning' : ($subscription->status === 'active' ? 'success' : 'secondary');
                                    $statusText = $isExpired ? __('admin.status.expired') : ucfirst($subscription->status);
                                @endphp
                                <span class="badge bg-{{ $statusClass }}">{{ $statusText }}</span>
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">{{ __('admin.subscriptions.start_date') }}</label>
                            <p class="fw-semibold mb-0">{{ $subscription->start_date ? $subscription->start_date->format('d F Y') : '-' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">{{ __('admin.subscriptions.end_date') }}</label>
                            <p class="fw-semibold mb-0">{{ $subscription->end_date ? $subscription->end_date->format('d F Y') : '-' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">{{ __('admin.common.price') }}</label>
                            <p class="fw-semibold mb-0">Rp {{ number_format($subscription->subscriptionPlan->price ?? 0, 0, ',', '.') }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">{{ __('admin.subscriptions.created') }}</label>
                            <p class="fw-semibold mb-0">{{ $subscription->created_at->format('d F Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($subscription->payment)
            <!-- Payment Info -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('admin.subscriptions.payment_info') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">{{ __('admin.subscriptions.payment_id') }}</label>
                            <p class="fw-semibold mb-0">{{ $subscription->payment->id }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">{{ __('admin.common.status') }}</label>
                            <p class="mb-0">
                                <span class="badge bg-{{ $subscription->payment->status === 'paid' ? 'success' : 'warning' }}">
                                    {{ ucfirst($subscription->payment->status) }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">{{ __('admin.common.amount') }}</label>
                            <p class="fw-semibold mb-0">Rp {{ number_format($subscription->payment->amount ?? 0, 0, ',', '.') }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">{{ __('admin.common.method') }}</label>
                            <p class="fw-semibold mb-0">{{ $subscription->payment->payment_method ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- User Info -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('admin.subscriptions.user_info') }}</h5>
                </div>
                <div class="card-body text-center">
                    <div class="avatar avatar-xl mx-auto mb-3">
                        @if($subscription->user->profile_photo)
                            <img src="{{ asset('storage/' . $subscription->user->profile_photo) }}" alt="Avatar" class="rounded-circle">
                        @else
                            <span class="avatar-initial rounded-circle bg-primary fs-1">
                                {{ strtoupper(substr($subscription->user->name ?? 'U', 0, 1)) }}
                            </span>
                        @endif
                    </div>
                    <h5 class="mb-1">{{ $subscription->user->name ?? __('admin.common.unknown') }}</h5>
                    <p class="text-muted mb-3">{{ $subscription->user->email ?? '-' }}</p>
                    
                    <a href="{{ route('admin.users.show', $subscription->user->id) }}" class="btn btn-outline-primary btn-sm">
                        <i class="bx bx-user me-1"></i> {{ __('admin.actions.view_profile') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
