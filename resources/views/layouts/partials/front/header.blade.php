<header class="header-area header-style-1 header-height-2">
    <div class="mobile-promotion">
        <span>Grand opening, <strong>up to 15%</strong> off all items. Only <strong>3 days</strong> left</span>
    </div>
    <div class="header-top header-top-ptb-1 d-none d-lg-block">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-3 col-lg-4">
                    <div class="header-info">
                        <ul>
                            <li><a href="{{ route('page.about') }}">About Us</a></li>
                            <li><a href="{{ route('page.account') }}">My Account</a></li>
                            <li><a href="{{ route('page.contact') }}">Contact</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-4">
                    <div class="text-center">
                        <div id="news-flash" class="d-inline-block">
                            <ul>
                                <li>100% Secure delivery without contacting the courier</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4">
                    <div class="header-info header-info-right">
                        <ul>
                            @guest
                                <li><a href="{{ route('login') }}">Log In</a></li>
                                <li><a href="{{ route('register') }}">Sign Up</a></li>
                            @else
                                <li><a href="{{ route('user.account') }}">{{ Auth::user()->name }}</a></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                        @csrf
                                        <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
                                    </form>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-middle header-middle-ptb-1 d-none d-lg-block">
        <div class="container">
            <div class="header-wrap">
                <div class="logo logo-width-1">
                    <a href="{{ route('home') }}"><img src="{{ asset('assets/front/imgs/theme/logo.svg') }}" alt="logo" /></a>
                </div>
                <div class="header-right">
                    <div class="search-style-2">
                        <form action="{{ route('shop.search') }}" method="GET">
                            <select class="select-active" name="category">
                                <option value="">All Categories</option>
                                <!-- Add categories dynamically -->
                            </select>
                            <input type="text" name="q" placeholder="Search for items..." />
                        </form>
                    </div>
                    <div class="header-action-right">
                        <div class="header-action-2">
                            <div class="header-action-icon-2">
                                <a href="{{ route('shop.wishlist') }}">
                                    <img class="svgInject" alt="Wishlist" src="{{ asset('assets/front/imgs/theme/icons/icon-heart.svg') }}" />
                                    <span class="pro-count blue">0</span>
                                </a>
                                <a href="{{ route('shop.wishlist') }}"><span class="lable">Wishlist</span></a>
                            </div>
                            <div class="header-action-icon-2">
                                <a class="mini-cart-icon" href="{{ route('shop.cart') }}">
                                    <img alt="Cart" src="{{ asset('assets/front/imgs/theme/icons/icon-cart.svg') }}" />
                                    <span class="pro-count blue">0</span>
                                </a>
                                <a href="{{ route('shop.cart') }}"><span class="lable">Cart</span></a>
                            </div>
                            <div class="header-action-icon-2">
                                <a href="{{ route('user.account') }}">
                                    <img class="svgInject" alt="Account" src="{{ asset('assets/front/imgs/theme/icons/icon-user.svg') }}" />
                                </a>
                                <a href="{{ route('user.account') }}"><span class="lable ml-0">Account</span></a>
                            </div>
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
                    <a href="{{ route('home') }}"><img src="{{ asset('assets/front/imgs/theme/logo.svg') }}" alt="logo" /></a>
                </div>
                <div class="header-nav d-none d-lg-flex">
                    <div class="main-menu main-menu-padding-1 main-menu-lh-2 d-none d-lg-block font-heading">
                        <nav>
                            <ul>
                                <li><a class="{{ Request::is('/') ? 'active' : '' }}" href="{{ route('home') }}">Home</a></li>
                                <li><a class="{{ Request::is('shop*') ? 'active' : '' }}" href="{{ route('shop.index') }}">Shop</a></li>
                                <li><a class="{{ Request::is('blog*') ? 'active' : '' }}" href="{{ route('blog.index') }}">Blog</a></li>
                                <li><a class="{{ Request::is('contact') ? 'active' : '' }}" href="{{ route('page.contact') }}">Contact</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="hotline d-none d-lg-flex">
                    <img src="{{ asset('assets/front/imgs/theme/icons/icon-headphone.svg') }}" alt="hotline" />
                    <p>1900 - 888<span>24/7 Support Center</span></p>
                </div>
                <div class="header-action-icon-2 d-block d-lg-none">
                    <div class="burger-icon burger-icon-white">
                        <span class="burger-icon-top"></span>
                        <span class="burger-icon-mid"></span>
                        <span class="burger-icon-bottom"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="mobile-header-active mobile-header-wrapper-style">
    <div class="mobile-header-wrapper-inner">
        <div class="mobile-header-top">
            <div class="mobile-header-logo">
                <a href="{{ route('home') }}"><img src="{{ asset('assets/front/imgs/theme/logo.svg') }}" alt="logo" /></a>
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
                <form action="{{ route('shop.search') }}" method="GET">
                    <input type="text" name="q" placeholder="Search for items…" />
                    <button type="submit"><i class="fi-rs-search"></i></button>
                </form>
            </div>
            <div class="mobile-menu-wrap mobile-header-border">
                <!-- Mobile menu content -->
                <nav>
                    <ul class="mobile-menu font-heading">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('shop.index') }}">Shop</a></li>
                        <li><a href="{{ route('blog.index') }}">Blog</a></li>
                        <li><a href="{{ route('page.contact') }}">Contact</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
