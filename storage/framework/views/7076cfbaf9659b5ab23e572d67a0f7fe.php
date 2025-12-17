<?php
// Pastikan $collections selalu ada
if (!isset($collections)) {
$collections = collect();
}
?>


<?php $__env->startSection('title', 'Home - MeatMap'); ?>

<?php $__env->startSection('content'); ?>
<style>
    /* Scroll Container Styles */
    .products-scroll-container {
        position: relative;
        overflow: hidden;
        padding: 0 60px;
        /* Space for arrows */
    }

    .scroll-wrapper {
        display: flex;
        transition: transform 0.3s ease;
        flex-wrap: nowrap;
        /* Prevent wrapping */
        margin: 0;
    }

    .scroll-item {
        flex: 0 0 20%;
        padding: 0 10px;
        min-width: 20%;
        box-sizing: border-box;
    }

    /* Scroll Buttons */
    .scroll-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 44px;
        height: 44px;
        background: #F2F3F4;
        /* Default bg color */
        color: #7E7E7E;
        /* Default icon color */
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        transition: all 0.3s ease;
        opacity: 1;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .scroll-btn:hover:not(:disabled) {
        background: #FF4C61;
        /* Hover bg color */
        color: white;
        /* Hover icon color */
        transform: translateY(-50%) scale(1.05);
        box-shadow: 0 4px 12px rgba(255, 76, 97, 0.3);
    }

    .scroll-btn:disabled {
        background: #F2F3F4;
        color: #CCCCCC;
        cursor: not-allowed;
        opacity: 0.6;
        transform: translateY(-50%);
    }

    .scroll-btn:disabled:hover {
        background: #F2F3F4;
        color: #CCCCCC;
        transform: translateY(-50%);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .scroll-left {
        left: 10px;
    }

    .scroll-right {
        right: 10px;
    }

    /* Container adjustment for perfect 5 items */
    .container {
        position: relative;
    }

    /* Ensure products take full width */
    .product-grid-4 {
        width: 100%;
        margin: 0;
    }

    /* Hide scrollbar but keep functionality */
    .products-scroll-container::-webkit-scrollbar {
        display: none;
    }

    .products-scroll-container {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .scroll-item {
            flex: 0 0 25%;
            /* 4 products per row on tablet */
            min-width: 25%;
        }
    }

    @media (max-width: 992px) {
        .scroll-item {
            flex: 0 0 33.333%;
            /* 3 products per row on medium tablet */
            min-width: 33.333%;
        }

        .products-scroll-container {
            padding: 0 50px;
        }
    }

    @media (max-width: 768px) {
        .scroll-item {
            flex: 0 0 50%;
            /* 2 products per row on mobile */
            min-width: 50%;
        }

        .products-scroll-container {
            padding: 0 45px;
        }

        .scroll-btn {
            width: 40px;
            height: 40px;
        }

        .scroll-left {
            left: 5px;
        }

        .scroll-right {
            right: 5px;
        }
    }

    @media (max-width: 576px) {
        .scroll-item {
            flex: 0 0 100%;
            /* 1 product per row on small mobile */
            min-width: 100%;
        }

        .products-scroll-container {
            padding: 0 40px;
        }
    }
</style>
<style>
    /* style untuk banner utama yang agak bug */
    .home-slider {
        min-height: 500px;
        /* Atur tinggi agar area tidak collapse saat loading */
    }

    /* Sembunyikan konten slider dan slide yang tidak aktif secara sementara */
    .hero-slider-1.temp-hidden .single-hero-slider:not(:first-child) {
        display: none !important;
    }

    /* Sembunyikan teks secara default untuk fade-in */
    .hero-slider-1 .slider-content {
        opacity: 0;
        transition: opacity 0.8s ease-in-out;
    }

    .hero-slider-1 .content-loaded {
        opacity: 1;
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
<style>
    /* style untuk banner slider */
    /* Slider Title Styling */
    .slider-title {
        font-size: 3rem !important;
        font-weight: 700;
        line-height: 1.2;
        margin-bottom: 1.5rem !important;
        word-wrap: break-word;
        max-width: 100%;
    }

    /* Untuk desktop - sedikit lebih besar */
    @media (min-width: 768px) {
        .slider-title {
            font-size: 3.5rem !important;
        }
    }

    /* Untuk mobile - lebih kecil lagi */
    @media (max-width: 767px) {
        .slider-title {
            font-size: 2rem !important;
            line-height: 1.3;
        }
    }

    .slider-description {
        font-size: 1.1rem;
        margin-bottom: 2rem !important;
        line-height: 1.5;
    }

    /* Fallback jika CSS tidak load */
    .display-2 {
        font-size: 2.5rem !important;
    }
</style>
<style>
    /* Kustomisasi Koleksi E-book */

    /* Poin 1: Style untuk deskripsi koleksi */
    .section-title.style-2 .collection-description {
        font-size: 0.9em;
        color: #888;
        margin-top: 0;
        margin-bottom: 20px;
        line-height: 1.5;
    }

    .section-title.style-2 h3 {
        margin-bottom: 5px;
    }

    /* Poin 3: Style untuk indikator akses berlangganan (pengganti harga) */
    .product-cart-wrap .product-access-indicator {
        text-align: center;
        color: #FF4C61;
        font-weight: 500;
        font-size: 0.9em;
        margin-top: 10px;
        padding: 5px 0;
    }

    .product-cart-wrap .product-access-indicator i {
        margin-right: 5px;
    }

    /* Poin 2: Style untuk tombol scroll saat dinonaktifkan */
    .scroll-btn:disabled {
        opacity: 0.4;
        cursor: not-allowed;
        pointer-events: none;
    }

    /* ==========================================================================
    Kustomisasi Tampilan E-book (Satu Kartu, Tombol Berbeda)
   ========================================================================== */

    .product-cart-wrap {
        border: 1px solid rgba(255, 255, 255, 0.05);
        transition: all 0.3s ease;
    }

    /* --- Gaya Umum untuk Elemen Kartu --- */
    .product-cart-wrap h2 {
        font-size: 1.1rem;
        line-height: 1.4;
        margin-bottom: 0.5rem;
        min-height: 3.2em;
    }

    .product-cart-wrap .product-description {
        min-height: 3.2em;
    }

    .product-author {
        font-size: 0.9rem;
        color: var(--text-color-muted);
        margin-bottom: 0.75rem;
    }

    .product-description {
        font-size: 0.85rem;
        color: var(--text-color-muted);
        margin-top: -15px;
        margin-bottom: 1rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .product-description.single-line {
        margin-bottom: 1.3rem;
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
        /* background-color: #6c757d; */
        color: #fff;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    /* Untuk membatasi judul buku maksimal 2 baris */
    .product-cart-wrap h2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        /* Maksimal 2 baris */
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        /* Menambahkan "..." */
    }

    /* Untuk membatasi deskripsi buku maksimal 2 baris */
    .product-description {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        /* Maksimal 2 baris */
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        /* Menambahkan "..." */
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
    }

    .btn-read-now {
        background-color: #FF4C61;
        /* Hijau untuk aksi positif */
        color: #fff;
    }

    .btn-read-now:hover {
        background-color: #de364aff;
        color: #fff;
    }

    .btn-subscribe-now {
        background: #FF4C61;
        color: #fff;
    }

    .btn-subscribe-now:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(168, 85, 247, 0.4);
        color: #FF4C61;
        background-color: #fff;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(168, 85, 247, 0.7);
        }

        70% {
            box-shadow: 0 0 0 10px rgba(168, 85, 247, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(168, 85, 247, 0);
        }
    }

    /* Untuk membatasi nama author maksimal 1 baris */
    .product-author span {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        /* Maksimal 1 baris */
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Untuk membuat gambar blog post seragam dan rapi */
    .post-thumb {
        position: relative;
        width: 100%;
        padding-top: 50%;
        overflow: hidden;
        border-radius: 15px;
        margin-bottom: 0px;
    }

    .post-thumb img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Untuk mengurangi jarak antara gambar dan kategori blog */
    .entry-content-2 h6 a {
        margin-top: -5px;
        /* Tarik kategori ke atas untuk mengurangi jarak */
    }

    /* sedikit style untuk card top city */
    .city-name-long {
        font-size: 0.75em;
        line-height: 1.2;
    }
</style>
<div class="container mx-auto p-6">
    <section class="home-slider position-relative mb-30">
        <div class="container">
            <div class="home-slide-cover mt-30">
                <div class="hero-slider-1 style-4 dot-style-1 dot-style-1-position-1 temp-hidden">

                    
                    <?php
                    // Jika $homeSliders tidak ada, buat data default
                    if (!isset($homeSliders)) {
                    $homeSliders = collect([
                    (object)[
                    'image' => 'images/slider-1.webp',
                    'title' => "Get My Essential Travel Guide",
                    'description' => 'Access insider tips and verified travel itineraries.',
                    'target_url' => '/pricing'
                    ],
                    (object)[
                    'image' => 'images/slider-2.webp',
                    'title' => "Start Your Plan Claim Your Promo",
                    'description' => 'Save up to 50% off on your first order',
                    'target_url' => '/promo'
                    ]
                    ]);
                    }
                    ?>

                    <?php $__currentLoopData = $homeSliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="single-hero-slider single-animation-wrap" style="background-image: url(<?php echo e(asset('storage/' . $slider->image)); ?>)">
                        <a href="<?php echo e($slider->target_url); ?>" style="display: block; height: 100%; text-decoration: none;">
                            <div class="slider-content">
                                <h1 class="slider-title mb-40">
                                    
                                    <?php
                                    $title = $slider->title;
                                    $words = explode(' ', $title);
                                    $currentLine = '';
                                    $lines = [];

                                    foreach ($words as $word) {
                                    // Jika panjang line + kata berikutnya <= 23 karakter
                                        if (strlen($currentLine . ' ' . $word) <=23) {
                                        $currentLine .=($currentLine ? ' ' : '' ) . $word;
                                        } else {
                                        // Simpan line saat ini dan mulai line baru
                                        if ($currentLine) {
                                        $lines[]=$currentLine;
                                        }
                                        $currentLine=$word;
                                        }
                                        }

                                        // Tambahkan line terakhir
                                        if ($currentLine) {
                                        $lines[]=$currentLine;
                                        }

                                        // Jika hanya 1 line, coba split di tengah
                                        if (count($lines)===1 && strlen($title)> 23) {
                                        $midPoint = floor(strlen($title) / 2);
                                        $spacePos = strpos($title, ' ', $midPoint);

                                        if ($spacePos !== false) {
                                        $lines = [
                                        substr($title, 0, $spacePos),
                                        substr($title, $spacePos + 1)
                                        ];
                                        }
                                        }
                                        ?>

                                        
                                        <?php $__currentLoopData = $lines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php echo e($line); ?><?php if(!$loop->last): ?><br><?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </h1>
                                <p class="slider-description mb-65"><?php echo e($slider->description); ?></p>
                            </div>
                        </a>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>
                <div class="slider-arrow hero-slider-1-arrow"></div>
            </div>
        </div>
    </section>
    <!-- top 10 ibu kota di indonesia -->
    <section class="popular-categories section-padding">
        <div class="container wow animate__animated animate__fadeIn">
            <div class="section-title style-2 flex-container-custom">
                <div class="title">
                    <h3>Top 10 City Guides</h3>
                </div>
                <a href="/destinations" class="show-all">View All</a>
            </div>
            <div class="slider-arrow slider-arrow-2 flex carausel-10-columns-arrow"></div>
            <div class="carausel-10-columns-cover position-relative">
                <div class="carausel-10-columns" id="carausel-10-columns">

                    
                    <?php $__currentLoopData = $topCities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="card-2 bg-12 wow animate__animated animate__fadeInUp" data-wow-delay="<?php echo e(($index + 1) * 0.1); ?>s">
                        <figure class="img-hover-scale overflow-hidden" style="width: 100px; height: 120px; margin: 0 auto 10px; border-radius: 8px;">
                            <a href="/destinations/<?php echo e($city->slug); ?>">
                                <img src="<?php echo e(asset($city->image)); ?>" alt="<?php echo e($city->name); ?>" style="width: 100%; height: 100%; object-fit: cover;" />
                            </a>
                        </figure>
                        <h6>
                            <a href="/destinations/<?php echo e($city->slug); ?>" class="<?php echo e(str_word_count($city->name) > 1 ? 'city-name-long' : ''); ?>">
                                <?php echo e($city->name); ?>

                            </a>
                        </h6>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>
            </div>
        </div>
    </section>
    <!-- 3 subscriprion plans -->
    <!-- Subscription Plans -->
    <section class="banners mb-25">
        <div class="container">
            <div class="row">
                <div class="section-title style-2">
                    <div class="title">
                        <h3>Subscription Plans</h3>
                    </div>
                    <a href="<?php echo e(route('pricing')); ?>" class="show-all">View All</a>
                </div>

                <?php
                // Fallback jika $subscriptionPlans tidak ada
                if (!isset($subscriptionPlans)) {
                $subscriptionPlans = app(\App\Services\SubscriptionPlanService::class)->getHomepagePlans(3);
                }
                ?>

                <?php $__currentLoopData = $subscriptionPlans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                // Tentukan class col untuk responsive design
                $colClass = 'col-lg-4 ';
                $colClass .= ($index == 2) ? 'd-md-none d-lg-flex' : 'col-md-6';

                // Tentukan delay untuk animation
                $delay = $index * 0.2;
                ?>

                <div class="<?php echo e($colClass); ?>">
                    <div class="banner-img wow animate__animated animate__fadeInUp" data-wow-delay="<?php echo e($delay); ?>s">
                        <a href="<?php echo e(route('pricing')); ?>#pricing-plans">
                            <img src="<?php echo e(asset($plan->image)); ?>" alt="<?php echo e($plan->name); ?>" />
                        </a>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>
        </div>
    </section>
    <!--End banners-->
    <!-- collection -->
    <?php if($collections->isNotEmpty()): ?>
    <?php $__currentLoopData = $collections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $collection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <section class="product-tabs section-padding position-relative">
        <div class="container">
            
            <div class="section-title style-2 wow animate__animated animate__fadeIn">
                <h3><?php echo e($collection->name); ?></h3>
                <a href="/collections/<?php echo e($collection->slug); ?>" class="show-all">View All</a>
            </div>
            <button class="scroll-btn scroll-left"><i class="fi-rs-angle-left"></i></button>
            <button class="scroll-btn scroll-right"><i class="fi-rs-angle-right"></i></button>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="<?php echo e($collection->slug); ?>" role="tabpanel">
                    <div class="products-scroll-container">
                        <div class="row product-grid-4 scroll-wrapper">

                            <?php if($collection->ebooks->isNotEmpty()): ?>
                            <?php $__currentLoopData = $collection->ebooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $ebook): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 scroll-item">

                                
                                <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn" data-wow-delay="<?php echo e(($index + 1) * 0.1); ?>s">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img product-img-zoom">
                                            <a href="/ebooks/<?php echo e($ebook->slug); ?>">
                                                <img class="default-img" src="<?php echo e($ebook->cover_image ?: 'assets-nest/nest-fe/imgs/shop/product-1-1.jpg'); ?>" alt="<?php echo e($ebook->title); ?>" />
                                            </a>
                                        </div>
                                        <div class="product-badges product-badges-position product-badges-mrg">
                                            <!-- <?php if($ebook->is_featured): ?>
                                            <span class="hot">Featured</span>
                                            <?php endif; ?> -->
                                            <span class="badge-language hot"><?php echo e(strtoupper($ebook->language)); ?></span>
                                        </div>
                                    </div>
                                    <div class="product-content-wrap">
                                        <h2 style="margin-top:15px;"><a href="/ebooks/<?php echo e($ebook->slug); ?>"><?php echo e(Str::limit($ebook->title, 40)); ?></a></h2>

                                        <div class="product-author" style="margin-bottom:-12px;">
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
                                                <i class="fi-rs-eye align-middle"></i><!--  <?php echo e(number_format($ebook->view_count)); ?> -->
                                                <span class="post-on">
                                                    <?php
                                                    $views = $ebook->view_count;
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
                                                    <?php echo e($formattedViews); ?>

                                                </span>
                                            </div>
                                        </div>

                                        <!-- <p class="product-description"><?php echo e(Str::limit($ebook->short_description ?? $ebook->description, 80)); ?></p> -->
                                        <?php
                                        // Ambil teks deskripsi
                                        $descriptionText = $ebook->short_description ?? $ebook->description;

                                        // Cek apakah teks pendek (kira-kira 1 baris). Sesuaikan angka 40 jika perlu.
                                        $isSingleLine = strlen($descriptionText) <= 29;
                                            ?>

                                            <p class="product-description <?php echo e($isSingleLine ? 'single-line' : ''); ?>">
                                            <?php echo e(Str::limit($descriptionText, 75)); ?>

                                            </p>

                                            
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
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                            <div class="col-12 text-center py-5">
                                <p class="text-muted">No ebooks available in this collection yet.</p>
                            </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
    <!-- blogs -->
    <section class="section-padding pb-5">
        <div class="container mb-30">
            <div class="section-title style-2 flex-container-custom">
                <div class="title">
                    <h3>Latest Blog</h3>
                </div>
                <a href="<?php echo e(route('blogs.index')); ?>" class="show-all">View All</a>
            </div>
            <div class="loop-grid">
                <div class="row">
                    <?php $__empty_1 = true; $__currentLoopData = $latestBlogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <article class="col-xl-3 col-lg-4 col-md-6 text-center hover-up mb-30 animated">
                        <div class="post-thumb">
                            <a href="<?php echo e(route('blogs.show', $blog->slug)); ?>">
                                <img class="border-radius-15" src="<?php echo e($blog->featured_image ?: asset('images/blog-placeholder.webp')); ?>" alt="<?php echo e($blog->title); ?>" />
                            </a>
                        </div>
                        <div class="entry-content-2">
                            <h6 class="mb-10 font-sm"><a class="entry-meta text-muted" href="#"><?php echo e($blog->category); ?></a></h6>
                            <h4 class="post-title mb-15">
                                <a href="<?php echo e(route('blogs.show', $blog->slug)); ?>"><?php echo e(Str::limit($blog->title, 60)); ?></a>
                            </h4>
                            <div class="entry-meta font-xs color-grey mt-10 pb-10">
                                <div>
                                    <!-- <span class="post-on mr-10"><?php echo e($blog->published_at->format('d F Y')); ?></span> -->
                                    <span class="post-on mr-10"><?php echo e(\Carbon\Carbon::parse($blog->published_at)->diffInHours() < 24 ? $blog->published_at->diffForHumans() : $blog->published_at->format('d M Y')); ?></span>
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
                    </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">No blog posts available yet.</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <!-- </div> -->
    </section>
</div>
<script>
    // Scroll functionality
    document.addEventListener('DOMContentLoaded', function() {
        const scrollWrapper = document.querySelector('.scroll-wrapper');
        const scrollLeftBtn = document.querySelector('.scroll-left');
        const scrollRightBtn = document.querySelector('.scroll-right');
        const scrollItems = document.querySelectorAll('.scroll-item');

        if (!scrollWrapper || !scrollLeftBtn || !scrollRightBtn) return;

        const itemWidth = scrollItems[0].offsetWidth + 20; // width + margin
        const visibleItems = 5; // Number of items visible at once
        const totalItems = scrollItems.length;
        let currentPosition = 0;
        const maxPosition = Math.max(0, totalItems - visibleItems);

        // Update button states
        function updateButtonStates() {
            scrollLeftBtn.disabled = currentPosition === 0;
            scrollRightBtn.disabled = currentPosition >= maxPosition;
        }

        // Scroll to position
        function scrollToPosition(position) {
            currentPosition = Math.max(0, Math.min(position, maxPosition));
            const translateX = -currentPosition * itemWidth;
            scrollWrapper.style.transform = `translateX(${translateX}px)`;
            updateButtonStates();
        }

        // Event listeners
        scrollLeftBtn.addEventListener('click', function() {
            if (currentPosition > 0) {
                scrollToPosition(currentPosition - 1);
            }
        });

        scrollRightBtn.addEventListener('click', function() {
            if (currentPosition < maxPosition) {
                scrollToPosition(currentPosition + 1);
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            // Recalculate on resize
            const newItemWidth = scrollItems[0].offsetWidth + 20;
            itemWidth = newItemWidth;
            scrollToPosition(currentPosition);
        });

        // Initialize
        updateButtonStates();
    });
</script>
<style>
    /* style untuk banner */
    /* CSS untuk menyembunyikan konten slider di awal */
    .hero-slider-1 .slider-content {
        opacity: 0;
        transition: opacity 0.8s ease-in-out;
    }

    /* CSS untuk menampilkan konten setelah JS dipicu */
    .hero-slider-1 .content-loaded {
        opacity: 1;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sliderWrapper = document.querySelector('.hero-slider-1');
        const sliderContents = document.querySelectorAll('.hero-slider-1 .slider-content');

        // 1. Hapus kelas penyembunyi sementara
        if (sliderWrapper) {
            // Hapus temp-hidden agar slider library bisa menata semua slide
            sliderWrapper.classList.remove('temp-hidden');
            setTimeout(() => {
                sliderContents.forEach(content => {
                    content.classList.add('content-loaded');
                });
            }, 0);
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sections = document.querySelectorAll('.product-tabs');

        sections.forEach(section => {
            const scrollContainer = section.querySelector('.products-scroll-container');
            const scrollLeftBtn = section.querySelector('.scroll-left');
            const scrollRightBtn = section.querySelector('.scroll-right');

            if (!scrollContainer || !scrollLeftBtn || !scrollRightBtn) {
                return;
            }

            // Fungsi untuk memperbarui status tombol (enable/disable)
            const updateButtonStates = () => {
                // Nonaktifkan tombol kiri jika di posisi paling kiri
                if (scrollContainer.scrollLeft <= 0) {
                    scrollLeftBtn.disabled = true;
                } else {
                    scrollLeftBtn.disabled = false;
                }

                // Nonaktifkan tombol kanan jika di posisi paling kanan
                // scrollWidth adalah total lebar konten, clientWidth adalah lebar yang terlihat
                if (scrollContainer.scrollLeft >= scrollContainer.scrollWidth - scrollContainer.clientWidth) {
                    scrollRightBtn.disabled = true;
                } else {
                    scrollRightBtn.disabled = false;
                }
            };

            // Event listener untuk tombol scroll
            scrollRightBtn.addEventListener('click', () => {
                // Geser sejauh lebar container yang terlihat
                scrollContainer.scrollBy({
                    left: scrollContainer.clientWidth,
                    behavior: 'smooth'
                });
            });

            scrollLeftBtn.addEventListener('click', () => {
                scrollContainer.scrollBy({
                    left: -scrollContainer.clientWidth,
                    behavior: 'smooth'
                });
            });

            // Event listener untuk memperbarui tombol saat konten di-scroll
            scrollContainer.addEventListener('scroll', updateButtonStates);

            // Panggil sekali saat halaman dimuat untuk set status awal
            updateButtonStates();
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts_lp.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views/index.blade.php ENDPATH**/ ?>