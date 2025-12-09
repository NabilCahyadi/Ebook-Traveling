<?php $__env->startSection('title', 'User Activity Logs'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">User Activity Logs</h4>
                <p class="text-muted mb-0">Monitor all user activities including admin actions</p>
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
                                    <th>URL</th>
                                    <th>Model</th>
                                    <th>IP Address</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <?php if($log->created_at): ?>
                                                <small><?php echo e($log->created_at->format('Y-m-d')); ?></small><br>
                                                <small class="text-muted"><?php echo e($log->created_at->format('H:i:s')); ?></small>
                                            <?php else: ?>
                                                <small class="text-muted">No date</small>
                                            <?php endif; ?>
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
                                                <span
                                                    class="badge bg-label-info"><?php echo e($log->user->roles->first()->name); ?></span>
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
                                            ?>
                                            <span
                                                class="badge bg-label-<?php echo e($color); ?>"><?php echo e(ucfirst(str_replace('_', ' ', $log->action_type))); ?></span>
                                            <?php if($detailInfo): ?>
                                                <br><small class="text-muted"><?php echo e($detailInfo); ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="text-truncate d-inline-block" style="max-width: 300px;"
                                                title="<?php echo e($log->url); ?>">
                                                <?php echo e($log->url ?? 'N/A'); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <?php if($log->table_name): ?>
                                                <small><?php echo e($log->table_name); ?></small>
                                                <?php if($log->record_id): ?>
                                                    <br><small class="text-muted">#<?php echo e($log->record_id); ?></small>
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