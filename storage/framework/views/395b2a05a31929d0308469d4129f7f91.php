<?php $__env->startSection('title', __('admin.permissions.title')); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* Override warna primary untuk halaman permission */
    .bg-label-primary {
        background-color: rgba(255, 76, 97, 0.12) !important;
        color: #ff4c61 !important;
    }
    
    .badge.bg-label-primary {
        background-color: rgba(255, 76, 97, 0.12) !important;
        color: #ff4c61 !important;
    }
    
    .avatar-initial.bg-label-primary {
        background-color: rgba(255, 76, 97, 0.12) !important;
        color: #ff4c61 !important;
        font-weight: 600;
    }
    
    .text-primary,
    .form-check-label.text-primary {
        color: #ff4c61 !important;
    }
    
    .card-header.bg-label-primary {
        background-color: rgba(255, 76, 97, 0.12) !important;
        border-bottom: 2px solid #ff4c61;
    }
    
    .card-header.bg-label-primary h5,
    .card-header.bg-label-primary i {
        color: #ff4c61 !important;
    }
    
    .form-check-input:checked {
        background-color: #ff4c61 !important;
        border-color: #ff4c61 !important;
    }
    
    .btn-primary {
        background-color: #ff4c61 !important;
        border-color: #ff4c61 !important;
    }
    
    .btn-primary:hover,
    .btn-primary:focus,
    .btn-primary:active {
        background-color: #e6405a !important;
        border-color: #e6405a !important;
    }
</style>
<?php $__env->stopPush(); ?>

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
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo e(__('admin.menu.dashboard')); ?></a>
                </li>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(route('admin.admins.index')); ?>"><?php echo e(__('admin.admins.title')); ?></a>
                </li>
                <li class="breadcrumb-item active"><?php echo e(__('admin.permissions.manage_permissions')); ?></li>
            </ol>
        </nav>
        <h4 class="fw-bold py-3 mb-2">
            <span class="text-muted fw-light"><?php echo e(__('admin.menu.settings')); ?> /</span> <?php echo e(__('admin.permissions.title')); ?>

        </h4>
    </div>

    <div class="row">
        <div class="col-md-12">
            <!-- Admin Info -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <?php if($admin->avatar): ?>
                            <img src="<?php echo e(Storage::url($admin->avatar)); ?>" alt="<?php echo e($admin->name); ?>"
                                class="rounded-circle me-3" style="width: 60px; height: 60px; object-fit: cover;">
                        <?php else: ?>
                            <div class="avatar avatar-lg me-3">
                                <span class="avatar-initial rounded-circle bg-label-primary">
                                    <?php echo e(strtoupper(substr($admin->name, 0, 2))); ?>

                                </span>
                            </div>
                        <?php endif; ?>
                        <div>
                            <h5 class="mb-1"><?php echo e($admin->name); ?></h5>
                            <p class="text-muted mb-0"><?php echo e($admin->email); ?></p>
                            <span class="badge bg-label-primary mt-1">
                                <i class="ti ti-user me-1"></i> <?php echo e(ucfirst($admin->type)); ?>

                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Permissions Form -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="ti ti-shield-lock me-2"></i>
                        <?php echo e(__('admin.permissions.manage_permissions')); ?>

                    </h5>
                    <p class="text-muted mb-0 mt-2"><?php echo e(__('admin.permissions.select_description')); ?></p>
                </div>

                <form action="<?php echo e(route('admin.admins.permissions.update', $admin->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="card-body">
                        <?php if($permissions->count() > 0): ?>
                            <!-- Global Select All -->
                            <div class="mb-4 p-3 bg-light rounded border">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="select-all-global">
                                    <label class="form-check-label fw-bold text-primary" for="select-all-global">
                                        <i class="ti ti-checkbox me-1"></i> <?php echo e(__('admin.permissions.select_all_permissions')); ?>

                                    </label>
                                </div>
                            </div>

                            <div class="row">
                                <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module => $subModules): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $moduleSlug = Str::slug($module);
                                    ?>
                                    <div class="col-12 mb-4">
                                        <div class="card">
                                            <div class="card-header bg-label-primary">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <h5 class="mb-0">
                                                        <i class="ti ti-folder me-2"></i>
                                                        <?php echo e($module); ?>

                                                    </h5>
                                                    <div class="form-check">
                                                        <input class="form-check-input module-checkbox" 
                                                               type="checkbox" 
                                                               id="select-all-module-<?php echo e($moduleSlug); ?>"
                                                               data-module="<?php echo e($moduleSlug); ?>">
                                                        <label class="form-check-label fw-semibold text-primary" for="select-all-module-<?php echo e($moduleSlug); ?>">
                                                            <?php echo e(__('admin.permissions.select_all')); ?>

                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body mt-4">
                                                <div class="row">
                                                    <?php $__currentLoopData = $subModules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subModule => $subModulePermissions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php
                                                            $subModuleSlug = Str::slug($subModule);
                                                        ?>
                                                        <div class="col-md-6 col-lg-4 mb-3">
                                                            <div class="border rounded p-3 h-100">
                                                                <div class="d-flex align-items-center mb-3">
                                                                    <i class="ti ti-table me-2 text-primary"></i>
                                                                    <h6 class="mb-0"><?php echo e($subModule); ?></h6>
                                                                </div>
                                                                
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input submodule-checkbox" 
                                                                           type="checkbox" 
                                                                           id="select-all-<?php echo e($moduleSlug); ?>-<?php echo e($subModuleSlug); ?>"
                                                                           data-module="<?php echo e($moduleSlug); ?>"
                                                                           data-submodule="<?php echo e($moduleSlug); ?>-<?php echo e($subModuleSlug); ?>">
                                                                    <label class="form-check-label fw-semibold text-primary" for="select-all-<?php echo e($moduleSlug); ?>-<?php echo e($subModuleSlug); ?>">
                                                                        <?php echo e(__('admin.permissions.all')); ?>

                                                                    </label>
                                                                </div>

                                                                <hr class="my-2">

                                                                <?php $__currentLoopData = $subModulePermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <div class="form-check mb-2">
                                                                        <input class="form-check-input permission-checkbox permission-<?php echo e($moduleSlug); ?>-<?php echo e($subModuleSlug); ?>" 
                                                                               type="checkbox" 
                                                                               name="permissions[]"
                                                                               value="<?php echo e($permission->id); ?>" 
                                                                               id="permission-<?php echo e($permission->id); ?>"
                                                                               data-module="<?php echo e($moduleSlug); ?>"
                                                                               data-submodule="<?php echo e($moduleSlug); ?>-<?php echo e($subModuleSlug); ?>"
                                                                               <?php echo e(in_array($permission->id, $adminPermissions) ? 'checked' : ''); ?>>
                                                                        <label class="form-check-label" for="permission-<?php echo e($permission->id); ?>">
                                                                            <strong><?php echo e($permission->display_name); ?></strong>
                                                                            <?php if($permission->description): ?>
                                                                                <br>
                                                                                <small class="text-muted"><?php echo e($permission->description); ?></small>
                                                                            <?php endif; ?>
                                                                        </label>
                                                                    </div>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="ti ti-shield-off ti-lg text-muted mb-3"></i>
                                <p class="text-muted"><?php echo e(__('admin.permissions.no_permissions')); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="card-footer d-flex flex-column flex-sm-row justify-content-between gap-2">
                        <a href="<?php echo e(route('admin.admins.index')); ?>" class="btn btn-label-secondary">
                            <i class="ti ti-arrow-left me-1"></i> <?php echo e(__('admin.common.back')); ?>

                        </a>
                        <?php if($permissions->count() > 0): ?>
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy me-1"></i> <?php echo e(__('admin.permissions.save')); ?>

                            </button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const globalCheckbox = document.getElementById('select-all-global');
        
        // Function to update global checkbox state
        function updateGlobalCheckbox() {
            if (!globalCheckbox) return;
            
            const allPermissions = document.querySelectorAll('.permission-checkbox');
            const checkedPermissions = document.querySelectorAll('.permission-checkbox:checked');
            
            if (allPermissions.length === checkedPermissions.length && allPermissions.length > 0) {
                globalCheckbox.checked = true;
                globalCheckbox.indeterminate = false;
            } else if (checkedPermissions.length > 0) {
                globalCheckbox.checked = false;
                globalCheckbox.indeterminate = true;
            } else {
                globalCheckbox.checked = false;
                globalCheckbox.indeterminate = false;
            }
        }
        
        // Function to update module checkbox state
        function updateModuleCheckbox(module) {
            const moduleCheckbox = document.querySelector('.module-checkbox[data-module="' + module + '"]');
            if (!moduleCheckbox) return;
            
            const allPermissions = document.querySelectorAll('.permission-checkbox[data-module="' + module + '"]');
            const checkedPermissions = document.querySelectorAll('.permission-checkbox[data-module="' + module + '"]:checked');
            
            if (allPermissions.length === checkedPermissions.length && allPermissions.length > 0) {
                moduleCheckbox.checked = true;
                moduleCheckbox.indeterminate = false;
            } else if (checkedPermissions.length > 0) {
                moduleCheckbox.checked = false;
                moduleCheckbox.indeterminate = true;
            } else {
                moduleCheckbox.checked = false;
                moduleCheckbox.indeterminate = false;
            }
        }
        
        // Function to update submodule checkbox state
        function updateSubmoduleCheckbox(submodule) {
            const submoduleCheckbox = document.querySelector('.submodule-checkbox[data-submodule="' + submodule + '"]');
            if (!submoduleCheckbox) return;
            
            const allPermissions = document.querySelectorAll('.permission-checkbox[data-submodule="' + submodule + '"]');
            const checkedPermissions = document.querySelectorAll('.permission-checkbox[data-submodule="' + submodule + '"]:checked');
            
            if (allPermissions.length === checkedPermissions.length && allPermissions.length > 0) {
                submoduleCheckbox.checked = true;
                submoduleCheckbox.indeterminate = false;
            } else if (checkedPermissions.length > 0) {
                submoduleCheckbox.checked = false;
                submoduleCheckbox.indeterminate = true;
            } else {
                submoduleCheckbox.checked = false;
                submoduleCheckbox.indeterminate = false;
            }
        }
        
        // Update all parent checkboxes
        function updateAllParentCheckboxes(module, submodule) {
            updateSubmoduleCheckbox(submodule);
            updateModuleCheckbox(module);
            updateGlobalCheckbox();
        }

        // Global Select All
        if (globalCheckbox) {
            globalCheckbox.addEventListener('change', function() {
                const isChecked = this.checked;
                
                // Update all permission checkboxes
                document.querySelectorAll('.permission-checkbox').forEach(function(permCheckbox) {
                    permCheckbox.checked = isChecked;
                });
                
                // Update all submodule checkboxes
                document.querySelectorAll('.submodule-checkbox').forEach(function(subCheckbox) {
                    subCheckbox.checked = isChecked;
                    subCheckbox.indeterminate = false;
                });
                
                // Update all module checkboxes
                document.querySelectorAll('.module-checkbox').forEach(function(modCheckbox) {
                    modCheckbox.checked = isChecked;
                    modCheckbox.indeterminate = false;
                });
            });
        }

        // Module Select All
        document.querySelectorAll('.module-checkbox').forEach(function(moduleCheckbox) {
            moduleCheckbox.addEventListener('change', function() {
                const module = this.dataset.module;
                const isChecked = this.checked;
                
                // Update all permission checkboxes in this module
                document.querySelectorAll('.permission-checkbox[data-module="' + module + '"]').forEach(function(permCheckbox) {
                    permCheckbox.checked = isChecked;
                });
                
                // Update all submodule checkboxes in this module
                document.querySelectorAll('.submodule-checkbox[data-module="' + module + '"]').forEach(function(subCheckbox) {
                    subCheckbox.checked = isChecked;
                    subCheckbox.indeterminate = false;
                });
                
                // Update global checkbox
                updateGlobalCheckbox();
            });
        });

        // Submodule Select All
        document.querySelectorAll('.submodule-checkbox').forEach(function(submoduleCheckbox) {
            submoduleCheckbox.addEventListener('change', function() {
                const submodule = this.dataset.submodule;
                const module = this.dataset.module;
                const isChecked = this.checked;
                
                // Update all permission checkboxes in this submodule
                document.querySelectorAll('.permission-checkbox[data-submodule="' + submodule + '"]').forEach(function(permCheckbox) {
                    permCheckbox.checked = isChecked;
                });
                
                // Update module checkbox and global checkbox
                updateModuleCheckbox(module);
                updateGlobalCheckbox();
            });
        });

        // Individual permission change
        document.querySelectorAll('.permission-checkbox').forEach(function(permCheckbox) {
            permCheckbox.addEventListener('change', function() {
                const module = this.dataset.module;
                const submodule = this.dataset.submodule;
                
                // Update all parent checkboxes
                updateAllParentCheckboxes(module, submodule);
            });
        });

        // Initialize all checkbox states on page load
        document.querySelectorAll('.submodule-checkbox').forEach(function(submoduleCheckbox) {
            const submodule = submoduleCheckbox.dataset.submodule;
            updateSubmoduleCheckbox(submodule);
        });
        
        document.querySelectorAll('.module-checkbox').forEach(function(moduleCheckbox) {
            const module = moduleCheckbox.dataset.module;
            updateModuleCheckbox(module);
        });
        
        updateGlobalCheckbox();
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\admin\admins\permissions.blade.php ENDPATH**/ ?>