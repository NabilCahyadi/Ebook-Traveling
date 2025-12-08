<?php $__env->startSection('title', 'Subscription Plans'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">Admin /</span> Subscription Plans
            </h4>
            <a href="<?php echo e(route('admin.subscription-plans.create')); ?>" class="btn btn-primary">
                <i class="bx bx-plus me-1"></i> Add New Plan
            </a>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">All Subscription Plans</h5>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Plan Name</th>
                            <th>Duration</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Subscribers</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <div>
                                        <strong class="d-block"><?php echo e($plan->name); ?></strong>
                                        <?php if($plan->description): ?>
                                            <small class="text-muted"><?php echo e(Str::limit($plan->description, 50)); ?></small>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-label-info">
                                        <?php if($plan->duration_days == 30): ?>
                                            1 Month
                                        <?php elseif($plan->duration_days == 180): ?>
                                            6 Months
                                        <?php elseif($plan->duration_days == 365): ?>
                                            1 Year
                                        <?php else: ?>
                                            <?php echo e($plan->duration_days); ?> Days
                                        <?php endif; ?>
                                    </span>
                                </td>
                                <td>
                                    <strong class="text-primary">Rp <?php echo e(number_format($plan->price, 0, ',', '.')); ?></strong>
                                </td>
                                <td>
                                    <?php if($plan->is_active): ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="text-muted"><?php echo e($plan->subscriptions->count()); ?></span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button"
                                            class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item"
                                                href="<?php echo e(route('admin.subscription-plans.show', $plan->id)); ?>">
                                                <i class="ti ti-eye me-2"></i> View Details
                                            </a>
                                            <a class="dropdown-item"
                                                href="<?php echo e(route('admin.subscription-plans.edit', $plan->id)); ?>">
                                                <i class="ti ti-pencil me-2"></i> Edit
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <form action="<?php echo e(route('admin.subscription-plans.destroy', $plan->id)); ?>"
                                                method="POST" style="display: none;" id="delete-plan-<?php echo e($plan->id); ?>">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                            </form>
                                            <a class="dropdown-item text-danger" href="javascript:void(0);"
                                                onclick="if(confirm('Are you sure you want to delete this plan?')) document.getElementById('delete-plan-<?php echo e($plan->id); ?>').submit();">
                                                <i class="ti ti-trash me-2"></i> Delete
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="bx bx-package" style="font-size: 48px; color: #ddd;"></i>
                                    <p class="mt-2 text-muted">No subscription plans found</p>
                                    <a href="<?php echo e(route('admin.subscription-plans.create')); ?>"
                                        class="btn btn-sm btn-primary">Add Your First Plan</a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($plans->hasPages()): ?>
                <div class="card-footer">
                    <?php echo e($plans->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views/admin/subscription-plans/index.blade.php ENDPATH**/ ?>