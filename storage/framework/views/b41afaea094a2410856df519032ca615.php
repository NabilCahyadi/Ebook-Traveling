<?php $__env->startSection('title', 'Kebijakan Pembayaran - MeatMap'); ?>

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
                        Last updated : November 25, 2025
                    </div>

                    <p class="paragraph">
                        This Payment Policy outlines the payment methods, verification processes, and terms related to financial transactions on the MeatMap platform. We are committed to providing a secure and reliable payment system.
                    </p>

                    <!-- KONTEN DINAMIS (sama seperti help-center) -->
                    <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sectionTitle => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <h2 class="section-title"><?php echo e($sectionTitle); ?></h2>

                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($item->subsection_title): ?>
                    <h3 class="subsection-title"><?php echo e($item->subsection_title); ?></h3>
                    <?php endif; ?>

                    <?php if(str_contains($item->content, "\n")): ?>
                    <ul class="policy-list">
                        <?php $__currentLoopData = explode("\n", trim($item->content)); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(trim($line)): ?>
                        <li><?php echo preg_replace('/^([^:]*):\s*/', '<strong>$1:</strong> ', e($line)); ?></li>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <?php else: ?>
                    <p class="paragraph"><?php echo e($item->content); ?></p>
                    <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <div class="contact-footer">
                        <p>For payment assistance, please contact our support team at payment@meatmap.co</p>
                        <p>&copy; 2025 MeatMap. All Rights Reserved.</p>
                    </div>
                </div>
            </div>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts_lp.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJEK PROJEK\Ebook-Traveling\resources\views/payment-policy.blade.php ENDPATH**/ ?>