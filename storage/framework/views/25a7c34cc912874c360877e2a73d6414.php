<?php $__env->startSection('title', 'Login'); ?>

<?php $__env->startSection('content'); ?>
<div class="container" id="container">
    <!-- Sign Up Form -->
    <div class="form-container sign-up-container">
        <form method="POST" action="<?php echo e(route('register')); ?>">
            <?php echo csrf_field(); ?>
            <h1>Create Account</h1>
            <div class="social-container">
                <a href="<?php echo e(route('register.google')); ?>" class="social google-btn">
                    <svg width="18" height="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                        <path fill="#FF416C" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z" />
                        <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z" />
                        <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z" />
                        <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z" />
                    </svg>
                </a>
            </div>
            <span>or use your email for registration</span>

            <?php if(session('error')): ?>
            <div class="alert-message error">
                <?php echo e(session('error')); ?>

            </div>
            <?php endif; ?>

            <?php if(session('info')): ?>
            <div class="alert-message info">
                <?php echo e(session('info')); ?>

            </div>
            <?php endif; ?>

            <input type="text" name="name" placeholder="Name" value="<?php echo e(old('name')); ?>" required />
            <input type="email" name="email" placeholder="Email" value="<?php echo e(old('email')); ?>" required />
            <input type="password" name="password" placeholder="Password" required />
            <input type="password" name="password_confirmation" placeholder="Confirm Password" required />

            <div class="terms-container">
                <label class="checkbox-label">
                    <input type="checkbox" name="terms" value="1" <?php echo e(old('terms') ? 'checked' : ''); ?> required>
                    <span class="checkmark"></span>
                    I agree to the <a href="<?php echo e(route('terms-conditions')); ?>" style="color: #FF4C61;"> Terms and Conditions</a>
                </label>
            </div>

            <button type="submit">Sign Up</button>
        </form>
    </div>

    <!-- Sign In Form -->
    <div class="form-container sign-in-container">
        <form method="POST" action="<?php echo e(route('login.post')); ?>">
            <?php echo csrf_field(); ?>
            <h1>Sign in</h1>
            <div class="social-container">
                <a href="<?php echo e(route('login.google')); ?>" class="social google-btn">
                    <svg width="18" height="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                        <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z" />
                        <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z" />
                        <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z" />
                        <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z" />
                    </svg>
                </a>
            </div>
            <span>or use your account</span>

            <?php if(session('success')): ?>
            <div class="alert-message success">
                <?php echo e(session('success')); ?>

            </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
            <div class="alert-message error">
                <?php echo e(session('error')); ?>

            </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
            <div class="alert-message error">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div><?php echo e($error); ?></div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php endif; ?>

            <input type="text" name="email" placeholder="Email or Phone Number" value="<?php echo e(old('email')); ?>"
                required />
            <input type="password" name="password" placeholder="Password" required />

            <div class="remember-forgot">
                <label class="checkbox-label">
                    <input type="checkbox" name="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                    <span class="checkmark"></span>
                    Remember me
                </label>
                <?php if(Route::has('password.request')): ?>
                <a href="<?php echo e(route('password.request')); ?>">Forgot Password ?</a>
                <?php endif; ?>
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

<?php $__env->startPush('styles'); ?>
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
        /* Pusatkan checkbox secara vertikal */
        transform: translateY(-50%);
        height: 18px;
        /* Diperbesar sedikit */
        width: 18px;
        /* Diperbesar sedikit */
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
        /* Posisikan centang di tengah */
        left: 6px;
        top: 2px;
        /* Buat ukuran centang lebih kecil agar tidak terpotong */
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
    }

    .remember-forgot .checkbox-label {
        /* Pastikan label di remember-forgot tidak ada margin bawahnya */
        margin-bottom: 0;
    }

    .remember-forgot a {
        color: #FF4C61;
        text-decoration: none;
    }

    .remember-forgot a:hover {
        text-decoration: underline;
    }

    .terms-container {
        width: 100%;
        margin: 10px 0;
        text-align: left;
    }

    /* Responsive adjustments for 67% zoom */
    @media screen and (max-width: 1400px) {
        #container {
            transform: scale(0.85);
            transform-origin: center center;
        }
    }

    @media screen and (max-width: 1200px) {
        #container {
            transform: scale(0.75);
            transform-origin: center center;
        }
    }

    @media screen and (max-width: 992px) {
        #container {
            transform: scale(1);
            transform-origin: center center;
            width: 90% !important;
            max-width: 800px !important;
        }
    }

    /* Alternative: Adjust container size directly */
    .container#container {
        width: 100%;
        max-width: 1100px;
        min-height: 600px;
        margin: 50px auto;
        position: relative;
    }

    /* Ensure forms are properly sized */
    .form-container {
        position: absolute;
        top: 0;
        height: 100%;
        transition: all 0.6s ease-in-out;
    }

    .sign-in-container {
        left: 0;
        padding: 0 30px 0 30px;
        width: 50%;
        z-index: 2;
    }

    .container.right-panel-active .sign-in-container {
        transform: translateX(100%);
    }

    .sign-up-container {
        left: 0;
        padding: 0 30px 0 30px;
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

        0%,
        49.99% {
            opacity: 0;
            z-index: 1;
        }

        50%,
        100% {
            opacity: 1;
            z-index: 5;
        }
    }

    /* Overlay adjustments */
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
        padding: 0 40px;
        text-align: center;
        top: 0;
        height: 100%;
        width: 50%;
        transform: translateX(0);
        transition: transform 0.6s ease-in-out;
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
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
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
        });

        signInButton.addEventListener('click', () => {
            container.classList.remove("right-panel-active");
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJEK PROJEK\Ebook-Traveling\resources\views/auth/login.blade.php ENDPATH**/ ?>