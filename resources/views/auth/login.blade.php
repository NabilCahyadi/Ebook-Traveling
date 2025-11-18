<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <title>Login - Ebook Traveling</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('front/nest-frontend/assets/imgs/theme/favicon.svg') }}" />
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('front/nest-frontend/assets/css/main.css?v=5.6') }}" />
</head>

<body>
    <main class="main pages">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ url('/') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> Login
                </div>
            </div>
        </div>
        <div class="page-content pt-150 pb-150">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 col-lg-10 col-md-12 m-auto">
                        <div class="row">
                            <div class="col-lg-6 pr-30 d-none d-lg-block">
                                <img class="border-radius-15" src="{{ asset('front/nest-frontend/assets/imgs/page/login-1.png') }}" alt="Login" />
                            </div>
                            <div class="col-lg-6 col-md-8">
                                <div class="login_wrap widget-taber-content background-white">
                                    <div class="padding_eight_all bg-white">
                                        <div class="heading_s1">
                                            <h1 class="mb-5">Login</h1>
                                            <p class="mb-30">Don't have an account? <a href="{{ route('register') }}">Create here</a></p>
                                        </div>

                                        @if (session('success'))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                {{ session('success') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        @endif

                                        @if (session('error'))
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                {{ session('error') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        @endif

                                        @if ($errors->any())
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <ul class="mb-0">
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $message }}</li>
                                                    @endforeach
                                                </ul>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        @endif

                                        <form method="POST" action="{{ route('login.post') }}">
                                            @csrf
                                            <div class="form-group">
                                                <input type="email" required name="email" placeholder="Email *" 
                                                       value="{{ old('email') }}" class="@error('email') is-invalid @enderror" />
                                                @error('email')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <input required type="password" name="password" placeholder="Your password *" 
                                                       class="@error('password') is-invalid @enderror" />
                                                @error('password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="login_footer form-group mb-50">
                                                <div class="chek-form">
                                                    <div class="custome-checkbox">
                                                        <input class="form-check-input" type="checkbox" name="remember" id="exampleCheckbox1" {{ old('remember') ? 'checked' : '' }} />
                                                        <label class="form-check-label" for="exampleCheckbox1"><span>Remember me</span></label>
                                                    </div>
                                                </div>
                                                @if (Route::has('password.request'))
                                                    <a class="text-muted" href="{{ route('password.request') }}">Forgot password?</a>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-heading btn-block hover-up" name="login">Log in</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Vendor JS-->
    <script src="{{ asset('front/nest-frontend/assets/js/vendor/modernizr-3.6.0.min.js') }}"></script>
    <script src="{{ asset('front/nest-frontend/assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('front/nest-frontend/assets/js/vendor/jquery-migrate-3.3.0.min.js') }}"></script>
    <script src="{{ asset('front/nest-frontend/assets/js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('front/nest-frontend/assets/js/plugins/slick.js') }}"></script>
    <script src="{{ asset('front/nest-frontend/assets/js/plugins/jquery.syotimer.min.js') }}"></script>
    <script src="{{ asset('front/nest-frontend/assets/js/plugins/waypoints.js') }}"></script>
    <script src="{{ asset('front/nest-frontend/assets/js/plugins/wow.js') }}"></script>
    <script src="{{ asset('front/nest-frontend/assets/js/plugins/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('front/nest-frontend/assets/js/plugins/magnific-popup.js') }}"></script>
    <script src="{{ asset('front/nest-frontend/assets/js/plugins/select2.min.js') }}"></script>
    <script src="{{ asset('front/nest-frontend/assets/js/plugins/counterup.js') }}"></script>
    <script src="{{ asset('front/nest-frontend/assets/js/plugins/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('front/nest-frontend/assets/js/plugins/images-loaded.js') }}"></script>
    <script src="{{ asset('front/nest-frontend/assets/js/plugins/isotope.js') }}"></script>
    <script src="{{ asset('front/nest-frontend/assets/js/plugins/scrollup.js') }}"></script>
    <script src="{{ asset('front/nest-frontend/assets/js/plugins/jquery.vticker-min.js') }}"></script>
    <script src="{{ asset('front/nest-frontend/assets/js/plugins/jquery.theia.sticky.js') }}"></script>
    <script src="{{ asset('front/nest-frontend/assets/js/plugins/jquery.elevatezoom.js') }}"></script>
    <!-- Template  JS -->
    <script src="{{ asset('front/nest-frontend/assets/js/main.js?v=5.6') }}"></script>
    <script src="{{ asset('front/nest-frontend/assets/js/shop.js?v=5.6') }}"></script>
</body>

</html>

    <!-- Core JS -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>

    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/@form-validation/popular.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/auto-focus.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('assets/js/pages-auth.js') }}"></script>

    <!-- Toggle Password Visibility -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.querySelector('.form-password-toggle .input-group-text');
            const password = document.querySelector('#password');

            if (togglePassword) {
                togglePassword.addEventListener('click', function() {
                    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                    password.setAttribute('type', type);

                    const icon = this.querySelector('i');
                    icon.classList.toggle('ti-eye-off');
                    icon.classList.toggle('ti-eye');
                });
            }
        });
    </script>
</body>

</html>
