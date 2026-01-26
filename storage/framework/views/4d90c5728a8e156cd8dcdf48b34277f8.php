

<?php $__env->startSection('title', __('admin.permissions.matrix_title', ['default' => 'Admin Permissions Matrix'])); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        
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
                <h4 class="fw-bold py-3 mb-0">
                    <span class="text-muted fw-light"><?php echo e(__('admin.menu.admin')); ?> /</span> 
                    Permissions Matrix
                </h4>
                <small class="text-muted">Manage permissions for all admins in one place</small>
            </div>
            <div>
                <a href="<?php echo e(route('admin.admins.index')); ?>" class="btn btn-secondary">
                    <i class="ti ti-arrow-left me-1"></i> Back to Admins
                </a>
            </div>
        </div>

        <!-- Search -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text"><i class="ti ti-search"></i></span>
                            <input type="text" class="form-control" name="search" 
                                   value="<?php echo e(request('search')); ?>" placeholder="Search admin by name or email...">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="ti ti-search me-1"></i> Search
                        </button>
                    </div>
                    <?php if(request('search')): ?>
                        <div class="col-md-2">
                            <a href="<?php echo e(route('admin.admin-permissions-matrix.index')); ?>" class="btn btn-outline-secondary w-100">
                                <i class="ti ti-x me-1"></i> Clear
                            </a>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <?php if($admins->count() > 0): ?>
            <!-- Permission Templates -->
            <?php if(!empty($templates)): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="ti ti-template me-2"></i>Quick Templates</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-2">
                            <?php $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-outline-primary btn-sm template-btn" 
                                            data-template="<?php echo e($key); ?>">
                                        <i class="ti ti-<?php echo e($template['icon'] ?? 'shield'); ?> me-1"></i>
                                        <?php echo e($template['name']); ?>

                                    </button>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Permissions Matrix Table -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="ti ti-table me-2"></i>Permissions Matrix</h5>
                    <div>
                        <span class="badge bg-label-info"><?php echo e($admins->count()); ?> Admins</span>
                        <span class="badge bg-label-primary"><?php echo e($permissions->flatten()->count()); ?> Permissions</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="permissionsMatrix">
                            <thead class="table-light">
                                <tr>
                                    <th class="sticky-col" style="min-width: 200px;">Admin</th>
                                    <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $groupPermissions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php $__currentLoopData = $groupPermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <th class="text-center" style="min-width: 100px;" 
                                                data-bs-toggle="tooltip" title="<?php echo e($permission->description ?? $permission->display_name); ?>">
                                                <small><?php echo e(Str::limit($permission->display_name, 15)); ?></small>
                                            </th>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $admins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="sticky-col">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm me-2">
                                                    <?php if($admin->avatar): ?>
                                                        <img src="<?php echo e($admin->avatar_url); ?>" alt="Avatar" class="rounded-circle">
                                                    <?php else: ?>
                                                        <span class="avatar-initial rounded-circle bg-label-primary">
                                                            <?php echo e(strtoupper(substr($admin->name, 0, 2))); ?>

                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                                <div>
                                                    <strong><?php echo e($admin->name); ?></strong>
                                                    <br><small class="text-muted"><?php echo e($admin->email); ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $groupPermissions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php $__currentLoopData = $groupPermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <td class="text-center">
                                                    <div class="form-check d-flex justify-content-center">
                                                        <input type="checkbox" 
                                                               class="form-check-input permission-checkbox"
                                                               data-admin-id="<?php echo e($admin->id); ?>"
                                                               data-permission-id="<?php echo e($permission->id); ?>"
                                                               <?php echo e($admin->permissions->contains('id', $permission->id) ? 'checked' : ''); ?>

                                                               <?php if($admin->isSuperAdmin()): ?> disabled title="Superadmin has all permissions" <?php endif; ?>>
                                                    </div>
                                                </td>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="ti ti-users-minus ti-xl text-muted mb-3"></i>
                    <h5 class="text-muted">No admins found</h5>
                    <p class="text-muted">Try adjusting your search criteria.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .sticky-col {
        position: sticky;
        left: 0;
        background: white;
        z-index: 1;
    }
    
    thead .sticky-col {
        z-index: 2;
    }
    
    .permission-checkbox {
        cursor: pointer;
        width: 18px;
        height: 18px;
    }
    
    .permission-checkbox:disabled {
        cursor: not-allowed;
        opacity: 0.5;
    }
    
    #permissionsMatrix {
        font-size: 0.875rem;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function(tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Handle permission checkbox changes
        document.querySelectorAll('.permission-checkbox').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const adminId = this.dataset.adminId;
                const permissionId = this.dataset.permissionId;
                const action = this.checked ? 'attach' : 'detach';
                
                // Show loading state
                this.disabled = true;
                
                fetch('<?php echo e(route("admin.admin-permissions-matrix.update-permission")); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                    },
                    body: JSON.stringify({
                        admin_id: adminId,
                        permission_id: permissionId,
                        action: action
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success toast/notification
                        showNotification('success', data.message);
                    } else {
                        // Revert checkbox state
                        this.checked = !this.checked;
                        showNotification('error', data.message || 'Failed to update permission');
                    }
                })
                .catch(error => {
                    // Revert checkbox state
                    this.checked = !this.checked;
                    showNotification('error', 'An error occurred');
                    console.error('Error:', error);
                })
                .finally(() => {
                    this.disabled = false;
                });
            });
        });

        function showNotification(type, message) {
            // You can implement a toast notification here
            console.log(type + ': ' + message);
        }
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\admin\admin-permissions-matrix\index.blade.php ENDPATH**/ ?>