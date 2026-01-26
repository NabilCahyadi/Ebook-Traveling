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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

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

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />

    <!-- Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    
    <!-- Custom Toastr CSS -->
    <style>
        #toast-container > div {
            opacity: 1;
            box-shadow: 0 0 12px rgba(0,0,0,0.2);
        }
        #toast-container > .toast {
            background-image: none !important;
        }
        #toast-container > .toast-success {
            background-color: #51A351;
        }
        #toast-container > .toast-error {
            background-color: #BD362F;
        }
        #toast-container > .toast-info {
            background-color: #2F96B4;
        }
        #toast-container > .toast-warning {
            background-color: #F89406;
        }
        .toast-message {
            font-weight: normal;
        }
        .toast-title {
            font-weight: bold;
        }
    </style>

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
            <?php echo $__env->make('layouts.partials.panel.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

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

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Moment.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

    <!-- Configure Toastr -->
    <script>
        // Pastikan jQuery dan Toastr loaded
        if (typeof jQuery === 'undefined') {
            console.error('jQuery is not loaded!');
        }
        if (typeof toastr === 'undefined') {
            console.error('Toastr is not loaded!');
        } else {
            console.log('Toastr loaded successfully');
        }

        // Konfigurasi Toastr agar mengambang
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut",
            "tapToDismiss": true
        };

        // Test toastr
        console.log('Toastr options:', toastr.options);

        // Tampilkan notifikasi dari session
        <?php if(session('success')): ?>
            console.log('Session success:', "<?php echo addslashes(session('success')); ?>");
            toastr.success("<?php echo addslashes(session('success')); ?>", "Success");
        <?php endif; ?>

        <?php if(session('error')): ?>
            console.log('Session error:', "<?php echo addslashes(session('error')); ?>");
            toastr.error("<?php echo addslashes(session('error')); ?>", "Error");
        <?php endif; ?>

        <?php if(session('warning')): ?>
            console.log('Session warning:', "<?php echo addslashes(session('warning')); ?>");
            toastr.warning("<?php echo addslashes(session('warning')); ?>", "Warning");
        <?php endif; ?>

        <?php if(session('info')): ?>
            console.log('Session info:', "<?php echo addslashes(session('info')); ?>");
            toastr.info("<?php echo addslashes(session('info')); ?>", "Info");
        <?php endif; ?>
    </script>

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

        // Notification Center
        function loadNotifications() {
            $.ajax({
                url: '<?php echo e(route('panel.notifications.recent')); ?>',
                method: 'GET',
                success: function(response) {
                    const notifications = response.notifications;
                    const unreadCount = response.unread_count;
                    
                    // Update unread count
                    if (unreadCount > 0) {
                        $('#unreadCount').text(unreadCount + ' new');
                        $('#notificationBadge').removeClass('d-none');
                    } else {
                        $('#unreadCount').text('0');
                        $('#notificationBadge').addClass('d-none');
                    }
                    
                    // Update notifications list
                    if (notifications.length === 0) {
                        $('#notificationsList').html(`
                            <li class="list-group-item text-center py-4">
                                <i class="ti ti-bell-off ti-lg text-muted mb-2 d-block"></i>
                                <p class="text-muted mb-0">No notifications</p>
                            </li>
                        `);
                    } else {
                        let html = '';
                        notifications.forEach(function(userNotif) {
                            const notif = userNotif.notification;
                            const isRead = userNotif.is_read;
                            const createdAt = moment(userNotif.created_at).fromNow();
                            
                            const iconMap = {
                                'success': 'ti-check',
                                'info': 'ti-info-circle',
                                'warning': 'ti-alert-triangle',
                                'danger': 'ti-alert-circle',
                                'order': 'ti-shopping-cart',
                                'user': 'ti-user',
                                'ebook': 'ti-book'
                            };
                            
                            const colorMap = {
                                'success': 'success',
                                'info': 'info',
                                'warning': 'warning',
                                'danger': 'danger',
                                'order': 'primary',
                                'user': 'secondary',
                                'ebook': 'info'
                            };
                            
                            const icon = iconMap[notif.icon] || 'ti-bell';
                            const color = colorMap[notif.icon] || 'secondary';
                            
                            html += `
                                <li class="list-group-item list-group-item-action dropdown-notifications-item ${!isRead ? 'bg-label-primary' : ''}" 
                                    data-id="${userNotif.id}" 
                                    style="cursor: pointer;">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="avatar">
                                                <span class="avatar-initial rounded-circle bg-label-${color}">
                                                    <i class="ti ${icon}"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="small mb-1 ${!isRead ? 'fw-bold' : ''}">${notif.title}</h6>
                                            <small class="mb-1 d-block text-body">${notif.message}</small>
                                            <small class="text-muted">${createdAt}</small>
                                        </div>
                                        ${!isRead ? '<div class="flex-shrink-0"><span class="badge badge-dot bg-primary"></span></div>' : ''}
                                    </div>
                                </li>
                            `;
                        });
                        $('#notificationsList').html(html);
                    }
                }
            });
        }

        // Mark notification as read on click
        $(document).on('click', '.dropdown-notifications-item', function() {
            const notifId = $(this).data('id');
            const $item = $(this);
            
            $.ajax({
                url: '/admin/notifications/' + notifId + '/mark-as-read',
                method: 'POST',
                success: function() {
                    $item.removeClass('bg-label-primary');
                    $item.find('.fw-bold').removeClass('fw-bold');
                    $item.find('.badge-dot').remove();
                    loadNotifications();
                }
            });
        });

        // Mark all as read
        $('#markAllAsRead').click(function() {
            $.ajax({
                url: '<?php echo e(route('panel.notifications.mark-all-as-read')); ?>',
                method: 'POST',
                success: function(response) {
                    toastr.success(response.message);
                    loadNotifications();
                }
            });
        });

        // Load notifications on page load
        $(document).ready(function() {
            loadNotifications();
            
            // Refresh notifications every 30 seconds
            setInterval(loadNotifications, 30000);
        });

        // Load when dropdown is opened
        $('#notificationDropdown').on('click', function() {
            loadNotifications();
        });
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html>

<?php /**PATH C:\laragon\www\ebook_traveling\resources\views\layouts\panel.blade.php ENDPATH**/ ?>