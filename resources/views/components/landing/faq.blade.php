{{-- FAQ Section --}}
<section class="faq-section" style="padding: 100px 0; background: #FFFFFF;">
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
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="accordion" id="faqAccordion{{ $section->id }}">
                    @foreach ($section->section_data['items'] ?? [] as $index => $item)
                        <div class="accordion-item mb-3"
                            style="border: none; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); overflow: hidden;">
                            <h2 class="accordion-header">
                                <button class="accordion-button {{ $index === 0 ? '' : 'collapsed' }}" type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#faq{{ $section->id }}_{{ $index }}"
                                    style="background: #FFFFFF; border: none; font-weight: 600; color: #1A202C; font-size: 1.1rem; padding: 1.5rem;">
                                    {{ $item['question'] ?? '' }}
                                </button>
                            </h2>
                            <div id="faq{{ $section->id }}_{{ $index }}"
                                class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                                data-bs-parent="#faqAccordion{{ $section->id }}">
                                <div class="accordion-body"
                                    style="color: #4A5568; line-height: 1.8; font-size: 1rem; padding: 1.5rem; padding-top: 0; font-weight: 400;">
                                    {{ $item['answer'] ?? '' }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .accordion-button:not(.collapsed) {
        color: #FF4C61 !important;
        background: #FFF !important;
        box-shadow: none !important;
    }

    .accordion-button:focus {
        box-shadow: none;
        border: none;
    }

    .accordion-button::after {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23FF4C61'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
    }
</style>
