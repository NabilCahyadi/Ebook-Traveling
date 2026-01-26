<?php $__env->startSection('title', 'Manage Collection Order'); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        .cursor-move {
            cursor: move;
        }

        .sortable-ghost {
            opacity: 0.4;
            background-color: #e3f2fd;
        }

        .sortable-drag {
            opacity: 0.8;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <span class="text-muted fw-light">Website Management /</span> Collection Order
            </h4>
            <p class="mb-0">Atur urutan tampilan collection di landing page untuk user</p>
        </div>
        <button type="button" class="btn btn-primary" id="saveOrder">
            <i class="ti ti-device-floppy me-1"></i> Save Order
        </button>
    </div>

    <!-- Success/Error Messages -->
    <div id="alert-container"></div>

    <!-- Collection List Card -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Collection List</h5>
            <div class="text-muted small">
                <i class="ti ti-arrows-sort me-1"></i> Drag and drop to reorder
            </div>
        </div>
        <div class="card-body">
            <?php if($collections->isEmpty()): ?>
                <div class="text-center py-5">
                    <i class="ti ti-box-off display-4 text-muted"></i>
                    <p class="mt-3 mb-0">No collections available</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th width="50">#</th>
                                <th width="80">Order</th>
                                <th>Collection Name</th>
                                <th width="150">Status</th>
                                <th width="150">Visibility</th>
                                <th width="80" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="sortable-collections">
                            <?php $__currentLoopData = $collections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $collection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr data-id="<?php echo e($collection->id); ?>" data-order="<?php echo e($collection->order); ?>"
                                    class="collection-row">
                                    <td>
                                        <i class="ti ti-grip-vertical cursor-move text-muted"></i>
                                    </td>
                                    <td>
                                        <span class="badge bg-label-secondary order-badge"><?php echo e($collection->order); ?></span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <h6 class="mb-0"><?php echo e($collection->name); ?></h6>
                                                <small class="text-muted"><?php echo e($collection->slug); ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if($collection->is_active): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input visibility-toggle" type="checkbox"
                                                data-id="<?php echo e($collection->id); ?>"
                                                <?php echo e($collection->is_visible_on_landing ? 'checked' : ''); ?>>
                                            <label class="form-check-label">
                                                <span class="visibility-text">
                                                    <?php echo e($collection->is_visible_on_landing ? 'Visible' : 'Hidden'); ?>

                                                </span>
                                            </label>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-icon btn-text-secondary"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="View Details">
                                            <i class="ti ti-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <!-- SortableJS -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Sortable
            const sortableElement = document.getElementById('sortable-collections');

            if (sortableElement) {
                const sortable = new Sortable(sortableElement, {
                    handle: '.ti-grip-vertical',
                    animation: 150,
                    ghostClass: 'sortable-ghost',
                    dragClass: 'sortable-drag',
                    onEnd: function(evt) {
                        updateOrderNumbers();
                    }
                });
            }

            // Update order numbers after drag and drop
            function updateOrderNumbers() {
                const rows = document.querySelectorAll('#sortable-collections tr');
                rows.forEach(function(row, index) {
                    row.dataset.order = index;
                    const badge = row.querySelector('.order-badge');
                    if (badge) {
                        badge.textContent = index;
                    }
                });
            }

            // Save order button
            const saveButton = document.getElementById('saveOrder');
            if (saveButton) {
                saveButton.addEventListener('click', function() {
                    const collections = [];
                    const rows = document.querySelectorAll('#sortable-collections tr');

                    rows.forEach(function(row, index) {
                        const checkbox = row.querySelector('.visibility-toggle');
                        collections.push({
                            id: row.dataset.id,
                            order: index,
                            is_visible_on_landing: checkbox ? checkbox.checked : true
                        });
                    });

                    // Show loading
                    saveButton.disabled = true;
                    saveButton.innerHTML =
                        '<span class="spinner-border spinner-border-sm me-1"></span> Saving...';

                    fetch("<?php echo e(route('admin.collection-order.update')); ?>", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                            },
                            body: JSON.stringify({
                                collections: collections
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            showAlert('success', data.message);
                            saveButton.disabled = false;
                            saveButton.innerHTML =
                            '<i class="ti ti-device-floppy me-1"></i> Save Order';
                        })
                        .catch(error => {
                            showAlert('danger', 'Failed to save collection order');
                            saveButton.disabled = false;
                            saveButton.innerHTML =
                            '<i class="ti ti-device-floppy me-1"></i> Save Order';
                        });
                });
            }

            // Toggle visibility
            const visibilityToggles = document.querySelectorAll('.visibility-toggle');
            visibilityToggles.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const collectionId = this.dataset.id;
                    const isVisible = this.checked;
                    const visibilityText = this.closest('td').querySelector('.visibility-text');

                    fetch(`/admin/collection/${collectionId}/toggle-visibility`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                            },
                            body: JSON.stringify({
                                is_visible_on_landing: isVisible
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (visibilityText) {
                                visibilityText.textContent = isVisible ? 'Visible' : 'Hidden';
                            }
                            showAlert('success', data.message, 3000);
                        })
                        .catch(error => {
                            // Revert checkbox state
                            checkbox.checked = !isVisible;
                            showAlert('danger', 'Failed to update visibility');
                        });
                });
            });

            // Show alert helper
            function showAlert(type, message, duration = 5000) {
                const alertContainer = document.getElementById('alert-container');
                const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
                alertContainer.innerHTML = alertHtml;

                setTimeout(function() {
                    const alert = alertContainer.querySelector('.alert');
                    if (alert) {
                        alert.classList.remove('show');
                        setTimeout(() => alert.remove(), 150);
                    }
                }, duration);
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\admin\website-management\collection-order.blade.php ENDPATH**/ ?>