<?php $__env->startSection('title', __('admin.subscribers.title')); ?>

<?php $__env->startSection('content'); ?>

    <!-- Success/Error Messages -->
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong><?php echo e(__('admin.messages.success_title')); ?></strong> <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><?php echo e(__('admin.messages.error_title')); ?></strong> <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold py-3 mb-2">
                <span class="text-muted fw-light"><?php echo e(__('admin.menu.subscription')); ?> /</span> <?php echo e(__('admin.subscribers.title')); ?>

            </h4>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="ti ti-filter me-2"></i><?php echo e(__('admin.subscribers.filter_subscribers')); ?>

            </h5>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('admin.active-subscribers.index')); ?>" method="GET" id="filterForm">
                <div class="row g-3">
                    <!-- Search -->
                    <div class="col-md-3">
                        <label for="search" class="form-label"><?php echo e(__('admin.common.search')); ?></label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="<?php echo e(request('search')); ?>" 
                               placeholder="<?php echo e(__('admin.subscribers.search_placeholder')); ?>">
                    </div>

                    <!-- Role Filter -->
                    <div class="col-md-3">
                        <label for="role" class="form-label"><?php echo e(__('admin.users.role')); ?></label>
                        <select class="form-select" id="role" name="role">
                            <option value=""><?php echo e(__('admin.users.all_roles')); ?></option>
                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($role->slug); ?>" 
                                    <?php echo e(request('role') == $role->slug ? 'selected' : ''); ?>>
                                    <?php echo e($role->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- Subscription Plan Filter -->
                    <div class="col-md-3">
                        <label for="subscription_plan" class="form-label"><?php echo e(__('admin.subscribers.subscription_plan')); ?></label>
                        <select class="form-select" id="subscription_plan" name="subscription_plan">
                            <option value=""><?php echo e(__('admin.subscribers.all_plans')); ?></option>
                            <?php $__currentLoopData = $subscriptionPlans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($plan->id); ?>" 
                                    <?php echo e(request('subscription_plan') == $plan->id ? 'selected' : ''); ?>>
                                    <?php echo e($plan->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- Date From -->
                    <div class="col-md-3">
                        <label for="date_from" class="form-label"><?php echo e(__('admin.subscribers.start_date_from')); ?></label>
                        <input type="date" class="form-control" id="date_from" name="date_from" 
                               value="<?php echo e(request('date_from')); ?>">
                    </div>

                    <!-- Date To -->
                    <div class="col-md-3">
                        <label for="date_to" class="form-label"><?php echo e(__('admin.subscribers.start_date_to')); ?></label>
                        <input type="date" class="form-control" id="date_to" name="date_to" 
                               value="<?php echo e(request('date_to')); ?>">
                    </div>

                    <!-- Filter Buttons -->
                    <div class="col-md-9 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="ti ti-search me-1"></i> <?php echo e(__('admin.actions.apply_filters')); ?>

                        </button>
                        <a href="<?php echo e(route('admin.active-subscribers.index')); ?>" class="btn btn-secondary">
                            <i class="ti ti-refresh me-1"></i> <?php echo e(__('admin.actions.reset')); ?>

                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Subscribers Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><?php echo e(__('admin.subscribers.list')); ?></h5>
            <div class="d-flex align-items-center gap-3">
                <div class="text-muted"><?php echo e(__('admin.common.total')); ?>: <?php echo e($subscriptions->total()); ?> <?php echo e(__('admin.subscribers.subscribers')); ?></div>
                <div class="d-flex align-items-center gap-2">
                    <label for="perPageSelect" class="mb-0 text-muted" style="white-space: nowrap;"><?php echo e(__('admin.common.show')); ?>:</label>
                    <select id="perPageSelect" class="form-select form-select-sm" style="width: auto;" onchange="changePerPage(this.value)">
                        <?php $__currentLoopData = [5, 10, 15, 20, 25, 30, 50]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($option); ?>" <?php echo e(request('per_page', 15) == $option ? 'selected' : ''); ?>>
                                <?php echo e($option); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body">
            <?php if($subscriptions->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th><?php echo e(__('admin.subscribers.user')); ?></th>
                                <th><?php echo e(__('admin.subscribers.email')); ?></th>
                                <th><?php echo e(__('admin.subscribers.role')); ?></th>
                                <th><?php echo e(__('admin.subscribers.plan')); ?></th>
                                <th><?php echo e(__('admin.subscribers.status')); ?></th>
                                <th><?php echo e(__('admin.subscribers.start_date')); ?></th>
                                <th><?php echo e(__('admin.subscribers.end_date')); ?></th>
                                <th><?php echo e(__('admin.subscribers.amount')); ?></th>
                                <th><?php echo e(__('admin.actions.actions')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $subscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-2">
                                                <span class="avatar-initial rounded-circle bg-label-primary">
                                                    <?php echo e(substr($subscription->user->name ?? 'U', 0, 1)); ?>

                                                </span>
                                            </div>
                                            <div>
                                                <div class="fw-medium"><?php echo e($subscription->user->name ?? 'N/A'); ?></div>
                                                <small class="text-muted">#<?php echo e($subscription->subscription_code); ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div><?php echo e($subscription->user->email ?? 'N/A'); ?></div>
                                        <?php if($subscription->user && $subscription->user->email_verified_at): ?>
                                            <small class="text-success">
                                                <i class="ti ti-check ti-xs"></i> <?php echo e(__('admin.status.verified')); ?>

                                            </small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($subscription->user && $subscription->user->roles && $subscription->user->roles->count() > 0): ?>
                                            <?php $__currentLoopData = $subscription->user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <span class="badge bg-label-primary mb-1"><?php echo e($role->name); ?></span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            <span class="badge bg-label-secondary"><?php echo e(__('admin.users.no_role')); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($subscription->plan): ?>
                                            <div class="fw-medium"><?php echo e($subscription->plan->name); ?></div>
                                            <small class="text-muted">
                                                <?php echo e($subscription->plan->duration_days); ?> <?php echo e(__('admin.subscribers.days')); ?>

                                            </small>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($subscription->status === 'active'): ?>
                                            <span class="badge bg-success">
                                                <i class="ti ti-check ti-xs"></i> <?php echo e(__('admin.status.active')); ?>

                                            </span>
                                        <?php elseif($subscription->status === 'pending'): ?>
                                            <span class="badge bg-warning">
                                                <i class="ti ti-clock ti-xs"></i> <?php echo e(__('admin.status.pending')); ?>

                                            </span>
                                        <?php elseif($subscription->status === 'expired'): ?>
                                            <span class="badge bg-danger">
                                                <i class="ti ti-x ti-xs"></i> <?php echo e(__('admin.status.expired')); ?>

                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">
                                                <?php echo e(ucfirst($subscription->status)); ?>

                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <?php echo e($subscription->start_date ? $subscription->start_date->format('d M Y') : '-'); ?><br>
                                            <?php echo e($subscription->start_date ? $subscription->start_date->format('H:i') : ''); ?>

                                        </small>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <?php echo e($subscription->end_date ? $subscription->end_date->format('d M Y') : '-'); ?><br>
                                            <?php echo e($subscription->end_date ? $subscription->end_date->format('H:i') : ''); ?>

                                        </small>
                                        <?php if($subscription->end_date && $subscription->end_date < now()): ?>
                                            <br><small class="text-danger"><i class="ti ti-alert-circle ti-xs"></i> <?php echo e(__('admin.status.expired')); ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="fw-medium">
                                            Rp <?php echo e(number_format($subscription->total_amount ?? 0, 0, ',', '.')); ?>

                                        </div>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button"
                                                class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <?php if($subscription->user): ?>
                                                    <a class="dropdown-item" href="<?php echo e(route('admin.users.show', $subscription->user->id)); ?>">
                                                        <i class="ti ti-user me-2"></i>
                                                        <span><?php echo e(__('admin.actions.view_user')); ?></span>
                                                    </a>
                                                <?php endif; ?>
                                                <a class="dropdown-item" href="<?php echo e(route('admin.manual-subscriptions.show', $subscription->id)); ?>">
                                                    <i class="ti ti-eye me-2"></i>
                                                    <span><?php echo e(__('admin.actions.view_subscription')); ?></span>
                                                </a>
                                                <?php if($subscription->status === 'active'): ?>
                                                    <a class="dropdown-item" href="<?php echo e(route('admin.manual-subscriptions.extend', $subscription->id)); ?>">
                                                        <i class="ti ti-calendar-plus me-2"></i>
                                                        <span><?php echo e(__('admin.actions.extend')); ?></span>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    <?php echo e($subscriptions->appends(request()->query())->links()); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="ti ti-users-off ti-xl text-muted mb-3"></i>
                    <h5 class="text-muted"><?php echo e(__('admin.subscribers.no_subscribers')); ?></h5>
                    <p class="text-muted">
                        <?php if(request()->hasAny(['search', 'role', 'subscription_plan', 'date_from', 'date_to'])): ?>
                            <?php echo e(__('admin.subscribers.try_adjusting')); ?>

                        <?php else: ?>
                            <?php echo e(__('admin.subscribers.no_active_yet')); ?>

                        <?php endif; ?>
                    </p>
                    <?php if(request()->hasAny(['search', 'role', 'subscription_plan', 'date_from', 'date_to'])): ?>
                        <a href="<?php echo e(route('admin.active-subscribers.index')); ?>" class="btn btn-primary mt-2">
                            <i class="ti ti-refresh me-1"></i> <?php echo e(__('admin.actions.clear_filters')); ?>

                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function changePerPage(value) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', value);
    url.searchParams.delete('page'); // Reset to first page
    window.location.href = url.toString();
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\admin\subscribers\index.blade.php ENDPATH**/ ?>