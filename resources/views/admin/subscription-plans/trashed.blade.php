@extends('layouts.admin')

@section('title', __('admin.subscription_plans.trashed_title'))

@push('styles')
<style>
    /* Fix: Sidebar icon tetap terlihat saat menu active tapi dropdown ditutup */
    .menu-inner > .menu-item.active:not(.open) > .menu-link.menu-toggle .menu-icon {
        color: #ffffff !important;
    }
    
    /* Fix: Pastikan background juga kontras */
    .menu-inner > .menu-item.active:not(.open) > .menu-link.menu-toggle {
        background-color: #ff4c61 !important;
        color: #ffffff !important;
    }
    
    .menu-inner > .menu-item.active:not(.open) > .menu-link.menu-toggle div {
        color: #ffffff !important;
    }
</style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">{{ __('admin.menu.dashboard') }} / {{ __('admin.subscription_plans.title') }} /</span> {{ __('admin.subscription_plans.trashed') }}
            </h4>
            <a href="{{ route('admin.subscription-plans.index') }}" class="btn btn-secondary">
                <i class="bx bx-arrow-back me-1"></i> {{ __('admin.actions.back_to_list') }}
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

        <div class="alert alert-warning" role="alert">
            <div class="d-flex align-items-center">
                <i class="ti ti-alert-triangle me-2" style="font-size: 24px;"></i>
                <div>
                    <strong>{{ __('admin.subscription_plans.trashed_notice') }}</strong>
                    <p class="mb-0 small">{{ __('admin.subscription_plans.trashed_description') }}</p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="ti ti-trash me-2"></i>{{ __('admin.subscription_plans.trashed_plans') }}
                    </h5>
                    <span class="badge bg-label-danger">{{ $plans->total() }} {{ __('admin.subscription_plans.items_in_trash') }}</span>
                </div>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>{{ __('admin.subscription_plans.plan_name') }}</th>
                            <th>{{ __('admin.subscription_plans.duration_days') }}</th>
                            <th>{{ __('admin.subscription_plans.price') }}</th>
                            <th>{{ __('admin.subscription_plans.deleted_at') }}</th>
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
                                            <div style="width: 120px; aspect-ratio: 3/1; overflow: hidden; border-radius: 0.375rem; background-color: #f5f5f5; flex-shrink: 0; opacity: 0.6;">
                                                <img src="{{ asset('storage/' . $plan->cover_image) }}" alt="Banner" 
                                                    style="width: 100%; height: 100%; object-fit: cover; display: block; filter: grayscale(50%);">
                                            </div>
                                        @endif
                                        <div>
                                            <strong class="d-block text-muted">{{ $plan->name }}</strong>
                                            @if ($plan->description)
                                                <small class="text-muted">{{ Str::limit($plan->description, 30) }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-label-secondary">
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
                                    <span class="text-muted">Rp {{ number_format($plan->price, 0, ',', '.') }}</span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <i class="ti ti-calendar me-1"></i>
                                        {{ $plan->deleted_at->format('d M Y, H:i') }}
                                        <br>
                                        <span class="text-muted" style="font-size: 0.75rem;">
                                            ({{ $plan->deleted_at->diffForHumans() }})
                                        </span>
                                    </small>
                                </td>
                                <td>
                                    @php
                                        $activeSubscriptions = \App\Models\Subscription::withTrashed()
                                            ->where('subscription_plan_id', $plan->id)
                                            ->count();
                                    @endphp
                                    <span class="text-muted">{{ $activeSubscriptions }}</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <!-- Restore Button -->
                                        <form action="{{ route('admin.subscription-plans.restore', $plan->id) }}"
                                            method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-success" 
                                                onclick="return confirm('{{ __('admin.subscription_plans.restore_confirm') }}')">
                                                <i class="ti ti-reload me-1"></i> {{ __('admin.actions.restore') }}
                                            </button>
                                        </form>

                                        <!-- Permanent Delete Button -->
                                        <form action="{{ route('admin.subscription-plans.force-delete', $plan->id) }}"
                                            method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('{{ __('admin.subscription_plans.permanent_delete_confirm') }}\n\n{{ __('admin.subscription_plans.permanent_delete_warning') }}')">
                                                <i class="ti ti-trash-x me-1"></i> {{ __('admin.actions.delete_permanent') }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="ti ti-trash" style="font-size: 48px; color: #ddd;"></i>
                                    <p class="mt-2 text-muted">{{ __('admin.subscription_plans.no_trashed_plans') }}</p>
                                    <a href="{{ route('admin.subscription-plans.index') }}"
                                        class="btn btn-sm btn-secondary">
                                        <i class="bx bx-arrow-back me-1"></i> {{ __('admin.actions.back_to_list') }}
                                    </a>
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
