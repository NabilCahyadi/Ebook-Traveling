<!doctype html>
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="<?php echo e(url('assets/admin/')); ?>/" data-template="vertical-menu-template"
    data-style="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title><?php echo $__env->yieldContent('title', 'Dashboard'); ?> - <?php echo e(config('app.name')); ?></title>
    <meta name="description" content="<?php echo $__env->yieldContent('meta_description', ''); ?>" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo e(url('assets/admin/img/favicon/favicon.ico')); ?>" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="<?php echo e(url('assets/admin/vendor/fonts/fontawesome.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(url('assets/admin/vendor/fonts/tabler-icons.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(url('assets/admin/vendor/fonts/flag-icons.css')); ?>" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?php echo e(url('assets/admin/vendor/css/core.css')); ?>" class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?php echo e(url('assets/admin/vendor/css/theme-default.css')); ?>"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?php echo e(url('assets/admin/css/demo.css')); ?>" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?php echo e(url('assets/admin/vendor/libs/node-waves/node-waves.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(url('assets/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(url('assets/admin/vendor/libs/typeahead-js/typeahead.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(url('assets/admin/vendor/libs/apex-charts/apex-charts.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(url('assets/admin/vendor/libs/swiper/swiper.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(url('assets/admin/vendor/libs/datatables-bs5/datatables.bootstrap5.css')); ?>" />
    <link rel="stylesheet"
        href="<?php echo e(url('assets/admin/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')); ?>" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="<?php echo e(url('assets/admin/vendor/css/pages/cards-advance.css')); ?>" />


    <!-- Helpers -->
    <script src="<?php echo e(url('assets/admin/vendor/js/helpers.js')); ?>"></script>
    <script src="<?php echo e(url('assets/admin/vendor/js/template-customizer.js')); ?>"></script>
    <script src="<?php echo e(url('assets/admin/js/config.js')); ?>"></script>
       <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            <?php echo $__env->make('layouts.partials.admin.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                <?php echo $__env->make('layouts.partials.admin.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <?php echo $__env->yieldContent('content'); ?>
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <?php echo $__env->make('layouts.partials.admin.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <script src="<?php echo e(url('assets/admin/vendor/libs/jquery/jquery.js')); ?>"></script>
    <script src="<?php echo e(url('assets/admin/vendor/libs/popper/popper.js')); ?>"></script>
    <script src="<?php echo e(url('assets/admin/vendor/js/bootstrap.js')); ?>"></script>
    <script src="<?php echo e(url('assets/admin/vendor/libs/node-waves/node-waves.js')); ?>"></script>
    <script src="<?php echo e(url('assets/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')); ?>"></script>
    <script src="<?php echo e(url('assets/admin/vendor/libs/hammer/hammer.js')); ?>"></script>
    <script src="<?php echo e(url('assets/admin/vendor/libs/typeahead-js/typeahead.js')); ?>"></script>
    <script src="<?php echo e(url('assets/admin/vendor/js/menu.js')); ?>"></script>

    <!-- Main JS -->
    <script src="<?php echo e(url('assets/admin/js/main.js')); ?>"></script>

    <!-- CSRF Token Setup for AJAX -->
    <script>
        // Setup CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Intercept AJAX errors
        $(document).ajaxError(function(event, jqxhr, settings, thrownError) {
            if (jqxhr.status === 419) {
                alert('Your session has expired. Please refresh the page.');
                location.reload();
            }
        });
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html>
<?php /**PATH C:\laragon\www\ebook_traveling\resources\views/layouts/admin.blade.php ENDPATH**/ ?>