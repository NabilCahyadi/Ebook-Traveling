@extends('layouts_lp.app')

@section('title', 'Search Results for "' . $query . '"')

@section('content')
<style>
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

    /* Make all cards same height */
    .product-grid {
        display: flex;
        flex-wrap: wrap;
    }

    .product-grid>[class*="col-"] {
        display: flex;
        flex-direction: column;
        margin-bottom: 30px;
    }

    .product-cart-wrap {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .product-content-wrap {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .product-cart-wrap h2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        min-height: 3.2em;
    }

    .product-description {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        min-height: 2.8em;
        flex-grow: 1;
        margin-bottom: 1rem;
    }

    .action-btn {
        margin-top: auto;
    }

    .badge-language {
        color: #fff;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .search-info {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 30px;
    }
</style>
<style>
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
        margin-top: 10px;
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

    .btn-brand {
        background-color: #FF4C61;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
    }

    .btn-brand:hover {
        background-color: #de364aff;
        color: white;
    }

    .product-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        font-size: 0.8rem;
    }
</style>
<div class="page-header mt-30 mb-50">
    <div class="container">
        <div class="archive-header">
            <div class="row align-items-center">
                <div class="col-xl-12">
                    <h3 class="mb-15">Search Results</h3>
                    <div class="breadcrumb">
                        <a href="/" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                        <span></span> Search Results
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container mb-50">
    <div class="search-info">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h4 class="mb-0">
                    @if($ebooks->total() > 0)
                    Found <span class="text-brand">{{ $ebooks->total() }}</span> result(s) for "<strong>{{ $query }}</strong>"
                    @else
                    No results found for "<strong>{{ $query }}</strong>"
                    @endif
                </h4>
            </div>
            <div class="col-lg-4 text-end">
                <form action="{{ route('search') }}" method="GET" class="d-inline-flex gap-2 w-100">
                    <input type="text" name="q" value="{{ $query }}" class="form-control" placeholder="Try another search...">
                    <button type="submit" class="btn btn-brand" style="white-space: nowrap;">
                        <i class="fi-rs-search"></i> Search
                    </button>
                </form>
            </div>
        </div>
    </div>

    @if($ebooks->total() > 0)
    <div class="row product-grid">
        @foreach($ebooks as $index => $ebook)
        <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
            <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn" data-wow-delay="{{ ($index + 1) * 0.1 }}s">
                <div class="product-img-action-wrap">
                    <div class="product-img product-img-zoom">
                        <a href="/ebooks/{{ $ebook->slug }}">
                            @php
                            $coverImage = $ebook->external_cover_url
                            ? $ebook->external_cover_url
                            : ($ebook->cover_image_url ?? 'assets-nest/nest-fe/imgs/shop/product-1-1.jpg');
                            @endphp
                            <img class="default-img" src="{{ $coverImage }}" alt="{{ $ebook->title }}" />
                        </a>
                    </div>
                    <div class="product-badges product-badges-position product-badges-mrg">
                        <span class="badge-language hot">{{ strtoupper($ebook->language) }}</span>
                    </div>
                </div>
                <div class="product-content-wrap">
                    <h2 style="margin-top:15px;"><a href="/ebooks/{{ $ebook->slug }}">{{ Str::limit($ebook->title, 40) }}</a></h2>

                    <div class="product-author" style="margin-bottom:-12px;">
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
                                        <div class="product-rating" style="width: {{ ($ebook->ratings()->avg('rating') / 5) * 100 }}%"></div>
                                    </div>
                                    <span class="font-small ml-5 text-muted">({{ round($ebook->ratings()->avg('rating'), 2) }})</span>
                                </div>
                            </div>
                        </div>
                        <div class="read-count">
                            <i class="fi-rs-eye align-middle"></i>
                            <span class="post-on">
                                @php
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
                                @endphp
                                {{ $formattedViews }}
                            </span>
                        </div>
                    </div>

                    <p class="product-description">{{ Str::limit(strip_tags($ebook->short_description ?? $ebook->description), 75) }}</p>

                    {{-- Tombol Aksi --}}
                    @auth
                    @if(auth()->user()->hasActiveSubscription() || $ebook->is_free)
                    <a href="{{ route('reader.show', $ebook->slug) }}" class="action-btn btn-read-now">
                        <i class="fi-rs-book"></i>
                        <span>Read Now</span>
                    </a>
                    @else
                    <a href="{{ route('pricing') }}" class="action-btn btn-subscribe-now">
                        <i class="fi-rs-crown"></i>
                        <span>Subscribe to Read</span>
                    </a>
                    @endif
                    @else
                    <a href="{{ route('pricing') }}" class="action-btn btn-subscribe-now">
                        <i class="fi-rs-crown"></i>
                        <span>Subscribe to Read</span>
                    </a>
                    @endauth
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="pagination-area mt-20 mb-20">
        <nav aria-label="Page navigation">
            {{ $ebooks->appends(['q' => $query])->links('pagination::bootstrap-4') }}
        </nav>
    </div>
    @else
    <div class="text-center py-5">
        <img src="/images/no-results.svg" alt="No Results" style="max-width: 300px; opacity: 0.5;" onerror="this.style.display='none'">
        <h4 class="mt-4">No ebooks found</h4>
        <p class="text-muted">Try searching with different keywords or browse our collections</p>
        <a href="/" class="btn btn-brand mt-3">Browse All Ebooks</a>
    </div>
    @endif
</div>
@endsection