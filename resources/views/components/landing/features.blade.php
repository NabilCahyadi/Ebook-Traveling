{{-- Features Section --}}
<section class="features-section" style="padding: 100px 0; background: #F7FAFC;">
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
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 feature-card"
                        style="border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,0.06); transition: all 0.3s ease; background: #FFFFFF;">
                        <div class="card-body text-center p-4">
                            @if (isset($item['icon']))
                                <div class="icon-wrapper mb-4"
                                    style="width: 72px; height: 72px; margin: 0 auto; display: flex; align-items: center; justify-content: center; border-radius: 50%; background: linear-gradient(135deg, #FF4C61 0%, #FF6B7A 100%); box-shadow: 0 8px 20px rgba(255, 76, 97, 0.3);">
                                    <i class="ti {{ $item['icon'] }}" style="font-size: 2rem; color: #FFFFFF;"></i>
                                </div>
                            @endif
                            <h5 class="card-title mb-3" style="font-weight: 600; color: #1A202C; font-size: 1.3rem;">
                                {{ $item['title'] ?? '' }}
                            </h5>
                            <p class="card-text mb-0"
                                style="line-height: 1.7; color: #718096; font-size: 1rem; font-weight: 400;">
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
    .feature-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12) !important;
    }
</style>
