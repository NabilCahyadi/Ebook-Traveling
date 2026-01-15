<?php $__env->startSection('title', __('admin.blogs.title')); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light"><?php echo e(__('admin.menu.admin')); ?> /</span> <?php echo e(__('admin.blogs.title')); ?>

            </h4>
            <a href="<?php echo e(route('admin.blogs.create')); ?>" class="btn btn-primary">
                <i class="bx bx-plus me-1"></i> <?php echo e(__('admin.blogs.create_blog')); ?>

            </a>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-3"><?php echo e(__('admin.blogs.all_blogs')); ?></h5>

                <!-- Filter Section -->
                <form method="GET" action="<?php echo e(route('admin.blogs.index')); ?>" class="row g-3">
                    <div class="col-md-3">
                        <label for="status" class="form-label"><?php echo e(__('admin.form.status')); ?></label>
                        <select class="form-select" id="status" name="status">
                            <option value=""><?php echo e(__('admin.blogs.all_status')); ?></option>
                            <option value="draft" <?php echo e($status == 'draft' ? 'selected' : ''); ?>><?php echo e(__('admin.status.draft')); ?></option>
                            <option value="published" <?php echo e($status == 'published' ? 'selected' : ''); ?>><?php echo e(__('admin.status.published')); ?></option>
                            <option value="unpublished" <?php echo e($status == 'unpublished' ? 'selected' : ''); ?>><?php echo e(__('admin.status.unpublished')); ?>

                            </option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="category" class="form-label"><?php echo e(__('admin.blogs.category')); ?></label>
                        <select class="form-select" id="category" name="category">
                            <option value=""><?php echo e(__('admin.blogs.all_categories')); ?></option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($cat); ?>" <?php echo e($category == $cat ? 'selected' : ''); ?>>
                                    <?php echo e($cat); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="search" class="form-label"><?php echo e(__('admin.common.search')); ?></label>
                        <input type="text" class="form-control" id="search" name="search"
                            placeholder="<?php echo e(__('admin.blogs.search_placeholder')); ?>" value="<?php echo e($search ?? ''); ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-search-alt me-1"></i> <?php echo e(__('admin.common.filter')); ?>

                            </button>
                            <?php if($status || $category || $search): ?>
                                <a href="<?php echo e(route('admin.blogs.index')); ?>" class="btn btn-outline-secondary">
                                    <i class="bx bx-x"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>

                <!-- Stats -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <span class="badge bg-primary">Total: <?php echo e($blogs->total()); ?> Blog</span>
                    <a href="<?php echo e(route('admin.blogs.archived')); ?>" class="btn btn-sm btn-outline-secondary">
                        <i class="bx bx-archive me-1"></i> <?php echo e(__('admin.blogs.view_archived')); ?>

                    </a>
                </div>
            </div>
            <div class="card-body">
                <?php if($blogs->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('admin.blogs.image')); ?></th>
                                    <th><?php echo e(__('admin.blogs.title')); ?></th>
                                    <th><?php echo e(__('admin.blogs.creator')); ?></th>
                                    <th><?php echo e(__('admin.blogs.category')); ?></th>
                                    <!-- <th><?php echo e(__('admin.blogs.views')); ?></th> -->
                                    <th><?php echo e(__('admin.blogs.status')); ?></th>
                                    <th><?php echo e(__('admin.blogs.published')); ?></th>
                                    <th><?php echo e(__('admin.actions.actions')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <?php if($blog->featured_image): ?>
                                                <?php
                                                    // Check if image is external URL or local storage
                                                    $imageUrl = filter_var($blog->featured_image, FILTER_VALIDATE_URL) 
                                                        ? $blog->featured_image 
                                                        : asset('storage/' . $blog->featured_image);
                                                ?>
                                                <img src="<?php echo e($imageUrl); ?>"
                                                    alt="<?php echo e($blog->title); ?>" class="rounded"
                                                    style="width: 60px; height: 60px; object-fit: cover;">
                                            <?php else: ?>
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                    style="width: 60px; height: 60px;">
                                                    <i class="bx bx-image text-muted fs-4"></i>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div>
                                                <strong><?php echo e(Str::limit($blog->title, 30)); ?></strong>
                                            </div>
                                            <small class="text-muted"><?php echo e(Str::limit($blog->slug, 35)); ?></small>
                                        </td>
                                        <td><?php echo e($blog->author->name ?? __('admin.blogs.unknown')); ?></td>
                                        <td>
                                            <?php if($blog->category): ?>
                                                <span class="badge bg-label-info"><?php echo e($blog->category); ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <!-- <td>
                                            <i class="bx bx-show me-1"></i><?php echo e(number_format($blog->view_count)); ?>

                                        </td> -->
                                        <td>
                                            <?php if($blog->status === 'published'): ?>
                                                <span class="badge bg-success"><?php echo e(__('admin.blogs.published')); ?></span>
                                            <?php elseif($blog->status === 'draft'): ?>
                                                <span class="badge bg-warning"><?php echo e(__('admin.blogs.draft')); ?></span>
                                            <?php elseif($blog->status === 'unpublished'): ?>
                                                <span class="badge bg-secondary"><?php echo e(__('admin.blogs.unpublished')); ?></span>
                                            <?php elseif($blog->status === 'archived'): ?>
                                                <span class="badge bg-dark"><?php echo e(__('admin.blogs.archived')); ?></span>
                                            <?php else: ?>
                                                <span class="badge bg-danger"><?php echo e($blog->status ?: __('admin.blogs.unknown')); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($blog->published_at): ?>
                                                <?php echo e($blog->published_at->format('d M Y')); ?>

                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button"
                                                    class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item"
                                                        href="<?php echo e(route('admin.blogs.show', $blog->id)); ?>">
                                                        <i class="ti ti-eye me-2"></i> <?php echo e(__('admin.blogs.view')); ?>

                                                    </a>
                                                    <a class="dropdown-item"
                                                        href="<?php echo e(route('admin.blogs.edit', $blog->id)); ?>">
                                                        <i class="ti ti-pencil me-2"></i> <?php echo e(__('admin.blogs.edit')); ?>

                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <form action="<?php echo e(route('admin.blogs.destroy', $blog->id)); ?>"
                                                        method="POST" style="display: none;"
                                                        id="delete-blog-<?php echo e($blog->id); ?>">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                    </form>
                                                    <a class="dropdown-item text-danger" href="javascript:void(0);"
                                                        onclick="if(confirm('<?php echo e(__('admin.blogs.delete_confirm')); ?>')) document.getElementById('delete-blog-<?php echo e($blog->id); ?>').submit();">
                                                        <i class="ti ti-trash me-2"></i> <?php echo e(__('admin.blogs.delete')); ?>

                                                    </a>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        <?php echo e($blogs->appends(['status' => $status, 'category' => $category, 'search' => $search])->links()); ?>

                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="bx bx-news display-1 text-muted"></i>
                        <p class="mt-3 text-muted"><?php echo e(__('admin.blogs.no_blogs_found')); ?></p>
                        <a href="<?php echo e(route('admin.blogs.create')); ?>" class="btn btn-primary">
                            <i class="bx bx-plus me-1"></i> <?php echo e(__('admin.blogs.create_new_blog')); ?>

                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views/admin/blogs/index.blade.php ENDPATH**/ ?>