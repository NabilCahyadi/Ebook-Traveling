<?php $__env->startSection('title', 'Subscription Plan Details'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">Admin / Subscription Plans /</span> Details
            </h4>
            <div>
                <a href="<?php echo e(route('admin.subscription-plans.edit', $plan->id)); ?>" class="btn btn-primary me-2">
                    <i class="bx bx-edit me-1"></i> Edit
                </a>
                <a href="<?php echo e(route('admin.subscription-plans.index')); ?>" class="btn btn-secondary">
                    <i class="bx bx-arrow-back me-1"></i> Back
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Plan Information</h5>
                        <span class="badge bg-<?php echo e($plan->is_active ? 'success' : 'secondary'); ?>">
                            <?php echo e($plan->is_active ? 'Active' : 'Inactive'); ?>

                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <h6 class="text-muted mb-1">Plan Name</h6>
                            </div>
                            <div class="col-sm-8">
                                <h5 class="mb-0"><?php echo e($plan->name); ?></h5>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <h6 class="text-muted mb-1">Slug</h6>
                            </div>
                            <div class="col-sm-8">
                                <code><?php echo e($plan->slug); ?></code>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <h6 class="text-muted mb-1">Description</h6>
                            </div>
                            <div class="col-sm-8">
                                <p class="mb-0"><?php echo e($plan->description ?? 'No description provided'); ?></p>
                            </div>
                        </div>

                        <hr>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <h6 class="text-muted mb-1">Price</h6>
                            </div>
                            <div class="col-sm-8">
                                <h4 class="text-primary mb-0">Rp <?php echo e(number_format($plan->price, 0, ',', '.')); ?></h4>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <h6 class="text-muted mb-1">Duration</h6>
                            </div>
                            <div class="col-sm-8">
                                <span class="badge bg-label-info"><?php echo e($plan->duration_days); ?> Days</span>
                                <?php if($plan->duration_days == 30): ?>
                                    <span class="text-muted">(1 Month)</span>
                                <?php elseif($plan->duration_days == 180): ?>
                                    <span class="text-muted">(6 Months)</span>
                                <?php elseif($plan->duration_days == 365): ?>
                                    <span class="text-muted">(1 Year)</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-sm-4">
                                <h6 class="text-muted mb-1">Features</h6>
                            </div>
                            <div class="col-sm-8">
                                <?php if($plan->features && count($plan->features) > 0): ?>
                                    <ul class="list-unstyled mb-0">
                                        <?php $__currentLoopData = $plan->features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="mb-2">
                                                <i class="bx bx-check-circle text-success me-2"></i>
                                                <?php echo e($feature); ?>

                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                <?php else: ?>
                                    <p class="text-muted mb-0">No features listed</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Statistics</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="badge bg-label-primary rounded p-2 me-3">
                                <i class="bx bx-user fs-4"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Active Subscribers</small>
                                <h5 class="mb-0"><?php echo e($plan->subscriptions()->where('status', 'active')->count()); ?></h5>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-3">
                            <div class="badge bg-label-info rounded p-2 me-3">
                                <i class="bx bx-time fs-4"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Total Subscriptions</small>
                                <h5 class="mb-0"><?php echo e($plan->subscriptions()->count()); ?></h5>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <div class="badge bg-label-success rounded p-2 me-3">
                                <i class="bx bx-money fs-4"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Estimated Revenue</small>
                                <h5 class="mb-0">Rp
                                    <?php echo e(number_format($plan->subscriptions()->count() * $plan->price, 0, ',', '.')); ?></h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Additional Info</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Created At</small>
                            <p class="mb-0"><?php echo e($plan->created_at->format('d M Y, H:i')); ?></p>
                        </div>
                        <div>
                            <small class="text-muted d-block mb-1">Last Updated</small>
                            <p class="mb-0"><?php echo e($plan->updated_at->format('d M Y, H:i')); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views/admin/subscription-plans/show.blade.php ENDPATH**/ ?>