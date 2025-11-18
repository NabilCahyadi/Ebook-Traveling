<!DOCTYPE html>
<html lang="en" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('assets/') }}" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Complete Registration - Ebook Traveling</title>
    <meta name="description" content="Complete your registration with Google" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}" />

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>
</head>

<body>
    <!-- Content -->
    <div class="authentication-wrapper authentication-cover authentication-bg">
        <div class="authentication-inner row">
            <!-- Register -->
            <div class="d-none d-lg-flex col-lg-7 p-0">
                <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center">
                    <img src="{{ asset('assets/img/illustrations/auth-register-illustration-light.png') }}"
                        alt="auth-register-cover" class="img-fluid my-5 auth-illustration"
                        data-app-light-img="illustrations/auth-register-illustration-light.png"
                        data-app-dark-img="illustrations/auth-register-illustration-dark.png" />
                    <img src="{{ asset('assets/img/illustrations/bg-shape-image-light.png') }}"
                        alt="auth-register-cover" class="platform-bg"
                        data-app-light-img="illustrations/bg-shape-image-light.png"
                        data-app-dark-img="illustrations/bg-shape-image-dark.png" />
                </div>
            </div>
            <!-- /Register -->

            <!-- Register -->
            <div class="d-flex col-12 col-lg-5 align-items-center p-sm-5 p-4">
                <div class="w-px-400 mx-auto">
                    <!-- Logo -->
                    <div class="app-brand mb-4">
                        <a href="/" class="app-brand-link gap-2">
                            <span class="app-brand-logo demo">
                                <i class="ti ti-book-2 ti-lg text-primary"></i>
                            </span>
                            <span class="app-brand-text demo text-body fw-bold ms-1">Ebook Traveling</span>
                        </a>
                    </div>
                    <!-- /Logo -->

                    <h3 class="mb-1">Complete Your Registration 🎉</h3>
                    <p class="mb-4">You're almost there! Just a few more details.</p>

                    <!-- Info Message -->
                    @if (session('info'))
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <i class="ti ti-info-circle me-2"></i>{{ session('info') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Error Message -->
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    @if (!session('google_user'))
                        <div class="alert alert-warning" role="alert">
                            <i class="ti ti-alert-triangle me-2"></i>Session expired. Please <a
                                href="{{ route('login.google') }}" class="alert-link">login with Google again</a>.
                        </div>
                    @else
                        <!-- Google User Info -->
                        <div class="card mb-4 border border-primary">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    @if (session('google_user.avatar'))
                                        <img src="{{ session('google_user.avatar') }}" alt="Avatar"
                                            class="rounded-circle me-3" width="60" height="60">
                                    @else
                                        <div class="avatar avatar-lg me-3">
                                            <span class="avatar-initial rounded-circle bg-label-primary">
                                                {{ strtoupper(substr(session('google_user.name'), 0, 1)) }}
                                            </span>
                                        </div>
                                    @endif
                                    <div>
                                        <h6 class="mb-0">{{ session('google_user.name') }}</h6>
                                        <small class="text-muted">{{ session('google_user.email') }}</small>
                                        <br>
                                        <span class="badge bg-label-success mt-1">
                                            <i class="ti ti-brand-google me-1"></i>Google Account
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form id="formAuthentication" class="mb-3"
                            action="{{ route('register.google.complete') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" placeholder="Enter your full name"
                                    value="{{ old('name', session('google_user.name')) }}" autofocus required />
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ session('google_user.email') }}" readonly disabled />
                                <small class="text-muted">Email from your Google account (cannot be changed)</small>
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number (Optional)</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" placeholder="Enter your phone number"
                                    value="{{ old('phone') }}" />
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">We may use this for account recovery</small>
                            </div>

                            <div class="mb-3">
                                <label for="language_pref" class="form-label">Preferred Language</label>
                                <select class="form-select @error('language_pref') is-invalid @enderror"
                                    id="language_pref" name="language_pref">
                                    <option value="en" {{ old('language_pref', 'en') == 'en' ? 'selected' : '' }}>
                                        English</option>
                                    <option value="id" {{ old('language_pref') == 'id' ? 'selected' : '' }}>Bahasa
                                        Indonesia</option>
                                </select>
                                @error('language_pref')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input @error('terms') is-invalid @enderror"
                                        type="checkbox" id="terms-conditions" name="terms" required />
                                    <label class="form-check-label" for="terms-conditions">
                                        I agree to <a href="javascript:void(0);">privacy policy & terms</a>
                                    </label>
                                    @error('terms')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary d-grid w-100">
                                <i class="ti ti-check me-2"></i>Complete Registration
                            </button>
                        </form>

                        <p class="text-center">
                            <span>Want to use a different account?</span>
                            <a href="{{ route('login') }}">
                                <span>Back to login</span>
                            </a>
                        </p>

                    @endif
                </div>
            </div>
            <!-- /Register -->
        </div>
    </div>
    <!-- / Content -->

    <!-- Core JS -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>
