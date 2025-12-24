<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('admin.dashboard') }}" class="app-brand-link">
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
            <span class="app-brand-text demo menu-text fw-bold ms-2">{{ config('app.name') }}</span>
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

        <!-- Ebooks Management -->
        <li
            class="menu-item open {{ Request::is('admin/ebooks*') || Request::is('admin/categories*') || Request::is('admin/cities*') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-books"></i>
                <div data-i18n="Ebook Management">{{ __('admin.menu.ebook_management') }}</div>
            </a>
            <ul class="menu-sub">
                <!-- Ebooks -->
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

                <!-- Categories -->
                <li class="menu-item {{ Request::is('admin/categories*') ? 'active' : '' }}">
                    <a href="{{ route('admin.categories.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-tags"></i>
                        <div data-i18n="Categories">{{ __('admin.menu.categories') }}</div>
                    </a>
                </li>

                <!-- Cities -->
                <li class="menu-item {{ Request::is('admin/cities*') ? 'active' : '' }}">
                    <a href="{{ route('admin.cities.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-map-pin"></i>
                        <div data-i18n="Cities">{{ __('admin.menu.cities') }}</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Users Management -->
        <li
            class="menu-item open {{ Request::is('admin/users*') || Request::is('admin/roles*') || Request::is('admin/role-permissions*') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-users"></i>
                <div data-i18n="User Management">{{ __('admin.menu.user_management') }}</div>
            </a>
            <ul class="menu-sub">
                <!-- Users -->
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

                <!-- Roles -->
                <li class="menu-item {{ Request::is('admin/roles*') ? 'active' : '' }}">
                    <a href="{{ route('admin.roles.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-shield"></i>
                        <div data-i18n="Roles">{{ __('admin.menu.roles') }}</div>
                    </a>
                </li>

                <!-- Role Permissions -->
                <li class="menu-item {{ Request::is('admin/role-permissions*') ? 'active' : '' }}">
                    <a href="{{ route('admin.role-permissions.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-lock-access"></i>
                        <div data-i18n="Role Permissions">{{ __('admin.menu.role_permissions') }}</div>
                    </a>
                </li>

                <!-- User Activity Logs -->
                <li class="menu-item {{ Request::is('admin/user-activity-logs*') ? 'active' : '' }}">
                    <a href="{{ route('admin.user-activity-logs.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-activity"></i>
                        <div data-i18n="Activity Logs">{{ __('admin.menu.activity_logs') }}</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Subscription Management -->
        <li
            class="menu-item open {{ Request::is('admin/subscription-plans*') || Request::is('admin/manual-subscriptions*') || Request::is('admin/active-subscribers*') || Request::is('admin/subscription-history*') || Request::is('admin/promos*') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-crown"></i>
                <div data-i18n="Subscription Management">{{ __('admin.menu.subscription_management') }}</div>
            </a>
            <ul class="menu-sub">
                <!-- Subscription Plans -->
                <li class="menu-item {{ Request::is('admin/subscription-plans*') ? 'active' : '' }}">
                    <a href="{{ route('admin.subscription-plans.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-package"></i>
                        <div data-i18n="Subscription Plans">{{ __('admin.menu.subscription_plans') }}</div>
                    </a>
                </li>

                <!-- Manual Subscriptions -->
                <li class="menu-item {{ Request::is('admin/manual-subscriptions*') ? 'active' : '' }}">
                    <a href="{{ route('admin.manual-subscriptions.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-edit"></i>
                        <div data-i18n="Manual Subscriptions">{{ __('admin.menu.manual_subscriptions') }}</div>
                    </a>
                </li>

                <!-- Active Subscribers -->
                <li class="menu-item {{ Request::is('admin/active-subscribers*') ? 'active' : '' }}">
                    <a href="{{ route('admin.active-subscribers.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-users-group"></i>
                        <div data-i18n="Active Subscribers">{{ __('admin.menu.active_subscribers') }}</div>
                    </a>
                </li>

                <!-- Payment History -->
                <li class="menu-item {{ Request::is('admin/subscription-history*') ? 'active' : '' }}">
                    <a href="{{ route('admin.subscription-history.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-receipt"></i>
                        <div data-i18n="Payment History">{{ __('admin.menu.subscription_history') }}</div>
                    </a>
                </li>

                <!-- Promos -->
                <li class="menu-item {{ Request::is('admin/promos*') ? 'active' : '' }}">
                    <a href="{{ route('admin.promos.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-ticket"></i>
                        <div data-i18n="Promos">{{ __('admin.menu.promos_discounts') }}</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Content Management -->
        <li class="menu-item {{ Request::is('admin/blogs*') ? 'active' : '' }}">
            <a href="{{ route('admin.blogs.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-news"></i>
                <div data-i18n="Blogs">{{ __('admin.menu.blogs') }}</div>
            </a>
        </li>

        <!-- Admin Management (Only for Superadmin) -->
        @if(auth('admin')->check() && auth('admin')->user()->type === 'superadmin')
        <li class="menu-item {{ Request::is('admin/admins*') ? 'active' : '' }}">
            <a href="{{ route('admin.admins.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-user-shield"></i>
                <div data-i18n="Admin Management">Manajemen Admin</div>
            </a>
        </li>
        @endif

        {{-- Blog Categories - Disabled (Controller not found)
        <li
            class="menu-item open {{ Request::is('admin/blogs*') || Request::is('admin/blog-categories*') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-file-text"></i>
                <div data-i18n="Content Management">Content Management</div>
            </a>
            <ul class="menu-sub">
                <li
                    class="menu-item {{ Request::is('admin/blogs*') && !Request::is('admin/blog-categories*') ? 'active' : '' }}">
                    <a href="{{ route('admin.blogs.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-article"></i>
                        <div data-i18n="Blogs">Blogs</div>
                    </a>
                </li>

                <li class="menu-item {{ Request::is('admin/blog-categories*') ? 'active' : '' }}">
                    <a href="{{ route('admin.blog-categories.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-category"></i>
                        <div data-i18n="Blog Categories">Blog Categories</div>
                    </a>
                </li>
            </ul>
        </li>
        --}}

        <!-- Website Management -->
        <li
            class="menu-item {{ Request::is('admin/collection-order*') || Request::is('admin/banners*') || Request::is('admin/collections*') || Request::is('admin/landing-page-content*') || Request::is('admin/pricing-benefits*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-settings"></i>
                <div data-i18n="Website Management">{{ __('admin.menu.website_setting') }}</div>
            </a>
            <ul class="menu-sub">
                <!-- Landing Page Content -->
                <li class="menu-item {{ Request::is('admin/landing-page-content*') ? 'active' : '' }}">
                    <a href="{{ route('admin.landing-page-content.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-layout"></i>
                        <div data-i18n="Landing Page Content">{{ __('admin.menu.landing_page_content') }}</div>
                    </a>
                </li>
                <!-- Pricing Benefits -->
                <li class="menu-item {{ Request::is('admin/pricing-benefits*') ? 'active' : '' }}">
                    <a href="{{ route('admin.pricing-benefits.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-gift"></i>
                        <div data-i18n="Pricing Benefits">{{ __('admin.menu.pricing_benefits') }}</div>
                    </a>
                </li>
                <!-- Hero Banners -->
                <li class="menu-item {{ Request::is('admin/banners*') ? 'active' : '' }}">
                    <a href="{{ route('admin.banners.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-photo"></i>
                        <div data-i18n="Hero Banners">{{ __('admin.menu.hero_banners') }}</div>
                    </a>
                </li>
                <!-- Collection Ebook -->
                <li class="menu-item {{ Request::is('admin/collections*') ? 'active' : '' }}">
                    <a href="{{ route('admin.collections.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-folders"></i>
                        <div data-i18n="Collection Ebook">{{ __('admin.menu.collection_ebook') }}</div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>
