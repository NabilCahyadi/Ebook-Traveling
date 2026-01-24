@extends('layouts_lp.app')

@section('title', $blog->meta_title ?: $blog->title . ' - MeatMap Blog')

@section('meta')
    {{-- Basic Meta Tags --}}
    <meta name="description" content="{{ $blog->meta_description ?: Str::limit(strip_tags($blog->content), 160) }}">
    <meta name="keywords"
        content="{{ $blog->meta_keywords ?: ($blog->tags ? implode(', ', $blog->tags) : 'blog, travel, meatmap') }}">
    <meta name="author" content="MeatMap Team">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $blog->meta_title ?: $blog->title }}">
    <meta property="og:description" content="{{ $blog->meta_description ?: Str::limit(strip_tags($blog->content), 160) }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="MeatMap">
    <meta property="og:image" content="{{ $blog->featured_image_url }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="article:published_time" content="{{ $blog->published_at->toIso8601String() }}">
    <meta property="article:modified_time" content="{{ $blog->updated_at->toIso8601String() }}">
    <meta property="article:author" content="MeatMap Team">
    @if ($blog->tags)
        @foreach ($blog->tags as $tag)
            <meta property="article:tag" content="{{ $tag }}">
        @endforeach
    @endif

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $blog->meta_title ?: $blog->title }}">
    <meta name="twitter:description"
        content="{{ $blog->meta_description ?: Str::limit(strip_tags($blog->content), 160) }}">
    <meta name="twitter:image" content="{{ $blog->featured_image_url }}">

    {{-- Schema.org structured data for Article --}}
    @php
        $imageUrl = $blog->featured_image_url;

        $schemaKeywords = $blog->tags ? implode(', ', $blog->tags) : '';

        // Build JSON-LD schema as PHP array
        $schemaData = [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $blog->title,
            'description' => $blog->meta_description ?: Str::limit(strip_tags($blog->content), 160),
            'image' => [
                '@type' => 'ImageObject',
                'url' => $imageUrl,
                'width' => 1200,
                'height' => 630,
            ],
            'author' => [
                '@type' => 'Organization',
                'name' => 'MeatMap Team',
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'MeatMap',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('images/only-logoo.png'),
                ],
            ],
            'datePublished' => $blog->published_at->toIso8601String(),
            'dateModified' => $blog->updated_at->toIso8601String(),
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => url()->current(),
            ],
            'url' => url()->current(),
        ];

        // Add keywords only if they exist
        if ($schemaKeywords) {
            $schemaData['keywords'] = $schemaKeywords;
        }

        // Breadcrumb Schema
        $breadcrumbSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'Home',
                    'item' => url('/'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => 'Blog',
                    'item' => route('blogs.index'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 3,
                    'name' => $blog->title,
                    'item' => url()->current(),
                ],
            ],
        ];
    @endphp

    {{-- Article Schema --}}
    <script type="application/ld+json">
    {!! json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>

    {{-- Breadcrumb Schema --}}
    <script type="application/ld+json">
    {!! json_encode($breadcrumbSchema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
@endsection

@section('content')
    <style>
        /* Untuk memperbesar gambar utama di halaman detail blog */
        .single-thumbnail {
            height: 500px;
            width: 100%;
            border-radius: 15px;
            overflow: hidden;
        }

        .single-thumbnail img {
            width: 800px;
            height: 100%;
            object-position: right;
        }

        .main-content-wrapper {
            display: flex;
            /* Jadikan wrapper sebagai flex container */
            flex-direction: column;
            /* Susun anak-anaknya secara vertikal */
        }

        .ebook-title-link:hover {
            color: #FF416C !important;
        }
    </style>
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ route('home') }}" rel="nofollow"><i class="fi fi-rs-home mr-5"></i></a>
                    <span></span>
                    <a href="{{ route('blogs.index') }}">Blog & News</a>
                    <span class="active"> {{ $blog->title }}</span>
                </div>
            </div>
        </div>
        <div class="page-content mb-50">
            <div class="container">
                <div class="row">
                    <div class="col-xl-11 col-lg-12 main-content-wrapper">
                        <div class="row">
                            <div class="col-lg-9">
                                <div class="single-page pt-50 pr-30">
                                    <div class="single-header style-2">
                                        <div class="row">
                                            <div class="col-xl-10 col-lg-12 m-auto">
                                                <h6 class="mb-10" style="color: #FF4C61;">{{ $blog->category }}</h6>
                                                <h2 class="mb-10">{{ $blog->title }}</h2>
                                                <div class="single-header-meta">
                                                    <div class="entry-meta meta-1 font-xs mt-15 mb-15">
                                                        <a class="author-avatar fs-4" href="#">
                                                            <i class="bi bi-person-circle mr-10"></i>
                                                        </a>
                                                        <span class="post-by">By <a href="">MeatMap Team</a></span>
                                                        <span
                                                            class="post-on has-dot">{{ \Carbon\Carbon::parse($blog->published_at)->diffInHours() < 24 ? $blog->published_at->diffForHumans() : $blog->published_at->format('d M Y') }}</span>
                                                        <span class="post-on has-dot">
                                                            @php
                                                                $views = $blog->view_count;
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
                                                                    $formattedViews =
                                                                        number_format($views / 1000, 1) . 'k';
                                                                } else {
                                                                    $formattedViews = $views;
                                                                }
                                                            @endphp
                                                            {{ $formattedViews }} Views
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <figure class="single-thumbnail">
                                        <div class="col-xl-10 col-lg-12 m-auto">
                                            @php
                                                // Check if image is external URL or local storage
                                                $imageUrl = $blog->featured_image_url;
                                            @endphp
                                            <img src="{{ $imageUrl }}" alt="{{ $blog->title }}" />
                                        </div>
                                    </figure>
                                    <div class="single-content">
                                        <div class="row">
                                            <div class="col-xl-10 col-lg-12 m-auto">
                                                <p>{!! $blog->content !!}</p>
                                                <!--Entry bottom / tags-->
                                                @if (isset($blog) && $blog->tags && count($blog->tags) > 0)
                                                    <div class="entry-bottom mt-50 mb-30">
                                                        <div class="d-flex flex-wrap align-items-center">
                                                            @foreach ($blog->tags as $tag)
                                                                <a href="{{ route('blogs.by.tag', ['tag' => $tag]) }}"
                                                                    rel="tag"
                                                                    class="hover-up btn btn-sm btn-rounded me-2 mb-2">
                                                                    {{ $tag }}
                                                                </a>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 primary-sidebar sticky-sidebar pt-50">
                                <div class="widget-area">
                                    <!-- Product sidebar Widget -->
                                    <div class="sidebar-widget product-sidebar mb-50 p-30 bg-grey border-radius-10">
                                        <h5 class="section-title style-1 mb-30">Related E-Books</h5>

                                        @if ($blog->ebooks && $blog->ebooks->isNotEmpty())
                                            @foreach ($blog->ebooks as $ebook)
                                                <div class="single-post clearfix">
                                                    <div class="image">
                                                        <img src="@if ($ebook->cover_image && filter_var($ebook->cover_image, FILTER_VALIDATE_URL)) {{ $ebook->cover_image }}@elseif($ebook->cover_image){{ asset('storage/' . $ebook->cover_image) }}@else{{ asset('images/ebook-placeholder.webp') }} @endif"
                                                            alt="{{ $ebook->title }}" />
                                                    </div>
                                                    <div class="content pt-10">
                                                        <h6><a href="{{ route('ebooks.show', $ebook->slug) }}"
                                                                class="ebook-title-link">{{ $ebook->title }}</a></h6>
                                                        <div class="product-detail-rating">
                                                            <div class="product-rate-cover text-end">
                                                                <div class="product-rate-cover">
                                                                    <div class="product-rate d-inline-block">
                                                                        <div class="product-rating"
                                                                            style="width: {{ ($ebook->ratings()->avg('rating') / 5) * 100 }}%">
                                                                        </div>
                                                                    </div>
                                                                    <span
                                                                        class="font-small ml-5 text-muted">({{ round($ebook->ratings()->avg('rating'), 2) }})</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            @endforeach
                                        @else
                                            <p>Belum ada e-book terkait untuk artikel ini.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
