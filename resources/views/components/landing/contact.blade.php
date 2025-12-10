{{-- Contact Section --}}
<section class="contact-section" style="padding: 100px 0; background: #FFFFFF;">
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
            <div class="col-lg-4">
                <div class="card h-100 border-0 contact-card"
                    style="border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,0.06); transition: all 0.3s ease; background: #FFFFFF;">
                    <div class="card-body text-center p-4">
                        <div class="icon-wrapper mb-4"
                            style="width: 72px; height: 72px; margin: 0 auto; display: flex; align-items: center; justify-content: center; border-radius: 50%; background: linear-gradient(135deg, rgba(255, 76, 97, 0.1) 0%, rgba(255, 107, 122, 0.1) 100%);">
                            <i class="ti ti-map-pin" style="font-size: 2rem; color: #FF4C61;"></i>
                        </div>
                        <h5 class="mb-3" style="font-weight: 600; color: #1A202C; font-size: 1.3rem;">Address</h5>
                        <p class="mb-0" style="color: #4A5568; line-height: 1.8; font-size: 1rem;">
                            {{ $section->section_data['address'] ?? '' }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card h-100 border-0 contact-card"
                    style="border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,0.06); transition: all 0.3s ease; background: #FFFFFF;">
                    <div class="card-body text-center p-4">
                        <div class="icon-wrapper mb-4"
                            style="width: 72px; height: 72px; margin: 0 auto; display: flex; align-items: center; justify-content: center; border-radius: 50%; background: linear-gradient(135deg, rgba(255, 76, 97, 0.1) 0%, rgba(255, 107, 122, 0.1) 100%);">
                            <i class="ti ti-mail" style="font-size: 2rem; color: #FF4C61;"></i>
                        </div>
                        <h5 class="mb-3" style="font-weight: 600; color: #1A202C; font-size: 1.3rem;">Email</h5>
                        <p class="mb-0">
                            <a href="mailto:{{ $section->section_data['email'] ?? '' }}" class="text-decoration-none"
                                style="color: #FF4C61; font-weight: 500; font-size: 1rem; transition: color 0.3s ease;">
                                {{ $section->section_data['email'] ?? '' }}
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card h-100 border-0 contact-card"
                    style="border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,0.06); transition: all 0.3s ease; background: #FFFFFF;">
                    <div class="card-body text-center p-4">
                        <div class="icon-wrapper mb-4"
                            style="width: 72px; height: 72px; margin: 0 auto; display: flex; align-items: center; justify-content: center; border-radius: 50%; background: linear-gradient(135deg, rgba(255, 76, 97, 0.1) 0%, rgba(255, 107, 122, 0.1) 100%);">
                            <i class="ti ti-phone" style="font-size: 2rem; color: #FF4C61;"></i>
                        </div>
                        <h5 class="mb-3" style="font-weight: 600; color: #1A202C; font-size: 1.3rem;">Phone</h5>
                        <p class="mb-0">
                            <a href="tel:{{ $section->section_data['phone'] ?? '' }}" class="text-decoration-none"
                                style="color: #FF4C61; font-weight: 500; font-size: 1rem; transition: color 0.3s ease;">
                                {{ $section->section_data['phone'] ?? '' }}
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        @if (isset($section->section_data['map_embed']))
            <div class="row mt-5">
                <div class="col-12">
                    <div class="card border-0"
                        style="border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,0.06); overflow: hidden;">
                        <div class="card-body p-0" style="height: 450px;">
                            {!! $section->section_data['map_embed'] !!}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

<style>
    .contact-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12) !important;
    }

    .contact-card a:hover {
        color: #FF6B7A !important;
    }
</style>
