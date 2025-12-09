@extends('layouts.admin')

@section('title', 'Subscription Detail')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">Subscription History /</span> Detail
            </h4>
            <a href="{{ route('admin.subscription-history.index') }}" class="btn btn-secondary">
                <i class="ti ti-arrow-left me-1"></i> Back to History
            </a>
        </div>

        <div class="row">
            <!-- Subscription Information -->
            <div class="col-lg-8 mb-4">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Subscription Information</h5>
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
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <small class="text-muted">Subscription Code</small>
                                <p class="mb-0 fw-bold text-primary">{{ $subscription->subscription_code }}</p>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted">Status</small>
                                <div>
                                    @if ($subscription->status === 'active')
                                        @if ($subscription->end_date->isFuture())
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-warning">Expired</span>
                                        @endif
                                    @elseif ($subscription->status === 'cancelled')
                                        <span class="badge bg-danger">Cancelled</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($subscription->status) }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted">Auto Renew</small>
                                <p class="mb-0">
                                    @if ($subscription->auto_renew)
                                        <span class="badge bg-label-success">Yes</span>
                                    @else
                                        <span class="badge bg-label-danger">No</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <hr>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <small class="text-muted">Plan</small>
                                <p class="mb-0 fw-semibold">{{ $subscription->plan->name }}</p>
                                <small class="text-muted">{{ $subscription->plan->description }}</small>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted">Total Amount</small>
                                <h4 class="mb-0 text-success">Rp
                                    {{ number_format($subscription->total_amount, 0, ',', '.') }}</h4>
                            </div>
                        </div>

                        <hr>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <small class="text-muted">Start Date</small>
                                <p class="mb-0">{{ $subscription->start_date->format('d F Y, H:i') }}</p>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted">End Date</small>
                                <p class="mb-0">{{ $subscription->end_date->format('d F Y, H:i') }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <small class="text-muted">Created At</small>
                                <p class="mb-0">{{ $subscription->created_at->format('d F Y, H:i') }}</p>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted">Last Updated</small>
                                <p class="mb-0">{{ $subscription->updated_at->format('d F Y, H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Information (if applicable) -->
                @if ($subscription->payment)
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Payment Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <small class="text-muted">Transaction ID</small>
                                    <p class="mb-0 fw-semibold">{{ $subscription->payment->transaction_id ?? '-' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted">Payment Method</small>
                                    <p class="mb-0">{{ ucfirst($subscription->payment->payment_method ?? '-') }}</p>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <small class="text-muted">Payment Status</small>
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
                                    <small class="text-muted">Paid At</small>
                                    <p class="mb-0">
                                        {{ $subscription->payment->paid_at ? $subscription->payment->paid_at->format('d F Y, H:i') : '-' }}
                                    </p>
                                </div>
                            </div>

                            @if ($subscription->payment->payment_details)
                                <hr>
                                <small class="text-muted">Payment Details</small>
                                <div class="mt-2">
                                    <pre class="bg-light p-3 rounded"><code>{{ json_encode($subscription->payment->payment_details, JSON_PRETTY_PRINT) }}</code></pre>
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="card">
                        <div class="card-body text-center py-4">
                            <i class="ti ti-info-circle text-muted mb-2" style="font-size: 3rem;"></i>
                            <p class="text-muted mb-0">This is a manual subscription without payment gateway.</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- User Information -->
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">User Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <div class="avatar avatar-xl mx-auto mb-3">
                                <span class="avatar-initial rounded-circle bg-label-primary">
                                    {{ strtoupper(substr($subscription->user->name, 0, 2)) }}
                                </span>
                            </div>
                            <h5 class="mb-1">{{ $subscription->user->name }}</h5>
                            <p class="text-muted mb-0">{{ $subscription->user->email }}</p>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Phone</small>
                            <p class="mb-0">{{ $subscription->user->profile->phone ?? '-' }}</p>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">User Since</small>
                            <p class="mb-0">{{ $subscription->user->created_at->format('d F Y') }}</p>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Total Subscriptions</small>
                            <p class="mb-0 fw-bold">{{ $subscription->user->subscriptions->count() }}</p>
                        </div>

                        <hr>

                        <a href="{{ route('admin.users.show', $subscription->user->id) }}" class="btn btn-primary w-100">
                            <i class="ti ti-user me-1"></i> View User Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
