@extends('layouts.admin')

@section('title', 'Kelola Permission Admin')

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
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.admins.index') }}">Manajemen Admin</a>
                </li>
                <li class="breadcrumb-item active">Kelola Permission</li>
            </ol>
        </nav>
        <h4 class="fw-bold py-3 mb-2">
            <span class="text-muted fw-light">Pengaturan /</span> Kelola Permission Admin
        </h4>
    </div>

    <div class="row">
        <div class="col-md-12">
            <!-- Admin Info -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        @if ($admin->avatar)
                            <img src="{{ Storage::url($admin->avatar) }}" alt="{{ $admin->name }}"
                                class="rounded-circle me-3" style="width: 60px; height: 60px; object-fit: cover;">
                        @else
                            <div class="avatar avatar-lg me-3">
                                <span class="avatar-initial rounded-circle bg-label-primary">
                                    {{ strtoupper(substr($admin->name, 0, 2)) }}
                                </span>
                            </div>
                        @endif
                        <div>
                            <h5 class="mb-1">{{ $admin->name }}</h5>
                            <p class="text-muted mb-0">{{ $admin->email }}</p>
                            <span class="badge bg-label-primary mt-1">
                                <i class="ti ti-user me-1"></i> {{ ucfirst($admin->type) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Permissions Form -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="ti ti-shield-lock me-2"></i>
                        Kelola Permission
                    </h5>
                    <p class="text-muted mb-0 mt-2">Pilih permission yang akan diberikan kepada admin ini. Super Admin memiliki semua akses secara otomatis.</p>
                </div>

                <form action="{{ route('admin.admins.permissions.update', $admin->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        @if ($permissions->count() > 0)
                            <div class="row">
                                @foreach ($permissions as $module => $subModules)
                                    @php
                                        $moduleSlug = Str::slug($module);
                                    @endphp
                                    <div class="col-12 mb-4">
                                        <div class="card">
                                            <div class="card-header bg-label-primary">
                                                <h5 class="mb-0">
                                                    <i class="ti ti-folder me-2"></i>
                                                    {{ $module }}
                                                </h5>
                                            </div>
                                            <div class="card-body mt-4">
                                                <div class="row">
                                                    @foreach ($subModules as $subModule => $subModulePermissions)
                                                        @php
                                                            $subModuleSlug = Str::slug($subModule);
                                                        @endphp
                                                        <div class="col-md-6 col-lg-4 mb-3">
                                                            <div class="border rounded p-3 h-100">
                                                                <div class="d-flex align-items-center mb-3">
                                                                    <i class="ti ti-table me-2 text-primary"></i>
                                                                    <h6 class="mb-0">{{ $subModule }}</h6>
                                                                </div>
                                                                
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input submodule-checkbox" 
                                                                           type="checkbox" 
                                                                           id="select-all-{{ $moduleSlug }}-{{ $subModuleSlug }}"
                                                                           data-submodule="{{ $moduleSlug }}-{{ $subModuleSlug }}">
                                                                    <label class="form-check-label fw-semibold text-primary" for="select-all-{{ $moduleSlug }}-{{ $subModuleSlug }}">
                                                                        All
                                                                    </label>
                                                                </div>

                                                                <hr class="my-2">

                                                                @foreach ($subModulePermissions as $permission)
                                                                    <div class="form-check mb-2">
                                                                        <input class="form-check-input permission-checkbox permission-{{ $moduleSlug }}-{{ $subModuleSlug }}" 
                                                                               type="checkbox" 
                                                                               name="permissions[]"
                                                                               value="{{ $permission->id }}" 
                                                                               id="permission-{{ $permission->id }}"
                                                                               {{ in_array($permission->id, $adminPermissions) ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="permission-{{ $permission->id }}">
                                                                            <strong>{{ $permission->display_name }}</strong>
                                                                            @if ($permission->description)
                                                                                <br>
                                                                                <small class="text-muted">{{ $permission->description }}</small>
                                                                            @endif
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="ti ti-shield-off ti-lg text-muted mb-3"></i>
                                <p class="text-muted">Belum ada permission yang tersedia. Silakan tambahkan permission terlebih dahulu.</p>
                            </div>
                        @endif
                    </div>

                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('admin.admins.index') }}" class="btn btn-label-secondary">
                            <i class="ti ti-arrow-left me-1"></i> Kembali
                        </a>
                        @if ($permissions->count() > 0)
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy me-1"></i> Simpan Permission
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to update submodule checkbox state
        function updateSubmoduleCheckbox(submodule) {
            const submoduleCheckbox = document.querySelector('[data-submodule="' + submodule + '"]');
            if (!submoduleCheckbox) {
                console.log('Submodule checkbox not found:', submodule);
                return;
            }
            
            const allPermissions = document.querySelectorAll('.permission-' + submodule);
            const checkedPermissions = document.querySelectorAll('.permission-' + submodule + ':checked');
            
            console.log('Submodule:', submodule, 'Total:', allPermissions.length, 'Checked:', checkedPermissions.length);
            
            if (allPermissions.length === checkedPermissions.length && allPermissions.length > 0) {
                // All checked
                submoduleCheckbox.checked = true;
                submoduleCheckbox.indeterminate = false;
            } else if (checkedPermissions.length > 0) {
                // Some checked
                submoduleCheckbox.checked = false;
                submoduleCheckbox.indeterminate = true;
            } else {
                // None checked
                submoduleCheckbox.checked = false;
                submoduleCheckbox.indeterminate = false;
            }
        }

        // Select/Deselect all in a sub-module
        document.querySelectorAll('.submodule-checkbox').forEach(function(submoduleCheckbox) {
            submoduleCheckbox.addEventListener('click', function(e) {
                const submodule = this.dataset.submodule;
                const isChecked = this.checked;
                
                console.log('All checkbox clicked for:', submodule, 'New state:', isChecked);
                
                document.querySelectorAll('.permission-' + submodule).forEach(function(permCheckbox) {
                    permCheckbox.checked = isChecked;
                });
                
                // Update state immediately after changing all checkboxes
                updateSubmoduleCheckbox(submodule);
            });
        });

        // Update sub-module checkbox when individual permissions change
        document.querySelectorAll('.permission-checkbox').forEach(function(permCheckbox) {
            permCheckbox.addEventListener('change', function() {
                const classList = Array.from(this.classList);
                const submoduleClass = classList.find(c => c.startsWith('permission-'));
                
                if (submoduleClass) {
                    const submodule = submoduleClass.replace('permission-', '');
                    console.log('Individual checkbox changed, updating:', submodule);
                    updateSubmoduleCheckbox(submodule);
                }
            });
        });

        // Initialize state on page load
        console.log('Initializing checkboxes...');
        document.querySelectorAll('.submodule-checkbox').forEach(function(submoduleCheckbox) {
            const submodule = submoduleCheckbox.dataset.submodule;
            updateSubmoduleCheckbox(submodule);
        });
    });
</script>
@endpush
