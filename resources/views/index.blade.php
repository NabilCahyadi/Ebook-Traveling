@extends('layouts_lp.app')
@section('title', 'Home - MeatMap')

@section('content')
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
        /* 5 products per row (100% / 5 = 20%) */
        padding: 0 10px;
        min-width: 20%;
        /* Ensure consistent width */
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
<div class="container mx-auto p-6">
    <section class="home-slider position-relative mb-30">
        <div class="container">
            <div class="home-slide-cover mt-30">
                <div class="hero-slider-1 style-4 dot-style-1 dot-style-1-position-1 temp-hidden">
                    <div class="single-hero-slider single-animation-wrap" style="background-image: url(images/slider-1.webp)">
                        <div class="slider-content">
                            <h1 class="display-2 mb-40">
                                Get My Essential<br />
                                Travel Guide
                            </h1>
                            <p class="mb-65">Access insider tips and verified travel itineraries.</p>
                            <a href="{{ route('pricing') }}" class="pricing-button-inverted" style="width: 100%; padding: 1rem 2rem; margin-top: auto; letter-spacing: 0.05em; color: #ffffffff; text-transform: capitalize; background-color: #FF4C61; border-radius: 20rem; border: none; cursor: pointer; transition: background-color 0.3s ease;">
                                Subscribe Now
                            </a>
                        </div>
                    </div>
                    <div class="single-hero-slider single-animation-wrap" style="background-image: url(images/slider-2.webp)">
                        <div class="slider-content">
                            <h1 class="display-2 mb-40">
                                Start Your Plan<br />
                                Claim Your Promo
                            </h1>
                            <p class="mb-65">Save up to <strong style="color:#FF4C61">50%</strong> off on your first order</p>
                            <a href="{{ route('promo') }}" class="pricing-button-inverted" style="width: 100%; padding: 1rem 2rem; margin-top: auto; letter-spacing: 0.05em; color: #ffffffff; text-transform: capitalize; background-color: #FF4C61; border-radius: 20rem; border: none; cursor: pointer; transition: background-color 0.3s ease;">
                                Claim Promo
                            </a>
                        </div>
                    </div>
                </div>
                <div class="slider-arrow hero-slider-1-arrow"></div>
            </div>
        </div>
    </section>
    <!-- kategori Ibu Kota setiap provinsi -->
    <section class="popular-categories section-padding">
        <div class="container wow animate__animated animate__fadeIn">
            <div class="section-title style-2 flex-container-custom">
                <div class="title">
                    <h3>Top 10 City Guides</h3>
                </div>
                <a href="{{ route('destinations')}}" class="show-all">View All</a>
            </div>
            <div class="slider-arrow slider-arrow-2 flex carausel-10-columns-arrow"></div>
            <div class="carausel-10-columns-cover position-relative">
                <div class="carausel-10-columns" id="carausel-10-columns">

                    <div class="card-2 bg-12 wow animate__animated animate__fadeInUp" data-wow-delay=".1s">
                        <figure class="img-hover-scale overflow-hidden" style="width: 100px; height: 80px; margin: 0 auto 10px; border-radius: 8px;">
                            <a href="shop-grid-right.html">
                                <img src="images/ach.jpg" alt="Bandung" style="width: 100%; height: 100%; object-fit: cover;" />
                            </a>
                        </figure>
                        <h6><a href="shop-grid-right.html">Bandung</a></h6>
                        <span>26 items</span>
                    </div>

                    <div class="card-2 bg-12 wow animate__animated animate__fadeInUp" data-wow-delay=".2s">
                        <figure class="img-hover-scale overflow-hidden" style="width: 100px; height: 80px; margin: 0 auto 10px; border-radius: 8px;">
                            <a href="shop-grid-right.html">
                                <img src="images/mdn.jpg" alt="Surabaya" style="width: 100%; height: 100%; object-fit: cover;" />
                            </a>
                        </figure>
                        <h6><a href="shop-grid-right.html">Surabaya</a></h6>
                        <span>28 items</span>
                    </div>

                    <div class="card-2 bg-12 wow animate__animated animate__fadeInUp" data-wow-delay=".3s">
                        <figure class="img-hover-scale overflow-hidden" style="width: 100px; height: 80px; margin: 0 auto 10px; border-radius: 8px;">
                            <a href="shop-grid-right.html">
                                <img src="images/pdg.jpg" alt="Semarang" style="width: 100%; height: 100%; object-fit: cover;" />
                            </a>
                        </figure>
                        <h6><a href="shop-grid-right.html">Semarang</a></h6>
                        <span>14 items</span>
                    </div>

                    <div class="card-2 bg-12 wow animate__animated animate__fadeInUp" data-wow-delay=".4s">
                        <figure class="img-hover-scale overflow-hidden" style="width: 100px; height: 80px; margin: 0 auto 10px; border-radius: 8px;">
                            <a href="shop-grid-right.html">
                                <img src="images/jkt.jpg" alt="Jakarta" style="width: 100%; height: 100%; object-fit: cover;" />
                            </a>
                        </figure>
                        <h6><a href="shop-grid-right.html">Jakarta</a></h6>
                        <span>54 items</span>
                    </div>

                    <div class="card-2 bg-12 wow animate__animated animate__fadeInUp" data-wow-delay=".5s">
                        <figure class="img-hover-scale overflow-hidden" style="width: 100px; height: 80px; margin: 0 auto 10px; border-radius: 8px;">
                            <a href="shop-grid-right.html">
                                <img src="images/ach.jpg" alt="Serang" style="width: 100%; height: 100%; object-fit: cover;" />
                            </a>
                        </figure>
                        <h6><a href="shop-grid-right.html">Serang</a></h6>
                        <span>56 items</span>
                    </div>

                    <div class="card-2 bg-12 wow animate__animated animate__fadeInUp" data-wow-delay=".6s">
                        <figure class="img-hover-scale overflow-hidden" style="width: 100px; height: 80px; margin: 0 auto 10px; border-radius: 8px;">
                            <a href="shop-grid-right.html">
                                <img src="images/mdn.jpg" alt="Medan" style="width: 100%; height: 100%; object-fit: cover;" />
                            </a>
                        </figure>
                        <h6><a href="shop-grid-right.html">Medan</a></h6>
                        <span>72 items</span>
                    </div>

                    <div class="card-2 bg-12 wow animate__animated animate__fadeInUp" data-wow-delay=".7s">
                        <figure class="img-hover-scale overflow-hidden" style="width: 100px; height: 80px; margin: 0 auto 10px; border-radius: 8px;">
                            <a href="shop-grid-right.html">
                                <img src="images/pdg.jpg" alt="Makassar" style="width: 100%; height: 100%; object-fit: cover;" />
                            </a>
                        </figure>
                        <h6><a href="shop-grid-right.html">Makassar</a></h6>
                        <span>36 items</span>
                    </div>

                    <div class="card-2 bg-12 wow animate__animated animate__fadeInUp" data-wow-delay=".8s">
                        <figure class="img-hover-scale overflow-hidden" style="width: 100px; height: 80px; margin: 0 auto 10px; border-radius: 8px;">
                            <a href="shop-grid-right.html">
                                <img src="images/jkt.jpg" alt="Yogyakarta" style="width: 100%; height: 100%; object-fit: cover;" />
                            </a>
                        </figure>
                        <h6><a href="shop-grid-right.html">Yogyakarta</a></h6>
                        <span>123 items</span>
                    </div>

                    <div class="card-2 bg-12 wow animate__animated animate__fadeInUp" data-wow-delay=".9s">
                        <figure class="img-hover-scale overflow-hidden" style="width: 100px; height: 80px; margin: 0 auto 10px; border-radius: 8px;">
                            <a href="shop-grid-right.html">
                                <img src="images/ach.jpg" alt="Bandar Lampung" style="width: 100%; height: 100%; object-fit: cover;" />
                            </a>
                        </figure>
                        <h6><a href="shop-grid-right.html">Bandar Lampung</a></h6>
                        <span>34 items</span>
                    </div>

                    <div class="card-2 bg-12 wow animate__animated animate__fadeInUp" data-wow-delay="1s">
                        <figure class="img-hover-scale overflow-hidden" style="width: 100px; height: 80px; margin: 0 auto 10px; border-radius: 8px;">
                            <a href="shop-grid-right.html">
                                <img src="images/mdn.jpg" alt="Denpasar" style="width: 100%; height: 100%; object-fit: cover;" />
                            </a>
                        </figure>
                        <h6><a href="shop-grid-right.html">Denpasar</a></h6>
                        <span>89 items</span>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- 3 banner -->
    <section class="banners mb-25">
        <div class="container">
            <div class="row">
                <div class="section-title style-2">
                    <div class="title">
                        <h3>Subscription Plans</h3>
                    </div>
                    <a href="{{ route('pricing') }}" class="show-all">View All</a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="banner-img wow animate__animated animate__fadeInUp" data-wow-delay="0">
                        <img src="images/banner-subs-1.webp" alt="" />
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="banner-img wow animate__animated animate__fadeInUp" data-wow-delay=".2s">
                        <img src="images/banner-subs-2.webp" alt="" />
                    </div>
                </div>
                <div class="col-lg-4 d-md-none d-lg-flex">
                    <div class="banner-img mb-sm-0 wow animate__animated animate__fadeInUp" data-wow-delay=".4s">
                        <img src="images/banner-subs-3.webp" alt="" />
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End banners-->
    <!-- percobaaan 1 -->
    <section class="product-tabs section-padding position-relative">
        <div class="container">
            <div class="section-title style-2 wow animate__animated animate__fadeIn">
                <h3>Popular Products</h3>
                <a href="#" class="show-all">View All</a>
            </div>

            <!-- Navigation Arrows -->
            <button class="scroll-btn scroll-left" disabled>
                <i class="fi-rs-angle-left"></i>
            </button>
            <button class="scroll-btn scroll-right">
                <i class="fi-rs-angle-right"></i>
            </button>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="tab-one" role="tabpanel" aria-labelledby="tab-one">
                    <div class="products-scroll-container">
                        <div class="row product-grid-4 scroll-wrapper">
                            <!-- PRODUCT CARD 1 -->
                            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 scroll-item">
                                <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".1s">
                                    <!-- Isi product card sama seperti sebelumnya -->
                                    <div class="product-img-action-wrap">
                                        <div class="product-img product-img-zoom">
                                            <a href="shop-product-right.html">
                                                <img class="default-img" src="assets-nest/nest-fe/imgs/shop/product-1-1.jpg" alt="" />
                                                <img class="hover-img" src="assets-nest/nest-fe/imgs/shop/product-1-2.jpg" alt="" />
                                            </a>
                                        </div>
                                        <div class="product-action-1">
                                            <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                            <a aria-label="Share" class="action-btn" href="#" title="Share"><i class="fi-rs-share"></i></a>
                                        </div>
                                        <div class="product-badges product-badges-position product-badges-mrg">
                                            <span class="hot">Hot</span>
                                        </div>
                                    </div>
                                    <div class="product-content-wrap">
                                        <div class="product-category">
                                            <a href="shop-grid-right.html">Travel Guide</a>
                                        </div>
                                        <h2><a href="shop-product-right.html">Hidden Paradise of Bali</a></h2>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                                        </div>
                                        <div>
                                            <span class="font-small text-muted">By <a href="vendor-details-1.html">Sarah Creator</a></span>
                                        </div>
                                        <div class="product-card-bottom">
                                            <div class="product-price">
                                                <span>Rp 99.000</span>
                                                <span class="old-price">Rp 120.000</span>
                                            </div>
                                            <div class="add-cart">
                                                <a class="add" href="shop-cart.html"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END PRODUCT CARD 1 -->
                            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 scroll-item">
                                <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".2s">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img product-img-zoom">
                                            <a href="shop-product-right.html">
                                                <img class="default-img" src="assets-nest/nest-fe/imgs/shop/product-2-1.jpg" alt="" />
                                                <img class="hover-img" src="assets-nest/nest-fe/imgs/shop/product-2-2.jpg" alt="" />
                                            </a>
                                        </div>
                                        <div class="product-action-1">
                                            <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                            <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
                                            <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                        </div>
                                        <div class="product-badges product-badges-position product-badges-mrg">
                                            <span class="sale">Sale</span>
                                        </div>
                                    </div>
                                    <div class="product-content-wrap">
                                        <div class="product-category">
                                            <a href="shop-grid-right.html">Hodo Foods</a>
                                        </div>
                                        <h2><a href="shop-product-right.html">All Natural Italian-Style Chicken Meatballs</a></h2>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 80%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (3.5)</span>
                                        </div>
                                        <div>
                                            <span class="font-small text-muted">By <a href="vendor-details-1.html">Stouffer</a></span>
                                        </div>
                                        <div class="product-card-bottom">
                                            <div class="product-price">
                                                <span>$52.85</span>
                                                <span class="old-price">$55.8</span>
                                            </div>
                                            <div class="add-cart">
                                                <a class="add" href="shop-cart.html"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end product card-->
                            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 scroll-item">
                                <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".3s">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img product-img-zoom">
                                            <a href="shop-product-right.html">
                                                <img class="default-img" src="assets-nest/nest-fe/imgs/shop/product-3-1.jpg" alt="" />
                                                <img class="hover-img" src="assets-nest/nest-fe/imgs/shop/product-3-2.jpg" alt="" />
                                            </a>
                                        </div>
                                        <div class="product-action-1">
                                            <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                            <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
                                            <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                        </div>
                                        <div class="product-badges product-badges-position product-badges-mrg">
                                            <span class="new">New</span>
                                        </div>
                                    </div>
                                    <div class="product-content-wrap">
                                        <div class="product-category">
                                            <a href="shop-grid-right.html">Snack</a>
                                        </div>
                                        <h2><a href="shop-product-right.html">Angie’s Boomchickapop Sweet & Salty Kettle Corn</a></h2>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 85%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                                        </div>
                                        <div>
                                            <span class="font-small text-muted">By <a href="vendor-details-1.html">StarKist</a></span>
                                        </div>
                                        <div class="product-card-bottom">
                                            <div class="product-price">
                                                <span>$48.85</span>
                                                <span class="old-price">$52.8</span>
                                            </div>
                                            <div class="add-cart">
                                                <a class="add" href="shop-cart.html"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end product card-->
                            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 scroll-item">
                                <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".4s">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img product-img-zoom">
                                            <a href="shop-product-right.html">
                                                <img class="default-img" src="assets-nest/nest-fe/imgs/shop/product-4-1.jpg" alt="" />
                                                <img class="hover-img" src="assets-nest/nest-fe/imgs/shop/product-4-2.jpg" alt="" />
                                            </a>
                                        </div>
                                        <div class="product-action-1">
                                            <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                            <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
                                            <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                        </div>
                                    </div>
                                    <div class="product-content-wrap">
                                        <div class="product-category">
                                            <a href="shop-grid-right.html">Vegetables</a>
                                        </div>
                                        <h2><a href="shop-product-right.html">Foster Farms Takeout Crispy Classic Buffalo Wings</a></h2>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                                        </div>
                                        <div>
                                            <span class="font-small text-muted">By <a href="vendor-details-1.html">NestFood</a></span>
                                        </div>
                                        <div class="product-card-bottom">
                                            <div class="product-price">
                                                <span>$17.85</span>
                                                <span class="old-price">$19.8</span>
                                            </div>
                                            <div class="add-cart">
                                                <a class="add" href="shop-cart.html"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end product card-->
                            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 scroll-item">
                                <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".5s">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img product-img-zoom">
                                            <a href="shop-product-right.html">
                                                <img class="default-img" src="assets-nest/nest-fe/imgs/shop/product-5-1.jpg" alt="" />
                                                <img class="hover-img" src="assets-nest/nest-fe/imgs/shop/product-5-2.jpg" alt="" />
                                            </a>
                                        </div>
                                        <div class="product-action-1">
                                            <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                            <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
                                            <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                        </div>
                                        <div class="product-badges product-badges-position product-badges-mrg">
                                            <span class="best">-14%</span>
                                        </div>
                                    </div>
                                    <div class="product-content-wrap">
                                        <div class="product-category">
                                            <a href="shop-grid-right.html">Pet Foods</a>
                                        </div>
                                        <h2><a href="shop-product-right.html">Blue Diamond Almonds Lightly Salted Vegetables</a></h2>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                                        </div>
                                        <div>
                                            <span class="font-small text-muted">By <a href="vendor-details-1.html">NestFood</a></span>
                                        </div>
                                        <div class="product-card-bottom">
                                            <div class="product-price">
                                                <span>$23.85</span>
                                                <span class="old-price">$25.8</span>
                                            </div>
                                            <div class="add-cart">
                                                <a class="add" href="shop-cart.html"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end product card-->
                            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 scroll-item">
                                <div class="product-cart-wrap wow animate__animated animate__fadeIn" data-wow-delay=".1s">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img product-img-zoom">
                                            <a href="shop-product-right.html">
                                                <img class="default-img" src="assets-nest/nest-fe/imgs/shop/product-6-1.jpg" alt="" />
                                                <img class="hover-img" src="assets-nest/nest-fe/imgs/shop/product-6-2.jpg" alt="" />
                                            </a>
                                        </div>
                                        <div class="product-action-1">
                                            <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                            <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
                                            <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                        </div>
                                    </div>
                                    <div class="product-content-wrap">
                                        <div class="product-category">
                                            <a href="shop-grid-right.html">Hodo Foods</a>
                                        </div>
                                        <h2><a href="shop-product-right.html">Chobani Complete Vanilla Greek Yogurt</a></h2>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                                        </div>
                                        <div>
                                            <span class="font-small text-muted">By <a href="vendor-details-1.html">NestFood</a></span>
                                        </div>
                                        <div class="product-card-bottom">
                                            <div class="product-price">
                                                <span>$54.85</span>
                                                <span class="old-price">$55.8</span>
                                            </div>
                                            <div class="add-cart">
                                                <a class="add" href="shop-cart.html"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end product card-->
                            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 scroll-item">
                                <div class="product-cart-wrap wow animate__animated animate__fadeIn" data-wow-delay=".2s">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img product-img-zoom">
                                            <a href="shop-product-right.html">
                                                <img class="default-img" src="assets-nest/nest-fe/imgs/shop/product-7-1.jpg" alt="" />
                                                <img class="hover-img" src="assets-nest/nest-fe/imgs/shop/product-7-2.jpg" alt="" />
                                            </a>
                                        </div>
                                        <div class="product-action-1">
                                            <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                            <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
                                            <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                        </div>
                                    </div>
                                    <div class="product-content-wrap">
                                        <div class="product-category">
                                            <a href="shop-grid-right.html">Meats</a>
                                        </div>
                                        <h2><a href="shop-product-right.html">Canada Dry Ginger Ale – 2 L Bottle - 200ml - 400g</a></h2>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                                        </div>
                                        <div>
                                            <span class="font-small text-muted">By <a href="vendor-details-1.html">NestFood</a></span>
                                        </div>
                                        <div class="product-card-bottom">
                                            <div class="product-price">
                                                <span>$32.85</span>
                                                <span class="old-price">$33.8</span>
                                            </div>
                                            <div class="add-cart">
                                                <a class="add" href="shop-cart.html"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end product card-->
                            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 scroll-item">
                                <div class="product-cart-wrap wow animate__animated animate__fadeIn" data-wow-delay=".3s">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img product-img-zoom">
                                            <a href="shop-product-right.html">
                                                <img class="default-img" src="assets-nest/nest-fe/imgs/shop/product-8-1.jpg" alt="" />
                                                <img class="hover-img" src="assets-nest/nest-fe/imgs/shop/product-8-2.jpg" alt="" />
                                            </a>
                                        </div>
                                        <div class="product-action-1">
                                            <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                            <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
                                            <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                        </div>
                                        <div class="product-badges product-badges-position product-badges-mrg">
                                            <span class="sale">Sale</span>
                                        </div>
                                    </div>
                                    <div class="product-content-wrap">
                                        <div class="product-category">
                                            <a href="shop-grid-right.html">Snack</a>
                                        </div>
                                        <h2><a href="shop-product-right.html">Encore Seafoods Stuffed Alaskan Salmon</a></h2>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                                        </div>
                                        <div>
                                            <span class="font-small text-muted">By <a href="vendor-details-1.html">NestFood</a></span>
                                        </div>
                                        <div class="product-card-bottom">
                                            <div class="product-price">
                                                <span>$35.85</span>
                                                <span class="old-price">$37.8</span>
                                            </div>
                                            <div class="add-cart">
                                                <a class="add" href="shop-cart.html"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end product card-->
                            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 scroll-item">
                                <div class="product-cart-wrap wow animate__animated animate__fadeIn" data-wow-delay=".4s">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img product-img-zoom">
                                            <a href="shop-product-right.html">
                                                <img class="default-img" src="assets-nest/nest-fe/imgs/shop/product-9-1.jpg" alt="" />
                                                <img class="hover-img" src="assets-nest/nest-fe/imgs/shop/product-9-2.jpg" alt="" />
                                            </a>
                                        </div>
                                        <div class="product-action-1">
                                            <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                            <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
                                            <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                        </div>
                                        <div class="product-badges product-badges-position product-badges-mrg">
                                            <span class="hot">Hot</span>
                                        </div>
                                    </div>
                                    <div class="product-content-wrap">
                                        <div class="product-category">
                                            <a href="shop-grid-right.html">Coffes</a>
                                        </div>
                                        <h2><a href="shop-product-right.html">Gorton’s Beer Battered Fish Fillets with soft paper</a></h2>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                                        </div>
                                        <div>
                                            <span class="font-small text-muted">By <a href="vendor-details-1.html">Old El Paso</a></span>
                                        </div>
                                        <div class="product-card-bottom">
                                            <div class="product-price">
                                                <span>$23.85</span>
                                                <span class="old-price">$25.8</span>
                                            </div>
                                            <div class="add-cart">
                                                <a class="add" href="shop-cart.html"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end product card-->
                            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 scroll-item d-none d-xl-block">
                                <div class="product-cart-wrap wow animate__animated animate__fadeIn" data-wow-delay=".5s">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img product-img-zoom">
                                            <a href="shop-product-right.html">
                                                <img class="default-img" src="assets-nest/nest-fe/imgs/shop/product-10-1.jpg" alt="" />
                                                <img class="hover-img" src="assets-nest/nest-fe/imgs/shop/product-10-2.jpg" alt="" />
                                            </a>
                                        </div>
                                        <div class="product-action-1">
                                            <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                            <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
                                            <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                        </div>
                                    </div>
                                    <div class="product-content-wrap">
                                        <div class="product-category">
                                            <a href="shop-grid-right.html">Cream</a>
                                        </div>
                                        <h2><a href="shop-product-right.html">Haagen-Dazs Caramel Cone Ice Cream Ketchup</a></h2>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 50%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (2.0)</span>
                                        </div>
                                        <div>
                                            <span class="font-small text-muted">By <a href="vendor-details-1.html">Tyson</a></span>
                                        </div>
                                        <div class="product-card-bottom">
                                            <div class="product-price">
                                                <span>$22.85</span>
                                                <span class="old-price">$24.8</span>
                                            </div>
                                            <div class="add-cart">
                                                <a class="add" href="shop-cart.html"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Products Tabs-->
    <section class="section-padding pb-5">
        <div class="container">
            <div class="section-title wow animate__animated animate__fadeIn">
                <div class="title">
                    <h4 class="">Promo Flash Sale</h4>
                </div>
                <a href="{{ route('promo') }}" class="show-all">View All</a>
            </div>
            <div class="row">
                <div class="col-lg-3 d-none d-lg-flex wow animate__animated animate__fadeIn">
                    <div class="banner-img style-2">
                    </div>
                </div>
                <div class="col-lg-9 col-md-12 wow animate__animated animate__fadeIn" data-wow-delay=".4s">
                    <div class="tab-content" id="myTabContent-1">
                        <div class="tab-pane fade show active" id="tab-one-1" role="tabpanel" aria-labelledby="tab-one-1">
                            <div class="carausel-4-columns-cover arrow-center position-relative">
                                <div class="slider-arrow slider-arrow-2 carausel-4-columns-arrow" id="carausel-4-columns-arrows"></div>
                                <div class="carausel-4-columns carausel-arrow-center" id="carausel-4-columns">
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href="shop-product-right.html">
                                                    <img class="default-img" src="assets-nest/nest-fe/imgs/shop/product-1-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets-nest/nest-fe/imgs/shop/product-1-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label="Quick view" class="action-btn small hover-up" data-bs-toggle="modal" data-bs-target="#quickViewModal"> <i class="fi-rs-eye"></i></a>
                                                <a aria-label="Add To Wishlist" class="action-btn small hover-up" href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                                <a aria-label="Compare" class="action-btn small hover-up" href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="hot">Save 15%</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href="shop-grid-right.html">Hodo Foods</a>
                                            </div>
                                            <h2><a href="shop-product-right.html">Seeds of Change Organic Quinoa, Brown</a></h2>
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 80%"></div>
                                            </div>
                                            <div class="product-price mt-10">
                                                <span>$238.85 </span>
                                                <span class="old-price">$245.8</span>
                                            </div>
                                            <div class="sold mt-15 mb-15">
                                                <div class="progress mb-5">
                                                    <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <span class="font-xs text-heading"> Sold: 90/120</span>
                                            </div>
                                            <a href="shop-cart.html" class="btn w-100 hover-up"><i class="fi-rs-shopping-cart mr-5"></i>Add To Cart</a>
                                        </div>
                                    </div>
                                    <!--End product Wrap-->
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href="shop-product-right.html">
                                                    <img class="default-img" src="assets-nest/nest-fe/imgs/shop/product-5-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets-nest/nest-fe/imgs/shop/product-5-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label="Quick view" class="action-btn small hover-up" data-bs-toggle="modal" data-bs-target="#quickViewModal"> <i class="fi-rs-eye"></i></a>
                                                <a aria-label="Add To Wishlist" class="action-btn small hover-up" href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                                <a aria-label="Compare" class="action-btn small hover-up" href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="new">Save 35%</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href="shop-grid-right.html">Hodo Foods</a>
                                            </div>
                                            <h2><a href="shop-product-right.html">All Natural Italian-Style Chicken Meatballs</a></h2>
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 80%"></div>
                                            </div>
                                            <div class="product-price mt-10">
                                                <span>$238.85 </span>
                                                <span class="old-price">$245.8</span>
                                            </div>
                                            <div class="sold mt-15 mb-15">
                                                <div class="progress mb-5">
                                                    <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <span class="font-xs text-heading"> Sold: 90/120</span>
                                            </div>
                                            <a href="shop-cart.html" class="btn w-100 hover-up"><i class="fi-rs-shopping-cart mr-5"></i>Add To Cart</a>
                                        </div>
                                    </div>
                                    <!--End product Wrap-->
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href="shop-product-right.html">
                                                    <img class="default-img" src="assets-nest/nest-fe/imgs/shop/product-2-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets-nest/nest-fe/imgs/shop/product-2-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label="Quick view" class="action-btn small hover-up" data-bs-toggle="modal" data-bs-target="#quickViewModal"> <i class="fi-rs-eye"></i></a>
                                                <a aria-label="Add To Wishlist" class="action-btn small hover-up" href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                                <a aria-label="Compare" class="action-btn small hover-up" href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="sale">Sale</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href="shop-grid-right.html">Hodo Foods</a>
                                            </div>
                                            <h2><a href="shop-product-right.html">Angie’s Boomchickapop Sweet and womnies</a></h2>
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 80%"></div>
                                            </div>
                                            <div class="product-price mt-10">
                                                <span>$238.85 </span>
                                                <span class="old-price">$245.8</span>
                                            </div>
                                            <div class="sold mt-15 mb-15">
                                                <div class="progress mb-5">
                                                    <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <span class="font-xs text-heading"> Sold: 90/120</span>
                                            </div>
                                            <a href="shop-cart.html" class="btn w-100 hover-up"><i class="fi-rs-shopping-cart mr-5"></i>Add To Cart</a>
                                        </div>
                                    </div>
                                    <!--End product Wrap-->
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href="shop-product-right.html">
                                                    <img class="default-img" src="assets-nest/nest-fe/imgs/shop/product-3-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets-nest/nest-fe/imgs/shop/product-3-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label="Quick view" class="action-btn small hover-up" data-bs-toggle="modal" data-bs-target="#quickViewModal"> <i class="fi-rs-eye"></i></a>
                                                <a aria-label="Add To Wishlist" class="action-btn small hover-up" href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                                <a aria-label="Compare" class="action-btn small hover-up" href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="best">Best sale</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href="shop-grid-right.html">Hodo Foods</a>
                                            </div>
                                            <h2><a href="shop-product-right.html">Foster Farms Takeout Crispy Classic </a></h2>
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 80%"></div>
                                            </div>
                                            <div class="product-price mt-10">
                                                <span>$238.85 </span>
                                                <span class="old-price">$245.8</span>
                                            </div>
                                            <div class="sold mt-15 mb-15">
                                                <div class="progress mb-5">
                                                    <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <span class="font-xs text-heading"> Sold: 90/120</span>
                                            </div>
                                            <a href="shop-cart.html" class="btn w-100 hover-up"><i class="fi-rs-shopping-cart mr-5"></i>Add To Cart</a>
                                        </div>
                                    </div>
                                    <!--End product Wrap-->
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href="shop-product-right.html">
                                                    <img class="default-img" src="assets-nest/nest-fe/imgs/shop/product-4-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets-nest/nest-fe/imgs/shop/product-4-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label="Quick view" class="action-btn small hover-up" data-bs-toggle="modal" data-bs-target="#quickViewModal"> <i class="fi-rs-eye"></i></a>
                                                <a aria-label="Add To Wishlist" class="action-btn small hover-up" href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                                <a aria-label="Compare" class="action-btn small hover-up" href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="hot">Save 15%</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href="shop-grid-right.html">Hodo Foods</a>
                                            </div>
                                            <h2><a href="shop-product-right.html">Blue Diamond Almonds Lightly Salted</a></h2>
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 80%"></div>
                                            </div>
                                            <div class="product-price mt-10">
                                                <span>$238.85 </span>
                                                <span class="old-price">$245.8</span>
                                            </div>
                                            <div class="sold mt-15 mb-15">
                                                <div class="progress mb-5">
                                                    <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <span class="font-xs text-heading"> Sold: 90/120</span>
                                            </div>
                                            <a href="shop-cart.html" class="btn w-100 hover-up"><i class="fi-rs-shopping-cart mr-5"></i>Add To Cart</a>
                                        </div>
                                    </div>
                                    <!--End product Wrap-->
                                </div>
                            </div>
                        </div>
                        <!--End tab-pane-->
                    </div>
                    <!--End tab-content-->
                </div>
                <!--End Col-lg-9-->
            </div>
        </div>
    </section>
    <!-- blogs -->
    <section class="section-padding pb-5">
        <div class="container mb-30">
            <div class="section-title style-2 flex-container-custom">
                <div class="title">
                    <h3>Latest Blog</h3>
                </div>
                <a href="{{ route('blogs')}}" class="show-all">View All</a>
            </div>
            <div class="loop-grid">
                <div class="row">
                    <article class="col-xl-3 col-lg-4 col-md-6 text-center hover-up mb-30 animated">
                        <div class="post-thumb">
                            <a href="blog-post-right.html">
                                <img class="border-radius-15" src="images/blogs/1.webp" alt="" />
                            </a>
                            <div class="entry-meta">
                                <a class="entry-meta meta-2" href="blog-category-grid.html"><i class="fi-rs-heart"></i></a>
                            </div>
                        </div>
                        <div class="entry-content-2">
                            <h6 class="mb-10 font-sm"><a class="entry-meta text-muted" href="blog-category-grid.html">Side Dish</a></h6>
                            <h4 class="post-title mb-15">
                                <a href="blog-post-right.html">Liburan Hemat Budget: Cara Menghemat Jutaan Rupiah Tanpa Mengorbankan Kenyamanan</a>
                            </h4>
                            <div class="entry-meta font-xs color-grey mt-10 pb-10">
                                <div>
                                    <span class="post-on mr-10">25 April 2022</span>
                                    <span class="hit-count has-dot mr-10">126k Views</span>
                                    <span class="hit-count has-dot">4 mins read</span>
                                </div>
                            </div>
                        </div>
                    </article>
                    <article class="col-xl-3 col-lg-4 col-md-6 text-center hover-up mb-30 animated">
                        <div class="post-thumb">
                            <a href="blog-post-right.html">
                                <img class="border-radius-15" src="images/blogs/2.webp" alt="" />
                            </a>
                        </div>
                        <div class="entry-content-2">
                            <h6 class="mb-10 font-sm"><a class="entry-meta text-muted" href="blog-category-grid.html">Soups and Stews</a></h6>
                            <h4 class="post-title mb-15">
                                <a href="blog-post-right.html">7 Rute Rahasia Indonesia yang Tidak Ada di Peta Wisatawan Biasa (Panduan Eksklusif)</a>
                            </h4>
                            <div class="entry-meta font-xs color-grey mt-10 pb-10">
                                <div>
                                    <span class="post-on mr-10">25 April 2022</span>
                                    <span class="hit-count has-dot mr-10">126k Views</span>
                                    <span class="hit-count has-dot">4 mins read</span>
                                </div>
                            </div>
                        </div>
                    </article>
                    <article class="col-xl-3 col-lg-4 col-md-6 text-center hover-up mb-30 animated">
                        <div class="post-thumb">
                            <a href="blog-post-right.html">
                                <img class="border-radius-15" src="images/blogs/3.webp" alt="" />
                            </a>
                            <div class="entry-meta">
                                <a class="entry-meta meta-2" href="blog-category-grid.html"><i class="fi-rs-link"></i></a>
                            </div>
                        </div>
                        <div class="entry-content-2">
                            <h6 class="mb-10 font-sm"><a class="entry-meta text-muted" href="blog-category-grid.html">Salad</a></h6>
                            <h4 class="post-title mb-15">
                                <a href="blog-post-right.html">Beyond Bali: 5 Destinasi Budaya Terbaik di Indonesia untuk Pecinta Sejarah</a>
                            </h4>
                            <div class="entry-meta font-xs color-grey mt-10 pb-10">
                                <div>
                                    <span class="post-on mr-10">25 April 2022</span>
                                    <span class="hit-count has-dot mr-10">126k Views</span>
                                    <span class="hit-count has-dot">4 mins read</span>
                                </div>
                            </div>
                        </div>
                    </article>
                    <!-- Article 4 -->
                    <article class="col-xl-3 col-lg-4 col-md-6 text-center hover-up mb-30 animated">
                        <div class="post-thumb">
                            <div class="image-frame">
                                <a href="post-kesalahan-fatal.html">
                                    <img class="border-radius-15" src="/images/blogs/6.webp" alt="Ransel traveling rusak" />
                                </a>
                            </div>
                        </div>
                        <div class="entry-content-2">
                            <h6 class="mb-10 font-sm"><a class="entry-meta text-muted" href="kategori-kesalahan-umum.html">Panduan Praktis</a></h6>
                            <h5 class="post-title mb-15">
                                <a href="post-kesalahan-fatal.html">Jangan Sampai Salah! Ini 10 Kesalahan Fatal Saat Traveling ke Pedalaman</a>
                            </h5>
                            <div class="entry-meta font-xs color-grey mt-10 pb-10">
                                <div>
                                    <span class="post-on mr-10">01 September 2025</span>
                                    <span class="hit-count has-dot mr-10">7.9k Views</span>
                                    <span class="hit-count has-dot">8 mins read</span>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
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
@endsection