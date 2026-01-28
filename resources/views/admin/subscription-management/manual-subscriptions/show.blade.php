@extends('layouts.admin')

@section('title', __('admin.manual_subscription.subscription_info'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">{{ __('admin.menu.subscription') }} / {{ __('admin.menu.manual_subscriptions') }} /</span> {{ __('admin.common.details') }}
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
                        <h5 class="mb-0">{{ __('admin.manual_subscription.subscription_info') }}</h5>
                        <div>
                            @if ($subscription->status === 'active' && $subscription->end_date->isFuture())
                                <span class="badge bg-success">{{ __('admin.status.active') }}</span>
                            @elseif ($subscription->status === 'active' && $subscription->end_date->isPast())
                                <span class="badge bg-warning">{{ __('admin.status.expired') }}</span>
                            @elseif ($subscription->status === 'cancelled')
                                <span class="badge bg-danger">{{ __('admin.status.cancelled') }}</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($subscription->status) }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <strong>{{ __('admin.manual_subscription.code') }}:</strong>
                            </div>
                            <div class="col-sm-8">
                                <span class="badge bg-label-primary"
                                    style="font-size: 0.9rem;">{{ $subscription->subscription_code }}</span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <strong>{{ __('admin.common.user') }}:</strong>
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
                                <strong>{{ __('admin.manual_subscription.plan') }}:</strong>
                            </div>
                            <div class="col-sm-8">
                                <span class="badge bg-label-info">{{ $subscription->plan->name }}</span>
                                <div class="mt-1">
                                    <small class="text-muted">{{ $subscription->plan->duration_days }} {{ __('admin.receipt.days') }}</small>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <strong>{{ __('admin.manual_subscription.start_date') }}:</strong>
                            </div>
                            <div class="col-sm-8">
                                {{ $subscription->start_date->format('d M Y, H:i') }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <strong>{{ __('admin.manual_subscription.end_date') }}:</strong>
                            </div>
                            <div class="col-sm-8">
                                {{ $subscription->end_date->format('d M Y, H:i') }}
                                @if ($subscription->end_date->isFuture())
                                    <small class="text-success d-block">
                                        ({{ $subscription->end_date->diffForHumans() }})
                                    </small>
                                @else
                                    <small class="text-danger d-block">
                                        ({{ __('admin.status.expired') }} {{ $subscription->end_date->diffForHumans() }})
                                    </small>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <strong>{{ __('admin.manual_subscription.total_amount') }}:</strong>
                            </div>
                            <div class="col-sm-8">
                                <strong class="text-primary">Rp
                                    {{ number_format($subscription->total_amount, 0, ',', '.') }}</strong>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <strong>{{ __('admin.subscription_history.auto_renew') }}:</strong>
                            </div>
                            <div class="col-sm-8">
                                @if ($subscription->auto_renew)
                                    <span class="badge bg-success">{{ __('admin.common.yes') }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ __('admin.common.no') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <strong>{{ __('admin.common.created_at') }}:</strong>
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
                        <h5 class="mb-0">{{ __('admin.common.actions') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            @if ($subscription->status === 'active')
                                <a href="{{ route('admin.manual-subscriptions.extend', $subscription->id) }}"
                                    class="btn btn-primary">
                                    <i class="bx bx-time me-1"></i> {{ __('admin.manual_subscription.extend') }}</a>
                                </a>

                                <form action="{{ route('admin.manual-subscriptions.cancel', $subscription->id) }}"
                                    method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-warning w-100"
                                        onclick="return confirm('{{ __('admin.manual_subscription.confirm_cancel') }}')">
                                        <i class="bx bx-x-circle me-1"></i> {{ __('admin.manual_subscription.cancel_subscription') }}
                                    </button>
                                </form>
                            @endif

                            <a href="{{ route('admin.manual-subscriptions.index') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-arrow-back me-1"></i> {{ __('admin.manual_subscription.back_to_list') }}
                            </a>
                            <hr>

                            <form action="{{ route('admin.manual-subscriptions.destroy', $subscription->id) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100"
                                    onclick="return confirm('{{ __('admin.manual_subscription.confirm_delete') }}')">
                                    <i class="bx bx-trash me-1"></i> {{ __('admin.actions.delete') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                @if ($subscription->plan->features)
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">{{ __('admin.subscription_plans.features') }}</h5>
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
