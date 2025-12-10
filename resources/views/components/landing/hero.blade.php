{{-- Hero Section --}}
<section class="hero-section" style="background: linear-gradient(135deg, #FF4C61 0%, #FF6B7A 100%); padding: 100px 0;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 text-white">
                <h1 class="fw-bold mb-4" style="font-size: 3.5rem; line-height: 1.2; color: #FFFFFF;">
                    {{ $section->section_data['title'] ?? 'Welcome' }}
                </h1>
                <p class="mb-5"
                    style="font-size: 1.2rem; line-height: 1.8; color: rgba(255,255,255,0.95); font-weight: 400;">
                    {{ $section->section_data['subtitle'] ?? '' }}
                </p>
                @if (isset($section->section_data['button_text']) && isset($section->section_data['button_link']))
                    <a href="{{ $section->section_data['button_link'] }}" class="btn btn-light btn-lg px-5 py-3"
                        style="border-radius: 50px; font-weight: 600; font-size: 1.1rem; color: #FF4C61; box-shadow: 0 10px 30px rgba(0,0,0,0.2); border: none; transition: all 0.3s ease;">
                        {{ $section->section_data['button_text'] }}
                    </a>
                @endif
            </div>
            @if (isset($section->section_data['image']))
                <div class="col-lg-6 text-center mt-5 mt-lg-0">
                    <div class="hero-image-wrapper"
                        style="position: relative; width: 100%; padding-bottom: 75%; overflow: hidden; border-radius: 20px; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
                        <img src="{{ asset('storage/' . $section->section_data['image']) }}"
                            alt="{{ $section->section_data['title'] ?? 'Hero' }}"
                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
