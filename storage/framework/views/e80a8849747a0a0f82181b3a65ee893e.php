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
                <div data-i18n="Dashboard"><?php echo e(__('admin.menu.dashboard')); ?></div>
            </a>
        </li>
                <!-- Admin Management (Only for Superadmin) -->
        <?php if(auth('admin')->check() && auth('admin')->user()->type === 'superadmin'): ?>
        <li class="menu-item <?php echo e(Request::is('admin/admins*') || Request::is('admin/admin-activity-logs*') ? 'active open' : ''); ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-user-shield"></i>
                <div data-i18n="Admin Management">Admin Management</div>
            </a>
            <ul class="menu-sub">
                <!-- Admin List -->
                <li class="menu-item <?php echo e(Request::is('admin/admins*') && !Request::is('admin/admin-activity-logs*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.admins.index')); ?>" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-users"></i>
                        <div data-i18n="Admins">Admin List</div>
                    </a>
                </li>
                
                <!-- Admin Activity Logs -->
                <li class="menu-item <?php echo e(Request::is('admin/admin-activity-logs*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.admin-activity-logs.index')); ?>" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-activity"></i>
                        <div data-i18n="Admin Activity Logs">Activity Logs</div>
                    </a>
                </li>
            </ul>
        </li>
        <?php endif; ?>
        <!-- Users Management -->
        <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasAnyPermission(['users.view', 'users.create', 'users.edit', 'users.delete', 'roles.view', 'roles.create', 'roles.edit', 'roles.delete'])): ?>
        <li
            class="menu-item open <?php echo e(Request::is('admin/users*') || Request::is('admin/roles*') || Request::is('admin/role-permissions*') ? 'active' : ''); ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-users"></i>
                <div data-i18n="User Management"><?php echo e(__('admin.menu.user_management')); ?></div>
            </a>
            <ul class="menu-sub">
                <!-- Users -->
                <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission('users.view')): ?>
                <li class="menu-item <?php echo e(Request::is('admin/users*') ? 'active open' : ''); ?>">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-user"></i>
                        <div data-i18n="Users"><?php echo e(__('admin.menu.users')); ?></div>
                    </a>
                    <ul class="menu-sub">
                        <li
                            class="menu-item <?php echo e(Request::is('admin/users') && !Request::get('role') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('admin.users.index', ['role' => 'all'])); ?>" class="menu-link">
                                <i class="menu-icon tf-icons ti ti-users"></i>
                                <div data-i18n="All Users"><?php echo e(__('admin.users.all_users')); ?></div>
                            </a>
                        </li>
                        <?php if(isset($sidebarRoles) && $sidebarRoles->count() > 0): ?>
                            <?php $__currentLoopData = $sidebarRoles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="menu-item <?php echo e(Request::get('role') === $role->slug ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('admin.users.index', ['role' => $role->slug])); ?>"
                                        class="menu-link">
                                        <i class="menu-icon tf-icons ti ti-user-check"></i>
                                        <div data-i18n="<?php echo e($role->name); ?>"><?php echo e($role->name); ?></div>
                                    </a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>

                <!-- Roles -->
                <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasAnyPermission(['roles.view', 'roles.create', 'roles.edit', 'roles.delete'])): ?>
                <li class="menu-item <?php echo e(Request::is('admin/roles*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.roles.index')); ?>" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-shield"></i>
                        <div data-i18n="Roles"><?php echo e(__('admin.menu.roles')); ?></div>
                    </a>
                </li>
                <?php endif; ?>

                <!-- Role Permissions -->
                <!-- <li class="menu-item <?php echo e(Request::is('admin/role-permissions*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.role-permissions.index')); ?>" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-lock-access"></i>
                        <div data-i18n="Role Permissions"><?php echo e(__('admin.menu.role_permissions')); ?></div>
                    </a>
                </li> -->

                <!-- User Activity Logs -->
                <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission('users.view')): ?>
                <li class="menu-item <?php echo e(Request::is('admin/user-activity-logs*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.user-activity-logs.index')); ?>" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-activity"></i>
                        <div data-i18n="Activity Logs"><?php echo e(__('admin.menu.activity_logs')); ?></div>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </li>
        <?php endif; ?>
        <!-- Ebooks Management -->
        <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasAnyPermission(['ebooks.view', 'ebooks.create', 'ebooks.edit', 'ebooks.delete', 'ebooks.approve', 'categories.view', 'categories.create', 'categories.edit', 'categories.delete', 'cities.view', 'cities.create', 'cities.edit', 'cities.delete'])): ?>
        <li
            class="menu-item open <?php echo e(Request::is('admin/ebooks*') || Request::is('admin/categories*') || Request::is('admin/cities*') ? 'active' : ''); ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-books"></i>
                <div data-i18n="Ebook Management"><?php echo e(__('admin.menu.ebook_management')); ?></div>
            </a>
            <ul class="menu-sub">
                <!-- Ebooks -->
                <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission('ebooks.view')): ?>
                <li class="menu-item <?php echo e(Request::is('admin/ebooks*') ? 'active open' : ''); ?>">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-book"></i>
                        <div data-i18n="Ebooks"><?php echo e(__('admin.menu.ebooks')); ?></div>
                    </a>
                    <ul class="menu-sub">
                        <li
                            class="menu-item <?php echo e(Request::is('admin/ebooks') && !Request::is('admin/ebooks/create') && !Request::is('admin/ebooks/pending-approval') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('admin.ebooks.index')); ?>" class="menu-link">
                                <i class="menu-icon tf-icons ti ti-list"></i>
                                <div data-i18n="All Ebooks"><?php echo e(__('admin.ebooks.all_ebooks')); ?></div>
                            </a>
                        </li>
                        <li class="menu-item <?php echo e(Request::is('admin/ebooks/create') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('admin.ebooks.create')); ?>" class="menu-link">
                                <i class="menu-icon tf-icons ti ti-plus"></i>
                                <div data-i18n="Add New"><?php echo e(__('admin.ebooks.add_new')); ?></div>
                            </a>
                        </li>
                        <!-- <li class="menu-item <?php echo e(Request::is('admin/ebooks/pending-approval') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('admin.ebooks.pending-approval')); ?>" class="menu-link">
                                <div data-i18n="Pending Approval">Pending Approval</div>
                                <?php
                                    $pendingCount = \App\Models\Ebook::where('status', 'waiting_approval')->count();
                                ?>
                                <?php if($pendingCount > 0): ?>
                                    <span class="badge bg-warning rounded-pill ms-auto"><?php echo e($pendingCount); ?></span>
                                <?php endif; ?>
                            </a>
                        </li> -->
                    </ul>
                </li>
                <?php endif; ?>

                <!-- Categories -->
                <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasAnyPermission(['categories.view', 'categories.create', 'categories.edit', 'categories.delete'])): ?>
                <li class="menu-item <?php echo e(Request::is('admin/categories*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.categories.index')); ?>" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-tags"></i>
                        <div data-i18n="Categories"><?php echo e(__('admin.menu.categories')); ?></div>
                    </a>
                </li>
                <?php endif; ?>

                <!-- Cities -->
                <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasAnyPermission(['cities.view', 'cities.create', 'cities.edit', 'cities.delete'])): ?>
                <li class="menu-item <?php echo e(Request::is('admin/cities*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.cities.index')); ?>" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-map-pin"></i>
                        <div data-i18n="Cities"><?php echo e(__('admin.menu.cities')); ?></div>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </li>
        <?php endif; ?>

        <!-- Blog Management -->
        <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasAnyPermission(['blogs.view', 'blogs.create', 'blogs.edit', 'blogs.delete', 'blog-categories.view', 'blog-categories.create', 'blog-categories.edit', 'blog-categories.delete'])): ?>
        <li class="menu-item <?php echo e(Request::is('admin/blogs*') || Request::is('admin/blog-categories*') ? 'active open' : ''); ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-news"></i>
                <div data-i18n="Blog Management"><?php echo e(__('admin.menu.blog_management')); ?></div>
            </a>
            <ul class="menu-sub">
                <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission('blogs.view')): ?>
                <li class="menu-item <?php echo e(Request::is('admin/blogs*') && !Request::is('admin/blog-categories*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.blogs.index')); ?>" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-article"></i>
                        <div data-i18n="Blogs"><?php echo e(__('admin.menu.blogs')); ?></div>
                    </a>
                </li>
                <?php endif; ?>

                <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasAnyPermission(['blog-categories.view', 'blog-categories.create', 'blog-categories.edit', 'blog-categories.delete'])): ?>
                <li class="menu-item <?php echo e(Request::is('admin/blog-categories*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.blog-categories.index')); ?>" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-category"></i>
                        <div data-i18n="Blog Categories"><?php echo e(__('admin.menu.blog_categories')); ?></div>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </li>
        <?php endif; ?>
        <!-- Subscription Management -->
        <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasAnyPermission(['subscription-plans.view', 'subscription-plans.create', 'subscription-plans.edit', 'subscription-plans.delete', 'subscriptions.view', 'subscriptions.create', 'subscriptions.edit', 'subscriptions.delete', 'promos.view', 'promos.create', 'promos.edit', 'promos.delete'])): ?>
        <li
            class="menu-item open <?php echo e(Request::is('admin/subscription-plans*') || Request::is('admin/manual-subscriptions*') || Request::is('admin/active-subscribers*') || Request::is('admin/subscription-history*') || Request::is('admin/promos*') ? 'active' : ''); ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-crown"></i>
                <div data-i18n="Subscription Management"><?php echo e(__('admin.menu.subscription_management')); ?></div>
            </a>
            <ul class="menu-sub">
                <!-- Subscription Plans -->
                <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasAnyPermission(['subscription-plans.view', 'subscription-plans.create', 'subscription-plans.edit', 'subscription-plans.delete'])): ?>
                <li class="menu-item <?php echo e(Request::is('admin/subscription-plans*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.subscription-plans.index')); ?>" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-package"></i>
                        <div data-i18n="Subscription Plans"><?php echo e(__('admin.menu.subscription_plans')); ?></div>
                    </a>
                </li>
                <?php endif; ?>

                <!-- Manual Subscriptions -->
                <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission('subscriptions.view')): ?>
                <li class="menu-item <?php echo e(Request::is('admin/manual-subscriptions*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.manual-subscriptions.index')); ?>" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-edit"></i>
                        <div data-i18n="Manual Subscriptions"><?php echo e(__('admin.menu.manual_subscriptions')); ?></div>
                    </a>
                </li>
                <?php endif; ?>

                <!-- Active Subscribers -->
                <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission('subscriptions.view')): ?>
                <li class="menu-item <?php echo e(Request::is('admin/active-subscribers*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.active-subscribers.index')); ?>" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-users-group"></i>
                        <div data-i18n="Active Subscribers"><?php echo e(__('admin.menu.active_subscribers')); ?></div>
                    </a>
                </li>
                <?php endif; ?>

                <!-- Payment History -->
                <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission('subscriptions.view')): ?>
                <li class="menu-item <?php echo e(Request::is('admin/subscription-history*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.subscription-history.index')); ?>" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-receipt"></i>
                        <div data-i18n="Payment History"><?php echo e(__('admin.menu.subscription_history')); ?></div>
                    </a>
                </li>
                <?php endif; ?>

                <!-- Promos -->
                <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasAnyPermission(['promos.view', 'promos.create', 'promos.edit', 'promos.delete'])): ?>
                <li class="menu-item <?php echo e(Request::is('admin/promos*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.promos.index')); ?>" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-ticket"></i>
                        <div data-i18n="Promos"><?php echo e(__('admin.menu.promos_discounts')); ?></div>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </li>
        <?php endif; ?>


        <!-- Website Management -->
        <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasAnyPermission(['website.landing-page', 'website.about-us.view', 'website.about-us.create', 'website.about-us.edit', 'website.about-us.delete', 'website.banners.view', 'website.banners.create', 'website.banners.edit', 'website.banners.delete', 'website.collections.view', 'website.collections.create', 'website.collections.edit', 'website.collections.delete', 'website.contact-info.view', 'website.contact-info.create', 'website.contact-info.edit', 'website.contact-info.delete', 'website.site-settings'])): ?>
        <li
            class="menu-item <?php echo e(Request::is('admin/collection-order*') || Request::is('admin/banners*') || Request::is('admin/collections*') || Request::is('admin/landing-page-content*') || Request::is('admin/about-us*') || Request::is('admin/contact-info*') || Request::is('admin/site-settings*') ? 'active open' : ''); ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-settings"></i>
                <div data-i18n="Website Management"><?php echo e(__('admin.menu.website_setting')); ?></div>
            </a>
            <ul class="menu-sub">
                <!-- Landing Page Content -->
                <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission('website.landing-page')): ?>
                <li class="menu-item <?php echo e(Request::is('admin/landing-page-content*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.landing-page-content.index')); ?>" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-layout"></i>
                        <div data-i18n="Landing Page Content"><?php echo e(__('admin.menu.landing_page_content')); ?></div>
                    </a>
                </li>
                <?php endif; ?>
                <!-- About Us -->
                <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasAnyPermission(['website.about-us.view', 'website.about-us.create', 'website.about-us.edit', 'website.about-us.delete'])): ?>
                <li class="menu-item <?php echo e(Request::is('admin/about-us*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.about-us.index')); ?>" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-info-circle"></i>
                        <div data-i18n="About Us"><?php echo e(__('admin.menu.about_us')); ?></div>
                    </a>
                </li>
                <?php endif; ?>
                <!-- Hero Banners -->
                <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasAnyPermission(['website.banners.view', 'website.banners.create', 'website.banners.edit', 'website.banners.delete'])): ?>
                <li class="menu-item <?php echo e(Request::is('admin/banners*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.banners.index')); ?>" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-photo"></i>
                        <div data-i18n="Hero Banners"><?php echo e(__('admin.menu.hero_banners')); ?></div>
                    </a>
                </li>
                <?php endif; ?>
                <!-- Collection Ebook -->
                <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasAnyPermission(['website.collections.view', 'website.collections.create', 'website.collections.edit', 'website.collections.delete'])): ?>
                <li class="menu-item <?php echo e(Request::is('admin/collections*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.collections.index')); ?>" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-folders"></i>
                        <div data-i18n="Collection Ebook"><?php echo e(__('admin.menu.collection_ebook')); ?></div>
                    </a>
                </li>
                <?php endif; ?>
                <!-- Contact Info -->
                <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasAnyPermission(['website.contact-info.view', 'website.contact-info.create', 'website.contact-info.edit', 'website.contact-info.delete'])): ?>
                <li class="menu-item <?php echo e(Request::is('admin/contact-info*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.contact-info.index')); ?>" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-address-book"></i>
                        <div data-i18n="Contact Info"><?php echo e(__('admin.menu.contact_info')); ?></div>
                    </a>
                </li>
                <?php endif; ?>
                <!-- Site Settings -->
                <?php if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission('website.site-settings')): ?>
                <li class="menu-item <?php echo e(Request::is('admin/site-settings*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.site-settings.index')); ?>" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-adjustments"></i>
                        <div data-i18n="Site Settings"><?php echo e(__('admin.menu.site_settings')); ?></div>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </li>
        <?php endif; ?>
    </ul>
</aside>
<?php /**PATH C:\laragon\www\ebook_traveling\resources\views/layouts/partials/admin/sidebar.blade.php ENDPATH**/ ?>