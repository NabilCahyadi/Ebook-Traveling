<?php $__env->startSection('title', 'Edit Pricing Section'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold py-3 mb-2">
                    <span class="text-muted fw-light">Website Management / Landing Page Content /</span> Pricing Section
                </h4>
                <p class="text-muted">Kelola judul dan deskripsi yang tampil di halaman pricing</p>
            </div>
            <a href="<?php echo e(route('admin.landing-page-content.index')); ?>" class="btn btn-secondary">
                <i class="ti ti-arrow-left me-2"></i>Back
            </a>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <strong>Success!</strong> <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <strong>Error!</strong> <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <!-- Form Card -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="ti ti-tag me-2"></i>Edit Pricing Section
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo e(route('admin.landing-page-content.pricing.update')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>

                            <!-- Title -->
                            <div class="mb-4">
                                <label for="title" class="form-label">
                                    Judul <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="title" 
                                       name="title" 
                                       value="<?php echo e(old('title', $banner->title)); ?>"
                                       placeholder="e.g., Choose Your Perfect Plan"
                                       required>
                                <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="form-text">
                                    <i class="ti ti-info-circle me-1"></i>
                                    Judul utama yang akan ditampilkan di halaman pricing. Gunakan \n untuk baris baru.
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="mb-4">
                                <label for="description" class="form-label">
                                    Deskripsi
                                </label>
                                <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                          id="description" 
                                          name="description" 
                                          rows="4"
                                          placeholder="e.g., Pilih paket berlangganan yang sesuai dengan kebutuhan perjalanan Anda"><?php echo e(old('description', $banner->description)); ?></textarea>
                                <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="form-text">
                                    <i class="ti ti-info-circle me-1"></i>
                                    Deskripsi tambahan di bawah judul (opsional). Maksimal 500 karakter.
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="<?php echo e(route('admin.landing-page-content.index')); ?>" class="btn btn-label-secondary">
                                    <i class="ti ti-x me-2"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-warning">
                                    <i class="ti ti-device-floppy me-2"></i>Update Pricing Section
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Preview Card -->
            <div class="col-lg-4">
                <div class="card sticky-top" style="top: 100px;">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="ti ti-eye me-2"></i>Preview
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info mb-3">
                            <i class="ti ti-info-circle me-2"></i>
                            <small>Preview tampilan di halaman pricing</small>
                        </div>

                        <div class="preview-container p-4 border rounded bg-dark text-white text-center">
                            <h4 class="mb-3" id="preview-title">
                                <?php echo nl2br(e($banner->title)); ?>

                            </h4>
                            <?php if($banner->description): ?>
                            <p class="mb-0" id="preview-description" style="font-size: 14px;">
                                <?php echo e($banner->description); ?>

                            </p>
                            <?php endif; ?>
                        </div>

                        <div class="mt-3">
                            <small class="text-muted">
                                <i class="ti ti-info-circle me-1"></i>
                                Teks akan ditampilkan dengan background overlay di atas banner image
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Card -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">
                    <i class="ti ti-bulb me-2"></i>Tips
                </h5>
                <ul class="mb-0">
                    <li class="mb-2">
                        <strong>Judul:</strong> Buat judul yang menarik dan jelas. Gunakan \n untuk membuat baris baru (contoh: "Choose\nYour Plan").
                    </li>
                    <li class="mb-2">
                        <strong>Deskripsi:</strong> Jelaskan manfaat memilih paket berlangganan dengan singkat dan jelas.
                    </li>
                    <li>
                        <strong>Preview:</strong> Gunakan panel preview untuk melihat bagaimana teks akan tampil di halaman pricing.
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        // Real-time preview
        document.getElementById('title').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\\n/g, '<br>');
            document.getElementById('preview-title').innerHTML = value || 'title';
        });

        document.getElementById('description').addEventListener('input', function(e) {
            document.getElementById('preview-description').textContent = e.target.value || 'lorem ipsum';
        });
    </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\admin\landing-page-content\pricing.blade.php ENDPATH**/ ?>