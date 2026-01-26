<?php $__env->startSection('title', __('admin.blog_categories.edit_category')); ?>

<?php $__env->startSection('content'); ?>

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold py-3 mb-2">
                <span class="text-muted fw-light">Admin / Content Management / Blog Categories /</span> <?php echo e(__('admin.blog_categories.edit')); ?>

            </h4>
        </div>
        <div>
            <a href="<?php echo e(route('admin.blog-categories.index')); ?>" class="btn btn-secondary">
                <i class="ti ti-arrow-left me-1"></i> <?php echo e(__('admin.blog_categories.back_to_list')); ?>

            </a>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><?php echo e(__('admin.blog_categories.edit_category')); ?></h5>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('admin.blog-categories.update', $blogCategory->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="name" class="form-label"><?php echo e(__('admin.blog_categories.category_name')); ?> <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="name"
                                name="name" value="<?php echo e(old('name', $blogCategory->name)); ?>" required>
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
                            <small class="text-muted"><?php echo e(__('admin.blog_categories.name_help')); ?></small>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label"><?php echo e(__('admin.blog_categories.description')); ?></label>
                            <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="description"
                                name="description" rows="4"><?php echo e(old('description', $blogCategory->description)); ?></textarea>
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
                            <small class="text-muted"><?php echo e(__('admin.blog_categories.description_help')); ?></small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="card-title"><?php echo e(__('admin.blog_categories.category_settings')); ?></h6>

                                <div class="mb-3">
                                    <label class="form-label"><?php echo e(__('admin.blog_categories.status')); ?></label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                            <?php echo e(old('is_active', $blogCategory->is_active) ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="is_active">
                                            <?php echo e(__('admin.blog_categories.active')); ?>

                                        </label>
                                    </div>
                                    <small class="text-muted"><?php echo e(__('admin.blog_categories.active_help')); ?></small>
                                </div>

                                <hr>

                                <div class="mb-3">
                                    <label class="form-label"><?php echo e(__('admin.blog_categories.current_slug')); ?></label>
                                    <div>
                                        <code><?php echo e($blogCategory->slug); ?></code>
                                    </div>
                                    <small class="text-muted"><?php echo e(__('admin.blog_categories.slug_auto_update')); ?></small>
                                </div>

                                <hr>

                                <div class="mb-0">
                                    <label class="form-label"><?php echo e(__('admin.blog_categories.blogs_count')); ?></label>
                                    <div>
                                        <span class="badge bg-label-primary"><?php echo e($blogCategory->blogs()->count()); ?> <?php echo e(__('admin.blog_categories.blogs')); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-check me-1"></i> <?php echo e(__('admin.blog_categories.update_category')); ?>

                    </button>
                    <a href="<?php echo e(route('admin.blog-categories.index')); ?>" class="btn btn-secondary">
                        <?php echo e(__('admin.blog_categories.cancel')); ?>

                    </a>
                </div>
            </form>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\admin\blog-categories\edit.blade.php ENDPATH**/ ?>