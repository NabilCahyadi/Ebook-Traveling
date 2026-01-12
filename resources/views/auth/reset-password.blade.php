@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
<div class="auth-centered-container">
    <div class="auth-centered-form">
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="email" value="{{ session('email') }}">
            <input type="hidden" name="token" value="{{ session('token') }}">
            
            <h1>Reset Password 🔒</h1>
            <span>Password baru Anda harus berbeda dari password sebelumnya</span>

            @if (session('error'))
            <div class="alert-message error">
                {{ session('error') }}
            </div>
            @endif

            @if ($errors->has('password'))
            <div class="alert-message error">
                {{ $errors->first('password') }}
            </div>
            @endif

            <div class="password-input-wrapper">
                <input 
                    type="password" 
                    id="password"
                    name="password" 
                    placeholder="Password Baru" 
                    required
                />
                <i class="fas fa-eye toggle-password" onclick="togglePassword('password')"></i>
            </div>

            <div class="password-input-wrapper">
                <input 
                    type="password" 
                    id="password_confirmation"
                    name="password_confirmation" 
                    placeholder="Konfirmasi Password" 
                    required
                />
                <i class="fas fa-eye toggle-password" onclick="togglePassword('password_confirmation')"></i>
            </div>

            <button type="submit">Set Password Baru</button>

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
    
    .auth-centered-form span {
        font-size: 14px;
        margin: 10px 0 30px;
        color: #666;
        font-weight: 300;
    }
    
    .auth-centered-form button {
        border-radius: 20px;
        border: 1px solid #FF4B2B;
        background-color: #FF4B2B;
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
    
    .auth-centered-form button:hover {
        background-color: #e43d23;
    }
    
    .password-input-wrapper {
        position: relative;
        width: 100%;
        margin: 8px 0;
    }
    
    .password-input-wrapper input {
        width: 100%;
        padding: 12px 40px 12px 15px;
        background-color: #eee;
        border: none;
        border-radius: 5px;
        font-size: 14px;
    }
    
    .toggle-password {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #aaa;
    }
    
    .toggle-password:hover {
        color: #FF4B2B;
    }
    
    .back-link {
        margin-top: 15px;
    }
    
    .back-link a {
        color: #FF4B2B;
        text-decoration: none;
        font-weight: bold;
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

<script>
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const icon = input.nextElementSibling;
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
@endsection
