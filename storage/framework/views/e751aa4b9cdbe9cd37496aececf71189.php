

<?php $__env->startSection('title', 'Active Subscribers'); ?>

<?php $__env->startSection('content'); ?>

    <!-- Success/Error Messages -->
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold py-3 mb-2">
                <span class="text-muted fw-light">Subscription /</span> Active Subscribers
            </h4>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="ti ti-filter me-2"></i>Filter Subscribers
            </h5>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('admin.active-subscribers.index')); ?>" method="GET" id="filterForm">
                <div class="row g-3">
                    <!-- Search -->
                    <div class="col-md-3">
                        <label for="search" class="form-label">Search</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="<?php echo e(request('search')); ?>" 
                               placeholder="Name or email...">
                    </div>

                    <!-- Role Filter -->
                    <div class="col-md-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role">
                            <option value="">All Roles</option>
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
                        <label for="subscription_plan" class="form-label">Subscription Plan</label>
                        <select class="form-select" id="subscription_plan" name="subscription_plan">
                            <option value="">All Plans</option>
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
                        <label for="date_from" class="form-label">Start Date From</label>
                        <input type="date" class="form-control" id="date_from" name="date_from" 
                               value="<?php echo e(request('date_from')); ?>">
                    </div>

                    <!-- Date To -->
                    <div class="col-md-3">
                        <label for="date_to" class="form-label">Start Date To</label>
                        <input type="date" class="form-control" id="date_to" name="date_to" 
                               value="<?php echo e(request('date_to')); ?>">
                    </div>

                    <!-- Filter Buttons -->
                    <div class="col-md-9 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="ti ti-search me-1"></i> Apply Filters
                        </button>
                        <a href="<?php echo e(route('admin.active-subscribers.index')); ?>" class="btn btn-secondary">
                            <i class="ti ti-refresh me-1"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Subscribers Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Subscribers List</h5>
            <div class="text-muted">Total: <?php echo e($subscriptions->total()); ?> subscribers</div>
        </div>
        <div class="card-body">
            <?php if($subscriptions->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Plan</th>
                                <th>Status</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Amount</th>
                                <th>Actions</th>
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
                                                <i class="ti ti-check ti-xs"></i> Verified
                                            </small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($subscription->user && $subscription->user->roles && $subscription->user->roles->count() > 0): ?>
                                            <?php $__currentLoopData = $subscription->user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <span class="badge bg-label-primary mb-1"><?php echo e($role->name); ?></span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            <span class="badge bg-label-secondary">No Role</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($subscription->plan): ?>
                                            <div class="fw-medium"><?php echo e($subscription->plan->name); ?></div>
                                            <small class="text-muted">
                                                <?php echo e($subscription->plan->duration_days); ?> days
                                            </small>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($subscription->status === 'active'): ?>
                                            <span class="badge bg-success">
                                                <i class="ti ti-check ti-xs"></i> Active
                                            </span>
                                        <?php elseif($subscription->status === 'pending'): ?>
                                            <span class="badge bg-warning">
                                                <i class="ti ti-clock ti-xs"></i> Pending
                                            </span>
                                        <?php elseif($subscription->status === 'expired'): ?>
                                            <span class="badge bg-danger">
                                                <i class="ti ti-x ti-xs"></i> Expired
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
                                            <br><small class="text-danger"><i class="ti ti-alert-circle ti-xs"></i> Expired</small>
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
                                                        <span>View User</span>
                                                    </a>
                                                <?php endif; ?>
                                                <a class="dropdown-item" href="<?php echo e(route('admin.manual-subscriptions.show', $subscription->id)); ?>">
                                                    <i class="ti ti-eye me-2"></i>
                                                    <span>View Subscription</span>
                                                </a>
                                                <?php if($subscription->status === 'active'): ?>
                                                    <a class="dropdown-item" href="<?php echo e(route('admin.manual-subscriptions.extend', $subscription->id)); ?>">
                                                        <i class="ti ti-calendar-plus me-2"></i>
                                                        <span>Extend</span>
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
                    <h5 class="text-muted">No subscribers found</h5>
                    <p class="text-muted">
                        <?php if(request()->hasAny(['search', 'role', 'subscription_plan', 'date_from', 'date_to'])): ?>
                            Try adjusting your filters to find what you're looking for.
                        <?php else: ?>
                            There are no active subscribers yet.
                        <?php endif; ?>
                    </p>
                    <?php if(request()->hasAny(['search', 'role', 'subscription_plan', 'date_from', 'date_to'])): ?>
                        <a href="<?php echo e(route('admin.active-subscribers.index')); ?>" class="btn btn-primary mt-2">
                            <i class="ti ti-refresh me-1"></i> Clear Filters
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views/admin/subscribers/index.blade.php ENDPATH**/ ?>