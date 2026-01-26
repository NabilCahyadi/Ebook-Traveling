

<?php $__env->startSection('title', 'Dashboard - Ebook Traveling'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-4">Dashboard</h1>
                <div class="alert alert-success">
                    <h4>Welcome, <?php echo e(auth()->user()->name); ?>!</h4>
                    <p>You are logged in as a regular user.</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">My Books</h5>
                        <p class="card-text">View and manage your purchased ebooks.</p>
                        <a href="#" class="btn btn-primary">View Books</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Reading History</h5>
                        <p class="card-text">Track your reading progress.</p>
                        <a href="#" class="btn btn-primary">View History</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Profile Settings</h5>
                        <p class="card-text">Update your account information.</p>
                        <a href="#" class="btn btn-primary">Edit Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\user\dashboard.blade.php ENDPATH**/ ?>