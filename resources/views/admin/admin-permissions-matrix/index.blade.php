@extends('layouts.admin')

@section('title', __('admin.permissions.matrix_title', ['default' => 'Admin Permissions Matrix']))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        
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
                <h4 class="fw-bold py-3 mb-0">
                    <span class="text-muted fw-light">{{ __('admin.menu.admin') }} /</span> 
                    Permissions Matrix
                </h4>
                <small class="text-muted">Manage permissions for all admins in one place</small>
            </div>
            <div>
                <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary">
                    <i class="ti ti-arrow-left me-1"></i> Back to Admins
                </a>
            </div>
        </div>

        <!-- Search -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text"><i class="ti ti-search"></i></span>
                            <input type="text" class="form-control" name="search" 
                                   value="{{ request('search') }}" placeholder="Search admin by name or email...">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="ti ti-search me-1"></i> Search
                        </button>
                    </div>
                    @if(request('search'))
                        <div class="col-md-2">
                            <a href="{{ route('admin.admin-permissions-matrix.index') }}" class="btn btn-outline-secondary w-100">
                                <i class="ti ti-x me-1"></i> Clear
                            </a>
                        </div>
                    @endif
                </form>
            </div>
        </div>

        @if($admins->count() > 0)
            <!-- Permission Templates -->
            @if(!empty($templates))
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="ti ti-template me-2"></i>Quick Templates</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-2">
                            @foreach($templates as $key => $template)
                                <div class="col-auto">
                                    <button type="button" class="btn btn-outline-primary btn-sm template-btn" 
                                            data-template="{{ $key }}">
                                        <i class="ti ti-{{ $template['icon'] ?? 'shield' }} me-1"></i>
                                        {{ $template['name'] }}
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Permissions Matrix Table -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="ti ti-table me-2"></i>Permissions Matrix</h5>
                    <div>
                        <span class="badge bg-label-info">{{ $admins->count() }} Admins</span>
                        <span class="badge bg-label-primary">{{ $permissions->flatten()->count() }} Permissions</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="permissionsMatrix">
                            <thead class="table-light">
                                <tr>
                                    <th class="sticky-col" style="min-width: 200px;">Admin</th>
                                    @foreach($permissions as $group => $groupPermissions)
                                        @foreach($groupPermissions as $permission)
                                            <th class="text-center" style="min-width: 100px;" 
                                                data-bs-toggle="tooltip" title="{{ $permission->description ?? $permission->display_name }}">
                                                <small>{{ Str::limit($permission->display_name, 15) }}</small>
                                            </th>
                                        @endforeach
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($admins as $admin)
                                    <tr>
                                        <td class="sticky-col">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm me-2">
                                                    @if($admin->avatar)
                                                        <img src="{{ $admin->avatar_url }}" alt="Avatar" class="rounded-circle">
                                                    @else
                                                        <span class="avatar-initial rounded-circle bg-label-primary">
                                                            {{ strtoupper(substr($admin->name, 0, 2)) }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div>
                                                    <strong>{{ $admin->name }}</strong>
                                                    <br><small class="text-muted">{{ $admin->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        @foreach($permissions as $group => $groupPermissions)
                                            @foreach($groupPermissions as $permission)
                                                <td class="text-center">
                                                    <div class="form-check d-flex justify-content-center">
                                                        <input type="checkbox" 
                                                               class="form-check-input permission-checkbox"
                                                               data-admin-id="{{ $admin->id }}"
                                                               data-permission-id="{{ $permission->id }}"
                                                               {{ $admin->permissions->contains('id', $permission->id) ? 'checked' : '' }}
                                                               @if($admin->isSuperAdmin()) disabled title="Superadmin has all permissions" @endif>
                                                    </div>
                                                </td>
                                            @endforeach
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="ti ti-users-minus ti-xl text-muted mb-3"></i>
                    <h5 class="text-muted">No admins found</h5>
                    <p class="text-muted">Try adjusting your search criteria.</p>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('styles')
<style>
    .sticky-col {
        position: sticky;
        left: 0;
        background: white;
        z-index: 1;
    }
    
    thead .sticky-col {
        z-index: 2;
    }
    
    .permission-checkbox {
        cursor: pointer;
        width: 18px;
        height: 18px;
    }
    
    .permission-checkbox:disabled {
        cursor: not-allowed;
        opacity: 0.5;
    }
    
    #permissionsMatrix {
        font-size: 0.875rem;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function(tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Handle permission checkbox changes
        document.querySelectorAll('.permission-checkbox').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const adminId = this.dataset.adminId;
                const permissionId = this.dataset.permissionId;
                const action = this.checked ? 'attach' : 'detach';
                
                // Show loading state
                this.disabled = true;
                
                fetch('{{ route("admin.admin-permissions-matrix.update-permission") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        admin_id: adminId,
                        permission_id: permissionId,
                        action: action
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success toast/notification
                        showNotification('success', data.message);
                    } else {
                        // Revert checkbox state
                        this.checked = !this.checked;
                        showNotification('error', data.message || 'Failed to update permission');
                    }
                })
                .catch(error => {
                    // Revert checkbox state
                    this.checked = !this.checked;
                    showNotification('error', 'An error occurred');
                    console.error('Error:', error);
                })
                .finally(() => {
                    this.disabled = false;
                });
            });
        });

        function showNotification(type, message) {
            // You can implement a toast notification here
            console.log(type + ': ' + message);
        }
    });
</script>
@endpush
