<?php $__env->startSection('title', 'Destinations - MeatMap'); ?>

<?php $__env->startSection('content'); ?>
<style>
    /* style untuk top 10 slider */
    .slider-container {
        position: relative;
        width: 100%;
        height: 600px;
        background: #f5f5f5;
        box-shadow: 0 30px 50px #dbdbdb;
        border-radius: 20px;
        overflow: hidden;
        margin: 50px auto;
    }

    .slider-container .slide .item {
        width: 200px;
        height: 300px;
        position: absolute;
        top: 50%;
        transform: translate(0, -50%);
        border-radius: 20px;
        /* box-shadow: 0 30px 50px #8c8c8c3e; */
        background-position: 50% 50%;
        background-size: cover;
        background-repeat: no-repeat;
        display: inline-block;
        transition: .5s;
    }

    .slide .item:nth-child(1),
    .slide .item:nth-child(2) {
        top: 0;
        left: 0;
        transform: translate(0, 0);
        border-radius: 0;
        width: 100%;
        height: 100%;
    }

    .slide .item:nth-child(2) .content {
        display: block;
    }

    .slide .item:nth-child(3) {
        left: 50%;
    }

    .slide .item:nth-child(4) {
        left: calc(50% + 220px);
    }

    .slide .item:nth-child(5) {
        left: calc(50% + 440px);
    }

    .slide .item:nth-child(n + 6) {
        left: calc(50% + 440px);
        overflow: hidden;
    }

    .item .content {
        position: absolute;
        top: 50%;
        left: 100px;
        width: 400px;
        text-align: left;
        color: #eee;
        transform: translate(0, -50%);
        font-family: 'Poppins', sans-serif;
        display: none;
    }

    .content .name {
        font-size: 40px;
        text-transform: uppercase;
        font-weight: bold;
        opacity: 0;
        margin-bottom: 20px;
        animation: animate 1s ease-in-out 1 forwards;
        color: white;
    }

    .content .description {
        margin-top: 10px;
        margin-bottom: 20px;
        opacity: 0;
        animation: animate 1s ease-in-out .3s 1 forwards;
        font-size: 21px;
        line-height: 1.6;
        max-width: 380px;
        font-weight: 400;
        color: white;
    }

    .content button {
        padding: 12px 25px;
        border: none;
        cursor: pointer;
        opacity: 0;
        animation: animate 1s ease-in-out .6s 1 forwards;
        background: #FF4C61;
        color: white;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .content button:hover {
        background: #e04355;
        transform: translateY(-2px);
    }

    @keyframes animate {
        from {
            opacity: 0;
            transform: translate(0, 100px);
            filter: blur(33px);
        }

        to {
            opacity: 1;
            transform: translate(0);
            filter: blur(0);
        }
    }

    .slider-button {
        width: 100%;
        text-align: center;
        position: absolute;
        bottom: 20px;
        z-index: 10;
    }

    .slider-button button {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        border: none;
        cursor: pointer;
        margin: 0 10px;
        background: #F2F3F4;
        color: #7E7E7E;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .slider-button button:hover {
        background: #FF4C61;
        color: white;
        transform: scale(1.05);
    }

    /* Overlay untuk readability */
    .item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, rgba(0, 0, 0, 0.3) 0%, rgba(0, 0, 0, 0.1) 100%);
        border-radius: inherit;
    }

    .item .content {
        z-index: 2;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .slider-container {
            height: 500px;
            margin: 30px auto;
        }

        .item .content {
            left: 50px;
            width: 320px;
        }

        .content .name {
            font-size: 30px;
        }

        .content .description {
            font-size: 16px;
            max-width: 300px;
        }
    }

    @media (max-width: 576px) {
        .slider-container {
            height: 400px;
        }

        .item .content {
            left: 30px;
            width: 280px;
        }

        .content .name {
            font-size: 24px;
        }

        .content .description {
            font-size: 15px;
            max-width: 260px;
            margin-top: 10px;
            margin-bottom: 20px;
        }
    }
</style>
<style>
    /* Combined Destination Cards Style */
    .destination-card {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 8px 20px rgba(16, 24, 40, 0.06);
        margin-bottom: 1.25rem;
        transition: all 0.3s ease;
    }

    .destination-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .destination-thumb {
        height: 170px;
        background-position: center;
        background-size: cover;
        transition: transform 0.3s ease;
        border-radius: 12px 12px 0 0;
    }

    .destination-card:hover .destination-thumb {
        transform: scale(1.05);
    }

    .destination-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        background: #FF4C61;
        color: #fff;
        padding: 6px 10px;
        border-radius: 999px;
        font-weight: 700;
        font-size: 0.9rem;
        box-shadow: 0 6px 18px rgba(255, 76, 97, 0.18);
        z-index: 2;
    }

    .destination-content {
        padding: 12px 14px 8px 12px;
    }

    .destination-title {
        font-size: 1rem;
        font-weight: 600;
        margin: 0 0 6px;
        color: #0f172a;
    }

    .destination-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
        color: #6b7280;
    }

    .destination-stars {
        color: #FFB74D;
    }

    .destination-stars i {
        color: #FFB74D;
        margin-right: 2px;
    }

    .destination-rating {
        font-weight: 600;
        color: #111827;
        margin-left: 6px;
    }

    @media(min-width:1200px) {
        .col-xl-3 {
            flex: 0 0 25%;
            max-width: 25%;
        }
    }
</style>

<!-- top 10 city slider -->
<div class="container">
    <!-- Ini adalah wadah utama slider, class-nya TIDAK BOLEH BERUBAH -->
    <div class="slider-container">
        <!-- Ini adalah wadah untuk slide-slide, class-nya TIDAK BOLEH BERUBAH -->
        <div class="slide">
            <?php $__empty_1 = true; $__currentLoopData = $popularCities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <!-- Ini adalah item slide untuk setiap kota, class-nya TIDAK BOLEH BERUBAH -->
            <!-- Kita tambahkan style inline untuk background image yang dinamis -->
            <div class="item" style="background-image: url('<?php echo e(asset($city->image)); ?>');">
                <!-- Ini adalah konten di dalam slide, class-nya TIDAK BOLEH BERUBAH -->
                <div class="content">
                    <h2 class="name"><?php echo e($city->name); ?></h2>
                    <p class="description"><?php echo e(Str::limit($city->description, 150)); ?></p>
                    <!-- Kita gunakan button agar sesuai dengan CSS, dan tambahkan onclick untuk navigasi -->
                    <button onclick="window.location.href='<?php echo e(route('destination.show', $city->slug)); ?>'">
                        Explore Now
                    </button>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <!-- Ini adalah fallback jika tidak ada kota populer -->
            <div class="item" style="background-image: url('https://via.placeholder.com/1200x600.png?text=No+Destinations');">
                <div class="content">
                    <h2 class="name">Discover Your Journey</h2>
                    <p class="description">Popular destinations will be shown here.</p>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Ini adalah tombol navigasi, class-nya TIDAK BOLEH BERUBAH -->
        <!-- JS Anda membutuhkan tombol dengan class .next dan .prev -->
        <div class="slider-button">
            <button class="prev">
                <i class="fi-rs-arrow-left"></i>
            </button>
            <button class="next">
                <i class="fi-rs-arrow-right"></i>
            </button>
        </div>
    </div>
</div>

<!-- cards -->
<section class="destinations-cards py-5">
    <div class="container">
        <div class="text-center mb-10">
            <h3 class="mb-4">Destinations Across Indonesia</h3>
            <p class="mb-4 mx-auto" style="max-width:50rem;">
                Explore diverse destinations from beaches to cities — discover hidden gems and popular spots with authentic local experiences.
            </p>
        </div>
        <div class="row">
            <?php $__empty_1 = true; $__currentLoopData = $allCities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-lg-3 col-md-4 col-sm-6">
                
                <a href="<?php echo e(route('destination.show', $city->slug)); ?>" class="text-decoration-none">
                    <div class="destination-card position-relative">
                        <div class="destination-thumb" style="background-image:url('<?php echo e(asset($city->image)); ?>');"></div>

                        <?php if($city->is_popular && $city->order_index <= 10): ?>
                            <span class="destination-badge">#<?php echo e($city->order_index); ?></span>
                        <?php endif; ?>

                            <div class="destination-content">
                                <div class="destination-title"><?php echo e($city->name); ?></div>
                            </div>
                    </div>
                </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12 text-center py-5">
                <p>No destinations found.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let next = document.querySelector('.next');
        let prev = document.querySelector('.prev');

        next.addEventListener('click', function() {
            let items = document.querySelectorAll('.item');
            document.querySelector('.slide').appendChild(items[0]);
        })

        prev.addEventListener('click', function() {
            let items = document.querySelectorAll('.item');
            document.querySelector('.slide').prepend(items[items.length - 1]);
        })
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts_lp.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views/destinations.blade.php ENDPATH**/ ?>