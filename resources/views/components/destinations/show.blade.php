<!-- resources/views/components/destinations/show.blade.php -->
@extends('layouts_lp.app')

@section('title', $city->name . ' - Destination Details')

@section('content')
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

<div class="container mt-5 mb-5">
    <!-- Bagian Utama Detail Kota -->
    <section class="product-tabs section-padding position-relative">
        <div class="container">
            {{-- Kontainer untuk Detail Kota --}}
            <div class="row">
                <div class="col-lg-12">
                    <!-- Tombol Kembali -->
                    <a href="{{ url('/destinations') }}" class="btn mb-4 fs-6">
                        <i class="bi bi-arrow-left"></i>‎ ‎ Back
                    </a>
                    <div class="city-detail-card">
                        {{-- Gambar Kota --}}
                        <div class="city-image">
                            @if($city->image)
                            <img src="{{ $city->image }}" alt="{{ $city->name }}">
                            @else
                            <img src="https://via.placeholder.com/1200x450.png?text=Gambar+Tidak+Tersedia" alt="Gambar Tidak Tersedia">
                            @endif
                        </div>

                        {{-- Konten Detail --}}
                        <div class="city-content">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h3 class="mb-3">{{ $city->name }}</h3>
                                    <p class="city-description">
                                        {{-- Jika deskripsi panjang, Anda bisa menampilkannya di sini --}}
                                        {{ $city->description ?? 'Informasi detail tentang kota ini belum tersedia.' }}
                                    </p>
                                </div>

                                <div class="col-lg-4">
                                    <div class="city-meta">
                                        <h5 class="mb-3">Information</h5>

                                        <div class="city-meta-item">
                                            <i class="bi bi-geo-alt"></i>
                                            <span><strong>Province :</strong> {{ $city->province }}</span>
                                        </div>

                                        <div class="city-meta-item">
                                            <i class="bi bi-eye"></i>
                                            <span><strong>Viewed :</strong> {{ number_format($city->views_count) }} kali</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Tampilkan List E-books Terkait --}}
            <section class="ebooks-section mt-5">
                <div class="container">
                    <!-- <hr class="my-5"> -->
                    <h4 class="my-5">Discover Your Journey to {{ $city->name }}</h4>

                    <div class="row product-grid-4">
                        @if($ebooks->isNotEmpty())
                        @foreach($ebooks as $index => $ebook)
                        <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                            {{-- Kartu E-book --}}
                            <div class="product-cart-wrap mb-30">
                                <div class="product-img-action-wrap">
                                    <div class="product-img product-img-zoom">
                                        <a href="/ebooks/{{ $ebook->slug }}">
                                            <img class="default-img" src="{{ $ebook->cover_image ?: 'https://via.placeholder.com/300x400.png?text=No+Cover' }}" alt="{{ $ebook->title }}" />
                                        </a>
                                    </div>
                                    <div class="product-badges product-badges-position product-badges-mrg">
                                        <span class="badge-language hot">{{ strtoupper($ebook->language) }}</span>
                                    </div>
                                </div>
                                <div class="product-content-wrap">
                                    <h2><a href="/ebooks/{{ $ebook->slug }}">{{ Str::limit($ebook->title, 40) }}</a></h2>
                                    <div class="product-author">
                                        @if($ebook->creator)
                                        <span>by {{ $ebook->creator->pen_name ?? $ebook->creator->name }}</span>
                                        @else
                                        <span>by Unknown Author</span>
                                        @endif
                                    </div>
                                    <div class="product-meta">
                                        <div class="product-detail-rating">
                                            <div class="product-rate-cover text-end">
                                                <div class="product-rate-cover">
                                                    <div class="product-rate d-inline-block">
                                                        <div class="product-rating" style="width: {{ ($ebook->ratings->avg('rating') / 5) * 100 }}%"></div>
                                                    </div>
                                                    <span class="font-small ml-5 text-muted">({{ round($ebook->ratings->avg('rating'), 2) }})</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="read-count">
                                            <i class="fi-rs-eye align-middle"></i>
                                            <span class="post-on">
                                                @php
                                                $views = $ebook->view_count;
                                                if ($views >= 1000000) {
                                                $formattedViews = number_format($views / 1000000, 1) . 'M';
                                                } elseif ($views >= 1000) {
                                                $formattedViews = number_format($views / 1000, 1) . 'k';
                                                } else {
                                                $formattedViews = $views;
                                                }
                                                @endphp
                                                {{ $formattedViews }}
                                            </span>
                                        </div>
                                    </div>
                                    @php
                                    // Ambil teks deskripsi
                                    $descriptionText = $ebook->short_description ?? $ebook->description;

                                    // Cek apakah teks pendek (kira-kira 1 baris). Sesuaikan angka 40 jika perlu.
                                    $isSingleLine = strlen($descriptionText) <= 35;
                                        @endphp

                                        <p class="product-description {{ $isSingleLine ? 'single-line' : '' }}">
                                        {{ Str::limit($descriptionText, 75) }}
                                        </p>
                                        {{-- Logika Tombol Aksi --}}
                                        @if(auth()->check() && auth()->user()->hasActiveSubscription())
                                        <a href="/reader/{{ $ebook->slug }}" class="action-btn btn-read-now">
                                            <i class="fi-rs-book-open"></i>
                                            <span>Read Now</span>
                                        </a>
                                        @else
                                        <a href="/pricing" class="action-btn btn-subscribe-now">
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
                            <p class="text-muted">Belum ada e-book untuk destinasi ini.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </section>
        </div>
    </section>
</div>
@endsection