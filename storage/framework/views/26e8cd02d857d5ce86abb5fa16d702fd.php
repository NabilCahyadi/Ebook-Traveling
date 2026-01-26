<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['collection']));

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

foreach (array_filter((['collection']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?> 

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
        display: flex;
        flex-direction: column;
        height: 100%;
        min-height: 520px;
    }

    .product-content-wrap {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
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
        margin-bottom: 0.75rem;
    }

    /* Gaya untuk Deskripsi Buku (digabung dari 2 aturan) */
    .product-description {
        font-size: 0.85rem;
        color: var(--text-color-muted);
        margin-bottom: 1rem;
        min-height: 2.8em;
        /* Untuk konsistensi tinggi */
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        flex-grow: 1;
    }

    /* Maksimal 2 baris */
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

    /* Fixed ukuran cover ebook agar konsisten */
    .product-img {
        position: relative;
        width: 100%;
        padding-top: 140%;
        /* Rasio 5:7 (tinggi 140% dari lebar) untuk cover buku */
        overflow: hidden;
        border-radius: 15px;
        background-color: #f5f5f5;
    }

    .product-img img.default-img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
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
        margin-top: auto;
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

    .product-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        font-size: 0.8rem;
    }
</style>
<section class="product-tabs section-padding position-relative">
    <div class="container">
        
        <div class="section-title style-2 wow animate__animated animate__fadeIn">
            <h3><?php echo e($collection->name); ?></h3>
            <?php if($collection->description): ?>
                <p class="collection-description"><?php echo e($collection->description); ?></p>
            <?php endif; ?>
        </div>

        
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="<?php echo e($collection->slug); ?>" role="tabpanel">
                <div class="products-scroll-container">
                    <div class="row product-grid-4 scroll-wrapper">
                        <?php if($collection->ebooks->isNotEmpty()): ?>
                            <?php $__currentLoopData = $collection->ebooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $ebook): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 scroll-item">

                                    
                                    <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn"
                                        data-wow-delay="<?php echo e(($index + 1) * 0.1); ?>s">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href="/ebooks/<?php echo e($ebook->slug); ?>">
                                                    <?php
                                                        $coverImage = $ebook->external_cover_url
                                                            ? $ebook->external_cover_url
                                                            : $ebook->cover_image_url ??
                                                                'assets-nest/nest-fe/imgs/shop/product-1-1.jpg';
                                                    ?>
                                                    <img class="default-img" src="<?php echo e($coverImage); ?>"
                                                        alt="<?php echo e($ebook->title); ?>" />
                                                </a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span
                                                    class="badge-language hot"><?php echo e(strtoupper($ebook->language)); ?></span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <h2 style="margin-top:15px;"><a
                                                    href="/ebooks/<?php echo e($ebook->slug); ?>"><?php echo e(Str::limit($ebook->title, 40)); ?></a>
                                            </h2>

                                            <div class="product-author" style="margin-bottom:-4px;">
                                                <?php if($ebook->creator): ?>
                                                    <span>by
                                                        <?php echo e($ebook->creator->creator->pen_name ?? $ebook->creator->name); ?></span>
                                                <?php else: ?>
                                                    <span>by Unknown Author</span>
                                                <?php endif; ?>
                                            </div>

                                            <div class="product-meta">
                                                <div class="product-detail-rating">
                                                    <div class="product-rate-cover text-end">
                                                        <div class="product-rate-cover">
                                                            <div class="product-rate d-inline-block">
                                                                
                                                                <div class="product-rating"
                                                                    style="width: <?php echo e(($ebook->ratings()->avg('rating') / 5) * 100); ?>%">
                                                                </div>
                                                            </div>
                                                            
                                                            <span
                                                                class="font-small ml-5 text-muted">(<?php echo e(round($ebook->ratings()->avg('rating'), 2)); ?>)</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="read-count">
                                                    <i
                                                        class="fi fi-rs-eye align-middle"></i><!--  <?php echo e(number_format($ebook->view_count)); ?> -->
                                                    <span class="post-on">
                                                        <?php
                                                            $views = $ebook->view_count;
                                                            if ($views >= 1000000000) {
                                                                // 1 Miliar
                                                                $formattedViews =
                                                                    number_format($views / 1000000000, 1) . 'B';
                                                            } elseif ($views >= 1000000) {
                                                                // 1 Juta
                                                                $formattedViews =
                                                                    number_format($views / 1000000, 1) . 'M';
                                                            } elseif ($views >= 1000) {
                                                                // 1 Ribu
                                                                $formattedViews = number_format($views / 1000, 1) . 'k';
                                                            } else {
                                                                $formattedViews = $views;
                                                            }
                                                        ?>
                                                        <?php echo e($formattedViews); ?>

                                                    </span>
                                                </div>
                                            </div>

                                            <p class="product-description">
                                                <?php echo e(Str::limit(strip_tags($ebook->short_description ?? $ebook->description), 80)); ?>

                                            </p>

                                            
                                            <?php if(auth()->check() && auth()->user()->hasActiveSubscription()): ?>
                                                <a href="<?php echo e(route('user.ebook.read', $ebook->slug)); ?>"
                                                    class="action-btn btn-read-now">
                                                    <i class="fi fi-rs-book-open"></i>
                                                    <span>Read Now</span>
                                                </a>
                                            <?php else: ?>
                                                <a href="/pricing" class="action-btn btn-subscribe-now">
                                                    <i class="fi fi-rs-lock"></i>
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
<?php /**PATH C:\laragon\www\ebook_traveling\resources\views\components\collections\show.blade.php ENDPATH**/ ?>