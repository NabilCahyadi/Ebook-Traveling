@extends('layouts.admin')

@section('title', __('admin.ebooks.trash') . ' - ' . __('admin.ebooks.title'))

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">Admin / {{ __('admin.ebooks.title') }} /</span> {{ __('admin.ebooks.trash') }}
            </h4>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.ebooks.index') }}" class="btn btn-outline-secondary">
                    <i class="ti ti-arrow-left me-1"></i> {{ __('admin.ebooks.back_to_all') }}
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <h5 class="mb-0"><i class="ti ti-trash me-2"></i>{{ __('admin.ebooks.trash_ebooks') }}</h5>
                        <small class="text-muted">{{ __('admin.ebooks.trash_description') }}</small>
                    </div>
                    <div class="col-md-9">
                        <div class="d-flex gap-2 justify-content-end align-items-center flex-wrap">
                            <!-- Select Multiple Button -->
                            <button type="button" class="btn btn-outline-secondary btn-sm" id="toggleBulkMode"
                                onclick="toggleBulkMode()">
                                <i class="ti ti-checkbox me-1"></i> {{ __('admin.ebooks.select_multiple') }}
                            </button>
                            <!-- Filters Group -->
                            <div class="d-flex gap-2 flex-wrap">
                                <!-- Filter Category -->
                                <select class="form-select form-select-sm" id="filterCategory" style="width: 150px;">
                                    <option value="">{{ __('admin.ebooks.all_categories') }}</option>
                                    @foreach(\App\Models\Category::orderBy('name')->get() as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>

                                <!-- Filter City -->
                                <select class="form-select form-select-sm" id="filterCity" style="width: 140px;">
                                    <option value="">{{ __('admin.ebooks.all_cities') }}</option>
                                    @foreach(\App\Models\City::orderBy('name')->get() as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
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
                            <input type="text" class="form-control" placeholder="{{ __('admin.ebooks.search_trash') }}" id="searchEbook">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bulk Actions Bar -->
            <div id="bulkActionsBar" class="mx-3 mt-2 mb-3 p-3 bg-light rounded d-none">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div class="d-flex align-items-center">
                        <span class="me-3"><strong id="selectedCount">0</strong> {{ __('admin.ebooks.ebooks_selected') }}</span>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <button type="button" class="btn btn-sm btn-success" onclick="bulkRestore()">
                            <i class="ti ti-refresh me-1"></i> Restore Selected
                        </button>
                        <button type="button" class="btn btn-sm btn-danger" onclick="bulkForceDelete()">
                            <i class="ti ti-trash-x me-1"></i> Delete Permanently
                        </button>
                    </div>
                </div>
            </div>

            <!-- Table View -->
            <div id="tableView" class="table-responsive text-nowrap">
                <table class="table table-hover align-middle">
                    <thead style="background-color: #fff; border-bottom: 2px solid #dee2e6;">
                        <tr>
                            <th class="bulk-checkbox-column" style="width: 40px; display: none;">
                                <input type="checkbox" class="form-check-input" id="selectAll" onclick="toggleSelectAll()">
                            </th>
                            <th style="width: 60px; color: #566a7f; font-weight: 600;">{{ __('admin.ebooks.cover') }}</th>
                            <th style="width: 35%; color: #566a7f; font-weight: 600;">{{ __('admin.ebooks.title') }}</th>
                            <th style="width: 15%; color: #566a7f; font-weight: 600;">{{ __('admin.ebooks.creator') }}</th>
                            <th style="width: 15%; color: #566a7f; font-weight: 600;">{{ __('admin.ebooks.deleted_at') }}</th>
                            <!-- <th style="width: 12%; color: #566a7f; font-weight: 600;">Status</th> -->
                            <th style="width: 80px; text-align: center; color: #566a7f; font-weight: 600;">{{ __('admin.ebooks.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse($ebooks as $ebook)
                            <tr style="height: 60px;">
                                <td class="py-2 bulk-checkbox-column" style="display: none;">
                                    <input type="checkbox" class="form-check-input ebook-checkbox" value="{{ $ebook->id }}"
                                        onchange="updateBulkActions()">
                                </td>
                                <td class="py-2">
                                    @if ($ebook->cover_image_url)
                                        <img src="{{ $ebook->cover_image_url }}" alt="{{ $ebook->title }}"
                                            class="rounded" style="width: 45px; height: 60px; object-fit: cover;"
                                            onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="bg-label-secondary rounded align-items-center justify-content-center"
                                            style="width: 45px; height: 60px; display: none;">
                                            <i class="ti ti-book" style="font-size: 20px;"></i>
                                        </div>
                                    @else
                                        <div class="bg-label-secondary rounded d-flex align-items-center justify-content-center"
                                            style="width: 45px; height: 60px;">
                                            <i class="ti ti-book" style="font-size: 20px;"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="py-2">
                                    <div style="max-width: 300px;">
                                        <strong class="d-block mb-0"
                                            style="font-size: 0.9rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"
                                            title="{{ $ebook->title }}">{{ $ebook->title }}</strong>
                                        <small class="text-muted d-block"
                                            style="font-size: 0.75rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"
                                            title="{{ strip_tags($ebook->description) }}">{{ strip_tags($ebook->description) }}</small>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <div style="max-width: 120px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; font-size: 0.85rem;"
                                        title="{{ $ebook->creator->name ?? '-' }}">{{ $ebook->creator->name ?? '-' }}</div>
                                </td>
                                <td class="py-2">
                                    <small class="text-muted">{{ $ebook->deleted_at ? $ebook->deleted_at->format('d M Y') : '-' }}</small>
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
                                            <form action="{{ route('admin.ebooks.restore', $ebook->id) }}" method="POST" style="display: none;" id="restore-form-{{ $ebook->id }}">
                                                @csrf
                                                @method('PATCH')
                                            </form>
                                            <a class="dropdown-item" href="javascript:void(0);" 
                                                onclick="confirmRestore({{ $ebook->id }}, '{{ addslashes($ebook->title) }}')">
                                                <i class="ti ti-refresh me-2"></i> {{ __('admin.ebooks.restore') }}
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('admin.ebooks.force-delete', $ebook->id) }}" method="POST" style="display: none;" id="force-delete-form-{{ $ebook->id }}">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <a class="dropdown-item text-danger" href="javascript:void(0);" 
                                                onclick="confirmForceDelete({{ $ebook->id }}, '{{ addslashes($ebook->title) }}')">
                                                <i class="ti ti-trash-x me-2"></i> {{ __('admin.ebooks.delete_permanent') }}
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="ti ti-trash" style="font-size: 48px; color: #ddd;"></i>
                                    <p class="mt-2 text-muted">{{ __('admin.ebooks.trash_empty') }}</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Card View -->
            <div id="cardView" class="card-body" style="display: none;">
                <div class="row g-4">
                    @forelse($ebooks as $ebook)
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
                                            <form action="{{ route('admin.ebooks.restore', $ebook->id) }}" method="POST" style="display: none;" id="restore-form-card-{{ $ebook->id }}">
                                                @csrf
                                                @method('PATCH')
                                            </form>
                                            <a class="dropdown-item" href="javascript:void(0);" 
                                                onclick="confirmRestore({{ $ebook->id }}, '{{ addslashes($ebook->title) }}', 'card')">
                                                <i class="ti ti-refresh me-2"></i> {{ __('admin.ebooks.restore') }}
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('admin.ebooks.force-delete', $ebook->id) }}" method="POST" style="display: none;" id="force-delete-form-card-{{ $ebook->id }}">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <a class="dropdown-item text-danger" href="javascript:void(0);" 
                                                onclick="confirmForceDelete({{ $ebook->id }}, '{{ addslashes($ebook->title) }}', 'card')">
                                                <i class="ti ti-trash-x me-2"></i> {{ __('admin.ebooks.delete_permanent') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Cover Image dengan bingkai putih -->
                                <div style="background-color: #fff;" class="p-2 rounded">
                                    @if ($ebook->cover_image_url)
                                        <img src="{{ $ebook->cover_image_url }}" class="card-img-top rounded"
                                            alt="{{ $ebook->title }}" style="height: 250px; object-fit: cover;"
                                            onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="bg-label-secondary rounded align-items-center justify-content-center"
                                            style="height: 250px; display: none;">
                                            <i class="ti ti-book" style="font-size: 72px;"></i>
                                        </div>
                                    @else
                                        <div class="bg-label-secondary rounded d-flex align-items-center justify-content-center"
                                            style="height: 250px;">
                                            <i class="ti ti-book" style="font-size: 72px;"></i>
                                        </div>
                                    @endif
                                </div>

                                <div class="card-body d-flex flex-column">
                                    <div class="mb-2">
                                        <h5 class="card-title mb-1">{{ Str::limit($ebook->title, 30) }}</h5>
                                        <span class="badge bg-danger">{{ __('admin.ebooks.trashed') }}</span>
                                    </div>
                                    <p class="card-text small text-muted mb-3"
                                        style="flex-grow: 1; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">
                                        {{ Str::limit(strip_tags($ebook->description), 100) }}</p>

                                    <!-- Fixed bottom section -->
                                    <div class="mt-auto pt-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">
                                                <i class="ti ti-calendar me-1"></i>
                                                {{ $ebook->deleted_at ? $ebook->deleted_at->diffForHumans() : '-' }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <i class="ti ti-trash" style="font-size: 48px; color: #ddd;"></i>
                            <p class="mt-2 text-muted">{{ __('admin.ebooks.trash_empty') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>

            @if ($ebooks->hasPages())
                <div class="card-footer">
                    {{ $ebooks->appends(['per_page' => request('per_page', 10)])->links() }}
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
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
    @endpush

    @push('scripts')
        <script>
            // Bulk Actions Functions
            let isBulkMode = false;

            window.toggleBulkMode = function () {
                const toggleBtn = document.getElementById('toggleBulkMode');
                isBulkMode = !isBulkMode;

                if (isBulkMode) {
                    document.querySelectorAll('.bulk-checkbox-column').forEach(el => {
                        el.style.display = '';
                    });
                    document.getElementById('bulkActionsBar').classList.remove('d-none');
                    toggleBtn.classList.remove('btn-outline-secondary');
                    toggleBtn.classList.add('btn-dark');
                } else {
                    clearSelection();
                    document.querySelectorAll('.bulk-checkbox-column').forEach(el => {
                        el.style.display = 'none';
                    });
                    document.getElementById('bulkActionsBar').classList.add('d-none');
                    toggleBtn.classList.remove('btn-dark');
                    toggleBtn.classList.add('btn-outline-secondary');
                }
            }

            window.toggleSelectAll = function () {
                const selectAllCheckbox = document.getElementById('selectAll');
                const checkboxes = document.querySelectorAll('.ebook-checkbox');
                checkboxes.forEach(cb => cb.checked = selectAllCheckbox.checked);
                updateBulkActions();
            }

            window.updateBulkActions = function () {
                const checkboxes = document.querySelectorAll('.ebook-checkbox:checked');
                const selectedCount = document.getElementById('selectedCount');
                const selectAllCheckbox = document.getElementById('selectAll');
                const allCheckboxes = document.querySelectorAll('.ebook-checkbox');

                selectedCount.textContent = checkboxes.length;
                selectAllCheckbox.checked = checkboxes.length === allCheckboxes.length && allCheckboxes.length > 0;
                selectAllCheckbox.indeterminate = checkboxes.length > 0 && checkboxes.length < allCheckboxes.length;
            }

            window.getSelectedIds = function () {
                const checkboxes = document.querySelectorAll('.ebook-checkbox:checked');
                return Array.from(checkboxes).map(cb => cb.value);
            }

            window.clearSelection = function () {
                document.getElementById('selectAll').checked = false;
                document.querySelectorAll('.ebook-checkbox').forEach(cb => cb.checked = false);
                updateBulkActions();
            }

            // SweetAlert2 Confirmations
            window.confirmRestore = function(ebookId, ebookTitle, viewType = 'table') {
                const formId = viewType === 'card' ? `restore-form-card-${ebookId}` : `restore-form-${ebookId}`;
                
                Swal.fire({
                    title: 'Restore Ebook?',
                    html: `<p class="text-muted">Are you sure you want to restore <strong>${ebookTitle}</strong>?</p>`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: '<i class="ti ti-refresh me-1"></i> Yes, Restore',
                    cancelButtonText: '<i class="ti ti-x me-1"></i> Cancel',
                    customClass: {
                        popup: 'swal2-popup-custom',
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-outline-secondary',
                        actions: 'swal2-actions-custom',
                        title: 'swal2-title-custom',
                        htmlContainer: 'swal2-html-custom'
                    },
                    buttonsStyling: false,
                    reverseButtons: true,
                    focusCancel: true,
                    iconColor: '#28a745'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(formId).submit();
                    }
                });
            }

            window.confirmForceDelete = function(ebookId, ebookTitle, viewType = 'table') {
                const formId = viewType === 'card' ? `force-delete-form-card-${ebookId}` : `force-delete-form-${ebookId}`;
                
                Swal.fire({
                    title: 'Delete Permanently?',
                    html: `<p class="text-muted">Are you sure you want to permanently delete <strong>${ebookTitle}</strong>?</p><p class="small text-danger mb-0"><i class="ti ti-alert-triangle me-1"></i> This action cannot be undone!</p>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '<i class="ti ti-trash-x me-1"></i> Yes, Delete Permanently',
                    cancelButtonText: '<i class="ti ti-x me-1"></i> Cancel',
                    customClass: {
                        popup: 'swal2-popup-custom',
                        confirmButton: 'btn btn-danger',
                        cancelButton: 'btn btn-outline-secondary',
                        actions: 'swal2-actions-custom',
                        title: 'swal2-title-custom',
                        htmlContainer: 'swal2-html-custom'
                    },
                    buttonsStyling: false,
                    reverseButtons: true,
                    focusCancel: true,
                    iconColor: '#ec4899'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(formId).submit();
                    }
                });
            }

            window.bulkRestore = function () {
                const ids = getSelectedIds();
                if (ids.length === 0) {
                    Swal.fire({
                        icon: 'info',
                        title: 'No Selection',
                        text: 'Please select at least one ebook',
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        },
                        buttonsStyling: false
                    });
                    return;
                }

                Swal.fire({
                    title: `Restore ${ids.length} Ebook(s)?`,
                    html: `<p class="text-muted">Are you sure you want to restore ${ids.length} selected ebook(s)?</p>`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: '<i class="ti ti-refresh me-1"></i> Yes, Restore All',
                    cancelButtonText: '<i class="ti ti-x me-1"></i> Cancel',
                    customClass: {
                        popup: 'swal2-popup-custom',
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-outline-secondary',
                        actions: 'swal2-actions-custom',
                        title: 'swal2-title-custom',
                        htmlContainer: 'swal2-html-custom'
                    },
                    buttonsStyling: false,
                    reverseButtons: true,
                    focusCancel: true,
                    iconColor: '#28a745'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.getElementById('bulkRestoreForm');
                        const idsContainer = document.getElementById('bulkRestoreIds');
                        idsContainer.innerHTML = '';
                        ids.forEach(id => {
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'ids[]';
                            input.value = id;
                            idsContainer.appendChild(input);
                        });
                        form.submit();
                    }
                });
            }

            window.bulkForceDelete = function () {
                const ids = getSelectedIds();
                if (ids.length === 0) {
                    Swal.fire({
                        icon: 'info',
                        title: 'No Selection',
                        text: 'Please select at least one ebook',
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        },
                        buttonsStyling: false
                    });
                    return;
                }

                Swal.fire({
                    title: `Delete ${ids.length} Ebook(s) Permanently?`,
                    html: `<p class="text-muted">Are you sure you want to permanently delete ${ids.length} selected ebook(s)?</p><p class="small text-danger mb-0"><i class="ti ti-alert-triangle me-1"></i> This action cannot be undone!</p>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '<i class="ti ti-trash-x me-1"></i> Yes, Delete Permanently',
                    cancelButtonText: '<i class="ti ti-x me-1"></i> Cancel',
                    customClass: {
                        popup: 'swal2-popup-custom',
                        confirmButton: 'btn btn-danger',
                        cancelButton: 'btn btn-outline-secondary',
                        actions: 'swal2-actions-custom',
                        title: 'swal2-title-custom',
                        htmlContainer: 'swal2-html-custom'
                    },
                    buttonsStyling: false,
                    reverseButtons: true,
                    focusCancel: true,
                    iconColor: '#ec4899'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.getElementById('bulkForceDeleteForm');
                        const idsContainer = document.getElementById('bulkForceDeleteIds');
                        idsContainer.innerHTML = '';
                        ids.forEach(id => {
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'ids[]';
                            input.value = id;
                            idsContainer.appendChild(input);
                        });
                        form.submit();
                    }
                });
            }
        </script>

        <style>
            .swal2-popup-custom {
                border-radius: 0.75rem !important;
                padding: 2rem !important;
            }
            .swal2-title-custom {
                color: #384551 !important;
                font-size: 1.375rem !important;
                font-weight: 600 !important;
            }
            .swal2-html-custom {
                color: #697a8d !important;
            }
            .swal2-actions-custom {
                gap: 0.75rem !important;
                margin-top: 1.5rem !important;
            }
            .swal2-icon.swal2-warning {
                border-color: #ec4899 !important;
                color: #ec4899 !important;
            }
            .swal2-icon.swal2-warning .swal2-icon-content {
                color: #ec4899 !important;
            }
        </style>

        <!-- Hidden forms for bulk actions -->
        <form id="bulkRestoreForm" action="{{ route('admin.ebooks.bulk-restore') }}" method="POST" style="display: none;">
            @csrf
            <div id="bulkRestoreIds"></div>
        </form>

        <form id="bulkForceDeleteForm" action="{{ route('admin.ebooks.bulk-force-delete') }}" method="POST" style="display: none;">
            @csrf
            <div id="bulkForceDeleteIds"></div>
        </form>
    @endpush
@endsection
