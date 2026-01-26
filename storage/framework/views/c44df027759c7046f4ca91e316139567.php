<!DOCTYPE html>
<html lang="en" class="light-style layout-navbar-fixed layout-wide" dir="ltr" data-theme="theme-default">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Internal Server Error - <?php echo e(config('app.name')); ?></title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('images/only-logoo.png')); ?>" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/admin/vendor/css/rtl/core.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('assets/admin/vendor/css/rtl/theme-default.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('assets/admin/css/demo.css')); ?>" />
</head>

<body>
    <!-- Content -->
    <div class="container-xxl container-p-y">
        <div class="misc-wrapper">
            <h1 class="mb-2 mx-2 text-primary" style="font-size: 6rem; line-height: 6rem;">500</h1>
            <h4 class="mb-2">Terjadi Kesalahan Server</h4>
            <p class="mb-6 mx-2">Maaf, terjadi kesalahan pada server. Tim kami sedang memperbaikinya.</p>
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-primary mb-6 waves-effect waves-light">
                Back to Dashboard
            </a>
            <!-- <div class="mt-12">
                <img src="<?php echo e(asset('assets/admin/img/illustrations/page-misc-error-light.png')); ?>"
                    alt="page-misc-error-light"
                    width="250"
                    class="img-fluid">
            </div> -->
        </div>
    </div>
    <!-- / Content -->

    <style>
        body {
            background-color: #f8f9fa;
        }

        .misc-wrapper {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            text-align: center;
            padding: 2rem;
        }

        .misc-wrapper h1 {
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .misc-wrapper h4 {
            font-weight: 600;
            margin-bottom: 1rem;
            color: #5e5873;
        }

        .misc-wrapper p {
            color: #6e6b7b;
            font-size: 1.1rem;
            max-width: 500px;
        }
    </style>
</body>

</html>
<?php /**PATH C:\laragon\www\ebook_traveling\resources\views\errors\500.blade.php ENDPATH**/ ?>