@extends('layouts.admin')

@section('title', __('admin.categories.edit'))

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">{{ __('admin.menu.categories') }}</a></li>
            <li class="breadcrumb-item active">{{ __('admin.actions.edit') }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('admin.actions.edit') }} - {{ $category->name }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('admin.form.name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                id="name" name="name" value="{{ old('name', $category->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('admin.form.current_image') }}</label>
                            <div class="mb-2">
                                <img src="{{ $category->image_url }}" alt="{{ $category->name }}" 
                                    class="rounded" style="max-width: 150px; max-height: 150px; object-fit: cover;">
                            </div>
                        </div>

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
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
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
