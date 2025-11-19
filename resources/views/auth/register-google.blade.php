@extends('layouts.auth')

@section('title', 'Complete Registration')

@section('content')
<div class="container" id="container">
    <!-- Registration Form -->
    <div class="form-container sign-in-container">
        <form method="POST" action="{{ route('register.google.complete') }}">
            @csrf
            <h1>Complete Registration</h1>
            
            @if (!session('google_user'))
                <div class="alert-message error">
                    Session expired. <a href="{{ route('login.google') }}" style="color: #FF416C;">Login with Google again</a>
                </div>
            @else
                @if (session('info'))
                    <div class="alert-message info">
                        {{ session('info') }}
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

                <input type="text" name="name" placeholder="Full Name" 
                       value="{{ old('name', session('google_user.name')) }}" required />

                <input type="email" placeholder="Email (from Google)" 
                       value="{{ session('google_user.email') }}" readonly 
                       style="background-color: #f0f0f0; cursor: not-allowed;" />

                <input type="text" name="phone" placeholder="Phone Number (Optional)" 
                       value="{{ old('phone') }}" />

                <input type="password" name="password" placeholder="Create Password" required />

                <input type="password" name="password_confirmation" placeholder="Confirm Password" required />
                
                <small style="display: block; text-align: left; color: #666; font-size: 12px; margin: -5px 0 8px 0;">
                    Password for manual login (min. 8 characters)
                </small>

                <select name="language_pref" style="width: 100%; padding: 12px 15px; margin: 8px 0; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;">
                    <option value="en" {{ old('language_pref', 'en') == 'en' ? 'selected' : '' }}>English</option>
                    <option value="id" {{ old('language_pref') == 'id' ? 'selected' : '' }}>Bahasa Indonesia</option>
                </select>

                <div class="terms-checkbox">
                    <label>
                        <input type="checkbox" name="terms" required> 
                        I agree to <a href="#" style="color: #FF416C;">privacy policy & terms</a>
                    </label>
                </div>

                <button type="submit">Complete Registration</button>

                <div style="margin-top: 15px;">
                    <a href="{{ route('login') }}" style="color: #FF416C; text-decoration: none; font-size: 13px;">
                        ← Back to login
                    </a>
                </div>
            @endif
        </form>
    </div>

    <!-- Overlay Panel -->
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-right">
                <h1>Almost There! 🎉</h1>
                <p>Just a few more details to complete your registration</p>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    /* Container adjustments */
    #container {
        position: relative;
        max-width: 1100px;
        width: 90%;
        min-height: 600px;
        box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
    }



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

    .terms-checkbox {
        width: 100%;
        text-align: left;
        font-size: 13px;
        margin: 10px 0;
    }

    .terms-checkbox label {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }

    .terms-checkbox input[type="checkbox"] {
        width: auto;
        margin: 0;
    }

    /* Form container adjustments */
    .form-container {
        width: 50%;
        z-index: 2;
    }

    .sign-in-container {
        left: 0;
        width: 50%;
        z-index: 2;
        transform: translateX(0);
    }

    .overlay-container {
        width: 50%;
        left: 50%;
        overflow: hidden;
    }

    .overlay {
        background: #FF416C;
        background: -webkit-linear-gradient(to right, #FF4B2B, #FF416C);
        background: linear-gradient(to right, #FF4B2B, #FF416C);
        background-repeat: no-repeat;
        background-size: cover;
        background-position: 0 0;
        color: #FFFFFF;
        position: relative;
        left: 0%;
        height: 100%;
        width: 100%;
        transform: translateX(0);
        transition: transform 0.6s ease-in-out;
    }

    .overlay-panel {
        position: absolute;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 0 40px;
        text-align: center;
        top: 0;
        height: 100%;
        width: 100%;
        transform: translateX(0);
        transition: transform 0.6s ease-in-out;
    }

    .overlay-right {
        right: 0;
        transform: translateX(0);
    }

    /* Hide Sign Up container */
    .sign-up-container {
        display: none;
    }

    /* Make it responsive */
    @media (max-width: 768px) {
        .overlay-container {
            display: none;
        }

        .form-container {
            width: 100%;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Disable the sliding functionality for this page
    document.addEventListener('DOMContentLoaded', function() {
        const signUpButton = document.getElementById('signUp');
        const signInButton = document.getElementById('signIn');
        
        if (signUpButton) signUpButton.remove();
        if (signInButton) signInButton.remove();
    });
</script>
@endpush
@endsection
