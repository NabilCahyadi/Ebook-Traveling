@extends('layouts_lp.app')

@section('content')

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
        margin-bottom: 0.75rem;
    }

    /* Gaya untuk Deskripsi Buku (digabung dari 2 aturan) */
    .product-description {
        font-size: 0.85rem;
        color: var(--text-color-muted);
        margin-bottom: 1rem;
        min-height: 2.6em;
        /* Untuk konsistensi tinggi */
        display: -webkit-box;
        -webkit-line-clamp: 2;
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
</style>
<div class="container mt-5">
    <div class="page-header mt-30 mb-30">
        <div class="container">
            <div class="archive-header">
                <div class="row align-items-center">
                    <div class="col-xl-6">
                        <h1 class="mb-15">{{ $category->name }}</h1>
                        <div class="breadcrumb">
                            <p>{{ $category->description }}</p>
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
                    {{-- PINDAHKAN BAGIAN FILTER & SORT KE SINI --}}
                    <div class="shop-product-fillter mb-30">
                        <div class="totall-product">
                            <h4>
                                <img class="w-36px mr-10" src="assets/imgs/theme/icons/category-1.svg" alt="" />
                                Ebooks in this category
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
                    <!-- Menampilkan Data Ebooks - Start In Here -->
                    <!-- Menampilkan Data Ebooks - Start In Here -->
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="{{ $category->slug }}" role="tabpanel">
                            <div class="products-scroll-container">
                                <div class="row product-grid-4 scroll-wrapper">

                                    @if($category->ebooks->isNotEmpty())
                                    @foreach($category->ebooks as $index => $ebook)
                                    <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 scroll-item">

                                        {{-- ========== KARTU EBOOK ========== --}}
                                        <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn" data-wow-delay="{{ ($index + 1) * 0.1 }}s">
                                            <div class="product-img-action-wrap">
                                                <div class="product-img product-img-zoom">
                                                    <a href="{{ route('ebooks.show', $ebook->slug) }}">
                                                        <img class="default-img" src="{{ $ebook->cover_image ?: asset('assets-nest/nest-fe/imgs/shop/product-1-1.jpg') }}" alt="{{ $ebook->title }}" />
                                                    </a>
                                                </div>
                                                <div class="product-badges product-badges-position product-badges-mrg">
                                                    <span class="badge-language hot">{{ strtoupper($ebook->language) }}</span>
                                                </div>
                                            </div>
                                            <div class="product-content-wrap">
                                                <h2 style="margin-top:15px;"><a href="{{ route('ebooks.show', $ebook->slug) }}">{{ Str::limit($ebook->title, 40) }}</a></h2>

                                                <div class="product-author" style="margin-bottom:-4px;">
                                                    @if($ebook->creator)
                                                    <span>by {{ $ebook->creator->creator->pen_name ?? $ebook->creator->name }}</span>
                                                    @else
                                                    <span>by Unknown Author</span>
                                                    @endif
                                                </div>

                                                <div class="product-meta">
                                                    <div class="product-detail-rating">
                                                        <div class="product-rate-cover text-end">
                                                            <div class="product-rate-cover">
                                                                <div class="product-rate d-inline-block">
                                                                    {{-- MENGGUNAKAN ATRIBUT average_rating DARI TABEL EBOOKS --}}
                                                                    <div class="product-rating" style="width: {{ ($ebook->average_rating / 5) * 100 }}%"></div>
                                                                </div>
                                                                {{-- MENGGUNAKAN ATRIBUT average_rating JUGA --}}
                                                                <span class="font-small ml-5 text-muted">({{ round($ebook->average_rating, 2) }})</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="read-count">
                                                        <i class="fi-rs-eye align-middle"></i>
                                                        <span class="post-on">
                                                            @php
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
                                                            @endphp
                                                            {{ $formattedViews }}
                                                        </span>
                                                    </div>
                                                </div>

                                                <p class="product-description">{{ Str::limit($ebook->short_description ?? $ebook->description, 80) }}</p>

                                                {{-- LOGIKA TOMBOL AKSI --}}
                                                @if(auth()->check() && auth()->user()->hasActiveSubscription())
                                                <a href="/reader/{{ $ebook->slug }}" class="action-btn btn-read-now">
                                                    <i class="fi-rs-book-open"></i>
                                                    <span>Read Now</span>
                                                </a>
                                                @else
                                                <a href="{{ route('pricing') }}" class="action-btn btn-subscribe-now">
                                                    <i class="fi-rs-lock"></i>
                                                    <span>Subscribe to Read</span>
                                                </a>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                    @endforeach
                                    @else
                                    <div class="col-12 text-center py-5">
                                        <p class="text-muted">No ebooks available in this category yet.</p>
                                    </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Menampilkan Data Ebooks - End Here -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection