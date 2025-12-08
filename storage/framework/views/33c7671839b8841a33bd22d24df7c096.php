
<?php $__env->startSection('title', 'FAQs - MeatMap'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .faq-container {
        padding: 3rem 0;
        background-color: #f7f9fb;
        min-height: 80vh;
    }

    .faq-content {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        padding: 3rem;
        margin: 0 auto;
    }

    .faq-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #FF4C61;
        margin-bottom: 1rem;
        text-align: center;
    }

    .faq-subtitle {
        text-align: center;
        color: #666;
        font-size: 1rem;
        margin-bottom: 3rem;
        line-height: 1.6;
        max-width: 900px;
        margin-left: auto;
        margin-right: auto;
    }

    .faq-category {
        margin-bottom: 3rem;
    }

    .category-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #71464b;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #FF4C61;
    }

    /* FAQ Accordion Styles */
    .faq-accordion-item {
        background: #fff;
        border: 1px solid #e6e9ee;
        border-radius: 10px;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .faq-accordion-item:hover {
        border-color: #FF4C61;
        box-shadow: 0 2px 8px rgba(255, 76, 97, 0.1);
    }

    .faq-accordion-header {
        padding: 1.25rem 1.5rem;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .faq-accordion-header h4 {
        font-size: 1rem;
        margin: 0;
        font-weight: 600;
        color: #111827;
        flex: 1;
    }

    .faq-accordion-header i {
        color: #FF4C61;
        transition: transform 0.3s ease;
        font-size: 0.9rem;
    }

    .faq-accordion-item.active .faq-accordion-header i {
        transform: rotate(45deg);
    }

    .faq-accordion-content {
        padding: 0 1.5rem;
        color: #6b7280;
        line-height: 1.6;
        max-height: 0;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .faq-accordion-item.active .faq-accordion-content {
        max-height: 500px;
        padding-bottom: 1.5rem;
    }

    .contact-support {
        text-align: left;
        margin-top: 3rem;
        padding: 2rem;
        background: #f8fafc;
        border-radius: 10px;
        border: 1px solid #eaeaea;
    }

    .contact-support h4 {
        color: #71464b;
        margin-bottom: 1rem;
    }

    @media (max-width: 768px) {
        .faq-content {
            padding: 2rem 1.5rem;
            margin: 0 1rem;
        }

        .faq-title {
            font-size: 1.5rem;
        }

        .category-title {
            font-size: 1.3rem;
        }

        .faq-accordion-header h4 {
            font-size: 0.95rem;
        }

        .faq-accordion-header {
            padding: 1rem 1.25rem;
        }
    }
</style>

<div class="faq-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="faq-content">
                    <!-- MAIN TITLE -->
                    <h1 class="faq-title">
                        Frequently Asked Questions
                    </h1>
                    <p class="faq-subtitle">
                        Find answers to common questions about subscriptions, payments, and accessing travel eBooks on MeatMap. Need further assistance? Our <a href="<?php echo e(route('contact')); ?>">support team</a> is ready to help.
                    </p>

                    <!-- CATEGORY: SUBSCRIPTION & MEMBERSHIP -->
                    <div class="faq-category">
                        <h2 class="category-title">Subscription & Membership</h2>

                        <div class="faq-accordion-item">
                            <div class="faq-accordion-header">
                                <h4>What is included in the monthly MeatMap subscription?</h4>
                                <i class="fas fa-plus"></i>
                            </div>
                            <div class="faq-accordion-content">
                                <p>The monthly MeatMap subscription gives you:</p>
                                <ul>
                                    <li>Unlimited access to the entire collection of travel eBooks</li>
                                    <li>Latest destination guides every month</li>
                                    <li>Download eBooks for offline reading</li>
                                    <li>Regular content updates and exclusive travel tips</li>
                                    <li>Priority customer support 24/7</li>
                                </ul>
                            </div>
                        </div>

                        <div class="faq-accordion-item">
                            <div class="faq-accordion-header">
                                <h4>Can I cancel my subscription anytime?</h4>
                                <i class="fas fa-plus"></i>
                            </div>
                            <div class="faq-accordion-content">
                                <p>Yes, you can cancel your subscription at any time via the "Billing" page in your account. The cancellation will be effective at the end of the current billing period. There are no cancellation fees.</p>
                            </div>
                        </div>

                        <div class="faq-accordion-item">
                            <div class="faq-accordion-header">
                                <h4>Is there an annual subscription with a discount?</h4>
                                <i class="fas fa-plus"></i>
                            </div>
                            <div class="faq-accordion-content">
                                <p>Yes, we offer an annual subscription plan with a discount of up to 30% compared to the monthly subscription. The annual package provides full access for 12 months with a single payment.</p>
                            </div>
                        </div>
                    </div>

                    <!-- CATEGORY: PAYMENTS -->
                    <div class="faq-category">
                        <h2 class="category-title">Payments & Transactions</h2>

                        <div class="faq-accordion-item">
                            <div class="faq-accordion-header">
                                <h4>What payment methods are accepted?</h4>
                                <i class="fas fa-plus"></i>
                            </div>
                            <div class="faq-accordion-content">
                                <p>We accept various payment methods:</p>
                                <ul>
                                    <li><strong>Bank Transfer:</strong> BCA, BNI, Mandiri, BRI, and other banks</li>
                                    <li><strong>E-Wallet:</strong> Gopay, OVO, Dana, LinkAja</li>
                                    <li><strong>Credit Cards:</strong> Visa, Mastercard, JCB</li>
                                    <li><strong>QRIS:</strong> Payment via QR Code</li>
                                </ul>
                            </div>
                        </div>

                        <div class="faq-accordion-item">
                            <div class="faq-accordion-header">
                                <h4>What is the refund process?</h4>
                                <i class="fas fa-plus"></i>
                            </div>
                            <div class="faq-accordion-content">
                                <p>Refund policy:</p>
                                <ul>
                                    <li>Refunds can be requested within 7 days of purchase</li>
                                    <li>Only valid if the eBook has not been downloaded or accessed</li>
                                    <li>The refund process takes 3-7 working days</li>
                                    <li>Funds are returned to the original payment method</li>
                                </ul>
                                <p>Full details are on the <a href="<?php echo e(route('terms-conditions')); ?>">Refund Policy</a> page.</p>
                            </div>
                        </div>

                        <div class="faq-accordion-item">
                            <div class="faq-accordion-header">
                                <h4>What happens if the payment fails?</h4>
                                <i class="fas fa-plus"></i>
                            </div>
                            <div class="faq-accordion-content">
                                <p>If the payment fails:</p>
                                <ul>
                                    <li>The transaction status will be marked "Failed"</li>
                                    <li>You can try another payment method</li>
                                    <li>Failed transactions will not be charged</li>
                                    <li>Contact support if a double charge occurs</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- CATEGORY: EBOOK ACCESS -->
                    <div class="faq-category">
                        <h2 class="category-title">eBook Access & Reading</h2>

                        <div class="faq-accordion-item">
                            <div class="faq-accordion-header">
                                <h4>How do I access the eBook after subscribing?</h4>
                                <i class="fas fa-plus"></i>
                            </div>
                            <div class="faq-accordion-content">
                                <p>After a successful subscription:</p>
                                <ol>
                                    <li>Log in to your MeatMap account</li>
                                    <li>Go to the "Library" or "My Collection" page</li>
                                    <li>Click on the eBook you want to read</li>
                                    <li>Choose "Read in Browser" or "Download"</li>
                                </ol>
                            </div>
                        </div>

                        <div class="faq-accordion-item">
                            <div class="faq-accordion-header">
                                <h4>Can the eBooks be read offline?</h4>
                                <i class="fas fa-plus"></i>
                            </div>
                            <div class="faq-accordion-content">
                                <p>Yes! You can download eBooks for offline reading:</p>
                                <ul>
                                    <li>Download available in PDF, EPUB, and MOBI formats</li>
                                    <li>Downloaded eBooks are available on your device</li>
                                    <li>No internet connection needed to read</li>
                                    <li>Re-download is available anytime during the subscription period</li>
                                </ul>
                            </div>
                        </div>

                        <div class="faq-accordion-item">
                            <div class="faq-accordion-header">
                                <h4>On which devices can I read the eBooks?</h4>
                                <i class="fas fa-plus"></i>
                            </div>
                            <div class="faq-accordion-content">
                                <p>MeatMap eBooks can be accessed on:</p>
                                <ul>
                                    <li><strong>Smartphone & Tablet:</strong> Android and iOS via browser</li>
                                    <li><strong>Laptop/PC:</strong> All modern browsers (Chrome, Firefox, Safari, Edge)</li>
                                    <li><strong>E-Reader:</strong> Kindle (MOBI format), Kobo, and other e-readers</li>
                                    <li>Maximum of 3 active devices simultaneously</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- CATEGORY: ACCOUNT & TECHNICAL -->
                    <div class="faq-category">
                        <h2 class="category-title">🔧 Account & Technical Support</h2>

                        <div class="faq-accordion-item">
                            <div class="faq-accordion-header">
                                <h4>How do I reset my password?</h4>
                                <i class="fas fa-plus"></i>
                            </div>
                            <div class="faq-accordion-content">
                                <p>To reset your password:</p>
                                <ol>
                                    <li>Click "Forgot Password" on the login page</li>
                                    <li>Enter your registered email</li>
                                    <li>Check your email for the password reset link</li>
                                    <li>Click the link and create a new password</li>
                                    <li>The reset link is valid for 1 hour</li>
                                </ol>
                            </div>
                        </div>

                        <div class="faq-accordion-item">
                            <div class="faq-accordion-header">
                                <h4>Can I subscribe without a credit card?</h4>
                                <i class="fas fa-plus"></i>
                            </div>
                            <div class="faq-accordion-content">
                                <p>Certainly! Besides credit cards, you can use:</p>
                                <ul>
                                    <li>Bank transfer (virtual account)</li>
                                    <li>E-wallet (Gopay, OVO, Dana)</li>
                                    <li>Payment via minimarkets (Alfamart, Indomaret)</li>
                                    <li>QRIS for quick payment</li>
                                </ul>
                            </div>
                        </div>

                        <div class="faq-accordion-item">
                            <div class="faq-accordion-header">
                                <h4>What if I encounter technical problems?</h4>
                                <i class="fas fa-plus"></i>
                            </div>
                            <div class="faq-accordion-content">
                                <p>If you experience technical problems:</p>
                                <ul>
                                    <li>Check your internet connection</li>
                                    <li>Clear browser cache and cookies</li>
                                    <li>Try using a different browser</li>
                                    <li>Contact our support team via WhatsApp or email</li>
                                    <li>Include an error screenshot for faster assistance</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- CATEGORY: CONTENT & FEATURES -->
                    <div class="faq-category">
                        <h2 class="category-title">Content & Features</h2>

                        <div class="faq-accordion-item">
                            <div class="faq-accordion-header">
                                <h4>How often is new content added?</h4>
                                <i class="fas fa-plus"></i>
                            </div>
                            <div class="faq-accordion-content">
                                <p>We routinely add new content:</p>
                                <ul>
                                    <li><strong>New eBooks:</strong> 5-10 titles every month</li>
                                    <li><strong>Content Updates:</strong> Existing guides are regularly updated</li>
                                    <li><strong>New Destinations:</strong> Trending destinations are added every 2 weeks</li>
                                    <li><strong>Seasonal Guide:</strong> Seasonal guides for special holidays</li>
                                </ul>
                            </div>
                        </div>

                        <div class="faq-accordion-item">
                            <div class="faq-accordion-header">
                                <h4>Can I give ratings and reviews for the eBooks?</h4>
                                <i class="fas fa-plus"></i>
                            </div>
                            <div class="faq-accordion-content">
                                <p>Yes! We highly appreciate your feedback:</p>
                                <ul>
                                    <li>Give a 1-5 star rating for each eBook</li>
                                    <li>Write a review based on your reading experience</li>
                                    <li>Reviews help other travelers choose the best guide</li>
                                    <li>Ratings and reviews will be displayed publicly</li>
                                </ul>
                            </div>
                        </div>

                        <div class="faq-accordion-item">
                            <div class="faq-accordion-header">
                                <h4>Is there a search feature for specific destinations?</h4>
                                <i class="fas fa-plus"></i>
                            </div>
                            <div class="faq-accordion-content">
                                <p>Yes, we have a complete search feature:</p>
                                <ul>
                                    <li>Search by destination (Bali, Japan, Europe, etc.)</li>
                                    <li>Filter by category (Backpacker, Luxury, Family, etc.)</li>
                                    <li>Search by keyword (culinary, budget, accommodation)</li>
                                    <li>Sort by rating, newest, or most popular</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- CONTACT SUPPORT -->
                    <div class="contact-support">
                        <h4>Still Have Questions?</h4>
                        <p>Our support team is ready to assist you 24/7 via :</p>
                        <p>
                            <strong>WhatsApp :</strong> +62 812 3456 7890<br>
                            <strong>Email :</strong> support@meatmap.co<br>
                            <strong>Operating Hours :</strong> 08:00 - 22:00 WIB
                        </p>
                        <p>or click <a href="<?php echo e(route('contact')); ?>">contact</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const accordionItems = document.querySelectorAll('.faq-accordion-item');

        accordionItems.forEach(item => {
            const header = item.querySelector('.faq-accordion-header');

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

        // Auto-open first item in each category
        const categories = document.querySelectorAll('.faq-category');
        categories.forEach(category => {
            const firstItem = category.querySelector('.faq-accordion-item');
            if (firstItem) {
                firstItem.classList.add('active');
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts_lp.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJEK PROJEK\Ebook-Traveling\resources\views/faq.blade.php ENDPATH**/ ?>