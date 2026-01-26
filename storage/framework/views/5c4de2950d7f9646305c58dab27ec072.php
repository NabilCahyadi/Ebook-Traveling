<?php $__env->startSection('title', __('admin.promos.title')); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <div>
                <h4 class="mb-1"><?php echo e(__('admin.promos.title')); ?></h4>
                <p class="text-muted mb-0"><?php echo e(__('admin.promos.description')); ?></p>
            </div>
            <a href="<?php echo e(route('admin.promos.create')); ?>" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i> <?php echo e(__('admin.promos.create_promo')); ?>

            </a>
        </div>

        <!-- Alert Messages -->
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="ti ti-check"></i> <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="ti ti-x"></i> <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Promo List Card -->
        <div class="card">
            <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
                <h5 class="mb-0"><?php echo e(__('admin.promos.all_promos')); ?></h5>
                <span class="badge bg-label-primary"><?php echo e(__('admin.common.total')); ?>: <?php echo e($promos->total()); ?></span>
            </div>
            <div class="card-datatable table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo e(__('admin.form.name')); ?></th>
                            <th><?php echo e(__('admin.promos.code')); ?></th>
                            <th class="d-none d-md-table-cell"><?php echo e(__('admin.promos.type')); ?></th>
                            <th class="d-none d-md-table-cell"><?php echo e(__('admin.promos.value')); ?></th>
                            <th class="d-none d-lg-table-cell"><?php echo e(__('admin.promos.date_range')); ?></th>
                            <th class="d-none d-lg-table-cell"><?php echo e(__('admin.promos.usage')); ?></th>
                            <th><?php echo e(__('admin.form.status')); ?></th>
                            <th><?php echo e(__('admin.common.actions')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $promos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $promo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($promos->firstItem() + $index); ?></td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-medium"><?php echo e($promo->name); ?></span>
                                        <?php if($promo->description): ?>
                                            <small class="text-muted"><?php echo e(Str::limit($promo->description, 50)); ?></small>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <?php if($promo->code): ?>
                                        <span class="badge bg-label-secondary"><?php echo e($promo->code); ?></span>
                                    <?php else: ?>
                                        <span class="text-muted"><?php echo e(__('admin.promos.auto_apply')); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="d-none d-md-table-cell">
                                    <?php if($promo->type === 'percentage'): ?>
                                        <span class="badge bg-label-info"><i class="ti ti-percentage"></i> <?php echo e(__('admin.promos.percentage')); ?></span>
                                    <?php elseif($promo->type === 'fixed_amount'): ?>
                                        <span class="badge bg-label-success"><i class="ti ti-currency-dollar"></i>
                                            <?php echo e(__('admin.promos.fixed')); ?></span>
                                    <?php elseif($promo->type === 'free_trial'): ?>
                                        <span class="badge bg-label-warning"><i class="ti ti-gift"></i> <?php echo e(__('admin.promos.free_trial')); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="d-none d-md-table-cell">
                                    <span class="fw-medium">
                                        <?php if($promo->type === 'percentage'): ?>
                                            <?php echo e($promo->value); ?>%
                                        <?php elseif($promo->type === 'fixed_amount'): ?>
                                            $<?php echo e(number_format($promo->value, 2)); ?>

                                        <?php else: ?>
                                            <?php echo e($promo->value); ?> <?php echo e(__('admin.promos.days')); ?>

                                        <?php endif; ?>
                                    </span>
                                </td>
                                <td class="d-none d-lg-table-cell">
                                    <small class="text-muted">
                                        <div><i class="ti ti-calendar-event"></i>
                                            <?php echo e($promo->start_date->format('M d, Y')); ?></div>
                                        <div><i class="ti ti-calendar-x"></i> <?php echo e($promo->end_date->format('M d, Y')); ?>

                                        </div>
                                    </small>
                                </td>
                                <td class="d-none d-lg-table-cell">
                                    <div class="d-flex flex-column">
                                        <small class="text-muted mb-1"><?php echo e($promo->current_usage); ?> /
                                            <?php echo e($promo->max_usage ?? '∞'); ?></small>
                                        <div class="progress" style="height: 6px;">
                                            <?php
                                                $percentage = $promo->max_usage
                                                    ? min(100, ($promo->current_usage / $promo->max_usage) * 100)
                                                    : 0;
                                            ?>
                                            <div class="progress-bar <?php echo e($percentage >= 100 ? 'bg-danger' : 'bg-primary'); ?>"
                                                role="progressbar" style="width: <?php echo e($percentage); ?>%"
                                                aria-valuenow="<?php echo e($percentage); ?>" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input toggle-status" type="checkbox"
                                            id="status-<?php echo e($promo->id); ?>" data-id="<?php echo e($promo->id); ?>"
                                            <?php echo e($promo->is_active ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="status-<?php echo e($promo->id); ?>"></label>
                                    </div>
                                    <?php if($promo->is_active): ?>
                                        <span class="badge bg-label-success"><?php echo e(__('admin.status.active')); ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-label-secondary"><?php echo e(__('admin.status.inactive')); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="<?php echo e(route('admin.promos.edit', $promo->id)); ?>"
                                            class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light"
                                            data-bs-toggle="tooltip" title="Edit">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <button type="button"
                                            class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light"
                                            onclick="deletePromo('<?php echo e($promo->id); ?>', '<?php echo e($promo->name); ?>')"
                                            data-bs-toggle="tooltip" title="Delete">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Hidden delete form -->
                                    <form id="delete-form-<?php echo e($promo->id); ?>"
                                        action="<?php echo e(route('admin.promos.destroy', $promo->id)); ?>" method="POST"
                                        class="d-none">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <div class="mb-4">
                                        <i class="ti ti-ticket-off" style="font-size: 4rem; color: var(--bs-gray-400);"></i>
                                    </div>
                                    <h5 class="text-muted mb-2"><?php echo e(__('admin.promos.no_promos')); ?></h5>
                                    <p class="text-muted mb-3"><?php echo e(__('admin.promos.create_first_promo')); ?></p>
                                    <a href="<?php echo e(route('admin.promos.create')); ?>" class="btn btn-primary">
                                        <i class="ti ti-plus me-1"></i> <?php echo e(__('admin.promos.create_promo')); ?>

                                    </a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if($promos->hasPages()): ?>
                <div class="card-footer d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                    <div class="text-muted">
                        <?php echo e(__('admin.common.showing_results', ['from' => $promos->firstItem(), 'to' => $promos->lastItem(), 'total' => $promos->total()])); ?>

                    </div>
                    <div>
                        <?php echo e($promos->links()); ?>

                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
        <script>
            // Toggle Status AJAX
            $(document).on('change', '.toggle-status', function() {
                const checkbox = $(this);
                const promoId = checkbox.data('id');
                const isActive = checkbox.is(':checked');
                const badge = checkbox.closest('td').find('.badge');

                $.ajax({
                    url: `/admin/promos/${promoId}/toggle-active`,
                    method: 'POST',
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>'
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update badge
                            if (response.is_active) {
                                badge.removeClass('bg-label-secondary').addClass('bg-label-success').text(
                                    'Active');
                            } else {
                                badge.removeClass('bg-label-success').addClass('bg-label-secondary').text(
                                    '<?php echo e(__('admin.status.inactive')); ?>');
                            }

                            // Show toast notification
                            toastr.success(response.message);
                        }
                    },
                    error: function(xhr) {
                        // Revert checkbox
                        checkbox.prop('checked', !isActive);
                        toastr.error('<?php echo e(__('admin.messages.update_failed')); ?>');
                    }
                });
            });

            // Delete Promo
            function deletePromo(id, name) {
                Swal.fire({
                    title: '<?php echo e(__('admin.messages.are_you_sure')); ?>',
                    html: `<?php echo e(__('admin.promos.delete_confirm')); ?> "<strong>${name}</strong>".<br><?php echo e(__('admin.messages.cannot_undo')); ?>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '<?php echo e(__('admin.messages.yes_delete')); ?>',
                    cancelButtonText: '<?php echo e(__('admin.actions.cancel')); ?>',
                    customClass: {
                        confirmButton: 'btn btn-danger me-2',
                        cancelButton: 'btn btn-secondary'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form-' + id).submit();
                    }
                });
            }

            // Initialize tooltips
            document.addEventListener('DOMContentLoaded', function() {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            });
        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\admin\promos\index.blade.php ENDPATH**/ ?>