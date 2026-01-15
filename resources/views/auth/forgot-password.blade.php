@extends('layouts.auth')

@section('title', 'Lupa Password')

@section('content')
<div class="auth-centered-container">
    <div class="auth-centered-form">
        <form method="POST" action="{{ route('password.send-code') }}">
            @csrf
            <!-- Logo di atas teks -->
            <img src="{{ asset('images/logo_horizontall.png') }}" alt="Logo" class="auth-logo">

            <h2>Forgot Password ?</h2>
            <span>Enter your email and we'll send you a verification code</span>

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

            @if ($errors->has('email'))
            <div class="alert-message error">
                {{ $errors->first('email') }}
            </div>
            @endif

            <input
                type="email"
                name="email"
                placeholder="Enter your email address"
                value="{{ old('email') }}"
                required
                autofocus />

            <button type="submit">Send Verification Code</button>

            <div class="back-link">
                <a href="{{ route('login') }}">← Back to Login</a>
            </div>
        </form>
    </div>
</div>

<style>
    .auth-centered-container {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #f5f5f5;
        padding: 20px;
    }

    .auth-centered-form {
        background: white;
        border-radius: 10px;
        box-shadow: 0 14px 28px rgba(101, 101, 101, 0.08), 0 10px 10px rgba(67, 67, 67, 0);
        padding: 50px 20px;
        max-width: 450px;
        width: 100%;
        margin: 0 20px;
    }

    .auth-centered-form form {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .auth-centered-form h2 {
        font-weight: 400;
        margin: 0 0 10px;
        /* font-size: 28px; */
        color: #333;
    }

    /* Logo di atas teks */
    .auth-logo {
        width: 150px;
        height: auto;
        margin-bottom: 20px;
        display: block;
    }

    .auth-centered-form span {
        font-size: 14px;
        margin: 10px 0 30px;
        color: #666;
        font-weight: 300;
    }

    .auth-centered-form input {
        background-color: #eee;
        border: none;
        padding: 12px 15px;
        margin: 8px 0;
        width: 100%;
        border-radius: 5px;
        font-size: 14px;
        box-sizing: border-box;
    }

    .auth-centered-form input:focus {
        outline: none;
        box-shadow: 0 0 3px rgba(255, 76, 97, 0.5);
        border: 1.5px solid #FF4C61;
    }

    .auth-centered-form button {
        border-radius: 20px;
        border: 1px solid #FF4C61;
        background-color: #FF4C61;
        color: #FFFFFF;
        font-size: 13px;
        font-weight: 500;
        padding: 12px 45px;
        letter-spacing: 0.5px;
        text-transform: capitalize;
        transition: transform 80ms ease-in;
        cursor: pointer;
        margin-top: 10px;
        width: 100%;
        box-sizing: border-box;
    }

    .auth-centered-form button:active {
        transform: scale(0.95);
    }

    .auth-centered-form button:focus {
        outline: none;
    }

    .auth-centered-form button:hover {
        background-color: #FF4C61;
    }

    .back-link {
        margin-top: 15px;
    }

    .back-link a {
        color: #FF4B2B;
        text-decoration: none;
        font-size: 14px;
    }

    .back-link a:hover {
        text-decoration: underline;
    }

    .alert-message {
        padding: 10px 15px;
        border-radius: 5px;
        margin: 10px 0;
        width: 100%;
        font-size: 14px;
        box-sizing: border-box;
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
</style>
@endsection