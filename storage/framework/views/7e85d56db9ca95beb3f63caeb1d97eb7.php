<!DOCTYPE html>
<html lang="en" class="light-style layout-navbar-fixed layout-wide" dir="ltr" data-theme="theme-default">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Access Forbidden - <?php echo e(config('app.name')); ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('assets/admin/img/favicon/favicon.ico')); ?>" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/admin/vendor/css/rtl/core.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('assets/admin/vendor/css/rtl/theme-default.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('assets/admin/css/demo.css')); ?>" />
</head>

<body>
    <!-- Content -->
    <div class="container-xxl container-p-y">
        <div class="misc-wrapper">
            <div class="text-content">
                <h1 class="mb-2" style="font-size: 6rem; line-height: 6rem;">403</h1>
                <h4 class="mb-2">Akses Ditolak! 🔐</h4>
                <p class="mb-4">Anda tidak memiliki permission untuk mengakses halaman ini.</p>
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-primary waves-effect waves-light">
                    Kembali ke Dashboard
                </a>
            </div>
            <div class="image-content">
                <img src="<?php echo e(asset('assets/admin/img/illustrations/girl-unlock-password-light.png')); ?>"
                    alt="girl-unlock-password-light"
                    width="350"
                    class="img-fluid">
            </div>
        </div>
    </div>
    <!-- / Content -->

    <style>
        body {
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container-xxl {
            padding: 0 !important;
        }
        .misc-wrapper {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            gap: 4rem;
            min-height: 100vh;
            padding: 2rem;
            margin-top: -4rem;
        }
        
        .text-content {
            text-align: left;
            max-width: 500px;
        }
        
        .image-content {
            flex-shrink: 0;
        }
        
        .misc-wrapper h1 {
            font-weight: 700;
            color: #7367f0;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 1rem;
        }
        
        .misc-wrapper h4 {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #5e5873;
        }
        
        .misc-wrapper p {
            color: #6e6b7b;
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
        }
        
        @media (max-width: 768px) {
            .misc-wrapper {
                flex-direction: column;
                text-align: center;
            }
            .text-content {
                text-align: center;
            }
        }
    </style>
</body>
</html>
<?php /**PATH C:\laragon\www\ebook_traveling\resources\views/errors/403.blade.php ENDPATH**/ ?>