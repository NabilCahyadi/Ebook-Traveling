@extends('layouts.admin')

@section('title', __('admin.subscription_plans.details'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">{{ __('admin.menu.admin') }} / {{ __('admin.subscription_plans.title') }} /</span> {{ __('admin.common.details') }}
            </h4>
            <div>
                <a href="{{ route('admin.subscription-plans.edit', $plan->id) }}" class="btn btn-primary me-2">
                    <i class="bx bx-edit me-1"></i> {{ __('admin.actions.edit') }}
                </a>
                <a href="{{ route('admin.subscription-plans.index') }}" class="btn btn-secondary">
                    <i class="bx bx-arrow-back me-1"></i> {{ __('admin.actions.back') }}
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ __('admin.subscription_plans.plan_info') }}</h5>
                        <span class="badge bg-{{ $plan->is_active ? 'success' : 'secondary' }}">
                            {{ $plan->is_active ? __('admin.status.active') : __('admin.status.inactive') }}
                        </span>
                    </div>
                    <div class="card-body">
                        @if ($plan->cover_image)
                            <div class="mb-3">
                                <div class="border rounded p-2" style="max-width: 600px;">
                                    <div class="position-relative" style="aspect-ratio: 3/1; overflow: hidden; border-radius: 0.375rem; background-color: #f5f5f5;">
                                        <img src="{{ asset('storage/' . $plan->cover_image) }}" alt="{{ $plan->name }} Banner" 
                                            style="width: 100%; height: 100%; object-fit: cover; display: block;">
                                    </div>
                                </div>
                            </div>
                            <hr>
                        @endif

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <h6 class="text-muted mb-1">{{ __('admin.subscription_plans.plan_name') }}</h6>
                            </div>
                            <div class="col-sm-8">
                                <h5 class="mb-0">{{ $plan->name }}</h5>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <h6 class="text-muted mb-1">{{ __('admin.subscription_plans.slug') }}</h6>
                            </div>
                            <div class="col-sm-8">
                                <code>{{ $plan->slug }}</code>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <h6 class="text-muted mb-1">{{ __('admin.form.description') }}</h6>
                            </div>
                            <div class="col-sm-8">
                                <p class="mb-0">{{ $plan->description ?? __('admin.subscription_plans.no_description') }}</p>
                            </div>
                        </div>

                        <hr>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <h6 class="text-muted mb-1">{{ __('admin.subscription_plans.price') }}</h6>
                            </div>
                            <div class="col-sm-8">
                                <h4 class="text-primary mb-0">Rp {{ number_format($plan->price, 0, ',', '.') }}</h4>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <h6 class="text-muted mb-1">{{ __('admin.subscription_plans.duration') }}</h6>
                            </div>
                            <div class="col-sm-8">
                                <span class="badge bg-label-info">{{ $plan->duration_days }} {{ __('admin.receipt.days') }}</span>
                                @if ($plan->duration_days == 30)
                                    <span class="text-muted">(1 {{ __('admin.receipt.month') }})</span>
                                @elseif($plan->duration_days == 180)
                                    <span class="text-muted">(6 {{ __('admin.receipt.months') }})</span>
                                @elseif($plan->duration_days == 365)
                                    <span class="text-muted">(1 {{ __('admin.receipt.year') }})</span>
                                @endif
                            </div>
                        </div>

                        <hr>

                        {{-- Features section hidden as requested --}}
                        @if(false)
                        <div class="row">
                            <div class="col-sm-4">
                                <h6 class="text-muted mb-1">{{ __('admin.subscription_plans.features') }}</h6>
                            </div>
                            <div class="col-sm-8">
                                @if ($plan->features && count($plan->features) > 0)
                                    <ul class="list-unstyled mb-0">
                                        @foreach ($plan->features as $feature)
                                            <li class="mb-2">
                                                <i class="bx bx-check-circle text-success me-2"></i>
                                                {{ $feature }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-muted mb-0">{{ __('admin.subscription_plans.no_features') }}</p>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">{{ __('admin.subscription_plans.statistics') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="badge bg-label-primary rounded p-2 me-3">
                                <i class="bx bx-user fs-4"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">{{ __('admin.subscription_plans.active_subscribers') }}</small>
                                <h5 class="mb-0">{{ $plan->subscriptions()->where('status', 'active')->count() }}</h5>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-3">
                            <div class="badge bg-label-info rounded p-2 me-3">
                                <i class="bx bx-time fs-4"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">{{ __('admin.subscription_plans.total_subscriptions') }}</small>
                                <h5 class="mb-0">{{ $plan->subscriptions()->count() }}</h5>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <div class="badge bg-label-success rounded p-2 me-3">
                                <i class="bx bx-money fs-4"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">{{ __('admin.subscription_plans.estimated_revenue') }}</small>
                                <h5 class="mb-0">Rp
                                    {{ number_format($plan->subscriptions()->count() * $plan->price, 0, ',', '.') }}</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{ __('admin.subscription_plans.additional_info') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">{{ __('admin.common.created_at') }}</small>
                            <p class="mb-0">{{ $plan->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <div>
                            <small class="text-muted d-block mb-1">{{ __('admin.common.updated_at') }}</small>
                            <p class="mb-0">{{ $plan->updated_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
