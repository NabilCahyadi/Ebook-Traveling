@extends('layouts.admin')

@section('title', 'User Activity Logs')

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">User Activity Logs</h4>
                <p class="text-muted mb-0">Monitor user activities (excluding admin)</p>
            </div>
            <div>
                <a href="{{ route('admin.user-activity-logs.export', request()->all()) }}" class="btn btn-outline-primary">
                    <i class="ti ti-download me-1"></i> Export CSV
                </a>
            </div>
        </div>

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.user-activity-logs.index') }}" class="row g-3">
                    <div class="col-md-3">
                        <label for="user_id" class="form-label">User</label>
                        <select name="user_id" id="user_id" class="form-select">
                            <option value="">All Users</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->roles->first()->name ?? 'No Role' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="action" class="form-label">Action</label>
                        <select name="action" id="action" class="form-select">
                            @foreach ($actions as $action)
                                <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                    {{ ucfirst($action) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="date_from" class="form-label">Date From</label>
                        <input type="date" name="date_from" id="date_from" class="form-control"
                            value="{{ request('date_from') }}">
                    </div>

                    <div class="col-md-2">
                        <label for="date_to" class="form-label">Date To</label>
                        <input type="date" name="date_to" id="date_to" class="form-control"
                            value="{{ request('date_to') }}">
                    </div>

                    <div class="col-md-2">
                        <label for="search" class="form-label">Search</label>
                        <input type="text" name="search" id="search" class="form-control" placeholder="Search..."
                            value="{{ request('search') }}">
                    </div>

                    <div class="col-md-1 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="ti ti-filter"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Activity Logs Table -->
        <div class="card">
            <div class="card-body">
                @if ($logs->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>User</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                    <th>Description</th>
                                    <th>Model</th>
                                    <th>IP Address</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($logs as $log)
                                    <tr>
                                        <td>
                                            <small>{{ $log->created_at->format('Y-m-d') }}</small><br>
                                            <small class="text-muted">{{ $log->created_at->format('H:i:s') }}</small>
                                        </td>
                                        <td>
                                            @if ($log->user)
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-xs me-2">
                                                        <span class="avatar-initial rounded-circle bg-label-primary">
                                                            {{ substr($log->user->name, 0, 1) }}
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <div class="fw-medium">{{ $log->user->name }}</div>
                                                        <small class="text-muted">{{ $log->user->email }}</small>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-muted">System</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($log->user && $log->user->roles->isNotEmpty())
                                                <span class="badge bg-label-info">{{ $log->user->roles->first()->name }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
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
                                            <span
                                                class="badge bg-label-{{ $color }}">{{ ucfirst($log->action) }}</span>
                                        </td>
                                        <td>
                                            <span class="text-truncate d-inline-block" style="max-width: 300px;"
                                                title="{{ $log->description }}">
                                                {{ $log->description }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($log->model_type)
                                                <small>{{ class_basename($log->model_type) }}</small>
                                                @if ($log->model_id)
                                                    <br><small class="text-muted">#{{ $log->model_id }}</small>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ $log->ip_address ?? '-' }}</small>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.user-activity-logs.show', $log->id) }}"
                                                class="btn btn-sm btn-icon btn-text-secondary rounded-pill"
                                                title="View Details">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $logs->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="ti ti-activity-off ti-xl text-muted mb-3 d-block" style="font-size: 3rem;"></i>
                        <h6 class="text-muted">No activity logs found</h6>
                        <p class="text-muted mb-0">
                            @if (request()->hasAny(['user_id', 'action', 'date_from', 'date_to', 'search']))
                                Try adjusting your filters
                            @else
                                No user activities have been logged yet
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Auto-submit on filter change (optional)
        document.querySelectorAll('#user_id, #action').forEach(function(element) {
            element.addEventListener('change', function() {
                this.form.submit();
            });
        });
    </script>
@endpush
