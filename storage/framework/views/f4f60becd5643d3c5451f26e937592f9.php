<section class="popular-categories section-padding">
    <div class="container wow animate__animated animate__fadeIn">
        <div class="section-title style-2 flex-container-custom">
            <div class="title">
                <h3>Top 10 City Guides</h3>
            </div>
            <a href="/destinations" class="show-all">View All</a>
        </div>
        <div class="slider-arrow slider-arrow-2 flex carausel-10-columns-arrow"></div>
        <div class="carausel-10-columns-cover position-relative">
            <div class="carausel-10-columns" id="carausel-10-columns">

                <?php $__currentLoopData = $topCities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="card-2 bg-12 wow animate__animated animate__fadeInUp"
                        data-wow-delay="<?php echo e(($index + 1) * 0.1); ?>s">
                        <figure class="img-hover-scale overflow-hidden"
                            style="width: 100px; height: 120px; margin: 0 auto 10px; border-radius: 8px;">
                            <a href="/destination/<?php echo e($city->slug); ?>">
                                <img src="<?php echo e(asset($city->image)); ?>" alt="<?php echo e($city->name); ?>"
                                    style="width: 100%; height: 100%; object-fit: cover;" />
                            </a>
                        </figure>
                        <h6>
                            <a href="/destination/<?php echo e($city->slug); ?>"><?php echo e($city->name); ?></a>
                        </h6>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>
        </div>
    </div>
</section>
<?php /**PATH C:\laragon\www\ebook_traveling\resources\views/components/landing/top-cities.blade.php ENDPATH**/ ?>