<?php $__env->startSection('title', $ebook->title); ?>

<?php $__env->startSection('content'); ?>
<style>
    .ebook-cover-frame img {
        display: block;
        max-width: 100%;
        height: 100%;
    }

    /* --- Style untuk Cover Image --- */
    .ebook-cover-frame {
        width: 100%;
        height: 450px;
        /* Beri tinggi tetap untuk konsistensi tampilan */
        border-radius: 10px;
        padding: 10px;
        background-color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        /* Pastikan tidak ada yang meluber dari frame */
    }

    .ebook-cover-frame img {
        max-width: 100%;
        max-height: 100%;
        object-fit: cover;
        /* KUNCINYA: Gambar akan memenuhi frame tanpa merubah aspek rasio */
        border-radius: 5px;
        transition: transform 0.3s ease;
        /* Tambahkan efek hover yang halus */
    }

    .ebook-cover-frame:hover img {
        transform: scale(1.05);
        /* Sedikit zoom saat hover */
    }
</style>

<style>
    .single-comment {
        min-height: 150px;
        /* Atur tinggi minimum yang konsisten */
    }

    .single-comment .desc {
        flex-grow: 1;
    }

    .single-comment .thumb {
        width: 80px;
        flex-shrink: 0;
    }

    .single-comment .thumb img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
    }
</style>

<style>
    .review-container {
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .rating-container {
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 20px;
        height: fit-content;
    }

    .single-comment {
        padding: 15px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .single-comment:last-child {
        border-bottom: none;
    }

    .single-comment:hover {
        background-color: transparent !important;
        box-shadow: none !important;
        transform: none !important;
    }

    .avatar-container {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        overflow: hidden;
        flex-shrink: 0;
        background-color: #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .user-avatar {
        width: auto;
        height: 100%;
        object-fit: contain;
        display: block;
    }

    .username {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 200px;
        font-weight: 600;
        color: #FF4C61;
        text-decoration: none;
    }

    .review-date {
        font-size: 0.8rem;
        color: #6c757d;
        line-height: 13px;
        margin-left: 5px;
    }

    .review-text {
        margin-top: 10px;
        line-height: 1.5;
    }

    /* .rating-label {
        font-size: 0.9rem;
        color: #495057;
    }

    .rating-value {
        font-size: 0.85rem;
        color: #6c757d;
    }

    .average-score {
        font-size: 1.2rem;
        font-weight: 600;
    } */

    .card {
        border: 1px solid #e9ecef;
        border-radius: 8px;
    }

    .card-body {
        padding: 20px;
    }

    .page-link.dot {
        padding: 0 10px;
    }

    .showing-info {
        font-size: 0.9rem;
        color: #6c757d;
        margin-bottom: 20px;
    }

    .review-header {
        display: flex;
        /* justify-content: space-between; */
        align-items: left;
        margin-bottom: 10px;
    }

    .review-user {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }
</style>

<style>
    .alert-custom-info {
        background-color: #e7f5ff;
        border-color: #bde0fe;
        color: #055160;
    }

    .alert-custom-info .large-icon {
        font-size: 2rem;
        color: #339af0;
    }
</style>

<style>
    /* Salin CSS yang diperlukan dari template koleksi */
    /* Gaya Umum untuk Kartu */
    .product-cart-wrap {
        border: 1px solid rgba(255, 255, 255, 0.05);
        transition: all 0.3s ease;
    }

    /* Gaya untuk Judul Buku */
    .product-cart-wrap h2 {
        font-size: 1.1rem;
        line-height: 1.4;
        margin-bottom: 0.5rem;
        min-height: 3.2em;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .product-author {
        font-size: 0.9rem;
        color: var(--text-color-muted);
        margin-bottom: 0.75rem;
    }

    /* Gaya untuk Deskripsi Buku */
    .product-description {
        font-size: 0.85rem;
        color: var(--text-color-muted);
        margin-bottom: 1rem;
        margin-top: -20px;
        min-height: 2.5em;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .product-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        font-size: 0.8rem;
    }

    .read-count {
        color: var(--text-color-muted);
    }

    /* --- Badge Bahasa --- */
    .badge-language {
        color: #fff;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    /* --- Gaya untuk Tombol Aksi --- */
    .action-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        margin-top: 15px;
    }

    .btn-read-now {
        background-color: #FF4C61;
        color: #fff;
    }

    .btn-read-now:hover {
        background-color: #e64356;
        color: #fff;
    }

    .btn-subscribe-now {
        background: #FF4C61;
        color: #fff;
    }

    .btn-subscribe-now:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 76, 97, 0.4);
        color: #FF4C61;
        background-color: #fff;
    }

    /* --- CSS untuk Read More/Less Link --- */
    .review-text-container .read-more-link {
        color: #FF4C61;
        /* Warna link biru, bisa disesuaikan */
        font-weight: bold;
        font-size: 0.9em;
        cursor: pointer;
        text-decoration: none;
        transition: color 0.2s;
    }

    .review-text-container .read-more-link:hover {
        color: #df1e35ff;
        text-decoration: underline;
    }
</style>

<main class="main">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="<?php echo e(route('home')); ?>" rel="nofollow"><i class="fi-rs-home mr-5"></i></a>
                <span></span>
                <a href="/">E-Books</a>
                <span class="active">‎ ‎ <?php echo e($ebook->title); ?></span>
            </div>
        </div>
    </div>
    <div class="container mb-30">
        <div class="row">
            <div class="col-xl-10 col-lg-12 m-auto">
                <div class="product-detail accordion-detail">
                    <div class="row mb-50 mt-30">
                        <div class="col-md-3 col-sm-12 col-xs-12 mb-md-0 mb-sm-5">
                            <div class="detail-gallery">
                                <!-- GAMBAR DIBUNGKUS DENGAN FRAME KHUSUS -->
                                <div class="ebook-cover-frame">
                                    <img src="<?php echo e(asset($ebook->cover_image)); ?>" alt="<?php echo e($ebook->title); ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9 col-sm-12 col-xs-12">
                            <div class="detail-info pr-30 pl-30">
                                <?php if($ebook->is_featured): ?>
                                <span class="stock-status out-stock"> Featured </span>
                                <?php endif; ?>
                                <h2 class="title-detail"><?php echo e($ebook->title); ?></h2>
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
                                <div class="short-desc mb-30">
                                    <p class="font-lg"><?php echo e($ebook->description); ?></p>
                                </div>
                                <div class="font-xs">
                                    <ul class="mr-50 float-start">
                                        <li class="mb-5">Creator : <span class="text-brand"><?php echo e($ebook->creator->pen_name ?? $ebook->author); ?></span></li>
                                        <li class="mb-5">
                                            Language :
                                            <span class="text-brand">
                                                <?php if($ebook->language === 'en'): ?>
                                                English
                                                <?php elseif($ebook->language === 'id'): ?>
                                                Indonesian
                                                <?php else: ?>
                                                <?php echo e($ebook->language); ?> 
                                                <?php endif; ?>
                                            </span>
                                        </li>
                                        <li>Published : <span class="text-brand"><?php echo e(\Carbon\Carbon::parse($ebook->published_at)->format('d M Y')); ?></span></li>
                                        <li>
                                            <?php if(auth()->check() && auth()->user()->hasActiveSubscription()): ?>
                                            <a href="/reader/<?php echo e($ebook->slug); ?>" class="action-btn btn-read-now">
                                                <i class="fi-rs-book-open"></i>
                                                <span>Read Now</span>
                                            </a>
                                            <?php else: ?>
                                            <a href="/pricing" class="action-btn btn-subscribe-now">
                                                <i class="fi-rs-lock"></i>
                                                <span>Subscribe to Read</span>
                                            </a>
                                            <?php endif; ?>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="comments-area">
                        <div class="row">
                            <!-- BAGIAN KIRI: DAFTAR REVIEW -->
                            <div class="col-lg-8">
                                <div class="review-container">
                                    <h4 class="mb-10">Customer Reviews ( <?php echo e($ratings->total()); ?> ) </h4>
                                    <div class="showing-info">Showing <?php echo e($ratings->firstItem()); ?> to <?php echo e($ratings->lastItem()); ?> of <?php echo e($ratings->total()); ?> reviews</div>

                                    <div class="comment-list">
                                        <?php $__empty_1 = true; $__currentLoopData = $ratings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rating): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <div class="single-comment mb-30">
                                            <div class="review-header">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: <?php echo e(($rating->rating / 5) * 100); ?>%"></div>
                                                </div>
                                                <div class="review-date"><?php echo e($rating->created_at->format('F d, Y')); ?></div>
                                            </div>
                                            <div class="review-user">
                                                <div class="avatar-container">
                                                    <img src="<?php echo e($rating->user->avatar ? asset('storage/' . $rating->user->avatar) : asset('/images/user-avatar.png')); ?>" alt="<?php echo e($rating->user->name); ?>" class="user-avatar" />
                                                </div>
                                                <a href="" class="username ms-3"><?php echo e($rating->user->name); ?></a>
                                            </div>
                                            <div class="review-text-container">
                                                
                                                <p class="truncated-text"><?php echo e(Str::limit($rating->review_text, 180)); ?></p>

                                                
                                                <p class="full-text" style="display: none;"><?php echo e($rating->review_text); ?></p>

                                                
                                                <?php if(Str::length($rating->review_text) > 150): ?>
                                                <a href="#" class="read-more-link">more</a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <div class="single-comment mb-30">
                                            <p>There are no reviews for this e-book yet.</p>
                                        </div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- PAGINASI -->
                                    <?php if($ratings->hasPages()): ?>
                                    <div class="pagination-area mt-15 mb-sm-5 mb-lg-0">
                                        <?php echo e($ratings->links('pagination::bootstrap-4')); ?>

                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- BAGIAN KANAN: SIDEBAR RATING -->
                            <div class="col-lg-4">
                                <div class="rating-container">
                                    <h4 class="mb-30">Average Rating</h4>
                                    <div class="d-flex mb-30">
                                        <div class="product-rate d-inline-block mr-15">
                                            <div class="product-rating" style="width: <?php echo e(($ebook->ratings()->avg('rating') / 5) * 100); ?>%"></div>
                                        </div>
                                        <h6><?php echo e(number_format($ebook->ratings()->avg('rating'), 1)); ?> out of 5</h6>
                                    </div>

                                    
                                    <div class="d-flex align-items-center mb-15">
                                        <span class="me-3" style="width: 50px;">5 star</span>
                                        <div class="progress flex-grow-1">
                                            <div class="progress-bar" role="progressbar" style="width: <?php echo e(($ebook->total_reviews > 0) ? ($ratingDistribution[5] / $ebook->total_reviews) * 100 : 0); ?>%" aria-valuenow="<?php echo e(($ebook->total_reviews > 0) ? ($ratingDistribution[5] / $ebook->total_reviews) * 100 : 0); ?>" aria-valuemin="0" aria-valuemax="100">
                                                <?php echo e(($ebook->total_reviews > 0) ? number_format(($ratingDistribution[5] / $ebook->total_reviews) * 100) : 0); ?>%
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mb-15">
                                        <span class="me-3" style="width: 50px;">4 star</span>
                                        <div class="progress flex-grow-1">
                                            <div class="progress-bar" role="progressbar" style="width: <?php echo e(($ebook->total_reviews > 0) ? ($ratingDistribution[4] / $ebook->total_reviews) * 100 : 0); ?>%" aria-valuenow="<?php echo e(($ebook->total_reviews > 0) ? ($ratingDistribution[4] / $ebook->total_reviews) * 100 : 0); ?>" aria-valuemin="0" aria-valuemax="100">
                                                <?php echo e(($ebook->total_reviews > 0) ? number_format(($ratingDistribution[4] / $ebook->total_reviews) * 100) : 0); ?>%
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mb-15">
                                        <span class="me-3" style="width: 50px;">3 star</span>
                                        <div class="progress flex-grow-1">
                                            <div class="progress-bar" role="progressbar" style="width: <?php echo e(($ebook->total_reviews > 0) ? ($ratingDistribution[3] / $ebook->total_reviews) * 100 : 0); ?>%" aria-valuenow="<?php echo e(($ebook->total_reviews > 0) ? ($ratingDistribution[3] / $ebook->total_reviews) * 100 : 0); ?>" aria-valuemin="0" aria-valuemax="100">
                                                <?php echo e(($ebook->total_reviews > 0) ? number_format(($ratingDistribution[3] / $ebook->total_reviews) * 100) : 0); ?>%
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mb-15">
                                        <span class="me-3" style="width: 50px;">2 star</span>
                                        <div class="progress flex-grow-1">
                                            <div class="progress-bar" role="progressbar" style="width: <?php echo e(($ebook->total_reviews > 0) ? ($ratingDistribution[2] / $ebook->total_reviews) * 100 : 0); ?>%" aria-valuenow="<?php echo e(($ebook->total_reviews > 0) ? ($ratingDistribution[2] / $ebook->total_reviews) * 100 : 0); ?>" aria-valuemin="0" aria-valuemax="100">
                                                <?php echo e(($ebook->total_reviews > 0) ? number_format(($ratingDistribution[2] / $ebook->total_reviews) * 100) : 0); ?>%
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mb-30">
                                        <span class="me-3" style="width: 50px;">1 star</span>
                                        <div class="progress flex-grow-1">
                                            <div class="progress-bar" role="progressbar" style="width: <?php echo e(($ebook->total_reviews > 0) ? ($ratingDistribution[1] / $ebook->total_reviews) * 100 : 0); ?>%" aria-valuenow="<?php echo e(($ebook->total_reviews > 0) ? ($ratingDistribution[1] / $ebook->total_reviews) * 100 : 0); ?>" aria-valuemin="0" aria-valuemax="100">
                                                <?php echo e(($ebook->total_reviews > 0) ? number_format(($ratingDistribution[1] / $ebook->total_reviews) * 100) : 0); ?>%
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="comment-form">
                        <h4 class="mb-15">Add a review</h4>

                        
                        <?php if(auth()->check()): ?>

                        
                        <?php if(auth()->user()->hasActiveSubscription()): ?>

                        
                        <?php if(!$hasReviewed): ?>
                        
                        <form class="form-contact comment_form" action="<?php echo e(route('ratings.store')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="ebook_id" value="<?php echo e($ebook->id); ?>">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <textarea class="form-control w-100" name="review_text" id="comment" cols="30" rows="9" placeholder="Write Comment" required></textarea>
                                    </div>
                                </div>
                                <!-- <div class="col-sm-6">
                                    <div class="form-group">
                                        <input class="form-control" name="name" id="name" type="text" placeholder="Name" value="<?php echo e(auth()->user()->name); ?>" disabled />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input class="form-control" name="email" id="email" type="email" placeholder="Email" value="<?php echo e(auth()->user()->email); ?>" disabled />
                                    </div>
                                </div> -->
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Rating</label>
                                        <select name="rating" class="form-control">
                                            <option value="5">5 - Excellent</option>
                                            <option value="4">4 - Very Good</option>
                                            <option value="3">3 - Average</option>
                                            <option value="2">2 - Poor</option>
                                            <option value="1">1 - Terrible</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="button button-contactForm">Submit Review</button>
                            </div>
                        </form>

                        <?php else: ?>
                        
                        <div class="alert alert-success">
                            <p>You have already submitted a review for this ebook.</p>
                        </div>
                        <?php endif; ?>

                        <?php else: ?>
                        
                        <div class="alert alert-warning">
                            <h5 style="margin-bottom: 10px;">Premium Feature</h5>
                            <p style="margin-bottom: 10px;">To give a rating and review, you need to upgrade your account to Premium.</p>
                            <a href="<?php echo e(route('pricing')); ?>" class="btn btn-warning">Subscribe Now</a>
                        </div>
                        <?php endif; ?>

                        <?php else: ?>
                        
                        <div class="alert alert-custom-info d-flex align-items-center" role="alert">
                            <div class="flex-shrink-0">
                                <i class="fi fi-rr-lock large-icon"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="mb-3">Sign in or create a free account to share your thoughts about this book.</p>
                                <div>
                                    <a href="<?php echo e(route('login')); ?>" class="btn btn-primary btn-sm me-2">
                                        <i class="fi fi-rr-sign-in-alt me-1"></i> Login
                                    </a>
                                    <a href="<?php echo e(route('login')); ?>?form=register" class="btn btn-sm">
                                        <i class="fi fi-rr-user-add me-1"></i> Register
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                
                <div class="row mt-60">
                    <div class="col-12">
                        
                        <h2 class="section-title style-1 mb-30">More options for you</h2>
                    </div>
                    <div class="col-12">
                        <div class="row related-products">
                            
                            <?php
                            $moreOptionsEbooks = App\Models\Ebook::inRandomOrder()->get();
                            ?>

                            <?php $__empty_1 = true; $__currentLoopData = $moreOptionsEbooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ebook): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            
                            <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                                <div class="product-cart-wrap mb-30 hover-up wow animate__animated animate__fadeIn" data-wow-delay="<?php echo e(($loop->index + 1) * 0.1); ?>s">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img product-img-zoom">
                                            <a href="<?php echo e(route('ebooks.show', $ebook->slug)); ?>">
                                                <img class="default-img" src="<?php echo e($ebook->cover_image ?: 'assets-nest/nest-fe/imgs/shop/product-1-1.jpg'); ?>" alt="<?php echo e($ebook->title); ?>" />
                                            </a>
                                        </div>
                                        <div class="product-badges product-badges-position product-badges-mrg">
                                            <span class="badge-language hot"><?php echo e(strtoupper($ebook->language)); ?></span>
                                        </div>
                                    </div>
                                    <div class="product-content-wrap">
                                        <h2 style="margin-top:15px;"><a href="<?php echo e(route('ebooks.show', $ebook->slug)); ?>"><?php echo e(Str::limit($ebook->title, 40)); ?></a></h2>

                                        <div class="product-author" style="margin-bottom:-4px;">
                                            <?php if($ebook->creator): ?>
                                            <span>by <?php echo e($ebook->creator->pen_name ?? $ebook->creator->user->name); ?></span>
                                            <?php else: ?>
                                            <span>by Unknown Author</span>
                                            <?php endif; ?>
                                        </div>

                                        <div class="product-meta">
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
                                            <div class="read-count">
                                                <i class="fi-rs-eye align-middle"></i>
                                                <span class="post-on">
                                                    <?php
                                                    $views = $ebook->view_count;
                                                    if ($views >= 1000000000) {
                                                    $formattedViews = number_format($views / 1000000000, 1) . 'B';
                                                    } elseif ($views >= 1000000) {
                                                    $formattedViews = number_format($views / 1000000, 1) . 'M';
                                                    } elseif ($views >= 1000) {
                                                    $formattedViews = number_format($views / 1000, 1) . 'k';
                                                    } else {
                                                    $formattedViews = $views;
                                                    }
                                                    ?>
                                                    <?php echo e($formattedViews); ?>

                                                </span>
                                            </div>
                                        </div>

                                        <p class="product-description"><?php echo e($ebook->short_description); ?></p>

                                        
                                        <?php if(auth()->check() && auth()->user()->hasActiveSubscription()): ?>
                                        <a href="/reader/<?php echo e($ebook->slug); ?>" class="action-btn btn-read-now">
                                            <i class="fi-rs-book-open"></i>
                                            <span>Read Now</span>
                                        </a>
                                        <?php else: ?>
                                        <a href="/pricing" class="action-btn btn-subscribe-now">
                                            <i class="fi-rs-lock"></i>
                                            <span>Subscribe to Read</span>
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p>Belum ada e-book lain untuk saat ini.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- Tambahkan ini sebelum </body> -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const readMoreLinks = document.querySelectorAll('.read-more-link');

        readMoreLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault(); // Mencegah link meloncat ke atas

                const container = this.closest('.review-text-container');
                const fullText = container.querySelector('.full-text');
                const truncatedText = container.querySelector('.truncated-text');

                if (fullText.style.display === 'none') {
                    // Jika teks lengkap tersembunyi, tampilkan
                    fullText.style.display = 'block';
                    truncatedText.style.display = 'none';
                    this.textContent = 'less'; // Ubah teks link menjadi "less"
                } else {
                    // Jika teks lengkap terlihat, sembunyikan kembali
                    fullText.style.display = 'none';
                    truncatedText.style.display = 'block';
                    this.textContent = 'more'; // Ubah teks link menjadi "more"
                }
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts_lp.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJEK PROJEK\Ebook-Traveling\resources\views/ebooks-detail.blade.php ENDPATH**/ ?>