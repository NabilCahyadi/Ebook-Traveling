@extends('layouts_lp.app')
@section('title', 'Destinations - MeatMap')

@section('content')
<style>
    /* style untuk top 10 slider */
    .slider-container {
        position: relative;
        width: 100%;
        height: 600px;
        background: #f5f5f5;
        box-shadow: 0 30px 50px #dbdbdb;
        border-radius: 20px;
        overflow: hidden;
        margin: 50px auto;
    }

    .slider-container .slide .item {
        width: 200px;
        height: 300px;
        position: absolute;
        top: 50%;
        transform: translate(0, -50%);
        border-radius: 20px;
        /* box-shadow: 0 30px 50px #8c8c8c3e; */
        background-position: 50% 50%;
        background-size: cover;
        background-repeat: no-repeat;
        display: inline-block;
        transition: .5s;
    }

    .slide .item:nth-child(1),
    .slide .item:nth-child(2) {
        top: 0;
        left: 0;
        transform: translate(0, 0);
        border-radius: 0;
        width: 100%;
        height: 100%;
    }

    .slide .item:nth-child(2) .content {
        display: block;
    }

    .slide .item:nth-child(3) {
        left: 50%;
    }

    .slide .item:nth-child(4) {
        left: calc(50% + 220px);
    }

    .slide .item:nth-child(5) {
        left: calc(50% + 440px);
    }

    .slide .item:nth-child(n + 6) {
        left: calc(50% + 440px);
        overflow: hidden;
    }

    .item .content {
        position: absolute;
        top: 50%;
        left: 100px;
        width: 400px;
        text-align: left;
        color: #eee;
        transform: translate(0, -50%);
        font-family: 'Poppins', sans-serif;
        display: none;
    }

    .content .name {
        font-size: 40px;
        text-transform: uppercase;
        font-weight: bold;
        opacity: 0;
        margin-bottom: 20px;
        animation: animate 1s ease-in-out 1 forwards;
        color: white;
    }

    .content .description {
        margin-top: 10px;
        margin-bottom: 20px;
        opacity: 0;
        animation: animate 1s ease-in-out .3s 1 forwards;
        font-size: 21px;
        line-height: 1.6;
        max-width: 380px;
        font-weight: 400;
        color: white;
    }

    .content button {
        padding: 12px 25px;
        border: none;
        cursor: pointer;
        opacity: 0;
        animation: animate 1s ease-in-out .6s 1 forwards;
        background: #FF4C61;
        color: white;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .content button:hover {
        background: #e04355;
        transform: translateY(-2px);
    }

    @keyframes animate {
        from {
            opacity: 0;
            transform: translate(0, 100px);
            filter: blur(33px);
        }

        to {
            opacity: 1;
            transform: translate(0);
            filter: blur(0);
        }
    }

    .slider-button {
        width: 100%;
        text-align: center;
        position: absolute;
        bottom: 20px;
        z-index: 10;
    }

    .slider-button button {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        border: none;
        cursor: pointer;
        margin: 0 10px;
        background: #F2F3F4;
        color: #7E7E7E;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .slider-button button:hover {
        background: #FF4C61;
        color: white;
        transform: scale(1.05);
    }

    /* Overlay untuk readability */
    .item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, rgba(0, 0, 0, 0.3) 0%, rgba(0, 0, 0, 0.1) 100%);
        border-radius: inherit;
    }

    .item .content {
        z-index: 2;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .slider-container {
            height: 500px;
            margin: 30px auto;
        }

        .item .content {
            left: 50px;
            width: 320px;
        }

        .content .name {
            font-size: 30px;
        }

        .content .description {
            font-size: 16px;
            max-width: 300px;
        }
    }

    @media (max-width: 576px) {
        .slider-container {
            height: 400px;
        }

        .item .content {
            left: 30px;
            width: 280px;
        }

        .content .name {
            font-size: 24px;
        }

        .content .description {
            font-size: 15px;
            max-width: 260px;
            margin-top: 10px;
            margin-bottom: 20px;
        }
    }
</style>
<style>
    /* Combined Destination Cards Style */
    .destination-card {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 8px 20px rgba(16, 24, 40, 0.06);
        margin-bottom: 1.25rem;
        transition: all 0.3s ease;
    }

    .destination-thumb {
        height: 170px;
        background-position: center;
        background-size: cover;
        transition: transform 0.3s ease;
        border-radius: 12px 12px 0 0;
    }

    .destination-card:hover .destination-thumb {
        transform: scale(1.09);
    }

    .destination-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        background: #FF4C61;
        color: #fff;
        padding: 6px 10px;
        border-radius: 999px;
        font-weight: 700;
        font-size: 0.9rem;
        box-shadow: 0 6px 18px rgba(255, 76, 97, 0.18);
        z-index: 2;
    }
</style>
<style>
    .destination-link {
        display: block;
        height: 100%;
        transition: transform 0.3s ease;
    }

    .destination-card {
        height: 250px;
        border-radius: 12px;
        overflow: hidden;
    }

    .destination-title {
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.8);
        font-size: 1.1rem;
    }

    .destination-badge {
        font-size: 0.85rem;
        font-weight: bold;
    }
</style>

<!-- top 10 city slider -->
<div class="container">
    <!-- Ini adalah wadah utama slider, class-nya TIDAK BOLEH BERUBAH -->
    <div class="slider-container">
        <!-- Ini adalah wadah untuk slide-slide, class-nya TIDAK BOLEH BERUBAH -->
        <div class="slide">
            @forelse ($popularCities as $city)
            <!-- Ini adalah item slide untuk setiap kota, class-nya TIDAK BOLEH BERUBAH -->
            <!-- Kita tambahkan style inline untuk background image yang dinamis -->
            <div class="item destination-slider-item" data-image="{{ asset($city->image) }}" style="background-color: #f0f0f0;">
                <!-- Ini adalah konten di dalam slide, class-nya TIDAK BOLEH BERUBAH -->
                <div class="content">
                    <h2 class="name">{{ $city->name }}</h2>
                    <p class="description">{{ Str::limit($city->description, 150) }}</p>
                    <!-- Kita gunakan button agar sesuai dengan CSS, dan tambahkan onclick untuk navigasi -->
                    <button onclick="window.location.href='{{ route('destination.show', $city->slug) }}'">
                        Explore Now
                    </button>
                </div>
            </div>
            @empty
            <!-- Ini adalah fallback jika tidak ada kota populer -->
            <div class="item" style="background-image: url('https://www.shutterstock.com/image-vector/simple-image-placeholder-picture-minimalist-600nw-2679706831.jpg');">
                <div class="content">
                    <h2 class="name">Discover Your Journey</h2>
                    <p class="description">Popular destinations will be shown here.</p>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Ini adalah tombol navigasi, class-nya TIDAK BOLEH BERUBAH -->
        <!-- JS Anda membutuhkan tombol dengan class .next dan .prev -->
        <div class="slider-button">
            <button class="prev">
                <i class="fi fi-rs-arrow-left mt-1"></i>
            </button>
            <button class="next">
                <i class="fi fi-rs-arrow-right mt-1"></i>
            </button>
        </div>
    </div>
</div>

<!-- cards -->
<section class="destinations-cards py-5">
    <div class="container">
        <div class="text-center mb-16">
            <h3 class="mb-1">Destinations Across Indonesia</h3>
            <p class="mb-3 mx-auto" style="max-width:50rem;">
                Explore diverse destinations from beaches to cities — discover hidden gems and popular spots with authentic local experiences.
            </p>
        </div>
        <div class="row mt-5">
            @forelse ($allCities as $index => $city)
            @php
            $cityImageUrl = getImageUrl($city->image, 'images/placeholder-destination.jpg');
            @endphp
            <div class="col-lg-3 col-md-4 col-sm-6">
                {{-- Bungkus seluruh card dengan tag <a> --}}
                <a href="{{ route('destination.show', $city->slug) }}" class="text-decoration-none destination-link">
                    <div class="destination-card position-relative overflow-hidden" style="height: 250px; border-radius: 12px; background-color: #f0f0f0;">
                        <!-- Gambar sebagai background dengan fallback -->
                        <div class="destination-thumb destination-card-item"
                             data-image="{{ $cityImageUrl }}"
                             data-fallback="https://www.shutterstock.com/image-vector/simple-image-placeholder-picture-minimalist-600nw-2679706831.jpg"
                             style="height: 100%; background-size: cover; background-position: center; background-color: #f0f0f0;">
                        </div>

                        <!-- Overlay gelap untuk teks lebih terbaca -->
                        <div class="destination-overlay position-absolute top-0 start-0 w-100 h-100" style="background: rgba(0,0,0,0.3);"></div>

                        <!-- Konten overlay (nama kota) -->
                        <div class="destination-content position-absolute bottom-0 start-0 w-100 p-3 text-center">
                            <div class="destination-title text-white fw-bold fs-5">{{ $city->name }}</div>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <p>No destinations found.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const placeholderImage = 'https://www.shutterstock.com/image-vector/simple-image-placeholder-picture-minimalist-600nw-2679706831.jpg';

        // Function untuk validate image dan set background
        function setBackgroundImage(element, imageUrl) {
            // Jika image path kosong, langsung gunakan placeholder
            if (!imageUrl || imageUrl.trim() === '' || imageUrl.includes('null')) {
                const fallbackUrl = element.getAttribute('data-fallback') || placeholderImage;
                element.style.backgroundImage = `url('${fallbackUrl}')`;
                return;
            }

            // Test apakah image bisa diload
            const img = new Image();
            img.onload = function() {
                element.style.backgroundImage = `url('${imageUrl}')`;
            };
            img.onerror = function() {
                // Jika image gagal diload, gunakan placeholder
                const fallbackUrl = element.getAttribute('data-fallback') || placeholderImage;
                element.style.backgroundImage = `url('${fallbackUrl}')`;
                console.warn('Image fallback digunakan untuk destination:', imageUrl);
            };
            img.src = imageUrl;
        }

        // Handle slider items
        document.querySelectorAll('.destination-slider-item').forEach(function(item) {
            const imageUrl = item.getAttribute('data-image');
            setBackgroundImage(item, imageUrl);
        });

        // Handle destination card items
        document.querySelectorAll('.destination-card-item').forEach(function(item) {
            const imageUrl = item.getAttribute('data-image');
            setBackgroundImage(item, imageUrl);
        });

        // Slider navigation
        let next = document.querySelector('.next');
        let prev = document.querySelector('.prev');

        if (next) {
            next.addEventListener('click', function() {
                let items = document.querySelectorAll('.item');
                document.querySelector('.slide').appendChild(items[0]);
            });
        }

        if (prev) {
            prev.addEventListener('click', function() {
                let items = document.querySelectorAll('.item');
                document.querySelector('.slide').prepend(items[items.length - 1]);
            });
        }
    });
</script>
@endsection
