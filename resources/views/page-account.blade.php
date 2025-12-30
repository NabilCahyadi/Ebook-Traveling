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
        padding-top: 140%; /* Rasio 5:7 (tinggi 140% dari lebar) untuk cover buku */
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
<main class="main pages">
    <div class="page-header mt-30 mb-30">
        <div class="container">
            <div class="archive-header">
                <div class="row align-items-center">
                    <div class="col-xl-3">
                        <h1 class="mb-15">My Account</h1>
                        <div class="breadcrumb">
                            <a href="/" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
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
                    <div class="dashboard-menu">
                        <ul class="nav flex-column" role="tablist">
                            <!-- ========== MENU KHUSUS PREMIUM MEMBER ========== -->
                            @if(auth()->user()->hasActiveSubscription())
                            <li class="nav-item">
                                <a class="nav-link {{ request('tab') == 'library' ? 'active' : '' }}"
                                    href="{{ route('page-account') }}?tab=library">
                                    <i class="fi-rs-book mr-10"></i>My Library
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request('tab') == 'reading-history' ? 'active' : '' }}"
                                    href="{{ route('page-account') }}?tab=reading-history">
                                    <i class="bi-clock-history mr-10"></i>Reading History
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request('tab') == 'reviews' ? 'active' : '' }}"
                                    href="{{ route('page-account') }}?tab=reviews">
                                    <i class="fi-rs-star mr-10"></i>My Reviews
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request('tab') == 'subscription' ? 'active' : '' }}"
                                    href="{{ route('page-account') }}?tab=subscription">
                                    <i class="fi-rs-crown mr-10"></i>My Subscription
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request('tab') == 'help' ? 'active' : '' }}"
                                    href="{{ route('page-account') }}?tab=help">
                                    <i class="fi-rs-interactive mr-10"></i>Help Center
                                </a>
                            </li>
                            @endif

                            <!-- ========== MENU UNTUK SEMUA USER (DILUAR IF-ELSE) ========== -->
                            <li class="nav-item">
                                <a class="nav-link {{ request('tab', 'dashboard') == 'dashboard' ? 'active' : '' }}"
                                    href="{{ route('page-account') }}?tab=dashboard">
                                    <i class="fi-rs-settings-sliders mr-10"></i>Dashboard Member
                                </a>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link {{ request('tab') == 'wishlist' ? 'active' : '' }}"
                                    href="{{ route('page-account') }}?tab=wishlist">
                                    <i class="fi fi-rs-heart mr-10"></i>Wishlist
                                    @if($wishlistCount > 0)
                                    <span class="badge bg-primary ms-1">{{ $wishlistCount }}</span>
                                    @endif
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request('tab') == 'creator' ? 'active' : '' }}"
                                    href="{{ route('page-account') }}?tab=creator">
                                    <i class="fi-rs-edit mr-10"></i>Creator
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request('tab') == 'account-detail' ? 'active' : '' }}"
                                    href="{{ route('page-account') }}?tab=account-detail">
                                    <i class="fi-rs-user mr-10"></i>Profile Settings
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request('tab') == 'payment' ? 'active' : '' }}"
                                    href="{{ route('page-account') }}?tab=payment">
                                    <i class="fi-rs-credit-card mr-10"></i>Payment History
                                    @if($ordersCount > 0)
                                    <span class="badge bg-success ms-1">{{ $ordersCount }}</span>
                                    @endif
                                </a>
                            </li>

                            <!-- ========== LOGOUT (SEMUA USER) ========== -->
                            <li class="nav-item mt-auto">
                                <a class="nav-link text-danger" href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fi-rs-sign-out mr-10"></i>Logout
                                </a>
                                <form id="logout-form" action="{{ route('user.logout') }}" method="POST" class="d-none">
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
                            @if(auth()->user()->hasActiveSubscription())
                            <!-- TAMPILAN UNTUK USER PREMIUM -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="mb-0">Hello {{ auth()->user()->name }}!</h3>
                                    <small>Premium Member since {{ auth()->user()->created_at->format('M Y') }}</small>
                                </div>
                            </div>
                            @else
                            <!-- TAMPILAN UNTUK USER NON-PREMIUM -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="mb-0">Hello {{ auth()->user()->name }}!</h3>
                                    <small class="text-muted">Member since
                                        {{ auth()->user()->created_at->format('M Y') }}</small>
                                </div>
                                <div class="card-body">
                                    <div class="alert alert-info border-0"
                                        style="background: #e3f2fd; border-left: 4px solid #2196F3;">
                                        <h5 class="alert-heading">Upgrade to Premium!</h5>
                                        <p class="mt-4">Unlock exclusive features and access our complete ebook library
                                            by subscribing to our <u><a href="{{route('pricing')}}">premium
                                                    plan</a>.</u>
                                            Get unlimited access to all ebooks, advanced features, and priority support.
                                            Enjoy a limited-time <u><a href="{{route('promo')}}">exclusive offer</a></u>
                                            <strong>don't miss out!</strong>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- WISHLIST TAB -->
                        <div class="tab-pane fade {{ request('tab') == 'orders' ? 'active show' : '' }}" id="orders"
                            role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Your Wishlist</h5>
                                </div>
                                <div class="card-body">
                                    @if($wishlistItems->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Ebook</th>
                                                    <th>Category</th>
                                                    <th>Price</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($wishlistItems as $item)
                                                <tr>
                                                    <td>{{ $item->ebook->title ?? 'Unknown Book' }}</td>
                                                    <td>
                                                        @if(isset($item->ebook->categories) &&
                                                        $item->ebook->categories->count() > 0)
                                                        @foreach($item->ebook->categories as $category)
                                                        <span class="badge bg-secondary">{{ $category->name }}</span>
                                                        @endforeach
                                                        @else
                                                        <span class="text-muted">No category</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(isset($item->ebook->price))
                                                        @if($item->ebook->price == 0)
                                                        <span class="text-success">Free</span>
                                                        @else
                                                        ${{ number_format($item->ebook->price, 2) }}
                                                        @endif
                                                        @else
                                                        <span class="text-muted">N/A</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(isset($item->ebook->price) && $item->ebook->price == 0)
                                                        <a href="#" class="btn-small d-block">Read Now</a>
                                                        @else
                                                        <a href="#" class="btn-small d-block">Buy Now</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @else
                                    <div class="text-center py-4">
                                        <i class="fi fi-rs-heart text-muted" style="font-size: 48px;"></i>
                                        <h5 class="mt-3">No saved books yet</h5>
                                        <p class="text-muted">Start exploring our ebooks and add them to your wishlist!
                                        </p>
                                        <a href="{{ route('destinations') }}" class="btn btn-custom">Browse
                                            Ebooks</a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- PROFILE SETTINGS TAB -->
                        <div class="tab-pane fade {{ request('tab') == 'account-detail' ? 'active show' : '' }}"
                            id="account-detail" role="tabpanel">
                            {{-- Tambahkan ini di bagian atas untuk debugging --}}
                            @if($errors->any())
                            <div class="alert alert-danger">
                                <strong>Ada kesalahan:</strong>
                                <ul>
                                    @foreach($errors->all() as $error)
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
                                    @if(session('avatar_success'))
                                    <div class="alert alert-success">
                                        {{ session('avatar_success') }}
                                    </div>
                                    @endif

                                    <form method="POST" action="{{ route('account.update.avatar') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row align-items-center">
                                            <div class="col-md-3 text-center">
                                                <label for="avatar_input" style="cursor: pointer;">
                                                    {{-- SOLUSI CACHE-BUSTING: Tambahkan ?t={{ time() }} --}}
                                                    <img id="avatar-preview"
                                                        src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) . '?t=' . auth()->user()->updated_at->timestamp : asset('/images/user-avatar.png') }}"
                                                        alt="Avatar Preview"
                                                        class="img-fluid rounded-circle"
                                                        style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #e9ecef;">
                                                    <p class="mt-2 mb-0"><small>Click to change photo.</small></p>
                                                </label>
                                                <input type="file" id="avatar_input" name="avatar" class="form-control d-none" accept="image/*">
                                            </div>
                                            <div class="col-md-9">
                                                <p class="mb-2">Upload a new profile photo. Supported formats: JPEG, PNG, JPG, GIF. Maximum size: 2MB.</p>
                                                <button type="submit" class="btn">
                                                    <i class="fi-rs-camera mr-5"></i> Update Picture
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
                                    @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                    @endif

                                    @if($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach($errors->all() as $error)
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
                                            <div class="form-group col-md-12">
                                                <label>Bio</label>
                                                <textarea class="form-control" name="bio" rows="3"
                                                    placeholder="Tell us about yourself...">{{ old('bio', auth()->user()->profile->bio ?? '') }}</textarea>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Country</label>
                                                <input class="form-control" name="country"
                                                    value="{{ old('country', auth()->user()->profile->country ?? '') }}" />
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Preferred Language</label>
                                                <select class="form-control" name="preferred_language">
                                                    <option value="id"
                                                        {{ (old('preferred_language', auth()->user()->preferred_language) == 'id') ? 'selected' : '' }}>
                                                        Indonesian</option>
                                                    <option value="en"
                                                        {{ (old('preferred_language', auth()->user()->preferred_language) == 'en') ? 'selected' : '' }}>
                                                        English</option>
                                                </select>
                                            </div>

                                            <!-- BUTTONS ROW -->
                                            <div class="col-md-12 mt-4">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <button type="submit" class="btn px-4 py-2"
                                                        style="background: linear-gradient(135deg, #FF4C61 0%, #FF416C 100%); border: none; border-radius: 8px;">
                                                        Save Changes
                                                    </button>

                                                    <button type="button" class="btn btn-outline-primary px-4 py-2"
                                                        data-bs-toggle="modal" data-bs-target="#changePasswordModal"
                                                        style="border: 2px solid #FF4C61; color: #FF4C61; border-radius: 8px; background: white;">
                                                        Change Password
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- PAYMENT HISTORY TAB -->
                        <div class="tab-pane fade {{ request('tab') == 'payment' ? 'active show' : '' }}" id="payment"
                            role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Payment History</h5>
                                </div>
                                <div class="card-body">
                                    @if($orders->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Date</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($orders as $order)
                                                <tr>
                                                    <td>#{{ $order->order_code ?? $order->id }}</td>
                                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                                    <td>${{ number_format($order->total_amount, 2) }}</td>
                                                    <td>
                                                        @if($order->status == 'completed')
                                                        <span class="badge bg-success">Paid</span>
                                                        @elseif($order->status == 'pending')
                                                        <span class="badge bg-warning">Pending</span>
                                                        @else
                                                        <span
                                                            class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                                                        @endif
                                                    </td>
                                                    <td><a href="#" class="btn-small d-block">View Details</a></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @else
                                    <div class="text-center py-4">
                                        <i class="fi-rs-credit-card text-muted" style="font-size: 48px;"></i>
                                        <h5 class="mt-3">No payment history yet</h5>
                                        <p class="text-muted">Your payment history will appear here after you make a
                                            purchase.</p>
                                        <a href="{{ route('destinations') }}" class="btn btn-custom">Browse
                                            Ebooks</a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- MY LIBRARY TAB -->
                        <div class="tab-pane fade {{ request('tab') == 'library' ? 'active show' : '' }}" id="library" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">My Library ({{ $allEbooks->count() }} ebooks)</h5>
                                </div>
                                <div class="card-body">
                                    <!-- resources/views/page-account.blade.php -->

                                    <form method="GET" action="{{ route('page-account') }}" class="mb-4">
                                        <input type="hidden" name="tab" value="library">
                                        <div class="row g-3 align-items-end"> <!-- Tambahkan align-items-end di row untuk meratakan semua elemen di bawah -->
                                            <div class="col-md-6">
                                                <label for="search" class="form-label">Search by Title</label>
                                                <input type="text" class="form-control h-100" name="search" id="search" placeholder="e.g., Yogyakarta" value="{{ request('search') }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="city_slug" class="form-label">Filter by City</label>
                                                <select name="city_slug" id="city_slug" class="form-select form-select-md">
                                                    <option value="">All Cities</option>
                                                    @foreach($cities as $city)
                                                    <option value="{{ $city->slug }}" {{ request('city_slug') == $city->slug ? 'selected' : '' }}>
                                                        {{ $city->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <!-- <label for="submit-search" class="form-label d-block invisible">&nbsp;</label> -->
                                                <button type="submit" id="submit-search" class="btn px-4 py-2">
                                                    <i class="fi-rs-search me-2"></i>Search
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    @if($allEbooks->isNotEmpty())
                                    <!-- Grid 4 per baris -->
                                    <div class="row">
                                        @foreach($allEbooks as $index => $ebook)
                                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                            <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn" data-wow-delay="{{ ($index % 4) * 0.1 }}s">
                                                <div class="product-img-action-wrap">
                                                    <div class="product-img product-img-zoom">
                                                        <a href="/ebooks/{{ $ebook->slug }}">
                                                            @php
                                                                $coverImage = $ebook->external_cover_url 
                                                                    ? $ebook->external_cover_url 
                                                                    : ($ebook->cover_image_url ?? 'assets-nest/nest-fe/imgs/shop/product-1-1.jpg');
                                                            @endphp
                                                            <img class="default-img"
                                                                src="{{ $coverImage }}"
                                                                alt="{{ $ebook->title }}" />
                                                        </a>
                                                    </div>
                                                    <div class="product-badges product-badges-position product-badges-mrg">
                                                        <span class="badge-language hot">{{ strtoupper($ebook->language ?? 'ID') }}</span>
                                                    </div>
                                                </div>
                                                <div class="product-content-wrap">
                                                    <!-- HILANGKAN INLINE STYLE, GUNAKAN CSS -->
                                                    <h2>
                                                        <a href="/ebooks/{{ $ebook->slug }}">{{ Str::limit($ebook->title, 40) }}</a>
                                                    </h2>

                                                    <!-- HILANGKAN INLINE STYLE, GUNAKAN CSS -->
                                                    <div class="product-author">
                                                        @if($ebook->creator)
                                                        <span>by {{ $ebook->creator->creator->pen_name ?? $ebook->creator->name }}</span>
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
                                                                            style="width: {{ ($ebook->ratings()->avg('rating') / 5) * 100 }}%"></div>
                                                                    </div>
                                                                    <span class="font-small ml-5 text-muted">({{ round($ebook->ratings()->avg('rating') ?? 0, 1) }})</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="read-count">
                                                            <i class="fi-rs-eye align-middle"></i>
                                                            <span class="post-on">
                                                                @php
                                                                $views = $ebook->view_count;
                                                                echo $views >= 1000000 ? number_format($views / 1000000, 1).'M'
                                                                : ($views >= 1000 ? number_format($views / 1000, 1).'k' : $views);
                                                                @endphp
                                                            </span>
                                                        </div>
                                                    </div>

                                                    @php
                                                    $descriptionText = strip_tags($ebook->short_description ?? $ebook->description);
                                                    $isSingleLine = strlen($descriptionText) <= 29;
                                                        @endphp
                                                        <p class="product-description {{ $isSingleLine ? 'single-line' : '' }}">
                                                        {{ Str::limit($descriptionText, 75) }}
                                                        </p>

                                                        <!-- PROGRESS BAR (jika sedang dibaca) -->
                                                        @php
                                                        $reading = $userReadings->get($ebook->id); // Lebih efisien menggunakan get()
                                                        @endphp
                                                        @if($reading && $reading > 0)
                                                        <div class="progress mb-2" style="height: 6px;">
                                                            <div class="progress-bar bg-success" role="progressbar"
                                                                style="width: {{ $reading }}%">
                                                            </div>
                                                        </div>
                                                        <small class="text-success">✓ {{ $reading }}% Complete</small>
                                                        @endif

                                                        <!-- TOMBOL AKSI -->
                                                        <a href="/reader/{{ $ebook->slug }}" class="action-btn btn-read-now w-100 mt-2">
                                                            <i class="fi-rs-book-open"></i>
                                                            <span>{{ $reading ? 'Continue Reading' : 'Read Now' }}</span>
                                                        </a>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @else
                                    <!-- Periksa apakah sedang ada pencarian atau filter -->
                                    @if(request()->filled('search') || request()->filled('city_slug'))
                                    <!-- Jika ya, tampilkan pesan "Tidak Ditemukan" -->
                                    <div class="text-center py-5">
                                        <i class="fi-rs-search text-muted" style="font-size: 64px;"></i>
                                        <h4 class="mt-3">No E-books Found</h4>
                                        <p class="text-muted">
                                            We couldn't find any e-books matching your criteria.
                                            @if(request()->filled('search'))
                                            <br>Try searching for "<strong>{{ request('search') }}</strong>" with different keywords.
                                            @endif
                                        </p>
                                        <a href="{{ route('page-account', ['tab' => 'library']) }}" class="btn mt-2">
                                            Clear Search
                                        </a>
                                    </div>
                                    @else
                                    <!-- Jika tidak, tampilkan pesan "Perpustakaan Kosong" -->
                                    <div class="text-center py-5">
                                        <i class="fi-rs-book text-muted" style="font-size: 64px;"></i>
                                        <h4 class="mt-3">Your Library is Empty</h4>
                                        <p class="text-muted">You have access to all ebooks — start exploring!</p>
                                        <a href="{{ route('destinations') }}" class="btn btn-primary mt-2">
                                            <i class="fi-rs-search"></i> Browse All Ebooks
                                        </a>
                                    </div>
                                    @endif
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- READING HISTORY TAB -->
                        <div class="tab-pane fade {{ request('tab') == 'reading-history' ? 'active show' : '' }}" id="reading-history" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Reading History</h5>
                                </div>
                                <div class="card-body">
                                    @if($readingHistory->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Ebook</th>
                                                    <th>Last Read</th>
                                                    <th>Progress</th>
                                                    <th>Last Page</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($readingHistory as $reading)
                                                <tr>
                                                    <td>
                                                        @if($reading->ebook)
                                                        <strong>{{ $reading->ebook->title }}</strong><br>
                                                        <small class="text-muted">by
                                                            @if($reading->ebook->creator)
                                                            {{ $reading->ebook->creator->creator->pen_name ?? $reading->ebook->creator->name }}
                                                            @else
                                                            Unknown Author
                                                            @endif
                                                        </small>
                                                        @else
                                                        <strong class="text-muted">E-book has been deleted</strong>
                                                        @endif
                                                    </td>
                                                    <td>{{ $reading->last_read_at ? $reading->last_read_at->format('M d, Y H:i') : '-' }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="progress" style="height: 8px; width: 80px;">
                                                                <div class="progress-bar bg-success" role="progressbar"
                                                                    style="width: {{ $reading->progress_percentage }}%">
                                                                </div>
                                                            </div>
                                                            <small class="ms-2">{{ number_format($reading->progress_percentage, 1) }}%</small>
                                                        </div>
                                                    </td>
                                                    <td>Page {{ $reading->last_page }}</td>
                                                    <td>
                                                        @if($reading->ebook)
                                                        <a href="/reader/{{ $reading->ebook->slug }}" class="btn btn-sm">Continue</a>
                                                        @else
                                                        <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @else
                                    <div class="text-center py-5">
                                        <i class="fi-rs-history text-muted" style="font-size: 64px;"></i>
                                        <h4 class="mt-3">No Reading History Yet</h4>
                                        <p class="text-muted">Start reading ebooks to build your reading history</p>
                                        <a href="{{ route('page-account', ['tab' => 'library']) }}" class="btn mt-2">Start Reading</a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- MY REVIEWS TAB -->
                        <div class="tab-pane fade {{ request('tab') == 'reviews' ? 'active show' : '' }}" id="reviews"
                            role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">My Reviews</h5>
                                </div>
                                <div class="card-body">
                                    @if($userRatings->count() > 0)
                                    <div class="row">
                                        @foreach($userRatings as $rating)
                                        <div class="col-md-6 mb-4">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                                        <h6 class="card-title mb-0">
                                                            {{ $rating->ebook->title ?? 'Unknown Book' }}
                                                        </h6>
                                                        <div class="rating">
                                                            @for($i = 1; $i <= 5; $i++) <i
                                                                class="fi-rs-star{{ $i <= $rating->rating ? ' text-warning' : '' }}">
                                                                </i>
                                                                @endfor
                                                        </div>
                                                    </div>
                                                    <p class="card-text small text-muted">by
                                                        {{ $rating->ebook->author ?? 'Unknown Author' }}
                                                    </p>
                                                    @if($rating->review_title)
                                                    <h6 class="text-dark">{{ $rating->review_title }}</h6>
                                                    @endif
                                                    <p class="card-text">{{ $rating->review_text }}</p>
                                                    <small class="text-muted">Reviewed on
                                                        {{ $rating->created_at->format('M d, Y') }}</small>
                                                </div>
                                                <div class="card-footer bg-transparent">
                                                    <div class="d-flex gap-2">
                                                        <button class="btn btn-outline-primary btn-sm">Edit</button>
                                                        <button class="btn btn-outline-danger btn-sm">Delete</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @else
                                    <div class="text-center py-4">
                                        <i class="fi-rs-star text-muted" style="font-size: 48px;"></i>
                                        <h5 class="mt-3">No Reviews Yet</h5>
                                        <p class="text-muted">Share your thoughts by reviewing ebooks you've read</p>
                                        <a href="{{ route('destinations') }}" class="btn">Browse Ebooks</a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- MY SUBSCRIPTION TAB -->
                        <div class="tab-pane fade {{ request('tab') == 'subscription' ? 'active show' : '' }}"
                            id="subscription" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">My Subscription</h5>
                                </div>
                                <div class="card-body">
                                    @if(isset($activeSubscription) && $activeSubscription)
                                    <div class="alert alert-success">
                                        <h6>🎉 Premium Member</h6>
                                        <p class="mb-1">
                                            You are subscribed to
                                            <strong>{{ $activeSubscription->plan->name ?? 'Premium Plan' }}</strong>
                                        </p>
                                        <p class="mb-0">
                                            @if($activeSubscription->end_date)
                                            Next billing date : {{ $activeSubscription->end_date->format('M d, Y') }}
                                            @else
                                            Subscription is active
                                            @endif
                                        </p>
                                    </div>

                                    <div class="mt-4">
                                        <button class="btn">Cancel Subscription</button>
                                        <button class="btn">Upgrade Plan</button>
                                    </div>
                                    @else
                                    <div class="alert alert-warning">
                                        <h6>No Active Subscription</h6>
                                        <p>You don't have an active subscription. Upgrade to unlock premium features.
                                        </p>
                                    </div>
                                    <a href="{{ route('page-account') }}?tab=dashboard" class="btn">View
                                        Subscription Plans</a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- CREATOR TAB -->
                        <div class="tab-pane fade {{ request('tab') == 'creator' ? 'active show' : '' }}" id="creator"
                            role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Creator Dashboard</h5>
                                </div>
                                <div class="card-body">
                                    @if(auth()->user()->isCreator())
                                    @if(isset($createdEbooks) && $createdEbooks->count() > 0)
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
                                        @foreach($createdEbooks as $ebook)
                                        <div class="col-md-4 mb-4">
                                            <div class="card h-100">
                                                <img src="@if($ebook->cover_image && filter_var($ebook->cover_image, FILTER_VALIDATE_URL)){{ $ebook->cover_image }}@elseif($ebook->cover_image){{ asset('storage/' . $ebook->cover_image) }}@else{{ asset('images/ebook-placeholder.webp') }}@endif"
                                                    class="card-img-top" alt="{{ $ebook->title }}"
                                                    style="height: 200px; object-fit: cover;">
                                                <div class="card-body">
                                                    <h6 class="card-title">{{ $ebook->title }}</h6>
                                                    <p class="card-text small text-muted">
                                                        {{ $ebook->short_description }}
                                                    </p>
                                                    <div class="mb-2">
                                                        @foreach($ebook->categories as $category)
                                                        <span class="badge bg-secondary">{{ $category->name }}</span>
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
                                                        <button class="btn btn-outline-primary btn-sm">Stats</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @else
                                    <div class="text-center py-4">
                                        <i class="fi-rs-edit text-muted" style="font-size: 48px;"></i>
                                        <h5 class="mt-3">No Published Ebooks Yet</h5>
                                        <p class="text-muted">Start creating and publishing your ebooks</p>
                                        <button class="btn">Create Your First Ebook</button>
                                    </div>
                                    @endif
                                    @else
                                    <div class="text-center py-4">
                                        <i class="fi-rs-edit text-muted" style="font-size: 48px;"></i>
                                        <h5 class="mt-3">Become a Creator</h5>
                                        <p class="text-muted">Start sharing your knowledge by creating ebooks</p>
                                        <button class="btn">Apply as Creator</button>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- HELP CENTER TAB -->
                        <div class="tab-pane fade {{ request('tab') == 'help' ? 'active show' : '' }}" id="help"
                            role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Help Center</h5>
                                </div>
                                <div class="card-body">
                                    <div class="text-center py-4">
                                        <i class="fi-rs-interactive text-muted" style="font-size: 48px;"></i>
                                        <h5 class="mt-3">How Can We Help You?</h5>
                                        <p class="text-muted">Find answers to common questions and get support</p>

                                        <div class="row mt-4">
                                            <div class="col-md-4 mb-3">
                                                <div class="card border-0 shadow-sm">
                                                    <div class="card-body text-center">
                                                        <i class="fi-rs-book text-primary" style="font-size: 32px;"></i>
                                                        <h6 class="mt-2">Reading Guide</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="card border-0 shadow-sm">
                                                    <div class="card-body text-center">
                                                        <i class="fi-rs-credit-card text-success"
                                                            style="font-size: 32px;"></i>
                                                        <h6 class="mt-2">Billing Help</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="card border-0 shadow-sm">
                                                    <div class="card-body text-center">
                                                        <i class="fi-rs-user text-info" style="font-size: 32px;"></i>
                                                        <h6 class="mt-2">Account Help</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p class="">Need more help? Visit our full
                                    <a href="{{ route('help-center') }}" class="text-primary font-weight-bold">Help
                                        Center</a>.
                                </p>
                            </div>
                        </div>
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
            <form method="POST" action="{{ route('password.update') }}">
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
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-outline-secondary px-4">
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
@endsection