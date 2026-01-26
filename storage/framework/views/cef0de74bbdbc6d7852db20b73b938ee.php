<!DOCTYPE html>
<html lang="en" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="<?php echo e(asset('assets/admin/')); ?>/" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Verify Code - Admin MeatMap</title>
    <meta name="description" content="Admin Verify Code" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('images/only-logoo.png')); ?>" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/admin/vendor/fonts/fontawesome.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('assets/admin/vendor/fonts/tabler-icons.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('assets/admin/vendor/fonts/flag-icons.css')); ?>" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/admin/vendor/css/rtl/core.css')); ?>"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?php echo e(asset('assets/admin/vendor/css/rtl/theme-default.css')); ?>"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?php echo e(asset('assets/admin/css/demo.css')); ?>" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/admin/vendor/libs/node-waves/node-waves.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('assets/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('assets/admin/vendor/libs/typeahead-js/typeahead.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('assets/admin/vendor/libs/@form-validation/form-validation.css')); ?>" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/admin/vendor/css/pages/page-auth.css')); ?>" />

    <!-- Helpers -->
    <script src="<?php echo e(asset('assets/admin/vendor/js/helpers.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/admin/vendor/js/template-customizer.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/admin/js/config.js')); ?>"></script>

    <style>
        :root {
            --bs-primary: #ff4c61 !important;
            --bs-primary-rgb: 255, 76, 97 !important;
        }

        .code-input {
            width: 50px;
            height: 50px;
            text-align: center;
            font-size: 24px;
            font-weight: 600;
            margin: 0 5px;
            border: 2px solid #d9dee3;
            border-radius: 8px;
        }

        .code-input:focus {
            border-color: #ff4c61;
            box-shadow: 0 0 0 0.2rem rgba(255, 76, 97, 0.25);
        }

        .code-container {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }

        .resend-timer {
            color: #ff4c61;
            font-weight: 500;
        }

        .btn-primary {
            background-color: #ff4c61 !important;
            border-color: #ff4c61 !important;
        }

        .btn-primary:hover,
        .btn-primary:focus,
        .btn-primary:active {
            background-color: #e6405a !important;
            border-color: #e6405a !important;
        }

        .text-primary,
        a {
            color: #ff4c61 !important;
        }

        a:hover {
            color: #e6405a !important;
        }
    </style>
</head>

<body>
    <!-- Content -->
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">
                <!-- Verify Code Card -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-4">
                            <a href="/" class="app-brand-link gap-2">
                                <img src="<?php echo e(asset('images/logo_horizontall.png')); ?>" alt="MeatMap Logo" style="height: 50px;">
                            </a>
                        </div>
                        <!-- /Logo -->

                        <h4 class="mb-1">Verifikasi Kode ✉️</h4>
                        <p class="mb-4">Kami telah mengirimkan kode 6 digit ke <strong><?php echo e(session('email')); ?></strong></p>

                        <?php if(session('success')): ?>
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <?php echo e(session('success')); ?>

                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <?php if(session('error')): ?>
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <?php echo e(session('error')); ?>

                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <form id="formVerifyCode" class="mb-3" action="<?php echo e(route('admin.password.verify')); ?>"
                            method="POST">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="email" value="<?php echo e(session('email')); ?>">
                            <input type="hidden" name="code" id="fullCode">

                            <div class="mb-3">
                                <label class="form-label">Masukkan Kode Verifikasi</label>
                                <div class="code-container">
                                    <input type="text" class="form-control code-input" maxlength="1" id="code1" autofocus>
                                    <input type="text" class="form-control code-input" maxlength="1" id="code2">
                                    <input type="text" class="form-control code-input" maxlength="1" id="code3">
                                    <input type="text" class="form-control code-input" maxlength="1" id="code4">
                                    <input type="text" class="form-control code-input" maxlength="1" id="code5">
                                    <input type="text" class="form-control code-input" maxlength="1" id="code6">
                                </div>
                            </div>

                            <button class="btn btn-primary d-grid w-100 mb-3" type="submit" id="btnVerify">
                                <span class="d-flex align-items-center justify-content-center">
                                    <i class="ti ti-check me-2"></i>
                                    <span>Verifikasi Kode</span>
                                </span>
                            </button>

                            <div class="text-center">
                                <p class="mb-0">
                                    Tidak menerima kode?
                                    <span id="resendContainer">
                                        <span class="resend-timer" id="timer">Tunggu <span id="countdown">60</span>s</span>
                                        <a href="#" id="btnResend" class="d-none" style="color: #ff4c61; font-weight: 500;">Kirim ulang kode</a>
                                    </span>
                                </p>
                            </div>
                        </form>

                        <div class="text-center">
                            <a href="<?php echo e(route('admin.login')); ?>" class="d-flex align-items-center justify-content-center">
                                <i class="ti ti-chevron-left scaleX-n1-rtl me-1"></i>
                                Back to login
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /Verify Code Card -->
            </div>
        </div>
    </div>
    <!-- / Content -->

    <!-- Core JS -->
    <script src="<?php echo e(asset('assets/admin/vendor/libs/jquery/jquery.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/admin/vendor/libs/popper/popper.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/admin/vendor/js/bootstrap.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/admin/vendor/libs/node-waves/node-waves.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/admin/vendor/libs/hammer/hammer.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/admin/vendor/libs/i18n/i18n.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/admin/vendor/libs/typeahead-js/typeahead.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/admin/vendor/js/menu.js')); ?>"></script>

    <!-- Main JS -->
    <script src="<?php echo e(asset('assets/admin/js/main.js')); ?>"></script>

    <script>
        $(document).ready(function() {
            // Auto focus to next input
            $('.code-input').on('keyup', function(e) {
                const $current = $(this);
                const value = $current.val();

                if (value.length === 1 && e.key !== 'Backspace') {
                    $current.next('.code-input').focus();
                }

                // Combine all codes
                let fullCode = '';
                $('.code-input').each(function() {
                    fullCode += $(this).val();
                });
                $('#fullCode').val(fullCode);

                // Auto submit when all 6 digits are entered
                if (fullCode.length === 6) {
                    $('#formVerifyCode').submit();
                }
            });

            // Handle backspace
            $('.code-input').on('keydown', function(e) {
                if (e.key === 'Backspace' && $(this).val() === '') {
                    $(this).prev('.code-input').focus();
                }
            });

            // Paste handler
            $('#code1').on('paste', function(e) {
                e.preventDefault();
                const pastedData = e.originalEvent.clipboardData.getData('text');
                const digits = pastedData.replace(/\D/g, '').substring(0, 6).split('');

                $('.code-input').each(function(index) {
                    if (digits[index]) {
                        $(this).val(digits[index]);
                    }
                });

                if (digits.length === 6) {
                    $('#fullCode').val(pastedData.replace(/\D/g, '').substring(0, 6));
                    $('#formVerifyCode').submit();
                }
            });

            // Countdown timer
            let countdown = 60;
            const timerInterval = setInterval(function() {
                countdown--;
                $('#countdown').text(countdown);

                if (countdown <= 0) {
                    clearInterval(timerInterval);
                    $('#timer').addClass('d-none');
                    $('#btnResend').removeClass('d-none');
                }
            }, 1000);

            // Resend code
            $('#btnResend').on('click', function(e) {
                e.preventDefault();

                $.ajax({
                    url: '<?php echo e(route("admin.password.resend-code")); ?>',
                    method: 'POST',
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>',
                        email: '<?php echo e(session("email")); ?>'
                    },
                    success: function(response) {
                        if (response.success) {
                            // Show success message
                            const alertHtml = `
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    ${response.message}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            `;
                            $(alertHtml).insertAfter('.app-brand');

                            // Reset timer
                            countdown = 60;
                            $('#countdown').text(countdown);
                            $('#btnResend').addClass('d-none');
                            $('#timer').removeClass('d-none');

                            // Clear code inputs
                            $('.code-input').val('');
                            $('#code1').focus();

                            // Restart countdown
                            const newTimerInterval = setInterval(function() {
                                countdown--;
                                $('#countdown').text(countdown);

                                if (countdown <= 0) {
                                    clearInterval(newTimerInterval);
                                    $('#timer').addClass('d-none');
                                    $('#btnResend').removeClass('d-none');
                                }
                            }, 1000);
                        }
                    },
                    error: function(xhr) {
                        const response = xhr.responseJSON;
                        const alertHtml = `
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                ${response.message || 'Terjadi kesalahan. Silakan coba lagi.'}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `;
                        $(alertHtml).insertAfter('.app-brand');
                    }
                });
            });
        });
    </script>
</body>

</html>
<?php /**PATH C:\laragon\www\ebook_traveling\resources\views\admin\auth\verify-code.blade.php ENDPATH**/ ?>