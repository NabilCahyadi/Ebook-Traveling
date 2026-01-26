@extends('layouts.admin')

@section('title', __('admin.users.edit_user'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">{{ __('admin.menu.user_management') }} /</span> {{ __('admin.users.edit_user') }}
            </h4>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="ti ti-arrow-left me-1"></i> {{ __('admin.manual_subscription.back_to_list') }}
            </a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible" role="alert">
                <strong>{{ __('admin.messages.error_title') }}</strong> {{ __('admin.messages.validation_error') }}
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ __('admin.users.edit_user') }}: {{ $user->name }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Name -->
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">{{ __('admin.form.name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">{{ __('admin.form.email') }} <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Current Roles -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('admin.form.current_roles') }}</label>
                            <div>
                                @if ($user->roles && $user->roles->count() > 0)
                                    @foreach ($user->roles as $role)
                                        <span class="badge bg-primary me-1">{{ $role->name }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">No roles assigned</span>
                                @endif
                            </div>
                            <small class="text-muted">To change roles, use Role Management</small>
                        </div>

                        <!-- User Info -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('admin.users.user_info') }}</label>
                            <div class="text-muted">
                                <small>
                                    <strong>Registered:</strong> {{ $user->created_at->format('d M Y H:i') }}<br>
                                    <strong>Email Verified:</strong> 
                                    @if ($user->email_verified_at)
                                        <span class="text-success">Yes ({{ $user->email_verified_at->format('d M Y') }})</span>
                                    @else
                                        <span class="text-warning">No</span>
                                    @endif
                                </small>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">{{ __('admin.form.new_password') }}</label>
                            <div class="input-group">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="Leave blank to keep current password">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="ti ti-eye" id="togglePasswordIcon"></i>
                                </button>
                            </div>
                            <small class="text-muted">Minimum 8 characters (leave blank to keep current)</small>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">{{ __('admin.form.confirm_password') }}</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" placeholder="Confirm new password">
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-check me-1"></i> {{ __('admin.buttons.update') }}
                        </button>
                        <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-outline-info">
                            <i class="ti ti-eye me-1"></i> {{ __('admin.buttons.view') }}
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-label-secondary">
                            {{ __('admin.buttons.cancel') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Toggle password visibility
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const icon = document.getElementById('togglePasswordIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('ti-eye');
            icon.classList.add('ti-eye-off');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('ti-eye-off');
            icon.classList.add('ti-eye');
        }
    });
</script>
@endpush
