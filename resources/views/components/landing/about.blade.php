{{-- About Section --}}
<section class="about-section" style="padding: 100px 0; background: #FFFFFF;">
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
        <div class="row align-items-center">
            @if (isset($section->section_data['image']))
                <div class="col-lg-5 mb-4 mb-lg-0">
                    <div class="about-image-wrapper"
                        style="position: relative; width: 100%; padding-bottom: 120%; overflow: hidden; border-radius: 20px; box-shadow: 0 15px 50px rgba(0,0,0,0.12);">
                        <img src="{{ asset('storage/' . $section->section_data['image']) }}"
                            alt="{{ $section->section_data['heading'] ?? 'About' }}"
                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                    </div>
                </div>
            @endif
            <div class="col-lg-{{ isset($section->section_data['image']) ? '7 ps-lg-5' : '12' }}">
                <h3 class="mb-4" style="font-size: 2.2rem; font-weight: 700; color: #1A202C; line-height: 1.3;">
                    {{ $section->section_data['heading'] ?? '' }}
                </h3>
                <p style="line-height: 1.9; font-size: 1.1rem; color: #4A5568; font-weight: 400;">
                    {{ $section->section_data['description'] ?? '' }}
                </p>
            </div>
        </div>
    </div>
</section>
