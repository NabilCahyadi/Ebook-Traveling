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
                    <h1 class="terms-title">Terms & Conditions and Refund Policy</h1>
                    <div class="last-updated">Last updated : 25 November 2025</div>

                    <!-- Konten dinamis -->
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
                        <li><?php echo preg_replace('/^-\s*/', '', e($line)); ?></li>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <?php else: ?>
                    <p class="paragraph"><?php echo e($item->content); ?></p>
                    <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <div class="contact-footer">
                        <p>For further questions, please contact our customer service.</p>
                        <p>&copy; 2025 MeatMap. All Rights Reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts_lp.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJEK PROJEK\Ebook-Traveling\resources\views/terms-conditions.blade.php ENDPATH**/ ?>