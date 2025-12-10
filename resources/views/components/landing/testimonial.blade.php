{{-- Testimonial Section --}}
<section class="testimonial-section" style="padding: 100px 0; background: #F7FAFC;">
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
                    <div class="card h-100 border-0"
                        style="border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,0.06); padding: 35px; background: #FFFFFF;">
                        <div class="card-body text-center p-0">
                            @if (isset($item['photo']))
                                <div class="testimonial-photo mb-4"
                                    style="width: 80px; height: 80px; margin: 0 auto; border-radius: 50%; overflow: hidden; box-shadow: 0 4px 16px rgba(255, 76, 97, 0.25); border: 4px solid #FFF;">
                                    <img src="{{ asset('storage/' . $item['photo']) }}" alt="{{ $item['name'] ?? '' }}"
                                        style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                            @else
                                <div class="d-inline-flex align-items-center justify-content-center mb-4"
                                    style="width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, #FF4C61 0%, #FF6B7A 100%); color: #FFFFFF; font-size: 2rem; font-weight: 700; box-shadow: 0 4px 16px rgba(255, 76, 97, 0.25);">
                                    {{ substr($item['name'] ?? 'U', 0, 1) }}
                                </div>
                            @endif
                            <p class="fst-italic mb-4"
                                style="line-height: 1.8; font-size: 1rem; color: #4A5568; font-weight: 400; position: relative;">
                                <span
                                    style="color: #FF4C61; font-size: 2rem; line-height: 0; vertical-align: middle;">"</span>
                                {{ $item['message'] ?? '' }}
                                <span
                                    style="color: #FF4C61; font-size: 2rem; line-height: 0; vertical-align: middle;">"</span>
                            </p>
                            <h6 class="mb-1" style="font-weight: 700; color: #1A202C; font-size: 1.1rem;">
                                {{ $item['name'] ?? '' }}
                            </h6>
                            <small style="color: #718096; font-weight: 500; font-size: 0.9rem;">
                                {{ $item['position'] ?? '' }}
                            </small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
