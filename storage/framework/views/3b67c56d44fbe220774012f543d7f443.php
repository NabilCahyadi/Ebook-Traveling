<?php $__env->startSection('title', __('admin.blogs.details')); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">Admin / Blogs /</span> <?php echo e(__('admin.blogs.details')); ?>

            </h4>
            <div>
                <a href="<?php echo e(route('admin.blogs.edit', $blog->id)); ?>" class="btn btn-primary me-2">
                    <i class="bx bx-edit me-1"></i> <?php echo e(__('admin.blogs.edit')); ?>

                </a>
                <a href="<?php echo e(route('admin.blogs.index')); ?>" class="btn btn-secondary">
                    <i class="bx bx-arrow-back me-1"></i> <?php echo e(__('admin.blogs.back')); ?>

                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <?php if($blog->featured_image): ?>
                        <?php
                            // Check if image is external URL or local storage
                            $imageUrl = filter_var($blog->featured_image, FILTER_VALIDATE_URL) 
                                ? $blog->featured_image 
                                : asset('storage/' . $blog->featured_image);
                        ?>
                        <img src="<?php echo e($imageUrl); ?>" alt="<?php echo e($blog->title); ?>"
                            class="card-img-top" style="max-height: 400px; object-fit: cover;">
                    <?php endif; ?>

                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h3 class="card-title mb-2"><?php echo e($blog->title); ?></h3>
                                <div class="text-muted mb-2">
                                    <i class="bx bx-user me-1"></i> <?php echo e($blog->author->name ?? 'Unknown'); ?>

                                    <span class="mx-2">•</span>
                                    <i class="bx bx-calendar me-1"></i>
                                    <?php if($blog->published_at): ?>
                                        <?php echo e($blog->published_at->format('d M Y')); ?>

                                    <?php else: ?>
                                        <?php echo e(__('admin.blogs.not_published')); ?>

                                    <?php endif; ?>
                                    <span class="mx-2">•</span>
                                    <i class="bx bx-show me-1"></i> <?php echo e(number_format($blog->view_count)); ?> <?php echo e(__('admin.blogs.views')); ?>

                                </div>
                            </div>
                            <?php if($blog->status === 'published'): ?>
                                <span class="badge bg-success">Published</span>
                            <?php elseif($blog->status === 'draft'): ?>
                                <span class="badge bg-warning">Draft</span>
                            <?php elseif($blog->status === 'scheduled'): ?>
                                <span class="badge bg-info"><i class="ti ti-clock me-1"></i>Scheduled</span>
                            <?php elseif($blog->status === 'unpublished'): ?>
                                <span class="badge bg-secondary">Unpublished</span>
                            <?php else: ?>
                                <span class="badge bg-danger"><?php echo e($blog->status ?: 'Unknown'); ?></span>
                            <?php endif; ?>
                        </div>

                        <?php if($blog->category): ?>
                            <div class="mb-3">
                                <span class="badge bg-label-info"><?php echo e($blog->category); ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if($blog->excerpt): ?>
                            <div class="alert alert-info">
                                <strong><?php echo e(__('admin.blogs.excerpt')); ?>:</strong> <?php echo e($blog->excerpt); ?>

                            </div>
                        <?php endif; ?>

                        <hr>

                        <div class="blog-content">
                            <?php echo $blog->content; ?>

                        </div>

                        <?php if($blog->tags && (is_array($blog->tags) ? count($blog->tags) > 0 : !empty($blog->tags))): ?>
                            <hr>
                            <div class="mt-3">
                                <strong><?php echo e(__('admin.blogs.tags')); ?>:</strong>
                                <?php if(is_array($blog->tags)): ?>
                                    <?php $__currentLoopData = $blog->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="badge bg-label-secondary me-1"><?php echo e($tag); ?></span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <?php $__currentLoopData = explode(',', $blog->tags); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="badge bg-label-secondary me-1"><?php echo e(trim($tag)); ?></span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><?php echo e(__('admin.blogs.blog_information')); ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted d-block mb-1"><?php echo e(__('admin.blogs.slug')); ?></small>
                            <code><?php echo e($blog->slug); ?></code>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block mb-1"><?php echo e(__('admin.blogs.author')); ?></small>
                            <p class="mb-0"><?php echo e($blog->author->name ?? __('admin.blogs.unknown')); ?></p>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block mb-1"><?php echo e(__('admin.blogs.category')); ?></small>
                            <?php if($blog->category): ?>
                                <span class="badge bg-label-info"><?php echo e($blog->category); ?></span>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block mb-1"><?php echo e(__('admin.blogs.status')); ?></small>
                            <?php if($blog->status === 'published'): ?>
                                <span class="badge bg-success"><?php echo e(__('admin.blogs.published')); ?></span>
                            <?php elseif($blog->status === 'draft'): ?>
                                <span class="badge bg-warning"><?php echo e(__('admin.blogs.draft')); ?></span>
                            <?php elseif($blog->status === 'scheduled'): ?>
                                <span class="badge bg-info"><i class="ti ti-clock me-1"></i>Scheduled</span>
                            <?php elseif($blog->status === 'unpublished'): ?>
                                <span class="badge bg-secondary"><?php echo e(__('admin.blogs.unpublished')); ?></span>
                            <?php else: ?>
                                <span class="badge bg-danger"><?php echo e($blog->status ?: __('admin.blogs.unknown')); ?></span>
                            <?php endif; ?>
                        </div>

                        <?php if($blog->published_at): ?>
                            <div class="mb-3">
                                <small class="text-muted d-block mb-1"><?php echo e(__('admin.blogs.published_at')); ?></small>
                                <p class="mb-0"><?php echo e($blog->published_at->format('d M Y, H:i')); ?></p>
                            </div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <small class="text-muted d-block mb-1"><?php echo e(__('admin.blogs.created_at')); ?></small>
                            <p class="mb-0"><?php echo e($blog->created_at->format('d M Y, H:i')); ?></p>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block mb-1"><?php echo e(__('admin.blogs.last_updated')); ?></small>
                            <p class="mb-0"><?php echo e($blog->updated_at->format('d M Y, H:i')); ?></p>
                        </div>

                        <?php if($blog->tags && (is_array($blog->tags) ? count($blog->tags) > 0 : !empty($blog->tags))): ?>
                            <div class="mb-3">
                                <small class="text-muted d-block mb-1"><?php echo e(__('admin.blogs.tags')); ?></small>
                                <div>
                                    <?php if(is_array($blog->tags)): ?>
                                        <?php $__currentLoopData = $blog->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="badge bg-label-secondary me-1 mb-1"><?php echo e($tag); ?></span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <?php $__currentLoopData = explode(',', $blog->tags); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="badge bg-label-secondary me-1 mb-1"><?php echo e(trim($tag)); ?></span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><?php echo e(__('admin.blogs.statistics')); ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="badge bg-label-primary rounded p-2 me-3">
                                <i class="bx bx-show fs-4"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block"><?php echo e(__('admin.blogs.total_views')); ?></small>
                                <h5 class="mb-0"><?php echo e(number_format($blog->view_count)); ?></h5>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex align-items-center mb-3">
                            <div class="badge bg-label-info rounded p-2 me-3">
                                <i class="bx bx-file fs-4"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block"><?php echo e(__('admin.blogs.content_length')); ?></small>
                                <h6 class="mb-0"><?php echo e(number_format(strlen(strip_tags($blog->content)))); ?> <?php echo e(__('admin.blogs.characters')); ?></h6>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="badge bg-label-success rounded p-2 me-3">
                                <i class="bx bx-time fs-4"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block"><?php echo e(__('admin.blogs.reading_time')); ?></small>
                                <h6 class="mb-0"><?php echo e(ceil(str_word_count(strip_tags($blog->content)) / 200)); ?> <?php echo e(__('admin.blogs.min_read')); ?>

                                </h6>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><?php echo e(__('admin.blogs.actions')); ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="<?php echo e(route('admin.blogs.edit', $blog->id)); ?>" class="btn btn-primary">
                                <i class="bx bx-edit me-1"></i> <?php echo e(__('admin.blogs.edit_blog')); ?>

                            </a>
                            <form action="<?php echo e(route('admin.blogs.destroy', $blog->id)); ?>" method="POST"
                                onsubmit="return confirm('<?php echo e(__('admin.blogs.delete_confirm')); ?>');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger w-100">
                                <i class="bx bx-trash me-1"></i> <?php echo e(__('admin.blogs.delete_blog')); ?>

                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('styles'); ?>
        <style>
            .blog-content {
                line-height: 1.8;
            }

            .blog-content img {
                max-width: 100%;
                height: auto;
            }

            .blog-content h1,
            .blog-content h2,
            .blog-content h3,
            .blog-content h4,
            .blog-content h5,
            .blog-content h6 {
                margin-top: 1.5rem;
                margin-bottom: 1rem;
            }

            .blog-content p {
                margin-bottom: 1rem;
            }

            .blog-content ul,
            .blog-content ol {
                margin-bottom: 1rem;
                padding-left: 2rem;
            }
        </style>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\admin\blogs\show.blade.php ENDPATH**/ ?>