<?php $__env->startSection('title', 'User Activity Logs'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">User Activity Logs</h4>
                <p class="text-muted mb-0">Monitor user activities (excluding admin)</p>
            </div>
            <div>
                <a href="<?php echo e(route('admin.user-activity-logs.export', request()->all())); ?>" class="btn btn-outline-primary">
                    <i class="ti ti-download me-1"></i> Export CSV
                </a>
            </div>
        </div>

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="<?php echo e(route('admin.user-activity-logs.index')); ?>" class="row g-3">
                    <div class="col-md-3">
                        <label for="user_id" class="form-label">User</label>
                        <select name="user_id" id="user_id" class="form-select">
                            <option value="">All Users</option>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($user->id); ?>" <?php echo e(request('user_id') == $user->id ? 'selected' : ''); ?>>
                                    <?php echo e($user->name); ?> (<?php echo e($user->roles->first()->name ?? 'No Role'); ?>)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="action" class="form-label">Action</label>
                        <select name="action" id="action" class="form-select">
                            <?php $__currentLoopData = $actions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($action); ?>" <?php echo e(request('action') == $action ? 'selected' : ''); ?>>
                                    <?php echo e(ucfirst($action)); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="date_from" class="form-label">Date From</label>
                        <input type="date" name="date_from" id="date_from" class="form-control"
                            value="<?php echo e(request('date_from')); ?>">
                    </div>

                    <div class="col-md-2">
                        <label for="date_to" class="form-label">Date To</label>
                        <input type="date" name="date_to" id="date_to" class="form-control"
                            value="<?php echo e(request('date_to')); ?>">
                    </div>

                    <div class="col-md-2">
                        <label for="search" class="form-label">Search</label>
                        <input type="text" name="search" id="search" class="form-control" placeholder="Search..."
                            value="<?php echo e(request('search')); ?>">
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
                <?php if($logs->count() > 0): ?>
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
                                <?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <small><?php echo e($log->created_at->format('Y-m-d')); ?></small><br>
                                            <small class="text-muted"><?php echo e($log->created_at->format('H:i:s')); ?></small>
                                        </td>
                                        <td>
                                            <?php if($log->user): ?>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-xs me-2">
                                                        <span class="avatar-initial rounded-circle bg-label-primary">
                                                            <?php echo e(substr($log->user->name, 0, 1)); ?>

                                                        </span>
                                                    </div>
                                                    <div>
                                                        <div class="fw-medium"><?php echo e($log->user->name); ?></div>
                                                        <small class="text-muted"><?php echo e($log->user->email); ?></small>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <span class="text-muted">System</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($log->user && $log->user->roles->isNotEmpty()): ?>
                                                <span class="badge bg-label-info"><?php echo e($log->user->roles->first()->name); ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php
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
                                            ?>
                                            <span
                                                class="badge bg-label-<?php echo e($color); ?>"><?php echo e(ucfirst($log->action)); ?></span>
                                        </td>
                                        <td>
                                            <span class="text-truncate d-inline-block" style="max-width: 300px;"
                                                title="<?php echo e($log->description); ?>">
                                                <?php echo e($log->description); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <?php if($log->model_type): ?>
                                                <small><?php echo e(class_basename($log->model_type)); ?></small>
                                                <?php if($log->model_id): ?>
                                                    <br><small class="text-muted">#<?php echo e($log->model_id); ?></small>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <small class="text-muted"><?php echo e($log->ip_address ?? '-'); ?></small>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route('admin.user-activity-logs.show', $log->id)); ?>"
                                                class="btn btn-sm btn-icon btn-text-secondary rounded-pill"
                                                title="View Details">
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
                        <i class="ti ti-activity-off ti-xl text-muted mb-3 d-block" style="font-size: 3rem;"></i>
                        <h6 class="text-muted">No activity logs found</h6>
                        <p class="text-muted mb-0">
                            <?php if(request()->hasAny(['user_id', 'action', 'date_from', 'date_to', 'search'])): ?>
                                Try adjusting your filters
                            <?php else: ?>
                                No user activities have been logged yet
                            <?php endif; ?>
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        // Auto-submit on filter change (optional)
        document.querySelectorAll('#user_id, #action').forEach(function(element) {
            element.addEventListener('change', function() {
                this.form.submit();
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views/admin/user-activity-logs/index.blade.php ENDPATH**/ ?>