@extends('layouts.admin')

@section('title', __('admin.roles.role_details'))

@section('content')

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ __('admin.messages.success_title') }}</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ __('admin.messages.error_title') }}</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold py-3 mb-2">
                <span class="text-muted fw-light">{{ __('admin.menu.admin') }} / <a href="{{ route('admin.roles.index') }}">{{ __('admin.roles.title') }}</a> /</span> {{ $role->name }}
            </h4>
        </div>
        <div>
            <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-primary me-2">
                <i class="ti ti-pencil me-1"></i> {{ __('admin.buttons.edit') }}
            </a>
            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                <i class="ti ti-arrow-left me-1"></i> {{ __('admin.buttons.back') }}
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('admin.roles.role_details') }}</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 30%">{{ __('admin.form.name') }}</th>
                            <td>{{ $role->name }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('admin.form.slug') }}</th>
                            <td><code>{{ $role->slug }}</code></td>
                        </tr>
                        <tr>
                            <th>{{ __('admin.form.description') }}</th>
                            <td>{{ $role->description ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('admin.form.status') }}</th>
                            <td>
                                @if ($role->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>{{ __('admin.roles.created') }}</th>
                            <td>{{ $role->created_at->format('d M Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('admin.roles.updated') }}</th>
                            <td>{{ $role->updated_at->format('d M Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('admin.users.users') }} with this Role</h5>
                    <span class="badge bg-primary">{{ $role->users->count() ?? 0 }}</span>
                </div>
                <div class="card-body">
                    @if ($role->users && $role->users->count() > 0)
                        <ul class="list-group list-group-flush">
                            @foreach ($role->users->take(10) as $user)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $user->name }}</strong>
                                        <br><small class="text-muted">{{ $user->email }}</small>
                                    </div>
                                    <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="ti ti-eye"></i>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        @if ($role->users->count() > 10)
                            <div class="text-center mt-3">
                                <small class="text-muted">and {{ $role->users->count() - 10 }} more users...</small>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <i class="ti ti-users-minus ti-xl text-muted mb-2"></i>
                            <p class="text-muted mb-0">No users with this role</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
