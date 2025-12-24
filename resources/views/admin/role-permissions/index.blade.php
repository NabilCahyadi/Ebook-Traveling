@extends('layouts.admin')

@section('title', __('admin.role_permissions.title'))

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">{{ __('admin.role_permissions.title') }}</h4>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        @foreach($roles as $role)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="avatar avatar-lg bg-label-primary rounded">
                            <i class="ti ti-shield ti-lg"></i>
                        </div>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="roleMenu{{ $role->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="roleMenu{{ $role->id }}">
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.role-permissions.edit', $role->id) }}">
                                        <i class="ti ti-settings me-2"></i>{{ __('admin.role_permissions.configure_permissions') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <h5 class="card-title mb-1">{{ $role->name }}</h5>
                    <p class="text-muted small mb-3">{{ $role->description ?? __('admin.role_permissions.no_description') }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-label-info">
                            {{ $role->permissions->count() }} {{ __('admin.role_permissions.permissions') }}
                        </span>
                        <a href="{{ route('admin.role-permissions.edit', $role->id) }}" class="btn btn-sm btn-primary">
                            <i class="ti ti-settings me-1"></i>{{ __('admin.role_permissions.configure') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
