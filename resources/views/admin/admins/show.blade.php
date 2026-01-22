@extends('layouts.admin')

@section('title', __('admin.admins.admin_detail'))

@section('content')

    <!-- Page Header -->
    <div class="mb-4">
        <h4 class="fw-bold py-3 mb-2">
            <span class="text-muted fw-light">
                <a href="{{ route('admin.admins.index') }}" class="text-muted">{{ __('admin.admins.title') }}</a> /
            </span> 
            {{ __('admin.admins.admin_detail') }}
        </h4>
    </div>

    <div class="row">
        <!-- Profile Card -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body text-center py-5">
                    <div class="mb-3">
                        @if ($admin->avatar)
                            <img src="{{ Storage::url($admin->avatar) }}" alt="{{ $admin->name }}"
                                class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">
                        @else
                            <div style="width: 120px; height: 120px; margin: 0 auto; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <span style="font-size: 2.5rem; font-weight: 600; color: white;">
                                    {{ getInitials($admin->name) }}
                                </span>
                            </div>
                        @endif
                    </div>
                    <h5 class="mb-2">{{ $admin->name }}</h5>
                    <p class="text-muted mb-3">{{ $admin->email }}</p>
                    @if ($admin->type === 'superadmin')
                        <span class="badge bg-label-danger">
                            <i class="ti ti-crown me-1"></i> {{ __('admin.admins.super_admin') }}
                        </span>
                    @else
                        <span class="badge bg-label-primary">
                            <i class="ti ti-user me-1"></i> {{ __('admin.admins.admin') }}
                        </span>
                    @endif
                </div>
            </div>

            <!-- Statistik Card -->
            <div class="card mt-3">
                <div class="card-body">
                    <h6 class="mb-4">
                        <i class="ti ti-info-circle me-2"></i> {{ __('admin.admins.statistics') }}
                    </h6>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">{{ __('admin.admins.account_status') }}:</span>
                        @if ($admin->status === 'active')
                            <span class="badge bg-success">{{ __('admin.admins.active') }}</span>
                        @else
                            <span class="badge bg-secondary">{{ __('admin.admins.inactive') }}</span>
                        @endif
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">{{ __('admin.admins.type') }}:</span>
                        <strong>{{ $admin->type === 'superadmin' ? __('admin.admins.super_admin') : __('admin.admins.admin') }}</strong>
                    </div>
                    @if($admin->last_login_at)
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">{{ __('admin.admins.last_activity') }}:</span>
                        <small class="text-end">{{ $admin->last_login_at->diffForHumans() }}</small>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Information Card -->
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('admin.admins.admin_info') }}</h5>
                    <div>
                        <a href="{{ route('admin.admins.edit', $admin->id) }}" class="btn btn-sm btn-primary">
                            <i class="ti ti-edit me-1"></i> {{ __('admin.admins.edit') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td class="text-muted" style="width: 200px;">{{ __('admin.admins.full_name') }}</td>
                                    <td class="fw-medium">{{ $admin->name }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">{{ __('admin.admins.email') }}</td>
                                    <td class="fw-medium">{{ $admin->email }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">{{ __('admin.admins.phone_number') }}</td>
                                    <td class="fw-medium">{{ $admin->phone ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">{{ __('admin.admins.admin_type') }}</td>
                                    <td>
                                        @if ($admin->type === 'superadmin')
                                            <span class="badge bg-label-danger">
                                                <i class="ti ti-crown me-1"></i> {{ __('admin.admins.super_admin') }}
                                            </span>
                                        @else
                                            <span class="badge bg-label-primary">
                                                <i class="ti ti-user me-1"></i> {{ __('admin.admins.admin') }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">{{ __('admin.admins.status') }}</td>
                                    <td>
                                        @if ($admin->status === 'active')
                                            <span class="badge bg-label-success">{{ __('admin.admins.active') }}</span>
                                        @else
                                            <span class="badge bg-label-secondary">{{ __('admin.admins.inactive') }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">{{ __('admin.admins.date_created') }}</td>
                                    <td>
                                        {{ $admin->created_at->format('d F Y, H:i') }}
                                        <small class="text-muted d-block">({{ $admin->created_at->diffForHumans() }})</small>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">{{ __('admin.admins.last_updated') }}</td>
                                    <td>
                                        {{ $admin->updated_at->format('d F Y, H:i') }}
                                        <small class="text-muted d-block">({{ $admin->updated_at->diffForHumans() }})</small>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">{{ __('admin.admins.last_login') }}</td>
                                    <td>
                                        @if ($admin->last_login_at)
                                            {{ $admin->last_login_at->format('d F Y, H:i') }}
                                            <small class="text-muted d-block">({{ $admin->last_login_at->diffForHumans() }})</small>
                                        @else
                                            <span class="text-muted">{{ __('admin.admins.never_logged_in') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.admins.index') }}" class="btn btn-outline-secondary">
                            <i class="ti ti-arrow-left me-1"></i> {{ __('admin.admins.back') }}
                        </a>
                        @if (auth('admin')->id() !== $admin->id)
                            <form action="{{ route('admin.admins.destroy', $admin->id) }}" method="POST"
                                onsubmit="return confirm('{{ __('admin.admins.confirm_delete') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="ti ti-trash me-1"></i> {{ __('admin.admins.delete_admin') }}
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
