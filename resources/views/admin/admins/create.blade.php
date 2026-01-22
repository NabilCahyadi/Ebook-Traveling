@extends('layouts.admin')

@section('title', __('admin.admins.add_admin'))

@section('content')

    <!-- Page Header -->
    <div class="mb-4">
        <h4 class="fw-bold py-3 mb-2">
            <span class="text-muted fw-light">
                <a href="{{ route('admin.admins.index') }}" class="text-muted">{{ __('admin.admins.title') }}</a> /
            </span> 
            {{ __('admin.admins.add_admin') }}
        </h4>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('admin.admins.form_add_admin') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.admins.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('admin.admins.full_name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('admin.admins.email') }} <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">{{ __('admin.admins.phone_number') }}</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                id="phone" name="phone" value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="type" class="form-label">{{ __('admin.admins.admin_type') }} <span class="text-danger">*</span></label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="">{{ __('admin.admins.select_type') }}</option>
                                <option value="admin" {{ old('type') === 'admin' ? 'selected' : '' }}>{{ __('admin.admins.admin') }}</option>
                                <option value="superadmin" {{ old('type') === 'superadmin' ? 'selected' : '' }}>{{ __('admin.admins.super_admin') }}</option>
                            </select>
                            <small class="form-text text-muted">
                                {{ __('admin.admins.superadmin_full_access') }}
                            </small>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">{{ __('admin.admins.status') }} <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="active" {{ old('status') === 'active' ? 'selected' : 'selected' }}>{{ __('admin.admins.active') }}</option>
                                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>{{ __('admin.admins.inactive') }}</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('admin.admins.password') }} <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                id="password" name="password" required>
                            <small class="form-text text-muted">{{ __('admin.admins.min_8_chars') }}</small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">{{ __('admin.admins.confirm_password') }} <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                id="password_confirmation" name="password_confirmation" required>
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.admins.index') }}" class="btn btn-outline-secondary">
                                <i class="ti ti-arrow-left me-1"></i> {{ __('admin.admins.back') }}
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-check me-1"></i> {{ __('admin.admins.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="text-white mb-3">
                        <i class="ti ti-info-circle me-2"></i> {{ __('admin.admins.info') }}
                    </h5>
                    <ul class="mb-0" style="list-style: none; padding-left: 0;">
                        <li class="mb-2">
                            <i class="ti ti-point-filled me-2"></i>
                            <strong>{{ __('admin.admins.admin') }}:</strong> {{ __('admin.admins.info_admin') }}
                        </li>
                        <li class="mb-2">
                            <i class="ti ti-point-filled me-2"></i>
                            <strong>{{ __('admin.admins.super_admin') }}:</strong> {{ __('admin.admins.info_superadmin') }}
                        </li>
                        <li class="mb-2">
                            <i class="ti ti-point-filled me-2"></i>
                            {{ __('admin.admins.info_password') }}
                        </li>
                        <li>
                            <i class="ti ti-point-filled me-2"></i>
                            {{ __('admin.admins.info_email') }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection
