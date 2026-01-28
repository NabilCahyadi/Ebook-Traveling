<!doctype html>
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="{{ url('assets/admin/') }}/" data-template="vertical-menu-template"
    data-style="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>@yield('title', 'Dashboard') - {{ config('app.name') }}</title>
    <meta name="description" content="@yield('meta_description', '')" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ url('images/only-logoo.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ url('assets/admin/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/admin/vendor/fonts/tabler-icons.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/admin/vendor/fonts/flag-icons.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ url('assets/admin/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ url('assets/admin/vendor/css/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ url('assets/admin/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ url('assets/admin/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/admin/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/admin/vendor/libs/apex-charts/apex-charts.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/admin/vendor/libs/swiper/swiper.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/admin/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ url('assets/admin/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ url('assets/admin/vendor/css/pages/cards-advance.css') }}" />

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />

    <!-- Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    
    <!-- Custom Toastr CSS -->
    <style>
        /* Comprehensive override of all pink colors to match front-end red (#ff4c61) */
        
        /* CSS Variables */
        :root {
            --bs-primary: #ff4c61 !important;
            --bs-primary-rgb: 255, 76, 97 !important;
        }
        
        /* Replace all colors with #ff4c61 */
        .text-primary,
        .link-primary,
        a.text-primary,
        .btn-link.text-primary {
            color: #ff4c61 !important;
        }
        
        .btn-primary,
        .bg-primary,
        .badge-primary,
        .badge.bg-primary,
        .alert-primary,
        .list-group-item-primary.list-group-item-action.active {
            background-color: #ff4c61 !important;
            border-color: #ff4c61 !important;
        }
        
        .btn-primary:hover,
        .btn-primary:focus,
        .btn-primary:active,
        .btn-primary.active {
            background-color: #e6405a !important;
            border-color: #e6405a !important;
        }
        
        .btn-outline-primary {
            color: #ff4c61 !important;
            border-color: #ff4c61 !important;
        }
        
        .btn-outline-primary:hover,
        .btn-outline-primary:focus,
        .btn-outline-primary:active {
            background-color: #ff4c61 !important;
            border-color: #ff4c61 !important;
            color: #fff !important;
        }
        
        .border-primary {
            border-color: #ff4c61 !important;
        }
        
        .border-top-primary {
            border-top-color: #ff4c61 !important;
        }
        
        .border-bottom-primary {
            border-bottom-color: #ff4c61 !important;
        }
        
        .border-start-primary {
            border-left-color: #ff4c61 !important;
        }
        
        .border-end-primary {
            border-right-color: #ff4c61 !important;
        }
        
        /* Progress bars */
        .progress-bar.bg-primary {
            background-color: #ff4c61 !important;
        }
        
        /* Pagination */
        .pagination .page-item.active .page-link {
            background-color: #ff4c61 !important;
            border-color: #ff4c61 !important;
        }
        
        /* List groups */
        .list-group-item-primary {
            background-color: rgba(255, 76, 97, 0.1) !important;
            color: #ff4c61 !important;
        }
        
        /* Forms */
        .form-check-input:checked {
            background-color: #ff4c61 !important;
            border-color: #ff4c61 !important;
        }
        
        .form-switch .form-check-input:checked {
            background-color: #ff4c61 !important;
            border-color: #ff4c61 !important;
        }
        
        .form-control:focus,
        .form-select:focus {
            border-color: #ff4c61 !important;
            box-shadow: 0 0 0 0.2rem rgba(255, 76, 97, 0.25) !important;
        }
        
        /* Links */
        a:not(.btn):not(.badge):not(.menu-link):hover {
            color: #ff4c61 !important;
        }
        
        /* Navbar search */
        .navbar-search-wrapper .search-input:focus {
            border-color: #ff4c61 !important;
        }
        
        /* Cards with primary accent */
        .card-header.bg-primary {
            background-color: #ff4c61 !important;
        }
        
        /* Spinners */
        .spinner-border.text-primary,
        .spinner-grow.text-primary {
            color: #ff4c61 !important;
        }
        
        /* Dropdown active items */
        .dropdown-item.active,
        .dropdown-item:active {
            background-color: #ff4c61 !important;
        }
        
        /* Tabs */
        .nav-tabs .nav-link.active,
        .nav-pills .nav-link.active {
            background-color: #ff4c61 !important;
            border-color: #ff4c61 !important;
        }
        
        /* Timeline */
        .timeline-item.timeline-item-primary .timeline-indicator {
            background-color: #ff4c61 !important;
            border-color: #ff4c61 !important;
        }
        
        /* ========================================
           SIDEBAR MENU STYLING
           ======================================== */
        
        /* Base sidebar styles */
        .layout-menu {
            background-color: #fff !important;
            border-right: 1px solid rgba(255, 76, 97, 0.1);
        }
        
        /* Menu item base */
        .menu-inner .menu-item .menu-link {
            border-radius: 6px;
            margin: 2px 8px;
            transition: all 0.2s ease;
        }
        
        /* Menu item hover */
        .menu-inner .menu-item .menu-link:hover {
            background-color: rgba(255, 76, 97, 0.08) !important;
        }
        
        /* Active menu item (single item, no dropdown) */
        .menu-inner > .menu-item.active > .menu-link:not(.menu-toggle) {
            background-color: #ff4c61 !important;
            color: #fff !important;
        }
        
        .menu-inner > .menu-item.active > .menu-link:not(.menu-toggle) .menu-icon,
        .menu-inner > .menu-item.active > .menu-link:not(.menu-toggle) div {
            color: #fff !important;
        }
        
        /* --- LEVEL 1: Parent Dropdowns (User Management, Ebook Management) --- */
        .menu-inner > .menu-item.open > .menu-link.menu-toggle {
            background-color: rgba(255, 76, 97, 0.12) !important;
            color: #ff4c61 !important;
            font-weight: 600;
        }
        
        .menu-inner > .menu-item.open > .menu-link.menu-toggle .menu-icon {
            color: #ff4c61 !important;
        }
        
        /* Level 1 dropdown when ACTIVE but CLOSED (Ebook Management active tapi dropdown tutup) */
        .menu-inner > .menu-item.active:not(.open) > .menu-link.menu-toggle {
            background-color: rgba(255, 76, 97, 0.08) !important;
            color: #ff4c61 !important;
            font-weight: 500;
        }
        
        .menu-inner > .menu-item.active:not(.open) > .menu-link.menu-toggle .menu-icon {
            color: #ff4c61 !important;
        }
        
        /* Level 1 dropdown when ACTIVE AND OPEN - Icon putih seperti menu active biasa */
        .menu-inner > .menu-item.active.open > .menu-link.menu-toggle {
            background-color: #ff4c61 !important;
            color: #fff !important;
            font-weight: 600;
        }
        
        .menu-inner > .menu-item.active.open > .menu-link.menu-toggle .menu-icon,
        .menu-inner > .menu-item.active.open > .menu-link.menu-toggle div {
            color: #fff !important;
        }
        
        /* Level 1 submenu container */
        .menu-inner > .menu-item > .menu-sub {
            background-color: rgba(255, 76, 97, 0.03);
            border-radius: 0 0 8px 8px;
            margin: 0 8px;
            padding: 4px 0;
        }
        
        /* --- LEVEL 2: Child Items (Roles, Activity Logs) --- */
        .menu-inner > .menu-item > .menu-sub > .menu-item > .menu-link:not(.menu-toggle) {
            padding-left: 2.5rem;
        }
        
        .menu-inner > .menu-item > .menu-sub > .menu-item.active > .menu-link:not(.menu-toggle) {
            background-color: rgba(255, 76, 97, 0.15) !important;
            color: #ff4c61 !important;
            font-weight: 500;
        }
        
        /* --- LEVEL 2: Child Dropdowns (Users dropdown inside User Management) --- */
        .menu-inner > .menu-item > .menu-sub > .menu-item > .menu-link.menu-toggle {
            padding-left: 2.5rem;
        }
        
        .menu-inner > .menu-item > .menu-sub > .menu-item.open > .menu-link.menu-toggle {
            background-color: rgba(255, 76, 97, 0.08) !important;
            color: #ff4c61 !important;
            font-weight: 500;
        }
        
        /* Level 2 submenu container */
        .menu-inner > .menu-item > .menu-sub > .menu-item > .menu-sub {
            background-color: rgba(255, 76, 97, 0.02);
            border-left: 2px solid rgba(255, 76, 97, 0.2);
            margin-left: 2rem;
            padding: 4px 0;
            border-radius: 0 6px 6px 0;
        }
        
        /* --- LEVEL 3: Deepest Items (All Users, Creator, Reader) --- */
        .menu-inner > .menu-item > .menu-sub > .menu-item > .menu-sub > .menu-item > .menu-link {
            padding-left: 1.5rem;
            font-size: 0.875rem;
        }
        
        .menu-inner > .menu-item > .menu-sub > .menu-item > .menu-sub > .menu-item.active > .menu-link {
            background-color: rgba(255, 76, 97, 0.12) !important;
            color: #ff4c61 !important;
            font-weight: 600;
            border-left: 3px solid #ff4c61;
            margin-left: -2px;
        }
        
        .menu-inner > .menu-item > .menu-sub > .menu-item > .menu-sub > .menu-item > .menu-link:hover {
            background-color: rgba(255, 76, 97, 0.06) !important;
        }
        
        /* Dropdown arrow rotation */
        .menu-item.open > .menu-link.menu-toggle::after {
            transform: rotate(90deg);
        }
        
        /* Menu icons */
        .menu-inner .menu-icon {
            color: #697a8d;
            transition: color 0.2s ease;
        }
        
        .menu-inner .menu-item:hover .menu-icon {
            color: #ff4c61;
        }
        
        /* App brand in sidebar */
        .app-brand {
            padding: 1rem;
            border-bottom: 1px solid rgba(255, 76, 97, 0.1);
        }
        
        /* ========================================
           END SIDEBAR STYLING
           ======================================== */
        
        /* Override background colors */
        body {
            background-color: #ffffff !important;
        }
        
        .layout-wrapper {
            background-color: #ffffff !important;
        }
        
        .layout-page {
            background-color: #ffffff !important;
        }
        
        .content-wrapper {
            background-color: #ffffff !important;
        }
        
        /* Toastr */
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
    <script src="{{ url('assets/admin/vendor/js/helpers.js') }}"></script>
    <script src="{{ url('assets/admin/vendor/js/template-customizer.js') }}"></script>
    <script src="{{ url('assets/admin/js/config.js') }}"></script>
       @stack('styles')
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            @include('layouts.partials.admin.sidebar')

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                @include('layouts.partials.admin.navbar')

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        @yield('content')
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
    <script src="{{ url('assets/admin/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ url('assets/admin/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ url('assets/admin/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ url('assets/admin/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ url('assets/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ url('assets/admin/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ url('assets/admin/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ url('assets/admin/vendor/js/menu.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ url('assets/admin/js/main.js') }}"></script>

    <!-- Fix Menu Dropdown - Keep Open & Remember State -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const MENU_STATE_KEY = 'adminMenuState';
            let menuInstance = null;

            // Wait for menu instance to be ready
            setTimeout(function() {
                const layoutMenu = document.getElementById('layout-menu');
                if (layoutMenu && layoutMenu.menuInstance) {
                    menuInstance = layoutMenu.menuInstance;
                }

                // Mark server-opened menus (those with 'active' class on page load)
                document.querySelectorAll('.menu-item.active.open').forEach(function(item) {
                    item.setAttribute('data-server-open', 'true');
                });

                // Restore user-opened menus
                restoreMenuState();

                // Listen to menu toggle events
                document.querySelectorAll('.menu-toggle').forEach(function(toggle) {
                    toggle.addEventListener('click', function(e) {
                        const menuItem = this.closest('.menu-item');
                        if (menuItem && !menuItem.getAttribute('data-server-open')) {
                            // Mark as manually toggled
                            menuItem.setAttribute('data-manual-toggle', 'true');
                        }
                        
                        setTimeout(saveMenuState, 400);
                    });
                });

                // Save before leaving page
                window.addEventListener('beforeunload', saveMenuState);
            }, 300);

            // Save state of manually opened menus only
            function saveMenuState() {
                const openMenus = [];
                document.querySelectorAll('.menu-item.open').forEach(function(item) {
                    // Only save if manually toggled and not server-opened
                    if (item.getAttribute('data-manual-toggle') && !item.getAttribute('data-server-open')) {
                        const link = item.querySelector('.menu-link');
                        if (link) {
                            const menuId = link.textContent.trim();
                            openMenus.push(menuId);
                        }
                    }
                });
                localStorage.setItem(MENU_STATE_KEY, JSON.stringify(openMenus));
            }

            // Restore manually opened menus
            function restoreMenuState() {
                try {
                    const savedState = localStorage.getItem(MENU_STATE_KEY);
                    if (savedState) {
                        const openMenus = JSON.parse(savedState);
                        
                        openMenus.forEach(function(menuId) {
                            document.querySelectorAll('.menu-link').forEach(function(link) {
                                if (link.textContent.trim() === menuId) {
                                    const menuItem = link.closest('.menu-item');
                                    // Only restore if not already managed by server
                                    if (menuItem && !menuItem.getAttribute('data-server-open') && !menuItem.classList.contains('active')) {
                                        if (menuInstance) {
                                            menuInstance.open(menuItem, false);
                                        } else {
                                            menuItem.classList.add('open');
                                            const menuSub = menuItem.querySelector('.menu-sub');
                                            if (menuSub) {
                                                menuSub.style.display = 'block';
                                            }
                                        }
                                        menuItem.setAttribute('data-manual-toggle', 'true');
                                    }
                                }
                            });
                        });
                    }
                } catch (e) {
                    console.error('Error restoring menu state:', e);
                }
            }
        });
    </script>

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
        @if(session('success'))
            console.log('Session success:', "{!! addslashes(session('success')) !!}");
            toastr.success("{!! addslashes(session('success')) !!}", "Success");
        @endif

        @if(session('error'))
            console.log('Session error:', "{!! addslashes(session('error')) !!}");
            toastr.error("{!! addslashes(session('error')) !!}", "Error");
        @endif

        @if(session('warning'))
            console.log('Session warning:', "{!! addslashes(session('warning')) !!}");
            toastr.warning("{!! addslashes(session('warning')) !!}", "Warning");
        @endif

        @if(session('info'))
            console.log('Session info:', "{!! addslashes(session('info')) !!}");
            toastr.info("{!! addslashes(session('info')) !!}", "Info");
        @endif
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
                url: '{{ route('admin.notifications.recent') }}',
                method: 'GET',
                success: function(response) {
                    const notifications = response.notifications;
                    const unreadCount = response.unread_count;
                    
                    // Update unread count
                    if (unreadCount > 0) {
                        $('#unreadCount').text(unreadCount + ' {{ __('admin.notifications.new') }}');
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
                                <p class="text-muted mb-0">{{ __('admin.notifications.no_notifications') }}</p>
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
                url: '{{ route('admin.notifications.mark-all-as-read') }}',
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
            
            // DISABLED: Notification polling removed to reduce server load
            // Notifications will only refresh when:
            // 1. Page is loaded
            // 2. User clicks notification dropdown
            // 3. After marking notification as read
            
            // If you need real-time notifications, consider implementing:
            // - WebSockets (Laravel Echo + Pusher/Soketi)
            // - Server-Sent Events (SSE)
            // - Or increase interval to 5 minutes: setInterval(loadNotifications, 300000);
        });

        // Load when dropdown is opened
        $('#notificationDropdown').on('click', function() {
            loadNotifications();
        });
    </script>

    <!-- Page Preload System -->
    <script>
        (function() {
            // Preload system: load page completely before navigation
            document.addEventListener('DOMContentLoaded', function() {
                
                // Function to preload page in hidden iframe
                function preloadPageComplete(url) {
                    return new Promise((resolve, reject) => {
                        // Create hidden iframe
                        const iframe = document.createElement('iframe');
                        iframe.style.display = 'none';
                        iframe.style.position = 'absolute';
                        iframe.style.width = '0';
                        iframe.style.height = '0';
                        iframe.style.border = 'none';
                        
                        let timeoutId;
                        
                        // Set timeout (10 seconds max)
                        timeoutId = setTimeout(() => {
                            document.body.removeChild(iframe);
                            reject(new Error('Timeout'));
                        }, 10000);
                        
                        iframe.onload = function() {
                            clearTimeout(timeoutId);
                            
                            // Wait for iframe content to be fully loaded
                            try {
                                const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
                                
                                if (iframeDoc.readyState === 'complete') {
                                    // Ensure all resources are loaded
                                    setTimeout(() => {
                                        document.body.removeChild(iframe);
                                        resolve(true);
                                    }, 100);
                                } else {
                                    // Wait for complete state
                                    iframeDoc.addEventListener('readystatechange', function() {
                                        if (iframeDoc.readyState === 'complete') {
                                            setTimeout(() => {
                                                document.body.removeChild(iframe);
                                                resolve(true);
                                            }, 100);
                                        }
                                    });
                                }
                            } catch (e) {
                                // Cross-origin, just wait a bit more
                                setTimeout(() => {
                                    document.body.removeChild(iframe);
                                    resolve(true);
                                }, 500);
                            }
                        };
                        
                        iframe.onerror = function() {
                            clearTimeout(timeoutId);
                            document.body.removeChild(iframe);
                            reject(new Error('Load error'));
                        };
                        
                        document.body.appendChild(iframe);
                        iframe.src = url;
                    });
                }
                
                // Handle all internal links
                const links = document.querySelectorAll('a[href]:not([target="_blank"]):not([href^="#"]):not([href^="javascript:"]):not(.no-preload)');
                
                links.forEach(function(link) {
                    link.addEventListener('click', function(e) {
                        const href = this.getAttribute('href');
                        
                        // Only handle internal navigation
                        if (href && !href.startsWith('http://') && !href.startsWith('https://') && 
                            !href.startsWith('mailto:') && !href.startsWith('tel:')) {
                            
                            e.preventDefault();
                            
                            // Visual feedback - disable link and change cursor
                            const originalText = this.innerHTML;
                            this.style.opacity = '0.6';
                            this.style.pointerEvents = 'none';
                            document.body.style.cursor = 'wait';
                            
                            // Preload the page completely
                            preloadPageComplete(href)
                                .then(() => {
                                    // Page is fully loaded in background, now navigate
                                    window.location.href = href;
                                })
                                .catch(() => {
                                    // If preload fails, navigate anyway
                                    window.location.href = href;
                                })
                                .finally(() => {
                                    // Reset styles (in case navigation is delayed)
                                    this.style.opacity = '1';
                                    this.style.pointerEvents = 'auto';
                                    document.body.style.cursor = 'default';
                                });
                        }
                    });
                });
            });
        })();
    </script>

    @stack('scripts')
</body>

</html>
