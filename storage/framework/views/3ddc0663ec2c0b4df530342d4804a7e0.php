<?php $__env->startSection('title', 'Manage Permissions - ' . ucfirst($role->name)); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="mb-4">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">Admin / Permissions /</span> <?php echo e(ucfirst($role->name)); ?>

            </h4>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">Manage Permissions for <?php echo e(ucfirst($role->name)); ?></h5>
                    <p class="text-muted mb-0 mt-1">Set access permissions for each resource</p>
                </div>
                <a href="<?php echo e(route('admin.permissions.index')); ?>" class="btn btn-secondary">
                    <i class="ti ti-arrow-left me-1"></i> Back
                </a>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('admin.permissions.update', $role->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 250px;">Resource</th>
                                    <th class="text-center" style="width: 120px;">Create</th>
                                    <th class="text-center" style="width: 120px;">Read</th>
                                    <th class="text-center" style="width: 120px;">Update</th>
                                    <th class="text-center" style="width: 120px;">Delete</th>
                                    <th class="text-center" style="width: 120px;">
                                        <input type="checkbox" class="form-check-input" id="selectAll"
                                            onclick="toggleAll(this)">
                                        <label for="selectAll" class="ms-1">All</label>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $resources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $permission = $permissions->firstWhere('resource', $key);
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="fw-semibold"><?php echo e($label); ?></span>
                                                <small class="text-muted"><?php echo e($key); ?></small>
                                            </div>
                                            <input type="hidden" name="permissions[<?php echo e($loop->index); ?>][resource]"
                                                value="<?php echo e($key); ?>">
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input permission-check" type="checkbox"
                                                    name="permissions[<?php echo e($loop->index); ?>][can_create]" value="1"
                                                    <?php echo e($permission && $permission->can_create ? 'checked' : ''); ?>>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input permission-check" type="checkbox"
                                                    name="permissions[<?php echo e($loop->index); ?>][can_read]" value="1"
                                                    <?php echo e($permission && $permission->can_read ? 'checked' : ''); ?>>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input permission-check" type="checkbox"
                                                    name="permissions[<?php echo e($loop->index); ?>][can_update]" value="1"
                                                    <?php echo e($permission && $permission->can_update ? 'checked' : ''); ?>>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input permission-check" type="checkbox"
                                                    name="permissions[<?php echo e($loop->index); ?>][can_delete]" value="1"
                                                    <?php echo e($permission && $permission->can_delete ? 'checked' : ''); ?>>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" class="form-check-input row-select"
                                                onclick="toggleRow(this, <?php echo e($loop->index); ?>)">
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-check me-1"></i> Save Permissions
                        </button>
                        <a href="<?php echo e(route('admin.permissions.index')); ?>" class="btn btn-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
        <script>
            function toggleAll(source) {
                const checkboxes = document.querySelectorAll('.permission-check');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = source.checked;
                });

                const rowSelects = document.querySelectorAll('.row-select');
                rowSelects.forEach(select => {
                    select.checked = source.checked;
                });
            }

            function toggleRow(source, index) {
                const checkboxes = document.querySelectorAll(`input[name^="permissions[${index}]"]:not([type="hidden"])`);
                checkboxes.forEach(checkbox => {
                    checkbox.checked = source.checked;
                });
            }
        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\admin\permissions\edit.blade.php ENDPATH**/ ?>