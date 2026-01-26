<?php $__env->startSection('title', __('admin.admins.title')); ?>

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
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold py-3 mb-2">
                <span class="text-muted fw-light"><?php echo e(__('admin.menu.settings')); ?> /</span> <?php echo e(__('admin.admins.title')); ?>

            </h4>
        </div>
        <div>
            <a href="<?php echo e(route('admin.admins.create')); ?>" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i> <?php echo e(__('admin.admins.add_admin')); ?>

            </a>
        </div>
    </div>

    <!-- Admins Table -->
    <div class="card">
        <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
            <h5 class="mb-0"><?php echo e(__('admin.admins.list')); ?></h5>
            <div class="d-flex gap-2 align-items-center">
                <a href="<?php echo e(route('admin.admins.export', request()->all())); ?>" class="btn btn-success btn-sm">
                    <i class="ti ti-download me-1"></i>
                    <?php echo e(__('admin.common.export')); ?>

                </a>
                <div class="text-muted"><?php echo e(__('admin.admins.total_admins', ['count' => $admins->total()])); ?></div>
            </div>
        </div>

        <!-- Search Filter -->
        <div class="card-body border-bottom">
            <form action="<?php echo e(route('admin.admins.index')); ?>" method="GET" class="row g-3">
                <div class="col-12 col-md-6 col-lg-7">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="ti ti-search"></i>
                        </span>
                        <input type="text" class="form-control" name="search" value="<?php echo e($search ?? ''); ?>"
                            placeholder="<?php echo e(__('admin.admins.search_placeholder')); ?>">
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3 col-lg-3">
                    <select name="type" class="form-select">
                        <option value=""><?php echo e(__('admin.admins.all_types')); ?></option>
                        <option value="admin" <?php echo e(request('type') === 'admin' ? 'selected' : ''); ?>><?php echo e(__('admin.admins.admin')); ?></option>
                        <option value="superadmin" <?php echo e(request('type') === 'superadmin' ? 'selected' : ''); ?>><?php echo e(__('admin.admins.super_admin')); ?></option>
                    </select>
                </div>
                <div class="col-12 col-sm-6 col-md-3 col-lg-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="ti ti-search me-1"></i> <?php echo e(__('admin.common.search')); ?>

                    </button>
                </div>
                <?php if((isset($search) && $search) || (isset($type) && $type)): ?>
                    <div class="col-12">
                        <a href="<?php echo e(route('admin.admins.index')); ?>"
                            class="btn btn-sm btn-outline-secondary">
                            <i class="ti ti-x me-1"></i> <?php echo e(__('admin.common.clear_filters')); ?>

                        </a>
                    </div>
                <?php endif; ?>
            </form>
        </div>

        <div class="card-body">
            <?php if($admins->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th><?php echo e(__('admin.admins.name')); ?></th>
                                <th class="d-none d-md-table-cell"><?php echo e(__('admin.admins.email')); ?></th>
                                <th class="d-none d-lg-table-cell"><?php echo e(__('admin.admins.phone')); ?></th>
                                <th><?php echo e(__('admin.admins.type')); ?></th>
                                <th class="d-none d-sm-table-cell"><?php echo e(__('admin.admins.status')); ?></th>
                                <th class="d-none d-lg-table-cell"><?php echo e(__('admin.admins.last_login')); ?></th>
                                <th class="text-center"><?php echo e(__('admin.common.actions')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $admins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if($admin->avatar): ?>
                                                <img src="<?php echo e(Storage::url($admin->avatar)); ?>" alt="<?php echo e($admin->name); ?>"
                                                    class="rounded-circle me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                            <?php else: ?>
                                                <div class="avatar avatar-sm me-2">
                                                    <span class="avatar-initial rounded-circle" style="background-color: rgba(236, 72, 153, 0.2); border: none; color: #ec4899; font-weight: 600;">
                                                        <?php echo e(strtoupper(substr($admin->name, 0, 2))); ?>

                                                    </span>
                                                </div>
                                            <?php endif; ?>
                                            <div>
                                                <strong><?php echo e($admin->name); ?></strong>
                                                <div class="d-md-none small text-muted"><?php echo e($admin->email); ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="d-none d-md-table-cell"><?php echo e($admin->email); ?></td>
                                    <td class="d-none d-lg-table-cell"><?php echo e($admin->phone ?? '-'); ?></td>
                                    <td>
                                        <?php if($admin->type === 'superadmin'): ?>
                                            <span class="badge bg-label-danger">
                                                <i class="ti ti-crown me-1 d-none d-sm-inline"></i> <?php echo e(__('admin.admins.super_admin')); ?>

                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-label-danger">
                                                <i class="ti ti-user me-1 d-none d-sm-inline"></i> <?php echo e(__('admin.admins.admin')); ?>

                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="d-none d-sm-table-cell">
                                        <?php if($admin->status === 'active'): ?>
                                            <span class="badge bg-label-success"><?php echo e(__('admin.admins.active')); ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-label-secondary"><?php echo e(__('admin.admins.inactive')); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="d-none d-lg-table-cell">
                                        <?php if($admin->last_login_at): ?>
                                            <small><?php echo e($admin->last_login_at->diffForHumans()); ?></small>
                                        <?php else: ?>
                                            <small class="text-muted"><?php echo e(__('admin.admins.never_logged_in')); ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm btn-icon dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="<?php echo e(route('admin.admins.show', $admin->id)); ?>">
                                                    <i class="ti ti-eye me-2"></i> <?php echo e(__('admin.common.detail')); ?>

                                                </a>
                                                <a class="dropdown-item" href="<?php echo e(route('admin.admins.edit', $admin->id)); ?>">
                                                    <i class="ti ti-edit me-2"></i> <?php echo e(__('admin.common.edit')); ?>

                                                </a>
                                                <?php if($admin->type !== 'superadmin'): ?>
                                                    <a class="dropdown-item" href="<?php echo e(route('admin.admins.permissions.edit', $admin->id)); ?>">
                                                        <i class="ti ti-shield-lock me-2"></i> <?php echo e(__('admin.admins.manage_permissions')); ?>

                                                    </a>
                                                <?php endif; ?>
                                                <?php if(auth('admin')->id() !== $admin->id): ?>
                                                    <div class="dropdown-divider"></div>
                                                    <form action="<?php echo e(route('admin.admins.destroy', $admin->id)); ?>" method="POST"
                                                        onsubmit="return confirm('<?php echo e(__('admin.admins.confirm_delete')); ?>')">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="ti ti-trash me-2"></i> <?php echo e(__('admin.common.delete')); ?>

                                                        </button>
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
                    <?php echo e($admins->links()); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="ti ti-users ti-lg text-muted"></i>
                    </div>
                    <h5 class="text-muted"><?php echo e(__('admin.admins.no_admins_found')); ?></h5>
                    <p class="text-muted">
                        <?php if(isset($search) || isset($type)): ?>
                            <?php echo e(__('admin.admins.try_adjusting_filters')); ?>

                        <?php else: ?>
                            <?php echo e(__('admin.admins.no_admins_yet')); ?>

                        <?php endif; ?>
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\admin\admins\index.blade.php ENDPATH**/ ?>