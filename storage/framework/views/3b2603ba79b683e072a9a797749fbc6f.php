<?php $__env->startSection('title', 'Pricing - MeatMap'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .icon-wrapper {
        width: 80px;
        height: 80px;
        margin: 0 auto 20px auto;
        background-color: #FF4C61;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .icon-wrapper i,
    .icon-wrapper svg {
        color: #FFFFFF;
        font-size: 35px;
    }
</style>
<style>
    .accordion-content {
        transition: max-height 0.3s ease-out, padding 0.3s ease;
    }

    /* Styling untuk tombol Primary (Solid #FF4C61) */
    .btn-primary-custom:hover {
        background-color: #E54457 !important;
        /* BG menjadi lebih gelap */
        color: white !important;
        /* Warna teks tetap putih */
        transform: translateY(-1px);
        /* Efek sedikit naik */
    }

    /* Styling untuk tombol Secondary (Outline #FF4C61) */
    .btn-secondary-custom:hover {
        background-color: #FF4C61 !important;
        /* BG berubah menjadi warna utama */
        color: white !important;
        /* Teks berubah menjadi putih */
        transform: translateY(-1px);
        /* Efek sedikit naik */
    }

    /* Menghilangkan border pada hover tombol secondary agar tidak terlihat double */
    .btn-secondary-custom:hover {
        border-color: #E54457 !important;
        /* Opsi: Samakan border dengan warna hover primary, atau hilangkan border */
    }
</style>
<!-- <style>
    /* CSS untuk Grid Layout dan Centering */
    .pricing-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 2rem;
        margin-top: 1.5rem;
    }

    .pricing-card {
        flex: 0 0 calc(33.333% - 1.333rem);
        padding: 2rem;
        text-align: center;
        border-radius: 0.5rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .pricing-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    /* --- Gaya untuk Card Ganjil (Background Putih) --- */
    .pricing-card--odd {
        border: 1px solid #FF4C61;
        background-color: #ffffff;
        color: #1f2937;
        /* Warna teks utama gelap */
    }

    .pricing-card--odd .card-title,
    .pricing-card--odd .card-price-description,
    .pricing-card--odd .card-features {
        color: #6b7280;
    }

    .pricing-card--odd .card-features .feature-check {
        color: #FF4C61;
    }

    /* --- Gaya untuk Card Genap (Background Merah) --- */
    .pricing-card--even {
        background-color: #FF4C61;
    }

    /* Paksa semua teks di dalam card merah menjadi putih */
    .pricing-card--even * {
        color: #ffffff !important;
    }

    /* --- Gaya Tombol (Perbaikan di sini) --- */
    .pricing-button {
        width: 100%;
        padding: 0.75rem 1.5rem;
        margin-top: auto;
        font-weight: 600;
        text-transform: capitalize;
        border-radius: 0.375rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    /* Tombol di Card Putih */
    .pricing-card--odd .pricing-button {
        background-color: #FF4C61;
        color: white;
    }

    .pricing-card--odd .pricing-button:hover {
        background-color: #ca3145;
        /* Warna merah lebih gelap saat hover */
    }

    /* Tombol di Card Merah */
    .pricing-card--even .pricing-button {
        background-color: #ffffff;
        /* Background putih */
        color: #FF4C61 !important;
        /* Teks merah */
    }

    .pricing-card--even .pricing-button:hover {
        background-color: #f8f8f8;
        /* Background abu-abu sangat muda saat hover, agar tidak menyatu */
        color: #ca3145 !important;
        /* Teks merah lebih gelap saat hover */
    }

    /* Responsive */
    @media (max-width: 992px) {
        .pricing-card {
            flex: 0 0 calc(50% - 1rem);
        }
    }

    @media (max-width: 576px) {
        .pricing-card {
            flex: 0 0 100%;
        }
    }
</style> -->
<style>
    /* STYLE UNTUK FAQS */
    /* FAQ accordion styles (minimal & elegant) */
    .faqs-section .accordion-item {
        background: #fff;
        border: 1px solid #e6e9ee;
    }

    .faqs-section .accordion-header {
        padding: 1rem 1rem;
    }

    .faqs-section .accordion-header h4 {
        font-size: 1rem;
        margin: 0;
        font-weight: 600;
        color: #111827;
    }

    .faqs-section .accordion-header i.fas {
        color: #6b7280;
        transition: transform 0.25s ease;
    }

    .faqs-section .accordion-item.bg-indigo-50 {
        background-color: #f8fafc;
    }

    .faqs-section .accordion-content {
        padding: 0 1rem 1rem 1rem;
        color: #6b7280;
    }

    @media (min-width: 768px) {
        .faqs-section .accordion-header h4 {
            font-size: 1.05rem;
        }
    }
</style>
<style>
    /* ----------------- */
    /* CUSTOM PRICING STYLE */
    /* ----------------- */

    /* Gunakan CSS Variable agar mudah diubah */
    :root {
        --primary-color: #FF4C61;
        --primary-color-dark: #e53e4a;
        --secondary-color: #FF416C;
        /* Warna untuk tombol secondary */
        --light-color: #f8f9fa;
        --dark-color: rgba(86, 86, 86, 1);
        --text-muted: #6c757d;
    }

    /* --- Style untuk Tab Navigasi --- */
    .nav-pills .nav-link {
        border-radius: 50px;
        padding: 12px 28px;
        color: var(--dark-color);
        background-color: var(--light-color);
        border: 2px solid transparent;
        font-weight: 500;
        transition: all 0.3s ease;
        margin: 0 5px;
    }

    .nav-pills .nav-link:hover {
        background-color: #fff;
        border-color: var(--primary-color);
        transform: translateY(-2px);
    }

    .nav-pills .nav-link.active {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: #fff;
        box-shadow: 0 4px 15px rgba(255, 76, 97, 0.3);
    }

    /* --- Style untuk Container Tab --- */
    .tab-content {
        margin-top: 3rem;
    }

    /* --- Style untuk Grid Kartu --- */
    .pricing-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 2rem;
        margin-top: 2rem;
        justify-content: center;
    }

    @media (max-width: 1200px) {
        .pricing-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 992px) {
        .pricing-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 576px) {
        .pricing-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
    }

    /* --- Style untuk Kartu Harga (DIPERBAIKI) --- */
    .pricing-card {
        background-color: #fff;
        border-radius: 16px;
        padding: 2.5rem 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 2px solid transparent;
        position: relative;
        text-align: center;
        display: flex;
        flex-direction: column;
    }

    .pricing-card:hover {
        transform: translateY(-15px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
    }

    /* .pricing-card--featured {
        border-color: var(--primary-color);
        transform: scale(1.05);
    } */

    /* .pricing-card--featured::before {
        content: 'MOST POPULAR';
        position: absolute;
        top: -15px;
        left: 50%;
        transform: translateX(-50%);
        background-color: var(--primary-color);
        color: white;
        padding: 5px 20px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 1px;
    } */

    /* --- Typography di dalam Kartu --- */
    .pricing-card .card-title {
        font-size: 1.1rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 1.5rem;
    }

    .pricing-card h2 {
        font-size: 3rem;
        font-weight: 800;
        color: var(--dark-color);
        margin-bottom: 0.5rem;
    }

    .pricing-card .card-price-description {
        font-size: 1rem;
        color: var(--text-muted);
        margin-bottom: 2rem;
    }

    .pricing-card .desc-plan {
        font-size: 0.95rem;
        color: var(--text-muted);
        margin-bottom: 2.5rem;
        flex-grow: 1;
    }

    .pricing-card .card-features {
        list-style: none;
        padding: 0;
        text-align: left;
        margin-bottom: 2rem;
        flex-grow: 1;
    }

    .pricing-card .card-features li {
        padding: 0.75rem 0;
        border-bottom: 1px solid #f1f1f1;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
    }

    .pricing-card .card-features li:last-child {
        border-bottom: none;
    }

    .pricing-card .card-features li .feature-check {
        color: #28a745;
        margin-right: 1rem;
        font-size: 1.1rem;
    }

    /* --- Style untuk Container Tombol --- */
    .pricing-button-container {
        margin-top: auto;
        /* Dorong container tombol ke bawah */
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        /* Jarak antar tombol */
    }

    /* --- Style untuk Tombol --- */
    .pricing-button {
        width: 100%;
        padding: 15px 30px;
        border: none;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        /* text-transform: uppercase; */
        letter-spacing: 1px;
        text-decoration: none;
        /* Hapus underline untuk link */
        text-align: center;
        display: inline-block;
        /* Agar padding dan height bekerja dengan baik di link */
    }

    .pricing-button--primary {
        background-color: #FF4C61;
        color: #fff;
    }

    .pricing-card--featured .pricing-button--primary {
        background-color: var(--primary-color);
        box-shadow: 0 5px 15px rgba(255, 76, 97, 0.3);
    }

    .pricing-button--primary:hover {
        background-color: var(--primary-color-dark);
        transform: translateY(-3px);
        color: #fff;
    }

    .pricing-button--secondary {
        background-color: transparent;
        color: var(--secondary-color);
        border: 2px solid var(--secondary-color);
    }

    .pricing-button--secondary:hover {
        background-color: var(--secondary-color);
        color: #fff;
        transform: translateY(-3px);
    }

    .custom-button {
        padding: 10px 10px;
        border: none;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        letter-spacing: 1px;
        text-decoration: none;
        text-align: center;
        display: inline-block;
    }

    .custom-button--primary {
        background-color: #FF4C61;
        color: #fff;
    }

    .pricing-card--featured .custom-button--primary {
        background-color: var(--primary-color);
        box-shadow: 0 5px 15px rgba(255, 76, 97, 0.3);
    }

    .custom-button--primary:hover {
        background-color: #FF416C;
        transform: translateY(-3px);
        color: #fff;
    }
</style>
<div class="container">
    <section class="home-slider position-relative mb-30">
        <div>
            <div class="style-4">
                <div class="rectangle single-animation-wrap rounded mt-15" style="position: relative;">
                    <?php if($bannerData): ?>
                    <img src="<?php echo e(asset('storage/' . $bannerData->image)); ?>" alt="Banner" class="img-fluid w-100 rounded" id="pricing-banner-img" style="aspect-ratio: 2.5/1; object-fit: cover;">

                    <div id="pricing-banner-content" class="js-fade-in" style="
                        position: absolute; 
                        top: 0; 
                        left: 0; 
                        width: 100%; 
                        height: 100%; 
                        display: flex; 
                        flex-direction: column;
                        justify-content: center; 
                        align-items: center;
                        text-align: center;
                        color: white; 
                        padding: 20px;
                        opacity: 0;
                        transition: opacity 1s ease-in-out;
                    ">
                        <div style="max-width: 800px; width: 90%;">
                            <h1 class="mb-30">
                                <?php echo nl2br(e($bannerData->title)); ?>

                            </h1>
                            <?php if($bannerData->description): ?>
                            <p class="mb-65 lh-base" style="font-size: 25px;"><?php echo e($bannerData->description); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php else: ?>
                    <p>Banner pricing tidak ditemukan.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <!-- end banner pricing -->
    <section id="pricing-plans" class="benefits-section py-5">
        <div class="container text-center">
            <h3>Our Flexible Subscription Plans</h3>
            <p style="max-width: 50rem; margin: 0.5rem auto 0; text-align: center; color: #6b7280; margin-bottom: 3rem;">
                Choose the best plan to power your projects, from small personal websites to large-scale enterprise applications.
            </p>

            <?php if(isset($groupedSubscriptionPlans) && $groupedSubscriptionPlans->isNotEmpty()): ?>
            <!-- Tab Navigation (menggunakan nav-pills) -->
            <ul class="nav nav-pills justify-content-center mb-5" id="pricingTab" role="tablist">
                <?php $__currentLoopData = $groupedSubscriptionPlans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoryKey => $plans): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?php echo e($loop->first ? 'active' : ''); ?>" id="<?php echo e($categoryKey); ?>-tab" data-bs-toggle="pill" data-bs-target="#<?php echo e($categoryKey); ?>" type="button" role="tab" aria-controls="<?php echo e($categoryKey); ?>" aria-selected="<?php echo e($loop->first ? 'true' : 'false'); ?>">
                        <?php echo e(App\Models\SubscriptionPlan::CATEGORIES[$categoryKey] ?? ucfirst($categoryKey)); ?>

                    </button>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="pricingTabContent">
                <?php $__currentLoopData = $groupedSubscriptionPlans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoryKey => $plans): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="tab-pane fade <?php echo e($loop->first ? 'show active' : ''); ?>" id="<?php echo e($categoryKey); ?>" role="tabpanel" aria-labelledby="<?php echo e($categoryKey); ?>-tab">
                    <div class="pricing-grid">
                        <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="pricing-card <?php echo e($plan->is_featured ? 'pricing-card--featured' : ''); ?>">
                            <p class="card-title"><?php echo e($plan->name); ?></p>
                            <h2>Rp <?php echo e(number_format($plan->price, 0, ',', '.')); ?></h2>
                            <p class="card-price-description"><?php echo e($plan->price_description); ?></p>
                            <p class="desc-plan"><?php echo e(Str::limit($plan->description, 75)); ?></p>

                            <div class="pricing-button-container">
                                <?php if($user): ?>
                                <?php
                                // ✅ AMAN: semua dicek bertahap
                                $currentSub = $user->currentSubscription ?? null;
                                $isActive = $currentSub !== null;
                                $isCurrentPlan = $isActive && $currentSub->subscription_plan_id === $plan->id;
                                $currentPlan = $user->currentPlan ?? null;
                                ?>

                                <?php if($isActive): ?>
                                <?php if($isCurrentPlan): ?>
                                <!-- 🟢 RENEW -->
                                <!-- <button type="button" class="pricing-button pricing-button--primary w-100"
                                    data-bs-toggle="modal" data-bs-target="#renewModal-<?php echo e($plan->id); ?>">
                                    Renew Subscription
                                </button> -->
                                <a href="<?php echo e(route('simulate.renew', $plan->slug)); ?>"
                                    class="pricing-button pricing-button--primary w-100 text-white">
                                    <i class="fi-rs-sparkles me-1"></i> Simulate Renewal
                                </a>
                                <?php elseif($currentPlan && $plan->price > $currentPlan->price): ?>
                                <!-- 🔼 UPGRADE -->
                                <!-- <button type="button" class="pricing-button pricing-button--primary w-100"
                                    data-bs-toggle="modal" data-bs-target="#upgradeModal-<?php echo e($plan->id); ?>">
                                    Upgrade Subscription
                                </button> -->
                                <?php if(app()->environment('local')): ?>
                                <button type="button"
                                    class="pricing-button pricing-button--primary w-100"
                                    data-bs-toggle="modal"
                                    data-bs-target="#upgradeModal-<?php echo e($plan->id); ?>">
                                    Upgrade Subscription
                                </button>
                                <?php endif; ?>
                                <?php else: ?>
                                <!-- 🟡 SUDAH LEBIH MAHAL -->
                                <span class="text-muted small d-block text-center py-2">Already covered</span>
                                <?php endif; ?>
                                <?php else: ?>
                                <!-- 🔵 LANGGANAN BARU -->
                                <?php if(app()->environment('local')): ?>
                                <a href="<?php echo e(route('simulate.pay', $plan->slug)); ?>"
                                    class="pricing-button pricing-button--primary w-100 text-white">
                                    <i class="fi-rs-sparkles me-1"></i> Subscribe (Simulation)
                                </a>
                                <?php else: ?>
                                <button class="pricing-button pricing-button--primary w-100"
                                    onclick="subscribeWithMayar('<?php echo e($plan->id); ?>', this)">
                                    <?php echo e($plan->button_text ?? 'Subscribe Now'); ?>

                                </button>
                                <?php endif; ?>
                                <?php endif; ?>

                                <!-- 📞 WhatsApp (hanya untuk user login) -->
                                <?php
                                $waNumber = trim(app('settings')->get('whatsapp_number', '6289657571177'));
                                $waText = urlencode("Halo Admin, saya ingin berlangganan.\n\nNama\t: " . $user->name . "\nEmail\t: " . $user->email . "\nPaket\t: " . $plan->name . "\nHarga\t: Rp " . number_format($plan->price, 0, ',', '.') . "\n\nMohon bantuannya. Terima kasih!");
                                ?>
                                <a href="https://wa.me/<?php echo e($waNumber); ?>?text=<?php echo e($waText); ?>"
                                    class="btn bg-success text-white rounded-pill py-3 w-100 mb-2"
                                    target="_blank">
                                    <i class="bi bi-whatsapp"></i> Call Us - WhatsApp
                                </a>

                                <?php else: ?>
                                <!-- ❌ BELUM LOGIN -->
                                <a href="<?php echo e(route('login')); ?>" class="pricing-button pricing-button--primary w-100 text-white">
                                    Login to Subscribe
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>

                        
                        <?php if($user): ?>
                        
                        <?php if($user->currentSubscription && $user->currentSubscription->subscription_plan_id === $plan->id): ?>
                        <div class="modal fade" id="renewModal-<?php echo e($plan->id); ?>" tabindex="-1" data-bs-focus="false">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg">
                                    <div class="modal-header bg-gradient-success text-white p-4">
                                        <div>
                                            <h5 class="modal-title fw-bold">
                                                <i class="fi-rs-refresh me-2"></i> Renew <?php echo e($plan->name); ?>

                                            </h5>
                                            <small class="opacity-75">+<?php echo e($plan->duration_days); ?> days access</small>
                                        </div>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <div class="alert alert-light border-0 bg-light-subtle mb-4">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-success bg-opacity-10 p-2 rounded">
                                                    <i class="fi-rs-calendar-check text-success fs-4"></i>
                                                </div>
                                                <div class="ms-3">
                                                    <div class="fw-bold">Current Expiry</div>
                                                    <div><?php echo e($user->currentSubscription->end_date->format('d M Y')); ?></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center bg-white p-3 rounded border">
                                            <div>
                                                <div class="text-muted small">NEW EXPIRY</div>
                                                <div class="fw-bold">
                                                    <?php echo e($user->currentSubscription->end_date->addDays($plan->duration_days)->format('d M Y')); ?>

                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <div class="text-success fw-bold">+<?php echo e($plan->duration_days); ?> days</div>
                                            </div>
                                        </div>

                                        <div class="mt-4 text-center">
                                            <div class="display-6 fw-bold text-success">
                                                Rp <?php echo e(number_format($plan->price, 0, ',', '.')); ?>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer bg-light p-3">
                                        <?php if(app()->environment('local')): ?>
                                        <a href="<?php echo e(route('simulate.pay', $plan->slug)); ?>"
                                            class="pricing-button pricing-button--primary w-100 text-white">
                                            <i class="fi-rs-sparkles me-1"></i> Simulate Renewal
                                        </a>
                                        <?php else: ?>
                                        <form action="<?php echo e(route('api.subscription.create')); ?>" method="POST" class="w-100">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="plan_id" value="<?php echo e($plan->id); ?>">
                                            <button type="submit" class="pricing-button pricing-button--primary w-100 text-white">
                                                <i class="fi-rs-clock-six me-1"></i> Renew Now
                                            </button>
                                        </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        
                        <?php if($user->currentPlan && $plan->price > $user->currentPlan->price): ?>
                        <div class="modal fade" id="upgradeModal-<?php echo e($plan->id); ?>" tabindex="-1" data-bs-focus="false">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow-sm" style="border-radius: 1rem;">
                                    <!-- Header -->
                                    <div class="modal-header border-0 pb-0">
                                        <div class="flex-grow-1 mt-4">
                                            <h4 class="modal-title fw-bold mb-1">Upgrade to <?php echo e($plan->name); ?></h4>
                                            <p class="mb-0">Get more access with enhanced features</p>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <!-- Body -->
                                    <div class="modal-body px-4 pt-3 pb-4">
                                        <!-- Plan Comparison -->
                                        <div class="d-flex align-items-center justify-content-between mb-4 p-3 bg-light rounded-3">
                                            <div class="text-center flex-grow-1">
                                                <div class="text-muted small fw-medium mb-1">CURRENT PLAN</div>
                                                <h6 class="mb-1 fw-semibold"><?php echo e($user->currentPlan->name); ?></h6>
                                                <div class="text-dark fw-bold">
                                                    Rp <?php echo e(number_format($user->currentPlan->price, 0, ',', '.')); ?>

                                                </div>
                                            </div>
                                            <div class="px-3 text-muted">
                                                <i class="fi-rs-arrow-right"></i>
                                            </div>
                                            <div class="text-center flex-grow-1">
                                                <div class="text-primary small fw-medium mb-1">NEW PLAN</div>
                                                <h6 class="mb-1 fw-semibold text-primary"><?php echo e($plan->name); ?></h6>
                                                <div class="text-primary fw-bold">
                                                    Rp <?php echo e(number_format($plan->price, 0, ',', '.')); ?>

                                                </div>
                                            </div>
                                        </div>

                                        <!-- Features -->
                                        <?php if($plan->features && count($plan->features) > 0): ?>
                                        <div class="mb-4">
                                            <h6 class="fw-bold mb-3 d-flex align-items-center">
                                                You'll get :
                                            </h6>
                                            <ul class="list-unstyled mb-0">
                                                <?php $__currentLoopData = $plan->features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li class="mb-2 d-flex align-items-center">
                                                    <i class="fi-rs-check-circle text-success me-2 fs-6"></i>
                                                    <span><?php echo e($feature); ?></span>
                                                </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        </div>
                                        <?php endif; ?>

                                        <!-- Price Difference -->
                                        <?php
                                        $diff = $plan->price - $user->currentPlan->price;
                                        ?>
                                        <div class="bg-light rounded-3 p-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fw-medium">Additional payment :</span>
                                                <span class="fw-bold text-success fs-5">+Rp <?php echo e(number_format($diff, 0, ',', '.')); ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Footer -->
                                    <div class="modal-footer border-0 pt-0 px-4 pb-4">
                                        <div class="d-grid gap-2 w-100">
                                            <?php if(app()->environment('local')): ?>
                                            <a href="<?php echo e(route('simulate.upgrade', $plan->slug)); ?>"
                                                class="custom-button custom-button--primary px-4">
                                                Simulate Upgrade
                                            </a>
                                            <?php else: ?>
                                            <form action="<?php echo e(route('api.subscription.create')); ?>" method="POST" class="w-100">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="plan_id" value="<?php echo e($plan->id); ?>">
                                                <button type="submit" class="custom-button custom-button--primary px-4">
                                                    <i class="fi-rs-arrow-up me-2"></i> Upgrade Now
                                                </button>
                                            </form>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php else: ?>
            <p>Subscription plans are currently unavailable.</p>
            <?php endif; ?>
        </div>
    </section>
    <!-- end pricing cards-->
    <!-- Frequently Asked Questions - minimal, elegant, readable -->
    <section class="faqs-section py-5">
        <div class="container">
            <h3 class="text-center mb-3">Frequently Asked Questions</h3>
            <p class="text-center text-muted mb-4" style="max-width:54rem;margin:0 auto;">Common questions about subscriptions, billing, and accessing your guides. If you need further help, contact our support team.</p>

            <div class="accordion" role="tablist" style="max-width:900px;margin:0 auto;">
                <?php if($faqs && $faqs->isNotEmpty()): ?>
                <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="accordion-item rounded shadow-sm mb-3 p-0">
                    <div class="accordion-header d-flex justify-content-between align-items-center px-3 py-3" style="cursor:pointer;" onclick="toggleAccordion(this)">
                        <h6 class="mb-0"><?php echo e($faq->question); ?></h6>
                        <i class="fas fa-plus" aria-hidden="true"></i>
                    </div>
                    <div class="accordion-content" style="max-height:0px; overflow:hidden; padding:0 1rem;">
                        <p class="mb-3 mt-3"><?php echo e($faq->answer); ?></p>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                <p class="text-center">No pricing FAQs available at the moment.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <!-- end faqs-->
    <section class="newsletter mb-15 wow animate__animated animate__fadeIn">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="position-relative newsletter-inner" style="background-image: url('<?php echo e(asset($ctaBackground)); ?>'); background-size: cover; background-position: center; color: #ffffff; padding: 5rem 5rem 5rem 5rem; text-align: left; border-radius: 1rem;">
                        <div class="newsletter-content">
                            <h3 class="mb-20">
                                Still confused about which subscription<br />
                                package is right for you ?
                            </h3>
                            <p class="mb-45">Let's chat with the Gramedia team to ask for more information about the subscription packages. <br> <span class="text-brand">We are ready to help.</span></p>
                            <div style="display: flex; flex-direction: row; gap: 1rem; justify-content: flex-start; align-items: center; flex-wrap: nowrap;">
                                <a href="/subscription" class="btn-primary-custom" style="background-color: #FF4C61; color: white; border: none; padding: 0.8rem 1.8rem; border-radius: 0.5rem; font-size: 1rem; cursor: pointer; transition: background-color 0.3s ease, transform 0.2s ease; white-space: nowrap; text-decoration: none;">
                                    Subscribe Now
                                </a>
                                <a href="/contact" class="btn-secondary-custom" style="background-color: transparent; color: #FF4C61; border: 2px solid #FF4C61; padding: 0.8rem 1.8rem; border-radius: 0.5rem; font-size: 1rem; cursor: pointer; transition: background-color 0.3s ease, color 0.3s ease, transform 0.2s ease; white-space: nowrap; text-decoration: none;">
                                    Call Us
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    function showBannerText() {
        const textElement = document.querySelector('.js-fade-in');
        if (textElement) {
            textElement.style.opacity = 1;
        }
    }
    window.addEventListener('load', showBannerText);
</script>
<script>
    // script for faqs
    const accordionHeader = document.querySelectorAll(".accordion-header");
    accordionHeader.forEach((header) => {
        header.addEventListener("click", function() {
            const accordionContent = header.parentElement.querySelector(".accordion-content");
            let accordionMaxHeight = accordionContent.style.maxHeight;

            // Condition handling
            if (accordionMaxHeight == "0px" || accordionMaxHeight.length == 0) {
                // Close all open content first (optional, for a single-open accordion)
                document.querySelectorAll(".accordion-content").forEach(content => {
                    if (content !== accordionContent) {
                        content.style.maxHeight = `0px`;
                        content.parentElement.classList.remove("bg-indigo-50");
                        content.parentElement.querySelector(".fas").classList.remove("fa-minus");
                        content.parentElement.querySelector(".fas").classList.add("fa-plus");
                    }
                });


                // Open current content
                accordionContent.style.maxHeight = `${accordionContent.scrollHeight + 32}px`;
                header.querySelector(".fas").classList.remove("fa-plus");
                header.querySelector(".fas").classList.add("fa-minus");
                header.parentElement.classList.add("bg-indigo-50");
            } else {
                // Close current content
                accordionContent.style.maxHeight = `0px`;
                header.querySelector(".fas").classList.add("fa-plus");
                header.querySelector(".fas").classList.remove("fa-minus");
                header.parentElement.classList.remove("bg-indigo-50");
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const contentElement = document.getElementById('pricing-banner-content');
        if (contentElement) {
            // Gunakan setTimeout kecil untuk memastikan transisi berjalan
            setTimeout(() => {
                contentElement.style.opacity = '1';
            }, 100); // 100ms delay
        }
    });
</script>
<script>
    async function subscribeWithMayar(planId, buttonElement) {
        const originalText = buttonElement.innerText;
        buttonElement.disabled = true;
        buttonElement.innerText = 'Memproses...';

        try {
            const response = await fetch('/api/subscription/create', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                },
                body: JSON.stringify({
                    plan_id: planId
                })
            });

            // CEK 1: Jika response status-nya 500 (server error)
            if (response.status === 500) {
                throw new Error('Server mengalami kesalahan internal. Coba lihat log Laravel.');
            }

            // CEK 2: Jika response adalah redirect ke login (status 302)
            if (response.redirected && response.url.includes('login')) {
                window.location.href = response.url;
                return; // Hentikan eksekusi
            }

            // CEK 3: Jika response-nya bukan 200 OK
            if (!response.ok) {
                throw new Error(`Server error: ${response.status} ${response.statusText}`);
            }

            // Jika sampai sini, berarti response-nya OK dan berupa JSON
            const result = await response.json();

            if (result.success) {
                window.location.href = result.data.payment_url;
            } else {
                alert('Error: ' + result.message);
                buttonElement.disabled = false;
                buttonElement.innerText = originalText;
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan: ' + error.message);
            buttonElement.disabled = false;
            buttonElement.innerText = originalText;
        }
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts_lp.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJEK PROJEK\Ebook-Traveling\resources\views/pricing.blade.php ENDPATH**/ ?>