

<?php $__env->startSection('title', 'Trashed Roles'); ?>

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
                <span class="text-muted fw-light"><?php echo e(__('admin.menu.admin')); ?> / <a href="<?php echo e(route('admin.roles.index')); ?>"><?php echo e(__('admin.roles.title')); ?></a> /</span> 
                <span class="text-danger">Trash</span>
            </h4>
        </div>
        <div>
            <a href="<?php echo e(route('admin.roles.index')); ?>" class="btn btn-secondary">
                <i class="ti ti-arrow-left me-1"></i> Back to Active Roles
            </a>
        </div>
    </div>

    <!-- Trashed Roles Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="ti ti-trash me-2"></i>Trashed Roles</h5>
            <div class="text-muted">Total: <?php echo e($roles->total()); ?> trashed roles</div>
        </div>
        <div class="card-body">
            <?php if($roles->count() > 0): ?>
                <div class="alert alert-warning" role="alert">
                    <i class="ti ti-alert-triangle me-2"></i>
                    <strong>Warning:</strong> These roles have been moved to trash. You can restore or permanently delete them.
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th><?php echo e(__('admin.form.name')); ?></th>
                                <th><?php echo e(__('admin.form.slug')); ?></th>
                                <th><?php echo e(__('admin.form.description')); ?></th>
                                <th>Deleted At</th>
                                <th><?php echo e(__('admin.ebooks.actions')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-2 bg-label-danger">
                                                <span class="avatar-initial rounded-circle">
                                                    <i class="ti ti-shield-off"></i>
                                                </span>
                                            </div>
                                            <strong class="text-muted"><?php echo e($role->name); ?></strong>
                                        </div>
                                    </td>
                                    <td>
                                        <code class="text-muted"><?php echo e($role->slug); ?></code>
                                    </td>
                                    <td>
                                        <small class="text-muted"><?php echo e($role->description ?? '-'); ?></small>
                                    </td>
                                    <td>
                                        <small class="text-danger">
                                            <i class="ti ti-calendar-x me-1"></i>
                                            <?php echo e($role->deleted_at->format('d M Y H:i')); ?>

                                        </small>
                                        <br>
                                        <small class="text-muted"><?php echo e($role->deleted_at->diffForHumans()); ?></small>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <!-- Restore Button -->
                                            <button type="button" class="btn btn-sm btn-success" 
                                                onclick="if(confirm('Are you sure you want to restore this role?')) document.getElementById('restore-form-<?php echo e($role->id); ?>').submit();">
                                                <i class="ti ti-restore me-1"></i> Restore
                                            </button>
                                            <form id="restore-form-<?php echo e($role->id); ?>"
                                                action="<?php echo e(route('admin.roles.restore', $role->id)); ?>"
                                                method="POST" style="display: none;">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                            </form>

                                            <!-- Permanent Delete Button -->
                                            <button type="button" class="btn btn-sm btn-danger" 
                                                onclick="if(confirm('Are you sure you want to PERMANENTLY delete this role? This action cannot be undone!')) document.getElementById('force-delete-form-<?php echo e($role->id); ?>').submit();">
                                                <i class="ti ti-trash-x me-1"></i> Delete Forever
                                            </button>
                                            <form id="force-delete-form-<?php echo e($role->id); ?>"
                                                action="<?php echo e(route('admin.roles.force-delete', $role->id)); ?>"
                                                method="POST" style="display: none;">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    <?php echo e($roles->links()); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="ti ti-trash-off ti-xl text-muted mb-3"></i>
                    <h5 class="text-muted">Trash is empty</h5>
                    <p class="text-muted">No roles in trash.</p>
                    <a href="<?php echo e(route('admin.roles.index')); ?>" class="btn btn-primary mt-3">
                        <i class="ti ti-arrow-left me-1"></i> Back to Roles
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .text-muted code {
        color: #a8b1bb !important;
    }
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views/admin/roles/trashed.blade.php ENDPATH**/ ?>