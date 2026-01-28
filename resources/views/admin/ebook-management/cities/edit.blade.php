@extends('layouts.admin')

@section('title', __('admin.cities.edit'))

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.cities.index') }}">{{ __('admin.menu.cities') }}</a></li>
            <li class="breadcrumb-item active">{{ __('admin.actions.edit') }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('admin.actions.edit') }} - {{ $city->name }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.cities.update', $city->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('admin.form.name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                id="name" name="name" value="{{ old('name', $city->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="province" class="form-label">{{ __('admin.cities.province') }}</label>
                            <input type="text" class="form-control @error('province') is-invalid @enderror" 
                                id="province" name="province" value="{{ old('province', $city->province) }}">
                            @error('province')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if($city->image)
                        <div class="mb-3">
                            <label class="form-label">{{ __('admin.form.current_image') }}</label>
                            <div class="mb-2">
                                <img src="{{ $city->image_url }}" alt="{{ $city->name }}" 
                                    class="rounded" style="max-width: 150px; max-height: 150px; object-fit: cover;">
                            </div>
                        </div>
                        @endif

                        <div class="mb-4">
                            <label for="image" class="form-label">{{ __('admin.form.new_image') }}</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                id="image" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Format: JPEG, PNG, JPG, GIF. Max: 2MB</small>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-check me-1"></i> {{ __('admin.actions.update') }}
                            </button>
                            <a href="{{ route('admin.cities.index') }}" class="btn btn-outline-secondary">
                                {{ __('admin.actions.cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
