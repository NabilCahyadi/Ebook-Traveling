<?php $__env->startSection('title', 'Add New FAQ ' . $categoryName); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Page Header -->
        <div class="mb-4">
            <h4 class="fw-bold py-3 mb-2">
                <span class="text-muted fw-light">Web Setting / FAQ / <?php echo e($categoryName); ?> /</span> Add New
            </h4>
        </div>

        <!-- Form Card -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">FAQ Information</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo e(route("admin.faqs.{$categorySlug}.store")); ?>" method="POST">
                            <?php echo csrf_field(); ?>

                            <!-- Question -->
                            <div class="mb-4">
                                <label for="question" class="form-label">Question <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?php $__errorArgs = ['question'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="question" name="question" value="<?php echo e(old('question')); ?>" 
                                    placeholder="Enter the question..." maxlength="500" required>
                                <?php $__errorArgs = ['question'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <small class="text-muted">Maximum 500 characters</small>
                            </div>

                            <!-- Answer -->
                            <div class="mb-4">
                                <label for="answer" class="form-label">Answer <span class="text-danger">*</span></label>
                                <textarea class="form-control <?php $__errorArgs = ['answer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="answer" name="answer" rows="6" 
                                    placeholder="Enter the answer..." required><?php echo e(old('answer')); ?></textarea>
                                <?php $__errorArgs = ['answer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <small class="text-muted">Provide a clear and concise answer</small>
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
                                    id="order_index" name="order_index" value="<?php echo e(old('order_index', $nextOrder)); ?>" 
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
                                <small class="text-muted">Lower numbers appear first. Suggested: <?php echo e($nextOrder); ?></small>
                            </div>

                            <!-- Is Active -->
                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" 
                                        name="is_active" <?php echo e(old('is_active', true) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="is_active">
                                        Active (Display on website)
                                    </label>
                                </div>
                                <small class="text-muted">Toggle to show/hide this FAQ on the website</small>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-check me-1"></i> Save FAQ
                                </button>
                                <a href="<?php echo e(route("admin.faqs.{$categorySlug}.index")); ?>" class="btn btn-label-secondary">
                                    <i class="ti ti-x me-1"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Help Sidebar -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="ti ti-info-circle me-2"></i>Guidelines</h5>
                    </div>
                    <div class="card-body">
                        <h6 class="mb-3">Creating Effective FAQs</h6>
                        
                        <div class="mb-3">
                            <strong class="d-block mb-2">Questions:</strong>
                            <ul class="small mb-0">
                                <li>Keep it concise and clear</li>
                                <li>Use natural language</li>
                                <li>Focus on one topic per question</li>
                            </ul>
                        </div>

                        <div class="mb-3">
                            <strong class="d-block mb-2">Answers:</strong>
                            <ul class="small mb-0">
                                <li>Be specific and accurate</li>
                                <li>Use simple language</li>
                                <li>Include relevant details</li>
                                <li>Keep it helpful and friendly</li>
                            </ul>
                        </div>

                        <div class="alert alert-info mb-0">
                            <small>
                                <i class="ti ti-bulb me-1"></i>
                                <strong>Tip:</strong> Review existing FAQs in this category to maintain consistency.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\admin\faqs\create.blade.php ENDPATH**/ ?>