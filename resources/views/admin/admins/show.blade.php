@extends('layouts.admin')

@section('title', 'Detail Admin')

@section('content')

    <!-- Page Header -->
    <div class="mb-4">
        <h4 class="fw-bold py-3 mb-2">
            <span class="text-muted fw-light">
                <a href="{{ route('admin.admins.index') }}" class="text-muted">Manajemen Admin</a> /
            </span> 
            Detail Admin
        </h4>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Informasi Admin</h5>
                    <div>
                        <a href="{{ route('admin.admins.edit', $admin->id) }}" class="btn btn-sm btn-primary">
                            <i class="ti ti-edit me-1"></i> Edit
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Nama Lengkap</strong>
                        </div>
                        <div class="col-md-8">
                            {{ $admin->name }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Email</strong>
                        </div>
                        <div class="col-md-8">
                            {{ $admin->email }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Nomor Telepon</strong>
                        </div>
                        <div class="col-md-8">
                            {{ $admin->phone ?? '-' }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Tipe Admin</strong>
                        </div>
                        <div class="col-md-8">
                            @if ($admin->type === 'superadmin')
                                <span class="badge bg-label-danger">
                                    <i class="ti ti-crown me-1"></i> Super Admin
                                </span>
                            @else
                                <span class="badge bg-label-primary">
                                    <i class="ti ti-user me-1"></i> Admin
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Status</strong>
                        </div>
                        <div class="col-md-8">
                            @if ($admin->status === 'active')
                                <span class="badge bg-label-success">Aktif</span>
                            @else
                                <span class="badge bg-label-secondary">Tidak Aktif</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Tanggal Dibuat</strong>
                        </div>
                        <div class="col-md-8">
                            {{ $admin->created_at->format('d F Y, H:i') }}
                            <br>
                            <small class="text-muted">({{ $admin->created_at->diffForHumans() }})</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Terakhir Diperbarui</strong>
                        </div>
                        <div class="col-md-8">
                            {{ $admin->updated_at->format('d F Y, H:i') }}
                            <br>
                            <small class="text-muted">({{ $admin->updated_at->diffForHumans() }})</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Login Terakhir</strong>
                        </div>
                        <div class="col-md-8">
                            @if ($admin->last_login_at)
                                {{ $admin->last_login_at->format('d F Y, H:i') }}
                                <br>
                                <small class="text-muted">({{ $admin->last_login_at->diffForHumans() }})</small>
                            @else
                                <span class="text-muted">Belum pernah login</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.admins.index') }}" class="btn btn-outline-secondary">
                            <i class="ti ti-arrow-left me-1"></i> Kembali
                        </a>
                        @if (auth('admin')->id() !== $admin->id)
                            <form action="{{ route('admin.admins.destroy', $admin->id) }}" method="POST"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus admin ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="ti ti-trash me-1"></i> Hapus Admin
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    @if ($admin->avatar)
                        <img src="{{ Storage::url($admin->avatar) }}" alt="{{ $admin->name }}"
                            class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <div class="avatar avatar-xl mb-3" style="margin: 0 auto;">
                            <span class="avatar-initial rounded-circle bg-label-primary" style="font-size: 3rem; width: 150px; height: 150px; display: flex; align-items: center; justify-content: center;">
                                {{ strtoupper(substr($admin->name, 0, 2)) }}
                            </span>
                        </div>
                    @endif
                    <h5>{{ $admin->name }}</h5>
                    <p class="text-muted">{{ $admin->email }}</p>
                    @if ($admin->type === 'superadmin')
                        <span class="badge bg-label-danger">
                            <i class="ti ti-crown me-1"></i> Super Admin
                        </span>
                    @else
                        <span class="badge bg-label-primary">
                            <i class="ti ti-user me-1"></i> Admin
                        </span>
                    @endif
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <h6 class="mb-3">
                        <i class="ti ti-info-circle me-2"></i> Statistik
                    </h6>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Status Akun:</span>
                        @if ($admin->status === 'active')
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary">Tidak Aktif</span>
                        @endif
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tipe:</span>
                        <strong>{{ $admin->type === 'superadmin' ? 'Super Admin' : 'Admin' }}</strong>
                    </div>
                    @if($admin->last_login_at)
                    <div class="d-flex justify-content-between">
                        <span>Aktivitas Terakhir:</span>
                        <small class="text-muted">{{ $admin->last_login_at->diffForHumans() }}</small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
