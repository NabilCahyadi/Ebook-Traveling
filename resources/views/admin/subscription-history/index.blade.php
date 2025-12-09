@extends('layouts.admin')

@section('title', 'Payment History')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">Payment /</span> History
            </h4>
            <div>
                <a href="{{ route('admin.subscription-history.export') }}" class="btn btn-success">
                    <i class="ti ti-download me-1"></i> Export
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

        @if (session('info'))
            <div class="alert alert-info alert-dismissible" role="alert">
                {{ session('info') }}
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
                                <small class="text-muted d-block">Total Payments</small>
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
                                <small class="text-muted d-block">Manual</small>
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
                                <small class="text-muted d-block">Payment Gateway</small>
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
                                <small class="text-muted d-block">Total Revenue</small>
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
                            <label class="form-label">Search</label>
                            <input type="text" class="form-control" name="search" placeholder="User, email, code..."
                                value="{{ request('search') }}">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Type</label>
                            <select class="form-select" name="type">
                                <option value="">All Types</option>
                                <option value="manual" {{ request('type') === 'manual' ? 'selected' : '' }}>Manual
                                </option>
                                <option value="payment_gateway"
                                    {{ request('type') === 'payment_gateway' ? 'selected' : '' }}>Payment Gateway</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="">All Status</option>
                                <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed
                                </option>
                                <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expired
                                </option>
                                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>
                                    Cancelled</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Start Date</label>
                            <input type="date" class="form-control" name="start_date"
                                value="{{ request('start_date') }}">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">End Date</label>
                            <input type="date" class="form-control" name="end_date"
                                value="{{ request('end_date') }}">
                        </div>

                        <div class="col-md-1 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="ti ti-filter"></i>
                            </button>
                        </div>

                        @if (request()->hasAny(['search', 'type', 'status', 'start_date', 'end_date']))
                            <div class="col-md-12">
                                <a href="{{ route('admin.subscription-history.index') }}"
                                    class="btn btn-outline-secondary btn-sm">
                                    <i class="ti ti-x me-1"></i> Clear Filters
                                </a>
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Payment History Table -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Payment History</h5>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>User</th>
                            <th>Plan</th>
                            <th>Type</th>
                            <th>Period</th>
                            <th>Status</th>
                            <th>Amount</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($subscriptions as $subscription)
                            <tr>
                                <td>
                                    <strong class="text-primary">{{ $subscription->subscription_code }}</strong>
                                </td>
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
                                            <i class="ti ti-credit-card me-1"></i> Payment Gateway
                                        </span>
                                    @else
                                        <span class="badge bg-label-secondary">
                                            <i class="ti ti-hand-click me-1"></i> Manual
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <small class="text-muted">Start:</small>
                                        <small
                                            class="fw-semibold">{{ $subscription->start_date->format('d M Y') }}</small>
                                        <small class="text-muted mt-1">End:</small>
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
                                    <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill"
                                        data-bs-toggle="modal" data-bs-target="#detailModal{{ $subscription->id }}"
                                        title="View Details">
                                        <i class="ti ti-eye"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Detail Modal -->
                            <div class="modal fade" id="detailModal{{ $subscription->id }}" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Payment Detail</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <small class="text-muted d-block">Subscription Code</small>
                                                    <p class="mb-0 fw-bold text-primary">
                                                        {{ $subscription->subscription_code }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <small class="text-muted d-block">Type</small>
                                                    @if ($subscription->payment_id)
                                                        <span class="badge bg-label-warning">
                                                            <i class="ti ti-credit-card me-1"></i> Payment Gateway
                                                        </span>
                                                    @else
                                                        <span class="badge bg-label-secondary">
                                                            <i class="ti ti-hand-click me-1"></i> Manual
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <small class="text-muted d-block">User</small>
                                                    <p class="mb-0 fw-semibold">{{ $subscription->user->name }}</p>
                                                    <small class="text-muted">{{ $subscription->user->email }}</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <small class="text-muted d-block">Plan</small>
                                                    <p class="mb-0 fw-semibold">{{ $subscription->plan->name }}</p>
                                                    <span class="badge bg-label-info">Rp
                                                        {{ number_format($subscription->plan->price, 0, ',', '.') }} /
                                                        {{ $subscription->plan->duration_in_days }} days</span>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <small class="text-muted d-block">Start Date</small>
                                                    <p class="mb-0">
                                                        {{ $subscription->start_date->format('d M Y, H:i') }}</p>
                                                </div>
                                                <div class="col-md-4">
                                                    <small class="text-muted d-block">End Date</small>
                                                    <p class="mb-0">{{ $subscription->end_date->format('d M Y, H:i') }}
                                                    </p>
                                                </div>
                                                <div class="col-md-4">
                                                    <small class="text-muted d-block">Status</small>
                                                    <div>
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
                                                            <span
                                                                class="badge bg-secondary">{{ ucfirst($subscription->status) }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <small class="text-muted d-block">Total Amount</small>
                                                    <h4 class="mb-0 text-success">Rp
                                                        {{ number_format($subscription->total_amount, 0, ',', '.') }}</h4>
                                                </div>
                                                <div class="col-md-6">
                                                    <small class="text-muted d-block">Auto Renew</small>
                                                    <p class="mb-0">
                                                        @if ($subscription->auto_renew)
                                                            <span class="badge bg-label-success">Yes</span>
                                                        @else
                                                            <span class="badge bg-label-danger">No</span>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>

                                            @if ($subscription->payment)
                                                <hr>
                                                <h6 class="mb-3">Payment Information</h6>
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <small class="text-muted d-block">Transaction ID</small>
                                                        <p class="mb-0 fw-semibold">
                                                            {{ $subscription->payment->transaction_id ?? '-' }}</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <small class="text-muted d-block">Payment Method</small>
                                                        <p class="mb-0">
                                                            {{ ucfirst($subscription->payment->payment_method ?? '-') }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <small class="text-muted d-block">Payment Status</small>
                                                        <div>
                                                            @if ($subscription->payment->status === 'paid')
                                                                <span class="badge bg-success">Paid</span>
                                                            @elseif($subscription->payment->status === 'pending')
                                                                <span class="badge bg-warning">Pending</span>
                                                            @elseif($subscription->payment->status === 'failed')
                                                                <span class="badge bg-danger">Failed</span>
                                                            @else
                                                                <span
                                                                    class="badge bg-secondary">{{ ucfirst($subscription->payment->status) }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <small class="text-muted d-block">Paid At</small>
                                                        <p class="mb-0">
                                                            {{ $subscription->payment->paid_at ? $subscription->payment->paid_at->format('d M Y, H:i') : '-' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endif

                                            <hr>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <small class="text-muted d-block">Created At</small>
                                                    <p class="mb-0">
                                                        {{ $subscription->created_at->format('d M Y, H:i') }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <small class="text-muted d-block">Last Updated</small>
                                                    <p class="mb-0">
                                                        {{ $subscription->updated_at->format('d M Y, H:i') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="ti ti-info-circle mb-2" style="font-size: 3rem;"></i>
                                        <p class="mb-0">No payment history found.</p>
                                        @if (request()->hasAny(['search', 'type', 'status', 'start_date', 'end_date']))
                                            <small>Try adjusting your filters.</small>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($subscriptions->hasPages())
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Showing {{ $subscriptions->firstItem() }} to {{ $subscriptions->lastItem() }} of
                            {{ $subscriptions->total() }} entries
                        </div>
                        <div>
                            {{ $subscriptions->links() }}
                        </div>
                    </div>
                </div>
            @endif
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
