<?php $__env->startSection('title', __('admin.subscription_plans.edit_plan')); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light"><?php echo e(__('admin.menu.dashboard')); ?> / <?php echo e(__('admin.subscription_plans.title')); ?> /</span> <?php echo e(__('admin.actions.edit')); ?>

            </h4>
            <a href="<?php echo e(route('admin.subscription-plans.index')); ?>" class="btn btn-secondary">
                <i class="bx bx-arrow-back me-1"></i> <?php echo e(__('admin.actions.back')); ?>

            </a>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><?php echo e(__('admin.subscription_plans.edit_plan')); ?>: <?php echo e($plan->name); ?></h5>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('admin.subscription-plans.update', $plan->id)); ?>" method="POST"
                    enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="name"><?php echo e(__('admin.subscription_plans.plan_name')); ?> <span
                                class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="name"
                                name="name" value="<?php echo e(old('name', $plan->name)); ?>"
                                placeholder="e.g., Monthly Plan, Annual Plan" required>
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
                    </div>

                    <!-- Banner Image Upload -->
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="cover_image">Banner Image</label>
                        <div class="col-sm-10">
                            <?php if($plan->cover_image): ?>
                                <div class="mb-2">
                                    <div class="border rounded p-2" style="max-width: 600px;">
                                        <img src="<?php echo e(asset('storage/' . $plan->cover_image)); ?>" alt="Current Banner"
                                            style="width: 100%; height: auto; border-radius: 0.375rem;">
                                        <small class="text-muted d-block mt-1">Current banner image</small>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <input type="file" class="form-control <?php $__errorArgs = ['cover_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="cover_image" name="cover_image" accept="image/*" onchange="previewBanner(event)">
                            <?php $__errorArgs = ['cover_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <div class="form-text">Upload a new banner image to replace the current one (Optional,
                                recommended size: 1200x400px)</div>

                            <!-- Preview -->
                            <div id="bannerPreview" class="mt-3" style="display: none;">
                                <div class="border rounded p-2" style="max-width: 600px;">
                                    <img id="bannerPreviewImg" src="" alt="Banner Preview"
                                        style="width: 100%; height: auto; border-radius: 0.375rem;">
                                    <button type="button" class="btn btn-sm btn-label-danger mt-2"
                                        onclick="removeBanner()">
                                        <i class="ti ti-x me-1"></i> Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="description"><?php echo e(__('admin.form.description')); ?></label>
                        <div class="col-sm-10">
                            <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="description" name="description"
                                rows="3" placeholder="Enter plan description"><?php echo e(old('description', $plan->description)); ?></textarea>
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
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="price"><?php echo e(__('admin.subscription_plans.price')); ?> (Rp) <span
                                class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="price"
                                name="price" value="<?php echo e(old('price', $plan->price)); ?>" min="0" step="0.01"
                                required>
                            <?php $__errorArgs = ['price'];
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

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="duration_days"><?php echo e(__('admin.subscription_plans.duration_days')); ?> <span
                                class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <select class="form-select <?php $__errorArgs = ['duration_days'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="duration_select"
                                        required>
                                        <option value=""><?php echo e(__('admin.common.select')); ?> <?php echo e(__('admin.subscription_history.duration')); ?></option>
                                        <option value="30"
                                            <?php echo e(old('duration_days', $plan->duration_days) == 30 ? 'selected' : ''); ?>>1 <?php echo e(__('admin.receipt.month')); ?> (30 <?php echo e(__('admin.receipt.days')); ?>)</option>
                                        <option value="180"
                                            <?php echo e(old('duration_days', $plan->duration_days) == 180 ? 'selected' : ''); ?>>6 <?php echo e(__('admin.receipt.months')); ?> (180 <?php echo e(__('admin.receipt.days')); ?>)</option>
                                        <option value="365"
                                            <?php echo e(old('duration_days', $plan->duration_days) == 365 ? 'selected' : ''); ?>>1 <?php echo e(__('admin.receipt.year')); ?> (365 <?php echo e(__('admin.receipt.days')); ?>)</option>
                                        <option value="custom"
                                            <?php echo e(!in_array(old('duration_days', $plan->duration_days), [30, 180, 365]) ? 'selected' : ''); ?>>
                                            Custom Duration</option>
                                    </select>
                                    <?php $__errorArgs = ['duration_days'];
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
                                <div class="col-md-6" id="customDurationDiv"
                                    style="display: <?php echo e(!in_array(old('duration_days', $plan->duration_days), [30, 180, 365]) ? 'block' : 'none'); ?>;">
                                    <input type="number" class="form-control" id="custom_duration"
                                        value="<?php echo e(!in_array($plan->duration_days, [30, 180, 365]) ? $plan->duration_days : ''); ?>"
                                        min="1" placeholder="Enter custom days">
                                </div>
                            </div>
                            <!-- Hidden input that will be submitted -->
                            <input type="hidden" name="duration_days" id="duration_days" value="<?php echo e(old('duration_days', $plan->duration_days)); ?>">
                        </div>
                    </div>

                    
                    <?php if(false): ?>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="features">Features</label>
                        <div class="col-sm-10">
                            <textarea class="form-control <?php $__errorArgs = ['features'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="features" name="features" rows="5"
                                placeholder="Enter each feature on a new line"><?php echo e(old('features', is_array($plan->features) ? implode("\n", $plan->features) : '')); ?></textarea>
                            <?php $__errorArgs = ['features'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <div class="form-text">Enter one feature per line</div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="button_text">Button Text</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?php $__errorArgs = ['button_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                id="button_text" name="button_text" value="<?php echo e(old('button_text', $plan->button_text)); ?>" 
                                placeholder="e.g., Get Started, Subscribe Now, Choose Plan">
                            <?php $__errorArgs = ['button_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <div class="form-text">Text that will appear on the button in pricing page (optional)</div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="mayar_payment_link">Mayar Payment Link</label>
                        <div class="col-sm-10">
                            <input type="url" class="form-control <?php $__errorArgs = ['mayar_payment_link'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                id="mayar_payment_link" name="mayar_payment_link" value="<?php echo e(old('mayar_payment_link', $plan->mayar_payment_link)); ?>" 
                                placeholder="https://app.mayar.id/payment/...">
                            <?php $__errorArgs = ['mayar_payment_link'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <div class="form-text">Link pembayaran Mayar untuk paket langganan ini (opsional)</div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label"><?php echo e(__('admin.ebooks.status')); ?></label>
                        <div class="col-sm-10">
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                    <?php echo e(old('is_active', $plan->is_active) ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="is_active">
                                    <?php echo e(__('admin.status.active')); ?> (Available for users to subscribe)
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-10 offset-sm-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-save me-1"></i> <?php echo e(__('admin.actions.save')); ?> <?php echo e(__('admin.subscription_plans.title')); ?>

                            </button>
                            <a href="<?php echo e(route('admin.subscription-plans.index')); ?>" class="btn btn-secondary">
                                <?php echo e(__('admin.actions.cancel')); ?>

                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const durationSelect = document.getElementById('duration_select');
                const hiddenInput = document.getElementById('duration_days');
                const customDiv = document.getElementById('customDurationDiv');
                const customInput = document.getElementById('custom_duration');
                const form = document.querySelector('form');

                // Handle duration change
                durationSelect.addEventListener('change', function() {
                    if (this.value === 'custom') {
                        customDiv.style.display = 'block';
                        customInput.required = true;
                        customInput.focus();
                        hiddenInput.value = ''; // Clear hidden input
                    } else {
                        customDiv.style.display = 'none';
                        customInput.required = false;
                        customInput.value = '';
                        hiddenInput.value = this.value; // Set hidden input to selected value
                    }
                });

                // Update hidden input when custom duration changes
                customInput.addEventListener('input', function() {
                    if (durationSelect.value === 'custom' && this.value) {
                        hiddenInput.value = this.value;
                    }
                });

                // Handle form submission
                form.addEventListener('submit', function(e) {
                    // If custom duration is selected, validate and set hidden input
                    if (durationSelect.value === 'custom') {
                        if (!customInput.value || customInput.value <= 0) {
                            e.preventDefault();
                            alert('Silakan masukkan durasi custom (minimal 1 hari)');
                            customInput.focus();
                            return false;
                        }
                        // Make sure hidden input has the custom value
                        hiddenInput.value = customInput.value;
                    }
                    
                    return true;
                });
            });

            // Banner image preview
            function previewBanner(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('bannerPreviewImg').src = e.target.result;
                        document.getElementById('bannerPreview').style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                }
            }

            function removeBanner() {
                document.getElementById('cover_image').value = '';
                document.getElementById('bannerPreview').style.display = 'none';
                document.getElementById('bannerPreviewImg').src = '';
            }
        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views/admin/subscription-plans/edit.blade.php ENDPATH**/ ?>