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
                <section class="row align-items-center mb-50">
                    <div class="col-lg-6">
                        <img src="/images/blogs/6.webp" alt="" class="border-radius-15 mb-md-3 mb-lg-0 mb-sm-4" />
                    </div>
                    <div class="col-lg-6">
                        <div class="pl-25">
                            <h2 class="mb-30">Welcome to MeatMap</h2>
                            <p class="mb-25">We are a premium platform dedicated to travel enthusiasts. We provide an exclusive collection of Travel ebooks with a simple and affordable monthly subscription model. Our goal is to be the most complete and reliable source of information for every adventurer, offering guides, inspiration, and travel stories from various destinations worldwide.</p>
                            <p class="mb-50">The shopping and reading experience is designed to be as easy as possible, starting from the main page which presents various ebook categories per destination, up to a fast and integrated subscription process.</p>
                            <div class="carausel-3-columns-cover position-relative">
                                <div id="carausel-3-columns-arrows"></div>
                                <div class="carausel-3-columns" id="carausel-3-columns">
                                    <img src="/images/blogs/1.webp" alt="" />
                                    <img src="/images/blogs/2.webp" alt="" />
                                    <img src="/images/blogs/3.webp" alt="" />
                                    <img src="/images/blogs/4.webp" alt="" />
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
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
                <section class="row align-items-center mb-50">
                    <div class="row mb-50 align-items-center">
                        <div class="col-lg-7 pr-30">
                            <img src="assets-nest/nest-fe/imgs/page/about-5.png" alt="" class="mb-md-3 mb-lg-0 mb-sm-4" />
                        </div>
                        <div class="col-lg-5">
                            <h4 class="mb-20 text-muted">Our performance</h4>
                            <h1 class="heading-1 mb-40">Your Partner for e-commerce grocery solution</h1>
                            <p class="mb-30">Ed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto</p>
                            <p>Pitatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 pr-30 mb-md-5 mb-lg-0 mb-sm-5">
                            <h3 class="mb-30">Who we are</h3>
                            <p>Volutpat diam ut venenatis tellus in metus. Nec dui nunc mattis enim ut tellus eros donec ac odio orci ultrices in. ellus eros donec ac odio orci ultrices in.</p>
                        </div>
                        <div class="col-lg-4 pr-30 mb-md-5 mb-lg-0 mb-sm-5">
                            <h3 class="mb-30">Our history</h3>
                            <p>Volutpat diam ut venenatis tellus in metus. Nec dui nunc mattis enim ut tellus eros donec ac odio orci ultrices in. ellus eros donec ac odio orci ultrices in.</p>
                        </div>
                        <div class="col-lg-4">
                            <h3 class="mb-30">Our mission</h3>
                            <p>Volutpat diam ut venenatis tellus in metus. Nec dui nunc mattis enim ut tellus eros donec ac odio orci ultrices in. ellus eros donec ac odio orci ultrices in.</p>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts_lp.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJEK PROJEK\Ebook-Traveling\resources\views/about-us.blade.php ENDPATH**/ ?>