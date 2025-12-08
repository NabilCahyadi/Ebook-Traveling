 

<?php $__env->startSection('title', $collection->name); ?>

<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginalb4fc95e0b39473d6f95653f690462350 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb4fc95e0b39473d6f95653f690462350 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.collections.show','data' => ['collection' => $collection]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('collections.show'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['collection' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($collection)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb4fc95e0b39473d6f95653f690462350)): ?>
<?php $attributes = $__attributesOriginalb4fc95e0b39473d6f95653f690462350; ?>
<?php unset($__attributesOriginalb4fc95e0b39473d6f95653f690462350); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb4fc95e0b39473d6f95653f690462350)): ?>
<?php $component = $__componentOriginalb4fc95e0b39473d6f95653f690462350; ?>
<?php unset($__componentOriginalb4fc95e0b39473d6f95653f690462350); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts_lp.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJEK PROJEK\Ebook-Traveling\resources\views/collections/show.blade.php ENDPATH**/ ?>