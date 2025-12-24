<?php $__env->startSection('title', __('admin.users.trashed_users')); ?>

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
                <span class="text-muted fw-light"><?php echo e(__('admin.menu.dashboard')); ?> / <?php echo e(__('admin.menu.user_management')); ?> /</span>
                <span class="text-danger"><?php echo e(__('admin.users.trashed_users')); ?></span>
            </h4>
            <p class="text-muted mb-0"><?php echo e(__('admin.users.trashed_description')); ?></p>
        </div>
        <div>
            <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-secondary">
                <i class="ti ti-arrow-left me-1"></i> <?php echo e(__('admin.users.back_to_active')); ?>

            </a>
        </div>
    </div>

    <!-- Trashed Users Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-danger">
                <i class="ti ti-trash me-1"></i>
                <?php echo e(__('admin.users.trashed_users')); ?>

            </h5>
            <div class="text-muted">Total: <?php echo e($users->total()); ?> <?php echo e(__('admin.users.users')); ?></div>
        </div>

        <!-- Search Filter -->
        <div class="card-body border-bottom">
            <form action="<?php echo e(route('admin.users.trashed')); ?>" method="GET" class="row g-3">
                <div class="col-md-10">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="ti ti-search"></i>
                        </span>
                        <input type="text" class="form-control" name="search" value="<?php echo e($search ?? ''); ?>"
                            placeholder="<?php echo e(__('admin.users.search_placeholder')); ?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="ti ti-search me-1"></i> <?php echo e(__('admin.actions.search')); ?>

                    </button>
                </div>
                <?php if(isset($search) && $search): ?>
                    <div class="col-12">
                        <a href="<?php echo e(route('admin.users.trashed')); ?>" class="btn btn-sm btn-outline-secondary">
                            <i class="ti ti-x me-1"></i> <?php echo e(__('admin.common.clear')); ?> <?php echo e(__('admin.common.filter')); ?>

                        </a>
                        <span class="text-muted ms-2"><?php echo e(__('admin.users.showing_results_for')); ?>: <strong>"<?php echo e($search); ?>"</strong></span>
                    </div>
                <?php endif; ?>
            </form>
        </div>

        <div class="card-body">
            <?php if($users->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th><?php echo e(__('admin.users.name')); ?></th>
                                <th><?php echo e(__('admin.users.email')); ?></th>
                                <th><?php echo e(__('admin.users.role')); ?></th>
                                <th><?php echo e(__('admin.users.deleted_at')); ?></th>
                                <th><?php echo e(__('admin.users.actions')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="table-danger">
                                    <td>
                                        <strong>#<?php echo e($user->id); ?></strong>
                                        <span class="badge bg-label-danger ms-1"><?php echo e(__('admin.users.deleted')); ?></span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-2">
                                                <span class="avatar-initial rounded-circle bg-label-danger">
                                                    <?php echo e(substr($user->name, 0, 1)); ?>

                                                </span>
                                            </div>
                                            <div>
                                                <div class="fw-medium">
                                                    <?php echo e($user->name); ?>

                                                    <i class="ti ti-trash text-danger ms-1" title="<?php echo e(__('admin.users.deleted')); ?>"></i>
                                                </div>
                                                <?php if($user->id === auth()->id()): ?>
                                                    <small class="badge bg-label-warning">
                                                        <i class="ti ti-star ti-xs"></i> <?php echo e(__('admin.users.you')); ?>

                                                    </small>
                                                <?php elseif($user->email_verified_at): ?>
                                                    <small class="text-success">
                                                        <i class="ti ti-check ti-xs"></i> <?php echo e(__('admin.users.verified')); ?>

                                                    </small>
                                                <?php else: ?>
                                                    <small class="text-muted">
                                                        <i class="ti ti-x ti-xs"></i> <?php echo e(__('admin.users.not_verified')); ?>

                                                    </small>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <div class="fw-medium"><?php echo e($user->email); ?></div>
                                            <?php if($user->phone): ?>
                                                <small class="text-muted"><?php echo e($user->phone); ?></small>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if($user->roles && $user->roles->count() > 0): ?>
                                            <?php $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <span class="badge bg-label-secondary mb-1"><?php echo e($role->name); ?></span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            <span class="badge bg-label-secondary"><?php echo e(__('admin.users.role')); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <small class="text-danger">
                                            <?php echo e($user->deleted_at->format('d M Y')); ?><br>
                                            <?php echo e($user->deleted_at->format('H:i')); ?>

                                        </small>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button"
                                                class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item text-success" href="javascript:void(0);"
                                                    onclick="event.preventDefault(); if(confirm('<?php echo e(__('admin.users.confirm_restore')); ?>')) document.getElementById('restore-form-<?php echo e($user->id); ?>').submit();">
                                                    <i class="ti ti-restore me-2"></i>
                                                    <span><?php echo e(__('admin.actions.restore')); ?></span>
                                                </a>
                                                <form id="restore-form-<?php echo e($user->id); ?>"
                                                    action="<?php echo e(route('admin.users.restore', $user->id)); ?>" method="POST"
                                                    style="display: none;">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('PATCH'); ?>
                                                </form>
                                                <?php if($user->id !== auth()->id()): ?>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item text-danger" href="javascript:void(0);"
                                                        onclick="event.preventDefault(); if(confirm('<?php echo e(__('admin.users.confirm_force_delete')); ?>')) document.getElementById('force-delete-form-<?php echo e($user->id); ?>').submit();">
                                                        <i class="ti ti-trash-x me-2"></i>
                                                        <span><?php echo e(__('admin.users.delete_permanently')); ?></span>
                                                    </a>
                                                    <form id="force-delete-form-<?php echo e($user->id); ?>"
                                                        action="<?php echo e(route('admin.users.force-delete', $user->id)); ?>"
                                                        method="POST" style="display: none;">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                    </form>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    <?php echo e($users->appends(['search' => $search])->links()); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="ti ti-trash-off ti-xl text-muted mb-3" style="font-size: 3rem;"></i>
                    <h6 class="text-muted"><?php echo e(__('admin.users.no_users_found')); ?></h6>
                    <p class="text-muted mb-0">
                        <?php if(isset($search) && $search): ?>
                            <?php echo e(__('admin.users.no_deleted_users_search')); ?>

                        <?php else: ?>
                            <?php echo e(__('admin.users.no_deleted_users_yet')); ?>

                        <?php endif; ?>
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views/admin/users/trashed.blade.php ENDPATH**/ ?>