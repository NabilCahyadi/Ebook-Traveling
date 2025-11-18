<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - Ebook Traveling</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/tabler-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Layout page -->
            <div class="layout-page">
                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <!-- Success Message -->
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success!</strong> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Page Header -->
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <h4 class="fw-bold py-3 mb-2">
                                    <span class="text-muted fw-light">Dashboard /</span> Welcome
                                </h4>
                                <p class="mb-0">Welcome back, <strong>{{ Auth::user()->name }}</strong>!</p>
                            </div>
                            <div class="col-md-4 text-end">
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger">
                                        <i class="ti ti-logout me-2"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- User Info Card -->
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-start">
                                            <div class="avatar me-3">
                                                @if (Auth::user()->avatar)
                                                    <img src="{{ Auth::user()->avatar }}" alt="Avatar"
                                                        class="rounded-circle" width="100" height="100">
                                                @else
                                                    <div class="avatar avatar-xl">
                                                        <span class="avatar-initial rounded-circle bg-label-primary"
                                                            style="width: 100px; height: 100px; font-size: 40px;">
                                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-grow-1">
                                                <h5 class="mb-1">{{ Auth::user()->name }}</h5>
                                                <p class="mb-2 text-muted">{{ Auth::user()->email }}</p>
                                                <div class="d-flex gap-3">
                                                    <span
                                                        class="badge bg-label-success">{{ ucfirst(Auth::user()->status) }}</span>
                                                    @if (Auth::user()->google_id)
                                                        <span class="badge bg-label-info">
                                                            <i class="ti ti-brand-google me-1"></i>Google Account
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="mt-3">
                                                    <small class="text-muted">
                                                        <i class="ti ti-calendar me-1"></i>
                                                        Member since {{ Auth::user()->created_at->format('F d, Y') }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Stats -->
                        <div class="row">
                            <div class="col-lg-3 col-sm-6 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div class="card-info">
                                                <p class="card-text">My Ebooks</p>
                                                <div class="d-flex align-items-end mb-2">
                                                    <h4 class="card-title mb-0 me-2">0</h4>
                                                </div>
                                                <small class="text-muted">Total purchased</small>
                                            </div>
                                            <div class="card-icon">
                                                <span class="badge bg-label-primary rounded p-2">
                                                    <i class="ti ti-book ti-sm"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div class="card-info">
                                                <p class="card-text">Subscriptions</p>
                                                <div class="d-flex align-items-end mb-2">
                                                    <h4 class="card-title mb-0 me-2">0</h4>
                                                </div>
                                                <small class="text-muted">Active plans</small>
                                            </div>
                                            <div class="card-icon">
                                                <span class="badge bg-label-success rounded p-2">
                                                    <i class="ti ti-wallet ti-sm"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div class="card-info">
                                                <p class="card-text">My Ratings</p>
                                                <div class="d-flex align-items-end mb-2">
                                                    <h4 class="card-title mb-0 me-2">0</h4>
                                                </div>
                                                <small class="text-muted">Total reviews</small>
                                            </div>
                                            <div class="card-icon">
                                                <span class="badge bg-label-warning rounded p-2">
                                                    <i class="ti ti-star ti-sm"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div class="card-info">
                                                <p class="card-text">Language</p>
                                                <div class="d-flex align-items-end mb-2">
                                                    <h4 class="card-title mb-0 me-2 text-uppercase">
                                                        {{ Auth::user()->language_pref }}</h4>
                                                </div>
                                                <small class="text-muted">Preference</small>
                                            </div>
                                            <div class="card-icon">
                                                <span class="badge bg-label-info rounded p-2">
                                                    <i class="ti ti-language ti-sm"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- / Content -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>
