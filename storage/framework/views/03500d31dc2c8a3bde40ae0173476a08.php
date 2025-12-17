

<?php $__env->startSection('title', 'Edit Banner'); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        .image-preview {
            width: 100%;
            max-height: 300px;
            object-fit: cover;
            border-radius: 8px;
        }

        .preview-container {
            position: relative;
            margin-bottom: 1rem;
        }

        .remove-preview {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 1;
        }

        .current-image {
            border: 2px solid #e0e0e0;
            padding: 0.5rem;
            border-radius: 8px;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <span class="text-muted fw-light">Website Management / Banners /</span> Edit Banner
            </h4>
            <p class="mb-0">Update banner information</p>
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

    <!-- Form Card -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Banner Information</h5>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('admin.banners.update', $banner->id)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

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
unset($__errorArgs, $__bag); ?>" id="type" name="type" <?php echo e($banner->type === 'banner-pricing' ? 'disabled' : ''); ?>>
                            <option value="hero" <?php echo e(old('type', $banner->type) == 'hero' ? 'selected' : ''); ?>>Hero Banner</option>
                            <option value="home-slider" <?php echo e(old('type', $banner->type) == 'home-slider' ? 'selected' : ''); ?>>Home Slider</option>
                            <option value="banner-pricing" <?php echo e(old('type', $banner->type) == 'banner-pricing' ? 'selected' : ''); ?>>Banner Pricing</option>
                            <option value="promo" <?php echo e(old('type', $banner->type) == 'promo' ? 'selected' : ''); ?>>Promo Banner</option>
                            <option value="announcement" <?php echo e(old('type', $banner->type) == 'announcement' ? 'selected' : ''); ?>>Announcement</option>
                        </select>
                        <?php if($banner->type === 'banner-pricing'): ?>
                        <input type="hidden" name="type" value="banner-pricing">
                        <small class="form-text text-muted">Banner type tidak bisa diubah untuk Banner Pricing</small>
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
                            name="title" value="<?php echo e(old('title', $banner->title)); ?>" placeholder="Enter banner title"
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
                            rows="3" placeholder="Enter banner description (optional)"><?php echo e(old('description', $banner->description)); ?></textarea>
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

                    <!-- Current Banner Image -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Current Banner Image</label>
                        <div class="current-image">
                            <img src="<?php echo e($banner->image_url); ?>" alt="<?php echo e($banner->title); ?>"
                                class="image-preview <?php echo e($banner->type === 'banner-pricing' ? 'banner-pricing' : 'home-slider'); ?>" id="currentImage">
                        </div>
                    </div>

                    <!-- New Banner Image -->
                    <div class="col-md-12 mb-3">
                        <label for="image" class="form-label">Change Banner Image</label>
                        <div class="preview-container">
                            <img id="newImagePreview" class="image-preview" src="" alt="Preview"
                                style="display: none;">
                            <button type="button" class="btn btn-sm btn-danger remove-preview" id="removePreview"
                                style="display: none;">
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
                            name="image" accept="image/jpeg,image/jpg,image/png,image/webp">
                        <small class="form-text text-muted" id="image-size-hint">
                            Leave empty to keep current image. Recommended size: <?php echo e($banner->type === 'banner-pricing' ? '1500x600px (2.5:1)' : '1920x600px (3.2:1)'); ?>. Max size: 2MB
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
                    <div class="col-md-12 mb-3" id="target_url_field" style="<?php echo e($banner->type === 'banner-pricing' ? 'display: none;' : ''); ?>">
                        <label for="target_url" class="form-label">Target URL (Link)</label>
                        <input type="text" class="form-control <?php $__errorArgs = ['target_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            id="target_url" name="target_url" value="<?php echo e(old('target_url', $banner->target_url)); ?>"
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
                    <div class="col-md-6 mb-3" id="order_index_field" style="<?php echo e($banner->type === 'banner-pricing' ? 'display: none;' : ''); ?>">
                        <label for="order_index" class="form-label">Display Order</label>
                        <input type="number" class="form-control <?php $__errorArgs = ['order_index'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            id="order_index" name="order_index" value="<?php echo e(old('order_index', $banner->order_index)); ?>"
                            min="0">
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
                            id="start_date" name="start_date"
                            value="<?php echo e(old('start_date', $banner->start_date?->format('Y-m-d\TH:i'))); ?>">
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
                            id="end_date" name="end_date"
                            value="<?php echo e(old('end_date', $banner->end_date?->format('Y-m-d\TH:i'))); ?>">
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
                                <?php echo e(old('is_active', $banner->is_active) ? 'checked' : ''); ?>>
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
                        <i class="ti ti-check me-1"></i> Update Banner
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
            const newImagePreview = document.getElementById('newImagePreview');
            const currentImage = document.getElementById('currentImage');
            const removePreview = document.getElementById('removePreview');

            // Preview new image
            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        newImagePreview.src = e.target.result;
                        newImagePreview.style.display = 'block';
                        removePreview.style.display = 'block';
                        currentImage.style.opacity = '0.3';
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Remove new preview
            removePreview.addEventListener('click', function() {
                imageInput.value = '';
                newImagePreview.src = '';
                newImagePreview.style.display = 'none';
                removePreview.style.display = 'none';
                currentImage.style.opacity = '1';
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
            const currentImage = document.getElementById('currentImage');

            function toggleFields() {
                if (typeSelect.value === 'banner-pricing') {
                    targetUrlField.style.display = 'none';
                    targetUrlInput.value = '';
                    targetUrlInput.removeAttribute('required');
                    
                    orderIndexField.style.display = 'none';
                    orderIndexInput.value = '0';
                    
                    imageSizeHint.innerHTML = 'Leave empty to keep current image. Recommended size: 1500x600px (2.5:1). Max size: 2MB';
                    newImagePreview.classList.remove('home-slider');
                    newImagePreview.classList.add('banner-pricing');
                    if (currentImage) {
                        currentImage.classList.remove('home-slider');
                        currentImage.classList.add('banner-pricing');
                    }
                } else {
                    targetUrlField.style.display = 'block';
                    orderIndexField.style.display = 'block';
                    
                    imageSizeHint.innerHTML = 'Leave empty to keep current image. Recommended size: 1920x600px (3.2:1). Max size: 2MB';
                    newImagePreview.classList.remove('banner-pricing');
                    newImagePreview.classList.add('home-slider');
                    if (currentImage) {
                        currentImage.classList.remove('banner-pricing');
                        currentImage.classList.add('home-slider');
                    }
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
                            type: bannerType,
                            banner_id: '<?php echo e($banner->id); ?>'
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

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views/admin/banners/edit.blade.php ENDPATH**/ ?>