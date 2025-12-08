
<?php $__env->startSection('title', 'Terms & Conditions - MeatMap'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .terms-container {
        padding: 2rem 0;
        background-color: #f7f9fb;
        min-height: 80vh;
    }

    .terms-content {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        padding: 3rem;
        margin: 0 auto;
    }

    .terms-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #FF4C61;
        margin-bottom: 1rem;
        text-align: center;
    }

    .last-updated {
        text-align: center;
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 2.5rem;
        border-bottom: 1px solid #eaeaea;
        padding-bottom: 1.5rem;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #483638ff;
        margin: 2.5rem 0 1rem 0;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #FF4C61;
    }

    .subsection-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #FF4C61;
        margin: 1.5rem 0 0.75rem 0;
    }

    .paragraph {
        color: #333;
        line-height: 1.6;
        margin-bottom: 1rem;
        text-align: justify;
    }

    .policy-list {
        margin: 1rem 0;
        padding-left: 1.5rem;
    }

    .policy-list li {
        margin-bottom: 0.5rem;
        color: #333;
        line-height: 1.5;
        position: relative;
    }

    .policy-list li::before {
        content: "•";
        color: #FF4C61;
        font-weight: bold;
        position: absolute;
        left: -1rem;
    }

    .contact-footer {
        text-align: center;
        margin-top: 3rem;
        padding-top: 1.5rem;
        border-top: 1px solid #eaeaea;
        color: #666;
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .terms-content {
            padding: 2rem 1.5rem;
            margin: 0 1rem;
        }

        .terms-title {
            font-size: 1.5rem;
        }

        .section-title {
            font-size: 1.3rem;
        }

        .subsection-title {
            font-size: 1.1rem;
        }
    }
</style>

<div class="terms-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="terms-content">
                    <!-- JUDUL UTAMA -->
                    <h1 class="terms-title">
                        Terms & Conditions and Refund Policy
                    </h1>
                    <div class="last-updated">
                        Last updated: 25 November 2025
                    </div>

                    <!-- SEKSI 1: SYARAT & KETENTUAN -->
                    <h2 class="section-title">
                        1. Terms and Conditions for Ebook Service Usage
                    </h2>
                    <p class="paragraph">
                        Welcome to our ebook service. By accessing or using this Service, you agree to be bound by these Terms and Conditions. Please read them carefully before using our Service.
                    </p>

                    <!-- Sub Judul 1: Akun Pengguna -->
                    <h3 class="subsection-title">
                        1.1. User Account
                    </h3>
                    <p class="paragraph">
                        To access certain features of the Service, you may be required to register an account. You are responsible for maintaining the confidentiality of your password and for all activities that occur under your account.
                    </p>
                    <ul class="policy-list">
                        <li>You must be at least 18 years old, or have legal permission from a parent/guardian to use this Service.</li>
                        <li>You are prohibited from sharing your account login details with any other party.</li>
                    </ul>

                    <!-- Sub Judul 2: Lisensi dan Hak Cipta Ebook -->
                    <h3 class="subsection-title">
                        1.2. Ebook License and Copyright
                    </h3>
                    <p class="paragraph">
                        All ebooks provided within the Service are the property of their respective authors, publishers, or content providers and are protected by copyright laws.
                    </p>
                    <ul class="policy-list">
                        <li>You are granted a limited, non-exclusive, and non-transferable license to access and read the content for personal, non-commercial use.</li>
                        <li>You are prohibited from copying, distributing, selling, or modifying ebook content without written permission.</li>
                    </ul>

                    <!-- SEKSI 2: KEBIJAKAN PENGEMBALIAN DANA -->
                    <h2 class="section-title">
                        2. Refund Policy
                    </h2>
                    <p class="paragraph">
                        We are committed to providing the best content and service. However, due to the digital nature of our products, our refund policy has certain limitations.
                    </p>

                    <!-- Sub Judul 1: Syarat Umum Pengembalian Dana -->
                    <h3 class="subsection-title">
                        2.1. General Refund Conditions
                    </h3>
                    <p class="paragraph">
                        Refund requests can only be processed if they meet one of the following conditions:
                    </p>
                    <ul class="policy-list">
                        <li>The purchase was made less than 7 days ago.</li>
                        <li>The purchased ebook content is proven to be damaged, incomplete, or inaccessible due to technical issues on our side.</li>
                        <li>The user has not downloaded or accessed more than 5% of the total ebook content.</li>
                    </ul>

                    <!-- Sub Judul 2: Proses Pengembalian Dana -->
                    <h3 class="subsection-title">
                        2.2. Refund Process
                    </h3>
                    <p class="paragraph">
                        To submit a refund request, please contact our customer support team with the following details: order number, ebook title, and reason for the refund.
                    </p>
                    <ul class="policy-list">
                        <li>Requests will be reviewed within 5 business days.</li>
                        <li>If approved, the funds will be returned to the original payment method within 7-14 business days, depending on your bank's policy.</li>
                        <li>We reserve the right to reject refund requests if policy abuse is found.</li>
                    </ul>

                    <div class="contact-footer">
                        <p>For further questions, please contact our customer service.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts_lp.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJEK PROJEK\Ebook-Traveling\resources\views/terms-conditions.blade.php ENDPATH**/ ?>