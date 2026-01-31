@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<!-- Navigation Tabs for Mobile -->
<div class="mobile-nav-tabs">
    <button class="nav-tab active" data-form="signin">Sign In</button>
    <button class="nav-tab" data-form="signup">Sign Up</button>
</div>

<div class="container" id="container">
    <!-- Sign Up Form -->
    <div class="form-container sign-up-container">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <h1>Create Account</h1>
            <div class="social-container">
                <a href="{{ route('register.google') }}" class="social google-btn">
                    <svg width="18" height="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                        <path fill="#FF416C" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z" />
                        <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z" />
                        <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z" />
                        <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z" />
                    </svg>
                </a>
            </div>
            <span>or use your email for registration</span>

            @if (session('error'))
            <div class="alert-message error">
                {!! session('error') !!}
            </div>
            @endif

            @if (session('info'))
            <div class="alert-message info">
                {!! session('info') !!}
            </div>
            @endif

            <input type="text" name="name" placeholder="Name" value="{{ old('name') }}" required />
            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required />
            <input type="password" name="password" placeholder="Password" required />
            <input type="password" name="password_confirmation" placeholder="Confirm Password" required />

            <div class="terms-container">
                <label class="checkbox-label">
                    <input type="checkbox" name="terms" value="1" {{ old('terms') ? 'checked' : '' }} required>
                    <span class="checkmark"></span>
                    I agree to the <a href="{{route('terms-conditions')}}" style="color: #FF4C61;"> Terms and Conditions</a>
                </label>
            </div>

            <button type="submit">Sign Up</button>
        </form>
    </div>

    <!-- Sign In Form -->
    <div class="form-container sign-in-container">
        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <h1>Sign in</h1>
            <div class="social-container">
                <a href="{{ route('login.google') }}" class="social google-btn">
                    <svg width="18" height="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                        <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z" />
                        <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z" />
                        <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z" />
                        <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z" />
                    </svg>
                </a>
            </div>
            <span>or use your account</span>

            @if (session('success'))
            <div class="alert-message success">
                {{ session('success') }}
            </div>
            @endif

            @if (session('error'))
            <div class="alert-message error">
                {!! session('error') !!}
            </div>
            @endif

            @if ($errors->any())
            <div class="alert-message error">
                @foreach ($errors->all() as $error)
                <div>{!! $error !!}</div>
                @endforeach
            </div>
            @endif

            <input type="text" name="email" placeholder="Email or Phone Number" value="{{ old('email') }}"
                required />
            <input type="password" name="password" placeholder="Password" required />

            <div class="remember-forgot">
                <label class="checkbox-label">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <span class="checkmark"></span>
                    Remember me
                </label>
                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">Forgot Password ?</a>
                @endif
            </div>

            <button type="submit">Sign In</button>
        </form>
    </div>

    <!-- Overlay Panels -->
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
                <h1>Hello, Friend !</h1>
                <p>Enter your personal details and start journey with us</p>
                <small class="text-sm" style="margin-top: 0px; margin-bottom: 15px;">Already have an account ?</small>
                <button class="ghost" id="signIn">Sign In</button>
            </div>
            <div class="overlay-panel overlay-right">
                <h1>Welcome Back !</h1>
                <p>To keep connected with us please login with your personal info</p>
                <small class="text-sm" style="margin-top: 0px; margin-bottom: 15px;">Don't have an account yet ?</small>
                <button class="ghost" id="signUp">Sign Up</button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Base styles */
    .alert-message {
        width: 100%;
        padding: 12px;
        margin: 10px 0;
        border-radius: 5px;
        font-size: 14px;
    }

    .alert-message.success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-message.error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .alert-message.info {
        background-color: #d1ecf1;
        color: #0c5460;
        border: 1px solid #bee5eb;
    }

    /* Mobile Navigation Tabs */
    .mobile-nav-tabs {
        display: none;
        flex-direction: row;
        background-color: #ffffff;
        border-bottom: 2px solid #f0f0f0;
        gap: 0;
        width: 100%;
        box-sizing: border-box;
    }

    .nav-tab {
        flex: 1;
        padding: 15px 0;
        border: none;
        background-color: transparent;
        color: #666;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        border-bottom: 3px solid transparent;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .nav-tab:hover {
        color: #FF4C61;
    }

    .nav-tab.active {
        color: #FF4C61;
        border-bottom-color: #FF4C61;
    }

    /* Checkbox styles */
    .checkbox-label {
        display: flex;
        align-items: center;
        cursor: pointer;
        font-size: small;
        color: #5c5c5cff;
        position: relative;
        padding-left: 28px;
        margin-bottom: 10px;
    }

    .checkbox-label input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    .checkmark {
        position: absolute;
        top: 50%;
        left: 0;
        transform: translateY(-50%);
        height: 18px;
        width: 18px;
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 3px;
    }

    .checkbox-label:hover input~.checkmark {
        background-color: #f5f5f5;
    }

    .checkbox-label input:checked~.checkmark {
        background-color: #FF4C61;
        border-color: #FF4C61;
    }

    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    .checkbox-label input:checked~.checkmark:after {
        display: block;
    }

    .checkbox-label .checkmark:after {
        left: 6px;
        top: 2px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }

    .remember-forgot {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 13px;
        margin: 10px 0;
        gap: 10px;
        flex-wrap: wrap;
    }

    .remember-forgot .checkbox-label {
        margin-bottom: 0;
        flex: 1;
        min-width: 120px;
    }

    .remember-forgot a {
        color: #FF4C61;
        text-decoration: none;
        white-space: nowrap;
    }

    .remember-forgot a:hover {
        text-decoration: underline;
    }

    .terms-container {
        width: 100%;
        margin: 10px 0;
        text-align: left;
    }

    /* Desktop Layout - Full Side by Side */
    .container#container {
        width: 100%;
        max-width: 1100px;
        min-height: 600px;
        margin: 20px auto;
        position: relative;
        display: flex;
        padding: 0 15px;
        box-sizing: border-box;
    }

    .form-container {
        position: absolute;
        top: 0;
        height: 100%;
        transition: all 0.6s ease-in-out;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .form-container form {
        width: 100%;
        max-width: 100%;
    }

    .form-container form h1 {
        font-size: 28px;
        margin: 0 0 20px 0;
    }

    .form-container form input {
        width: 100%;
        padding: 12px;
        margin: 8px 0;
        border: 1px solid #e0e0e0;
        border-radius: 5px;
        font-size: 14px;
        box-sizing: border-box;
    }

    .form-container form button {
        margin-top: 15px;
        width: 100%;
        padding: 12px;
        border-radius: 5px;
    }

    .sign-in-container {
        left: 0;
        padding: 40px;
        width: 50%;
        z-index: 2;
    }

    .container.right-panel-active .sign-in-container {
        transform: translateX(100%);
    }

    .sign-up-container {
        left: 0;
        padding: 40px;
        width: 50%;
        opacity: 0;
        z-index: 1;
    }

    .container.right-panel-active .sign-up-container {
        transform: translateX(100%);
        opacity: 1;
        z-index: 5;
        animation: show 0.6s;
    }

    @keyframes show {
        0%, 49.99% {
            opacity: 0;
            z-index: 1;
        }
        50%, 100% {
            opacity: 1;
            z-index: 5;
        }
    }

    .overlay-container {
        position: absolute;
        top: 0;
        left: 50%;
        width: 50%;
        height: 100%;
        overflow: hidden;
        transition: transform 0.6s ease-in-out;
        z-index: 100;
    }

    .container.right-panel-active .overlay-container {
        transform: translateX(-100%);
    }

    .overlay {
        background: #FF416C;
        background: -webkit-linear-gradient(to right, #FF4C61, #FF416C);
        background: linear-gradient(to right, #FF4C61, #FF416C);
        background-repeat: no-repeat;
        background-size: cover;
        background-position: 0 0;
        color: #FFFFFF;
        position: relative;
        left: -100%;
        height: 100%;
        width: 200%;
        transform: translateX(0);
        transition: transform 0.6s ease-in-out;
    }

    .container.right-panel-active .overlay {
        transform: translateX(50%);
    }

    .overlay-panel {
        position: absolute;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 40px 20px;
        text-align: center;
        top: 0;
        height: 100%;
        width: 50%;
        transform: translateX(0);
        transition: transform 0.6s ease-in-out;
    }

    .overlay-panel h1 {
        font-size: 32px;
        margin: 0 0 15px 0;
    }

    .overlay-panel p {
        margin: 10px 0;
        font-size: 14px;
    }

    .overlay-left {
        transform: translateX(-20%);
    }

    .container.right-panel-active .overlay-left {
        transform: translateX(0);
    }

    .overlay-right {
        right: 0;
        transform: translateX(0);
    }

    .container.right-panel-active .overlay-right {
        transform: translateX(20%);
    }

    .ghost {
        background-color: transparent;
        border-color: #FFFFFF;
        color: #FFFFFF;
        cursor: pointer;
        font-size: 12px;
        font-weight: bold;
        padding: 12px 45px;
        letter-spacing: 1px;
        text-transform: uppercase;
        transition: transform 0.3s ease;
        border: 2px solid #FFFFFF;
        border-radius: 5px;
    }

    .ghost:hover {
        transform: scale(1.05);
    }

    .social-container {
        margin: 20px 0;
    }

    .social {
        border: 1px solid #e0e0e0;
        border-radius: 50%;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        margin: 0 5px;
        height: 40px;
        width: 40px;
        transition: background-color 0.3s;
    }

    .social:hover {
        background-color: #f0f0f0;
    }

    /* Tablet Responsive (768px - 1024px) */
    @media screen and (max-width: 1024px) {
        .container#container {
            min-height: 550px;
        }

        .sign-in-container,
        .sign-up-container {
            padding: 30px;
        }

        .overlay-panel {
            padding: 30px 15px;
        }

        .overlay-panel h1 {
            font-size: 26px;
        }

        .form-container form h1 {
            font-size: 24px;
        }

        .form-container form input {
            padding: 10px;
            font-size: 13px;
        }
    }

    /* Small Tablet (600px - 768px) */
    @media screen and (max-width: 768px) {
        .mobile-nav-tabs {
            display: flex;
            width: 100%;
            margin: 0;
            padding: 0;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .nav-tab {
            padding: 15px 0;
        }

        .container#container {
            min-height: auto;
            position: relative;
            margin: 0 auto;
            padding: 0;
            box-shadow: none !important;
            border: none;
        }

        .form-container {
            position: relative;
            width: 100% !important;
            left: 0 !important;
            transform: none !important;
            opacity: 1 !important;
            z-index: auto !important;
            padding: 30px 20px;
            min-height: auto;
            animation: none !important;
            box-shadow: none !important;
            border: none !important;
        }

        .sign-in-container,
        .sign-up-container {
            position: relative;
            width: 100% !important;
            padding: 0;
            left: 0;
            height: auto;
            display: none;
        }

        .sign-in-container {
            display: block;
            z-index: 2;
        }

        .container.right-panel-active .sign-in-container {
            display: none;
            transform: none;
        }

        .container.right-panel-active .sign-up-container {
            display: block;
            transform: none;
            opacity: 1;
            z-index: 2;
            animation: none;
        }

        .sign-up-container {
            display: none;
        }

        .overlay-container {
            display: none;
        }

        .form-container form h1 {
            font-size: 22px;
            margin: 0 0 15px 0;
        }

        .form-container form input {
            padding: 11px;
            font-size: 14px;
            margin: 10px 0;
        }

        .form-container form button {
            margin-top: 15px;
            padding: 12px;
            font-size: 14px;
        }

        .remember-forgot {
            flex-direction: column;
            align-items: flex-start;
        }

        .remember-forgot .checkbox-label {
            min-width: auto;
            margin-bottom: 10px;
        }

        .remember-forgot a {
            align-self: flex-start;
        }

        .checkbox-label {
            font-size: 13px;
        }

        .social-container {
            margin: 15px 0;
        }

        .text-sm {
            font-size: 13px !important;
        }
    }

    /* Mobile Small (360px - 600px) */
    @media screen and (max-width: 600px) {
        .mobile-nav-tabs {
            display: flex;
        }

        .container#container {
            margin: 10px 5px;
            padding: 0 10px;
            box-shadow: none !important;
        }

        .form-container {
            padding: 20px 15px;
            box-shadow: none !important;
            border: none !important;
        }

        .form-container form h1 {
            font-size: 20px;
            margin: 0 0 12px 0;
        }

        .form-container form span {
            font-size: 12px;
            margin: 8px 0;
        }

        .form-container form input {
            padding: 10px;
            font-size: 13px;
            margin: 8px 0;
        }

        .form-container form button {
            margin-top: 12px;
            padding: 11px;
            font-size: 13px;
        }

        .alert-message {
            padding: 10px;
            font-size: 12px;
            margin: 8px 0;
        }

        .checkbox-label {
            font-size: 12px;
            padding-left: 26px;
        }

        .checkmark {
            height: 16px;
            width: 16px;
        }

        .remember-forgot {
            font-size: 12px;
            margin: 8px 0;
        }

        .social-container {
            margin: 12px 0;
        }

        .social {
            height: 36px;
            width: 36px;
            margin: 0 4px;
        }

        .social svg {
            width: 14px;
            height: 14px;
        }
    }

    /* Extra Small Mobile (320px - 360px) */
    @media screen and (max-width: 360px) {
        .form-container {
            padding: 15px 10px;
            box-shadow: none !important;
            border: none !important;
        }

        .container#container {
            box-shadow: none !important;
        }

        .form-container form h1 {
            font-size: 18px;
        }

        .form-container form input {
            padding: 9px;
            font-size: 12px;
        }

        .form-container form button {
            padding: 10px;
            font-size: 12px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Cek URL parameter
        const urlParams = new URLSearchParams(window.location.search);
        const formType = urlParams.get('form');

        if (formType === 'register') {
            // Trigger click pada button Sign Up di overlay
            document.getElementById('signUp').click();
        }

        // Tetap pertahankan fungsi existing button
        const signUpButton = document.getElementById('signUp');
        const signInButton = document.getElementById('signIn');
        const container = document.getElementById('container');

        signUpButton.addEventListener('click', () => {
            container.classList.add("right-panel-active");
            updateMobileNavTabs('signup');
        });

        signInButton.addEventListener('click', () => {
            container.classList.remove("right-panel-active");
            updateMobileNavTabs('signin');
        });

        // Mobile Navigation Tabs Handler
        const navTabs = document.querySelectorAll('.nav-tab');
        navTabs.forEach(tab => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                const formType = this.getAttribute('data-form');
                
                // Update active tab
                navTabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');

                // Toggle form visibility
                if (formType === 'signup') {
                    container.classList.add("right-panel-active");
                } else {
                    container.classList.remove("right-panel-active");
                }
            });
        });

        // Function to update active tab based on form shown
        function updateMobileNavTabs(formType) {
            if (window.innerWidth <= 768) {
                const navTabs = document.querySelectorAll('.nav-tab');
                navTabs.forEach(tab => tab.classList.remove('active'));
                
                if (formType === 'signup') {
                    document.querySelector('[data-form="signup"]').classList.add('active');
                } else {
                    document.querySelector('[data-form="signin"]').classList.add('active');
                }
            }
        }

        // Check initial form on load for mobile
        if (window.innerWidth <= 768) {
            const isSignUp = container.classList.contains('right-panel-active');
            updateMobileNavTabs(isSignUp ? 'signup' : 'signin');
        }
    });
</script>
@endpush
@endsection