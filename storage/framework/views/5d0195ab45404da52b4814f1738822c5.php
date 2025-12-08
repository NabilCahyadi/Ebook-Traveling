<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Authentication'); ?> - <?php echo e(config('app.name')); ?></title>

    <!-- Font Awesome -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css'>

    <!-- Auth Template CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/auth/style.css')); ?>">

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body>
    <?php echo $__env->yieldContent('content'); ?>

    <!-- Auth Template JS -->
    <script src="<?php echo e(asset('assets/auth/script.js')); ?>"></script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html>
<?php /**PATH C:\laragon\www\ebook_traveling\resources\views/layouts/auth.blade.php ENDPATH**/ ?>