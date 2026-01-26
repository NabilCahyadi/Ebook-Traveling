<?php $__env->startSection('title', 'Verifikasi Kode'); ?>

<?php $__env->startSection('content'); ?>
<div class="auth-centered-container">
    <div class="auth-centered-form">
        <form method="POST" action="<?php echo e(route('password.verify')); ?>">
            <?php echo csrf_field(); ?>
            <h1>Verify Code</h1>
            <span>Enter the 6-digit code sent to<br><?php echo e(session('email')); ?></span>

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

            <?php if($errors->has('code')): ?>
            <div class="alert-message error">
                <?php echo e($errors->first('code')); ?>

            </div>
            <?php endif; ?>

            <div class="code-input-container">
                <input type="text" class="code-input" maxlength="1" />
                <input type="text" class="code-input" maxlength="1" />
                <input type="text" class="code-input" maxlength="1" />
                <input type="text" class="code-input" maxlength="1" />
                <input type="text" class="code-input" maxlength="1" />
                <input type="text" class="code-input" maxlength="1" />
            </div>
            <input type="hidden" name="code" id="combinedCode" />
            <input type="hidden" name="email" value="<?php echo e(session('email')); ?>" />

            <button type="button" id="resendBtn" class="resend-button" onclick="resendCode()">
                <span id="resendText">Resend Code</span>
                <span id="countdown" style="display: none;"></span>
            </button>
        </form>

        <form id="resend-form" method="POST" action="<?php echo e(route('password.resend-code')); ?>" style="display: none;">
            <?php echo csrf_field(); ?>
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
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
        padding: 50px 30px;
        /* ✅ Kurangi padding dari 50px ke 30px */
        max-width: 450px;
        width: 100%;
        /* margin: 0 20px; */
    }

    .auth-centered-form form {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        width: 100%;
    }

    .auth-centered-form h1 {
        font-weight: 400;
        margin: 0 0 8px;
        /* ✅ Kurangi margin bawah */
        font-size: 24px;
        /* ✅ Ukuran lebih proporsional */
        color: #333;
    }

    .auth-centered-form span {
        font-size: 14px;
        margin: 8px 0 20px;
        /* ✅ Kurangi margin */
        color: #666;
        font-weight: 300;
        line-height: 1.4;
    }

    .auth-centered-form input:not(.code-input) {
        background-color: #eee;
        border: none;
        padding: 12px 15px;
        margin: 8px 0;
        width: 100%;
        border-radius: 5px;
        font-size: 14px;
        box-sizing: border-box;
    }

    .auth-centered-form button {
        border-radius: 20px;
        border: 1px solid #FF4C61;
        background-color: #FF4C61;
        color: #FFFFFF !important;
        font-size: 13px;
        font-weight: 500;
        padding: 12px 45px;
        letter-spacing: 0.5px;
        text-transform: capitalize;
        transition: all 0.3s ease;
        cursor: pointer;
        margin-top: 15px;
        /* ✅ Kurangi margin atas */
        width: 100%;
        max-width: 100%;
        height: 45px;
        /* ✅ Tinggi lebih proporsional */
        display: flex;
        align-items: center;
        justify-content: center;
        white-space: nowrap;
        overflow: hidden;
    }

    .auth-centered-form button * {
        color: #FFFFFF !important;
    }

    .auth-centered-form button:active {
        transform: scale(0.95);
    }

    .auth-centered-form button:hover:not(:disabled) {
        background-color: #e63d52;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 76, 97, 0.3);
    }

    .auth-centered-form button:disabled {
        background-color: #ccc;
        border-color: #ccc;
        cursor: not-allowed;
        opacity: 0.6;
    }

    .code-input-container {
        display: flex;
        gap: 8px;
        /* ✅ Kurangi gap antar input */
        justify-content: center;
        margin: 15px 0;
        /* ✅ Kurangi margin */
    }

    .code-input {
        width: 45px;
        /* ✅ Ukuran lebih kompak */
        height: 45px;
        text-align: center;
        font-size: 20px;
        /* ✅ Font size lebih sesuai */
        font-weight: bold;
        border: 2px solid #ddd;
        border-radius: 8px;
        outline: none;
        background-color: #eee;
    }

    .code-input:focus {
        border-color: #FF4C61;
        background-color: white;
        box-shadow: 0 0 0 3px rgba(255, 76, 97, 0.1);
    }

    .code-input.filled {
        background-color: #FF4C61;
        color: white;
        border-color: #FF4C61;
    }

    #countdown {
        font-weight: bold;
        color: #FFFFFF !important;
    }

    #resendText {
        color: #FFFFFF !important;
    }

    .loading-spinner {
        display: inline-block;
        width: 14px;
        height: 14px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-top: 2px solid #FFFFFF;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
        margin-left: 5px;
        vertical-align: middle;
        flex-shrink: 0;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .success-message {
        color: #28a745;
        font-size: 12px;
        margin-top: 10px;
        display: none;
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

    .resend-button{
        padding-top: 10px;
    }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
    let countdownTimer = null;
    let timeLeft = 30;

    // Auto-focus and combine code inputs with AJAX auto-submit
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('.code-input');
        const hiddenInput = document.getElementById('combinedCode');
        const form = document.querySelector('form');

        // Start countdown on page load
        startCountdown();

        inputs.forEach((input, index) => {
            input.addEventListener('input', function(e) {
                // Only allow numbers
                this.value = this.value.replace(/[^0-9]/g, '');

                // Add filled class
                if (this.value) {
                    this.classList.add('filled');
                } else {
                    this.classList.remove('filled');
                }

                // Combine all values
                let code = '';
                inputs.forEach(inp => code += inp.value);
                hiddenInput.value = code;

                // Auto submit when all 6 digits are filled
                if (code.length === 6) {
                    submitVerification(code);
                }

                // Auto focus next input
                if (this.value && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });

            // Handle backspace
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && !this.value && index > 0) {
                    inputs[index - 1].focus();
                }
            });

            // Handle paste
            input.addEventListener('paste', function(e) {
                e.preventDefault();
                const pasteData = e.clipboardData.getData('text').replace(/[^0-9]/g, '');

                for (let i = 0; i < pasteData.length && index + i < inputs.length; i++) {
                    inputs[index + i].value = pasteData[i];
                    inputs[index + i].classList.add('filled');
                }

                // Combine all values
                let code = '';
                inputs.forEach(inp => code += inp.value);
                hiddenInput.value = code;

                // Auto submit if 6 digits
                if (code.length === 6) {
                    submitVerification(code);
                }

                // Focus last filled input
                const lastIndex = Math.min(index + pasteData.length, inputs.length - 1);
                inputs[lastIndex].focus();
            });
        });

        // Auto focus first input
        if (inputs.length > 0) {
            inputs[0].focus();
        }
    });

    function submitVerification(code) {
        const form = document.querySelector('form');
        const email = document.querySelector('input[name="email"]').value;

        // Show loading
        const alertContainer = document.querySelector('.auth-centered-form form');
        let loadingDiv = document.getElementById('loading-message');
        if (!loadingDiv) {
            loadingDiv = document.createElement('div');
            loadingDiv.id = 'loading-message';
            loadingDiv.className = 'alert-message';
            loadingDiv.style.backgroundColor = '#d1ecf1';
            loadingDiv.style.color = '#0c5460';
            loadingDiv.style.border = '1px solid #bee5eb';
            loadingDiv.innerHTML = '<span class="loading-spinner"></span> Memverifikasi kode...';
            form.insertBefore(loadingDiv, form.querySelector('.code-input-container'));
        }
        loadingDiv.style.display = 'block';

        // Send AJAX request
        fetch('<?php echo e(route("password.verify")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({
                    email: email,
                    code: code
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Verify response:', data);
                if (data.success) {
                    loadingDiv.style.display = 'none';
                    // Redirect to reset password page
                    window.location.href = data.redirect || '<?php echo e(route("password.reset")); ?>';
                } else {
                    loadingDiv.style.display = 'none';
                    showError(data.message || 'Kode verifikasi tidak valid');
                    clearInputs();
                }
            })
            .catch(error => {
                console.error('Verify error:', error);
                loadingDiv.style.display = 'none';
                showError('Terjadi kesalahan. Silakan coba lagi.');
                clearInputs();
            });
    }

    function showError(message) {
        let errorDiv = document.getElementById('ajax-error');
        if (!errorDiv) {
            errorDiv = document.createElement('div');
            errorDiv.id = 'ajax-error';
            errorDiv.className = 'alert-message error';
            const form = document.querySelector('form');
            form.insertBefore(errorDiv, form.querySelector('.code-input-container'));
        }
        errorDiv.textContent = message;
        errorDiv.style.display = 'block';

        setTimeout(() => {
            errorDiv.style.display = 'none';
        }, 5000);
    }

    function clearInputs() {
        const inputs = document.querySelectorAll('.code-input');
        inputs.forEach(input => {
            input.value = '';
            input.classList.remove('filled');
        });
        if (inputs.length > 0) {
            inputs[0].focus();
        }
    }

    function startCountdown() {
        const resendBtn = document.getElementById('resendBtn');
        const resendText = document.getElementById('resendText');
        const countdown = document.getElementById('countdown');

        resendBtn.disabled = true;
        resendText.style.display = 'none';
        countdown.style.display = 'inline';

        timeLeft = 30;
        countdown.textContent = `Kirim Ulang dalam ${timeLeft}s`;

        countdownTimer = setInterval(() => {
            timeLeft--;
            countdown.textContent = `Kirim Ulang dalam ${timeLeft}s`;

            if (timeLeft <= 0) {
                clearInterval(countdownTimer);
                resendBtn.disabled = false;
                resendText.style.display = 'inline';
                countdown.style.display = 'none';
            }
        }, 1000);
    }

    function resendCode() {
        const resendBtn = document.getElementById('resendBtn');
        const resendText = document.getElementById('resendText');
        const email = document.querySelector('input[name="email"]').value;

        if (!email) {
            showError('Email tidak ditemukan. Silakan mulai dari awal.');
            return;
        }

        // Disable button and show loading
        resendBtn.disabled = true;
        resendText.innerHTML = 'Mengirim... <span class="loading-spinner"></span>';

        // Send AJAX request
        fetch('<?php echo e(route("password.resend-code")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({
                    email: email
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Resend response:', data);
                resendText.textContent = 'Kirim Ulang Kode';

                if (data.success) {
                    // Show success message
                    const alertContainer = document.querySelector('.auth-centered-form form');
                    let successDiv = document.getElementById('resend-success');
                    if (!successDiv) {
                        successDiv = document.createElement('div');
                        successDiv.id = 'resend-success';
                        successDiv.className = 'alert-message success';
                        const form = document.querySelector('form');
                        form.insertBefore(successDiv, form.querySelector('.code-input-container'));
                    }
                    successDiv.textContent = data.message || 'Kode berhasil dikirim ulang!';
                    successDiv.style.display = 'block';

                    setTimeout(() => {
                        successDiv.style.display = 'none';
                    }, 5000);

                    // Restart countdown
                    startCountdown();
                    clearInputs();
                } else {
                    showError(data.message || 'Gagal mengirim kode. Silakan coba lagi.');
                    resendBtn.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                resendText.textContent = 'Kirim Ulang Kode';
                showError('Terjadi kesalahan. Silakan coba lagi.');
                resendBtn.disabled = false;
            });
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\auth\verify-code.blade.php ENDPATH**/ ?>