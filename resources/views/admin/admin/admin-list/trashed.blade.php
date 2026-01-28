@extends('layouts.admin')

@section('title', __('admin.admins.trash'))

@section('content')

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
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold py-3 mb-2">
                <span class="text-muted fw-light">{{ __('admin.menu.settings') }} / 
                    <a href="{{ route('admin.admins.index') }}" class="text-muted">{{ __('admin.admins.title') }}</a> /
                </span> {{ __('admin.admins.trash') }}
            </h4>
        </div>
        <div>
            <a href="{{ route('admin.admins.index') }}" class="btn btn-outline-secondary">
                <i class="ti ti-arrow-left me-1"></i> {{ __('admin.admins.back_to_list') }}
            </a>
        </div>
    </div>

    <!-- Trashed Admins Table -->
    <div class="card">
        <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2" style="background: linear-gradient(135deg, rgba(236, 72, 153, 0.1) 0%, rgba(236, 72, 153, 0.05) 100%);">
            <h5 class="mb-0">
                <i class="ti ti-trash me-2" style="color: #ec4899;"></i>
                {{ __('admin.admins.trashed_list') }}
            </h5>
            <div class="text-muted">{{ __('admin.admins.total_trashed', ['count' => $admins->total()]) }}</div>
        </div>

        <!-- Search Filter -->
        <div class="card-body border-bottom mt-4">
            <form action="{{ route('admin.admins.trashed') }}" method="GET" class="row g-3">
                <div class="col-12 col-md-6 col-lg-7">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="ti ti-search"></i>
                        </span>
                        <input type="text" class="form-control" name="search" value="{{ $search ?? '' }}"
                            placeholder="{{ __('admin.admins.search_placeholder') }}">
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3 col-lg-3">
                    <select name="type" class="form-select">
                        <option value="">{{ __('admin.admins.all_types') }}</option>
                        <option value="admin" {{ request('type') === 'admin' ? 'selected' : '' }}>{{ __('admin.admins.admin') }}</option>
                        <option value="superadmin" {{ request('type') === 'superadmin' ? 'selected' : '' }}>{{ __('admin.admins.super_admin') }}</option>
                    </select>
                </div>
                <div class="col-12 col-sm-6 col-md-3 col-lg-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="ti ti-search me-1"></i> {{ __('admin.common.search') }}
                    </button>
                </div>
                @if ((isset($search) && $search) || (isset($type) && $type))
                    <div class="col-12">
                        <a href="{{ route('admin.admins.trashed') }}"
                            class="btn btn-sm btn-outline-secondary">
                            <i class="ti ti-x me-1"></i> {{ __('admin.common.clear_filters') }}
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
                                <th>{{ __('admin.admins.name') }}</th>
                                <th class="d-none d-md-table-cell">{{ __('admin.admins.email') }}</th>
                                <th class="d-none d-lg-table-cell">{{ __('admin.admins.phone') }}</th>
                                <th>{{ __('admin.admins.type') }}</th>
                                <th class="d-none d-sm-table-cell">{{ __('admin.admins.deleted_at') }}</th>
                                <th class="text-center">{{ __('admin.common.actions') }}</th>
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
                                                    <span class="avatar-initial rounded-circle" style="background-color: rgba(236, 72, 153, 0.2); border: none; color: #ec4899; font-weight: 600;">
                                                        {{ strtoupper(substr($admin->name, 0, 2)) }}
                                                    </span>
                                                </div>
                                            @endif
                                            <div>
                                                <strong>{{ $admin->name }}</strong>
                                                <div class="d-md-none small text-muted">{{ $admin->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="d-none d-md-table-cell">{{ $admin->email }}</td>
                                    <td class="d-none d-lg-table-cell">{{ $admin->phone ?? '-' }}</td>
                                    <td>
                                        @if ($admin->type === 'superadmin')
                                            <span class="badge bg-label-danger">
                                                <i class="ti ti-crown me-1 d-none d-sm-inline"></i> {{ __('admin.admins.super_admin') }}
                                            </span>
                                        @else
                                            <span class="badge bg-label-danger">
                                                <i class="ti ti-user me-1 d-none d-sm-inline"></i> {{ __('admin.admins.admin') }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="d-none d-sm-table-cell">
                                        <small>{{ $admin->deleted_at->diffForHumans() }}</small>
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm btn-icon dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a href="javascript:void(0);" class="dropdown-item text-success restore-admin-btn"
                                                    data-admin-id="{{ $admin->id }}"
                                                    data-admin-name="{{ $admin->name }}">
                                                    <i class="ti ti-refresh me-2"></i> {{ __('admin.admins.restore') }}
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <a href="javascript:void(0);" class="dropdown-item text-danger force-delete-admin-btn"
                                                    data-admin-id="{{ $admin->id }}"
                                                    data-admin-name="{{ $admin->name }}">
                                                    <i class="ti ti-trash-x me-2"></i> {{ __('admin.admins.force_delete') }}
                                                </a>
                                            </div>
                                            <form id="restore-form-{{ $admin->id }}" action="{{ route('admin.admins.restore', $admin->id) }}" method="POST" class="d-none">
                                                @csrf
                                                @method('PATCH')
                                            </form>
                                            <form id="force-delete-form-{{ $admin->id }}" action="{{ route('admin.admins.force-delete', $admin->id) }}" method="POST" class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
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
                        <i class="ti ti-trash ti-lg text-muted"></i>
                    </div>
                    <h5 class="text-muted">{{ __('admin.admins.no_trashed_admins') }}</h5>
                    <p class="text-muted">
                        @if (isset($search) || isset($type))
                            {{ __('admin.admins.try_adjusting_filters') }}
                        @else
                            {{ __('admin.admins.trash_empty') }}
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Restore admin confirmation with SweetAlert
    document.querySelectorAll('.restore-admin-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const adminId = this.getAttribute('data-admin-id');
            const adminName = this.getAttribute('data-admin-name');
            
            Swal.fire({
                title: '{{ __('admin.admins.restore_confirm_title') }}',
                html: `<p class="text-muted">{{ __('admin.admins.restore_confirm_text') }} <strong>${adminName}</strong>?</p>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: '<i class="ti ti-refresh me-1"></i> {{ __('admin.admins.yes_restore') }}',
                cancelButtonText: '<i class="ti ti-x me-1"></i> {{ __('admin.common.cancel') }}',
                customClass: {
                    popup: 'swal2-popup-custom',
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-outline-secondary',
                    actions: 'swal2-actions-custom',
                    title: 'swal2-title-custom',
                    htmlContainer: 'swal2-html-custom'
                },
                buttonsStyling: false,
                reverseButtons: true,
                focusCancel: true,
                iconColor: '#28a745'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('restore-form-' + adminId).submit();
                }
            });
        });
    });

    // Force delete admin confirmation with SweetAlert
    document.querySelectorAll('.force-delete-admin-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const adminId = this.getAttribute('data-admin-id');
            const adminName = this.getAttribute('data-admin-name');
            
            Swal.fire({
                title: '{{ __('admin.admins.force_delete_confirm_title') }}',
                html: `<p class="text-muted">{{ __('admin.admins.force_delete_confirm_text') }} <strong>${adminName}</strong>?</p><p class="small text-danger mb-0"><i class="ti ti-alert-triangle me-1"></i> {{ __('admin.admins.force_delete_warning') }}</p>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '<i class="ti ti-trash-x me-1"></i> {{ __('admin.admins.yes_delete_permanently') }}',
                cancelButtonText: '<i class="ti ti-x me-1"></i> {{ __('admin.common.cancel') }}',
                customClass: {
                    popup: 'swal2-popup-custom',
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-outline-secondary',
                    actions: 'swal2-actions-custom',
                    title: 'swal2-title-custom',
                    htmlContainer: 'swal2-html-custom'
                },
                buttonsStyling: false,
                reverseButtons: true,
                focusCancel: true,
                iconColor: '#ec4899'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('force-delete-form-' + adminId).submit();
                }
            });
        });
    });
});
</script>
<style>
    .swal2-popup-custom {
        border-radius: 0.75rem !important;
        padding: 2rem !important;
    }
    .swal2-title-custom {
        color: #384551 !important;
        font-size: 1.375rem !important;
        font-weight: 600 !important;
    }
    .swal2-html-custom {
        color: #697a8d !important;
    }
    .swal2-actions-custom {
        gap: 0.75rem !important;
        margin-top: 1.5rem !important;
    }
    .swal2-icon.swal2-warning {
        border-color: #ec4899 !important;
        color: #ec4899 !important;
    }
    .swal2-icon.swal2-warning .swal2-icon-content {
        color: #ec4899 !important;
    }
</style>
@endpush
