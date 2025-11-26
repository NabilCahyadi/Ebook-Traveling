<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MeatMap')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/only-logoo.png') }}">
    <!-- styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Vendor CSS (bootstrap, icons, plugins) -->
    <link rel="stylesheet" href="{{ asset('assets-nest/nest-fe/css/vendors/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-nest/nest-fe/css/vendors/uicons-regular-straight.css') }}">
    <!-- plugin CSS -->
    <link rel="stylesheet" href="{{ asset('assets-nest/nest-fe/css/plugins/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-nest/nest-fe/css/plugins/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-nest/nest-fe/css/plugins/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-nest/nest-fe/css/plugins/animate.min.css') }}">
    <!-- Main template CSS -->
    <link rel="stylesheet" href="{{ asset('assets-nest/nest-fe/css/main.css') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=roboto:400,500,700" rel="stylesheet" />
    <!-- Syntax Highlighter -->
    <link rel="stylesheet" type="text/css" href="{{ asset('front/doc/assets/syntax-highlighter/styles/shCore.css') }}" media="all">
    <link rel="stylesheet" type="text/css" href="{{ asset('front/doc/assets/syntax-highlighter/styles/shThemeDefault.css') }}" media="all">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        body {
            font-family: 'Poppins', sans-serif !important;
        }

        * {
            font-family: 'Poppins', sans-serif !important;
        }
    </style>
    <style>
        /* Force override for scrollbar color (stronger specificity / important) */
        /* This is a short-term safety net so the browser shows your #FF4C61 color
           even if a compiled stylesheet (public/build/...) is still cached. */
        ::-webkit-scrollbar-thumb {
            background-color: #FF4C61 !important;
            border-radius: 10px !important;
            border: 3px solid transparent !important;
            background-clip: padding-box !important;
        }

        ::-webkit-scrollbar-thumb:hover {
            background-color: #e43a4d !important;
        }

        /* Firefox */
        html {
            scrollbar-color: #FF4C61 #f1f1f1 !important;
        }
    </style>
    <style>
        /* Top progress bar only */

        #top-progress {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            z-index: 99999;
            pointer-events: none;
            background: transparent;
            transition: opacity .3s ease;
        }

        #top-progress-bar {
            height: 100%;
            width: 0%;
            background: #FF4C61;
            transition: width .2s linear;
        }
    </style>
    <style>
        /* style public untuk LP (header&footer) yang mengandung logo_horizontal */
        .logo-crop {
            display: inline-block;
            width: 270px;
            height: 60px;
            overflow: hidden;
        }

        .logo-crop img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* object-position: 10% center;  */
        }
    </style>
    <style>
        /* Custom scrollbar color */
        /* WebKit browsers (Chrome, Edge, Safari) */
        ::-webkit-scrollbar {
            width: 12px;
            height: 12px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #FF4C61;
            /* primary scrollbar color */
            border-radius: 10px;
            border: 3px solid transparent;
            background-clip: padding-box;
        }

        ::-webkit-scrollbar-thumb:hover {
            background-color: #e43a4d;
        }

        /* Firefox */
        * {
            scrollbar-width: thin;
            scrollbar-color: #FF4C61 transparent;
        }

        /* Optional: force visible track for Windows high-contrast assist */
        :root {
            --scrollbar-thumb: #FF4C61;
        }

        /* for title in beranda LP */
        .section-title.style-2 h3 {
            font-size: 24px !important;
            margin-bottom: 0px !important;
        }

        .style-2 h3 {
            font-size: 24px !important;
            margin-bottom: -10px !important;
        }
    </style>
</head>

<body>
    <!-- Top progress bar only -->
    <div id="top-progress">
        <div id="top-progress-bar"></div>
    </div>
    <!-- Header -->
    @include('layouts_lp.components.header')

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    @include('layouts_lp.components.footer')

    <!-- Vendor JS -->
    <script src="{{ asset('assets-nest/nest-fe/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets-nest/nest-fe/js/vendor/jquery-migrate-3.3.0.min.js') }}"></script>
    <script src="{{ asset('assets-nest/nest-fe/js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets-nest/nest-fe/js/plugins/perfect-scrollbar.js') }}"></script>
    <!-- Plugins -->
    <script src="{{ asset('assets-nest/nest-fe/js/plugins/images-loaded.js') }}"></script>
    <script src="{{ asset('assets-nest/nest-fe/js/plugins/isotope.js') }}"></script>
    <script src="{{ asset('assets-nest/nest-fe/js/plugins/magnific-popup.js') }}"></script>
    <script src="{{ asset('assets-nest/nest-fe/js/plugins/slick.js') }}"></script>
    <script src="{{ asset('assets-nest/nest-fe/js/plugins/TweenMax.min.js') }}"></script>
    <script src="{{ asset('assets-nest/nest-fe/js/plugins/wow.js') }}"></script>
    <script src="{{ asset('assets-nest/nest-fe/js/plugins/waypoints.js') }}"></script>
    <script src="{{ asset('assets-nest/nest-fe/js/plugins/scrollup.js') }}"></script>
    <script src="{{ asset('assets-nest/nest-fe/js/plugins/counterup.js') }}"></script>
    <script src="{{ asset('assets-nest/nest-fe/js/plugins/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('assets-nest/nest-fe/js/plugins/jquery.elevatezoom.js') }}"></script>
    <script src="{{ asset('assets-nest/nest-fe/js/plugins/jquery.syotimer.min.js') }}"></script>
    <script src="{{ asset('assets-nest/nest-fe/js/plugins/jquery.theia.sticky.js') }}"></script>
    <script src="{{ asset('assets-nest/nest-fe/js/plugins/jquery.vticker-min.js') }}"></script>
    <script src="{{ asset('assets-nest/nest-fe/js/plugins/select2.min.js') }}"></script>
    <script src="{{ asset('assets-nest/nest-fe/js/plugins/slider-range.js') }}"></script>
    <!-- Custom Script -->
    <script src="{{ asset('assets-nest/nest-fe/js/main.js') }}"></script>
    <script>
        // Progress bar animation on page load
        document.addEventListener('DOMContentLoaded', function() {
            var bar = document.getElementById('top-progress-bar');
            var progress = 0;
            var interval = setInterval(function() {
                progress += Math.random() * 20;
                if (progress > 90) progress = 90;
                bar.style.width = progress + '%';
            }, 120);
            window.addEventListener('load', function() {
                bar.style.width = '100%';
                setTimeout(function() {
                    document.getElementById('top-progress').style.opacity = 0;
                }, 400);
                clearInterval(interval);
            });
        });
    </script>
    <script>
        if (/MSIE \d|Trident.*rv:/.test(navigator.userAgent)) {
            document.write('<script src="https://cdn.jsdelivr.net/npm/css-vars-ponyfill@1"><\/script>');
            document.write('<script src="assets/js/ie.js"><\/script>');
        }
    </script>
    <script type="text/javascript" src="{{ asset('front/doc/assets/syntax-highlighter/scripts/shCore.js') }}"></script>
    <script type="text/javascript" src="{{ asset('front/doc/assets/syntax-highlighter/scripts/shBrushXml.js') }}"></script>
    <script type="text/javascript" src="{{ asset('front/doc/assets/syntax-highlighter/scripts/shBrushCss.js') }}"></script>
    <script type="text/javascript" src="{{ asset('front/doc/assets/syntax-highlighter/scripts/shBrushJScript.js') }}"></script>
    <script type="text/javascript" src="{{ asset('front/doc/assets/syntax-highlighter/scripts/shBrushPhp.js') }}"></script>
    <script type="text/javascript">
        SyntaxHighlighter.all()
    </script>
</body>

</html>