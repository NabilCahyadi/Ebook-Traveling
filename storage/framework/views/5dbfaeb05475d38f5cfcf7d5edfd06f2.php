<?php $__env->startSection('title', 'Activity Log Detail'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">Activity Log Detail</h4>
                <p class="text-muted mb-0">Detailed information about user activity</p>
            </div>
            <a href="<?php echo e(route('admin.user-activity-logs.index')); ?>" class="btn btn-outline-secondary">
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
                                <span class="badge bg-<?php echo e($color); ?>"><?php echo e(ucfirst($log->action_type)); ?></span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-3 fw-medium">URL:</div>
                            <div class="col-sm-9"><?php echo e($log->url ?? 'N/A'); ?></div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-3 fw-medium">Table Name:</div>
                            <div class="col-sm-9">
                                <?php if($log->table_name): ?>
                                    <code><?php echo e($log->table_name); ?></code>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-3 fw-medium">Record ID:</div>
                            <div class="col-sm-9">
                                <?php if($log->record_id): ?>
                                    <code>#<?php echo e($log->record_id); ?></code>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-3 fw-medium">IP Address:</div>
                            <div class="col-sm-9">
                                <code><?php echo e($log->ip_address ?? 'N/A'); ?></code>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-3 fw-medium">User Agent:</div>
                            <div class="col-sm-9">
                                <small class="text-muted"><?php echo e($log->user_agent ?? 'N/A'); ?></small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-3 fw-medium">Timestamp:</div>
                            <div class="col-sm-9">
                                <?php if($log->created_at): ?>
                                    <?php echo e($log->created_at->format('d M Y, H:i:s')); ?>

                                    <small class="text-muted">(<?php echo e($log->created_at->diffForHumans()); ?>)</small>
                                <?php else: ?>
                                    <span class="text-muted">No timestamp</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Data -->
                <?php if($log->data): ?>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Additional Data</h5>
                        </div>
                        <div class="card-body">
                            <pre class="bg-light p-3 rounded"><code><?php echo e(json_encode(json_decode($log->data), JSON_PRETTY_PRINT)); ?></code></pre>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- User Info Sidebar -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">User Information</h5>
                    </div>
                    <div class="card-body">
                        <?php if($log->user): ?>
                            <div class="text-center mb-4">
                                <div class="avatar avatar-xl mb-3">
                                    <span class="avatar-initial rounded-circle bg-label-primary" style="font-size: 2rem;">
                                        <?php echo e(substr($log->user->name, 0, 1)); ?>

                                    </span>
                                </div>
                                <h5 class="mb-1"><?php echo e($log->user->name); ?></h5>
                                <p class="text-muted mb-0"><?php echo e($log->user->email); ?></p>
                            </div>

                            <hr>

                            <div class="mb-3">
                                <small class="text-muted d-block mb-1">Role</small>
                                <?php if($log->user->roles->isNotEmpty()): ?>
                                    <span class="badge bg-label-info"><?php echo e($log->user->roles->first()->name); ?></span>
                                <?php else: ?>
                                    <span class="text-muted">No role assigned</span>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted d-block mb-1">User ID</small>
                                <code>#<?php echo e($log->user->id); ?></code>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted d-block mb-1">Account Status</small>
                                <?php if($log->user->is_active ?? true): ?>
                                    <span class="badge bg-label-success">Active</span>
                                <?php else: ?>
                                    <span class="badge bg-label-danger">Inactive</span>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted d-block mb-1">Registered</small>
                                <?php echo e($log->user->created_at->format('d M Y')); ?>

                            </div>

                            <hr>

                            <a href="<?php echo e(route('admin.users.show', $log->user->id)); ?>" class="btn btn-primary w-100">
                                <i class="ti ti-user me-1"></i> View User Profile
                            </a>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="ti ti-user-off ti-lg text-muted mb-2"></i>
                                <p class="text-muted mb-0">User information not available</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views/admin/user-activity-logs/show.blade.php ENDPATH**/ ?>