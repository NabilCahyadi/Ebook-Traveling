<section class="section-padding pb-5">
    <div class="container mb-30">
        <div class="section-title style-2 flex-container-custom">
            <div class="title">
                <h3>Latest Blog</h3>
            </div>
            <a href="<?php echo e(route('blogs.index')); ?>" class="show-all">View All</a>
        </div>
        <div class="loop-grid">
            <div class="row">
                <?php $__empty_1 = true; $__currentLoopData = $latestBlogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <article class="col-xl-3 col-lg-4 col-md-6 text-center hover-up mb-30 animated">
                        <div class="post-thumb">
                            <a href="<?php echo e(route('blogs.show', $blog->slug)); ?>">
                                <img class="border-radius-15"
                                    src="<?php echo e($blog->featured_image ?: asset('images/blog-placeholder.webp')); ?>"
                                    alt="<?php echo e($blog->title); ?>" />
                            </a>
                        </div>
                        <div class="entry-content-2">
                            <h6 class="mb-10 font-sm"><a class="entry-meta text-muted"
                                    href="#"><?php echo e($blog->category); ?></a></h6>
                            <h4 class="post-title mb-15">
                                <a href="<?php echo e(route('blogs.show', $blog->slug)); ?>"><?php echo e(Str::limit($blog->title, 60)); ?></a>
                            </h4>
                            <div class="entry-meta font-xs color-grey mt-10 pb-10">
                                <div>
                                    <span
                                        class="post-on mr-10"><?php echo e(\Carbon\Carbon::parse($blog->published_at)->diffInHours() < 24 ? $blog->published_at->diffForHumans() : $blog->published_at->format('d M Y')); ?></span>
                                    <span class="post-on has-dot">
                                        <?php
                                            $views = $blog->view_count;
                                            if ($views >= 1000000000) {
                                                $formattedViews = number_format($views / 1000000000, 1) . 'B';
                                            } elseif ($views >= 1000000) {
                                                $formattedViews = number_format($views / 1000000, 1) . 'M';
                                            } elseif ($views >= 1000) {
                                                $formattedViews = number_format($views / 1000, 1) . 'k';
                                            } else {
                                                $formattedViews = $views;
                                            }
                                        ?>
                                        <?php echo e($formattedViews); ?> Views
                                    </span>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">No blog posts available yet.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php /**PATH C:\laragon\www\ebook_traveling\resources\views/components/landing/latest-blogs.blade.php ENDPATH**/ ?>