@extends('layouts.admin')

@section('title', 'Admin Permissions Matrix')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Admin Permissions Matrix</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><span class="text-muted fw-light">Admin /</span> Permissions Matrix</h4>
            <p class="text-muted mb-0">Kelola hak akses semua admin dalam satu tampilan</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.admin-permissions-matrix.export') }}" class="btn btn-outline-primary">
                <i class="bx bx-export me-1"></i> Export
            </a>
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

    <!-- Template Selection -->
    @if($templates && count($templates) > 0)
    <div class="card mb-4">
        <div class="card-header">
            <h6 class="mb-0">Apply Template</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.admin-permissions-matrix.apply-template') }}" method="POST" class="row g-3">
                @csrf
                <div class="col-md-4">
                    <select name="admin_id" class="form-select" required>
                        <option value="">Pilih Admin</option>
                        @foreach($admins as $admin)
                            <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <select name="template" class="form-select" required>
                        <option value="">Pilih Template</option>
                        @foreach($templates as $key => $template)
                            <option value="{{ $key }}">{{ $template['name'] ?? ucfirst($key) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-check me-1"></i> Apply Template
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Permissions Matrix -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead class="table-light">
                        <tr>
                            <th class="sticky-col bg-light" width="200">Permission</th>
                            @foreach($admins as $admin)
                                <th class="text-center" style="min-width: 100px;">
                                    <small class="d-block fw-semibold">{{ $admin->name }}</small>
                                    <small class="text-muted">{{ $admin->type }}</small>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($permissions as $moduleName => $modulePermissions)
                            <tr class="table-secondary">
                                <td colspan="{{ count($admins) + 1 }}" class="fw-semibold">
                                    <i class="bx bx-folder me-1"></i>
                                    {{ ucfirst(str_replace(['-', '_'], ' ', $moduleName)) }}
                                </td>
                            </tr>
                            @foreach($modulePermissions as $permission)
                                <tr>
                                    <td class="sticky-col bg-white">
                                        <small>{{ ucwords(str_replace(['.', '-', '_'], ' ', $permission->name)) }}</small>
                                    </td>
                                    @foreach($admins as $admin)
                                        <td class="text-center">
                                            @if($admin->type === 'admin')
                                                <i class="bx bx-check text-success"></i>
                                            @else
                                                <div class="form-check d-flex justify-content-center">
                                                    <input class="form-check-input permission-toggle" 
                                                        type="checkbox" 
                                                        data-admin="{{ $admin->id }}"
                                                        data-permission="{{ $permission->name }}"
                                                        {{ $admin->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                                </div>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.sticky-col {
    position: sticky;
    left: 0;
    z-index: 1;
}
.table-responsive {
    max-height: 70vh;
    overflow: auto;
}
</style>
@endpush

@push('scripts')
<script>
document.querySelectorAll('.permission-toggle').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const adminId = this.dataset.admin;
        const permission = this.dataset.permission;
        const isChecked = this.checked;
        
        fetch('{{ route("admin.admin-permissions-matrix.update-permission") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                admin_id: adminId,
                permission: permission,
                grant: isChecked
            })
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                this.checked = !isChecked;
                alert(data.message || 'Terjadi kesalahan');
            }
        })
        .catch(error => {
            this.checked = !isChecked;
            console.error('Error:', error);
            alert('Terjadi kesalahan');
        });
    });
});
</script>
@endpush
