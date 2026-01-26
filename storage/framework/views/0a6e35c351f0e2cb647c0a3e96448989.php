<?php $__env->startSection('title', 'User Detail - ' . $user->name); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Page Header -->
        <div class="mb-4">
            <h4 class="fw-bold py-3 mb-2">
                <span class="text-muted fw-light"><?php echo e(__('admin.menu.user_management')); ?> / <?php echo e(__('admin.users.title')); ?> /</span> 
                Detail
            </h4>
        </div>

        <!-- User Information Cards -->
        <div class="row">
            <!-- Left Column - Profile Card -->
            <div class="col-lg-4 col-md-5">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <?php if($user->avatar): ?>
                                <img src="<?php echo e(Storage::url($user->avatar)); ?>" alt="Avatar" 
                                    class="rounded-circle" width="120" height="120" style="object-fit: cover;">
                            <?php else: ?>
                                <div class="d-inline-flex align-items-center justify-content-center rounded-circle" 
                                    style="width: 120px; height: 120px; background: linear-gradient(135deg, #e8eaf6 0%, #f5f5f5 100%); border: 3px solid #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                    <span style="font-size: 3rem; font-weight: 600; color: #5a5a5a;">
                                        <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <h4 class="text-center mb-2"><?php echo e($user->name); ?></h4>
                        <p class="text-center text-muted mb-3"><?php echo e($user->email); ?></p>

                        <!-- Status Badge -->
                        <div class="text-center mb-3">
                            <?php if($user->deleted_at): ?>
                                <span class="badge bg-danger">Deleted</span>
                            <?php elseif($user->email_verified_at): ?>
                                <span class="badge bg-success">Verified</span>
                            <?php else: ?>
                                <span class="badge bg-warning">Unverified</span>
                            <?php endif; ?>

                            <?php if($user->google_id): ?>
                                <span class="badge bg-info ms-1">
                                    <i class="ti ti-brand-google"></i> Google
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- User Roles -->
                        <?php if($user->roles && $user->roles->count() > 0): ?>
                        <div class="mb-3">
                            <h6 class="mb-2">Roles:</h6>
                            <?php $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $badgeColors = [
                                        'Creator' => 'bg-label-success',
                                        'Reader' => 'bg-label-info',
                                        'Admin' => 'bg-label-danger',
                                        'Super Admin' => 'bg-label-primary',
                                    ];
                                    $badgeClass = $badgeColors[$role->name] ?? 'bg-label-warning';
                                ?>
                                <span class="badge <?php echo e($badgeClass); ?> me-1"><?php echo e($role->name); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <?php endif; ?>

                        <!-- Quick Actions -->
                        <div class="d-grid gap-2 mt-4">
                            <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission('users.edit')): ?>
                            <a href="<?php echo e(route('admin.users.edit', $user->id)); ?>" class="btn btn-primary">
                                <i class="ti ti-edit me-1"></i> Edit User
                            </a>
                            <?php endif; ?>

                            <?php if(!$user->email_verified_at && (auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission('users.edit'))): ?>
                            <form action="<?php echo e(route('admin.users.verify-email', $user->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="ti ti-check me-1"></i> Verify Email
                                </button>
                            </form>
                            <?php endif; ?>

                            <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-label-secondary">
                                <i class="ti ti-arrow-left me-1"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Details Tab -->
            <div class="col-lg-8 col-md-7">
                <!-- Nav tabs -->
                <ul class="nav nav-pills mb-4" id="userTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" 
                            data-bs-target="#overview" type="button" role="tab">
                            <i class="ti ti-user me-1"></i> Overview
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="account-tab" data-bs-toggle="tab" 
                            data-bs-target="#account" type="button" role="tab">
                            <i class="ti ti-settings me-1"></i> Account Info
                        </button>
                    </li>
                    <?php if($user->subscriptions && $user->subscriptions->count() > 0): ?>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="subscriptions-tab" data-bs-toggle="tab" 
                            data-bs-target="#subscriptions" type="button" role="tab">
                            <i class="ti ti-credit-card me-1"></i> Subscriptions
                        </button>
                    </li>
                    <?php endif; ?>
                </ul>

                <!-- Tab content -->
                <div class="tab-content">
                    <!-- Overview Tab -->
                    <div class="tab-pane fade show active" id="overview" role="tabpanel">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Personal Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong>Full Name:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <?php echo e($user->name); ?>

                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong>Email:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <?php echo e($user->email); ?>

                                        <?php if($user->email_verified_at): ?>
                                            <i class="ti ti-circle-check text-success ms-1" title="Verified"></i>
                                        <?php else: ?>
                                            <i class="ti ti-alert-circle text-warning ms-1" title="Not Verified"></i>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <?php if($user->phone): ?>
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong>Phone:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <?php echo e($user->phone); ?>

                                    </div>
                                </div>
                                <?php endif; ?>

                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong>User Type:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <span class="badge bg-label-info"><?php echo e(ucfirst($user->user_type ?? 'user')); ?></span>
                                    </div>
                                </div>

                                <?php if($user->google_id): ?>
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong>Google ID:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <?php echo e($user->google_id); ?>

                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Statistics Card -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">User Statistics</h5>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-4">
                                        <div class="d-flex flex-column">
                                            <div class="mb-2">
                                                <i class="ti ti-book-2 ti-lg text-primary"></i>
                                            </div>
                                            <h4 class="mb-0"><?php echo e($user->savedBooks->count() ?? 0); ?></h4>
                                            <small class="text-muted">Saved Books</small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="d-flex flex-column">
                                            <div class="mb-2">
                                                <i class="ti ti-book-upload ti-lg text-success"></i>
                                            </div>
                                            <h4 class="mb-0"><?php echo e($user->readings->count() ?? 0); ?></h4>
                                            <small class="text-muted">Reading History</small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="d-flex flex-column">
                                            <div class="mb-2">
                                                <i class="ti ti-credit-card ti-lg text-info"></i>
                                            </div>
                                            <h4 class="mb-0"><?php echo e($user->subscriptions->count() ?? 0); ?></h4>
                                            <small class="text-muted">Subscriptions</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Account Info Tab -->
                    <div class="tab-pane fade" id="account" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="mb-4">Account Details</h5>
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong>User ID:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <code><?php echo e($user->id); ?></code>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong>Registration Date:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <?php echo e($user->created_at->format('d M Y, H:i')); ?>

                                        <small class="text-muted">(<?php echo e($user->created_at->diffForHumans()); ?>)</small>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong>Last Updated:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <?php echo e($user->updated_at->format('d M Y, H:i')); ?>

                                        <small class="text-muted">(<?php echo e($user->updated_at->diffForHumans()); ?>)</small>
                                    </div>
                                </div>

                                <?php if($user->email_verified_at): ?>
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong>Email Verified At:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <?php echo e($user->email_verified_at->format('d M Y, H:i')); ?>

                                    </div>
                                </div>
                                <?php endif; ?>

                                <?php if($user->deleted_at): ?>
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong>Deleted At:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <span class="text-danger">
                                            <?php echo e($user->deleted_at->format('d M Y, H:i')); ?>

                                            (<?php echo e($user->deleted_at->diffForHumans()); ?>)
                                        </span>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Subscriptions Tab -->
                    <?php if($user->subscriptions && $user->subscriptions->count() > 0): ?>
                    <div class="tab-pane fade" id="subscriptions" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Subscription History</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Plan</th>
                                                <th>Status</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $user->subscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td>
                                                    <strong><?php echo e($subscription->subscriptionPlan->name ?? 'N/A'); ?></strong>
                                                </td>
                                                <td>
                                                    <?php if($subscription->status === 'active'): ?>
                                                        <span class="badge bg-success">Active</span>
                                                    <?php elseif($subscription->status === 'expired'): ?>
                                                        <span class="badge bg-danger">Expired</span>
                                                    <?php elseif($subscription->status === 'cancelled'): ?>
                                                        <span class="badge bg-warning">Cancelled</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-secondary"><?php echo e(ucfirst($subscription->status)); ?></span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo e(\Carbon\Carbon::parse($subscription->start_date)->format('d M Y')); ?></td>
                                                <td><?php echo e(\Carbon\Carbon::parse($subscription->end_date)->format('d M Y')); ?></td>
                                                <td>Rp <?php echo e(number_format($subscription->price ?? 0, 0, ',', '.')); ?></td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Auto-hide alerts after 3 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 3000);
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\admin\users\show.blade.php ENDPATH**/ ?>