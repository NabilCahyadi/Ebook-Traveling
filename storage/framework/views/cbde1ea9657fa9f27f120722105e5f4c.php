<?php $__env->startSection('title', __('admin.blog_categories.blog_categories')); ?>

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
                <span class="text-muted fw-light">Admin / Content Management /</span> <?php echo e(__('admin.blog_categories.blog_categories')); ?>

            </h4>
        </div>
        <div>
            <a href="<?php echo e(route('admin.blog-categories.trashed')); ?>" class="btn btn-outline-danger me-2">
                <i class="ti ti-trash me-1"></i> <?php echo e(__('admin.blog_categories.view_trashed')); ?>

            </a>
            <a href="<?php echo e(route('admin.blog-categories.create')); ?>" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i> <?php echo e(__('admin.blog_categories.add_new_category')); ?>

            </a>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('admin.blog-categories.index')); ?>">
                <div class="row">
                    <div class="col-md-10">
                        <input type="text" name="search" class="form-control" placeholder="<?php echo e(__('admin.blog_categories.search_placeholder')); ?>"
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

    <!-- Categories Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><?php echo e(__('admin.blog_categories.blog_categories')); ?></h5>
            <div class="text-muted"><?php echo e(__('admin.blog_categories.total')); ?>: <?php echo e($categories->total()); ?> <?php echo e(__('admin.blog_categories.categories')); ?></div>
        </div>
        <div class="card-body">
            <?php if($categories->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th><?php echo e(__('admin.blog_categories.name')); ?></th>
                                <!-- <th><?php echo e(__('admin.blog_categories.slug')); ?></th> -->
                                <th><?php echo e(__('admin.blog_categories.description')); ?></th>
                                <th><?php echo e(__('admin.blog_categories.status')); ?></th>
                                <th><?php echo e(__('admin.blog_categories.blogs')); ?></th>
                                <th><?php echo e(__('admin.blog_categories.created')); ?></th>
                                <th><?php echo e(__('admin.blog_categories.actions')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <strong><?php echo e($category->name); ?></strong>
                                        </div>
                                    </td>
                                    <!-- <td>
                                        <code><?php echo e($category->slug); ?></code>
                                    </td> -->
                                    <td>
                                        <small class="text-muted"><?php echo e(Str::limit($category->description ?? '-', 50)); ?></small>
                                    </td>
                                    <td>
                                        <?php if($category->is_active): ?>
                                            <span class="badge bg-success"><?php echo e(__('admin.blog_categories.active')); ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary"><?php echo e(__('admin.blog_categories.inactive')); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-label-primary"><?php echo e($category->blogs_count ?? 0); ?></span>
                                    </td>
                                    <td>
                                        <small class="text-muted"><?php echo e($category->created_at->format('d M Y')); ?></small>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a href="<?php echo e(route('admin.blog-categories.edit', $category->id)); ?>" class="dropdown-item">
                                                    <i class="ti ti-edit me-1"></i> <?php echo e(__('admin.blog_categories.edit')); ?>

                                                </a>
                                                <a href="<?php echo e(route('admin.blog-categories.show', $category->id)); ?>" class="dropdown-item">
                                                    <i class="ti ti-eye me-1"></i> <?php echo e(__('admin.blog_categories.view_details')); ?>

                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <form action="<?php echo e(route('admin.blog-categories.destroy', $category->id)); ?>" method="POST"
                                                    onsubmit="return confirm('<?php echo e(__('admin.blog_categories.delete_confirm')); ?>');">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="ti ti-trash me-1"></i> <?php echo e(__('admin.blog_categories.move_to_trash')); ?>

                                                    </button>
                                                </form>
                                            </div>
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
                    <i class="ti ti-folder-off" style="font-size: 3rem; opacity: 0.3;"></i>
                    <p class="text-muted mt-3"><?php echo e(__('admin.blog_categories.no_categories_found')); ?></p>
                    <a href="<?php echo e(route('admin.blog-categories.create')); ?>" class="btn btn-primary">
                        <i class="ti ti-plus me-1"></i> <?php echo e(__('admin.blog_categories.add_first_category')); ?>

                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\admin\blog-categories\index.blade.php ENDPATH**/ ?>