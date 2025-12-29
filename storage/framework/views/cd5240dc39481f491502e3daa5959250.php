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
    <div class="mobile-promotion">
        <span>Grand opening, <strong>up to 15%</strong> off all items. Only <strong>3 days</strong> left</span>
    </div>
    <div class="header-top header-top-ptb-1 d-none d-lg-block">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-3 col-lg-4">
                    <div class="header-info">
                        <ul>

                            <li><a href="<?php echo e(route('about-us')); ?>">About Us</a></li>
                            <li><a href="<?php echo e(route('contact')); ?>">Customer Service</a></li>
                            <!-- <li><a href="#">E-book</a></li> -->
                        </ul>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-4">
                    <div class="text-center">
                        <div id="news-flash" class="d-inline-block">
                            <ul>
                                <!-- max 55 char -->
                                <li>Instant Access : Travel E-books World-wide</li>
                                <li>Flash Sale : Get 30% Off Destination Guides</li>
                                <li>Top Guides : Don't Miss Secret Travel Maps</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4">
                    <div class="header-info header-info-right">
                        <ul>
                            <li>Need help ? Visit<strong>‎ <a href="<?php echo e(route('help-center')); ?>" class="text-brand">Help Center</a></strong></li>
                            <!-- <li>
                                <a class="language-dropdown-active" href="#">English <i class="fi-rs-angle-small-down"></i></a>
                                <ul class="language-dropdown">
                                    <li>
                                        <a href="#">Indonesian</a>
                                    </li>
                                </ul>
                            </li> -->
                            <!-- <li>
                                <a class="language-dropdown-active" href="#">USD <i class="fi-rs-angle-small-down"></i></a>
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
                            placeholder="Search by E-book Title or Author..."
                            style="height:40px; margin-left:7px; padding:0px 15px; font-size:14px; border-radius: 5px; border: 1px solid #ECECEC;" />
                    </div>
                    <div class="header-action-right ml-20">
                        <div class="header-action-2">
                            <div class="search-location">
                                <form action="#">
                                    <select class="select-active">
                                        <option>Your Location</option>
                                        <option>Bandung</option>
                                        <option>Jakarta</option>
                                        <option>Bogor</option>
                                        <option>Depok</option>
                                        <option>Tanggerang</option>
                                        <option>Bekasi</option>
                                        <option>Hawaii</option>
                                        <option>Cianjur</option>
                                        <option>Surabaya</option>
                                    </select>
                                </form>
                            </div>
                            <!-- <div class="header-action-icon-2">
                                <a href="shop-compare.html">
                                    <img class="svgInject" alt="Nest" src="assets-nest/nest-fe/imgs/theme/icons/icon-compare.svg" />
                                    <span class="pro-count blue">3</span>
                                </a>
                                <a href="shop-compare.html"><span class="lable ml-0">Compare</span></a>
                            </div> -->
                            <!-- <div class="header-action-icon-2">
                                <a href="shop-wishlist.html">
                                    <img class="svgInject" alt="Nest" src="assets-nest/nest-fe/imgs/theme/icons/icon-heart.svg" />
                                    <span class="pro-count blue">6</span>
                                </a>
                                <a href="shop-wishlist.html"><span class="lable">Wishlist</span></a>
                            </div> -->
                            <!-- <div class="header-action-icon-2">
                                <a class="mini-cart-icon" href="#">
                                    <i class="bi bi-bell mr-5"></i>
                                    <span class="pro-count blue">2</span>
                                </a>
                                <div class="cart-dropdown-wrap cart-dropdown-hm2 notification-dropdown">
                                    <div class="notification-header">
                                        <h5>Notifications</h5>
                                        <a href="#" class="mark-all-read">Mark all as read</a>
                                    </div>
                                    <ul>
                                        <li class="notification-item unread">
                                            <div class="notification-icon">
                                                <i class="bi bi-book text-primary"></i>
                                            </div>
                                            <div class="notification-content">
                                                <h6><a href="#">New Ebook Added</a></h6>
                                                <p>Bali Travel Guide 2024 is now available</p>
                                                <span class="notification-time">2 hours ago</span>
                                            </div>
                                            <div class="notification-delete">
                                                <a href="#"><i class="fi-rs-cross-small"></i></a>
                                            </div>
                                        </li>
                                        <li class="notification-item">
                                            <div class="notification-icon">
                                                <i class="bi bi-credit-card text-success"></i>
                                            </div>
                                            <div class="notification-content">
                                                <h6><a href="#">Subscription Reminder</a></h6>
                                                <p>Your subscription ends in 3 days</p>
                                                <span class="notification-time">1 day ago</span>
                                            </div>
                                            <div class="notification-delete">
                                                <a href="#"><i class="fi-rs-cross-small"></i></a>
                                            </div>
                                        </li>
                                        <li class="notification-item">
                                            <div class="notification-icon">
                                                <i class="bi bi-star text-warning"></i>
                                            </div>
                                            <div class="notification-content">
                                                <h6><a href="#">Rate Your Experience</a></h6>
                                                <p>How was your reading experience?</p>
                                                <span class="notification-time">2 days ago</span>
                                            </div>
                                            <div class="notification-delete">
                                                <a href="#"><i class="fi-rs-cross-small"></i></a>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="notification-footer">
                                        <a href="#" class="view-all">View All Notifications</a>
                                    </div>
                                </div>
                            </div> -->
                            
                            <?php if(auth()->check()): ?>
                            <div class="header-action-icon-2">
                                <a href="<?php echo e(route('page-account')); ?>">
                                    <img class="svgInject" alt="Nest" src="/assets-nest/nest-fe/imgs/theme/icons/icon-user.svg" />
                                </a>
                                <div class="cart-dropdown-wrap cart-dropdown-hm2 account-dropdown">
                                    <ul>
                                        <li>
                                            <a href="<?php echo e(route('page-account')); ?>?tab=account-detail"><i class="fi fi-rs-user mr-10"></i>Account</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo e(route('page-account')); ?>?tab=wishlist"><i class="fi fi-rs-label mr-10"></i>Wishlist</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo e(route('page-account')); ?>?tab=creator"><i class="fi-rs-edit mr-10"></i>Creator</a>
                                        </li>
                                        <li>
                                            
                                            <form method="POST" action="<?php echo e(route('user.logout')); ?>" id="logout-form" style="display: none;">
                                                <?php echo csrf_field(); ?>
                                            </form>
                                            <a href="#" onclick="event.preventDefault(); handleLogout();">
                                                <i class="fi fi-rs-sign-out mr-10"></i>Sign out
                                            </a>
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
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <?php else: ?>
                            <div class="header-action-icon-2">
                                <a href="<?php echo e(route('login')); ?>" class="btn-simple" style="padding: 8px 20px; background: transparent; color: #FF4C61; border-radius: 25px; text-decoration: none; font-size: 14px; border: 1.5px solid #FF4C61; transition: all 0.3s ease;">
                                    Sign In
                                </a>
                            </div>
                            <div class="header-action-icon-2">
                                <a href="<?php echo e(route('login')); ?>?form=register" class="btn-simple" style="padding: 8px 20px; background: #FF4C61; color: white; border-radius: 25px; text-decoration: none; font-size: 14px; border: 1.5px solid #FF4C61; transition: all 0.3s ease;">
                                    Sign Up
                                </a>
                            </div>
                            <?php endif; ?>
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
                            <span class="fi-rs-apps"></span>Category
                            <i class="fi-rs-angle-down"></i>
                        </a>
                        <div id="categories-dropdown-inner" class="categories-dropdown-wrap categories-dropdown-active-large font-heading">
                            <div class="categori-dropdown-inner-new">
                                <ul class="category-list-columns">
                                    <?php $__empty_1 = true; $__currentLoopData = $headerCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <li class="category-item">
                                        <a href="<?php echo e(route('category.show', $category->slug)); ?>">
                                            <?php if($category->image): ?>
                                            <img src="<?php echo e(asset($category->image)); ?>" alt="<?php echo e($category->name); ?>" />
                                            <?php else: ?>
                                            <img src="<?php echo e(asset('images/default-category-icon.svg')); ?>" alt="<?php echo e($category->name); ?>" />
                                            <?php endif; ?>
                                            <?php echo e($category->name); ?>

                                        </a>
                                    </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <li><a href="#">No categories found</a></li>
                                    <?php endif; ?>
                                </ul>
                            </div>

                            
                            
                        </div>
                    </div>
                    <div class="main-menu main-menu-padding-1 main-menu-lh-2 d-none d-lg-block font-heading">
                        <nav>
                            <ul>
                                <?php
                                // Debug: check user and role
                                $currentUser = auth()->user();
                                $debugInfo = '';
                                if ($currentUser) {
                                $userType = $currentUser->user_type ?? 'unknown';
                                $debugInfo = "User: {$currentUser->name}, Type: {$userType}";
                                } else {
                                $debugInfo = "Guest User";
                                }
                                ?>

                                <li class="<?php echo e(request()->routeIs('home') ? 'active' : ''); ?>">
                                    <a href="/">Home</a>
                                </li>

                                <li class="<?php echo e(request()->routeIs('destinations*') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('destinations')); ?>">Destinations</a>
                                </li>

                                <li class="<?php echo e(request()->routeIs('blogs.*') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('blogs.index')); ?>">Blog</a>
                                </li>

                                <li class="<?php echo e(request()->routeIs('pricing') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('pricing')); ?>">Pricing</a>
                                </li>

                                <li class="<?php echo e(request()->routeIs('promo') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('promo')); ?>">Promo</a>
                                </li>
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
                <div class="header-action-right d-block d-lg-none">
                    <div class="header-action-2">
                        <div class="header-action-icon-2">
                            <a href="shop-wishlist.html">
                                <img alt="Nest" src="assets-nest/nest-fe/imgs/theme/icons/icon-heart.svg" />
                                <span class="pro-count white">4</span>
                            </a>
                        </div>
                        <div class="header-action-icon-2">
                            <a class="mini-cart-icon" href="shop-cart.html">
                                <img alt="Nest" src="assets-nest/nest-fe/imgs/theme/icons/icon-cart.svg" />
                                <span class="pro-count white">2</span>
                            </a>
                            <div class="cart-dropdown-wrap cart-dropdown-hm2">
                                <ul>
                                    <li>
                                        <div class="shopping-cart-img">
                                            <a href="shop-product-right.html"><img alt="Nest" src="assets-nest/nest-fe/imgs/shop/thumbnail-3.jpg" /></a>
                                        </div>
                                        <div class="shopping-cart-title">
                                            <h4><a href="shop-product-right.html">Plain Striola Shirts</a></h4>
                                            <h3><span>1 × </span>$800.00</h3>
                                        </div>
                                        <div class="shopping-cart-delete">
                                            <a href="#"><i class="fi-rs-cross-small"></i></a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="shopping-cart-img">
                                            <a href="shop-product-right.html"><img alt="Nest" src="assets-nest/nest-fe/imgs/shop/thumbnail-4.jpg" /></a>
                                        </div>
                                        <div class="shopping-cart-title">
                                            <h4><a href="shop-product-right.html">Macbook Pro 2022</a></h4>
                                            <h3><span>1 × </span>$3500.00</h3>
                                        </div>
                                        <div class="shopping-cart-delete">
                                            <a href="#"><i class="fi-rs-cross-small"></i></a>
                                        </div>
                                    </li>
                                </ul>
                                <div class="shopping-cart-footer">
                                    <div class="shopping-cart-total">
                                        <h4>Total <span>$383.00</span></h4>
                                    </div>
                                    <div class="shopping-cart-button">
                                        <a href="shop-cart.html">View cart</a>
                                        <a href="shop-checkout.html">Checkout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                <a href="index.html"><img src="assets/imgs/theme/logo.svg" alt="logo" /></a>
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
                <form action="#">
                    <input type="text" placeholder="Search by E-book Title or Author..." />
                    <button type="submit"><i class="fi-rs-search"></i></button>
                </form>
            </div>
            <div class="mobile-menu-wrap mobile-header-border">
                <!-- mobile menu start -->
                <nav>
                    <ul class="mobile-menu font-heading">
                        <li class="menu-item-has-children">
                            <a href="index.html">Home</a>
                            <ul class="dropdown">
                                <li><a href="index.html">Home 1</a></li>
                                <li><a href="index-2.html">Home 2</a></li>
                                <li><a href="index-3.html">Home 3</a></li>
                                <li><a href="index-4.html">Home 4</a></li>
                                <li><a href="index-5.html">Home 5</a></li>
                                <li><a href="index-6.html">Home 6</a></li>
                            </ul>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="shop-grid-right.html">shop</a>
                            <ul class="dropdown">
                                <li><a href="shop-grid-right.html">Shop Grid – Right Sidebar</a></li>
                                <li><a href="shop-grid-left.html">Shop Grid – Left Sidebar</a></li>
                                <li><a href="shop-list-right.html">Shop List – Right Sidebar</a></li>
                                <li><a href="shop-list-left.html">Shop List – Left Sidebar</a></li>
                                <li><a href="shop-fullwidth.html">Shop - Wide</a></li>
                                <li class="menu-item-has-children">
                                    <a href="#">Single Product</a>
                                    <ul class="dropdown">
                                        <li><a href="shop-product-right.html">Product – Right Sidebar</a></li>
                                        <li><a href="shop-product-left.html">Product – Left Sidebar</a></li>
                                        <li><a href="shop-product-full.html">Product – No sidebar</a></li>
                                        <li><a href="shop-product-vendor.html">Product – Vendor Infor</a></li>
                                    </ul>
                                </li>
                                <li><a href="shop-filter.html">Shop – Filter</a></li>
                                <li><a href="shop-wishlist.html">Shop – Wishlist</a></li>
                                <li><a href="shop-cart.html">Shop – Cart</a></li>
                                <li><a href="shop-checkout.html">Shop – Checkout</a></li>
                                <li><a href="shop-compare.html">Shop – Compare</a></li>
                                <li class="menu-item-has-children">
                                    <a href="#">Shop Invoice</a>
                                    <ul class="dropdown">
                                        <li><a href="shop-invoice-1.html">Shop Invoice 1</a></li>
                                        <li><a href="shop-invoice-2.html">Shop Invoice 2</a></li>
                                        <li><a href="shop-invoice-3.html">Shop Invoice 3</a></li>
                                        <li><a href="shop-invoice-4.html">Shop Invoice 4</a></li>
                                        <li><a href="shop-invoice-5.html">Shop Invoice 5</a></li>
                                        <li><a href="shop-invoice-6.html">Shop Invoice 6</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="#">Vendors</a>
                            <ul class="dropdown">
                                <li><a href="vendors-grid.html">Vendors Grid</a></li>
                                <li><a href="vendors-list.html">Vendors List</a></li>
                                <li><a href="vendor-details-1.html">Vendor Details 01</a></li>
                                <li><a href="vendor-details-2.html">Vendor Details 02</a></li>
                                <li><a href="vendor-dashboard.html">Vendor Dashboard</a></li>
                                <li><a href="vendor-guide.html">Vendor Guide</a></li>
                            </ul>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="#">Mega menu</a>
                            <ul class="dropdown">
                                <li class="menu-item-has-children">
                                    <a href="#">Women's Fashion</a>
                                    <ul class="dropdown">
                                        <li><a href="shop-product-right.html">Dresses</a></li>
                                        <li><a href="shop-product-right.html">Blouses & Shirts</a></li>
                                        <li><a href="shop-product-right.html">Hoodies & Sweatshirts</a></li>
                                        <li><a href="shop-product-right.html">Women's Sets</a></li>
                                    </ul>
                                </li>
                                <li class="menu-item-has-children">
                                    <a href="#">Men's Fashion</a>
                                    <ul class="dropdown">
                                        <li><a href="shop-product-right.html">Jackets</a></li>
                                        <li><a href="shop-product-right.html">Casual Faux Leather</a></li>
                                        <li><a href="shop-product-right.html">Genuine Leather</a></li>
                                    </ul>
                                </li>
                                <li class="menu-item-has-children">
                                    <a href="#">Technology</a>
                                    <ul class="dropdown">
                                        <li><a href="shop-product-right.html">Gaming Laptops</a></li>
                                        <li><a href="shop-product-right.html">Ultraslim Laptops</a></li>
                                        <li><a href="shop-product-right.html">Tablets</a></li>
                                        <li><a href="shop-product-right.html">Laptop Accessories</a></li>
                                        <li><a href="shop-product-right.html">Tablet Accessories</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="blog-category-fullwidth.html">Blog</a>
                            <ul class="dropdown">
                                <li><a href="blog-category-grid.html">Blog Category Grid</a></li>
                                <li><a href="blog-category-list.html">Blog Category List</a></li>
                                <li><a href="blog-category-big.html">Blog Category Big</a></li>
                                <li><a href="blog-category-fullwidth.html">Blog Category Wide</a></li>
                                <li class="menu-item-has-children">
                                    <a href="#">Single Product Layout</a>
                                    <ul class="dropdown">
                                        <li><a href="blog-post-left.html">Left Sidebar</a></li>
                                        <li><a href="blog-post-right.html">Right Sidebar</a></li>
                                        <li><a href="blog-post-fullwidth.html">No Sidebar</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="#">Pages</a>
                            <ul class="dropdown">
                                <li><a href="page-about.html">About Us</a></li>
                                <li><a href="page-contact.html">Contact</a></li>
                                <li><a href="page-account.html">My Account</a></li>
                                <li><a href="page-login.html">Login</a></li>
                                <li><a href="page-register.html">Register</a></li>
                                <li><a href="page-forgot-password.html">Forgot password</a></li>
                                <li><a href="page-reset-password.html">Reset password</a></li>
                                <li><a href="page-purchase-guide.html">Purchase Guide</a></li>
                                <li><a href="page-privacy-policy.html">Privacy Policy</a></li>
                                <li><a href="page-terms.html">Terms of Service</a></li>
                                <li><a href="page-404.html">404 Page</a></li>
                            </ul>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="#">Language</a>
                            <ul class="dropdown">
                                <li><a href="#">English</a></li>
                                <li><a href="#">French</a></li>
                                <li><a href="#">German</a></li>
                                <li><a href="#">Spanish</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- mobile menu end -->
            </div>
            <div class="mobile-header-info-wrap">
                <div class="single-mobile-header-info">
                    <a href="page-contact.html"><i class="fi-rs-marker"></i> Our location </a>
                </div>
                <div class="single-mobile-header-info">
                    <a href="page-login.html"><i class="fi-rs-user"></i>Log In / Sign Up </a>
                </div>
                <div class="single-mobile-header-info">
                    <a href="#"><i class="fi-rs-headphones"></i>(+01) - 2345 - 6789 </a>
                </div>
            </div>
            <div class="mobile-social-icon mb-50">
                <h6 class="mb-15">Follow Us</h6>
                <a href="#"><img src="assets/imgs/theme/icons/icon-facebook-white.svg" alt="" /></a>
                <a href="#"><img src="assets/imgs/theme/icons/icon-twitter-white.svg" alt="" /></a>
                <a href="#"><img src="assets/imgs/theme/icons/icon-instagram-white.svg" alt="" /></a>
                <a href="#"><img src="assets/imgs/theme/icons/icon-pinterest-white.svg" alt="" /></a>
                <a href="#"><img src="assets/imgs/theme/icons/icon-youtube-white.svg" alt="" /></a>
            </div>
            <div class="site-copyright">Copyright 2022 © Nest. All rights reserved. Powered by AliThemes.</div>
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
    });
</script><?php /**PATH D:\PROJEK PROJEK\Ebook-Traveling\resources\views/layouts_lp/components/header.blade.php ENDPATH**/ ?>