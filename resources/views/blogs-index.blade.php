{{-- resources/views/blogs/index.blade.php --}}

@extends('layouts_lp.app')

@section('title', 'Tags Blog & News - MeatMap')

@section('content')
<style>
    .post-thumb {
        margin-left: 20px;
        border-radius: 10px;
    }
</style>
<main class="main">
    <!-- Page Header -->
    <div class="page-header mt-30 mb-35">
        <div class="container">
            <div class="archive-header">
                <div class="row align-items-center">
                    <div class="col-xl-3">
                        <h1 class="mb-15">Tags Blog</h1>
                        <div class="breadcrumb">
                            <a href="{{ route('home') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                            <span></span> <a href="{{ route('blogs.index') }}">Blog & News</a>
                            <span></span> Tags
                        </div>
                    </div>
                    {{-- Bagian tag di header bisa diisi nanti jika diperlukan --}}
                    <div class="col-xl-9 text-end d-none d-xl-block">
                        {{-- Contoh: Anda bisa menampilkan tag populer di sini --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Page Content -->
    <div class="page-content mb-50">
        <div class="container">
            <div class="row">
                <!-- Main Blog List (col-lg-9) -->
                <div class="col-lg-9">
                    <!-- Filter Bar (Opsional, bisa dikembangkan fungsinya) -->
                    <div class="shop-product-fillter mb-40 pr-30">
                        <div class="totall-product">
                            <h4>
                                @if(isset($tag))
                                <img class="w-36px mr-10" src="{{ asset('assets/imgs/theme/icons/category-1.svg') }}" alt="" />
                                Tag : <span class="text-brand">#{{ ucfirst($tag) }}</span>
                                @else
                                <img class="w-36px mr-10" src="{{ asset('assets/imgs/theme/icons/category-1.svg') }}" alt="" />
                                Semua Artikel
                                @endif
                            </h4>
                        </div>
                        {{-- Dropdown filter ini statis, perlu pengembangan lebih lanjut untuk fungsional --}}
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

                    <!-- Loop Artikel Blog Dinamis -->
                    <div class="loop-grid loop-list pr-30 mb-50">
                        @forelse ($blogs as $blog)
                        <article class="wow fadeIn animated hover-up mb-30">
                            @if($blog->featured_image)
                            @php
                                // Check if image is external URL or local storage
                                $imageUrl = filter_var($blog->featured_image, FILTER_VALIDATE_URL) 
                                    ? $blog->featured_image 
                                    : asset('storage/' . $blog->featured_image);
                            @endphp
                            <div class="post-thumb" style="background-image: url({{ $imageUrl }})">
                                <!-- <div class="entry-meta">
                                    <a class="entry-meta meta-2" href="{{ route('blogs.show', $blog->slug) }}"><i class="fi-rs-bookmark"></i></a>
                                </div> -->
                            </div>
                            @endif
                            <div class="entry-content-2 pl-50">
                                <h3 class="post-title mb-20">
                                    <a href="{{ route('blogs.show', $blog->slug) }}">{{ $blog->title }}</a>
                                </h3>
                                <p class="post-exerpt mb-40">{{ $blog->excerpt ?? Str::limit(strip_tags($blog->content), 150) }}</p>
                                <div class="entry-meta meta-1 font-xs color-grey mt-10 pb-10">
                                    <div>
                                        <span class="post-on">{{ \Carbon\Carbon::parse($blog->published_at)->diffInHours() < 24 ? $blog->published_at->diffForHumans() : $blog->published_at->format('d M Y') }}</span>
                                        <span class="hit-count has-dot">
                                            @php
                                            $views = $blog->view_count;
                                            if ($views >= 1000000000) { $formattedViews = number_format($views / 1000000000, 1) . 'B'; }
                                            elseif ($views >= 1000000) { $formattedViews = number_format($views / 1000000, 1) . 'M'; }
                                            elseif ($views >= 1000) { $formattedViews = number_format($views / 1000, 1) . 'k'; }
                                            else { $formattedViews = $views; }
                                            @endphp
                                            {{ $formattedViews }} Views
                                        </span>
                                    </div>
                                    <a href="{{ route('blogs.show', $blog->slug) }}" class="text-brand font-heading font-weight-bold">Read more <i class="fi-rs-arrow-right"></i></a>
                                </div>

                                {{-- Komponen Tags --}}
                                <x-blogs.blog-tags :blog="$blog" />
                            </div>
                        </article>
                        @empty
                        <div class="alert alert-info">
                            @if(isset($tag))
                            Tidak ada artikel dengan tag "<strong>{{ $tag }}</strong>" untuk saat ini.
                            @else
                            Belum ada artikel yang dipublish untuk saat ini.
                            @endif
                        </div>
                        @endforelse
                    </div>

                    <!-- Pagination Dinamis -->
                    <div class="pagination-area mt-15 mb-sm-5 mb-lg-0">
                        {{ $blogs->links() }}
                    </div>
                </div>

                <!-- Sidebar (col-lg-3) -->
                <div class="col-lg-3 primary-sidebar sticky-sidebar">
                    <div class="widget-area">
                        <!-- Widget Search -->
                        <div class="sidebar-widget-2 widget_search mb-50">
                            <div class="search-form">
                                <form action="{{ route('blogs.index') }}" method="GET">
                                    <input type="text" name="search" placeholder="Search…" value="{{ request('search') }}" />
                                    <button type="submit"><i class="fi-rs-search"></i></button>
                                </form>
                            </div>
                        </div>

                        <!-- Widget Popular Tags (DINAMIS) -->
                        <div class="sidebar-widget widget-tags mb-50 pb-10">
                            <h5 class="section-title style-1 mb-30">Popular Tags</h5>
                            <ul class="tags-list">
                                {{-- GANTI $allTags MENJADI $popularTags --}}
                                @forelse ($popularTags as $tag)
                                <li class="hover-up">
                                    <a href="{{ route('blogs.by.tag', $tag) }}"><i class="fi-rs-cross mr-10"></i>{{ $tag }}</a>
                                </li>
                                @empty
                                <li>Belum ada tag populer.</li> {{-- Ubah pesan sedikit --}}
                                @endforelse
                            </ul>
                        </div>

                        <!-- Widget lainnya bisa ditambahkan di sini -->
                        <!-- Contoh: Widget Kategori, Trending E-book, dll -->
                        <!-- <div class="sidebar-widget product-sidebar mb-50 p-30 bg-grey border-radius-10">
                            <h5 class="section-title style-1 mb-30">Trending E-Books</h5>
                            {{-- Anda bisa memanggil komponen related e-books di sini jika diperlukan --}}
                            <p>Widget E-Book bisa ditambahkan di sini.</p>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection