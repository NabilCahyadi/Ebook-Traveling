<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Authentication') - {{ config('app.name') }}</title>

    <!-- Font Awesome -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css'>

    <!-- Auth Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/auth/style.css') }}">

    @stack('styles')
</head>
<body>
    @yield('content')

    <!-- Auth Template JS -->
    <script src="{{ asset('assets/auth/script.js') }}"></script>

    @stack('scripts')
</body>
</html>
