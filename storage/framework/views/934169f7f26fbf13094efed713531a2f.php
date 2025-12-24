<?php $__env->startSection('title', 'Manage Hero Banners'); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        .banner-preview {
            position: relative;
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
        }

        .cursor-move {
            cursor: move;
        }

        .sortable-ghost {
            opacity: 0.4;
            background-color: #e3f2fd;
        }

        .action-buttons {
            gap: 0.25rem;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <span class="text-muted fw-light">Website Management /</span> Hero Banners
            </h4>
            <p class="mb-0">Kelola banner slider yang tampil di halaman utama</p>
        </div>
        <div>
            <?php if($activeTab === 'home-slider'): ?>
                <a href="<?php echo e(route('admin.banners.create')); ?>" class="btn btn-primary">
                    <i class="ti ti-plus me-1"></i> Add New Banner
                </a>
            <?php elseif($activeTab === 'banner-pricing'): ?>
                <?php if($bannerPricing): ?>
                    <button class="btn btn-secondary" disabled title="Banner pricing sudah ada, hapus dulu untuk membuat yang baru">
                        <i class="ti ti-plus me-1"></i> Add New Banner
                    </button>
                <?php else: ?>
                    <a href="<?php echo e(route('admin.banners.create')); ?>?type=banner-pricing" class="btn btn-primary">
                        <i class="ti ti-plus me-1"></i> Add New Banner
                    </a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Tab Navigation -->
    <ul class="nav nav-tabs mb-4" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link <?php echo e($activeTab === 'home-slider' ? 'active' : ''); ?>" 
               href="<?php echo e(route('admin.banners.index', ['tab' => 'home-slider'])); ?>">
                <i class="ti ti-photo me-1"></i> Home Slider
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link <?php echo e($activeTab === 'banner-pricing' ? 'active' : ''); ?>" 
               href="<?php echo e(route('admin.banners.index', ['tab' => 'banner-pricing'])); ?>">
                <i class="ti ti-tag me-1"></i> Banner Pricing
            </a>
        </li>
    </ul>

    <!-- Success/Error Messages -->
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if($activeTab === 'home-slider'): ?>
        <!-- Info Alert -->
        <div class="alert alert-info d-flex align-items-center" role="alert">
            <i class="ti ti-info-circle me-2"></i>
            <div>
                <strong>Tips:</strong> Banner dengan dimensi 1920x600px (3.2:1) akan terlihat sempurna. Format: JPEG, PNG,
                atau WebP.
            </div>
        </div>

        <!-- Banners Card -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Hero Banners List</h5>
                <?php if($banners->count() > 1): ?>
                    <div class="text-muted small">
                        <i class="ti ti-arrows-sort me-1"></i> Drag and drop to reorder
                    </div>
                <?php endif; ?>
            </div>
            <div class="card-body p-0">
                <?php if($banners->isEmpty()): ?>
                <div class="text-center py-5">
                    <i class="ti ti-photo-off display-4 text-muted"></i>
                    <p class="mt-3 mb-2">No banners available</p>
                    <p class="text-muted mb-3">Create your first banner to display on homepage</p>
                    <a href="<?php echo e(route('admin.banners.create')); ?>" class="btn btn-primary">
                        <i class="ti ti-plus me-1"></i> Create Banner
                    </a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="50">#</th>
                                <th width="150">Banner Image</th>
                                <th>Title</th>
                                <th width="150">Status</th>
                                <th width="100">Order</th>
                                <th width="200" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="sortable-banners">
                            <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr data-id="<?php echo e($banner->id); ?>">
                                    <td>
                                        <i class="ti ti-grip-vertical cursor-move text-muted"></i>
                                    </td>
                                    <td>
                                        <img src="<?php echo e($banner->image_url); ?>" alt="<?php echo e($banner->title); ?>"
                                            class="banner-preview">
                                    </td>
                                    <td>
                                        <div>
                                            <h6 class="mb-1"><?php echo e($banner->title); ?></h6>
                                            <?php if($banner->description): ?>
                                                <small class="text-muted"><?php echo e(Str::limit($banner->description, 60)); ?></small>
                                            <?php endif; ?>
                                            <?php if($banner->target_url): ?>
                                                <div class="mt-1">
                                                    <small class="text-primary">
                                                        <i class="ti ti-link ti-xs"></i>
                                                        <?php echo e(Str::limit($banner->target_url, 40)); ?>

                                                    </small>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input status-toggle" type="checkbox"
                                                data-id="<?php echo e($banner->id); ?>" <?php echo e($banner->is_active ? 'checked' : ''); ?>>
                                            <label class="form-check-label">
                                                <span class="badge <?php echo e($banner->is_active ? 'bg-success' : 'bg-secondary'); ?>">
                                                    <?php echo e($banner->is_active ? 'Active' : 'Inactive'); ?>

                                                </span>
                                            </label>
                                        </div>
                                        <?php if($banner->start_date || $banner->end_date): ?>
                                            <small class="text-muted d-block mt-1">
                                                <?php if($banner->start_date): ?>
                                                    From: <?php echo e($banner->start_date->format('d M Y')); ?><br>
                                                <?php endif; ?>
                                                <?php if($banner->end_date): ?>
                                                    Until: <?php echo e($banner->end_date->format('d M Y')); ?>

                                                <?php endif; ?>
                                            </small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-label-secondary order-badge"><?php echo e($banner->order_index); ?></span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center action-buttons">
                                            <a href="<?php echo e(route('admin.banners.edit', $banner->id)); ?>"
                                                class="btn btn-sm btn-icon btn-label-primary" data-bs-toggle="tooltip"
                                                title="Edit">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-icon btn-label-danger"
                                                onclick="confirmDelete('<?php echo e($banner->id); ?>')" data-bs-toggle="tooltip"
                                                title="Delete">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Delete Form (Hidden) -->
    <form id="delete-form" method="POST" style="display: none;">
        <?php echo csrf_field(); ?>
        <?php echo method_field('DELETE'); ?>
    </form>
    <?php endif; ?>

<?php $__env->startPush('scripts'); ?>
    <?php if($activeTab === 'home-slider'): ?>
    <!-- SortableJS -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Sortable
            const sortableElement = document.getElementById('sortable-banners');

            if (sortableElement) {
                const sortable = new Sortable(sortableElement, {
                    handle: '.ti-grip-vertical',
                    animation: 150,
                    ghostClass: 'sortable-ghost',
                    onEnd: function(evt) {
                        updateBannerOrder();
                    }
                });
            }

            // Update banner order
            function updateBannerOrder() {
                const rows = document.querySelectorAll('#sortable-banners tr');
                const banners = [];

                rows.forEach(function(row, index) {
                    const badge = row.querySelector('.order-badge');
                    if (badge) {
                        badge.textContent = index;
                    }

                    banners.push({
                        id: row.dataset.id,
                        order_index: index
                    });
                });

                // Save to server
                fetch("<?php echo e(route('admin.banners.update-order')); ?>", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                        },
                        body: JSON.stringify({
                            banners: banners
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast('success', data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('error', 'Failed to update order');
                    });
            }

            // Toggle status
            const statusToggles = document.querySelectorAll('.status-toggle');
            statusToggles.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const bannerId = this.dataset.id;
                    const badge = this.closest('td').querySelector('.badge');

                    fetch(`/admin/banners/${bannerId}/toggle-active`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                badge.textContent = data.is_active ? 'Active' : 'Inactive';
                                badge.className = data.is_active ? 'badge bg-success' :
                                    'badge bg-secondary';
                                showToast('success', data.message);
                            }
                        })
                        .catch(error => {
                            checkbox.checked = !checkbox.checked;
                            showToast('error', 'Failed to update status');
                        });
                });
            });

            // Show toast notification
            function showToast(type, message) {
                // Simple alert for now, can be replaced with toast library
                const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
                const alertHtml = `
                    <div class="alert ${alertClass} alert-dismissible fade show position-fixed top-0 end-0 m-3" role="alert" style="z-index: 9999;">
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `;
                document.body.insertAdjacentHTML('beforeend', alertHtml);

                setTimeout(() => {
                    const alert = document.querySelector('.alert');
                    if (alert) alert.remove();
                }, 3000);
            }
        });

        // Confirm delete
        function confirmDelete(bannerId) {
            if (confirm('Are you sure you want to delete this banner?')) {
                const form = document.getElementById('delete-form');
                form.action = `/admin/banners/${bannerId}`;
                form.submit();
            }
        }
    </script>
    <?php endif; ?>
<?php $__env->stopPush(); ?>

<?php if($activeTab === 'banner-pricing'): ?>
<!-- Banner Pricing Section -->
<div class="alert alert-info d-flex align-items-center" role="alert">
    <i class="ti ti-info-circle me-2"></i>
    <div>
        <strong>Info:</strong> Banner Pricing hanya boleh ada 1 banner. Dimensi yang disarankan: 1500x600px (2.5:1).
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Banner Pricing</h5>
    </div>
    <div class="card-body">
        <?php if($bannerPricing): ?>
            <!-- Existing Banner -->
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="position-relative">
                        <img src="<?php echo e(asset('storage/' . $bannerPricing->image)); ?>" 
                             alt="<?php echo e($bannerPricing->title); ?>" 
                             class="img-fluid rounded shadow-sm"
                             style="width: 100%; aspect-ratio: 2.5/1; object-fit: cover;">
                        <span class="badge position-absolute top-0 end-0 m-2 <?php echo e($bannerPricing->is_active ? 'bg-success' : 'bg-secondary'); ?>">
                            <?php echo e($bannerPricing->is_active ? 'Active' : 'Inactive'); ?>

                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <h4 class="mb-3"><?php echo e($bannerPricing->title); ?></h4>
                    <?php if($bannerPricing->description): ?>
                    <p class="text-muted mb-3"><?php echo e($bannerPricing->description); ?></p>
                    <?php endif; ?>
                    
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1"><i class="ti ti-calendar me-1"></i> Period</small>
                        <?php if($bannerPricing->start_date || $bannerPricing->end_date): ?>
                        <div class="d-flex gap-2 align-items-center">
                            <span class="badge bg-label-primary"><?php echo e($bannerPricing->start_date ? $bannerPricing->start_date->format('d M Y') : 'Immediate'); ?></span>
                            <i class="ti ti-arrow-right"></i>
                            <span class="badge bg-label-primary"><?php echo e($bannerPricing->end_date ? $bannerPricing->end_date->format('d M Y') : 'No end'); ?></span>
                        </div>
                        <?php else: ?>
                        <span class="text-muted">Always active</span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted"><i class="ti ti-photo me-1"></i> Image: <?php echo e(basename($bannerPricing->image)); ?></small>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted"><i class="ti ti-clock me-1"></i> Last updated: <?php echo e($bannerPricing->updated_at->diffForHumans()); ?></small>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="d-flex gap-2 mt-4">
                        <a href="<?php echo e(route('admin.banners.edit', $bannerPricing->id)); ?>" class="btn btn-primary btn-sm">
                            <i class="ti ti-edit me-1"></i> Edit
                        </a>
                        <form action="<?php echo e(route('admin.banners.destroy', $bannerPricing->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus banner pricing ini?');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="ti ti-trash me-1"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <!-- No Banner -->
            <div class="text-center py-5">
                <i class="ti ti-photo-off" style="font-size: 3rem; opacity: 0.3;"></i>
                <h5 class="mt-3 mb-2">Belum Ada Banner Pricing</h5>
                <p class="text-muted mb-4">Buat banner pricing untuk ditampilkan di halaman pricing</p>
                <a href="<?php echo e(route('admin.banners.create')); ?>?type=banner-pricing" class="btn btn-primary">
                    <i class="ti ti-plus me-1"></i> Buat Banner Pricing
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJEK PROJEK\Ebook-Traveling\resources\views/admin/banners/index.blade.php ENDPATH**/ ?>