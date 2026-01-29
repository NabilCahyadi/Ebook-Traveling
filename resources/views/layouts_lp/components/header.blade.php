<header class="header-area header-style-1 header-height-2">
    <style>
        .notification-dropdown {
            width: 350px;
        }

        .notification-header {
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .notification-header h5 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
        }

        .mark-all-read {
            font-size: 12px;
            color: #FF4C61;
            text-decoration: none;
        }

        .notification-item {
            display: flex;
            padding: 15px 20px;
            border-bottom: 1px solid #f5f5f5;
            align-items: flex-start;
        }

        .notification-item.unread {
            background-color: #f8f9fa;
        }

        .notification-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .notification-icon i {
            font-size: 18px;
        }

        .notification-content {
            flex: 1;
        }

        .notification-content h6 {
            margin: 0 0 5px 0;
            font-size: 14px;
            font-weight: 600;
        }

        .notification-content h6 a {
            color: #333;
            text-decoration: none;
        }

        .notification-content p {
            margin: 0 0 5px 0;
            font-size: 13px;
            color: #666;
            line-height: 1.4;
        }

        .notification-time {
            font-size: 11px;
            color: #999;
        }

        .notification-delete a {
            color: #999;
            padding: 5px;
        }

        .notification-delete a:hover {
            color: #FF4C61;
        }

        .notification-footer {
            padding: 15px 20px;
            text-align: center;
            border-top: 1px solid #eee;
        }

        .view-all {
            color: #FF4C61;
            text-decoration: none;
            font-weight: 500;
        }
    </style>
    <style>
        /* style for button login register */
        .btn-simple:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 76, 97, 0.3);
        }

        /* Hover untuk Sign In */
        .header-action-icon-2 a[href*="login"]:hover {
            background: #FF4C61 !important;
            color: white !important;
        }

        /* Hover untuk Sign Up */
        .header-action-icon-2 a[href*="register"]:hover {
            background: transparent !important;
            color: #FF4C61 !important;
        }
    </style>
    <style>
        /* Style untuk tombol (bisa dihapus jika tidak digunakan di tempat lain) */
        .btn-link {
            background: none;
            border: none;
            color: inherit;
            cursor: pointer;
            padding: 0;
            font-size: inherit;
            text-decoration: none;
        }

        .btn-link:hover {
            text-decoration: underline;
        }

        /* --- PERBAIKI STYLE UNTUK ITEM (HILANGKAN ANIMASI) --- */
        .category-item {
            break-inside: avoid;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            /* Animasi dihapus */
        }

        .category-item img {
            margin-right: 10px;
            width: 24px;
            height: 24px;
            object-fit: contain;
        }

        /* --- STYLE UNTUK LAYOUT, SCROLL, DAN LEBAR KONSISTEN (TETAP DIPERTAHANKAN) --- */
        .categori-dropdown-inner-new {
            display: flex;
            justify-content: space-between;
        }

        .category-list-columns {
            list-style: none;
            padding: 0;
            margin: 0;
            width: 100%;
            column-count: 2;
            column-gap: 30px;
        }

        .categories-dropdown-wrap {
            max-height: 450px;
            overflow-y: auto;
            width: 600px;
            padding-right: 10px;
        }

        /* Untuk scrollbar yang lebih cantik di Webkit (Chrome, Safari, Edge) */
        .categories-dropdown-wrap::-webkit-scrollbar {
            width: 6px;
        }

        .categories-dropdown-wrap::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .categories-dropdown-wrap::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 10px;
        }

        .categories-dropdown-wrap::-webkit-scrollbar-thumb:hover {
            background: #aaa;
        }
    </style>
    <style>
        /* Style untuk item menu yang aktif */
        .main-menu ul li.active a {
            color: #FF4C61 !important;
            font-weight: 600;
            /* Opsional: membuat teks sedikit lebih tebal */
        }

        /* Opsional: Jika Anda ingin menambahkan efek border bawah */
        .main-menu ul li.active a {
            color: #FF4C61 !important;
            font-weight: 600;
            border-bottom: 2px solid #FF4C61;
            padding-bottom: 2px;
            /* Beri jarak agar border tidak menempel */
        }
    </style>
    <!-- start header di desktop -->
    <div class="header-top header-top-ptb-1 d-none d-lg-block">
        <!-- Header di website -->
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-5 col-lg-6">
                    <div class="header-info">
                        <ul>

                            <li><a href="{{route('about-us')}}">About Us</a></li>
                            <li><a href="{{route('contact')}}">Customer Service</a></li>
                            <!-- <li><a href="#">E-book</a></li> -->
                        </ul>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-6">
                    <div class="header-info header-info-right">
                        <ul>
                            <li>Need help ? Visit<strong>‎ <a href="{{route('help-center')}}" class="text-brand">Help Center</a></strong></li>
                            <!-- <li>
                                <a class="language-dropdown-active" href="#">English <i class="fi fi-rs-angle-small-down"></i></a>
                                <ul class="language-dropdown">
                                    <li>
                                        <a href="#">Indonesian</a>
                                    </li>
                                </ul>
                            </li> -->
                            <!-- <li>
                                <a class="language-dropdown-active" href="#">USD <i class="fi fi-rs-angle-small-down"></i></a>
                                <ul class="language-dropdown">
                                    <li>
                                        <a href="#"><img src="assets-nest/nest-fe/imgs/theme/flag-fr.png" alt="" />INR</a>
                                    </li>
                                    <li>
                                        <a href="#"><img src="assets-nest/nest-fe/imgs/theme/flag-dt.png" alt="" />MBP</a>
                                    </li>
                                    <li>
                                        <a href="#"><img src="assets-nest/nest-fe/imgs/theme/flag-ru.png" alt="" />EU</a>
                                    </li>
                                </ul>
                            </li> -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-middle header-middle-ptb-1 d-none d-lg-block">
        <div class="container">
            <div class="header-wrap">
                <div class="logo">
                    <a href="/" class="mx-1"><img src="/images/logo_horizontall.png" alt="logo" style="width: 120px; height: auto;" /></a>
                </div>
                <div class="header-right">
                    <div class="search-style-2">
                        <input
                            type="text"
                            id="search-input-desktop"
                            placeholder="Search by E-book Title or Author..."
                            value="{{ request('q') }}"
                            style="height:40px; margin-left:7px; padding:0px 15px; font-size:14px; border-radius: 5px; border: 1px solid #ECECEC;" />
                    </div>
                    <div class="header-action-right ml-20">
                        <div class="header-action-2">
                            <div class="search-location">
                                <select class="select-active" onchange="window.location.href='/filter-by-city/'+this.value">
                                    <option value="">Your Location</option>
                                    @foreach($citiesHeader as $city)
                                    <option value="{{ $city->slug }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- AUTH SECTION --}}
                            @if(auth()->check())
                            <div class="header-action-icon-2">
                                <a href="{{ route('page-account') }}">
                                    <img class="svgInject" alt="Nest" src="/assets-nest/nest-fe/imgs/theme/icons/icon-user.svg" />
                                </a>
                                <div class="cart-dropdown-wrap cart-dropdown-hm2 account-dropdown">
                                    <ul>
                                        <li>
                                            <a href="{{ route('page-account') }}?tab=account-detail"><i class="fi fi-rs-user mr-10"></i>Account</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('page-account') }}?tab=wishlist"><i class="fi fi-rs-heart mr-10"></i>Wishlist</a>
                                        </li>
                                        {{-- MENU READING AREA (Hanya untuk user login + premium) --}}
                                        @if(auth()->check() && auth()->user()->hasActiveSubscription())
                                        <li>
                                            <a href="{{ route('page-account') }}?tab=library">
                                                <i class="fi fi-rs-book mr-10"></i>Reading Area
                                            </a>
                                        </li>
                                        @endif
                                        <li>
                                            {{-- FORM LOGOUT USER --}}
                                            <form method="POST" action="{{ route('user.logout') }}" id="logout-form" style="display: none;">
                                                @csrf
                                            </form>
                                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <i class="fi fi-rs-sign-out mr-5"></i>
                                                Sign out
                                            </a>
                                            <!-- Pastikan form logout ada di halaman ini -->
                                            <form id="logout-form" action="{{ route('user.logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            @else
                            <div class="header-action-icon-2">
                                <a href="{{ route('login') }}" class="btn-simple" style="padding: 8px 20px; background: transparent; color: #FF4C61; border-radius: 25px; text-decoration: none; font-size: 14px; border: 1.5px solid #FF4C61; transition: all 0.3s ease;">
                                    Sign In
                                </a>
                            </div>
                            <div class="header-action-icon-2">
                                <a href="{{ route('login') }}?form=register" class="btn-simple" style="padding: 8px 20px; background: #FF4C61; color: white; border-radius: 25px; text-decoration: none; font-size: 14px; border: 1.5px solid #FF4C61; transition: all 0.3s ease;">
                                    Sign Up
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-bottom header-bottom-bg-color sticky-bar">
        <div class="container">
            <div class="header-wrap header-space-between position-relative">
                <div class="logo logo-width-1 d-block d-lg-none">
                    <a href="index.html"><img src="/images/logo_horizontall.png" alt="logo" style="width: 150px; height: auto; margin-right:10px;" /></a>
                </div>
                <div class="header-nav d-none d-lg-flex">
                    <div class="main-categori-wrap d-none d-lg-block">
                        <a class="categories-button-active" href="#">
                            <span class="fi fi-rs-apps"></span>Category
                            <i class="fi fi-rs-angle-down"></i>
                        </a>
                        <div id="categories-dropdown-inner" class="categories-dropdown-wrap categories-dropdown-active-large font-heading">
                            <div class="categori-dropdown-inner-new">
                                <ul class="category-list-columns">
                                    @forelse ($headerCategories as $category)
                                    <li class="category-item" onclick="window.location.href='{{ route('category.show', $category->slug) }}';" style="cursor: pointer;">
                                        <a href="{{ route('category.show', $category->slug) }}" onclick="event.preventDefault();">
                                            @if ($category->image)
                                            <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" />
                                            @else
                                            <img src="{{ asset('images/default-category-icon.svg') }}" alt="{{ $category->name }}" />
                                            @endif
                                            {{ $category->name }}
                                        </a>
                                    </li>
                                    @empty
                                    <li><a href="#">No categories found</a></li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="main-menu main-menu-padding-1 main-menu-lh-2 d-none d-lg-block font-heading">
                        <nav>
                            <ul>
                                @php
                                // Debug: check user and role
                                $currentUser = auth()->user();
                                $debugInfo = '';
                                if ($currentUser) {
                                $userType = $currentUser->user_type ?? 'unknown';
                                $debugInfo = "User: {$currentUser->name}, Type: {$userType}";
                                } else {
                                $debugInfo = "Guest User";
                                }
                                @endphp

                                <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                                    <a href="/">Home</a>
                                </li>

                                <li class="{{ request()->routeIs('destinations*') ? 'active' : '' }}">
                                    <a href="{{ route('destinations') }}">Destinations</a>
                                </li>

                                <li class="{{ request()->routeIs('blogs.*') ? 'active' : '' }}">
                                    <a href="{{ route('blogs.index') }}">Blog</a>
                                </li>

                                <li class="{{ request()->routeIs('pricing') ? 'active' : '' }}">
                                    <a href="{{ route('pricing') }}">Pricing</a>
                                </li>

                                <!-- <li class="{{ request()->routeIs('promo') ? 'active' : '' }}">
                                    <a href="{{ route('promo') }}">Promo</a>
                                </li> -->
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- <div class="hotline d-none d-lg-flex">
                    <img src="assets-nest/nest-fe/imgs/theme/icons/icon-headphone.svg" alt="hotline" />
                    <p>1900 - 888<span>24/7 Support Center</span></p>
                </div> -->
                <div class="header-action-icon-2 d-block d-lg-none">
                    <div class="burger-icon burger-icon-white">
                        <span class="burger-icon-top"></span>
                        <span class="burger-icon-mid"></span>
                        <span class="burger-icon-bottom"></span>
                    </div>
                </div>
                <!-- disini ada icon untuk redirect ke page-account beserta dropdown nya -->
            </div>
        </div>
    </div>
    <!-- end header di desktop -->
</header>
<div class="mobile-header-active mobile-header-wrapper-style">
    <div class="mobile-header-wrapper-inner">
        <div class="mobile-header-top">
            <div class="mobile-header-logo">
                <a href="index.html"><img src="/images/logo_horizontall.png" alt="logo" style="width: 150px; height: auto; margin-right:10px;" /></a>
            </div>
            <div class="mobile-menu-close close-style-wrap close-style-position-inherit">
                <button class="close-style search-close">
                    <i class="icon-top"></i>
                    <i class="icon-bottom"></i>
                </button>
            </div>
        </div>
        <div class="mobile-header-content-area">
            <div class="mobile-search search-style-3 mobile-header-border">
                <form action="{{ route('search') }}" method="GET" id="mobile-search-form">
                    <input type="text" name="q" id="search-input-mobile" placeholder="Search by E-book Title or Author..." value="{{ request('q') }}" />
                    <button type="submit"><i class="bi bi-search"></i></button>
                </form>
            </div>
            <div class="mobile-menu-wrap mobile-header-border">
                <!-- mobile menu start -->
                <nav>
                    <ul class="mobile-menu font-heading">
                        <li class="menu-item-has-children">
                            <a href="/">Home</a>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="{{ route('destinations') }}">Destinations</a>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="{{ route('blogs.index') }}">Blog</a>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="{{ route('pricing') }}">Pricing</a>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="{{ route('about-us') }}">About Us</a>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="#">Dashboard Account</a>
                            <ul class="dropdown">
                                <li><a href="{{ route('page-account') }}?tab=account-detail">Account</a></li>
                                <li><a href="{{ route('page-account') }}?tab=wishlist">Wishlist</a></li>
                                {{-- MENU READING AREA (Hanya untuk user login + premium) --}}
                                @if(auth()->check() && auth()->user()->hasActiveSubscription())
                                <li>
                                    <a href="{{ route('page-account') }}?tab=library">
                                        </i>Reading Area
                                    </a>
                                </li>
                                @endif
                                <li>
                                    {{-- FORM LOGOUT USER --}}
                                    <form method="POST" action="{{ route('user.logout') }}" id="logout-form" style="display: none;">
                                        @csrf
                                    </form>
                                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Sign out
                                    </a>
                                    <!-- Pastikan form logout ada di halaman ini -->
                                    <form id="logout-form" action="{{ route('user.logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="#">Pages</a>
                            <ul class="dropdown">
                                <li class="menu-group-title">Help & Support</li>
                                <li><a href="{{ route('faq') }}">FAQs</a></li>
                                <li><a href="{{ route('contact') }}">Customer Service</a></li>
                                <li><a href="{{ route('help-center') }}">Support Center</a></li>
                                <li></li>
                                <li class="menu-group-title">Policies & Legal</li>
                                <li><a href="{{ route('terms-conditions') }}">Terms & Conditions</a></li>
                                <li><a href="{{ route('privacy-policy') }}">Privacy Policy</a></li>
                                <li><a href="{{ route('shopping-policy') }}">Shopping Policy</a></li>
                                <li><a href="{{ route('payment-policy') }}">Payment Policy</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- mobile menu end -->
            </div>
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
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropdownButton = document.querySelector('.categories-button-active');
        const dropdownContent = document.querySelector('.categories-dropdown-wrap');

        // --- FITUR: AUTO-CLOSE ON SCROLL (TETAP DIPERTAHANKAN) ---
        function closeDropdown() {
            // Periksa apakah dropdown sedang terbuka
            // Asumsi: dropdown terbuka jika memiliki style display:block
            if (dropdownContent.style.display === 'block') {
                // Simulasi klik pada tombol untuk menutup dropdown
                dropdownButton.click();
            }
        }

        // Tambahkan event listener untuk scroll pada window
        let isScrolling;
        window.addEventListener('scroll', () => {
            // Clear our timeout throughout the scroll
            window.clearTimeout(isScrolling);

            // Set a timeout to run after scrolling ends
            isScrolling = setTimeout(() => {
                // Tutup dropdown setelah user selesai scroll
                closeDropdown();
            }, 100); // Tunggu 100ms setelah scroll berhenti
        }, false);

        // Handle search functionality for desktop
        const searchInputDesktop = document.getElementById('search-input-desktop');
        if (searchInputDesktop) {
            searchInputDesktop.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    const query = this.value.trim();
                    if (query) {
                        window.location.href = '{{ route("search") }}?q=' + encodeURIComponent(query);
                    }
                }
            });
        }
    });
</script>
<script>
    function handleLogout() {
        // Try to submit logout form
        const form = document.getElementById('logout-form');
        const formData = new FormData(form);

        fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (response.ok || response.status === 419) {
                    // Success or CSRF expired, redirect to login
                    window.location.href = '/login';
                } else {
                    throw new Error('Logout failed');
                }
            })
            .catch(error => {
                // If anything fails, just redirect to login
                console.log('Logout error, redirecting to login', error);
                window.location.href = '/login';
            });
    }
</script>
