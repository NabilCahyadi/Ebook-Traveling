{!! '<' !!}?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:news="http://www.google.com/schemas/sitemap-news/0.9"
        xmlns:xhtml="http://www.w3.org/1999/xhtml"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">

    {{-- Homepage --}}
    <url>
        <loc>{{ url('/') }}</loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
    </url>

    {{-- About Page --}}
    <url>
        <loc>{{ route('about') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>

    {{-- Blog Index --}}
    <url>
        <loc>{{ route('blogs.index') }}</loc>
        <changefreq>daily</changefreq>
        <priority>0.9</priority>
        <lastmod>{{ $blogs->first()?->updated_at?->toAtomString() ?? now()->toAtomString() }}</lastmod>
    </url>

    {{-- Blog Articles --}}
    @foreach($blogs as $blog)
    <url>
        <loc>{{ route('blogs.show', $blog->slug) }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
        <lastmod>{{ $blog->updated_at->toAtomString() }}</lastmod>
        @if($blog->featured_image_url)
        <image:image>
            <image:loc>{{ $blog->featured_image_url }}</image:loc>
            <image:title>{{ $blog->title }}</image:title>
        </image:image>
        @endif
    </url>
    @endforeach

    {{-- Cities --}}
    @foreach($cities as $city)
    <url>
        <loc>{{ route('city.show', $city->slug) }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>
    @endforeach

    {{-- Categories --}}
    @foreach($categories as $category)
    <url>
        <loc>{{ route('category.show', $category->slug) }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>
    @endforeach

    {{-- FAQ --}}
    <url>
        <loc>{{ route('faq') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>

    {{-- Contact --}}
    <url>
        <loc>{{ route('contact') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>

    {{-- Pricing --}}
    <url>
        <loc>{{ route('pricing') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>

</urlset>
