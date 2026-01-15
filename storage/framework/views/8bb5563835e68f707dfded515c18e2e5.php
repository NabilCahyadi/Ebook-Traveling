<?php $__env->startSection('title', $blog->meta_title ?: $blog->title . ' - MeatMap Blog'); ?>

<?php $__env->startSection('meta'); ?>
    
    <meta name="description" content="<?php echo e($blog->meta_description ?: Str::limit(strip_tags($blog->content), 160)); ?>">
    <meta name="keywords" content="<?php echo e($blog->meta_keywords ?: ($blog->tags ? implode(', ', $blog->tags) : 'blog, travel, meatmap')); ?>">
    <meta name="author" content="MeatMap Team">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?php echo e(url()->current()); ?>">
    
    
    <meta property="og:type" content="article">
    <meta property="og:title" content="<?php echo e($blog->meta_title ?: $blog->title); ?>">
    <meta property="og:description" content="<?php echo e($blog->meta_description ?: Str::limit(strip_tags($blog->content), 160)); ?>">
    <meta property="og:url" content="<?php echo e(url()->current()); ?>">
    <meta property="og:site_name" content="MeatMap">
    <meta property="og:image" content="<?php echo e($blog->featured_image_url); ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="article:published_time" content="<?php echo e($blog->published_at->toIso8601String()); ?>">
    <meta property="article:modified_time" content="<?php echo e($blog->updated_at->toIso8601String()); ?>">
    <meta property="article:author" content="MeatMap Team">
    <?php if($blog->tags): ?>
        <?php $__currentLoopData = $blog->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <meta property="article:tag" content="<?php echo e($tag); ?>">
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
    
    
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo e($blog->meta_title ?: $blog->title); ?>">
    <meta name="twitter:description" content="<?php echo e($blog->meta_description ?: Str::limit(strip_tags($blog->content), 160)); ?>">
    <meta name="twitter:image" content="<?php echo e($blog->featured_image_url); ?>">
    
    
    <?php
        $imageUrl = $blog->featured_image_url;
        
        $schemaKeywords = $blog->tags ? implode(', ', $blog->tags) : '';
        
        // Build JSON-LD schema as PHP array
        $schemaData = [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $blog->title,
            'description' => $blog->meta_description ?: Str::limit(strip_tags($blog->content), 160),
            'image' => $imageUrl,
            'author' => [
                '@type' => 'Organization',
                'name' => 'MeatMap Team'
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'MeatMap',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('images/only-logoo.png')
                ]
            ],
            'datePublished' => $blog->published_at->toIso8601String(),
            'dateModified' => $blog->updated_at->toIso8601String(),
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => url()->current()
            ]
        ];
        
        // Add keywords only if they exist
        if ($schemaKeywords) {
            $schemaData['keywords'] = $schemaKeywords;
        }
    ?>
    <script type="application/ld+json">
    <?php echo json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>

    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<style>
    /* Untuk memperbesar gambar utama di halaman detail blog */
    .single-thumbnail {
        height: 500px;
        width: 100%;
        border-radius: 15px;
        overflow: hidden;
    }

    .single-thumbnail img {
        width: 800px;
        height: 100%;
        object-position: right;
    }

    .main-content-wrapper {
        display: flex;
        /* Jadikan wrapper sebagai flex container */
        flex-direction: column;
        /* Susun anak-anaknya secara vertikal */
    }
</style>
<main class="main">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="<?php echo e(route('home')); ?>" rel="nofollow"><i class="fi-rs-home mr-5"></i></a>
                <span></span>
                <a href="<?php echo e(route('blogs.index')); ?>">Blog & News</a>
                <span class="active"> <?php echo e($blog->title); ?></span>
            </div>
        </div>
    </div>
    <div class="page-content mb-50">
        <div class="container">
            <div class="row">
                <div class="col-xl-11 col-lg-12 main-content-wrapper">
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="single-page pt-50 pr-30">
                                <div class="single-header style-2">
                                    <div class="row">
                                        <div class="col-xl-10 col-lg-12 m-auto">
                                            <h6 class="mb-10"><a href="#"><?php echo e($blog->category); ?></a></h6>
                                            <h2 class="mb-10"><?php echo e($blog->title); ?></h2>
                                            <div class="single-header-meta">
                                                <div class="entry-meta meta-1 font-xs mt-15 mb-15">
                                                    <a class="author-avatar fs-4" href="#">
                                                        <i class="bi bi-person-circle mr-10"></i>
                                                    </a>
                                                    <!-- <span class="post-by">By <a href=""><?php echo e(optional($blog->author)->name ?? 'Anonymous'); ?></a></span> -->
                                                    <span class="post-by">By <a href="">MeatMap Team</a></span>
                                                    <span class="post-on has-dot"><?php echo e(\Carbon\Carbon::parse($blog->published_at)->diffInHours() < 24 ? $blog->published_at->diffForHumans() : $blog->published_at->format('d M Y')); ?></span>
                                                    <span class="post-on has-dot">
                                                        <?php
                                                        $views = $blog->view_count;
                                                        if ($views >= 1000000000) { // 1 Miliar
                                                        $formattedViews = number_format($views / 1000000000, 1) . 'B';
                                                        } elseif ($views >= 1000000) { // 1 Juta
                                                        $formattedViews = number_format($views / 1000000, 1) . 'M';
                                                        } elseif ($views >= 1000) { // 1 Ribu
                                                        $formattedViews = number_format($views / 1000, 1) . 'k';
                                                        } else {
                                                        $formattedViews = $views;
                                                        }
                                                        ?>
                                                        <?php echo e($formattedViews); ?> Views
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <figure class="single-thumbnail">
                                    <div class="col-xl-10 col-lg-12 m-auto">
                                        <?php
                                            // Check if image is external URL or local storage
                                            $imageUrl = $blog->featured_image_url;
                                        ?>
                                        <img src="<?php echo e($imageUrl); ?>" alt="<?php echo e($blog->title); ?>" />
                                    </div>
                                </figure>
                                <div class="single-content">
                                    <div class="row">
                                        <div class="col-xl-10 col-lg-12 m-auto">
                                            <p><?php echo $blog->content; ?></p>
                                            <!--Entry bottom / tags-->
                                            <?php if(isset($blog) && $blog->tags && count($blog->tags) > 0): ?>
                                            <div class="entry-bottom mt-50 mb-30">
                                                <div class="d-flex flex-wrap align-items-center">
                                                    <?php $__currentLoopData = $blog->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <a href="<?php echo e(route('blogs.by.tag', ['tag' => $tag])); ?>" rel="tag" class="hover-up btn btn-sm btn-rounded me-2 mb-2">
                                                        <?php echo e($tag); ?>

                                                    </a>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 primary-sidebar sticky-sidebar pt-50">
                            <div class="widget-area">
                                <div class="sidebar-widget-2 widget_search mb-50">
                                    <div class="search-form">
                                        <form action="#">
                                            <input type="text" placeholder="Search…" />
                                            <button type="submit"><i class="fi-rs-search"></i></button>
                                        </form>
                                    </div>
                                </div>
                                <!-- Product sidebar Widget -->
                                <div class="sidebar-widget product-sidebar mb-50 p-30 bg-grey border-radius-10">
                                    <h5 class="section-title style-1 mb-30">Related E-Books</h5>

                                    <?php if($blog->ebooks && $blog->ebooks->isNotEmpty()): ?>
                                        <?php $__currentLoopData = $blog->ebooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ebook): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="single-post clearfix">
                                            <div class="image">
                                                <?php
                                                    $ebookImageUrl = $ebook->cover_image && filter_var($ebook->cover_image, FILTER_VALIDATE_URL) 
                                                        ? $ebook->cover_image 
                                                        : ($ebook->cover_image 
                                                            ? asset('storage/' . $ebook->cover_image) 
                                                            : asset('images/ebook-placeholder.webp'));
                                                ?>
                                                <img src="<?php echo e($ebookImageUrl); ?>" alt="<?php echo e($ebook->title); ?>" />
                                            </div>
                                            <div class="content pt-10">
                                                <h6><a href="<?php echo e(route('ebooks.show', $ebook->slug)); ?>"><?php echo e($ebook->title); ?></a></h6>
                                                <div class="product-detail-rating">
                                                    <div class="product-rate-cover text-end">
                                                        <div class="product-rate-cover">
                                                            <div class="product-rate d-inline-block">
                                                                <div class="product-rating" style="width: <?php echo e(($ebook->ratings()->avg('rating') / 5) * 100); ?>%"></div>
                                                            </div>
                                                            <span class="font-small ml-5 text-muted">(<?php echo e(round($ebook->ratings()->avg('rating'), 2)); ?>)</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <p>Belum ada e-book terkait untuk artikel ini.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts_lp.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views/blog-detail.blade.php ENDPATH**/ ?>