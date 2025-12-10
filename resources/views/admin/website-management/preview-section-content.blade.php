<style>
    /* Front-end section styles */
    .preview-section-wrapper {
        padding: 20px;
        background: #f8f9fa;
    }

    .section-info-bar {
        background: white;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .info-badges {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        align-items: center;
    }

    .product-tabs {
        padding: 20px 0;
    }

    .section-title {
        font-size: 28px;
        font-weight: 700;
        color: #253D4E;
        margin-bottom: 20px;
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
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .product-cart-wrap:hover {
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
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

    .product-rate-cover {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 8px;
    }

    .product-rate {
        color: #FDC040;
    }

    .text-muted {
        color: #B6B6B6;
        font-size: 13px;
    }
</style>

<div class="preview-section-wrapper">
    <div class="section-info-bar">
        <h5 class="mb-2">{{ $section->section_title ?: $section->section_name }}</h5>
        <div class="info-badges">
            <span class="badge {{ $section->is_visible ? 'bg-success' : 'bg-secondary' }}">
                {{ $section->is_visible ? 'Visible' : 'Hidden' }}
            </span>
            <span class="badge bg-info">
                {{ ucwords(str_replace('_', ' ', $section->section_type)) }}
            </span>
            <span class="badge bg-secondary">
                Order: {{ $section->order }}
            </span>
            <span class="badge bg-light text-dark">
                Template: {{ ucwords($section->card_template ?? 'default') }}
            </span>
            @if ($section->filter_config)
                <span class="badge bg-primary">
                    Filter: {{ ucwords(str_replace('_', ' ', $section->filter_config['filter_type'] ?? 'custom')) }}
                </span>
            @endif
            @if ($section->collection)
                <span class="badge bg-warning text-dark">
                    Collection: {{ $section->collection->name }}
                </span>
            @endif
        </div>
    </div>

    <div class="bg-white rounded p-3">
        @if ($section->section_type === 'collection')
            @include('components.landing.collection', ['section' => $section])
        @elseif($section->section_type === 'hero_banner')
            @include('components.landing.hero-banner', ['section' => $section])
        @elseif($section->section_type === 'top_cities')
            @include('components.landing.top-cities', ['section' => $section])
        @elseif($section->section_type === 'subscription_plans')
            @include('components.landing.subscription-plans', ['section' => $section])
        @elseif($section->section_type === 'latest_blogs')
            @include('components.landing.latest-blogs', ['section' => $section])
        @endif
    </div>
</div>

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
