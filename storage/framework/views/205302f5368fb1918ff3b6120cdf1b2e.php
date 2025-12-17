<?php $__env->startSection('title', 'Create New Ebook'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.css" />
<style>
    .ck-editor__editable {
        min-height: 400px;
    }
    /* Category Badge Styles - Override Vuexy */
    .category-badge {
        display: inline-flex !important;
        align-items: center !important;
        padding: 0.5rem 0.75rem !important;
        margin: 0.25rem 0.25rem 0.25rem 0 !important;
        font-size: 0.875rem !important;
        font-weight: 500 !important;
        line-height: 1.5 !important;
        color: #7367f0 !important;
        background-color: #f8f7ff !important;
        border: 2px solid #7367f0 !important;
        border-radius: 0.5rem !important;
        box-shadow: 0 2px 6px rgba(115, 103, 240, 0.15) !important;
    }

    .remove-category {
        margin-left: 0.5rem !important;
        cursor: pointer !important;
        font-size: 1rem !important;
        line-height: 1 !important;
        opacity: 0.8 !important;
        color: #7367f0 !important;
    }
    
    .remove-category:hover {
        opacity: 1 !important;
    }
    
    #selected-categories {
        min-height: 20px !important;
    }

    #selected-categories .category-badge .remove-category:hover {
        opacity: 1 !important;
    }

    /* Creator Autocomplete Suggestions */
    #creator_suggestions {
        background-color: #fff;
        border: 1px solid #d9dee3;
        border-radius: 0.375rem;
        box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
        margin-top: 0.25rem;
    }

    #creator_suggestions .list-group-item {
        background-color: #fff;
        border: none;
        border-bottom: 1px solid #f0f0f0;
        cursor: pointer;
        padding: 0.75rem 1rem;
    }

    #creator_suggestions .list-group-item:last-child {
        border-bottom: none;
    }

    #creator_suggestions .list-group-item:hover {
        background-color: #f8f9fa;
    }

    #creator_suggestions .list-group-item.text-muted,
    #creator_suggestions .list-group-item.text-danger {
        cursor: default;
    }
</style>
<?php $__env->stopPush(); ?>


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
                            <label for="creator_search" class="form-label">Creator <span class="text-danger">*</span></label>
                            <input type="text" 
                                class="form-control <?php $__errorArgs = ['creator_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                id="creator_search" 
                                placeholder="Ketik nama atau email creator..."
                                autocomplete="off">
                            <input type="hidden" name="creator_id" id="creator_id" value="<?php echo e(old('creator_id')); ?>">
                            
                            <!-- Autocomplete dropdown -->
                            <div id="creator_suggestions" class="list-group position-absolute w-100" style="z-index: 1000; display: none; max-height: 250px; overflow-y: auto;"></div>
                            
                            <!-- Selected creator display -->
                            <div id="selected_creator" class="mt-2"></div>
                            
                            <?php $__errorArgs = ['creator_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="category_selector" class="form-label">Category <span
                                        class="text-danger">*</span></label>
                                <select class="form-select <?php $__errorArgs = ['category_ids'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="category_selector">
                                    <option value="">Pilih Kategori</option>
                                    <?php if(isset($categories)): ?>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($category->id); ?>" data-name="<?php echo e($category->name); ?>">
                                                <?php echo e($category->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                                
                                <!-- Selected Categories Display -->
                                <div id="selected-categories" class="mt-2">
                                    <!-- Badges will appear here -->
                                </div>
                                
                                <!-- Hidden inputs for form submission -->
                                <div id="category-inputs"></div>
                                
                                <?php $__errorArgs = ['category_ids'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <?php $__errorArgs = ['category_ids.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
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
                                rows="5" placeholder="Deskripsi singkat tentang ebook"><?php echo e(old('description')); ?></textarea>
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
                            <div class="col-md-12 mb-3">
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
                                    <option value="draft" <?php echo e(old('status', 'draft') == 'draft' ? 'selected' : ''); ?>>Draft
                                    </option>
                                    <option value="published" <?php echo e(old('status') == 'published' ? 'selected' : ''); ?>>
                                        Published</option>
                                    <option value="unpublished" <?php echo e(old('status') == 'unpublished' ? 'selected' : ''); ?>>
                                        Unpublished</option>
                                    <option value="archived" <?php echo e(old('status') == 'archived' ? 'selected' : ''); ?>>Archived
                                    </option>
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

                        <div class="mb-3">
                            <label class="form-label">Cover Image (Ratio 1:1.6)</label>
                            <input type="file" class="form-control <?php $__errorArgs = ['cover_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="coverImageInput" name="cover_image" accept="image/*">
                            <small class="text-muted">Gambar akan otomatis di-crop ke rasio 1:1.6 (contoh: 650x965px). 
                                <strong>File besar akan otomatis dikompresi.</strong></small>
                            <?php $__errorArgs = ['cover_image'];
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

                        <!-- Preview Area -->
                        <div id="previewArea" style="display: none;" class="mt-3">
                            <label class="form-label">Preview (Auto-cropped)</label>
                            <div style="max-width: 200px;">
                                <img id="previewImage" src="" alt="Preview"
                                    style="width: 100%; border: 2px solid #ddd; border-radius: 8px;">
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-secondary mt-2" onclick="resetCrop()">
                                <i class="ti ti-x me-1"></i> Hapus
                            </button>
                        </div>

                        <!-- Hidden input untuk menyimpan hasil crop -->
                        <input type="hidden" name="cover_image_cropped" id="croppedImageData">
                    </div>
                </div>

                <!-- File and submit same as original -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">PDF File</h5>
                        <div class="mb-0">
                            <input type="file" class="form-control <?php $__errorArgs = ['pdf_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="pdf_file" name="pdf_file" accept=".pdf">
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
                            <?php $__errorArgs = ['pdf_file'];
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
<script type="importmap">
{
    "imports": {
        "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.js",
        "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/43.0.0/"
    }
}
</script>

<script type="module">
    import {
        ClassicEditor,
        Essentials,
        Bold,
        Italic,
        Underline,
        Strikethrough,
        Paragraph,
        Heading,
        List,
        Link,
        BlockQuote,
        Alignment,
        Font,
        Indent,
        IndentBlock,
        Table,
        TableToolbar,
        MediaEmbed,
        HorizontalLine,
        RemoveFormat,
        Undo,
        Image,
        ImageCaption,
        ImageStyle,
        ImageToolbar,
        ImageUpload,
        ImageResize,
        LinkImage,
        Base64UploadAdapter
    } from 'ckeditor5';

    let editorInstance;

    // Wait for DOM to be ready
    document.addEventListener('DOMContentLoaded', function() {
        ClassicEditor
            .create(document.querySelector('#description'), {
                plugins: [
                    Essentials, Bold, Italic, Underline, Strikethrough, Paragraph, Heading,
                    List, Link, BlockQuote, Alignment, Font, Indent, IndentBlock,
                    Table, TableToolbar, MediaEmbed, HorizontalLine, RemoveFormat, Undo,
                    Image, ImageCaption, ImageStyle, ImageToolbar, ImageUpload, ImageResize, LinkImage,
                    Base64UploadAdapter
                ],
                toolbar: [
                    'undo', 'redo', '|',
                    'heading', '|',
                    'bold', 'italic', 'underline', 'strikethrough', '|',
                    'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', '|',
                    'alignment', '|',
                    'bulletedList', 'numberedList', '|',
                    'outdent', 'indent', '|',
                    'link', 'uploadImage', 'blockQuote', 'insertTable', 'mediaEmbed', '|',
                    'horizontalLine', 'removeFormat'
                ],
                image: {
                    toolbar: [
                        'imageStyle:inline',
                        'imageStyle:block',
                        'imageStyle:side',
                        '|',
                        'toggleImageCaption',
                        'imageTextAlternative',
                        '|',
                        'linkImage'
                    ]
                },
                heading: {
                    options: [{
                            model: 'paragraph',
                            title: 'Paragraph',
                            class: 'ck-heading_paragraph'
                        },
                        {
                            model: 'heading1',
                            view: 'h1',
                            title: 'Heading 1',
                            class: 'ck-heading_heading1'
                        },
                        {
                            model: 'heading2',
                            view: 'h2',
                            title: 'Heading 2',
                            class: 'ck-heading_heading2'
                        },
                        {
                            model: 'heading3',
                            view: 'h3',
                            title: 'Heading 3',
                            class: 'ck-heading_heading3'
                        }
                    ]
                },
                table: {
                    contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
                }
            })
            .then(editor => {
                editorInstance = editor;
                console.log('Description editor initialized');

                // Sync editor content before form submit
                const form = document.querySelector('form');
                if (form) {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        console.log('Form submit intercepted');
                        
                        const content = editor.getData();
                        console.log('Editor content:', content.substring(0, 100));
                        
                        document.querySelector('#description').value = content;
                        console.log('Content synced to textarea');
                        
                        // Submit form
                        setTimeout(() => {
                            form.submit();
                        }, 100);
                    });
                }
            })
            .catch(error => {
                console.error('Editor initialization error:', error);
            });
    });
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        (function() {
            // Configuration untuk auto crop
            const CROP_CONFIG = {
                ratioWidth: 1,
                ratioHeight: 1.6,
                minWidth: 400,
                minHeight: 640,
                maxFileSize: 2 * 1024 * 1024, // 2MB
                outputWidth: 650,
                outputHeight: 1040, // 650 * 1.6
                quality: 0.90,
                outputFormat: 'image/jpeg'
            };

            const coverImageInput = document.getElementById('coverImageInput');
            const croppedImageData = document.getElementById('croppedImageData');
            const previewArea = document.getElementById('previewArea');
            const previewImage = document.getElementById('previewImage');

            if (!coverImageInput || !croppedImageData) {
                console.error('Required elements not found');
                return;
            }

            coverImageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (!file) return;

                // Validate file size
                if (file.size > CROP_CONFIG.maxFileSize) {
                    alert('File terlalu besar. Maksimal 2MB.');
                    coverImageInput.value = '';
                    return;
                }

                // Validate file type
                if (!file.type.match('image.*')) {
                    alert('File harus berupa gambar (JPG, PNG, atau WEBP)');
                    coverImageInput.value = '';
                    return;
                }

                // Read and process image
                const reader = new FileReader();
                reader.onload = function(event) {
                    const img = new Image();
                    img.onload = function() {
                        autoCropImage(img);
                    };
                    img.src = event.target.result;
                };
                reader.readAsDataURL(file);
            });

            function autoCropImage(image) {
                const targetRatio = CROP_CONFIG.ratioWidth / CROP_CONFIG.ratioHeight;
                const sourceWidth = image.width;
                const sourceHeight = image.height;
                const sourceRatio = sourceWidth / sourceHeight;

                let cropWidth, cropHeight, cropX, cropY;

                if (sourceRatio > targetRatio) {
                    // Crop width (gambar terlalu lebar)
                    cropHeight = sourceHeight;
                    cropWidth = sourceHeight * targetRatio;
                    cropX = (sourceWidth - cropWidth) / 2;
                    cropY = 0;
                } else {
                    // Crop height (gambar terlalu tinggi)
                    cropWidth = sourceWidth;
                    cropHeight = sourceWidth / targetRatio;
                    cropX = 0;
                    cropY = (sourceHeight - cropHeight) / 2;
                }

                // TIDAK ada minimum size - gambar kecil akan diperbesar, besar akan dikompres
                // Semua akan di-resize ke 650x1040px

                // Create canvas
                const canvas = document.createElement('canvas');
                canvas.width = CROP_CONFIG.outputWidth;
                canvas.height = CROP_CONFIG.outputHeight;

                const ctx = canvas.getContext('2d');
                ctx.imageSmoothingEnabled = true;
                ctx.imageSmoothingQuality = 'high';

                // Draw cropped image
                ctx.drawImage(
                    image,
                    cropX, cropY, cropWidth, cropHeight,
                    0, 0, CROP_CONFIG.outputWidth, CROP_CONFIG.outputHeight
                );

                // Convert to base64
                canvas.toBlob(function(blob) {
                    const reader = new FileReader();
                    reader.onloadend = function() {
                        const base64Data = reader.result;
                        croppedImageData.value = base64Data;

                        // Show preview
                        previewImage.src = base64Data;
                        previewArea.style.display = 'block';

                        console.log('Image cropped and saved to hidden input');
                    };
                    reader.readAsDataURL(blob);
                }, CROP_CONFIG.outputFormat, CROP_CONFIG.quality);
            }

            // Reset function
            window.resetCrop = function() {
                coverImageInput.value = '';
                croppedImageData.value = '';
                previewArea.style.display = 'none';
            };

        })();
    </script>

    <!-- PDF validation script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

        const pdfInput = document.getElementById('pdf_file');
        pdfInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            if (file.type !== 'application/pdf') {
                alert('File harus berformat PDF');
                pdfInput.value = '';
                return;
            }

            if (file.size > 10 * 1024 * 1024) {
                alert('Ukuran file maksimal 10MB');
                pdfInput.value = '';
                return;
            }
        });

        
        // Category Selection Handler
        $(document).ready(function() {
            const selectedCategories = new Map();
            const categorySelector = $('#category_selector');
            const selectedContainer = $('#selected-categories');
            const inputsContainer = $('#category-inputs');
            
            // Load old values if validation failed
            <?php if(old('category_ids')): ?>
                const oldCategories = <?php echo json_encode(old('category_ids'), 15, 512) ?>;
                categorySelector.find('option').each(function() {
                    const optionValue = $(this).val();
                    const optionName = $(this).data('name');
                    if (oldCategories.includes(optionValue)) {
                        selectedCategories.set(optionValue, optionName);
                    }
                });
                updateDisplay();
            <?php endif; ?>
            
            // Handle category selection
            categorySelector.on('change', function() {
                const selectedValue = $(this).val();
                const selectedText = $(this).find('option:selected').data('name');
                
                if (selectedValue && !selectedCategories.has(selectedValue)) {
                    selectedCategories.set(selectedValue, selectedText);
                    updateDisplay();
                    $(this).val(''); // Reset selector
                }
            });
            
            // Update display and hidden inputs
            function updateDisplay() {
                // Clear existing badges
                selectedContainer.empty();
                inputsContainer.empty();
                
                // Create badges for each selected category
                selectedCategories.forEach((name, id) => {
                    // Create badge
                    const badge = $('<span class="category-badge"></span>');
                    badge.text(name);
                    
                    // Create remove button
                    const removeBtn = $('<span class="remove-category">&times;</span>');
                    removeBtn.on('click', function() {
                        selectedCategories.delete(id);
                        updateDisplay();
                    });
                    
                    badge.append(removeBtn);
                    selectedContainer.append(badge);
                    
                    // Create hidden input
                    const input = $('<input type="hidden" name="category_ids[]">');
                    input.val(id);
                    inputsContainer.append(input);
                });
            }
        });

        // Creator Autocomplete
        const creatorSearch = $('#creator_search');
        const creatorId = $('#creator_id');
        const creatorSuggestions = $('#creator_suggestions');
        const selectedCreatorDiv = $('#selected_creator');
        let searchTimeout;

        // Load selected creator if edit mode
        <?php if(old('creator_id')): ?>
            loadSelectedCreator('<?php echo e(old('creator_id')); ?>');
        <?php endif; ?>

        creatorSearch.on('input', function() {
            const query = $(this).val().trim();
            
            clearTimeout(searchTimeout);
            
            if (query.length < 2) {
                creatorSuggestions.hide().empty();
                return;
            }
            
            searchTimeout = setTimeout(() => {
                $.ajax({
                    url: '<?php echo e(route('admin.ebooks.search-creators')); ?>',
                    method: 'GET',
                    data: { q: query },
                    success: function(data) {
                        creatorSuggestions.empty();
                        
                        if (data.length === 0) {
                            creatorSuggestions.append(
                                '<div class="list-group-item text-muted">Tidak ada creator ditemukan</div>'
                            );
                        } else {
                            data.forEach(creator => {
                                const item = $('<a href="javascript:void(0)" class="list-group-item list-group-item-action"></a>');
                                item.html(`
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>${creator.name}</strong>
                                            <br><small class="text-muted">${creator.email}</small>
                                        </div>
                                    </div>
                                `);
                                item.on('click', function() {
                                    selectCreator(creator);
                                });
                                creatorSuggestions.append(item);
                            });
                        }
                        
                        creatorSuggestions.show();
                    },
                    error: function() {
                        creatorSuggestions.html(
                            '<div class="list-group-item text-danger">Error loading creators</div>'
                        ).show();
                    }
                });
            }, 300);
        });

        function selectCreator(creator) {
            creatorId.val(creator.id);
            creatorSearch.val('');
            creatorSuggestions.hide().empty();
            
            selectedCreatorDiv.html(`
                <div class="alert alert-info d-flex justify-content-between align-items-center py-2 mb-0">
                    <div>
                        <i class="ti ti-user me-1"></i>
                        <strong>${creator.name}</strong>
                        <br><small>${creator.email}</small>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearCreator()">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
            `);
        }

        function loadSelectedCreator(creatorId) {
            $.ajax({
                url: '<?php echo e(route('admin.ebooks.search-creators')); ?>',
                method: 'GET',
                data: { q: '' },
                success: function(data) {
                    const creator = data.find(c => c.id == creatorId);
                    if (creator) {
                        selectCreator(creator);
                    }
                }
            });
        }

        window.clearCreator = function() {
            creatorId.val('');
            creatorSearch.val('');
            selectedCreatorDiv.empty();
        };

        // Hide suggestions when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('#creator_search, #creator_suggestions').length) {
                creatorSuggestions.hide();
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views/admin/ebooks/create.blade.php ENDPATH**/ ?>