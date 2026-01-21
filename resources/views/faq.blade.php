@extends('layouts_lp.app')
@section('title', 'FAQs - MeatMap')

@section('content')
<style>
    .faq-container {
        padding: 3rem 0;
        background-color: #f7f9fb;
        min-height: 80vh;
    }

    .faq-content {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        padding: 3rem;
        margin: 0 auto;
    }

    .faq-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #FF4C61;
        margin-bottom: 1rem;
        text-align: center;
    }

    .faq-subtitle {
        text-align: center;
        color: #666;
        font-size: 1rem;
        margin-bottom: 3rem;
        line-height: 1.6;
        max-width: 900px;
        margin-left: auto;
        margin-right: auto;
    }

    .faq-category {
        margin-bottom: 3rem;
    }

    .category-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #71464b;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #FF4C61;
    }

    /* FAQ Accordion Styles */
    .faq-accordion-item {
        background: #fff;
        border: 1px solid #e6e9ee;
        border-radius: 10px;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .faq-accordion-item:hover {
        border-color: #FF4C61;
        box-shadow: 0 2px 8px rgba(255, 76, 97, 0.1);
    }

    .faq-accordion-header {
        padding: 1.25rem 1.5rem;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .faq-accordion-header h4 {
        font-size: 1rem;
        margin: 0;
        font-weight: 600;
        color: #111827;
        flex: 1;
    }

    .faq-accordion-header i {
        color: #FF4C61;
        transition: transform 0.3s ease;
        font-size: 0.9rem;
    }

    .faq-accordion-item.active .faq-accordion-header i {
        transform: rotate(45deg);
    }

    .faq-accordion-content {
        padding: 0 1.5rem;
        color: #6b7280;
        line-height: 1.6;
        max-height: 0;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .faq-accordion-item.active .faq-accordion-content {
        max-height: 500px;
        padding-bottom: 1.5rem;
    }

    .contact-support {
        text-align: left;
        margin-top: 3rem;
        padding: 2rem;
        background: #f8fafc;
        border-radius: 10px;
        border: 1px solid #eaeaea;
    }

    .contact-support h4 {
        color: #71464b;
        margin-bottom: 1rem;
    }

    @media (max-width: 768px) {
        .faq-content {
            padding: 2rem 1.5rem;
            margin: 0 1rem;
        }

        .faq-title {
            font-size: 1.5rem;
        }

        .category-title {
            font-size: 1.3rem;
        }

        .faq-accordion-header h4 {
            font-size: 0.95rem;
        }

        .faq-accordion-header {
            padding: 1rem 1.25rem;
        }
    }
</style>

<div class="faq-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="faq-content">
                    <!-- MAIN TITLE -->
                    <h1 class="faq-title">Frequently Asked Questions</h1>
                    <p class="faq-subtitle">
                        Find answers to common questions about subscriptions, payments, and accessing travel eBooks on MeatMap. Need further assistance? Our <a href="{{ route('contact') }}">support team</a> is ready to help.
                    </p>

                    <!-- DINAMIS: LOOP PER KATEGORI -->
                    @foreach($faqs as $category => $items)
                    <div class="faq-category">
                        <h2 class="category-title">{{ $category }}</h2>

                        @foreach($items as $faq)
                        <div class="faq-accordion-item">
                            <div class="faq-accordion-header">
                                <h4>{{ $faq->question }}</h4>
                                <i class="fas fa-plus"></i>
                            </div>
                            <div class="faq-accordion-content">
                                {!! nl2br(e($faq->answer)) !!}
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endforeach

                    <!-- CONTACT SUPPORT -->
                    <div class="contact-support">
                        <h4>Still Have Questions?</h4>
                        <p>Our support team is ready to assist you 24/7 via :</p>
                        <p>
                            <strong>WhatsApp :</strong> +62 812 3456 7890<br>
                            <strong>Email :</strong> support@meatmap.co<br>
                            <strong>Operating Hours :</strong> 08:00 - 22:00 WIB
                        </p>
                        <p>or click <a href="{{ route('contact') }}">contact</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const accordionItems = document.querySelectorAll('.faq-accordion-item');

        accordionItems.forEach(item => {
            const header = item.querySelector('.faq-accordion-header');

            header.addEventListener('click', () => {
                // Close all other items
                accordionItems.forEach(otherItem => {
                    if (otherItem !== item) {
                        otherItem.classList.remove('active');
                    }
                });

                // Toggle current item
                item.classList.toggle('active');
            });
        });

        // Auto-open first item in each category
        const categories = document.querySelectorAll('.faq-category');
        categories.forEach(category => {
            const firstItem = category.querySelector('.faq-accordion-item');
            if (firstItem) {
                firstItem.classList.add('active');
            }
        });
    });
</script>
@endsection