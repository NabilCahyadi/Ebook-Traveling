<?php $__env->startSection('title', 'Ebooks Pending Approval'); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        /* Cover preview di tabel dengan ratio 1:1.6 */
        .table .ebook-cover-preview {
            width: 40px;
            height: 64px;
            /* 40 * 1.6 = 64 */
            object-fit: cover;
        }

        /* Cover preview di modal dengan ratio 1:1.6 */
        .modal-cover-wrapper {
            width: 100%;
            max-width: 280px;
            aspect-ratio: 1 / 1.6;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .modal-cover-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .modal-cover-placeholder {
            width: 100%;
            max-width: 280px;
            aspect-ratio: 1 / 1.6;
            background: linear-gradient(135deg, #f5f7fa 0%, #e8eef5 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold py-3 mb-2">
                <span class="text-muted fw-light">Ebook Management /</span> Pending Approval
            </h4>
        </div>
        <div>
            <a href="<?php echo e(route('admin.ebooks.index')); ?>" class="btn btn-secondary">
                <i class="ti ti-arrow-left me-1"></i> Back to All Ebooks
            </a>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ti ti-check me-2"></i><?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="ti ti-alert-triangle me-2"></i><?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Statistics Card -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="badge bg-label-warning p-2 me-3 rounded">
                            <i class="ti ti-clock-hour-4 ti-md"></i>
                        </div>
                        <div class="card-info">
                            <h5 class="card-title mb-0"><?php echo e($ebooks->total()); ?> Ebook(s)</h5>
                            <small class="text-muted">Waiting for approval</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ebooks Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Ebooks Pending Approval</h5>
        </div>
        <div class="card-body">
            <?php if($ebooks->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Cover</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Category</th>
                                <th>City</th>
                                <th>Submitted By</th>
                                <th>Submitted At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $ebooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ebook): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <?php if($ebook->cover_image_url): ?>
                                            <img src="<?php echo e($ebook->cover_image_url); ?>"
                                                alt="<?php echo e($ebook->title); ?>" class="rounded ebook-cover-preview">
                                        <?php else: ?>
                                            <div class="bg-label-secondary rounded d-flex align-items-center justify-content-center"
                                                style="width: 40px; height: 64px;">
                                                <i class="ti ti-book"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="fw-semibold"><?php echo e($ebook->title); ?></div>
                                        <small class="text-muted"><?php echo e(Str::limit($ebook->description, 50)); ?></small>
                                    </td>
                                    <td><?php echo e($ebook->author); ?></td>
                                    <td>
                                        <?php if($ebook->category): ?>
                                            <span class="badge bg-label-primary"><?php echo e($ebook->category->name); ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($ebook->city): ?>
                                            <span class="badge bg-label-info"><?php echo e($ebook->city->name); ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($ebook->creator): ?>
                                            <div><?php echo e($ebook->creator->name); ?></div>
                                            <small class="text-muted"><?php echo e($ebook->creator->email); ?></small>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div><?php echo e($ebook->created_at->format('d M Y')); ?></div>
                                        <small class="text-muted"><?php echo e($ebook->created_at->format('H:i')); ?></small>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <!-- Preview Button -->
                                            <button type="button" class="btn btn-sm btn-icon btn-outline-info"
                                                data-bs-toggle="modal" data-bs-target="#previewModal<?php echo e($ebook->id); ?>"
                                                title="Preview">
                                                <i class="ti ti-eye"></i>
                                            </button>

                                            <!-- Approve Button -->
                                            <form action="<?php echo e(route('admin.ebooks.approve', $ebook->id)); ?>" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Approve ebook: <?php echo e($ebook->title); ?>?')">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-sm btn-icon btn-success"
                                                    title="Approve">
                                                    <i class="ti ti-check"></i>
                                                </button>
                                            </form>

                                            <!-- Reject Button -->
                                            <form action="<?php echo e(route('admin.ebooks.reject', $ebook->id)); ?>" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Reject ebook: <?php echo e($ebook->title); ?>?')">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-sm btn-icon btn-danger"
                                                    title="Reject">
                                                    <i class="ti ti-x"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Preview Modal -->
                                <div class="modal fade" id="previewModal<?php echo e($ebook->id); ?>" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Preview Ebook</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <?php if($ebook->cover_image_url): ?>
                                                            <div class="modal-cover-wrapper">
                                                                <img src="<?php echo e($ebook->cover_image_url); ?>"
                                                                    alt="<?php echo e($ebook->title); ?>">
                                                            </div>
                                                        <?php else: ?>
                                                            <div class="modal-cover-placeholder">
                                                                <i class="ti ti-book"
                                                                    style="font-size: 4rem; color: #cbd5e1;"></i>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <h4 class="mb-3"><?php echo e($ebook->title); ?></h4>
                                                        <div class="mb-2">
                                                            <strong>Author:</strong> <?php echo e($ebook->author); ?>

                                                        </div>
                                                        <div class="mb-2">
                                                            <strong>Category:</strong>
                                                            <?php if($ebook->category): ?>
                                                                <span
                                                                    class="badge bg-label-primary"><?php echo e($ebook->category->name); ?></span>
                                                            <?php else: ?>
                                                                <span class="text-muted">-</span>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="mb-2">
                                                            <strong>City:</strong>
                                                            <?php if($ebook->city): ?>
                                                                <span
                                                                    class="badge bg-label-info"><?php echo e($ebook->city->name); ?></span>
                                                            <?php else: ?>
                                                                <span class="text-muted">-</span>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="mb-2">
                                                            <strong>Page Count:</strong> <?php echo e($ebook->page_count ?? '-'); ?>

                                                        </div>
                                                        <div class="mb-3">
                                                            <strong>Description:</strong>
                                                            <p class="mt-2"><?php echo e($ebook->description); ?></p>
                                                        </div>
                                                        <div class="mb-2">
                                                            <strong>Submitted By:</strong>
                                                            <?php if($ebook->creator): ?>
                                                                <?php echo e($ebook->creator->name); ?> (<?php echo e($ebook->creator->email); ?>)
                                                            <?php else: ?>
                                                                -
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="mb-2">
                                                            <strong>Submitted At:</strong>
                                                            <?php echo e($ebook->created_at->format('d M Y H:i')); ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <form action="<?php echo e(route('admin.ebooks.reject', $ebook->id)); ?>"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Reject ebook: <?php echo e($ebook->title); ?>?')">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="ti ti-x me-1"></i>Reject
                                                    </button>
                                                </form>
                                                <form action="<?php echo e(route('admin.ebooks.approve', $ebook->id)); ?>"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Approve ebook: <?php echo e($ebook->title); ?>?')">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="ti ti-check me-1"></i>Approve
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    <?php echo e($ebooks->links()); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="ti ti-inbox" style="font-size: 4rem; color: #ddd;"></i>
                    </div>
                    <h5 class="text-muted">No ebooks pending approval</h5>
                    <p class="text-muted">All submissions have been reviewed</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\admin\ebooks\pending-approval.blade.php ENDPATH**/ ?>