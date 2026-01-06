<?php $__env->startSection('title', 'Edit Contact Info'); ?>

<?php $__env->startSection('content'); ?>
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <span class="text-muted fw-light">
                    <a href="<?php echo e(route('admin.contact-info.index')); ?>" class="text-muted"><?php echo e(__('admin.menu.website_setting')); ?> / <?php echo e(__('admin.contact_info.title')); ?></a> /
                </span> <?php echo e(__('admin.actions.edit')); ?>

            </h4>
            <p class="mb-0"><?php echo e(__('admin.contact_info.edit_subtitle')); ?></p>
        </div>
        <a href="<?php echo e(route('admin.contact-info.index')); ?>" class="btn btn-label-secondary">
            <i class="ti ti-arrow-left me-1"></i> <?php echo e(__('admin.actions.back_to_list')); ?>

        </a>
    </div>

    <!-- Error Messages -->
    <?php if($errors->any()): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> Please check the form below.
            <ul class="mb-0 mt-2">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Form Card -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><?php echo e(__('admin.contact_info.form_title')); ?></h5>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('admin.contact-info.update', $contactInfo->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="row">
                    <!-- Contact Type (Read Only) -->
                    <div class="col-md-6 mb-3">
                        <label for="contact_type" class="form-label"><?php echo e(__('admin.contact_info.contact_type')); ?> <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control" 
                               value="<?php echo e(ucfirst($contactInfo->contact_type)); ?>" 
                               readonly 
                               style="background-color: #f5f5f5; cursor: not-allowed;">
                        <!-- Hidden field to maintain contact_type value on submit -->
                        <input type="hidden" name="contact_type" value="<?php echo e($contactInfo->contact_type); ?>">
                        <!-- <small class="text-muted">Contact type tidak dapat diubah</small> -->
                        <?php $__errorArgs = ['contact_type'];
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

                    <!-- Title -->
                    <div class="col-md-6 mb-3">
                        <label for="title" class="form-label"><?php echo e(__('admin.contact_info.title_label')); ?> <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="title"
                               name="title" 
                               value="<?php echo e(old('title', $contactInfo->title)); ?>" 
                               placeholder="<?php echo e(__('admin.contact_info.title_placeholder')); ?>" 
                               required>
                        <?php $__errorArgs = ['title'];
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

                    <!-- Description -->
                    <div class="col-md-12 mb-3">
                        <label for="description" class="form-label"><?php echo e(__('admin.contact_info.description')); ?></label>
                        <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                  id="description" 
                                  name="description"
                                  rows="3" 
                                  placeholder="<?php echo e(__('admin.contact_info.description_placeholder')); ?>"><?php echo e(old('description', $contactInfo->description)); ?></textarea>
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

                    <!-- Link -->
                    <div class="col-md-12 mb-3">
                        <label for="link" class="form-label"><?php echo e(__('admin.contact_info.link')); ?></label>
                        <input type="text" 
                               class="form-control <?php $__errorArgs = ['link'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="link"
                               name="link" 
                               value="<?php echo e(old('link', $contactInfo->link)); ?>" 
                               placeholder="<?php echo e(__('admin.contact_info.link_placeholder')); ?>">
                        <small class="form-text text-muted">
                            <?php echo e(__('admin.contact_info.link_examples')); ?>

                        </small>
                        <?php $__errorArgs = ['link'];
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

                    <!-- Icon Class -->
                    <div class="col-md-12 mb-3">
                        <label for="icon_class" class="form-label"><?php echo e(__('admin.contact_info.icon_class')); ?></label>
                        <div class="input-group">
                            <span class="input-group-text" id="selectedIconPreview">
                                <?php if($contactInfo->icon_class): ?>
                                    <i class="<?php echo e($contactInfo->icon_class); ?>"></i>
                                <?php else: ?>
                                    <i class="ti ti-icons"></i>
                                <?php endif; ?>
                            </span>
                            <input type="text" 
                                   class="form-control <?php $__errorArgs = ['icon_class'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="icon_class"
                                   name="icon_class" 
                                   value="<?php echo e(old('icon_class', $contactInfo->icon_class)); ?>" 
                                   placeholder="<?php echo e(__('admin.contact_info.icon_placeholder')); ?>"
                                   readonly>
                            <button class="btn btn-outline-primary" type="button" id="iconPreviewBtn">
                                <i class="ti ti-search"></i> <?php echo e(__('admin.contact_info.browse_icons')); ?>

                            </button>
                        </div>
                        <small class="form-text text-muted">
                            <?php echo e(__('admin.contact_info.icon_help')); ?>

                        </small>
                        <?php $__errorArgs = ['icon_class'];
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

                    <!-- Checkboxes -->
                    <div class="col-md-6 mb-3">
                        <div class="form-check">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="is_active" 
                                   name="is_active"
                                   <?php echo e(old('is_active', $contactInfo->is_active) ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="is_active">
                                <?php echo e(__('admin.contact_info.is_active')); ?>

                            </label>
                        </div>
                        <small class="form-text text-muted"><?php echo e(__('admin.contact_info.is_active_help')); ?></small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-check">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="show_in_contact_page" 
                                   name="show_in_contact_page"
                                   <?php echo e(old('show_in_contact_page', $contactInfo->show_in_contact_page) ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="show_in_contact_page">
                                <?php echo e(__('admin.contact_info.show_in_contact_page')); ?>

                            </label>
                        </div>
                        <small class="form-text text-muted"><?php echo e(__('admin.contact_info.show_in_contact_page_help')); ?></small>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="ti ti-check me-1"></i> <?php echo e(__('admin.actions.update')); ?>

                    </button>
                    <a href="<?php echo e(route('admin.contact-info.index')); ?>" class="btn btn-label-secondary">
                        <?php echo e(__('admin.actions.cancel')); ?>

                    </a>
                </div>
            </form>
        </div>
    </div>

    <?php echo $__env->make('admin.contact-info.partials._icon-picker', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views/admin/contact-info/edit.blade.php ENDPATH**/ ?>