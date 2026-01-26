

<?php $__env->startSection('title', __('admin.roles.role_details')); ?>

<?php $__env->startSection('content'); ?>

    <!-- Success/Error Messages -->
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong><?php echo e(__('admin.messages.success_title')); ?></strong> <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><?php echo e(__('admin.messages.error_title')); ?></strong> <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold py-3 mb-2">
                <span class="text-muted fw-light"><?php echo e(__('admin.menu.admin')); ?> / <a href="<?php echo e(route('admin.roles.index')); ?>"><?php echo e(__('admin.roles.title')); ?></a> /</span> <?php echo e($role->name); ?>

            </h4>
        </div>
        <div>
            <a href="<?php echo e(route('admin.roles.edit', $role->id)); ?>" class="btn btn-primary me-2">
                <i class="ti ti-pencil me-1"></i> <?php echo e(__('admin.buttons.edit')); ?>

            </a>
            <a href="<?php echo e(route('admin.roles.index')); ?>" class="btn btn-secondary">
                <i class="ti ti-arrow-left me-1"></i> <?php echo e(__('admin.buttons.back')); ?>

            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><?php echo e(__('admin.roles.role_details')); ?></h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 30%"><?php echo e(__('admin.form.name')); ?></th>
                            <td><?php echo e($role->name); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo e(__('admin.form.slug')); ?></th>
                            <td><code><?php echo e($role->slug); ?></code></td>
                        </tr>
                        <tr>
                            <th><?php echo e(__('admin.form.description')); ?></th>
                            <td><?php echo e($role->description ?? '-'); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo e(__('admin.form.status')); ?></th>
                            <td>
                                <?php if($role->is_active): ?>
                                    <span class="badge bg-success">Active</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Inactive</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th><?php echo e(__('admin.roles.created')); ?></th>
                            <td><?php echo e($role->created_at->format('d M Y H:i')); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo e(__('admin.roles.updated')); ?></th>
                            <td><?php echo e($role->updated_at->format('d M Y H:i')); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><?php echo e(__('admin.users.users')); ?> with this Role</h5>
                    <span class="badge bg-primary"><?php echo e($role->users->count() ?? 0); ?></span>
                </div>
                <div class="card-body">
                    <?php if($role->users && $role->users->count() > 0): ?>
                        <ul class="list-group list-group-flush">
                            <?php $__currentLoopData = $role->users->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong><?php echo e($user->name); ?></strong>
                                        <br><small class="text-muted"><?php echo e($user->email); ?></small>
                                    </div>
                                    <a href="<?php echo e(route('admin.users.show', $user->id)); ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="ti ti-eye"></i>
                                    </a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        <?php if($role->users->count() > 10): ?>
                            <div class="text-center mt-3">
                                <small class="text-muted">and <?php echo e($role->users->count() - 10); ?> more users...</small>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="ti ti-users-minus ti-xl text-muted mb-2"></i>
                            <p class="text-muted mb-0">No users with this role</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\admin\roles\show.blade.php ENDPATH**/ ?>