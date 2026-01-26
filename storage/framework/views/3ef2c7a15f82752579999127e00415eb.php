<?php $__env->startSection('title', 'Contact Info Management'); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        /* Override warna primary menggunakan warna brand MeatMap */
        .bg-label-primary {
            background-color: rgba(255, 76, 97, 0.12) !important;
            color: #ff4c61 !important;
        }

        .contact-icon {
            font-size: 1.5rem;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
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

    <?php if($errors->any()): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> Terdapat kesalahan pada input Anda.
            <ul class="mb-0 mt-2">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
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

    <!-- Contact Info Form -->
    <form action="<?php echo e(route('admin.contact-info.update-all')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="row">
            <?php $__empty_1 = true; $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-start mb-3">
                                <div class="contact-icon bg-label-primary me-3">
                                    <i class="<?php echo e($contact->icon_class ?? 'ti ti-mail'); ?>"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-1"><?php echo e($contact->title); ?></h5>
                                    <span class="badge <?php echo e($contact->is_active ? 'badge-active' : 'badge-inactive'); ?>">
                                        <?php echo e($contact->is_active ? 'Active' : 'Inactive'); ?>

                                    </span>
                                    <?php if($contact->show_in_contact_page): ?>
                                        <span class="badge bg-info">Contact Page</span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <input type="hidden" name="contacts[<?php echo e($loop->index); ?>][id]" value="<?php echo e($contact->id); ?>">

                            <!-- Title -->
                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" 
                                       class="form-control" 
                                       name="contacts[<?php echo e($loop->index); ?>][title]" 
                                       value="<?php echo e(old("contacts.{$loop->index}.title", $contact->title)); ?>"
                                       required>
                            </div>

                            <!-- Icon Class -->
                            <div class="mb-3">
                                <label class="form-label">Icon Class</label>
                                <input type="text" 
                                       class="form-control" 
                                       name="contacts[<?php echo e($loop->index); ?>][icon_class]" 
                                       value="<?php echo e(old("contacts.{$loop->index}.icon_class", $contact->icon_class)); ?>"
                                       placeholder="ti ti-mail">
                                <small class="form-text text-muted">Gunakan icon dari Tabler Icons (e.g., ti ti-mail, ti ti-phone)</small>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" 
                                          name="contacts[<?php echo e($loop->index); ?>][description]" 
                                          rows="2"><?php echo e(old("contacts.{$loop->index}.description", $contact->description)); ?></textarea>
                            </div>

                            <!-- Link -->
                            <div class="mb-3">
                                <label class="form-label">Link</label>
                                <input type="text" 
                                       class="form-control" 
                                       name="contacts[<?php echo e($loop->index); ?>][link]" 
                                       value="<?php echo e(old("contacts.{$loop->index}.link", $contact->link)); ?>"
                                       placeholder="https://example.com atau tel:+62811234567">
                                <small class="form-text text-muted">Gunakan URL (https://...), tel:+62xxx, mailto:email@domain.com. Kosongkan jika tidak ada.</small>
                            </div>

                            <!-- Toggles -->
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               name="contacts[<?php echo e($loop->index); ?>][is_active]" 
                                               value="1"
                                               <?php echo e(old("contacts.{$loop->index}.is_active", $contact->is_active) ? 'checked' : ''); ?>>
                                        <label class="form-check-label">Active</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               name="contacts[<?php echo e($loop->index); ?>][show_in_contact_page]" 
                                               value="1"
                                               <?php echo e(old("contacts.{$loop->index}.show_in_contact_page", $contact->show_in_contact_page) ? 'checked' : ''); ?>>
                                        <label class="form-check-label">Contact Page</label>
                                    </div>
                                </div>
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

        <?php if($contacts->count() > 0): ?>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-check me-1"></i> Save All Changes
                </button>
            </div>
        <?php endif; ?>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\admin\contact-info\index.blade.php ENDPATH**/ ?>