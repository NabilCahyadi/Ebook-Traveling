<?php $__env->startSection('title', __('admin.blog_categories.details')); ?>

<?php $__env->startSection('content'); ?>

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold py-3 mb-2">
                <span class="text-muted fw-light">Admin / Content Management / Blog Categories /</span> <?php echo e(__('admin.blog_categories.details')); ?>

            </h4>
        </div>
        <div>
            <a href="<?php echo e(route('admin.blog-categories.index')); ?>" class="btn btn-secondary me-2">
                <i class="ti ti-arrow-left me-1"></i> <?php echo e(__('admin.blog_categories.back_to_list')); ?>

            </a>
            <a href="<?php echo e(route('admin.blog-categories.edit', $category->id)); ?>" class="btn btn-primary">
                <i class="ti ti-edit me-1"></i> <?php echo e(__('admin.blog_categories.edit_category')); ?>

            </a>
        </div>
    </div>

    <div class="row">
        <!-- Category Info -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><?php echo e(__('admin.blog_categories.category_information')); ?></h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <strong><?php echo e(__('admin.blog_categories.name')); ?>:</strong>
                        </div>
                        <div class="col-md-9">
                            <?php echo e($category->name); ?>

                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <strong><?php echo e(__('admin.blog_categories.slug')); ?>:</strong>
                        </div>
                        <div class="col-md-9">
                            <code><?php echo e($category->slug); ?></code>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <strong><?php echo e(__('admin.blog_categories.description')); ?>:</strong>
                        </div>
                        <div class="col-md-9">
                            <?php echo e($category->description ?? '-'); ?>

                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <strong><?php echo e(__('admin.blog_categories.status')); ?>:</strong>
                        </div>
                        <div class="col-md-9">
                            <?php if($category->is_active): ?>
                                <span class="badge bg-success"><?php echo e(__('admin.blog_categories.active')); ?></span>
                            <?php else: ?>
                                <span class="badge bg-secondary"><?php echo e(__('admin.blog_categories.inactive')); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <strong><?php echo e(__('admin.blog_categories.total_blogs')); ?>:</strong>
                        </div>
                        <div class="col-md-9">
                            <span class="badge bg-label-primary"><?php echo e($category->blogs->count()); ?></span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <strong><?php echo e(__('admin.blog_categories.created_at')); ?>:</strong>
                        </div>
                        <div class="col-md-9">
                            <?php echo e($category->created_at->format('d M Y H:i:s')); ?>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <strong><?php echo e(__('admin.blog_categories.updated_at')); ?>:</strong>
                        </div>
                        <div class="col-md-9">
                            <?php echo e($category->updated_at->format('d M Y H:i:s')); ?>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Associated Blogs -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><?php echo e(__('admin.blog_categories.blogs_in_category')); ?></h5>
                </div>
                <div class="card-body">
                    <?php if($category->blogs->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th><?php echo e(__('admin.blog_categories.blog_title')); ?></th>
                                        <th><?php echo e(__('admin.blog_categories.author')); ?></th>
                                        <th><?php echo e(__('admin.blog_categories.status')); ?></th>
                                        <th><?php echo e(__('admin.blog_categories.created')); ?></th>
                                        <th><?php echo e(__('admin.blog_categories.actions')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $category->blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($blog->title); ?></td>
                                            <td><?php echo e($blog->author->name ?? '-'); ?></td>
                                            <td>
                                                <?php if($blog->status): ?>
                                                    <span class="badge bg-success"><?php echo e(__('admin.blogs.published')); ?></span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning"><?php echo e(__('admin.blogs.draft')); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <small class="text-muted"><?php echo e($blog->created_at->format('d M Y')); ?></small>
                                            </td>
                                            <td>
                                                <a href="<?php echo e(route('admin.blogs.edit', $blog->id)); ?>" class="btn btn-sm btn-primary">
                                                    <i class="ti ti-edit"></i> <?php echo e(__('admin.blog_categories.edit')); ?>

                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="ti ti-file-off" style="font-size: 2rem; opacity: 0.3;"></i>
                            <p class="text-muted mt-2"><?php echo e(__('admin.blog_categories.no_blogs_in_category')); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Actions Sidebar -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><?php echo e(__('admin.blog_categories.actions')); ?></h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="<?php echo e(route('admin.blog-categories.edit', $category->id)); ?>" class="btn btn-primary">
                            <i class="ti ti-edit me-1"></i> <?php echo e(__('admin.blog_categories.edit_category')); ?>

                        </a>

                        <form action="<?php echo e(route('admin.blog-categories.destroy', $category->id)); ?>" method="POST"
                            onsubmit="return confirm('<?php echo e(__('admin.blog_categories.delete_confirm')); ?>');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="ti ti-trash me-1"></i> <?php echo e(__('admin.blog_categories.move_to_trash')); ?>

                            </button>
                        </form>
                    </div>

                    <hr>

                    <div class="alert alert-info mb-0">
                        <i class="ti ti-info-circle me-1"></i>
                        <small>
                            <strong><?php echo e(__('admin.blog_categories.note')); ?>:</strong> <?php echo e(__('admin.blog_categories.delete_note')); ?>

                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views/admin/blog-categories/show.blade.php ENDPATH**/ ?>