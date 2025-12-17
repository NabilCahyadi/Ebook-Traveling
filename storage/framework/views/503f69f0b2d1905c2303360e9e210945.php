<?php $__env->startSection('title', 'Collections Management'); ?>

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
                    <span class="text-muted fw-light">Website Management /</span> Collections
                </h4>
            </div>
            <div>
                <a href="<?php echo e(route('admin.collections.create')); ?>" class="btn btn-primary">
                    <i class="ti ti-plus me-1"></i> Add New Collection
                </a>
            </div>
        </div>

        <!-- Collections Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">All Collections</h5>
                <div>
                    <span class="badge bg-label-primary me-2"><?php echo e($collections->total()); ?> Total</span>
                    <small class="text-muted"><i class="ti ti-grip-vertical"></i> Drag to reorder</small>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="ti ti-info-circle me-2"></i>
                    <strong>Drag & Drop</strong> to reorder collections. Changes will be saved automatically.
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="50">Drag</th>
                                <th>Order</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Ebooks Count</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="sortable-collections">
                            <?php $__empty_1 = true; $__currentLoopData = $collections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $collection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr data-id="<?php echo e($collection->id); ?>" data-order="<?php echo e($collection->order); ?>" style="cursor: move;">
                                    <td class="text-center">
                                        <i class="ti ti-grip-vertical text-muted"></i>
                                    </td>
                                    <td>
                                        <span class="badge bg-label-secondary order-badge"><?php echo e($collection->order); ?></span>
                                    </td>
                                    <td>
                                        <strong><?php echo e($collection->name); ?></strong>
                                        <?php if($collection->description): ?>
                                            <br>
                                            <small class="text-muted"><?php echo e(Str::limit($collection->description, 50)); ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <code><?php echo e($collection->slug); ?></code>
                                    </td>
                                    <td>
                                        <span class="badge bg-label-info">
                                            <?php echo e($collection->ebooks_count ?? 0); ?> ebooks
                                        </span>
                                    </td>
                                    <td>
                                        <?php if($collection->is_active): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="<?php echo e(route('admin.collections.manage-ebooks', $collection->id)); ?>">
                                                    <i class="ti ti-books me-2"></i> Manage Ebooks
                                                </a>
                                                <a class="dropdown-item" href="<?php echo e(route('admin.collections.edit', $collection->id)); ?>">
                                                    <i class="ti ti-edit me-2"></i> Edit
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <form action="<?php echo e(route('admin.collections.destroy', $collection->id)); ?>" 
                                                      method="POST" 
                                                      onsubmit="return confirm('Are you sure you want to delete this collection?');">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="ti ti-trash me-2"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="ti ti-folder-off" style="font-size: 3rem; opacity: 0.3;"></i>
                                            <p class="mt-2 mb-0 text-muted">No collections found</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if($collections->hasPages()): ?>
                    <div class="mt-4">
                        <?php echo e($collections->links()); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .sortable-ghost {
        opacity: 0.4;
        background: #f8f9fa;
    }
    .sortable-drag {
        opacity: 1;
        background: #fff;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    #sortable-collections tr:hover {
        background-color: #f8f9fa;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tbody = document.getElementById('sortable-collections');
        
        if (tbody) {
            const sortable = new Sortable(tbody, {
                animation: 150,
                handle: 'tr',
                ghostClass: 'sortable-ghost',
                dragClass: 'sortable-drag',
                onEnd: function(evt) {
                    updateCollectionOrder();
                }
            });
        }
    });

    function updateCollectionOrder() {
        const rows = document.querySelectorAll('#sortable-collections tr[data-id]');
        const orders = {};
        
        rows.forEach((row, index) => {
            const id = row.dataset.id;
            const newOrder = index;
            orders[id] = newOrder;
            
            // Update order badge display
            const orderBadge = row.querySelector('.order-badge');
            if (orderBadge) {
                orderBadge.textContent = newOrder;
            }
        });

        // Send AJAX request to update order
        fetch('<?php echo e(route("admin.collections.update-order")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({ orders: orders })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Success', 'Collection order updated successfully', 'success');
            } else {
                showToast('Error', data.message || 'Failed to update order', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Error', 'Failed to update order', 'error');
        });
    }

    function showToast(title, message, type) {
        // Simple toast notification
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const alert = document.createElement('div');
        alert.className = `alert ${alertClass} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
        alert.style.zIndex = '9999';
        alert.innerHTML = `
            <strong>${title}!</strong> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(alert);
        
        setTimeout(() => {
            alert.remove();
        }, 3000);
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views/admin/collections/index.blade.php ENDPATH**/ ?>