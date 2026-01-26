<?php $__env->startSection('title', __('admin.blogs.create')); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.css" />
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
    <style>
        .ck-editor__editable {
            min-height: 500px;
        }
        
        /* Author Autocomplete Suggestions */
        #author_suggestions {
            background-color: #fff;
            border: 1px solid #d9dee3;
            border-radius: 0.375rem;
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
            margin-top: 0.25rem;
        }

        #author_suggestions .list-group-item {
            background-color: #fff;
            border: none;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
            padding: 0.75rem 1rem;
        }

        #author_suggestions .list-group-item:last-child {
            border-bottom: none;
        }

        #author_suggestions .list-group-item:hover {
            background-color: #f8f9fa;
        }

        #author_suggestions .list-group-item.text-muted,
        #author_suggestions .list-group-item.text-danger {
            cursor: default;
        }
        
        /* Category Badges */
        #selected-categories .category-badge {
            display: inline-block;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
        }
        
        #selected-categories .category-badge .remove-category:hover {
            color: #d32f2f;
        }
    </style>
<?php $__env->stopPush(); ?>


<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">Admin / Blogs /</span> <?php echo e(__('admin.blogs.create_new')); ?>

            </h4>
            <a href="<?php echo e(route('admin.blogs.index')); ?>" class="btn" style="background-color: #ea5455; color: white;">
                <i class="bx bx-arrow-back me-1"></i> <?php echo e(__('admin.blogs.back')); ?>

            </a>
        </div>

        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form id="blogForm" action="<?php echo e(route('admin.blogs.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><?php echo e(__('admin.blogs.blog_content')); ?></h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="title"><?php echo e(__('admin.blogs.blog_title')); ?> <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="title" name="title" value="<?php echo e(old('title')); ?>" placeholder="<?php echo e(__('admin.blogs.enter_title')); ?>"
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
                                <label class="form-label" for="content"><?php echo e(__('admin.blogs.content')); ?> <span class="text-danger">*</span></label>
                                <textarea class="form-control <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="content" name="content" rows="20"><?php echo e(old('content')); ?></textarea>
                                <?php $__errorArgs = ['content'];
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
                                <label class="form-label" for="excerpt"><?php echo e(__('admin.blogs.excerpt')); ?></label>
                                <textarea class="form-control <?php $__errorArgs = ['excerpt'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="excerpt" name="excerpt" rows="3"
                                    placeholder="<?php echo e(__('admin.blogs.excerpt_placeholder')); ?>"><?php echo e(old('excerpt')); ?></textarea>
                                <?php $__errorArgs = ['excerpt'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="form-text"><?php echo e(__('admin.blogs.excerpt_help')); ?></div>
                            </div>

                            <!-- Tags Input -->
                            <div class="mb-3">
                                <label class="form-label" for="tags"><?php echo e(__('admin.blogs.tags')); ?> <span class="text-muted">(<?php echo e(__('admin.common.optional')); ?>)</span></label>
                                <input type="text" 
                                    class="form-control <?php $__errorArgs = ['tags'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="tags" 
                                    name="tags" 
                                    value="<?php echo e(old('tags')); ?>"
                                    placeholder="<?php echo e(__('admin.blogs.tags_placeholder')); ?>"
                                    data-role="tagsinput">
                                <?php $__errorArgs = ['tags'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="form-text"><?php echo e(__('admin.blogs.tags_help')); ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><?php echo e(__('admin.blogs.publish')); ?></h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="author_search"><?php echo e(__('admin.blogs.author')); ?> <span class="text-muted">(<?php echo e(__('admin.common.optional')); ?>)</span></label>
                                <input type="text" 
                                    class="form-control <?php $__errorArgs = ['author_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="author_search" 
                                    placeholder="<?php echo e(__('admin.blogs.search_author_placeholder')); ?>"
                                    autocomplete="off">
                                <input type="hidden" name="author_id" id="author_id" value="<?php echo e(old('author_id')); ?>">
                                
                                <!-- Autocomplete dropdown -->
                                <div id="author_suggestions" class="list-group position-absolute w-100" style="z-index: 1000; display: none; max-height: 250px; overflow-y: auto;"></div>
                                
                                <!-- Selected author display -->
                                <div id="selected_author" class="mt-2"></div>
                                
                                <?php $__errorArgs = ['author_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="form-text text-info">
                                    <i class="ti ti-info-circle me-1"></i>
                                    <?php echo __('admin.blogs.leave_empty_for_team'); ?>

                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label" for="status"><?php echo e(__('admin.blogs.status')); ?> <span class="text-danger">*</span></label>
                                <select class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="status"
                                    name="status" required>
                                    <option value="draft" <?php echo e(old('status', 'draft') == 'draft' ? 'selected' : ''); ?>><?php echo e(__('admin.blogs.draft')); ?>

                                    </option>
                                    <option value="published" <?php echo e(old('status') == 'published' ? 'selected' : ''); ?>>
                                        <?php echo e(__('admin.blogs.published')); ?></option>
                                    <option value="scheduled" <?php echo e(old('status') == 'scheduled' ? 'selected' : ''); ?>>
                                        <i class="ti ti-clock"></i> Scheduled</option>
                                    <option value="unpublished" <?php echo e(old('status') == 'unpublished' ? 'selected' : ''); ?>>
                                        <?php echo e(__('admin.blogs.unpublished')); ?></option>
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
                                <div class="form-text"><?php echo e(__('admin.blogs.set_blog_status')); ?></div>
                            </div>

                            <!-- Scheduled Publishing Date/Time -->
                            <div class="mb-3" id="scheduledDateContainer" style="display: none;">
                                <label class="form-label" for="published_at"><i class="ti ti-calendar-time me-1"></i> Publish Date & Time <span class="text-danger" id="published_at_required">*</span></label>
                                <input type="datetime-local" class="form-control <?php $__errorArgs = ['published_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="published_at" name="published_at" 
                                    value="<?php echo e(old('published_at')); ?>"
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
                                <div class="form-text">Set the date and time when this blog will be automatically published</div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-save me-1"></i> <?php echo e(__('admin.blogs.create_blog')); ?>

                                </button>
                                <a href="<?php echo e(route('admin.blogs.index')); ?>" class="btn" style="background-color: #ea5455; color: white;">
                                    <?php echo e(__('admin.blogs.cancel')); ?>

                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><?php echo e(__('admin.blogs.featured_image')); ?></h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <input type="file" class="form-control <?php $__errorArgs = ['featured_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="featured_image" accept="image/*">
                                <?php $__errorArgs = ['featured_image'];
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
                            
                            <!-- Preview Frame 1200x630 -->
                            <div id="imagePreview" class="mt-3" style="display: none;">
                                <!-- <label class="form-label">Preview (1200 × 630)</label> -->
                                <div style="
                                    width: 100%;
                                    max-width: 420px;
                                    aspect-ratio: 1200/630;
                                    border: 2px dashed #d9dee3;
                                    border-radius: 12px;
                                    overflow: hidden;
                                    background: #fff;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                ">
                                    <img id="previewImage" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-secondary mt-2" onclick="resetImagePreview()">
                                    <i class="bx bx-x me-1"></i> <?php echo e(__('admin.ebooks.remove')); ?>

                                </button>
                            </div>
                            
                            <!-- Hidden input untuk menyimpan hasil kompres -->
                            <input type="hidden" name="featured_image_compressed" id="compressedImageData">
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><?php echo e(__('admin.blogs.category')); ?></h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="category_selector"><?php echo e(__('admin.blogs.blog_category')); ?></label>
                                <select class="form-select <?php $__errorArgs = ['categories'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="category_selector">
                                    <option value=""><?php echo e(__('admin.blogs.select_category')); ?></option>
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
                                
                                <?php $__errorArgs = ['categories'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="form-text">
                                    <?php echo e(__('admin.blogs.select_category_text')); ?>

                                    <a href="<?php echo e(route('admin.blog-categories.create')); ?>" target="_blank"><?php echo e(__('admin.blogs.add_new_category')); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEO Section - Full Width Below -->
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bx bx-search-alt me-2"></i><?php echo e(__('admin.blogs.seo_settings')); ?></h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="meta_title"><?php echo e(__('admin.blogs.meta_title')); ?></label>
                                    <input type="text" 
                                        class="form-control <?php $__errorArgs = ['meta_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                        id="meta_title" 
                                        name="meta_title" 
                                        value="<?php echo e(old('meta_title')); ?>"
                                        maxlength="500"
                                        placeholder="<?php echo e(__('admin.blogs.meta_title_placeholder')); ?>">
                                    <?php $__errorArgs = ['meta_title'];
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
                                        <span id="meta_title_count">0</span>/500 <?php echo e(__('admin.blogs.meta_title_count')); ?>

                                    </div>
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="meta_description"><?php echo e(__('admin.blogs.meta_description')); ?></label>
                                    <textarea 
                                        class="form-control <?php $__errorArgs = ['meta_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                        id="meta_description" 
                                        name="meta_description" 
                                        rows="3"
                                        maxlength="1000"
                                        placeholder="<?php echo e(__('admin.blogs.meta_description_placeholder')); ?>"><?php echo e(old('meta_description')); ?></textarea>
                                    <?php $__errorArgs = ['meta_description'];
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
                                        <span id="meta_description_count">0</span>/1000 <?php echo e(__('admin.blogs.meta_description_count')); ?>

                                    </div>
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="meta_keywords"><?php echo e(__('admin.blogs.meta_keywords')); ?></label>
                                    <input type="text" 
                                        class="form-control <?php $__errorArgs = ['meta_keywords'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                        id="meta_keywords" 
                                        name="meta_keywords" 
                                        value="<?php echo e(old('meta_keywords')); ?>"
                                        maxlength="500"
                                        placeholder="<?php echo e(__('admin.blogs.meta_keywords_placeholder')); ?>">
                                    <?php $__errorArgs = ['meta_keywords'];
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
                                        <span id="meta_keywords_count">0</span>/500 <?php echo e(__('admin.blogs.meta_keywords_count')); ?>

                                    </div>
                                </div>
                            </div>
                            
                            <div class="alert alert-info mb-0">
                                <i class="bx bx-info-circle me-2"></i>
                                <strong><?php echo e(__('admin.blogs.seo_tips')); ?></strong>
                                <ul class="mb-0 mt-2">
                                    <li><?php echo e(__('admin.blogs.seo_tip_1')); ?></li>
                                    <li><?php echo e(__('admin.blogs.seo_tip_2')); ?></li>
                                    <li><?php echo e(__('admin.blogs.seo_tip_3')); ?></li>
                                    <li><?php echo e(__('admin.blogs.seo_tip_4')); ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Ebooks Section - Full Width Below -->
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><?php echo e(__('admin.blogs.related_ebooks')); ?></h5>
                        </div>
                        <div class="card-body">
                            <!-- Filters -->
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label"><?php echo e(__('admin.blogs.search')); ?></label>
                                    <input type="text" 
                                        class="form-control" 
                                        id="ebook_search" 
                                        placeholder="<?php echo e(__('admin.blogs.search_ebooks')); ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label"><?php echo e(__('admin.blogs.filter_by_city')); ?></label>
                                    <select class="form-select" id="city_filter">
                                        <option value=""><?php echo e(__('admin.blogs.all_cities')); ?></option>
                                        <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($city->id); ?>"><?php echo e($city->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label"><?php echo e(__('admin.blogs.filter_by_category')); ?></label>
                                    <select class="form-select" id="category_filter">
                                        <option value=""><?php echo e(__('admin.blogs.all_categories')); ?></option>
                                        <?php $__currentLoopData = $ebookCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Ebooks Table -->
                            <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                                <table class="table table-hover">
                                    <thead style="background-color: #fff; position: sticky; top: 0; z-index: 10;">
                                        <tr>
                                            <th style="width: 50px;">
                                                <input type="checkbox" class="form-check-input" id="select_all">
                                            </th>
                                            <th style="width: 100px;"><?php echo e(__('admin.blogs.cover')); ?></th>
                                            <th><?php echo e(__('admin.blogs.title')); ?></th>
                                            <th style="width: 150px;"><?php echo e(__('admin.blogs.creator')); ?></th>
                                            <th style="width: 150px;"><?php echo e(__('admin.blogs.city')); ?></th>
                                            <th style="width: 200px;"><?php echo e(__('admin.blogs.categories')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody id="ebooks_table_body">
                                        <?php if($ebooks->count() > 0): ?>
                                            <?php $__currentLoopData = $ebooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ebook): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr class="ebook-row" 
                                                    data-city="<?php echo e($ebook->city_id ?? ''); ?>" 
                                                    data-category="<?php echo e($ebook->categories->pluck('id')->join(',')); ?>"
                                                    data-title="<?php echo e(strtolower($ebook->title)); ?>"
                                                    style="cursor: pointer;">
                                                    <td onclick="event.stopPropagation();">
                                                        <input class="form-check-input ebook-checkbox" 
                                                            type="checkbox" 
                                                            name="related_ebooks[]" 
                                                            value="<?php echo e($ebook->id); ?>"
                                                            <?php echo e(in_array($ebook->id, old('related_ebooks', [])) ? 'checked' : ''); ?>>
                                                    </td>
                                                    <td>
                                                        <img src="<?php echo e($ebook->cover_image_url); ?>" 
                                                            alt="<?php echo e($ebook->title); ?>" 
                                                            class="img-thumbnail"
                                                            style="width: 70px; height: 100px; object-fit: cover;"
                                                            onerror="this.src='<?php echo e(asset('images/no-cover.png')); ?>'">
                                                    </td>
                                                    <td><?php echo e($ebook->title); ?></td>
                                                    <td>
                                                        <span class="badge bg-label-success">
                                                            <?php echo e($ebook->creator->name ?? 'N/A'); ?>

                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-label-info">
                                                            <?php echo e($ebook->city->name ?? 'N/A'); ?>

                                                        </span>
                                                    </td>
                                                    <td>
                                                        <?php if($ebook->categories->count() > 0): ?>
                                                            <?php $__currentLoopData = $ebook->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <span class="badge bg-label-primary me-1"><?php echo e($cat->name); ?></span>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php else: ?>
                                                            <span class="badge bg-label-secondary">N/A</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6" class="text-center text-muted"><?php echo e(__('admin.blogs.no_ebooks_available')); ?></td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            
                            <?php $__errorArgs = ['related_ebooks'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <div class="form-text mt-2">
                                <span id="selected_count">0</span> <?php echo e(__('admin.blogs.ebooks_selected')); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <?php $__env->startPush('scripts'); ?>
        <script>
            // Filter and search functionality
            function filterEbooks() {
                const searchText = document.getElementById('ebook_search').value.toLowerCase();
                const cityFilter = document.getElementById('city_filter').value;
                const categoryFilter = document.getElementById('category_filter').value;
                const rows = document.querySelectorAll('.ebook-row');
                
                rows.forEach(row => {
                    const title = row.dataset.title;
                    const city = row.dataset.city;
                    const categories = row.dataset.category.split(',');
                    
                    let showRow = true;
                    
                    // Search filter
                    if (searchText && !title.includes(searchText)) {
                        showRow = false;
                    }
                    
                    // City filter
                    if (cityFilter && city !== cityFilter) {
                        showRow = false;
                    }
                    
                    // Category filter - check if any category matches
                    if (categoryFilter && !categories.includes(categoryFilter)) {
                        showRow = false;
                    }
                    
                    row.style.display = showRow ? '' : 'none';
                });
                
                updateSelectedCount();
            }
            
            // Update selected count
            function updateSelectedCount() {
                const visibleChecked = document.querySelectorAll('.ebook-row:not([style*="display: none"]) .ebook-checkbox:checked');
                document.getElementById('selected_count').textContent = visibleChecked.length;
            }
            
            // Select all functionality
            document.getElementById('select_all').addEventListener('change', function() {
                const visibleCheckboxes = document.querySelectorAll('.ebook-row:not([style*="display: none"]) .ebook-checkbox');
                visibleCheckboxes.forEach(cb => cb.checked = this.checked);
                updateSelectedCount();
            });
            
            // Individual checkbox change
            document.querySelectorAll('.ebook-checkbox').forEach(cb => {
                cb.addEventListener('change', updateSelectedCount);
            });
            
            // Click row to toggle checkbox
            document.querySelectorAll('.ebook-row').forEach(row => {
                row.addEventListener('click', function(e) {
                    // Don't toggle if clicking on checkbox itself
                    if (e.target.type !== 'checkbox') {
                        const checkbox = this.querySelector('.ebook-checkbox');
                        checkbox.checked = !checkbox.checked;
                        updateSelectedCount();
                    }
                });
            });
            
            // Attach filter event listeners
            document.getElementById('ebook_search').addEventListener('keyup', filterEbooks);
            document.getElementById('city_filter').addEventListener('change', filterEbooks);
            document.getElementById('category_filter').addEventListener('change', filterEbooks);
            
            // Initial count
            updateSelectedCount();
        </script>
        <?php $__env->stopPush(); ?>
    </div>

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
                    .create(document.querySelector('#content'), {
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
                        console.log('Editor initialized successfully');

                        // Sync editor content before form submit
                        const form = document.getElementById('blogForm');
                        if (form) {
                            form.addEventListener('submit', function(e) {
                                console.log('Form submit event triggered');
                                const content = editor.getData();
                                console.log('Editor content length:', content.length);
                                document.querySelector('#content').value = content;
                                console.log('Content synced to textarea');
                                // Let form submit naturally
                            });
                            console.log('Form submit listener attached');
                        } else {
                            console.error('Form not found!');
                        }
                    })
                    .catch(error => {
                        console.error('Editor initialization error:', error);
                    });
            });
        </script>
        <script>
            // Debug: Check if form exists
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('blogForm');
                console.log('Form found:', form ? 'Yes' : 'No');
                if (form) {
                    console.log('Form action:', form.action);
                    console.log('Form method:', form.method);
                }
            });

            /* ======================================================
               FEATURED IMAGE — AUTO CROP 1200x630 (CENTER)
            ====================================================== */
            
            const featuredImageInput = document.getElementById('featured_image');
            const imagePreview = document.getElementById('imagePreview');
            const previewImage = document.getElementById('previewImage');
            const compressedImageData = document.getElementById('compressedImageData');
            
            featuredImageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (!file) return;
                
                if (!file.type.startsWith('image/')) {
                    alert('File harus berupa gambar');
                    featuredImageInput.value = '';
                    return;
                }
                
                if (file.size > 5 * 1024 * 1024) {
                    alert('Maksimal 5MB');
                    featuredImageInput.value = '';
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(evt) {
                    const img = new Image();
                    img.onload = function() {
                        cropAndCompress(img);
                    };
                    img.src = evt.target.result;
                };
                reader.readAsDataURL(file);
            });
            
            function cropAndCompress(image) {
                
                const TARGET_W = 1200;
                const TARGET_H = 630;
                const TARGET_RATIO = TARGET_W / TARGET_H;
                
                const srcW = image.width;
                const srcH = image.height;
                const srcRatio = srcW / srcH;
                
                let cropW, cropH, offsetX, offsetY;
                
                // CENTER CROP
                if (srcRatio > TARGET_RATIO) {
                    cropH = srcH;
                    cropW = srcH * TARGET_RATIO;
                    offsetX = (srcW - cropW) / 2;
                    offsetY = 0;
                } else {
                    cropW = srcW;
                    cropH = srcW / TARGET_RATIO;
                    offsetX = 0;
                    offsetY = (srcH - cropH) / 2;
                }
                
                const canvas = document.createElement('canvas');
                canvas.width = TARGET_W;
                canvas.height = TARGET_H;
                
                const ctx = canvas.getContext('2d');
                ctx.imageSmoothingEnabled = true;
                ctx.imageSmoothingQuality = 'high';
                
                ctx.drawImage(
                    image,
                    offsetX,
                    offsetY,
                    cropW,
                    cropH,
                    0,
                    0,
                    TARGET_W,
                    TARGET_H
                );
                
                canvas.toBlob(blob => {
                    const reader = new FileReader();
                    reader.onloadend = () => {
                        compressedImageData.value = reader.result;
                        previewImage.src = reader.result;
                        imagePreview.style.display = 'block';
                    };
                    reader.readAsDataURL(blob);
                }, 'image/jpeg', 0.85);
            }
            
            window.resetImagePreview = function() {
                featuredImageInput.value = '';
                compressedImageData.value = '';
                imagePreview.style.display = 'none';
            };

            // Author Autocomplete
            const authorSearch = $('#author_search');
            const authorId = $('#author_id');
            const authorSuggestions = $('#author_suggestions');
            const selectedAuthorDiv = $('#selected_author');
            let searchTimeout;
            let allAuthors = [];

            // Load selected author if edit mode
            <?php if(old('author_id')): ?>
                loadSelectedAuthor('<?php echo e(old('author_id')); ?>');
            <?php endif; ?>

            // Load all authors on focus
            authorSearch.on('focus', function() {
                if (authorId.val()) {
                    return;
                }
                
                if (allAuthors.length > 0) {
                    displayAuthors(allAuthors);
                } else {
                    loadAllAuthors();
                }
            });

            // Search on input
            authorSearch.on('input', function() {
                const query = $(this).val().trim();
                
                clearTimeout(searchTimeout);
                
                if (query.length === 0) {
                    loadAllAuthors();
                } else {
                    searchTimeout = setTimeout(() => {
                        searchAuthorsFromServer(query);
                    }, 300);
                }
            });
            
            function searchAuthorsFromServer(query) {
                authorSuggestions.html('<div class="list-group-item text-muted"><i class="bx bx-loader-alt bx-spin me-1"></i> Searching...</div>').show();
                
                $.ajax({
                    url: '<?php echo e(route('admin.blogs.search-authors')); ?>',
                    method: 'GET',
                    data: { q: query },
                    success: function(data) {
                        displayAuthors(data);
                    },
                    error: function() {
                        authorSuggestions.html(
                            '<div class="list-group-item text-danger">Error searching authors</div>'
                        ).show();
                    }
                });
            }

            function loadAllAuthors() {
                authorSuggestions.html('<div class="list-group-item text-muted"><i class="bx bx-loader-alt bx-spin me-1"></i> Loading authors...</div>').show();
                
                $.ajax({
                    url: '<?php echo e(route('admin.blogs.search-authors')); ?>',
                    method: 'GET',
                    data: { q: '' },
                    success: function(data) {
                        allAuthors = data;
                        displayAuthors(data);
                    },
                    error: function() {
                        authorSuggestions.html(
                            '<div class="list-group-item text-danger">Error loading authors</div>'
                        ).show();
                    }
                });
            }

            function displayAuthors(authors) {
                authorSuggestions.empty();
                
                if (authors.length === 0) {
                    authorSuggestions.append(
                        '<div class="list-group-item text-muted">No authors found</div>'
                    );
                } else {
                    authors.forEach(author => {
                        const item = $('<a href="javascript:void(0)" class="list-group-item list-group-item-action"></a>');
                        item.html(`
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>${author.name}</strong>
                                    <br><small class="text-muted">${author.email}</small>
                                </div>
                            </div>
                        `);
                        item.on('click', function() {
                            selectAuthor(author);
                        });
                        authorSuggestions.append(item);
                    });
                }
                
                authorSuggestions.show();
            }

            function selectAuthor(author) {
                authorId.val(author.id);
                authorSearch.val('');
                authorSuggestions.hide().empty();
                
                selectedAuthorDiv.html(`
                    <div class="alert alert-info d-flex justify-content-between align-items-center py-2 mb-0">
                        <div>
                            <i class="bx bx-user me-1"></i>
                            <strong>${author.name}</strong>
                            <br><small>${author.email}</small>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearAuthor()">
                            <i class="bx bx-x"></i>
                        </button>
                    </div>
                `);
            }

            function loadSelectedAuthor(authorId) {
                $.ajax({
                    url: '<?php echo e(route('admin.blogs.search-authors')); ?>',
                    method: 'GET',
                    data: { q: '' },
                    success: function(data) {
                        const author = data.find(c => c.id == authorId);
                        if (author) {
                            selectAuthor(author);
                        }
                    }
                });
            }

            window.clearAuthor = function() {
                authorId.val('');
                authorSearch.val('');
                selectedAuthorDiv.empty();
            };

            // Hide suggestions when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#author_search, #author_suggestions').length) {
                    authorSuggestions.hide();
                }
            });
            
            // SEO Character Counters
            $('#meta_title').on('input', function() {
                $('#meta_title_count').text($(this).val().length);
            });
            
            $('#meta_description').on('input', function() {
                $('#meta_description_count').text($(this).val().length);
            });
            
            $('#meta_keywords').on('input', function() {
                $('#meta_keywords_count').text($(this).val().length);
            });
            
            // Initialize counters on page load
            $('#meta_title_count').text($('#meta_title').val().length);
            $('#meta_description_count').text($('#meta_description').val().length);
            $('#meta_keywords_count').text($('#meta_keywords').val().length);
            
            // Category Selection Handler
            const selectedCategories = new Map();
            const categorySelector = $('#category_selector');
            const selectedContainer = $('#selected-categories');

            // Handle old input on validation errors
            <?php if(old('categories')): ?>
                const oldCategories = <?php echo json_encode(old('categories'), 15, 512) ?>;
                $('#category_selector option').each(function() {
                    const optionValue = $(this).val();
                    const optionName = $(this).data('name');
                    if (oldCategories.includes(optionValue)) {
                        selectedCategories.set(optionValue, optionName);
                    }
                });
                renderCategories();
            <?php endif; ?>

            // Add category when selected
            categorySelector.on('change', function() {
                const selectedValue = $(this).val();
                const selectedText = $(this).find('option:selected').data('name');
                
                if (selectedValue && !selectedCategories.has(selectedValue)) {
                    selectedCategories.set(selectedValue, selectedText);
                    renderCategories();
                    $(this).val(''); // Reset selector
                }
            });

            // Render selected categories as badges
            function renderCategories() {
                selectedContainer.empty();
                selectedCategories.forEach((name, id) => {
                    const badge = $(`
                        <span class="badge bg-primary category-badge">
                            ${name}
                            <input type="hidden" name="categories[]" value="${id}">
                            <i class="bx bx-x ms-1 remove-category" style="cursor: pointer;" data-id="${id}"></i>
                        </span>
                    `);
                    selectedContainer.append(badge);
                });
                
                // Bind remove handlers
                $('.remove-category').on('click', function() {
                    const id = $(this).data('id');
                    selectedCategories.delete(id);
                    renderCategories();
                });
            }

            // Toggle scheduled date container based on status selection
            const statusSelect = document.getElementById('status');
            const scheduledContainer = document.getElementById('scheduledDateContainer');
            const publishedAtInput = document.getElementById('published_at');
            const publishedAtRequired = document.getElementById('published_at_required');
            
            function toggleScheduledDate() {
                if (statusSelect.value === 'scheduled') {
                    scheduledContainer.style.display = 'block';
                    publishedAtInput.setAttribute('required', 'required');
                    if (publishedAtRequired) publishedAtRequired.style.display = 'inline';
                } else {
                    scheduledContainer.style.display = 'none';
                    publishedAtInput.removeAttribute('required');
                    if (publishedAtRequired) publishedAtRequired.style.display = 'none';
                    publishedAtInput.value = ''; // Clear the value when not scheduled
                }
            }
            
            statusSelect.addEventListener('change', toggleScheduledDate);
            // Run on page load
            toggleScheduledDate();
            // Run on page load
            toggleScheduledDate();
        </script>

        <!-- Tagify Script -->
        <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
        <script>
            // Initialize Tagify on tags input
            const tagsInput = document.querySelector('input[name="tags"]');
            const tagify = new Tagify(tagsInput, {
                delimiters: ",",
                maxTags: 10,
                placeholder: "Type and press Enter...",
                dropdown: {
                    enabled: 0
                }
            });

            // Convert tagify format to simple array for form submission
            document.querySelector('form').addEventListener('submit', function(e) {
                const tags = tagify.value.map(tag => tag.value);
                tagsInput.value = JSON.stringify(tags);
            });
        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\admin\blogs\create.blade.php ENDPATH**/ ?>