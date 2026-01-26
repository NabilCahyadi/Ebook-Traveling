<?php $__env->startSection('title', __('admin.subscription_history.title')); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light"><?php echo e(__('admin.menu.subscription_management')); ?> /</span> <?php echo e(__('admin.subscription_history.title')); ?>

            </h4>
            <div>
                <a href="<?php echo e(route('admin.subscription-history.export', request()->all())); ?>" class="btn btn-success">
                    <i class="ti ti-download me-1"></i> <?php echo e(__('admin.actions.export')); ?>

                </a>
            </div>
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

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="ti ti-receipt-2 ti-sm"></i>
                                </span>
                            </div>
                            <div>
                                <small class="text-muted d-block"><?php echo e(__('admin.subscription_history.total_payments')); ?></small>
                                <h5 class="mb-0"><?php echo e(number_format($stats['total'])); ?></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-info">
                                    <i class="ti ti-hand-click ti-sm"></i>
                                </span>
                            </div>
                            <div>
                                <small class="text-muted d-block"><?php echo e(__('admin.subscription_history.manual')); ?></small>
                                <h5 class="mb-0"><?php echo e(number_format($stats['manual'])); ?></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-warning">
                                    <i class="ti ti-credit-card ti-sm"></i>
                                </span>
                            </div>
                            <div>
                                <small class="text-muted d-block"><?php echo e(__('admin.subscription_history.payment_gateway')); ?></small>
                                <h5 class="mb-0"><?php echo e(number_format($stats['payment_gateway'])); ?></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-success">
                                    <i class="ti ti-currency-dollar ti-sm"></i>
                                </span>
                            </div>
                            <div>
                                <small class="text-muted d-block"><?php echo e(__('admin.subscription_history.total_revenue')); ?></small>
                                <h5 class="mb-0">Rp <?php echo e(number_format($stats['total_revenue'], 0, ',', '.')); ?></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters & Search -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="<?php echo e(route('admin.subscription-history.index')); ?>">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label"><?php echo e(__('admin.common.search')); ?></label>
                            <input type="text" class="form-control" name="search" placeholder="<?php echo e(__('admin.subscription_history.search_placeholder')); ?>"
                                value="<?php echo e(request('search')); ?>">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label"><?php echo e(__('admin.subscription_history.type')); ?></label>
                            <select class="form-select" name="type">
                                <option value=""><?php echo e(__('admin.subscription_history.all_types')); ?></option>
                                <option value="manual" <?php echo e(request('type') === 'manual' ? 'selected' : ''); ?>>Manual
                                </option>
                                <option value="payment_gateway"
                                    <?php echo e(request('type') === 'payment_gateway' ? 'selected' : ''); ?>>Payment Gateway</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label"><?php echo e(__('admin.subscription_history.status')); ?></label>
                            <select class="form-select" name="status">
                                <option value=""><?php echo e(__('admin.subscription_history.all_status')); ?></option>
                                <option value="paid" <?php echo e(request('status') === 'paid' ? 'selected' : ''); ?>><?php echo e(__('admin.receipt.paid')); ?></option>
                                <option value="pending" <?php echo e(request('status') === 'pending' ? 'selected' : ''); ?>><?php echo e(__('admin.status.pending')); ?>

                                </option>
                                <option value="failed" <?php echo e(request('status') === 'failed' ? 'selected' : ''); ?>><?php echo e(__('admin.subscription_history.failed')); ?>

                                </option>
                                <option value="expired" <?php echo e(request('status') === 'expired' ? 'selected' : ''); ?>><?php echo e(__('admin.status.expired')); ?>

                                </option>
                                <option value="cancelled" <?php echo e(request('status') === 'cancelled' ? 'selected' : ''); ?>>
                                    <?php echo e(__('admin.status.cancelled')); ?></option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label"><?php echo e(__('admin.subscription_history.start_date')); ?></label>
                            <input type="date" class="form-control" name="start_date"
                                value="<?php echo e(request('start_date')); ?>">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label"><?php echo e(__('admin.subscription_history.end_date')); ?></label>
                            <input type="date" class="form-control" name="end_date"
                                value="<?php echo e(request('end_date')); ?>">
                        </div>

                            <!-- <div class="col-md-2">
                                <label class="form-label"><?php echo e(__('admin.common.per_page')); ?></label>
                                <select class="form-select" name="per_page">
                                    <option value="15" <?php echo e(request('per_page', 15) == 15 ? 'selected' : ''); ?>>15</option>
                                    <option value="30" <?php echo e(request('per_page') == 30 ? 'selected' : ''); ?>>30</option>
                                    <option value="45" <?php echo e(request('per_page') == 45 ? 'selected' : ''); ?>>45</option>
                                    <option value="60" <?php echo e(request('per_page') == 60 ? 'selected' : ''); ?>>60</option>
                                </select>
                            </div> -->

                        <div class="col-md-1 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="ti ti-filter"></i>
                            </button>
                        </div>

                        <?php if(request()->hasAny(['search', 'type', 'status', 'start_date', 'end_date', 'per_page'])): ?>
                            <div class="col-md-12">
                                <a href="<?php echo e(route('admin.subscription-history.index')); ?>"
                                    class="btn btn-outline-secondary btn-sm">
                                    <i class="ti ti-x me-1"></i> <?php echo e(__('admin.actions.clear_filters')); ?>

                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <!-- Payment History Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><?php echo e(__('admin.subscription_history.payment_history')); ?></h5>
                <div class="d-flex align-items-center gap-2">
                    <label class="text-muted small mb-0"><?php echo e(__('admin.common.per_page')); ?>:</label>
                    <select class="form-select form-select-sm" style="width: auto;" onchange="window.location.href=this.value">
                        <?php $__currentLoopData = [15, 30, 45, 60]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $perPageOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e(request()->fullUrlWithQuery(['per_page' => $perPageOption, 'page' => 1])); ?>" 
                                <?php echo e(request('per_page', 15) == $perPageOption ? 'selected' : ''); ?>>
                                <?php echo e($perPageOption); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th><?php echo e(__('admin.subscription_history.user')); ?></th>
                            <th><?php echo e(__('admin.subscription_history.plan')); ?></th>
                            <th><?php echo e(__('admin.subscription_history.type')); ?></th>
                            <th><?php echo e(__('admin.subscription_history.period')); ?></th>
                            <th><?php echo e(__('admin.subscription_history.status')); ?></th>
                            <th><?php echo e(__('admin.subscription_history.amount')); ?></th>
                            <th><?php echo e(__('admin.actions.actions')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $subscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-semibold"><?php echo e($subscription->user->name); ?></span>
                                        <small class="text-muted"><?php echo e($subscription->user->email); ?></small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-label-info"><?php echo e($subscription->plan->name); ?></span>
                                </td>
                                <td>
                                    <?php if($subscription->payment_id): ?>
                                        <span class="badge bg-label-warning">
                                            <i class="ti ti-credit-card me-1"></i> <?php echo e(__('admin.subscription_history.payment_gateway')); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-label-secondary">
                                            <i class="ti ti-hand-click me-1"></i> <?php echo e(__('admin.subscription_history.manual')); ?>

                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <small class="text-muted"><?php echo e(__('admin.subscription_history.start')); ?>:</small>
                                        <small
                                            class="fw-semibold"><?php echo e($subscription->start_date->format('d M Y')); ?></small>
                                        <small class="text-muted mt-1">End:</small>
                                        <small class="fw-semibold"><?php echo e($subscription->end_date->format('d M Y')); ?></small>
                                    </div>
                                </td>
                                <td>
                                    <?php if($subscription->status === 'active'): ?>
                                        <?php if($subscription->end_date->isFuture()): ?>
                                            <span class="badge bg-success">Paid</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning">Expired</span>
                                        <?php endif; ?>
                                    <?php elseif($subscription->status === 'cancelled'): ?>
                                        <span class="badge bg-danger">Cancelled</span>
                                    <?php elseif($subscription->status === 'pending'): ?>
                                        <span class="badge bg-info">Pending</span>
                                    <?php elseif($subscription->status === 'failed'): ?>
                                        <span class="badge bg-danger">Failed</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary"><?php echo e(ucfirst($subscription->status)); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong>Rp <?php echo e(number_format($subscription->total_amount, 0, ',', '.')); ?></strong>
                                </td>
                                <td>
                                    <?php if($subscription->status === 'active' && $subscription->end_date->isFuture()): ?>
                                        
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill" 
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0);" 
                                                        data-bs-toggle="modal" data-bs-target="#detailModal<?php echo e($subscription->id); ?>">
                                                        <i class="ti ti-eye me-2"></i>
                                                        View Details
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="<?php echo e(route('admin.subscription-history.print', $subscription->id)); ?>" 
                                                        target="_blank">
                                                        <i class="ti ti-printer me-2"></i>
                                                        <?php echo e(__('admin.subscription_history.print_receipt')); ?>

                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    <?php else: ?>
                                        
                                        <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill"
                                            data-bs-toggle="modal" data-bs-target="#detailModal<?php echo e($subscription->id); ?>"
                                            title="View Details">
                                            <i class="ti ti-eye"></i>
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>

                            <!-- Detail Modal -->
                            <div class="modal fade" id="detailModal<?php echo e($subscription->id); ?>" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"><?php echo e(__('admin.subscription_history.payment_detail')); ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <small class="text-muted d-block"><?php echo e(__('admin.manual_subscription.code')); ?></small>
                                                    <p class="mb-0 fw-bold text-primary">
                                                        <?php echo e($subscription->subscription_code); ?></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <small class="text-muted d-block"><?php echo e(__('admin.subscription_history.type')); ?></small>
                                                    <?php if($subscription->payment_id): ?>
                                                        <span class="badge bg-label-warning">
                                                            <i class="ti ti-credit-card me-1"></i> <?php echo e(__('admin.subscription_history.payment_gateway')); ?>

                                                        </span>
                                                    <?php else: ?>
                                                        <span class="badge bg-label-secondary">
                                                            <i class="ti ti-hand-click me-1"></i> <?php echo e(__('admin.subscription_history.manual')); ?>

                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <small class="text-muted d-block"><?php echo e(__('admin.subscription_history.user')); ?></small>
                                                    <p class="mb-0 fw-semibold"><?php echo e($subscription->user->name); ?></p>
                                                    <small class="text-muted"><?php echo e($subscription->user->email); ?></small>
                                                </div>
                                                <div class="col-md-6">
                                                    <small class="text-muted d-block"><?php echo e(__('admin.subscription_history.plan')); ?></small>
                                                    <p class="mb-0 fw-semibold"><?php echo e($subscription->plan->name); ?></p>
                                                    <span class="badge bg-label-info">Rp
                                                        <?php echo e(number_format($subscription->plan->price, 0, ',', '.')); ?> /
                                                        <?php echo e($subscription->plan->duration_in_days); ?> days</span>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <small class="text-muted d-block"><?php echo e(__('admin.subscription_history.start_date')); ?></small>
                                                    <p class="mb-0">
                                                        <?php echo e($subscription->start_date->format('d M Y, H:i')); ?></p>
                                                </div>
                                                <div class="col-md-4">
                                                    <small class="text-muted d-block"><?php echo e(__('admin.subscription_history.end_date')); ?></small>
                                                    <p class="mb-0"><?php echo e($subscription->end_date->format('d M Y, H:i')); ?>

                                                    </p>
                                                </div>
                                                <div class="col-md-4">
                                                    <small class="text-muted d-block"><?php echo e(__('admin.subscription_history.status')); ?></small>
                                                    <div>
                                                        <?php if($subscription->status === 'active'): ?>
                                                            <?php if($subscription->end_date->isFuture()): ?>
                                                                <span class="badge bg-success"><?php echo e(__('admin.receipt.paid')); ?></span>
                                                            <?php else: ?>
                                                                <span class="badge bg-warning"><?php echo e(__('admin.status.expired')); ?></span>
                                                            <?php endif; ?>
                                                        <?php elseif($subscription->status === 'cancelled'): ?>
                                                            <span class="badge bg-danger"><?php echo e(__('admin.status.cancelled')); ?></span>
                                                        <?php elseif($subscription->status === 'pending'): ?>
                                                            <span class="badge bg-info"><?php echo e(__('admin.status.pending')); ?></span>
                                                        <?php elseif($subscription->status === 'failed'): ?>
                                                            <span class="badge bg-danger"><?php echo e(__('admin.subscription_history.failed')); ?></span>
                                                        <?php else: ?>
                                                            <span
                                                                class="badge bg-secondary"><?php echo e(ucfirst($subscription->status)); ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <small class="text-muted d-block"><?php echo e(__('admin.subscription_history.total_amount')); ?></small>
                                                    <h4 class="mb-0 text-success">Rp
                                                        <?php echo e(number_format($subscription->total_amount, 0, ',', '.')); ?></h4>
                                                </div>
                                                <div class="col-md-6">
                                                    <small class="text-muted d-block"><?php echo e(__('admin.subscription_history.auto_renew')); ?></small>
                                                    <p class="mb-0">
                                                        <?php if($subscription->auto_renew): ?>
                                                            <span class="badge bg-label-success"><?php echo e(__('admin.common.yes')); ?></span>
                                                        <?php else: ?>
                                                            <span class="badge bg-label-danger"><?php echo e(__('admin.common.no')); ?></span>
                                                        <?php endif; ?>
                                                    </p>
                                                </div>
                                            </div>

                                            <?php if($subscription->payment): ?>
                                                <hr>
                                                <h6 class="mb-3"><?php echo e(__('admin.subscription_history.payment_information')); ?></h6>
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <small class="text-muted d-block"><?php echo e(__('admin.subscription_history.transaction_id')); ?></small>
                                                        <p class="mb-0 fw-semibold">
                                                            <?php echo e($subscription->payment->transaction_id ?? '-'); ?></p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <small class="text-muted d-block"><?php echo e(__('admin.subscription_history.payment_method')); ?></small>
                                                        <p class="mb-0">
                                                            <?php echo e(ucfirst($subscription->payment->payment_method ?? '-')); ?>

                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <small class="text-muted d-block"><?php echo e(__('admin.subscription_history.payment_status')); ?></small>
                                                        <div>
                                                            <?php if($subscription->payment->status === 'paid'): ?>
                                                                <span class="badge bg-success"><?php echo e(__('admin.receipt.paid')); ?></span>
                                                            <?php elseif($subscription->payment->status === 'pending'): ?>
                                                                <span class="badge bg-warning"><?php echo e(__('admin.status.pending')); ?></span>
                                                            <?php elseif($subscription->payment->status === 'failed'): ?>
                                                                <span class="badge bg-danger"><?php echo e(__('admin.subscription_history.failed')); ?></span>
                                                            <?php else: ?>
                                                                <span
                                                                    class="badge bg-secondary"><?php echo e(ucfirst($subscription->payment->status)); ?></span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <small class="text-muted d-block"><?php echo e(__('admin.subscription_history.paid_at')); ?></small>
                                                        <p class="mb-0">
                                                            <?php echo e($subscription->payment->paid_at ? $subscription->payment->paid_at->format('d M Y, H:i') : '-'); ?>

                                                        </p>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <hr>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <small class="text-muted d-block"><?php echo e(__('admin.common.created_at')); ?></small>
                                                    <p class="mb-0">
                                                        <?php echo e($subscription->created_at->format('d M Y, H:i')); ?></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <small class="text-muted d-block"><?php echo e(__('admin.subscription_history.last_updated')); ?></small>
                                                    <p class="mb-0">
                                                        <?php echo e($subscription->updated_at->format('d M Y, H:i')); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal"><?php echo e(__('admin.actions.close')); ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="ti ti-info-circle mb-2" style="font-size: 3rem;"></i>
                                        <p class="mb-0"><?php echo e(__('admin.subscription_history.no_payment_found')); ?></p>
                                        <?php if(request()->hasAny(['search', 'type', 'status', 'start_date', 'end_date'])): ?>
                                            <small><?php echo e(__('admin.subscription_history.try_adjusting')); ?></small>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="card-footer">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="text-muted small">
                        <?php if($subscriptions->total() > 0): ?>
                            <?php echo e(__('admin.common.showing')); ?> <?php echo e($subscriptions->firstItem()); ?> <?php echo e(__('admin.common.to')); ?> <?php echo e($subscriptions->lastItem()); ?> <?php echo e(__('admin.common.of')); ?>

                            <?php echo e($subscriptions->total()); ?> <?php echo e(__('admin.common.entries')); ?>

                        <?php else: ?>
                            <?php echo e(__('admin.common.no_entries')); ?>

                        <?php endif; ?>
                    </div>
                    <?php if($subscriptions->hasPages()): ?>
                        <div>
                            <?php echo e($subscriptions->withQueryString()->links()); ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views/admin/subscription-history/index.blade.php ENDPATH**/ ?>