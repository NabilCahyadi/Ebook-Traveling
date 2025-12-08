
<?php $__env->startSection('title', 'Blogs & News - MeatMap'); ?>

<?php $__env->startSection('content'); ?>
<style>
    /* Consistent Blog Image Frame */
    .post-thumb {
        position: relative;
        overflow: hidden;
        border-radius: 15px;
        margin-bottom: 20px;
    }

    .post-thumb img {
        width: 100%;
        height: 250px;
        /* Fixed height untuk konsistensi */
        object-fit: cover;
        /* Gambar akan menyesuaikan tanpa distort */
        object-position: center;
        /* Fokus ke tengah gambar */
        transition: all 0.3s ease;
        border-radius: 15px;
    }

    .post-thumb:hover img {
        transform: scale(1.05);
    }

    /* Optional: Tambahkan overlay gradient untuk semua gambar */
    .post-thumb::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 60px;
        background: linear-gradient(transparent, rgba(0, 0, 0, 0.1));
        border-radius: 0 0 15px 15px;
        pointer-events: none;
    }

    /* Entry meta positioning */
    .entry-meta.meta-2 {
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 3;
    }

    /* Hover effects untuk article */
    .hover-up {
        transition: all 0.3s ease;
    }

    .hover-up:hover {
        transform: translateY(-5px);
    }
</style>
<style>
    .image-frame {
        position: relative;
        width: 100%;
        height: 200px;
        overflow: hidden;
        border-radius: 15px;
    }

    .image-frame img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        transition: transform 0.3s ease;
    }

    .image-frame:hover img {
        transform: scale(1.05);
    }

    .post-title {
        font-size: 19px;
        /* Ukuran default */
        line-height: 1.4;
        font-weight: 600;
    }

    .post-title a {
        color: #333;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    /* Variasi ukuran untuk post-title */
    .post-title-sm {
        font-size: 14px;
    }

    .post-title-md {
        font-size: 16px;
    }

    .post-title-lg {
        font-size: 18px;
    }

    .post-title-xl {
        font-size: 20px;
    }
</style>
<style>
    /* style agar baris jadi ... */
    .post-title {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        /* Maksimal 2 baris */
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 1.4;
        font-size: 16px;
        font-weight: 600;
        min-height: 2.8em;
        /* Untuk konsistensi tinggi */
    }

    .post-title a {
        color: #333;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .post-title a:hover {
        color: #FF4C61;
    }

    /* Optional: Untuk yang mau lebih kecil */
    .post-title-sm {
        font-size: 14px;
        min-height: 2.6em;
    }

    .post-title-md {
        font-size: 16px;
        min-height: 2.8em;
    }

    .post-title-lg {
        font-size: 18px;
        min-height: 3em;
    }
</style>
<main class="main">
    <div class="page-header mt-30 mb-30">
        <div class="container">
            <div class="archive-header">
                <div class="row align-items-center">
                    <div class="col-xl-3">
                        <h1 class="mb-15">Blog & News</h1>
                        <div class="breadcrumb">
                            <a href="/" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                            <span></span> Blog & News
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-content mb-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    
                    <div class="shop-product-fillter mb-30">
                        <div class="totall-product">
                            <h4>
                                <img class="w-36px mr-10" src="assets/imgs/theme/icons/category-1.svg" alt="" />
                                Blog & News
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

                    
                    <div class="loop-grid">
                        <div class="row">
                            <?php $__empty_1 = true; $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <article class="col-xl-3 col-lg-4 col-md-6 text-center hover-up mb-30 animated">
                                <div class="post-thumb">
                                    <div class="image-frame">
                                        <a href="<?php echo e(route('blogs.show', $blog->slug)); ?>">
                                            <img class="border-radius-15" src="<?php echo e($blog->featured_image ?: asset('images/blog-placeholder.webp')); ?>" alt="<?php echo e($blog->title); ?>" />
                                        </a>
                                    </div>
                                </div>
                                <div class="entry-content-2">
                                    <h6 class="mb-10 font-sm"><a class="entry-meta text-muted" href="#"><?php echo e($blog->category); ?></a></h6>
                                    <h5 class="post-title mb-15">
                                        <a href="<?php echo e(route('blogs.show', $blog->slug)); ?>"><?php echo e(Str::limit($blog->title, 60)); ?></a>
                                    </h5>
                                    <div class="entry-meta font-xs color-grey mt-10 pb-10">
                                        <div>
                                            <span class="post-on mr-10"><?php echo e($blog->published_at->format('d F Y')); ?></span>
                                            <span class="hit-count has-dot mr-10"><?php echo e(number_format($blog->view_count)); ?> Views</span>
                                            
                                            
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="col-12 text-center py-5">
                                <p class="text-muted">No blog posts available yet.</p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    
                    <div class="pagination-area mt-15 mb-sm-5 mb-lg-0">
                        <?php echo e($blogs->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts_lp.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJEK PROJEK\Ebook-Traveling\resources\views/blogs.blade.php ENDPATH**/ ?>