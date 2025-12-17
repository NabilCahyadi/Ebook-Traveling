<?php $__env->startSection('title', 'Manage Landing Page Sections'); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        .section-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-size: 20px;
        }

        .section-row {
            border-bottom: 1px solid #f0f0f0;
        }

        .section-row:hover {
            background-color: #f8f9fa;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <span class="text-muted fw-light">Website Management /</span> Landing Page Sections
            </h4>
            <p class="mb-0">Kelola visibility dan content section di landing page</p>
        </div>
    </div>

    <!-- Success/Error Messages -->
    <div id="alert-container"></div>

    <!-- Sections List Card -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Landing Page Sections</h5>
            <div class="text-muted small">
                <i class="ti ti-info-circle me-1"></i> Manage content dan visibility untuk setiap section
            </div>
        </div>
        <div class="card-body">
            <?php if($sections->isEmpty()): ?>
                <div class="text-center py-5">
                    <i class="ti ti-box-off display-4 text-muted"></i>
                    <p class="mt-3 mb-2">No sections available. Please run seeder to initialize sections.</p>
                    <code class="d-block mb-3">php artisan db:seed --class=LandingPageSectionsSeeder</code>
                    <button class="btn btn-primary mt-3" onclick="window.location.reload()">
                        <i class="ti ti-refresh me-1"></i> Refresh
                    </button>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th width="80">Order</th>
                                <th width="60">Icon</th>
                                <th>Section Name</th>
                                <th>Type</th>
                                <th width="150">Visibility</th>
                                <th width="200" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr data-id="<?php echo e($section->id); ?>" class="section-row">
                                    <td>
                                        <span class="badge bg-label-secondary"><?php echo e($section->order + 1); ?></span>
                                    </td>
                                    <td>
                                        <div
                                            class="section-icon <?php echo e($section->is_visible ? 'bg-label-primary' : 'bg-label-secondary'); ?>">
                                            <?php switch($section->section_type):
                                                case ('hero_banner'): ?>
                                                    <i class="ti ti-photo"></i>
                                                <?php break; ?>

                                                <?php case ('top_cities'): ?>
                                                    <i class="ti ti-map-pin"></i>
                                                <?php break; ?>

                                                <?php case ('subscription_plans'): ?>
                                                    <i class="ti ti-crown"></i>
                                                <?php break; ?>

                                                <?php case ('collection'): ?>
                                                    <i class="ti ti-books"></i>
                                                <?php break; ?>

                                                <?php case ('latest_blogs'): ?>
                                                    <i class="ti ti-article"></i>
                                                <?php break; ?>

                                                <?php default: ?>
                                                    <i class="ti ti-box"></i>
                                            <?php endswitch; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-0"><?php echo e($section->section_name); ?></h6>
                                            <?php if($section->section_type === 'collection' && $section->collection): ?>
                                                <small class="text-muted">Collection:
                                                    <?php echo e($section->collection->name); ?></small>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-label-info">
                                            <?php echo e(str_replace('_', ' ', ucwords($section->section_type))); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input visibility-toggle" type="checkbox"
                                                data-id="<?php echo e($section->id); ?>" <?php echo e($section->is_visible ? 'checked' : ''); ?>>
                                            <label class="form-check-label">
                                                <span class="visibility-text">
                                                    <?php echo e($section->is_visible ? 'Visible' : 'Hidden'); ?>

                                                </span>
                                            </label>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <?php if($section->section_type === 'hero_banner'): ?>
                                            <a href="<?php echo e(route('admin.banners.index')); ?>"
                                                class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Manage Banners">
                                                <i class="ti ti-settings"></i> Manage Content
                                            </a>
                                        <?php elseif($section->section_type === 'top_cities'): ?>
                                            <a href="<?php echo e(route('admin.cities.index')); ?>"
                                                class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Manage Cities">
                                                <i class="ti ti-settings"></i> Manage Content
                                            </a>
                                        <?php elseif($section->section_type === 'latest_blogs'): ?>
                                            <a href="<?php echo e(route('admin.blogs.index')); ?>"
                                                class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Manage Blogs">
                                                <i class="ti ti-settings"></i> Manage Content
                                            </a>
                                        <?php elseif($section->section_type === 'collection'): ?>
                                            <a href="<?php echo e(route('admin.collections.manage-ebooks', $section->reference_id)); ?>"
                                                class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Manage Collection">
                                                <i class="ti ti-settings"></i> Manage Content
                                            </a>
                                        <?php elseif($section->section_type === 'subscription_plans'): ?>
                                            <a href="<?php echo e(route('admin.subscription-plans.index')); ?>"
                                                class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Manage Plans">
                                                <i class="ti ti-settings"></i> Manage Content
                                            </a>
                                        <?php else: ?>
                                            <button type="button" class="btn btn-sm btn-icon btn-text-secondary"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="View Details">
                                                <i class="ti ti-eye"></i>
                                            </button>
                                        <?php endif; ?>
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
     script>
        document.addEventListener('DOMContentLoaded', function() {                checkbox.addEventListener('change', function() {
                    const sectionId = this.dataset.id;
                    const isVisible = this.checked;
                    const visibilityText = this.closest('td').querySelector('.visibility-text');
                    const icon = this.closest('tr').querySelector('.section-icon');

                    fetch(`/admin/landing-section/${sectionId}/toggle-visibility`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                            },
                            body: JSON.stringify({
                                is_visible: isVisible
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (visibilityText) {
                                visibilityText.textContent = isVisible ? 'Visible' : 'Hidden';
                            }
                            if (icon) {
                                icon.classList.toggle('bg-label-primary', isVisible);
                                icon.classList.toggle('bg-label-secondary', !isVisible);
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

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views/admin/website-management/landing-sections.blade.php ENDPATH**/ ?>