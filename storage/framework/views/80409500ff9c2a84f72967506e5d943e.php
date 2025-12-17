

<?php $__env->startSection('title', 'Landing Page Sections Management'); ?>

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
                    <span class="text-muted fw-light">Website Management /</span> Landing Page Sections
                </h4>
                <p class="text-muted">Kelola section yang tampil di landing page</p>
            </div>
            <div>
                <a href="<?php echo e(route('admin.landing-page-sections.create')); ?>" class="btn btn-primary">
                    <i class="ti ti-plus me-1"></i> Tambah Section Baru
                </a>
            </div>
        </div>

        <!-- Filter -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="<?php echo e(route('admin.landing-page-sections.index')); ?>" method="GET">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="section_type" class="form-label">Filter by Section Type</label>
                            <select class="form-select" id="section_type" name="section_type" onchange="this.form.submit()">
                                <option value="">Semua Section</option>
                                <?php $__currentLoopData = $sectionTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key); ?>" <?php echo e(request('section_type') == $key ? 'selected' : ''); ?>>
                                        <?php echo e($label); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <?php if(request('section_type')): ?>
                            <div class="col-md-2 d-flex align-items-end">
                                <a href="<?php echo e(route('admin.landing-page-sections.index')); ?>" class="btn btn-label-secondary">
                                    <i class="ti ti-x me-1"></i> Clear Filter
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sections List -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">List Section Landing Page</h5>
                <small class="text-muted">Total: <?php echo e(is_countable($sections) ? $sections->total() : $sections->count()); ?> sections</small>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="5%">Order</th>
                                <th width="20%">Section Name</th>
                                <th width="15%">Section Type</th>
                                <th width="15%">Reference</th>
                                <th width="10%" class="text-center">Visibility</th>
                                <th width="15%">Last Updated</th>
                                <th width="20%" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="sortable-sections">
                            <?php $__empty_1 = true; $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr data-id="<?php echo e($section->id); ?>">
                                    <td>
                                        <span class="badge bg-label-primary"><?php echo e($section->order); ?></span>
                                    </td>
                                    <td>
                                        <strong><?php echo e($section->section_name); ?></strong>
                                    </td>
                                    <td>
                                        <?php
                                            $badges = [
                                                'hero_banner' => 'primary',
                                                'top_cities' => 'success',
                                                'subscription_plans' => 'warning',
                                                'collection' => 'info',
                                                'latest_blogs' => 'danger',
                                            ];
                                            $badgeColor = $badges[$section->section_type] ?? 'secondary';
                                        ?>
                                        <span class="badge bg-<?php echo e($badgeColor); ?>">
                                            <?php echo e($sectionTypes[$section->section_type] ?? $section->section_type); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <?php if($section->reference_id && $section->collection): ?>
                                            <small>Collection: <?php echo e($section->collection->name); ?></small>
                                        <?php elseif($section->section_type == 'top_cities'): ?>
                                            <small class="text-muted">Top 10 Cities</small>
                                        <?php elseif($section->section_type == 'latest_blogs'): ?>
                                            <small class="text-muted">Latest Blogs</small>
                                        <?php else: ?>
                                            <small class="text-muted">-</small>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check form-switch d-inline-block">
                                            <input class="form-check-input visibility-toggle" type="checkbox" 
                                                   data-id="<?php echo e($section->id); ?>" 
                                                   <?php echo e($section->is_visible ? 'checked' : ''); ?>>
                                        </div>
                                    </td>
                                    <td>
                                        <small class="text-muted"><?php echo e($section->updated_at->format('d M Y H:i')); ?></small>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="<?php echo e(route('admin.landing-page-sections.edit', $section->id)); ?>" 
                                               class="btn btn-sm btn-icon btn-label-primary" 
                                               data-bs-toggle="tooltip" 
                                               title="Edit">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <form action="<?php echo e(route('admin.landing-page-sections.destroy', $section->id)); ?>" 
                                                  method="POST" 
                                                  class="d-inline delete-form">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="button" 
                                                        class="btn btn-sm btn-icon btn-label-danger delete-btn" 
                                                        data-bs-toggle="tooltip" 
                                                        title="Delete">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="mb-3">
                                            <i class="ti ti-folder-off" style="font-size: 3rem; color: #ddd;"></i>
                                        </div>
                                        <p class="text-muted mb-0">Belum ada section yang ditambahkan</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if(method_exists($sections, 'links')): ?>
                    <div class="mt-4">
                        <?php echo e($sections->links()); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    $(document).ready(function() {
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Toggle visibility
        $('.visibility-toggle').on('change', function() {
            const sectionId = $(this).data('id');
            const isChecked = $(this).is(':checked');
            
            $.ajax({
                url: `/admin/landing-page-sections/${sectionId}/toggle-visibility`,
                type: 'POST',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>'
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                    }
                },
                error: function(xhr) {
                    toastr.error('Gagal mengubah visibility');
                    // Revert checkbox
                    $(this).prop('checked', !isChecked);
                }
            });
        });

        // Delete confirmation
        $('.delete-btn').on('click', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Section akan dihapus dari landing page!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views/admin/landing-page-sections/index.blade.php ENDPATH**/ ?>