<?php $__env->startSection('title', 'Kebijakan Berbelanja - MeatMap'); ?>

<?php $__env->startSection('content'); ?>
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
    }
</style>

<div class="policy-container bg-gray-50 min-h-screen py-12 sm:py-16">
    <div class="container mx-auto px-4">
        <div class="flex justify-center">
            <!-- Konten policy akan terpusat dan memiliki lebar maksimal yang baik -->
            <div class="w-full lg:max-w-4xl xl:max-w-3xl">
                <div class="policy-content bg-white shadow-2xl rounded-2xl p-6 sm:p-10 md:p-12 space-y-6">

                    <!-- JUDUL UTAMA -->
                    <h1 class="policy-title text-4xl sm:text-5xl font-extrabold text-indigo-700 mb-3 leading-tight">
                        Shopping Policy
                    </h1>
                    <div class="last-updated text-sm text-gray-500 border-b border-indigo-100 pb-4 mb-6">
                        Last updated: November 25, 2025
                    </div>

                    <p class="paragraph text-gray-600 text-lg leading-relaxed">
                        This Shopping Policy explains the purchase process, delivery, and related policies for digital products (ebooks and guides) on the MeatMap platform. By making a purchase, you agree to the terms listed below.
                    </p>

                    <!-- SEKSI 1: PROSES PEMBELIAN -->
                    <h2 class="section-title text-3xl font-bold text-gray-800 pt-8 border-t border-gray-100 mt-8">
                        1. Purchase Process
                    </h2>

                    <h3 class="subsection-title text-xl font-semibold text-gray-700 mt-6 mb-3">
                        1.1. How to Shop
                    </h3>
                    <p class="paragraph text-gray-600 leading-relaxed">
                        To purchase digital products on MeatMap:
                    </p>
                    <ul class="policy-list space-y-2 pl-6 text-gray-700">
                        <li>Select the ebook or guide you wish to purchase</li>
                        <li>Click the "Buy Now" or "Add to Cart" button</li>
                        <li>Login or register for a MeatMap account (if you don't have one)</li>
                        <li>Select the available payment method</li>
                        <li>Confirm and complete the payment</li>
                    </ul>

                    <h3 class="subsection-title text-xl font-semibold text-gray-700 mt-6 mb-3">
                        1.2. Purchase Confirmation
                    </h3>
                    <p class="paragraph text-gray-600 leading-relaxed">
                        After successful payment, you will receive:
                    </p>
                    <ul class="policy-list space-y-2 pl-6 text-gray-700">
                        <li>Purchase confirmation email</li>
                        <li>Direct access to the purchased digital product</li>
                        <li>Notification in your MeatMap account</li>
                    </ul>

                    <!-- SEKSI 2: PRODUK DIGITAL -->
                    <h2 class="section-title text-3xl font-bold text-gray-800 pt-8 border-t border-gray-100 mt-8">
                        2. Digital Products
                    </h2>

                    <h3 class="subsection-title text-xl font-semibold text-gray-700 mt-6 mb-3">
                        2.1. Access and Usage
                    </h3>
                    <p class="paragraph text-gray-600 leading-relaxed">
                        Purchased digital products can be accessed via:
                    </p>
                    <ul class="policy-list space-y-2 pl-6 text-gray-700">
                        <li>Your MeatMap account in the "Library" or "My Collection" section</li>
                        <li>MeatMap application (if available)</li>
                        <li>Download link sent via email</li>
                    </ul>

                    <h3 class="subsection-title text-xl font-semibold text-gray-700 mt-6 mb-3">
                        2.2. Format and Compatibility
                    </h3>
                    <p class="paragraph text-gray-600 leading-relaxed">
                        Our products are available in various formats:
                    </p>
                    <ul class="policy-list space-y-2 pl-6 text-gray-700">
                        <li><strong>PDF:</strong> Readable on most devices</li>
                        <li><strong>EPUB:</strong> Standard format for e-readers</li>
                        <li><strong>MOBI:</strong> Specifically for Amazon Kindle</li>
                    </ul>

                    <!-- SEKSI 3: PENGIRIMAN -->
                    <h2 class="section-title text-3xl font-bold text-gray-800 pt-8 border-t border-gray-100 mt-8">
                        3. Digital Product Delivery
                    </h2>
                    <p class="paragraph text-gray-600 leading-relaxed">
                        Due to its digital nature, the product will be available immediately after payment is confirmed:
                    </p>
                    <ul class="policy-list space-y-2 pl-6 text-gray-700">
                        <li><strong>Instant:</strong> Direct access after successful payment</li>
                        <li><strong>24/7:</strong> Accessible anytime</li>
                        <li><strong>Permanent:</strong> As long as your account is active</li>
                    </ul>

                    <!-- SEKSI 4: PEMBATASAN -->
                    <h2 class="section-title text-3xl font-bold text-gray-800 pt-8 border-t border-gray-100 mt-8">
                        4. Restrictions and Usage Rights
                    </h2>
                    <p class="paragraph text-gray-600 leading-relaxed">
                        Digital product usage rights:
                    </p>
                    <ul class="policy-list space-y-2 pl-6 text-gray-700">
                        <li>For personal use only</li>
                        <li>Prohibited from reproducing, distributing, or reselling</li>
                        <li>Maximum of 3 devices per account</li>
                        <li>Access rights may be revoked if terms are violated</li>
                    </ul>

                    <div class="contact-footer mt-10 pt-6 border-t border-indigo-100 text-center text-sm text-gray-500">
                        <p>For further questions regarding the shopping policy, please contact our customer service.</p>
                        <p class="mt-2">&copy; 2025 MeatMap. All Rights Reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts_lp.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views/shopping-policy.blade.php ENDPATH**/ ?>