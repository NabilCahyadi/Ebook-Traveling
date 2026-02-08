@extends('layouts.admin')

@section('title', __('admin.admins.edit_admin'))

@section('content')

    <!-- Page Header -->
    <div class="mb-4">
        <h4 class="fw-bold py-3 mb-2">
            <span class="text-muted fw-light">
                <a href="{{ route('admin.admins.index') }}" class="text-muted">{{ __('admin.admins.title') }}</a> /
            </span> 
            {{ __('admin.admins.edit_admin') }}
        </h4>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('admin.admins.form_edit_admin') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.admins.update', $admin->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('admin.admins.full_name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                id="name" name="name" value="{{ old('name', $admin->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('admin.admins.email') }} <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                id="email" name="email" value="{{ old('email', $admin->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">{{ __('admin.admins.phone_number') }}</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                id="phone" name="phone" value="{{ old('phone', $admin->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- <div class="mb-3">
                            <label for="type" class="form-label">{{ __('admin.admins.admin_type') }} <span class="text-danger">*</span></label>
                            @if($admin->type === 'superadmin')
                                <input type="text" class="form-control" id="type" value="Super Admin" readonly>
                                <input type="hidden" name="type" value="superadmin">
                                <small class="form-text text-muted">
                                    Super Admin type cannot be changed
                                </small>
                            @else
                                <input type="text" class="form-control" id="type" value="Admin" readonly>
                                <input type="hidden" name="type" value="admin">
                                <small class="form-text text-muted">
                                    Admin type cannot be changed to Super Admin
                                </small>
                            @endif
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div> -->

                        <div class="mb-3">
                            <label for="status" class="form-label">{{ __('admin.admins.status') }} <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="active" {{ old('status', $admin->status) === 'active' ? 'selected' : '' }}>{{ __('admin.admins.active') }}</option>
                                <option value="inactive" {{ old('status', $admin->status) === 'inactive' ? 'selected' : '' }}>{{ __('admin.admins.inactive') }}</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <div class="alert alert-warning">
                            <i class="ti ti-info-circle me-2"></i>
                            <strong>{{ __('admin.admins.change_password') }}</strong> - {{ __('admin.admins.leave_blank_password') }}
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('admin.admins.new_password') }}</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                id="password" name="password">
                            <small class="form-text text-muted">{{ __('admin.admins.min_8_chars') }}. {{ __('admin.admins.leave_blank_password') }}.</small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">{{ __('admin.admins.confirm_new_password') }}</label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                id="password_confirmation" name="password_confirmation">
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.admins.index') }}" class="btn btn-outline-secondary">
                                <i class="ti ti-arrow-left me-1"></i> {{ __('admin.admins.back') }}
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-check me-1"></i> {{ __('admin.admins.update') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-3">
                        <i class="ti ti-info-circle me-2"></i> {{ __('admin.admins.admin_detail') }}
                    </h5>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <strong>{{ __('admin.admins.created_at') }}:</strong><br>
                            <small class="text-muted">{{ $admin->created_at->format('d M Y, H:i') }}</small>
                        </li>
                        <li class="mb-2">
                            <strong>{{ __('admin.admins.updated_at') }}:</strong><br>
                            <small class="text-muted">{{ $admin->updated_at->format('d M Y, H:i') }}</small>
                        </li>
                        @if($admin->last_login_at)
                        <li class="mb-2">
                            <strong>{{ __('admin.admins.last_login') }}:</strong><br>
                            <small class="text-muted">{{ $admin->last_login_at->format('d M Y, H:i') }}</small>
                            <br>
                            <small class="text-muted">({{ $admin->last_login_at->diffForHumans() }})</small>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>

            <div class="card bg-primary text-white mt-3">
                <div class="card-body">
                    <h6 class="text-white mb-3">
                        <i class="ti ti-shield-check me-2"></i> {{ __('admin.admins.security') }}
                    </h6>
                    <ul class="mb-0" style="list-style: none; padding-left: 0;">
                        <li class="mb-2">
                            <i class="ti ti-point-filled me-2"></i>
                            {{ __('admin.admins.info_password') }}
                        </li>
                        <li>
                            <i class="ti ti-point-filled me-2"></i>
                            {{ __('admin.admins.leave_blank_password') }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection
