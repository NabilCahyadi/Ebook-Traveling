@extends('layouts.admin')

@section('title', __('admin.subscription_history.title'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">{{ __('admin.menu.subscription_management') }} /</span> {{ __('admin.subscription_history.title') }}
            </h4>
            <div>
                <a href="{{ route('admin.subscription-history.export', request()->all()) }}" class="btn btn-success">
                    <i class="ti ti-download me-1"></i> {{ __('admin.actions.export') }}
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="ti ti-receipt-2 ti-sm"></i>
                                </span>
                            </div>
                            <div>
                                <small class="text-muted d-block">{{ __('admin.subscription_history.total_payments') }}</small>
                                <h5 class="mb-0">{{ number_format($stats['total']) }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-info">
                                    <i class="ti ti-hand-click ti-sm"></i>
                                </span>
                            </div>
                            <div>
                                <small class="text-muted d-block">{{ __('admin.subscription_history.manual') }}</small>
                                <h5 class="mb-0">{{ number_format($stats['manual']) }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-warning">
                                    <i class="ti ti-credit-card ti-sm"></i>
                                </span>
                            </div>
                            <div>
                                <small class="text-muted d-block">{{ __('admin.subscription_history.payment_gateway') }}</small>
                                <h5 class="mb-0">{{ number_format($stats['payment_gateway']) }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-success">
                                    <i class="ti ti-currency-dollar ti-sm"></i>
                                </span>
                            </div>
                            <div>
                                <small class="text-muted d-block">{{ __('admin.subscription_history.total_revenue') }}</small>
                                <h5 class="mb-0">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters & Search -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.subscription-history.index') }}">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">{{ __('admin.common.search') }}</label>
                            <input type="text" class="form-control" name="search" placeholder="{{ __('admin.subscription_history.search_placeholder') }}"
                                value="{{ request('search') }}">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">{{ __('admin.subscription_history.type') }}</label>
                            <select class="form-select" name="type">
                                <option value="">{{ __('admin.subscription_history.all_types') }}</option>
                                <option value="manual" {{ request('type') === 'manual' ? 'selected' : '' }}>{{ __('admin.subscription_history.manual') }}
                                </option>
                                <option value="payment_gateway"
                                    {{ request('type') === 'payment_gateway' ? 'selected' : '' }}>{{ __('admin.subscription_history.payment_gateway') }}</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">{{ __('admin.subscription_history.status') }}</label>
                            <select class="form-select" name="status">
                                <option value="">{{ __('admin.subscription_history.all_status') }}</option>
                                <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>{{ __('admin.receipt.paid') }}</option>
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>{{ __('admin.status.pending') }}
                                </option>
                                <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>{{ __('admin.subscription_history.failed') }}
                                </option>
                                <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>{{ __('admin.status.expired') }}
                                </option>
                                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>
                                    {{ __('admin.status.cancelled') }}</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">{{ __('admin.subscription_history.start_date') }}</label>
                            <input type="date" class="form-control" name="start_date"
                                value="{{ request('start_date') }}">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">{{ __('admin.subscription_history.end_date') }}</label>
                            <input type="date" class="form-control" name="end_date"
                                value="{{ request('end_date') }}">
                        </div>

                            <!-- <div class="col-md-2">
                                <label class="form-label">{{ __('admin.common.per_page') }}</label>
                                <select class="form-select" name="per_page">
                                    <option value="15" {{ request('per_page', 15) == 15 ? 'selected' : '' }}>15</option>
                                    <option value="30" {{ request('per_page') == 30 ? 'selected' : '' }}>30</option>
                                    <option value="45" {{ request('per_page') == 45 ? 'selected' : '' }}>45</option>
                                    <option value="60" {{ request('per_page') == 60 ? 'selected' : '' }}>60</option>
                                </select>
                            </div> -->

                        <div class="col-md-1 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="ti ti-filter"></i>
                            </button>
                        </div>

                        @if (request()->hasAny(['search', 'type', 'status', 'start_date', 'end_date', 'per_page']))
                            <div class="col-md-12">
                                <a href="{{ route('admin.subscription-history.index') }}"
                                    class="btn btn-outline-secondary btn-sm">
                                    <i class="ti ti-x me-1"></i> {{ __('admin.actions.clear_filters') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Payment History Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ __('admin.subscription_history.payment_history') }}</h5>
                <div class="d-flex align-items-center gap-2">
                    <label class="text-muted small mb-0">{{ __('admin.common.per_page') }}:</label>
                    <select class="form-select form-select-sm" style="width: auto;" onchange="window.location.href=this.value">
                        @foreach([15, 30, 45, 60] as $perPageOption)
                            <option value="{{ request()->fullUrlWithQuery(['per_page' => $perPageOption, 'page' => 1]) }}" 
                                {{ request('per_page', 15) == $perPageOption ? 'selected' : '' }}>
                                {{ $perPageOption }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>{{ __('admin.subscription_history.user') }}</th>
                            <th>{{ __('admin.subscription_history.plan') }}</th>
                            <th>{{ __('admin.subscription_history.type') }}</th>
                            <th>{{ __('admin.subscription_history.period') }}</th>
                            <th>{{ __('admin.subscription_history.status') }}</th>
                            <th>{{ __('admin.subscription_history.amount') }}</th>
                            <th>{{ __('admin.actions.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($subscriptions as $subscription)
                            <tr>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-semibold">{{ $subscription->user->name }}</span>
                                        <small class="text-muted">{{ $subscription->user->email }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-label-info">{{ $subscription->plan->name }}</span>
                                </td>
                                <td>
                                    @if ($subscription->payment_id)
                                        <span class="badge bg-label-warning">
                                            <i class="ti ti-credit-card me-1"></i> {{ __('admin.subscription_history.payment_gateway') }}
                                        </span>
                                    @else
                                        <span class="badge bg-label-secondary">
                                            <i class="ti ti-hand-click me-1"></i> {{ __('admin.subscription_history.manual') }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <small class="text-muted">{{ __('admin.subscription_history.start') }}:</small>
                                        <small
                                            class="fw-semibold">{{ $subscription->start_date->format('d M Y') }}</small>
                                        <small class="text-muted mt-1">{{ __('admin.subscription_history.end') }}:</small>
                                        <small class="fw-semibold">{{ $subscription->end_date->format('d M Y') }}</small>
                                    </div>
                                </td>
                                <td>
                                    @if ($subscription->status === 'active')
                                        @if ($subscription->end_date->isFuture())
                                            <span class="badge bg-success">Paid</span>
                                        @else
                                            <span class="badge bg-warning">Expired</span>
                                        @endif
                                    @elseif ($subscription->status === 'cancelled')
                                        <span class="badge bg-danger">Cancelled</span>
                                    @elseif ($subscription->status === 'pending')
                                        <span class="badge bg-info">Pending</span>
                                    @elseif ($subscription->status === 'failed')
                                        <span class="badge bg-danger">Failed</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($subscription->status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <strong>Rp {{ number_format($subscription->total_amount, 0, ',', '.') }}</strong>
                                </td>
                                <td>
                                    @if ($subscription->status === 'active' && $subscription->end_date->isFuture())
                                        {{-- Dropdown menu dengan 2 actions --}}
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill" 
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0);" 
                                                        data-bs-toggle="modal" data-bs-target="#detailModal{{ $subscription->id }}">
                                                        <i class="ti ti-eye me-2"></i>
                                                        View Details
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('admin.subscription-history.print', $subscription->id) }}" 
                                                        target="_blank">
                                                        <i class="ti ti-printer me-2"></i>
                                                        {{ __('admin.subscription_history.print_receipt') }}
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    @else
                                        {{-- Hanya 1 action, tampilkan icon biasa --}}
                                        <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill"
                                            data-bs-toggle="modal" data-bs-target="#detailModal{{ $subscription->id }}"
                                            title="View Details">
                                            <i class="ti ti-eye"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>

                            <!-- Detail Modal -->
                            <div class="modal fade" id="detailModal{{ $subscription->id }}" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ __('admin.subscription_history.payment_detail') }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <small class="text-muted d-block">{{ __('admin.manual_subscription.code') }}</small>
                                                    <p class="mb-0 fw-bold text-primary">
                                                        {{ $subscription->subscription_code }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <small class="text-muted d-block">{{ __('admin.subscription_history.type') }}</small>
                                                    @if ($subscription->payment_id)
                                                        <span class="badge bg-label-warning">
                                                            <i class="ti ti-credit-card me-1"></i> {{ __('admin.subscription_history.payment_gateway') }}
                                                        </span>
                                                    @else
                                                        <span class="badge bg-label-secondary">
                                                            <i class="ti ti-hand-click me-1"></i> {{ __('admin.subscription_history.manual') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <small class="text-muted d-block">{{ __('admin.subscription_history.user') }}</small>
                                                    <p class="mb-0 fw-semibold">{{ $subscription->user->name }}</p>
                                                    <small class="text-muted">{{ $subscription->user->email }}</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <small class="text-muted d-block">{{ __('admin.subscription_history.plan') }}</small>
                                                    <p class="mb-0 fw-semibold">{{ $subscription->plan->name }}</p>
                                                    <span class="badge bg-label-info">Rp
                                                        {{ number_format($subscription->plan->price, 0, ',', '.') }} /
                                                        {{ $subscription->plan->duration_in_days }} days</span>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <small class="text-muted d-block">{{ __('admin.subscription_history.start_date') }}</small>
                                                    <p class="mb-0">
                                                        {{ $subscription->start_date->format('d M Y, H:i') }}</p>
                                                </div>
                                                <div class="col-md-4">
                                                    <small class="text-muted d-block">{{ __('admin.subscription_history.end_date') }}</small>
                                                    <p class="mb-0">{{ $subscription->end_date->format('d M Y, H:i') }}
                                                    </p>
                                                </div>
                                                <div class="col-md-4">
                                                    <small class="text-muted d-block">{{ __('admin.subscription_history.status') }}</small>
                                                    <div>
                                                        @if ($subscription->status === 'active')
                                                            @if ($subscription->end_date->isFuture())
                                                                <span class="badge bg-success">{{ __('admin.receipt.paid') }}</span>
                                                            @else
                                                                <span class="badge bg-warning">{{ __('admin.status.expired') }}</span>
                                                            @endif
                                                        @elseif ($subscription->status === 'cancelled')
                                                            <span class="badge bg-danger">{{ __('admin.status.cancelled') }}</span>
                                                        @elseif ($subscription->status === 'pending')
                                                            <span class="badge bg-info">{{ __('admin.status.pending') }}</span>
                                                        @elseif ($subscription->status === 'failed')
                                                            <span class="badge bg-danger">{{ __('admin.subscription_history.failed') }}</span>
                                                        @else
                                                            <span
                                                                class="badge bg-secondary">{{ ucfirst($subscription->status) }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <small class="text-muted d-block">{{ __('admin.subscription_history.total_amount') }}</small>
                                                    <h4 class="mb-0 text-success">Rp
                                                        {{ number_format($subscription->total_amount, 0, ',', '.') }}</h4>
                                                </div>
                                                <div class="col-md-6">
                                                    <small class="text-muted d-block">{{ __('admin.subscription_history.auto_renew') }}</small>
                                                    <p class="mb-0">
                                                        @if ($subscription->auto_renew)
                                                            <span class="badge bg-label-success">{{ __('admin.common.yes') }}</span>
                                                        @else
                                                            <span class="badge bg-label-danger">{{ __('admin.common.no') }}</span>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>

                                            @if ($subscription->payment)
                                                <hr>
                                                <h6 class="mb-3">{{ __('admin.subscription_history.payment_information') }}</h6>
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <small class="text-muted d-block">{{ __('admin.subscription_history.transaction_id') }}</small>
                                                        <p class="mb-0 fw-semibold">
                                                            {{ $subscription->payment->transaction_id ?? '-' }}</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <small class="text-muted d-block">{{ __('admin.subscription_history.payment_method') }}</small>
                                                        <p class="mb-0">
                                                            {{ ucfirst($subscription->payment->payment_method ?? '-') }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <small class="text-muted d-block">{{ __('admin.subscription_history.payment_status') }}</small>
                                                        <div>
                                                            @if ($subscription->payment->status === 'paid')
                                                                <span class="badge bg-success">{{ __('admin.receipt.paid') }}</span>
                                                            @elseif($subscription->payment->status === 'pending')
                                                                <span class="badge bg-warning">{{ __('admin.status.pending') }}</span>
                                                            @elseif($subscription->payment->status === 'failed')
                                                                <span class="badge bg-danger">{{ __('admin.subscription_history.failed') }}</span>
                                                            @else
                                                                <span
                                                                    class="badge bg-secondary">{{ ucfirst($subscription->payment->status) }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <small class="text-muted d-block">{{ __('admin.subscription_history.paid_at') }}</small>
                                                        <p class="mb-0">
                                                            {{ $subscription->payment->paid_at ? $subscription->payment->paid_at->format('d M Y, H:i') : '-' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endif

                                            <hr>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <small class="text-muted d-block">{{ __('admin.common.created_at') }}</small>
                                                    <p class="mb-0">
                                                        {{ $subscription->created_at->format('d M Y, H:i') }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <small class="text-muted d-block">{{ __('admin.subscription_history.last_updated') }}</small>
                                                    <p class="mb-0">
                                                        {{ $subscription->updated_at->format('d M Y, H:i') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">{{ __('admin.actions.close') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="ti ti-info-circle mb-2" style="font-size: 3rem;"></i>
                                        <p class="mb-0">{{ __('admin.subscription_history.no_payment_found') }}</p>
                                        @if (request()->hasAny(['search', 'type', 'status', 'start_date', 'end_date']))
                                            <small>{{ __('admin.subscription_history.try_adjusting') }}</small>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="text-muted small">
                        @if ($subscriptions->total() > 0)
                            {{ __('admin.common.showing') }} {{ $subscriptions->firstItem() }} {{ __('admin.common.to') }} {{ $subscriptions->lastItem() }} {{ __('admin.common.of') }}
                            {{ $subscriptions->total() }} {{ __('admin.common.entries') }}
                        @else
                            {{ __('admin.common.no_entries') }}
                        @endif
                    </div>
                    @if ($subscriptions->hasPages())
                        <div>
                            {{ $subscriptions->withQueryString()->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endpush
