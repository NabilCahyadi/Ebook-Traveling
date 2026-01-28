@extends('layouts.admin')

@section('title', __('admin.contact_info.detail'))

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.contact-info.index') }}">{{ __('admin.menu.contact_info') }}</a></li>
            <li class="breadcrumb-item active">{{ $contactInfo->title ?? __('admin.common.detail') }}</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">{{ $contactInfo->title ?? __('admin.contact_info.detail') }}</h4>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.contact-info.edit', $contactInfo->id) }}" class="btn btn-primary">
                <i class="ti ti-pencil me-1"></i> {{ __('admin.actions.edit') }}
            </a>
            <a href="{{ route('admin.contact-info.index') }}" class="btn btn-outline-secondary">
                <i class="ti ti-arrow-left me-1"></i> {{ __('admin.actions.back') }}
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('admin.common.information') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label class="form-label text-muted small">{{ __('admin.contact_info.type') }}</label>
                            <p class="mb-0">
                                @php
                                    $typeColors = [
                                        'email' => 'primary',
                                        'phone' => 'success',
                                        'whatsapp' => 'success',
                                        'address' => 'info',
                                        'social' => 'warning'
                                    ];
                                    $color = $typeColors[$contactInfo->type] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $color }}">{{ ucfirst($contactInfo->type) }}</span>
                            </p>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label text-muted small">{{ __('admin.common.status') }}</label>
                            <p class="mb-0">
                                @if($contactInfo->is_active)
                                    <span class="badge bg-success">{{ __('admin.common.active') }}</span>
                                @else
                                    <span class="badge bg-danger">{{ __('admin.common.inactive') }}</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label text-muted small">{{ __('admin.contact_info.title') }}</label>
                            <p class="mb-0 fw-medium">{{ $contactInfo->title }}</p>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label text-muted small">{{ __('admin.contact_info.value') }}</label>
                            <p class="mb-0 fw-medium">
                                @if($contactInfo->type === 'email')
                                    <a href="mailto:{{ $contactInfo->value }}">{{ $contactInfo->value }}</a>
                                @elseif($contactInfo->type === 'phone' || $contactInfo->type === 'whatsapp')
                                    <a href="tel:{{ $contactInfo->value }}">{{ $contactInfo->value }}</a>
                                @elseif($contactInfo->type === 'social' && $contactInfo->link)
                                    <a href="{{ $contactInfo->link }}" target="_blank">{{ $contactInfo->value }}</a>
                                @else
                                    {{ $contactInfo->value }}
                                @endif
                            </p>
                        </div>
                        @if($contactInfo->link)
                        <div class="col-12 mb-3">
                            <label class="form-label text-muted small">{{ __('admin.contact_info.link') }}</label>
                            <p class="mb-0">
                                <a href="{{ $contactInfo->link }}" target="_blank" class="text-break">
                                    {{ $contactInfo->link }}
                                    <i class="ti ti-external-link ms-1"></i>
                                </a>
                            </p>
                        </div>
                        @endif
                        @if($contactInfo->icon)
                        <div class="col-sm-6 mb-3">
                            <label class="form-label text-muted small">{{ __('admin.contact_info.icon') }}</label>
                            <p class="mb-0 fw-medium">
                                <i class="{{ $contactInfo->icon }} me-2"></i>
                                <code>{{ $contactInfo->icon }}</code>
                            </p>
                        </div>
                        @endif
                        <div class="col-sm-6 mb-3">
                            <label class="form-label text-muted small">{{ __('admin.common.order') }}</label>
                            <p class="mb-0 fw-medium">{{ $contactInfo->order ?? 0 }}</p>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label text-muted small">{{ __('admin.common.date_created') }}</label>
                            <p class="mb-0 fw-medium">{{ $contactInfo->created_at->format('d F Y H:i') }}</p>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label text-muted small">{{ __('admin.common.last_updated') }}</label>
                            <p class="mb-0 fw-medium">{{ $contactInfo->updated_at->format('d F Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('admin.common.preview') }}</h5>
                </div>
                <div class="card-body text-center">
                    @if($contactInfo->icon)
                        <div class="mb-3">
                            <i class="{{ $contactInfo->icon }} display-4"></i>
                        </div>
                    @endif
                    <h6 class="mb-1">{{ $contactInfo->title }}</h6>
                    <p class="text-muted mb-0">{{ $contactInfo->value }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
