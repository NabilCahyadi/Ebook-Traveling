@extends('layouts.admin')

@section('title', 'Activity Log Detail')

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">Activity Log Detail</h4>
                <p class="text-muted mb-0">Detailed information about user activity</p>
            </div>
            <a href="{{ route('admin.user-activity-logs.index') }}" class="btn btn-outline-secondary">
                <i class="ti ti-arrow-left me-1"></i> Back to List
            </a>
        </div>

        <div class="row">
            <!-- Main Info -->
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Activity Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-3 fw-medium">Action:</div>
                            <div class="col-sm-9">
                                @php
                                    $actionColors = [
                                        'create' => 'success',
                                        'update' => 'info',
                                        'delete' => 'danger',
                                        'login' => 'primary',
                                        'logout' => 'secondary',
                                        'view' => 'info',
                                        'download' => 'warning',
                                    ];
                                    $color = $actionColors[$log->action] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $color }}">{{ ucfirst($log->action_type) }}</span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-3 fw-medium">URL:</div>
                            <div class="col-sm-9">{{ $log->url ?? 'N/A' }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-3 fw-medium">Table Name:</div>
                            <div class="col-sm-9">
                                @if ($log->table_name)
                                    <code>{{ $log->table_name }}</code>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-3 fw-medium">Record ID:</div>
                            <div class="col-sm-9">
                                @if ($log->record_id)
                                    <code>#{{ $log->record_id }}</code>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-3 fw-medium">IP Address:</div>
                            <div class="col-sm-9">
                                <code>{{ $log->ip_address ?? 'N/A' }}</code>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-3 fw-medium">User Agent:</div>
                            <div class="col-sm-9">
                                <small class="text-muted">{{ $log->user_agent ?? 'N/A' }}</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-3 fw-medium">Timestamp:</div>
                            <div class="col-sm-9">
                                @if($log->created_at)
                                    {{ $log->created_at->format('d M Y, H:i:s') }}
                                    <small class="text-muted">({{ $log->created_at->diffForHumans() }})</small>
                                @else
                                    <span class="text-muted">No timestamp</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Data -->
                @if ($log->data)
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Additional Data</h5>
                        </div>
                        <div class="card-body">
                            <pre class="bg-light p-3 rounded"><code>{{ json_encode(json_decode($log->data), JSON_PRETTY_PRINT) }}</code></pre>
                        </div>
                    </div>
                @endif
            </div>

            <!-- User Info Sidebar -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">User Information</h5>
                    </div>
                    <div class="card-body">
                        @if ($log->user)
                            <div class="text-center mb-4">
                                <div class="avatar avatar-xl mb-3">
                                    <span class="avatar-initial rounded-circle bg-label-primary" style="font-size: 2rem;">
                                        {{ substr($log->user->name, 0, 1) }}
                                    </span>
                                </div>
                                <h5 class="mb-1">{{ $log->user->name }}</h5>
                                <p class="text-muted mb-0">{{ $log->user->email }}</p>
                            </div>

                            <hr>

                            <div class="mb-3">
                                <small class="text-muted d-block mb-1">Role</small>
                                @if ($log->user->roles->isNotEmpty())
                                    <span class="badge bg-label-info">{{ $log->user->roles->first()->name }}</span>
                                @else
                                    <span class="text-muted">No role assigned</span>
                                @endif
                            </div>

                            <div class="mb-3">
                                <small class="text-muted d-block mb-1">User ID</small>
                                <code>#{{ $log->user->id }}</code>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted d-block mb-1">Account Status</small>
                                @if ($log->user->is_active ?? true)
                                    <span class="badge bg-label-success">Active</span>
                                @else
                                    <span class="badge bg-label-danger">Inactive</span>
                                @endif
                            </div>

                            <div class="mb-3">
                                <small class="text-muted d-block mb-1">Registered</small>
                                {{ $log->user->created_at->format('d M Y') }}
                            </div>

                            <hr>

                            <a href="{{ route('admin.users.show', $log->user->id) }}" class="btn btn-primary w-100">
                                <i class="ti ti-user me-1"></i> View User Profile
                            </a>
                        @else
                            <div class="text-center py-4">
                                <i class="ti ti-user-off ti-lg text-muted mb-2"></i>
                                <p class="text-muted mb-0">User information not available</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
