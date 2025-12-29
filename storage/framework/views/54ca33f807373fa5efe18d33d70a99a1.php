<?php $__env->startSection('title', 'My Account - MeatMap'); ?>

<?php $__env->startSection('content'); ?>

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
                            <?php if(auth()->user()->hasActiveSubscription()): ?>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e(request('tab') == 'library' ? 'active' : ''); ?>"
                                    href="<?php echo e(route('page-account')); ?>?tab=library">
                                    <i class="fi-rs-book mr-10"></i>My Library
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e(request('tab') == 'reading-history' ? 'active' : ''); ?>"
                                    href="<?php echo e(route('page-account')); ?>?tab=reading-history">
                                    <i class="bi-clock-history mr-10"></i>Reading History
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e(request('tab') == 'reviews' ? 'active' : ''); ?>"
                                    href="<?php echo e(route('page-account')); ?>?tab=reviews">
                                    <i class="fi-rs-star mr-10"></i>My Reviews
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e(request('tab') == 'subscription' ? 'active' : ''); ?>"
                                    href="<?php echo e(route('page-account')); ?>?tab=subscription">
                                    <i class="fi-rs-crown mr-10"></i>My Subscription
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e(request('tab') == 'help' ? 'active' : ''); ?>"
                                    href="<?php echo e(route('page-account')); ?>?tab=help">
                                    <i class="fi-rs-interactive mr-10"></i>Help Center
                                </a>
                            </li>
                            <?php endif; ?>

                            <!-- ========== MENU UNTUK SEMUA USER (DILUAR IF-ELSE) ========== -->
                            <li class="nav-item">
                                <a class="nav-link <?php echo e(request('tab', 'dashboard') == 'dashboard' ? 'active' : ''); ?>"
                                    href="<?php echo e(route('page-account')); ?>?tab=dashboard">
                                    <i class="fi-rs-settings-sliders mr-10"></i>Dashboard Member
                                </a>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link <?php echo e(request('tab') == 'wishlist' ? 'active' : ''); ?>"
                                    href="<?php echo e(route('page-account')); ?>?tab=wishlist">
                                    <i class="fi fi-rs-heart mr-10"></i>Wishlist
                                    <?php if($wishlistCount > 0): ?>
                                    <span class="badge bg-primary ms-1"><?php echo e($wishlistCount); ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link <?php echo e(request('tab') == 'creator' ? 'active' : ''); ?>"
                                    href="<?php echo e(route('page-account')); ?>?tab=creator">
                                    <i class="fi-rs-edit mr-10"></i>Creator
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link <?php echo e(request('tab') == 'account-detail' ? 'active' : ''); ?>"
                                    href="<?php echo e(route('page-account')); ?>?tab=account-detail">
                                    <i class="fi-rs-user mr-10"></i>Profile Settings
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link <?php echo e(request('tab') == 'payment' ? 'active' : ''); ?>"
                                    href="<?php echo e(route('page-account')); ?>?tab=payment">
                                    <i class="fi-rs-credit-card mr-10"></i>Payment History
                                    <?php if($ordersCount > 0): ?>
                                    <span class="badge bg-success ms-1"><?php echo e($ordersCount); ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>

                            <!-- ========== LOGOUT (SEMUA USER) ========== -->
                            <li class="nav-item mt-auto">
                                <a class="nav-link text-danger" href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fi-rs-sign-out mr-10"></i>Logout
                                </a>
                                <form id="logout-form" action="<?php echo e(route('user.logout')); ?>" method="POST" class="d-none">
                                    <?php echo csrf_field(); ?>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content account dashboard-content pl-50">
                        <!-- DASHBOARD TAB -->
                        <div class="tab-pane fade <?php echo e(request('tab', 'dashboard') == 'dashboard' ? 'active show' : ''); ?>"
                            id="dashboard" role="tabpanel">
                            <?php if(auth()->user()->hasActiveSubscription()): ?>
                            <!-- TAMPILAN UNTUK USER PREMIUM -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="mb-0">Hello <?php echo e(auth()->user()->name); ?>!</h3>
                                    <small>Premium Member since <?php echo e(auth()->user()->created_at->format('M Y')); ?></small>
                                </div>
                            </div>
                            <?php else: ?>
                            <!-- TAMPILAN UNTUK USER NON-PREMIUM -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="mb-0">Hello <?php echo e(auth()->user()->name); ?>!</h3>
                                    <small class="text-muted">Member since
                                        <?php echo e(auth()->user()->created_at->format('M Y')); ?></small>
                                </div>
                                <div class="card-body">
                                    <div class="alert alert-info border-0"
                                        style="background: #e3f2fd; border-left: 4px solid #2196F3;">
                                        <h5 class="alert-heading">Upgrade to Premium!</h5>
                                        <p class="mt-4">Unlock exclusive features and access our complete ebook library
                                            by subscribing to our <u><a href="<?php echo e(route('pricing')); ?>">premium
                                                    plan</a>.</u>
                                            Get unlimited access to all ebooks, advanced features, and priority support.
                                            Enjoy a limited-time <u><a href="<?php echo e(route('promo')); ?>">exclusive offer</a></u>
                                            <strong>don't miss out!</strong>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>

                        <!-- WISHLIST TAB -->
                        <div class="tab-pane fade <?php echo e(request('tab') == 'orders' ? 'active show' : ''); ?>" id="orders"
                            role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Your Wishlist</h5>
                                </div>
                                <div class="card-body">
                                    <?php if($wishlistItems->count() > 0): ?>
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
                                                <?php $__currentLoopData = $wishlistItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($item->ebook->title ?? 'Unknown Book'); ?></td>
                                                    <td>
                                                        <?php if(isset($item->ebook->categories) &&
                                                        $item->ebook->categories->count() > 0): ?>
                                                        <?php $__currentLoopData = $item->ebook->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <span class="badge bg-secondary"><?php echo e($category->name); ?></span>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php else: ?>
                                                        <span class="text-muted">No category</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if(isset($item->ebook->price)): ?>
                                                        <?php if($item->ebook->price == 0): ?>
                                                        <span class="text-success">Free</span>
                                                        <?php else: ?>
                                                        $<?php echo e(number_format($item->ebook->price, 2)); ?>

                                                        <?php endif; ?>
                                                        <?php else: ?>
                                                        <span class="text-muted">N/A</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if(isset($item->ebook->price) && $item->ebook->price == 0): ?>
                                                        <a href="#" class="btn-small d-block">Read Now</a>
                                                        <?php else: ?>
                                                        <a href="#" class="btn-small d-block">Buy Now</a>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php else: ?>
                                    <div class="text-center py-4">
                                        <i class="fi fi-rs-heart text-muted" style="font-size: 48px;"></i>
                                        <h5 class="mt-3">No saved books yet</h5>
                                        <p class="text-muted">Start exploring our ebooks and add them to your wishlist!
                                        </p>
                                        <a href="<?php echo e(route('destinations')); ?>" class="btn btn-custom">Browse
                                            Ebooks</a>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- PROFILE SETTINGS TAB -->
                        <div class="tab-pane fade <?php echo e(request('tab') == 'account-detail' ? 'active show' : ''); ?>"
                            id="account-detail" role="tabpanel">
                            
                            <?php if($errors->any()): ?>
                            <div class="alert alert-danger">
                                <strong>Ada kesalahan:</strong>
                                <ul>
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                            <?php endif; ?>

                            
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5>Profile Picture</h5>
                                </div>
                                <div class="card-body">
                                    <?php if(session('avatar_success')): ?>
                                    <div class="alert alert-success">
                                        <?php echo e(session('avatar_success')); ?>

                                    </div>
                                    <?php endif; ?>

                                    <form method="POST" action="<?php echo e(route('account.update.avatar')); ?>" enctype="multipart/form-data">
                                        <?php echo csrf_field(); ?>
                                        <div class="row align-items-center">
                                            <div class="col-md-3 text-center">
                                                <label for="avatar_input" style="cursor: pointer;">
                                                    
                                                    <img id="avatar-preview"
                                                        src="<?php echo e(auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) . '?t=' . auth()->user()->updated_at->timestamp : asset('/images/user-avatar.png')); ?>"
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
                            

                            
                            <div class="card">
                                <div class="card-header">
                                    <h5>Profile Settings</h5>
                                </div>
                                <div class="card-body">
                                    <?php if(session('success')): ?>
                                    <div class="alert alert-success">
                                        <?php echo e(session('success')); ?>

                                    </div>
                                    <?php endif; ?>

                                    <?php if($errors->any()): ?>
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><?php echo e($error); ?></li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </div>
                                    <?php endif; ?>

                                    <form method="post" action="<?php echo e(route('profile.update')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>Full Name <span class="required">*</span></label>
                                                <input required class="form-control" name="name" type="text"
                                                    value="<?php echo e(old('name', auth()->user()->name)); ?>" />
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Phone Number</label>
                                                <input class="form-control" name="phone"
                                                    value="<?php echo e(old('phone', auth()->user()->phone)); ?>" />
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label>Email Address <span class="required">*</span></label>
                                                <input required class="form-control" name="email" type="email"
                                                    value="<?php echo e(old('email', auth()->user()->email)); ?>" readonly />
                                                <small class="text-muted">Email cannot be changed</small>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label>Bio</label>
                                                <textarea class="form-control" name="bio" rows="3"
                                                    placeholder="Tell us about yourself..."><?php echo e(old('bio', auth()->user()->profile->bio ?? '')); ?></textarea>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Country</label>
                                                <input class="form-control" name="country"
                                                    value="<?php echo e(old('country', auth()->user()->profile->country ?? '')); ?>" />
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Preferred Language</label>
                                                <select class="form-control" name="preferred_language">
                                                    <option value="id"
                                                        <?php echo e((old('preferred_language', auth()->user()->preferred_language) == 'id') ? 'selected' : ''); ?>>
                                                        Indonesian</option>
                                                    <option value="en"
                                                        <?php echo e((old('preferred_language', auth()->user()->preferred_language) == 'en') ? 'selected' : ''); ?>>
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
                        <div class="tab-pane fade <?php echo e(request('tab') == 'payment' ? 'active show' : ''); ?>" id="payment"
                            role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Payment History</h5>
                                </div>
                                <div class="card-body">
                                    <?php if($orders->count() > 0): ?>
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
                                                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td>#<?php echo e($order->order_code ?? $order->id); ?></td>
                                                    <td><?php echo e($order->created_at->format('M d, Y')); ?></td>
                                                    <td>$<?php echo e(number_format($order->total_amount, 2)); ?></td>
                                                    <td>
                                                        <?php if($order->status == 'completed'): ?>
                                                        <span class="badge bg-success">Paid</span>
                                                        <?php elseif($order->status == 'pending'): ?>
                                                        <span class="badge bg-warning">Pending</span>
                                                        <?php else: ?>
                                                        <span
                                                            class="badge bg-secondary"><?php echo e(ucfirst($order->status)); ?></span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><a href="#" class="btn-small d-block">View Details</a></td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php else: ?>
                                    <div class="text-center py-4">
                                        <i class="fi-rs-credit-card text-muted" style="font-size: 48px;"></i>
                                        <h5 class="mt-3">No payment history yet</h5>
                                        <p class="text-muted">Your payment history will appear here after you make a
                                            purchase.</p>
                                        <a href="<?php echo e(route('destinations')); ?>" class="btn btn-custom">Browse
                                            Ebooks</a>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- MY LIBRARY TAB -->
                        <div class="tab-pane fade <?php echo e(request('tab') == 'library' ? 'active show' : ''); ?>" id="library" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">My Library (<?php echo e($allEbooks->count()); ?> ebooks)</h5>
                                </div>
                                <div class="card-body">
                                    <!-- resources/views/page-account.blade.php -->

                                    <form method="GET" action="<?php echo e(route('page-account')); ?>" class="mb-4">
                                        <input type="hidden" name="tab" value="library">
                                        <div class="row g-3 align-items-end"> <!-- Tambahkan align-items-end di row untuk meratakan semua elemen di bawah -->
                                            <div class="col-md-6">
                                                <label for="search" class="form-label">Search by Title</label>
                                                <input type="text" class="form-control h-100" name="search" id="search" placeholder="e.g., Yogyakarta" value="<?php echo e(request('search')); ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="city_slug" class="form-label">Filter by City</label>
                                                <select name="city_slug" id="city_slug" class="form-select form-select-md">
                                                    <option value="">All Cities</option>
                                                    <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($city->slug); ?>" <?php echo e(request('city_slug') == $city->slug ? 'selected' : ''); ?>>
                                                        <?php echo e($city->name); ?>

                                                    </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                    <?php if($allEbooks->isNotEmpty()): ?>
                                    <!-- Grid 4 per baris -->
                                    <div class="row">
                                        <?php $__currentLoopData = $allEbooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $ebook): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                            <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn" data-wow-delay="<?php echo e(($index % 4) * 0.1); ?>s">
                                                <div class="product-img-action-wrap">
                                                    <div class="product-img product-img-zoom">
                                                        <a href="/ebooks/<?php echo e($ebook->slug); ?>">
                                                            <img class="default-img"
                                                                src="<?php echo e($ebook->cover_image ?: 'assets-nest/nest-fe/imgs/shop/product-1-1.jpg'); ?>"
                                                                alt="<?php echo e($ebook->title); ?>" />
                                                        </a>
                                                    </div>
                                                    <div class="product-badges product-badges-position product-badges-mrg">
                                                        <span class="badge-language hot"><?php echo e(strtoupper($ebook->language ?? 'ID')); ?></span>
                                                    </div>
                                                </div>
                                                <div class="product-content-wrap">
                                                    <!-- HILANGKAN INLINE STYLE, GUNAKAN CSS -->
                                                    <h2>
                                                        <a href="/ebooks/<?php echo e($ebook->slug); ?>"><?php echo e(Str::limit($ebook->title, 40)); ?></a>
                                                    </h2>

                                                    <!-- HILANGKAN INLINE STYLE, GUNAKAN CSS -->
                                                    <div class="product-author">
                                                        <?php if($ebook->creator): ?>
                                                        <span>by <?php echo e($ebook->creator->pen_name ?? $ebook->creator->user->name); ?></span>
                                                        <?php else: ?>
                                                        <span>by Unknown Author</span>
                                                        <?php endif; ?>
                                                    </div>

                                                    <div class="product-meta">
                                                        <div class="product-detail-rating">
                                                            <div class="product-rate-cover text-end">
                                                                <div class="product-rate-cover">
                                                                    <div class="product-rate d-inline-block">
                                                                        <div class="product-rating"
                                                                            style="width: <?php echo e(($ebook->ratings()->avg('rating') / 5) * 100); ?>%"></div>
                                                                    </div>
                                                                    <span class="font-small ml-5 text-muted">(<?php echo e(round($ebook->ratings()->avg('rating') ?? 0, 1)); ?>)</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="read-count">
                                                            <i class="fi-rs-eye align-middle"></i>
                                                            <span class="post-on">
                                                                <?php
                                                                $views = $ebook->view_count;
                                                                echo $views >= 1000000 ? number_format($views / 1000000, 1).'M'
                                                                : ($views >= 1000 ? number_format($views / 1000, 1).'k' : $views);
                                                                ?>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <?php
                                                    $descriptionText = $ebook->short_description ?? $ebook->description;
                                                    $isSingleLine = strlen($descriptionText) <= 29;
                                                        ?>
                                                        <p class="product-description <?php echo e($isSingleLine ? 'single-line' : ''); ?>">
                                                        <?php echo e(Str::limit($descriptionText, 75)); ?>

                                                        </p>

                                                        <!-- PROGRESS BAR (jika sedang dibaca) -->
                                                        <?php
                                                        $reading = $userReadings->get($ebook->id); // Lebih efisien menggunakan get()
                                                        ?>
                                                        <?php if($reading && $reading > 0): ?>
                                                        <div class="progress mb-2" style="height: 6px;">
                                                            <div class="progress-bar bg-success" role="progressbar"
                                                                style="width: <?php echo e($reading); ?>%">
                                                            </div>
                                                        </div>
                                                        <small class="text-success">✓ <?php echo e($reading); ?>% Complete</small>
                                                        <?php endif; ?>

                                                        <!-- TOMBOL AKSI -->
                                                        <a href="/reader/<?php echo e($ebook->slug); ?>" class="action-btn btn-read-now w-100 mt-2">
                                                            <i class="fi-rs-book-open"></i>
                                                            <span><?php echo e($reading ? 'Continue Reading' : 'Read Now'); ?></span>
                                                        </a>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                    <?php else: ?>
                                    <!-- Periksa apakah sedang ada pencarian atau filter -->
                                    <?php if(request()->filled('search') || request()->filled('city_slug')): ?>
                                    <!-- Jika ya, tampilkan pesan "Tidak Ditemukan" -->
                                    <div class="text-center py-5">
                                        <i class="fi-rs-search text-muted" style="font-size: 64px;"></i>
                                        <h4 class="mt-3">No E-books Found</h4>
                                        <p class="text-muted">
                                            We couldn't find any e-books matching your criteria.
                                            <?php if(request()->filled('search')): ?>
                                            <br>Try searching for "<strong><?php echo e(request('search')); ?></strong>" with different keywords.
                                            <?php endif; ?>
                                        </p>
                                        <a href="<?php echo e(route('page-account', ['tab' => 'library'])); ?>" class="btn mt-2">
                                            Clear Search
                                        </a>
                                    </div>
                                    <?php else: ?>
                                    <!-- Jika tidak, tampilkan pesan "Perpustakaan Kosong" -->
                                    <div class="text-center py-5">
                                        <i class="fi-rs-book text-muted" style="font-size: 64px;"></i>
                                        <h4 class="mt-3">Your Library is Empty</h4>
                                        <p class="text-muted">You have access to all ebooks — start exploring!</p>
                                        <a href="<?php echo e(route('destinations')); ?>" class="btn btn-primary mt-2">
                                            <i class="fi-rs-search"></i> Browse All Ebooks
                                        </a>
                                    </div>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- READING HISTORY TAB -->
                        <div class="tab-pane fade <?php echo e(request('tab') == 'reading-history' ? 'active show' : ''); ?>" id="reading-history" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Reading History</h5>
                                </div>
                                <div class="card-body">
                                    <?php if($readingHistory->count() > 0): ?>
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
                                                <?php $__currentLoopData = $readingHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reading): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td>
                                                        <?php if($reading->ebook): ?>
                                                        <strong><?php echo e($reading->ebook->title); ?></strong><br>
                                                        <small class="text-muted">by
                                                            <?php if($reading->ebook->creator): ?>
                                                            <?php echo e($reading->ebook->creator->pen_name ?? $reading->ebook->creator->user->name); ?>

                                                            <?php else: ?>
                                                            Unknown Author
                                                            <?php endif; ?>
                                                        </small>
                                                        <?php else: ?>
                                                        <strong class="text-muted">E-book has been deleted</strong>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?php echo e($reading->last_read_at ? $reading->last_read_at->format('M d, Y H:i') : '-'); ?></td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="progress" style="height: 8px; width: 80px;">
                                                                <div class="progress-bar bg-success" role="progressbar"
                                                                    style="width: <?php echo e($reading->progress_percentage); ?>%">
                                                                </div>
                                                            </div>
                                                            <small class="ms-2"><?php echo e(number_format($reading->progress_percentage, 1)); ?>%</small>
                                                        </div>
                                                    </td>
                                                    <td>Page <?php echo e($reading->last_page); ?></td>
                                                    <td>
                                                        <?php if($reading->ebook): ?>
                                                        <a href="/reader/<?php echo e($reading->ebook->slug); ?>" class="btn btn-sm">Continue</a>
                                                        <?php else: ?>
                                                        <span class="text-muted">-</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php else: ?>
                                    <div class="text-center py-5">
                                        <i class="fi-rs-history text-muted" style="font-size: 64px;"></i>
                                        <h4 class="mt-3">No Reading History Yet</h4>
                                        <p class="text-muted">Start reading ebooks to build your reading history</p>
                                        <a href="<?php echo e(route('page-account', ['tab' => 'library'])); ?>" class="btn mt-2">Start Reading</a>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- MY REVIEWS TAB -->
                        <div class="tab-pane fade <?php echo e(request('tab') == 'reviews' ? 'active show' : ''); ?>" id="reviews"
                            role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">My Reviews</h5>
                                </div>
                                <div class="card-body">
                                    <?php if($userRatings->count() > 0): ?>
                                    <div class="row">
                                        <?php $__currentLoopData = $userRatings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rating): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-md-6 mb-4">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                                        <h6 class="card-title mb-0">
                                                            <?php echo e($rating->ebook->title ?? 'Unknown Book'); ?>

                                                        </h6>
                                                        <div class="rating">
                                                            <?php for($i = 1; $i <= 5; $i++): ?> <i
                                                                class="fi-rs-star<?php echo e($i <= $rating->rating ? ' text-warning' : ''); ?>">
                                                                </i>
                                                                <?php endfor; ?>
                                                        </div>
                                                    </div>
                                                    <p class="card-text small text-muted">by
                                                        <?php echo e($rating->ebook->author ?? 'Unknown Author'); ?>

                                                    </p>
                                                    <?php if($rating->review_title): ?>
                                                    <h6 class="text-dark"><?php echo e($rating->review_title); ?></h6>
                                                    <?php endif; ?>
                                                    <p class="card-text"><?php echo e($rating->review_text); ?></p>
                                                    <small class="text-muted">Reviewed on
                                                        <?php echo e($rating->created_at->format('M d, Y')); ?></small>
                                                </div>
                                                <div class="card-footer bg-transparent">
                                                    <div class="d-flex gap-2">
                                                        <button class="btn btn-outline-primary btn-sm">Edit</button>
                                                        <button class="btn btn-outline-danger btn-sm">Delete</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                    <?php else: ?>
                                    <div class="text-center py-4">
                                        <i class="fi-rs-star text-muted" style="font-size: 48px;"></i>
                                        <h5 class="mt-3">No Reviews Yet</h5>
                                        <p class="text-muted">Share your thoughts by reviewing ebooks you've read</p>
                                        <a href="<?php echo e(route('destinations')); ?>" class="btn">Browse Ebooks</a>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- MY SUBSCRIPTION TAB -->
                        <div class="tab-pane fade <?php echo e(request('tab') == 'subscription' ? 'active show' : ''); ?>"
                            id="subscription" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">My Subscription</h5>
                                </div>
                                <div class="card-body">
                                    <?php if(isset($activeSubscription) && $activeSubscription): ?>
                                    <div class="alert alert-success">
                                        <h6>🎉 Premium Member</h6>
                                        <p class="mb-1">
                                            You are subscribed to
                                            <strong><?php echo e($activeSubscription->plan->name ?? 'Premium Plan'); ?></strong>
                                        </p>
                                        <p class="mb-0">
                                            <?php if($activeSubscription->end_date): ?>
                                            Next billing date : <?php echo e($activeSubscription->end_date->format('M d, Y')); ?>

                                            <?php else: ?>
                                            Subscription is active
                                            <?php endif; ?>
                                        </p>
                                    </div>

                                    <div class="mt-4">
                                        <button class="btn">Cancel Subscription</button>
                                        <button class="btn">Upgrade Plan</button>
                                    </div>
                                    <?php else: ?>
                                    <div class="alert alert-warning">
                                        <h6>No Active Subscription</h6>
                                        <p>You don't have an active subscription. Upgrade to unlock premium features.
                                        </p>
                                    </div>
                                    <a href="<?php echo e(route('page-account')); ?>?tab=dashboard" class="btn">View
                                        Subscription Plans</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- CREATOR TAB -->
                        <div class="tab-pane fade <?php echo e(request('tab') == 'creator' ? 'active show' : ''); ?>" id="creator"
                            role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Creator Dashboard</h5>
                                </div>
                                <div class="card-body">
                                    <?php if(auth()->user()->isCreator()): ?>
                                    <?php if(isset($createdEbooks) && $createdEbooks->count() > 0): ?>
                                    <div class="row mb-4">
                                        <div class="col-md-3 mb-3">
                                            <div class="text-center p-3 border rounded">
                                                <h4 class="text-primary"><?php echo e($createdEbooks->count()); ?></h4>
                                                <p class="mb-0">Published Ebooks</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="text-center p-3 border rounded">
                                                <h4 class="text-success"><?php echo e($createdEbooks->sum('view_count')); ?></h4>
                                                <p class="mb-0">Total Views</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="text-center p-3 border rounded">
                                                <h4 class="text-warning"><?php echo e($createdEbooks->sum('read_count')); ?></h4>
                                                <p class="mb-0">Total Reads</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="text-center p-3 border rounded">
                                                <h4 class="text-info"><?php echo e($createdEbooks->sum('total_reviews')); ?></h4>
                                                <p class="mb-0">Total Reviews</p>
                                            </div>
                                        </div>
                                    </div>

                                    <h6>Your Published Ebooks</h6>
                                    <div class="row">
                                        <?php $__currentLoopData = $createdEbooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ebook): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-md-4 mb-4">
                                            <div class="card h-100">
                                                <img src="<?php echo e($ebook->cover_image ?? '/images/ebook-placeholder.jpg'); ?>"
                                                    class="card-img-top" alt="<?php echo e($ebook->title); ?>"
                                                    style="height: 200px; object-fit: cover;">
                                                <div class="card-body">
                                                    <h6 class="card-title"><?php echo e($ebook->title); ?></h6>
                                                    <p class="card-text small text-muted">
                                                        <?php echo e($ebook->short_description); ?>

                                                    </p>
                                                    <div class="mb-2">
                                                        <?php $__currentLoopData = $ebook->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <span class="badge bg-secondary"><?php echo e($category->name); ?></span>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                    <div class="d-flex justify-content-between small text-muted">
                                                        <span>Views: <?php echo e($ebook->view_count); ?></span>
                                                        <span>Reads: <?php echo e($ebook->read_count); ?></span>
                                                        <span>Rating: <?php echo e($ebook->average_rating); ?>/5</span>
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
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                    <?php else: ?>
                                    <div class="text-center py-4">
                                        <i class="fi-rs-edit text-muted" style="font-size: 48px;"></i>
                                        <h5 class="mt-3">No Published Ebooks Yet</h5>
                                        <p class="text-muted">Start creating and publishing your ebooks</p>
                                        <button class="btn">Create Your First Ebook</button>
                                    </div>
                                    <?php endif; ?>
                                    <?php else: ?>
                                    <div class="text-center py-4">
                                        <i class="fi-rs-edit text-muted" style="font-size: 48px;"></i>
                                        <h5 class="mt-3">Become a Creator</h5>
                                        <p class="text-muted">Start sharing your knowledge by creating ebooks</p>
                                        <button class="btn">Apply as Creator</button>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- HELP CENTER TAB -->
                        <div class="tab-pane fade <?php echo e(request('tab') == 'help' ? 'active show' : ''); ?>" id="help"
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
                                    <a href="<?php echo e(route('help-center')); ?>" class="text-primary font-weight-bold">Help
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
            <form method="POST" action="<?php echo e(route('password.update')); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts_lp.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJEK PROJEK\Ebook-Traveling\resources\views/page-account.blade.php ENDPATH**/ ?>