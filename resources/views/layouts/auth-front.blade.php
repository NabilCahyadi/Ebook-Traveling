<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Home') - {{ config('app.name') }}</title>
    <meta name="description" content="@yield('meta_description', '')" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #7367f0;
            --primary-dark: #5e50ee;
        }
        
        body {
            font-family: 'Public Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f8f7fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 20px 0;
        }
        
        .authentication-wrapper {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 1.5rem;
        }
        
        .authentication-inner {
            width: 100%;
            max-width: 400px;
        }
        
        .card {
            border: none;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            border-radius: 0.5rem;
        }
        
        .card-body {
            padding: 2rem;
        }
        
        .app-brand {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .app-brand-text {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            text-decoration: none;
        }
        
        h4 {
            font-weight: 600;
            color: #5d596c;
            margin-bottom: 0.5rem;
        }
        
        .form-label {
            font-weight: 500;
            color: #5d596c;
            margin-bottom: 0.5rem;
        }
        
        .form-control {
            padding: 0.625rem 0.875rem;
            font-size: 0.9375rem;
            border-color: #d9dee3;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(115, 103, 240, 0.15);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 0.625rem 1.25rem;
            font-weight: 500;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }
        
        .auth-input {
            font-size: 1.5rem;
            text-align: center;
            font-weight: 600;
        }
        
        .input-group-text {
            cursor: pointer;
            border-color: #d9dee3;
        }
        
        .form-password-toggle .input-group-text:hover {
            background-color: #f8f7fa;
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Content -->
    @yield('content')
    <!-- / Content -->

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
