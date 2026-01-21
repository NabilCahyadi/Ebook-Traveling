@extends('layouts_lp.app')
@section('title', 'Pusat Bantuan - MeatMap')

@section('content')
<style>
    .help-container {
        padding: 2rem 0;
        background-color: #f7f9fb;
        min-height: 80vh;
    }

    .help-content {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        padding: 3rem;
        margin: 0 auto;
    }

    .help-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #FF4C61;
        margin-bottom: 1rem;
        text-align: center;
    }

    .help-subtitle {
        text-align: center;
        color: #666;
        font-size: 1rem;
        margin-bottom: 3rem;
        line-height: 1.6;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #71464b;
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

    .help-list {
        margin: 1rem 0;
        padding-left: 1.5rem;
    }

    .help-list li {
        margin-bottom: 0.75rem;
        color: #333;
        line-height: 1.5;
        position: relative;
    }

    .help-list li::before {
        content: "•";
        color: #FF4C61;
        font-weight: bold;
        position: absolute;
        left: -1rem;
    }

    .help-list strong {
        color: #71464b;
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
        .help-content {
            padding: 2rem 1.5rem;
            margin: 0 1rem;
        }

        .help-title {
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

<div class="help-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="help-content">
                    <!-- JUDUL UTAMA -->
                    <!-- Judul utama tetap statis (sesuai desain) -->
                    <h1 class="help-title">MeatMap Help Center</h1>
                    <div class="help-subtitle">Complete guide to using the MeatMap platform.</div>

                    <!-- Konten dinamis -->
                    @foreach($sections as $sectionTitle => $items)
                    <h2 class="section-title">{{ $sectionTitle }}</h2>

                    @foreach($items as $item)
                    @if($item->subsection_title)
                    <h3 class="subsection-title">{{ $item->subsection_title }}</h3>
                    @endif

                    @if(str_contains($item->content, "\n"))
                    <ul class="help-list">
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
                        <p><strong>Need further assistance?</strong> Contact our support team at <a href="mailto:support@meatmap.co">support@meatmap.co</a> or WhatsApp <a href="https://wa.me/6281234567890">+62 812 3456 7890</a></p>
                        <p>&copy; 2025 MeatMap. All Rights Reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection