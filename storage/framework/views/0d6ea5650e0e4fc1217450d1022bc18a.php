<?php $__env->startSection('title', 'Archived Blogs'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">Admin / Blogs /</span> Archived
            </h4>
            <a href="<?php echo e(route('admin.blogs.index')); ?>" class="btn btn-outline-secondary">
                <i class="bx bx-arrow-back me-1"></i> Back to All Blogs
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
                <h5 class="mb-3">Archived Blogs</h5>

                <!-- Search Section -->
                <form method="GET" action="<?php echo e(route('admin.blogs.archived')); ?>" class="row g-3">
                    <div class="col-md-10">
                        <label for="search" class="form-label">Search</label>
                        <input type="text" class="form-control" id="search" name="search"
                            placeholder="Search archived blogs..." value="<?php echo e($search ?? ''); ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-search-alt me-1"></i> Search
                            </button>
                            <?php if($search): ?>
                                <a href="<?php echo e(route('admin.blogs.archived')); ?>" class="btn btn-outline-secondary">
                                    <i class="bx bx-x"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>

                <!-- Stats -->
                <div class="mt-3">
                    <span class="badge bg-dark"><?php echo e($blogs->total()); ?> Archived</span>
                </div>
            </div>
            <div class="card-body">
                <?php if($blogs->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Category</th>
                                    <th>Views</th>
                                    <th>Archived Date</th>
                                    <th>Actions</th>
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
                                                <strong><?php echo e(Str::limit($blog->title, 50)); ?></strong>
                                            </div>
                                            <small class="text-muted"><?php echo e($blog->slug); ?></small>
                                        </td>
                                        <td><?php echo e($blog->author->name ?? 'Unknown'); ?></td>
                                        <td>
                                            <?php if($blog->category): ?>
                                                <span class="badge bg-label-info"><?php echo e($blog->category); ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <i class="bx bx-show me-1"></i><?php echo e(number_format($blog->view_count)); ?>

                                        </td>
                                        <td>
                                            <?php echo e($blog->updated_at->format('d M Y')); ?>

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
                                                        <i class="ti ti-eye me-2"></i> View
                                                    </a>
                                                    <a class="dropdown-item"
                                                        href="<?php echo e(route('admin.blogs.edit', $blog->id)); ?>">
                                                        <i class="ti ti-pencil me-2"></i> Edit
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <form action="<?php echo e(route('admin.blogs.destroy', $blog->id)); ?>"
                                                        method="POST" style="display: none;"
                                                        id="delete-blog-<?php echo e($blog->id); ?>">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                    </form>
                                                    <a class="dropdown-item text-danger" href="javascript:void(0);"
                                                        onclick="if(confirm('Are you sure you want to permanently delete this archived blog?')) document.getElementById('delete-blog-<?php echo e($blog->id); ?>').submit();">
                                                        <i class="ti ti-trash me-2"></i> Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        <?php echo e($blogs->appends(['search' => $search])->links()); ?>

                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="bx bx-archive display-1 text-muted"></i>
                        <p class="mt-3 text-muted">No archived blogs found.</p>
                        <a href="<?php echo e(route('admin.blogs.index')); ?>" class="btn btn-outline-secondary">
                            <i class="bx bx-arrow-back me-1"></i> Back to All Blogs
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views/admin/blogs/archived.blade.php ENDPATH**/ ?>