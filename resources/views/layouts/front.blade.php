<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8" />
    <title>@yield('title', 'Home') - {{ config('app.name') }}</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="@yield('meta_description', '')" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/front/imgs/theme/favicon.svg') }}" />
    
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/front/css/plugins/animate.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front/css/main.css') }}" />
    
    @stack('styles')
</head>
<body>
    <!-- Header -->
    @include('layouts.partials.front.header')
    
    <!-- Main Content -->
    <main class="main">
        @yield('content')
    </main>
    
    <!-- Footer -->
    @include('layouts.partials.front.footer')
    
    <!-- Vendor JS -->
    <script src="{{ asset('assets/front/js/vendor/modernizr-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/vendor/jquery-migrate-3.3.0.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/plugins/slick.js') }}"></script>
    <script src="{{ asset('assets/front/js/plugins/jquery.syotimer.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/plugins/waypoints.js') }}"></script>
    <script src="{{ asset('assets/front/js/plugins/wow.js') }}"></script>
    <script src="{{ asset('assets/front/js/plugins/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/front/js/plugins/magnific-popup.js') }}"></script>
    <script src="{{ asset('assets/front/js/plugins/select2.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/plugins/counterup.js') }}"></script>
    <script src="{{ asset('assets/front/js/plugins/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/plugins/images-loaded.js') }}"></script>
    <script src="{{ asset('assets/front/js/plugins/isotope.js') }}"></script>
    <script src="{{ asset('assets/front/js/plugins/scrollup.js') }}"></script>
    <script src="{{ asset('assets/front/js/plugins/jquery.vticker-min.js') }}"></script>
    <script src="{{ asset('assets/front/js/plugins/jquery.theia.sticky.js') }}"></script>
    <script src="{{ asset('assets/front/js/plugins/jquery.elevatezoom.js') }}"></script>
    
    <!-- Template JS -->
    <script src="{{ asset('assets/front/js/main.js') }}"></script>
    <script src="{{ asset('assets/front/js/shop.js') }}"></script>
    
    @stack('scripts')
</body>
</html>
