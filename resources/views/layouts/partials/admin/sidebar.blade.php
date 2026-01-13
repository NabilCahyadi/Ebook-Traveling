<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('admin.dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo" style="display: flex; align-items: center;">
                <img src="{{ asset('images/only-logoo.png') }}" alt="MeatMap Logo" style="height: 23px; width: 23px; object-fit: contain;">
            </span>
            <span class="app-brand-text demo menu-text fw-bold ms-2">MeatMap</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-md align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-smart-home"></i>
                <div data-i18n="Dashboard">{{ __('admin.menu.dashboard') }}</div>
            </a>
        </li>



        <!-- Admin Management (Only for Superadmin) -->
        @if(auth('admin')->check() && auth('admin')->user()->type === 'superadmin')
        <li class="menu-item {{ Request::is('admin/admins*') || Request::is('admin/admin-activity-logs*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-user-shield"></i>
                <div data-i18n="Admin Management">Admin Management</div>
            </a>
            <ul class="menu-sub">
                <!-- Admin List -->
                <li class="menu-item {{ Request::is('admin/admins*') && !Request::is('admin/admin-activity-logs*') ? 'active' : '' }}">
                    <a href="{{ route('admin.admins.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-users"></i>
                        <div data-i18n="Admins">Admin List</div>
                    </a>
                </li>
                
                <!-- Admin Activity Logs -->
                <li class="menu-item {{ Request::is('admin/admin-activity-logs*') ? 'active' : '' }}">
                    <a href="{{ route('admin.admin-activity-logs.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-activity"></i>
                        <div data-i18n="Admin Activity Logs">Activity Logs</div>
                    </a>
                </li>
            </ul>
        </li>
        @endif
        <!-- Users Management -->
        @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasAnyPermission(['users.view', 'users.create', 'users.edit', 'users.delete', 'roles.view', 'roles.create', 'roles.edit', 'roles.delete']))
        <li
            class="menu-item open {{ Request::is('admin/users*') || Request::is('admin/roles*') || Request::is('admin/role-permissions*') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-users"></i>
                <div data-i18n="User Management">{{ __('admin.menu.user_management') }}</div>
            </a>
            <ul class="menu-sub">
                <!-- Users -->
                @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission('users.view'))
                <li class="menu-item {{ Request::is('admin/users*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-user"></i>
                        <div data-i18n="Users">{{ __('admin.menu.users') }}</div>
                    </a>
                    <ul class="menu-sub">
                        <li
                            class="menu-item {{ Request::is('admin/users') && !Request::get('role') ? 'active' : '' }}">
                            <a href="{{ route('admin.users.index', ['role' => 'all']) }}" class="menu-link">
                                <i class="menu-icon tf-icons ti ti-users"></i>
                                <div data-i18n="All Users">{{ __('admin.users.all_users') }}</div>
                            </a>
                        </li>
                        @if (isset($sidebarRoles) && $sidebarRoles->count() > 0)
                            @foreach ($sidebarRoles as $role)
                                <li class="menu-item {{ Request::get('role') === $role->slug ? 'active' : '' }}">
                                    <a href="{{ route('admin.users.index', ['role' => $role->slug]) }}"
                                        class="menu-link">
                                        <i class="menu-icon tf-icons ti ti-user-check"></i>
                                        <div data-i18n="{{ $role->name }}">{{ $role->name }}</div>
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </li>
                @endif

                <!-- Roles -->
                @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasAnyPermission(['roles.view', 'roles.create', 'roles.edit', 'roles.delete']))
                <li class="menu-item {{ Request::is('admin/roles*') ? 'active' : '' }}">
                    <a href="{{ route('admin.roles.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-shield"></i>
                        <div data-i18n="Roles">{{ __('admin.menu.roles') }}</div>
                    </a>
                </li>
                @endif

                <!-- Role Permissions -->
                <!-- <li class="menu-item {{ Request::is('admin/role-permissions*') ? 'active' : '' }}">
                    <a href="{{ route('admin.role-permissions.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-lock-access"></i>
                        <div data-i18n="Role Permissions">{{ __('admin.menu.role_permissions') }}</div>
                    </a>
                </li> -->

                <!-- User Activity Logs -->
                @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission('users.view'))
                <li class="menu-item {{ Request::is('admin/user-activity-logs*') ? 'active' : '' }}">
                    <a href="{{ route('admin.user-activity-logs.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-activity"></i>
                        <div data-i18n="Activity Logs">{{ __('admin.menu.activity_logs') }}</div>
                    </a>
                </li>
                @endif
            </ul>
        </li>
        @endif
        <!-- Ebooks Management -->
        @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasAnyPermission(['ebooks.view', 'ebooks.create', 'ebooks.edit', 'ebooks.delete', 'ebooks.approve', 'categories.view', 'categories.create', 'categories.edit', 'categories.delete', 'cities.view', 'cities.create', 'cities.edit', 'cities.delete']))
        <li
            class="menu-item open {{ Request::is('admin/ebooks*') || Request::is('admin/categories*') || Request::is('admin/cities*') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-books"></i>
                <div data-i18n="Ebook Management">{{ __('admin.menu.ebook_management') }}</div>
            </a>
            <ul class="menu-sub">
                <!-- Ebooks -->
                @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission('ebooks.view'))
                <li class="menu-item {{ Request::is('admin/ebooks*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-book"></i>
                        <div data-i18n="Ebooks">{{ __('admin.menu.ebooks') }}</div>
                    </a>
                    <ul class="menu-sub">
                        <li
                            class="menu-item {{ Request::is('admin/ebooks') && !Request::is('admin/ebooks/create') && !Request::is('admin/ebooks/pending-approval') ? 'active' : '' }}">
                            <a href="{{ route('admin.ebooks.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons ti ti-list"></i>
                                <div data-i18n="All Ebooks">{{ __('admin.ebooks.all_ebooks') }}</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::is('admin/ebooks/create') ? 'active' : '' }}">
                            <a href="{{ route('admin.ebooks.create') }}" class="menu-link">
                                <i class="menu-icon tf-icons ti ti-plus"></i>
                                <div data-i18n="Add New">{{ __('admin.ebooks.add_new') }}</div>
                            </a>
                        </li>
                        <!-- <li class="menu-item {{ Request::is('admin/ebooks/pending-approval') ? 'active' : '' }}">
                            <a href="{{ route('admin.ebooks.pending-approval') }}" class="menu-link">
                                <div data-i18n="Pending Approval">Pending Approval</div>
                                @php
                                    $pendingCount = \App\Models\Ebook::where('status', 'waiting_approval')->count();
                                @endphp
                                @if ($pendingCount > 0)
                                    <span class="badge bg-warning rounded-pill ms-auto">{{ $pendingCount }}</span>
                                @endif
                            </a>
                        </li> -->
                    </ul>
                </li>
                @endif

                <!-- Categories -->
                @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasAnyPermission(['categories.view', 'categories.create', 'categories.edit', 'categories.delete']))
                <li class="menu-item {{ Request::is('admin/categories*') ? 'active' : '' }}">
                    <a href="{{ route('admin.categories.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-tags"></i>
                        <div data-i18n="Categories">{{ __('admin.menu.categories') }}</div>
                    </a>
                </li>
                @endif

                <!-- Cities -->
                @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasAnyPermission(['cities.view', 'cities.create', 'cities.edit', 'cities.delete']))
                <li class="menu-item {{ Request::is('admin/cities*') ? 'active' : '' }}">
                    <a href="{{ route('admin.cities.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-map-pin"></i>
                        <div data-i18n="Cities">{{ __('admin.menu.cities') }}</div>
                    </a>
                </li>
                @endif
            </ul>
        </li>
        @endif

        <!-- Blog Management -->
        @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasAnyPermission(['blogs.view', 'blogs.create', 'blogs.edit', 'blogs.delete', 'blog-categories.view', 'blog-categories.create', 'blog-categories.edit', 'blog-categories.delete']))
        <li class="menu-item {{ Request::is('admin/blogs*') || Request::is('admin/blog-categories*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-news"></i>
                <div data-i18n="Blog Management">{{ __('admin.menu.blog_management') }}</div>
            </a>
            <ul class="menu-sub">
                @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission('blogs.view'))
                <li class="menu-item {{ Request::is('admin/blogs*') && !Request::is('admin/blog-categories*') ? 'active' : '' }}">
                    <a href="{{ route('admin.blogs.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-article"></i>
                        <div data-i18n="Blogs">{{ __('admin.menu.blogs') }}</div>
                    </a>
                </li>
                @endif

                @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasAnyPermission(['blog-categories.view', 'blog-categories.create', 'blog-categories.edit', 'blog-categories.delete']))
                <li class="menu-item {{ Request::is('admin/blog-categories*') ? 'active' : '' }}">
                    <a href="{{ route('admin.blog-categories.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-category"></i>
                        <div data-i18n="Blog Categories">{{ __('admin.menu.blog_categories') }}</div>
                    </a>
                </li>
                @endif
            </ul>
        </li>
        @endif
        <!-- Subscription Management -->
        @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasAnyPermission(['subscription-plans.view', 'subscription-plans.create', 'subscription-plans.edit', 'subscription-plans.delete', 'subscriptions.view', 'subscriptions.create', 'subscriptions.edit', 'subscriptions.delete', 'promos.view', 'promos.create', 'promos.edit', 'promos.delete']))
        <li
            class="menu-item open {{ Request::is('admin/subscription-plans*') || Request::is('admin/manual-subscriptions*') || Request::is('admin/active-subscribers*') || Request::is('admin/subscription-history*') || Request::is('admin/promos*') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-crown"></i>
                <div data-i18n="Subscription Management">{{ __('admin.menu.subscription_management') }}</div>
            </a>
            <ul class="menu-sub">
                <!-- Subscription Plans -->
                @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasAnyPermission(['subscription-plans.view', 'subscription-plans.create', 'subscription-plans.edit', 'subscription-plans.delete']))
                <li class="menu-item {{ Request::is('admin/subscription-plans*') ? 'active' : '' }}">
                    <a href="{{ route('admin.subscription-plans.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-package"></i>
                        <div data-i18n="Subscription Plans">{{ __('admin.menu.subscription_plans') }}</div>
                    </a>
                </li>
                @endif

                <!-- Manual Subscriptions -->
                @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission('subscriptions.view'))
                <li class="menu-item {{ Request::is('admin/manual-subscriptions*') ? 'active' : '' }}">
                    <a href="{{ route('admin.manual-subscriptions.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-edit"></i>
                        <div data-i18n="Manual Subscriptions">{{ __('admin.menu.manual_subscriptions') }}</div>
                    </a>
                </li>
                @endif

                <!-- Active Subscribers -->
                @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission('subscriptions.view'))
                <li class="menu-item {{ Request::is('admin/active-subscribers*') ? 'active' : '' }}">
                    <a href="{{ route('admin.active-subscribers.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-users-group"></i>
                        <div data-i18n="Active Subscribers">{{ __('admin.menu.active_subscribers') }}</div>
                    </a>
                </li>
                @endif

                <!-- Payment History -->
                @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission('subscriptions.view'))
                <li class="menu-item {{ Request::is('admin/subscription-history*') ? 'active' : '' }}">
                    <a href="{{ route('admin.subscription-history.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-receipt"></i>
                        <div data-i18n="Payment History">{{ __('admin.menu.subscription_history') }}</div>
                    </a>
                </li>
                @endif

                <!-- Promos -->
                @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasAnyPermission(['promos.view', 'promos.create', 'promos.edit', 'promos.delete']))
                <li class="menu-item {{ Request::is('admin/promos*') ? 'active' : '' }}">
                    <a href="{{ route('admin.promos.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-ticket"></i>
                        <div data-i18n="Promos">{{ __('admin.menu.promos_discounts') }}</div>
                    </a>
                </li>
                @endif
            </ul>
        </li>
        @endif

                <!-- Reports -->
        <li class="menu-item {{ Request::is('admin/reports*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-report-analytics"></i>
                <div data-i18n="Reports">{{ __('admin.menu.reports') }}</div>
            </a>
            <ul class="menu-sub">
                <!-- <li class="menu-item {{ Request::is('admin/reports') && !Request::is('admin/reports/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.reports.index') }}" class="menu-link">
                        <div data-i18n="Overview">{{ __('admin.menu.reports_overview') }}</div>
                    </a>
                </li> -->
                <li class="menu-item {{ Request::is('admin/reports/revenue') ? 'active' : '' }}">
                    <a href="{{ route('admin.reports.revenue') }}" class="menu-link">
                        <div data-i18n="Revenue Report">{{ __('admin.menu.revenue_report') }}</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('admin/reports/ebook-performance') ? 'active' : '' }}">
                    <a href="{{ route('admin.reports.ebook-performance') }}" class="menu-link">
                        <div data-i18n="Ebook Performance">{{ __('admin.menu.ebook_performance') }}</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('admin/reports/user-analytics') ? 'active' : '' }}">
                    <a href="{{ route('admin.reports.user-analytics') }}" class="menu-link">
                        <div data-i18n="User Analytics">{{ __('admin.menu.user_analytics') }}</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('admin/reports/subscription-analytics') ? 'active' : '' }}">
                    <a href="{{ route('admin.reports.subscription-analytics') }}" class="menu-link">
                        <div data-i18n="Subscription Analytics">{{ __('admin.menu.subscription_analytics') }}</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Website Management -->
        @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasAnyPermission(['website.landing-page', 'website.about-us.view', 'website.about-us.create', 'website.about-us.edit', 'website.about-us.delete', 'website.banners.view', 'website.banners.create', 'website.banners.edit', 'website.banners.delete', 'website.collections.view', 'website.collections.create', 'website.collections.edit', 'website.collections.delete', 'website.contact-info.view', 'website.contact-info.create', 'website.contact-info.edit', 'website.contact-info.delete', 'website.site-settings']))
        <li
            class="menu-item {{ Request::is('admin/collection-order*') || Request::is('admin/banners*') || Request::is('admin/collections*') || Request::is('admin/landing-page-content*') || Request::is('admin/about-us*') || Request::is('admin/contact-info*') || Request::is('admin/site-settings*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-settings"></i>
                <div data-i18n="Website Management">{{ __('admin.menu.website_setting') }}</div>
            </a>
            <ul class="menu-sub">
                <!-- Landing Page Content -->
                @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission('website.landing-page'))
                <li class="menu-item {{ Request::is('admin/landing-page-content*') ? 'active' : '' }}">
                    <a href="{{ route('admin.landing-page-content.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-layout"></i>
                        <div data-i18n="Landing Page Content">{{ __('admin.menu.landing_page_content') }}</div>
                    </a>
                </li>
                @endif
                <!-- About Us -->
                @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasAnyPermission(['website.about-us.view', 'website.about-us.create', 'website.about-us.edit', 'website.about-us.delete']))
                <li class="menu-item {{ Request::is('admin/about-us*') ? 'active' : '' }}">
                    <a href="{{ route('admin.about-us.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-info-circle"></i>
                        <div data-i18n="About Us">{{ __('admin.menu.about_us') }}</div>
                    </a>
                </li>
                @endif
                <!-- Hero Banners -->
                @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasAnyPermission(['website.banners.view', 'website.banners.create', 'website.banners.edit', 'website.banners.delete']))
                <li class="menu-item {{ Request::is('admin/banners*') ? 'active' : '' }}">
                    <a href="{{ route('admin.banners.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-photo"></i>
                        <div data-i18n="Hero Banners">{{ __('admin.menu.hero_banners') }}</div>
                    </a>
                </li>
                @endif
                <!-- Collection Ebook -->
                @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasAnyPermission(['website.collections.view', 'website.collections.create', 'website.collections.edit', 'website.collections.delete']))
                <li class="menu-item {{ Request::is('admin/collections*') ? 'active' : '' }}">
                    <a href="{{ route('admin.collections.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-folders"></i>
                        <div data-i18n="Collection Ebook">{{ __('admin.menu.collection_ebook') }}</div>
                    </a>
                </li>
                @endif
                <!-- Contact Info -->
                @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasAnyPermission(['website.contact-info.view', 'website.contact-info.create', 'website.contact-info.edit', 'website.contact-info.delete']))
                <li class="menu-item {{ Request::is('admin/contact-info*') ? 'active' : '' }}">
                    <a href="{{ route('admin.contact-info.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-address-book"></i>
                        <div data-i18n="Contact Info">{{ __('admin.menu.contact_info') }}</div>
                    </a>
                </li>
                @endif
                <!-- Site Settings -->
                @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission('website.site-settings'))
                <li class="menu-item {{ Request::is('admin/site-settings*') ? 'active' : '' }}">
                    <a href="{{ route('admin.site-settings.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-adjustments"></i>
                        <div data-i18n="Site Settings">{{ __('admin.menu.site_settings') }}</div>
                    </a>
                </li>
                @endif
            </ul>
        </li>
        @endif
    </ul>
</aside>
