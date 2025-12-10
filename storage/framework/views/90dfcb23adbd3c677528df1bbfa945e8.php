<?php $__env->startSection('title', 'User Management'); ?>

<?php $__env->startSection('content'); ?>

    <!-- Success/Error Messages -->
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> <?php echo e(session('success')); ?>

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
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold py-3 mb-2">
                <span class="text-muted fw-light">Admin /</span> User Management
                <?php if(isset($roleSlug) && $roleSlug): ?>
                    <span class="badge bg-label-primary ms-2">
                        <?php echo e(ucfirst(str_replace('-', ' ', $roleSlug))); ?>

                    </span>
                <?php endif; ?>
                <?php if($showTrashed ?? false): ?>
                    <span class="badge bg-label-danger ms-2">Trashed Users</span>
                <?php endif; ?>
            </h4>
        </div>
        <div>
            <?php if($showTrashed ?? false): ?>
                <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-secondary me-2">
                    <i class="ti ti-arrow-left me-1"></i> Back to Active Users
                </a>
            <?php else: ?>
                <a href="<?php echo e(route('admin.users.trashed')); ?>" class="btn btn-outline-danger me-2">
                    <i class="ti ti-trash me-1"></i> View Trashed Users
                </a>
            <?php endif; ?>
            <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i> Add New User
            </a>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Users List</h5>
            <div class="text-muted">Total: <?php echo e($users->total()); ?> users</div>
        </div>

        <!-- Search Filter -->
        <div class="card-body border-bottom">
            <form action="<?php echo e(route('admin.users.index')); ?>" method="GET" class="row g-3">
                <?php if(isset($roleSlug) && $roleSlug): ?>
                    <input type="hidden" name="role" value="<?php echo e($roleSlug); ?>">
                <?php endif; ?>
                <div class="col-md-10">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="ti ti-search"></i>
                        </span>
                        <input type="text" class="form-control" name="search" value="<?php echo e($search ?? ''); ?>"
                            placeholder="Search by name, email, or phone...">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="ti ti-search me-1"></i> Search
                    </button>
                </div>
                <?php if(isset($search) && $search): ?>
                    <div class="col-12">
                        <a href="<?php echo e(route('admin.users.index', ['role' => $roleSlug])); ?>"
                            class="btn btn-sm btn-outline-secondary">
                            <i class="ti ti-x me-1"></i> Clear Filter
                        </a>
                        <span class="text-muted ms-2">Showing results for: <strong>"<?php echo e($search); ?>"</strong></span>
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
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role(s)</th>
                                <th>Google ID</th>
                                <th>Registered</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr <?php if($user->trashed()): ?> class="table-danger" <?php endif; ?>>
                                    <td>
                                        <strong>#<?php echo e($user->id); ?></strong>
                                        <?php if($user->trashed()): ?>
                                            <span class="badge bg-label-danger ms-1">Deleted</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-2">
                                                <span class="avatar-initial rounded-circle bg-label-primary">
                                                    <?php echo e(substr($user->name, 0, 1)); ?>

                                                </span>
                                            </div>
                                            <div>
                                                <div class="fw-medium">
                                                    <?php echo e($user->name); ?>

                                                    <?php if($user->trashed()): ?>
                                                        <i class="ti ti-trash text-danger ms-1" title="Deleted"></i>
                                                    <?php endif; ?>
                                                </div>
                                                <?php if($user->id === auth()->id()): ?>
                                                    <small class="badge bg-label-success">You</small>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div><?php echo e($user->email); ?></div>
                                        <?php if($user->email_verified_at): ?>
                                            <small class="text-success">
                                                <i class="ti ti-check ti-xs"></i> Verified
                                            </small>
                                        <?php else: ?>
                                            <small class="text-muted">
                                                <i class="ti ti-x ti-xs"></i> Not verified
                                            </small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($user->roles && $user->roles->count() > 0): ?>
                                            <?php $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <span class="badge bg-label-primary mb-1"><?php echo e($role->name); ?></span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            <span class="badge bg-label-secondary">No Role</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($user->google_id): ?>
                                            <span class="badge bg-label-info">
                                                <i class="ti ti-brand-google ti-xs"></i> Linked
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-label-secondary">
                                                <i class="ti ti-user ti-xs"></i> Regular
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <?php echo e($user->created_at->format('d M Y')); ?><br>
                                            <?php echo e($user->created_at->format('H:i')); ?>

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
                                                <?php if(!$user->trashed()): ?>
                                                    
                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                        onclick="editUser('<?php echo e($user->id); ?>', '<?php echo e($user->name); ?>', '<?php echo e($user->email); ?>')">
                                                        <i class="ti ti-pencil me-2"></i>
                                                        <span>Edit</span>
                                                    </a>
                                                    <a class="dropdown-item"
                                                        href="<?php echo e(route('admin.users.show', $user->id)); ?>">
                                                        <i class="ti ti-eye me-2"></i>
                                                        <span>View Details</span>
                                                    </a>
                                                    <?php if($user->id !== auth()->id()): ?>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item text-warning" href="javascript:void(0);"
                                                            onclick="event.preventDefault(); if(confirm('Are you sure you want to move this user to trash?')) document.getElementById('delete-form-<?php echo e($user->id); ?>').submit();">
                                                            <i class="ti ti-trash me-2"></i>
                                                            <span>Move to Trash</span>
                                                        </a>
                                                        <form id="delete-form-<?php echo e($user->id); ?>"
                                                            action="<?php echo e(route('admin.users.destroy', $user->id)); ?>"
                                                            method="POST" style="display: none;">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('DELETE'); ?>
                                                        </form>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    
                                                    <a class="dropdown-item text-success" href="javascript:void(0);"
                                                        onclick="event.preventDefault(); if(confirm('Are you sure you want to restore this user?')) document.getElementById('restore-form-<?php echo e($user->id); ?>').submit();">
                                                        <i class="ti ti-restore me-2"></i>
                                                        <span>Restore</span>
                                                    </a>
                                                    <form id="restore-form-<?php echo e($user->id); ?>"
                                                        action="<?php echo e(route('admin.users.restore', $user->id)); ?>"
                                                        method="POST" style="display: none;">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PATCH'); ?>
                                                    </form>
                                                    <?php if($user->id !== auth()->id()): ?>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item text-danger" href="javascript:void(0);"
                                                            onclick="event.preventDefault(); if(confirm('Are you sure you want to permanently delete this user? This action cannot be undone!')) document.getElementById('force-delete-form-<?php echo e($user->id); ?>').submit();">
                                                            <i class="ti ti-trash-x me-2"></i>
                                                            <span>Delete Permanently</span>
                                                        </a>
                                                        <form id="force-delete-form-<?php echo e($user->id); ?>"
                                                            action="<?php echo e(route('admin.users.force-delete', $user->id)); ?>"
                                                            method="POST" style="display: none;">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('DELETE'); ?>
                                                        </form>
                                                    <?php endif; ?>
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
                    <?php echo e($users->appends(['role' => $roleSlug, 'search' => $search])->links()); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="ti ti-users-off ti-xl text-muted mb-3"></i>
                    <h5 class="text-muted">No users found</h5>
                    <p class="text-muted">Start by creating your first user</p>
                    <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal"
                        data-bs-target="#createModal">
                        <i class="ti ti-plus me-1"></i> Add New User
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="<?php echo e(route('admin.users.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-header">
                        <h5 class="modal-title">Create New User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="name"
                                name="name" value="<?php echo e(old('name')); ?>" placeholder="e.g. John Doe" required>
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
                            <label for="email" class="form-label">Email Address <span
                                    class="text-danger">*</span></label>
                            <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="email" name="email" value="<?php echo e(old('email')); ?>"
                                placeholder="e.g. user@example.com" required>
                            <?php $__errorArgs = ['email'];
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
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="password" name="password" placeholder="Min. 8 characters" required>
                            <?php $__errorArgs = ['password'];
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
                            <label for="password_confirmation" class="form-label">Confirm Password <span
                                    class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" placeholder="Retype password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-1"></i> Create User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="editForm" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="modal-header">
                        <h5 class="modal-title">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Full Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_name" name="name"
                                placeholder="e.g. John Doe" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_email" class="form-label">Email Address <span
                                    class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="edit_email" name="email"
                                placeholder="e.g. user@example.com" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="edit_password" name="password"
                                placeholder="Leave blank to keep current password">
                            <small class="text-muted">Only fill if you want to change password</small>
                        </div>
                        <div class="mb-3">
                            <label for="edit_password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="edit_password_confirmation"
                                name="password_confirmation" placeholder="Retype new password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-1"></i> Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
        <script>
            function editUser(id, name, email) {
                document.getElementById('editForm').action = '/admin/users/' + id;
                document.getElementById('edit_name').value = name;
                document.getElementById('edit_email').value = email;
                document.getElementById('edit_password').value = '';
                document.getElementById('edit_password_confirmation').value = '';
                new bootstrap.Modal(document.getElementById('editModal')).show();
            }

            // Show create modal if validation error exists
            <?php if($errors->any() && !old('_method')): ?>
                new bootstrap.Modal(document.getElementById('createModal')).show();
            <?php elseif($errors->any() && old('_method') === 'PUT'): ?>
                // Show edit modal if edit validation failed
                // You might need to pass user data back to show the modal
            <?php endif; ?>
        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views/admin/users/index.blade.php ENDPATH**/ ?>