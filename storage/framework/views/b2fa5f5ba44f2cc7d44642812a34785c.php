<?php $__env->startSection('title', isset($tag) ? 'Blog Tag: ' . ucfirst($tag) . ' - MeatMap' : 'Blog & News - MeatMap'); ?>

<?php $__env->startSection('meta'); ?>
    <?php
        $metaDescription = isset($tag)
            ? "Explore articles tagged with " . ucfirst($tag) . " on MeatMap blog. Discover travel guides, tips, and stories."
            : "Read the latest travel guides, destination tips, and stories from MeatMap. Your source for travel inspiration and information.";

        $metaKeywords = isset($tag) ? $tag . ", " : "";
        $metaKeywords .= "blog, travel, destinations, guides, meatmap";

        $ogTitle = isset($tag) ? "Blog Tag: " . ucfirst($tag) . " - MeatMap" : "Blog & News - MeatMap";
        $ogDescription = isset($tag)
            ? "Explore articles tagged with " . ucfirst($tag) . " on MeatMap blog."
            : "Read the latest travel guides and stories from MeatMap.";
        $twitterDescription = isset($tag)
            ? "Explore articles tagged with " . ucfirst($tag) . "."
            : "Read the latest travel guides from MeatMap.";
    ?>
    <meta name="description" content="<?php echo e($metaDescription); ?>">
    <meta name="keywords" content="<?php echo e($metaKeywords); ?>">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?php echo e(url()->current()); ?>">

    
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?php echo e($ogTitle); ?>">
    <meta property="og:description" content="<?php echo e($ogDescription); ?>">
    <meta property="og:url" content="<?php echo e(url()->current()); ?>">
    <meta property="og:site_name" content="MeatMap">
    <meta property="og:image" content="<?php echo e(asset('images/only-logoo.png')); ?>">

    
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="<?php echo e($ogTitle); ?>">
    <meta name="twitter:description" content="<?php echo e($twitterDescription); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<style>
    .post-thumb {
        margin-left: 20px;
        border-radius: 10px;
    }

    /* Empty State Styling */
    .empty-state-blog {
        padding: 50px 40px !important;
        margin: 40px 0;
        transition: all 0.3s ease;
    }

    .empty-state-blog .empty-icon {
        animation: floatIcon 3s ease-in-out infinite;
    }

    @keyframes floatIcon {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-10px);
        }
    }

    .empty-state-blog h4 {
        font-weight: 700;
        font-size: 1.5rem;
    }

    .empty-state-blog p {
        font-size: 1rem;
        line-height: 1.6;
        max-width: 550px;
        margin: 0 auto 1.5rem;
    }

    .empty-state-blog .btn-brand {
        background-color: #FF4C61;
        color: white;
        padding: 10px 25px;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .empty-state-blog .btn-brand:hover {
        background-color: #e03a4d;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 76, 97, 0.3);
        color: white;
    }

    .text-brand {
        color: #FF4C61 !important;
    }
</style>
<main class="main">
    <!-- Page Header -->
    <div class="page-header mt-30 mb-35">
        <div class="container">
            <div class="archive-header">
                <div class="row align-items-center">
                    <div class="col-xl-3">
                        <h3 class="mb-15">Tags Blog</h3>
                        <div class="breadcrumb">
                            <a href="<?php echo e(route('home')); ?>" rel="nofollow"><i class="fi fi-rs-home mr-5"></i>Home</a>
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
                                All Articles
                                <?php endif; ?>
                            </h4>
                        </div>
                        <?php
                            $perPage = request('per_page', 20);
                            $sortBy = request('sort_by', 'newest');

                            $perPageOptions = [
                                20 => '20',
                                40 => '40',
                                60 => '60',
                                80 => '80',
                                100 => '100',
                                'all' => 'All'
                            ];

                            $sortOptions = [
                                'newest' => 'Newest',
                                'oldest' => 'Oldest',
                                'most_viewed' => 'Most Viewed',
                                'title' => 'Title (A-Z)'
                            ];
                        ?>
                        <div class="sort-by-product-area">
                            <div class="sort-by-cover mr-10">
                                <div class="sort-by-product-wrap">
                                    <div class="sort-by">
                                        <span><i class="fi fi-rs-apps"></i>Show :</span>
                                    </div>
                                    <div class="sort-by-dropdown-wrap">
                                        <span><?php echo e($perPageOptions[$perPage] ?? '10'); ?> <i class="fi fi-rs-angle-small-down"></i></span>
                                    </div>
                                </div>
                                <div class="sort-by-dropdown">
                                    <ul>
                                        <?php $__currentLoopData = $perPageOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li>
                                            <a class="<?php echo e($perPage == $value ? 'active' : ''); ?>"
                                               href="<?php echo e(request()->fullUrlWithQuery(['per_page' => $value, 'page' => 1])); ?>">
                                                <?php echo e($label); ?>

                                            </a>
                                        </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="sort-by-cover">
                                <div class="sort-by-product-wrap">
                                    <div class="sort-by">
                                        <span><i class="fi fi-rs-apps-sort"></i>Sort :</span>
                                    </div>
                                    <div class="sort-by-dropdown-wrap">
                                        <span><?php echo e($sortOptions[$sortBy] ?? 'Newest'); ?> <i class="fi fi-rs-angle-small-down"></i></span>
                                    </div>
                                </div>
                                <div class="sort-by-dropdown">
                                    <ul>
                                        <?php $__currentLoopData = $sortOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li>
                                            <a class="<?php echo e($sortBy == $value ? 'active' : ''); ?>"
                                               href="<?php echo e(request()->fullUrlWithQuery(['sort_by' => $value, 'page' => 1])); ?>">
                                                <?php echo e($label); ?>

                                            </a>
                                        </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                            <?php
                                // Check if image is external URL or local storage
                                $imageUrl = $blog->featured_image_url;
                            ?>
                            <div class="post-thumb" style="background-image: url(<?php echo e($imageUrl); ?>)">
                                <!-- <div class="entry-meta">
                                    <a class="entry-meta meta-2" href="<?php echo e(route('blogs.show', $blog->slug)); ?>"><i class="fi fi-rs-bookmark"></i></a>
                                </div> -->
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
                                    <a href="<?php echo e(route('blogs.show', $blog->slug)); ?>" class="text-brand font-heading font-weight-bold">Read more <i class="fi fi-rs-arrow-right"></i></a>
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
                        <div class="empty-state-blog text-center py-5">
                            <div class="empty-icon mb-4">
                                <i class="fi fi-rs-document" style="font-size: 4rem; color: #FF4C61;"></i>
                            </div>
                            <?php if(isset($tag)): ?>
                            <h4 class="mb-3" style="color: #253D4E;">No Articles Found</h4>
                            <p class="text-muted mb-4">
                                We couldn't find any articles tagged with "<strong class="text-brand"><?php echo e($tag); ?></strong>" at the moment.
                                <br>
                                Try exploring other tags or check back later for new content.
                            </p>
                            <?php else: ?>
                            <h4 class="mb-3" style="color: #253D4E;">No Articles Published Yet</h4>
                            <p class="text-muted mb-4">
                                We're working on bringing you amazing content. Stay tuned for our latest travel guides and stories!
                            </p>
                            <?php endif; ?>
                            <a href="<?php echo e(route('blogs.index')); ?>" class="btn btn-sm btn-brand">
                                <i class="fi fi-rs-arrow-left mr-2"></i> Back to All Articles
                            </a>
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
                        <!-- Widget Popular Tags (DINAMIS) -->
                        <div class="sidebar-widget widget-tags mb-50 pb-10">
                            <h5 class="section-title style-1 mb-30">Popular Tags</h5>
                            <ul class="tags-list">
                                
                                <?php $__empty_1 = true; $__currentLoopData = $popularTags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <li class="hover-up">
                                    <a href="<?php echo e(route('blogs.by.tag', $tag)); ?>"><i class="fi fi-rs-cross mr-10"></i><?php echo e($tag); ?></a>
                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <li>No popular tags yet.</li> 
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts_lp.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\blogs-index.blade.php ENDPATH**/ ?>