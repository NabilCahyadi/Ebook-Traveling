

<?php $__env->startSection('title', 'Configure Permissions - ' . $role->name); ?>

<?php $__env->startSection('content'); ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Configure Permissions</h4>
            <p class="text-muted mb-0">Managing permissions for <strong><?php echo e($role->name); ?></strong> role</p>
            <?php if(isset($isGuestRole) && $isGuestRole): ?>
            <div class="alert alert-info mt-2 mb-0">
                <i class="ti ti-info-circle me-1"></i>
                <strong>Guest Role:</strong> Controls what visitors can access before logging in
            </div>
            <?php endif; ?>
        </div>
        <a href="<?php echo e(route('admin.role-permissions.index')); ?>" class="btn btn-label-secondary">
            <i class="ti ti-arrow-left me-1"></i>Back to Roles
        </a>
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

    <form action="<?php echo e(route('admin.role-permissions.update', $role->id)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="ti ti-lock-access me-2"></i>Permission Modules
                </h5>
                <span class="badge bg-primary" id="selectedCount">0 permissions selected</span>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <?php $__currentLoopData = $permissionModules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card border shadow-none h-100">
                            <div class="card-header bg-label-primary d-flex justify-content-between align-items-center">
                                <h6 class="mb-0"><?php echo e($module['name']); ?></h6>
                                <div class="form-check">
                                    <input class="form-check-input select-all-group" type="checkbox" 
                                           data-group="<?php echo e(Str::slug($module['name'])); ?>">
                                    <label class="form-check-label small">Select All</label>
                                </div>
                            </div>
                            <div class="card-body pt-3" style="max-height: 400px; overflow-y: auto;">
                                <div class="permission-group" data-group="<?php echo e(Str::slug($module['name'])); ?>">
                                    <?php $__currentLoopData = $module['permissions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input permission-checkbox" 
                                               type="checkbox" 
                                               name="permissions[]" 
                                               value="<?php echo e($permission['name']); ?>"
                                               id="perm_<?php echo e($permission['name']); ?>"
                                               data-group="<?php echo e(Str::slug($module['name'])); ?>"
                                               <?php echo e(in_array($permission['name'], $rolePermissions) ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="perm_<?php echo e($permission['name']); ?>">
                                            <?php echo e($permission['label']); ?>

                                        </label>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <a href="<?php echo e(route('admin.role-permissions.index')); ?>" class="btn btn-label-secondary">
                    <i class="ti ti-x me-1"></i>Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-device-floppy me-1"></i>Save Permissions
                </button>
            </div>
        </div>
    </form>
</div>

<style>
    .card-body::-webkit-scrollbar {
        width: 6px;
    }
    
    .card-body::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .card-body::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }
    
    .card-body::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
    
    .card.border.shadow-none.h-100 {
        transition: all 0.3s ease;
    }
    
    .card.border.shadow-none.h-100:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
        transform: translateY(-2px);
    }
</style>

<?php $__env->startPush('scripts'); ?>
<script>
$(document).ready(function() {
    // Update selected count on page load
    updateSelectedCount();
    
    // Update group select all checkboxes on page load
    $('.select-all-group').each(function() {
        updateGroupSelectAll($(this).data('group'));
    });

    // Handle select all checkbox
    $('.select-all-group').on('change', function() {
        const group = $(this).data('group');
        const isChecked = $(this).prop('checked');
        
        $(`.permission-checkbox[data-group="${group}"]`).prop('checked', isChecked);
        updateSelectedCount();
    });

    // Handle individual permission checkboxes
    $('.permission-checkbox').on('change', function() {
        const group = $(this).data('group');
        updateGroupSelectAll(group);
        updateSelectedCount();
    });

    function updateGroupSelectAll(group) {
        const groupCheckboxes = $(`.permission-checkbox[data-group="${group}"]`);
        const checkedCount = groupCheckboxes.filter(':checked').length;
        const selectAllCheckbox = $(`.select-all-group[data-group="${group}"]`);
        
        if (checkedCount === 0) {
            selectAllCheckbox.prop('checked', false);
            selectAllCheckbox.prop('indeterminate', false);
        } else if (checkedCount === groupCheckboxes.length) {
            selectAllCheckbox.prop('checked', true);
            selectAllCheckbox.prop('indeterminate', false);
        } else {
            selectAllCheckbox.prop('checked', false);
            selectAllCheckbox.prop('indeterminate', true);
        }
    }

    function updateSelectedCount() {
        const count = $('.permission-checkbox:checked').length;
        $('#selectedCount').text(count + ' permission' + (count !== 1 ? 's' : '') + ' selected');
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views/admin/role-permissions/edit.blade.php ENDPATH**/ ?>