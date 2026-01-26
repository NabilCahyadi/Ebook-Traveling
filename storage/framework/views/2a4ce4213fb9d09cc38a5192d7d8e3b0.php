<?php $__env->startSection('title', __('admin.faqs.title') . ' - ' . $categoryName); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">

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
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <div>
                <h4 class="fw-bold py-3 mb-2">
                    <span class="text-muted fw-light"><?php echo e(__('admin.menu.website_setting')); ?> / <?php echo e(__('admin.menu.faqs')); ?> /</span> <?php echo e($categoryName); ?>

                </h4>
            </div>
            <div>
                <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission("website.faqs-{$categorySlug}.create")): ?>
                <a href="<?php echo e(route("admin.faqs.{$categorySlug}.create")); ?>" class="btn btn-primary">
                    <i class="ti ti-plus me-1"></i> <?php echo e(__('admin.faqs.add_faq')); ?>

                </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="<?php echo e(route("admin.faqs.{$categorySlug}.index")); ?>" method="GET">
                    <div class="row g-3">
                        <div class="col-12 col-md-8">
                            <label for="search" class="form-label"><?php echo e(__('admin.common.search')); ?></label>
                            <input type="text" class="form-control" id="search" name="search"
                                value="<?php echo e(request('search')); ?>" placeholder="<?php echo e(__('admin.faqs.search_placeholder')); ?>">
                        </div>
                        <div class="col-6 col-md-2">
                            <label for="per_page" class="form-label"><?php echo e(__('admin.common.per_page')); ?></label>
                            <select class="form-select" id="per_page" name="per_page">
                                <option value="10" <?php echo e(request('per_page') == 10 ? 'selected' : ''); ?>>10</option>
                                <option value="25" <?php echo e(request('per_page') == 25 ? 'selected' : ''); ?>>25</option>
                                <option value="50" <?php echo e(request('per_page') == 50 ? 'selected' : ''); ?>>50</option>
                                <option value="100" <?php echo e(request('per_page') == 100 ? 'selected' : ''); ?>>100</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-2 d-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <i class="ti ti-search"></i> <span class="d-none d-sm-inline"><?php echo e(__('admin.common.search')); ?></span>
                            </button>
                            <?php if(request()->hasAny(['search'])): ?>
                                <a href="<?php echo e(route("admin.faqs.{$categorySlug}.index")); ?>" class="btn btn-label-secondary"
                                    title="<?php echo e(__('admin.common.clear_filters')); ?>">
                                    <i class="ti ti-x"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- FAQs Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><?php echo e($categoryName); ?> FAQs</h5>
                <div class="text-muted">Total: <?php echo e($faqs->total()); ?> FAQs</div>
            </div>
            <div class="card-body">
                <?php if($faqs->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover" id="faqsTable">
                            <thead>
                                <tr>
                                    <th width="80"><?php echo e(__('admin.faqs.order')); ?></th>
                                    <th><?php echo e(__('admin.faqs.question')); ?></th>
                                    <th class="d-none d-md-table-cell"><?php echo e(__('admin.faqs.answer')); ?></th>
                                    <th width="100"><?php echo e(__('admin.form.status')); ?></th>
                                    <th width="120" class="d-none d-lg-table-cell"><?php echo e(__('admin.common.date_created')); ?></th>
                                    <th width="80" class="text-center"><?php echo e(__('admin.common.actions')); ?></th>
                                </tr>
                            </thead>
                            <tbody id="sortableFaqs">
                                <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr data-id="<?php echo e($faq->id); ?>" style="cursor: move;">
                                        <td>
                                            <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission("website.faqs-{$categorySlug}.edit")): ?>
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="ti ti-grip-vertical text-muted drag-handle" style="cursor: grab; font-size: 1.2rem;" title="Drag to reorder"></i>
                                                <span class="badge bg-label-secondary"><?php echo e($faq->order_index); ?></span>
                                            </div>
                                            <?php else: ?>
                                            <span class="badge bg-label-secondary"><?php echo e($faq->order_index); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div style="max-width: 300px;">
                                                <strong><?php echo e(Str::limit($faq->question, 80)); ?></strong>
                                            </div>
                                        </td>
                                        <td class="d-none d-md-table-cell">
                                            <div style="max-width: 400px;">
                                                <?php echo e(Str::limit($faq->answer, 80)); ?>

                                            </div>
                                        </td>
                                        <td>
                                            <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission("website.faqs-{$categorySlug}.edit")): ?>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input status-toggle" type="checkbox" 
                                                    data-id="<?php echo e($faq->id); ?>" 
                                                    <?php echo e($faq->is_active ? 'checked' : ''); ?>>
                                            </div>
                                            <?php else: ?>
                                            <span class="badge <?php echo e($faq->is_active ? 'bg-success' : 'bg-secondary'); ?>">
                                                <?php echo e($faq->is_active ? __('admin.common.active') : __('admin.common.inactive')); ?>

                                            </span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="d-none d-lg-table-cell">
                                            <small class="text-muted"><?php echo e($faq->created_at->format('d M Y')); ?></small>
                                        </td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow" 
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical ti-md"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission("website.faqs-{$categorySlug}.edit")): ?>
                                                    <a href="<?php echo e(route("admin.faqs.{$categorySlug}.edit", $faq->id)); ?>" class="dropdown-item">
                                                        <i class="ti ti-edit me-2"></i>
                                                        <?php echo e(__('admin.common.edit')); ?>

                                                    </a>
                                                    <?php endif; ?>
                                                    
                                                    <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission("website.faqs-{$categorySlug}.delete")): ?>
                                                    <button type="button" class="dropdown-item text-danger delete-faq" data-id="<?php echo e($faq->id); ?>">
                                                        <i class="ti ti-trash me-2"></i>
                                                        <?php echo e(__('admin.common.delete')); ?>

                                                    </button>
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
                        <?php echo e($faqs->appends(request()->query())->links()); ?>

                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="ti ti-help-circle ti-xl text-muted mb-3 d-block" style="font-size: 4rem;"></i>
                        <h5 class="text-muted"><?php echo e(__('admin.faqs.no_faqs')); ?></h5>
                        <p class="text-muted">
                            <?php if(request()->has('search')): ?>
                                <?php echo e(__('admin.faqs.no_match')); ?>

                            <?php else: ?>
                                <?php echo e(__('admin.faqs.start_creating')); ?>

                            <?php endif; ?>
                        </p>
                        <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission("website.faqs-{$categorySlug}.create")): ?>
                        <a href="<?php echo e(route("admin.faqs.{$categorySlug}.create")); ?>" class="btn btn-primary mt-2">
                            <i class="ti ti-plus me-1"></i> <?php echo e(__('admin.faqs.add_first_faq')); ?>

                        </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <!-- SortableJS for drag & drop -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    
    <script>
        $(document).ready(function() {
            const categorySlug = '<?php echo e($categorySlug); ?>';
            
            // Initialize SortableJS for drag-drop reordering
            <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission("website.faqs-{$categorySlug}.edit")): ?>
            const sortable = new Sortable(document.getElementById('sortableFaqs'), {
                handle: '.drag-handle',
                animation: 150,
                onEnd: function(evt) {
                    let orders = [];
                    $('#sortableFaqs tr').each(function(index) {
                        orders.push({
                            id: $(this).data('id'),
                            order_index: index + 1
                        });
                    });

                    // Send AJAX request to update order
                    $.ajax({
                        url: `/admin/faqs/${categorySlug}/update-order`,
                        method: 'POST',
                        data: {
                            _token: '<?php echo e(csrf_token()); ?>',
                            orders: orders
                        },
                        success: function(response) {
                            if (response.success) {
                                // Update order badges
                                $('#sortableFaqs tr').each(function(index) {
                                    $(this).find('.badge.bg-label-secondary').text(index + 1);
                                });
                                
                                // Show success message
                                showToast('success', response.message);
                            }
                        },
                        error: function(xhr) {
                            showToast('error', 'Failed to update order');
                        }
                    });
                }
            });
            <?php endif; ?>

            // Toggle Status
            $('.status-toggle').on('change', function() {
                const faqId = $(this).data('id');
                const isChecked = $(this).is(':checked');

                $.ajax({
                    url: `/admin/faqs/${categorySlug}/${faqId}/toggle-status`,
                    method: 'POST',
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>'
                    },
                    success: function(response) {
                        if (response.success) {
                            showToast('success', response.message);
                        }
                    },
                    error: function(xhr) {
                        // Revert checkbox on error
                        $(this).prop('checked', !isChecked);
                        showToast('error', 'Failed to update status');
                    }
                });
            });

            // Delete FAQ
            $('.delete-faq').on('click', function() {
                const faqId = $(this).data('id');
                const row = $(this).closest('tr');

                if (confirm('Are you sure you want to delete this FAQ?')) {
                    $.ajax({
                        url: `/admin/faqs/${categorySlug}/${faqId}`,
                        method: 'DELETE',
                        data: {
                            _token: '<?php echo e(csrf_token()); ?>'
                        },
                        success: function(response) {
                            if (response.success) {
                                row.fadeOut(300, function() {
                                    $(this).remove();
                                    // Update total count
                                    location.reload();
                                });
                                showToast('success', response.message);
                            }
                        },
                        error: function(xhr) {
                            showToast('error', 'Failed to delete FAQ');
                        }
                    });
                }
            });

            // Helper function to show toast messages
            function showToast(type, message) {
                const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
                const alertHtml = `
                    <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                        <strong>${type === 'success' ? 'Success!' : 'Error!'}</strong> ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
                $('.container-xxl').prepend(alertHtml);
                
                // Auto dismiss after 3 seconds
                setTimeout(function() {
                    $('.alert').fadeOut(300, function() {
                        $(this).remove();
                    });
                }, 3000);
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\admin\faqs\index.blade.php ENDPATH**/ ?>