<?php $__env->startSection('title', __('admin.reports.revenue_report')); ?>

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
                        <li class="breadcrumb-item active"><?php echo e(__('admin.reports.revenue_report')); ?></li>
                    </ol>
                </nav>
                <h4 class="mb-1"><?php echo e(__('admin.reports.revenue_report')); ?></h4>
                <p class="text-muted mb-0"><?php echo e(__('admin.reports.revenue_report_subtitle')); ?></p>
            </div>
        </div>

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="<?php echo e(route('admin.reports.revenue')); ?>" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label"><?php echo e(__('admin.reports.filter_type')); ?></label>
                        <select name="filter" class="form-select" onchange="this.form.submit()">
                            <option value="day" <?php echo e($filter === 'day' ? 'selected' : ''); ?>><?php echo e(__('admin.reports.daily')); ?></option>
                            <option value="week" <?php echo e($filter === 'week' ? 'selected' : ''); ?>><?php echo e(__('admin.reports.weekly')); ?></option>
                            <option value="month" <?php echo e($filter === 'month' ? 'selected' : ''); ?>><?php echo e(__('admin.reports.monthly')); ?></option>
                            <option value="year" <?php echo e($filter === 'year' ? 'selected' : ''); ?>><?php echo e(__('admin.reports.yearly')); ?></option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"><?php echo e(__('admin.reports.start_date')); ?></label>
                        <input type="date" name="start_date" class="form-control" value="<?php echo e(request('start_date')); ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"><?php echo e(__('admin.reports.end_date')); ?></label>
                        <input type="date" name="end_date" class="form-control" value="<?php echo e(request('end_date')); ?>">
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2 mt-2">
                            <i class="ti ti-filter me-1"></i> <?php echo e(__('admin.reports.apply_filter')); ?>

                        </button>
                        <a href="<?php echo e(route('admin.reports.revenue')); ?>" class="btn btn-outline-secondary">
                            <?php echo e(__('admin.reports.reset')); ?>

                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Total Revenue Card -->
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center">
                        <h2 class="text-primary mb-2">Rp <?php echo e(number_format($totalRevenue, 0, ',', '.')); ?></h2>
                        <p class="text-muted mb-0"><?php echo e(__('admin.reports.total_revenue')); ?></p>
                        <small class="text-muted">
                            <?php echo e($start->format('d M Y')); ?> - <?php echo e($end->format('d M Y')); ?>

                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue Trend Chart -->
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><?php echo e(__('admin.reports.revenue_trend')); ?></h5>
                    </div>
                    <div class="card-body">
                        <canvas id="revenueTrendChart" height="80"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue by Subscription Plan & Payment Method -->
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">Pendapatan per Subscription Plan</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="revenueByPlanChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">Pendapatan per Metode Pembayaran</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="revenueByPaymentMethodChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Methods -->
        <div class="row g-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><?php echo e(__('admin.reports.payment_methods')); ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th><?php echo e(__('admin.reports.payment_method')); ?></th>
                                        <th><?php echo e(__('admin.reports.transactions')); ?></th>
                                        <th><?php echo e(__('admin.reports.total_amount')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $paymentMethodsTable; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><strong><?php echo e($method->payment_method ?? 'N/A'); ?></strong></td>
                                            <td><?php echo e($method->count); ?></td>
                                            <td>Rp <?php echo e(number_format($method->total, 0, ',', '.')); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">
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
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        const locale = '<?php echo e(app()->getLocale()); ?>';
        const isIndonesian = locale === 'id';

        // Revenue Trend Chart
        const revenueTrendCtx = document.getElementById('revenueTrendChart').getContext('2d');
        const revenueTrendChart = new Chart(revenueTrendCtx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($revenueByDate->pluck('date')->map(fn($date) => \Carbon\Carbon::parse($date)->format('d M'))); ?>,
                datasets: [{
                    label: '<?php echo e(__("admin.reports.revenue")); ?>',
                    data: <?php echo json_encode($revenueByDate->pluck('total')); ?>,
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
                            callback: function(value) {
                                if (value >= 1000000) {
                                    return 'Rp ' + (value / 1000000).toFixed(1) + (isIndonesian ? ' Jt' : 'M');
                                }
                                return 'Rp ' + (value / 1000).toFixed(0) + 'K';
                            }
                        }
                    }
                }
            }
        });

        // Revenue by Subscription Plan Chart
        const planCtx = document.getElementById('revenueByPlanChart').getContext('2d');
        const planChart = new Chart(planCtx, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($revenueByPlan->pluck('name')); ?>,
                datasets: [{
                    data: <?php echo json_encode($revenueByPlan->pluck('total')); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                        'rgba(255, 159, 64, 0.8)',
                        'rgba(99, 255, 132, 0.8)',
                        'rgba(235, 54, 162, 0.8)',
                        'rgba(86, 255, 206, 0.8)',
                        'rgba(192, 75, 192, 0.8)'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += 'Rp ' + context.parsed.toLocaleString('id-ID');
                                return label;
                            }
                        }
                    }
                }
            }
        });

        // Revenue by Payment Method Chart
        const paymentMethodCtx = document.getElementById('revenueByPaymentMethodChart').getContext('2d');
        const paymentMethodChart = new Chart(paymentMethodCtx, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($revenueByPaymentMethod->pluck('payment_method')); ?>,
                datasets: [{
                    data: <?php echo json_encode($revenueByPaymentMethod->pluck('total')); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                        'rgba(255, 159, 64, 0.8)',
                        'rgba(99, 255, 132, 0.8)',
                        'rgba(235, 54, 162, 0.8)',
                        'rgba(86, 255, 206, 0.8)',
                        'rgba(192, 75, 192, 0.8)'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += 'Rp ' + context.parsed.toLocaleString('id-ID');
                                return label;
                            }
                        }
                    }
                }
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\admin\reports\revenue.blade.php ENDPATH**/ ?>