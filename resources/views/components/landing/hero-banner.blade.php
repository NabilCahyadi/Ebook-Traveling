<section class="home-slider position-relative mb-30">
    <div class="container">
        <div class="home-slide-cover mt-30">
            <div class="hero-slider-1 style-4 dot-style-1 dot-style-1-position-1 temp-hidden">

                @php
                    // Jika $homeSliders tidak ada, buat data default
                    if (!isset($homeSliders)) {
                        $homeSliders = collect([
                            (object) [
                                'image' => 'images/slider-1.webp',
                                'title' => 'Get My Essential Travel Guide',
                                'description' => 'Access insider tips and verified travel itineraries.',
                                'target_url' => '/pricing',
                            ],
                            (object) [
                                'image' => 'images/slider-2.webp',
                                'title' => 'Start Your Plan Claim Your Promo',
                                'description' => 'Save up to 50% off on your first order',
                                'target_url' => '/promo',
                            ],
                        ]);
                    }
                @endphp

                @foreach ($homeSliders as $slider)
                    <div class="single-hero-slider single-animation-wrap"
                        style="background-image: url({{ asset($slider->image) }})">
                        <a href="{{ $slider->target_url }}" style="display: block; height: 100%; text-decoration: none;">
                            <div class="slider-content">
                                <h1 class="slider-title mb-40">
                                    @php
                                        $title = $slider->title;
                                        $words = explode(' ', $title);
                                        $currentLine = '';
                                        $lines = [];

                                        foreach ($words as $word) {
                                            if (strlen($currentLine . ' ' . $word) <= 23) {
                                                $currentLine .= ($currentLine ? ' ' : '') . $word;
                                            } else {
                                                if ($currentLine) {
                                                    $lines[] = $currentLine;
                                                }
                                                $currentLine = $word;
                                            }
                                        }

                                        if ($currentLine) {
                                            $lines[] = $currentLine;
                                        }

                                        if (count($lines) === 1 && strlen($title) > 23) {
                                            $midPoint = floor(strlen($title) / 2);
                                            $spacePos = strpos($title, ' ', $midPoint);

                                            if ($spacePos !== false) {
                                                $lines = [substr($title, 0, $spacePos), substr($title, $spacePos + 1)];
                                            }
                                        }
                                    @endphp

                                    @foreach ($lines as $line)
                                        {{ $line }}@if (!$loop->last)
                                            <br>
                                        @endif
                                    @endforeach
                                </h1>
                                <p class="slider-description mb-65">{{ $slider->description }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach

            </div>
            <div class="slider-arrow hero-slider-1-arrow"></div>
        </div>
    </div>
</section>
