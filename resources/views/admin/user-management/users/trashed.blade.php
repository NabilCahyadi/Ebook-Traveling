@extends('layouts.admin')

@section('title', __('admin.users.trashed_users'))

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
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold py-3 mb-2">
                <span class="text-muted fw-light">{{ __('admin.menu.dashboard') }} / {{ __('admin.menu.user_management') }} /</span>
                <span class="text-danger">{{ __('admin.users.trashed_users') }}</span>
            </h4>
            <p class="text-muted mb-0">{{ __('admin.users.trashed_description') }}</p>
        </div>
        <div>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="ti ti-arrow-left me-1"></i> {{ __('admin.users.back_to_active') }}
            </a>
        </div>
    </div>

    <!-- Trashed Users Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-danger">
                <i class="ti ti-trash me-1"></i>
                {{ __('admin.users.trashed_users') }}
            </h5>
            <div class="text-muted">Total: {{ $users->total() }} {{ __('admin.users.users') }}</div>
        </div>

        <!-- Search Filter -->
        <div class="card-body border-bottom">
            <form action="{{ route('admin.users.trashed') }}" method="GET" class="row g-3">
                <div class="col-md-10">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="ti ti-search"></i>
                        </span>
                        <input type="text" class="form-control" name="search" value="{{ $search ?? '' }}"
                            placeholder="{{ __('admin.users.search_placeholder') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="ti ti-search me-1"></i> {{ __('admin.actions.search') }}
                    </button>
                </div>
                @if (isset($search) && $search)
                    <div class="col-12">
                        <a href="{{ route('admin.users.trashed') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="ti ti-x me-1"></i> {{ __('admin.common.clear') }} {{ __('admin.common.filter') }}
                        </a>
                        <span class="text-muted ms-2">{{ __('admin.users.showing_results_for') }}: <strong>"{{ $search }}"</strong></span>
                    </div>
                @endif
            </form>
        </div>

        <div class="card-body">
            @if ($users->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>{{ __('admin.users.name') }}</th>
                                <th>{{ __('admin.users.email') }}</th>
                                <th>{{ __('admin.users.role') }}</th>
                                <th>{{ __('admin.users.deleted_at') }}</th>
                                <th>{{ __('admin.users.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="table-danger">
                                    <td>
                                        <strong>#{{ $user->id }}</strong>
                                        <span class="badge bg-label-danger ms-1">{{ __('admin.users.deleted') }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-2">
                                                <span class="avatar-initial rounded-circle bg-label-danger">
                                                    {{ substr($user->name, 0, 1) }}
                                                </span>
                                            </div>
                                            <div>
                                                <div class="fw-medium">
                                                    {{ $user->name }}
                                                    <i class="ti ti-trash text-danger ms-1" title="{{ __('admin.users.deleted') }}"></i>
                                                </div>
                                                @if ($user->id === auth()->id())
                                                    <small class="badge bg-label-warning">
                                                        <i class="ti ti-star ti-xs"></i> {{ __('admin.users.you') }}
                                                    </small>
                                                @elseif($user->email_verified_at)
                                                    <small class="text-success">
                                                        <i class="ti ti-check ti-xs"></i> {{ __('admin.users.verified') }}
                                                    </small>
                                                @else
                                                    <small class="text-muted">
                                                        <i class="ti ti-x ti-xs"></i> {{ __('admin.users.not_verified') }}
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <div class="fw-medium">{{ $user->email }}</div>
                                            @if ($user->phone)
                                                <small class="text-muted">{{ $user->phone }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if ($user->roles && $user->roles->count() > 0)
                                            @foreach ($user->roles as $role)
                                                <span class="badge bg-label-secondary mb-1">{{ $role->name }}</span>
                                            @endforeach
                                        @else
                                            <span class="badge bg-label-secondary">{{ __('admin.users.role') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-danger">
                                            {{ $user->deleted_at->format('d M Y') }}<br>
                                            {{ $user->deleted_at->format('H:i') }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button"
                                                class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item text-success" href="javascript:void(0);"
                                                    onclick="event.preventDefault(); if(confirm('{{ __('admin.users.confirm_restore') }}')) document.getElementById('restore-form-{{ $user->id }}').submit();">
                                                    <i class="ti ti-restore me-2"></i>
                                                    <span>{{ __('admin.actions.restore') }}</span>
                                                </a>
                                                <form id="restore-form-{{ $user->id }}"
                                                    action="{{ route('admin.users.restore', $user->id) }}" method="POST"
                                                    style="display: none;">
                                                    @csrf
                                                    @method('PATCH')
                                                </form>
                                                @if ($user->id !== auth()->id())
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item text-danger" href="javascript:void(0);"
                                                        onclick="event.preventDefault(); if(confirm('{{ __('admin.users.confirm_force_delete') }}')) document.getElementById('force-delete-form-{{ $user->id }}').submit();">
                                                        <i class="ti ti-trash-x me-2"></i>
                                                        <span>{{ __('admin.users.delete_permanently') }}</span>
                                                    </a>
                                                    <form id="force-delete-form-{{ $user->id }}"
                                                        action="{{ route('admin.users.force-delete', $user->id) }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
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
                    {{ $users->appends(['search' => $search])->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="ti ti-trash-off ti-xl text-muted mb-3" style="font-size: 3rem;"></i>
                    <h6 class="text-muted">{{ __('admin.users.no_users_found') }}</h6>
                    <p class="text-muted mb-0">
                        @if (isset($search) && $search)
                            {{ __('admin.users.no_deleted_users_search') }}
                        @else
                            {{ __('admin.users.no_deleted_users_yet') }}
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>
@endsection
