<?php $__env->startSection('title', __('admin.ratings.title') . ' - ' . $ebook->title); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold py-3 mb-0">
                    <span class="text-muted fw-light"><?php echo e(__('admin.ebooks.title')); ?> /</span> <?php echo e(__('admin.ratings.title')); ?>

                </h4>
                <small class="text-muted"><?php echo e($ebook->title); ?></small>
            </div>
            <div>
                <a href="<?php echo e(route('admin.ebooks.ratings.create', $ebook->id)); ?>" class="btn btn-primary me-2">
                    <i class="ti ti-plus me-1"></i> <?php echo e(__('admin.ratings.add_new')); ?>

                </a>
                <a href="<?php echo e(route('admin.ebooks.index')); ?>" class="btn btn-secondary">
                    <i class="ti ti-arrow-left me-1"></i> <?php echo e(__('admin.ratings.back_to_ebooks')); ?>

                </a>
            </div>
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

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-body text-center d-flex flex-column justify-content-center py-4">
                        <h1 class="mb-3 text-primary fw-bold"><?php echo e(number_format($stats['average'], 1)); ?></h1>
                        <div class="mb-3">
                            <?php for($i = 1; $i <= 5; $i++): ?>
                                <i class="ti ti-star<?php echo e($i <= round($stats['average']) ? '-filled text-warning' : ' text-muted'); ?> fs-4"></i>
                            <?php endfor; ?>
                        </div>
                        <p class="text-muted mb-0"><?php echo e(__('admin.ratings.average_rating')); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-body text-center d-flex flex-column justify-content-center py-4">
                        <h1 class="mb-3 fw-bold"><?php echo e($ebook->ratings()->count()); ?></h1>
                        <p class="text-muted mb-0"><?php echo e(__('admin.ratings.total_reviews')); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="mb-3"><?php echo e(__('admin.ratings.rating_distribution')); ?></h6>
                        <?php for($i = 5; $i >= 1; $i--): ?>
                            <?php
                                $count = $stats['distribution'][$i];
                                $percentage = $stats['total'] > 0 ? ($count / $stats['total']) * 100 : 0;
                            ?>
                            <div class="d-flex align-items-center mb-2">
                                <span class="me-2" style="width: 20px;"><?php echo e($i); ?></span>
                                <i class="ti ti-star-filled text-warning me-2"></i>
                                <div class="progress flex-grow-1" style="height: 10px;">
                                    <div class="progress-bar bg-warning" style="width: <?php echo e($percentage); ?>%"></div>
                                </div>
                                <span class="ms-2" style="width: 40px;"><?php echo e($count); ?></span>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ratings Table -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><?php echo e(__('admin.ratings.all_reviews')); ?></h5>
            </div>
            <div class="card-body">
                <?php if($ratings->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('admin.ratings.user')); ?></th>
                                    <th><?php echo e(__('admin.ratings.rating')); ?></th>
                                    <th><?php echo e(__('admin.ratings.review')); ?></th>
                                    <th><?php echo e(__('admin.ratings.status')); ?></th>
                                    <th><?php echo e(__('admin.ratings.date')); ?></th>
                                    <th><?php echo e(__('admin.ratings.actions')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $ratings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rating): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm me-2">
                                                    <span class="avatar-initial rounded-circle bg-label-primary">
                                                        <?php echo e(substr($rating->user->name ?? 'U', 0, 1)); ?>

                                                    </span>
                                                </div>
                                                <div>
                                                    <div class="fw-medium"><?php echo e($rating->user->name ?? __('admin.ebooks.unknown')); ?></div>
                                                    <small class="text-muted"><?php echo e($rating->user->email ?? '-'); ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <?php for($i = 1; $i <= 5; $i++): ?>
                                                    <i class="ti ti-star<?php echo e($i <= $rating->rating ? '-filled text-warning' : ' text-muted'); ?>" style="font-size: 14px;"></i>
                                                <?php endfor; ?>
                                                <span class="ms-2 badge bg-label-primary"><?php echo e($rating->rating); ?>/5</span>
                                            </div>
                                        </td>
                                        <td style="max-width: 300px;">
                                            <?php if($rating->review_title): ?>
                                                <div class="fw-medium"><?php echo e($rating->review_title); ?></div>
                                            <?php endif; ?>
                                            <?php if($rating->review_text): ?>
                                                <small class="text-muted"><?php echo e(Str::limit($rating->review_text, 100)); ?></small>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($rating->is_approved): ?>
                                                <span class="badge bg-success">
                                                    <i class="ti ti-check ti-xs"></i> <?php echo e(__('admin.ratings.approved')); ?>

                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-warning">
                                                    <i class="ti ti-clock ti-xs"></i> <?php echo e(__('admin.ratings.unapproved')); ?>

                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <small class="text-muted"><?php echo e($rating->created_at->format('d M Y')); ?></small>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button"
                                                    class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="<?php echo e(route('admin.ebooks.ratings.edit', [$ebook->id, $rating->id])); ?>">
                                                        <i class="ti ti-pencil me-2"></i> <?php echo e(__('admin.ratings.edit')); ?>

                                                    </a>
                                                    <form action="<?php echo e(route('admin.ebooks.ratings.toggle-approval', [$ebook->id, $rating->id])); ?>" method="POST" style="display: inline;">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PATCH'); ?>
                                                        <button type="submit" class="dropdown-item">
                                                            <?php if($rating->is_approved): ?>
                                                                <i class="ti ti-x me-2"></i> <?php echo e(__('admin.ratings.unapproved')); ?>

                                                            <?php else: ?>
                                                                <i class="ti ti-check me-2"></i> <?php echo e(__('admin.ratings.approved')); ?>

                                                            <?php endif; ?>
                                                        </button>
                                                    </form>
                                                    <div class="dropdown-divider"></div>
                                                    <form action="<?php echo e(route('admin.ebooks.ratings.destroy', [$ebook->id, $rating->id])); ?>" method="POST"
                                                        id="delete-rating-<?php echo e($rating->id); ?>" style="display: none;">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                    </form>
                                                    <a class="dropdown-item text-danger" href="javascript:void(0);"
                                                        onclick="if(confirm('<?php echo e(__('admin.ratings.delete_confirm')); ?>')) document.getElementById('delete-rating-<?php echo e($rating->id); ?>').submit();">
                                                        <i class="ti ti-trash me-2"></i> <?php echo e(__('admin.ratings.delete')); ?>

                                                    </a>
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
                        <?php echo e($ratings->links()); ?>

                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="ti ti-star-off" style="font-size: 48px; color: #ddd;"></i>
                        <p class="mt-2 text-muted"><?php echo e(__('admin.ratings.no_reviews')); ?></p>
                        <small class="text-muted d-block mb-3"><?php echo e(__('admin.ratings.no_reviews_description')); ?></small>
                        <a href="<?php echo e(route('admin.ebooks.ratings.create', $ebook->id)); ?>" class="btn btn-primary">
                            <i class="ti ti-plus me-1"></i> <?php echo e(__('admin.ratings.add_new')); ?>

                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\admin\ebooks\ratings\index.blade.php ENDPATH**/ ?>