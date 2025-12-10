@php
    // Pastikan $collections selalu ada
    if (!isset($collections)) {
        $collections = collect();
    }
@endphp

@extends('layouts_lp.app')
@section('title', 'Home - MeatMap')

@section('content')
    <style>
        /* Scroll Container Styles */
        .products-scroll-container {
            position: relative;
            overflow: hidden;
            padding: 0 60px;
            /* Space for arrows */
        }

        .scroll-wrapper {
            display: flex;
            transition: transform 0.3s ease;
            flex-wrap: nowrap;
            /* Prevent wrapping */
            margin: 0;
        }

        .scroll-item {
            flex: 0 0 20%;
            padding: 0 10px;
            min-width: 20%;
            box-sizing: border-box;
        }

        /* Scroll Buttons */
        .scroll-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 44px;
            height: 44px;
            background: #F2F3F4;
            /* Default bg color */
            color: #7E7E7E;
            /* Default icon color */
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            transition: all 0.3s ease;
            opacity: 1;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .scroll-btn:hover:not(:disabled) {
            background: #FF4C61;
            /* Hover bg color */
            color: white;
            /* Hover icon color */
            transform: translateY(-50%) scale(1.05);
            box-shadow: 0 4px 12px rgba(255, 76, 97, 0.3);
        }

        .scroll-btn:disabled {
            background: #F2F3F4;
            color: #CCCCCC;
            cursor: not-allowed;
            opacity: 0.6;
            transform: translateY(-50%);
        }

        .scroll-btn:disabled:hover {
            background: #F2F3F4;
            color: #CCCCCC;
            transform: translateY(-50%);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .scroll-left {
            left: 10px;
        }

        .scroll-right {
            right: 10px;
        }

        /* Container adjustment for perfect 5 items */
        .container {
            position: relative;
        }

        /* Ensure products take full width */
        .product-grid-4 {
            width: 100%;
            margin: 0;
        }

        /* Hide scrollbar but keep functionality */
        .products-scroll-container::-webkit-scrollbar {
            display: none;
        }

        .products-scroll-container {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .scroll-item {
                flex: 0 0 25%;
                /* 4 products per row on tablet */
                min-width: 25%;
            }
        }

        @media (max-width: 992px) {
            .scroll-item {
                flex: 0 0 33.333%;
                /* 3 products per row on medium tablet */
                min-width: 33.333%;
            }

            .products-scroll-container {
                padding: 0 50px;
            }
        }

        @media (max-width: 768px) {
            .scroll-item {
                flex: 0 0 50%;
                /* 2 products per row on mobile */
                min-width: 50%;
            }

            .products-scroll-container {
                padding: 0 45px;
            }

            .scroll-btn {
                width: 40px;
                height: 40px;
            }

            .scroll-left {
                left: 5px;
            }

            .scroll-right {
                right: 5px;
            }
        }

        @media (max-width: 576px) {
            .scroll-item {
                flex: 0 0 100%;
                /* 1 product per row on small mobile */
                min-width: 100%;
            }

            .products-scroll-container {
                padding: 0 40px;
            }
        }
    </style>
    <style>
        /* style untuk banner utama yang agak bug */
        .home-slider {
            min-height: 500px;
            /* Atur tinggi agar area tidak collapse saat loading */
        }

        /* Sembunyikan konten slider dan slide yang tidak aktif secara sementara */
        .hero-slider-1.temp-hidden .single-hero-slider:not(:first-child) {
            display: none !important;
        }

        /* Sembunyikan teks secara default untuk fade-in */
        .hero-slider-1 .slider-content {
            opacity: 0;
            transition: opacity 0.8s ease-in-out;
        }

        .hero-slider-1 .content-loaded {
            opacity: 1;
        }
    </style>
    <style>
        /* style agar baris jadi ... */
        .post-title {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            /* Maksimal 2 baris */
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.4;
            font-size: 16px;
            font-weight: 600;
            min-height: 2.8em;
            /* Untuk konsistensi tinggi */
        }

        .post-title a {
            color: #333;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .post-title a:hover {
            color: #FF4C61;
        }

        /* Optional: Untuk yang mau lebih kecil */
        .post-title-sm {
            font-size: 14px;
            min-height: 2.6em;
        }

        .post-title-md {
            font-size: 16px;
            min-height: 2.8em;
        }

        .post-title-lg {
            font-size: 18px;
            min-height: 3em;
        }
    </style>
    <style>
        /* style untuk banner slider */
        /* Slider Title Styling */
        .slider-title {
            font-size: 3rem !important;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 1.5rem !important;
            word-wrap: break-word;
            max-width: 100%;
        }

        /* Untuk desktop - sedikit lebih besar */
        @media (min-width: 768px) {
            .slider-title {
                font-size: 3.5rem !important;
            }
        }

        /* Untuk mobile - lebih kecil lagi */
        @media (max-width: 767px) {
            .slider-title {
                font-size: 2rem !important;
                line-height: 1.3;
            }
        }

        .slider-description {
            font-size: 1.1rem;
            margin-bottom: 2rem !important;
            line-height: 1.5;
        }

        /* Fallback jika CSS tidak load */
        .display-2 {
            font-size: 2.5rem !important;
        }
    </style>
    <style>
        /* Kustomisasi Koleksi E-book */

        /* Poin 1: Style untuk deskripsi koleksi */
        .section-title.style-2 .collection-description {
            font-size: 0.9em;
            color: #888;
            margin-top: 0;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .section-title.style-2 h3 {
            margin-bottom: 5px;
        }

        /* Poin 3: Style untuk indikator akses berlangganan (pengganti harga) */
        .product-cart-wrap .product-access-indicator {
            text-align: center;
            color: #FF4C61;
            font-weight: 500;
            font-size: 0.9em;
            margin-top: 10px;
            padding: 5px 0;
        }

        .product-cart-wrap .product-access-indicator i {
            margin-right: 5px;
        }

        /* Poin 2: Style untuk tombol scroll saat dinonaktifkan */
        .scroll-btn:disabled {
            opacity: 0.4;
            cursor: not-allowed;
            pointer-events: none;
        }

        /* ==========================================================================
            Kustomisasi Tampilan E-book (Satu Kartu, Tombol Berbeda)
           ========================================================================== */

        .product-cart-wrap {
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
        }

        /* --- Gaya Umum untuk Elemen Kartu --- */
        .product-cart-wrap h2 {
            font-size: 1.1rem;
            line-height: 1.4;
            margin-bottom: 0.5rem;
            min-height: 3.2em;
        }

        .product-cart-wrap .product-description {
            min-height: 3.2em;
        }

        .product-author {
            font-size: 0.9rem;
            color: var(--text-color-muted);
            margin-bottom: 0.75rem;
        }

        .product-description {
            font-size: 0.85rem;
            color: var(--text-color-muted);
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
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
            /* background-color: #6c757d; */
            color: #fff;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        /* Untuk membatasi judul buku maksimal 2 baris */
        .product-cart-wrap h2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            /* Maksimal 2 baris */
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            /* Menambahkan "..." */
        }

        /* Untuk membatasi deskripsi buku maksimal 2 baris */
        .product-description {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            /* Maksimal 2 baris */
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            /* Menambahkan "..." */
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
            /* Hijau untuk aksi positif */
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
            box-shadow: 0 5px 15px rgba(168, 85, 247, 0.4);
            color: #FF4C61;
            background-color: #fff;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(168, 85, 247, 0.7);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(168, 85, 247, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(168, 85, 247, 0);
            }
        }

        /* Untuk membatasi nama author maksimal 1 baris */
        .product-author span {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            /* Maksimal 1 baris */
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Untuk membuat gambar blog post seragam dan rapi */
        .post-thumb {
            position: relative;
            width: 100%;
            padding-top: 50%;
            overflow: hidden;
            border-radius: 15px;
            margin-bottom: 0px;
        }

        .post-thumb img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Untuk mengurangi jarak antara gambar dan kategori blog */
        .entry-content-2 h6 a {
            margin-top: -5px;
            /* Tarik kategori ke atas untuk mengurangi jarak */
        }
    </style>
    <div class="container mx-auto p-6">
        {{-- Dynamic Landing Page Sections based on order from admin --}}
        @foreach ($landingSections as $section)
            @switch($section->section_type)
                @case('hero_banner')
                    @include('components.landing.hero-banner')
                @break

                @case('hero')
                    @include('components.landing.hero', ['section' => $section])
                @break

                @case('about')
                    @include('components.landing.about', ['section' => $section])
                @break

                @case('features')
                    @include('components.landing.features', ['section' => $section])
                @break

                @case('services')
                    @include('components.landing.services', ['section' => $section])
                @break

                @case('testimonial')
                    @include('components.landing.testimonial', ['section' => $section])
                @break

                @case('cta')
                    @include('components.landing.cta', ['section' => $section])
                @break

                @case('faq')
                    @include('components.landing.faq', ['section' => $section])
                @break

                @case('gallery')
                    @include('components.landing.gallery', ['section' => $section])
                @break

                @case('contact')
                    @include('components.landing.contact', ['section' => $section])
                @break

                @case('top_cities')
                    @include('components.landing.top-cities')
                @break

                @case('subscription_plans')
                    @include('components.landing.subscription-plans')
                @break

                @case('collection')
                    @include('components.landing.collection', ['section' => $section])
                @break

                @case('latest_blogs')
                    @include('components.landing.latest-blogs')
                @break
            @endswitch
        @endforeach
    </div>
    <script>
        // Scroll functionality
        document.addEventListener('DOMContentLoaded', function() {
            const scrollWrapper = document.querySelector('.scroll-wrapper');
            const scrollLeftBtn = document.querySelector('.scroll-left');
            const scrollRightBtn = document.querySelector('.scroll-right');
            const scrollItems = document.querySelectorAll('.scroll-item');

            if (!scrollWrapper || !scrollLeftBtn || !scrollRightBtn) return;

            const itemWidth = scrollItems[0].offsetWidth + 20; // width + margin
            const visibleItems = 5; // Number of items visible at once
            const totalItems = scrollItems.length;
            let currentPosition = 0;
            const maxPosition = Math.max(0, totalItems - visibleItems);

            // Update button states
            function updateButtonStates() {
                scrollLeftBtn.disabled = currentPosition === 0;
                scrollRightBtn.disabled = currentPosition >= maxPosition;
            }

            // Scroll to position
            function scrollToPosition(position) {
                currentPosition = Math.max(0, Math.min(position, maxPosition));
                const translateX = -currentPosition * itemWidth;
                scrollWrapper.style.transform = `translateX(${translateX}px)`;
                updateButtonStates();
            }

            // Event listeners
            scrollLeftBtn.addEventListener('click', function() {
                if (currentPosition > 0) {
                    scrollToPosition(currentPosition - 1);
                }
            });

            scrollRightBtn.addEventListener('click', function() {
                if (currentPosition < maxPosition) {
                    scrollToPosition(currentPosition + 1);
                }
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                // Recalculate on resize
                const newItemWidth = scrollItems[0].offsetWidth + 20;
                itemWidth = newItemWidth;
                scrollToPosition(currentPosition);
            });

            // Initialize
            updateButtonStates();
        });
    </script>
    <style>
        /* style untuk banner */
        /* CSS untuk menyembunyikan konten slider di awal */
        .hero-slider-1 .slider-content {
            opacity: 0;
            transition: opacity 0.8s ease-in-out;
        }

        /* CSS untuk menampilkan konten setelah JS dipicu */
        .hero-slider-1 .content-loaded {
            opacity: 1;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sliderWrapper = document.querySelector('.hero-slider-1');
            const sliderContents = document.querySelectorAll('.hero-slider-1 .slider-content');

            // 1. Hapus kelas penyembunyi sementara
            if (sliderWrapper) {
                // Hapus temp-hidden agar slider library bisa menata semua slide
                sliderWrapper.classList.remove('temp-hidden');
                setTimeout(() => {
                    sliderContents.forEach(content => {
                        content.classList.add('content-loaded');
                    });
                }, 0);
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sections = document.querySelectorAll('.product-tabs');

            sections.forEach(section => {
                const scrollContainer = section.querySelector('.products-scroll-container');
                const scrollLeftBtn = section.querySelector('.scroll-left');
                const scrollRightBtn = section.querySelector('.scroll-right');

                if (!scrollContainer || !scrollLeftBtn || !scrollRightBtn) {
                    return;
                }

                // Fungsi untuk memperbarui status tombol (enable/disable)
                const updateButtonStates = () => {
                    // Nonaktifkan tombol kiri jika di posisi paling kiri
                    if (scrollContainer.scrollLeft <= 0) {
                        scrollLeftBtn.disabled = true;
                    } else {
                        scrollLeftBtn.disabled = false;
                    }

                    // Nonaktifkan tombol kanan jika di posisi paling kanan
                    // scrollWidth adalah total lebar konten, clientWidth adalah lebar yang terlihat
                    if (scrollContainer.scrollLeft >= scrollContainer.scrollWidth - scrollContainer
                        .clientWidth) {
                        scrollRightBtn.disabled = true;
                    } else {
                        scrollRightBtn.disabled = false;
                    }
                };

                // Event listener untuk tombol scroll
                scrollRightBtn.addEventListener('click', () => {
                    // Geser sejauh lebar container yang terlihat
                    scrollContainer.scrollBy({
                        left: scrollContainer.clientWidth,
                        behavior: 'smooth'
                    });
                });

                scrollLeftBtn.addEventListener('click', () => {
                    scrollContainer.scrollBy({
                        left: -scrollContainer.clientWidth,
                        behavior: 'smooth'
                    });
                });

                // Event listener untuk memperbarui tombol saat konten di-scroll
                scrollContainer.addEventListener('scroll', updateButtonStates);

                // Panggil sekali saat halaman dimuat untuk set status awal
                updateButtonStates();
            });
        });
    </script>
@endsection
