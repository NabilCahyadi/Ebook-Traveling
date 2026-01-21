<footer>
    <style>
        .logo-crop {
            display: inline-block;
            width: 270px;
            height: 60px;
            overflow: hidden;
        }

        .logo-crop img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .row .col {
            margin: 1rem 2rem 1rem 2rem !important;
        }

        .mobile-social-icon a i {
            color: white;
            text-align: center;
            margin: 8px 10px 11px 11px;
        }
    </style>
    <section class="section-padding footer-mid">
        <div class="container pt-15 pb-20">
            <div class="row">
                <div class="col">
                    <div class="widget-about font-md mb-md-3 mb-lg-3 mb-xl-0">
                        <div class="logo mb-30">
                            <a href="/" class="mb-15">
                                <img src="/images/logo_horizontall.png" alt="logo" style="width: 180px; height: auto;">
                            </a>
                            <p class="font-lg text-heading">{{ $siteSettings['tagline'] ?? 'Tagline tidak tersedia' }}</p>
                        </div>
                        <ul class="contact-infor">
                            <li><strong>Address : </strong> <span>{{ $siteSettings['address'] ?? 'Alamat tidak tersedia' }}</span></li>
                            <li><strong>Call Us : </strong><span>{{ $siteSettings['phone'] ?? 'Nomor telepon tidak tersedia' }}</span></li>
                            <li><strong>Email : </strong><span>{{ $siteSettings['email'] ?? 'Email tidak tersedia' }}</span></li>
                            <li><strong>Hours : </strong><span>{{ $siteSettings['hours'] ?? 'Jam operasional tidak tersedia' }}</span></li>
                        </ul>
                    </div>
                </div>
                <div class="footer-link-widget col">
                    <h4 class="widget-title">Company</h4>
                    <ul class="footer-list mb-sm-5 mb-md-0">
                        <li><a href="{{route('about-us')}}">About Us</a></li>
                        <li><a href="{{route('terms-conditions')}}">Terms &amp; Conditions</a></li>
                        <li><a href="{{route('contact')}}">Contact Us</a></li>
                        <li><a href="{{route('help-center')}}">Support Center</a></li>
                    </ul>
                </div>
                <div class="footer-link-widget col">
                    <h4 class="widget-title">More</h4>
                    <ul class="footer-list mb-sm-5 mb-md-0">
                        <li><a href="{{route('privacy-policy')}}">Privacy Policy</a></li>
                        <li><a href="{{route('shopping-policy')}}">Shopping Policy</a></li>
                        <li><a href="{{route('payment-policy')}}">Payment Policy</a></li>
                        <li><a href="{{route('faq')}}">FAQs</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <div class="container pb-30">
        <div class="row align-items-center">
            <div class="col-12 mb-30">
                <div class="footer-bottom"></div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6">
                <p class="font-sm mb-0">&copy; <span id="year"></span> <strong class="fw-bold">MeatMap</strong> — {{ $siteSettings['short_tagline'] ?? 'Short Tagline is Empty' }}<br /><!--All rights reserved --> </p>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 text-end d-none d-md-block">
                <div class="mobile-social-icon">
                    <h6>Follow Us</h6>
                    @forelse ($footerContacts as $contact)
                    <a href="{{ $contact->link }}" target="_blank" title="{{ $contact->title }}">
                        <i class="{{ $contact->icon_class }}"></i>
                    </a>
                    @empty
                    <!-- Opsional: Tampilkan link statis jika tidak ada data di database -->
                    <a href="#"><i class="bi bi-facebook"></i></a>
                    <a href="#"><i class="bi bi-whatsapp"></i></a>
                    <a href="#"><i class="bi bi-tiktok"></i></a>
                    <a href="#"><i class="bi bi-youtube"></i></a>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById("year").textContent = new Date().getFullYear();
    </script>
</footer>