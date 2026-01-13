@extends('layouts_lp.app') {{-- Sesuaikan dengan layout utama Anda --}}

@section('title', 'Blog - MeatMap')

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
                <a href="{{ route('home') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i></a>
                <span></span>
                <a href="{{ route('blogs.index') }}">Blog & News</a>
                <span class="active">‎ ‎ {{ $blog->title }}</span>
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
                                            <h6 class="mb-10"><a href="#">{{ $blog->category }}</a></h6>
                                            <h2 class="mb-10">{{ $blog->title }}</h2>
                                            <div class="single-header-meta">
                                                <div class="entry-meta meta-1 font-xs mt-15 mb-15">
                                                    <a class="author-avatar fs-4" href="#">
                                                        <i class="bi bi-person-circle mr-10"></i>
                                                    </a>
                                                    <!-- <span class="post-by">By <a href="">{{ optional($blog->author)->name ?? 'Anonymous' }}</a></span> -->
                                                    <span class="post-by">By <a href="">MeatMap Team</a></span>
                                                    <span class="post-on has-dot">{{ \Carbon\Carbon::parse($blog->published_at)->diffInHours() < 24 ? $blog->published_at->diffForHumans() : $blog->published_at->format('d M Y') }}</span>
                                                    <span class="post-on has-dot">
                                                        @php
                                                        $views = $blog->view_count;
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
                                                        {{ $formattedViews }} Views
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <figure class="single-thumbnail">
                                    <div class="col-xl-10 col-lg-12 m-auto">
                                        <img src="{{ $blog->featured_image }}" alt="" />
                                    </div>
                                </figure>
                                <div class="single-content">
                                    <div class="row">
                                        <div class="col-xl-10 col-lg-12 m-auto">
                                            <p>{!! $blog->content !!}</p>
                                            <!--Entry bottom / tags-->
                                            {{-- resources/views/components/blogs/blog-tags.blade.php --}}

                                            @props(['blog'])
                                            @if(isset($blog) && $blog->tags && count($blog->tags) > 0)
                                            <div class="entry-bottom mt-50 mb-30">
                                                {{-- PERUBAHAN UTAMA DI SINI --}}
                                                <div class="d-flex flex-wrap align-items-center">
                                                    @foreach($blog->tags as $tag)
                                                    {{-- PERUBAHAN KELAS MARGIN DI SINI --}}
                                                    <a href="{{ route('blogs.by.tag', ['tag' => $tag]) }}" rel="tag" class="hover-up btn btn-sm btn-rounded me-2 mb-2">
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
                                <div class="sidebar-widget-2 widget_search mb-50">
                                    <div class="search-form">
                                        <form action="#">
                                            <input type="text" placeholder="Search…" />
                                            <button type="submit"><i class="fi-rs-search"></i></button>
                                        </form>
                                    </div>
                                </div>
                                <!-- Product sidebar Widget -->
                                <div class="sidebar-widget product-sidebar mb-50 p-30 bg-grey border-radius-10">
                                    <h5 class="section-title style-1 mb-30">Related E-Books</h5>

                                    @if($blog->ebooks->isNotEmpty())
                                    @foreach($blog->ebooks as $ebook)
                                    <div class="single-post clearfix">
                                        <div class="image">
                                            <img src="{{ asset($ebook->cover_image) }}" alt="{{ $ebook->title }}" />
                                        </div>
                                        <div class="content pt-10">
                                            {{-- PERBAIKAN: Buat link ke halaman detail e-book --}}
                                            <h6><a href="{{ route('ebooks.show', $ebook->slug) }}" class="ebook-title-link">{{ $ebook->title }}</a></h6>
                                            <div class="product-detail-rating">
                                                <div class="product-rate-cover text-end">
                                                    <div class="product-rate-cover">
                                                        <div class="product-rate d-inline-block">
                                                            {{-- HITUNG RATA-RATA LANGSUNG DARI TABEL ebook_ratings --}}
                                                            <div class="product-rating" style="width: {{ ($ebook->ratings()->avg('rating') / 5) * 100 }}%"></div>
                                                        </div>
                                                        {{-- TAMPILKAN JUGA RATA-RATA YANG SAMA --}}
                                                        <span class="font-small ml-5 text-muted">({{ round($ebook->ratings()->avg('rating'), 2) }})</span>
                                                    </div>
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