@extends('layouts.admin')

@section('title', __('admin.sub_list.title'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">{{ __('admin.menu.subscription') }} /</span> {{ __('admin.sub_list.title') }}
            </h4>
            <a href="{{ route('admin.manual-subscriptions.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i> {{ __('admin.sub_list.create_manual') }}
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
                        <h5 class="mb-0">{{ __('admin.sub_list.all_subscriptions') }}</h5>
                    </div>
                    <div class="col-md-6">
                        <form method="GET" action="{{ route('admin.subscription-management.list') }}">
                            <div class="input-group">
                                <span class="input-group-text"><i class="ti ti-search"></i></span>
                                <input type="text" class="form-control" name="search"
                                    placeholder="{{ __('admin.sub_list.search_placeholder') }}" value="{{ $search ?? '' }}">
                                <button type="submit" class="btn btn-primary">{{ __('admin.common.search') }}</button>
                                @if ($search)
                                    <a href="{{ route('admin.subscription-management.list') }}"
                                        class="btn btn-outline-secondary">{{ __('admin.common.clear') }}</a>
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
                            <th>{{ __('admin.sub_list.subscription_code') }}</th>
                            <th>{{ __('admin.common.user') }}</th>
                            <th>{{ __('admin.sub_list.plan') }}</th>
                            <th>{{ __('admin.subscriptions.start_date') }}</th>
                            <th>{{ __('admin.subscriptions.end_date') }}</th>
                            <th>{{ __('admin.common.status') }}</th>
                            <th>{{ __('admin.sub_list.amount') }}</th>
                            <th>{{ __('admin.common.actions') }}</th>
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
                                            <span class="badge bg-success">{{ __('admin.status.active') }}</span>
                                        @else
                                            <span class="badge bg-warning">{{ __('admin.status.expired') }}</span>
                                        @endif
                                    @elseif ($subscription->status === 'cancelled')
                                        <span class="badge bg-danger">{{ __('admin.status.cancelled') }}</span>
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
                                                <i class="ti ti-eye me-2"></i> {{ __('admin.actions.view_details') }}
                                            </a>
                                            @if ($subscription->status === 'active')
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.manual-subscriptions.extend', $subscription->id) }}">
                                                    <i class="ti ti-clock me-2"></i> {{ __('admin.manual_subscription.extend') }}
                                                </a>
                                                <form
                                                    action="{{ route('admin.manual-subscriptions.cancel', $subscription->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item text-warning"
                                                        onclick="return confirm('{{ __('admin.manual_subscription.confirm_cancel') }}')">
                                                        <i class="ti ti-x me-2"></i> {{ __('admin.manual_subscription.cancel_subscription') }}
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
                                                    onclick="return confirm('{{ __('admin.manual_subscription.confirm_delete') }}')">
                                                    <i class="ti ti-trash me-2"></i> {{ __('admin.actions.delete') }}
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
                                        <p>{{ __('admin.manual_subscription.no_subscriptions') }}</p>
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
