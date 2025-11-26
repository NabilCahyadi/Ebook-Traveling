@extends('layouts_lp.app')
@section('title', 'Privacy Policy - MeatMap')

@section('content')
<style>
    .privacy-container {
        padding: 2rem 0;
        background-color: #f7f9fb;
        min-height: 80vh;
    }

    .privacy-content {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        padding: 3rem;
        margin: 0 auto;
    }

    .privacy-title {
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

    .policy-list strong {
        color: #71464b;
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
        .privacy-content {
            padding: 2rem 1.5rem;
            margin: 0 1rem;
        }

        .privacy-title {
            font-size: 1.5rem;
        }

        .section-title {
            font-size: 1.3rem;
        }

        .subsection-title {
            font-size: 1.1rem;
        }

        .policy-list {
            padding-left: 1rem;
        }
    }
</style>

<div class="privacy-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="privacy-content">
                    <!-- JUDUL UTAMA -->
                    <h1 class="privacy-title">
                        MeatMap Privacy Policy
                    </h1>
                    <div class="last-updated">
                        Last updated: 25 November 2025
                    </div>

                    <p class="paragraph">
                        MeatMap (hereinafter referred to as "We" or "Us") is committed to protecting the privacy of our users' personal data. This Privacy Policy explains how We collect, use, disclose, and protect your personal information when you use our services and applications (hereinafter referred to as the "Service").
                    </p>

                    <!-- SEKSI 1: INFORMASI YANG KAMI KUMPULKAN -->
                    <h2 class="section-title">
                        1. Information We Collect
                    </h2>

                    <h3 class="subsection-title">
                        1.1. Personal Data You Provide
                    </h3>
                    <p class="paragraph">
                        We collect personal information that you provide directly to Us, including but not limited to:
                    </p>
                    <ul class="policy-list">
                        <li><strong>Account Data:</strong> Full name, email address, phone number, and encrypted password when you create an account.</li>
                        <li><strong>Profile Data:</strong> Date of birth, gender, and profile photo.</li>
                        <li><strong>Transaction Data:</strong> Information related to subscription or ebook/guide purchases (payment method, purchase history, although We do not store credit card data directly).</li>
                        <li><strong>Communication:</strong> Information you provide when contacting customer service or participating in surveys.</li>
                    </ul>

                    <h3 class="subsection-title">
                        1.2. Automatically Collected Data
                    </h3>
                    <p class="paragraph">
                        When you access Our Service, We may automatically collect certain information:
                    </p>
                    <ul class="policy-list">
                        <li><strong>Location Data:</strong> The geographical location of your device (if you enable location services) to provide relevant destination content ("Near Me").</li>
                        <li><strong>Device Data:</strong> IP address, device type, operating system, unique device identifier, and cellular network data.</li>
                        <li><strong>Usage Data:</strong> Pages you visit, time spent on those pages, links clicked, and other interaction patterns.</li>
                    </ul>

                    <!-- SEKSI 2: PENGGUNAAN INFORMASI -->
                    <h2 class="section-title">
                        2. Use of Information
                    </h2>
                    <p class="paragraph">
                        We use the information We collect for various purposes, including:
                    </p>
                    <ul class="policy-list">
                        <li>Providing, administering, and maintaining Our Service (including granting access to ebooks and guides).</li>
                        <li>Processing your transactions and sending purchase confirmations.</li>
                        <li>Analyzing Service usage to improve functionality and user experience.</li>
                        <li>Sending technical updates, security notifications, and support messages.</li>
                        <li>Conducting marketing and promotions, including sending information about Our new offers and products (if you consent).</li>
                        <li>Protecting, investigating, and preventing illegal activities, fraud, or misuse.</li>
                    </ul>

                    <!-- SEKSI 3: PENGUNGKAPAN DAN BERBAGI INFORMASI -->
                    <h2 class="section-title">
                        3. Disclosure and Sharing of Information
                    </h2>
                    <p class="paragraph">
                        We will not sell your personal data to third parties. We will only share information in the following situations:
                    </p>
                    <ul class="policy-list">
                        <li><strong>Service Providers:</strong> To third parties who perform services on Our behalf (e.g., payment processors, cloud service providers, or analytics services). These parties only have access to the information necessary to perform their functions.</li>
                        <li><strong>Legal Compliance:</strong> If required by law, court order, or valid legal process.</li>
                        <li><strong>Business Transfer:</strong> In connection with a merger, sale of company assets, financing, or acquisition of all or part of Our business.</li>
                        <li><strong>With Your Consent:</strong> We may share your information for other purposes that We explain at the time of data collection, with your consent.</li>
                    </ul>

                    <!-- SEKSI 4: KEAMANAN DATA -->
                    <h2 class="section-title">
                        4. Data Security
                    </h2>
                    <p class="paragraph">
                        We take reasonable security measures to protect personal information from loss, theft, misuse, unauthorized access, disclosure, alteration, and destruction.
                    </p>
                    <ul class="policy-list">
                        <li>We use encryption (SSL/TLS) to protect the transmission of sensitive data.</li>
                        <li>Password data is stored in an irreversible hash format.</li>
                        <li>Access to personal data is restricted only to employees and contractors who need the information to perform their duties.</li>
                    </ul>

                    <!-- SEKSI 5: PILIHAN DAN HAK PENGGUNA -->
                    <h2 class="section-title">
                        5. User Choices and Rights
                    </h2>
                    <p class="paragraph">
                        You have certain rights regarding your personal data:
                    </p>
                    <ul class="policy-list">
                        <li><strong>Access and Correction:</strong> You can review and update your account information through profile settings.</li>
                        <li><strong>Withdrawal of Consent:</strong> You can withdraw your consent for the collection of certain data (such as location data) at any time through your device settings.</li>
                        <li><strong>Unsubscribe:</strong> You can opt out of receiving marketing emails from Us by clicking the "unsubscribe" link in those emails.</li>
                        <li><strong>Data Deletion:</strong> You can request the deletion of your account and personal data by contacting customer service.</li>
                    </ul>

                    <!-- SEKSI 6: PERUBAHAN KEBIJAKAN PRIVASI -->
                    <h2 class="section-title">
                        6. Changes to This Privacy Policy
                    </h2>
                    <p class="paragraph">
                        We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page. You are advised to review this Privacy Policy periodically for any changes. Changes are effective immediately upon being posted on this page.
                    </p>

                    <!-- SEKSI 7: KONTAK KAMI -->
                    <h2 class="section-title">
                        7. Contact Us
                    </h2>
                    <p class="paragraph">
                        If you have any questions about this Privacy Policy, please contact Us via:
                    </p>
                    <ul class="policy-list">
                        <li><strong>Email : </strong> privacy@meatmap.com</li>
                        <li><strong>Address : </strong> [Your Company Address]</li>
                        <li><strong>Phone Number : </strong> [Your Phone Number]</li>
                    </ul>

                    <div class="contact-footer">
                        <p>&copy; 2025 MeatMap. All Rights Reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection