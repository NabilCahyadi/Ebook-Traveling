<?php $__env->startSection('title', __('admin.notifications.title')); ?>

<?php $__env->startSection('content'); ?>
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1"><?php echo e(__('admin.notifications.title')); ?></h4>
            <p class="text-muted mb-0"><?php echo e(__('admin.notifications.description')); ?></p>
        </div>
        <div>
            <button type="button" class="btn btn-outline-primary" id="markAllRead">
                <i class="ti ti-mail-opened me-1"></i>
                <?php echo e(__('admin.notifications.mark_all_read')); ?>

            </button>
        </div>
    </div>

    <!-- Notifications Card -->
    <div class="card">
        <div class="card-body">
            <?php if($notifications->count() > 0): ?>
                <div class="list-group list-group-flush">
                    <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userNotification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $notification = $userNotification->notification;
                            $iconMap = [
                                'success' => 'ti-check',
                                'info' => 'ti-info-circle',
                                'warning' => 'ti-alert-triangle',
                                'danger' => 'ti-alert-circle',
                                'order' => 'ti-shopping-cart',
                                'user' => 'ti-user',
                                'ebook' => 'ti-book'
                            ];
                            $colorMap = [
                                'success' => 'success',
                                'info' => 'info',
                                'warning' => 'warning',
                                'danger' => 'danger',
                                'order' => 'primary',
                                'user' => 'secondary',
                                'ebook' => 'info'
                            ];
                            $icon = $iconMap[$notification->icon] ?? 'ti-bell';
                            $color = $colorMap[$notification->icon] ?? 'secondary';
                        ?>
                        
                        <div class="list-group-item list-group-item-action <?php echo e(!$userNotification->is_read ? 'bg-label-primary' : ''); ?>" 
                             data-id="<?php echo e($userNotification->id); ?>">
                            <div class="d-flex w-100">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar">
                                        <span class="avatar-initial rounded-circle bg-label-<?php echo e($color); ?>">
                                            <i class="ti <?php echo e($icon); ?>"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="mb-0 <?php echo e(!$userNotification->is_read ? 'fw-bold' : ''); ?>">
                                            <?php echo e($notification->title); ?>

                                        </h6>
                                        <div class="d-flex align-items-center">
                                            <?php if(!$userNotification->is_read): ?>
                                                <span class="badge badge-dot bg-primary me-2"></span>
                                            <?php endif; ?>
                                            <small class="text-muted"><?php echo e($userNotification->created_at->diffForHumans()); ?></small>
                                        </div>
                                    </div>
                                    <p class="mb-2 text-body"><?php echo e($notification->message); ?></p>
                                    <div class="d-flex gap-2">
                                        <?php if($notification->action_url): ?>
                                            <a href="<?php echo e($notification->action_url); ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="ti ti-external-link me-1"></i>
                                                <?php echo e(__('admin.notifications.view_details')); ?>

                                            </a>
                                        <?php endif; ?>
                                        <?php if(!$userNotification->is_read): ?>
                                            <button type="button" class="btn btn-sm btn-outline-secondary mark-as-read" 
                                                    data-id="<?php echo e($userNotification->id); ?>">
                                                <i class="ti ti-check me-1"></i>
                                                <?php echo e(__('admin.notifications.mark_read')); ?>

                                            </button>
                                        <?php endif; ?>
                                        <button type="button" class="btn btn-sm btn-outline-danger delete-notification" 
                                                data-id="<?php echo e($userNotification->id); ?>">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    <?php echo e($notifications->links()); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="ti ti-bell-off" style="font-size: 4rem; color: var(--bs-gray-400);"></i>
                    <h5 class="text-muted mt-3"><?php echo e(__('admin.notifications.no_notifications')); ?></h5>
                    <p class="text-muted"><?php echo e(__('admin.notifications.no_notifications_desc')); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    $(document).ready(function() {
        // Mark single notification as read
        $('.mark-as-read').click(function() {
            const notifId = $(this).data('id');
            const $item = $(this).closest('.list-group-item');
            
            $.ajax({
                url: '/admin/notifications/' + notifId + '/mark-as-read',
                method: 'POST',
                success: function() {
                    $item.removeClass('bg-label-primary');
                    $item.find('.fw-bold').removeClass('fw-bold');
                    $item.find('.badge-dot').remove();
                    $item.find('.mark-as-read').remove();
                    toastr.success('<?php echo e(__('admin.notifications.marked_read')); ?>');
                }
            });
        });

        // Mark all as read
        $('#markAllRead').click(function() {
            $.ajax({
                url: '<?php echo e(route('admin.notifications.mark-all-as-read')); ?>',
                method: 'POST',
                success: function(response) {
                    toastr.success(response.message);
                    location.reload();
                }
            });
        });

        // Delete notification
        $('.delete-notification').click(function() {
            const notifId = $(this).data('id');
            const $item = $(this).closest('.list-group-item');
            
            if (confirm('<?php echo e(__('admin.notifications.confirm_delete')); ?>')) {
                $.ajax({
                    url: '/admin/notifications/' + notifId,
                    method: 'DELETE',
                    success: function(response) {
                        $item.fadeOut(300, function() {
                            $(this).remove();
                            
                            // Check if no notifications left
                            if ($('.list-group-item').length === 0) {
                                location.reload();
                            }
                        });
                        toastr.success(response.message);
                    }
                });
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\admin\notifications\index.blade.php ENDPATH**/ ?>