@extends('layouts.admin')

@section('title', __('admin.subscription_plans.title'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">{{ __('admin.menu.dashboard') }} /</span> {{ __('admin.subscription_plans.title') }}
            </h4>
            <a href="{{ route('admin.subscription-plans.create') }}" class="btn btn-primary">
                <i class="bx bx-plus me-1"></i> {{ __('admin.subscription_plans.add_plan') }}
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
                <h5 class="mb-0">{{ __('admin.subscription_plans.title') }}</h5>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>{{ __('admin.subscription_plans.plan_name') }}</th>
                            <th>{{ __('admin.subscription_plans.duration_days') }}</th>
                            <th>{{ __('admin.subscription_plans.price') }}</th>
                            <th>{{ __('admin.ebooks.status') }}</th>
                            <th>{{ __('admin.subscription_plans.subscribers') }}</th>
                            <th>{{ __('admin.users.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($plans as $plan)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        @if ($plan->cover_image)
                                            <div style="width: 120px; aspect-ratio: 3/1; overflow: hidden; border-radius: 0.375rem; background-color: #f5f5f5; flex-shrink: 0;">
                                                <img src="{{ asset('storage/' . $plan->cover_image) }}" alt="Banner" 
                                                    style="width: 100%; height: 100%; object-fit: cover; display: block;">
                                            </div>
                                        @endif
                                        <div>
                                            <strong class="d-block">{{ $plan->name }}</strong>
                                            @if ($plan->description)
                                                <small class="text-muted">{{ Str::limit($plan->description, 30) }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-label-info">
                                        @if ($plan->duration_days == 30)
                                            1 {{ __('admin.receipt.month') }}
                                        @elseif($plan->duration_days == 180)
                                            6 {{ __('admin.receipt.months') }}
                                        @elseif($plan->duration_days == 365)
                                            1 {{ __('admin.receipt.year') }}
                                        @else
                                            {{ $plan->duration_days }} {{ __('admin.receipt.days') }}
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <strong class="text-primary">Rp {{ number_format($plan->price, 0, ',', '.') }}</strong>
                                </td>
                                <td>
                                    @if ($plan->is_active)
                                        <span class="badge bg-success">{{ __('admin.status.active') }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ __('admin.status.inactive') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="text-muted">{{ $plan->subscriptions->count() }}</span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button"
                                            class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item"
                                                href="{{ route('admin.subscription-plans.show', $plan->id) }}">
                                                <i class="ti ti-eye me-2"></i> {{ __('admin.actions.view_details') }}
                                            </a>
                                            <a class="dropdown-item"
                                                href="{{ route('admin.subscription-plans.edit', $plan->id) }}">
                                                <i class="ti ti-pencil me-2"></i> {{ __('admin.actions.edit') }}
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('admin.subscription-plans.destroy', $plan->id) }}"
                                                method="POST" style="display: none;" id="delete-plan-{{ $plan->id }}">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <a class="dropdown-item text-danger" href="javascript:void(0);"
                                                onclick="if(confirm('Are you sure you want to delete this plan?')) document.getElementById('delete-plan-{{ $plan->id }}').submit();">
                                                <i class="ti ti-trash me-2"></i> {{ __('admin.actions.delete') }}
                                            </a>
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
                                        class="btn btn-sm btn-primary">{{ __('admin.subscription_plans.add_plan') }}</a>
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
