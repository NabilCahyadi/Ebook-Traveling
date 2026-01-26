<?php $__env->startSection('title', __('admin.users.add_user')); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light"><?php echo e(__('admin.menu.user_management')); ?> /</span> <?php echo e(__('admin.users.add_user')); ?>

            </h4>
            <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-secondary">
                <i class="ti ti-arrow-left me-1"></i> <?php echo e(__('admin.manual_subscription.back_to_list')); ?>

            </a>
        </div>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <strong><?php echo e(__('admin.messages.error_title')); ?></strong> <?php echo e(__('admin.messages.validation_error')); ?>

                <ul class="mb-0 mt-2">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <form action="<?php echo e(route('admin.users.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>

                    <div class="row">
                        <!-- Name -->
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label"><?php echo e(__('admin.form.name')); ?> <span class="text-danger">*</span></label>
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

                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label"><?php echo e(__('admin.form.email')); ?> <span class="text-danger">*</span></label>
                            <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="email"
                                name="email" value="<?php echo e(old('email')); ?>" required>
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

                        <!-- Phone -->
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label"><?php echo e(__('admin.users.phone')); ?></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="phone"
                                name="phone" value="<?php echo e(old('phone')); ?>" placeholder="<?php echo e(__('admin.common.optional')); ?>">
                            <?php $__errorArgs = ['phone'];
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

                        <!-- Role -->
                        <div class="col-md-6 mb-3">
                            <label for="role_selector" class="form-label"><?php echo e(__('admin.form.role')); ?> <span class="text-danger">*</span></label>
                            <?php
                                $roles = \App\Models\Role::all();
                                $selectedRoles = old('roles', $roleSlug ? [$roleSlug] : []);
                            ?>
                            <select class="form-select <?php $__errorArgs = ['roles'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> <?php $__errorArgs = ['roles.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                id="role_selector">
                                <option value="">Select Role</option>
                                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($role->slug); ?>" data-name="<?php echo e($role->name); ?>">
                                        <?php echo e($role->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            
                            <!-- Selected Roles Display -->
                            <div id="selected-roles" class="mt-2">
                                <!-- Badges will appear here -->
                            </div>
                            
                            <!-- Hidden inputs for form submission -->
                            <div id="role-inputs"></div>
                            
                            <?php $__errorArgs = ['roles'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <?php $__errorArgs = ['roles.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Password -->
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label"><?php echo e(__('admin.form.password')); ?> <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="password" name="password" required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="ti ti-eye" id="togglePasswordIcon"></i>
                                </button>
                            </div>
                            <small class="text-muted">Minimum 8 characters</small>
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Confirm Password -->
                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label"><?php echo e(__('admin.form.password_confirmation')); ?> <span
                                    class="text-danger">*</span></label>
                            <input type="password" class="form-control <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="password_confirmation" name="password_confirmation" required>
                            <?php $__errorArgs = ['password_confirmation'];
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
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-check me-1"></i> <?php echo e(__('admin.users.add_user')); ?>

                        </button>
                        <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-label-secondary">
                            <?php echo e(__('admin.actions.cancel')); ?>

                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
        <script>
            // Toggle password visibility
            document.getElementById('togglePassword').addEventListener('click', function() {
                const password = document.getElementById('password');
                const icon = document.getElementById('togglePasswordIcon');

                if (password.type === 'password') {
                    password.type = 'text';
                    icon.classList.remove('ti-eye');
                    icon.classList.add('ti-eye-off');
                } else {
                    password.type = 'password';
                    icon.classList.remove('ti-eye-off');
                    icon.classList.add('ti-eye');
                }
            });

            // Role selection handler
            const selectedRoles = new Map();
            
            // Restore old values on validation errors
            <?php if(old('roles')): ?>
                <?php $__currentLoopData = old('roles'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $roleSlug): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $role = \App\Models\Role::where('slug', $roleSlug)->first();
                    ?>
                    <?php if($role): ?>
                        selectedRoles.set('<?php echo e($roleSlug); ?>', '<?php echo e($role->name); ?>');
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php elseif(isset($roleSlug) && $roleSlug): ?>
                <?php
                    $role = \App\Models\Role::where('slug', $roleSlug)->first();
                ?>
                <?php if($role): ?>
                    selectedRoles.set('<?php echo e($roleSlug); ?>', '<?php echo e($role->name); ?>');
                <?php endif; ?>
            <?php endif; ?>
            
            // Render existing selections
            function renderRoleSelection() {
                const container = document.getElementById('selected-roles');
                const inputsContainer = document.getElementById('role-inputs');
                container.innerHTML = '';
                inputsContainer.innerHTML = '';
                
                selectedRoles.forEach((name, slug) => {
                    // Create badge
                    const badge = document.createElement('span');
                    badge.className = 'role-badge';
                    badge.innerHTML = `
                        ${name}
                        <button type="button" class="badge-remove" data-slug="${slug}">
                            <i class="ti ti-x"></i>
                        </button>
                    `;
                    container.appendChild(badge);
                    
                    // Create hidden input
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'roles[]';
                    input.value = slug;
                    inputsContainer.appendChild(input);
                });
                
                // Add remove handlers
                document.querySelectorAll('.badge-remove').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const slug = this.dataset.slug;
                        selectedRoles.delete(slug);
                        renderRoleSelection();
                        
                        // Re-enable option in select
                        const option = document.querySelector(`#role_selector option[value="${slug}"]`);
                        if (option) option.disabled = false;
                    });
                });
            }
            
            // Role selector change event
            document.getElementById('role_selector').addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption.value) {
                    const slug = selectedOption.value;
                    const name = selectedOption.dataset.name;
                    
                    if (!selectedRoles.has(slug)) {
                        selectedRoles.set(slug, name);
                        renderRoleSelection();
                        selectedOption.disabled = true;
                    }
                    
                    this.value = '';
                }
            });
            
            // Initial render
            renderRoleSelection();
        </script>
    <?php $__env->stopPush(); ?>

    <?php $__env->startPush('styles'); ?>
        <style>
            .role-badge {
                display: inline-flex;
                align-items: center;
                background-color: #e0f0ff;
                border: 1px solid #7eb3ff;
                border-radius: 4px;
                padding: 4px 8px;
                margin-right: 6px;
                margin-bottom: 6px;
                font-size: 13px;
                color: #0056b3;
            }
            
            .role-badge .badge-remove {
                background: none;
                border: none;
                color: #0056b3;
                cursor: pointer;
                padding: 0;
                margin-left: 6px;
                display: inline-flex;
                align-items: center;
                font-size: 14px;
                line-height: 1;
            }
            
            .role-badge .badge-remove:hover {
                color: #003d82;
            }
            
            .role-badge .badge-remove i {
                font-size: 14px;
            }
        </style>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views/admin/users/create.blade.php ENDPATH**/ ?>