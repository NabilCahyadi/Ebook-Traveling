@extends('layouts.auth')

@section('title', 'Lupa Password')

@section('content')
<div class="auth-centered-container">
    <div class="auth-centered-form">
        <form method="POST" action="{{ route('password.send-code') }}">
            @csrf
            <!-- Icon di atas teks -->
            <svg class="title-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
            </svg>
            <h1>Lupa Password?</h1>
            <span>Masukkan email Anda dan kami akan mengirimkan kode verifikasi</span>

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
                placeholder="Masukkan email Anda" 
                value="{{ old('email') }}"
                required 
                autofocus
            />

            <button type="submit">Kirim Kode Verifikasi</button>

            <div class="back-link">
                <a href="{{ route('login') }}">← Kembali ke Login</a>
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
        box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
        padding: 50px;
        max-width: 450px;
        width: 100%;
    }
    
    .auth-centered-form form {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
    }
    
    .auth-centered-form h1 {
        font-weight: 400;
        margin: 0 0 10px;
        font-size: 28px;
        color: #333;
    }
    
    /* Icon di atas teks - Ubah width dan height untuk mengatur ukuran */
    .title-icon {
        width: 100px;        /* Ubah nilai ini untuk memperbesar/mengecilkan (contoh: 50px, 70px, 80px) */
        height: 100px;       /* Harus sama dengan width agar tetap proporsional */
        color: #FF4C61;
        margin-bottom: 15px;
        display: block;
        animation: swing 2s ease-in-out infinite;
    }
    
    @keyframes swing {
        0%, 100% {
            transform: rotate(0deg);
        }
        25% {
            transform: rotate(-10deg);
        }
        75% {
            transform: rotate(10deg);
        }
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
        /* font-weight: bold; */
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
