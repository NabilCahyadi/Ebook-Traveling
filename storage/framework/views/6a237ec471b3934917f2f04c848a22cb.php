<?php $__env->startSection('title', __('admin.admins.admin_detail')); ?>

<?php $__env->startSection('content'); ?>

    <!-- Page Header -->
    <div class="mb-4">
        <h4 class="fw-bold py-3 mb-2">
            <span class="text-muted fw-light">
                <a href="<?php echo e(route('admin.admins.index')); ?>" class="text-muted"><?php echo e(__('admin.admins.title')); ?></a> /
            </span> 
            <?php echo e(__('admin.admins.admin_detail')); ?>

        </h4>
    </div>

    <div class="row">
        <!-- Profile Card -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body text-center py-5">
                    <div class="mb-3">
                        <?php if($admin->avatar): ?>
                            <img src="<?php echo e(Storage::url($admin->avatar)); ?>" alt="<?php echo e($admin->name); ?>"
                                class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">
                        <?php else: ?>
                            <div style="width: 120px; height: 120px; margin: 0 auto; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <span style="font-size: 2.5rem; font-weight: 600; color: white;">
                                    <?php echo e(getInitials($admin->name)); ?>

                                </span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <h5 class="mb-2"><?php echo e($admin->name); ?></h5>
                    <p class="text-muted mb-3"><?php echo e($admin->email); ?></p>
                    <?php if($admin->type === 'superadmin'): ?>
                        <span class="badge bg-label-danger">
                            <i class="ti ti-crown me-1"></i> <?php echo e(__('admin.admins.super_admin')); ?>

                        </span>
                    <?php else: ?>
                        <span class="badge bg-label-primary">
                            <i class="ti ti-user me-1"></i> <?php echo e(__('admin.admins.admin')); ?>

                        </span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Statistik Card -->
            <div class="card mt-3">
                <div class="card-body">
                    <h6 class="mb-4">
                        <i class="ti ti-info-circle me-2"></i> <?php echo e(__('admin.admins.statistics')); ?>

                    </h6>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted"><?php echo e(__('admin.admins.account_status')); ?>:</span>
                        <?php if($admin->status === 'active'): ?>
                            <span class="badge bg-success"><?php echo e(__('admin.admins.active')); ?></span>
                        <?php else: ?>
                            <span class="badge bg-secondary"><?php echo e(__('admin.admins.inactive')); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted"><?php echo e(__('admin.admins.type')); ?>:</span>
                        <strong><?php echo e($admin->type === 'superadmin' ? __('admin.admins.super_admin') : __('admin.admins.admin')); ?></strong>
                    </div>
                    <?php if($admin->last_login_at): ?>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted"><?php echo e(__('admin.admins.last_activity')); ?>:</span>
                        <small class="text-end"><?php echo e($admin->last_login_at->diffForHumans()); ?></small>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Information Card -->
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><?php echo e(__('admin.admins.admin_info')); ?></h5>
                    <div>
                        <a href="<?php echo e(route('admin.admins.edit', $admin->id)); ?>" class="btn btn-sm btn-primary">
                            <i class="ti ti-edit me-1"></i> <?php echo e(__('admin.admins.edit')); ?>

                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td class="text-muted" style="width: 200px;"><?php echo e(__('admin.admins.full_name')); ?></td>
                                    <td class="fw-medium"><?php echo e($admin->name); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted"><?php echo e(__('admin.admins.email')); ?></td>
                                    <td class="fw-medium"><?php echo e($admin->email); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted"><?php echo e(__('admin.admins.phone_number')); ?></td>
                                    <td class="fw-medium"><?php echo e($admin->phone ?? '-'); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted"><?php echo e(__('admin.admins.admin_type')); ?></td>
                                    <td>
                                        <?php if($admin->type === 'superadmin'): ?>
                                            <span class="badge bg-label-danger">
                                                <i class="ti ti-crown me-1"></i> <?php echo e(__('admin.admins.super_admin')); ?>

                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-label-primary">
                                                <i class="ti ti-user me-1"></i> <?php echo e(__('admin.admins.admin')); ?>

                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted"><?php echo e(__('admin.admins.status')); ?></td>
                                    <td>
                                        <?php if($admin->status === 'active'): ?>
                                            <span class="badge bg-label-success"><?php echo e(__('admin.admins.active')); ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-label-secondary"><?php echo e(__('admin.admins.inactive')); ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted"><?php echo e(__('admin.admins.date_created')); ?></td>
                                    <td>
                                        <?php echo e($admin->created_at->format('d F Y, H:i')); ?>

                                        <small class="text-muted d-block">(<?php echo e($admin->created_at->diffForHumans()); ?>)</small>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted"><?php echo e(__('admin.admins.last_updated')); ?></td>
                                    <td>
                                        <?php echo e($admin->updated_at->format('d F Y, H:i')); ?>

                                        <small class="text-muted d-block">(<?php echo e($admin->updated_at->diffForHumans()); ?>)</small>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted"><?php echo e(__('admin.admins.last_login')); ?></td>
                                    <td>
                                        <?php if($admin->last_login_at): ?>
                                            <?php echo e($admin->last_login_at->format('d F Y, H:i')); ?>

                                            <small class="text-muted d-block">(<?php echo e($admin->last_login_at->diffForHumans()); ?>)</small>
                                        <?php else: ?>
                                            <span class="text-muted"><?php echo e(__('admin.admins.never_logged_in')); ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a href="<?php echo e(route('admin.admins.index')); ?>" class="btn btn-outline-secondary">
                            <i class="ti ti-arrow-left me-1"></i> <?php echo e(__('admin.admins.back')); ?>

                        </a>
                        <?php if(auth('admin')->id() !== $admin->id): ?>
                            <form action="<?php echo e(route('admin.admins.destroy', $admin->id)); ?>" method="POST"
                                onsubmit="return confirm('<?php echo e(__('admin.admins.confirm_delete')); ?>')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger">
                                    <i class="ti ti-trash me-1"></i> <?php echo e(__('admin.admins.delete_admin')); ?>

                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\admin\admins\show.blade.php ENDPATH**/ ?>