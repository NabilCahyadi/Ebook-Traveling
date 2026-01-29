@props(['collection']) {{-- Definisikan bahwa komponen ini menerima data 'collection' --}}

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

    /* Style untuk judul koleksi */
    .section-title.style-2 h3 {
        margin-bottom: 5px;
    }

    /* Gaya kolom untuk baris dan spacing */
    .row.product-grid-4 {
        margin-left: -15px;
        margin-right: -15px;
    }

    .row.product-grid-4 > div {
        padding-left: 15px;
        padding-right: 15px;
        margin-bottom: 30px;
    }

    /* Gaya Umum untuk Kartu */
    .product-cart-wrap {
        border: 1px solid rgba(255, 255, 255, 0.05);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .product-content-wrap {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    /* Gaya untuk Judul Buku */
    .product-cart-wrap h2 {
        font-size: 1.1rem;
        line-height: 1.4;
        margin-bottom: 0.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        min-height: 3.2em;
    }

    .product-author {
        font-size: 0.9rem;
        color: var(--text-color-muted);
        margin-bottom: -12px;
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

    /* Gaya untuk Deskripsi Buku */
    .product-description {
        font-size: 0.85rem;
        color: var(--text-color-muted);
        margin-bottom: 0.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        min-height: 2.8em;
        flex-grow: 1;
        margin-bottom: -0.80rem;
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
        background-color: #de364aff;
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
<section class="product-tabs section-padding position-relative">
    <div class="container">
        {{-- Bagian Judul Koleksi --}}
        <div class="section-title style-2 wow animate__animated animate__fadeIn">
            <h3>{{ $collection->name }}</h3>
            @if ($collection->description)
                <p class="collection-description">{{ $collection->description }}</p>
            @endif
        </div>

        {{-- Kontainer untuk Daftar Ebook --}}
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="{{ $collection->slug }}" role="tabpanel">
                <div class="products-scroll-container">
                    <div class="row product-grid-4 scroll-wrapper">
                        @if ($collection->ebooks->isNotEmpty())
                            @foreach ($collection->ebooks as $index => $ebook)
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 scroll-item">

                                    {{-- ========== KARTU EBOOK YANG SAMA UNTUK SEMUA USER ========== --}}
                                    <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn"
                                        data-wow-delay="{{ ($index + 1) * 0.1 }}s">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href="/ebooks/{{ $ebook->slug }}">
                                                    @php
                                                        $coverImage = $ebook->external_cover_url
                                                            ? $ebook->external_cover_url
                                                            : $ebook->cover_image_url ??
                                                                'assets-nest/nest-fe/imgs/shop/product-1-1.jpg';
                                                    @endphp
                                                    <img class="default-img" src="{{ $coverImage }}"
                                                        alt="{{ $ebook->title }}" />
                                                </a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span
                                                    class="badge-language hot">{{ strtoupper($ebook->language) }}</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <h2 style="margin-top:15px;"><a
                                                    href="/ebooks/{{ $ebook->slug }}">{{ Str::limit($ebook->title, 40) }}</a>
                                            </h2>

                                            <div class="product-author" style="margin-bottom:-4px;">
                                                @if ($ebook->creator)
                                                    <span>by
                                                        {{ $ebook->creator->creator->pen_name ?? $ebook->creator->name }}</span>
                                                @else
                                                    <span>by Unknown Author</span>
                                                @endif
                                            </div>

                                            <div class="product-meta">
                                                <div class="product-detail-rating">
                                                    <div class="product-rate-cover text-end">
                                                        <div class="product-rate-cover">
                                                            <div class="product-rate d-inline-block">
                                                                {{-- HITUNG RATA-RATA LANGSUNG DARI TABEL ebook_ratings --}}
                                                                <div class="product-rating"
                                                                    style="width: {{ ($ebook->ratings()->avg('rating') / 5) * 100 }}%">
                                                                </div>
                                                            </div>
                                                            {{-- TAMPILKAN JUGA RATA-RATA YANG SAMA --}}
                                                            <span
                                                                class="font-small ml-5 text-muted">({{ round($ebook->ratings()->avg('rating'), 2) }})</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="read-count">
                                                    <i
                                                        class="fi fi-rs-eye align-middle"></i><!--  {{ number_format($ebook->view_count) }} -->
                                                    <span class="post-on">
                                                        @php
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
                                                        @endphp
                                                        {{ $formattedViews }}
                                                    </span>
                                                </div>
                                            </div>

                                            <p class="product-description">
                                                {{ Str::limit(strip_tags($ebook->short_description ?? $ebook->description), 80) }}
                                            </p>

                                            {{-- LOGIKA HANYA PADA TOMBOL AKSI --}}
                                            @if (auth()->check() && auth()->user()->hasActiveSubscription())
                                                <a href="{{ route('user.ebook.read', $ebook->slug) }}"
                                                    class="action-btn btn-read-now">
                                                    <span>Read Now</span>
                                                </a>
                                            @else
                                                <a href="/pricing" class="action-btn btn-subscribe-now">
                                                    <i class="fi fi-rs-lock mt-1"></i>
                                                    <span>Subscribe to Read</span>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12 text-center py-5">
                                <p class="text-muted">No ebooks available in this collection yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
