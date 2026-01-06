 

<?php $__env->startSection('title', 'Blog - MeatMap'); ?>

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
                <span class="active">‎ ‎ <?php echo e($blog->title); ?></span>
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
                                            $imageUrl = $blog->featured_image
                                                ? (filter_var($blog->featured_image, FILTER_VALIDATE_URL) 
                                                    ? $blog->featured_image 
                                                    : asset('storage/' . $blog->featured_image))
                                                : asset('images/blog-placeholder.webp');
                                        ?>
                                        <img src="<?php echo e($imageUrl); ?>" alt="<?php echo e($blog->title); ?>" />
                                    </div>
                                </figure>
                                <div class="single-content">
                                    <div class="row">
                                        <div class="col-xl-10 col-lg-12 m-auto">
                                            <p><?php echo $blog->content; ?></p>
                                            <!--Entry bottom / tags-->
                                            

                                            <?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['blog']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['blog']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
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

                                    <?php if($blog->ebooks->isNotEmpty()): ?>
                                    <?php $__currentLoopData = $blog->ebooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ebook): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="single-post clearfix">
                                        <div class="image">
                                            <img src="<?php if($ebook->cover_image && filter_var($ebook->cover_image, FILTER_VALIDATE_URL)): ?><?php echo e($ebook->cover_image); ?><?php elseif($ebook->cover_image): ?><?php echo e(asset('storage/' . $ebook->cover_image)); ?><?php else: ?><?php echo e(asset('images/ebook-placeholder.webp')); ?><?php endif; ?>" alt="<?php echo e($ebook->title); ?>" />
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