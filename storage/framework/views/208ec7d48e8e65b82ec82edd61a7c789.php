<section class="banners mb-25">
    <div class="container">
        <div class="row">
            <div class="section-title style-2">
                <div class="title">
                    <h3>Subscription Plans</h3>
                </div>
                <a href="<?php echo e(route('pricing')); ?>" class="show-all">View All</a>
            </div>

            <?php
                // Fallback jika $subscriptionPlans tidak ada
                if (!isset($subscriptionPlans)) {
                    $subscriptionPlans = app(\App\Services\SubscriptionPlanService::class)->getHomepagePlans(3);
                }
            ?>

            <?php $__currentLoopData = $subscriptionPlans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    // Tentukan class col untuk responsive design
                    $colClass = 'col-lg-4 ';
                    $colClass .= $index == 2 ? 'd-md-none d-lg-flex' : 'col-md-6';

                    // Tentukan delay untuk animation
                    $delay = $index * 0.2;
                ?>

                <div class="<?php echo e($colClass); ?>">
                    <div class="banner-img wow animate__animated animate__fadeInUp" data-wow-delay="<?php echo e($delay); ?>s">
                        <a href="<?php echo e(route('pricing')); ?>">
                            <img src="<?php echo e(asset($plan->image)); ?>" alt="<?php echo e($plan->name); ?>" />
                        </a>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>
    </div>
</section>
<?php /**PATH C:\laragon\www\ebook_traveling\resources\views/components/landing/subscription-plans.blade.php ENDPATH**/ ?>