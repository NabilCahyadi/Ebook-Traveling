@extends('layouts.admin')

@section('title', 'Edit Role Permissions - ' . $role->name)

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.role-permissions.index') }}">Role Permissions</a></li>
            <li class="breadcrumb-item active">{{ $role->name }}</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><span class="text-muted fw-light">Role Permissions /</span> {{ $role->name }}</h4>
            <p class="text-muted mb-0">Kelola hak akses untuk role "{{ $role->name }}"</p>
        </div>
        <a href="{{ route('admin.role-permissions.index') }}" class="btn btn-outline-secondary">
            <i class="bx bx-arrow-back me-1"></i> Kembali
        </a>
    </div>

    @if($isGuestRole)
        <div class="alert alert-info mb-4">
            <i class="bx bx-info-circle me-2"></i>
            <strong>Info:</strong> Role Guest memiliki akses terbatas sesuai dengan pengaturan default untuk pengunjung.
        </div>
    @endif

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

    <form action="{{ route('admin.role-permissions.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Permissions</h5>
                <div>
                    <button type="button" class="btn btn-sm btn-outline-primary me-2" onclick="selectAll()">
                        <i class="bx bx-check-square me-1"></i> Pilih Semua
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="deselectAll()">
                        <i class="bx bx-square me-1"></i> Hapus Semua
                    </button>
                </div>
            </div>
            <div class="card-body">
                @foreach($permissionModules as $moduleName => $permissions)
                    <div class="permission-module mb-4">
                        <h6 class="fw-semibold text-primary mb-3 border-bottom pb-2">
                            <i class="bx bx-folder me-2"></i>{{ ucfirst(str_replace('-', ' ', $moduleName)) }}
                        </h6>
                        <div class="row">
                            @foreach($permissions as $permission)
                                <div class="col-md-4 col-lg-3 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input permission-checkbox" 
                                            type="checkbox" 
                                            name="permissions[]" 
                                            value="{{ $permission->name }}" 
                                            id="permission_{{ $permission->id }}"
                                            {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>
                                        <label class="form-check-label small" for="permission_{{ $permission->id }}">
                                            {{ ucwords(str_replace(['.', '-', '_'], ' ', $permission->name)) }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="bx bx-save me-1"></i> Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function selectAll() {
    document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
        checkbox.checked = true;
    });
}

function deselectAll() {
    document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
        checkbox.checked = false;
    });
}
</script>
@endpush
