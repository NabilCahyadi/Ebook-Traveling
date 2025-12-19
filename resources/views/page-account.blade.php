@extends('layouts_lp.app')

@section('title', 'My Account - MeatMap')

@section('content')
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
                            @if(auth()->user()->hasActiveSubscription())
                            <!-- ========== PREMIUM MEMBER MENU ========== -->
                            <!-- DASHBOARD -->
                            <li class="nav-item">
                                <a class="nav-link {{ request('tab', 'dashboard') == 'dashboard' ? 'active' : '' }}"
                                    href="{{ route('page-account') }}?tab=dashboard">
                                    <i class="fi-rs-settings-sliders mr-10"></i>Dashboard Member
                                </a>
                            </li>

                            <!-- WISHLIST -->
                            @if(hasPermission('access_wishlist'))
                            <li class="nav-item">
                                <a class="nav-link {{ request('tab') == 'orders' ? 'active' : '' }}"
                                    href="{{ route('page-account') }}?tab=orders">
                                    <i class="fi fi-rs-heart mr-10"></i>Wishlist
                                    @if($wishlistCount > 0)
                                    <span class="badge bg-primary ms-1">{{ $wishlistCount }}</span>
                                    @endif
                                </a>
                            </li>
                            @endif

                            <!-- MY LIBRARY -->
                            <li class="nav-item">
                                <a class="nav-link {{ request('tab') == 'library' ? 'active' : '' }}"
                                    href="{{ route('page-account') }}?tab=library">
                                    <i class="fi-rs-book mr-10"></i>My Library
                                </a>
                            </li>

                            <!-- READING HISTORY -->
                            <li class="nav-item">
                                <a class="nav-link {{ request('tab') == 'reading-history' ? 'active' : '' }}"
                                    href="{{ route('page-account') }}?tab=reading-history">
                                    <i class="bi-clock-history mr-10"></i>Reading History
                                </a>
                            </li>

                            <!-- MY REVIEWS -->
                            <li class="nav-item">
                                <a class="nav-link {{ request('tab') == 'reviews' ? 'active' : '' }}"
                                    href="{{ route('page-account') }}?tab=reviews">
                                    <i class="fi-rs-star mr-10"></i>My Reviews
                                </a>
                            </li>

                            <!-- MY SUBSCRIPTION -->
                            <li class="nav-item">
                                <a class="nav-link {{ request('tab') == 'subscription' ? 'active' : '' }}"
                                    href="{{ route('page-account') }}?tab=subscription">
                                    <i class="fi-rs-crown mr-10"></i>My Subscription
                                </a>
                            </li>

                            <!-- HELP CENTER -->
                            <li class="nav-item">
                                <a class="nav-link {{ request('tab') == 'help' ? 'active' : '' }}"
                                    href="{{ route('page-account') }}?tab=help">
                                    <i class="fi-rs-interactive mr-10"></i>Help Center
                                </a>
                            </li>
                            @else
                            <!-- ========== FREE USER MENU ========== -->
                            <!-- DASHBOARD -->
                            <li class="nav-item">
                                <a class="nav-link {{ request('tab', 'dashboard') == 'dashboard' ? 'active' : '' }}"
                                    href="{{ route('page-account') }}?tab=dashboard">
                                    <i class="fi-rs-settings-sliders mr-10"></i>Dashboard Member
                                </a>
                            </li>

                            <!-- WISHLIST -->
                            @if(hasPermission('access_wishlist'))
                            <li class="nav-item">
                                <a class="nav-link {{ request('tab') == 'orders' ? 'active' : '' }}"
                                    href="{{ route('page-account') }}?tab=orders">
                                    <i class="fi fi-rs-heart mr-10"></i>Wishlist
                                    @if($wishlistCount > 0)
                                    <span class="badge bg-primary ms-1">{{ $wishlistCount }}</span>
                                    @endif
                                </a>
                            </li>
                            @endif

                            @endif

                            <!-- ========== MENU UNTUK SEMUA USER (WITH PERMISSIONS) ========== -->

                            <!-- CREATOR (UNTUK SEMUA USER) -->
                            @if(hasPermission('access_creator_dashboard'))
                            <li class="nav-item">
                                <a class="nav-link {{ request('tab') == 'creator' ? 'active' : '' }}"
                                    href="{{ route('page-account') }}?tab=creator">
                                    <i class="fi-rs-edit mr-10"></i>Creator
                                </a>
                            </li>
                            @endif

                            <!-- PROFILE SETTINGS (UNTUK SEMUA USER) -->
                            @if(hasPermission('access_profile_settings'))
                            <li class="nav-item">
                                <a class="nav-link {{ request('tab') == 'account-detail' ? 'active' : '' }}"
                                    href="{{ route('page-account') }}?tab=account-detail">
                                    <i class="fi-rs-user mr-10"></i>Profile Settings
                                </a>
                            </li>
                            @endif

                            <!-- PAYMENT HISTORY (UNTUK SEMUA USER) -->
                            @if(hasPermission('access_payment_history'))
                            <li class="nav-item">
                                <a class="nav-link {{ request('tab') == 'payment' ? 'active' : '' }}"
                                    href="{{ route('page-account') }}?tab=payment">
                                    <i class="fi-rs-credit-card mr-10"></i>Payment History
                                    @if($ordersCount > 0)
                                    <span class="badge bg-success ms-1">{{ $ordersCount }}</span>
                                    @endif
                                </a>
                            </li>
                            @endif

                            <!-- LOGOUT (SAMA UNTUK KEDUANYA) -->
                            <li class="nav-item">
                                <form method="POST" action="{{ route('user.logout') }}" id="nav-logout-form"
                                    style="display: none;">
                                    @csrf
                                </form>
                                <a class="nav-link" href="#"
                                    onclick="event.preventDefault(); handleAccountLogout();">
                                    <i class="fi-rs-sign-out mr-10"></i>Logout
                                </a>
                            </li>
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
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="stat-card text-center p-3 border rounded">
                                                <h4 class="text-primary">{{ $ordersCount }}</h4>
                                                <p class="mb-0">Total Orders</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="stat-card text-center p-3 border rounded">
                                                <h4 class="text-success">{{ $wishlistCount }}</h4>
                                                <p class="mb-0">Saved Books</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="stat-card text-center p-3 border rounded">
                                                <h4 class="text-info">{{ $readingProgressCount }}</h4>
                                                <p class="mb-0">Reading Progress</p>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-3">
                                        From your account dashboard. you can easily check &amp; view your <a
                                            href="{{ route('page-account') }}?tab=orders">recent orders</a>,<br />
                                        manage your <a href="{{ route('page-account') }}?tab=account-detail">profile
                                            settings</a> and edit your account details.
                                    </p>
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
                                        <a href="{{ route('destinations') }}" class="btn btn-primary btn-custom">Browse
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
                                                    <p class="mt-2 mb-0"><small>Click to change photo.</small></p>
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
                                                    <button type="submit" class="btn btn-primary px-4 py-2"
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
                                        <a href="{{ route('destinations') }}" class="btn btn-primary btn-custom">Browse
                                            Ebooks</a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- ========== PREMIUM ONLY TABS ========== -->

                        <!-- MY LIBRARY TAB -->
                        <div class="tab-pane fade {{ request('tab') == 'library' ? 'active show' : '' }}" id="library"
                            role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">My Library</h5>
                                </div>
                                <div class="card-body">
                                    @if(isset($purchasedEbooks) && $purchasedEbooks->count() > 0)
                                    <div class="row mb-4">
                                        <div class="col-md-3 mb-3">
                                            <div class="text-center p-3 border rounded">
                                                <h4 class="text-primary">{{ $purchasedEbooks->count() }}</h4>
                                                <p class="mb-0">Total Books</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="text-center p-3 border rounded">
                                                <h4 class="text-success">{{ $readingStats['total_books_read'] ?? 0 }}
                                                </h4>
                                                <p class="mb-0">Completed</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="text-center p-3 border rounded">
                                                <h4 class="text-warning">
                                                    {{ $readingStats['currently_reading']->count() ?? 0 }}
                                                </h4>
                                                <p class="mb-0">In Progress</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="text-center p-3 border rounded">
                                                <h4 class="text-info">
                                                    {{ $purchasedEbooks->count() - ($readingStats['total_books_read'] ?? 0) }}
                                                </h4>
                                                <p class="mb-0">Not Started</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        @foreach($purchasedEbooks as $ebook)
                                        <div class="col-md-4 mb-4">
                                            <div class="card h-100">
                                                <img src="{{ $ebook->cover_image ?? '/images/ebook-placeholder.jpg' }}"
                                                    class="card-img-top" alt="{{ $ebook->title }}"
                                                    style="height: 200px; object-fit: cover;">
                                                <div class="card-body">
                                                    <h6 class="card-title">{{ $ebook->title }}</h6>
                                                    <p class="card-text small text-muted">by {{ $ebook->author }}</p>
                                                    <div class="mb-2">
                                                        @foreach($ebook->categories as $category)
                                                        <span class="badge bg-secondary">{{ $category->name }}</span>
                                                        @endforeach
                                                    </div>
                                                    @php
                                                    $reading = $userReadings->where('ebook_id', $ebook->id)->first();
                                                    @endphp
                                                    @if($reading)
                                                    <div class="progress mb-2" style="height: 8px;">
                                                        <div class="progress-bar" role="progressbar"
                                                            style="width: {{ $reading->progress_percentage }}%"></div>
                                                    </div>
                                                    <small>Progress: {{ $reading->progress_percentage }}%</small>
                                                    @endif
                                                </div>
                                                <div class="card-footer bg-transparent">
                                                    <a href="#" class="btn btn-primary btn-sm w-100">Continue
                                                        Reading</a>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @else
                                    <div class="text-center py-4">
                                        <i class="fi-rs-book text-muted" style="font-size: 48px;"></i>
                                        <h5 class="mt-3">Your Library is Empty</h5>
                                        <p class="text-muted">Start building your library by purchasing ebooks</p>
                                        <a href="{{ route('destinations') }}" class="btn btn-primary">Browse Ebooks</a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- READING HISTORY TAB -->
                        <div class="tab-pane fade {{ request('tab') == 'reading-history' ? 'active show' : '' }}"
                            id="reading-history" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Reading History</h5>
                                </div>
                                <div class="card-body">
                                    @if($userReadings->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table">
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
                                                @foreach($userReadings as $reading)
                                                <tr>
                                                    <td>
                                                        <strong>{{ $reading->ebook->title ?? 'Unknown Book' }}</strong><br>
                                                        <small class="text-muted">by
                                                            {{ $reading->ebook->author ?? 'Unknown Author' }}</small>
                                                    </td>
                                                    <td>{{ $reading->last_read_at ? $reading->last_read_at->format('M d, Y H:i') : 'Never' }}
                                                    </td>
                                                    <td>
                                                        <div class="progress" style="height: 8px; width: 100px;">
                                                            <div class="progress-bar" role="progressbar"
                                                                style="width: {{ $reading->progress_percentage }}%">
                                                            </div>
                                                        </div>
                                                        <small>{{ $reading->progress_percentage }}%</small>
                                                    </td>
                                                    <td>Page {{ $reading->last_page }}</td>
                                                    <td>
                                                        <a href="#" class="btn-small d-block">Continue</a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @else
                                    <div class="text-center py-4">
                                        <i class="fi-rs-history text-muted" style="font-size: 48px;"></i>
                                        <h5 class="mt-3">No Reading History Yet</h5>
                                        <p class="text-muted">Start reading ebooks to build your reading history</p>
                                        <a href="{{ route('destinations') }}" class="btn btn-primary">Start Reading</a>
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
                                        <a href="{{ route('destinations') }}" class="btn btn-primary">Browse Ebooks</a>
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
                                        <button class="btn btn-outline-danger">Cancel Subscription</button>
                                        <button class="btn btn-primary">Upgrade Plan</button>
                                    </div>
                                    @else
                                    <div class="alert alert-warning">
                                        <h6>No Active Subscription</h6>
                                        <p>You don't have an active subscription. Upgrade to unlock premium features.
                                        </p>
                                    </div>
                                    <a href="{{ route('page-account') }}?tab=dashboard" class="btn btn-primary">View
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
                                                <img src="{{ $ebook->cover_image ?? '/images/ebook-placeholder.jpg' }}"
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
                                                        <button class="btn btn-primary btn-sm">Edit</button>
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
                                        <button class="btn btn-primary">Create Your First Ebook</button>
                                    </div>
                                    @endif
                                    @else
                                    <div class="text-center py-4">
                                        <i class="fi-rs-edit text-muted" style="font-size: 48px;"></i>
                                        <h5 class="mt-3">Become a Creator</h5>
                                        <p class="text-muted">Start sharing your knowledge by creating ebooks</p>
                                        <button class="btn btn-primary">Apply as Creator</button>
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
                    <button type="submit" class="btn btn-primary btn-custom px-4"
                        style="background: linear-gradient(135deg, #FF4C61 0%, #FF416C 100%); border: none;">
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

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

{{-- STYLES UNTUK CUSTOM CSS --}}

@push('styles')
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
@endpush