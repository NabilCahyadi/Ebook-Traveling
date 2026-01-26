<?php echo '<'; ?>?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:news="http://www.google.com/schemas/sitemap-news/0.9"
        xmlns:xhtml="http://www.w3.org/1999/xhtml"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">

    
    <url>
        <loc><?php echo e(url('/')); ?></loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
        <lastmod><?php echo e(now()->toAtomString()); ?></lastmod>
    </url>

    
    <url>
        <loc><?php echo e(route('about')); ?></loc>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>

    
    <url>
        <loc><?php echo e(route('blogs.index')); ?></loc>
        <changefreq>daily</changefreq>
        <priority>0.9</priority>
        <lastmod><?php echo e($blogs->first()?->updated_at?->toAtomString() ?? now()->toAtomString()); ?></lastmod>
    </url>

    
    <?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <url>
        <loc><?php echo e(route('blogs.show', $blog->slug)); ?></loc>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
        <lastmod><?php echo e($blog->updated_at->toAtomString()); ?></lastmod>
        <?php if($blog->featured_image_url): ?>
        <image:image>
            <image:loc><?php echo e($blog->featured_image_url); ?></image:loc>
            <image:title><?php echo e($blog->title); ?></image:title>
        </image:image>
        <?php endif; ?>
    </url>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    
    <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <url>
        <loc><?php echo e(route('city.show', $city->slug)); ?></loc>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    
    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <url>
        <loc><?php echo e(route('category.show', $category->slug)); ?></loc>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    
    <url>
        <loc><?php echo e(route('faq')); ?></loc>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>

    
    <url>
        <loc><?php echo e(route('contact')); ?></loc>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>

    
    <url>
        <loc><?php echo e(route('pricing')); ?></loc>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>

</urlset>
<?php /**PATH C:\laragon\www\ebook_traveling\resources\views\sitemap.blade.php ENDPATH**/ ?>