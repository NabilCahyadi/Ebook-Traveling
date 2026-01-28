@extends('layouts.admin')

@section('title', __('admin.categories.detail'))

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">{{ __('admin.menu.categories') }}</a></li>
            <li class="breadcrumb-item active">{{ $category->name }}</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">{{ $category->name }}</h4>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-primary">
                <i class="ti ti-pencil me-1"></i> {{ __('admin.actions.edit') }}
            </a>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                <i class="ti ti-arrow-left me-1"></i> {{ __('admin.actions.back') }}
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <img src="{{ $category->image_url }}" alt="{{ $category->name }}" 
                        class="rounded mb-3" style="max-width: 200px; max-height: 200px; object-fit: cover;">
                    <h5 class="mb-1">{{ $category->name }}</h5>
                    <p class="text-muted mb-0">{{ $category->slug }}</p>
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
                            <p class="mb-0 fw-medium">{{ $category->id }}</p>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label text-muted small">Slug</label>
                            <p class="mb-0 fw-medium">{{ $category->slug }}</p>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label text-muted small">{{ __('admin.categories.ebooks_count') }}</label>
                            <p class="mb-0">
                                <span class="badge bg-primary">{{ $category->ebooks_count ?? 0 }} {{ __('admin.common.ebooks') }}</span>
                            </p>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label text-muted small">{{ __('admin.common.date_created') }}</label>
                            <p class="mb-0 fw-medium">{{ $category->created_at->format('d F Y H:i') }}</p>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label text-muted small">{{ __('admin.common.last_updated') }}</label>
                            <p class="mb-0 fw-medium">{{ $category->updated_at->format('d F Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
