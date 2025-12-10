<?php $__env->startSection('title', 'Contact - MeatMap'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .contact-container {
        padding: 2rem 0;
        background-color: #f7f9fb;
        min-height: 80vh;
        display: flex;
        align-items: center;
    }

    .contact-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin: 0 auto;
    }

    .contact-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 25px;
    }

    .contact-title {
        font-size: 2rem;
        font-weight: 700;
        color: #FF4C61;
        margin-bottom: 1rem;
    }

    .contact-subtitle {
        color: #666;
        margin-bottom: 2rem;
        line-height: 1.5;
    }

    .contact-item {
        display: flex;
        align-items: center;
        padding: 1.5rem;
        margin-bottom: 1rem;
        /* border: 1px solid #eaeaea; */
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .contact-icon {
        width: 50px;
        height: 50px;
        background: #FF4C61;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        flex-shrink: 0;
    }

    .contact-icon i {
        font-size: 1.2rem;
    }

    .contact-detail h3 {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.25rem;
    }

    .contact-detail p {
        color: #666;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }

    .contact-detail a {
        color: #FF4C61;
        font-weight: 500;
        text-decoration: none;
    }

    .contact-detail a:hover {
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .contact-container {
            padding: 1rem 0;
        }

        .contact-title {
            font-size: 1.5rem;
        }

        .contact-item {
            padding: 1rem;
        }
    }
</style>

<div class="contact-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="row g-0">
                    <!-- Contact Image -->
                    <div class="col-lg-6 d-none d-lg-block">
                        <div class="h-100 p-4">
                            <a href="/"><img class="contact-image" src="/images/banner-contact.webp" alt="Contact MeatMap" /></a>
                        </div>
                    </div>

                    <!-- Contact Content -->
                    <div class="col-lg-6">
                        <div class="p-4 p-md-5">
                            <h1 class="contact-title">
                                Get In Touch
                            </h1>
                            <p class="contact-subtitle">
                                We're here to help! Reach out to us through any of these channels for prompt assistance.
                            </p>

                            <div class="contact-list">
                                <!-- WhatsApp -->
                                <div class="contact-item">
                                    <div class="contact-icon">
                                        <i class="bi bi-whatsapp"></i>
                                    </div>
                                    <div class="contact-detail">
                                        <h3>Instagram Support</h3>
                                        <p>Available Monday - Friday, 8:00 AM - 5:00 PM</p>
                                        <a href="https://wa.me/6281234567890" target="_blank">
                                            Message Us on WhatsApp
                                        </a>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="contact-item">
                                    <div class="contact-icon">
                                        <i class="bi bi-envelope"></i>
                                    </div>
                                    <div class="contact-detail">
                                        <h3>Email Support</h3>
                                        <p>Detailed inquiries? We'll get back to you within 24 hours</p>
                                        <a href="mailto:customercare@meatmap.id">
                                            customercare@meatmap.id
                                        </a>
                                    </div>
                                </div>

                                <!-- Phone -->
                                <div class="contact-item">
                                    <div class="contact-icon">
                                        <i class="bi bi-telephone"></i>
                                    </div>
                                    <div class="contact-detail">
                                        <h3>Phone Support</h3>
                                        <p>Speak directly with our customer service team</p>
                                        <a href="tel:+628112345678">
                                            +62 811 2345 678
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts_lp.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views/contact.blade.php ENDPATH**/ ?>