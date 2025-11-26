@extends('layouts_lp.app')
@section('title', 'Kebijakan Pembayaran - MeatMap')

@section('content')
<style>
    .policy-container {
        padding: 2rem 0;
        background-color: #f7f9fb;
        min-height: 80vh;
    }

    .policy-content {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        padding: 3rem;
        margin: 0 auto;
    }

    .policy-title {
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
        color: #71464b;
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
        margin-bottom: 0.75rem;
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

    .payment-methods {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin: 1.5rem 0;
    }

    .payment-method {
        text-align: center;
        padding: 1rem;
        border: 1px solid #eaeaea;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .payment-method:hover {
        border-color: #FF4C61;
        box-shadow: 0 2px 8px rgba(255, 76, 97, 0.1);
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
        .policy-content {
            padding: 2rem 1.5rem;
            margin: 0 1rem;
        }

        .policy-title {
            font-size: 1.5rem;
        }

        .section-title {
            font-size: 1.3rem;
        }

        .subsection-title {
            font-size: 1.1rem;
        }

        .payment-methods {
            grid-template-columns: 1fr;
        }
    }
</style>
<style>
    /* FAQ accordion styles (minimal & elegant) */
    .faqs-section .accordion-item {
        background: #fff;
        border: 1px solid #e6e9ee;
        border-radius: 10px;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .faqs-section .accordion-item:hover {
        border-color: #FF4C61;
    }

    .faqs-section .accordion-header {
        padding: 1.25rem 1.5rem;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .faqs-section .accordion-header h4 {
        font-size: 1rem;
        margin: 0;
        font-weight: 600;
        color: #111827;
        flex: 1;
    }

    .faqs-section .accordion-header i {
        color: #FF4C61;
        transition: transform 0.3s ease;
        font-size: 0.9rem;
    }

    .faqs-section .accordion-item.active .accordion-header i {
        transform: rotate(45deg);
    }

    .faqs-section .accordion-content {
        padding: 0 1.5rem;
        color: #6b7280;
        line-height: 1.6;
        max-height: 0;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .faqs-section .accordion-item.active .accordion-content {
        max-height: 500px;
        padding-bottom: 1.5rem;
    }

    @media (min-width: 768px) {
        .faqs-section .accordion-header h4 {
            font-size: 1.05rem;
        }
    }
</style>
<div class="policy-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="policy-content">
                    <!-- MAIN TITLE -->
                    <h1 class="policy-title">
                        Payment Policy
                    </h1>
                    <div class="last-updated">
                        Last updated: November 25, 2025
                    </div>

                    <p class="paragraph">
                        This Payment Policy outlines the payment methods, verification processes, and terms related to financial transactions on the MeatMap platform. We are committed to providing a secure and reliable payment system.
                    </p>

                    <!-- SECTION 1: PAYMENT METHODS -->
                    <h2 class="section-title">
                        1. Payment Methods
                    </h2>

                    <h3 class="subsection-title">
                        1.1. Accepted Methods
                    </h3>
                    <p class="paragraph">
                        MeatMap accepts various payment methods for transaction convenience:
                    </p>

                    <div class="payment-methods">
                        <div class="payment-method">
                            <h4>Bank Transfer</h4>
                            <p>BCA, BNI, Mandiri, BRI</p>
                        </div>
                        <div class="payment-method">
                            <h4>E-Wallet</h4>
                            <p>Gopay, OVO, Dana, LinkAja</p>
                        </div>
                        <div class="payment-method">
                            <h4>Credit Card</h4>
                            <p>Visa, Mastercard, JCB</p>
                        </div>
                        <div class="payment-method">
                            <h4>QRIS</h4>
                            <p>QR Code Payment</p>
                        </div>
                    </div>

                    <!-- SECTION 2: PAYMENT PROCESS -->
                    <h2 class="section-title">
                        2. Payment Process
                    </h2>

                    <h3 class="subsection-title">
                        2.1. Payment Verification
                    </h3>
                    <p class="paragraph">
                        Payment verification process:
                    </p>
                    <ul class="policy-list">
                        <li><strong>Instant:</strong> For e-wallets and credit cards (1-2 minutes)</li>
                        <li><strong>10-15 minutes:</strong> For virtual account bank transfers</li>
                        <li><strong>1-3 hours:</strong> For manual transfers</li>
                    </ul>

                    <h3 class="subsection-title">
                        2.2. Payment Deadline
                    </h3>
                    <p class="paragraph">
                        Every transaction has a payment deadline:
                    </p>
                    <ul class="policy-list">
                        <li>Virtual Account: 24 hours</li>
                        <li>E-wallet: 1 hour</li>
                        <li>QRIS: 30 minutes</li>
                    </ul>

                    <!-- SECTION 3: PAYMENT SECURITY -->
                    <h2 class="section-title">
                        3. Payment Security
                    </h2>
                    <p class="paragraph">
                        We use the best security systems to protect your transactions:
                    </p>
                    <ul class="policy-list">
                        <li>256-bit SSL Encryption</li>
                        <li>PCI DSS compliant</li>
                        <li>Two-factor authentication</li>
                        <li>24/7 transaction monitoring</li>
                    </ul>

                    <!-- SECTION 4: PAYMENT ISSUES AND SOLUTIONS -->
                    <h2 class="section-title">
                        4. Payment Issues and Solutions
                    </h2>

                    <h3 class="subsection-title">
                        4.1. Failed Payment
                    </h3>
                    <p class="paragraph">
                        If a payment fails, possible causes include:
                    </p>
                    <ul class="policy-list">
                        <li>Insufficient balance</li>
                        <li>Transaction limit exceeded</li>
                        <li>Network or system issue</li>
                        <li>Credit card rejected</li>
                    </ul>

                    <h3 class="subsection-title">
                        4.2. Double Charge
                    </h3>
                    <p class="paragraph">
                        If a double charge occurs:
                    </p>
                    <ul class="policy-list">
                        <li>Contact customer service immediately</li>
                        <li>Include proof of transaction</li>
                        <li>Refund process 3-7 business days</li>
                    </ul>

                    <div class="contact-footer">
                        <p>For payment assistance, please contact our support team at payment@meatmap.co</p>
                        <p>&copy; 2025 MeatMap. All Rights Reserved.</p>
                    </div>
                </div>
            </div>
            <!-- Frequently Asked Questions - minimal, elegant, readable -->
            <section class="faqs-section py-5">
                <div class="container">
                    <h3 class="text-center mb-3" style="font-size: 1.75rem; font-weight: 700; color: #FF4C61;">Pertanyaan yang Sering Diajukan</h3>
                    <p class="text-center text-muted mb-4" style="max-width:54rem;margin:0 auto; line-height: 1.6;">
                        Pertanyaan umum tentang berlangganan, pembayaran, dan mengakses panduan Anda. Jika membutuhkan bantuan lebih lanjut, hubungi tim support kami.
                    </p>

                    <div class="accordion" role="tablist" aria-label="FAQ MeatMap" style="max-width:900px;margin:0 auto;">

                        <div class="accordion-item">
                            <div class="accordion-header">
                                <h4>Apa yang termasuk dalam langganan MeatMap?</h4>
                                <i class="fas fa-plus" aria-hidden="true"></i>
                            </div>
                            <div class="accordion-content">
                                <p class="mb-0">Langganan Anda memberikan akses tak terbatas ke seluruh library panduan kuliner kami, termasuk versi yang dapat diunduh untuk offline, pembaruan konten reguler, dan prioritas support untuk rekomendasi personal.</p>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <div class="accordion-header">
                                <h4>Bisakah saya membatalkan kapan saja dan mendapatkan refund?</h4>
                                <i class="fas fa-plus" aria-hidden="true"></i>
                            </div>
                            <div class="accordion-content">
                                <p class="mb-0">Anda dapat membatalkan langganan kapan saja. Kelayakan refund tergantung pada paket dan siklus penagihan Anda — silakan tinjau kebijakan pengembalian dana kami atau hubungi support untuk bantuan terkait penagihan.</p>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <div class="accordion-header">
                                <h4>Apakah panduan bisa digunakan offline setelah diunduh?</h4>
                                <i class="fas fa-plus" aria-hidden="true"></i>
                            </div>
                            <div class="accordion-content">
                                <p class="mb-0">Ya — panduan yang sudah diunduh tersedia offline di perangkat Anda. Pastikan untuk mengunduhnya saat terhubung internet. Konten offline akan diperbarui saat Anda terhubung kembali.</p>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <div class="accordion-header">
                                <h4>Bisakah satu langganan digunakan di banyak perangkat?</h4>
                                <i class="fas fa-plus" aria-hidden="true"></i>
                            </div>
                            <div class="accordion-content">
                                <p class="mb-0">Ya, Anda bisa login di beberapa perangkat dengan akun yang sama. Beberapa batasan mungkin berlaku tergantung penggunaan bersamaan; hubungi support jika membutuhkan akses tim atau enterprise.</p>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <div class="accordion-header">
                                <h4>Bagaimana cara memperbarui metode pembayaran?</h4>
                                <i class="fas fa-plus" aria-hidden="true"></i>
                            </div>
                            <div class="accordion-content">
                                <p class="mb-0">Pergi ke pengaturan akun → Tagihan untuk memperbarui detail pembayaran. Jika mengalami masalah memperbarui kartu, hubungi tim billing kami dan kami akan membantu Anda memperbaruinya dengan aman.</p>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <div class="accordion-header">
                                <h4>Bagaimana jika lupa password akun?</h4>
                                <i class="fas fa-plus" aria-hidden="true"></i>
                            </div>
                            <div class="accordion-content">
                                <p class="mb-0">Gunakan fitur "Lupa Password" di halaman login. Kami akan mengirim link reset password ke email Anda. Link berlaku selama 1 jam untuk keamanan.</p>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const accordionItems = document.querySelectorAll('.accordion-item');

        accordionItems.forEach(item => {
            const header = item.querySelector('.accordion-header');

            header.addEventListener('click', () => {
                // Close all other items
                accordionItems.forEach(otherItem => {
                    if (otherItem !== item) {
                        otherItem.classList.remove('active');
                    }
                });

                // Toggle current item
                item.classList.toggle('active');
            });
        });
    });
</script>
@endsection