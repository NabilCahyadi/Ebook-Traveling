<?php $__env->startSection('title', 'Pricing - MeatMap'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .icon-wrapper {
        width: 80px;
        height: 80px;
        margin: 0 auto 20px auto;
        background-color: #FF4C61;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .icon-wrapper i,
    .icon-wrapper svg {
        color: #FFFFFF;
        font-size: 35px;
    }
</style>
<style>
    /* Responsive grid for the pricing cards */
    @media (min-width: 768px) {
        div[style*="grid-template-columns"] {
            grid-template-columns: repeat(2, 1fr) !important;
        }
    }

    @media (min-width: 1024px) {
        div[style*="grid-template-columns"] {
            grid-template-columns: repeat(3, 1fr) !important;
        }
    }

    /* Hover effect for standard buttons (Starter and Business) */
    .pricing-button:hover {
        background-color: #E54457 !important;
        /* Slightly darker than #FF4C61 */
    }

    /* Hover effect for the inverted button (Pro - which has white background) */
    .pricing-button-inverted:hover {
        background-color: #f5f5f5 !important;
        /* Slightly off-white/lighter gray */
        color: #FF4C61 !important;
    }

    /* Ensure default buttons use the custom color for consistency in CSS overrides */
    .pricing-button {
        background-color: #FF4C61;
    }

    /* Updated checkmark color for all packages */
    ul li span {
        color: #FF4C61;
    }
</style>
<style>
    .accordion-content {
        transition: max-height 0.3s ease-out, padding 0.3s ease;
    }

    /* Styling untuk tombol Primary (Solid #FF4C61) */
    .btn-primary-custom:hover {
        background-color: #E54457 !important;
        /* BG menjadi lebih gelap */
        color: white !important;
        /* Warna teks tetap putih */
        transform: translateY(-1px);
        /* Efek sedikit naik */
    }

    /* Styling untuk tombol Secondary (Outline #FF4C61) */
    .btn-secondary-custom:hover {
        background-color: #FF4C61 !important;
        /* BG berubah menjadi warna utama */
        color: white !important;
        /* Teks berubah menjadi putih */
        transform: translateY(-1px);
        /* Efek sedikit naik */
    }

    /* Menghilangkan border pada hover tombol secondary agar tidak terlihat double */
    .btn-secondary-custom:hover {
        border-color: #E54457 !important;
        /* Opsi: Samakan border dengan warna hover primary, atau hilangkan border */
    }
</style>
<div class="container">
    <section class="home-slider position-relative mb-30">
        <div>
            <div class="style-4">
                <div class="rectangle single-animation-wrap rounded mt-15" style="position: relative;">
                    <img src="/images/banner-pricing.webp" alt="Banner" class="img-fluid w-100 rounded" id="pricing-banner-img">
                    <div class="js-fade-in" style="
                        position: absolute; 
                        top: 0; 
                        left: 0; 
                        width: 100%; 
                        height: 100%; 
                        display: flex; 
                        flex-direction: column;
                        justify-content: center; 
                        align-items: center;
                        text-align: center;
                        color: white; 
                        padding: 20px;
                        opacity: 0; /* start with invisible */
                        transition: opacity 1s ease-in-out; /* animation fade in */
                    ">
                        <div style="max-width: 800px; width: 90%;">
                            <h1 class="mb-30">
                                Access Every Guide<br />
                                Unlock Limitless Adventure.
                            </h1>
                            <p class="mb-65 lh-base" style="font-size: 25px;">Get instant, ad-free access to our entire library of verified city guides and premium travel itineraries.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end banner pricing -->
    <section class="benefits-section py-5">
        <div class="container text-center">
            <h3 class="mb-40">Why Choose Our MeatMap Guides ?</h3>
            <div class="row justify-content-center">
                <div class="col-md-4 mb-4">
                    <div class="benefit-card p-4 rounded shadow-sm">
                        <div class="icon-wrapper mb-3">
                            <i class="bi bi-globe-americas"></i>
                        </div>
                        <h3 class="h5 mb-2">Unlimited Guides, Anywhere</h3>
                        <p class="text-muted">Get instant access to our entire library of verified guides, from major cities to hidden gems.</p>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="benefit-card p-4 rounded shadow-sm">
                        <div class="icon-wrapper mb-3">
                            <i class="bi bi-file-earmark-arrow-down"></i>
                        </div>
                        <h3 class="h5 mb-2">Explore Offline, Stress-Free</h3>
                        <p class="text-muted">Download your guides once and access them anytime, anywhere, even without Wi-Fi or data roaming.</p>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="benefit-card p-4 rounded shadow-sm">
                        <div class="icon-wrapper mb-3">
                            <i class="bi bi-geo"></i>
                        </div>
                        <h3 class="h5 mb-2">Insider Tips & Secret Spots</h3>
                        <p class="text-muted">Access hand-picked recommendations from local experts and discover truly exclusive destinations.</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-4 mb-4">
                    <div class="benefit-card p-4 rounded shadow-sm">
                        <div class="icon-wrapper mb-3">
                            <i class="bi bi-card-checklist"></i>
                        </div>
                        <h3 class="h5 mb-2">Effortless Planning Tools</h3>
                        <p class="text-muted">Utilize interactive checklists and organized tools for a smooth, stress-free pre-trip planning experience.</p>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="benefit-card p-4 rounded shadow-sm">
                        <div class="icon-wrapper mb-3">
                            <i class="bi bi-arrow-repeat"></i>
                        </div>
                        <h3 class="h5 mb-2">Always Up-to-Date Routes</h3>
                        <p class="text-muted">Enjoy seamless routine updates with the newest routes, local tips, and latest travel regulations.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end why choose our -->
    <section class="benefits-section py-5">
        <div class="container text-center">
            <h3>Our Flexible Subscription Plans</h3>

            <p style="max-width: 50rem; margin: 0.5rem auto 0; text-align: center; color: #6b7280; margin-bottom: 3rem;">
                Choose the best plan to power your projects, from small personal websites to large-scale enterprise applications.
            </p>

            <div style="display: grid; grid-template-columns: repeat(1, 1fr); gap: 2rem; margin-top: 1.5rem;">
                <div style="width: 100%; padding: 2rem; text-align: center; border: 1px solid #FF4C61; border-radius: 0.5rem; display: flex; flex-direction: column; align-items: center;">
                    <p style="font-weight: 500; color: #6b7280; text-transform: uppercase; margin-bottom: 2rem;">Starter</p>
                    <h2 style="font-size: 2.25rem; font-weight: 600; color: #1f2937; text-transform: uppercase;">
                        $0
                    </h2>
                    <p style="font-weight: 500; color: #6b7280; margin-bottom: 1rem;">Always Free</p>
                    <ul style="font-size: 0.875rem; color: #6b7280; list-style: none; padding: 0; margin: 1rem 0 2rem; text-align: left; width: 100%; max-width: 12rem;">
                        <li style="margin-bottom: 0.5rem;"><span style="color: #FF4C61; margin-right: 0.5rem;">&#10003;</span> 1 Project Limit</li>
                        <li style="margin-bottom: 0.5rem;"><span style="color: #FF4C61; margin-right: 0.5rem;">&#10003;</span> 500 MB Storage</li>
                        <li style="margin-bottom: 0.5rem;"><span style="color: #FF4C61; margin-right: 0.5rem;">&#10003;</span> Community Support</li>
                    </ul>
                    <button class="pricing-button" style="width: 100%; padding: 0.5rem 1rem; margin-top: auto; letter-spacing: 0.05em; color: white; text-transform: capitalize; background-color: #FF4C61; border-radius: 0.375rem; border: none; cursor: pointer; transition: background-color 0.3s ease;">
                        Get Started
                    </button>
                </div>
                <div style="width: 100%; padding: 2rem; text-align: center; background-color: #FF4C61; border-radius: 0.5rem; display: flex; flex-direction: column; align-items: center;">
                    <p style="font-weight: 500; color: #e5e7eb; text-transform: uppercase; margin-bottom: 2rem;">Pro</p>
                    <h2 style="font-size: 3rem; font-weight: 700; color: white; text-transform: uppercase;">
                        $40
                    </h2>
                    <p style="font-weight: 500; color: #e5e7eb; margin-bottom: 1rem;">Per Month</p>
                    <ul style="font-size: 0.875rem; color: white; list-style: none; padding: 0; margin: 1rem 0 2rem; text-align: left; width: 100%; max-width: 12rem;">
                        <li style="margin-bottom: 0.5rem;"><span style="color: white; margin-right: 0.5rem;">&#10003;</span> Unlimited Projects</li>
                        <li style="margin-bottom: 0.5rem;"><span style="color: white; margin-right: 0.5rem;">&#10003;</span> 100 GB Storage</li>
                        <li style="margin-bottom: 0.5rem;"><span style="color: white; margin-right: 0.5rem;">&#10003;</span> Priority Email Support</li>
                        <li style="margin-bottom: 0.5rem;"><span style="color: white; margin-right: 0.5rem;">&#10003;</span> Custom Domain</li>
                    </ul>
                    <button class="pricing-button-inverted" style="width: 100%; padding: 0.5rem 1rem; margin-top: auto; letter-spacing: 0.05em; color: #FF4C61; text-transform: capitalize; background-color: white; border-radius: 0.375rem; border: none; cursor: pointer; transition: background-color 0.3s ease;">
                        Subscribe Now
                    </button>
                </div>
                <div style="width: 100%; padding: 2rem; text-align: center; border: 1px solid #FF4C61; border-radius: 0.5rem; display: flex; flex-direction: column; align-items: center;">
                    <p style="font-weight: 500; color: #6b7280; text-transform: uppercase; margin-bottom: 2rem;">Business</p>
                    <h2 style="font-size: 2.25rem; font-weight: 600; color: #1f2937; text-transform: uppercase;">
                        $100
                    </h2>
                    <p style="font-weight: 500; color: #6b7280; margin-bottom: 1rem;">Per Month</p>
                    <ul style="font-size: 0.875rem; color: #6b7280; list-style: none; padding: 0; margin: 1rem 0 2rem; text-align: left; width: 100%; max-width: 12rem;">
                        <li style="margin-bottom: 0.5rem;"><span style="color: #FF4C61; margin-right: 0.5rem;">&#10003;</span> Everything in Pro</li>
                        <li style="margin-bottom: 0.5rem;"><span style="color: #FF4C61; margin-right: 0.5rem;">&#10003;</span> Dedicated Server</li>
                        <li style="margin-bottom: 0.5rem;"><span style="color: #FF4C61; margin-right: 0.5rem;">&#10003;</span> 24/7 Phone Support</li>
                        <li style="margin-bottom: 0.5rem;"><span style="color: #FF4C61; margin-right: 0.5rem;">&#10003;</span> Uptime SLA 99.9%</li>
                    </ul>
                    <button class="pricing-button" style="width: 100%; padding: 0.5rem 1rem; margin-top: auto; letter-spacing: 0.05em; color: white; text-transform: capitalize; background-color: #FF4C61; border-radius: 0.375rem; border: none; cursor: pointer; transition: background-color 0.3s ease;">
                        Contact Sales
                    </button>
                </div>
            </div>
        </div>
    </section>
    <!-- end pricing cards-->
    <!-- Frequently Asked Questions - minimal, elegant, readable -->
    <section class="faqs-section py-5">
        <div class="container">
            <h3 class="text-center mb-3">Frequently Asked Questions</h3>
            <p class="text-center text-muted mb-4" style="max-width:54rem;margin:0 auto;">Common questions about subscriptions, billing, and accessing your guides. If you need further help, contact our support team.</p>

            <style>
                /* FAQ accordion styles (minimal & elegant) */
                .faqs-section .accordion-item {
                    background: #fff;
                    border: 1px solid #e6e9ee;
                }

                .faqs-section .accordion-header {
                    padding: 1rem 1rem;
                }

                .faqs-section .accordion-header h4 {
                    font-size: 1rem;
                    margin: 0;
                    font-weight: 600;
                    color: #111827;
                }

                .faqs-section .accordion-header i.fas {
                    color: #6b7280;
                    transition: transform 0.25s ease;
                }

                .faqs-section .accordion-item.bg-indigo-50 {
                    background-color: #f8fafc;
                }

                .faqs-section .accordion-content {
                    padding: 0 1rem 1rem 1rem;
                    color: #6b7280;
                }

                @media (min-width: 768px) {
                    .faqs-section .accordion-header h4 {
                        font-size: 1.05rem;
                    }
                }
            </style>

            <div class="accordion" role="tablist" aria-label="Subscription FAQs" style="max-width:900px;margin:0 auto;">

                <div class="accordion-item rounded shadow-sm mb-3 p-0">
                    <div class="accordion-header d-flex justify-content-between align-items-center px-3 py-3" style="cursor:pointer;">
                        <h4>What does the subscription include?</h4>
                        <i class="fas fa-plus" aria-hidden="true"></i>
                    </div>
                    <div class="accordion-content" style="max-height:0px; overflow:hidden; padding:0 1rem;">
                        <p class="mb-3 mt-3">Your subscription grants unlimited access to our full library of city guides, downloadable offline copies, regular content updates, and priority support for troubleshooting and recommendations.</p>
                    </div>
                </div>

                <div class="accordion-item rounded shadow-sm mb-3 p-0">
                    <div class="accordion-header d-flex justify-content-between align-items-center px-3 py-3" style="cursor:pointer;">
                        <h4>Can I cancel anytime and get a refund?</h4>
                        <i class="fas fa-plus" aria-hidden="true"></i>
                    </div>
                    <div class="accordion-content" style="max-height:0px; overflow:hidden; padding:0 1rem;">
                        <p class="mb-3 mt-3">You can cancel at any time. Refund eligibility depends on your plan and billing cycle — please review our refund policy in the terms or contact support for assistance with billing issues.</p>
                    </div>
                </div>

                <div class="accordion-item rounded shadow-sm mb-3 p-0">
                    <div class="accordion-header d-flex justify-content-between align-items-center px-3 py-3" style="cursor:pointer;">
                        <h4>Will guides work offline after download?</h4>
                        <i class="fas fa-plus" aria-hidden="true"></i>
                    </div>
                    <div class="accordion-content" style="max-height:0px; overflow:hidden; padding:0 1rem;">
                        <p class="mb-3 mt-3">Yes — downloaded guides are available offline on your device. Make sure to download them while you have an internet connection. Offline content updates when you reconnect.</p>
                    </div>
                </div>

                <div class="accordion-item rounded shadow-sm mb-3 p-0">
                    <div class="accordion-header d-flex justify-content-between align-items-center px-3 py-3" style="cursor:pointer;">
                        <h4>Can I use one subscription on multiple devices?</h4>
                        <i class="fas fa-plus" aria-hidden="true"></i>
                    </div>
                    <div class="accordion-content" style="max-height:0px; overflow:hidden; padding:0 1rem;">
                        <p class="mb-3 mt-3">Yes, you can sign in on multiple devices with your account. Some limits may apply depending on concurrent usage; contact support if you need team or enterprise access.</p>
                    </div>
                </div>

                <div class="accordion-item rounded shadow-sm mb-3 p-0">
                    <div class="accordion-header d-flex justify-content-between align-items-center px-3 py-3" style="cursor:pointer;">
                        <h4>How do I update my payment method?</h4>
                        <i class="fas fa-plus" aria-hidden="true"></i>
                    </div>
                    <div class="accordion-content" style="max-height:0px; overflow:hidden; padding:0 1rem;">
                        <p class="mb-3 mt-3">Go to your account settings → Billing to update payment details. If you encounter issues updating your card, contact our billing team and we’ll help you update it securely.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- end faqs-->
    <section class="newsletter mb-15 wow animate__animated animate__fadeIn">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="position-relative newsletter-inner">
                        <div class="newsletter-content">
                            <h3 class="mb-20">
                                Still confused about which subscription<br />
                                package is right for you ?
                            </h3>
                            <p class="mb-45">Let's chat with the Gramedia team to ask for more information about the subscription packages. <br> <span class="text-brand">We are ready to help.</span></p>
                            <div style="display: flex; flex-direction: row; gap: 1rem; justify-content: flex-start; align-items: center; flex-wrap: nowrap;">
                                <a href="/subscription" class="btn-primary-custom" style="background-color: #FF4C61; color: white; border: none; padding: 0.8rem 1.8rem; border-radius: 0.5rem; font-size: 1rem; cursor: pointer; transition: background-color 0.3s ease, transform 0.2s ease; white-space: nowrap; text-decoration: none;">
                                    Subscribe Now
                                </a>
                                <a href="/contact" class="btn-secondary-custom" style="background-color: transparent; color: #FF4C61; border: 2px solid #FF4C61; padding: 0.8rem 1.8rem; border-radius: 0.5rem; font-size: 1rem; cursor: pointer; transition: background-color 0.3s ease, color 0.3s ease, transform 0.2s ease; white-space: nowrap; text-decoration: none;">
                                    Call Us
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    function showBannerText() {
        const textElement = document.querySelector('.js-fade-in');
        if (textElement) {
            textElement.style.opacity = 1;
        }
    }
    window.addEventListener('load', showBannerText);
</script>
<script>
    // script for faqs
    const accordionHeader = document.querySelectorAll(".accordion-header");
    accordionHeader.forEach((header) => {
        header.addEventListener("click", function() {
            const accordionContent = header.parentElement.querySelector(".accordion-content");
            let accordionMaxHeight = accordionContent.style.maxHeight;

            // Condition handling
            if (accordionMaxHeight == "0px" || accordionMaxHeight.length == 0) {
                // Close all open content first (optional, for a single-open accordion)
                document.querySelectorAll(".accordion-content").forEach(content => {
                    if (content !== accordionContent) {
                        content.style.maxHeight = `0px`;
                        content.parentElement.classList.remove("bg-indigo-50");
                        content.parentElement.querySelector(".fas").classList.remove("fa-minus");
                        content.parentElement.querySelector(".fas").classList.add("fa-plus");
                    }
                });


                // Open current content
                accordionContent.style.maxHeight = `${accordionContent.scrollHeight + 32}px`;
                header.querySelector(".fas").classList.remove("fa-plus");
                header.querySelector(".fas").classList.add("fa-minus");
                header.parentElement.classList.add("bg-indigo-50");
            } else {
                // Close current content
                accordionContent.style.maxHeight = `0px`;
                header.querySelector(".fas").classList.add("fa-plus");
                header.querySelector(".fas").classList.remove("fa-minus");
                header.parentElement.classList.remove("bg-indigo-50");
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts_lp.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views/pricing.blade.php ENDPATH**/ ?>