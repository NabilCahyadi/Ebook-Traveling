<?php $__env->startSection('title', __('admin.reports.ebook_performance')); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mb-2">
                        <li class="breadcrumb-item">
                            <a href="<?php echo e(route('admin.reports.index')); ?>"><?php echo e(__('admin.reports.title')); ?></a>
                        </li>
                        <li class="breadcrumb-item active"><?php echo e(__('admin.reports.ebook_performance')); ?></li>
                    </ol>
                </nav>
                <h4 class="mb-1"><?php echo e(__('admin.reports.ebook_performance')); ?></h4>
                <p class="text-muted mb-0"><?php echo e(__('admin.reports.ebook_performance_subtitle')); ?></p>
            </div>
        </div>

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="<?php echo e(route('admin.reports.ebook-performance')); ?>" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label"><?php echo e(__('admin.reports.time_period')); ?></label>
                        <select name="filter" class="form-select" onchange="this.form.submit()">
                            <option value="all" <?php echo e($filter === 'all' ? 'selected' : ''); ?>><?php echo e(__('admin.reports.all_time')); ?></option>
                            <option value="month" <?php echo e($filter === 'month' ? 'selected' : ''); ?>><?php echo e(__('admin.reports.last_30_days')); ?></option>
                            <option value="week" <?php echo e($filter === 'week' ? 'selected' : ''); ?>><?php echo e(__('admin.reports.last_7_days')); ?></option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"><?php echo e(__('admin.reports.sort_by')); ?></label>
                        <select name="sort" class="form-select" onchange="this.form.submit()">
                            <option value="reads" <?php echo e($sortBy === 'reads' ? 'selected' : ''); ?>><?php echo e(__('admin.reports.most_read')); ?></option>
                            <option value="views" <?php echo e($sortBy === 'views' ? 'selected' : ''); ?>><?php echo e(__('admin.reports.most_viewed')); ?></option>
                            <option value="rating" <?php echo e($sortBy === 'rating' ? 'selected' : ''); ?>><?php echo e(__('admin.reports.highest_rated')); ?></option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <a href="<?php echo e(route('admin.reports.ebook-performance')); ?>" class="btn btn-outline-secondary">
                            <?php echo e(__('admin.reports.reset')); ?>

                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="text-primary mb-2"><?php echo e(number_format($totalEbooks)); ?></h3>
                        <p class="text-muted mb-0"><?php echo e(__('admin.reports.total_ebooks')); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="text-success mb-2"><?php echo e(number_format($activeEbooks)); ?></h3>
                        <p class="text-muted mb-0"><?php echo e(__('admin.reports.active_ebooks')); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="text-info mb-2"><?php echo e(number_format($totalReads)); ?></h3>
                        <p class="text-muted mb-0"><?php echo e(__('admin.reports.total_reads')); ?></p>
                        <small class="text-muted"><?php echo e(number_format($totalViews)); ?> <?php echo e(__('admin.reports.views')); ?></small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Performing Ebooks -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><?php echo e(__('admin.reports.most_popular_ebooks')); ?></h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo e(__('admin.reports.ebook')); ?></th>
                                <th><?php echo e(__('admin.reports.category')); ?></th>
                                <th><?php echo e(__('admin.reports.city')); ?></th>
                                <th><?php echo e(__('admin.reports.reads')); ?></th>
                                <th><?php echo e(__('admin.reports.views')); ?></th>
                                <th><?php echo e(__('admin.reports.rating')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $topEbooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $ebook): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($index + 1); ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if($ebook->cover_image): ?>
                                                <img src="<?php echo e($ebook->cover_image_url); ?>" 
                                                     alt="<?php echo e($ebook->title); ?>" 
                                                     class="rounded me-2"
                                                     style="width: 40px; height: 60px; object-fit: cover;">
                                            <?php endif; ?>
                                            <div>
                                                <strong><?php echo e(Str::limit($ebook->title, 30)); ?></strong>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?php echo e($ebook->category->name ?? '-'); ?></td>
                                    <td><?php echo e($ebook->city->name ?? '-'); ?></td>
                                    <td><strong><?php echo e(number_format($ebook->read_count ?? 0)); ?></strong></td>
                                    <td><?php echo e(number_format($ebook->view_count ?? 0)); ?></td>
                                    <td>
                                        <?php
                                            $avgRating = $ebook->ratings_avg_rating ?? 0;
                                        ?>
                                        <span class="badge bg-label-<?php echo e($avgRating >= 4 ? 'success' : ($avgRating >= 3 ? 'warning' : 'danger')); ?>">
                                            ⭐ <?php echo e(number_format($avgRating, 1)); ?>

                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted">
                                        <?php echo e(__('admin.reports.no_data')); ?>

                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Low Performing Ebooks (Active but No Sales) -->
        <?php if($lowPerformingEbooks->count() > 0): ?>
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><?php echo e(__('admin.reports.low_engagement_ebooks')); ?></h5>
                    <small class="text-muted"><?php echo e(__('admin.reports.low_views_desc')); ?></small>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('admin.reports.ebook')); ?></th>
                                    <th><?php echo e(__('admin.reports.category')); ?></th>
                                    <th><?php echo e(__('admin.reports.city')); ?></th>
                                    <th><?php echo e(__('admin.reports.reads')); ?></th>
                                    <th><?php echo e(__('admin.reports.views')); ?></th>
                                    <th><?php echo e(__('admin.reports.rating')); ?></th>
                                    <th><?php echo e(__('admin.reports.action')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $lowPerformingEbooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ebook): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <?php if($ebook->cover_image): ?>
                                                    <img src="<?php echo e($ebook->cover_image_url); ?>" 
                                                         alt="<?php echo e($ebook->title); ?>" 
                                                         class="rounded me-2"
                                                         style="width: 40px; height: 60px; object-fit: cover;">
                                                <?php endif; ?>
                                                <div>
                                                    <strong><?php echo e(Str::limit($ebook->title, 30)); ?></strong>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?php echo e($ebook->category->name ?? '-'); ?></td>
                                        <td><?php echo e($ebook->city->name ?? '-'); ?></td>
                                        <td><strong><?php echo e(number_format($ebook->read_count ?? 0)); ?></strong></td>
                                        <td><?php echo e(number_format($ebook->view_count ?? 0)); ?></td>
                                        <td>
                                            <?php
                                                $avgRating = $ebook->ratings_avg_rating ?? 0;
                                            ?>
                                            <?php if($avgRating > 0): ?>
                                                <span class="badge bg-label-warning">⭐ <?php echo e(number_format($avgRating, 1)); ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route('admin.ebooks.edit', $ebook->id)); ?>" 
                                               class="btn btn-sm btn-icon btn-text-secondary">
                                                <i class="ti ti-pencil"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\admin\reports\ebook-performance.blade.php ENDPATH**/ ?>