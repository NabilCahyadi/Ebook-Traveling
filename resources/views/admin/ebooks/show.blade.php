<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('assets/') }}" data-template="vertical-menu-template">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>View Ebook - Admin Dashboard</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/tabler-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            <!-- Menu -->
            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="{{ route('admin.dashboard') }}" class="app-brand-link">
                        <span class="app-brand-logo demo">
                            <i class="ti ti-book-2 ti-lg text-primary"></i>
                        </span>
                        <span class="app-brand-text demo menu-text fw-bold ms-2">Ebook Traveling</span>
                    </a>

                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                        <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
                        <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <!-- Dashboard -->
                    <li class="menu-item">
                        <a href="{{ route('admin.dashboard') }}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-smart-home"></i>
                            <div data-i18n="Dashboard">Dashboard</div>
                        </a>
                    </li>

                    <!-- Role & Permission -->
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons ti ti-shield-lock"></i>
                            <div data-i18n="Role & Permission">Role & Permission</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <div data-i18n="Roles">Roles</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <div data-i18n="Permissions">Permissions</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Ebook -->
                    <li class="menu-item active open">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons ti ti-book"></i>
                            <div data-i18n="Ebook">Ebook</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item active">
                                <a href="{{ route('admin.ebooks.index') }}" class="menu-link">
                                    <div data-i18n="All Ebooks">All Ebooks</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <div data-i18n="Categories">Categories</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <div data-i18n="Cities">Cities</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Subscription -->
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons ti ti-crown"></i>
                            <div data-i18n="Subscription">Subscription</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <div data-i18n="Plans">Plans</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <div data-i18n="Subscribers">Subscribers</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <div data-i18n="Payments">Payments</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Dashboard Setting -->
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons ti ti-settings"></i>
                            <div data-i18n="Dashboard Setting">Dashboard Setting</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <div data-i18n="General">General</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <div data-i18n="Email Settings">Email Settings</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Log Action User -->
                    <li class="menu-item">
                        <a href="#" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-file-text"></i>
                            <div data-i18n="Log Action User">Log Action User</div>
                        </a>
                    </li>

                    <!-- Promo and Discount -->
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons ti ti-discount-2"></i>
                            <div data-i18n="Promo & Discount">Promo & Discount</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <div data-i18n="All Promos">All Promos</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <div data-i18n="Create Promo">Create Promo</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </aside>
            <!-- / Menu -->

            <!-- Layout page -->
            <div class="layout-page">

                <!-- Navbar -->
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="ti ti-menu-2 ti-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <span
                                            class="avatar-initial rounded-circle bg-label-primary">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="ti ti-logout me-2 ti-sm"></i>
                                                <span class="align-middle">Log Out</span>
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">

                        <!-- Page Header -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h4 class="fw-bold py-3 mb-2">
                                    <span class="text-muted fw-light">Ebook /</span> View Details
                                </h4>
                            </div>
                            <div>
                                <a href="{{ route('admin.ebooks.index') }}" class="btn btn-secondary me-2">
                                    <i class="ti ti-arrow-left me-1"></i> Back
                                </a>
                                <a href="{{ route('admin.ebooks.edit', $ebook->id) }}" class="btn btn-primary">
                                    <i class="ti ti-pencil me-1"></i> Edit
                                </a>
                            </div>
                        </div>

                        <!-- Ebook Details -->
                        <div class="row">
                            <!-- Cover Image -->
                            <div class="col-md-4">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3">Cover Image</h5>
                                        @if ($ebook->cover_image)
                                            <img src="{{ $ebook->cover_image }}" alt="{{ $ebook->title }}"
                                                class="img-fluid rounded w-100">
                                        @else
                                            <div class="bg-label-secondary rounded d-flex align-items-center justify-content-center"
                                                style="height: 400px;">
                                                <i class="ti ti-photo ti-xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Quick Info -->
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3">Quick Info</h5>
                                        <ul class="list-unstyled mb-0">
                                            <li class="mb-3">
                                                <span class="fw-medium">Status:</span>
                                                @if ($ebook->is_active)
                                                    <span class="badge bg-label-success ms-2">Active</span>
                                                @else
                                                    <span class="badge bg-label-secondary ms-2">Inactive</span>
                                                @endif
                                            </li>
                                            <li class="mb-3">
                                                <span class="fw-medium">Category:</span>
                                                <span
                                                    class="badge bg-label-info ms-2">{{ $ebook->category->name ?? 'N/A' }}</span>
                                            </li>
                                            <li class="mb-3">
                                                <span class="fw-medium">City:</span>
                                                <span class="ms-2">
                                                    <i class="ti ti-map-pin ti-xs"></i>
                                                    {{ $ebook->city->name ?? 'N/A' }}
                                                </span>
                                            </li>
                                            <li class="mb-3">
                                                <span class="fw-medium">Created:</span>
                                                <span
                                                    class="ms-2">{{ $ebook->created_at->format('d M Y, H:i') }}</span>
                                            </li>
                                            <li class="mb-0">
                                                <span class="fw-medium">Last Updated:</span>
                                                <span
                                                    class="ms-2">{{ $ebook->updated_at->format('d M Y, H:i') }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Ebook Information -->
                            <div class="col-md-8">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3">Ebook Information</h5>

                                        <div class="mb-4">
                                            <label class="form-label fw-medium">Title</label>
                                            <p class="form-control-plaintext">{{ $ebook->title }}</p>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label fw-medium">Slug</label>
                                            <p class="form-control-plaintext text-muted">{{ $ebook->slug }}</p>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label fw-medium">Description</label>
                                            <p class="form-control-plaintext">{{ $ebook->description }}</p>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label fw-medium">Preview Content</label>
                                            <p class="form-control-plaintext">
                                                {{ $ebook->preview_content ?? 'No preview content available' }}</p>
                                        </div>

                                        <div class="mb-0">
                                            <label class="form-label fw-medium">PDF File</label>
                                            @if ($ebook->file_url)
                                                <p class="form-control-plaintext">
                                                    <a href="{{ Storage::url($ebook->file_url) }}" target="_blank"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="ti ti-download me-1"></i> Download PDF
                                                    </a>
                                                </p>
                                            @else
                                                <p class="form-control-plaintext text-muted">No PDF file uploaded</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3">Actions</h5>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.ebooks.edit', $ebook->id) }}"
                                                class="btn btn-primary">
                                                <i class="ti ti-pencil me-1"></i> Edit Ebook
                                            </a>
                                            <form action="{{ route('admin.ebooks.destroy', $ebook->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this ebook? This action cannot be undone.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="ti ti-trash me-1"></i> Delete Ebook
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl">
                            <div
                                class="footer-container d-flex align-items-center justify-content-between py-2 flex-md-row flex-column">
                                <div>
                                    © {{ date('Y') }}, made with ❤️ by <strong>Ebook Traveling</strong>
                                </div>
                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>
