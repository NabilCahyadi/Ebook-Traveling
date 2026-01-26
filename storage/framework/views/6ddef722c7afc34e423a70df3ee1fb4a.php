<?php $__env->startSection('title', 'Policy - ' . $pageTypeName); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Success/Error Messages -->
        <!-- <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
         <?php endif; ?> -->

        <!-- <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?> -->

        <!-- Page Header -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <div>
                <h4 class="fw-bold py-3 mb-2">
                    <span class="text-muted fw-light"><?php echo e(__('admin.menu.website_setting')); ?> / Policy /</span> <?php echo e($pageTypeName); ?>

                </h4>
            </div>
            <div>
                <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission("website.policies-{$pageTypeSlug}.create")): ?>
                <a href="<?php echo e(route("admin.policies.{$pageTypeSlug}.create")); ?>" class="btn btn-primary">
                    <i class="ti ti-plus me-1"></i> Add Section
                </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="<?php echo e(route("admin.policies.{$pageTypeSlug}.index")); ?>" method="GET">
                    <div class="row g-3">
                        <div class="col-12 col-md-8">
                            <label for="search" class="form-label"><?php echo e(__('admin.common.search')); ?></label>
                            <input type="text" class="form-control" id="search" name="search"
                                value="<?php echo e(request('search')); ?>" placeholder="Search by title, subsection, or content...">
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
                                <a href="<?php echo e(route("admin.policies.{$pageTypeSlug}.index")); ?>" class="btn btn-label-secondary"
                                    title="<?php echo e(__('admin.common.clear_filters')); ?>">
                                    <i class="ti ti-x"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sections Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><?php echo e($pageTypeName); ?> Sections</h5>
                <div class="text-muted">Total: <?php echo e($sections->total()); ?> Sections</div>
            </div>
            <div class="card-body">
                <?php if($sections->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover" id="sectionsTable">
                            <thead>
                                <tr>
                                    <th width="80">Order</th>
                                    <th>Section Title</th>
                                    <th>Subsection Title</th>
                                    <th class="d-none d-md-table-cell">Content Preview</th>
                                    <th width="120" class="d-none d-lg-table-cell"><?php echo e(__('admin.common.date_created')); ?></th>
                                    <th width="80" class="text-center"><?php echo e(__('admin.common.actions')); ?></th>
                                </tr>
                            </thead>
                            <tbody id="sortableSections">
                                <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr data-id="<?php echo e($section->id); ?>" style="cursor: move;">
                                        <td>
                                            <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission("website.policies-{$pageTypeSlug}.edit")): ?>
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="ti ti-grip-vertical text-muted drag-handle" style="cursor: grab; font-size: 1.2rem;" title="Drag to reorder"></i>
                                                <span class="badge bg-label-secondary"><?php echo e($section->order_index); ?></span>
                                            </div>
                                            <?php else: ?>
                                            <span class="badge bg-label-secondary"><?php echo e($section->order_index); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div style="max-width: 200px;">
                                                <strong><?php echo e($section->section_title ?? '-'); ?></strong>
                                            </div>
                                        </td>
                                        <td>
                                            <div style="max-width: 200px;">
                                                <?php echo e($section->subsection_title ?? '-'); ?>

                                            </div>
                                        </td>
                                        <td class="d-none d-md-table-cell">
                                            <div style="max-width: 300px;">
                                                <?php echo e(Str::limit($section->content, 80)); ?>

                                            </div>
                                        </td>
                                        <td class="d-none d-lg-table-cell">
                                            <small class="text-muted"><?php echo e($section->created_at->format('d M Y')); ?></small>
                                        </td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow" 
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical ti-md"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission("website.policies-{$pageTypeSlug}.edit")): ?>
                                                    <a href="<?php echo e(route("admin.policies.{$pageTypeSlug}.edit", $section->id)); ?>" class="dropdown-item">
                                                        <i class="ti ti-edit me-2"></i>
                                                        <?php echo e(__('admin.common.edit')); ?>

                                                    </a>
                                                    <?php endif; ?>
                                                    
                                                    <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission("website.policies-{$pageTypeSlug}.delete")): ?>
                                                    <button type="button" class="dropdown-item text-danger delete-section" data-id="<?php echo e($section->id); ?>">
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
                        <?php echo e($sections->appends(request()->query())->links()); ?>

                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="ti ti-file-text ti-xl text-muted mb-3 d-block" style="font-size: 4rem;"></i>
                        <h5 class="text-muted">No sections found</h5>
                        <p class="text-muted">
                            <?php if(request()->has('search')): ?>
                                No sections match your search criteria.
                            <?php else: ?>
                                Start by creating your first section.
                            <?php endif; ?>
                        </p>
                        <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission("website.policies-{$pageTypeSlug}.create")): ?>
                        <a href="<?php echo e(route("admin.policies.{$pageTypeSlug}.create")); ?>" class="btn btn-primary mt-2">
                            <i class="ti ti-plus me-1"></i> Add First Section
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
            const pageTypeSlug = '<?php echo e($pageTypeSlug); ?>';
            
            // Initialize SortableJS for drag-drop reordering
            <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission("website.policies-{$pageTypeSlug}.edit")): ?>
            const sortable = new Sortable(document.getElementById('sortableSections'), {
                handle: '.drag-handle',
                animation: 150,
                ghostClass: 'bg-light',
                onEnd: function(evt) {
                    const rows = document.querySelectorAll('#sortableSections tr');
                    const orders = [];
                    
                    rows.forEach((row, index) => {
                        orders.push({
                            id: row.dataset.id,
                            order_index: index + 1
                        });
                    });
                    
                    // Send AJAX request to update order
                    $.ajax({
                        url: '<?php echo e(route("admin.policies.{$pageTypeSlug}.update-order")); ?>',
                        method: 'POST',
                        data: {
                            _token: '<?php echo e(csrf_token()); ?>',
                            orders: orders
                        },
                        success: function(response) {
                            if (response.success) {
                                // Update badge numbers
                                rows.forEach((row, index) => {
                                    row.querySelector('.badge').textContent = index + 1;
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Gagal memperbarui urutan. Silakan refresh halaman.'
                            });
                        }
                    });
                }
            });
            <?php endif; ?>
            
            // Delete section
            $(document).on('click', '.delete-section', function() {
                const id = $(this).data('id');
                
                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: 'Apakah Anda yakin ingin menghapus section ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/policies/${pageTypeSlug}/${id}`,
                            method: 'DELETE',
                            data: {
                                _token: '<?php echo e(csrf_token()); ?>'
                            },
                            success: function(response) {
                                if (response.success) {
                                    // Remove row from table
                                    $(`tr[data-id="${id}"]`).fadeOut(300, function() {
                                        $(this).remove();
                                    });
                                    
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Terhapus!',
                                        text: response.message,
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: xhr.responseJSON?.message || 'Gagal menghapus section.'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\admin\policies\index.blade.php ENDPATH**/ ?>