<?php $__env->startSection('title', __('admin.ebooks.title')); ?>

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
                <span class="text-muted fw-light">Admin /</span> <?php echo e(__('admin.menu.ebooks')); ?>

            </h4>
            <div class="d-flex gap-2">
                <!-- Toggle Enable Download -->
                <?php
                    $downloadEnabled = \App\Models\SystemSetting::get('enable_ebook_download', '1');
                ?>
                <div class="d-flex align-items-center gap-2 px-3 py-2 bg-light rounded">
                    <i class="ti ti-download <?php echo e($downloadEnabled == '1' ? 'text-success' : 'text-danger'); ?>"></i>
                    <span class="small fw-semibold"><?php echo e(__('admin.ebooks.download')); ?>:</span>
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" id="toggleDownload" 
                            <?php echo e($downloadEnabled == '1' ? 'checked' : ''); ?>

                            onchange="toggleEbookDownload(this)">
                        <label class="form-check-label" for="toggleDownload">
                            <span id="downloadStatus" class="badge bg-<?php echo e($downloadEnabled == '1' ? 'success' : 'danger'); ?>">
                                <?php echo e($downloadEnabled == '1' ? __('admin.ebooks.enabled') : __('admin.ebooks.disabled')); ?>

                            </span>
                        </label>
                    </div>
                </div>
                <a href="<?php echo e(route('admin.ebooks.create')); ?>" class="btn btn-primary">
                    <i class="ti ti-plus me-1"></i> <?php echo e(__('admin.ebooks.add_new')); ?>

                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <h5 class="mb-0"><?php echo e(__('admin.ebooks.all_ebooks')); ?></h5>
                    </div>
                    <div class="col-md-9">
                        <div class="d-flex gap-2 justify-content-end align-items-center flex-wrap">
                            <!-- Filters Group -->
                            <div class="d-flex gap-2 flex-wrap">
                                <!-- Filter Category -->
                                <select class="form-select form-select-sm" id="filterCategory" onchange="applyFilters()" style="width: 150px;">
                                    <option value="">All Categories</option>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category->id); ?>" <?php echo e(request('category_id') == $category->id ? 'selected' : ''); ?>>
                                            <?php echo e($category->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                                <!-- Filter City -->
                                <select class="form-select form-select-sm" id="filterCity" onchange="applyFilters()" style="width: 140px;">
                                    <option value="">All Cities</option>
                                    <option value="null" <?php echo e(request('city_id') == 'null' ? 'selected' : ''); ?>>No City</option>
                                    <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($city->id); ?>" <?php echo e(request('city_id') == $city->id ? 'selected' : ''); ?>>
                                            <?php echo e($city->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                                <!-- Filter Status -->
                                <select class="form-select form-select-sm" id="filterStatus" onchange="applyFilters()" style="width: 130px;">
                                    <option value=""><?php echo e(__('admin.ebooks.all_status')); ?></option>
                                    <option value="published" <?php echo e(request('status') == 'published' ? 'selected' : ''); ?>><?php echo e(__('admin.ebooks.published')); ?></option>
                                    <option value="draft" <?php echo e(request('status') == 'draft' ? 'selected' : ''); ?>><?php echo e(__('admin.ebooks.draft')); ?></option>
                                    <option value="archived" <?php echo e(request('status') == 'archived' ? 'selected' : ''); ?>>Archived</option>
                                </select>

                                <!-- Sort By -->
                                <select class="form-select form-select-sm" id="sortBy" onchange="applySorting()" style="width: 160px;">
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
                            <div class="btn-group btn-group-sm" role="group">
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
                
                <!-- Search Row -->
                <div class="row align-items-center mt-3">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-text"><i class="ti ti-search"></i></span>
                            <input type="text" class="form-control" placeholder="<?php echo e(__('admin.ebooks.search_placeholder')); ?>" id="searchEbook" 
                                value="<?php echo e(request('search')); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table View -->
            <div id="tableView" class="table-responsive text-nowrap">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th style="width: 80px;"><?php echo e(__('admin.ebooks.cover')); ?></th>
                            <th style="width: 35%;"><?php echo e(__('admin.ebooks.title')); ?></th>
                            <th style="width: 20%;"><?php echo e(__('admin.ebooks.creator')); ?></th>
                            <th style="width: 12%;"><?php echo e(__('admin.ebooks.status')); ?></th>
                            <th style="width: 12%; display: none;"><?php echo e(__('admin.ebooks.views')); ?></th>
                            <th style="width: 100px;"><?php echo e(__('admin.ebooks.actions')); ?></th>
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
                                        title="<?php echo e($ebook->creator->name ?? 'MeatMap Team'); ?>">
                                        <?php if($ebook->creator): ?>
                                            <?php echo e($ebook->creator->name); ?>

                                        <?php else: ?>
                                            <span class="badge bg-primary">MeatMap Team</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <?php if($ebook->status === 'published'): ?>
                                        <span class="badge bg-success" style="font-size: 0.8125rem;"><?php echo e(__('admin.ebooks.published')); ?></span>
                                    <?php elseif($ebook->status === 'draft'): ?>
                                        <span class="badge bg-warning" style="font-size: 0.8125rem;"><?php echo e(__('admin.ebooks.draft')); ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary" style="font-size: 0.8125rem;">Archived</span>
                                    <?php endif; ?>
                                </td>
                                <td style="display: none;">
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
                                                <i class="ti ti-eye me-2"></i> <?php echo e(__('admin.actions.view_details')); ?>

                                            </a>
                                            <a class="dropdown-item" href="<?php echo e(route('admin.ebooks.edit', $ebook->id)); ?>">
                                                <i class="ti ti-pencil me-2"></i> <?php echo e(__('admin.actions.edit')); ?>

                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <form action="<?php echo e(route('admin.ebooks.destroy', $ebook->id)); ?>" method="POST"
                                                style="display: none;" id="delete-ebook-<?php echo e($ebook->id); ?>">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                            </form>
                                            <a class="dropdown-item text-danger" href="javascript:void(0);"
                                                onclick="if(confirm('<?php echo e(__('admin.actions.delete_confirm')); ?>')) document.getElementById('delete-ebook-<?php echo e($ebook->id); ?>').submit();">
                                                <i class="ti ti-trash me-2"></i> <?php echo e(__('admin.actions.delete')); ?>

                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr id="noDataRow">
                                <td colspan="5" class="text-center py-5">
                                    <i class="ti ti-book" style="font-size: 48px; color: #ddd;"></i>
                                    <p class="mt-2 text-muted"><?php echo e(__('admin.ebooks.no_data')); ?></p>
                                    <a href="<?php echo e(route('admin.ebooks.create')); ?>" class="btn btn-sm btn-primary"><?php echo e(__('admin.ebooks.add_new')); ?></a>
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
                const categoryFilter = document.getElementById('filterCategory').value;
                const cityFilter = document.getElementById('filterCity').value;
                
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
                
                // Set or remove category parameter
                if (categoryFilter) {
                    currentUrl.searchParams.set('category_id', categoryFilter);
                } else {
                    currentUrl.searchParams.delete('category_id');
                }
                
                // Set or remove city parameter
                if (cityFilter) {
                    currentUrl.searchParams.set('city_id', cityFilter);
                } else {
                    currentUrl.searchParams.delete('city_id');
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

            // Toggle Ebook Download
            window.toggleEbookDownload = function(checkbox) {
                const isEnabled = checkbox.checked;
                
                console.log('Toggle clicked:', isEnabled);
                
                fetch('<?php echo e(route('admin.ebooks.toggle-download')); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        enable: isEnabled ? '1' : '0'
                    })
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    
                    if (data.success) {
                        const statusBadge = document.getElementById('downloadStatus');
                        const icon = document.querySelector('.ti-download');
                        
                        if (isEnabled) {
                            statusBadge.textContent = '<?php echo e(__("admin.ebooks.enabled")); ?>';
                            statusBadge.classList.remove('bg-danger');
                            statusBadge.classList.add('bg-success');
                            icon.classList.remove('text-danger');
                            icon.classList.add('text-success');
                        } else {
                            statusBadge.textContent = '<?php echo e(__("admin.ebooks.disabled")); ?>';
                            statusBadge.classList.remove('bg-success');
                            statusBadge.classList.add('bg-danger');
                            icon.classList.remove('text-success');
                            icon.classList.add('text-danger');
                        }
                        
                        // Show success message using Toastr
                        console.log('Showing toastr with message:', data.message);
                        toastr.success(data.message, 'Success');
                    } else {
                        console.log('Error response:', data.message);
                        toastr.error(data.message || 'Terjadi kesalahan', 'Error');
                        checkbox.checked = !isEnabled;
                    }
                })
                .catch(error => {
                    console.error('Fetch Error:', error);
                    toastr.error('Gagal mengubah setting', 'Error');
                    checkbox.checked = !isEnabled;
                });
            }

        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views/admin/ebooks/index.blade.php ENDPATH**/ ?>