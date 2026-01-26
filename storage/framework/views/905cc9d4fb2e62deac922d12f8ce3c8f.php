<?php $__env->startSection('title', 'Edit Section - ' . $pageTypeName); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Page Header -->
        <div class="mb-4">
            <h4 class="fw-bold py-3 mb-2">
                <span class="text-muted fw-light"><?php echo e(__('admin.menu.website_setting')); ?> / Policy / <?php echo e($pageTypeName); ?> /</span> Edit Section
            </h4>
        </div>

        <!-- Form Card -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Section Information</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo e(route("admin.policies.{$pageTypeSlug}.update", $section->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>

                            <!-- Section Title -->
                            <div class="mb-4">
                                <label for="section_title" class="form-label">Section Title</label>
                                <input type="text" class="form-control <?php $__errorArgs = ['section_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="section_title" name="section_title" value="<?php echo e(old('section_title', $section->section_title)); ?>" 
                                    placeholder="e.g., 1. How to Register" maxlength="255">
                                <?php $__errorArgs = ['section_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <small class="text-muted">Main section heading (optional)</small>
                            </div>

                            <!-- Subsection Title -->
                            <div class="mb-4">
                                <label for="subsection_title" class="form-label">Subsection Title</label>
                                <input type="text" class="form-control <?php $__errorArgs = ['subsection_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="subsection_title" name="subsection_title" value="<?php echo e(old('subsection_title', $section->subsection_title)); ?>" 
                                    placeholder="e.g., 1.1. Via Website" maxlength="255">
                                <?php $__errorArgs = ['subsection_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <small class="text-muted">Subsection heading (optional)</small>
                            </div>

                            <!-- Content -->
                            <div class="mb-4">
                                <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                                <textarea class="form-control <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="content" name="content" rows="10" 
                                    placeholder="Enter the content... (Use new lines for list items)" required><?php echo e(old('content', $section->content)); ?></textarea>
                                <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <small class="text-muted">Plain text content. Use line breaks for list items.</small>
                            </div>

                            <!-- Order Index -->
                            <div class="mb-4">
                                <label for="order_index" class="form-label">Display Order <span class="text-danger">*</span></label>
                                <input type="number" class="form-control <?php $__errorArgs = ['order_index'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="order_index" name="order_index" value="<?php echo e(old('order_index', $section->order_index)); ?>" 
                                    min="0" required>
                                <?php $__errorArgs = ['order_index'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <small class="text-muted">Lower numbers appear first</small>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-check me-1"></i> Update Section
                                </button>
                                <a href="<?php echo e(route("admin.policies.{$pageTypeSlug}.index")); ?>" class="btn btn-label-secondary">
                                    <i class="ti ti-x me-1"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Info Sidebar -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="ti ti-info-circle me-2"></i>Section Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted d-block">Page Type</small>
                            <strong><?php echo e($pageTypeName); ?></strong>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block">Created</small>
                            <strong><?php echo e($section->created_at->format('d M Y, H:i')); ?></strong>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block">Last Updated</small>
                            <strong><?php echo e($section->updated_at->format('d M Y, H:i')); ?></strong>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block">Order Index</small>
                            <span class="badge bg-label-secondary"><?php echo e($section->order_index); ?></span>
                        </div>

                        <hr>

                        <div class="alert alert-warning mb-0">
                            <small>
                                <i class="ti ti-alert-triangle me-1"></i>
                                Changes will be visible immediately on the website.
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Content Preview -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="ti ti-eye me-2"></i>Content Preview</h5>
                    </div>
                    <div class="card-body">
                        <?php if($section->section_title): ?>
                        <h6 class="fw-bold"><?php echo e($section->section_title); ?></h6>
                        <?php endif; ?>
                        
                        <?php if($section->subsection_title): ?>
                        <p class="text-muted small mb-2"><?php echo e($section->subsection_title); ?></p>
                        <?php endif; ?>
                        
                        <div class="small">
                            <?php $__currentLoopData = explode("\n", $section->content); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(trim($line)): ?>
                                <div class="mb-1">• <?php echo e(trim($line)); ?></div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\admin\policies\edit.blade.php ENDPATH**/ ?>