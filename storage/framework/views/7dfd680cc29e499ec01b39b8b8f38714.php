

<?php $__env->startSection('title', 'Kelola Permission Admin'); ?>

<?php $__env->startSection('content'); ?>

    <!-- Success/Error Messages -->
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil!</strong> <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Page Header -->
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(route('admin.admins.index')); ?>">Manajemen Admin</a>
                </li>
                <li class="breadcrumb-item active">Kelola Permission</li>
            </ol>
        </nav>
        <h4 class="fw-bold py-3 mb-2">
            <span class="text-muted fw-light">Pengaturan /</span> Kelola Permission Admin
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
                        Kelola Permission
                    </h5>
                    <p class="text-muted mb-0 mt-2">Pilih permission yang akan diberikan kepada admin ini. Super Admin memiliki semua akses secara otomatis.</p>
                </div>

                <form action="<?php echo e(route('admin.admins.permissions.update', $admin->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="card-body">
                        <?php if($permissions->count() > 0): ?>
                            <div class="row">
                                <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module => $subModules): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $moduleSlug = Str::slug($module);
                                    ?>
                                    <div class="col-12 mb-4">
                                        <div class="card">
                                            <div class="card-header bg-label-primary">
                                                <h5 class="mb-0">
                                                    <i class="ti ti-folder me-2"></i>
                                                    <?php echo e($module); ?>

                                                </h5>
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
                                                                           data-submodule="<?php echo e($moduleSlug); ?>-<?php echo e($subModuleSlug); ?>">
                                                                    <label class="form-check-label fw-semibold text-primary" for="select-all-<?php echo e($moduleSlug); ?>-<?php echo e($subModuleSlug); ?>">
                                                                        All
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
                                <p class="text-muted">Belum ada permission yang tersedia. Silakan tambahkan permission terlebih dahulu.</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="card-footer d-flex justify-content-between">
                        <a href="<?php echo e(route('admin.admins.index')); ?>" class="btn btn-label-secondary">
                            <i class="ti ti-arrow-left me-1"></i> Kembali
                        </a>
                        <?php if($permissions->count() > 0): ?>
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy me-1"></i> Simpan Permission
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
        // Function to update submodule checkbox state
        function updateSubmoduleCheckbox(submodule) {
            const submoduleCheckbox = document.querySelector('[data-submodule="' + submodule + '"]');
            if (!submoduleCheckbox) {
                console.log('Submodule checkbox not found:', submodule);
                return;
            }
            
            const allPermissions = document.querySelectorAll('.permission-' + submodule);
            const checkedPermissions = document.querySelectorAll('.permission-' + submodule + ':checked');
            
            console.log('Submodule:', submodule, 'Total:', allPermissions.length, 'Checked:', checkedPermissions.length);
            
            if (allPermissions.length === checkedPermissions.length && allPermissions.length > 0) {
                // All checked
                submoduleCheckbox.checked = true;
                submoduleCheckbox.indeterminate = false;
            } else if (checkedPermissions.length > 0) {
                // Some checked
                submoduleCheckbox.checked = false;
                submoduleCheckbox.indeterminate = true;
            } else {
                // None checked
                submoduleCheckbox.checked = false;
                submoduleCheckbox.indeterminate = false;
            }
        }

        // Select/Deselect all in a sub-module
        document.querySelectorAll('.submodule-checkbox').forEach(function(submoduleCheckbox) {
            submoduleCheckbox.addEventListener('click', function(e) {
                const submodule = this.dataset.submodule;
                const isChecked = this.checked;
                
                console.log('All checkbox clicked for:', submodule, 'New state:', isChecked);
                
                document.querySelectorAll('.permission-' + submodule).forEach(function(permCheckbox) {
                    permCheckbox.checked = isChecked;
                });
                
                // Update state immediately after changing all checkboxes
                updateSubmoduleCheckbox(submodule);
            });
        });

        // Update sub-module checkbox when individual permissions change
        document.querySelectorAll('.permission-checkbox').forEach(function(permCheckbox) {
            permCheckbox.addEventListener('change', function() {
                const classList = Array.from(this.classList);
                const submoduleClass = classList.find(c => c.startsWith('permission-'));
                
                if (submoduleClass) {
                    const submodule = submoduleClass.replace('permission-', '');
                    console.log('Individual checkbox changed, updating:', submodule);
                    updateSubmoduleCheckbox(submodule);
                }
            });
        });

        // Initialize state on page load
        console.log('Initializing checkboxes...');
        document.querySelectorAll('.submodule-checkbox').forEach(function(submoduleCheckbox) {
            const submodule = submoduleCheckbox.dataset.submodule;
            updateSubmoduleCheckbox(submodule);
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views/admin/admins/permissions.blade.php ENDPATH**/ ?>