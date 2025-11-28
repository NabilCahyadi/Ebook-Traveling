@extends('layouts.admin')

@section('title', 'Subscription Details')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Subscription / Manual Subscriptions /</span> Details
        </h4>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Subscription Information</h5>
                        <div>
                            @if ($subscription->status === 'active' && $subscription->end_date->isFuture())
                                <span class="badge bg-success">Active</span>
                            @elseif ($subscription->status === 'active' && $subscription->end_date->isPast())
                                <span class="badge bg-warning">Expired</span>
                            @elseif ($subscription->status === 'cancelled')
                                <span class="badge bg-danger">Cancelled</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($subscription->status) }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <strong>Subscription Code:</strong>
                            </div>
                            <div class="col-sm-8">
                                <span class="badge bg-label-primary"
                                    style="font-size: 0.9rem;">{{ $subscription->subscription_code }}</span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <strong>User:</strong>
                            </div>
                            <div class="col-sm-8">
                                <div class="d-flex flex-column">
                                    <span>{{ $subscription->user->name }}</span>
                                    <small class="text-muted">{{ $subscription->user->email }}</small>
                                    @if ($subscription->user->phone)
                                        <small class="text-muted">{{ $subscription->user->phone }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <strong>Plan:</strong>
                            </div>
                            <div class="col-sm-8">
                                <span class="badge bg-label-info">{{ $subscription->plan->name }}</span>
                                <div class="mt-1">
                                    <small class="text-muted">{{ $subscription->plan->duration_days }} days</small>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <strong>Start Date:</strong>
                            </div>
                            <div class="col-sm-8">
                                {{ $subscription->start_date->format('d M Y, H:i') }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <strong>End Date:</strong>
                            </div>
                            <div class="col-sm-8">
                                {{ $subscription->end_date->format('d M Y, H:i') }}
                                @if ($subscription->end_date->isFuture())
                                    <small class="text-success d-block">
                                        ({{ $subscription->end_date->diffForHumans() }})
                                    </small>
                                @else
                                    <small class="text-danger d-block">
                                        (Expired {{ $subscription->end_date->diffForHumans() }})
                                    </small>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <strong>Total Amount:</strong>
                            </div>
                            <div class="col-sm-8">
                                <strong class="text-primary">Rp
                                    {{ number_format($subscription->total_amount, 0, ',', '.') }}</strong>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <strong>Auto Renew:</strong>
                            </div>
                            <div class="col-sm-8">
                                @if ($subscription->auto_renew)
                                    <span class="badge bg-success">Yes</span>
                                @else
                                    <span class="badge bg-secondary">No</span>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <strong>Created At:</strong>
                            </div>
                            <div class="col-sm-8">
                                {{ $subscription->created_at->format('d M Y, H:i') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            @if ($subscription->status === 'active')
                                <a href="{{ route('admin.manual-subscriptions.extend', $subscription->id) }}"
                                    class="btn btn-primary">
                                    <i class="bx bx-time me-1"></i> Extend Subscription
                                </a>

                                <form action="{{ route('admin.manual-subscriptions.cancel', $subscription->id) }}"
                                    method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-warning w-100"
                                        onclick="return confirm('Are you sure you want to cancel this subscription?')">
                                        <i class="bx bx-x-circle me-1"></i> Cancel Subscription
                                    </button>
                                </form>
                            @endif

                            <a href="{{ route('admin.manual-subscriptions.index') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-arrow-back me-1"></i> Back to List
                            </a>

                            <hr>

                            <form action="{{ route('admin.manual-subscriptions.destroy', $subscription->id) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100"
                                    onclick="return confirm('Are you sure you want to delete this subscription? This action cannot be undone.')">
                                    <i class="bx bx-trash me-1"></i> Delete Subscription
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                @if ($subscription->plan->features)
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Plan Features</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                @foreach ($subscription->plan->features as $feature)
                                    <li class="mb-2">
                                        <i class="bx bx-check text-success me-2"></i>{{ $feature }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
