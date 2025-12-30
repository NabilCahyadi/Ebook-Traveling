

<?php $__env->startSection('title', 'Edit Contact Info'); ?>

<?php $__env->startSection('content'); ?>
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <span class="text-muted fw-light">
                    <a href="<?php echo e(route('admin.contact-info.index')); ?>" class="text-muted">Website Management / Contact Info</a> /
                </span> Edit
            </h4>
            <p class="mb-0">Edit informasi kontak</p>
        </div>
        <a href="<?php echo e(route('admin.contact-info.index')); ?>" class="btn btn-label-secondary">
            <i class="ti ti-arrow-left me-1"></i> Back to List
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
            <h5 class="mb-0">Contact Information</h5>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('admin.contact-info.update', $contactInfo->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="row">
                    <!-- Contact Type -->
                    <div class="col-md-6 mb-3">
                        <label for="contact_type" class="form-label">Contact Type <span class="text-danger">*</span></label>
                        <select class="form-select <?php $__errorArgs = ['contact_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                id="contact_type" 
                                name="contact_type" 
                                required>
                            <option value="">-- Select Type --</option>
                            <option value="whatsapp" <?php echo e(old('contact_type', $contactInfo->contact_type) == 'whatsapp' ? 'selected' : ''); ?>>WhatsApp</option>
                            <option value="email" <?php echo e(old('contact_type', $contactInfo->contact_type) == 'email' ? 'selected' : ''); ?>>Email</option>
                            <option value="phone" <?php echo e(old('contact_type', $contactInfo->contact_type) == 'phone' ? 'selected' : ''); ?>>Phone</option>
                            <option value="instagram" <?php echo e(old('contact_type', $contactInfo->contact_type) == 'instagram' ? 'selected' : ''); ?>>Instagram</option>
                            <option value="facebook" <?php echo e(old('contact_type', $contactInfo->contact_type) == 'facebook' ? 'selected' : ''); ?>>Facebook</option>
                            <option value="twitter" <?php echo e(old('contact_type', $contactInfo->contact_type) == 'twitter' ? 'selected' : ''); ?>>Twitter/X</option>
                            <option value="address" <?php echo e(old('contact_type', $contactInfo->contact_type) == 'address' ? 'selected' : ''); ?>>Address</option>
                            <option value="linkedin" <?php echo e(old('contact_type', $contactInfo->contact_type) == 'linkedin' ? 'selected' : ''); ?>>LinkedIn</option>
                            <option value="youtube" <?php echo e(old('contact_type', $contactInfo->contact_type) == 'youtube' ? 'selected' : ''); ?>>YouTube</option>
                            <option value="other" <?php echo e(old('contact_type', $contactInfo->contact_type) == 'other' ? 'selected' : ''); ?>>Other</option>
                        </select>
                        <?php $__errorArgs = ['contact_type'];
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

                    <!-- Title -->
                    <div class="col-md-6 mb-3">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
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
                               placeholder="e.g., WhatsApp Support" 
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
                        <label for="description" class="form-label">Description</label>
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
                                  placeholder="Enter description (optional)"><?php echo e(old('description', $contactInfo->description)); ?></textarea>
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
                        <label for="link" class="form-label">Link</label>
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
                               placeholder="e.g., https://wa.me/628123456789 or mailto:support@example.com">
                        <small class="form-text text-muted">
                            Examples: https://wa.me/628xxx, mailto:email@example.com, tel:+6281xxx
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
                        <label for="icon_class" class="form-label">Icon Class</label>
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
                                   placeholder="e.g., bi bi-whatsapp or ti ti-brand-whatsapp"
                                   readonly>
                            <button class="btn btn-outline-primary" type="button" id="iconPreviewBtn">
                                <i class="ti ti-search"></i> Browse Icons
                            </button>
                        </div>
                        <small class="form-text text-muted">
                            Click "Browse Icons" to select from available icons
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
                                Is Active
                            </label>
                        </div>
                        <small class="form-text text-muted">Tampilkan contact info ini</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-check">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="show_in_contact_page" 
                                   name="show_in_contact_page"
                                   <?php echo e(old('show_in_contact_page', $contactInfo->show_in_contact_page) ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="show_in_contact_page">
                                Show in Contact Page
                            </label>
                        </div>
                        <small class="form-text text-muted">Tampilkan di halaman Contact Us</small>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="ti ti-check me-1"></i> Update
                    </button>
                    <a href="<?php echo e(route('admin.contact-info.index')); ?>" class="btn btn-label-secondary">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <?php echo $__env->make('admin.contact-info.partials._icon-picker', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views/admin/contact-info/edit.blade.php ENDPATH**/ ?>