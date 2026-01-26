<?php $__env->startSection('title', __('admin.admins.edit_admin')); ?>

<?php $__env->startSection('content'); ?>

    <!-- Page Header -->
    <div class="mb-4">
        <h4 class="fw-bold py-3 mb-2">
            <span class="text-muted fw-light">
                <a href="<?php echo e(route('admin.admins.index')); ?>" class="text-muted"><?php echo e(__('admin.admins.title')); ?></a> /
            </span> 
            <?php echo e(__('admin.admins.edit_admin')); ?>

        </h4>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><?php echo e(__('admin.admins.form_edit_admin')); ?></h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('admin.admins.update', $admin->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="mb-3">
                            <label for="name" class="form-label"><?php echo e(__('admin.admins.full_name')); ?> <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                id="name" name="name" value="<?php echo e(old('name', $admin->name)); ?>" required>
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
                            <label for="email" class="form-label"><?php echo e(__('admin.admins.email')); ?> <span class="text-danger">*</span></label>
                            <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                id="email" name="email" value="<?php echo e(old('email', $admin->email)); ?>" required>
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
                            <label for="phone" class="form-label"><?php echo e(__('admin.admins.phone_number')); ?></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                id="phone" name="phone" value="<?php echo e(old('phone', $admin->phone)); ?>">
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

                        <div class="mb-3">
                            <label for="type" class="form-label"><?php echo e(__('admin.admins.admin_type')); ?> <span class="text-danger">*</span></label>
                            <select class="form-select <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="type" name="type" required>
                                <option value=""><?php echo e(__('admin.admins.select_type')); ?></option>
                                <option value="admin" <?php echo e(old('type', $admin->type) === 'admin' ? 'selected' : ''); ?>><?php echo e(__('admin.admins.admin')); ?></option>
                                <option value="superadmin" <?php echo e(old('type', $admin->type) === 'superadmin' ? 'selected' : ''); ?>><?php echo e(__('admin.admins.super_admin')); ?></option>
                            </select>
                            <small class="form-text text-muted">
                                <?php echo e(__('admin.admins.superadmin_full_access')); ?>

                            </small>
                            <?php $__errorArgs = ['type'];
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
                            <label for="status" class="form-label"><?php echo e(__('admin.admins.status')); ?> <span class="text-danger">*</span></label>
                            <select class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="status" name="status" required>
                                <option value="active" <?php echo e(old('status', $admin->status) === 'active' ? 'selected' : ''); ?>><?php echo e(__('admin.admins.active')); ?></option>
                                <option value="inactive" <?php echo e(old('status', $admin->status) === 'inactive' ? 'selected' : ''); ?>><?php echo e(__('admin.admins.inactive')); ?></option>
                            </select>
                            <?php $__errorArgs = ['status'];
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

                        <hr class="my-4">

                        <div class="alert alert-warning">
                            <i class="ti ti-info-circle me-2"></i>
                            <strong><?php echo e(__('admin.admins.change_password')); ?></strong> - <?php echo e(__('admin.admins.leave_blank_password')); ?>

                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label"><?php echo e(__('admin.admins.new_password')); ?></label>
                            <input type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                id="password" name="password">
                            <small class="form-text text-muted"><?php echo e(__('admin.admins.min_8_chars')); ?>. <?php echo e(__('admin.admins.leave_blank_password')); ?>.</small>
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
                            <label for="password_confirmation" class="form-label"><?php echo e(__('admin.admins.confirm_new_password')); ?></label>
                            <input type="password" class="form-control <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                id="password_confirmation" name="password_confirmation">
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

                        <div class="d-flex justify-content-between">
                            <a href="<?php echo e(route('admin.admins.index')); ?>" class="btn btn-outline-secondary">
                                <i class="ti ti-arrow-left me-1"></i> <?php echo e(__('admin.admins.back')); ?>

                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-check me-1"></i> <?php echo e(__('admin.admins.update')); ?>

                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-3">
                        <i class="ti ti-info-circle me-2"></i> <?php echo e(__('admin.admins.admin_detail')); ?>

                    </h5>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <strong><?php echo e(__('admin.admins.created_at')); ?>:</strong><br>
                            <small class="text-muted"><?php echo e($admin->created_at->format('d M Y, H:i')); ?></small>
                        </li>
                        <li class="mb-2">
                            <strong><?php echo e(__('admin.admins.updated_at')); ?>:</strong><br>
                            <small class="text-muted"><?php echo e($admin->updated_at->format('d M Y, H:i')); ?></small>
                        </li>
                        <?php if($admin->last_login_at): ?>
                        <li class="mb-2">
                            <strong><?php echo e(__('admin.admins.last_login')); ?>:</strong><br>
                            <small class="text-muted"><?php echo e($admin->last_login_at->format('d M Y, H:i')); ?></small>
                            <br>
                            <small class="text-muted">(<?php echo e($admin->last_login_at->diffForHumans()); ?>)</small>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

            <div class="card bg-primary text-white mt-3">
                <div class="card-body">
                    <h6 class="text-white mb-3">
                        <i class="ti ti-shield-check me-2"></i> <?php echo e(__('admin.admins.security')); ?>

                    </h6>
                    <ul class="mb-0" style="list-style: none; padding-left: 0;">
                        <li class="mb-2">
                            <i class="ti ti-point-filled me-2"></i>
                            <?php echo e(__('admin.admins.info_password')); ?>

                        </li>
                        <li>
                            <i class="ti ti-point-filled me-2"></i>
                            <?php echo e(__('admin.admins.leave_blank_password')); ?>

                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\admin\admins\edit.blade.php ENDPATH**/ ?>