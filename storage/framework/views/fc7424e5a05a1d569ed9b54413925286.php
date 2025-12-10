<?php $__env->startSection('title', 'Create New Promo'); ?>

<?php $__env->startPush('styles'); ?>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet" />
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">Create New Promo</h4>
                <p class="text-muted mb-0">Create a new subscription promo code</p>
            </div>
            <a href="<?php echo e(route('admin.promos.index')); ?>" class="btn btn-label-secondary">
                <i class="ti ti-arrow-left me-1"></i> Back to List
            </a>
        </div>

        <!-- Error Messages -->
        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Validation Error!</strong>
                <ul class="mb-0">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Form Card -->
        <div class="row">
            <div class="col-lg-8">
                <form action="<?php echo e(route('admin.promos.store')); ?>" method="POST" id="promoForm">
                    <?php echo csrf_field(); ?>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Basic Information</h5>
                        </div>
                        <div class="card-body">
                            <!-- Name -->
                            <div class="form-group">
                                <label for="name">Promo Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="name" name="name" value="<?php echo e(old('name')); ?>"
                                    placeholder="e.g., Welcome Discount 50%" required>
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

                            <!-- Code -->
                            <div class="form-group">
                                <label for="code">Promo Code</label>
                                <input type="text" class="form-control <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="code" name="code" value="<?php echo e(old('code')); ?>"
                                    placeholder="e.g., WELCOME50 (leave empty for auto-apply)"
                                    style="text-transform: uppercase;">
                                <small class="form-text text-muted">
                                    Leave empty for automatic discount. Use uppercase letters, numbers, underscore, and
                                    hyphen only.
                                </small>
                                <?php $__errorArgs = ['code'];
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
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="description" name="description"
                                    rows="3" placeholder="Describe this promo..."><?php echo e(old('description')); ?></textarea>
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
                    </div>

                    <!-- Discount Settings -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Discount Settings</h5>
                        </div>
                        <div class="card-body">
                            <!-- Type -->
                            <div class="form-group">
                                <label for="type">Discount Type <span class="text-danger">*</span></label>
                                <select class="form-control <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="type"
                                    name="type" required>
                                    <option value="">-- Select Type --</option>
                                    <option value="percentage" <?php echo e(old('type') === 'percentage' ? 'selected' : ''); ?>>
                                        Percentage Discount</option>
                                    <option value="fixed_amount" <?php echo e(old('type') === 'fixed_amount' ? 'selected' : ''); ?>>
                                        Fixed Amount Discount</option>
                                    <option value="free_trial" <?php echo e(old('type') === 'free_trial' ? 'selected' : ''); ?>>Free
                                        Trial</option>
                                </select>
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

                            <!-- Value -->
                            <div class="form-group">
                                <label for="value">
                                    <span id="valueLabel">Discount Value</span> <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="number" class="form-control <?php $__errorArgs = ['value'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="value" name="value" value="<?php echo e(old('value')); ?>" step="0.01"
                                        min="0" placeholder="Enter value" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="valueUnit">
                                            <span id="unitLabel">%</span>
                                        </span>
                                    </div>
                                    <?php $__errorArgs = ['value'];
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
                                <small class="form-text text-muted" id="valueHint">
                                    Enter the discount percentage (e.g., 50 for 50% off)
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Date Range & Usage Limits -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Validity & Usage Limits</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="start_date">Start Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control <?php $__errorArgs = ['start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="start_date" name="start_date"
                                            value="<?php echo e(old('start_date', now()->format('Y-m-d'))); ?>" required>
                                        <?php $__errorArgs = ['start_date'];
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="end_date">End Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control <?php $__errorArgs = ['end_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="end_date" name="end_date" value="<?php echo e(old('end_date')); ?>" required>
                                        <?php $__errorArgs = ['end_date'];
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
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="max_usage">Maximum Total Usage</label>
                                        <input type="number"
                                            class="form-control <?php $__errorArgs = ['max_usage'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="max_usage"
                                            name="max_usage" value="<?php echo e(old('max_usage')); ?>" min="1"
                                            placeholder="Leave empty for unlimited">
                                        <small class="form-text text-muted">Total times this promo can be used by all
                                            users</small>
                                        <?php $__errorArgs = ['max_usage'];
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="max_usage_per_user">Max Usage Per User <span
                                                class="text-danger">*</span></label>
                                        <input type="number"
                                            class="form-control <?php $__errorArgs = ['max_usage_per_user'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="max_usage_per_user" name="max_usage_per_user"
                                            value="<?php echo e(old('max_usage_per_user', 1)); ?>" min="1" required>
                                        <small class="form-text text-muted">How many times each user can use this
                                            promo</small>
                                        <?php $__errorArgs = ['max_usage_per_user'];
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
                            </div>

                            <!-- Active Status -->
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="is_active" name="is_active"
                                        value="1" <?php echo e(old('is_active', true) ? 'checked' : ''); ?>>
                                    <label class="custom-control-label" for="is_active">
                                        <strong>Active</strong> - Promo is available for use
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Conditions -->
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Conditions (Optional)</h5>
                            <button type="button" class="btn btn-sm btn-primary" id="addCondition">
                                <i class="ti ti-plus"></i> Add Condition
                            </button>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-3">Add conditions to restrict who can use this promo</p>

                            <div id="conditionsContainer">
                                <?php if(old('conditions')): ?>
                                    <?php $__currentLoopData = old('conditions'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $condition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="condition-row card mb-3">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <label>Condition Type</label>
                                                        <select class="form-control condition-type"
                                                            name="conditions[<?php echo e($index); ?>][condition_type]">
                                                            <option value="">-- Select Type --</option>
                                                            <option value="new_user"
                                                                <?php echo e($condition['condition_type'] === 'new_user' ? 'selected' : ''); ?>>
                                                                New User Only</option>
                                                            <option value="first_subscription"
                                                                <?php echo e($condition['condition_type'] === 'first_subscription' ? 'selected' : ''); ?>>
                                                                First Subscription Only</option>
                                                            <option value="subscription_type"
                                                                <?php echo e($condition['condition_type'] === 'subscription_type' ? 'selected' : ''); ?>>
                                                                Specific Subscription Type</option>
                                                            <option value="min_price"
                                                                <?php echo e($condition['condition_type'] === 'min_price' ? 'selected' : ''); ?>>
                                                                Minimum Price</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 condition-value-wrapper"
                                                        style="<?php echo e(in_array($condition['condition_type'], ['new_user', 'first_subscription']) ? 'display:none;' : ''); ?>">
                                                        <label>Value <span class="value-required text-danger"
                                                                style="<?php echo e(in_array($condition['condition_type'], ['subscription_type', 'min_price']) ? '' : 'display:none;'); ?>">*</span></label>
                                                        <input type="number"
                                                            class="form-control condition-value condition-value-text"
                                                            name="conditions[<?php echo e($index); ?>][condition_value_text]"
                                                            value="<?php echo e($condition['condition_type'] === 'min_price' ? $condition['condition_value'] ?? '' : ''); ?>"
                                                            step="0.01" placeholder="Enter value"
                                                            style="<?php echo e($condition['condition_type'] !== 'min_price' ? 'display:none;' : ''); ?>">
                                                        <select class="form-select condition-value condition-value-select"
                                                            name="conditions[<?php echo e($index); ?>][condition_value_select]"
                                                            multiple
                                                            style="<?php echo e($condition['condition_type'] !== 'subscription_type' ? 'display:none;' : ''); ?>">
                                                            <?php $__currentLoopData = $subscriptionPlans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php
                                                                    $selectedPlans =
                                                                        $condition['condition_type'] ===
                                                                            'subscription_type' &&
                                                                        isset($condition['condition_value'])
                                                                            ? explode(
                                                                                ',',
                                                                                $condition['condition_value'],
                                                                            )
                                                                            : [];
                                                                ?>
                                                                <option value="<?php echo e($plan->name); ?>"
                                                                    <?php echo e(in_array($plan->name, $selectedPlans) ? 'selected' : ''); ?>>
                                                                    <?php echo e($plan->name); ?> - Rp
                                                                    <?php echo e(number_format($plan->price, 0, ',', '.')); ?>

                                                                </option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                        <small class="form-text text-muted condition-hint"></small>
                                                    </div>
                                                    <div class="col-md-1 d-flex align-items-end">
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm remove-condition">
                                                            <i class="ti ti-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </div>

                            <div id="noConditions" class="text-center text-muted py-3"
                                style="<?php echo e(old('conditions') ? 'display:none;' : ''); ?>">
                                <i class="fas fa-info-circle"></i> No conditions added. Click "Add Condition" to set
                                restrictions.
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <a href="<?php echo e(route('admin.promos.index')); ?>" class="btn btn-label-secondary">
                                    <i class="ti ti-x me-1"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-check me-1"></i> Create Promo
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Help Sidebar -->
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="ti ti-help"></i> Help & Tips
                        </h5>
                    </div>
                    <div class="card-body">
                        <h6 class="font-weight-bold">Discount Types:</h6>
                        <ul class="small">
                            <li><strong>Percentage:</strong> Reduces price by % (e.g., 50% off)</li>
                            <li><strong>Fixed Amount:</strong> Reduces price by $ (e.g., $10 off)</li>
                            <li><strong>Free Trial:</strong> Number of free days</li>
                        </ul>

                        <h6 class="font-weight-bold mt-3">Condition Types:</h6>
                        <ul class="small">
                            <li><strong>New User:</strong> Users registered within 7 days (no value needed)</li>
                            <li><strong>First Subscription:</strong> User's first subscription only (no value needed)</li>
                            <li><strong>Subscription Type:</strong> Specific plan types (e.g., "Premium,Pro")</li>
                            <li><strong>Minimum Price:</strong> Order must meet minimum amount (e.g., "9.99")</li>
                        </ul>

                        <h6 class="font-weight-bold mt-3">Examples:</h6>
                        <div class="alert alert-info small">
                            <strong>Welcome Discount:</strong><br>
                            - Code: WELCOME50<br>
                            - Type: Percentage (50%)<br>
                            - Conditions: New User + First Subscription
                        </div>
                        <div class="alert alert-success small">
                            <strong>Holiday Sale:</strong><br>
                            - Code: HOLIDAY70<br>
                            - Type: Percentage (70%)<br>
                            - Conditions: Min Price $9.99
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            let conditionIndex = <?php echo e(old('conditions') ? count(old('conditions')) : 0); ?>;

            // Update value field based on type selection
            $('#type').on('change', function() {
                const type = $(this).val();
                const valueInput = $('#value');
                const unitLabel = $('#unitLabel');
                const valueHint = $('#valueHint');
                const valueLabel = $('#valueLabel');

                switch (type) {
                    case 'percentage':
                        valueLabel.text('Discount Percentage');
                        unitLabel.text('%');
                        valueInput.attr('max', '100');
                        valueInput.attr('placeholder', 'Enter percentage (e.g., 50)');
                        valueHint.text('Enter the discount percentage (0-100). Example: 50 for 50% off');
                        break;
                    case 'fixed_amount':
                        valueLabel.text('Discount Amount');
                        unitLabel.text('Rp');
                        valueInput.removeAttr('max');
                        valueInput.attr('placeholder', 'Enter amount (e.g., 10000)');
                        valueHint.text('Enter the discount amount in rupiah. Example: 10000 for Rp 10.000 off');
                        break;
                    case 'free_trial':
                        valueLabel.text('Trial Days');
                        unitLabel.text('days');
                        valueInput.attr('max', '365');
                        valueInput.attr('placeholder', 'Enter days (e.g., 30)');
                        valueHint.text('Enter number of free trial days (1-365). Example: 30 for 30 days free');
                        break;
                    default:
                        valueLabel.text('Discount Value');
                        unitLabel.text('-');
                        valueInput.removeAttr('max');
                        valueInput.attr('placeholder', 'Enter value');
                        valueHint.text('Select a discount type first');
                }
            });

            // Uppercase code input
            $('#code').on('input', function() {
                this.value = this.value.toUpperCase();
            });

            // Add Condition
            $('#addCondition').on('click', function() {
                const html = `
        <div class="condition-row card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-5">
                        <label>Condition Type</label>
                        <select class="form-control condition-type" name="conditions[${conditionIndex}][condition_type]" required>
                            <option value="">-- Select Type --</option>
                            <option value="new_user">New User Only</option>
                            <option value="first_subscription">First Subscription Only</option>
                            <option value="subscription_type">Specific Subscription Type</option>
                            <option value="min_price">Minimum Price</option>
                        </select>
                    </div>
                    <div class="col-md-6 condition-value-wrapper" style="display:none;">
                        <label>Value <span class="value-required text-danger" style="display:none;">*</span></label>
                        <input type="number"
                               class="form-control condition-value condition-value-text"
                               name="conditions[${conditionIndex}][condition_value_text]"
                               step="0.01"
                               placeholder="Enter value"
                               style="display:none;">
                        <select class="form-select condition-value condition-value-select"
                                name="conditions[${conditionIndex}][condition_value_select]"
                                multiple
                                style="display:none;">
                            <?php $__currentLoopData = $subscriptionPlans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($plan->name); ?>"><?php echo e($plan->name); ?> - Rp <?php echo e(number_format($plan->price, 0, ',', '.')); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <small class="form-text text-muted condition-hint"></small>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-danger btn-sm remove-condition">
                            <i class="ti ti-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;

                const newRow = $(html);
                $('#conditionsContainer').append(newRow);

                // Initialize select2 for subscription type select
                newRow.find('.condition-value-select').select2({
                    placeholder: 'Select subscription plans',
                    allowClear: true,
                    width: '100%'
                });

                $('#noConditions').hide();
                conditionIndex++;
            });

            // Remove Condition
            $(document).on('click', '.remove-condition', function() {
                $(this).closest('.condition-row').remove();

                if ($('.condition-row').length === 0) {
                    $('#noConditions').show();
                }
            });

            // Update condition value field based on type
            $(document).on('change', '.condition-type', function() {
                const type = $(this).val();
                const row = $(this).closest('.condition-row');
                const valueWrapper = row.find('.condition-value-wrapper');
                const textInput = row.find('.condition-value-text');
                const selectInput = row.find('.condition-value-select');
                const valueRequired = row.find('.value-required');
                const hint = row.find('.condition-hint');

                // Hide all inputs first
                textInput.hide().prop('required', false);
                selectInput.hide().prop('required', false);

                switch (type) {
                    case 'new_user':
                    case 'first_subscription':
                        valueWrapper.hide();
                        textInput.val('');
                        selectInput.val(null).trigger('change');
                        valueRequired.hide();
                        hint.text('This condition does not require a value');
                        break;
                    case 'subscription_type':
                        valueWrapper.show();
                        selectInput.show().prop('required', true);
                        textInput.hide();
                        valueRequired.show();
                        hint.text('Select one or more subscription plans');
                        break;
                    case 'min_price':
                        valueWrapper.show();
                        textInput.show().prop('required', true);
                        selectInput.hide();
                        textInput.attr('type', 'number').attr('step', '1').attr('placeholder', 'e.g., 99000');
                        valueRequired.show();
                        hint.text('Enter minimum price in rupiah (e.g., 99000)');
                        break;
                    default:
                        valueWrapper.show();
                        textInput.show();
                        selectInput.hide();
                        textInput.attr('type', 'text').attr('placeholder', 'Enter value');
                        valueRequired.hide();
                        hint.text('');
                }
            });

            // Form validation
            $('#promoForm').on('submit', function(e) {
                const type = $('#type').val();
                const value = parseFloat($('#value').val());

                if (type === 'percentage' && value > 100) {
                    e.preventDefault();
                    alert('Percentage cannot exceed 100%');
                    return false;
                }

                if (type === 'free_trial' && value > 365) {
                    e.preventDefault();
                    alert('Free trial days cannot exceed 365 days');
                    return false;
                }

                const startDate = new Date($('#start_date').val());
                const endDate = new Date($('#end_date').val());

                if (endDate <= startDate) {
                    e.preventDefault();
                    alert('End date must be after start date');
                    return false;
                }

                // Process conditions: merge select values into single field
                $('.condition-row').each(function(index) {
                    const row = $(this);
                    const conditionType = row.find('.condition-type').val();

                    if (conditionType === 'subscription_type') {
                        const selectedValues = row.find('.condition-value-select').val();
                        if (selectedValues && selectedValues.length > 0) {
                            // Create hidden input with comma-separated values
                            const joinedValue = selectedValues.join(',');
                            row.append(
                                `<input type="hidden" name="conditions[${index}][condition_value]" value="${joinedValue}">`
                                );
                        }
                        // Remove the select name to avoid duplicate submission
                        row.find('.condition-value-select').attr('name', '');
                    } else if (conditionType === 'min_price') {
                        const textValue = row.find('.condition-value-text').val();
                        if (textValue) {
                            row.append(
                                `<input type="hidden" name="conditions[${index}][condition_value]" value="${textValue}">`
                                );
                        }
                        // Remove the text input name
                        row.find('.condition-value-text').attr('name', '');
                    }
                });
            });

            // Trigger type change on page load if value exists
            $(document).ready(function() {
                if ($('#type').val()) {
                    $('#type').trigger('change');
                }

                // Initialize select2 for existing conditions
                $('.condition-value-select').each(function() {
                    $(this).select2({
                        placeholder: 'Select subscription plans',
                        allowClear: true,
                        width: '100%'
                    });
                });

                // Update condition hints for existing conditions
                $('.condition-type').each(function() {
                    if ($(this).val()) {
                        $(this).trigger('change');
                    }
                });
            });
        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views/admin/promos/create.blade.php ENDPATH**/ ?>