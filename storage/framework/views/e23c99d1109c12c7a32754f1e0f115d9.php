

<?php $__env->startSection('title', 'Promo Details - ' . $promo->name); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo e(route('admin.promos.index')); ?>">Promos</a></li>
                        <li class="breadcrumb-item active"><?php echo e($promo->name); ?></li>
                    </ol>
                </nav>
                <h4 class="mb-0">Promo Details</h4>
            </div>
            <div class="d-flex gap-2">
                <a href="<?php echo e(route('admin.promos.edit', $promo->id)); ?>" class="btn btn-primary">
                    <i class="ti ti-edit me-1"></i> Edit Promo
                </a>
                <a href="<?php echo e(route('admin.promos.index')); ?>" class="btn btn-label-secondary">
                    <i class="ti ti-arrow-left me-1"></i> Back to List
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Left Column - Main Information -->
            <div class="col-lg-8">
                <!-- Basic Information Card -->
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Basic Information</h5>
                        <!-- <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="statusSwitch" <?php echo e($promo->is_active ? 'checked' : ''); ?> disabled>
                            <label class="form-check-label" for="statusSwitch">
                                <?php if($promo->is_active): ?>
                                    <span class="badge bg-label-success">Active</span>
                                <?php else: ?>
                                    <span class="badge bg-label-secondary">Inactive</span>
                                <?php endif; ?>
                            </label>
                        </div> -->
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Promo Name</label>
                            </div>
                            <div class="col-md-9">
                                <p class="mb-0"><?php echo e($promo->name); ?></p>
                            </div>
                        </div>

                        <?php if($promo->description): ?>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Description</label>
                            </div>
                            <div class="col-md-9">
                                <p class="mb-0"><?php echo e($promo->description); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Promo Code</label>
                            </div>
                            <div class="col-md-9">
                                <?php if($promo->code): ?>
                                    <span class="badge bg-label-secondary fs-6"><?php echo e($promo->code); ?></span>
                                    <button class="btn btn-sm btn-icon btn-label-secondary ms-2" onclick="copyToClipboard('<?php echo e($promo->code); ?>')" title="Copy code">
                                        <i class="ti ti-copy"></i>
                                    </button>
                                <?php else: ?>
                                    <span class="text-muted">Auto-apply (No code required)</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Promo Type</label>
                            </div>
                            <div class="col-md-9">
                                <?php if($promo->type === 'percentage'): ?>
                                    <span class="badge bg-label-info"><i class="ti ti-percentage me-1"></i>Percentage Discount</span>
                                <?php elseif($promo->type === 'fixed_amount'): ?>
                                    <span class="badge bg-label-success"><i class="ti ti-currency-dollar me-1"></i>Fixed Amount</span>
                                <?php elseif($promo->type === 'free_trial'): ?>
                                    <span class="badge bg-label-warning"><i class="ti ti-gift me-1"></i>Free Trial</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Discount Value</label>
                            </div>
                            <div class="col-md-9">
                                <h4 class="mb-0">
                                    <?php if($promo->type === 'percentage'): ?>
                                        <?php echo e($promo->value); ?>%
                                    <?php elseif($promo->type === 'fixed_amount'): ?>
                                        $<?php echo e(number_format($promo->value, 2)); ?>

                                    <?php else: ?>
                                        <?php echo e($promo->value); ?> days
                                    <?php endif; ?>
                                </h4>
                            </div>
                        </div>

                        <?php if($promo->minimum_purchase): ?>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Minimum Purchase</label>
                            </div>
                            <div class="col-md-9">
                                <p class="mb-0">$<?php echo e(number_format($promo->minimum_purchase, 2)); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if($promo->maximum_discount): ?>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Maximum Discount</label>
                            </div>
                            <div class="col-md-9">
                                <p class="mb-0">$<?php echo e(number_format($promo->maximum_discount, 2)); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Date & Usage Information Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Date & Usage Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted small">START DATE</label>
                                <div class="d-flex align-items-center">
                                    <i class="ti ti-calendar-event me-2 text-primary"></i>
                                    <span><?php echo e($promo->start_date->format('F d, Y')); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted small">END DATE</label>
                                <div class="d-flex align-items-center">
                                    <i class="ti ti-calendar-x me-2 text-danger"></i>
                                    <span><?php echo e($promo->end_date->format('F d, Y')); ?></span>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-muted small">USAGE LIMIT</label>
                                <h4 class="mb-0"><?php echo e($promo->max_usage ?? '∞ Unlimited'); ?></h4>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-muted small">CURRENT USAGE</label>
                                <h4 class="mb-0"><?php echo e($promo->current_usage); ?></h4>
                            </div>
                        </div>

                        <?php if($promo->max_usage): ?>
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted small">USAGE PROGRESS</label>
                            <div class="progress" style="height: 20px;">
                                <?php
                                    $percentage = min(100, ($promo->current_usage / $promo->max_usage) * 100);
                                ?>
                                <div class="progress-bar <?php echo e($percentage >= 100 ? 'bg-danger' : ($percentage >= 75 ? 'bg-warning' : 'bg-success')); ?>"
                                    role="progressbar" style="width: <?php echo e($percentage); ?>%"
                                    aria-valuenow="<?php echo e($percentage); ?>" aria-valuemin="0" aria-valuemax="100">
                                    <?php echo e(number_format($percentage, 1)); ?>%
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if($promo->max_usage_per_user): ?>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted small">MAX USAGE PER USER</label>
                                <p class="mb-0"><?php echo e($promo->max_usage_per_user); ?> time(s)</p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Applicable Plans Card -->
                <?php if($promo->subscriptionPlans && $promo->subscriptionPlans->count() > 0): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Applicable Subscription Plans</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <?php $__currentLoopData = $promo->subscriptionPlans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-6">
                                <div class="border rounded p-3">
                                    <h6 class="mb-1"><?php echo e($plan->name); ?></h6>
                                    <p class="text-muted small mb-0"><?php echo e($plan->duration_days); ?> days - $<?php echo e(number_format($plan->price, 2)); ?></p>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Right Column - Statistics & Actions -->
            <div class="col-lg-4">
                <!-- Quick Stats Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Quick Statistics</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <p class="text-muted mb-1 small">Days Remaining</p>
                                <h4 class="mb-0">
                                    <?php
                                        $daysRemaining = now()->diffInDays($promo->end_date, false);
                                    ?>
                                    <?php if($daysRemaining > 0): ?>
                                        <?php echo e($daysRemaining); ?> days
                                    <?php elseif($daysRemaining === 0): ?>
                                        <span class="text-warning">Ends today</span>
                                    <?php else: ?>
                                        <span class="text-danger">Expired</span>
                                    <?php endif; ?>
                                </h4>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded <?php echo e($daysRemaining > 7 ? 'bg-label-success' : ($daysRemaining > 0 ? 'bg-label-warning' : 'bg-label-danger')); ?>">
                                    <i class="ti ti-clock ti-lg"></i>
                                </span>
                            </div>
                        </div>

                        <?php if($promo->max_usage): ?>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <p class="text-muted mb-1 small">Remaining Uses</p>
                                <h4 class="mb-0"><?php echo e(max(0, $promo->max_usage - $promo->current_usage)); ?></h4>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-info">
                                    <i class="ti ti-ticket ti-lg"></i>
                                </span>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 small">Promo Status</p>
                                <h6 class="mb-0">
                                    <?php if($promo->is_active && $daysRemaining >= 0): ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php elseif(!$promo->is_active): ?>
                                        <span class="badge bg-secondary">Inactive</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Expired</span>
                                    <?php endif; ?>
                                </h6>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded <?php echo e($promo->is_active ? 'bg-label-success' : 'bg-label-secondary'); ?>">
                                    <i class="ti ti-<?php echo e($promo->is_active ? 'check' : 'x'); ?> ti-lg"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Metadata Card -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Metadata</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Created At</small>
                            <span><?php echo e($promo->created_at->format('M d, Y H:i')); ?></span>
                        </div>
                        <div>
                            <small class="text-muted d-block mb-1">Last Updated</small>
                            <span><?php echo e($promo->updated_at->format('M d, Y H:i')); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                toastr.success('Promo code copied to clipboard!');
            }, function() {
                toastr.error('Failed to copy code');
            });
        }
    </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views/admin/promos/show.blade.php ENDPATH**/ ?>