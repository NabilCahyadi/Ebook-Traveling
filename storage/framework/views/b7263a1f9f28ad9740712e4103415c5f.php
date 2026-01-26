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
            <div class="w-full lg:max-w-4xl xl:max-w-3xl">
                <div class="policy-content bg-white shadow-2xl rounded-2xl p-6 sm:p-10 md:p-12 space-y-6">

                    <!-- JUDUL UTAMA -->
                    <h1 class="policy-title text-4xl sm:text-5xl font-extrabold text-indigo-700 mb-3 leading-tight">
                        Shopping Policy
                    </h1>
                    <div class="last-updated text-sm text-gray-500 border-b border-indigo-100 pb-4 mb-6">
                        Last updated : November 25, 2025
                    </div>

                    <p class="paragraph text-gray-600 text-lg leading-relaxed">
                        This Shopping Policy explains the purchase process, delivery, and related policies for digital products (ebooks and guides) on the MeatMap platform. By making a purchase, you agree to the terms listed below.
                    </p>

                    <!-- KONTEN DINAMIS (sama seperti help-center) -->
                    <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sectionTitle => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <h2 class="section-title text-3xl font-bold text-gray-800 pt-8 border-t border-gray-100 mt-8">
                        <?php echo e($sectionTitle); ?>

                    </h2>

                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($item->subsection_title): ?>
                    <h3 class="subsection-title text-xl font-semibold text-gray-700 mt-6 mb-3">
                        <?php echo e($item->subsection_title); ?>

                    </h3>
                    <?php endif; ?>

                    <?php if(str_contains($item->content, "\n")): ?>
                    <ul class="policy-list space-y-2 pl-6 text-gray-700">
                        <?php $__currentLoopData = explode("\n", trim($item->content)); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(trim($line)): ?>
                        <li><?php echo preg_replace('/^([^:]*):\s*/', '<strong>$1:</strong> ', e($line)); ?></li>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <?php else: ?>
                    <p class="paragraph text-gray-600 leading-relaxed"><?php echo e($item->content); ?></p>
                    <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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
<?php echo $__env->make('layouts_lp.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\shopping-policy.blade.php ENDPATH**/ ?>