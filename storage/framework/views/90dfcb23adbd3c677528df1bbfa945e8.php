<?php $__env->startSection('title', __('admin.users.title')); ?>

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
                <span class="text-muted fw-light"><?php echo e(__('admin.menu.admin')); ?> /</span> <?php echo e(__('admin.users.title')); ?>

                <?php if(isset($roleSlug) && $roleSlug): ?>
                    <span class="badge bg-label-primary ms-2">
                        <?php echo e(ucfirst(str_replace('-', ' ', $roleSlug))); ?>

                    </span>
                <?php endif; ?>
                <?php if($showTrashed ?? false): ?>
                    <span class="badge bg-label-danger ms-2"><?php echo e(__('admin.users.trashed_users')); ?></span>
                <?php endif; ?>
            </h4>
        </div>
        <div>
            <?php if($showTrashed ?? false): ?>
                <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-secondary me-2">
                    <i class="ti ti-arrow-left me-1"></i> <?php echo e(__('admin.users.back_to_active')); ?>

                </a>
            <?php else: ?>
                <a href="<?php echo e(route('admin.users.trashed')); ?>" class="btn btn-outline-danger me-2">
                    <i class="ti ti-trash me-1"></i> <?php echo e(__('admin.users.view_trashed')); ?>

                </a>
            <?php endif; ?>
            <a href="<?php echo e(route('admin.users.create', ['role' => $roleSlug ?? ''])); ?>" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i> <?php echo e(__('admin.users.add_user')); ?>

                <?php if(isset($roleSlug) && $roleSlug && $roleSlug !== 'all'): ?>
                    <?php echo e(ucfirst($roleSlug)); ?>

                <?php else: ?>
                    <?php echo e(__('admin.users.user')); ?>

                <?php endif; ?>
            </a>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card">
        <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
            <div>
                <h5 class="mb-0"><?php echo e(__('admin.users.users_list')); ?></h5>
                <div class="text-muted small"><?php echo e(__('admin.common.total')); ?>: <?php echo e($users->total()); ?> <?php echo e(__('admin.users.users')); ?></div>
            </div>
            <a href="<?php echo e(route('admin.users.export', request()->all())); ?>" class="btn btn-success btn-sm">
                <i class="ti ti-download me-1"></i>
                <?php echo e(__('admin.common.export')); ?>

            </a>
        </div>

        <!-- Search Filter -->
        <div class="card-body border-bottom">
            <form action="<?php echo e(route('admin.users.index')); ?>" method="GET" class="row g-3 align-items-end">
                <?php if(isset($roleSlug) && $roleSlug): ?>
                    <input type="hidden" name="role" value="<?php echo e($roleSlug); ?>">
                <?php endif; ?>
                
                <!-- Google ID Filter -->
                <div class="col-6 col-md-2">
                    <label class="form-label"><?php echo e(__('admin.users.filter_by_google_id')); ?></label>
                    <select name="google_id" class="form-select">
                        <option value=""><?php echo e(__('admin.users.all_accounts')); ?></option>
                        <option value="linked" <?php echo e(request('google_id') == 'linked' ? 'selected' : ''); ?>>
                            <?php echo e(__('admin.users.google_linked')); ?>

                        </option>
                        <option value="regular" <?php echo e(request('google_id') == 'regular' ? 'selected' : ''); ?>>
                            <?php echo e(__('admin.users.regular_account')); ?>

                        </option>
                    </select>
                </div>

                <!-- Registered Time Filter -->
                <div class="col-6 col-md-2">
                    <label class="form-label"><?php echo e(__('admin.users.filter_by_registered')); ?></label>
                    <select name="registered" class="form-select">
                        <option value=""><?php echo e(__('admin.users.all_time')); ?></option>
                        <option value="today" <?php echo e(request('registered') == 'today' ? 'selected' : ''); ?>>
                            <?php echo e(__('admin.users.today')); ?>

                        </option>
                        <option value="week" <?php echo e(request('registered') == 'week' ? 'selected' : ''); ?>>
                            <?php echo e(__('admin.users.this_week')); ?>

                        </option>
                        <option value="month" <?php echo e(request('registered') == 'month' ? 'selected' : ''); ?>>
                            <?php echo e(__('admin.users.this_month')); ?>

                        </option>
                        <option value="year" <?php echo e(request('registered') == 'year' ? 'selected' : ''); ?>>
                            <?php echo e(__('admin.users.this_year')); ?>

                        </option>
                    </select>
                </div>

                <!-- User Type Filter -->
                <div class="col-6 col-md-2">
                    <label class="form-label"><?php echo e(__('admin.users.filter_by_subscription')); ?></label>
                    <select name="user_type" class="form-select">
                        <option value=""><?php echo e(__('admin.users.all_subscriptions')); ?></option>
                        <option value="free_user" <?php echo e(request('user_type') == 'free_user' ? 'selected' : ''); ?>>
                            <?php echo e(__('admin.users.free_user')); ?>

                        </option>
                        <option value="member" <?php echo e(request('user_type') == 'member' ? 'selected' : ''); ?>>
                            <?php echo e(__('admin.users.premium_member')); ?>

                        </option>
                    </select>
                </div>

                <!-- Search -->
                <div class="col-12 col-md-4">
                    <label class="form-label"><?php echo e(__('admin.users.search')); ?></label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="ti ti-search"></i>
                        </span>
                        <input type="text" class="form-control" name="search" value="<?php echo e($search ?? ''); ?>"
                            placeholder="<?php echo e(__('admin.users.search_placeholder')); ?>">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="col-6 col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="ti ti-filter me-1"></i> <?php echo e(__('admin.common.filter')); ?>

                    </button>
                </div>

                <!-- Clear Filter -->
                <?php if(request('search') || request('google_id') || request('registered') || request('user_type')): ?>
                    <div class="col-12">
                        <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-sm btn-outline-secondary">
                            <i class="ti ti-x me-1"></i> <?php echo e(__('admin.common.clear_filters')); ?>

                        </a>
                        <span class="text-muted ms-2">
                            <?php if(request('search')): ?>
                                Search: <strong>"<?php echo e(request('search')); ?>"</strong>
                            <?php endif; ?>
                            <?php if(request('google_id')): ?>
                                | Google ID: <strong><?php echo e(request('google_id') == 'linked' ? 'Linked' : 'Regular Account'); ?></strong>
                            <?php endif; ?>
                            <?php if(request('registered')): ?>
                                | Registered: <strong><?php echo e(ucfirst(request('registered'))); ?></strong>
                            <?php endif; ?>
                            <?php if(request('user_type')): ?>
                                | Type: <strong><?php echo e(request('user_type') == 'free_user' ? 'Free User' : 'Premium Member'); ?></strong>
                            <?php endif; ?>
                        </span>
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
                                <th><?php echo e(__('admin.form.name')); ?></th>
                                <th><?php echo e(__('admin.form.email')); ?></th>
                                <th class="d-none d-md-table-cell"><?php echo e(__('admin.users.roles')); ?></th>
                                <th class="d-none d-lg-table-cell"><?php echo e(__('admin.users.google_id')); ?></th>
                                <th class="d-none d-lg-table-cell"><?php echo e(__('admin.users.registered')); ?></th>
                                <th><?php echo e(__('admin.common.actions')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr <?php if($user->trashed()): ?> class="table-danger" <?php endif; ?>>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-2">
                                                <span class="avatar-initial rounded-circle" style="background-color: rgba(236, 72, 153, 0.2); border: none; color: #ec4899; font-weight: 600;">
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
                                    </td>
                                    <td class="d-none d-md-table-cell">
                                        <?php if($user->roles && $user->roles->count() > 0): ?>
                                            <?php $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $badgeColors = [
                                                        'Creator' => 'bg-label-success',
                                                        'Reader' => 'bg-label-info',
                                                        'Admin' => 'bg-label-danger',
                                                        'Super Admin' => 'bg-label-primary',
                                                    ];
                                                    $badgeClass = $badgeColors[$role->name] ?? 'bg-label-warning';
                                                ?>
                                                <span class="badge <?php echo e($badgeClass); ?> mb-1"><?php echo e($role->name); ?></span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            <span class="badge bg-label-secondary"><?php echo e(__('admin.users.no_role')); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="d-none d-lg-table-cell">
                                        <?php if($user->google_id): ?>
                                            <span class="badge bg-label-info">
                                                <i class="ti ti-brand-google ti-xs"></i> <?php echo e(__('admin.users.linked')); ?>

                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-label-secondary">
                                                <i class="ti ti-user ti-xs"></i> <?php echo e(__('admin.users.regular')); ?>

                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="d-none d-lg-table-cell">
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
                                                        <span><?php echo e(__('admin.actions.edit')); ?></span>
                                                    </a>
                                                    <a class="dropdown-item"
                                                        href="<?php echo e(route('admin.users.show', $user->id)); ?>">
                                                        <i class="ti ti-eye me-2"></i>
                                                        <span><?php echo e(__('admin.users.view_details')); ?></span>
                                                    </a>
                                                    <?php if($user->id !== auth()->id()): ?>
                                                        <div class="dropdown-divider"></div>
                                                        <?php if(!$user->email_verified_at): ?>
                                                            <a class="dropdown-item text-success" href="javascript:void(0);"
                                                                onclick="event.preventDefault(); if(confirm('Are you sure you want to verify this user email?')) document.getElementById('verify-form-<?php echo e($user->id); ?>').submit();">
                                                                <i class="ti ti-circle-check me-2"></i>
                                                                <span>Verify Email</span>
                                                            </a>
                                                            <form id="verify-form-<?php echo e($user->id); ?>"
                                                                action="<?php echo e(route('admin.users.verify-email', $user->id)); ?>"
                                                                method="POST" style="display: none;">
                                                                <?php echo csrf_field(); ?>
                                                                <?php echo method_field('PATCH'); ?>
                                                            </form>
                                                        <?php else: ?>
                                                            <a class="dropdown-item text-secondary" href="javascript:void(0);"
                                                                onclick="event.preventDefault(); if(confirm('Are you sure you want to unverify this user email?')) document.getElementById('unverify-form-<?php echo e($user->id); ?>').submit();">
                                                                <i class="ti ti-circle-x me-2"></i>
                                                                <span>Unverify Email</span>
                                                            </a>
                                                            <form id="unverify-form-<?php echo e($user->id); ?>"
                                                                action="<?php echo e(route('admin.users.unverify-email', $user->id)); ?>"
                                                                method="POST" style="display: none;">
                                                                <?php echo csrf_field(); ?>
                                                                <?php echo method_field('PATCH'); ?>
                                                            </form>
                                                        <?php endif; ?>
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
                    <a href="<?php echo e(route('admin.users.create', ['role' => $roleSlug ?? ''])); ?>" class="btn btn-primary mt-2">
                        <i class="ti ti-plus me-1"></i> Add New 
                        <?php if(isset($roleSlug) && $roleSlug && $roleSlug !== 'all'): ?>
                            <?php echo e(ucfirst($roleSlug)); ?>

                        <?php else: ?>
                            User
                        <?php endif; ?>
                    </a>
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