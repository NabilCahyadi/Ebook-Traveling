

<?php $__env->startSection('title', 'Home'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="mt-50 mb-50">Welcome to <?php echo e(config('app.name')); ?></h1>
                <p>This is the home page using the Front (Nest) template for regular users.</p>

                <div class="alert alert-info">
                    <strong>Template Info:</strong> This page uses the <strong>Front Template (Nest)</strong>
                    which is stored in <code>resources/views/layouts/front.blade.php</code>
                </div>

                <h3>Template Features:</h3>
                <ul>
                    <li>Header with navigation</li>
                    <li>Shopping cart integration</li>
                    <li>Wishlist functionality</li>
                    <li>User account access</li>
                    <li>Responsive design</li>
                    <li>Footer with newsletter</li>
                </ul>

                <h3>Quick Links:</h3>
                <div class="mt-30">
                    <a href="<?php echo e(route('shop.index')); ?>" class="btn btn-primary">Browse Shop</a>
                    <a href="<?php echo e(route('blog.index')); ?>" class="btn btn-secondary">Read Blog</a>
                    <a href="<?php echo e(route('page.about')); ?>" class="btn btn-info">About Us</a>
                    <a href="<?php echo e(route('page.contact')); ?>" class="btn btn-warning">Contact</a>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\front\index.blade.php ENDPATH**/ ?>