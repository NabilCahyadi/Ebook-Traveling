@extends('layouts.admin')

@section('title', __('admin.role_permissions.title') . ' - ' . $role->name)

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">{{ __('admin.role_permissions.title') }}</h4>
            <p class="text-muted mb-0">{{ __('admin.role_permissions.managing_permissions') }} <strong>{{ $role->name }}</strong> role</p>
            @if(isset($isGuestRole) && $isGuestRole)
            <div class="alert alert-info mt-2 mb-0">
                <i class="ti ti-info-circle me-1"></i>
                <strong>{{ $role->name }} {{ __('admin.role_permissions.role_info') }}</strong>
            </div>
            @endif
        </div>
        <a href="{{ route('admin.role-permissions.index') }}" class="btn btn-label-secondary">
            <i class="ti ti-arrow-left me-1"></i>{{ __('admin.role_permissions.back_to_roles') }}
        </a>
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

    <form action="{{ route('admin.role-permissions.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="ti ti-lock-access me-2"></i>{{ __('admin.role_permissions.permission_modules') }}
                </h5>
                <span class="badge bg-primary" id="selectedCount">0 {{ __('admin.role_permissions.permissions_selected') }}</span>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    @foreach($permissionModules as $module)
                    <div class="col-md-6 col-lg-4">
                        <div class="card border shadow-none h-100">
                            <div class="card-header bg-label-primary d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">{{ $module['name'] }}</h6>
                                <div class="form-check">
                                    <input class="form-check-input select-all-group" type="checkbox" 
                                           data-group="{{ Str::slug($module['name']) }}">
                                    <label class="form-check-label small">{{ __('admin.role_permissions.select_all') }}</label>
                                </div>
                            </div>
                            <div class="card-body pt-3" style="max-height: 400px; overflow-y: auto;">
                                <div class="permission-group" data-group="{{ Str::slug($module['name']) }}">
                                    @foreach($module['permissions'] as $permission)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input permission-checkbox" 
                                               type="checkbox" 
                                               name="permissions[]" 
                                               value="{{ $permission['name'] }}"
                                               id="perm_{{ $permission['name'] }}"
                                               data-group="{{ Str::slug($module['name']) }}"
                                               {{ in_array($permission['name'], $rolePermissions) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="perm_{{ $permission['name'] }}">
                                            {{ $permission['label'] }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <a href="{{ route('admin.role-permissions.index') }}" class="btn btn-label-secondary">
                    <i class="ti ti-x me-1"></i>Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-device-floppy me-1"></i>Save Permissions
                </button>
            </div>
        </div>
    </form>
</div>

<style>
    .card-body::-webkit-scrollbar {
        width: 6px;
    }
    
    .card-body::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .card-body::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }
    
    .card-body::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
    
    .card.border.shadow-none.h-100 {
        transition: all 0.3s ease;
    }
    
    .card.border.shadow-none.h-100:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
        transform: translateY(-2px);
    }
</style>

@push('scripts')
<script>
$(document).ready(function() {
    // Update selected count on page load
    updateSelectedCount();
    
    // Update group select all checkboxes on page load
    $('.select-all-group').each(function() {
        updateGroupSelectAll($(this).data('group'));
    });

    // Handle select all checkbox
    $('.select-all-group').on('change', function() {
        const group = $(this).data('group');
        const isChecked = $(this).prop('checked');
        
        $(`.permission-checkbox[data-group="${group}"]`).prop('checked', isChecked);
        updateSelectedCount();
    });

    // Handle individual permission checkboxes
    $('.permission-checkbox').on('change', function() {
        const group = $(this).data('group');
        updateGroupSelectAll(group);
        updateSelectedCount();
    });

    function updateGroupSelectAll(group) {
        const groupCheckboxes = $(`.permission-checkbox[data-group="${group}"]`);
        const checkedCount = groupCheckboxes.filter(':checked').length;
        const selectAllCheckbox = $(`.select-all-group[data-group="${group}"]`);
        
        if (checkedCount === 0) {
            selectAllCheckbox.prop('checked', false);
            selectAllCheckbox.prop('indeterminate', false);
        } else if (checkedCount === groupCheckboxes.length) {
            selectAllCheckbox.prop('checked', true);
            selectAllCheckbox.prop('indeterminate', false);
        } else {
            selectAllCheckbox.prop('checked', false);
            selectAllCheckbox.prop('indeterminate', true);
        }
    }

    function updateSelectedCount() {
        const count = $('.permission-checkbox:checked').length;
        $('#selectedCount').text(count + ' permission' + (count !== 1 ? 's' : '') + ' selected');
    }
});
</script>
@endpush
@endsection
