<?php $__env->startSection('title', __('admin.reports.user_analytics')); ?>

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
                        <li class="breadcrumb-item active"><?php echo e(__('admin.reports.user_analytics')); ?></li>
                    </ol>
                </nav>
                <h4 class="mb-1"><?php echo e(__('admin.reports.user_analytics')); ?></h4>
                <p class="text-muted mb-0">User growth and activity analysis</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="<?php echo e(route('admin.reports.user-analytics')); ?>" class="row g-3">
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
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="ti ti-filter me-1"></i> <?php echo e(__('admin.reports.apply_filter')); ?>

                        </button>
                        <a href="<?php echo e(route('admin.reports.user-analytics')); ?>" class="btn btn-outline-secondary">
                            <?php echo e(__('admin.reports.reset')); ?>

                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="text-primary mb-2"><?php echo e(number_format($totalUsers)); ?></h3>
                        <p class="text-muted mb-0">Total Users</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="text-success mb-2"><?php echo e(number_format($activeUsers)); ?></h3>
                        <p class="text-muted mb-0">Active Users</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="text-warning mb-2"><?php echo e(number_format($inactiveUsers)); ?></h3>
                        <p class="text-muted mb-0">Inactive Users</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="text-info mb-2"><?php echo e(number_format($premiumUsers)); ?></h3>
                        <p class="text-muted mb-0">Premium Users</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Growth Chart -->
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <h5 class="card-title mb-0">User Growth</h5>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <input type="number" id="userPeriod" class="form-control form-control-sm" style="width: 80px;" value="6" min="1" max="30" placeholder="6">
                        <div class="btn-group" role="group">
                            <input type="radio" class="btn-check" name="userFilter" id="userFilterDay" value="day" autocomplete="off">
                            <label class="btn btn-sm btn-outline-primary" for="userFilterDay">Hari</label>

                            <input type="radio" class="btn-check" name="userFilter" id="userFilterMonth" value="month" autocomplete="off" checked>
                            <label class="btn btn-sm btn-outline-primary" for="userFilterMonth">Bulan</label>

                            <input type="radio" class="btn-check" name="userFilter" id="userFilterYear" value="year" autocomplete="off">
                            <label class="btn btn-sm btn-outline-primary" for="userFilterYear">Tahun</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <canvas id="userGrowthChart" height="80"></canvas>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Recent Users</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Registered</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $recentUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><strong><?php echo e($user->name); ?></strong></td>
                                    <td><?php echo e($user->email); ?></td>
                                    <td>
                                        <span class="badge bg-label-primary"><?php echo e(ucfirst($user->user_type ?? 'user')); ?></span>
                                    </td>
                                    <td>
                                        <?php if($user->subscriptions->where('status', 'active')->count() > 0): ?>
                                            <span class="badge bg-label-success">Premium</span>
                                        <?php else: ?>
                                            <span class="badge bg-label-secondary">Free</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($user->created_at->format('d M Y')); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        // User Growth Chart
        const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
        let userGrowthChart = new Chart(userGrowthCtx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($userGrowth->pluck('date')->map(fn($date) => \Carbon\Carbon::parse($date)->format('d M'))); ?>,
                datasets: [{
                    label: 'New Users',
                    data: <?php echo json_encode($userGrowth->pluck('count')); ?>,
                    borderColor: 'rgb(75, 85, 192)',
                    backgroundColor: 'rgba(75, 85, 192, 0.1)',
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
                            precision: 0
                        }
                    }
                }
            }
        });

        // Filter Handler
        const userFilterInputs = document.querySelectorAll('input[name="userFilter"]');
        const userPeriodInput = document.getElementById('userPeriod');

        userFilterInputs.forEach(input => {
            input.addEventListener('change', updateUserChart);
        });

        userPeriodInput.addEventListener('change', updateUserChart);

        function updateUserChart() {
            const filter = document.querySelector('input[name="userFilter"]:checked').value;
            const count = userPeriodInput.value || 6;

            fetch(`/admin/reports/user-analytics-data?filter=${filter}&count=${count}`)
                .then(response => response.json())
                .then(data => {
                    userGrowthChart.data.labels = data.labels;
                    userGrowthChart.data.datasets[0].data = data.data;
                    userGrowthChart.update();
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\admin\reports\user-analytics.blade.php ENDPATH**/ ?>