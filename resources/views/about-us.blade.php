@extends('layouts_lp.app')
@section('title', 'About Us - MeatMap')

@section('content')
<style>
    .featured-card img {
        width: 60px;
        height: 60px;
        margin-bottom: 20px;
    }
</style>
<style>
    .icon-wrapper {
        width: 80px;
        height: 80px;
        margin: 0 auto 20px auto;
        background-color: #FF4C61;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .icon-wrapper i,
    .icon-wrapper svg {
        color: #FFFFFF;
        font-size: 35px;
    }
</style>
<div class="page-content pt-50">
    <div class="container">
        <div class="row">
            <div class="col-xl-10 col-lg-12 m-auto">
                <!-- SECTION 1: WELCOME -->
                @if(isset($aboutSections['welcome']))
                <section class="row align-items-center mb-50">
                    <div class="col-lg-6">
                        <img src="{{ asset($aboutSections['welcome']->image) }}" alt="{{ $aboutSections['welcome']->title }}" class="border-radius-15 mb-md-3 mb-lg-0 mb-sm-4" />
                    </div>
                    <div class="col-lg-6">
                        <div class="pl-25">
                            <h2 class="mb-30">{{ $aboutSections['welcome']->title }}</h2>
                            {!! $aboutSections['welcome']->content !!}
                            <div class="carausel-3-columns-cover position-relative">
                                <div id="carausel-3-columns-arrows"></div>
                                <div class="carausel-3-columns" id="carausel-3-columns">
                                    @if($latestBlogImages && $latestBlogImages->isNotEmpty())
                                    @foreach($latestBlogImages as $blogImage)
                                    <img src="{{ asset('storage/' . $blogImage) }}" 
                                         alt="Latest Blog Image" 
                                         onerror="this.src='/images/blogs/1.webp';" />
                                    @endforeach
                                    @else
                                    <!-- Tampilkan gambar default jika tidak ada blog -->
                                    <img src="/images/blogs/1.webp" alt="Default Image" />
                                    <img src="/images/blogs/1.webp" alt="Default Image" />
                                    <img src="/images/blogs/1.webp" alt="Default Image" />
                                    <img src="/images/blogs/1.webp" alt="Default Image" />
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                @endif

                <!-- SECTION BENEFITS (sudah dinamis) -->
                <section class="benefits-section py-5">
                    <div class="container text-center">
                        <h3 class="mb-40">Why Choose Our MeatMap Guides ?</h3>
                        @if($benefits && $benefits->isNotEmpty())
                        <div class="row justify-content-center">
                            @foreach($benefits as $benefit)
                            <div class="col-md-4 mb-4">
                                <div class="benefit-card p-4 rounded shadow-sm">
                                    <div class="icon-wrapper mb-3">
                                        <i class="{{ $benefit->icon }}"></i>
                                    </div>
                                    <h3 class="h5 mb-2">{{ $benefit->title }}</h3>
                                    <p class="text-muted">{{ $benefit->description }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p>Benefits information is currently unavailable.</p>
                        @endif
                    </div>
                </section>

                <!-- SECTION 2: PERFORMANCE & ABOUT DETAILS -->
                @if(isset($aboutSections['performance']) && isset($aboutSections['about_details']))
                <section class="row align-items-center mb-50">
                    <div class="row mb-50 align-items-center">
                        <div class="col-lg-7 pr-30">
                            <img src="{{ asset($aboutSections['performance']->image) }}" alt="{{ $aboutSections['performance']->title }}" class="mb-md-3 mb-lg-0 mb-sm-4" />
                        </div>
                        <div class="col-lg-5">
                            <h4 class="mb-20 text-muted">Our performance</h4>
                            <h1 class="heading-1 mb-40">{{ $aboutSections['performance']->title }}</h1>
                            {!! $aboutSections['performance']->content !!}
                        </div>
                    </div>
                    @php
                    // Decode JSON untuk 3 kolom
                    $details = json_decode($aboutSections['about_details']->content, true);
                    @endphp
                    <div class="row">
                        @foreach($details as $detail)
                        <div class="col-lg-4 pr-30 mb-md-5 mb-lg-0 mb-sm-5">
                            <h3 class="mb-30">{{ $detail['title'] }}</h3>
                            <p>{{ $detail['description'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </section>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection