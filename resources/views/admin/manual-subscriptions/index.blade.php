@extends('layouts.admin')

@section('title', 'Manual Subscriptions')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">Subscription /</span> Manual Subscriptions
            </h4>
            <a href="{{ route('admin.manual-subscriptions.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i> Create Manual Subscription
            </a>
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

        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h5 class="mb-0">All Subscriptions</h5>
                    </div>
                    <div class="col-md-6">
                        <form method="GET" action="{{ route('admin.manual-subscriptions.index') }}">
                            <div class="input-group">
                                <span class="input-group-text"><i class="ti ti-search"></i></span>
                                <input type="text" class="form-control" name="search"
                                    placeholder="Search by user name, email, or code..." value="{{ $search ?? '' }}">
                                <button type="submit" class="btn btn-primary">Search</button>
                                @if ($search)
                                    <a href="{{ route('admin.manual-subscriptions.index') }}"
                                        class="btn btn-outline-secondary">Clear</a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Subscription Code</th>
                            <th>User</th>
                            <th>Plan</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Amount</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($subscriptions as $subscription)
                            <tr>
                                <td>
                                    <strong>{{ $subscription->subscription_code }}</strong>
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
                                <td>{{ $subscription->start_date->format('d M Y') }}</td>
                                <td>{{ $subscription->end_date->format('d M Y') }}</td>
                                <td>
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
                                </td>
                                <td>Rp {{ number_format($subscription->total_amount, 0, ',', '.') }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-sm btn-icon dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item"
                                                href="{{ route('admin.manual-subscriptions.show', $subscription->id) }}">
                                                <i class="ti ti-eye me-2"></i> View Details
                                            </a>
                                            @if ($subscription->status === 'active')
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.manual-subscriptions.extend', $subscription->id) }}">
                                                    <i class="ti ti-clock me-2"></i> Extend
                                                </a>
                                                <form
                                                    action="{{ route('admin.manual-subscriptions.cancel', $subscription->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item text-warning"
                                                        onclick="return confirm('Are you sure you want to cancel this subscription?')">
                                                        <i class="ti ti-x me-2"></i> Cancel Subscription
                                                    </button>
                                                </form>
                                            @endif
                                            <div class="dropdown-divider"></div>
                                            <form
                                                action="{{ route('admin.manual-subscriptions.destroy', $subscription->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"
                                                    onclick="return confirm('Are you sure you want to delete this subscription? This action cannot be undone.')">
                                                    <i class="ti ti-trash me-2"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="ti ti-info-circle mb-2" style="font-size: 2rem;"></i>
                                        <p>No subscriptions found.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($subscriptions->hasPages())
                <div class="card-footer">
                    {{ $subscriptions->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
