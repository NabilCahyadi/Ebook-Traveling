<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="app-brand-link">
            <span class="app-brand-logo demo">
                <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z"
                        fill="#7367F0" />
                    <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd"
                        d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z" fill="#161616" />
                    <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd"
                        d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z" fill="#161616" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z"
                        fill="#7367F0" />
                </svg>
            </span>
            <span class="app-brand-text demo menu-text fw-bold ms-2"><?php echo e(config('app.name')); ?></span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-md align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item <?php echo e(Request::is('admin/dashboard') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="menu-link">
                <i class="menu-icon tf-icons ti ti-smart-home"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>

        <!-- Ebooks Management -->
        <li
            class="menu-item open <?php echo e(Request::is('admin/ebooks*') || Request::is('admin/categories*') || Request::is('admin/cities*') ? 'active' : ''); ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-books"></i>
                <div data-i18n="Ebook Management">Ebook Management</div>
            </a>
            <ul class="menu-sub">
                <!-- Ebooks -->
                <li class="menu-item <?php echo e(Request::is('admin/ebooks*') ? 'active open' : ''); ?>">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-book"></i>
                        <div data-i18n="Ebooks">Ebooks</div>
                    </a>
                    <ul class="menu-sub">
                        <li
                            class="menu-item <?php echo e(Request::is('admin/ebooks') && !Request::is('admin/ebooks/create') && !Request::is('admin/ebooks/pending-approval') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('admin.ebooks.index')); ?>" class="menu-link">
                                <div data-i18n="All Ebooks">All Ebooks</div>
                            </a>
                        </li>
                        <li class="menu-item <?php echo e(Request::is('admin/ebooks/create') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('admin.ebooks.create')); ?>" class="menu-link">
                                <div data-i18n="Add New">Add New</div>
                            </a>
                        </li>
                        <li class="menu-item <?php echo e(Request::is('admin/ebooks/pending-approval') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('admin.ebooks.pending-approval')); ?>" class="menu-link">
                                <div data-i18n="Pending Approval">Pending Approval</div>
                                <?php
                                    $pendingCount = \App\Models\Ebook::where('status', 'waiting_approval')->count();
                                ?>
                                <?php if($pendingCount > 0): ?>
                                    <span class="badge bg-warning rounded-pill ms-auto"><?php echo e($pendingCount); ?></span>
                                <?php endif; ?>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Categories -->
                <li class="menu-item <?php echo e(Request::is('admin/categories*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.categories.index')); ?>" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-tags"></i>
                        <div data-i18n="Categories">Categories</div>
                    </a>
                </li>

                <!-- Cities -->
                <li class="menu-item <?php echo e(Request::is('admin/cities*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.cities.index')); ?>" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-map-pin"></i>
                        <div data-i18n="Cities">Cities</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Users Management -->
        <li
            class="menu-item open <?php echo e(Request::is('admin/users*') || Request::is('admin/roles*') || Request::is('admin/permissions*') ? 'active' : ''); ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-users"></i>
                <div data-i18n="User Management">User Management</div>
            </a>
            <ul class="menu-sub">
                <!-- Users -->
                <li class="menu-item <?php echo e(Request::is('admin/users*') ? 'active open' : ''); ?>">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-user"></i>
                        <div data-i18n="Users">Users</div>
                    </a>
                    <ul class="menu-sub">
                        <li
                            class="menu-item <?php echo e(Request::is('admin/users') && !Request::get('role') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('admin.users.index')); ?>" class="menu-link">
                                <div data-i18n="All Users">All Users</div>
                            </a>
                        </li>
                        <?php if(isset($sidebarRoles) && $sidebarRoles->count() > 0): ?>
                            <?php $__currentLoopData = $sidebarRoles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="menu-item <?php echo e(Request::get('role') === $role->slug ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('admin.users.index', ['role' => $role->slug])); ?>"
                                        class="menu-link">
                                        <div data-i18n="<?php echo e($role->name); ?>"><?php echo e($role->name); ?></div>
                                    </a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </ul>
                </li>

                <!-- Roles -->
                <li class="menu-item <?php echo e(Request::is('admin/roles*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.roles.index')); ?>" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-shield"></i>
                        <div data-i18n="Roles">Roles</div>
                    </a>
                </li>

                <!-- Permissions -->
                <li class="menu-item <?php echo e(Request::is('admin/permissions*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.permissions.index')); ?>" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-lock"></i>
                        <div data-i18n="Permissions">Permissions</div>
                    </a>
                </li>

                <!-- User Activity Logs -->
                <li class="menu-item <?php echo e(Request::is('admin/user-activity-logs*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.user-activity-logs.index')); ?>" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-activity"></i>
                        <div data-i18n="Activity Logs">Activity Logs</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Subscription Management -->
        <li
            class="menu-item open <?php echo e(Request::is('admin/subscription-plans*') || Request::is('admin/manual-subscriptions*') || Request::is('admin/active-subscribers*') || Request::is('admin/subscription-history*') || Request::is('admin/promos*') ? 'active' : ''); ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-crown"></i>
                <div data-i18n="Subscription Management">Subscription Management</div>
            </a>
            <ul class="menu-sub">
                <!-- Subscription Plans -->
                <li class="menu-item <?php echo e(Request::is('admin/subscription-plans*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.subscription-plans.index')); ?>" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-crown"></i>
                        <div data-i18n="Subscription Plans">Subscription Plans</div>
                    </a>
                </li>

                <!-- Manual Subscriptions -->
                <li class="menu-item <?php echo e(Request::is('admin/manual-subscriptions*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.manual-subscriptions.index')); ?>" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-clipboard-check"></i>
                        <div data-i18n="Manual Subscriptions">Manual Subscriptions</div>
                    </a>
                </li>

                <!-- Active Subscribers -->
                <li class="menu-item <?php echo e(Request::is('admin/active-subscribers*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.active-subscribers.index')); ?>" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-users-group"></i>
                        <div data-i18n="Active Subscribers">Active Subscribers</div>
                    </a>
                </li>

                <!-- Payment History -->
                <li class="menu-item <?php echo e(Request::is('admin/subscription-history*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.subscription-history.index')); ?>" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-history"></i>
                        <div data-i18n="Payment History">Payment History</div>
                    </a>
                </li>

                <!-- Promos -->
                <li class="menu-item <?php echo e(Request::is('admin/promos*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.promos.index')); ?>" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-discount-2"></i>
                        <div data-i18n="Promos">Promos & Discounts</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Content Management -->
        <li
            class="menu-item open <?php echo e(Request::is('admin/blogs*') || Request::is('admin/blog-categories*') ? 'active' : ''); ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-file-text"></i>
                <div data-i18n="Content Management">Content Management</div>
            </a>
            <ul class="menu-sub">
                <!-- Blogs -->
                <li
                    class="menu-item <?php echo e(Request::is('admin/blogs*') && !Request::is('admin/blog-categories*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.blogs.index')); ?>" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-article"></i>
                        <div data-i18n="Blogs">Blogs</div>
                    </a>
                </li>

                <!-- Blog Categories -->
                <li class="menu-item <?php echo e(Request::is('admin/blog-categories*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.blog-categories.index')); ?>" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-category"></i>
                        <div data-i18n="Blog Categories">Blog Categories</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Website Management -->
        <li
            class="menu-item open <?php echo e(Request::is('admin/collection-order*') || Request::is('admin/landing-sections*') ? 'active' : ''); ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-world"></i>
                <div data-i18n="Website Management">Website Management</div>
            </a>
            <ul class="menu-sub">
                <!-- Landing Page Sections -->
                <li class="menu-item <?php echo e(Request::is('admin/landing-sections*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.landing-sections')); ?>" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-layout-grid"></i>
                        <div data-i18n="Landing Page Sections">Landing Page Sections</div>
                    </a>
                </li>
                <!-- Collection Order -->
                <li class="menu-item <?php echo e(Request::is('admin/collection-order*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.collection-order')); ?>" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-arrows-sort"></i>
                        <div data-i18n="Collection Order">Collection Order</div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>
<?php /**PATH C:\laragon\www\ebook_traveling\resources\views/layouts/partials/admin/sidebar.blade.php ENDPATH**/ ?>