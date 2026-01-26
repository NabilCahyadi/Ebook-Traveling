<?php $__env->startSection('title', 'About Us - MeatMap'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .featured-card img {
        width: 60px;
        height: 60px;
        margin-bottom: 20px;
    }
</style>
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
<div class="page-content pt-50">
    <div class="container">
        <div class="row">
            <div class="col-xl-10 col-lg-12 m-auto">
                <!-- SECTION 1: WELCOME -->
                <?php if(isset($aboutSections['welcome'])): ?>
                <section class="row align-items-center mb-50">
                    <div class="col-lg-6">
                        <img src="<?php echo e(asset($aboutSections['welcome']->image)); ?>" alt="<?php echo e($aboutSections['welcome']->title); ?>" class="border-radius-15 mb-md-3 mb-lg-0 mb-sm-4" />
                    </div>
                    <div class="col-lg-6">
                        <div class="pl-25">
                            <h2 class="mb-30"><?php echo e($aboutSections['welcome']->title); ?></h2>
                            <?php echo $aboutSections['welcome']->content; ?>

                            <div class="carausel-3-columns-cover position-relative">
                                <div id="carausel-3-columns-arrows"></div>
                                <div class="carausel-3-columns" id="carausel-3-columns">
                                    <?php if($latestBlogImages && $latestBlogImages->isNotEmpty()): ?>
                                    <?php $__currentLoopData = $latestBlogImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blogImage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <img src="<?php echo e(asset($blogImage)); ?>" alt="Latest Blog Image" />
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                    <!-- Tampilkan gambar default jika tidak ada blog -->
                                    <img src="/images/blogs/1.webp" alt="Default Image" />
                                    <img src="/images/blogs/1.webp" alt="Default Image" />
                                    <img src="/images/blogs/1.webp" alt="Default Image" />
                                    <img src="/images/blogs/1.webp" alt="Default Image" />
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <?php endif; ?>

                <!-- SECTION BENEFITS (sudah dinamis) -->
                <section class="benefits-section py-5">
                    <div class="container text-center">
                        <h3 class="mb-40">Why Choose Our MeatMap Guides ?</h3>
                        <?php if($benefits && $benefits->isNotEmpty()): ?>
                        <div class="row justify-content-center">
                            <?php $__currentLoopData = $benefits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $benefit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-4 mb-4">
                                <div class="benefit-card p-4 rounded shadow-sm">
                                    <div class="icon-wrapper mb-3">
                                        <i class="<?php echo e($benefit->icon); ?>"></i>
                                    </div>
                                    <h3 class="h5 mb-2"><?php echo e($benefit->title); ?></h3>
                                    <p class="text-muted"><?php echo e($benefit->description); ?></p>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <?php else: ?>
                        <p>Benefits information is currently unavailable.</p>
                        <?php endif; ?>
                    </div>
                </section>

                <!-- SECTION 2: PERFORMANCE & ABOUT DETAILS -->
                <?php if(isset($aboutSections['performance']) && isset($aboutSections['about_details'])): ?>
                <section class="row align-items-center mb-50">
                    <div class="row mb-50 align-items-center">
                        <div class="col-lg-7 pr-30">
                            <img src="<?php echo e(asset($aboutSections['performance']->image)); ?>" alt="<?php echo e($aboutSections['performance']->title); ?>" class="mb-md-3 mb-lg-0 mb-sm-4" />
                        </div>
                        <div class="col-lg-5">
                            <h4 class="mb-20 text-muted">Our performance</h4>
                            <h1 class="heading-1 mb-40"><?php echo e($aboutSections['performance']->title); ?></h1>
                            <?php echo $aboutSections['performance']->content; ?>

                        </div>
                    </div>
                    <?php
                    // Decode JSON untuk 3 kolom
                    $details = json_decode($aboutSections['about_details']->content, true);
                    ?>
                    <div class="row">
                        <?php $__currentLoopData = $details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-lg-4 pr-30 mb-md-5 mb-lg-0 mb-sm-5">
                            <h3 class="mb-30"><?php echo e($detail['title']); ?></h3>
                            <p><?php echo e($detail['description']); ?></p>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </section>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts_lp.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\about-us.blade.php ENDPATH**/ ?>