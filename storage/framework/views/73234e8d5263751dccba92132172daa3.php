<?php $__env->startSection('title', __('admin.roles.title')); ?>

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
                <span class="text-muted fw-light"><?php echo e(__('admin.menu.admin')); ?> /</span> <?php echo e(__('admin.roles.title')); ?>

                <?php if($showTrashed ?? false): ?>
                    <span class="badge bg-label-danger ms-2"><?php echo e(__('admin.roles.trashed_roles')); ?></span>
                <?php endif; ?>
            </h4>
        </div>
        <div>
            <?php if($showTrashed ?? false): ?>
                <a href="<?php echo e(route('admin.roles.index')); ?>" class="btn btn-secondary me-2">
                    <i class="ti ti-arrow-left me-1"></i> <?php echo e(__('admin.roles.back_to_active')); ?>

                </a>
            <?php else: ?>
                <a href="<?php echo e(route('admin.roles.trashed')); ?>" class="btn btn-outline-danger me-2">
                    <i class="ti ti-trash me-1"></i> <?php echo e(__('admin.roles.view_trashed')); ?>

                </a>
            <?php endif; ?>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="ti ti-plus me-1"></i> <?php echo e(__('admin.roles.add_role')); ?>

            </button>
        </div>
    </div>

    <!-- Roles Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><?php echo e(__('admin.roles.roles_list')); ?></h5>
            <div class="text-muted">Total: <?php echo e($roles->total()); ?> roles</div>
        </div>
        <div class="card-body">
            <?php if($roles->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th><?php echo e(__('admin.form.name')); ?></th>
                                <th><?php echo e(__('admin.form.slug')); ?></th>
                                <th><?php echo e(__('admin.form.description')); ?></th>
                                <th><?php echo e(__('admin.form.status')); ?></th>
                                <th><?php echo e(__('admin.users.users')); ?></th>
                                <th><?php echo e(__('admin.roles.created')); ?></th>
                                <th><?php echo e(__('admin.ebooks.actions')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-2 bg-label-primary">
                                                <span class="avatar-initial rounded-circle">
                                                    <i class="ti ti-shield"></i>
                                                </span>
                                            </div>
                                            <strong><?php echo e($role->name); ?></strong>
                                        </div>
                                    </td>
                                    <td>
                                        <code><?php echo e($role->slug); ?></code>
                                    </td>
                                    <td>
                                        <small class="text-muted"><?php echo e($role->description ?? '-'); ?></small>
                                    </td>
                                    <td>
                                        <?php if($role->is_active): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-label-primary"><?php echo e($role->users_count ?? 0); ?></span>
                                    </td>
                                    <td>
                                        <small class="text-muted"><?php echo e($role->created_at->format('d M Y')); ?></small>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button"
                                                class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <?php if(!$role->trashed()): ?>
                                                    
                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                        onclick="editRole('<?php echo e($role->id); ?>', '<?php echo e($role->name); ?>', '<?php echo e($role->slug); ?>', '<?php echo e($role->description); ?>', <?php echo e($role->is_active ? 'true' : 'false'); ?>)">
                                                        <i class="ti ti-pencil me-2"></i>
                                                        <span>Edit</span>
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item text-warning" href="javascript:void(0);"
                                                        onclick="event.preventDefault(); if(confirm('Are you sure you want to move this role to trash?')) document.getElementById('delete-form-<?php echo e($role->id); ?>').submit();">
                                                        <i class="ti ti-trash me-2"></i>
                                                        <span>Move to Trash</span>
                                                    </a>
                                                    <form id="delete-form-<?php echo e($role->id); ?>"
                                                        action="<?php echo e(route('admin.roles.destroy', $role->id)); ?>"
                                                        method="POST" style="display: none;">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                    </form>
                                                <?php else: ?>
                                                    
                                                    <a class="dropdown-item text-success" href="javascript:void(0);"
                                                        onclick="event.preventDefault(); if(confirm('Are you sure you want to restore this role?')) document.getElementById('restore-form-<?php echo e($role->id); ?>').submit();">
                                                        <i class="ti ti-restore me-2"></i>
                                                        <span>Restore</span>
                                                    </a>
                                                    <form id="restore-form-<?php echo e($role->id); ?>"
                                                        action="<?php echo e(route('admin.roles.restore', $role->id)); ?>"
                                                        method="POST" style="display: none;">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PATCH'); ?>
                                                    </form>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item text-danger" href="javascript:void(0);"
                                                        onclick="event.preventDefault(); if(confirm('Are you sure you want to permanently delete this role? This action cannot be undone!')) document.getElementById('force-delete-form-<?php echo e($role->id); ?>').submit();">
                                                        <i class="ti ti-trash-x me-2"></i>
                                                        <span>Delete Permanently</span>
                                                    </a>
                                                    <form id="force-delete-form-<?php echo e($role->id); ?>"
                                                        action="<?php echo e(route('admin.roles.force-delete', $role->id)); ?>"
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
                    <?php echo e($roles->links()); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="ti ti-shield-off ti-xl text-muted mb-3"></i>
                    <h5 class="text-muted">No roles found</h5>
                    <p class="text-muted">Start by creating your first role.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo e(route('admin.roles.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Role Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="name"
                                name="name" value="<?php echo e(old('name')); ?>" required>
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug <small class="text-muted">(optional,
                                    auto-generated)</small></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="slug"
                                name="slug" value="<?php echo e(old('slug')); ?>">
                            <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="description" name="description"
                                rows="3"><?php echo e(old('description')); ?></textarea>
                            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                    value="1" <?php echo e(old('is_active', true) ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create Role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Role Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_slug" class="form-label">Slug</label>
                            <input type="text" class="form-control" id="edit_slug" name="slug">
                        </div>
                        <div class="mb-3">
                            <label for="edit_description" class="form-label">Description</label>
                            <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="edit_is_active" name="is_active"
                                    value="1">
                                <label class="form-check-label" for="edit_is_active">Active</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        function editRole(id, name, slug, description, isActive) {
            document.getElementById('editForm').action = '/admin/roles/' + id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_slug').value = slug;
            document.getElementById('edit_description').value = description;
            document.getElementById('edit_is_active').checked = isActive;

            var editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();
        }

        // Auto-generate slug from name
        document.getElementById('name').addEventListener('input', function() {
            var slug = this.value.toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '');
            document.getElementById('slug').value = slug;
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views/admin/roles/index.blade.php ENDPATH**/ ?>