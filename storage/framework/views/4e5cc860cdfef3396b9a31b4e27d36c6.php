

<?php $__env->startSection('title', 'FAQ Pricing Management'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">

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
                    <span class="text-muted fw-light">Web Setting / FAQ /</span> Pricing
                </h4>
            </div>
            <div>
                <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission('website.faqs-pricing.create')): ?>
                <a href="<?php echo e(route('admin.faqs.pricing.create')); ?>" class="btn btn-primary">
                    <i class="ti ti-plus me-1"></i> Add New FAQ
                </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="<?php echo e(route('admin.faqs.pricing.index')); ?>" method="GET">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label for="search" class="form-label">Search</label>
                            <input type="text" class="form-control" id="search" name="search"
                                value="<?php echo e(request('search')); ?>" placeholder="Search by question or answer...">
                        </div>
                        <div class="col-md-2">
                            <label for="per_page" class="form-label">Per Page</label>
                            <select class="form-select" id="per_page" name="per_page">
                                <option value="10" <?php echo e(request('per_page') == 10 ? 'selected' : ''); ?>>10</option>
                                <option value="25" <?php echo e(request('per_page') == 25 ? 'selected' : ''); ?>>25</option>
                                <option value="50" <?php echo e(request('per_page') == 50 ? 'selected' : ''); ?>>50</option>
                                <option value="100" <?php echo e(request('per_page') == 100 ? 'selected' : ''); ?>>100</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <i class="ti ti-search"></i> Search
                            </button>
                            <?php if(request()->hasAny(['search'])): ?>
                                <a href="<?php echo e(route('admin.faqs.pricing.index')); ?>" class="btn btn-label-secondary"
                                    title="Clear Filters">
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
                <h5 class="mb-0">Pricing FAQs</h5>
                <div class="text-muted">Total: <?php echo e($faqs->total()); ?> FAQs</div>
            </div>
            <div class="card-body">
                <?php if($faqs->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover" id="faqsTable">
                            <thead>
                                <tr>
                                    <th width="80">
                                         Order
                                    </th>
                                    <th>Question</th>
                                    <th>Answer</th>
                                    <th width="100">Status</th>
                                    <th width="120">Created</th>
                                    <th width="80" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="sortableFaqs">
                                <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr data-id="<?php echo e($faq->id); ?>" style="cursor: move;">
                                        <td>
                                            <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission('website.faqs-pricing.edit')): ?>
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
                                        <td>
                                            <div style="max-width: 400px;">
                                                <?php echo e(Str::limit($faq->answer, 80)); ?>

                                            </div>
                                        </td>
                                        <td>
                                            <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission('website.faqs-pricing.edit')): ?>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input status-toggle" type="checkbox" 
                                                    data-id="<?php echo e($faq->id); ?>" 
                                                    <?php echo e($faq->is_active ? 'checked' : ''); ?>>
                                            </div>
                                            <?php else: ?>
                                            <span class="badge <?php echo e($faq->is_active ? 'bg-success' : 'bg-secondary'); ?>">
                                                <?php echo e($faq->is_active ? 'Active' : 'Inactive'); ?>

                                            </span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <small class="text-muted"><?php echo e($faq->created_at->format('d M Y')); ?></small>
                                        </td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow" 
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical ti-md"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission('website.faqs-pricing.edit')): ?>
                                                    <a href="<?php echo e(route('admin.faqs.pricing.edit', $faq->id)); ?>" class="dropdown-item">
                                                        <i class="ti ti-edit me-2"></i>
                                                        Edit
                                                    </a>
                                                    <?php endif; ?>
                                                    
                                                    <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission('website.faqs-pricing.delete')): ?>
                                                    <button type="button" class="dropdown-item text-danger delete-faq" data-id="<?php echo e($faq->id); ?>">
                                                        <i class="ti ti-trash me-2"></i>
                                                        Delete
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
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            Showing <?php echo e($faqs->firstItem()); ?> to <?php echo e($faqs->lastItem()); ?> of <?php echo e($faqs->total()); ?> entries
                        </div>
                        <div>
                            <?php echo e($faqs->links()); ?>

                        </div>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="ti ti-help-circle" style="font-size: 4rem; color: #ddd;"></i>
                        <p class="text-muted mt-3">No FAQs found.</p>
                        <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission('website.faqs-pricing.create')): ?>
                        <a href="<?php echo e(route('admin.faqs.pricing.create')); ?>" class="btn btn-primary">
                            <i class="ti ti-plus me-1"></i> Add Your First FAQ
                        </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        $(document).ready(function() {
            // Toggle Status
            $('.status-toggle').on('change', function() {
                const faqId = $(this).data('id');
                const isChecked = $(this).prop('checked');

                $.ajax({
                    url: `/admin/faqs/pricing/${faqId}/toggle-status`,
                    type: 'POST',
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>'
                    },
                    success: function(response) {
                        if (response.success) {
                            // Optional: Show success message
                        }
                    },
                    error: function(xhr) {
                        alert('Error updating status. Please try again.');
                        // Revert checkbox
                        $(this).prop('checked', !isChecked);
                    }
                });
            });

            // Delete Single FAQ
            $('.delete-faq').on('click', function() {
                const faqId = $(this).data('id');
                
                if (confirm('Are you sure you want to delete this FAQ?')) {
                    $.ajax({
                        url: `/admin/faqs/pricing/${faqId}`,
                        type: 'DELETE',
                        data: {
                            _token: '<?php echo e(csrf_token()); ?>'
                        },
                        success: function(response) {
                            if (response.success) {
                                location.reload();
                            }
                        },
                        error: function(xhr) {
                            alert('Error deleting FAQ. Please try again.');
                        }
                    });
                }
            });

            // Sortable - Drag and Drop Reordering
            <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission('website.faqs-pricing.edit')): ?>
            const el = document.getElementById('sortableFaqs');
            if (el) {
                const sortable = Sortable.create(el, {
                    handle: '.drag-handle',
                    animation: 150,
                    ghostClass: 'sortable-ghost',
                    dragClass: 'sortable-drag',
                    onStart: function(evt) {
                        evt.item.style.opacity = '0.5';
                    },
                    onEnd: function(evt) {
                        evt.item.style.opacity = '1';
                        
                        const orders = [];
                        $('#sortableFaqs tr').each(function(index) {
                            orders.push({
                                id: $(this).data('id'),
                                order_index: index + 1
                            });
                        });

                        $.ajax({
                            url: '<?php echo e(route("admin.faqs.pricing.update-order")); ?>',
                            type: 'POST',
                            data: {
                                _token: '<?php echo e(csrf_token()); ?>',
                                orders: orders
                            },
                            success: function(response) {
                                if (response.success) {
                                    // Update order badges
                                    $('#sortableFaqs tr').each(function(index) {
                                        $(this).find('.badge').text(index + 1);
                                    });
                                    
                                    // Optional: Show success toast
                                    console.log('Order updated successfully!');
                                }
                            },
                            error: function(xhr) {
                                alert('Error updating order. Please refresh the page.');
                                location.reload();
                            }
                        });
                    }
                });
            }
            <?php endif; ?>
        });
    </script>
    
    <style>
        .sortable-ghost {
            opacity: 0.4;
            background-color: #f5f5f5;
        }
        
        .sortable-drag {
            opacity: 1;
            background-color: #fff;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .drag-handle:hover {
            color: #696cff !important;
        }
        
        .drag-handle:active {
            cursor: grabbing !important;
        }
    </style>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views/admin/faqs/pricing/index.blade.php ENDPATH**/ ?>