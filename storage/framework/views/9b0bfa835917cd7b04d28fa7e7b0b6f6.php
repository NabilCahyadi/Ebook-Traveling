<?php $__env->startSection('title', 'Contact Info Management'); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        .contact-icon {
            font-size: 2rem;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
        }

        .action-buttons {
            gap: 0.25rem;
        }

        .badge-active {
            background-color: #28a745;
        }

        .badge-inactive {
            background-color: #6c757d;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Header -->
    <div class="mb-4">
        <h4 class="fw-bold mb-1">
            <span class="text-muted fw-light">Website Management /</span> Contact Info
        </h4>
        <p class="mb-0">Kelola informasi kontak dan media sosial</p>
    </div>

    <!-- Success/Error Messages -->
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Info Alert -->
    <div class="alert alert-info d-flex align-items-center" role="alert">
        <i class="ti ti-info-circle me-2"></i>
        <div>
            <strong>Tips:</strong> Contact Info digunakan untuk menampilkan informasi kontak di footer dan halaman Contact Us.
        </div>
    </div>

    <!-- Contact Info Cards -->
    <div class="row">
        <?php $__empty_1 = true; $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-start mb-3">
                            <div class="contact-icon bg-label-primary me-3">
                                <i class="<?php echo e($contact->icon_class ?? 'ti ti-mail'); ?>"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-1"><?php echo e($contact->title); ?></h5>
                                <span class="badge <?php echo e($contact->is_active ? 'badge-active' : 'badge-inactive'); ?> mb-1">
                                    <?php echo e($contact->is_active ? 'Active' : 'Inactive'); ?>

                                </span>
                                <?php if($contact->show_in_contact_page): ?>
                                    <span class="badge bg-info">Contact Page</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- <p class="text-muted mb-2">
                            <strong>Type:</strong> <?php echo e(ucfirst($contact->contact_type)); ?>

                        </p> -->

                        <?php if($contact->description): ?>
                            <p class="text-muted mb-2"><?php echo e(Str::limit($contact->description, 80)); ?></p>
                        <?php endif; ?>

                        <?php if($contact->link): ?>
                            <div class="mb-3">
                                <p class="text-muted mb-1">
                                    <strong>Link:</strong>
                                </p>
                                <a href="<?php echo e($contact->link); ?>" target="_blank" class="text-primary text-truncate d-block" style="max-width: 100%;">
                                    <?php echo e($contact->link); ?>

                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="d-flex action-buttons gap-2">
                            <a href="<?php echo e(route('admin.contact-info.edit', $contact->id)); ?>" 
                               class="btn btn-sm btn-label-primary" title="Edit">
                                <i class="ti ti-pencil"></i> Edit
                            </a>
                            <button type="button" 
                                    class="btn btn-sm btn-label-<?php echo e($contact->is_active ? 'warning' : 'success'); ?> toggle-active" 
                                    data-id="<?php echo e($contact->id); ?>"
                                    data-status="<?php echo e($contact->is_active); ?>"
                                    title="Toggle Status">
                                <i class="ti ti-toggle-<?php echo e($contact->is_active ? 'right' : 'left'); ?>"></i>
                                <?php echo e($contact->is_active ? 'Disable' : 'Enable'); ?>

                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="ti ti-address-book" style="font-size: 4rem; color: #ddd;"></i>
                        <p class="text-muted mt-3 mb-0">Belum ada contact info. Tambahkan yang pertama!</p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        // Toggle Active Status
        document.querySelectorAll('.toggle-active').forEach(button => {
            button.addEventListener('click', function() {
                const contactId = this.dataset.id;
                const isActive = this.dataset.status === '1';

                if (confirm(`Apakah Anda yakin ingin ${isActive ? 'menonaktifkan' : 'mengaktifkan'} contact info ini?`)) {
                    fetch(`/admin/contact-info/${contactId}/toggle-active`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('Error: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mengubah status');
                    });
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views/admin/contact-info/index.blade.php ENDPATH**/ ?>