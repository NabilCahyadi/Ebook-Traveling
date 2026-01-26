<?php
    $maxRating = 5;
?>

<div class="rating-stars">
    <?php for($i = 1; $i <= $maxRating; $i++): ?>
        <?php if($i <= $rating): ?>
            
            <i class="fas fa-star text-warning"></i>
        <?php else: ?>
            
            <i class="far fa-star text-warning"></i>
        <?php endif; ?>
    <?php endfor; ?>
</div><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\components\ratings\rating-stars.blade.php ENDPATH**/ ?>