@extends('layouts.admin')

@section('title', 'Subscription Plans')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">Admin /</span> Subscription Plans
            </h4>
            <a href="{{ route('admin.subscription-plans.create') }}" class="btn btn-primary">
                <i class="bx bx-plus me-1"></i> Add New Plan
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
                <h5 class="mb-0">All Subscription Plans</h5>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Plan Name</th>
                            <th>Duration</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Subscribers</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($plans as $plan)
                            <tr>
                                <td>
                                    <div>
                                        <strong class="d-block">{{ $plan->name }}</strong>
                                        @if ($plan->description)
                                            <small class="text-muted">{{ Str::limit($plan->description, 50) }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-label-info">
                                        @if ($plan->duration_days == 30)
                                            1 Month
                                        @elseif($plan->duration_days == 180)
                                            6 Months
                                        @elseif($plan->duration_days == 365)
                                            1 Year
                                        @else
                                            {{ $plan->duration_days }} Days
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <strong class="text-primary">Rp {{ number_format($plan->price, 0, ',', '.') }}</strong>
                                </td>
                                <td>
                                    @if ($plan->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="text-muted">{{ $plan->subscriptions->count() }}</span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item"
                                                href="{{ route('admin.subscription-plans.show', $plan->id) }}">
                                                <i class="bx bx-show me-2"></i> View Details
                                            </a>
                                            <a class="dropdown-item"
                                                href="{{ route('admin.subscription-plans.edit', $plan->id) }}">
                                                <i class="bx bx-edit me-2"></i> Edit
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('admin.subscription-plans.destroy', $plan->id) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this plan?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="bx bx-trash me-2"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="bx bx-package" style="font-size: 48px; color: #ddd;"></i>
                                    <p class="mt-2 text-muted">No subscription plans found</p>
                                    <a href="{{ route('admin.subscription-plans.create') }}"
                                        class="btn btn-sm btn-primary">Add Your First Plan</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($plans->hasPages())
                <div class="card-footer">
                    {{ $plans->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
