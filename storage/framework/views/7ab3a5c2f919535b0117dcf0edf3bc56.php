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
                        <label class="col-sm-2 col-form-label"><?php echo e(app()->getLocale() == 'id' ? 'Durasi' : 'Duration'); ?> <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <div class="row g-2">
                                <!-- Category Dropdown -->
                                <div class="col-md-4">
                                    <label for="category_subscription" class="form-label small"><?php echo e(app()->getLocale() == 'id' ? 'Kategori' : 'Category'); ?></label>
                                    <select class="form-select <?php $__errorArgs = ['category_subscription'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                            id="category_subscription" 
                                            name="category_subscription" 
                                            required
                                            onchange="updateDurationLimits()">
                                        <option value=""><?php echo e(app()->getLocale() == 'id' ? 'Pilih Kategori' : 'Select Category'); ?></option>
                                        <option value="harian" <?php echo e(old('category_subscription', $plan->category_subscription ?? '') == 'harian' ? 'selected' : ''); ?>><?php echo e(app()->getLocale() == 'id' ? 'Harian' : 'Daily'); ?></option>
                                        <option value="mingguan" <?php echo e(old('category_subscription', $plan->category_subscription ?? '') == 'mingguan' ? 'selected' : ''); ?>><?php echo e(app()->getLocale() == 'id' ? 'Mingguan' : 'Weekly'); ?></option>
                                        <option value="bulanan" <?php echo e(old('category_subscription', $plan->category_subscription ?? '') == 'bulanan' ? 'selected' : ''); ?>><?php echo e(app()->getLocale() == 'id' ? 'Bulanan' : 'Monthly'); ?></option>
                                        <option value="tahunan" <?php echo e(old('category_subscription', $plan->category_subscription ?? '') == 'tahunan' ? 'selected' : ''); ?>><?php echo e(app()->getLocale() == 'id' ? 'Tahunan' : 'Yearly'); ?></option>
                                    </select>
                                    <?php $__errorArgs = ['category_subscription'];
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

                                <!-- Value Input -->
                                <div class="col-md-3">
                                    <label for="duration_value" class="form-label small">
                                        <span id="value_label"><?php echo e(app()->getLocale() == 'id' ? 'Nilai' : 'Value'); ?></span>
                                        <small class="text-muted" id="value_limit">(max: -)</small>
                                    </label>
                                    <input type="text" 
                                           class="form-control <?php $__errorArgs = ['duration_value'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="duration_value" 
                                           name="duration_value" 
                                           value="<?php echo e(old('duration_value', $durationValue ?? '')); ?>"
                                           required
                                           oninput="handleDurationInput(this)"
                                           onkeydown="return checkInput(event)"
                                           placeholder="<?php echo e(app()->getLocale() == 'id' ? 'Masukkan nilai' : 'Enter value'); ?>">
                                    <?php $__errorArgs = ['duration_value'];
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

                                <!-- Days Display -->
                                <div class="col-md-3">
                                    <label for="days_display" class="form-label small"><?php echo e(app()->getLocale() == 'id' ? 'Total Hari' : 'Total Days'); ?></label>
                                    <input type="text" 
                                           class="form-control bg-light" 
                                           id="days_display" 
                                           value="<?php echo e(old('duration_days', $plan->duration_days)); ?> <?php echo e(app()->getLocale() == 'id' ? 'hari' : 'days'); ?>"
                                           readonly>
                                </div>
                            </div>
                            <!-- Hidden input for duration_days -->
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
                // Define category limits and multipliers with proper limits
                const categoryLimits = {
                    'harian': { 
                        max: 7, 
                        multiplier: 1, 
                        label: '<?php echo e(app()->getLocale() == "id" ? "Hari" : "Days"); ?>'
                    },
                    'mingguan': { 
                        max: 4, 
                        multiplier: 7, 
                        label: '<?php echo e(app()->getLocale() == "id" ? "Minggu" : "Weeks"); ?>'
                    },
                    'bulanan': { 
                        max: 12, 
                        multiplier: 30, 
                        label: '<?php echo e(app()->getLocale() == "id" ? "Bulan" : "Months"); ?>'
                    },
                    'tahunan': { 
                        max: Infinity, 
                        multiplier: 365, 
                        label: '<?php echo e(app()->getLocale() == "id" ? "Tahun" : "Years"); ?>'
                    }
                };

                const dayLabel = '<?php echo e(app()->getLocale() == "id" ? "hari" : "days"); ?>';

                // Calculate duration value from existing duration_days if category exists
                initializeDurationValue();
                
                function initializeDurationValue() {
                    const category = document.getElementById('category_subscription').value;
                    const durationDays = parseInt(document.getElementById('duration_days').value) || 0;
                    
                    if (category && durationDays > 0) {
                        const multiplier = categoryLimits[category].multiplier;
                        const calculatedValue = Math.round(durationDays / multiplier);
                        document.getElementById('duration_value').value = calculatedValue;
                        updateDurationLimitsWithoutReset();
                    } else if (category) {
                        updateDurationLimitsWithoutReset();
                    }
                }
                
                function updateDurationLimitsWithoutReset() {
                    const category = document.getElementById('category_subscription').value;
                    const valueLabel = document.getElementById('value_label');
                    const valueLimit = document.getElementById('value_limit');
                    
                    if (!category) {
                        valueLabel.textContent = '<?php echo e(app()->getLocale() == "id" ? "Nilai" : "Value"); ?>';
                        valueLimit.textContent = '(max: -)';
                        return;
                    }
                    
                    const config = categoryLimits[category];
                    valueLabel.textContent = config.label;
                    
                    if (config.max === Infinity) {
                        valueLimit.textContent = '<?php echo e(app()->getLocale() == "id" ? "(tidak terbatas)" : "(unlimited)"); ?>';
                    } else {
                        valueLimit.textContent = `(max: ${config.max})`;
                    }
                    
                    calculateDurationDays();
                }

                // Block non-numeric keys and check max on keydown
                window.checkInput = function(evt) {
                    // Allow: backspace, delete, tab, escape, enter, and arrows
                    if ([8, 9, 13, 27, 46, 37, 38, 39, 40].includes(evt.keyCode)) {
                        return true;
                    }
                    
                    // Allow: Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
                    if ((evt.ctrlKey || evt.metaKey) && [65, 67, 86, 88].includes(evt.keyCode)) {
                        return true;
                    }
                    
                    // Block non-numeric (not 0-9)
                    if ((evt.keyCode < 48 || evt.keyCode > 57) && (evt.keyCode < 96 || evt.keyCode > 105)) {
                        evt.preventDefault();
                        return false;
                    }
                    
                    // Get the character that will be typed
                    const char = evt.key;
                    if (!/^\d$/.test(char)) {
                        evt.preventDefault();
                        return false;
                    }
                    
                    // Check if resulting number would exceed max
                    const input = evt.target;
                    const category = document.getElementById('category_subscription').value;
                    if (!category) return true;
                    
                    const config = categoryLimits[category];
                    if (config.max === Infinity) return true; // Yearly is unlimited
                    
                    // Calculate what the new value would be
                    const selectionStart = input.selectionStart;
                    const selectionEnd = input.selectionEnd;
                    const currentValue = input.value;
                    const newValue = currentValue.substring(0, selectionStart) + char + currentValue.substring(selectionEnd);
                    const numValue = parseInt(newValue);
                    
                    if (numValue > config.max) {
                        evt.preventDefault();
                        return false;
                    }
                    
                    return true;
                };

                // Make functions globally accessible
                window.updateDurationLimits = function() {
                    const category = document.getElementById('category_subscription').value;
                    const valueInput = document.getElementById('duration_value');
                    const valueLabel = document.getElementById('value_label');
                    const valueLimit = document.getElementById('value_limit');
                    
                    if (!category) {
                        valueInput.disabled = true;
                        valueInput.value = '';
                        valueLabel.textContent = '<?php echo e(app()->getLocale() == "id" ? "Nilai" : "Value"); ?>';
                        valueLimit.textContent = '(max: -)';
                        document.getElementById('days_display').value = '0 ' + dayLabel;
                        document.getElementById('duration_days').value = '0';
                        return;
                    }
                    
                    valueInput.disabled = false;
                    const config = categoryLimits[category];
                    
                    // Reset value to 1 when category changes
                    valueInput.value = 1;
                    
                    // Update label based on category
                    valueLabel.textContent = config.label;
                    
                    if (config.max === Infinity) {
                        valueLimit.textContent = '<?php echo e(app()->getLocale() == "id" ? "(tidak terbatas)" : "(unlimited)"); ?>';
                        valueInput.removeAttribute('max');
                    } else {
                        valueLimit.textContent = `(max: ${config.max})`;
                        valueInput.setAttribute('max', config.max);
                    }
                    
                    // Recalculate days
                    calculateDurationDays();
                };

                window.handleDurationInput = function(input) {
                    const category = document.getElementById('category_subscription').value;
                    if (!category) return;
                    
                    const config = categoryLimits[category];
                    let value = input.value.replace(/[^0-9]/g, ''); // Remove non-numeric
                    
                    if (value !== '') {
                        let numValue = parseInt(value);
                        
                        // Enforce max limit (except for yearly which is unlimited)
                        if (config.max !== Infinity && numValue > config.max) {
                            numValue = config.max;
                        }
                        
                        // Ensure minimum is 1
                        if (numValue < 1) {
                            numValue = 1;
                        }
                        
                        input.value = numValue;
                    }
                    
                    calculateDurationDays();
                };

                window.calculateDurationDays = function() {
                    const category = document.getElementById('category_subscription').value;
                    const value = parseInt(document.getElementById('duration_value').value) || 0;
                    const daysDisplay = document.getElementById('days_display');
                    const hiddenInput = document.getElementById('duration_days');
                    
                    if (!category || !value) {
                        daysDisplay.value = '0 ' + dayLabel;
                        hiddenInput.value = '0';
                        return;
                    }
                    
                    const multiplier = categoryLimits[category].multiplier;
                    const totalDays = value * multiplier;
                    
                    daysDisplay.value = totalDays + ' ' + dayLabel;
                    hiddenInput.value = totalDays;
                };
                
                // Handle paste event to validate pasted content
                const durationInput = document.getElementById('duration_value');
                durationInput.addEventListener('paste', function(evt) {
                    evt.preventDefault();
                    const pastedText = (evt.clipboardData || window.clipboardData).getData('text');
                    const numericValue = pastedText.replace(/[^0-9]/g, '');
                    
                    if (numericValue) {
                        const category = document.getElementById('category_subscription').value;
                        if (category) {
                            const config = categoryLimits[category];
                            let numValue = parseInt(numericValue);
                            
                            // Enforce max limit
                            if (config.max !== Infinity && numValue > config.max) {
                                numValue = config.max;
                            }
                            
                            this.value = numValue;
                            calculateDurationDays();
                        }
                    }
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

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\admin\subscription-plans\edit.blade.php ENDPATH**/ ?>