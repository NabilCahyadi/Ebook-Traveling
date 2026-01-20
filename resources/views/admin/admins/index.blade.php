@extends('layouts.admin')

@section('title', __('admin.admins.title'))

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
                <span class="text-muted fw-light">{{ __('admin.menu.settings') }} /</span> {{ __('admin.admins.title') }}
            </h4>
        </div>
        <div>
            <a href="{{ route('admin.admins.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i> {{ __('admin.admins.add_admin') }}
            </a>
        </div>
    </div>

    <!-- Admins Table -->
    <div class="card">
        <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
            <h5 class="mb-0">{{ __('admin.admins.list') }}</h5>
            <div class="d-flex gap-2 align-items-center">
                <a href="{{ route('admin.admins.export', request()->all()) }}" class="btn btn-success btn-sm">
                    <i class="ti ti-download me-1"></i>
                    {{ __('admin.common.export') }}
                </a>
                <div class="text-muted">{{ __('admin.admins.total_admins', ['count' => $admins->total()]) }}</div>
            </div>
        </div>

        <!-- Search Filter -->
        <div class="card-body border-bottom">
            <form action="{{ route('admin.admins.index') }}" method="GET" class="row g-3">
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
                        <a href="{{ route('admin.admins.index') }}"
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
                                <th class="d-none d-sm-table-cell">{{ __('admin.admins.status') }}</th>
                                <th class="d-none d-lg-table-cell">{{ __('admin.admins.last_login') }}</th>
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
                                        @if ($admin->status === 'active')
                                            <span class="badge bg-label-success">{{ __('admin.admins.active') }}</span>
                                        @else
                                            <span class="badge bg-label-secondary">{{ __('admin.admins.inactive') }}</span>
                                        @endif
                                    </td>
                                    <td class="d-none d-lg-table-cell">
                                        @if ($admin->last_login_at)
                                            <small>{{ $admin->last_login_at->diffForHumans() }}</small>
                                        @else
                                            <small class="text-muted">{{ __('admin.admins.never_logged_in') }}</small>
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
                                                    <i class="ti ti-eye me-2"></i> {{ __('admin.common.detail') }}
                                                </a>
                                                <a class="dropdown-item" href="{{ route('admin.admins.edit', $admin->id) }}">
                                                    <i class="ti ti-edit me-2"></i> {{ __('admin.common.edit') }}
                                                </a>
                                                @if ($admin->type !== 'superadmin')
                                                    <a class="dropdown-item" href="{{ route('admin.admins.permissions.edit', $admin->id) }}">
                                                        <i class="ti ti-shield-lock me-2"></i> {{ __('admin.admins.manage_permissions') }}
                                                    </a>
                                                @endif
                                                @if (auth('admin')->id() !== $admin->id)
                                                    <div class="dropdown-divider"></div>
                                                    <form action="{{ route('admin.admins.destroy', $admin->id) }}" method="POST"
                                                        onsubmit="return confirm('{{ __('admin.admins.confirm_delete') }}')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="ti ti-trash me-2"></i> {{ __('admin.common.delete') }}
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
                    <h5 class="text-muted">{{ __('admin.admins.no_admins_found') }}</h5>
                    <p class="text-muted">
                        @if (isset($search) || isset($type))
                            {{ __('admin.admins.try_adjusting_filters') }}
                        @else
                            {{ __('admin.admins.no_admins_yet') }}
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>

@endsection
