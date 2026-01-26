<?php $__env->startSection('title', 'Create New Banner'); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        .preview-container {
            position: relative;
            margin-bottom: 1rem;
            min-height: 50px;
        }

        .image-preview {
            width: 100%;
            max-height: 300px;
            object-fit: cover;
            border-radius: 8px;
        }

        .image-preview.home-slider {
            aspect-ratio: 3.2 / 1;
            max-height: none;
        }

        .image-preview.banner-pricing {
            aspect-ratio: 2.5 / 1;
            max-height: none;
        }

        .remove-preview {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 1;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <span class="text-muted fw-light">Website Management / Banners /</span> Create New Banner
            </h4>
            <p class="mb-0">Tambah banner baru untuk ditampilkan di homepage</p>
        </div>
        <a href="<?php echo e(route('admin.banners.index')); ?>" class="btn btn-label-secondary">
            <i class="ti ti-arrow-left me-1"></i> Back to List
        </a>
    </div>

    <!-- Error Messages -->
    <?php if($errors->any()): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> Please check the form below.
            <ul class="mb-0 mt-2">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Form Card -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Banner Information</h5>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('admin.banners.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                <div class="row">
                    <!-- Type -->
                    <div class="col-md-6 mb-3">
                        <label for="type" class="form-label">Banner Type</label>
                        <select class="form-select <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="type" name="type">
                            <?php
                                $selectedType = old('type', request('type', 'home-slider'));
                            ?>
                            <option value="home-slider" <?php echo e($selectedType == 'home-slider' ? 'selected' : ''); ?>>Home Slider</option>
                            <option value="banner-pricing" <?php echo e($selectedType == 'banner-pricing' ? 'selected' : ''); ?> <?php echo e(isset($hasBannerPricing) && $hasBannerPricing ? 'disabled' : ''); ?>>Banner Pricing <?php echo e(isset($hasBannerPricing) && $hasBannerPricing ? '(Sudah ada)' : ''); ?></option>
                        </select>
                        <?php if(isset($hasBannerPricing) && $hasBannerPricing): ?>
                        <small class="form-text text-muted">Banner Pricing sudah ada, hanya boleh 1 banner pricing</small>
                        <?php endif; ?>
                        <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Title -->
                    <div class="col-md-12 mb-3">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="title"
                            name="title" value="<?php echo e(old('title')); ?>" placeholder="Enter banner title" required>
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
                    </div>

                    <!-- Description -->
                    <div class="col-md-12 mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="description" name="description"
                            rows="3" placeholder="Enter banner description (optional)"><?php echo e(old('description')); ?></textarea>
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
                    </div>

                    <!-- Banner Image -->
                    <div class="col-md-12 mb-3">
                        <label for="image" class="form-label">Banner Image <span class="text-danger">*</span></label>
                        <div class="preview-container" id="previewContainer" style="display: none; position: relative;">
                            <img id="imagePreview" class="image-preview" src="" alt="Preview">
                            <button type="button" class="btn btn-sm btn-danger remove-preview" id="removePreview">
                                <i class="ti ti-x"></i>
                            </button>
                        </div>
                        <input type="file" class="form-control <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="image"
                            name="image" accept="image/jpeg,image/jpg,image/png,image/webp" required>
                        <small class="form-text text-muted" id="image-size-hint">
                            Recommended size: 1920x600px (3.2:1). Max size: 2MB. Format: JPEG, PNG, WebP
                        </small>
                        <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Target URL -->
                    <div class="col-md-12 mb-3" id="target_url_field">
                        <label for="target_url" class="form-label">Target URL (Link)</label>
                        <input type="text" class="form-control <?php $__errorArgs = ['target_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            id="target_url" name="target_url" value="<?php echo e(old('target_url')); ?>"
                            placeholder="/pricing atau https://example.com">
                        <small class="form-text text-muted">URL tujuan ketika banner diklik. Bisa relative (/pricing) atau absolute (https://...)</small>
                        <?php $__errorArgs = ['target_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Order Index -->
                    <div class="col-md-6 mb-3" id="order_index_field">
                        <label for="order_index" class="form-label">Display Order</label>
                        <input type="number" class="form-control <?php $__errorArgs = ['order_index'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            id="order_index" name="order_index" value="<?php echo e(old('order_index', 0)); ?>" min="0">
                        <div id="order-warning" class="mt-2" style="display: none;"></div>
                        <small class="form-text text-muted">Lower number appears first</small>
                        <?php $__errorArgs = ['order_index'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Start Date -->
                    <div class="col-md-6 mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="datetime-local" class="form-control <?php $__errorArgs = ['start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            id="start_date" name="start_date" value="<?php echo e(old('start_date')); ?>">
                        <small class="form-text text-muted">Leave empty for immediate display</small>
                        <?php $__errorArgs = ['start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- End Date -->
                    <div class="col-md-6 mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="datetime-local" class="form-control <?php $__errorArgs = ['end_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            id="end_date" name="end_date" value="<?php echo e(old('end_date')); ?>">
                        <small class="form-text text-muted">Leave empty for no expiry</small>
                        <?php $__errorArgs = ['end_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Is Active -->
                    <div class="col-md-12 mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                <?php echo e(old('is_active', true) ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="is_active">
                                Active (Display this banner)
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="<?php echo e(route('admin.banners.index')); ?>" class="btn btn-label-secondary">
                        <i class="ti ti-x me-1"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-check me-1"></i> Create Banner
                    </button>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('image');
            const imagePreview = document.getElementById('imagePreview');
            const removePreview = document.getElementById('removePreview');
            const previewContainer = document.getElementById('previewContainer');

            // Preview image
            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        previewContainer.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Remove preview
            removePreview.addEventListener('click', function() {
                imageInput.value = '';
                imagePreview.src = '';
                previewContainer.style.display = 'none';
            });

            // Validate dates
            const startDate = document.getElementById('start_date');
            const endDate = document.getElementById('end_date');

            endDate.addEventListener('change', function() {
                if (startDate.value && endDate.value) {
                    if (new Date(endDate.value) < new Date(startDate.value)) {
                        alert('End date must be after start date');
                        endDate.value = '';
                    }
                }
            });

            // Handle target URL and display order visibility based on banner type
            const typeSelect = document.getElementById('type');
            const targetUrlField = document.getElementById('target_url_field');
            const targetUrlInput = document.getElementById('target_url');
            const orderIndexField = document.getElementById('order_index_field');
            const orderIndexInput = document.getElementById('order_index');
            const imageSizeHint = document.getElementById('image-size-hint');

            function toggleFields() {
                if (typeSelect.value === 'banner-pricing') {
                    targetUrlField.style.display = 'none';
                    targetUrlInput.value = '';
                    targetUrlInput.removeAttribute('required');
                    
                    orderIndexField.style.display = 'none';
                    orderIndexInput.value = '0';
                    
                    imageSizeHint.textContent = 'Recommended size: 1500x600px (2.5:1). Max size: 2MB. Format: JPEG, PNG, WebP';
                    imagePreview.classList.remove('home-slider');
                    imagePreview.classList.add('banner-pricing');
                } else {
                    targetUrlField.style.display = 'block';
                    orderIndexField.style.display = 'block';
                    
                    imageSizeHint.textContent = 'Recommended size: 1920x600px (3.2:1). Max size: 2MB. Format: JPEG, PNG, WebP';
                    imagePreview.classList.remove('banner-pricing');
                    imagePreview.classList.add('home-slider');
                }
            }

            // Initial check
            toggleFields();

            // Listen for changes
            typeSelect.addEventListener('change', toggleFields);

            // Check display order via AJAX
            const orderInput = document.getElementById('order_index');
            const orderWarning = document.getElementById('order-warning');
            let checkTimeout;

            orderInput.addEventListener('input', function() {
                clearTimeout(checkTimeout);
                orderWarning.style.display = 'none';

                const orderValue = this.value;
                const bannerType = typeSelect.value;

                if (!orderValue || bannerType === 'banner-pricing') {
                    return;
                }

                checkTimeout = setTimeout(() => {
                    fetch('<?php echo e(route('admin.banners.check-order')); ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            order: orderValue,
                            type: bannerType
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.exists) {
                            orderWarning.innerHTML = `
                                <div class="alert alert-warning alert-sm mb-0">
                                    <i class="ti ti-alert-triangle me-1"></i>
                                    <strong>Peringatan:</strong> ${data.message}
                                    ${data.suggestion ? `<br><small>${data.suggestion}</small>` : ''}
                                </div>
                            `;
                            orderWarning.style.display = 'block';
                        }
                    })
                    .catch(error => console.error('Error:', error));
                }, 500);
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\admin\banners\create.blade.php ENDPATH**/ ?>