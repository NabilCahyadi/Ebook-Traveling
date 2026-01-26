<?php $__env->startSection('title', __('admin.blog_categories.trashed')); ?>

<?php $__env->startSection('content'); ?>

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
                <span class="text-muted fw-light">Admin / Content Management / Blog Categories /</span> <?php echo e(__('admin.blog_categories.trashed')); ?>

                <span class="badge bg-label-danger ms-2"><?php echo e($categories->total()); ?> <?php echo e(__('admin.blog_categories.trashed')); ?></span>
            </h4>
        </div>
        <div>
            <a href="<?php echo e(route('admin.blog-categories.index')); ?>" class="btn btn-secondary">
                <i class="ti ti-arrow-left me-1"></i> <?php echo e(__('admin.blog_categories.back_to_active')); ?>

            </a>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('admin.blog-categories.trashed')); ?>">
                <div class="row">
                    <div class="col-md-10">
                        <input type="text" name="search" class="form-control" placeholder="<?php echo e(__('admin.blog_categories.search_trashed')); ?>"
                            value="<?php echo e($search ?? ''); ?>">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="ti ti-search me-1"></i> <?php echo e(__('admin.blog_categories.search')); ?>

                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Trashed Categories Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><?php echo e(__('admin.blog_categories.trashed_blog_categories')); ?></h5>
        </div>
        <div class="card-body">
            <?php if($categories->count() > 0): ?>
                <div class="alert alert-warning">
                    <i class="ti ti-alert-triangle me-1"></i>
                    <?php echo e(__('admin.blog_categories.trashed_warning')); ?>

                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th><?php echo e(__('admin.blog_categories.name')); ?></th>
                                <th><?php echo e(__('admin.blog_categories.slug')); ?></th>
                                <th><?php echo e(__('admin.blog_categories.description')); ?></th>
                                <th><?php echo e(__('admin.blog_categories.blogs')); ?></th>
                                <th><?php echo e(__('admin.blog_categories.deleted_at')); ?></th>
                                <th><?php echo e(__('admin.blog_categories.actions')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-2 bg-label-danger">
                                                <span class="avatar-initial rounded-circle">
                                                    <i class="ti ti-folder-off"></i>
                                                </span>
                                            </div>
                                            <strong><?php echo e($category->name); ?></strong>
                                        </div>
                                    </td>
                                    <td>
                                        <code><?php echo e($category->slug); ?></code>
                                    </td>
                                    <td>
                                        <small class="text-muted"><?php echo e(Str::limit($category->description ?? '-', 50)); ?></small>
                                    </td>
                                    <td>
                                        <span class="badge bg-label-primary"><?php echo e($category->blogs()->count()); ?></span>
                                    </td>
                                    <td>
                                        <small class="text-muted"><?php echo e($category->deleted_at->format('d M Y H:i')); ?></small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <form action="<?php echo e(route('admin.blog-categories.restore', $category->id)); ?>" method="POST"
                                                class="d-inline" onsubmit="return confirm('<?php echo e(__('admin.blog_categories.restore_confirm')); ?>');">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <button type="submit" class="btn btn-sm btn-success" title="<?php echo e(__('admin.blog_categories.restore')); ?>">
                                                    <i class="ti ti-refresh"></i> <?php echo e(__('admin.blog_categories.restore')); ?>

                                                </button>
                                            </form>

                                            <form action="<?php echo e(route('admin.blog-categories.force-delete', $category->id)); ?>" method="POST"
                                                class="d-inline" onsubmit="return confirm('<?php echo e(__('admin.blog_categories.force_delete_confirm')); ?>');">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-danger" title="<?php echo e(__('admin.blog_categories.delete_forever')); ?>">
                                                    <i class="ti ti-trash-x"></i> <?php echo e(__('admin.blog_categories.delete_forever')); ?>

                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3">
                    <?php echo e($categories->links()); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="ti ti-folder-check" style="font-size: 3rem; opacity: 0.3;"></i>
                    <p class="text-muted mt-3"><?php echo e(__('admin.blog_categories.no_trashed')); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\admin\blog-categories\trashed.blade.php ENDPATH**/ ?>