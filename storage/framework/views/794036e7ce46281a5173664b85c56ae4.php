<!-- resources/views/components/destinations/show.blade.php -->


<?php $__env->startSection('title', $city->name . ' - Destination Details'); ?>

<?php $__env->startSection('content'); ?>
<style>
    /* 
            Kustomisasi dari template e-book Anda
            Beberapa aturan disesuaikan untuk halaman detail kota
        */
    .section-title.style-2 .collection-description {
        font-size: 1em;
        color: #666;
        margin-top: 10px;
        margin-bottom: 30px;
        line-height: 1.6;
    }

    .section-title.style-2 h1 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 0;
    }

    .city-detail-card {
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .city-image img {
        width: 100%;
        height: 450px;
        object-fit: cover;
    }

    .city-content {
        padding: 30px;
    }

    .city-meta-item {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        font-size: 0.95rem;
    }

    .city-meta-item i {
        margin-right: 5px;
        color: #FF4C61;
        width: 20px;
        text-align: center;
    }

    .city-description {
        font-size: 1rem;
        line-height: 1.8;
        color: #555;
        text-align: justify;
    }

    /* Badge Populer */
    .badge-popular {
        background-color: #FF4C61;
        color: #fff;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-block;
        margin-top: 10px;
    }

    /* Tombol Aksi */
    .action-button {
        display: inline-block;
        padding: 12px 30px;
        background-color: #FF4C61;
        color: #fff;
        border-radius: 5px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        margin-top: 20px;
    }

    .action-button:hover {
        background-color: #e04155;
        color: #fff;
        transform: translateY(-2px);
    }
</style>

<style>
    /* Kustomisasi Koleksi E-book */

    /* Style untuk deskripsi koleksi */
    .section-title.style-2 .collection-description {
        font-size: 0.9em;
        color: #888;
        margin-top: 0;
        margin-bottom: 20px;
        line-height: 1.5;
    }

    /* Style untuk judul koleksi (h1) */
    .section-title.style-2 h3 {
        margin-bottom: 5px;
    }

    /* Style untuk tombol scroll (saat dinonaktifkan) */
    /* Catatan: Aturan ini akan digunakan jika Anda menambahkan tombol scroll kembali */
    .scroll-btn:disabled {
        opacity: 0.4;
        cursor: not-allowed;
        pointer-events: none;
    }

    /* ==========================================================================
       Kustomisasi Tampilan E-book
    ========================================================================== */

    /* Gaya Umum untuk Kartu */
    .product-cart-wrap {
        border: 1px solid rgba(255, 255, 255, 0.05);
        transition: all 0.3s ease;
    }

    /* Gaya untuk Judul Buku (digabung dari 2 aturan) */
    .product-cart-wrap h2 {
        font-size: 1.1rem;
        line-height: 1.4;
        margin-bottom: 0.5rem;
        min-height: 3.2em;
        /* Untuk konsistensi tinggi */
        display: -webkit-box;
        -webkit-line-clamp: 2;
        /* Maksimal 2 baris */
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .product-author {
        font-size: 0.9rem;
        color: var(--text-color-muted);
        margin-bottom: -10px;
    }

    .product-author span {
        display: block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: -10px;
    }

    /* Gaya untuk Deskripsi Buku (digabung dari 2 aturan) */
    .product-description {
        font-size: 0.85rem;
        color: var(--text-color-muted);
        margin-bottom: 1rem;
        margin-top: -20px;
        min-height: 2.6em;
        /* Untuk konsistensi tinggi */
        display: -webkit-box;
        -webkit-line-clamp: 2;
        /* Maksimal 2 baris */
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .product-description.single-line {
        margin-bottom: 1.7rem;
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
    }

    .btn-read-now {
        background-color: #FF4C61;
        color: #fff;
    }

    .btn-read-now:hover {
        background-color: #FF4C61;
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

    .product-content-wrap h2 {
        margin-top: 10px;
    }
</style>
<style>
    .city-hero-card {
        border-radius: 12px !important;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }

    @media (max-width: 768px) {
        .city-hero-card {
            height: 380px !important;
        }

        .city-hero-content h1 {
            font-size: 1.8rem !important;
        }

        .city-hero-content p {
            font-size: 0.95rem !important;
        }
    }
</style>

<div class="container mt-5 mb-5">
    <!-- Bagian Utama Detail Kota -->
    <section class="product-tabs section-padding position-relative">
        <div class="container">
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb mb-15">
                        <a href="/" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                        <span></span>
                        <a href="<?php echo e(route('destinations')); ?>">Destinations</a>
                        <span></span>
                        <?php echo e($city->name); ?>

                    </div>

                    
                    <div class="city-hero-card rounded-3 overflow-hidden shadow-sm" style="position: relative; height: 450px;">
                        <!-- Gambar sebagai background -->
                        <img src="<?php echo e($city->image ?: 'https://via.placeholder.com/1200x450.png?text=' . urlencode($city->name)); ?>"
                            alt="<?php echo e($city->name); ?>"
                            class="w-100 h-100"
                            style="object-fit: cover;">

                        <!-- Overlay gelap lembut -->
                        <div class="city-overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to top, rgba(0,0,0,0.8), transparent 60%);"></div>

                        <!-- Teks: putih, center, di tengah bawah -->
                        <div class="city-hero-content" style="position: absolute; bottom: 2rem; left: 50%; transform: translateX(-50%); text-align: center; color: white; z-index: 2; max-width: 90%;">
                            <h1 class="mb-2" style="font-size: 2.25rem; font-weight: 700; color: white; text-shadow: 0 2px 4px rgba(0,0,0,0.6);">
                                <?php echo e($city->name); ?>

                            </h1>

                            <?php if($city->province): ?>
                            <p class="mb-2" style="font-size: 1.1rem; color: white; opacity: 0.95; font-weight: 500;">
                                <i class="bi bi-geo-alt me-1"></i>
                                <?php echo e($city->province); ?>

                                <?php if($city->country): ?>
                                , <?php echo e($city->country); ?>

                                <?php endif; ?>
                            </p>
                            <?php endif; ?>

                            <?php if($city->description): ?>
                            <p class="mb-0" style="font-size: 1rem; line-height: 1.6; color: white; opacity: 0.9;">
                                <?php echo e(Str::limit($city->description, 180, '...')); ?>

                            </p>
                            <?php else: ?>
                            <p class="mb-0" style="font-size: 1rem; color: white; opacity: 0.85;">
                                Informasi detail tentang kota ini belum tersedia.
                            </p>
                            <?php endif; ?>
                        </div>
                    </div>

                    
                    <?php if($city->description && strlen($city->description) > 180): ?>
                    <div class="city-full-desc mt-4 p-4 bg-white rounded-3 shadow-sm">
                        <p class="mb-0" style="line-height: 1.7; color: #444; text-align: justify;">
                            <?php echo e($city->description); ?>

                        </p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            
            <section class="ebooks-section mt-5">
                <div class="container">
                    <!-- <hr class="my-5"> -->
                    <h4 class="my-5">Discover Your Journey to <?php echo e($city->name); ?></h4>

                    <div class="row product-grid-4">
                        <?php if($ebooks->isNotEmpty()): ?>
                        <?php $__currentLoopData = $ebooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $ebook): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                            
                            <div class="product-cart-wrap mb-30">
                                <div class="product-img-action-wrap">
                                    <div class="product-img product-img-zoom">
                                        <a href="/ebooks/<?php echo e($ebook->slug); ?>">
                                            <img class="default-img" src="<?php echo e($ebook->cover_image ?: 'https://via.placeholder.com/300x400.png?text=No+Cover'); ?>" alt="<?php echo e($ebook->title); ?>" />
                                        </a>
                                    </div>
                                    <div class="product-badges product-badges-position product-badges-mrg">
                                        <span class="badge-language hot"><?php echo e(strtoupper($ebook->language)); ?></span>
                                    </div>
                                </div>
                                <div class="product-content-wrap">
                                    <h2><a href="/ebooks/<?php echo e($ebook->slug); ?>"><?php echo e(Str::limit($ebook->title, 40)); ?></a></h2>
                                    <div class="product-author">
                                        <?php if($ebook->creator): ?>
                                        <span>by <?php echo e($ebook->creator->pen_name ?? $ebook->creator->name); ?></span>
                                        <?php else: ?>
                                        <span>by Unknown Author</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="product-meta">
                                        <div class="product-detail-rating">
                                            <div class="product-rate-cover text-end">
                                                <div class="product-rate-cover">
                                                    <div class="product-rate d-inline-block">
                                                        <div class="product-rating" style="width: <?php echo e(($ebook->ratings->avg('rating') / 5) * 100); ?>%"></div>
                                                    </div>
                                                    <span class="font-small ml-5 text-muted">(<?php echo e(round($ebook->ratings->avg('rating'), 2)); ?>)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="read-count">
                                            <i class="fi-rs-eye align-middle"></i>
                                            <span class="post-on">
                                                <?php
                                                $views = $ebook->view_count;
                                                if ($views >= 1000000) {
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
                                    <?php
                                    // Ambil teks deskripsi
                                    $descriptionText = $ebook->short_description ?? $ebook->description;

                                    // Cek apakah teks pendek (kira-kira 1 baris). Sesuaikan angka 40 jika perlu.
                                    $isSingleLine = strlen($descriptionText) <= 35;
                                        ?>

                                        <p class="product-description <?php echo e($isSingleLine ? 'single-line' : ''); ?>">
                                        <?php echo e(Str::limit($descriptionText, 75)); ?>

                                        </p>
                                        
                                        <?php if(auth()->check() && auth()->user()->hasActiveSubscription()): ?>
                                        <a href="<?php echo e(route('user.ebook.read', $ebook->slug)); ?>" class="action-btn btn-read-now">
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
                            <p class="text-muted">Belum ada e-book untuk destinasi ini.</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts_lp.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJEK PROJEK\Ebook-Traveling\resources\views/components/destinations/show.blade.php ENDPATH**/ ?>