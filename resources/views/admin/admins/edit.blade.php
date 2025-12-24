@extends('layouts.admin')

@section('title', 'Edit Admin')

@section('content')

    <!-- Page Header -->
    <div class="mb-4">
        <h4 class="fw-bold py-3 mb-2">
            <span class="text-muted fw-light">
                <a href="{{ route('admin.admins.index') }}" class="text-muted">Manajemen Admin</a> /
            </span> 
            Edit Admin
        </h4>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Form Edit Admin</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.admins.update', $admin->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                id="name" name="name" value="{{ old('name', $admin->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                id="email" name="email" value="{{ old('email', $admin->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                id="phone" name="phone" value="{{ old('phone', $admin->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="type" class="form-label">Tipe Admin <span class="text-danger">*</span></label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="">Pilih Tipe</option>
                                <option value="admin" {{ old('type', $admin->type) === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="superadmin" {{ old('type', $admin->type) === 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                            </select>
                            <small class="form-text text-muted">
                                Super Admin memiliki akses penuh ke semua fitur sistem
                            </small>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="active" {{ old('status', $admin->status) === 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ old('status', $admin->status) === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <div class="alert alert-warning">
                            <i class="ti ti-info-circle me-2"></i>
                            <strong>Ubah Password</strong> - Kosongkan jika tidak ingin mengubah password
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                id="password" name="password">
                            <small class="form-text text-muted">Minimal 8 karakter. Kosongkan jika tidak ingin mengubah password.</small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                id="password_confirmation" name="password_confirmation">
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.admins.index') }}" class="btn btn-outline-secondary">
                                <i class="ti ti-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-check me-1"></i> Perbarui
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
                        <i class="ti ti-info-circle me-2"></i> Detail Admin
                    </h5>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <strong>Dibuat:</strong><br>
                            <small class="text-muted">{{ $admin->created_at->format('d M Y, H:i') }}</small>
                        </li>
                        <li class="mb-2">
                            <strong>Terakhir Diperbarui:</strong><br>
                            <small class="text-muted">{{ $admin->updated_at->format('d M Y, H:i') }}</small>
                        </li>
                        @if($admin->last_login_at)
                        <li class="mb-2">
                            <strong>Login Terakhir:</strong><br>
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
                        <i class="ti ti-shield-check me-2"></i> Keamanan
                    </h6>
                    <ul class="mb-0" style="list-style: none; padding-left: 0;">
                        <li class="mb-2">
                            <i class="ti ti-point-filled me-2"></i>
                            Password harus minimal 8 karakter
                        </li>
                        <li>
                            <i class="ti ti-point-filled me-2"></i>
                            Kosongkan password jika tidak ingin mengubah
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection
