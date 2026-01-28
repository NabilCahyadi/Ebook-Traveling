@extends('layouts.admin')

@section('title', __('admin.users.add_user'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">{{ __('admin.menu.user_management') }} /</span> {{ __('admin.users.add_user') }}
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
            <div class="card-body">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <!-- Name -->
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">{{ __('admin.form.name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">{{ __('admin.form.email') }} <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">{{ __('admin.users.phone') }}</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                                name="phone" value="{{ old('phone') }}" placeholder="{{ __('admin.common.optional') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Role -->
                        <div class="col-md-6 mb-3">
                            <label for="role_selector" class="form-label">{{ __('admin.form.role') }} <span class="text-danger">*</span></label>
                            @php
                                $roles = \App\Models\Role::all();
                                $selectedRoles = old('roles', $roleSlug ? [$roleSlug] : []);
                            @endphp
                            <select class="form-select @error('roles') is-invalid @enderror @error('roles.*') is-invalid @enderror" 
                                id="role_selector">
                                <option value="">Select Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->slug }}" data-name="{{ $role->name }}">
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                            
                            <!-- Selected Roles Display -->
                            <div id="selected-roles" class="mt-2">
                                <!-- Badges will appear here -->
                            </div>
                            
                            <!-- Hidden inputs for form submission -->
                            <div id="role-inputs"></div>
                            
                            @error('roles')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            @error('roles.*')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">{{ __('admin.form.password') }} <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="ti ti-eye" id="togglePasswordIcon"></i>
                                </button>
                            </div>
                            <small class="text-muted">Minimum 8 characters</small>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">{{ __('admin.form.password_confirmation') }} <span
                                    class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                id="password_confirmation" name="password_confirmation" required>
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-check me-1"></i> {{ __('admin.users.add_user') }}
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-label-secondary">
                            {{ __('admin.actions.cancel') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Toggle password visibility
            document.getElementById('togglePassword').addEventListener('click', function() {
                const password = document.getElementById('password');
                const icon = document.getElementById('togglePasswordIcon');

                if (password.type === 'password') {
                    password.type = 'text';
                    icon.classList.remove('ti-eye');
                    icon.classList.add('ti-eye-off');
                } else {
                    password.type = 'password';
                    icon.classList.remove('ti-eye-off');
                    icon.classList.add('ti-eye');
                }
            });

            // Role selection handler
            const selectedRoles = new Map();
            
            // Restore old values on validation errors
            @if(old('roles'))
                @foreach(old('roles') as $roleSlug)
                    @php
                        $role = \App\Models\Role::where('slug', $roleSlug)->first();
                    @endphp
                    @if($role)
                        selectedRoles.set('{{ $roleSlug }}', '{{ $role->name }}');
                    @endif
                @endforeach
            @elseif(isset($roleSlug) && $roleSlug)
                @php
                    $role = \App\Models\Role::where('slug', $roleSlug)->first();
                @endphp
                @if($role)
                    selectedRoles.set('{{ $roleSlug }}', '{{ $role->name }}');
                @endif
            @endif
            
            // Render existing selections
            function renderRoleSelection() {
                const container = document.getElementById('selected-roles');
                const inputsContainer = document.getElementById('role-inputs');
                container.innerHTML = '';
                inputsContainer.innerHTML = '';
                
                selectedRoles.forEach((name, slug) => {
                    // Create badge
                    const badge = document.createElement('span');
                    badge.className = 'role-badge';
                    badge.innerHTML = `
                        ${name}
                        <button type="button" class="badge-remove" data-slug="${slug}">
                            <i class="ti ti-x"></i>
                        </button>
                    `;
                    container.appendChild(badge);
                    
                    // Create hidden input
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'roles[]';
                    input.value = slug;
                    inputsContainer.appendChild(input);
                });
                
                // Add remove handlers
                document.querySelectorAll('.badge-remove').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const slug = this.dataset.slug;
                        selectedRoles.delete(slug);
                        renderRoleSelection();
                        
                        // Re-enable option in select
                        const option = document.querySelector(`#role_selector option[value="${slug}"]`);
                        if (option) option.disabled = false;
                    });
                });
            }
            
            // Role selector change event
            document.getElementById('role_selector').addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption.value) {
                    const slug = selectedOption.value;
                    const name = selectedOption.dataset.name;
                    
                    if (!selectedRoles.has(slug)) {
                        selectedRoles.set(slug, name);
                        renderRoleSelection();
                        selectedOption.disabled = true;
                    }
                    
                    this.value = '';
                }
            });
            
            // Initial render
            renderRoleSelection();
        </script>
    @endpush

    @push('styles')
        <style>
            .role-badge {
                display: inline-flex;
                align-items: center;
                background-color: #e0f0ff;
                border: 1px solid #7eb3ff;
                border-radius: 4px;
                padding: 4px 8px;
                margin-right: 6px;
                margin-bottom: 6px;
                font-size: 13px;
                color: #0056b3;
            }
            
            .role-badge .badge-remove {
                background: none;
                border: none;
                color: #0056b3;
                cursor: pointer;
                padding: 0;
                margin-left: 6px;
                display: inline-flex;
                align-items: center;
                font-size: 14px;
                line-height: 1;
            }
            
            .role-badge .badge-remove:hover {
                color: #003d82;
            }
            
            .role-badge .badge-remove i {
                font-size: 14px;
            }
        </style>
    @endpush
@endsection
