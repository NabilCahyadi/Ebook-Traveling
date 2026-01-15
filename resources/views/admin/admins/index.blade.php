@extends('layouts.admin')

@section('title', 'Manajemen Admin')

@section('content')

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold py-3 mb-2">
                <span class="text-muted fw-light">Pengaturan /</span> Manajemen Admin
            </h4>
        </div>
        <div>
            <a href="{{ route('admin.admins.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i> Tambah Admin
            </a>
        </div>
    </div>

    <!-- Admins Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Admin</h5>
            <div class="text-muted">Total: {{ $admins->total() }} Admin</div>
        </div>

        <!-- Search Filter -->
        <div class="card-body border-bottom">
            <form action="{{ route('admin.admins.index') }}" method="GET" class="row g-3">
                <div class="col-md-7">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="ti ti-search"></i>
                        </span>
                        <input type="text" class="form-control" name="search" value="{{ $search ?? '' }}"
                            placeholder="Cari nama, email, atau telepon...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="type" class="form-select">
                        <option value="">Semua Tipe</option>
                        <option value="admin" {{ request('type') === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="superadmin" {{ request('type') === 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="ti ti-search me-1"></i> Cari
                    </button>
                </div>
                @if ((isset($search) && $search) || (isset($type) && $type))
                    <div class="col-12">
                        <a href="{{ route('admin.admins.index') }}"
                            class="btn btn-sm btn-outline-secondary">
                            <i class="ti ti-x me-1"></i> Hapus Filter
                        </a>
                    </div>
                @endif
            </form>
        </div>

        <div class="card-body">
            @if ($admins->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Tipe</th>
                                <th>Status</th>
                                <th>Login Terakhir</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admins as $admin)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if ($admin->avatar)
                                                <img src="{{ Storage::url($admin->avatar) }}" alt="{{ $admin->name }}"
                                                    class="rounded-circle me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <div class="avatar avatar-sm me-2">
                                                    <span class="avatar-initial rounded-circle bg-label-primary">
                                                        {{ strtoupper(substr($admin->name, 0, 2)) }}
                                                    </span>
                                                </div>
                                            @endif
                                            <div>
                                                <strong>{{ $admin->name }}</strong>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $admin->email }}</td>
                                    <td>{{ $admin->phone ?? '-' }}</td>
                                    <td>
                                        @if ($admin->type === 'superadmin')
                                            <span class="badge bg-label-danger">
                                                <i class="ti ti-crown me-1"></i> Super Admin
                                            </span>
                                        @else
                                            <span class="badge bg-label-danger">
                                                <i class="ti ti-user me-1"></i> Admin
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($admin->status === 'active')
                                            <span class="badge bg-label-success">Aktif</span>
                                        @else
                                            <span class="badge bg-label-secondary">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($admin->last_login_at)
                                            <small>{{ $admin->last_login_at->diffForHumans() }}</small>
                                        @else
                                            <small class="text-muted">Belum pernah login</small>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm btn-icon dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="{{ route('admin.admins.show', $admin->id) }}">
                                                    <i class="ti ti-eye me-2"></i> Detail
                                                </a>
                                                <a class="dropdown-item" href="{{ route('admin.admins.edit', $admin->id) }}">
                                                    <i class="ti ti-edit me-2"></i> Edit
                                                </a>
                                                @if ($admin->type !== 'superadmin')
                                                    <a class="dropdown-item" href="{{ route('admin.admins.permissions.edit', $admin->id) }}">
                                                        <i class="ti ti-shield-lock me-2"></i> Kelola Permission
                                                    </a>
                                                @endif
                                                @if (auth('admin')->id() !== $admin->id)
                                                    <div class="dropdown-divider"></div>
                                                    <form action="{{ route('admin.admins.destroy', $admin->id) }}" method="POST"
                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus admin ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="ti ti-trash me-2"></i> Hapus
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $admins->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="ti ti-users ti-lg text-muted"></i>
                    </div>
                    <h5 class="text-muted">Tidak ada admin ditemukan</h5>
                    <p class="text-muted">
                        @if (isset($search) || isset($type))
                            Coba ubah filter pencarian Anda.
                        @else
                            Belum ada admin yang terdaftar.
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>

@endsection
