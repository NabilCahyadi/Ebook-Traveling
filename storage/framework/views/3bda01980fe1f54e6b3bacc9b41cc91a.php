<?php $__env->startSection('title', 'Subscription Details'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Subscription / Manual Subscriptions /</span> Details
        </h4>

        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Subscription Information</h5>
                        <div>
                            <?php if($subscription->status === 'active' && $subscription->end_date->isFuture()): ?>
                                <span class="badge bg-success">Active</span>
                            <?php elseif($subscription->status === 'active' && $subscription->end_date->isPast()): ?>
                                <span class="badge bg-warning">Expired</span>
                            <?php elseif($subscription->status === 'cancelled'): ?>
                                <span class="badge bg-danger">Cancelled</span>
                            <?php else: ?>
                                <span class="badge bg-secondary"><?php echo e(ucfirst($subscription->status)); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <strong>Subscription Code:</strong>
                            </div>
                            <div class="col-sm-8">
                                <span class="badge bg-label-primary"
                                    style="font-size: 0.9rem;"><?php echo e($subscription->subscription_code); ?></span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <strong>User:</strong>
                            </div>
                            <div class="col-sm-8">
                                <div class="d-flex flex-column">
                                    <span><?php echo e($subscription->user->name); ?></span>
                                    <small class="text-muted"><?php echo e($subscription->user->email); ?></small>
                                    <?php if($subscription->user->phone): ?>
                                        <small class="text-muted"><?php echo e($subscription->user->phone); ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <strong>Plan:</strong>
                            </div>
                            <div class="col-sm-8">
                                <span class="badge bg-label-info"><?php echo e($subscription->plan->name); ?></span>
                                <div class="mt-1">
                                    <small class="text-muted"><?php echo e($subscription->plan->duration_days); ?> days</small>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <strong>Start Date:</strong>
                            </div>
                            <div class="col-sm-8">
                                <?php echo e($subscription->start_date->format('d M Y, H:i')); ?>

                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <strong>End Date:</strong>
                            </div>
                            <div class="col-sm-8">
                                <?php echo e($subscription->end_date->format('d M Y, H:i')); ?>

                                <?php if($subscription->end_date->isFuture()): ?>
                                    <small class="text-success d-block">
                                        (<?php echo e($subscription->end_date->diffForHumans()); ?>)
                                    </small>
                                <?php else: ?>
                                    <small class="text-danger d-block">
                                        (Expired <?php echo e($subscription->end_date->diffForHumans()); ?>)
                                    </small>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <strong>Total Amount:</strong>
                            </div>
                            <div class="col-sm-8">
                                <strong class="text-primary">Rp
                                    <?php echo e(number_format($subscription->total_amount, 0, ',', '.')); ?></strong>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <strong>Auto Renew:</strong>
                            </div>
                            <div class="col-sm-8">
                                <?php if($subscription->auto_renew): ?>
                                    <span class="badge bg-success">Yes</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">No</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <strong>Created At:</strong>
                            </div>
                            <div class="col-sm-8">
                                <?php echo e($subscription->created_at->format('d M Y, H:i')); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <?php if($subscription->status === 'active'): ?>
                                <a href="<?php echo e(route('admin.manual-subscriptions.extend', $subscription->id)); ?>"
                                    class="btn btn-primary">
                                    <i class="bx bx-time me-1"></i> Extend Subscription
                                </a>

                                <form action="<?php echo e(route('admin.manual-subscriptions.cancel', $subscription->id)); ?>"
                                    method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-warning w-100"
                                        onclick="return confirm('Are you sure you want to cancel this subscription?')">
                                        <i class="bx bx-x-circle me-1"></i> Cancel Subscription
                                    </button>
                                </form>
                            <?php endif; ?>

                            <a href="<?php echo e(route('admin.manual-subscriptions.index')); ?>" class="btn btn-outline-secondary">
                                <i class="bx bx-arrow-back me-1"></i> Back to List
                            </a>
                            <hr>

                            <form action="<?php echo e(route('admin.manual-subscriptions.destroy', $subscription->id)); ?>"
                                method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger w-100"
                                    onclick="return confirm('Are you sure you want to delete this subscription? This action cannot be undone.')">
                                    <i class="bx bx-trash me-1"></i> Delete Subscription
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <?php if($subscription->plan->features): ?>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Plan Features</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <?php $__currentLoopData = $subscription->plan->features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="mb-2">
                                        <i class="bx bx-check text-success me-2"></i><?php echo e($feature); ?>

                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\admin\manual-subscriptions\show.blade.php ENDPATH**/ ?>