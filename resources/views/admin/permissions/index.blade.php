@extends('layouts.admin')

@section('title', 'Permission Management')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">Admin /</span> Permissions
            </h4>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Role Permissions Overview</h5>
                <p class="text-muted mb-0">Manage access permissions for each role</p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 200px;">Role</th>
                                <th>Resources</th>
                                <th style="width: 150px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($roles as $role)
                                <tr>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold">{{ ucfirst($role->name) }}</span>
                                            <small class="text-muted">{{ $role->slug }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $rolePermissions = $permissions->get($role->id) ?? collect();
                                            $permissionCount = $rolePermissions->count();
                                        @endphp

                                        @if ($permissionCount > 0)
                                            <div class="d-flex flex-wrap gap-1">
                                                @foreach ($rolePermissions->take(5) as $permission)
                                                    <span class="badge bg-label-primary">{{ $permission->resource }}</span>
                                                @endforeach
                                                @if ($permissionCount > 5)
                                                    <span class="badge bg-label-secondary">+{{ $permissionCount - 5 }}
                                                        more</span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-muted">No permissions assigned</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.permissions.edit', $role->id) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="ti ti-settings me-1"></i> Manage
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4">
                                        <p class="text-muted mb-0">No roles found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Resources Legend -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">Available Resources</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($resources as $key => $label)
                        <div class="col-md-3 mb-2">
                            <span class="badge bg-label-info me-2">{{ $key }}</span>
                            <small>{{ $label }}</small>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
