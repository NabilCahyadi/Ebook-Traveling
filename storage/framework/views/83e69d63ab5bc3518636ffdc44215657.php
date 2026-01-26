<?php $__env->startSection('title', __('admin.role_permissions.title')); ?>

<?php $__env->startSection('content'); ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold"><?php echo e(__('admin.role_permissions.title')); ?></h4>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-6 col-lg-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="avatar avatar-lg bg-label-primary rounded">
                            <i class="ti ti-shield ti-lg"></i>
                        </div>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="roleMenu<?php echo e($role->id); ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="roleMenu<?php echo e($role->id); ?>">
                                <li>
                                    <a class="dropdown-item" href="<?php echo e(route('admin.role-permissions.edit', $role->id)); ?>">
                                        <i class="ti ti-settings me-2"></i><?php echo e(__('admin.role_permissions.configure_permissions')); ?>

                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <h5 class="card-title mb-1"><?php echo e($role->name); ?></h5>
                    <p class="text-muted small mb-3"><?php echo e($role->description ?? __('admin.role_permissions.no_description')); ?></p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-label-info">
                            <?php echo e($role->permissions->count()); ?> <?php echo e(__('admin.role_permissions.permissions')); ?>

                        </span>
                        <a href="<?php echo e(route('admin.role-permissions.edit', $role->id)); ?>" class="btn btn-sm btn-primary">
                            <i class="ti ti-settings me-1"></i><?php echo e(__('admin.role_permissions.configure')); ?>

                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\admin\role-permissions\index.blade.php ENDPATH**/ ?>