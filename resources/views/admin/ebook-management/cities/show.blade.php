@extends('layouts.admin')

@section('title', __('admin.cities.detail'))

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.cities.index') }}">{{ __('admin.menu.cities') }}</a></li>
            <li class="breadcrumb-item active">{{ $city->name }}</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">{{ $city->name }}</h4>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.cities.edit', $city->id) }}" class="btn btn-primary">
                <i class="ti ti-pencil me-1"></i> {{ __('admin.actions.edit') }}
            </a>
            <a href="{{ route('admin.cities.index') }}" class="btn btn-outline-secondary">
                <i class="ti ti-arrow-left me-1"></i> {{ __('admin.actions.back') }}
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    @if($city->image)
                        <img src="{{ $city->image_url }}" alt="{{ $city->name }}" 
                            class="rounded mb-3" style="max-width: 200px; max-height: 200px; object-fit: cover;">
                    @else
                        <div class="bg-light rounded mb-3 d-flex align-items-center justify-content-center mx-auto" 
                            style="width: 200px; height: 200px;">
                            <i class="ti ti-map-pin fs-1 text-muted"></i>
                        </div>
                    @endif
                    <h5 class="mb-1">{{ $city->name }}</h5>
                    @if($city->province)
                        <p class="text-muted mb-0">{{ $city->province }}</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('admin.common.information') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label class="form-label text-muted small">ID</label>
                            <p class="mb-0 fw-medium">{{ $city->id }}</p>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label text-muted small">Slug</label>
                            <p class="mb-0 fw-medium">{{ $city->slug }}</p>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label text-muted small">{{ __('admin.cities.province') }}</label>
                            <p class="mb-0 fw-medium">{{ $city->province ?? '-' }}</p>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label text-muted small">{{ __('admin.cities.ebooks_count') }}</label>
                            <p class="mb-0">
                                <span class="badge bg-primary">{{ $city->ebooks_count ?? 0 }} {{ __('admin.common.ebooks') }}</span>
                            </p>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label text-muted small">{{ __('admin.common.date_created') }}</label>
                            <p class="mb-0 fw-medium">{{ $city->created_at->format('d F Y H:i') }}</p>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label text-muted small">{{ __('admin.common.last_updated') }}</label>
                            <p class="mb-0 fw-medium">{{ $city->updated_at->format('d F Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
