@extends('layouts.admin')

@section('title', __('admin.roles.edit_role'))

@section('content')

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold py-3 mb-2">
                <span class="text-muted fw-light">{{ __('admin.menu.admin') }} / <a href="{{ route('admin.roles.index') }}">{{ __('admin.roles.title') }}</a> /</span> {{ __('admin.roles.edit_role') }}
            </h4>
        </div>
        <div>
            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                <i class="ti ti-arrow-left me-1"></i> {{ __('admin.buttons.back') }}
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">{{ __('admin.roles.edit_role') }}: {{ $role->name }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('admin.form.name') }} <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name', $role->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="slug" class="form-label">{{ __('admin.form.slug') }}</label>
                    <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug"
                        name="slug" value="{{ old('slug', $role->slug) }}">
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">{{ __('admin.form.description') }}</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                        rows="3">{{ old('description', $role->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                            value="1" {{ old('is_active', $role->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">{{ __('admin.form.active') }}</label>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-check me-1"></i> {{ __('admin.buttons.update') }}
                    </button>
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-label-secondary">
                        {{ __('admin.buttons.cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </div>

@endsection
