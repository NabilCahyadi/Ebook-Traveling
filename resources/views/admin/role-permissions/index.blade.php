@extends('layouts.admin')

@section('title', 'Role Permissions')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Role Permissions</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><span class="text-muted fw-light">User Management /</span> Role Permissions</h4>
            <p class="text-muted mb-0">Kelola hak akses untuk setiap role</p>
        </div>
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

    <!-- Roles List -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Role</th>
                            <th>Deskripsi</th>
                            <th width="150">Jumlah Permission</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $index => $role)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <span class="fw-semibold">{{ $role->name }}</span>
                                    @if($role->slug === 'admin')
                                        <span class="badge bg-danger ms-1">System</span>
                                    @endif
                                </td>
                                <td>{{ $role->description ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ $role->permissions_count ?? $role->permissions->count() }}</span>
                                </td>
                                <td>
                                    @if($role->slug !== 'admin')
                                        <a href="{{ route('admin.role-permissions.edit', $role->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bx bx-edit"></i> Kelola
                                        </a>
                                    @else
                                        <span class="text-muted small">Full Access</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <i class="bx bx-info-circle fs-1 text-muted mb-2"></i>
                                    <p class="mb-0 text-muted">Tidak ada role ditemukan</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
