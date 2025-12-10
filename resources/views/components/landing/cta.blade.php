{{-- CTA Section --}}
<section class="cta-section"
    style="padding: 120px 0; background: linear-gradient(135deg, #FF4C61 0%, #FF6B7A 100%); position: relative; overflow: hidden;">
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url('data:image/svg+xml,<svg width="100"
        height="100" xmlns="http://www.w3.org/2000/svg">
        <circle cx="50" cy="50" r="40" fill="rgba(255,255,255,0.05)" /></svg>') repeat; opacity: 0.3;">
    </div>
    <div class="container text-center text-white" style="position: relative; z-index: 1;">
        <h2 class="fw-bold mb-4" style="font-size: 3rem; line-height: 1.3; color: #FFFFFF; letter-spacing: -0.5px;">
            {{ $section->section_data['text'] ?? '' }}
        </h2>
        @if (isset($section->section_data['button_text']) && isset($section->section_data['button_link']))
            <a href="{{ $section->section_data['button_link'] }}" class="btn btn-light btn-lg mt-4 px-5 py-3"
                style="border-radius: 50px; font-weight: 600; font-size: 1.1rem; color: #FF4C61; box-shadow: 0 12px 35px rgba(0,0,0,0.2); border: none; transition: all 0.3s ease;">
                {{ $section->section_data['button_text'] }}
            </a>
        @endif
    </div>
</section>
