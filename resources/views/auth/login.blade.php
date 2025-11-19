@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="container" id="container">
    <!-- Sign Up Form -->
    <div class="form-container sign-up-container">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <h1>Create Account</h1>
            <div class="social-container">
                <a href="{{ route('login.google') }}" class="social"><i class="fab fa-google"></i></a>
                <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
            </div>
            <span>or use your email for registration</span>
            <input type="text" name="name" placeholder="Name" value="{{ old('name') }}" required />
            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required />
            <input type="password" name="password" placeholder="Password" required />
            <input type="password" name="password_confirmation" placeholder="Confirm Password" required />
            <button type="submit">Sign Up</button>
        </form>
    </div>

    <!-- Sign In Form -->
    <div class="form-container sign-in-container">
        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <h1>Sign in</h1>
            <div class="social-container">
                <a href="{{ route('login.google') }}" class="social"><i class="fab fa-google"></i></a>
                <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
            </div>
            <span>or use your account</span>

            @if (session('success'))
                <div class="alert-message success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert-message error">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert-message error">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <input type="text" name="email" placeholder="Email or Phone Number" value="{{ old('email') }}" required />
            <input type="password" name="password" placeholder="Password" required />
            
            <div class="remember-forgot">
                <label>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember me
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">Forgot password?</a>
                @endif
            </div>
            
            <button type="submit">Sign In</button>
        </form>
    </div>

    <!-- Overlay Panels -->
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
                <h1>Welcome Back!</h1>
                <p>To keep connected with us please login with your personal info</p>
                <button class="ghost" id="signIn">Sign In</button>
            </div>
            <div class="overlay-panel overlay-right">
                <h1>Hello, Friend!</h1>
                <p>Enter your personal details and start journey with us</p>
                <button class="ghost" id="signUp">Sign Up</button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
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
    .remember-forgot {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 13px;
        margin: 10px 0;
    }
    .remember-forgot label {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .remember-forgot a {
        color: #FF4B2B;
        text-decoration: none;
    }
    .remember-forgot a:hover {
        text-decoration: underline;
    }
</style>
@endpush
@endsection
