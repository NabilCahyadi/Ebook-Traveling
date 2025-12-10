{{-- Services Section --}}
<section class="services-section" style="padding: 100px 0; background: #FFFFFF;">
    <div class="container">
        @if ($section->section_title)
            <div class="text-center mb-5">
                <h2 class="mb-3" style="font-size: 2.8rem; font-weight: 700; color: #1A202C; letter-spacing: -0.5px;">
                    {{ $section->section_title }}
                </h2>
                <div
                    style="width: 80px; height: 4px; background: linear-gradient(90deg, #FF4C61, #FF6B7A); margin: 0 auto; border-radius: 2px;">
                </div>
            </div>
        @endif
        <div class="row g-4 mt-3">
            @foreach ($section->section_data['items'] ?? [] as $item)
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 service-card"
                        style="border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,0.06); transition: all 0.3s ease; background: #FFFFFF;">
                        <div class="card-body text-center p-4">
                            @if (isset($item['icon']))
                                <div class="mb-4"
                                    style="width: 64px; height: 64px; margin: 0 auto; display: flex; align-items: center; justify-content: center; border-radius: 12px; background: linear-gradient(135deg, rgba(255, 76, 97, 0.1) 0%, rgba(255, 107, 122, 0.1) 100%);">
                                    <i class="ti {{ $item['icon'] }}" style="font-size: 2rem; color: #FF4C61;"></i>
                                </div>
                            @endif
                            <h5 class="card-title mb-3" style="font-weight: 600; color: #1A202C; font-size: 1.2rem;">
                                {{ $item['title'] ?? '' }}
                            </h5>
                            <p class="card-text mb-0"
                                style="line-height: 1.6; color: #718096; font-size: 0.95rem; font-weight: 400;">
                                {{ $item['description'] ?? '' }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<style>
    .service-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12) !important;
    }

    .service-card:hover .ti {
        transform: scale(1.1);
        transition: transform 0.3s ease;
    }
</style>
