<?php $__env->startSection('title', __('admin.ebooks.trash') . ' - ' . __('admin.ebooks.title')); ?>

<?php
    use Illuminate\Support\Facades\Storage;
?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">Admin / <?php echo e(__('admin.ebooks.title')); ?> /</span> <?php echo e(__('admin.ebooks.trash')); ?>

            </h4>
            <div class="d-flex gap-2">
                <a href="<?php echo e(route('admin.ebooks.index')); ?>" class="btn btn-outline-secondary">
                    <i class="ti ti-arrow-left me-1"></i> <?php echo e(__('admin.ebooks.back_to_all')); ?>

                </a>
            </div>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <h5 class="mb-0"><i class="ti ti-trash me-2"></i><?php echo e(__('admin.ebooks.trash_ebooks')); ?></h5>
                        <small class="text-muted"><?php echo e(__('admin.ebooks.trash_description')); ?></small>
                    </div>
                    <div class="col-md-9">
                        <div class="d-flex gap-2 justify-content-end align-items-center flex-wrap">
                            <!-- Filters Group -->
                            <div class="d-flex gap-2 flex-wrap">
                                <!-- Filter Category -->
                                <select class="form-select form-select-sm" id="filterCategory" style="width: 150px;">
                                    <option value=""><?php echo e(__('admin.ebooks.all_categories')); ?></option>
                                    <?php $__currentLoopData = \App\Models\Category::orderBy('name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                                <!-- Filter City -->
                                <select class="form-select form-select-sm" id="filterCity" style="width: 140px;">
                                    <option value=""><?php echo e(__('admin.ebooks.all_cities')); ?></option>
                                    <?php $__currentLoopData = \App\Models\City::orderBy('name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($city->id); ?>"><?php echo e($city->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                            <input type="text" class="form-control" placeholder="<?php echo e(__('admin.ebooks.search_trash')); ?>" id="searchEbook">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table View -->
            <div id="tableView" class="table-responsive text-nowrap">
                <table class="table table-hover align-middle">
                    <thead style="background-color: #fff; border-bottom: 2px solid #dee2e6;">
                        <tr>
                            <th style="width: 60px; color: #566a7f; font-weight: 600;"><?php echo e(__('admin.ebooks.cover')); ?></th>
                            <th style="width: 35%; color: #566a7f; font-weight: 600;"><?php echo e(__('admin.ebooks.title')); ?></th>
                            <th style="width: 15%; color: #566a7f; font-weight: 600;"><?php echo e(__('admin.ebooks.creator')); ?></th>
                            <th style="width: 15%; color: #566a7f; font-weight: 600;"><?php echo e(__('admin.ebooks.deleted_at')); ?></th>
                            <!-- <th style="width: 12%; color: #566a7f; font-weight: 600;">Status</th> -->
                            <th style="width: 80px; text-align: center; color: #566a7f; font-weight: 600;"><?php echo e(__('admin.ebooks.actions')); ?></th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php $__empty_1 = true; $__currentLoopData = $ebooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ebook): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr style="height: 60px;">
                                <td class="py-2">
                                    <?php if($ebook->cover_image_url): ?>
                                        <img src="<?php echo e($ebook->cover_image_url); ?>" alt="<?php echo e($ebook->title); ?>"
                                            class="rounded" style="width: 45px; height: 60px; object-fit: cover;"
                                            onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="bg-label-secondary rounded align-items-center justify-content-center"
                                            style="width: 45px; height: 60px; display: none;">
                                            <i class="ti ti-book" style="font-size: 20px;"></i>
                                        </div>
                                    <?php else: ?>
                                        <div class="bg-label-secondary rounded d-flex align-items-center justify-content-center"
                                            style="width: 45px; height: 60px;">
                                            <i class="ti ti-book" style="font-size: 20px;"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="py-2">
                                    <div style="max-width: 300px;">
                                        <strong class="d-block mb-0"
                                            style="font-size: 0.9rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"
                                            title="<?php echo e($ebook->title); ?>"><?php echo e($ebook->title); ?></strong>
                                        <small class="text-muted d-block"
                                            style="font-size: 0.75rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"
                                            title="<?php echo e(strip_tags($ebook->description)); ?>"><?php echo e(strip_tags($ebook->description)); ?></small>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <div style="max-width: 120px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; font-size: 0.85rem;"
                                        title="<?php echo e($ebook->creator->name ?? '-'); ?>"><?php echo e($ebook->creator->name ?? '-'); ?></div>
                                </td>
                                <td class="py-2">
                                    <small class="text-muted"><?php echo e($ebook->deleted_at ? $ebook->deleted_at->format('d M Y') : '-'); ?></small>
                                </td>
                                <!-- <td class="py-2">
                                    <span class="badge bg-danger" style="font-size: 0.75rem;">Trashed</span>
                                </td> -->
                                <td class="py-2 text-center">
                                    <div class="dropdown d-inline-block">
                                        <button type="button"
                                            class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <form action="<?php echo e(route('admin.ebooks.restore', $ebook->id)); ?>" method="POST" style="display: inline;">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <button type="submit" class="dropdown-item" 
                                                    onclick="return confirm('<?php echo e(__('admin.ebooks.restore_confirm')); ?>')">
                                                    <i class="ti ti-refresh me-2"></i> <?php echo e(__('admin.ebooks.restore')); ?>

                                                </button>
                                            </form>
                                            <div class="dropdown-divider"></div>
                                            <form action="<?php echo e(route('admin.ebooks.force-delete', $ebook->id)); ?>" method="POST" style="display: inline;">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="dropdown-item text-danger" 
                                                    onclick="return confirm('<?php echo e(__('admin.ebooks.delete_permanent_confirm')); ?>')">
                                                    <i class="ti ti-trash-x me-2"></i> <?php echo e(__('admin.ebooks.delete_permanent')); ?>

                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="ti ti-trash" style="font-size: 48px; color: #ddd;"></i>
                                    <p class="mt-2 text-muted"><?php echo e(__('admin.ebooks.trash_empty')); ?></p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Card View -->
            <div id="cardView" class="card-body" style="display: none;">
                <div class="row g-4">
                    <?php $__empty_1 = true; $__currentLoopData = $ebooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ebook): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="card h-100 shadow-sm d-flex flex-column border-danger position-relative">
                                <!-- Action Dropdown di pojok kanan atas -->
                                <div class="position-absolute top-0 end-0 p-2" style="z-index: 10;">
                                    <div class="dropdown pe-2">
                                        <button type="button"
                                            class="btn btn-sm btn-icon btn-text-secondary dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            style="background: transparent; border: none; border-radius: 50%;">
                                            <i class="ti ti-dots-vertical" style="color: #292929;"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <form action="<?php echo e(route('admin.ebooks.restore', $ebook->id)); ?>" method="POST" style="display: inline;">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <button type="submit" class="dropdown-item" 
                                                    onclick="return confirm('<?php echo e(__('admin.ebooks.restore_confirm')); ?>')">
                                                    <i class="ti ti-refresh me-2"></i> <?php echo e(__('admin.ebooks.restore')); ?>

                                                </button>
                                            </form>
                                            <div class="dropdown-divider"></div>
                                            <form action="<?php echo e(route('admin.ebooks.force-delete', $ebook->id)); ?>" method="POST" style="display: inline;">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="dropdown-item text-danger" 
                                                    onclick="return confirm('<?php echo e(__('admin.ebooks.delete_permanent_confirm')); ?>')">
                                                    <i class="ti ti-trash-x me-2"></i> <?php echo e(__('admin.ebooks.delete_permanent')); ?>

                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Cover Image dengan bingkai putih -->
                                <div style="background-color: #fff;" class="p-2 rounded">
                                    <?php if($ebook->cover_image_url): ?>
                                        <img src="<?php echo e($ebook->cover_image_url); ?>" class="card-img-top rounded"
                                            alt="<?php echo e($ebook->title); ?>" style="height: 250px; object-fit: cover;"
                                            onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="bg-label-secondary rounded align-items-center justify-content-center"
                                            style="height: 250px; display: none;">
                                            <i class="ti ti-book" style="font-size: 72px;"></i>
                                        </div>
                                    <?php else: ?>
                                        <div class="bg-label-secondary rounded d-flex align-items-center justify-content-center"
                                            style="height: 250px;">
                                            <i class="ti ti-book" style="font-size: 72px;"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="card-body d-flex flex-column">
                                    <div class="mb-2">
                                        <h5 class="card-title mb-1"><?php echo e(Str::limit($ebook->title, 30)); ?></h5>
                                        <span class="badge bg-danger"><?php echo e(__('admin.ebooks.trashed')); ?></span>
                                    </div>
                                    <p class="card-text small text-muted mb-3"
                                        style="flex-grow: 1; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">
                                        <?php echo e(Str::limit(strip_tags($ebook->description), 100)); ?></p>

                                    <!-- Fixed bottom section -->
                                    <div class="mt-auto pt-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">
                                                <i class="ti ti-calendar me-1"></i>
                                                <?php echo e($ebook->deleted_at ? $ebook->deleted_at->diffForHumans() : '-'); ?>

                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="col-12 text-center py-5">
                            <i class="ti ti-trash" style="font-size: 48px; color: #ddd;"></i>
                            <p class="mt-2 text-muted"><?php echo e(__('admin.ebooks.trash_empty')); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php if($ebooks->hasPages()): ?>
                <div class="card-footer">
                    <?php echo e($ebooks->appends(['per_page' => request('per_page', 10)])->links()); ?>

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
                    localStorage.setItem('ebookTrashView', 'table');

                    const currentUrl = new URL(window.location.href);
                    const currentPerPage = currentUrl.searchParams.get('per_page');
                    if (currentPerPage !== '6') {
                        currentUrl.searchParams.set('per_page', '6');
                        currentUrl.searchParams.delete('page');
                        window.location.href = currentUrl.toString();
                    }
                } else {
                    tableView.style.display = 'none';
                    cardView.style.display = 'block';
                    btnTable.classList.remove('active');
                    btnCard.classList.add('active');
                    localStorage.setItem('ebookTrashView', 'card');

                    const currentUrl = new URL(window.location.href);
                    const currentPerPage = currentUrl.searchParams.get('per_page');
                    if (currentPerPage !== '10') {
                        currentUrl.searchParams.set('per_page', '10');
                        currentUrl.searchParams.delete('page');
                        window.location.href = currentUrl.toString();
                    }
                }
            }

            // Load saved view preference
            document.addEventListener('DOMContentLoaded', function() {
                const savedView = localStorage.getItem('ebookTrashView') || 'table';
                const currentUrl = new URL(window.location.href);
                const currentPerPage = currentUrl.searchParams.get('per_page');
                const expectedPerPage = savedView === 'card' ? '10' : '6';

                if (!currentPerPage) {
                    currentUrl.searchParams.set('per_page', expectedPerPage);
                    window.history.replaceState({}, '', currentUrl.toString());
                }

                toggleView(savedView);
            });

            // Search and Filter functionality
            let searchTimeout;
            const searchInput = document.getElementById('searchEbook');
            const categoryFilter = document.getElementById('filterCategory');
            const cityFilter = document.getElementById('filterCity');

            // Real-time search
            if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(filterTable, 300);
                });
            }

            // Category and City filters
            if (categoryFilter) categoryFilter.addEventListener('change', filterTable);
            if (cityFilter) cityFilter.addEventListener('change', filterTable);

            function filterTable() {
                const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
                const selectedCategory = categoryFilter ? categoryFilter.value : '';
                const selectedCity = cityFilter ? cityFilter.value : '';

                const tableBody = document.querySelector('#tableView tbody');
                const cardBody = document.querySelector('#cardView .row');
                
                if (tableBody) {
                    const rows = tableBody.querySelectorAll('tr:not(#noDataRow)');
                    let visibleCount = 0;

                    rows.forEach(row => {
                        const title = row.querySelector('td:nth-child(2) strong')?.textContent.toLowerCase() || '';
                        const description = row.querySelector('td:nth-child(2) small')?.textContent.toLowerCase() || '';
                        const creator = row.querySelector('td:nth-child(3)')?.textContent.toLowerCase() || '';
                        
                        const matchesSearch = !searchTerm || 
                            title.includes(searchTerm) || 
                            description.includes(searchTerm) ||
                            creator.includes(searchTerm);

                        if (matchesSearch) {
                            row.style.display = '';
                            visibleCount++;
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    // Show/hide no data message
                    const noDataRow = tableBody.querySelector('#noDataRow');
                    if (noDataRow) {
                        noDataRow.style.display = visibleCount === 0 ? '' : 'none';
                    }
                }

                if (cardBody) {
                    const cards = cardBody.querySelectorAll('.col-md-6');
                    let visibleCount = 0;

                    cards.forEach(card => {
                        const title = card.querySelector('.card-title')?.textContent.toLowerCase() || '';
                        const description = card.querySelector('.card-text')?.textContent.toLowerCase() || '';
                        
                        const matchesSearch = !searchTerm || 
                            title.includes(searchTerm) || 
                            description.includes(searchTerm);

                        if (matchesSearch) {
                            card.style.display = '';
                            visibleCount++;
                        } else {
                            card.style.display = 'none';
                        }
                    });
                }
            }
        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\admin\ebooks\trash.blade.php ENDPATH**/ ?>