<?php $__env->startSection('title', 'Edit Blog'); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.css" />
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
    <style>
        .ck-editor__editable {
            min-height: 500px;
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
                <span class="text-muted fw-light">Admin / Blogs /</span> <?php echo e(__('admin.blogs.edit')); ?>

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

        <form action="<?php echo e(route('admin.blogs.update', $blog->id)); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="row">
                <div class="col-lg-8 d-flex flex-column">
                    <div class="card mb-4 h-100">
                        <div class="card-header">
                            <h5 class="mb-0"><?php echo e(__('admin.blogs.blog_content')); ?></h5>
                        </div>
                        <div class="card-body d-flex flex-column">
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
                                    id="title" name="title" value="<?php echo e(old('title', $blog->title)); ?>"
                                    placeholder="Enter blog title" required>
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

                            <div class="mb-3 flex-grow-1 d-flex flex-column">
                                <label class="form-label" for="content"><?php echo e(__('admin.blogs.content')); ?> <span class="text-danger">*</span></label>
                                <textarea class="form-control <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> flex-grow-1" id="content" name="content" style="min-height: 400px; resize: vertical;"><?php echo e(old('content', $blog->content)); ?></textarea>
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
unset($__errorArgs, $__bag); ?>" id="excerpt" name="excerpt" rows="4"
                                    placeholder="Short description"><?php echo e(old('excerpt', $blog->excerpt)); ?></textarea>
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
                            </div>

                            <!-- Tags Input -->
                            <div class="mb-0">
                                <label class="form-label" for="tags">Tags <span class="text-muted">(<?php echo e(__('admin.common.optional')); ?>)</span></label>
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
                                    value="<?php echo e(old('tags', is_array($blog->tags) ? json_encode($blog->tags) : $blog->tags)); ?>"
                                    placeholder="Type and press Enter to add tags..."
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
                                <div class="form-text">Press Enter after each tag. Example: sejarah-indonesia, test-blog</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 d-flex flex-column">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><?php echo e(__('admin.blogs.publish')); ?></h5>
                        </div>
                        <div class="card-body">
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
                                    <option value="draft" <?php echo e(old('status', $blog->status) == 'draft' ? 'selected' : ''); ?>>
                                        <?php echo e(__('admin.blogs.draft')); ?></option>
                                    <option value="published"
                                        <?php echo e(old('status', $blog->status) == 'published' ? 'selected' : ''); ?>><?php echo e(__('admin.blogs.published')); ?>

                                    </option>
                                    <option value="scheduled"
                                        <?php echo e(old('status', $blog->status) == 'scheduled' ? 'selected' : ''); ?>>Scheduled
                                    </option>
                                    <option value="unpublished"
                                        <?php echo e(old('status', $blog->status) == 'unpublished' ? 'selected' : ''); ?>><?php echo e(__('admin.blogs.unpublished')); ?>

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
                                <div class="form-text"><?php echo e(__('admin.blogs.set_blog_status')); ?></div>
                            </div>

                            <!-- Scheduled Publishing Date/Time -->
                            <div class="mb-3" id="scheduledDateContainer" style="<?php echo e(old('status', $blog->status) == 'scheduled' ? '' : 'display: none;'); ?>">
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
                                    value="<?php echo e(old('published_at', $blog->published_at ? $blog->published_at->format('Y-m-d\TH:i') : '')); ?>"
                                    min="<?php echo e(now()->format('Y-m-d\TH:i')); ?>"
                                    <?php echo e(old('status', $blog->status) == 'scheduled' ? 'required' : ''); ?>>
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

                            <?php if($blog->published_at): ?>
                                <div class="mb-3">
                                    <small class="text-muted">
                                        <?php echo e(__('admin.blogs.published_at')); ?>: <?php echo e($blog->published_at->format('d M Y, H:i')); ?>

                                    </small>
                                </div>
                            <?php endif; ?>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-save me-1"></i> <?php echo e(__('admin.blogs.update_blog')); ?>

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
                            <?php if($blog->featured_image): ?>
                                <div class="mb-3">
                                    <?php
                                        // Check if image is external URL or local storage
                                        $imageUrl = $blog->featured_image_url;
                                    ?>
                                    <img src="<?php echo e($imageUrl); ?>" alt="<?php echo e($blog->title); ?>"
                                        class="img-fluid rounded">
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" id="remove_image"
                                            name="remove_image">
                                        <label class="form-check-label" for="remove_image">
                                            <?php echo e(__('admin.blogs.remove_current_image')); ?>

                                        </label>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="mb-3">
                                <label
                                    class="form-label"><?php echo e($blog->featured_image ? __('admin.blogs.replace_image') : __('admin.blogs.upload_image')); ?></label>
                                <input type="file" class="form-control <?php $__errorArgs = ['featured_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="featured_image" name="featured_image" accept="image/*">
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
                            <div id="imagePreview" class="mt-2" style="display: none;">
                                <img src="" alt="Preview" class="img-fluid rounded">
                            </div>
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

                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><?php echo e(__('admin.blogs.statistics')); ?></h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bx bx-show me-2"></i>
                                <span><?php echo e(number_format($blog->view_count)); ?> <?php echo e(__('admin.blogs.views')); ?></span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="bx bx-time me-2"></i>
                                <span><?php echo e(__('admin.blogs.updated')); ?> <?php echo e($blog->updated_at->diffForHumans()); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEO Section - Full Width Below -->
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4 mt-4">
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
                                        value="<?php echo e(old('meta_title', $blog->meta_title)); ?>"
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
                                        <span id="meta_title_count">0</span>/500 <?php echo e(__('admin.blogs.characters_optimal_50_60')); ?>

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
                                        placeholder="<?php echo e(__('admin.blogs.meta_description_placeholder')); ?>"><?php echo e(old('meta_description', $blog->meta_description)); ?></textarea>
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
                                        <span id="meta_description_count">0</span>/1000 <?php echo e(__('admin.blogs.characters_optimal_150_160')); ?>

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
                                        value="<?php echo e(old('meta_keywords', $blog->meta_keywords)); ?>"
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
                                        <span id="meta_keywords_count">0</span>/500 <?php echo e(__('admin.blogs.characters_recommended_5_10_keywords')); ?>

                                    </div>
                                </div>
                            </div>
                            
                            <div class="alert alert-info mb-0">
                                <i class="bx bx-info-circle me-2"></i>
                                <strong><?php echo e(__('admin.blogs.seo_tips')); ?></strong>
                                <ul class="mb-0 mt-2">
                                    <li><?php echo e(__('admin.blogs.seo_tip_meta_title')); ?></li>
                                    <li><?php echo e(__('admin.blogs.seo_tip_meta_description')); ?></li>
                                    <li><?php echo e(__('admin.blogs.seo_tip_meta_keywords')); ?></li>
                                    <li><?php echo e(__('admin.blogs.seo_tip_auto_fill')); ?></li>
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
                                        placeholder="<?php echo e(__('admin.blogs.search_ebooks_placeholder')); ?>">
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
                                                            <?php echo e(in_array($ebook->id, old('related_ebooks', $blog->ebooks->pluck('id')->toArray())) ? 'checked' : ''); ?>>
                                                    </td>
                                                    <td>
                                                        <img src="<?php echo e($ebook->cover_image_url); ?>" 
                                                            alt="<?php echo e($ebook->title); ?>" 
                                                            class="img-thumbnail"
                                                            style="width: 70px; height: 100px; object-fit: cover;"
                                                            onerror="if(!this.hasAttribute('data-error')){this.setAttribute('data-error','1');this.src='<?php echo e(asset('images/no-cover.png')); ?>';}else{this.style.display='none';}">
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
                    document.querySelector('form').addEventListener('submit', function(e) {
                        const content = editor.getData();
                        document.querySelector('#content').value = content;
                        console.log('Form submitting with content length:', content.length);
                    });
                })
                .catch(error => {
                    console.error('Editor initialization error:', error);
                });
        </script>
        <script>
            // Image preview
            document.getElementById('featured_image').addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const preview = document.getElementById('imagePreview');
                        preview.querySelector('img').src = e.target.result;
                        preview.style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Handle remove image checkbox
            document.getElementById('remove_image')?.addEventListener('change', function() {
                if (this.checked) {
                    document.getElementById('featured_image').value = '';
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

            // Load existing categories
            <?php if($blog->categories->count() > 0): ?>
                <?php $__currentLoopData = $blog->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    selectedCategories.set('<?php echo e($category->id); ?>', '<?php echo e($category->name); ?>');
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                renderCategories();
            <?php endif; ?>

            // Handle old input on validation errors
            <?php if(old('categories')): ?>
                selectedCategories.clear();
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
        </script>

        <!-- Tagify Script -->
        <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
        <script>
            // Initialize Tagify on tags input
            const tagsInput = document.querySelector('input[name="tags"]');
            
            // Parse existing tags if any
            let existingTags = [];
            try {
                const tagsValue = tagsInput.value;
                if (tagsValue) {
                    existingTags = JSON.parse(tagsValue);
                }
            } catch (e) {
                console.log('No existing tags or invalid format');
            }

            const tagify = new Tagify(tagsInput, {
                delimiters: ",",
                maxTags: 10,
                placeholder: "Type and press Enter...",
                dropdown: {
                    enabled: 0
                }
            });

            // Add existing tags
            if (existingTags.length > 0) {
                tagify.addTags(existingTags);
            }

            // Convert tagify format to simple array for form submission
            document.querySelector('form').addEventListener('submit', function(e) {
                const tags = tagify.value.map(tag => tag.value);
                tagsInput.value = JSON.stringify(tags);
            });
        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\admin\blogs\edit.blade.php ENDPATH**/ ?>