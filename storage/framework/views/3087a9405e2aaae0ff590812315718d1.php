<?php $__env->startSection('title', __('admin.subscription_plans.title')); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light"><?php echo e(__('admin.menu.dashboard')); ?> /</span> <?php echo e(__('admin.subscription_plans.title')); ?>

            </h4>
            <a href="<?php echo e(route('admin.subscription-plans.create')); ?>" class="btn btn-primary">
                <i class="bx bx-plus me-1"></i> <?php echo e(__('admin.subscription_plans.add_plan')); ?>

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
                <h5 class="mb-0"><?php echo e(__('admin.subscription_plans.title')); ?></h5>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th><?php echo e(__('admin.subscription_plans.plan_name')); ?></th>
                            <th><?php echo e(__('admin.subscription_plans.duration_days')); ?></th>
                            <th><?php echo e(__('admin.subscription_plans.price')); ?></th>
                            <th><?php echo e(__('admin.ebooks.status')); ?></th>
                            <th><?php echo e(__('admin.subscription_plans.subscribers')); ?></th>
                            <th><?php echo e(__('admin.users.actions')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <?php if($plan->cover_image): ?>
                                            <div style="width: 120px; aspect-ratio: 3/1; overflow: hidden; border-radius: 0.375rem; background-color: #f5f5f5; flex-shrink: 0;">
                                                <img src="<?php echo e(asset('storage/' . $plan->cover_image)); ?>" alt="Banner" 
                                                    style="width: 100%; height: 100%; object-fit: cover; display: block;">
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <strong class="d-block"><?php echo e($plan->name); ?></strong>
                                            <?php if($plan->description): ?>
                                                <small class="text-muted"><?php echo e(Str::limit($plan->description, 30)); ?></small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-label-info">
                                        <?php if($plan->duration_days == 30): ?>
                                            1 <?php echo e(__('admin.receipt.month')); ?>

                                        <?php elseif($plan->duration_days == 180): ?>
                                            6 <?php echo e(__('admin.receipt.months')); ?>

                                        <?php elseif($plan->duration_days == 365): ?>
                                            1 <?php echo e(__('admin.receipt.year')); ?>

                                        <?php else: ?>
                                            <?php echo e($plan->duration_days); ?> <?php echo e(__('admin.receipt.days')); ?>

                                        <?php endif; ?>
                                    </span>
                                </td>
                                <td>
                                    <strong class="text-primary">Rp <?php echo e(number_format($plan->price, 0, ',', '.')); ?></strong>
                                </td>
                                <td>
                                    <?php if($plan->is_active): ?>
                                        <span class="badge bg-success"><?php echo e(__('admin.status.active')); ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary"><?php echo e(__('admin.status.inactive')); ?></span>
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
                                                <i class="ti ti-eye me-2"></i> <?php echo e(__('admin.actions.view_details')); ?>

                                            </a>
                                            <a class="dropdown-item"
                                                href="<?php echo e(route('admin.subscription-plans.edit', $plan->id)); ?>">
                                                <i class="ti ti-pencil me-2"></i> <?php echo e(__('admin.actions.edit')); ?>

                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <form action="<?php echo e(route('admin.subscription-plans.destroy', $plan->id)); ?>"
                                                method="POST" style="display: none;" id="delete-plan-<?php echo e($plan->id); ?>">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                            </form>
                                            <a class="dropdown-item text-danger" href="javascript:void(0);"
                                                onclick="if(confirm('Are you sure you want to delete this plan?')) document.getElementById('delete-plan-<?php echo e($plan->id); ?>').submit();">
                                                <i class="ti ti-trash me-2"></i> <?php echo e(__('admin.actions.delete')); ?>

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
                                        class="btn btn-sm btn-primary"><?php echo e(__('admin.subscription_plans.add_plan')); ?></a>
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