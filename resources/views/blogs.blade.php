@extends('layouts_lp.app')
@section('title', 'Blogs & News - MeatMap')

@section('content')
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
                                        <span><i class="fi-rs-apps"></i>Show:</span>
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
                                        <span><i class="fi-rs-apps-sort"></i>Sort:</span>
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
                            <!-- Article 1 -->
                            <article class="col-xl-3 col-lg-4 col-md-6 text-center hover-up mb-30 animated">
                                <div class="post-thumb">
                                    <div class="image-frame">
                                        <a href="post-rute-rahasia-indo.html">
                                            <img class="border-radius-15" src="/images/blogs/1.webp" alt="Pemandangan tersembunyi" />
                                        </a>
                                    </div>
                                    <div class="entry-meta">
                                        <a class="entry-meta meta-2" href="kategori-eksplorasi.html"><i class="fi-rs-eye"></i></a>
                                    </div>
                                </div>
                                <div class="entry-content-2">
                                    <h6 class="mb-10 font-sm"><a class="entry-meta text-muted" href="kategori-eksplorasi.html">Eksplorasi</a></h6>
                                    <h5 class="post-title mb-15">
                                        <a href="post-rute-rahasia-indo.html">7 Rute Rahasia Indonesia yang Tidak Ada di Peta Wisatawan Biasa</a>
                                    </h5>
                                    <div class="entry-meta font-xs color-grey mt-10 pb-10">
                                        <div>
                                            <span class="post-on mr-10">10 November 2025</span>
                                            <span class="hit-count has-dot mr-10">3.2k Views</span>
                                            <span class="hit-count has-dot">5 mins read</span>
                                        </div>
                                    </div>
                                </div>
                            </article>

                            <!-- Article 2 -->
                            <article class="col-xl-3 col-lg-4 col-md-6 text-center hover-up mb-30 animated">
                                <div class="post-thumb">
                                    <div class="image-frame">
                                        <a href="post-liburan-hemat-budget.html">
                                            <img class="border-radius-15" src="/images/blogs/2.webp" alt="Dompet dan koin" />
                                        </a>
                                    </div>
                                </div>
                                <div class="entry-content-2">
                                    <h6 class="mb-10 font-sm"><a class="entry-meta text-muted" href="kategori-tips-keuangan.html">Tips Keuangan</a></h6>
                                    <h5 class="post-title mb-15">
                                        <a href="post-liburan-hemat-budget.html">Liburan Hemat Budget: Cara Menghemat Jutaan Rupiah Tanpa Mengorbankan Kenyamanan</a>
                                    </h5>
                                    <div class="entry-meta font-xs color-grey mt-10 pb-10">
                                        <div>
                                            <span class="post-on mr-10">25 Oktober 2025</span>
                                            <span class="hit-count has-dot mr-10">5.8k Views</span>
                                            <span class="hit-count has-dot">6 mins read</span>
                                        </div>
                                    </div>
                                </div>
                            </article>

                            <!-- Article 3 -->
                            <article class="col-xl-3 col-lg-4 col-md-6 text-center hover-up mb-30 animated">
                                <div class="post-thumb">
                                    <div class="image-frame">
                                        <a href="post-culinary-journey.html">
                                            <img class="border-radius-15" src="/images/blogs/3.webp" alt="Makanan Indonesia" />
                                        </a>
                                    </div>
                                </div>
                                <div class="entry-content-2">
                                    <h6 class="mb-10 font-sm"><a class="entry-meta text-muted" href="kategori-kuliner.html">Kuliner</a></h6>
                                    <h5 class="post-title mb-15">
                                        <a href="post-culinary-journey.html">Jelajahi Kuliner Nusantara: Dari Rendang Padang sampai Sate Madura</a>
                                    </h5>
                                    <div class="entry-meta font-xs color-grey mt-10 pb-10">
                                        <div>
                                            <span class="post-on mr-10">15 Oktober 2025</span>
                                            <span class="hit-count has-dot mr-10">4.5k Views</span>
                                            <span class="hit-count has-dot">7 mins read</span>
                                        </div>
                                    </div>
                                </div>
                            </article>

                            <!-- Article 4 -->
                            <article class="col-xl-3 col-lg-4 col-md-6 text-center hover-up mb-30 animated">
                                <div class="post-thumb">
                                    <div class="image-frame">
                                        <a href="post-kesalahan-fatal.html">
                                            <img class="border-radius-15" src="/images/blogs/4.webp" alt="Ransel traveling rusak" />
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

                            <!-- Article 5 -->
                            <article class="col-xl-3 col-lg-4 col-md-6 text-center hover-up mb-30 animated">
                                <div class="post-thumb">
                                    <div class="image-frame">
                                        <a href="post-digital-nomad-asia.html">
                                            <img class="border-radius-15" src="/images/blogs/5.webp" alt="Orang bekerja di pantai" />
                                        </a>
                                    </div>
                                </div>
                                <div class="entry-content-2">
                                    <h6 class="mb-10 font-sm"><a class="entry-meta text-muted" href="kategori-digital-nomad.html">Gaya Hidup</a></h6>
                                    <h5 class="post-title mb-15">
                                        <a href="post-digital-nomad-asia.html">Mau Jadi Digital Nomad? Inilah Kota-Kota di Asia Tenggara dengan Biaya Hidup Paling Murah</a>
                                    </h5>
                                    <div class="entry-meta font-xs color-grey mt-10 pb-10">
                                        <div>
                                            <span class="post-on mr-10">15 Agustus 2025</span>
                                            <span class="hit-count has-dot mr-10">4.5k Views</span>
                                            <span class="hit-count has-dot">7 mins read</span>
                                        </div>
                                    </div>
                                </div>
                            </article>

                            <!-- Article 6 -->
                            <article class="col-xl-3 col-lg-4 col-md-6 text-center hover-up mb-30 animated">
                                <div class="post-thumb">
                                    <div class="image-frame">
                                        <a href="post-itinerary-jogja-3hari.html">
                                            <img class="border-radius-15" src="/images/blogs/6.webp" alt="Pemandangan kota Yogya" />
                                        </a>
                                    </div>
                                    <div class="entry-meta">
                                        <a class="entry-meta meta-2" href="kategori-itinerary.html"><i class="fi-rs-map-marker"></i></a>
                                    </div>
                                </div>
                                <div class="entry-content-2">
                                    <h6 class="mb-10 font-sm"><a class="entry-meta text-muted" href="kategori-itinerary.html">Itinerary</a></h6>
                                    <h5 class="post-title mb-15">
                                        <a href="post-itinerary-jogja-3hari.html">Yogyakarta: Itinerary 3 Hari Terbaik dan Tempat Makan Wajib Coba</a>
                                    </h5>
                                    <div class="entry-meta font-xs color-grey mt-10 pb-10">
                                        <div>
                                            <span class="post-on mr-10">01 Agustus 2025</span>
                                            <span class="hit-count has-dot mr-10">8.9k Views</span>
                                            <span class="hit-count has-dot">5 mins read</span>
                                        </div>
                                    </div>
                                </div>
                            </article>

                            <!-- Article 7 -->
                            <article class="col-xl-3 col-lg-4 col-md-6 text-center hover-up mb-30 animated">
                                <div class="post-thumb">
                                    <div class="image-frame">
                                        <a href="post-cara-memilih-ebook.html">
                                            <img class="border-radius-15" src="/images/blogs/7.webp" alt="Tangan memegang e-book reader" />
                                        </a>
                                    </div>
                                    <div class="entry-meta">
                                        <a class="entry-meta meta-2" href="kategori-panduan.html"><i class="fi-rs-play-alt"></i></a>
                                    </div>
                                </div>
                                <div class="entry-content-2">
                                    <h6 class="mb-10 font-sm"><a class="entry-meta text-muted" href="kategori-panduan.html">Produk</a></h6>
                                    <h5 class="post-title mb-15">
                                        <a href="post-cara-memilih-ebook.html">Panduan Lengkap: Cara Memilih E-book Travel yang Tepat Sesuai Gaya Perjalanan Anda</a>
                                    </h5>
                                    <div class="entry-meta font-xs color-grey mt-10 pb-10">
                                        <div>
                                            <span class="post-on mr-10">10 Juli 2025</span>
                                            <span class="hit-count has-dot mr-10">1.5k Views</span>
                                            <span class="hit-count has-dot">3 mins read</span>
                                        </div>
                                    </div>
                                </div>
                            </article>

                            <!-- Article 8 -->
                            <article class="col-xl-3 col-lg-4 col-md-6 text-center hover-up mb-30 animated">
                                <div class="post-thumb">
                                    <div class="image-frame">
                                        <a href="post-solo-travel-wanita.html">
                                            <img class="border-radius-15" src="/images/blogs/8.webp" alt="Wanita solo traveler" />
                                        </a>
                                    </div>
                                </div>
                                <div class="entry-content-2">
                                    <h6 class="mb-10 font-sm"><a class="entry-meta text-muted" href="kategori-solo-travel.html">Solo Travel</a></h6>
                                    <h5 class="post-title mb-15">
                                        <a href="post-solo-travel-wanita.html">Solo Travel Aman untuk Wanita: Tips dan Destinasi Paling Ramah di Asia</a>
                                    </h5>
                                    <div class="entry-meta font-xs color-grey mt-10 pb-10">
                                        <div>
                                            <span class="post-on mr-10">20 Juni 2025</span>
                                            <span class="hit-count has-dot mr-10">6.1k Views</span>
                                            <span class="hit-count has-dot">9 mins read</span>
                                        </div>
                                    </div>
                                </div>
                            </article>

                            <!-- Article 9 -->
                            <article class="col-xl-3 col-lg-4 col-md-6 text-center hover-up mb-30 animated">
                                <div class="post-thumb">
                                    <div class="image-frame">
                                        <a href="post-persiapan-rinjani.html">
                                            <img class="border-radius-15" src="/images/blogs/9.webp" alt="Pemandangan gunung" />
                                        </a>
                                    </div>
                                </div>
                                <div class="entry-content-2">
                                    <h6 class="mb-10 font-sm"><a class="entry-meta text-muted" href="kategori-mendaki.html">Adventure</a></h6>
                                    <h5 class="post-title mb-15">
                                        <a href="post-persiapan-rinjani.html">Persiapan Fisik & Mental: Checklist Wajib Sebelum Mendaki Gunung Rinjani</a>
                                    </h5>
                                    <div class="entry-meta font-xs color-grey mt-10 pb-10">
                                        <div>
                                            <span class="post-on mr-10">05 Juni 2025</span>
                                            <span class="hit-count has-dot mr-10">3.9k Views</span>
                                            <span class="hit-count has-dot">4 mins read</span>
                                        </div>
                                    </div>
                                </div>
                            </article>

                            <!-- Article 10 -->
                            <article class="col-xl-3 col-lg-4 col-md-6 text-center hover-up mb-30 animated">
                                <div class="post-thumb">
                                    <div class="image-frame">
                                        <a href="post-review-ebook-nama.html">
                                            <img class="border-radius-15" src="/images/blogs/10.webp" alt="Sampul e-book" />
                                        </a>
                                    </div>
                                </div>
                                <div class="entry-content-2">
                                    <h6 class="mb-10 font-sm"><a class="entry-meta text-muted" href="kategori-review.html">Review Produk</a></h6>
                                    <h5 class="post-title mb-15">
                                        <a href="post-review-ebook-nama.html">Review E-book "Backpacker Pro": Benarkah Ini Panduan Traveling Terlengkap Saat Ini?</a>
                                    </h5>
                                    <div class="entry-meta font-xs color-grey mt-10 pb-10">
                                        <div>
                                            <span class="post-on mr-10">15 Mei 2025</span>
                                            <span class="hit-count has-dot mr-10">1.2k Views</span>
                                            <span class="hit-count has-dot">3 mins read</span>
                                        </div>
                                    </div>
                                </div>
                            </article>

                            <!-- Article 11 -->
                            <article class="col-xl-3 col-lg-4 col-md-6 text-center hover-up mb-30 animated">
                                <div class="post-thumb">
                                    <div class="image-frame">
                                        <a href="post-trik-pesawat-murah.html">
                                            <img class="border-radius-15" src="/images/blogs/1.webp" alt="Pesawat di langit" />
                                        </a>
                                    </div>
                                    <div class="entry-meta">
                                        <a class="entry-meta meta-2" href="kategori-transportasi.html"><i class="fi-rs-heart"></i></a>
                                    </div>
                                </div>
                                <div class="entry-content-2">
                                    <h6 class="mb-10 font-sm"><a class="entry-meta text-muted" href="kategori-transportasi.html">Transportasi</a></h6>
                                    <h5 class="post-title mb-15">
                                        <a href="post-trik-pesawat-murah.html">Trik Rahasia Mendapatkan Tiket Pesawat Murah ke Eropa dengan Penerbangan Jarak Jauh</a>
                                    </h5>
                                    <div class="entry-meta font-xs color-grey mt-10 pb-10">
                                        <div>
                                            <span class="post-on mr-10">01 Mei 2025</span>
                                            <span class="hit-count has-dot mr-10">4.1k Views</span>
                                            <span class="hit-count has-dot">6 mins read</span>
                                        </div>
                                    </div>
                                </div>
                            </article>

                            <!-- Article 12 -->
                            <article class="col-xl-3 col-lg-4 col-md-6 text-center hover-up mb-30 animated">
                                <div class="post-thumb">
                                    <div class="image-frame">
                                        <a href="post-penginapan-unik-asia.html">
                                            <img class="border-radius-15" src="/images/blogs/2.webp" alt="Penginapan unik" />
                                        </a>
                                    </div>
                                </div>
                                <div class="entry-content-2">
                                    <h6 class="mb-10 font-sm"><a class="entry-meta text-muted" href="kategori-akomodasi.html">Akomodasi</a></h6>
                                    <h5 class="post-title mb-15">
                                        <a href="post-penginapan-unik-asia.html">12 Penginapan Paling Unik di Asia yang Wajib Anda Coba (Glamping Sampai Rumah Pohon)</a>
                                    </h5>
                                    <div class="entry-meta font-xs color-grey mt-10 pb-10">
                                        <div>
                                            <span class="post-on mr-10">10 April 2025</span>
                                            <span class="hit-count has-dot mr-10">2.7k Views</span>
                                            <span class="hit-count has-dot">5 mins read</span>
                                        </div>
                                    </div>
                                </div>
                            </article>

                            <!-- Article 13 -->
                            <article class="col-xl-3 col-lg-4 col-md-6 text-center hover-up mb-30 animated">
                                <div class="post-thumb">
                                    <div class="image-frame">
                                        <a href="post-makanan-khas-thailand.html">
                                            <img class="border-radius-15" src="/images/blogs/3.webp" alt="Makanan khas Thailand" />
                                        </a>
                                    </div>
                                </div>
                                <div class="entry-content-2">
                                    <h6 class="mb-10 font-sm"><a class="entry-meta text-muted" href="kategori-kuliner.html"> Kuliner Lokal </a></h6>
                                    <h5 class="post-title mb-15">
                                        <a href="post-makanan-khas-thailand.html">Wajib Coba! 7 Makanan Khas Thailand yang Paling Autentik (Bukan Hanya Tom Yum)</a>
                                    </h5>
                                    <div class="entry-meta font-xs color-grey mt-10 pb-10">
                                        <div>
                                            <span class="post-on mr-10">20 Maret 2025</span>
                                            <span class="hit-count has-dot mr-10">5.5k Views</span>
                                            <span class="hit-count has-dot">4 mins read</span>
                                        </div>
                                    </div>
                                </div>
                            </article>

                            <!-- Article 14 -->
                            <article class="col-xl-3 col-lg-4 col-md-6 text-center hover-up mb-30 animated">
                                <div class="post-thumb">
                                    <div class="image-frame">
                                        <a href="post-tips-packing-minimalis.html">
                                            <img class="border-radius-15" src="/images/blogs/4.webp" alt="Koper rapi" />
                                        </a>
                                    </div>
                                </div>
                                <div class="entry-content-2">
                                    <h6 class="mb-10 font-sm"><a class="entry-meta text-muted" href="kategori-packing.html">Persiapan</a></h6>
                                    <h5 class="post-title mb-15">
                                        <a href="post-tips-packing-minimalis.html">Packing Minimalis: Cara Mengemas Koper 7 Hari Liburan Hanya dalam 1 Tas Ransel</a>
                                    </h5>
                                    <div class="entry-meta font-xs color-grey mt-10 pb-10">
                                        <div>
                                            <span class="post-on mr-10">01 Maret 2025</span>
                                            <span class="hit-count has-dot mr-10">3.4k Views</span>
                                            <span class="hit-count has-dot">5 mins read</span>
                                        </div>
                                    </div>
                                </div>
                            </article>

                            <!-- Article 15 -->
                            <article class="col-xl-3 col-lg-4 col-md-6 text-center hover-up mb-30 animated">
                                <div class="post-thumb">
                                    <div class="image-frame">
                                        <a href="post-panduan-visa-schengen.html">
                                            <img class="border-radius-15" src="/images/blogs/5.webp" alt="Paspor dan visa" />
                                        </a>
                                    </div>
                                </div>
                                <div class="entry-content-2">
                                    <h6 class="mb-10 font-sm"><a class="entry-meta text-muted" href="kategori-visa-dokumen.html">Dokumen</a></h6>
                                    <h5 class="post-title mb-15">
                                        <a href="post-panduan-visa-schengen.html">Panduan Praktis Mendapatkan Visa Schengen Tanpa Agen (Langkah demi Langkah)</a>
                                    </h5>
                                    <div class="entry-meta font-xs color-grey mt-10 pb-10">
                                        <div>
                                            <span class="post-on mr-10">10 Februari 2025</span>
                                            <span class="hit-count has-dot mr-10">6.8k Views</span>
                                            <span class="hit-count has-dot">8 mins read</span>
                                        </div>
                                    </div>
                                </div>
                            </article>

                            <!-- Article 16 -->
                            <article class="col-xl-3 col-lg-4 col-md-6 text-center hover-up mb-30 animated">
                                <div class="post-thumb">
                                    <div class="image-frame">
                                        <a href="post-panduan-visa-schengen.html">
                                            <img class="border-radius-15" src="/images/blogs/6.webp" alt="Paspor dan visa" />
                                        </a>
                                    </div>
                                </div>
                                <div class="entry-content-2">
                                    <h6 class="mb-10 font-sm"><a class="entry-meta text-muted" href="kategori-visa-dokumen.html">Dokumen</a></h6>
                                    <h5 class="post-title mb-15">
                                        <a href="post-panduan-visa-schengen.html">Relaksasi Diri - Solo Travel</a>
                                    </h5>
                                    <div class="entry-meta font-xs color-grey mt-10 pb-10">
                                        <div>
                                            <span class="post-on mr-10">30 April 2025</span>
                                            <span class="hit-count has-dot mr-10">6.8k Views</span>
                                            <span class="hit-count has-dot">8 mins read</span>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </div>
                    </div>
                    <div class="pagination-area mt-15 mb-sm-5 mb-lg-0">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-end">
                                <li class="page-item">
                                    <a class="page-link" href="#"><i class="fi-rs-arrow-small-left"></i></a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item active"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link dot" href="#">...</a></li>
                                <li class="page-item"><a class="page-link" href="#">6</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#"><i class="fi-rs-arrow-small-right"></i></a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection