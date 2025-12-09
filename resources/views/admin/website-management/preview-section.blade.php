@extends('layouts.admin')

@section('title', 'Preview Section - ' . ($section->section_title ?: $section->section_name))

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets-nest/nest-fe/css/main.css') }}" />
    <style>
        /* Import front-end styles for proper display */
        .preview-container {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
        }

        .preview-header {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .section-info {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-top: 15px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-label {
            font-weight: 600;
            color: #6c757d;
        }

        .info-value {
            color: #333;
        }

        /* Front-end section styles */
        .product-tabs {
            padding: 40px 0;
        }

        .section-title {
            margin-bottom: 30px;
        }

        .section-title h3 {
            font-size: 32px;
            font-weight: 700;
            color: #253D4E;
            margin: 0;
        }

        .scroll-wrapper {
            display: flex;
            gap: 20px;
            overflow-x: auto;
            padding-bottom: 20px;
        }

        .scroll-item {
            flex: 0 0 auto;
            width: 220px;
        }

        .product-cart-wrap {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }

        .product-cart-wrap:hover {
            box-shadow: 0 4px 16px rgba(0,0,0,0.12);
            transform: translateY(-5px);
        }

        .product-img {
            position: relative;
            overflow: hidden;
            padding-top: 140%;
        }

        .product-img img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-badges {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 10;
        }

        .badge-language {
            background: #3BB77E;
            color: white;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
        }

        .product-content-wrap {
            padding: 15px;
        }

        .product-content-wrap h2 {
            font-size: 16px;
            margin-bottom: 8px;
        }

        .product-content-wrap h2 a {
            color: #253D4E;
            text-decoration: none;
        }

        .product-content-wrap h2 a:hover {
            color: #3BB77E;
        }

        .product-rate-cover {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }

        .product-rate {
            color: #FDC040;
        }

        .product-price {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 12px;
        }

        .product-price span {
            font-size: 18px;
            font-weight: 700;
            color: #3BB77E;
        }

        .text-muted {
            color: #B6B6B6;
            font-size: 13px;
        }
    </style>
@endpush

@section('content')
    <div class="preview-header">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <div class="d-flex align-items-center gap-2 mb-2">
                    <a href="{{ route('admin.landing-sections') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="ti ti-arrow-left me-1"></i> Back to Sections
                    </a>
                    <span class="badge bg-label-primary">Preview Mode</span>
                </div>
                <h4 class="mb-0">{{ $section->section_title ?: $section->section_name }}</h4>
            </div>
            <div class="text-end">
                <span class="badge {{ $section->is_visible ? 'bg-success' : 'bg-secondary' }} mb-2">
                    {{ $section->is_visible ? 'Visible' : 'Hidden' }}
                </span>
            </div>
        </div>

        <div class="section-info">
            <div class="info-item">
                <span class="info-label">Type:</span>
                <span class="badge bg-label-info">{{ ucwords(str_replace('_', ' ', $section->section_type)) }}</span>
            </div>

            <div class="info-item">
                <span class="info-label">Order:</span>
                <span class="info-value">{{ $section->order }}</span>
            </div>

            <div class="info-item">
                <span class="info-label">Card Template:</span>
                <span class="badge bg-label-secondary">{{ ucwords($section->card_template ?? 'default') }}</span>
            </div>

            @if($section->filter_config)
            <div class="info-item">
                <span class="info-label">Filter:</span>
                <span class="info-value">{{ ucwords(str_replace('_', ' ', $section->filter_config['filter_type'] ?? 'custom')) }}</span>
            </div>
            @endif

            @if($section->collection)
            <div class="info-item">
                <span class="info-label">Collection:</span>
                <span class="info-value">{{ $section->collection->name }}</span>
            </div>
            @endif
        </div>
    </div>

    <div class="preview-container">
        <div class="card">
            <div class="card-body p-0">
                @if($section->section_type === 'collection')
                    @include('components.landing.collection', ['section' => $section])
                @elseif($section->section_type === 'hero_banner')
                    @include('components.landing.hero', ['section' => $section])
                @elseif($section->section_type === 'top_cities')
                    @include('components.landing.cities', ['section' => $section])
                @elseif($section->section_type === 'subscription_plans')
                    @include('components.landing.subscriptions', ['section' => $section])
                @elseif($section->section_type === 'latest_blogs')
                    @include('components.landing.blogs', ['section' => $section])
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Add smooth scroll behavior
        document.querySelectorAll('.scroll-wrapper').forEach(wrapper => {
            let isDown = false;
            let startX;
            let scrollLeft;

            wrapper.addEventListener('mousedown', (e) => {
                isDown = true;
                startX = e.pageX - wrapper.offsetLeft;
                scrollLeft = wrapper.scrollLeft;
            });

            wrapper.addEventListener('mouseleave', () => {
                isDown = false;
            });

            wrapper.addEventListener('mouseup', () => {
                isDown = false;
            });

            wrapper.addEventListener('mousemove', (e) => {
                if (!isDown) return;
                e.preventDefault();
                const x = e.pageX - wrapper.offsetLeft;
                const walk = (x - startX) * 2;
                wrapper.scrollLeft = scrollLeft - walk;
            });
        });
    </script>
@endpush
