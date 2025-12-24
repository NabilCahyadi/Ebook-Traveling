<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-xl me-4">
                            <span class="avatar-initial rounded-circle bg-label-light">
                                <?php echo e(substr(auth()->user()->name ?? 'A', 0, 1)); ?>

                            </span>
                        </div>
                        <div>
                            <h4 class="text-white mb-1">Welcome back, <?php echo e(auth()->user()->name ?? 'Admin'); ?>!</h4>
                            <p class="text-white mb-0 opacity-75">Here's what's happening with your ebook store today.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards - Row 1 -->
    <div class="row g-4 mb-4">
        <!-- Total Revenue -->
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="avatar">
                            <div class="avatar-initial bg-label-success rounded">
                                <i class="ti ti-currency-dollar ti-lg"></i>
                            </div>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow"
                                data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical ti-md"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <?php if(Route::has('admin.orders.index')): ?>
                                    <a class="dropdown-item" href="<?php echo e(route('admin.orders.index')); ?>">View Orders</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-info mt-4">
                        <h4 class="mb-1">Rp <?php echo e(number_format($totalRevenue, 0, ',', '.')); ?></h4>
                        <p class="mb-0">Total Revenue</p>
                        <small class="text-success"><i class="ti ti-trending-up"></i> From completed orders</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="avatar">
                            <div class="avatar-initial bg-label-info rounded">
                                <i class="ti ti-shopping-cart ti-lg"></i>
                            </div>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow"
                                data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical ti-md"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <?php if(Route::has('admin.orders.index')): ?>
                                    <a class="dropdown-item" href="<?php echo e(route('admin.orders.index')); ?>">View All Orders</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-info mt-4">
                        <h4 class="mb-1"><?php echo e(number_format($totalOrders)); ?></h4>
                        <p class="mb-0">Total Orders</p>
                        <?php if($pendingOrders > 0): ?>
                            <small class="text-warning"><i class="ti ti-clock"></i> <?php echo e($pendingOrders); ?> pending</small>
                        <?php else: ?>
                            <small class="text-muted">All orders processed</small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Subscribers -->
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="avatar">
                            <div class="avatar-initial bg-label-warning rounded">
                                <i class="ti ti-crown ti-lg"></i>
                            </div>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow"
                                data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical ti-md"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <?php if(Route::has('admin.subscriptions.index')): ?>
                                    <a class="dropdown-item" href="<?php echo e(route('admin.subscriptions.index')); ?>">View
                                        Subscribers</a>
                                <?php elseif(Route::has('admin.active-subscribers.index')): ?>
                                    <a class="dropdown-item" href="<?php echo e(route('admin.active-subscribers.index')); ?>">View
                                        Subscribers</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-info mt-4">
                        <h4 class="mb-1"><?php echo e(number_format($activeSubscribers)); ?></h4>
                        <p class="mb-0">Active Subscribers</p>
                        <small class="text-success"><i class="ti ti-check"></i> Premium members</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="avatar">
                            <div class="avatar-initial bg-label-danger rounded">
                                <i class="ti ti-clock-hour-4 ti-lg"></i>
                            </div>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow"
                                data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical ti-md"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item"
                                    href="<?php echo e(route('admin.orders.index', ['status' => 'pending'])); ?>">View Pending</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-info mt-4">
                        <h4 class="mb-1"><?php echo e(number_format($pendingOrders)); ?></h4>
                        <p class="mb-0">Pending Orders</p>
                        <?php if($pendingOrders > 0): ?>
                            <?php if(Route::has('admin.orders.index')): ?>
                                <a href="<?php echo e(route('admin.orders.index', ['status' => 'pending'])); ?>"
                                    class="text-danger small">Process now →</a>
                            <?php else: ?>
                                <small class="text-danger">Needs attention</small>
                            <?php endif; ?>
                        <?php else: ?>
                            <small class="text-muted">All caught up!</small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards - Row 2 -->
    <div class="row g-4 mb-4">
        <!-- Total Ebooks -->
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="avatar">
                            <div class="avatar-initial bg-label-primary rounded">
                                <i class="ti ti-book ti-lg"></i>
                            </div>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow"
                                data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical ti-md"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="<?php echo e(route('admin.ebooks.index')); ?>">View All</a>
                                <a class="dropdown-item" href="<?php echo e(route('admin.ebooks.create')); ?>">Add New</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-info mt-4">
                        <h4 class="mb-1"><?php echo e(number_format($totalEbooks)); ?></h4>
                        <p class="mb-0">Total Ebooks</p>
                        <a href="<?php echo e(route('admin.ebooks.index')); ?>" class="text-primary small">View all ebooks →</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="avatar">
                            <div class="avatar-initial bg-label-success rounded">
                                <i class="ti ti-users ti-lg"></i>
                            </div>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow"
                                data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical ti-md"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="<?php echo e(route('admin.users.index')); ?>">View All</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-info mt-4">
                        <h4 class="mb-1"><?php echo e(number_format($totalUsers)); ?></h4>
                        <p class="mb-0">Total Users</p>
                        <a href="<?php echo e(route('admin.users.index')); ?>" class="text-success small">View all users →</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Categories -->
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="avatar">
                            <div class="avatar-initial bg-label-info rounded">
                                <i class="ti ti-tags ti-lg"></i>
                            </div>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow"
                                data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical ti-md"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="<?php echo e(route('admin.categories.index')); ?>">View All</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-info mt-4">
                        <h4 class="mb-1"><?php echo e(number_format($totalCategories)); ?></h4>
                        <p class="mb-0">Total Categories</p>
                        <a href="<?php echo e(route('admin.categories.index')); ?>" class="text-info small">Manage categories →</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Cities -->
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="avatar">
                            <div class="avatar-initial bg-label-warning rounded">
                                <i class="ti ti-map-pin ti-lg"></i>
                            </div>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow"
                                data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical ti-md"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="<?php echo e(route('admin.cities.index')); ?>">View All</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-info mt-4">
                        <h4 class="mb-1"><?php echo e(number_format($totalCities)); ?></h4>
                        <p class="mb-0">Total Cities</p>
                        <a href="<?php echo e(route('admin.cities.index')); ?>" class="text-warning small">Manage cities →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <!-- Revenue Chart -->
        <div class="col-xl-8 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-1">Revenue Overview</h5>
                        <p class="card-subtitle mb-0">Monthly revenue for the last 6 months</p>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" style="max-height: 300px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Category Distribution -->
        <div class="col-xl-4 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-1">Ebook by Category</h5>
                    <p class="card-subtitle mb-0">Top 5 categories</p>
                </div>
                <div class="card-body">
                    <canvas id="categoryChart" style="max-height: 300px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Log -->
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Activity</h5>
                    <?php if(Route::has('admin.action-logs.index')): ?>
                        <a href="<?php echo e(route('admin.action-logs.index')); ?>" class="btn btn-sm btn-text-primary">
                            View All
                        </a>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <?php if($recentActivities->count() > 0): ?>
                        <div class="timeline">
                            <?php $__currentLoopData = $recentActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="timeline-item mb-3">
                                    <div class="d-flex align-items-start">
                                        <div class="avatar avatar-sm me-3">
                                            <?php
                                                $actionIcons = [
                                                    'create' => 'ti-plus',
                                                    'update' => 'ti-edit',
                                                    'delete' => 'ti-trash',
                                                    'login' => 'ti-login',
                                                    'logout' => 'ti-logout',
                                                ];
                                                $actionColors = [
                                                    'create' => 'success',
                                                    'update' => 'info',
                                                    'delete' => 'danger',
                                                    'login' => 'primary',
                                                    'logout' => 'secondary',
                                                ];
                                                $icon = $actionIcons[$activity->action] ?? 'ti-activity';
                                                $color = $actionColors[$activity->action] ?? 'secondary';
                                            ?>
                                            <span class="avatar-initial rounded-circle bg-label-<?php echo e($color); ?>">
                                                <i class="ti <?php echo e($icon); ?>"></i>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h6 class="mb-0"><?php echo e($activity->user->name ?? 'System'); ?></h6>
                                                    <p class="mb-0"><?php echo e($activity->description); ?></p>
                                                    <small
                                                        class="text-muted"><?php echo e($activity->created_at->diffForHumans()); ?></small>
                                                </div>
                                                <?php if($activity->model_type && $activity->model_id): ?>
                                                    <span
                                                        class="badge bg-label-secondary"><?php echo e(class_basename($activity->model_type)); ?>

                                                        #<?php echo e($activity->model_id); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="ti ti-activity-off ti-lg text-muted mb-2"></i>
                            <p class="text-muted mb-0">No recent activity</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Ebooks -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Ebooks</h5>
                    <a href="<?php echo e(route('admin.ebooks.index')); ?>" class="btn btn-sm btn-primary">
                        <i class="ti ti-eye me-1"></i> View All
                    </a>
                </div>
                <div class="card-body">
                    <?php if($recentEbooks->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Cover</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>City</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $recentEbooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ebook): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <?php if($ebook->cover_image): ?>
                                                    <img src="<?php echo e(Storage::url($ebook->cover_image)); ?>"
                                                        alt="<?php echo e($ebook->title); ?>" class="rounded"
                                                        style="width: 40px; height: 56px; object-fit: cover;">
                                                <?php else: ?>
                                                    <div class="bg-label-secondary rounded d-flex align-items-center justify-content-center"
                                                        style="width: 40px; height: 56px;">
                                                        <i class="ti ti-book"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="fw-medium"><?php echo e(Str::limit($ebook->title, 40)); ?></div>
                                            </td>
                                            <td>
                                                <?php if($ebook->category): ?>
                                                    <span class="badge bg-label-info"><?php echo e($ebook->category->name); ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($ebook->city): ?>
                                                    <span class="badge bg-label-secondary"><?php echo e($ebook->city->name); ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($ebook->is_active): ?>
                                                    <span class="badge bg-label-success">Active</span>
                                                <?php else: ?>
                                                    <span class="badge bg-label-danger">Inactive</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <small
                                                    class="text-muted"><?php echo e($ebook->created_at->diffForHumans()); ?></small>
                                            </td>
                                            <td>
                                                <a href="<?php echo e(route('admin.ebooks.edit', $ebook->id)); ?>"
                                                    class="btn btn-sm btn-icon btn-text-secondary rounded-pill">
                                                    <i class="ti ti-pencil"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="ti ti-book-off ti-xl text-muted mb-3 d-block" style="font-size: 3rem;"></i>
                            <h6 class="text-muted">No ebooks yet</h6>
                            <p class="text-muted mb-3">Start by creating your first ebook</p>
                            <a href="<?php echo e(route('admin.ebooks.create')); ?>" class="btn btn-primary">
                                <i class="ti ti-plus me-1"></i> Add New Ebook
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Revenue Chart
            const revenueCtx = document.getElementById('revenueChart');
            if (revenueCtx) {
                const revenueData = <?php echo json_encode($monthlyRevenue, 15, 512) ?>;
                new Chart(revenueCtx, {
                    type: 'line',
                    data: {
                        labels: revenueData.map(item => item.month),
                        datasets: [{
                            label: 'Revenue (Rp)',
                            data: revenueData.map(item => item.revenue),
                            borderColor: 'rgb(75, 192, 192)',
                            backgroundColor: 'rgba(75, 192, 192, 0.1)',
                            tension: 0.4,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return 'Revenue: Rp ' + context.parsed.y.toLocaleString(
                                        'id-ID');
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return 'Rp ' + (value / 1000000).toFixed(1) + 'M';
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Category Chart
            const categoryCtx = document.getElementById('categoryChart');
            if (categoryCtx) {
                const categoryData = <?php echo json_encode($categoryStats, 15, 512) ?>;
                console.log('Category Data:', categoryData);

                if (categoryData && categoryData.length > 0) {
                    new Chart(categoryCtx, {
                        type: 'doughnut',
                        data: {
                            labels: categoryData.map(item => item.name),
                            datasets: [{
                                data: categoryData.map(item => item.ebooks_count),
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.8)',
                                    'rgba(54, 162, 235, 0.8)',
                                    'rgba(255, 206, 86, 0.8)',
                                    'rgba(75, 192, 192, 0.8)',
                                    'rgba(153, 102, 255, 0.8)'
                                ],
                                borderWidth: 2,
                                borderColor: '#fff'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return context.label + ': ' + context.parsed + ' ebooks';
                                        }
                                    }
                                }
                            }
                        }
                    });
                } else {
                    categoryCtx.parentElement.innerHTML =
                        '<div class=\"text-center py-5\"><p class=\"text-muted\">No category data available</p></div>';
                }
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJEK PROJEK\Ebook-Traveling\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>