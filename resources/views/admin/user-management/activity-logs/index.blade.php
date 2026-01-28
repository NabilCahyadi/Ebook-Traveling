@extends('layouts.admin')

@section('title', __('admin.activity_logs.title'))

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">{{ __('admin.activity_logs.title') }}</h4>
                <p class="text-muted mb-0">{{ __('admin.activity_logs.description') }}</p>
            </div>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-outline-secondary btn-sm" id="toggleBulkMode"
                    onclick="toggleBulkMode()">
                    <i class="ti ti-checkbox me-1"></i> {{ __('admin.activity_logs.select_multiple') }}
                </button>
                <a href="{{ route('admin.user-activity-logs.export', request()->all()) }}" class="btn btn-outline-primary">
                    <i class="ti ti-download me-1"></i> {{ __('admin.activity_logs.export_csv') }}
                </a>
            </div>
        </div>

        <!-- Bulk Actions Bar -->
        <div id="bulkActionsBar" class="mb-3 p-3 bg-light rounded d-none">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div class="d-flex align-items-center">
                    <span class="me-3"><strong id="selectedCount">0</strong> {{ __('admin.activity_logs.item_selected') }}</span>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <!-- Delete Button -->
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="bulkDelete()">
                        <i class="ti ti-trash me-1"></i> {{ __('admin.activity_logs.delete_selected') }}
                    </button>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.user-activity-logs.index') }}" class="row g-3">
                    <div class="col-md-3">
                        <label for="user_id" class="form-label">{{ __('admin.activity_logs.user') }}</label>
                        <select name="user_id" id="user_id" class="form-select">
                            <option value="">{{ __('admin.activity_logs.all_users') }}</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->roles->first()->name ?? 'No Role' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="action" class="form-label">{{ __('admin.activity_logs.action') }}</label>
                        <select name="action" id="action" class="form-select">
                            @foreach ($actions as $action)
                                <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                    {{ ucfirst($action) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="date_from" class="form-label">{{ __('admin.activity_logs.date_from') }}</label>
                        <input type="date" name="date_from" id="date_from" class="form-control"
                            value="{{ request('date_from') }}">
                    </div>

                    <div class="col-md-2">
                        <label for="date_to" class="form-label">{{ __('admin.activity_logs.date_to') }}</label>
                        <input type="date" name="date_to" id="date_to" class="form-control"
                            value="{{ request('date_to') }}">
                    </div>

                    <div class="col-md-2">
                        <label for="search" class="form-label">{{ __('admin.activity_logs.search') }}</label>
                        <input type="text" name="search" id="search" class="form-control" placeholder="{{ __('admin.activity_logs.search') }}..."
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
                                    <th class="bulk-checkbox-column" style="width: 40px; display: none;">
                                        <input type="checkbox" class="form-check-input" id="selectAll" onclick="toggleSelectAll()">
                                    </th>
                                    <th>{{ __('admin.activity_logs.time') }}</th>
                                    <th>{{ __('admin.activity_logs.user') }}</th>
                                    <th>{{ __('admin.activity_logs.role') }}</th>
                                    <th>{{ __('admin.activity_logs.action') }}</th>
                                    <th>{{ __('admin.activity_logs.url') }}</th>
                                    <th>{{ __('admin.activity_logs.model') }}</th>
                                    <th>{{ __('admin.activity_logs.ip_address') }}</th>
                                    <th>{{ __('admin.actions.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($logs as $log)
                                    <tr>
                                        <td class="py-2 bulk-checkbox-column" style="display: none;">
                                            <input type="checkbox" class="form-check-input log-checkbox" value="{{ $log->id }}"
                                                onchange="updateBulkActions()">
                                        </td>
                                        <td>
                                            @if ($log->created_at)
                                                <small>{{ $log->created_at->format('Y-m-d') }}</small><br>
                                                <small class="text-muted">{{ $log->created_at->format('H:i:s') }}</small>
                                            @else
                                                <small class="text-muted">No date</small>
                                            @endif
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
                                                <span
                                                    class="badge bg-label-info">{{ $log->user->roles->first()->name }}</span>
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
                                                    'restore' => 'warning',
                                                    'force_delete' => 'danger',
                                                ];
                                                $color = $actionColors[$log->action_type] ?? 'secondary';

                                                // Get detailed info from new_values
                                                $detailInfo = '';
                                                if ($log->new_values) {
                                                    $data = $log->new_values;

                                                    // For User actions
                                                    if (isset($data['target_user_name'])) {
                                                        $detailInfo = " → {$data['target_user_name']}";
                                                        if (isset($data['target_user_email'])) {
                                                            $detailInfo .= " ({$data['target_user_email']})";
                                                        }
                                                    }
                                                    // For Role actions
                                                    elseif (isset($data['role_name'])) {
                                                        $detailInfo = " → Role: {$data['role_name']}";
                                                    }
                                                    // For Blog actions
                                                    elseif (isset($data['blog_title'])) {
                                                        $detailInfo = " → Blog: {$data['blog_title']}";
                                                    }
                                                    // For Category actions
                                                    elseif (isset($data['category_name'])) {
                                                        $detailInfo = " → Category: {$data['category_name']}";
                                                    }
                                                    // For Banner actions
                                                    elseif (isset($data['banner_title'])) {
                                                        $detailInfo = " → Banner: {$data['banner_title']}";
                                                    }
                                                    // For Ebook actions
                                                    elseif (isset($data['ebook_title'])) {
                                                        $detailInfo = " → Ebook: {$data['ebook_title']}";
                                                    }
                                                    // For Subscription Plan actions
                                                    elseif (isset($data['plan_name'])) {
                                                        $detailInfo = " → Plan: {$data['plan_name']}";
                                                        if (isset($data['plan_price'])) {
                                                            $detailInfo .=
                                                                ' (Rp ' .
                                                                number_format($data['plan_price'], 0, ',', '.') .
                                                                ')';
                                                        }
                                                    }
                                                }
                                            @endphp
                                            <span
                                                class="badge bg-label-{{ $color }}">{{ ucfirst(str_replace('_', ' ', $log->action_type)) }}</span>
                                            @if ($detailInfo)
                                                <br><small class="text-muted">{{ $detailInfo }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="text-truncate d-inline-block" style="max-width: 300px;"
                                                title="{{ $log->url }}">
                                                {{ $log->url ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($log->table_name)
                                                <small>{{ $log->table_name }}</small>
                                                @if ($log->record_id)
                                                    <br><small class="text-muted">#{{ $log->record_id }}</small>
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

        // Bulk Actions Functions
        let isBulkMode = false;

        window.toggleBulkMode = function () {
            const toggleBtn = document.getElementById('toggleBulkMode');
            isBulkMode = !isBulkMode;

            if (isBulkMode) {
                // Activate bulk mode
                document.querySelectorAll('.bulk-checkbox-column').forEach(el => {
                    el.style.display = '';
                });
                document.getElementById('bulkActionsBar').classList.remove('d-none');
                // Change button style to dark
                toggleBtn.classList.remove('btn-outline-secondary');
                toggleBtn.classList.add('btn-dark');
            } else {
                // Deactivate bulk mode
                clearSelection();
                document.querySelectorAll('.bulk-checkbox-column').forEach(el => {
                    el.style.display = 'none';
                });
                document.getElementById('bulkActionsBar').classList.add('d-none');
                // Change button style back to outline
                toggleBtn.classList.remove('btn-dark');
                toggleBtn.classList.add('btn-outline-secondary');
            }
        }

        window.toggleSelectAll = function () {
            const selectAllCheckbox = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.log-checkbox');
            checkboxes.forEach(cb => cb.checked = selectAllCheckbox.checked);
            updateBulkActions();
        }

        window.updateBulkActions = function () {
            const checkboxes = document.querySelectorAll('.log-checkbox:checked');
            const selectedCount = document.getElementById('selectedCount');
            const selectAllCheckbox = document.getElementById('selectAll');
            const allCheckboxes = document.querySelectorAll('.log-checkbox');

            selectedCount.textContent = checkboxes.length;

            // Update "select all" checkbox state
            selectAllCheckbox.checked = checkboxes.length === allCheckboxes.length && allCheckboxes.length > 0;
            selectAllCheckbox.indeterminate = checkboxes.length > 0 && checkboxes.length < allCheckboxes.length;
        }

        window.getSelectedIds = function () {
            const checkboxes = document.querySelectorAll('.log-checkbox:checked');
            return Array.from(checkboxes).map(cb => cb.value);
        }

        window.clearSelection = function () {
            document.getElementById('selectAll').checked = false;
            document.querySelectorAll('.log-checkbox').forEach(cb => cb.checked = false);
            updateBulkActions();
        }

        window.bulkDelete = function () {
            const ids = getSelectedIds();
            if (ids.length === 0) {
                if (confirm('{{ __('admin.common.please_select') }}')) {
                    return;
                }
                return;
            }

            const message = '{{ __("admin.activity_logs.bulk_delete_confirm", ["count" => ":count"]) }}'.replace(':count', ids.length);
            if (confirm(message)) {
                const form = document.getElementById('bulkDeleteForm');

                const idsContainer = document.getElementById('bulkDeleteIds');
                idsContainer.innerHTML = '';
                ids.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'ids[]';
                    input.value = id;
                    idsContainer.appendChild(input);
                });

                form.submit();
            }
        }
    </script>
@endpush

<!-- Hidden form for bulk delete -->
<form id="bulkDeleteForm" action="{{ route('admin.user-activity-logs.bulk-delete') }}" method="POST" style="display: none;">
    @csrf
    <div id="bulkDeleteIds"></div>
</form>
