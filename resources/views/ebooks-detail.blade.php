@extends('layouts_lp.app')

@section('title', $ebook->title)

@section('content')
    <style>
        /* Sticky Sidebar Styling */
        .sticky-sidebar {
            position: relative;
        }

        .sticky-sidebar .detail-gallery {
            position: sticky;
            top: 100px;
            /* Jarak dari top saat sticky */
            z-index: 10;
        }

        /* Responsiveness - disable sticky on mobile */
        @media (max-width: 767px) {
            .sticky-sidebar .detail-gallery {
                position: relative;
                top: auto;
            }
        }

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

        /* Description Show More/Less Styling */
        .description-content {
            position: relative;
            line-height: 1.6em;
        }

        .truncated-desc,
        .full-desc {
            display: inline;
        }

        .show-more-btn {
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            cursor: pointer;
            color: #FF4C61;
            transition: color 0.2s ease;
            display: inline-block;
            margin-top: 5px;
        }

        .show-more-btn:hover {
            color: #e03a4d;
        }

        .show-more-btn i {
            font-size: 0.8rem;
            transition: transform 0.2s ease;
            display: inline-block;
        }

        .show-more-btn.expanded i {
            transform: rotate(180deg);
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
            margin-top: 15px;
            min-width: 140px !important;
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

        /* wishlist/favorite */
        .favorite-btn {
            width: 45px;
            height: 45px;
            padding: 0 !important;
            margin-top: 15px;
            border: 1px solid #FF4C61;
            border-radius: 5px;
            background-color: #FF4C61;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .favorite-btn i {
            color: white;
            font-size: 16px;
        }

        .favorite-btn.saved {
            background-color: white;
        }

        .favorite-btn.saved i {
            color: #FF4C61;
        }
    </style>
    <style>
        /* ✅ Style khusus untuk tombol di modal edit review */
        .btn-submit-review {
            padding: 10px 20px !important;
            border: none !important;
            border-radius: 50px !important;
            font-size: 0.9rem !important;
            font-weight: 600 !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
            letter-spacing: 1px !important;
            text-decoration: none !important;
            text-align: center !important;
            display: inline-block !important;
            background-color: #FF4C61 !important;
            color: white !important;
        }

        .btn-submit-review:hover {
            background-color: #FF416C !important;
            transform: translateY(-3px) !important;
        }

        .custom-button {
            padding: 10px 10px;
            border: none;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            letter-spacing: 1px;
            text-decoration: none;
            text-align: center;
            display: inline-block;
        }

        .custom-button--primary {
            background-color: #FF4C61;
            color: #fff;
        }

        .pricing-card--featured .custom-button--primary {
            background-color: var(--primary-color);
            box-shadow: 0 5px 15px rgba(255, 76, 97, 0.3);
        }

        .custom-button--primary:hover {
            background-color: #FF416C;
            transform: translateY(-3px);
            color: #fff;
        }
    </style>

    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ route('home') }}" rel="nofollow"><i class="fi fi-rs-home mr-5"></i></a>
                    <span></span>
                    <a href="/">E-Books</a>
                    <span class="active">‎ ‎ {{ $ebook->title }}</span>
                </div>
            </div>
        </div>
        <div class="container mb-30">
            <div class="row">
                <div class="col-xl-10 col-lg-12 m-auto">
                    <div class="product-detail accordion-detail">
                        <div class="row mb-50 mt-30">
                            <div class="col-md-3 col-sm-12 col-xs-12 mb-md-0 mb-sm-5 sticky-sidebar">
                                <div class="detail-gallery">
                                    <!-- GAMBAR DIBUNGKUS DENGAN FRAME KHUSUS -->
                                    <div class="ebook-cover-frame">
                                        <img src="@if ($ebook->cover_image && filter_var($ebook->cover_image, FILTER_VALIDATE_URL)) {{ $ebook->cover_image }}@elseif($ebook->cover_image){{ asset('storage/' . $ebook->cover_image) }}@else{{ asset('images/ebook-placeholder.webp') }} @endif"
                                            alt="{{ $ebook->title }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9 col-sm-12 col-xs-12">
                                <div class="detail-info pr-30 pl-30">
                                    @if ($ebook->is_featured)
                                        <span class="stock-status out-stock"> Featured </span>
                                    @endif
                                    <h2 class="title-detail">{{ $ebook->title }}</h2>
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
                                    <div class="short-desc mb-30">
                                        @php
                                            $fullDescription = strip_tags($ebook->description);
                                            $charLimit = 385;
                                            $needsShowMore = strlen($fullDescription) > $charLimit;
                                        @endphp

                                        <div class="font-lg description-content" id="ebookDescription"
                                            data-full-text="{{ htmlspecialchars($fullDescription) }}">
                                            @if ($needsShowMore)
                                                <span
                                                    class="truncated-desc">{{ substr($fullDescription, 0, $charLimit) }}...</span>
                                                <span class="full-desc"
                                                    style="display: none;">{{ $fullDescription }}</span>
                                            @else
                                                {{ $fullDescription }}
                                            @endif
                                        </div>

                                        @if ($needsShowMore)
                                            <span class="show-more-btn" id="showMoreBtn">
                                                Show More
                                            </span>
                                        @endif
                                    </div>
                                    <div class="font-xs">
                                        <ul class="mr-50 float-start">
                                            <li class="mb-5">Creator : <span
                                                    class="text-brand">{{ $ebook->creator->name ?? ($ebook->author ?? 'Unknown') }}</span>
                                            </li>
                                            <li class="mb-5">
                                                Language :
                                                <span class="text-brand">
                                                    @if ($ebook->language === 'en')
                                                        English
                                                    @elseif($ebook->language === 'id')
                                                        Indonesian
                                                    @else
                                                        {{ $ebook->language }} {{-- Tampilkan kode asli jika tidak cocok --}}
                                                    @endif
                                                </span>
                                            </li>
                                            <li>Published : <span
                                                    class="text-brand">{{ \Carbon\Carbon::parse($ebook->published_at)->format('d M Y') }}</span>
                                            </li>
                                            <li class="d-flex align-items-center gap-2">
                                                @if (auth()->check() && auth()->user()->hasActiveSubscription())
                                                    <a href="{{ route('user.ebook.read', $ebook->slug) }}"
                                                        class="action-btn btn-read-now">
                                                        <span>Read Now</span>
                                                    </a>
                                                @else
                                                    <a href="/pricing" class="action-btn btn-subscribe-now">
                                                        <i class="fi fi-rs-lock"></i>
                                                        <span>Subscribe to Read</span>
                                                    </a>
                                                @endif

                                                <!-- ✅ ICON ONLY DI SAMPING KANAN -->
                                                @if (auth()->check())
                                                    <div style="display: flex; align-items: center;">
                                                        <button id="favorite-btn-{{ $ebook->id }}"
                                                            class="favorite-btn {{ $isSaved ? 'saved' : '' }}"
                                                            data-ebook-id="{{ $ebook->id }}"
                                                            title="{{ $isSaved ? 'Remove from saved' : 'Save this book' }}">
                                                            <i
                                                                class="bi {{ $isSaved ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                                        </button>
                                                    </div>
                                                @endif
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
                                        <h4 class="mb-10">Customer Reviews ( {{ $ratings->total() }} ) </h4>
                                        <div class="showing-info">Showing {{ $ratings->firstItem() }} to
                                            {{ $ratings->lastItem() }} of {{ $ratings->total() }} reviews</div>

                                        <div class="comment-list">
                                            @forelse ($ratings as $rating)
                                                <div class="single-comment mb-30">
                                                    <div class="review-header">
                                                        <div class="product-rate d-inline-block">
                                                            <div class="product-rating"
                                                                style="width: {{ ($rating->rating / 5) * 100 }}%"></div>
                                                        </div>
                                                        <div class="review-date">
                                                            {{ $rating->created_at->format('F d, Y') }}</div>
                                                    </div>
                                                    <div class="review-user">
                                                        <div class="avatar-container">
                                                            <img src="{{ $rating->user->avatar ? asset('storage/' . $rating->user->avatar) : asset('/images/user-avatar.png') }}"
                                                                alt="{{ $rating->user->name }}" class="user-avatar" />
                                                        </div>
                                                        <a href=""
                                                            class="username ms-3">{{ $rating->user->name }}</a>
                                                    </div>
                                                    <div class="review-text-container">
                                                        {{-- Teks yang dipotong (akan muncul pertama kali) --}}
                                                        <p class="truncated-text">
                                                            {{ Str::limit($rating->review_text, 180) }}</p>

                                                        {{-- Teks lengkap (awalnya disembunyikan) --}}
                                                        <p class="full-text" style="display: none;">
                                                            {{ $rating->review_text }}</p>

                                                        {{-- Link "more" / "less" --}}
                                                        @if (Str::length($rating->review_text) > 150)
                                                            <a href="#" class="read-more-link">more</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="single-comment mb-30">
                                                    <p>There are no reviews for this e-book yet.</p>
                                                </div>
                                            @endforelse
                                        </div>

                                        <!-- PAGINASI -->
                                        @if ($ratings->hasPages())
                                            <div class="pagination-area mt-15 mb-sm-5 mb-lg-0">
                                                {{ $ratings->links('pagination::bootstrap-4') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- BAGIAN KANAN: SIDEBAR RATING -->
                                <div class="col-lg-4">
                                    <div class="rating-container">
                                        <h4 class="mb-30">Average Rating</h4>
                                        <div class="d-flex mb-30">
                                            <div class="product-rate d-inline-block mr-15">
                                                <div class="product-rating"
                                                    style="width: {{ ($ebook->ratings()->avg('rating') / 5) * 100 }}%">
                                                </div>
                                            </div>
                                            <h6>{{ number_format($ebook->ratings()->avg('rating'), 1) }} out of 5</h6>
                                        </div>

                                        {{-- GUNAKAN STRUKTUR INI --}}
                                        <div class="d-flex align-items-center mb-15">
                                            <span class="me-3" style="width: 50px;">5 star</span>
                                            <div class="progress flex-grow-1">
                                                <div class="progress-bar" role="progressbar"
                                                    style="width: {{ $ebook->total_reviews > 0 ? ($ratingDistribution[5] / $ebook->total_reviews) * 100 : 0 }}%"
                                                    aria-valuenow="{{ $ebook->total_reviews > 0 ? ($ratingDistribution[5] / $ebook->total_reviews) * 100 : 0 }}"
                                                    aria-valuemin="0" aria-valuemax="100">
                                                    {{ $ebook->total_reviews > 0 ? number_format(($ratingDistribution[5] / $ebook->total_reviews) * 100) : 0 }}%
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-15">
                                            <span class="me-3" style="width: 50px;">4 star</span>
                                            <div class="progress flex-grow-1">
                                                <div class="progress-bar" role="progressbar"
                                                    style="width: {{ $ebook->total_reviews > 0 ? ($ratingDistribution[4] / $ebook->total_reviews) * 100 : 0 }}%"
                                                    aria-valuenow="{{ $ebook->total_reviews > 0 ? ($ratingDistribution[4] / $ebook->total_reviews) * 100 : 0 }}"
                                                    aria-valuemin="0" aria-valuemax="100">
                                                    {{ $ebook->total_reviews > 0 ? number_format(($ratingDistribution[4] / $ebook->total_reviews) * 100) : 0 }}%
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-15">
                                            <span class="me-3" style="width: 50px;">3 star</span>
                                            <div class="progress flex-grow-1">
                                                <div class="progress-bar" role="progressbar"
                                                    style="width: {{ $ebook->total_reviews > 0 ? ($ratingDistribution[3] / $ebook->total_reviews) * 100 : 0 }}%"
                                                    aria-valuenow="{{ $ebook->total_reviews > 0 ? ($ratingDistribution[3] / $ebook->total_reviews) * 100 : 0 }}"
                                                    aria-valuemin="0" aria-valuemax="100">
                                                    {{ $ebook->total_reviews > 0 ? number_format(($ratingDistribution[3] / $ebook->total_reviews) * 100) : 0 }}%
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-15">
                                            <span class="me-3" style="width: 50px;">2 star</span>
                                            <div class="progress flex-grow-1">
                                                <div class="progress-bar" role="progressbar"
                                                    style="width: {{ $ebook->total_reviews > 0 ? ($ratingDistribution[2] / $ebook->total_reviews) * 100 : 0 }}%"
                                                    aria-valuenow="{{ $ebook->total_reviews > 0 ? ($ratingDistribution[2] / $ebook->total_reviews) * 100 : 0 }}"
                                                    aria-valuemin="0" aria-valuemax="100">
                                                    {{ $ebook->total_reviews > 0 ? number_format(($ratingDistribution[2] / $ebook->total_reviews) * 100) : 0 }}%
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-30">
                                            <span class="me-3" style="width: 50px;">1 star</span>
                                            <div class="progress flex-grow-1">
                                                <div class="progress-bar" role="progressbar"
                                                    style="width: {{ $ebook->total_reviews > 0 ? ($ratingDistribution[1] / $ebook->total_reviews) * 100 : 0 }}%"
                                                    aria-valuenow="{{ $ebook->total_reviews > 0 ? ($ratingDistribution[1] / $ebook->total_reviews) * 100 : 0 }}"
                                                    aria-valuemin="0" aria-valuemax="100">
                                                    {{ $ebook->total_reviews > 0 ? number_format(($ratingDistribution[1] / $ebook->total_reviews) * 100) : 0 }}%
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- FORM UNTUK MENAMBAH REVIEW --}}
                        <div class="comment-form">
                            <h4 class="mb-15">Add a review</h4>

                            {{-- CEK: Apakah user sudah login? --}}
                            @if (auth()->check())

                                {{-- Jika login, CEK: Apakah user sudah premium? --}}
                                @if (auth()->user()->hasActiveSubscription())

                                    {{-- Jika premium, CEK: Apakah sudah pernah review? --}}
                                    @if (!$hasReviewed)
                                        {{-- BELUM REVIEW: Tampilkan form --}}
                                        <form class="form-contact comment_form" action="{{ route('ratings.store') }}"
                                            method="POST">
                                            @csrf
                                            <input type="hidden" name="ebook_id" value="{{ $ebook->id }}">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <textarea class="form-control w-100" name="review_text" id="comment" cols="30" rows="9"
                                                            placeholder="Write Comment" required></textarea>
                                                    </div>
                                                </div>
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
                                                <button type="submit"
                                                    class="button button-contactForm btn-submit-review">Submit
                                                    Review</button>
                                            </div>
                                        </form>
                                    @else
                                        {{-- SUDAH REVIEW: Tampilkan pesan --}}
                                        <div class="alert alert-success">
                                            <p>You have already submitted a review for this ebook.</p>
                                        </div>
                                    @endif
                                @else
                                    {{-- BELUM PREMIUM: Tampilkan pesan untuk upgrade --}}
                                    <div class="alert alert-warning">
                                        <h5 style="margin-bottom: 10px;">Premium Feature</h5>
                                        <p style="margin-bottom: 10px;">To give a rating and review, you need to upgrade
                                            your account to Premium.</p>
                                        <a href="{{ route('pricing') }}" class="btn btn-warning">Subscribe Now</a>
                                    </div>
                                @endif
                            @else
                                {{-- BELUM LOGIN: Tampilkan peringatan untuk login --}}
                                <div class="alert alert-custom-info d-flex align-items-center" role="alert">
                                    <div class="flex-shrink-0">
                                        <i class="fi fi-rr-lock large-icon"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="mb-3">Sign in or create a free account to share your thoughts about
                                            this book.</p>
                                        <div>
                                            <a href="{{ route('login') }}"
                                                class="custom-button custom-button--primary px-4 me-2">
                                                <i class="fi fi-rr-sign-in-alt me-1"></i> Login
                                            </a>
                                            <a href="{{ route('login') }}?form=register"
                                                class="custom-button custom-button--primary px-4">
                                                <i class="fi fi-rr-user-add me-1"></i> Register
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- WIDGET More options for you --}}
                    <div class="row mt-60">
                        <div class="col-12">
                            {{-- 1. JUDUL DIUBAH --}}
                            <h2 class="section-title style-1 mb-30">More options for you</h2>
                        </div>
                        <div class="col-12">
                            <div class="row related-products">
                                {{-- 2. QUERY DIUBAH: Ambil buku secara acak dari semua buku --}}
                                @php
                                    $moreOptionsEbooks = App\Models\Ebook::inRandomOrder()->get();
                                @endphp

                                @forelse($moreOptionsEbooks as $ebook)
                                    {{-- Kartu ebook yang sama seperti sebelumnya --}}
                                    <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                                        <div class="product-cart-wrap mb-30 hover-up wow animate__animated animate__fadeIn"
                                            data-wow-delay="{{ ($loop->index + 1) * 0.1 }}s">
                                            <div class="product-img-action-wrap">
                                                <div class="product-img product-img-zoom">
                                                    <a href="{{ route('ebooks.show', $ebook->slug) }}">
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
                                                        href="{{ route('ebooks.show', $ebook->slug) }}">{{ Str::limit($ebook->title, 40) }}</a>
                                                </h2>

                                                <div class="product-author" style="margin-bottom:-4px;">
                                                    @if ($ebook->creator)
                                                        <span>by {{ $ebook->creator->name }}</span>
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
                                                        <i class="fi fi-rs-eye align-middle"></i>
                                                        <span class="post-on">
                                                            @php
                                                                $views = $ebook->view_count;
                                                                if ($views >= 1000000000) {
                                                                    $formattedViews =
                                                                        number_format($views / 1000000000, 1) . 'B';
                                                                } elseif ($views >= 1000000) {
                                                                    $formattedViews =
                                                                        number_format($views / 1000000, 1) . 'M';
                                                                } elseif ($views >= 1000) {
                                                                    $formattedViews =
                                                                        number_format($views / 1000, 1) . 'k';
                                                                } else {
                                                                    $formattedViews = $views;
                                                                }
                                                            @endphp
                                                            {{ $formattedViews }}
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="product-description">
                                                    {{ Str::limit(strip_tags($ebook->short_description ?? $ebook->description), 75) }}
                                                </div>

                                                {{-- LOGIKA HANYA PADA TOMBOL AKSI --}}
                                                @if (auth()->check() && auth()->user()->hasActiveSubscription())
                                                    <a href="{{ route('user.ebook.read', $ebook->slug) }}"
                                                        class="action-btn btn-read-now">
                                                        <i class="fi fi-rs-book-open"></i>
                                                        <span>Read Now</span>
                                                    </a>
                                                @else
                                                    <a href="/pricing" class="action-btn btn-subscribe-now">
                                                        <i class="fi fi-rs-lock"></i>
                                                        <span>Subscribe to Read</span>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p>Belum ada e-book lain untuk saat ini.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- NOTIFIKASI TOAST -->
        <div id="toast-notification" class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999; display: none;">
            <div class="toast align-items-center text-white border-0" role="alert" aria-live="assertive"
                aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body" id="toast-message">
                        Ebook saved to your list
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
    </main>
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
    <!-- <script>
        $(document).ready(function() {
            $('.btn-favorite').on('click', function(e) {
                e.preventDefault();

                var $button = $(this);
                var $icon = $button.find('i');
                var toggleUrl = $button.data('toggle-url');
                var isSaved = $button.data('is-saved') === 'true';

                // Optimis: Perbarui UI terlebih dahulu
                if (isSaved) {
                    $icon.removeClass('bi-heart-fill').addClass('bi-heart');
                    $button.data('is-saved', 'false');
                    $button.attr('title', 'Save this book');
                } else {
                    $icon.removeClass('bi-heart').addClass('bi-heart-fill');
                    $button.data('is-saved', 'true');
                    $button.attr('title', 'Remove from saved books');
                }

                // Kirim permintaan ke server
                $.ajax({
                    url: toggleUrl,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // Tampilkan pesan sukses kepada user
                        alert(response.message);
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseText);
                        alert('Gagal memperbarui status. Silakan coba lagi.');

                        // Kembalikan UI ke keadaan semula jika gagal
                        if (isSaved) {
                            $icon.removeClass('bi-heart').addClass('bi-heart-fill');
                            $button.data('is-saved', 'true');
                        } else {
                            $icon.removeClass('bi-heart-fill').addClass('bi-heart');
                            $button.data('is-saved', 'false');
                        }
                    }
                });
            });
        });
    </script> -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.querySelector('.favorite-btn');
            if (!btn) return;

            btn.addEventListener('click', function(e) {
                e.preventDefault();

                const ebookId = this.dataset.ebookId;
                const isCurrentlySaved = this.classList.contains('saved');
                const url = `/ebooks/${ebookId}/save`;
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // Optimistic UI update
                if (isCurrentlySaved) {
                    this.classList.remove('saved');
                    this.querySelector('i').className = 'bi bi-heart';
                    this.title = 'Save this book';
                } else {
                    this.classList.add('saved');
                    this.querySelector('i').className = 'bi bi-heart-fill';
                    this.title = 'Remove from saved';
                }

                // Kirim ke server
                fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({})
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.success) {
                            // Revert jika gagal
                            this.classList.toggle('saved');
                            this.querySelector('i').className = isCurrentlySaved ?
                                'bi bi-heart-fill' :
                                'bi bi-heart';
                            alert(data.message || 'Failed to update');
                        }
                    })
                    .catch(() => {
                        // Revert jika error
                        this.classList.toggle('saved');
                        this.querySelector('i').className = isCurrentlySaved ?
                            'bi bi-heart-fill' :
                            'bi bi-heart';
                        alert('Connection error');
                    });
            });
        });
    </script>

    <script>
        // Show More / Show Less Description (Character-based)
        document.addEventListener('DOMContentLoaded', function() {
            const showMoreBtn = document.getElementById('showMoreBtn');

            if (!showMoreBtn) return;

            const descriptionContent = document.getElementById('ebookDescription');
            const truncatedDesc = descriptionContent.querySelector('.truncated-desc');
            const fullDesc = descriptionContent.querySelector('.full-desc');

            showMoreBtn.addEventListener('click', function(e) {
                e.preventDefault();

                if (truncatedDesc.style.display !== 'none') {
                    // Show full description
                    truncatedDesc.style.display = 'none';
                    fullDesc.style.display = 'inline';
                    showMoreBtn.classList.add('expanded');
                    showMoreBtn.innerHTML = 'Show Less';
                } else {
                    // Show truncated description
                    truncatedDesc.style.display = 'inline';
                    fullDesc.style.display = 'none';
                    showMoreBtn.classList.remove('expanded');
                    showMoreBtn.innerHTML = 'Show More';

                    // Scroll to description smoothly
                    descriptionContent.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
@endsection
