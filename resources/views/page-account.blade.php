@extends('layouts_lp.app')

@section('title', 'My Account - MeatMap')

@section('content')
    {{-- STYLES UNTUK CUSTOM CSS --}}
    <style>
        .btn-custom {
            margin-top: 7px;
        }

        .stat-card {
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .required {
            color: #dc3545;
        }

        .btn-small {
            padding: 5px 10px;
            background: #FF4C61;
            color: white;
            border-radius: 4px;
            text-decoration: none;
            font-size: 12px;
            transition: all 0.3s ease;
        }

        .btn-small:hover {
            background: #e04154;
            color: white;
        }
    </style>
    <style>
        /* style untuk alert */
        .alert-fade-out {
            opacity: 0;
            transition: opacity 0.5s ease-out;
        }
    </style>
    <style>
        /* style agar baris jadi ... */
        .post-title {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            /* Maksimal 2 baris */
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.4;
            font-size: 16px;
            font-weight: 600;
            min-height: 2.8em;
            /* Untuk konsistensi tinggi */
        }

        .post-title a {
            color: #333;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .post-title a:hover {
            color: #FF4C61;
        }

        /* Optional: Untuk yang mau lebih kecil */
        .post-title-sm {
            font-size: 14px;
            min-height: 2.6em;
        }

        .post-title-md {
            font-size: 16px;
            min-height: 2.8em;
        }

        .post-title-lg {
            font-size: 18px;
            min-height: 3em;
        }
    </style>
    <style>
        /* Kustomisasi Koleksi E-book */

        /* Poin 1: Style untuk deskripsi koleksi */
        .section-title.style-2 .collection-description {
            font-size: 0.9em;
            color: #888;
            margin-top: 0;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .section-title.style-2 h3 {
            margin-bottom: 5px;
        }

        /* Poin 3: Style untuk indikator akses berlangganan (pengganti harga) */
        .product-cart-wrap .product-access-indicator {
            text-align: center;
            color: #FF4C61;
            font-weight: 500;
            font-size: 0.9em;
            margin-top: 10px;
            padding: 5px 0;
        }

        .product-cart-wrap .product-access-indicator i {
            margin-right: 5px;
        }

        /* Poin 2: Style untuk tombol scroll saat dinonaktifkan */
        .scroll-btn:disabled {
            opacity: 0.4;
            cursor: not-allowed;
            pointer-events: none;
        }

        /* ==========================================================================
                                Kustomisasi Tampilan E-book (Satu Kartu, Tombol Berbeda)
                               ========================================================================== */

        .product-cart-wrap {
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
        }

        /* --- Gaya Umum untuk Elemen Kartu --- */
        .product-cart-wrap h2 {
            font-size: 1.1rem;
            line-height: 1.4;
            margin-bottom: 0.5rem;
            min-height: 3.2em;
            margin-top: 8px;
        }

        .product-cart-wrap .product-description {
            min-height: 3.2em;
        }

        .product-author {
            font-size: 0.9rem;
            color: var(--text-color-muted);
            margin-bottom: 0.75rem;
        }

        .product-description {
            font-size: 0.85rem;
            color: var(--text-color-muted);
            margin-top: -15px;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-description.single-line {
            margin-bottom: 1.3rem;
        }

        .product-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            font-size: 0.8rem;
        }

        .read-count {
            color: var(--text-color-muted);
        }

        /* --- Badge Bahasa --- */
        .badge-language {
            /* background-color: #6c757d; */
            color: #fff;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        /* Fixed ukuran cover ebook agar konsisten */
        .product-img {
            position: relative;
            width: 100%;
            padding-top: 140%;
            /* Rasio 5:7 (tinggi 140% dari lebar) untuk cover buku */
            overflow: hidden;
            border-radius: 15px;
            background-color: #f5f5f5;
        }

        .product-img img.default-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        /* Untuk membatasi judul buku maksimal 2 baris */
        .product-cart-wrap h2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            /* Maksimal 2 baris */
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            /* Menambahkan "..." */
        }

        /* Untuk membatasi deskripsi buku maksimal 2 baris */
        .product-description {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            /* Maksimal 2 baris */
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            /* Menambahkan "..." */
        }

        /* --- Gaya untuk Tombol Aksi --- */
        .action-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-read-now {
            background-color: #FF4C61;
            /* Hijau untuk aksi positif */
            color: #fff;
        }

        .btn-read-now:hover {
            background-color: #de364aff;
            color: #fff;
        }

        .btn-subscribe-now {
            background: #FF4C61;
            color: #fff;
        }

        .btn-subscribe-now:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(168, 85, 247, 0.4);
            color: #FF4C61;
            background-color: #fff;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(168, 85, 247, 0.7);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(168, 85, 247, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(168, 85, 247, 0);
            }
        }

        /* Untuk membatasi nama author maksimal 1 baris */
        .product-author span {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            /* Maksimal 1 baris */
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Untuk membuat gambar blog post seragam dan rapi */
        .post-thumb {
            position: relative;
            width: 100%;
            padding-top: 50%;
            overflow: hidden;
            border-radius: 15px;
            margin-bottom: 0px;
        }

        .post-thumb img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Untuk mengurangi jarak antara gambar dan kategori blog */
        .entry-content-2 h6 a {
            margin-top: -5px;
            /* Tarik kategori ke atas untuk mengurangi jarak */
        }

        /* sedikit style untuk card top city */
        .city-name-long {
            font-size: 0.75em;
            line-height: 1.2;
        }
    </style>
    <style>
        .nav-link {
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .nav-link:hover {
            background-color: rgba(0, 0, 0, 0.03) !important;
            color: var(--bs-body-color) !important;
        }

        .nav-link.active {
            color: #ffffffff !important;
            background-color: #FF416C !important;
            font-weight: 600;
        }

        .js-submenu {
            overflow: hidden;
        }

        .js-submenu li:last-child {
            margin-bottom: 0.5rem;
        }

        .transition-transform {
            transition: transform 0.3s ease;
        }

        .rotated .transition-transform {
            transform: rotate(180deg);
        }

        .nav-item {
            margin: 0 1.5rem 0 0;
        }
    </style>
    <style>
        .custom-button {
            padding: 7px 17px !important;
            border: none !important;
            border-radius: 50px !important;
            font-size: 0.7rem !important;
            font-weight: 600 !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
            letter-spacing: 1px !important;
            text-decoration: none !important;
            text-align: center !important;
            display: inline-block !important;
        }

        .custom-button--primary {
            background-color: #FF4C61 !important;
            color: #fff !important;
        }

        .pricing-card--featured .custom-button--primary {
            background-color: var(--primary-color);
            box-shadow: 0 5px 15px rgba(255, 76, 97, 0.3);
        }

        .custom-button--primary:hover {
            background-color: #FF416C !important;
            transform: translateY(-3px) !important;
        }

        /* untuk progresss subscription */
        .progress-bar {
            transition: width 0.5s ease;
        }
    </style>
    <style>
        /* Hover underline untuk judul */
        .hover-underline:hover {
            text-decoration: underline;
            text-decoration-color: #FF4C61;
        }

        /* Button ungu sesuai tema */
        .btn-gradient-purple {
            background: linear-gradient(135deg, #6A4C93, #FF4C61);
            border: none;
        }

        .btn-gradient-purple:hover {
            background: linear-gradient(135deg, #7B5DA4, #FF6B81);
            transform: translateY(-2px);
        }
    </style>
    <style>
        .hover-lift {
            transition: all 0.2s ease;
        }

        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .bg-light-primary {
            background-color: rgba(255, 65, 108, 0.1);
        }

        .bg-light-info {
            background-color: rgba(23, 162, 184, 0.1);
        }

        .bg-light-success {
            background-color: rgba(40, 167, 69, 0.1);
        }
    </style>
    <style>
        .btn-no-style {
            padding: 5px 10px !important;
            border: none !important;
            border-radius: 50px !important;
            font-size: 0.7rem !important;
            font-weight: 600 !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
            letter-spacing: 1px !important;
            text-decoration: none !important;
            text-align: center !important;
            display: inline-block !important;
            background-color: #FF4C61 !important;
            color: #fff !important;
        }

        .btn-no-style:hover {
            background-color: #FF416C !important;
            transform: translateY(-3px) !important;
        }
    </style>
    <style>
        /* ✅ Style khusus untuk tombol di modal edit review */
        .btn-edit-review {
            padding: 5px 13px !important;
            border: none !important;
            border-radius: 50px !important;
            font-size: 0.7rem !important;
            font-weight: 600 !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
            letter-spacing: 1px !important;
            text-decoration: none !important;
            text-align: center !important;
            display: inline-block !important;
            background-color: #FF4C61 !important;
            color: white !important;
        }

        .btn-edit-review:hover {
            background-color: #FF416C !important;
            transform: translateY(-3px) !important;
        }
    </style>

    <style>
        /* ✅ Styling Pagination Merah */
        .pagination .page-link {
            color: #FF4C61 !important;
            background-color: #fff !important;
            border-color: #ddd !important;
        }

        .pagination .page-link:hover {
            color: #fff !important;
            background-color: #FF4C61 !important;
            border-color: #FF4C61 !important;
        }

        .pagination .page-item.active .page-link {
            color: #fff !important;
            background-color: #FF4C61 !important;
            border-color: #FF4C61 !important;
        }

        .pagination .page-item.disabled .page-link {
            color: #ccc !important;
            background-color: #f9f9f9 !important;
            border-color: #ddd !important;
            cursor: not-allowed !important;
        }
    </style>

    {{-- Popup Payment Success --}}
    @if (session('payment_success'))
        <div id="paymentSuccessModal" class="modal fade show" style="display: block; background: rgba(0,0,0,0.5);"
            tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content"
                    style="border-radius: 15px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
                    <div class="modal-body text-center p-5">
                        <div class="success-checkmark mb-4">
                            <div class="check-icon"
                                style="width: 80px; height: 80px; margin: 0 auto; background: linear-gradient(135deg, #FF4C61 0%, #FF6B81 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fi fi-rs-check" style="font-size: 40px; color: white; font-weight: bold;"></i>
                            </div>
                        </div>
                        <h3 class="mb-3" style="color: #2d3436; font-weight: 700;">Payment Successful!</h3>
                        <p class="text-muted mb-4" style="font-size: 16px;">
                            Congratulations! <br> You are now a <strong style="color: #FF4C61;">Premium Member</strong>.<br>
                            Enjoy unlimited access to all exclusive features!
                        </p>
                        <button type="button" class="btn btn-brand btn-lg px-5" onclick="closeSuccessModal()"
                            style="background: linear-gradient(135deg, #FF4C61 0%, #FF6B81 100%); border: none; border-radius: 25px; font-weight: 600;">
                            <i class="fi fi-rs-party-horn me-2"></i> Let's Explore!
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <style>
            @keyframes checkmark-pop {
                0% {
                    transform: scale(0);
                    opacity: 0;
                }

                50% {
                    transform: scale(1.2);
                }

                100% {
                    transform: scale(1);
                    opacity: 1;
                }
            }

            .success-checkmark .check-icon {
                animation: checkmark-pop 0.5s ease-out;
            }

            #paymentSuccessModal .modal-content {
                animation: slideDown 0.3s ease-out;
            }

            @keyframes slideDown {
                from {
                    transform: translateY(-50px);
                    opacity: 0;
                }

                to {
                    transform: translateY(0);
                    opacity: 1;
                }
            }
        </style>

        <script>
            function closeSuccessModal() {
                const modal = document.getElementById('paymentSuccessModal');
                modal.style.opacity = '0';
                modal.style.transition = 'opacity 0.3s ease-out';
                setTimeout(() => {
                    modal.style.display = 'none';
                }, 300);
            }

            // Auto close after 8 seconds
            setTimeout(() => {
                closeSuccessModal();
            }, 8000);

            // Close on click outside
            document.getElementById('paymentSuccessModal')?.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeSuccessModal();
                }
            });
        </script>
    @endif

    <main class="main pages">
        <div class="page-header mt-30 mb-30">
            <div class="container">
                <div class="archive-header">
                    <div class="row align-items-center">
                        <div class="col-xl-3">
                            <h3 class="mb-15">My Account</h3>
                            <div class="breadcrumb">
                                <a href="/" rel="nofollow"><i class="fi fi-rs-home mr-5"></i>Home</a>
                                <span></span> My Account
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-content">
            <div class="container">
                <div class="row">
                    <!-- sidebar mini -->
                    <div class="col-md-3">
                        <div class="dashboard-menu" style="position: sticky; top: 80px;">
                            <ul class="nav flex-column" role="tablist">
                                <!-- ========== DASHBOARD ========== -->
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center px-3 py-2 {{ request('tab', 'dashboard') == 'dashboard' ? 'active bg-light-subtle' : 'text-body' }}"
                                        href="{{ route('page-account') }}?tab=dashboard">
                                        <i class="fi fi-rs-settings-sliders me-3 fs-5"></i>
                                        <span>
                                            @if (auth()->check() && auth()->user()->hasActiveSubscription())
                                                Dashboard Member
                                            @else
                                                Dashboard
                                            @endif
                                        </span>
                                    </a>
                                </li>

                                <!-- ========== WISHLIST ========== -->
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center px-3 py-2 {{ request('tab') == 'wishlist' ? 'active bg-light-subtle' : 'text-body' }}"
                                        href="{{ route('page-account') }}?tab=wishlist">
                                        <i
                                            class="fi fi-rs-heart me-3 fs-5 mt-1 {{ request('tab') == 'wishlist' ? 'text-white' : 'text-danger' }}"></i>
                                        <span>Wishlist</span>
                                    </a>
                                </li>

                                <!-- ========== MY READING AREA (Premium Only) ========== -->
                                @if (auth()->user()->hasActiveSubscription())
                                    <li class="nav-item">
                                        <a class="nav-link d-flex justify-content-between align-items-center px-3 py-2 text-body"
                                            data-target="contentMenu" href="#"
                                            onclick="toggleMenu(event, 'contentMenu')">
                                            <span class="d-flex align-items-center">
                                                <i class="fi fi-rs-book me-3 fs-5 text-primary"></i>
                                                <span>Reading Area</span>
                                            </span>
                                            <i class="fi fi-rs-angle-small-down fs-4 transition-transform"></i>
                                        </a>
                                        <ul class="nav flex-column ms-4 mt-1 js-submenu" id="contentMenu"
                                            style="display: {{ in_array(request('tab'), ['library', 'reading-history', 'wishlist']) ? 'block' : 'none' }};">
                                            <li class="nav-item">
                                                <a class="nav-link d-flex align-items-center px-3 py-2 {{ request('tab') == 'library' ? 'active bg-light-subtle' : 'text-muted' }}"
                                                    href="{{ route('page-account') }}?tab=library">
                                                    <span><i class="bi bi-collection mr-10"></i>My Library</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link d-flex align-items-center px-3 py-2 {{ request('tab') == 'reading-history' ? 'active bg-light-subtle' : 'text-muted' }}"
                                                    href="{{ route('page-account') }}?tab=reading-history">
                                                    <span><i class="bi-clock-history mr-10"></i>Reading History</span>
                                                </a>
                                            </li>
                                            @if (auth()->user()->hasActiveSubscription())
                                                <li class="nav-item">
                                                    <a class="nav-link d-flex align-items-center px-3 py-2 {{ request('tab') == 'reviews' ? 'active bg-light-subtle' : 'text-muted' }}"
                                                        href="{{ route('page-account') }}?tab=reviews">
                                                        <span><i class="fi fi-rs-star mr-10"></i>My Reviews</span>
                                                    </a>
                                                </li>
                                            @endif
                                        </ul>
                                    </li>
                                @endif

                                <!-- ========== ACCOUNT SETTINGS ========== -->
                                <li class="nav-item">
                                    <a class="nav-link d-flex justify-content-between align-items-center px-3 py-2 text-body"
                                        data-target="settingMenu" href="#" onclick="toggleMenu(event, 'settingMenu')">
                                        <span class="d-flex align-items-center">
                                            <i class="fi fi-rs-user me-3 fs-5 text-info"></i>
                                            <span>Account Settings</span>
                                        </span>
                                        <i class="fi fi-rs-angle-small-down fs-4 transition-transform"></i>
                                    </a>
                                    <ul class="nav flex-column ms-4 mt-1 js-submenu" id="settingMenu"
                                        style="display: {{ in_array(request('tab'), ['account-detail', 'subscription', 'payment', 'help']) ? 'block' : 'none' }};">
                                        <li class="nav-item">
                                            <a class="nav-link d-flex align-items-center px-3 py-2 {{ request('tab') == 'account-detail' ? 'active bg-light-subtle' : 'text-muted' }}"
                                                href="{{ route('page-account') }}?tab=account-detail">
                                                <span><i class="fi fi-rs-user mr-10"></i>Profile Details</span>
                                            </a>
                                        </li>
                                        @if (auth()->user()->hasActiveSubscription())
                                            <li class="nav-item">
                                                <a class="nav-link d-flex align-items-center px-3 py-2 {{ request('tab') == 'subscription' ? 'active bg-light-subtle' : 'text-muted' }}"
                                                    href="{{ route('page-account') }}?tab=subscription">
                                                    <span><i class="fi fi-rs-crown mr-10"></i>My Subscription</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link d-flex align-items-center px-3 py-2 {{ request('tab') == 'help' ? 'active bg-light-subtle' : 'text-muted' }}"
                                                    href="{{ route('page-account') }}?tab=help">
                                                    <span><i class="fi fi-rs-interactive mr-10"></i>Help Center</span>
                                                </a>
                                            </li>
                                        @else
                                            <li class="nav-item">
                                                <a class="nav-link d-flex align-items-center px-3 py-2 {{ request('tab') == 'payment' ? 'active bg-light-subtle' : 'text-muted' }}"
                                                    href="{{ route('page-account') }}?tab=payment">
                                                    <span><i class="fi fi-rs-credit-card mr-10"></i>Payment History</span>
                                                    <!-- @if ($ordersCount > 0)
    <span class="badge bg-success rounded-pill ms-auto">{{ $ordersCount }}</span>
    @endif -->
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </li>

                                <!-- ========== LOGOUT ========== -->
                                <li class="nav-item border-top">
                                    <a class="nav-link d-flex align-items-center px-3 py-2 text-danger" href="#"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fi fi-rs-sign-out me-3 fs-5"></i>
                                        <span>Logout</span>
                                    </a>
                                    <form id="logout-form" action="{{ route('user.logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="tab-content account dashboard-content pl-50">

                            <!-- DASHBOARD TAB -->
                            <div class="tab-pane fade {{ request('tab', 'dashboard') == 'dashboard' ? 'active show' : '' }}"
                                id="dashboard" role="tabpanel">

                                <div class="card">
                                    <!-- Header: Sama untuk semua user -->
                                    <div class="card-header border-0 pb-3">
                                        <h4 class="mb-1">Hello {{ auth()->user()->name }}!</h4>
                                        <small class="text-muted">
                                            @if (auth()->user()->hasActiveSubscription())
                                                Premium Member since {{ auth()->user()->created_at->format('M Y') }}
                                            @else
                                                Member since {{ auth()->user()->created_at->format('M Y') }}
                                            @endif
                                        </small>
                                    </div>

                                    <div class="card-body p-4">
                                        @if (auth()->user()->hasActiveSubscription())
                                            <!-- TAMPILAN PREMIUM (Minimalis) -->
                                            <div class="d-flex align-items-start gap-3">
                                                <i class="fi fi-rs-crown mt-1"
                                                    style="font-size: 1.5rem; color: #FF416C;"></i>
                                                <div>
                                                    <h5 class="fw-bold mb-2" style="color: #333;">Welcome, Premium
                                                        Member!</h5>
                                                    <p class="text-muted mb-0">
                                                        You have full access to all travel eBooks and exclusive features.
                                                    </p>
                                                </div>
                                            </div>
                                        @else
                                            <!-- TAMPILAN NON-PREMIUM (Lebih ringkas & clean) -->
                                            <div class="alert alert-light border border-info-subtle rounded-3 mb-0 p-3">
                                                <h6 class="mb-2 text-info fw-bold">Upgrade to Premium</h6>
                                                <p class="mb-2 small text-muted">
                                                    Unlock all ebooks and exclusive features with a premium subscription.
                                                </p>
                                                <a href="{{ route('pricing') }}#pricing-plans"
                                                    class="custom-button custom-button--primary text-white px-4">View
                                                    Plans</a>
                                            </div>
                                        @endif

                                        <!-- Quick Stats (Real Data from Database) -->
                                        <div class="dashboard-stats d-flex justify-content-around mt-5 pt-3 border-top">
                                            <div class="text-center">
                                                <div class="h5 mb-1 fw-bold" style="color: #FF416C;">
                                                    {{ $ebooksRead ?? 0 }}
                                                </div>
                                                <small class="text-muted">Books Read</small>
                                            </div>
                                            <div class="text-center">
                                                <div class="h5 mb-1 fw-bold" style="color: #ffc107;">
                                                    {{ $favoritesCount ?? 0 }}
                                                </div>
                                                <small class="text-muted">Favorites</small>
                                            </div>
                                            <div class="text-center">
                                                <div class="h5 mb-1 fw-bold" style="color: #17a2b8;">
                                                    {{ $reviewsCount ?? 0 }}
                                                </div>
                                                <small class="text-muted">Reviews Written</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- WISHLIST TAB -->
                            <div class="tab-pane fade {{ request('tab') == 'wishlist' ? 'active show' : '' }}"
                                id="wishlist" role="tabpanel">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header bg-white border-0 py-3">
                                        <h5 class="mb-0 fw-bold text-dark">Your Wishlist</h5>
                                    </div>
                                    <div class="card-body">
                                        <!-- FORM SEARCH & FILTER -->
                                        <form method="GET" action="{{ route('page-account') }}" class="mb-4">
                                            <input type="hidden" name="tab" value="wishlist">
                                            <div class="row g-3 align-items-end">
                                                <div class="col-md-6">
                                                    <label for="wishlist_search" class="form-label">Search by
                                                        Title</label>
                                                    <input type="text" class="form-control h-100" name="search"
                                                        id="wishlist_search" placeholder="e.g., Bali Travel Guide"
                                                        value="{{ request('search') }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="wishlist_city" class="form-label">Filter by City</label>
                                                    <select name="city_slug" id="wishlist_city"
                                                        class="form-select form-select-md">
                                                        <option value="">All Cities</option>
                                                        @foreach ($cities as $city)
                                                            <option value="{{ $city->slug }}"
                                                                {{ request('city_slug') == $city->slug ? 'selected' : '' }}>
                                                                {{ $city->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="submit" class="btn-read-now text-white px-4 py-2 mt-2">
                                                        <i class="fi fi-rs-search me-2 mt-1"></i>Search
                                                    </button>
                                                </div>
                                            </div>
                                        </form>

                                        @if ($wishlistItems->count() > 0)
                                            <div class="table-responsive">
                                                <table class="table align-middle">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 80px;">Cover</th>
                                                            <th>Ebook</th>
                                                            <th>Category</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($wishlistItems as $ebook)
                                                            <tr>
                                                                <!--  FOTO COVER -->
                                                                <td>
                                                                    <div class="bg-light rounded"
                                                                        style="width: 60px; height: 80px;">
                                                                        @if ($ebook->cover_image_url)
                                                                            <img src="{{ $ebook->cover_image_url }}"
                                                                                alt="{{ $ebook->title }}"
                                                                                class="img-fluid rounded"
                                                                                style="width: 60px; height: 80px; object-fit: cover;">
                                                                        @else
                                                                            <div
                                                                                class="d-flex align-items-center justify-content-center h-100 text-muted">
                                                                                <i class="fi fi-rs-book"></i>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </td>

                                                                <!--  JUDUL -->
                                                                <td>
                                                                    <div class="fw-bold">
                                                                        {{ $ebook->title ?? 'Unknown Book' }}</div>
                                                                    @if ($ebook->creator)
                                                                        <small class="text-muted">by
                                                                            {{ $ebook->creator->name }}</small>
                                                                    @endif
                                                                </td>

                                                                <!--  KATEGORI -->
                                                                <td>
                                                                    @if ($ebook->categories && $ebook->categories->count() > 0)
                                                                        @foreach ($ebook->categories as $category)
                                                                            <span
                                                                                class="badge bg-light text-dark border me-1">{{ $category->name }}</span>
                                                                        @endforeach
                                                                    @else
                                                                        <span class="text-muted">—</span>
                                                                    @endif
                                                                </td>

                                                                <!--  ACTION -->
                                                                <td>
                                                                    @if (auth()->check() && auth()->user()->hasActiveSubscription())
                                                                        <a href="{{ route('user.ebook.read', $ebook->slug) }}"
                                                                            class="custom-button custom-button--primary text-white px-4">
                                                                            <span>Read Now</span>
                                                                        </a>
                                                                    @else
                                                                        <a href="/pricing"
                                                                            class="custom-button custom-button--primary text-white px-4">
                                                                            <i class="fi fi-rs-lock mt-1"></i>
                                                                            <span>Subscribe to Read</span>
                                                                        </a>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            <!-- Pagination -->
                                            @if ($wishlistItems->hasPages())
                                                <nav aria-label="Wishlist pagination" class="mt-4 mb-4">
                                                    <ul class="pagination justify-content-center">
                                                        {{-- Previous Page Link --}}
                                                        <li class="page-item {{ $wishlistItems->onFirstPage() ? 'disabled' : '' }}">
                                                            @if ($wishlistItems->onFirstPage())
                                                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                                                    <span aria-hidden="true">&laquo;</span>
                                                                </a>
                                                            @else
                                                                <a class="page-link" href="{{ $wishlistItems->previousPageUrl() }}" aria-label="Previous">
                                                                    <span aria-hidden="true">&laquo;</span>
                                                                </a>
                                                            @endif
                                                        </li>

                                                        {{-- Pagination Elements --}}
                                                        @foreach ($wishlistItems->getUrlRange(1, $wishlistItems->lastPage()) as $page => $url)
                                                            <li class="page-item {{ $page == $wishlistItems->currentPage() ? 'active' : '' }}">
                                                                @if ($page == $wishlistItems->currentPage())
                                                                    <a class="page-link" href="#">{{ $page }}</a>
                                                                @else
                                                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                                                @endif
                                                            </li>
                                                        @endforeach

                                                        {{-- Next Page Link --}}
                                                        <li class="page-item {{ !$wishlistItems->hasMorePages() ? 'disabled' : '' }}">
                                                            @if ($wishlistItems->hasMorePages())
                                                                <a class="page-link" href="{{ $wishlistItems->nextPageUrl() }}" aria-label="Next">
                                                                    <span aria-hidden="true">&raquo;</span>
                                                                </a>
                                                            @else
                                                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                                                    <span aria-hidden="true">&raquo;</span>
                                                                </a>
                                                            @endif
                                                        </li>
                                                    </ul>
                                                </nav>

                                                <!-- Page Info -->
                                                <div class="text-center text-muted small">
                                                    Showing {{ $wishlistItems->firstItem() }} to {{ $wishlistItems->lastItem() }} of {{ $wishlistItems->total() }} wishlist items
                                                </div>
                                            @endif
                                        @else
                                            <div class="text-center py-4">
                                                <i class="fi fi-rs-heart text-muted" style="font-size: 48px;"></i>
                                                <h5 class="mt-3">No saved books yet</h5>
                                                <p class="text-muted">Start exploring our ebooks and add them to your
                                                    wishlist!
                                                </p>
                                                @if (auth()->check() && auth()->user()->hasActiveSubscription())
                                                    <a href="{{ route('page-account') }}?tab=library"
                                                        class="custom-button custom-button--primary text-white px-4 mt-2">
                                                        Browse Ebooks
                                                    </a>
                                                @else
                                                    <a href="{{ route('destinations') }}"
                                                        class="custom-button custom-button--primary text-white px-4 mt-2">
                                                        Browse Ebooks
                                                    </a>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- PROFILE SETTINGS TAB -->
                            <div class="tab-pane fade {{ request('tab') == 'account-detail' ? 'active show' : '' }}"
                                id="account-detail" role="tabpanel">
                                {{-- Tambahkan ini di bagian atas untuk debugging --}}
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <strong>Ada kesalahan:</strong>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                {{-- AWAL: FORM UNTUK UPDATE AVATAR --}}
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5>Profile Picture</h5>
                                    </div>
                                    <div class="card-body">
                                        @if (session('avatar_success'))
                                            <div class="alert alert-success">
                                                {{ session('avatar_success') }}
                                            </div>
                                        @endif

                                        <form method="POST" action="{{ route('account.update.avatar') }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row align-items-center">
                                                <div class="col-md-3 text-center">
                                                    <label for="avatar_input" style="cursor: pointer;">
                                                        {{-- SOLUSI CACHE-BUSTING: Tambahkan ?t={{ time() }} --}}
                                                        <img id="avatar-preview"
                                                            src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) . '?t=' . auth()->user()->updated_at->timestamp : asset('/images/user-avatar.png') }}"
                                                            alt="Avatar Preview" class="img-fluid rounded-circle"
                                                            style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #e9ecef;">
                                                        <p class="mt-2 mb-0"><small>Click to change photo.</small></p>
                                                    </label>
                                                    <input type="file" id="avatar_input" name="avatar"
                                                        class="form-control d-none" accept="image/*">
                                                </div>
                                                <div class="col-md-9">
                                                    <p class="mb-2">Upload a new profile photo. Supported formats: JPEG,
                                                        PNG, JPG, GIF. Maximum size: 2MB.</p>
                                                    <button type="submit"
                                                        class="custom-button custom-button--primary text-white px-4">
                                                        <i class="fi fi-rs-camera mr-5"></i> Update Picture
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                {{-- AKHIR: FORM UNTUK UPDATE AVATAR --}}

                                {{-- FORM LAMA UNTUK DETAIL PROFIL --}}
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Profile Settings</h5>
                                    </div>
                                    <div class="card-body">
                                        @if (session('success'))
                                            <div class="alert alert-success">
                                                {{ session('success') }}
                                            </div>
                                        @endif

                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul class="mb-0">
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        <form method="post" action="{{ route('profile.update') }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label>Full Name <span class="required">*</span></label>
                                                    <input required class="form-control" name="name" type="text"
                                                        value="{{ old('name', auth()->user()->name) }}" />
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Phone Number</label>
                                                    <input class="form-control" name="phone"
                                                        value="{{ old('phone', auth()->user()->phone) }}" />
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>Email Address <span class="required">*</span></label>
                                                    <input required class="form-control" name="email" type="email"
                                                        value="{{ old('email', auth()->user()->email) }}" readonly />
                                                    <small class="text-muted">Email cannot be changed</small>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Bio</label>
                                                    <textarea class="form-control" name="bio" rows="4" placeholder="Tell us about yourself..."
                                                        style="min-height: 150px; resize: vertical;">{{ old('bio', auth()->user()->profile->bio ?? '') }}</textarea>
                                                    <small class="text-muted">Share a bit about yourself, your interests,
                                                        or your travel experiences.</small>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Country</label>
                                                    <input class="form-control" name="country"
                                                        value="{{ old('country', auth()->user()->profile->country ?? '') }}" />
                                                </div>
                                                {{-- <div class="form-group col-md-6">
                                                    <label>Preferred Language</label>
                                                    <select class="form-control" name="preferred_language">
                                                        <option value="id"
                                                            {{ old('preferred_language', auth()->user()->preferred_language) == 'id' ? 'selected' : '' }}>
                                                            Indonesian</option>
                                                        <option value="en"
                                                            {{ old('preferred_language', auth()->user()->preferred_language) == 'en' ? 'selected' : '' }}>
                                                            English</option>
                                                    </select>
                                                </div> --}}

                                                <!-- BUTTONS ROW -->
                                                <div class="modal-footer border-0 pt-0 pb-4 px-4">
                                                    <button type="button" class="btn-no-style" data-bs-toggle="modal"
                                                        data-bs-target="#changePasswordModal">
                                                        Change Password
                                                    </button>

                                                    <button type="submit" class="btn-no-style">
                                                        Save Changes
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- MY SUBSCRIPTION TAB -->
                            <div class="tab-pane fade {{ request('tab') == 'subscription' ? 'active show' : '' }}"
                                id="subscription" role="tabpanel">
                                <div class="card border-0 shadow-sm">
                                    <div
                                        class="card-header bg-white d-flex justify-content-between align-items-center border-bottom">
                                        <h5 class="mb-0 fw-bold text-dark">My Subscription</h5>
                                        @php
                                            $headerBadge = 'Expired';
                                            $headerBadgeClass = 'bg-danger text-white';
                                            $headerIcon = 'fi-rs-cross-circle';

                                            if ($user->hasActiveSubscription()) {
                                                $currentSub = $user->currentSubscription;
                                                $now = now();
                                                $hoursRemaining = $now->diffInHours($currentSub->end_date, false);

                                                if ($hoursRemaining > 24) {
                                                    // Active: More than 24 hours remaining
                                                    $headerBadge = 'Active';
                                                    $headerBadgeClass = 'bg-success';
                                                } elseif ($hoursRemaining > 0 && $hoursRemaining <= 12) {
                                                    // Soon Expired: Less than 12 hours remaining
                                                    $headerBadge = 'Soon Expired';
                                                    $headerBadgeClass = 'bg-warning text-dark';
                                                } elseif ($hoursRemaining <= 0) {
                                                    // Expired: Time has passed
                                                    $headerBadge = 'Expired';
                                                    $headerBadgeClass = 'bg-danger text-white';
                                                } else {
                                                    // Between 12-24 hours (still active but getting close)
                                                    $headerBadge = 'Active';
                                                    $headerBadgeClass = 'bg-success';
                                                }
                                            }
                                        @endphp
                                        <span class="badge {{ $headerBadgeClass }} rounded-pill px-3 py-2">
                                            {{ $headerBadge }}
                                        </span>
                                    </div>

                                    <div class="card-body">
                                        @if ($user->hasActiveSubscription())
                                            @php
                                                $sub = $user->currentSubscription;
                                                $plan = $sub->plan;
                                                $now = now();
                                                $start = $sub->start_date;
                                                $end = $sub->end_date;

                                                $totalSeconds = $start->diffInSeconds($end);
                                                $elapsedSeconds = $start->diffInSeconds($now->min($end));

                                                $progress =
                                                    $totalSeconds > 0
                                                        ? min(100, max(0, ($elapsedSeconds / $totalSeconds) * 100))
                                                        : 0;

                                                // Variables for upgrade/downgrade filtering
                                                $currentPlan = $plan;
                                                $currentDuration = $plan->duration_days ?? 0;

                                                // Compute upgrade/downgrade plans if subscriptionPlans is available
                                                if (isset($subscriptionPlans) && $subscriptionPlans) {
                                                    $upgradePlans = $subscriptionPlans->filter(function ($p) use ($currentDuration) {
                                                        return $p->duration_days > $currentDuration;
                                                    });
                                                    $downgradePlans = $subscriptionPlans->filter(function ($p) use ($currentDuration) {
                                                        return $p->duration_days < $currentDuration;
                                                    });
                                                } else {
                                                    $upgradePlans = collect();
                                                    $downgradePlans = collect();
                                                }
                                            @endphp

                                            <div class="row mb-4">
                                                <!-- Plan Info -->
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <h6 class="text-muted fw-normal mb-1">Plan</h6>
                                                        <p class="h5 mb-0">{{ $plan->name }}</p>
                                                    </div>
                                                    <div class="mb-3">
                                                        <h6 class="text-muted fw-normal mb-1">Period</h6>
                                                        @php
                                                            // Get payment record for this subscription to check payment_type
                                                            $subPayment = $user
                                                                ->payments()
                                                                ->where('subscription_id', $sub->id)
                                                                ->where('status', 'success')
                                                                ->first();

                                                            $paymentType = $subPayment
                                                                ? $subPayment->payment_type
                                                                : 'new';
                                                            $durationDays = $plan->duration_days;
                                                        @endphp

                                                        @if ($paymentType === 'renewal')
                                                            <p class="mb-0">
                                                                <span class="badge bg-info-subtle text-danger mb-1"
                                                                    style="border:1px solid #FF416C; border-radius: 100px; ">
                                                                    Renewed
                                                                </span><br>
                                                                Extended by <strong>{{ $durationDays }}
                                                                    day{{ $durationDays > 1 ? 's' : '' }}</strong><br>
                                                                <small class="text-muted">
                                                                    {{ $sub->start_date->format('d M Y H:i') }} –
                                                                    {{ $sub->end_date->format('d M Y H:i') }}
                                                                </small>
                                                            </p>
                                                        @elseif($paymentType === 'upgrade')
                                                            <p class="mb-0">
                                                                <span class="badge bg-primary-subtle text-primary mb-1"
                                                                    style="border:1px solid #5A97FA; border-radius: 100px;">
                                                                    Upgraded
                                                                </span><br>
                                                                Upgraded on
                                                                <strong>{{ $sub->start_date->format('d M Y H:i') }}</strong><br>
                                                                <small class="text-muted">
                                                                    Valid until {{ $sub->end_date->format('d M Y H:i') }}
                                                                </small>
                                                            </p>
                                                        @elseif($paymentType === 'downgrade')
                                                            <p class="mb-0">
                                                                <span class="badge text-white mb-1"
                                                                    style="background-color: #ff9800; border:1px solid #ff9800; border-radius: 100px;">
                                                                    Downgraded
                                                                </span><br>
                                                                Downgraded on
                                                                <strong>{{ $sub->start_date->format('d M Y H:i') }}</strong><br>
                                                                <small class="text-muted">
                                                                    Valid until {{ $sub->end_date->format('d M Y H:i') }}
                                                                </small>
                                                            </p>
                                                        @else
                                                            <p class="mb-0">
                                                                <span class="badge bg-success-subtle text-success mb-1">
                                                                    New Subscription
                                                                </span><br>
                                                                <strong>{{ $durationDays }}
                                                                    day{{ $durationDays > 1 ? 's' : '' }}</strong>
                                                                access<br>
                                                                <small class="text-muted">
                                                                    {{ $sub->start_date->format('d M Y H:i') }} –
                                                                    {{ $sub->end_date->format('d M Y H:i') }}
                                                                </small>
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>

                                                <!-- Financial Info -->
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <h6 class="text-muted fw-normal mb-1">Payment Method</h6>
                                                        <p class="mb-0">Mayar.id (QRIS / E-Wallet)</p>
                                                    </div>
                                                    <div class="mb-3">
                                                        <h6 class="text-muted fw-normal mb-1">Total Paid</h6>
                                                        <p class="h5 mb-0 text-danger">Rp
                                                            {{ number_format($sub->total_amount, 0, ',', '.') }}</p>
                                                    </div>
                                                    @php
                                                        $historyLines = $sub->notes
                                                            ? array_filter(explode("\n", trim($sub->notes)))
                                                            : [];
                                                    @endphp

                                                    @if (count($historyLines) > 0)
                                                        <div class="mb-3">
                                                            <h6 class="text-muted fw-normal mb-2">History</h6>
                                                            <div class="small text-muted"
                                                                style="max-height: 80px; overflow-y: auto;">
                                                                @foreach ($historyLines as $line)
                                                                    <div>• {{ trim($line) }}</div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Progress Bar -->
                                            <div class="mb-4">
                                                <div class="d-flex justify-content-between mb-2">
                                                    <small class="text-muted">Subscription Progress</small>
                                                    <small class="fw-medium">{{ round($progress) }}%</small>
                                                </div>
                                                <div class="progress rounded-pill" style="height: 8px;">
                                                    <div class="progress-bar bg-danger rounded-pill" role="progressbar"
                                                        style="width: {{ $progress }}%"
                                                        aria-valuenow="{{ $progress }}" aria-valuemin="0"
                                                        aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Action Buttons -->
                                            <div class="d-grid gap-2 d-md-flex mb-3">
                                                <!-- Renew Current Plan Button -->
                                                <form action="{{ route('subscription.renew') }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="custom-button custom-button--primary text-white px-4">
                                                        Renew Subscription
                                                    </button>
                                                </form>
                                            </div>

                                            <!-- Upgrade Options -->
                                            @if (isset($subscriptionPlans) && $subscriptionPlans->isNotEmpty())
                                                <!-- UPGRADE SECTION -->
                                                @if ($upgradePlans->isNotEmpty())
                                                    <div class="mt-4 pt-3 border-top">
                                                        <h6 class="fw-bold mb-3">
                                                            Upgrade to Higher Tier</h6>
                                                        <div class="row g-3">
                                                            @foreach ($upgradePlans as $upgradePlan)
                                                                <div class="col-lg-3 col-md-6">
                                                                    <div class="card border-success h-100">
                                                                        <div class="card-body d-flex flex-column">
                                                                                <small class="mb-2 fs-9">
                                                                                    {{ $upgradePlan->name }}
                                                                                </small>
                                                                            <p class="text-muted small mb-2">
                                                                                <i class="bi bi-calendar-check me-1"></i>
                                                                                {{ $upgradePlan->duration_days }} days
                                                                                access
                                                                            </p>
                                                                            <p class="h5 text-success mb-3">Rp
                                                                                {{ number_format($upgradePlan->price, 0, ',', '.') }}
                                                                            </p>
                                                                            <form
                                                                                action="{{ route('subscription.upgrade') }}"
                                                                                method="POST" class="mt-auto">
                                                                                @csrf
                                                                                <input type="hidden" name="plan_slug"
                                                                                    value="{{ $upgradePlan->slug }}">
                                                                                <button type="submit"
                                                                                    class="custom-button custom-button--primary text-white px-4 w-100">
                                                                                    Upgrade Now
                                                                                </button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif

                                                <!-- DOWNGRADE SECTION -->
                                                @if ($downgradePlans->isNotEmpty())
                                                    <div class="mt-4 pt-3 border-top">
                                                        <h6 class="fw-bold mb-3"><i class="fi fi-rs-arrow-down"
                                                                style="color: #ff9800;" me-2></i>Downgrade to Lower Tier
                                                        </h6>
                                                        <div class="row g-3">
                                                            @foreach ($downgradePlans as $downgradePlan)
                                                                <div class="col-lg-3 col-md-6">
                                                                    <div class="card border-warning h-100">
                                                                        <div class="card-body d-flex flex-column">
                                                                            <h6 class="mb-2">
                                                                                {{ $downgradePlan->name }}</h6>
                                                                            <p class="text-muted small mb-2">
                                                                                <i class="bi bi-calendar-check me-1"></i>
                                                                                {{ $downgradePlan->duration_days }} days
                                                                                access
                                                                            </p>
                                                                            <p class="h5 mb-3" style="color: #ff9800;">Rp
                                                                                {{ number_format($downgradePlan->price, 0, ',', '.') }}
                                                                            </p>
                                                                            <form
                                                                                action="{{ route('subscription.downgrade') }}"
                                                                                method="POST" class="mt-auto">
                                                                                @csrf
                                                                                <input type="hidden" name="plan_slug"
                                                                                    value="{{ $downgradePlan->slug }}">
                                                                                <button type="submit"
                                                                                    class="custom-button text-white px-4 w-100"
                                                                                    style="background-color: #ff9800; border-color: #ff9800;">
                                                                                    <i
                                                                                        class="fi fi-rs-arrow-down me-1"></i>
                                                                                    Downgrade Now
                                                                                </button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                        @else
                                            <!-- No Active Subscription -->
                                            <div class="text-center py-5">
                                                <div class="bg-light-subtle rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
                                                    style="width: 72px; height: 72px;">
                                                    <i class="fi fi-rs-lock fs-1 text-muted"></i>
                                                </div>
                                                <h5 class="mb-2">No Active Subscription</h5>
                                                <p class="text-muted mb-4">Get unlimited access to all premium ebooks</p>
                                                <a href="{{ route('pricing') }}"
                                                    class="custom-button custom-button--primary text-white px-4 mt-2">
                                                    <i class="fi fi-rs-shopping-cart me-1"></i> Choose a Plan
                                                </a>
                                            </div>
                                        @endif

                                        <!-- Payment History -->
                                        @if ($user->payments()->exists())
                                            <hr class="my-4">
                                            <h6 class="fw-bold mb-3">Payment History</h6>

                                            <!-- FORM SEARCH & FILTER -->
                                            <form method="GET" action="{{ route('page-account') }}" class="mb-4">
                                                <input type="hidden" name="tab" value="subscription">
                                                <div class="row g-3 align-items-end">
                                                    <!-- Search by Plan Name -->
                                                    <div class="col-md-4">
                                                        <label for="payment_search" class="form-label">Search by Plan Name</label>
                                                        <input type="text" class="form-control h-100" name="payment_search"
                                                            id="payment_search" placeholder="e.g., Daily, Weekly"
                                                            value="{{ request('payment_search') }}">
                                                    </div>

                                                    <!-- Filter by Status -->
                                                    <div class="col-md-3">
                                                        <label for="payment_status" class="form-label">Filter by Status</label>
                                                        <select name="payment_status" id="payment_status"
                                                            class="form-select form-select-md">
                                                            <option value="">All Statuses</option>
                                                            <option value="new" {{ request('payment_status') == 'new' ? 'selected' : '' }}>
                                                                New Member
                                                            </option>
                                                            <option value="renewal" {{ request('payment_status') == 'renewal' ? 'selected' : '' }}>
                                                                Renewal
                                                            </option>
                                                            <option value="upgrade" {{ request('payment_status') == 'upgrade' ? 'selected' : '' }}>
                                                                Upgrade
                                                            </option>
                                                            <option value="downgrade" {{ request('payment_status') == 'downgrade' ? 'selected' : '' }}>
                                                                Downgrade
                                                            </option>
                                                            <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>
                                                                Pending
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <!-- Sort by -->
                                                    <div class="col-md-3">
                                                        <label for="payment_sort" class="form-label">Sort by</label>
                                                        <select name="payment_sort" id="payment_sort"
                                                            class="form-select form-select-md">
                                                            <option value="latest" {{ request('payment_sort', 'latest') == 'latest' ? 'selected' : '' }}>
                                                                Latest
                                                            </option>
                                                            <option value="oldest" {{ request('payment_sort') == 'oldest' ? 'selected' : '' }}>
                                                                Oldest
                                                            </option>
                                                            <option value="name_asc" {{ request('payment_sort') == 'name_asc' ? 'selected' : '' }}>
                                                                Plan Name (A-Z)
                                                            </option>
                                                            <option value="name_desc" {{ request('payment_sort') == 'name_desc' ? 'selected' : '' }}>
                                                                Plan Name (Z-A)
                                                            </option>
                                                            <option value="amount_asc" {{ request('payment_sort') == 'amount_asc' ? 'selected' : '' }}>
                                                                Amount (Low to High)
                                                            </option>
                                                            <option value="amount_desc" {{ request('payment_sort') == 'amount_desc' ? 'selected' : '' }}>
                                                                Amount (High to Low)
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <!-- Search Button -->
                                                    <div class="col-md-2">
                                                        <button type="submit" class="btn-read-now text-white px-4 py-2 mt-2 w-100">
                                                            Search
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>

                                            <!-- Pagination Info -->
                                            @php
                                                $payments = $user->payments()->with(['plan', 'subscription'])->latest();

                                                // Apply search filter
                                                if (request('payment_search')) {
                                                    $payments = $payments->whereHas('plan', function($query) {
                                                        $query->where('name', 'like', '%' . request('payment_search') . '%');
                                                    });
                                                }

                                                // Apply status filter
                                                if (request('payment_status')) {
                                                    $filterStatus = request('payment_status');
                                                    if ($filterStatus === 'pending') {
                                                        // Filter by payment status 'pending'
                                                        $payments = $payments->where('status', 'pending');
                                                    } else {
                                                        // Filter by payment type (new, renewal, upgrade, downgrade)
                                                        $payments = $payments->where('payment_type', $filterStatus);
                                                    }
                                                }

                                                // Apply sorting
                                                $sort = request('payment_sort', 'latest');
                                                if ($sort === 'oldest') {
                                                    $payments = $payments->oldest();
                                                } elseif ($sort === 'name_asc') {
                                                    $payments = $payments->join('subscription_plans', 'payments.subscription_plan_id', '=', 'subscription_plans.id')
                                                        ->orderBy('subscription_plans.name', 'asc')
                                                        ->select('payments.*');
                                                } elseif ($sort === 'name_desc') {
                                                    $payments = $payments->join('subscription_plans', 'payments.subscription_plan_id', '=', 'subscription_plans.id')
                                                        ->orderBy('subscription_plans.name', 'desc')
                                                        ->select('payments.*');
                                                } elseif ($sort === 'amount_asc') {
                                                    $payments = $payments->orderBy('amount', 'asc');
                                                } elseif ($sort === 'amount_desc') {
                                                    $payments = $payments->orderBy('amount', 'desc');
                                                }

                                                // Paginate results (10 per page)
                                                $paymentsPaginated = $payments->paginate(10)->appends(request()->query());
                                            @endphp

                                            @if ($paymentsPaginated->count() > 0)
                                                <div class="table-responsive">
                                                    <table class="table table-hover align-middle">
                                                        <thead class="table-light px-3">
                                                            <tr>
                                                                <th scope="col" class="ps-3 py-3">Date</th>
                                                                <th scope="col" class="py-3">Plan</th>
                                                                <th scope="col" class="py-3">Amount</th>
                                                                <th scope="col" class="py-3 text-center">Status</th>
                                                                <th scope="col" class="py-3">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="px-3">
                                                            @foreach ($paymentsPaginated as $payment)
                                                                @php
                                                                    $sub = $payment->subscription;
                                                                    $now = now();
                                                                    $paymentType = $payment->payment_type ?? 'new';
                                                                    $durationDays = $payment->plan
                                                                        ? $payment->plan->duration_days
                                                                        : 0;

                                                                    // Determine status based on payment_type and subscription status
                                                                    $displayStatus = 'Unknown';
                                                                    $statusBadgeClass =
                                                                        'bg-secondary-subtle text-secondary';
                                                                    $statusIcon = 'fi-rs-question';

                                                                    if ($sub) {
                                                                        // Check if expired first
                                                                        $hoursRemaining = $now->diffInHours(
                                                                            $sub->end_date,
                                                                            false,
                                                                        );

                                                                        if ($hoursRemaining <= 0 && $sub->end_date < $now) {
                                                                            // Expired
                                                                            $displayStatus = 'Expired';
                                                                            $statusBadgeClass =
                                                                                'bg-danger-subtle text-danger';
                                                                        } elseif (
                                                                            $hoursRemaining > 0 &&
                                                                            $hoursRemaining <= 12
                                                                        ) {
                                                                            // Soon Expired (< 12 hours)
                                                                            $displayStatus = 'Soon Expired';
                                                                            $statusBadgeClass =
                                                                                'bg-warning-subtle text-warning';
                                                                        } elseif ($paymentType === 'renewal') {
                                                                            // Renewal
                                                                            $displayStatus = 'Renewed';
                                                                            $statusBadgeClass = 'bg-info-subtle text-info';
                                                                        } elseif ($paymentType === 'upgrade') {
                                                                            // Upgrade
                                                                            $displayStatus = 'Upgraded';
                                                                            $statusBadgeClass =
                                                                                'bg-primary-subtle text-primary';
                                                                        } elseif ($paymentType === 'downgrade') {
                                                                            // Downgrade
                                                                            $displayStatus = 'Downgraded';
                                                                            $statusBadgeClass = 'text-white';
                                                                        } else {
                                                                            // Active (new subscription)
                                                                            $displayStatus = 'Active';
                                                                            $statusBadgeClass =
                                                                                'bg-success-subtle text-success';
                                                                        }
                                                                    }
                                                                @endphp
                                                                <tr>
                                                                    <td class="ps-3 py-3">
                                                                        {{ $payment->created_at->format('d M Y') }}</td>
                                                                    <td class="py-3">
                                                                        <div>
                                                                            <strong>{{ $payment->plan?->name ?? '-' }}</strong><br>
                                                                            <small>
                                                                                @if ($sub)
                                                                                    @if ($paymentType === 'renewal')
                                                                                        Extended by <strong class="text-success">+{{ $durationDays }} day{{ $durationDays > 1 ? 's' : '' }}</strong>
                                                                                    @elseif ($paymentType === 'upgrade')
                                                                                        Extended by <strong class="text-success">+{{ $durationDays }} day{{ $durationDays > 1 ? 's' : '' }}</strong>
                                                                                    @elseif ($paymentType === 'downgrade')
                                                                                        Duration <strong class="text-warning">{{ $durationDays }} day{{ $durationDays > 1 ? 's' : '' }}</strong>
                                                                                    @else
                                                                                        Duration <strong class="text-success">{{ $durationDays }} day{{ $durationDays > 1 ? 's' : '' }}</strong>
                                                                                    @endif
                                                                                @else
                                                                                    {{-- For new subscription, show duration even without active subscription --}}
                                                                                    Duration <strong class="text-success">{{ $durationDays }} day{{ $durationDays > 1 ? 's' : '' }}</strong>
                                                                                @endif
                                                                            </small>
                                                                        </div>
                                                                    </td>
                                                                    <td class="py-3 fw-medium">Rp
                                                                        {{ number_format((float) $payment->amount, 0, ',', '.') }}
                                                                    </td>
                                                                    <td class="py-3 text-center">
                                                                        {{-- Status Display: Pending payments show "Pending + Operation Type", Paid show subscription status --}}
                                                                        <div
                                                                            class="d-flex align-items-center justify-content-center gap-2 flex-wrap">
                                                                            @if ($payment->status === 'pending')
                                                                                {{-- PENDING PAYMENT: Show "Pending + Operation Type" --}}
                                                                                <span
                                                                                    class="badge bg-warning-subtle text-warning rounded-pill px-2 py-1">
                                                                                    Pending
                                                                                </span>
                                                                                @if ($paymentType === 'renewal')
                                                                                    <span
                                                                                        class="badge bg-info-subtle text-info rounded-pill px-2 py-1">
                                                                                        Renewed
                                                                                    </span>
                                                                                @elseif ($paymentType === 'upgrade')
                                                                                    <span
                                                                                        class="badge bg-primary-subtle text-primary rounded-pill px-2 py-1">
                                                                                        Upgraded
                                                                                    </span>
                                                                                @elseif ($paymentType === 'downgrade')
                                                                                    <span
                                                                                        class="badge bg-primary-subtle text-warning rounded-pill px-2 py-1">
                                                                                        Downgraded
                                                                                    </span>
                                                                                @endif
                                                                            @else
                                                                                {{-- PAID PAYMENT: Show Paid + Subscription Status (or Paid + Operation Type) --}}
                                                                                @if ($paymentType === 'renewal')
                                                                                    <span
                                                                                        class="badge bg-success-subtle text-success rounded-pill px-2 py-1">
                                                                                        Paid
                                                                                    </span>
                                                                                    <span
                                                                                        class="badge bg-info-subtle text-info rounded-pill px-2 py-1">
                                                                                        Renewed
                                                                                    </span>
                                                                                @elseif ($paymentType === 'upgrade')
                                                                                    <span
                                                                                        class="badge bg-success-subtle text-success rounded-pill px-2 py-1">
                                                                                        Paid
                                                                                    </span>
                                                                                    <span
                                                                                        class="badge bg-primary-subtle text-primary rounded-pill px-2 py-1">
                                                                                        Upgraded
                                                                                    </span>
                                                                                @elseif ($paymentType === 'downgrade')
                                                                                    <span
                                                                                        class="badge bg-success-subtle text-success rounded-pill px-2 py-1">
                                                                                        Paid
                                                                                    </span>
                                                                                    <span
                                                                                        class="badge text-danger rounded-pill px-2 py-1">
                                                                                        Downgraded
                                                                                    </span>
                                                                                @else
                                                                                    {{-- For 'new' subscription, show subscription status if available --}}
                                                                                    <span
                                                                                        class="badge bg-success-subtle text-success rounded-pill px-2 py-1">
                                                                                        Paid
                                                                                    </span>

                                                                                    @if ($sub)
                                                                                        <span
                                                                                            class="badge {{ $statusBadgeClass }} rounded-pill px-2 py-1">
                                                                                            {{ $displayStatus }}
                                                                                        </span>
                                                                                    @elseif($payment->status === 'success')
                                                                                        <span
                                                                                            class="badge bg-primary-subtle text-primary rounded-pill px-2 py-1">
                                                                                            New Member
                                                                                        </span>
                                                                                    @endif
                                                                                @endif
                                                                            @endif
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        @if ($payment->status === 'success')
                                                                            <a href="{{ route('user.invoice.download', $payment) }}"
                                                                                download
                                                                                class="btn btn-sm"
                                                                                title="Download Invoice">
                                                                                <i class="bi bi-printer mt-1"></i>
                                                                            </a>
                                                                        @elseif ($payment->status === 'pending' && $payment->plan)
                                                                            {{-- Pending: Show link to payment gateway --}}
                                                                            <a href="{{ $payment->plan->mayar_payment_link }}"
                                                                                target="_blank" class="btn btn-sm"
                                                                                title="Continue Payment">
                                                                                <i class="bi bi-eye mt-1"></i>
                                                                            </a>
                                                                        @else
                                                                            <span class="text-muted small mt-1">—</span>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <!-- Pagination -->
                                                @if ($paymentsPaginated->hasPages())
                                                    <nav aria-label="Page navigation example" class="mt-4 mb-4">
                                                        <ul class="pagination justify-content-center">
                                                            {{-- Previous Page Link --}}
                                                            <li class="page-item {{ $paymentsPaginated->onFirstPage() ? 'disabled' : '' }}">
                                                                @if ($paymentsPaginated->onFirstPage())
                                                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                                                        <span aria-hidden="true">&laquo;</span>
                                                                    </a>
                                                                @else
                                                                    <a class="page-link" href="{{ $paymentsPaginated->previousPageUrl() }}" aria-label="Previous">
                                                                        <span aria-hidden="true">&laquo;</span>
                                                                    </a>
                                                                @endif
                                                            </li>

                                                            {{-- Pagination Elements --}}
                                                            @foreach ($paymentsPaginated->getUrlRange(1, $paymentsPaginated->lastPage()) as $page => $url)
                                                                <li class="page-item {{ $page == $paymentsPaginated->currentPage() ? 'active' : '' }}">
                                                                    @if ($page == $paymentsPaginated->currentPage())
                                                                        <a class="page-link" href="#">{{ $page }}</a>
                                                                    @else
                                                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                                                    @endif
                                                                </li>
                                                            @endforeach

                                                            {{-- Next Page Link --}}
                                                            <li class="page-item {{ !$paymentsPaginated->hasMorePages() ? 'disabled' : '' }}">
                                                                @if ($paymentsPaginated->hasMorePages())
                                                                    <a class="page-link" href="{{ $paymentsPaginated->nextPageUrl() }}" aria-label="Next">
                                                                        <span aria-hidden="true">&raquo;</span>
                                                                    </a>
                                                                @else
                                                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                                                        <span aria-hidden="true">&raquo;</span>
                                                                    </a>
                                                                @endif
                                                            </li>
                                                        </ul>
                                                    </nav>

                                                    <!-- Page Info -->
                                                    <div class="text-center text-muted small">
                                                        Showing {{ $paymentsPaginated->firstItem() }} to {{ $paymentsPaginated->lastItem() }} of {{ $paymentsPaginated->total() }} payments
                                                    </div>
                                                @endif
                                            @else
                                                <div class="text-center py-5">
                                                    <i class="fi fi-rs-search text-muted" style="font-size: 48px;"></i>
                                                    <h5 class="mt-3">No payments found</h5>
                                                    <p class="text-muted">Try adjusting your filters or search terms.</p>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- HELP CENTER TAB -->
                            <div class="tab-pane fade {{ request('tab') == 'help' ? 'active show' : '' }}"
                                id="help" role="tabpanel">
                                <div class="card border-0 shadow-sm rounded-3">
                                    <div class="card-header bg-white border-0 py-3">
                                        <h5 class="mb-0 fw-bold text-dark">Help & Support</h5>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="row g-4">
                                            <!-- CARD 1: Help Center -->
                                            <div class="col-lg-4 col-md-6">
                                                <a href="{{ route('help-center') }}" class="text-decoration-none">
                                                    <div class="card h-100 border-0 shadow-sm hover-card transition-all"
                                                        style="border-top: 3px solid #FF416C;">
                                                        <div class="card-body text-center p-4">
                                                            <div class="bg-light-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                                                style="width: 56px; height: 56px;">
                                                                <i class="fi fi-rs-book"
                                                                    style="font-size: 24px; color: #FF416C;"></i>
                                                            </div>
                                                            <h6 class="fw-bold mb-2">Help Center</h6>
                                                            <p class="text-muted small mb-0">
                                                                Step-by-step guides and tutorials
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>

                                            <!-- CARD 2: FAQs -->
                                            <div class="col-lg-4 col-md-6">
                                                <a href="{{ route('faq') }}" class="text-decoration-none">
                                                    <div class="card h-100 border-0 shadow-sm hover-card transition-all"
                                                        style="border-top: 3px solid #FF416C;">
                                                        <div class="card-body text-center p-4">
                                                            <div class="bg-light-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                                                style="width: 56px; height: 56px;">
                                                                <i class="bi bi-question-circle"
                                                                    style="font-size: 24px; color: #FF416C;"></i>
                                                            </div>
                                                            <h6 class="fw-bold mb-2">FAQs</h6>
                                                            <p class="text-muted small mb-0">
                                                                Quick answers to common questions
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>

                                            <!-- CARD 3: Contact Us -->
                                            <div class="col-lg-4 col-md-6">
                                                <a href="{{ route('contact') }}" class="text-decoration-none">
                                                    <div class="card h-100 border-0 shadow-sm hover-card transition-all"
                                                        style="border-top: 3px solid #FF416C;">
                                                        <div class="card-body text-center p-4">
                                                            <div class="bg-light-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                                                style="width: 56px; height: 56px;">
                                                                <i class="fi fi-rs-headset"
                                                                    style="font-size: 24px; color: #FF416C;"></i>
                                                            </div>
                                                            <h6 class="fw-bold mb-2">Contact Us</h6>
                                                            <p class="text-muted small mb-0">
                                                                Get direct support from our team
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- PAYMENT HISTORY TAB untuk NOT MEMBER -->
                            <div class="tab-pane fade {{ request('tab') == 'payment' ? 'active show' : '' }}"
                                id="payment" role="tabpanel">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header bg-white border-0 py-3">
                                        <h5 class="mb-0 fw-bold text-dark">Payment History</h5>
                                    </div>
                                    <div class="card-body">
                                        @if ($orders->count() > 0 || $user->subscriptions->count() > 0)
                                            <div class="row g-4">
                                                <!--  SUBSCRIPTION HISTORY -->
                                                @foreach ($user->subscriptions as $subscription)
                                                    <div class="col-12">
                                                        <div class="card h-100 border-0 shadow-sm transition-all"
                                                            style="border-left: 4px solid {{ $user->hasActiveSubscription() ? '#28a745' : '#6c757d' }};">
                                                            <div class="card-body">
                                                                <div
                                                                    class="d-flex justify-content-between align-items-start">
                                                                    <div>
                                                                        <div class="d-flex align-items-center mb-2">
                                                                            <span class="badge bg-light text-dark me-2"
                                                                                style="border: 1px solid {{ $user->hasActiveSubscription() ? '#28a745' : '#6c757d' }};">
                                                                                SUBSCRIPTION
                                                                            </span>
                                                                            <h6 class="mb-0 fw-bold">
                                                                                {{ $subscription->plan->name ?? 'Basic Plan' }}
                                                                            </h6>
                                                                        </div>
                                                                        <p class="mb-2">
                                                                            <i class="fi fi-rs-calendar me-1"></i>
                                                                            {{ $subscription->start_date?->format('d F Y') }}
                                                                            -
                                                                            {{ $subscription->end_date?->format('d F Y') }}
                                                                            @if (!$user->hasActiveSubscription() && $subscription->is_active)
                                                                                <span
                                                                                    class="badge bg-warning text-dark ms-2">Expired</span>
                                                                            @endif
                                                                        </p>
                                                                    </div>
                                                                    <div class="text-end">
                                                                        <!--  HARGA LEBIH KECIL -->
                                                                        <div class="fw-bold text-dark mb-1"
                                                                            style="font-size: 1.1rem; color: #FF416C;">
                                                                            Rp{{ number_format($subscription->plan->price, 0, ',', '.') }}
                                                                        </div>
                                                                        <!--  STATUS BENERAN -->
                                                                        @if ($user->hasActiveSubscription())
                                                                            <span class="badge bg-success">Active</span>
                                                                        @else
                                                                            <span class="badge bg-secondary">Expired</span>
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                                <div class="row mt-3">
                                                                    <div class="col-md-6">
                                                                        <small class="d-block mb-1">Payment Method</small>
                                                                        <span class="fw-medium">
                                                                            {{ $subscription->payment_method ?? 'Not specified' }}
                                                                        </span>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <small class="d-block mb-1">Transaction ID</small>
                                                                        <span class="fw-medium text-break">
                                                                            {{ $subscription->transaction_id ?? '-' }}
                                                                        </span>
                                                                    </div>
                                                                </div>

                                                                <!--  BUTTON SUBSCRIBE AGAIN -->
                                                                @if (!$user->hasActiveSubscription())
                                                                    <div
                                                                        class="mt-3 pt-3 border-top d-flex justify-content-end">
                                                                        <a href="{{ route('pricing') }}"
                                                                            class="custom-button custom-button--primary px-4 py-2">
                                                                            Subscribe Again
                                                                        </a>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach

                                                <!--  ORDER HISTORY -->
                                                @foreach ($orders as $order)
                                                    <div class="col-12">
                                                        <div class="card h-100 border-0 shadow-sm transition-all"
                                                            style="border-left: 4px solid {{ $order->status == 'completed' ? '#28a745' : ($order->status == 'pending' ? '#FFC107' : '#6c757d') }};">
                                                            <div class="card-body">
                                                                <div
                                                                    class="d-flex justify-content-between align-items-start">
                                                                    <div>
                                                                        <div class="d-flex align-items-center mb-2">
                                                                            <span class="badge bg-light text-dark me-2"
                                                                                style="border: 1px solid {{ $order->status == 'completed' ? '#28a745' : ($order->status == 'pending' ? '#FFC107' : '#6c757d') }};">
                                                                                ORDER
                                                                            </span>
                                                                            <h6 class="mb-0 fw-bold">Order
                                                                                #{{ $order->order_code ?? $order->id }}
                                                                            </h6>
                                                                        </div>
                                                                        <p class="text-muted mb-2">
                                                                            <i class="fi fi-rs-calendar me-1"></i>
                                                                            {{ $order->created_at->format('d F Y') }}
                                                                        </p>
                                                                    </div>
                                                                    <div class="text-end">
                                                                        <!--  HARGA LEBIH KECIL -->
                                                                        <div class="fw-bold text-dark mb-1"
                                                                            style="font-size: 1.1rem; color: #FF416C;">
                                                                            Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                                                                        </div>
                                                                        <span
                                                                            class="badge
                                            {{ $order->status == 'completed'
                                                ? 'bg-success'
                                                : ($order->status == 'pending'
                                                    ? 'bg-warning text-dark'
                                                    : 'bg-secondary') }}">
                                                                            {{ ucfirst($order->status) }}
                                                                        </span>
                                                                    </div>
                                                                </div>

                                                                <div class="mt-3">
                                                                    <small class="text-muted d-block mb-2">Items :</small>
                                                                    <div class="row g-2">
                                                                        @foreach ($order->items as $item)
                                                                            <div class="col-md-6">
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="{{ $item->ebook->cover_image_url ?: asset('assets/imgs/shop/product-1-1.jpg') }}"
                                                                                        alt="{{ $item->ebook->title }}"
                                                                                        class="rounded"
                                                                                        style="width: 40px; height: 40px; object-fit: cover;">
                                                                                    <div class="ms-2">
                                                                                        <div class="fw-medium">
                                                                                            {{ Str::limit($item->ebook->title, 25) }}
                                                                                        </div>
                                                                                        <small
                                                                                            class="text-muted">x{{ $item->quantity }}</small>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>

                                                                <div class="d-flex justify-content-between mt-3">
                                                                    <a href="#"
                                                                        class="btn btn-sm btn-outline-secondary">
                                                                        <i class="fi fi-rs-file-invoice me-1"></i> View
                                                                        Details
                                                                    </a>
                                                                    <!--  BUTTON SUBSCRIBE AGAIN -->
                                                                    @if (!$user->hasActiveSubscription())
                                                                        <a href="{{ route('pricing') }}"
                                                                            class="btn btn-sm"
                                                                            style="background: #FF416C; color: white; border-radius: 6px;">
                                                                            <i class="fi fi-rs-star me-1"></i> Subscribe
                                                                            Again
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="text-center py-5">
                                                <i class="fi fi-rs-credit-card"
                                                    style="font-size: 64px; color: #FF416C;"></i>
                                                <h5 class="mt-4 fw-bold text-dark">No Payment History</h5>
                                                <p class="text-muted mb-4">Your payment history will appear here after you
                                                    make a purchase or subscription.</p>
                                                <div class="d-flex justify-content-center gap-3">
                                                    <a href="{{ route('pricing') }}#pricing-plans"
                                                        class="custom-button custom-button--primary text-white px-4 py-2">
                                                        <i class="fi fi-rs-star me-1"></i> Subscribe Now
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- MY LIBRARY TAB -->
                            <div class="tab-pane fade {{ request('tab') == 'library' ? 'active show' : '' }}"
                                id="library" role="tabpanel">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0">My Library ({{ $allEbooks->count() }} ebooks)</h5>
                                    </div>
                                    <div class="card-body">
                                        <form method="GET" action="{{ route('page-account') }}" class="mb-4">
                                            <input type="hidden" name="tab" value="library">
                                            <div class="row g-3 align-items-end">
                                                <!-- Tambahkan align-items-end di row untuk meratakan semua elemen di bawah -->
                                                <div class="col-md-6">
                                                    <label for="search" class="form-label">Search by Title</label>
                                                    <input type="text" class="form-control h-100" name="search"
                                                        id="search" placeholder="e.g., Yogyakarta"
                                                        value="{{ request('search') }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="city_slug" class="form-label">Filter by City</label>
                                                    <select name="city_slug" id="city_slug"
                                                        class="form-select form-select-md">
                                                        <option value="">All Cities</option>
                                                        @foreach ($cities as $city)
                                                            <option value="{{ $city->slug }}"
                                                                {{ request('city_slug') == $city->slug ? 'selected' : '' }}>
                                                                {{ $city->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <!-- <label for="submit-search" class="form-label d-block invisible">&nbsp;</label> -->
                                                    <button type="submit" id="submit-search"
                                                        class="btn-read-now text-white px-4 py-2 mt-2">
                                                        <i class="fi fi-rs-search me-2 mt-1"></i>Search
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                        @if ($allEbooks->isNotEmpty())
                                            <!-- Grid 4 per baris -->
                                            <div class="row">
                                                @foreach ($allEbooks as $index => $ebook)
                                                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                                        <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn"
                                                            data-wow-delay="{{ ($index % 4) * 0.1 }}s">
                                                            <div class="product-img-action-wrap">
                                                                <div class="product-img product-img-zoom">
                                                                    <a href="/ebooks/{{ $ebook->slug }}">
                                                                        @php
                                                                            $coverImage = $ebook->external_cover_url
                                                                                ? $ebook->external_cover_url
                                                                                : $ebook->cover_image_url ??
                                                                                    'assets-nest/nest-fe/imgs/shop/product-1-1.jpg';
                                                                        @endphp
                                                                        <img class="default-img"
                                                                            src="{{ $coverImage }}"
                                                                            alt="{{ $ebook->title }}" />
                                                                    </a>
                                                                </div>
                                                                <div
                                                                    class="product-badges product-badges-position product-badges-mrg">
                                                                    <span
                                                                        class="badge-language hot">{{ strtoupper($ebook->language ?? 'ID') }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="product-content-wrap">
                                                                <!-- HILANGKAN INLINE STYLE, GUNAKAN CSS -->
                                                                <h2>
                                                                    <a
                                                                        href="/ebooks/{{ $ebook->slug }}">{{ Str::limit($ebook->title, 40) }}</a>
                                                                </h2>

                                                                <!-- HILANGKAN INLINE STYLE, GUNAKAN CSS -->
                                                                <div class="product-author">
                                                                    @if ($ebook->creator)
                                                                        <span>by
                                                                            {{ $ebook->creator->creator->pen_name ?? $ebook->creator->name }}</span>
                                                                    @else
                                                                        <span>by Unknown Author</span>
                                                                    @endif
                                                                </div>

                                                                <div class="product-meta">
                                                                    <div class="product-detail-rating">
                                                                        <div class="product-rate-cover text-end">
                                                                            <div class="product-rate-cover">
                                                                                <div class="product-rate d-inline-block">
                                                                                    <div class="product-rating"
                                                                                        style="width: {{ ($ebook->ratings()->avg('rating') / 5) * 100 }}%">
                                                                                    </div>
                                                                                </div>
                                                                                <span
                                                                                    class="font-small ml-5 text-muted">({{ round($ebook->ratings()->avg('rating') ?? 0, 1) }})</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="read-count">
                                                                        <i class="fi fi-rs-eye align-middle"></i>
                                                                        <span class="post-on">
                                                                            @php
                                                                                $views = $ebook->view_count;
                                                                                echo $views >= 1000000
                                                                                    ? number_format(
                                                                                            $views / 1000000,
                                                                                            1,
                                                                                        ) . 'M'
                                                                                    : ($views >= 1000
                                                                                        ? number_format(
                                                                                                $views / 1000,
                                                                                                1,
                                                                                            ) . 'k'
                                                                                        : $views);
                                                                            @endphp
                                                                        </span>
                                                                    </div>
                                                                </div>

                                                                @php
                                                                    $descriptionText = strip_tags(
                                                                        $ebook->short_description ??
                                                                            $ebook->description,
                                                                    );
                                                                    $isSingleLine = strlen($descriptionText) <= 29;
                                                                @endphp
                                                                <p
                                                                    class="product-description {{ $isSingleLine ? 'single-line' : '' }}">
                                                                    {{ Str::limit($descriptionText, 75) }}
                                                                </p>

                                                                <!-- PROGRESS BAR (jika sedang dibaca) -->
                                                                @php
                                                                    $reading = $userReadings[$ebook->id] ?? null;
                                                                    $progress = $reading
                                                                        ? $reading->progress_percentage
                                                                        : 0;
                                                                @endphp
                                                                @if ($progress > 0)
                                                                    <div class="progress mb-2" style="height: 6px;">
                                                                        <div class="progress-bar bg-success"
                                                                            role="progressbar"
                                                                            style="width: {{ $progress }}%">
                                                                        </div>
                                                                    </div>
                                                                    <small
                                                                        class="text-success">{{ number_format($progress, 0) }}%
                                                                        Complete</small>
                                                                @endif

                                                                @php
                                                                    $userReading = $userReadings[$ebook->id] ?? null;
                                                                    $lastPage = $userReading
                                                                        ? $userReading->last_page
                                                                        : 1;
                                                                    $progress = $userReading
                                                                        ? $userReading->progress_percentage
                                                                        : 0;
                                                                    $isReading = $progress > 0 && $progress < 100;
                                                                @endphp
                                                                <!-- TOMBOL AKSI -->
                                                                <a href="{{ route('user.ebook.read', $ebook->slug) }}"
                                                                    class="action-btn btn-read-now w-100 mt-2">
                                                                    <span>{{ $isReading ? 'Continue Reading' : 'Read Now' }}</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <!-- Periksa apakah sedang ada pencarian atau filter -->
                                            @if (request()->filled('search') || request()->filled('city_slug'))
                                                <!-- Jika ya, tampilkan pesan "Tidak Ditemukan" -->
                                                <div class="text-center py-5">
                                                    <i class="fi fi-rs-search text-muted" style="font-size: 64px;"></i>
                                                    <h4 class="mt-3">No E-books Found</h4>
                                                    <p class="text-muted">
                                                        We couldn't find any e-books matching your criteria.
                                                        @if (request()->filled('search'))
                                                            <br>Try searching for
                                                            "<strong>{{ request('search') }}</strong>" with different
                                                            keywords.
                                                        @endif
                                                    </p>
                                                    <a href="{{ route('page-account', ['tab' => 'library']) }}"
                                                        class="custom-button custom-button--primary text-white px-4 mt-2">
                                                        Clear Search
                                                    </a>
                                                </div>
                                            @else
                                                <!-- Jika tidak, tampilkan pesan "Perpustakaan Kosong" -->
                                                <div class="text-center py-5">
                                                    <i class="fi fi-rs-book text-muted" style="font-size: 64px;"></i>
                                                    <h4 class="mt-3">Your Library is Empty</h4>
                                                    <p class="text-muted">You have access to all ebooks — start exploring!
                                                    </p>
                                                    <a href="{{ route('destinations') }}"
                                                        class="custom-button custom-button--primary text-white px-4 mt-2">
                                                        <i class="fi fi-rs-search"></i> Browse All Ebooks
                                                    </a>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- READING HISTORY TAB -->
                            <div class="tab-pane fade {{ request('tab') == 'reading-history' ? 'active show' : '' }}"
                                id="reading-history" role="tabpanel">
                                <div class="card border-0 shadow-sm">
                                    <!-- Card Header with Title -->
                                    <div class="card-header bg-white border-0 py-3">
                                        <h5 class="mb-0 fw-bold text-dark">Reading History</h5>
                                    </div>

                                    <!-- Card Body -->
                                    <div class="card-body">
                                        <!-- FORM SEARCH & FILTER -->
                                        <form method="GET" action="{{ route('page-account') }}" class="mb-4">
                                            <input type="hidden" name="tab" value="reading-history">
                                            <div class="row g-3 align-items-end">
                                                <div class="col-md-6">
                                                    <label for="search" class="form-label">Search by Title</label>
                                                    <input type="text" class="form-control h-100" name="search"
                                                        id="search" placeholder="e.g., Yogyakarta"
                                                        value="{{ request('search') }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="city_slug" class="form-label">Filter by City</label>
                                                    <select name="city_slug" id="city_slug"
                                                        class="form-select form-select-md">
                                                        <option value="">All Cities</option>
                                                        @foreach ($cities as $city)
                                                            <option value="{{ $city->slug }}"
                                                                {{ request('city_slug') == $city->slug ? 'selected' : '' }}>
                                                                {{ $city->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="submit" class="btn-read-now text-white px-4 py-2 mt-2">
                                                        <i class="fi fi-rs-search me-2 mt-1"></i>Search
                                                    </button>
                                                </div>
                                            </div>
                                        </form>

                                        <!-- Content -->
                                        @if ($readingHistory->count() > 0)
                                            <div class="table-responsive">
                                                <table class="table align-middle">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 80px;">Cover</th>
                                                            <th>Ebook</th>
                                                            <th>Last Read</th>
                                                            <th>Progress</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($readingHistory as $reading)
                                                            @php
                                                                $progress = $reading->progress_percentage ?? 0;
                                                                $lastPage = $reading->last_page ?? 1;
                                                                $ebook = $reading->ebook;
                                                            @endphp
                                                            <tr>
                                                                <!--  FOTO COVER -->
                                                                <td>
                                                                    <div class="bg-light rounded"
                                                                        style="width: 60px; height: 80px;">
                                                                        @if ($ebook && $ebook->cover_image_url)
                                                                            <img src="{{ $ebook->cover_image_url }}"
                                                                                alt="{{ $ebook->title }}"
                                                                                class="img-fluid rounded"
                                                                                style="width: 60px; height: 80px; object-fit: cover;">
                                                                        @else
                                                                            <div
                                                                                class="d-flex align-items-center justify-content-center h-100 text-muted">
                                                                                <i class="fi fi-rs-book"></i>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </td>

                                                                <!--  JUDUL & AUTHOR -->
                                                                <td>
                                                                    @if ($ebook)
                                                                        <div class="fw-bold">
                                                                            {{ $ebook->title }}
                                                                        </div>
                                                                        <small class="text-muted">by
                                                                            {{ $ebook->creator?->pen_name ?? ($ebook->creator?->user?->name ?? 'Unknown') }}
                                                                        </small>
                                                                    @else
                                                                        <strong class="text-muted">E-book deleted</strong>
                                                                    @endif
                                                                </td>

                                                                <!--  LAST READ -->
                                                                <td>
                                                                    <small>{{ $reading->last_read_at?->format('d M Y H:i') ?? '-' }}</small>
                                                                </td>

                                                                <!--  PROGRESS -->
                                                                <td>
                                                                    <div class="d-flex align-items-center gap-2">
                                                                        <div class="progress"
                                                                            style="height: 8px; width: 80px; flex-shrink: 0;">
                                                                            <div class="progress-bar"
                                                                                style="width: {{ $progress }}%; background-color: #FF4C61;">
                                                                            </div>
                                                                        </div>
                                                                        <small
                                                                            class="text-nowrap">{{ number_format($progress, 0) }}%</small>
                                                                    </div>
                                                                </td>

                                                                <!--  ACTION -->
                                                                <td>
                                                                    @if ($ebook)
                                                                        <a href="{{ route('user.ebook.read', $ebook->slug) }}"
                                                                            class="custom-button custom-button--primary text-white px-4">
                                                                            Continue Reading
                                                                        </a>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            <!-- Pagination -->
                                            @if ($readingHistory->hasPages())
                                                <nav aria-label="Reading history pagination" class="mt-4 mb-4">
                                                    <ul class="pagination justify-content-center">
                                                        {{-- Previous Page Link --}}
                                                        <li class="page-item {{ $readingHistory->onFirstPage() ? 'disabled' : '' }}">
                                                            @if ($readingHistory->onFirstPage())
                                                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                                                    <span aria-hidden="true">&laquo;</span>
                                                                </a>
                                                            @else
                                                                <a class="page-link" href="{{ $readingHistory->previousPageUrl() }}" aria-label="Previous">
                                                                    <span aria-hidden="true">&laquo;</span>
                                                                </a>
                                                            @endif
                                                        </li>

                                                        {{-- Pagination Elements --}}
                                                        @foreach ($readingHistory->getUrlRange(1, $readingHistory->lastPage()) as $page => $url)
                                                            <li class="page-item {{ $page == $readingHistory->currentPage() ? 'active' : '' }}">
                                                                @if ($page == $readingHistory->currentPage())
                                                                    <a class="page-link" href="#">{{ $page }}</a>
                                                                @else
                                                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                                                @endif
                                                            </li>
                                                        @endforeach

                                                        {{-- Next Page Link --}}
                                                        <li class="page-item {{ !$readingHistory->hasMorePages() ? 'disabled' : '' }}">
                                                            @if ($readingHistory->hasMorePages())
                                                                <a class="page-link" href="{{ $readingHistory->nextPageUrl() }}" aria-label="Next">
                                                                    <span aria-hidden="true">&raquo;</span>
                                                                </a>
                                                            @else
                                                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                                                    <span aria-hidden="true">&raquo;</span>
                                                                </a>
                                                            @endif
                                                        </li>
                                                    </ul>
                                                </nav>

                                                <!-- Page Info -->
                                                <div class="text-center text-muted small">
                                                    Showing {{ $readingHistory->firstItem() }} to {{ $readingHistory->lastItem() }} of {{ $readingHistory->total() }} readings
                                                </div>
                                            @endif
                                        @else
                                            <div class="text-center py-5">
                                                <i class="fi fi-rs-history text-muted" style="font-size: 64px;"></i>
                                                <h4 class="mt-3">No Reading History Yet</h4>
                                                <p class="text-muted">Start reading ebooks to build your reading history
                                                </p>
                                                <a href="{{ route('page-account', ['tab' => 'library']) }}"
                                                    class="custom-button custom-button--primary text-white px-4 mt-2">Start
                                                    Reading</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- MY REVIEWS TAB -->
                            <div class="tab-pane fade {{ request('tab') == 'reviews' ? 'active show' : '' }}"
                                id="reviews" role="tabpanel">
                                <div class="card border-0 shadow-sm">
                                    <!-- Card Header with Title -->
                                    <div class="card-header bg-white border-0">
                                        <h5 class="mb-0 fw-bold text-dark">My Reviews</h5>
                                    </div>

                                    <!-- Card Body -->
                                    <div class="card-body">
                                        <!-- FORM SEARCH & FILTER -->
                                        <form method="GET" action="{{ route('page-account') }}" class="mb-4">
                                            <input type="hidden" name="tab" value="reviews">
                                            <div class="row g-3 align-items-end">
                                                <div class="col-md-6">
                                                    <label for="search" class="form-label">Search by Title</label>
                                                    <input type="text" class="form-control h-100" name="search"
                                                        id="search" placeholder="e.g., Bali Travel Guide"
                                                        value="{{ request('search') }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="city_slug" class="form-label">Filter by City</label>
                                                    <select name="city_slug" id="city_slug"
                                                        class="form-select form-select-md">
                                                        <option value="">All Cities</option>
                                                        @foreach ($cities as $city)
                                                            <option value="{{ $city->slug }}"
                                                                {{ request('city_slug') == $city->slug ? 'selected' : '' }}>
                                                                {{ $city->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="submit" class="btn-read-now text-white px-4 py-2 mt-2">
                                                        <i class="fi fi-rs-search me-2 mt-1"></i>Search
                                                    </button>
                                                </div>
                                            </div>
                                        </form>

                                        <!-- Content -->
                                        @if ($userRatings->count() > 0)
                                            <div class="row g-4">
                                                @foreach ($userRatings as $rating)
                                                    <div class="col-12">
                                                        <div class="card h-100">
                                                            <div class="row g-0 h-100"
                                                                style="margin-top:-15px; margin-bottom:-20px;">
                                                                <!--  COVER EBOOK DI KIRI -->
                                                                <div class="col-auto d-flex align-items-start"
                                                                    style="width: 140px; padding-right: 15px">
                                                                    <a href="{{ route('ebooks.show', $rating->ebook->slug) }}"
                                                                        class="d-block w-100">
                                                                        <img src="{{ $rating->ebook->cover_image_url ?: asset('assets/imgs/shop/product-1-1.jpg') }}"
                                                                            alt="{{ $rating->ebook->title }}"
                                                                            class="img-fluid rounded w-100"
                                                                            style="aspect-ratio: 2/3; object-fit: cover; border: 1px solid #e0e0e0; margin: 2rem -0.90rem -20px 1rem;">
                                                                    </a>
                                                                </div>

                                                                <div class="col d-flex flex-column">
                                                                    <div class="card-body">
                                                                        <div
                                                                            class="d-flex justify-content-between align-items-start mb-2">
                                                                            <div>
                                                                                <h6 class="card-title mb-1">
                                                                                    <a href="{{ route('ebooks.show', $rating->ebook->slug) }}"
                                                                                        class="text-decoration-none text-dark hover-underline"
                                                                                        style="color: #222;">
                                                                                        {{ Str::limit($rating->ebook->title, 60) }}
                                                                                    </a>
                                                                                </h6>
                                                                                <p class="mb-2 small">
                                                                                    <i class="fi fi-rs-user me-1"></i>
                                                                                    {{ $rating->ebook->author ?? 'Unknown Author' }}
                                                                                    •
                                                                                    {{ strtoupper($rating->ebook->language ?? 'ID') }}
                                                                                </p>
                                                                            </div>
                                                                            <div class="d-flex align-items-center gap-2">

                                                                                <!-- RATING -->
                                                                                <div class="rating">
                                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                                        <i class="fi fi-rs-star{{ $i <= $rating->rating ? ' text-danger' : ' text-muted' }}"
                                                                                            style="color: {{ $i <= $rating->rating ? '#FF416C' : '#ccc' }};"></i>
                                                                                    @endfor
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        @if ($rating->review_title)
                                                                            <h6 class="text-dark mb-2">
                                                                                {{ $rating->review_title }}</h6>
                                                                        @endif

                                                                        <div class="review-text-container"
                                                                            style="margin-top:-10px;"
                                                                            data-rating-id="{{ $rating->id }}">
                                                                            <p class="card-text review-text"
                                                                                data-rating-id="{{ $rating->id }}"
                                                                                style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; font-size: 0.95rem;">
                                                                                {{ $rating->review_text }}
                                                                            </p>

                                                                            @php
                                                                                $textLength = strlen(
                                                                                    $rating->review_text,
                                                                                );
                                                                                $shouldShowMore = $textLength > 180;
                                                                            @endphp

                                                                            @if ($shouldShowMore)
                                                                                <button type="button"
                                                                                    class="review-toggle-btn"
                                                                                    data-rating-id="{{ $rating->id }}"
                                                                                    style="background: none; border: none; color: #FF416C; font-weight: 600; padding: 0; font-size: 0.85rem; cursor: pointer; margin-bottom: 10px;">
                                                                                    More
                                                                                </button>
                                                                            @endif
                                                                        </div>

                                                                        <div class="d-flex justify-content-between align-items-center"
                                                                            style="margin-top: -10px;">
                                                                            <!--  TANGGAL + STATUS EDITED -->
                                                                            <small>
                                                                                <i class="fi fi-rs-calendar me-1"></i>
                                                                                {{ $rating->created_at->translatedFormat('d F Y') }}
                                                                                @if ($rating->updated_at && $rating->updated_at->gt($rating->created_at))
                                                                                    <span class="text-muted">(edited
                                                                                        {{ $rating->updated_at->format('d M') }})</span>
                                                                                @endif
                                                                            </small>

                                                                            <!--  ACTION BUTTONS -->
                                                                            <div class="d-flex gap-2">
                                                                                <button
                                                                                    class="custom-button custom-button--primary text-white px-3 py-1 mt-1"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editReviewModal-{{ $rating->id }}"
                                                                                    title="Edit review">
                                                                                    Edit
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- REUSABLE MODAL COMPONENT --}}
                                                    @include('components.edit-review-modal', [
                                                        'rating' => $rating,
                                                    ])
                                                @endforeach
                                            </div>

                                            <!-- Pagination -->
                                            @if ($userRatings->hasPages())
                                                <nav aria-label="Reviews pagination" class="mt-4 mb-4">
                                                    <ul class="pagination justify-content-center">
                                                        {{-- Previous Page Link --}}
                                                        <li class="page-item {{ $userRatings->onFirstPage() ? 'disabled' : '' }}">
                                                            @if ($userRatings->onFirstPage())
                                                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                                                    <span aria-hidden="true">&laquo;</span>
                                                                </a>
                                                            @else
                                                                <a class="page-link" href="{{ $userRatings->previousPageUrl() }}" aria-label="Previous">
                                                                    <span aria-hidden="true">&laquo;</span>
                                                                </a>
                                                            @endif
                                                        </li>

                                                        {{-- Pagination Elements --}}
                                                        @foreach ($userRatings->getUrlRange(1, $userRatings->lastPage()) as $page => $url)
                                                            <li class="page-item {{ $page == $userRatings->currentPage() ? 'active' : '' }}">
                                                                @if ($page == $userRatings->currentPage())
                                                                    <a class="page-link" href="#">{{ $page }}</a>
                                                                @else
                                                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                                                @endif
                                                            </li>
                                                        @endforeach

                                                        {{-- Next Page Link --}}
                                                        <li class="page-item {{ !$userRatings->hasMorePages() ? 'disabled' : '' }}">
                                                            @if ($userRatings->hasMorePages())
                                                                <a class="page-link" href="{{ $userRatings->nextPageUrl() }}" aria-label="Next">
                                                                    <span aria-hidden="true">&raquo;</span>
                                                                </a>
                                                            @else
                                                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                                                    <span aria-hidden="true">&raquo;</span>
                                                                </a>
                                                            @endif
                                                        </li>
                                                    </ul>
                                                </nav>

                                                <!-- Page Info -->
                                                <div class="text-center text-muted small">
                                                    Showing {{ $userRatings->firstItem() }} to {{ $userRatings->lastItem() }} of {{ $userRatings->total() }} reviews
                                                </div>
                                            @endif
                                        @else
                                            <div class="text-center py-5">
                                                <i class="fi fi-rs-star text-muted"
                                                    style="font-size: 64px; color: #FF416C;"></i>
                                                <h5 class="mt-4 fw-bold text-dark">No Reviews Yet</h5>
                                                <p class="text-muted mb-4">Share your thoughts by reviewing ebooks you've
                                                    read</p>
                                                <a href="{{ route('page-account') }}?tab=library"
                                                    class="custom-button custom-button--primary text-white px-4">
                                                    Browse Ebooks
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <script>
                                    // Handle all review toggle buttons
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const toggleButtons = document.querySelectorAll('.review-toggle-btn');

                                        toggleButtons.forEach(button => {
                                            button.addEventListener('click', function() {
                                                const ratingId = this.getAttribute('data-rating-id');
                                                const textElement = document.querySelector(
                                                    `.review-text[data-rating-id="${ratingId}"]`);

                                                if (textElement) {
                                                    const isCollapsed = this.textContent.trim() === 'More';

                                                    if (isCollapsed) {
                                                        // Expand text
                                                        textElement.style.webkitLineClamp = 'unset';
                                                        textElement.style.webkitBoxOrient = 'unset';
                                                        textElement.style.overflow = 'visible';
                                                        textElement.style.textOverflow = 'clip';
                                                        textElement.style.display = 'block';
                                                        this.textContent = 'Less';
                                                    } else {
                                                        // Collapse text
                                                        textElement.style.webkitLineClamp = '3';
                                                        textElement.style.webkitBoxOrient = 'vertical';
                                                        textElement.style.overflow = 'hidden';
                                                        textElement.style.textOverflow = 'ellipsis';
                                                        textElement.style.display = '-webkit-box';
                                                        this.textContent = 'More';
                                                    }
                                                }
                                            });
                                        });
                                    });
                                </script>
                                <!-- CREATOR TAB -->
                                <!-- <div class="tab-pane fade {{ request('tab') == 'creator' ? 'active show' : '' }}" id="creator"
                                                        role="tabpanel">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="mb-0">Creator Dashboard</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                @if (auth()->user()->isCreator())
                                                                @if (isset($createdEbooks) && $createdEbooks->count() > 0)
                                                                <div class="row mb-4">
                                                                    <div class="col-md-3 mb-3">
                                                                        <div class="text-center p-3 border rounded">
                                                                            <h4 class="text-primary">{{ $createdEbooks->count() }}</h4>
                                                                            <p class="mb-0">Published Ebooks</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 mb-3">
                                                                        <div class="text-center p-3 border rounded">
                                                                            <h4 class="text-success">{{ $createdEbooks->sum('view_count') }}</h4>
                                                                            <p class="mb-0">Total Views</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 mb-3">
                                                                        <div class="text-center p-3 border rounded">
                                                                            <h4 class="text-warning">{{ $createdEbooks->sum('read_count') }}</h4>
                                                                            <p class="mb-0">Total Reads</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 mb-3">
                                                                        <div class="text-center p-3 border rounded">
                                                                            <h4 class="text-info">{{ $createdEbooks->sum('total_reviews') }}</h4>
                                                                            <p class="mb-0">Total Reviews</p>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <h6>Your Published Ebooks</h6>
                                                                <div class="row">
                                                                    @foreach ($createdEbooks as $ebook)
    <div class="col-md-4 mb-4">
                                                                        <div class="card h-100">
                                                                            <img src="@if ($ebook->cover_image && filter_var($ebook->cover_image, FILTER_VALIDATE_URL)) {{ $ebook->cover_image }}@elseif($ebook->cover_image){{ asset('storage/' . $ebook->cover_image) }}@else{{ asset('images/ebook-placeholder.webp') }} @endif"
                                                                                class="card-img-top" alt="{{ $ebook->title }}"
                                                                                style="height: 200px; object-fit: cover;">
                                                                            <div class="card-body">
                                                                                <h6 class="card-title">{{ $ebook->title }}</h6>
                                                                                <p class="card-text small text-muted">
                                                                                    {{ $ebook->short_description }}
                                                                                </p>
                                                                                <div class="mb-2">
                                                                                    @foreach ($ebook->categories as $category)
    <span>{{ $category->name }}</span>
    @endforeach
                                                                                </div>
                                                                                <div class="d-flex justify-content-between small text-muted">
                                                                                    <span>Views: {{ $ebook->view_count }}</span>
                                                                                    <span>Reads: {{ $ebook->read_count }}</span>
                                                                                    <span>Rating: {{ $ebook->average_rating }}/5</span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="card-footer bg-transparent">
                                                                                <div class="d-flex gap-2">
                                                                                    <button class="btn btn-sm">Edit</button>
                                                                                    <button class="custom-button custom-button--primary text-white px-4">Stats</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
    @endforeach
                                                                </div>
@else
    <div class="text-center py-4">
                                                                    <i class="fi fi-rs-edit text-muted" style="font-size: 48px;"></i>
                                                                    <h5 class="mt-3">No Published Ebooks Yet</h5>
                                                                    <p class="text-muted">Start creating and publishing your ebooks</p>
                                                                    <button class="custom-button custom-button--primary text-white px-4">Create Your First Ebook</button>
                                                                </div>
                                                                @endif
@else
    <div class="text-center py-4">
                                                                    <i class="fi fi-rs-edit text-muted" style="font-size: 48px;"></i>
                                                                    <h5 class="mt-3">Become a Creator</h5>
                                                                    <p class="text-muted">Start sharing your knowledge by creating ebooks</p>
                                                                    <button class="custom-button custom-button--primary text-white px-4">Apply as Creator</button>
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </main>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header"
                    style="background: linear-gradient(135deg, #FF4C61 0%, #FF416C 100%); border-bottom: none;">
                    <h5 class="modal-title text-white" id="changePasswordModalLabel">
                        Password
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('account.password.update') }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-body p-4">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Current Password <span
                                    class="text-danger">*</span></label>
                            <input type="password" class="form-control form-control-lg" name="current_password" required
                                placeholder="Enter your current password">
                            <div class="form-text">We need your current password to confirm your identity.</div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">New Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control form-control-lg" name="new_password" required
                                placeholder="Enter new password">
                            <div class="form-text">Minimum 6 characters with letters and numbers.</div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Confirm New Password <span
                                    class="text-danger">*</span></label>
                            <input type="password" class="form-control form-control-lg" name="new_password_confirmation"
                                required placeholder="Confirm your new password">
                            <div class="form-text">Re-enter your new password for confirmation.</div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 px-4 pb-4 pt-0">
                        <button type="button" class="custom-button custom-button--primary text-white px-4 mt-2"
                            data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="custom-button custom-button--primary text-white px-4 mt-2">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- SOLUSI PREVIEW: JavaScript yang lebih andal --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const avatarInput = document.getElementById('avatar_input');
            const avatarPreview = document.getElementById('avatar-preview');

            if (avatarInput && avatarPreview) {
                avatarInput.addEventListener('change', function(event) {
                    const file = event.target.files[0];

                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            avatarPreview.src = e.target.result;
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Pilih semua elemen dengan class 'alert' (termasuk alert-success dan alert-danger)
            const alerts = document.querySelectorAll('.alert');

            // Loop melalui setiap alert yang ditemukan
            alerts.forEach(function(alert) {
                // Set timer untuk 5 detik (5000 milidetik)
                setTimeout(function() {
                    // Tambahkan class untuk efek fade-out
                    alert.classList.add('alert-fade-out');

                    // Setelah transisi selesai (0.5 detik), hapus elemen dari DOM
                    setTimeout(function() {
                        alert.remove();
                    }, 500);
                }, 5000); // 5000 milidetik = 5 detik
            });
        });
    </script>
    <script>
        function handleAccountLogout() {
            const form = document.getElementById('nav-logout-form');
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
                        window.location.href = '/login';
                    } else {
                        throw new Error('Logout failed');
                    }
                })
                .catch(error => {
                    console.log('Logout error, redirecting to login', error);
                    window.location.href = '/login';
                });
        }
    </script>
    <script>
        function downloadInvoice(paymentId = null) {
            // 📝 Replace with actual PDF generation later
            alert('Invoice download will be implemented.\nPayment ID: ' + (paymentId || 'latest'));
        }
    </script>
    <script>
        function toggleMenu(e, targetId) {
            e.preventDefault();
            const target = document.getElementById(targetId);
            const btn = e.currentTarget;
            btn.classList.toggle('rotated');
            target.style.display = target.style.display === 'block' ? 'none' : 'block';
        }

        // Auto-buka menu aktif
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.js-submenu').forEach(menu => {
                if (menu.querySelector('.active')) {
                    const btn = menu.previousElementSibling;
                    if (btn) {
                        btn.classList.add('rotated');
                        menu.style.display = 'block';
                    }
                }
            });
        });
    </script>
    <script>
        function updateReview(event, ratingId) {
            event.preventDefault();

            const form = document.getElementById(`editReviewForm-${ratingId}`);
            const saveBtn = document.getElementById(`saveBtn-${ratingId}`);
            const originalText = saveBtn.innerHTML;

            // Ambil nilai
            const reviewText = form.querySelector('[name="review_text"]').value;
            const rating = form.querySelector('[name="rating"]').value;

            // Validasi
            if (!reviewText.trim()) {
                alert('Review text is required');
                return;
            }

            // Ambil CSRF token dengan aman
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                alert('CSRF token missing. Please refresh the page.');
                return;
            }

            saveBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';
            saveBtn.disabled = true;

            fetch(`/account/reviews/${ratingId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken.content
                    },
                    body: JSON.stringify({
                        review_text: reviewText,
                        rating: rating
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        bootstrap.Modal.getInstance(document.getElementById(`editReviewModal-${ratingId}`)).hide();
                        alert('Review updated successfully!');
                        location.reload();
                    } else {
                        throw new Error(data.message || 'Update failed');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to update review. Please try again.');
                })
                .finally(() => {
                    saveBtn.innerHTML = originalText;
                    saveBtn.disabled = false;
                });
        }
    </script>
@endsection
