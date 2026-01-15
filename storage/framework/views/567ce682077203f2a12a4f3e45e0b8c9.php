<?php $__env->startSection('title', 'Admin Activity Logs'); ?>

<?php $__env->startSection('content'); ?>
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold py-3 mb-2">
                <span class="text-muted fw-light">Admin Management /</span> Admin Activity Logs
            </h4>
        </div>
        <div>
            <button type="button" class="btn btn-outline-danger me-2" data-bs-toggle="modal"
                data-bs-target="#cleanupModal">
                <i class="ti ti-trash me-1"></i> Cleanup Old Logs
            </button>
            <button type="button" class="btn btn-success" onclick="exportLogs()">
                <i class="ti ti-download me-1"></i> Export CSV
            </button>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('admin.admin-activity-logs.index')); ?>" id="filterForm">
                <div class="row g-3">
                    <!-- Admin Filter -->
                    <div class="col-md-3">
                        <label class="form-label">Admin</label>
                        <select name="admin_id" class="form-select">
                            <option value="">All Admins</option>
                            <?php $__currentLoopData = $admins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($admin->id); ?>"
                                    <?php echo e(request('admin_id') == $admin->id ? 'selected' : ''); ?>>
                                    <?php echo e($admin->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- Action Filter -->
                    <div class="col-md-2">
                        <label class="form-label">Action</label>
                        <select name="action" class="form-select">
                            <?php $__currentLoopData = $actions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($action); ?>" <?php echo e(request('action') == $action ? 'selected' : ''); ?>>
                                    <?php echo e(ucfirst($action)); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- Table Filter -->
                    <div class="col-md-2">
                        <label class="form-label">Table</label>
                        <select name="table" class="form-select">
                            <option value="all">All Tables</option>
                            <?php $__currentLoopData = $tables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $table): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($table); ?>" <?php echo e(request('table') == $table ? 'selected' : ''); ?>>
                                    <?php echo e($table); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- Date From -->
                    <div class="col-md-2">
                        <label class="form-label">From Date</label>
                        <input type="date" name="date_from" class="form-control" value="<?php echo e(request('date_from')); ?>">
                    </div>

                    <!-- Date To -->
                    <div class="col-md-2">
                        <label class="form-label">To Date</label>
                        <input type="date" name="date_to" class="form-control" value="<?php echo e(request('date_to')); ?>">
                    </div>

                    <!-- Search -->
                    <div class="col-md-3">
                        <label class="form-label">Search</label>
                        <input type="text" name="search" class="form-control" placeholder="Search..."
                            value="<?php echo e(request('search')); ?>">
                    </div>

                    <!-- Buttons -->
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="ti ti-filter me-1"></i> Filter
                        </button>
                        <a href="<?php echo e(route('admin.admin-activity-logs.index')); ?>" class="btn btn-label-secondary">
                            <i class="ti ti-x me-1"></i> Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Activity Logs Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Activity Logs</h5>
            <div class="text-muted">Total: <?php echo e($logs->total()); ?> logs</div>
        </div>
        <div class="card-body">
            <?php if($logs->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Admin</th>
                                <th>Action</th>
                                <th>Table</th>
                                <th>Record ID</th>
                                <th>IP Address</th>
                                <th>Date/Time</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-2">
                                                <?php if($log->admin && $log->admin->avatar): ?>
                                                    <img src="<?php echo e(asset('storage/' . $log->admin->avatar)); ?>"
                                                        alt="<?php echo e($log->admin->name); ?>" class="rounded-circle">
                                                <?php else: ?>
                                                    <span class="avatar-initial rounded-circle bg-label-primary">
                                                        <?php echo e(substr($log->admin->name ?? 'A', 0, 1)); ?>

                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <div>
                                                <strong><?php echo e($log->admin->name ?? 'Unknown'); ?></strong>
                                                <br>
                                                <small class="text-muted"><?php echo e($log->admin->email ?? 'N/A'); ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <?php
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
                                        ?>
                                        <span class="badge bg-label-<?php echo e($color); ?>">
                                            <?php echo e(ucfirst($log->action_type)); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <code><?php echo e($log->table_name ?? '-'); ?></code>
                                    </td>
                                    <td>
                                        <span class="badge bg-label-secondary"><?php echo e($log->record_id ?? '-'); ?></span>
                                    </td>
                                    <td>
                                        <small class="text-muted"><?php echo e($log->ip_address ?? '-'); ?></small>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <?php echo e($log->created_at->format('d M Y, H:i')); ?>

                                            <br>
                                            <span class="text-primary"><?php echo e($log->created_at->diffForHumans()); ?></span>
                                        </small>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('admin.admin-activity-logs.show', $log->id)); ?>"
                                            class="btn btn-sm btn-icon btn-text-secondary rounded-pill"
                                            data-bs-toggle="tooltip" title="View Details">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    <?php echo e($logs->links()); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="ti ti-activity-off ti-xl text-muted mb-3"></i>
                    <h5 class="text-muted">No activity logs found</h5>
                    <p class="text-muted">No admin activities have been recorded yet or try adjusting your filters.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Cleanup Modal -->
    <div class="modal fade" id="cleanupModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cleanup Old Logs</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo e(route('admin.admin-activity-logs.cleanup')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <i class="ti ti-alert-triangle me-2"></i>
                            <strong>Warning!</strong> This action will permanently delete old activity logs.
                        </div>
                        <div class="mb-3">
                            <label for="days" class="form-label">Delete logs older than (days) <span
                                    class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="days" name="days" min="1"
                                max="365" value="90" required>
                            <small class="text-muted">Recommended: 90 days</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete Old Logs</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        function exportLogs() {
            // Get current filter parameters
            const form = document.getElementById('filterForm');
            const formData = new FormData(form);
            const params = new URLSearchParams(formData).toString();

            // Redirect to export URL with parameters
            window.location.href = '<?php echo e(route('admin.admin-activity-logs.export')); ?>?' + params;
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views/admin/admin-activity-logs/index.blade.php ENDPATH**/ ?>