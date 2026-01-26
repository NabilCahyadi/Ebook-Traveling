<?php $__env->startSection('title', __('admin.manual_subscription.title')); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light"><?php echo e(__('admin.menu.subscription')); ?> /</span> <?php echo e(__('admin.manual_subscription.title')); ?>

            </h4>
            <a href="<?php echo e(route('admin.manual-subscriptions.create')); ?>" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i> <?php echo e(__('admin.manual_subscription.create')); ?>

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
                <div class="row align-items-center g-3">
                    <div class="col-12 col-md-6">
                        <h5 class="mb-0"><?php echo e(__('admin.manual_subscription.all_subscriptions')); ?></h5>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="<?php echo e(route('admin.manual-subscriptions.export', request()->all())); ?>" class="btn btn-success btn-sm">
                                <i class="ti ti-download me-1"></i>
                                <?php echo e(__('admin.common.export')); ?>

                            </a>
                            <form method="GET" action="<?php echo e(route('admin.manual-subscriptions.index')); ?>" class="flex-grow-1" style="max-width: 400px;">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text"><i class="ti ti-search"></i></span>
                                    <input type="text" class="form-control" name="search"
                                        placeholder="<?php echo e(__('admin.manual_subscription.search_placeholder')); ?>" value="<?php echo e($search ?? ''); ?>">
                                    <button type="submit" class="btn btn-primary"><?php echo e(__('admin.common.search')); ?></button>
                                    <?php if($search): ?>
                                        <a href="<?php echo e(route('admin.manual-subscriptions.index')); ?>"
                                            class="btn btn-outline-secondary"><?php echo e(__('admin.common.clear')); ?></a>
                                    <?php endif; ?>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th><?php echo e(__('admin.manual_subscription.code')); ?></th>
                            <th><?php echo e(__('admin.manual_subscription.user')); ?></th>
                            <th><?php echo e(__('admin.manual_subscription.plan')); ?></th>
                            <th><?php echo e(__('admin.manual_subscription.start_date')); ?></th>
                            <th><?php echo e(__('admin.manual_subscription.end_date')); ?></th>
                            <th><?php echo e(__('admin.manual_subscription.status')); ?></th>
                            <th><?php echo e(__('admin.manual_subscription.amount')); ?></th>
                            <th><?php echo e(__('admin.ebooks.actions')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $subscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($subscription->subscription_code); ?></strong>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-semibold"><?php echo e($subscription->user->name); ?></span>
                                        <small class="text-muted"><?php echo e($subscription->user->email); ?></small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-label-info"><?php echo e($subscription->plan->name); ?></span>
                                </td>
                                <td><?php echo e($subscription->start_date->format('d M Y')); ?></td>
                                <td><?php echo e($subscription->end_date->format('d M Y')); ?></td>
                                <td>
                                    <?php if($subscription->status === 'active'): ?>
                                        <?php if($subscription->end_date->isFuture()): ?>
                                            <span class="badge bg-success"><?php echo e(__('admin.status.active')); ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-warning"><?php echo e(__('admin.status.expired')); ?></span>
                                        <?php endif; ?>
                                    <?php elseif($subscription->status === 'cancelled'): ?>
                                        <span class="badge bg-danger"><?php echo e(__('admin.status.cancelled')); ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary"><?php echo e(ucfirst($subscription->status)); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>Rp <?php echo e(number_format($subscription->total_amount, 0, ',', '.')); ?></td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-sm btn-icon dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item"
                                                href="<?php echo e(route('admin.manual-subscriptions.show', $subscription->id)); ?>">
                                                <i class="ti ti-eye me-2"></i> <?php echo e(__('admin.actions.view_details')); ?>

                                            </a>
                                            <?php if($subscription->status === 'active'): ?>
                                                <a class="dropdown-item"
                                                    href="<?php echo e(route('admin.manual-subscriptions.extend', $subscription->id)); ?>">
                                                    <i class="ti ti-clock me-2"></i> <?php echo e(__('admin.manual_subscription.extend')); ?>

                                                </a>
                                                <form
                                                    action="<?php echo e(route('admin.manual-subscriptions.cancel', $subscription->id)); ?>"
                                                    method="POST" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" class="dropdown-item text-warning"
                                                        onclick="return confirm('<?php echo e(__('admin.manual_subscription.confirm_cancel')); ?>')">
                                                        <i class="ti ti-x me-2"></i> <?php echo e(__('admin.manual_subscription.cancel_subscription')); ?>

                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                            <div class="dropdown-divider"></div>
                                            <form
                                                action="<?php echo e(route('admin.manual-subscriptions.destroy', $subscription->id)); ?>"
                                                method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="dropdown-item text-danger"
                                                    onclick="return confirm('<?php echo e(__('admin.manual_subscription.confirm_delete')); ?>')">
                                                    <i class="ti ti-trash me-2"></i> <?php echo e(__('admin.actions.delete')); ?>

                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="ti ti-info-circle mb-2" style="font-size: 2rem;"></i>
                                        <p><?php echo e(__('admin.manual_subscription.no_subscriptions')); ?></p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($subscriptions->hasPages()): ?>
                <div class="card-footer">
                    <?php echo e($subscriptions->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\admin\manual-subscriptions\index.blade.php ENDPATH**/ ?>