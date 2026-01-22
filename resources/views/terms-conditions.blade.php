@extends('layouts_lp.app')
@section('title', 'Terms & Conditions - MeatMap')

@section('content')
<style>
    .terms-container {
        padding: 2rem 0;
        background-color: #f7f9fb;
        min-height: 80vh;
    }

    .terms-content {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        padding: 3rem;
        margin: 0 auto;
    }

    .terms-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #FF4C61;
        margin-bottom: 1rem;
        text-align: center;
    }

    .last-updated {
        text-align: center;
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 2.5rem;
        border-bottom: 1px solid #eaeaea;
        padding-bottom: 1.5rem;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #483638ff;
        margin: 2.5rem 0 1rem 0;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #FF4C61;
    }

    .subsection-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #FF4C61;
        margin: 1.5rem 0 0.75rem 0;
    }

    .paragraph {
        color: #333;
        line-height: 1.6;
        margin-bottom: 1rem;
        text-align: justify;
    }

    .policy-list {
        margin: 1rem 0;
        padding-left: 1.5rem;
    }

    .policy-list li {
        margin-bottom: 0.5rem;
        color: #333;
        line-height: 1.5;
        position: relative;
    }

    .policy-list li::before {
        content: "•";
        color: #FF4C61;
        font-weight: bold;
        position: absolute;
        left: -1rem;
    }

    .contact-footer {
        text-align: center;
        margin-top: 3rem;
        padding-top: 1.5rem;
        border-top: 1px solid #eaeaea;
        color: #666;
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .terms-content {
            padding: 2rem 1.5rem;
            margin: 0 1rem;
        }

        .terms-title {
            font-size: 1.5rem;
        }

        .section-title {
            font-size: 1.3rem;
        }

        .subsection-title {
            font-size: 1.1rem;
        }
    }
</style>

<div class="terms-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="terms-content">
                    <!-- JUDUL UTAMA -->
                    <h1 class="terms-title">Terms & Conditions and Refund Policy</h1>
                    <div class="last-updated">Last updated : 25 November 2025</div>

                    <!-- Konten dinamis -->
                    @foreach($sections as $sectionTitle => $items)
                    <h2 class="section-title">{{ $sectionTitle }}</h2>

                    @foreach($items as $item)
                    @if($item->subsection_title)
                    <h3 class="subsection-title">{{ $item->subsection_title }}</h3>
                    @endif

                    @if(str_contains($item->content, "\n"))
                    <ul class="policy-list">
                        @foreach(explode("\n", trim($item->content)) as $line)
                        @if(trim($line))
                        <li>{!! preg_replace('/^-\s*/', '', e($line)) !!}</li>
                        @endif
                        @endforeach
                    </ul>
                    @else
                    <p class="paragraph">{{ $item->content }}</p>
                    @endif
                    @endforeach
                    @endforeach

                    <div class="contact-footer">
                        <p>For further questions, please contact our customer service.</p>
                        <p>&copy; 2025 MeatMap. All Rights Reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection