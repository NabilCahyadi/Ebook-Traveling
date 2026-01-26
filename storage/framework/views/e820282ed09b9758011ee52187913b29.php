<?php $__env->startSection('title', __('admin.ebooks.ebook_details')); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        /* Cover Image - Fixed ratio 1:1.6 untuk ebook */
        .ebook-cover-wrapper {
            position: relative;
            width: 100%;
            height: 0;
            padding-bottom: 160%; /* Ratio 1:1.6 */
            background: #f5f5f9;
            border-radius: 8px;
            overflow: hidden;
        }

        .ebook-cover-img {
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
            object-position: center !important;
        }

        .no-image-placeholder {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: #a8aaae;
            font-size: 48px;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h4 class="fw-bold mb-1"><?php echo e(__('admin.ebooks.ebook_details')); ?></h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo e(route('admin.ebooks.index')); ?>"><?php echo e(__('admin.ebooks.title')); ?></a></li>
                            <li class="breadcrumb-item active"><?php echo e(Str::limit($ebook->title, 30)); ?></li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex gap-2">
                    <a href="<?php echo e(route('admin.ebooks.edit', $ebook->id)); ?>" class="btn btn-primary">
                        <i class="bx bx-edit-alt me-1"></i> <?php echo e(__('admin.ebooks.edit')); ?>

                    </a>
                    <a href="<?php echo e(route('admin.ebooks.index')); ?>" class="btn btn-secondary">
                        <i class="bx bx-arrow-back me-1"></i> <?php echo e(__('admin.ebooks.back')); ?>

                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Ebook Title Card -->
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                        <div>
                            <h3 class="card-title mb-2"><?php echo e($ebook->title); ?></h3>
                            <p class="text-muted mb-0">
                                <i class="bx bx-user me-1"></i> <?php echo e($ebook->author ?? __('admin.ebooks.unknown_author')); ?>

                            </p>
                        </div>
                        <div>
                            <?php if($ebook->status === 'published'): ?>
                                <span class="badge bg-success">
                                    <i class="bx bx-check-circle"></i> <?php echo e(__('admin.ebooks.published')); ?>

                                </span>
                            <?php elseif($ebook->status === 'draft'): ?>
                                <span class="badge bg-warning">
                                    <i class="bx bx-time"></i> <?php echo e(__('admin.ebooks.draft')); ?>

                                </span>
                            <?php elseif($ebook->status === 'scheduled'): ?>
                                <span class="badge bg-info">
                                    <i class="ti ti-clock"></i> <?php echo e(__('admin.ebooks.scheduled')); ?>

                                    <?php if($ebook->published_at): ?>
                                        <small class="ms-1">(<?php echo e($ebook->published_at->format('d M Y, H:i')); ?>)</small>
                                    <?php endif; ?>
                                </span>
                            <?php elseif($ebook->status === 'unpublished'): ?>
                                <span class="badge bg-secondary">
                                    <i class="bx bx-eye-off"></i> <?php echo e(__('admin.ebooks.unpublished')); ?>

                                </span>
                            <?php else: ?>
                                <span class="badge bg-secondary">
                                    <i class="bx bx-help-circle"></i> <?php echo e(ucfirst($ebook->status)); ?>

                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Left Sidebar - Cover and Stats -->
        <div class="col-lg-4">
            <!-- Cover Image -->
            <div class="card mb-3">
                <div class="card-body text-center">
                    <div style="max-width: 280px; margin: 0 auto;">
                        <div class="ebook-cover-wrapper">
                            <?php if($ebook->cover_image_url): ?>
                                <img src="<?php echo e($ebook->cover_image_url); ?>" alt="<?php echo e($ebook->title); ?>" class="ebook-cover-img">
                            <?php else: ?>
                                <div class="no-image-placeholder">
                                    <i class="bx bx-book"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <i class="bx bx-bar-chart-alt-2 me-2"></i>
                    <h5 class="mb-0"><?php echo e(__('admin.ebooks.statistics')); ?></h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="text-muted"><i class="bx bx-show me-1"></i> <?php echo e(__('admin.ebooks.views')); ?></span>
                            <strong><?php echo e(number_format($ebook->view_count ?? 0)); ?></strong>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="text-muted"><i class="bx bx-book-reader me-1"></i> Reads</span>
                            <strong><?php echo e(number_format($ebook->read_count ?? 0)); ?></strong>
                        </div>
                    </div>

                    <div class="mb-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="text-muted"><i class="bx bx-star me-1"></i> Rating</span>
                            <div>
                                <?php if(($ebook->average_rating ?? 0) > 0): ?>
                                    <strong><?php echo e(number_format($ebook->average_rating, 1)); ?></strong>
                                    <?php if(($ebook->total_reviews ?? 0) > 0): ?>
                                        <small class="text-muted">(<?php echo e($ebook->total_reviews); ?>)</small>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="text-muted">N/A</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Content -->
        <div class="col-lg-8">

            <!-- Ebook Information -->
            <div class="card mb-3">
                <div class="card-header d-flex align-items-center">
                    <i class="bx bx-info-circle me-2"></i>
                    <h5 class="mb-0"><?php echo e(__('admin.ebooks.ebook_info')); ?></h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td class="fw-semibold" style="width: 200px;"><?php echo e(__('admin.ebooks.category')); ?></td>
                            <td>
                                <?php if($ebook->category): ?>
                                    <span class="badge bg-label-info"><?php echo e($ebook->category->name); ?></span>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-semibold"><?php echo e(__('admin.ebooks.city')); ?></td>
                            <td>
                                <?php if($ebook->city): ?>
                                    <span class="badge bg-label-primary">
                                        <i class="bx bx-map me-1"></i><?php echo e($ebook->city->name); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-semibold"><?php echo e(__('admin.ebooks.total_pages')); ?> (PDF)</td>
                            <td>
                                <?php if($ebook->total_pages): ?>
                                    <span class="badge bg-label-success">
                                        <i class="bx bx-file-blank me-1"></i><?php echo e($ebook->total_pages); ?> <?php echo e(__('admin.ebooks.pages')); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Page Count</td>
                            <td>
                                <i class="bx bx-file me-1"></i><?php echo e($ebook->page_count ?? '-'); ?> <?php echo e(__('admin.ebooks.pages')); ?>

                            </td>
                        </tr>
                        <tr>
                            <td class="fw-semibold"><?php echo e(__('admin.ebooks.creator')); ?></td>
                            <td>
                                <i class="bx bx-user me-1"></i><?php echo e($ebook->creator->name ?? '-'); ?>

                            </td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Published At</td>
                            <td>
                                <i class="bx bx-calendar me-1"></i>
                                <?php echo e($ebook->published_at ? $ebook->published_at->format('d M Y, H:i') : '-'); ?>

                            </td>
                        </tr>
                        <tr>
                            <td class="fw-semibold"><?php echo e(__('admin.ebooks.created_date')); ?></td>
                            <td>
                                <i class="bx bx-time me-1"></i><?php echo e($ebook->created_at->format('d M Y, H:i')); ?>

                            </td>
                        </tr>
                        <tr>
                            <td class="fw-semibold"><?php echo e(__('admin.ebooks.last_update')); ?></td>
                            <td>
                                <i class="bx bx-refresh me-1"></i><?php echo e($ebook->updated_at->format('d M Y, H:i')); ?>

                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Description -->
            <div class="card mb-3">
                <div class="card-header d-flex align-items-center">
                    <i class="bx bx-detail me-2"></i>
                    <h5 class="mb-0"><?php echo e(__('admin.ebooks.description')); ?></h5>
                </div>
                <div class="card-body">
                    <div class="mb-0">
                        <?php echo $ebook->description ?? '<p class="text-muted">' . __('admin.ebooks.no_data') . '</p>'; ?>

                    </div>
                </div>
            </div>

            <!-- Ebook File -->
            <?php if($ebook->file_url): ?>
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <i class="bx bx-file me-2"></i>
                        <h5 class="mb-0"><?php echo e(__('admin.ebooks.file_pdf')); ?></h5>
                    </div>
                    <div class="card-body text-center">
                        <i class="bx bxs-file-pdf text-danger mb-2" style="font-size: 48px;"></i>
                        <h6 class="fw-bold mb-1"><?php echo e(basename($ebook->file_url)); ?></h6>
                        <p class="text-muted mb-3">PDF Document</p>
                        <a href="<?php echo e(asset('storage/' . $ebook->file_url)); ?>" target="_blank" class="btn btn-primary">
                            <i class="bx bx-download me-1"></i> <?php echo e(__('admin.ebooks.download')); ?>

                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\admin\ebooks\show.blade.php ENDPATH**/ ?>