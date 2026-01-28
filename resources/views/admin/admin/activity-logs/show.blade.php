@extends('layouts.admin')

@section('title', 'Admin Activity Log Details')

@section('content')
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold py-3 mb-2">
                <span class="text-muted fw-light">Admin Management / Admin Activity Logs /</span> Details
            </h4>
        </div>
        <div>
            <a href="{{ route('admin.admin-activity-logs.index') }}" class="btn btn-label-secondary">
                <i class="ti ti-arrow-left me-1"></i> Back to List
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Main Details -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Activity Details</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-3 fw-semibold">Log ID:</div>
                        <div class="col-sm-9"><code>{{ $log->id }}</code></div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3 fw-semibold">Admin:</div>
                        <div class="col-sm-9">
                            @if ($log->admin)
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-2">
                                        @if ($log->admin->avatar)
                                            <img src="{{ asset('storage/' . $log->admin->avatar) }}"
                                                alt="{{ $log->admin->name }}" class="rounded-circle">
                                        @else
                                            <span class="avatar-initial rounded-circle bg-label-primary">
                                                {{ substr($log->admin->name, 0, 1) }}
                                            </span>
                                        @endif
                                    </div>
                                    <div>
                                        <strong>{{ $log->admin->name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $log->admin->email }}</small>
                                    </div>
                                </div>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3 fw-semibold">Action Type:</div>
                        <div class="col-sm-9">
                            @php
                                $actionColors = [
                                    'create' => 'success',
                                    'update' => 'info',
                                    'delete' => 'warning',
                                    'force_delete' => 'danger',
                                    'restore' => 'primary',
                                    'login' => 'success',
                                    'logout' => 'secondary',
                                ];
                                $color = $actionColors[$log->action_type] ?? 'secondary';
                            @endphp
                            <span class="badge bg-{{ $color }}">{{ ucfirst($log->action_type) }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3 fw-semibold">Table Name:</div>
                        <div class="col-sm-9"><code>{{ $log->table_name ?? '-' }}</code></div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3 fw-semibold">Record ID:</div>
                        <div class="col-sm-9">
                            <span class="badge bg-label-secondary">{{ $log->record_id ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3 fw-semibold">Date/Time:</div>
                        <div class="col-sm-9">
                            {{ $log->created_at->format('l, d F Y - H:i:s') }}
                            <br>
                            <small class="text-primary">{{ $log->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Changes -->
            @if ($log->old_values || $log->new_values)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Data Changes</h5>
                    </div>
                    <div class="card-body">
                        @if ($log->old_values)
                            <h6 class="text-muted mb-2">Old Values:</h6>
                            <pre class="bg-light p-3 rounded"><code>{{ json_encode($log->old_values, JSON_PRETTY_PRINT) }}</code></pre>
                        @endif

                        @if ($log->new_values)
                            <h6 class="text-muted mb-2 mt-3">New Values:</h6>
                            <pre class="bg-light p-3 rounded"><code>{{ json_encode($log->new_values, JSON_PRETTY_PRINT) }}</code></pre>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- Request Details -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Request Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted d-block">IP Address</small>
                        <strong>{{ $log->ip_address ?? '-' }}</strong>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block">HTTP Method</small>
                        <span class="badge bg-label-info">{{ $log->method ?? '-' }}</span>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block">URL</small>
                        <small class="text-break">{{ $log->url ?? '-' }}</small>
                    </div>

                    @if ($log->user_agent)
                        <div class="mb-3">
                            <small class="text-muted d-block">User Agent</small>
                            <small class="text-break">{{ $log->user_agent }}</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
