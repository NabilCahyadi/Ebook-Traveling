<?php $__env->startSection('title', __('admin.ratings.edit_rating') . ' - ' . $ebook->title); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold py-3 mb-0">
                    <span class="text-muted fw-light"><?php echo e(__('admin.ebooks.title')); ?> / <?php echo e(__('admin.ratings.title')); ?> /</span> <?php echo e(__('admin.ratings.edit_rating')); ?>

                </h4>
                <small class="text-muted"><?php echo e($ebook->title); ?></small>
            </div>
            <a href="<?php echo e(route('admin.ebooks.ratings.index', $ebook->id)); ?>" class="btn btn-secondary">
                <i class="ti ti-arrow-left me-1"></i> <?php echo e(__('admin.ratings.back_to_ratings')); ?>

            </a>
        </div>

        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <form action="<?php echo e(route('admin.ebooks.ratings.update', [$ebook->id, $rating->id])); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="row">
                        <!-- User Info (Read-only) -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><?php echo e(__('admin.ratings.user')); ?></label>
                            <div class="d-flex align-items-center p-3 bg-label-danger rounded">
                                <div class="avatar avatar-sm me-2">
                                    <span class="avatar-initial rounded-circle bg-danger">
                                        <?php echo e(substr($rating->user->name ?? 'U', 0, 1)); ?>

                                    </span>
                                </div>
                                <div>
                                    <div class="fw-medium text-danger"><?php echo e($rating->user->name ?? __('admin.ebooks.unknown')); ?></div>
                                    <small class="text-muted"><?php echo e($rating->user->email ?? '-'); ?></small>
                                </div>
                            </div>
                        </div>

                        <!-- Rating -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><?php echo e(__('admin.ratings.rating')); ?> <span class="text-danger">*</span></label>
                            <div class="rating-input d-flex align-items-center gap-2">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="rating" id="rating<?php echo e($i); ?>" 
                                            value="<?php echo e($i); ?>" <?php echo e(old('rating', $rating->rating) == $i ? 'checked' : ''); ?> required>
                                        <label class="form-check-label" for="rating<?php echo e($i); ?>">
                                            <span class="d-flex align-items-center">
                                                <?php echo e($i); ?> <i class="ti ti-star-filled text-warning ms-1"></i>
                                            </span>
                                        </label>
                                    </div>
                                <?php endfor; ?>
                            </div>
                            <?php $__errorArgs = ['rating'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Review Title -->
                        <div class="col-md-12 mb-3">
                            <label for="review_title" class="form-label"><?php echo e(__('admin.ratings.review_title')); ?></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['review_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                id="review_title" name="review_title" value="<?php echo e(old('review_title', $rating->review_title)); ?>"
                                placeholder="<?php echo e(__('admin.ratings.review_title_placeholder')); ?>">
                            <?php $__errorArgs = ['review_title'];
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

                        <!-- Review Text -->
                        <div class="col-md-12 mb-3">
                            <label for="review_text" class="form-label"><?php echo e(__('admin.ratings.review_text')); ?></label>
                            <textarea class="form-control <?php $__errorArgs = ['review_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="review_text" 
                                name="review_text" rows="4" placeholder="<?php echo e(__('admin.ratings.review_text_placeholder')); ?>"><?php echo e(old('review_text', $rating->review_text)); ?></textarea>
                            <?php $__errorArgs = ['review_text'];
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

                        <!-- Approval Status -->
                        <div class="col-md-12 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_approved" name="is_approved" 
                                    <?php echo e(old('is_approved', $rating->is_approved) ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="is_approved"><?php echo e(__('admin.ratings.approved')); ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-check me-1"></i> <?php echo e(__('admin.ratings.update')); ?>

                        </button>
                        <a href="<?php echo e(route('admin.ebooks.ratings.index', $ebook->id)); ?>" class="btn btn-label-secondary">
                            <?php echo e(__('admin.ratings.cancel')); ?>

                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\admin\ebooks\ratings\edit.blade.php ENDPATH**/ ?>