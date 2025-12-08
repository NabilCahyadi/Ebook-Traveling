<?php $__env->startSection('title', 'Create New Ebook'); ?>

<?php $__env->startSection('styles'); ?>
    <style>
        /* Vuexy Style Auto Crop UI */
        .auto-crop-container {
            background: linear-gradient(135deg, rgba(105, 108, 255, 0.05) 0%, rgba(115, 103, 240, 0.03) 100%);
            border: 2px dashed rgba(105, 108, 255, 0.3);
            border-radius: 0.5rem;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .auto-crop-container:hover {
            border-color: rgba(105, 108, 255, 0.5);
            background: linear-gradient(135deg, rgba(105, 108, 255, 0.08) 0%, rgba(115, 103, 240, 0.05) 100%);
        }

        .auto-crop-container.processing {
            border-style: solid;
            border-color: #696cff;
            background: rgba(105, 108, 255, 0.1);
        }

        .crop-preview-card {
            background: #fff;
            border: 2px solid rgba(75, 70, 92, 0.08);
            border-radius: 0.5rem;
            padding: 1.25rem;
            min-height: 200px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0.125rem 0.5rem rgba(75, 70, 92, 0.08);
            transition: all 0.3s ease;
        }

        .crop-preview-card.has-image {
            border-color: rgba(105, 108, 255, 0.3);
            background: linear-gradient(135deg, #fff 0%, rgba(105, 108, 255, 0.02) 100%);
        }

        /* ============================================
           EBOOK COVER PREVIEW BOX - FIXED SIZE
           Anti-override dari Vuexy/Bootstrap
           ============================================ */
        .ebook-cover-preview-box {
            max-width: 300px !important;
            width: 100%;
            aspect-ratio: 1 / 1.6; /* Portrait ratio 1:1.6 */
            overflow: hidden !important;
            border-radius: 0.5rem;
            border: 2px solid rgba(105, 108, 255, 0.2);
            background: #f8f9fa;
            margin: 0 auto; /* Center alignment */
            position: relative;
            box-shadow: 0 0.25rem 1rem rgba(75, 70, 92, 0.15);
        }

        /* Prevent Vuexy/Bootstrap img overrides */
        .ebook-cover-preview-box img {
            width: 100% !important;
            height: 100% !important;
            max-width: none !important;
            max-height: none !important;
            object-fit: cover !important;
            object-position: center !important;
            display: block !important;
            border-radius: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        /* Override .img-fluid if accidentally applied */
        .ebook-cover-preview-box img.img-fluid {
            max-width: none !important;
            height: 100% !important;
        }

        /* Override .w-100 if accidentally applied */
        .ebook-cover-preview-box img.w-100 {
            width: 100% !important;
            height: 100% !important;
        }

        /* Responsive adjustment for small screens */
        @media (max-width: 576px) {
            .ebook-cover-preview-box {
                max-width: 250px !important;
            }
        }

        .crop-info-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: linear-gradient(72deg, #696cff 0%, #7367f0 100%);
            color: #fff;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            box-shadow: 0 0.125rem 0.5rem rgba(105, 108, 255, 0.4);
            margin-bottom: 1rem;
        }

        .upload-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #696cff 0%, #7367f0 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            box-shadow: 0 0.25rem 0.75rem rgba(105, 108, 255, 0.3);
        }

        .upload-icon i {
            font-size: 2rem;
            color: #fff;
        }

        .processing-spinner {
            display: inline-block;
            width: 1rem;
            height: 1rem;
            border: 2px solid rgba(105, 108, 255, 0.3);
            border-radius: 50%;
            border-top-color: #696cff;
            animation: spin 0.6s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* PDF loading spinner */
        .ti-spin {
            animation: spin 1s linear infinite;
        }

        .crop-result-info {
            background: rgba(40, 199, 111, 0.08);
            border: 1px solid rgba(40, 199, 111, 0.2);
            border-radius: 0.375rem;
            padding: 0.75rem 1rem;
            margin-top: 1rem;
            font-size: 0.875rem;
            color: #28c76f;
        }

        .crop-error-info {
            background: rgba(234, 84, 85, 0.08);
            border: 1px solid rgba(234, 84, 85, 0.2);
            border-radius: 0.375rem;
            padding: 0.75rem 1rem;
            margin-top: 1rem;
            font-size: 0.875rem;
            color: #ea5455;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- (form, left/right columns, preview, modal) -->
    <!-- I will keep your form exactly as before; only ids/classes matter to JS -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">Ebook /</span> Create New Ebook</h4>
        </div>
        <div>
            <a href="<?php echo e(route('admin.ebooks.index')); ?>" class="btn btn-secondary"><i class="ti ti-arrow-left me-1"></i>
                Back</a>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Validation Error!</strong>
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('admin.ebooks.store')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <div class="row">
            <!-- Left Column - Main Information -->
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <i class="ti ti-book"></i> Informasi Ebook
                        </h5>

                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="title"
                                name="title" value="<?php echo e(old('title')); ?>" placeholder="Masukkan judul ebook" required>
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

                        <div class="mb-3">
                            <label for="author" class="form-label">Author <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['author'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="author"
                                name="author" value="<?php echo e(old('author')); ?>" placeholder="Nama penulis" required>
                            <?php $__errorArgs = ['author'];
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

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="category_id" class="form-label">Category <span
                                        class="text-danger">*</span></label>
                                <select class="form-select <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="category_id"
                                    name="category_id" required>
                                    <option value="">Pilih Kategori</option>
                                    <?php if(isset($categories)): ?>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($category->id); ?>"
                                                <?php echo e(old('category_id') == $category->id ? 'selected' : ''); ?>>
                                                <?php echo e($category->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                                <?php $__errorArgs = ['category_id'];
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

                            <div class="col-md-6 mb-3">
                                <label for="city_id" class="form-label">City</label>
                                <select class="form-select <?php $__errorArgs = ['city_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="city_id"
                                    name="city_id">
                                    <option value="">Pilih Kota (Optional)</option>
                                    <?php if(isset($cities)): ?>
                                        <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($city->id); ?>"
                                                <?php echo e(old('city_id') == $city->id ? 'selected' : ''); ?>>
                                                <?php echo e($city->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                                <?php $__errorArgs = ['city_id'];
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
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="description" name="description"
                                rows="5" placeholder="Deskripsi singkat tentang ebook" required><?php echo e(old('description')); ?></textarea>
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

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="page_count" class="form-label">
                                    Page Count
                                    <span class="text-muted small">(Auto dari PDF)</span>
                                </label>
                                <input type="number" class="form-control <?php $__errorArgs = ['page_count'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="page_count" name="page_count" value="<?php echo e(old('page_count')); ?>"
                                    placeholder="Otomatis terisi dari PDF" min="1" readonly>
                                <small class="text-muted">Upload PDF untuk auto-fill</small>
                                <?php $__errorArgs = ['page_count'];
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

                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="status"
                                    name="status" required>
                                    <option value="draft" <?php echo e(old('status', 'draft') == 'draft' ? 'selected' : ''); ?>>Draft</option>
                                    <option value="published" <?php echo e(old('status') == 'published' ? 'selected' : ''); ?>>Published</option>
                                    <option value="unpublished" <?php echo e(old('status') == 'unpublished' ? 'selected' : ''); ?>>Unpublished</option>
                                    <option value="archived" <?php echo e(old('status') == 'archived' ? 'selected' : ''); ?>>Archived</option>
                                </select>
                                <small class="text-muted">Admin dapat langsung publish tanpa approval</small>
                                <?php $__errorArgs = ['status'];
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
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-md-4">
                <!-- Cover Image with Auto Crop -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="ti ti-photo"></i> Cover Image
                        </h5>

                        <div class="crop-info-badge">
                            <i class="ti ti-aspect-ratio"></i>
                            <span>Auto Crop: Rasio 1:1.6 (Portrait)</span>
                        </div>

                        <!-- Upload Area -->
                        <div class="auto-crop-container" id="uploadArea">
                            <div class="upload-icon">
                                <i class="ti ti-cloud-upload"></i>
                            </div>
                            <h6 class="mb-2">Upload Cover Image</h6>
                            <p class="text-muted small mb-3">Click atau drag gambar ke sini</p>
                            <input type="file" class="form-control <?php $__errorArgs = ['cover_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="coverImageInput" accept="image/*" style="display: none;">
                            <button type="button" class="btn btn-primary btn-sm"
                                onclick="document.getElementById('coverImageInput').click()">
                                <i class="ti ti-upload me-1"></i> Pilih Gambar
                            </button>
                            <p class="text-muted small mt-2 mb-0">Max 2MB. JPG, PNG, atau WEBP</p>
                            <?php $__errorArgs = ['cover_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small mt-2"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Hidden input untuk menyimpan hasil crop -->
                        <input type="hidden" name="cover_image" id="croppedImageData">

                        <!-- Preview Area -->
                        <div id="previewArea" style="display: none;" class="mt-3">
                            <div class="crop-preview-card has-image">
                                <!-- Fixed Size Preview Box -->
                                <div class="ebook-cover-preview-box">
                                    <img id="previewImage" src="" alt="Preview">
                                </div>

                                <div class="crop-result-info mt-3 w-100" id="cropResultInfo">
                                    <i class="ti ti-check-circle me-1"></i>
                                    <span id="cropResultText"></span>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary mt-2 w-100"
                                    onclick="resetCrop()">
                                    <i class="ti ti-refresh me-1"></i> Ganti Gambar
                                </button>
                            </div>
                        </div>

                        <!-- Error Message Area -->
                        <div id="errorArea" style="display: none;" class="mt-3">
                            <div class="crop-error-info">
                                <i class="ti ti-alert-circle me-1"></i>
                                <span id="errorText"></span>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-secondary mt-2 w-100"
                                onclick="resetCrop()">
                                <i class="ti ti-upload me-1"></i> Coba Lagi
                            </button>
                        </div>
                    </div>
                </div>

                <!-- File and submit same as original -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">PDF File</h5>
                        <div class="mb-0">
                            <input type="file" class="form-control <?php $__errorArgs = ['file_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="file_url" name="file_url" accept=".pdf">
                            <small class="text-muted">Max 10MB. PDF format only</small>
                            <div id="pdfLoadingInfo" class="mt-2" style="display: none;">
                                <small class="text-info">
                                    <i class="ti ti-loader ti-spin me-1"></i> Membaca jumlah halaman...
                                </small>
                            </div>
                            <div id="pdfPageInfo" class="mt-2" style="display: none;">
                                <small class="text-success">
                                    <i class="ti ti-check-circle me-1"></i>
                                    <span id="pdfPageCount"></span> halaman terdeteksi
                                </small>
                            </div>
                            <?php $__errorArgs = ['file_url'];
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
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <i class="ti ti-check me-1"></i> Create Ebook
                        </button>
                        <a href="<?php echo e(route('admin.ebooks.index')); ?>" class="btn btn-label-secondary w-100">
                            <i class="ti ti-x me-1"></i> Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        /**
         * AUTO CROP IMAGE TO 1:1.6 RATIO (PORTRAIT)
         * - Fully automatic cropping without manual adjustment
         * - Center-based cropping (symmetric from center)
         * - Error handling for images too small
         * - Preview display with Vuexy styling
         */

        // Configuration
            const CROP_CONFIG = {
                ratioWidth: 1,
                ratioHeight: 1.6,
                minWidth: 250, // Minimum width in pixels
                minHeight: 400, // Minimum height in pixels (250*1.6 = 400)
                maxFileSize: 2 * 1024 * 1024, // 2MB
                maxOutputHeight: 400, // Maximum output height (will be 500x800)
                quality: 0.85, // JPEG quality (reduced for smaller file size)
                outputFormat: 'image/jpeg'
            };

        // DOM Elements
        const coverImageInput = document.getElementById('coverImageInput');
        const croppedImageData = document.getElementById('croppedImageData');
        const uploadArea = document.getElementById('uploadArea');
        const previewArea = document.getElementById('previewArea');
        const previewImage = document.getElementById('previewImage');
        const errorArea = document.getElementById('errorArea');
        const errorText = document.getElementById('errorText');
        const cropResultText = document.getElementById('cropResultText');

        // Event Listener
        coverImageInput.addEventListener('change', handleImageUpload);

        // Drag & Drop Support
        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.style.borderColor = '#696cff';
            uploadArea.style.backgroundColor = 'rgba(105,108,255,0.15)';
        });

        uploadArea.addEventListener('dragleave', () => {
            uploadArea.style.borderColor = '';
            uploadArea.style.backgroundColor = '';
        });

        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.style.borderColor = '';
            uploadArea.style.backgroundColor = '';

            const files = e.dataTransfer.files;
            if (files.length > 0) {
                coverImageInput.files = files;
                handleImageUpload({
                    target: {
                        files: files
                    }
                });
            }
        });

        /**
         * Handle image upload and trigger auto crop
         */
        function handleImageUpload(event) {
            const file = event.target.files[0];

            if (!file) return;

            // Validate file type
            if (!file.type.match('image.*')) {
                showError('File harus berupa gambar (JPG, PNG, WEBP)');
                return;
            }

            // Validate file size
            if (file.size > CROP_CONFIG.maxFileSize) {
                showError('Ukuran file maksimal 2MB');
                return;
            }

            // Show processing state
            uploadArea.classList.add('processing');
            uploadArea.innerHTML = `
        <div class="upload-icon">
            <div class="processing-spinner"></div>
        </div>
        <h6 class="mb-2">Memproses gambar...</h6>
        <p class="text-muted small mb-0">Sedang melakukan auto crop ke rasio 1.6:1</p>
    `;

            // Read and process image
            const reader = new FileReader();
            reader.onload = (e) => {
                const img = new Image();
                img.onload = () => {
                    autoCropToRatio(img, file.name);
                };
                img.onerror = () => {
                    showError('Gagal memuat gambar. Silakan coba file lain.');
                };
                img.src = e.target.result;
            };
            reader.onerror = () => {
                showError('Gagal membaca file gambar.');
            };
            reader.readAsDataURL(file);
        }

        /**
         * Auto crop image to specified ratio (1.6:1)
         * Center-based cropping with symmetric cutting
         */
        function autoCropToRatio(image, fileName) {
            const targetRatio = CROP_CONFIG.ratioWidth / CROP_CONFIG.ratioHeight;
            const sourceWidth = image.width;
            const sourceHeight = image.height;
            const sourceRatio = sourceWidth / sourceHeight;

            // Calculate crop dimensions
            let cropWidth, cropHeight, cropX, cropY;

            if (sourceRatio > targetRatio) {
                // Image is wider than target ratio - crop width
                cropHeight = sourceHeight;
                cropWidth = sourceHeight * targetRatio;
                cropX = (sourceWidth - cropWidth) / 2; // Center horizontally
                cropY = 0;
            } else {
                // Image is taller than target ratio - crop height
                cropWidth = sourceWidth;
                cropHeight = sourceWidth / targetRatio;
                cropX = 0;
                cropY = (sourceHeight - cropHeight) / 2; // Center vertically
            }

            // Validate minimum dimensions
            if (cropWidth < CROP_CONFIG.minWidth || cropHeight < CROP_CONFIG.minHeight) {
                showError(
                    `Gambar terlalu kecil untuk dicrop ke rasio 1:1.6. Minimal ${CROP_CONFIG.minWidth}x${CROP_CONFIG.minHeight} pixels.`
                );
                resetUploadArea();
                return;
            }

            // Calculate output dimensions (maintain quality but compress)
            let outputWidth, outputHeight;
            if (cropHeight > CROP_CONFIG.maxOutputHeight) {
                // Scale down proportionally
                outputHeight = CROP_CONFIG.maxOutputHeight;
                outputWidth = Math.round(outputHeight / CROP_CONFIG.ratioHeight * CROP_CONFIG.ratioWidth);
            } else {
                outputWidth = Math.round(cropWidth);
                outputHeight = Math.round(cropHeight);
            }

            // Create canvas and perform crop
            const canvas = document.createElement('canvas');
            canvas.width = outputWidth;
            canvas.height = outputHeight;

            const ctx = canvas.getContext('2d');

            // Enable image smoothing for better quality
            ctx.imageSmoothingEnabled = true;
            ctx.imageSmoothingQuality = 'high';

            // Draw cropped image to canvas
            ctx.drawImage(
                image,
                cropX, cropY, cropWidth, cropHeight, // Source crop area
                0, 0, outputWidth, outputHeight // Destination
            );

            // Convert to base64
            canvas.toBlob((blob) => {
                if (!blob) {
                    showError('Gagal memproses gambar. Silakan coba lagi.');
                    resetUploadArea();
                    return;
                }

                // Convert blob to base64
                const reader = new FileReader();
                reader.onload = (e) => {
                    const base64Data = e.target.result;

                    // Save to hidden input
                    croppedImageData.value = base64Data;

                    // Show preview
                    showPreview(base64Data, outputWidth, outputHeight, fileName);
                };
                reader.readAsDataURL(blob);
            }, CROP_CONFIG.outputFormat, CROP_CONFIG.quality);
        }

        /**
         * Show preview of cropped image
         */
        function showPreview(base64Data, width, height, fileName) {
            // Hide upload and error areas
            uploadArea.style.display = 'none';
            errorArea.style.display = 'none';

            // Show preview
            previewImage.src = base64Data;
            previewArea.style.display = 'block';

            // Update result info
            const fileSize = Math.round((base64Data.length * 3) / 4 / 1024); // Approximate KB
            cropResultText.textContent = `Crop berhasil! ${width}x${height}px (${fileSize}KB) - Rasio 1:1.6`;
        }

        /**
         * Show error message
         */
        function showError(message) {
            uploadArea.style.display = 'none';
            previewArea.style.display = 'none';
            errorArea.style.display = 'block';
            errorText.textContent = message;

            // Clear input and hidden data
            coverImageInput.value = '';
            croppedImageData.value = '';
        }

        /**
         * Reset crop and show upload area again
         */
        function resetCrop() {
            coverImageInput.value = '';
            croppedImageData.value = '';

            previewArea.style.display = 'none';
            errorArea.style.display = 'none';

            resetUploadArea();
        }

        /**
         * Reset upload area to initial state
         */
        function resetUploadArea() {
            uploadArea.classList.remove('processing');
            uploadArea.style.display = 'block';
            uploadArea.innerHTML = `
        <div class="upload-icon">
            <i class="ti ti-cloud-upload"></i>
        </div>
        <h6 class="mb-2">Upload Cover Image</h6>
        <p class="text-muted small mb-3">Click atau drag gambar ke sini</p>
        <button type="button" class="btn btn-primary btn-sm" onclick="document.getElementById('coverImageInput').click()">
            <i class="ti ti-upload me-1"></i> Pilih Gambar
        </button>
        <p class="text-muted small mt-2 mb-0">Max 2MB. JPG, PNG, atau WEBP</p>
    `;
        }

        // Form validation before submit
        document.querySelector('form').addEventListener('submit', function(e) {
            if (!croppedImageData.value) {
                e.preventDefault();
                alert('Silakan upload cover image terlebih dahulu');
                return false;
            }
        });

        /**
         * ============================================
         * AUTO-FILL PAGE COUNT FROM PDF
         * ============================================
         */
        const pdfInput = document.getElementById('file_url');
        const pageCountInput = document.getElementById('page_count');
        const pdfLoadingInfo = document.getElementById('pdfLoadingInfo');
        const pdfPageInfo = document.getElementById('pdfPageInfo');
        const pdfPageCountText = document.getElementById('pdfPageCount');

        pdfInput.addEventListener('change', async function(e) {
            const file = e.target.files[0];

            if (!file) {
                pageCountInput.value = '';
                pdfPageInfo.style.display = 'none';
                return;
            }

            // Validate file type
            if (file.type !== 'application/pdf') {
                alert('File harus berformat PDF');
                pdfInput.value = '';
                return;
            }

            // Validate file size (10MB)
            if (file.size > 10 * 1024 * 1024) {
                alert('Ukuran file maksimal 10MB');
                pdfInput.value = '';
                return;
            }

            // Show loading
            pdfLoadingInfo.style.display = 'block';
            pdfPageInfo.style.display = 'none';
            pageCountInput.value = '';

            try {
                // Read PDF file
                const arrayBuffer = await file.arrayBuffer();

                // Load PDF.js library from CDN if not loaded
                if (typeof pdfjsLib === 'undefined') {
                    await loadPdfJs();
                }

                // Load PDF document
                const pdf = await pdfjsLib.getDocument({ data: arrayBuffer }).promise;
                const pageCount = pdf.numPages;

                // Update page count input
                pageCountInput.value = pageCount;

                // Show success message
                pdfLoadingInfo.style.display = 'none';
                pdfPageInfo.style.display = 'block';
                pdfPageCountText.textContent = pageCount;

            } catch (error) {
                console.error('Error reading PDF:', error);
                pdfLoadingInfo.style.display = 'none';
                alert('Gagal membaca file PDF. Page count tetap readonly.');
            }
        });

        /**
         * Load PDF.js library dynamically
         */
        function loadPdfJs() {
            return new Promise((resolve, reject) => {
                // Check if already loaded
                if (typeof pdfjsLib !== 'undefined') {
                    resolve();
                    return;
                }

                // Load PDF.js from CDN
                const script = document.createElement('script');
                script.src = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js';
                script.onload = () => {
                    // Set worker path
                    pdfjsLib.GlobalWorkerOptions.workerSrc =
                        'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
                    resolve();
                };
                script.onerror = reject;
                document.head.appendChild(script);
            });
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views/admin/ebooks/create.blade.php ENDPATH**/ ?>