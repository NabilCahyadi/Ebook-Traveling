<?php $__env->startSection('title', __('admin.reports.subscription_analytics')); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mb-2">
                        <li class="breadcrumb-item">
                            <a href="<?php echo e(route('admin.reports.index')); ?>"><?php echo e(__('admin.reports.title')); ?></a>
                        </li>
                        <li class="breadcrumb-item active"><?php echo e(__('admin.reports.subscription_analytics')); ?></li>
                    </ol>
                </nav>
                <h4 class="mb-1"><?php echo e(__('admin.reports.subscription_analytics')); ?></h4>
                <p class="text-muted mb-0"><?php echo e(__('admin.reports.subscription_analytics_subtitle')); ?></p>
            </div>
        </div>

        <!-- Key Metrics -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="text-primary mb-2"><?php echo e(number_format($subscriptionRate, 1)); ?>%</h3>
                        <p class="text-muted mb-0"><?php echo e(__('admin.reports.subscription_rate')); ?></p>
                        <small class="text-muted"><?php echo e($activeSubscribers); ?> / <?php echo e($totalUsers); ?> users</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="text-success mb-2"><?php echo e(number_format($activeSubscribers)); ?></h3>
                        <p class="text-muted mb-0"><?php echo e(__('admin.reports.active_subscribers')); ?></p>
                        <small class="text-muted">&nbsp;</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="text-info mb-2">Rp <?php echo e(number_format($mrr, 0, ',', '.')); ?></h3>
                        <p class="text-muted mb-0"><?php echo e(__('admin.reports.mrr')); ?></p>
                        <small class="text-muted"><?php echo e(__('admin.reports.monthly_recurring_revenue')); ?></small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="text-warning mb-2"><?php echo e(number_format($churnRate, 1)); ?>%</h3>
                        <p class="text-muted mb-0"><?php echo e(__('admin.reports.churn_rate')); ?></p>
                        <small class="text-muted">+<?php echo e($newSubscribersThisMonth); ?> <?php echo e(__('admin.reports.new_this_month')); ?></small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subscription Trend -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><?php echo e(__('admin.reports.subscription_trend')); ?></h5>
            </div>
            <div class="card-body">
                <canvas id="subscriptionTrendChart" height="80"></canvas>
            </div>
        </div>

        <!-- Peak Hours & Subscription Status -->
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0"><?php echo e(__('admin.reports.peak_subscription_hours')); ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th><?php echo e(__('admin.reports.hour')); ?></th>
                                        <th><?php echo e(__('admin.reports.subscriptions')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $peakHours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $peak): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><strong><?php echo e($peak->hour); ?>:00 - <?php echo e($peak->hour + 1); ?>:00</strong></td>
                                            <td><?php echo e($peak->count); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="2" class="text-center text-muted">
                                                <?php echo e(__('admin.reports.no_data')); ?>

                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0"><?php echo e(__('admin.reports.subscription_status')); ?></h5>
                    </div>
                    <div class="card-body">
                        <canvas id="subscriptionStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        const locale = '<?php echo e(app()->getLocale()); ?>';
        const isIndonesian = locale === 'id';

        // Subscription Trend Chart
        const subscriptionTrendCtx = document.getElementById('subscriptionTrendChart').getContext('2d');
        const subscriptionTrendChart = new Chart(subscriptionTrendCtx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($subscriptionTrend->pluck('date')->map(fn($date) => \Carbon\Carbon::parse($date)->format('d M'))); ?>,
                datasets: [{
                    label: isIndonesian ? 'Subscription Baru' : 'New Subscriptions',
                    data: <?php echo json_encode($subscriptionTrend->pluck('count')); ?>,
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Subscription Status Chart
        const subscriptionStatusCtx = document.getElementById('subscriptionStatusChart').getContext('2d');
        const subscriptionStatusChart = new Chart(subscriptionStatusCtx, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($subscriptionsByStatus->pluck('status')->map(fn($s) => ucfirst($s))); ?>,
                datasets: [{
                    data: <?php echo json_encode($subscriptionsByStatus->pluck('count')); ?>,
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.8)',   // active - green
                        'rgba(255, 206, 86, 0.8)',   // pending - yellow
                        'rgba(255, 99, 132, 0.8)',   // expired - red
                        'rgba(153, 102, 255, 0.8)',  // cancelled - purple
                        'rgba(54, 162, 235, 0.8)'    // other - blue
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\admin\reports\subscription-analytics.blade.php ENDPATH**/ ?>