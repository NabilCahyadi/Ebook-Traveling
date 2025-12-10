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
            /* object-position: 10% center;  */
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
                            <p class="font-lg text-heading">The Most Comprehensive Indonesia Destination Guide</p>
                        </div>
                        <ul class="contact-infor">
                            <li><img src="assets/imgs/theme/icons/icon-location.svg" alt="" /><strong>Address : </strong> <span>Perumahan Jati Indah, Jl. Otista No.57 Blok. B, Panyingkiran, Kab. Ciamis, Jawa Barat</span></li>
                            <li><img src="assets/imgs/theme/icons/icon-contact.svg" alt="" /><strong>Call Us :</strong><span>(+62) - 540-025-124553</span></li>
                            <li><img src="assets/imgs/theme/icons/icon-email-2.svg" alt="" /><strong>Email :</strong><span>smactactic@gmail.com</span></li>
                            <li><img src="assets/imgs/theme/icons/icon-clock.svg" alt="" /><strong>Hours :</strong><span>08:00 - 16:30, EveryDay</span></li>
                        </ul>
                    </div>
                </div>
                <div class="footer-link-widget col">
                    <h4 class="widget-title">Company</h4>
                    <ul class="footer-list mb-sm-5 mb-md-0">
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Terms &amp; Conditions</a></li>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">Support Center</a></li>
                    </ul>
                </div>
                <div class="footer-link-widget col">
                    <h4 class="widget-title">Account</h4>
                    <ul class="footer-list mb-sm-5 mb-md-0">
                        <li><a href="#">Sign In</a></li>
                        <li><a href="#">View Cart</a></li>
                        <li><a href="#">My Wishlist</a></li>
                    </ul>
                </div>
                <div class="footer-link-widget col">
                    <h4 class="widget-title">Quick Links</h4>
                    <ul class="footer-list mb-sm-5 mb-md-0">
                        <li><a href="{{route('shopping-policy')}}">Shopping Policy</a></li>
                        <li><a href="{{route('payment-policy')}}">Payment Policy</a></li>
                        <li><a href="{{route('faq')}}">FAQs</a></li>
                    </ul>
                </div>
                <div class="footer-link-widget col">
                    <h4 class="widget-title">More</h4>
                    <ul class="footer-list mb-sm-5 mb-md-0">
                        <li><a href="{{route('terms-conditions')}}">Terms &amp; Conditions</a></li>
                        <li><a href="{{route('privacy-policy')}}">Privacy Policy</a></li>
                        <li><a href="{{route('help-center')}}">Help Center</a></li>
                        <li><a href="{{route('contact')}}">Contact Us</a></li>
                    </ul>
                </div>
                <!-- <div class="footer-link-widget widget-install-app col">
                    <h4 class="widget-title">Install App</h4>
                    <p class="wow fadeIn animated">From App Store or Google Play</p>
                    <div class="download-app">
                        <a href="#" class="hover-up mb-sm-2 mb-lg-0"><img class="active" src="assets/imgs/theme/app-store.jpg" alt="" /></a>
                        <a href="#" class="hover-up mb-sm-2"><img src="assets/imgs/theme/google-play.jpg" alt="" /></a>
                    </div>
                    <p class="mb-20">Secured Payment Gateways</p>
                    <img class="wow fadeIn animated" src="assets/imgs/theme/payment-method.png" alt="" />
                </div> -->
            </div>
        </div>
    </section>
    <div class="container pb-30">
        <div class="row align-items-center">
            <div class="col-12 mb-30">
                <div class="footer-bottom"></div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6">
                <p class="font-sm mb-0">&copy; <span id="year"></span> <strong class="fw-bold">MeatMap</strong> — Vacation Guide E-Book<br /><!--All rights reserved --> </p> 
            </div>
            <!-- <div class="col-xl-4 col-lg-6 text-center d-none d-xl-block">
                <div class="hotline d-lg-inline-flex mr-30">
                    <img src="assets-nest/nest-fe/imgs/theme/icons/phone-call.svg" alt="hotline" />
                    <p>1900 - 6666<span>Working 8:00 - 22:00</span></p>
                </div>
                <div class="hotline d-lg-inline-flex">
                    <img src="assets-nest/nest-fe/imgs/theme/icons/phone-call.svg" alt="hotline" />
                    <p>1900 - 8888<span>24/7 Support Center</span></p>
                </div>
            </div> -->
            <div class="col-xl-6 col-lg-6 col-md-6 text-end d-none d-md-block">
                <div class="mobile-social-icon">
                    <h6>Follow Us</h6>
                    <a href="#"><img src="/assets-nest/nest-fe/imgs/theme/icons/icon-facebook-white.svg" alt="" /></a>
                    <a href="#"><img src="/assets-nest/nest-fe/imgs/theme/icons/icon-twitter-white.svg" alt="" /></a>
                    <a href="#"><img src="/assets-nest/nest-fe/imgs/theme/icons/icon-instagram-white.svg" alt="" /></a>
                    <a href="#"><img src="/assets-nest/nest-fe/imgs/theme/icons/icon-pinterest-white.svg" alt="" /></a>
                    <a href="#"><img src="/assets-nest/nest-fe/imgs/theme/icons/icon-youtube-white.svg" alt="" /></a>
                </div>
                <!-- <p class="font-sm">Up to 15% discount on your first subscribe</p> -->
            </div>
        </div>
    </div>
    <script>
        document.getElementById("year").textContent = new Date().getFullYear();
    </script>
</footer>