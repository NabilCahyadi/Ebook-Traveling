<?php $__env->startSection('title', 'Manage Ebooks'); ?>

<?php
    use Illuminate\Support\Facades\Storage;
?>

<?php $__env->startSection('content'); ?>

    <style>
        .btn .bx-dots-vertical-rounded {
            font-size: 22px;
            /* default sekitar 18px */
        }
    </style>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">Admin /</span> Ebooks
            </h4>
            <a href="<?php echo e(route('admin.ebooks.create')); ?>" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i> Add New Ebook
            </a>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <h5 class="mb-0">All Ebooks</h5>
                    </div>
                    <div class="col-md-9">
                        <div class="d-flex gap-2 justify-content-end flex-wrap">
                            <!-- Search -->
                            <div class="input-group" style="width: 250px;">
                                <span class="input-group-text"><i class="ti ti-search"></i></span>
                                <input type="text" class="form-control" placeholder="Search ebooks..." id="searchEbook" 
                                    value="<?php echo e(request('search')); ?>">
                            </div>

                            <!-- Filter Status -->
                            <div class="input-group" style="width: 180px;">
                                <span class="input-group-text"><i class="ti ti-filter"></i></span>
                                <select class="form-select" id="filterStatus" onchange="applyFilters()">
                                    <option value="">All Status</option>
                                    <option value="published" <?php echo e(request('status') == 'published' ? 'selected' : ''); ?>>Published</option>
                                    <option value="draft" <?php echo e(request('status') == 'draft' ? 'selected' : ''); ?>>Draft</option>
                                    <option value="archived" <?php echo e(request('status') == 'archived' ? 'selected' : ''); ?>>Archived</option>
                                </select>
                            </div>

                            <!-- Sort By -->
                            <div class="input-group" style="width: 200px;">
                                <span class="input-group-text"><i class="ti ti-sort-ascending"></i></span>
                                <select class="form-select" id="sortBy" onchange="applySorting()">
                                    <option value="created_at_desc"
                                        <?php echo e(request('sort_by') == 'created_at' && request('sort_order') == 'desc' ? 'selected' : ''); ?>>
                                        Terbaru</option>
                                    <option value="view_count_desc"
                                        <?php echo e(request('sort_by') == 'view_count' && request('sort_order') == 'desc' ? 'selected' : ''); ?>>
                                        Views Terbanyak</option>
                                    <option value="view_count_asc"
                                        <?php echo e(request('sort_by') == 'view_count' && request('sort_order') == 'asc' ? 'selected' : ''); ?>>
                                        Views Tersedikit</option>
                                    <option value="page_count_desc"
                                        <?php echo e(request('sort_by') == 'page_count' && request('sort_order') == 'desc' ? 'selected' : ''); ?>>
                                        Pages Terbanyak</option>
                                    <option value="page_count_asc"
                                        <?php echo e(request('sort_by') == 'page_count' && request('sort_order') == 'asc' ? 'selected' : ''); ?>>
                                        Pages Tersedikit</option>
                                </select>
                            </div>

                            <!-- View Toggle -->
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-primary active" id="viewTable"
                                    onclick="toggleView('table')">
                                    <i class="ti ti-table"></i>
                                </button>
                                <button type="button" class="btn btn-outline-primary" id="viewCard"
                                    onclick="toggleView('card')">
                                    <i class="ti ti-layout-grid"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table View -->
            <div id="tableView" class="table-responsive text-nowrap">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th style="width: 80px;">Cover</th>
                            <th style="width: 35%;">Title</th>
                            <th style="width: 20%;">Creator</th>
                            <th style="width: 12%;">Status</th>
                            <th style="width: 12%;">Views</th>
                            <th style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0" id="ebookTableBody">
                        <?php $__empty_1 = true; $__currentLoopData = $ebooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ebook): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr data-status="<?php echo e($ebook->status); ?>">
                                <td>
                                    <?php if($ebook->cover_image_url): ?>
                                        <img src="<?php echo e($ebook->cover_image_url); ?>" alt="<?php echo e($ebook->title); ?>"
                                            class="rounded" style="width: 50px; height: 70px; object-fit: cover;"
                                            onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="bg-label-secondary rounded align-items-center justify-content-center"
                                            style="width: 50px; height: 70px; display: none;">
                                            <i class="ti ti-book" style="font-size: 24px;"></i>
                                        </div>
                                    <?php else: ?>
                                        <div class="bg-label-secondary rounded d-flex align-items-center justify-content-center"
                                            style="width: 50px; height: 70px;">
                                            <i class="ti ti-book" style="font-size: 24px;"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div style="max-width: 300px;">
                                        <strong class="d-block mb-1"
                                            style="font-size: 0.9375rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"
                                            title="<?php echo e($ebook->title); ?>"><?php echo e($ebook->title); ?></strong>
                                        <small class="text-muted d-block"
                                            style="font-size: 0.8125rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"
                                            title="<?php echo e(strip_tags($ebook->description)); ?>"><?php echo e(strip_tags($ebook->description)); ?></small>
                                    </div>
                                </td>
                                <td>
                                    <div style="max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; font-size: 0.875rem;"
                                        title="<?php echo e($ebook->creator->name ?? '-'); ?>"><?php echo e($ebook->creator->name ?? '-'); ?></div>
                                </td>
                                <td>
                                    <?php if($ebook->status === 'published'): ?>
                                        <span class="badge bg-success" style="font-size: 0.8125rem;">Published</span>
                                    <?php elseif($ebook->status === 'draft'): ?>
                                        <span class="badge bg-warning" style="font-size: 0.8125rem;">Draft</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary" style="font-size: 0.8125rem;">Archived</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="text-muted d-flex align-items-center" style="font-size: 0.875rem;">
                                        <i class="ti ti-eye me-1"></i> <?php echo e(number_format($ebook->view_count ?? 0)); ?>

                                    </span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button"
                                            class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="<?php echo e(route('admin.ebooks.show', $ebook->id)); ?>">
                                                <i class="ti ti-eye me-2"></i> View Details
                                            </a>
                                            <a class="dropdown-item" href="<?php echo e(route('admin.ebooks.edit', $ebook->id)); ?>">
                                                <i class="ti ti-pencil me-2"></i> Edit
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <form action="<?php echo e(route('admin.ebooks.destroy', $ebook->id)); ?>" method="POST"
                                                style="display: none;" id="delete-ebook-<?php echo e($ebook->id); ?>">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                            </form>
                                            <a class="dropdown-item text-danger" href="javascript:void(0);"
                                                onclick="if(confirm('Are you sure you want to delete this ebook?')) document.getElementById('delete-ebook-<?php echo e($ebook->id); ?>').submit();">
                                                <i class="ti ti-trash me-2"></i> Delete
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr id="noDataRow">
                                <td colspan="6" class="text-center py-5">
                                    <i class="ti ti-book" style="font-size: 48px; color: #ddd;"></i>
                                    <p class="mt-2 text-muted">No ebooks found</p>
                                    <a href="<?php echo e(route('admin.ebooks.create')); ?>" class="btn btn-sm btn-primary">Add Your
                                        First Ebook</a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Card View -->
            <div id="cardView" class="card-body" style="display: none;">
                <div class="row g-4" id="ebookCardBody">
                    <?php $__empty_1 = true; $__currentLoopData = $ebooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ebook): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="col-md-6 col-lg-4 col-xl-3 ebook-card" data-status="<?php echo e($ebook->status); ?>">
                            <div class="card h-100 shadow-sm d-flex flex-column">
                                <?php if($ebook->cover_image_url): ?>
                                    <img src="<?php echo e($ebook->cover_image_url); ?>" class="card-img-top"
                                        alt="<?php echo e($ebook->title); ?>" style="height: 250px; object-fit: cover;"
                                        onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="bg-label-secondary align-items-center justify-content-center"
                                        style="height: 250px; display: none;">
                                        <i class="ti ti-book" style="font-size: 72px;"></i>
                                    </div>
                                <?php else: ?>
                                    <div class="bg-label-secondary d-flex align-items-center justify-content-center"
                                        style="height: 250px;">
                                        <i class="ti ti-book" style="font-size: 72px;"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title mb-0 flex-grow-1" style="max-width: 80%;">
                                            <?php echo e(Str::limit($ebook->title, 30)); ?></h5>
                                        <div class="dropdown">
                                            <button type="button"
                                                class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item"
                                                    href="<?php echo e(route('admin.ebooks.show', $ebook->id)); ?>">
                                                    <i class="ti ti-eye me-2"></i> View
                                                </a>
                                                <a class="dropdown-item"
                                                    href="<?php echo e(route('admin.ebooks.edit', $ebook->id)); ?>">
                                                    <i class="ti ti-pencil me-2"></i> Edit
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <form action="<?php echo e(route('admin.ebooks.destroy', $ebook->id)); ?>"
                                                    method="POST" style="display: none;"
                                                    id="delete-ebook-card-<?php echo e($ebook->id); ?>">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                </form>
                                                <a class="dropdown-item text-danger" href="javascript:void(0);"
                                                    onclick="if(confirm('Delete this ebook?')) document.getElementById('delete-ebook-card-<?php echo e($ebook->id); ?>').submit();">
                                                    <i class="ti ti-trash me-2"></i> Delete
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="card-text small text-muted mb-3"
                                        style="flex-grow: 1; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">
                                        <?php echo e(Str::limit(strip_tags($ebook->description), 100)); ?></p>

                                    <!-- Fixed bottom section -->
                                    <div class="mt-auto pt-2">
                                        <div class="d-flex justify-content-between align-items-center mb-2 gap-2">
                                            <span class="badge bg-label-info flex-shrink-0">
                                                <i class="ti ti-file me-1"></i><?php echo e($ebook->page_count ?? 0); ?> pages
                                            </span>
                                            <?php if($ebook->status === 'published'): ?>
                                                <span class="badge bg-success">Published</span>
                                            <?php elseif($ebook->status === 'draft'): ?>
                                                <span class="badge bg-warning">Draft</span>
                                            <?php elseif($ebook->status === 'waiting_approval'): ?>
                                                <span class="badge bg-info text-truncate" style="max-width: 120px;"
                                                    title="Waiting Approval">Waiting</span>
                                            <?php elseif($ebook->status === 'unpublished'): ?>
                                                <span class="badge bg-secondary">Unpublished</span>
                                            <?php elseif($ebook->status === 'archived'): ?>
                                                <span class="badge bg-dark">Archived</span>
                                            <?php elseif($ebook->status === 'rejected'): ?>
                                                <span class="badge bg-danger">Rejected</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary text-truncate"
                                                    style="max-width: 120px;"><?php echo e(ucfirst($ebook->status)); ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="small text-muted d-flex align-items-center">
                                            <i class="ti ti-eye me-1"></i>
                                            <span><?php echo e(number_format($ebook->view_count ?? 0)); ?> views</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="col-12 text-center py-5">
                            <i class="ti ti-book" style="font-size: 48px; color: #ddd;"></i>
                            <p class="mt-2 text-muted">No ebooks found</p>
                            <a href="<?php echo e(route('admin.ebooks.create')); ?>" class="btn btn-sm btn-primary">Add Your First
                                Ebook</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php if($ebooks->hasPages()): ?>
                <div class="card-footer">
                    <?php echo e($ebooks->appends([
                        'per_page' => request('per_page', 8), 
                        'sort_by' => request('sort_by'), 
                        'sort_order' => request('sort_order'),
                        'search' => request('search'),
                        'status' => request('status')
                    ])->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
        <script>
            // View toggle with pagination adjustment
            function toggleView(view) {
                const tableView = document.getElementById('tableView');
                const cardView = document.getElementById('cardView');
                const btnTable = document.getElementById('viewTable');
                const btnCard = document.getElementById('viewCard');

                if (view === 'table') {
                    tableView.style.display = 'block';
                    cardView.style.display = 'none';
                    btnTable.classList.add('active');
                    btnCard.classList.remove('active');
                    localStorage.setItem('ebookView', 'table');

                    // Reload with table pagination (6 per page)
                    const currentUrl = new URL(window.location.href);
                    const currentPerPage = currentUrl.searchParams.get('per_page');
                    if (currentPerPage !== '6') {
                        currentUrl.searchParams.set('per_page', '6');
                        currentUrl.searchParams.delete('page'); // Reset to page 1
                        window.location.href = currentUrl.toString();
                    }
                } else {
                    tableView.style.display = 'none';
                    cardView.style.display = 'block';
                    btnTable.classList.remove('active');
                    btnCard.classList.add('active');
                    localStorage.setItem('ebookView', 'card');

                    // Reload with card pagination (8 per page)
                    const currentUrl = new URL(window.location.href);
                    const currentPerPage = currentUrl.searchParams.get('per_page');
                    if (currentPerPage !== '8') {
                        currentUrl.searchParams.set('per_page', '8');
                        currentUrl.searchParams.delete('page'); // Reset to page 1
                        window.location.href = currentUrl.toString();
                    }
                }
            }

            // Load saved view preference
            document.addEventListener('DOMContentLoaded', function() {
                const savedView = localStorage.getItem('ebookView') || 'table';

                // Set per_page based on saved view without reloading if already correct
                const currentUrl = new URL(window.location.href);
                const currentPerPage = currentUrl.searchParams.get('per_page');
                const expectedPerPage = savedView === 'card' ? '8' : '6';

                if (!currentPerPage) {
                    // First load, set per_page
                    currentUrl.searchParams.set('per_page', expectedPerPage);
                    window.history.replaceState({}, '', currentUrl.toString());
                }

                toggleView(savedView);
            });

            // Search functionality - Server-side dengan debounce
            let searchTimeout;
            document.getElementById('searchEbook')?.addEventListener('keyup', function(e) {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    applyFilters();
                }, 500); // Tunggu 500ms setelah user selesai mengetik
            });

            // Apply filters function - Server-side
            window.applyFilters = function() {
                const searchTerm = document.getElementById('searchEbook').value;
                const statusFilter = document.getElementById('filterStatus').value;
                
                const currentUrl = new URL(window.location.href);
                
                // Set or remove search parameter
                if (searchTerm) {
                    currentUrl.searchParams.set('search', searchTerm);
                } else {
                    currentUrl.searchParams.delete('search');
                }
                
                // Set or remove status parameter
                if (statusFilter) {
                    currentUrl.searchParams.set('status', statusFilter);
                } else {
                    currentUrl.searchParams.delete('status');
                }
                
                // Reset ke page 1 saat filter berubah
                currentUrl.searchParams.delete('page');
                
                window.location.href = currentUrl.toString();
            }

            // Sort functionality
            window.applySorting = function() {
                const sortValue = document.getElementById('sortBy').value;
                const [sortBy, sortOrder] = sortValue.split('_');
                const lastPart = sortValue.split('_').pop();

                // Reconstruct proper sort_by and sort_order
                let actualSortBy = sortBy;
                let actualSortOrder = lastPart;

                if (sortValue.startsWith('view_count')) {
                    actualSortBy = 'view_count';
                } else if (sortValue.startsWith('page_count')) {
                    actualSortBy = 'page_count';
                } else if (sortValue.startsWith('created_at')) {
                    actualSortBy = 'created_at';
                }

                const currentUrl = new URL(window.location.href);
                currentUrl.searchParams.set('sort_by', actualSortBy);
                currentUrl.searchParams.set('sort_order', actualSortOrder);
                window.location.href = currentUrl.toString();
            }


        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views/admin/ebooks/index.blade.php ENDPATH**/ ?>