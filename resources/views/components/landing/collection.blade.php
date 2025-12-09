@php
    // Get collection from section
    $collection = $section->collection ?? null;

    // Check if this is a custom filtered section
    $isCustomSection = isset($section->custom_ebooks);
    $ebooks = $isCustomSection ? $section->custom_ebooks : ($collection ? $collection->ebooks : collect());
    $sectionTitle = $isCustomSection ? $section->section_title : ($collection ? $collection->name : '');
    $sectionSlug = $isCustomSection ? 'custom-' . $section->id : ($collection ? $collection->slug : '');
@endphp

@if ($ebooks->isNotEmpty())
    <section class="product-tabs section-padding position-relative">
        <div class="container">
            <div class="section-title style-2 wow animate__animated animate__fadeIn">
                <h3>{{ $sectionTitle }}</h3>
                @if (!$isCustomSection)
                    <a href="/collections/{{ $collection->slug }}" class="show-all">View All</a>
                @endif
            </div>
            <button class="scroll-btn scroll-left"><i class="fi-rs-angle-left"></i></button>
            <button class="scroll-btn scroll-right"><i class="fi-rs-angle-right"></i></button>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="{{ $sectionSlug }}" role="tabpanel">
                    <div class="products-scroll-container">
                        <div class="row product-grid-4 scroll-wrapper">

                            @foreach ($ebooks as $index => $ebook)
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 scroll-item">
                                    <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn"
                                        data-wow-delay="{{ ($index + 1) * 0.1 }}s">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href="/ebooks/{{ $ebook->slug }}">
                                                    <img class="default-img"
                                                        src="{{ $ebook->cover_image ?: 'assets-nest/nest-fe/imgs/shop/product-1-1.jpg' }}"
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
                                                        {{ $ebook->creator->pen_name ?? $ebook->creator->user->name }}</span>
                                                @else
                                                    <span>by Unknown Author</span>
                                                @endif
                                            </div>

                                            <div class="product-meta">
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
                                                <div class="read-count">
                                                    <i class="fi-rs-eye align-middle"></i>
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
                                                {{ Str::limit($ebook->short_description ?? $ebook->description, 80) }}
                                            </p>

                                            @if (auth()->check() && auth()->user()->hasActiveSubscription())
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

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
