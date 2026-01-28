@extends('layouts.admin')

@section('title', 'Promo Details - ' . $promo->name)

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin.menu.dashboard') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.promos.index') }}">{{ __('admin.promos.title') }}</a></li>
                        <li class="breadcrumb-item active">{{ $promo->name }}</li>
                    </ol>
                </nav>
                <h4 class="mb-0">{{ __('admin.promos.promo_details') }}</h4>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.promos.edit', $promo->id) }}" class="btn btn-primary">
                    <i class="ti ti-edit me-1"></i> {{ __('admin.promos.edit_promo') }}
                </a>
                <a href="{{ route('admin.promos.index') }}" class="btn btn-label-secondary">
                    <i class="ti ti-arrow-left me-1"></i> {{ __('admin.promos.back_to_list') }}
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Left Column - Main Information -->
            <div class="col-lg-8">
                <!-- Basic Information Card -->
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ __('admin.promos.basic_information') }}</h5>
                        <!-- <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="statusSwitch" {{ $promo->is_active ? 'checked' : '' }} disabled>
                            <label class="form-check-label" for="statusSwitch">
                                @if($promo->is_active)
                                    <span class="badge bg-label-success">{{ __('admin.status.active') }}</span>
                                @else
                                    <span class="badge bg-label-secondary">{{ __('admin.status.inactive') }}</span>
                                @endif
                            </label>
                        </div> -->
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">{{ __('admin.promos.promo_name') }}</label>
                            </div>
                            <div class="col-md-9">
                                <p class="mb-0">{{ $promo->name }}</p>
                            </div>
                        </div>

                        @if($promo->description)
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Description</label>
                            </div>
                            <div class="col-md-9">
                                <p class="mb-0">{{ $promo->description }}</p>
                            </div>
                        </div>
                        @endif

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Promo Code</label>
                            </div>
                            <div class="col-md-9">
                                @if($promo->code)
                                    <span class="badge bg-label-secondary fs-6">{{ $promo->code }}</span>
                                    <button class="btn btn-sm btn-icon btn-label-secondary ms-2" onclick="copyToClipboard('{{ $promo->code }}')" title="Copy code">
                                        <i class="ti ti-copy"></i>
                                    </button>
                                @else
                                    <span class="text-muted">Auto-apply (No code required)</span>
                                @endif
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Promo Type</label>
                            </div>
                            <div class="col-md-9">
                                @if($promo->type === 'percentage')
                                    <span class="badge bg-label-info"><i class="ti ti-percentage me-1"></i>Percentage Discount</span>
                                @elseif($promo->type === 'fixed_amount')
                                    <span class="badge bg-label-success"><i class="ti ti-currency-dollar me-1"></i>Fixed Amount</span>
                                @elseif($promo->type === 'free_trial')
                                    <span class="badge bg-label-warning"><i class="ti ti-gift me-1"></i>Free Trial</span>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Discount Value</label>
                            </div>
                            <div class="col-md-9">
                                <h4 class="mb-0">
                                    @if($promo->type === 'percentage')
                                        {{ $promo->value }}%
                                    @elseif($promo->type === 'fixed_amount')
                                        ${{ number_format($promo->value, 2) }}
                                    @else
                                        {{ $promo->value }} days
                                    @endif
                                </h4>
                            </div>
                        </div>

                        @if($promo->minimum_purchase)
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Minimum Purchase</label>
                            </div>
                            <div class="col-md-9">
                                <p class="mb-0">${{ number_format($promo->minimum_purchase, 2) }}</p>
                            </div>
                        </div>
                        @endif

                        @if($promo->maximum_discount)
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Maximum Discount</label>
                            </div>
                            <div class="col-md-9">
                                <p class="mb-0">${{ number_format($promo->maximum_discount, 2) }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Date & Usage Information Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Date & Usage Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted small">START DATE</label>
                                <div class="d-flex align-items-center">
                                    <i class="ti ti-calendar-event me-2 text-primary"></i>
                                    <span>{{ $promo->start_date->format('F d, Y') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted small">END DATE</label>
                                <div class="d-flex align-items-center">
                                    <i class="ti ti-calendar-x me-2 text-danger"></i>
                                    <span>{{ $promo->end_date->format('F d, Y') }}</span>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-muted small">USAGE LIMIT</label>
                                <h4 class="mb-0">{{ $promo->max_usage ?? '∞ Unlimited' }}</h4>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-muted small">CURRENT USAGE</label>
                                <h4 class="mb-0">{{ $promo->current_usage }}</h4>
                            </div>
                        </div>

                        @if($promo->max_usage)
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted small">USAGE PROGRESS</label>
                            <div class="progress" style="height: 20px;">
                                @php
                                    $percentage = min(100, ($promo->current_usage / $promo->max_usage) * 100);
                                @endphp
                                <div class="progress-bar {{ $percentage >= 100 ? 'bg-danger' : ($percentage >= 75 ? 'bg-warning' : 'bg-success') }}"
                                    role="progressbar" style="width: {{ $percentage }}%"
                                    aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                                    {{ number_format($percentage, 1) }}%
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($promo->max_usage_per_user)
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted small">MAX USAGE PER USER</label>
                                <p class="mb-0">{{ $promo->max_usage_per_user }} time(s)</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Applicable Plans Card -->
                @if($promo->subscriptionPlans && $promo->subscriptionPlans->count() > 0)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Applicable Subscription Plans</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            @foreach($promo->subscriptionPlans as $plan)
                            <div class="col-md-6">
                                <div class="border rounded p-3">
                                    <h6 class="mb-1">{{ $plan->name }}</h6>
                                    <p class="text-muted small mb-0">{{ $plan->duration_days }} days - ${{ number_format($plan->price, 2) }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column - Statistics & Actions -->
            <div class="col-lg-4">
                <!-- Quick Stats Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Quick Statistics</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <p class="text-muted mb-1 small">Days Remaining</p>
                                <h4 class="mb-0">
                                    @php
                                        $daysRemaining = (int) now()->diffInDays($promo->end_date, false);
                                    @endphp
                                    @if($daysRemaining > 0)
                                        {{ number_format($daysRemaining, 0) }} days
                                    @elseif($daysRemaining === 0)
                                        <span class="text-warning">Ends today</span>
                                    @else
                                        <span class="text-danger">Expired</span>
                                    @endif
                                </h4>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded {{ $daysRemaining > 7 ? 'bg-label-success' : ($daysRemaining > 0 ? 'bg-label-warning' : 'bg-label-danger') }}">
                                    <i class="ti ti-clock ti-lg"></i>
                                </span>
                            </div>
                        </div>

                        @if($promo->max_usage)
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <p class="text-muted mb-1 small">Remaining Uses</p>
                                <h4 class="mb-0">{{ max(0, $promo->max_usage - $promo->current_usage) }}</h4>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-info">
                                    <i class="ti ti-ticket ti-lg"></i>
                                </span>
                            </div>
                        </div>
                        @endif

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 small">Promo Status</p>
                                <h6 class="mb-0">
                                    @if($promo->is_active && $daysRemaining >= 0)
                                        <span class="badge bg-success">Active</span>
                                    @elseif(!$promo->is_active)
                                        <span class="badge bg-secondary">Inactive</span>
                                    @else
                                        <span class="badge bg-danger">Expired</span>
                                    @endif
                                </h6>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded {{ $promo->is_active ? 'bg-label-success' : 'bg-label-secondary' }}">
                                    <i class="ti ti-{{ $promo->is_active ? 'check' : 'x' }} ti-lg"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Metadata Card -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Metadata</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Created At</small>
                            <span>{{ $promo->created_at->format('M d, Y H:i') }}</span>
                        </div>
                        <div>
                            <small class="text-muted d-block mb-1">Last Updated</small>
                            <span>{{ $promo->updated_at->format('M d, Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                toastr.success('Promo code copied to clipboard!');
            }, function() {
                toastr.error('Failed to copy code');
            });
        }
    </script>
    @endpush
@endsection
