<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="ti ti-menu-2 ti-md"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Search -->
        <div class="navbar-nav align-items-center">
            <div class="nav-item navbar-search-wrapper mb-0">
                <a class="nav-item nav-link search-toggler d-flex align-items-center px-0" href="javascript:void(0);">
                    <i class="ti ti-search ti-md me-2 me-lg-4 ti-lg"></i>
                    <span class="d-none d-md-inline-block text-muted fw-normal">Search (Ctrl+/)</span>
                </a>
            </div>
        </div>
        <!-- /Search -->

        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <!-- Language -->
            <li class="nav-item dropdown-language dropdown">
                <a class="nav-link btn btn-text-secondary btn-icon rounded-pill dropdown-toggle hide-arrow"
                    href="javascript:void(0);" data-bs-toggle="dropdown">
                    <i class="ti ti-language rounded-circle ti-md"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item <?php echo e(app()->getLocale() == 'en' ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.language.switch', 'en')); ?>"
                            onclick="event.preventDefault(); document.getElementById('lang-en-form').submit();">
                            <span class="align-middle">English</span>
                        </a>
                        <form id="lang-en-form" action="<?php echo e(route('admin.language.switch', 'en')); ?>" method="POST"
                            style="display: none;">
                            <?php echo csrf_field(); ?>
                        </form>
                    </li>
                    <li>
                        <a class="dropdown-item <?php echo e(app()->getLocale() == 'id' ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.language.switch', 'id')); ?>"
                            onclick="event.preventDefault(); document.getElementById('lang-id-form').submit();">
                            <span class="align-middle">Indonesia</span>
                        </a>
                        <form id="lang-id-form" action="<?php echo e(route('admin.language.switch', 'id')); ?>" method="POST"
                            style="display: none;">
                            <?php echo csrf_field(); ?>
                        </form>
                    </li>
                </ul>
            </li>
            <!--/ Language -->

            <!-- Style Switcher -->
            <li class="nav-item dropdown-style-switcher dropdown">
                <a class="nav-link btn btn-text-secondary btn-icon rounded-pill dropdown-toggle hide-arrow"
                    href="javascript:void(0);" data-bs-toggle="dropdown">
                    <i class="ti ti-md"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" data-theme="light">
                            <span class="align-middle"><i class="ti ti-sun me-3"></i>Light</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" data-theme="dark">
                            <span class="align-middle"><i class="ti ti-moon-stars me-3"></i>Dark</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" data-theme="system">
                            <span class="align-middle"><i class="ti ti-device-desktop-analytics me-3"></i>System</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- / Style Switcher-->

            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <?php if(Auth::user()->avatar): ?>
                            <img src="<?php echo e(asset('storage/' . Auth::user()->avatar)); ?>" alt="<?php echo e(Auth::user()->name); ?>"
                                class="rounded-circle" />
                        <?php else: ?>
                            <span class="avatar-initial rounded-circle"
                                style="background-color: rgba(236, 72, 153, 0.2); border: none; color: #ec4899; font-weight: 600;">
                                <?php echo e(getInitials(Auth::user()->name)); ?>

                            </span>
                        <?php endif; ?>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item mt-0" href="<?php echo e(route('admin.profile.edit')); ?>">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-2">
                                    <div class="avatar avatar-online">
                                        <?php if(Auth::user()->avatar): ?>
                                            <img src="<?php echo e(asset('storage/' . Auth::user()->avatar)); ?>"
                                                alt="<?php echo e(Auth::user()->name); ?>" class="rounded-circle" />
                                        <?php else: ?>
                                            <span class="avatar-initial rounded-circle"
                                                style="background-color: rgba(236, 72, 153, 0.2); border: none; color: #ec4899; font-weight: 600;">
                                                <?php echo e(getInitials(Auth::user()->name)); ?>

                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0"><?php echo e(Auth::user()->name); ?></h6>
                                    <small class="text-muted"><?php echo e(ucfirst(Auth::user()->user_type ?? 'Admin')); ?></small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider my-1 mx-n2"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="<?php echo e(route('admin.dashboard')); ?>">
                            <i class="ti ti-smart-home me-3 ti-md"></i><span class="align-middle">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="<?php echo e(route('admin.profile.edit')); ?>">
                            <i class="ti ti-user me-3 ti-md"></i><span class="align-middle">My Profile</span>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider my-1 mx-n2"></div>
                    </li>
                    <li>
                        <form action="<?php echo e(route('admin.logout')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="dropdown-item">
                                <i class="ti ti-logout me-3 ti-md"></i><span class="align-middle">Log Out</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
            <!--/ User -->
        </ul>
    </div>

    <!-- Search Small Screens -->
    <div class="navbar-search-wrapper search-input-wrapper d-none">
        <input type="text" class="form-control search-input container-xxl border-0" placeholder="Search..."
            aria-label="Search..." />
        <i class="ti ti-x search-toggler cursor-pointer"></i>
    </div>
</nav>

<style>
    /* Fix active dropdown item text visibility */
    .dropdown-item.active,
    .dropdown-item:active {
        color: #fff !important;
        background-color: var(--bs-primary) !important;
    }
    
    .dropdown-item.active span,
    .dropdown-item:active span {
        color: #fff !important;
    }
    
    /* Fix dropdown styles active state */
    .dropdown-styles .dropdown-item.active,
    .dropdown-styles .dropdown-item[data-theme].active {
        color: #fff !important;
        background-color: var(--bs-primary) !important;
    }
    
    .dropdown-styles .dropdown-item.active i,
    .dropdown-styles .dropdown-item[data-theme].active i {
        color: #fff !important;
    }
</style><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\layouts\partials\admin\navbar.blade.php ENDPATH**/ ?>