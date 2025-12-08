



<?php $__env->startSection('title', 'Tags Blog & News - MeatMap'); ?>

<?php $__env->startSection('content'); ?>
<main class="main">
    <!-- Page Header -->
    <div class="page-header mt-30 mb-35">
        <div class="container">
            <div class="archive-header">
                <div class="row align-items-center">
                    <div class="col-xl-3">
                        <h1 class="mb-15">Tags Blog</h1>
                        <div class="breadcrumb">
                            <a href="<?php echo e(route('home')); ?>" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                            <span></span> <a href="<?php echo e(route('blogs.index')); ?>">Blog & News</a>
                            <span></span> Tags
                        </div>
                    </div>
                    
                    <div class="col-xl-9 text-end d-none d-xl-block">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Page Content -->
    <div class="page-content mb-50">
        <div class="container">
            <div class="row">
                <!-- Main Blog List (col-lg-9) -->
                <div class="col-lg-9">
                    <!-- Filter Bar (Opsional, bisa dikembangkan fungsinya) -->
                    <div class="shop-product-fillter mb-40 pr-30">
                        <div class="totall-product">
                            <h4>
                                <?php if(isset($tag)): ?>
                                <img class="w-36px mr-10" src="<?php echo e(asset('assets/imgs/theme/icons/category-1.svg')); ?>" alt="" />
                                Tag : <span class="text-brand">#<?php echo e(ucfirst($tag)); ?></span>
                                <?php else: ?>
                                <img class="w-36px mr-10" src="<?php echo e(asset('assets/imgs/theme/icons/category-1.svg')); ?>" alt="" />
                                Semua Artikel
                                <?php endif; ?>
                            </h4>
                        </div>
                        
                        <div class="sort-by-product-area">
                            <div class="sort-by-cover mr-10">
                                <div class="sort-by-product-wrap">
                                    <div class="sort-by">
                                        <span><i class="fi-rs-apps"></i>Show :</span>
                                    </div>
                                    <div class="sort-by-dropdown-wrap">
                                        <span> 50 <i class="fi-rs-angle-small-down"></i></span>
                                    </div>
                                </div>
                                <div class="sort-by-dropdown">
                                    <ul>
                                        <li><a class="active" href="#">50</a></li>
                                        <li><a href="#">100</a></li>
                                        <li><a href="#">150</a></li>
                                        <li><a href="#">200</a></li>
                                        <li><a href="#">All</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="sort-by-cover">
                                <div class="sort-by-product-wrap">
                                    <div class="sort-by">
                                        <span><i class="fi-rs-apps-sort"></i>Sort :</span>
                                    </div>
                                    <div class="sort-by-dropdown-wrap">
                                        <span>Featured <i class="fi-rs-angle-small-down"></i></span>
                                    </div>
                                </div>
                                <div class="sort-by-dropdown">
                                    <ul>
                                        <li><a class="active" href="#">Featured</a></li>
                                        <li><a href="#">Newest</a></li>
                                        <li><a href="#">Most comments</a></li>
                                        <li><a href="#">Release Date</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Loop Artikel Blog Dinamis -->
                    <div class="loop-grid loop-list pr-30 mb-50">
                        <?php $__empty_1 = true; $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <article class="wow fadeIn animated hover-up mb-30">
                            <?php if($blog->featured_image): ?>
                            <div class="post-thumb" style="background-image: url(<?php echo e(asset($blog->featured_image)); ?>)">
                                <div class="entry-meta">
                                    <a class="entry-meta meta-2" href="<?php echo e(route('blogs.show', $blog->slug)); ?>"><i class="fi-rs-bookmark"></i></a>
                                </div>
                            </div>
                            <?php endif; ?>
                            <div class="entry-content-2 pl-50">
                                <h3 class="post-title mb-20">
                                    <a href="<?php echo e(route('blogs.show', $blog->slug)); ?>"><?php echo e($blog->title); ?></a>
                                </h3>
                                <p class="post-exerpt mb-40"><?php echo e($blog->excerpt ?? Str::limit(strip_tags($blog->content), 150)); ?></p>
                                <div class="entry-meta meta-1 font-xs color-grey mt-10 pb-10">
                                    <div>
                                        <span class="post-on"><?php echo e(\Carbon\Carbon::parse($blog->published_at)->diffInHours() < 24 ? $blog->published_at->diffForHumans() : $blog->published_at->format('d M Y')); ?></span>
                                        <span class="hit-count has-dot">
                                            <?php
                                            $views = $blog->view_count;
                                            if ($views >= 1000000000) { $formattedViews = number_format($views / 1000000000, 1) . 'B'; }
                                            elseif ($views >= 1000000) { $formattedViews = number_format($views / 1000000, 1) . 'M'; }
                                            elseif ($views >= 1000) { $formattedViews = number_format($views / 1000, 1) . 'k'; }
                                            else { $formattedViews = $views; }
                                            ?>
                                            <?php echo e($formattedViews); ?> Views
                                        </span>
                                    </div>
                                    <a href="<?php echo e(route('blogs.show', $blog->slug)); ?>" class="text-brand font-heading font-weight-bold">Read more <i class="fi-rs-arrow-right"></i></a>
                                </div>

                                
                                <?php if (isset($component)) { $__componentOriginalde20b359b564520e5f792d5f1afd9469 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalde20b359b564520e5f792d5f1afd9469 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.blogs.blog-tags','data' => ['blog' => $blog]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('blogs.blog-tags'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['blog' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($blog)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalde20b359b564520e5f792d5f1afd9469)): ?>
<?php $attributes = $__attributesOriginalde20b359b564520e5f792d5f1afd9469; ?>
<?php unset($__attributesOriginalde20b359b564520e5f792d5f1afd9469); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalde20b359b564520e5f792d5f1afd9469)): ?>
<?php $component = $__componentOriginalde20b359b564520e5f792d5f1afd9469; ?>
<?php unset($__componentOriginalde20b359b564520e5f792d5f1afd9469); ?>
<?php endif; ?>
                            </div>
                        </article>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="alert alert-info">
                            <?php if(isset($tag)): ?>
                            Tidak ada artikel dengan tag "<strong><?php echo e($tag); ?></strong>" untuk saat ini.
                            <?php else: ?>
                            Belum ada artikel yang dipublish untuk saat ini.
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Pagination Dinamis -->
                    <div class="pagination-area mt-15 mb-sm-5 mb-lg-0">
                        <?php echo e($blogs->links()); ?>

                    </div>
                </div>

                <!-- Sidebar (col-lg-3) -->
                <div class="col-lg-3 primary-sidebar sticky-sidebar">
                    <div class="widget-area">
                        <!-- Widget Search -->
                        <div class="sidebar-widget-2 widget_search mb-50">
                            <div class="search-form">
                                <form action="<?php echo e(route('blogs.index')); ?>" method="GET">
                                    <input type="text" name="search" placeholder="Search…" value="<?php echo e(request('search')); ?>" />
                                    <button type="submit"><i class="fi-rs-search"></i></button>
                                </form>
                            </div>
                        </div>

                        <!-- Widget Popular Tags (DINAMIS) -->
                        <div class="sidebar-widget widget-tags mb-50 pb-10">
                            <h5 class="section-title style-1 mb-30">Popular Tags</h5>
                            <ul class="tags-list">
                                <?php $__empty_1 = true; $__currentLoopData = $allTags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <li class="hover-up">
                                    <a href="<?php echo e(route('blogs.by.tag', $tag)); ?>"><i class="fi-rs-cross mr-10"></i><?php echo e($tag); ?></a>
                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <li>Belum ada tag</li>
                                <?php endif; ?>
                            </ul>
                        </div>

                        <!-- Widget lainnya bisa ditambahkan di sini -->
                        <!-- Contoh: Widget Kategori, Trending E-book, dll -->
                        <!-- <div class="sidebar-widget product-sidebar mb-50 p-30 bg-grey border-radius-10">
                            <h5 class="section-title style-1 mb-30">Trending E-Books</h5>
                            
                            <p>Widget E-Book bisa ditambahkan di sini.</p>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts_lp.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJEK PROJEK\Ebook-Traveling\resources\views/blogs-index.blade.php ENDPATH**/ ?>