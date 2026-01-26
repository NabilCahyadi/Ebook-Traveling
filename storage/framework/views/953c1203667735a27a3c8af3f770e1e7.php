<?php $__env->startSection('title', __('admin.site_settings.title')); ?>

<?php $__env->startPush('styles'); ?>
    <style>

        .bg-label-primary {
            background-color: rgba(255, 76, 97, 0.12) !important;
            color: #ff4c61 !important;
        }
        .add-setting-card {
            border: 2px dashed #ddd;
            transition: all 0.3s;
        }

        .add-setting-card:hover {
            border-color: #ff4c61;
            background-color: #f8f9fa;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1">
                <span class="text-muted fw-light"><?php echo e(__('admin.menu.website_management')); ?> /</span> <?php echo e(__('admin.site_settings.title')); ?>

            </h4>
            <p class="mb-0"><?php echo e(__('admin.site_settings.description')); ?></p>
        </div>
        
    </div>

    <!-- Success/Error Messages -->
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><?php echo e(__('admin.messages.error_title')); ?></strong> <?php echo e(__('admin.messages.validation_error')); ?>

            <ul class="mb-0 mt-2">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Info Alert -->
    <div class="alert alert-info d-flex align-items-center" role="alert">
        <i class="ti ti-info-circle me-2"></i>
        <div>
            <strong><?php echo e(__('admin.site_settings.tip_title')); ?></strong> <?php echo e(__('admin.site_settings.tip_description')); ?>

        </div>
    </div>

    <!-- Settings Form -->
    <form action="<?php echo e(route('admin.site-settings.update')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="row">
            <?php $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $setting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-6 mb-4">
                    <div class="card setting-card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="mb-1"><?php echo e(ucwords(str_replace('_', ' ', $setting->key))); ?></h5>
                                    <span class="badge bg-label-primary"><?php echo e(ucfirst($setting->type)); ?></span>
                                </div>
                                
                                
                            </div>

                            <input type="hidden" name="settings[<?php echo e($loop->index); ?>][key]" value="<?php echo e($setting->key); ?>">
                            <input type="hidden" name="settings[<?php echo e($loop->index); ?>][type]" value="<?php echo e($setting->type); ?>">

                            <div class="mb-2">
                                <label class="form-label"><?php echo e(__('admin.site_settings.key')); ?></label>
                                <input type="text" class="form-control-plaintext" value="<?php echo e($setting->key); ?>" readonly>
                            </div>

                            <div class="mb-0">
                                <label for="value_<?php echo e($setting->key); ?>" class="form-label"><?php echo e(__('admin.site_settings.value')); ?></label>
                                <?php if($setting->type === 'textarea'): ?>
                                    <textarea class="form-control" 
                                              id="value_<?php echo e($setting->key); ?>"
                                              name="settings[<?php echo e($loop->index); ?>][value]" 
                                              rows="3"><?php echo e(old("settings.{$loop->index}.value", $setting->value)); ?></textarea>
                                <?php else: ?>
                                    <input type="<?php echo e($setting->type === 'email' ? 'email' : ($setting->type === 'phone' ? 'tel' : 'text')); ?>" 
                                           class="form-control" 
                                           id="value_<?php echo e($setting->key); ?>"
                                           name="settings[<?php echo e($loop->index); ?>][value]" 
                                           value="<?php echo e(old("settings.{$loop->index}.value", $setting->value)); ?>"
                                           placeholder="Enter <?php echo e($setting->key); ?>">
                                <?php endif; ?>
                                <?php if($setting->type === 'phone'): ?>
                                    <small class="form-text text-muted"><?php echo e(__('admin.site_settings.phone_format')); ?></small>
                                <?php elseif($setting->type === 'email'): ?>
                                    <small class="form-text text-muted"><?php echo e(__('admin.site_settings.email_format')); ?></small>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <?php if($settings->count() > 0): ?>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-check me-1"></i> <?php echo e(__('admin.site_settings.save_all')); ?>

                </button>
            </div>
        <?php else: ?>
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="ti ti-settings" style="font-size: 4rem; color: #ddd;"></i>
                    <p class="text-muted mt-3 mb-0"><?php echo e(__('admin.site_settings.no_settings')); ?></p>
                </div>
            </div>
        <?php endif; ?>
    </form>

    
    
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\admin\site-settings\index.blade.php ENDPATH**/ ?>