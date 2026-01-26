<?php $__env->startSection('title', __('admin.ebooks.edit_ebook')); ?>

<?php
    use Illuminate\Support\Facades\Storage;
?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.css" />
<style>
    .ck-editor__editable {
        min-height: 400px;
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
    
    /* Category Badge Styles - Override Vuexy */
    .category-badge {
        display: inline-flex !important;
        align-items: center !important;
        padding: 0.5rem 0.75rem !important;
        margin: 0.25rem 0.25rem 0.25rem 0 !important;
        font-size: 0.875rem !important;
        font-weight: 500 !important;
        line-height: 1.5 !important;
        color: #000000 !important;
        background-color: #ffe0f0 !important;
        border: 2px solid #ff7eb3 !important;
        border-radius: 0.5rem !important;
        box-shadow: 0 2px 6px rgba(255, 126, 179, 0.15) !important;
    }
    
    .remove-category {
        margin-left: 0.5rem !important;
        cursor: pointer !important;
        font-size: 1rem !important;
        line-height: 1 !important;
        opacity: 0.8 !important;
        color: #000000 !important;
    }
    
    .remove-category:hover {
        opacity: 1 !important;
    }
    
    #selected-categories {
        min-height: 20px !important;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold py-3 mb-2"><span class="text-muted fw-light"><?php echo e(__('admin.menu.ebooks')); ?> /</span> <?php echo e(__('admin.ebooks.edit_ebook')); ?></h4>
        </div>
        <div>
            <a href="<?php echo e(route('admin.ebooks.index')); ?>" class="btn" style="background-color: #ea5455; color: white;"><i class="ti ti-arrow-left me-1"></i>
                <?php echo e(__('admin.ebooks.back')); ?></a>
        </div>
    </div>

    <form action="<?php echo e(route('admin.ebooks.update', $ebook->id)); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="row">
            <!-- Left Column - Main Information -->
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <i class="ti ti-book"></i> <?php echo e(__('admin.ebooks.ebook_info')); ?>

                        </h5>

                        <div class="mb-3">
                            <label for="title" class="form-label"><?php echo e(__('admin.ebooks.title_field')); ?> <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="title"
                                name="title" value="<?php echo e(old('title', $ebook->title)); ?>" placeholder="<?php echo e(__('admin.ebooks.title_placeholder')); ?>"
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

                        <div class="mb-3">
                            <label for="creator_search" class="form-label"><?php echo e(__('admin.ebooks.creator')); ?> <span class="text-muted">(<?php echo e(__('admin.common.optional')); ?>)</span></label>
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
                                placeholder="<?php echo e(__('admin.ebooks.creator_search_placeholder')); ?>"
                                autocomplete="off">
                            <input type="hidden" name="creator_id" id="creator_id" value="<?php echo e(old('creator_id', $ebook->creator_id)); ?>">
                            
                            <!-- Autocomplete dropdown -->
                            <div id="creator_suggestions" class="list-group position-absolute w-100" style="z-index: 1000; display: none; max-height: 250px; overflow-y: auto;"></div>
                            
                            <!-- Selected creator display -->
                            <div id="selected_creator" class="mt-2"></div>
                            
                            <div class="form-text text-info">
                                <i class="ti ti-info-circle me-1"></i>
                                Biarkan kosong jika ebook ini dibuat oleh <strong>MeatMap Team</strong>
                            </div>
                            
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
                                <label for="category_selector" class="form-label"><?php echo e(__('admin.ebooks.category')); ?> <span
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
                                    <option value=""><?php echo e(__('admin.ebooks.select_category')); ?></option>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category->id); ?>" data-name="<?php echo e($category->name); ?>">
                                            <?php echo e($category->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                <label for="city_id" class="form-label"><?php echo e(__('admin.ebooks.city')); ?></label>
                                <select class="form-select <?php $__errorArgs = ['city_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="city_id"
                                    name="city_id">
                                    <option value=""><?php echo e(__('admin.ebooks.select_city')); ?></option>
                                    <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($city->id); ?>"
                                            <?php echo e(old('city_id', $ebook->city_id) == $city->id ? 'selected' : ''); ?>>
                                            <?php echo e($city->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                            <label for="description" class="form-label"><?php echo e(__('admin.ebooks.description')); ?> <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="description" name="description"
                                rows="5" placeholder="<?php echo e(__('admin.ebooks.description_placeholder')); ?>"><?php echo e(old('description', $ebook->description)); ?></textarea>
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
                                <label for="status" class="form-label"><?php echo e(__('admin.ebooks.status')); ?> <span class="text-danger">*</span></label>
                                <select class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="status"
                                    name="status" required>
                                    <option value="draft"
                                        <?php echo e(old('status', $ebook->status) == 'draft' ? 'selected' : ''); ?>><?php echo e(__('admin.ebooks.draft')); ?></option>
                                    <option value="published"
                                        <?php echo e(old('status', $ebook->status) == 'published' ? 'selected' : ''); ?>><?php echo e(__('admin.ebooks.published')); ?>

                                    </option>
                                    <option value="scheduled"
                                        <?php echo e(old('status', $ebook->status) == 'scheduled' ? 'selected' : ''); ?>>Scheduled
                                    </option>
                                    <option value="unpublished"
                                        <?php echo e(old('status', $ebook->status) == 'unpublished' ? 'selected' : ''); ?>><?php echo e(__('admin.ebooks.unpublished')); ?>

                                    </option>
                                </select>
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

                        <!-- Scheduled Publishing Date/Time -->
                        <div class="row" id="scheduledDateContainer" style="<?php echo e(old('status', $ebook->status) == 'scheduled' ? '' : 'display: none;'); ?>">
                            <div class="col-md-12 mb-3">
                                <label for="published_at" class="form-label"><i class="ti ti-calendar-time me-1"></i> Publish Date & Time <span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control <?php $__errorArgs = ['published_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="published_at" name="published_at" 
                                    value="<?php echo e(old('published_at', $ebook->published_at ? $ebook->published_at->format('Y-m-d\TH:i') : '')); ?>"
                                    min="<?php echo e(now()->format('Y-m-d\TH:i')); ?>">
                                <?php $__errorArgs = ['published_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="form-text">Set the date and time when this ebook will be automatically published</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-md-4">
                <!-- Cover Image -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="ti ti-photo"></i> <?php echo e(__('admin.ebooks.cover_image')); ?>

                        </h5>

                        <?php if($ebook->cover_image): ?>
                            <div class="mb-3">
                                <label class="form-label"><?php echo e(__('admin.ebooks.current_cover')); ?></label>
                                <div style="max-width: 200px;">
                                    <img src="<?php echo e(Storage::url($ebook->cover_image)); ?>" alt="Current Cover"
                                        style="width: 100%; border: 2px solid #ddd; border-radius: 8px;"
                                        onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="bg-label-secondary rounded align-items-center justify-content-center"
                                        style="width: 100%; aspect-ratio: 650/1040; display: none;">
                                        <i class="ti ti-book" style="font-size: 48px;"></i>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="mb-3">
                                <label class="form-label"><?php echo e(__('admin.ebooks.current_cover')); ?></label>
                                <div style="max-width: 200px;">
                                    <div class="bg-label-secondary rounded d-flex align-items-center justify-content-center"
                                        style="width: 100%; aspect-ratio: 650/1040;">
                                        <i class="ti ti-book" style="font-size: 48px;"></i>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <label class="form-label"><?php echo e(__('admin.ebooks.change_cover')); ?></label>
                            <input type="file" class="form-control <?php $__errorArgs = ['cover_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="coverImageInput" name="cover_image" accept="image/*">
                            <small class="text-muted"><?php echo __('admin.ebooks.cover_hint'); ?></small>
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
                            <label class="form-label"><?php echo e(__('admin.ebooks.preview')); ?></label>
                            <div style="max-width: 200px;">
                                <img id="previewImage" src="" alt="Preview"
                                    style="width: 100%; border: 2px solid #ddd; border-radius: 8px;">
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-secondary mt-2" onclick="resetCrop()">
                                <i class="ti ti-x me-1"></i> <?php echo e(__('admin.ebooks.remove')); ?>

                            </button>
                        </div>

                        <!-- Hidden input untuk menyimpan hasil crop -->
                        <input type="hidden" name="cover_image_cropped" id="croppedImageData">
                    </div>
                </div>

                <!-- PDF File -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><?php echo e(__('admin.ebooks.pdf_file')); ?></h5>

                        <?php if($ebook->pdf_file): ?>
                            <div class="mb-2">
                                <small class="text-success">
                                    <i class="ti ti-file-check me-1"></i> <?php echo e(__('admin.ebooks.pdf_exists')); ?>

                                </small>
                            </div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <input type="file" class="form-control <?php $__errorArgs = ['pdf_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="pdf_file" name="pdf_file" accept=".pdf">
                            <small class="text-muted"><?php echo e(__('admin.ebooks.pdf_hint')); ?></small>
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

                        <!-- Total Pages (Read-only) -->
                        <div class="mb-0">
                            <label for="total_pages" class="form-label"><?php echo e(__('admin.ebooks.total_pages')); ?></label>
                            <input type="number" class="form-control bg-lighter" id="total_pages" 
                                name="total_pages" value="<?php echo e(old('total_pages', $ebook->total_pages)); ?>" readonly 
                                placeholder="<?php echo e(__('admin.ebooks.total_pages_placeholder')); ?>">
                            <small class="text-muted">
                                <?php if($ebook->total_pages): ?>
                                    <?php echo e(__('admin.ebooks.total_pages_current', ['count' => $ebook->total_pages])); ?>

                                <?php else: ?>
                                    <?php echo e(__('admin.ebooks.total_pages_auto_update')); ?>

                                <?php endif; ?>
                            </small>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <i class="ti ti-check me-1"></i> <?php echo e(__('admin.ebooks.update_ebook')); ?>

                        </button>
                        <a href="<?php echo e(route('admin.ebooks.index')); ?>" class="btn btn-label-secondary w-100">
                            <i class="ti ti-x me-1"></i> <?php echo e(__('admin.ebooks.cancel')); ?>

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
        const totalPagesInput = document.getElementById('total_pages');

        if (pdfInput) {
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

                // Read PDF page count
                const fileReader = new FileReader();
                fileReader.onload = function() {
                    const typedArray = new Uint8Array(this.result);
                    
                    pdfjsLib.getDocument(typedArray).promise.then(function(pdf) {
                        const numPages = pdf.numPages;
                        
                        // Update total pages field
                        if (totalPagesInput) {
                            totalPagesInput.value = numPages;
                        }
                    }).catch(function(error) {
                        console.error('Error reading PDF:', error);
                        alert('Gagal membaca PDF. Pastikan file valid.');
                    });
                };
                
                fileReader.readAsArrayBuffer(file);
            });
        }

        
        // Category Selection Handler
        $(document).ready(function() {
            const selectedCategories = new Map();
            const categorySelector = $('#category_selector');
            const selectedContainer = $('#selected-categories');
            const inputsContainer = $('#category-inputs');
            
            // Load existing categories from ebook
            <?php if(old('category_ids')): ?>
                const existingCategories = <?php echo json_encode(old('category_ids'), 15, 512) ?>;
            <?php else: ?>
                const existingCategories = <?php echo json_encode($ebook->categories->pluck('id')->toArray(), 15, 512) ?>;
            <?php endif; ?>
            
            categorySelector.find('option').each(function() {
                const optionValue = $(this).val();
                const optionName = $(this).data('name');
                if (existingCategories.includes(optionValue)) {
                    selectedCategories.set(optionValue, optionName);
                }
            });
            updateDisplay();
            
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

        // Load current creator
        <?php if($ebook->creator_id): ?>
            loadSelectedCreator('<?php echo e($ebook->creator_id); ?>', '<?php echo e($ebook->creator->name ?? ''); ?>', '<?php echo e($ebook->creator->email ?? ''); ?>');
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
                <div class="alert d-flex justify-content-between align-items-center py-2 mb-0" style="background-color: #ffe0f0; border: 1px solid #ff7eb3; color: #d63384;">
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

        function loadSelectedCreator(creatorId, creatorName, creatorEmail) {
            if (creatorId && creatorName) {
                selectCreator({
                    id: creatorId,
                    name: creatorName,
                    email: creatorEmail
                });
            }
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

        // Toggle scheduled date container based on status selection
        const statusSelect = document.getElementById('status');
        const scheduledContainer = document.getElementById('scheduledDateContainer');
        const publishedAtInput = document.getElementById('published_at');
        
        function toggleScheduledDate() {
            if (statusSelect.value === 'scheduled') {
                scheduledContainer.style.display = 'flex';
                publishedAtInput.required = true;
                publishedAtInput.disabled = false;
            } else {
                scheduledContainer.style.display = 'none';
                publishedAtInput.required = false;
                publishedAtInput.disabled = true;
                publishedAtInput.value = ''; // Clear value when hidden
            }
        }
        
        statusSelect.addEventListener('change', toggleScheduledDate);
        // Run on page load
        toggleScheduledDate();
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\admin\ebooks\edit.blade.php ENDPATH**/ ?>