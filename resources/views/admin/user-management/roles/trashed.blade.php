@extends('layouts.admin')

@section('title', 'Trashed Roles')

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
                <span class="text-muted fw-light">{{ __('admin.menu.admin') }} / <a href="{{ route('admin.roles.index') }}">{{ __('admin.roles.title') }}</a> /</span> 
                <span class="text-danger">Trash</span>
            </h4>
        </div>
        <div>
            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                <i class="ti ti-arrow-left me-1"></i> Back to Active Roles
            </a>
        </div>
    </div>

    <!-- Trashed Roles Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="ti ti-trash me-2"></i>Trashed Roles</h5>
            <div class="text-muted">Total: {{ $roles->total() }} trashed roles</div>
        </div>
        <div class="card-body">
            @if ($roles->count() > 0)
                <div class="alert alert-warning" role="alert">
                    <i class="ti ti-alert-triangle me-2"></i>
                    <strong>Warning:</strong> These roles have been moved to trash. You can restore or permanently delete them.
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('admin.form.name') }}</th>
                                <th>{{ __('admin.form.slug') }}</th>
                                <th>{{ __('admin.form.description') }}</th>
                                <th>Deleted At</th>
                                <th>{{ __('admin.ebooks.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-2 bg-label-danger">
                                                <span class="avatar-initial rounded-circle">
                                                    <i class="ti ti-shield-off"></i>
                                                </span>
                                            </div>
                                            <strong class="text-muted">{{ $role->name }}</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <code class="text-muted">{{ $role->slug }}</code>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $role->description ?? '-' }}</small>
                                    </td>
                                    <td>
                                        <small class="text-danger">
                                            <i class="ti ti-calendar-x me-1"></i>
                                            {{ $role->deleted_at->format('d M Y H:i') }}
                                        </small>
                                        <br>
                                        <small class="text-muted">{{ $role->deleted_at->diffForHumans() }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <!-- Restore Button -->
                                            <button type="button" class="btn btn-sm btn-success" 
                                                onclick="if(confirm('Are you sure you want to restore this role?')) document.getElementById('restore-form-{{ $role->id }}').submit();">
                                                <i class="ti ti-restore me-1"></i> Restore
                                            </button>
                                            <form id="restore-form-{{ $role->id }}"
                                                action="{{ route('admin.roles.restore', $role->id) }}"
                                                method="POST" style="display: none;">
                                                @csrf
                                                @method('PATCH')
                                            </form>

                                            <!-- Permanent Delete Button -->
                                            <button type="button" class="btn btn-sm btn-danger" 
                                                onclick="if(confirm('Are you sure you want to PERMANENTLY delete this role? This action cannot be undone!')) document.getElementById('force-delete-form-{{ $role->id }}').submit();">
                                                <i class="ti ti-trash-x me-1"></i> Delete Forever
                                            </button>
                                            <form id="force-delete-form-{{ $role->id }}"
                                                action="{{ route('admin.roles.force-delete', $role->id) }}"
                                                method="POST" style="display: none;">
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
                    {{ $roles->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="ti ti-trash-off ti-xl text-muted mb-3"></i>
                    <h5 class="text-muted">Trash is empty</h5>
                    <p class="text-muted">No roles in trash.</p>
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-primary mt-3">
                        <i class="ti ti-arrow-left me-1"></i> Back to Roles
                    </a>
                </div>
            @endif
        </div>
    </div>

@endsection

@push('styles')
<style>
    .text-muted code {
        color: #a8b1bb !important;
    }
</style>
@endpush
