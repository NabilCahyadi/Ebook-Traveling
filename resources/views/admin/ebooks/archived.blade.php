@extends('layouts.admin')

@section('title', 'Archived Ebooks')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">Admin / Ebooks /</span> Archived
            </h4>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.ebooks.index') }}" class="btn btn-outline-secondary">
                    <i class="ti ti-arrow-left me-1"></i> Back to All Ebooks
                </a>
                <a href="{{ route('admin.ebooks.create') }}" class="btn btn-primary">
                    <i class="ti ti-plus me-1"></i> {{ __('admin.ebooks.add_new') }}
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <h5 class="mb-0"><i class="ti ti-archive me-2"></i>Archived Ebooks</h5>
                    </div>
                    <div class="col-md-9">
                        <div class="d-flex gap-2 justify-content-end align-items-center flex-wrap">
                            <!-- Filters Group -->
                            <div class="d-flex gap-2 flex-wrap">
                                <!-- Filter Category -->
                                <select class="form-select form-select-sm" id="filterCategory" onchange="applyFilters()" style="width: 150px;">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <!-- Filter City -->
                                <select class="form-select form-select-sm" id="filterCity" onchange="applyFilters()" style="width: 140px;">
                                    <option value="">All Cities</option>
                                    <option value="null" {{ request('city_id') == 'null' ? 'selected' : '' }}>No City</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}" {{ request('city_id') == $city->id ? 'selected' : '' }}>
                                            {{ $city->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <!-- Sort By -->
                                <select class="form-select form-select-sm" id="sortBy" onchange="applySorting()" style="width: 160px;">
                                    <option value="created_at_desc"
                                        {{ request('sort_by') == 'created_at' && request('sort_order') == 'desc' ? 'selected' : '' }}>
                                        Terbaru</option>
                                    <option value="view_count_desc"
                                        {{ request('sort_by') == 'view_count' && request('sort_order') == 'desc' ? 'selected' : '' }}>
                                        Views Terbanyak</option>
                                    <option value="view_count_asc"
                                        {{ request('sort_by') == 'view_count' && request('sort_order') == 'asc' ? 'selected' : '' }}>
                                        Views Tersedikit</option>
                                    <option value="page_count_desc"
                                        {{ request('sort_by') == 'page_count' && request('sort_order') == 'desc' ? 'selected' : '' }}>
                                        Pages Terbanyak</option>
                                    <option value="page_count_asc"
                                        {{ request('sort_by') == 'page_count' && request('sort_order') == 'asc' ? 'selected' : '' }}>
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
                            <input type="text" class="form-control" placeholder="{{ __('admin.ebooks.search_placeholder') }}" id="searchEbook" 
                                value="{{ request('search') }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table View -->
            <div id="tableView" class="table-responsive text-nowrap">
                <table class="table table-hover align-middle">
                    <thead style="background-color: #fff; border-bottom: 2px solid #dee2e6;">
                        <tr>
                            <th style="width: 60px; color: #566a7f; font-weight: 600;">Cover</th>
                            <th style="width: 40%; color: #566a7f; font-weight: 600;">Title</th>
                            <th style="width: 20%; color: #566a7f; font-weight: 600;">Creator</th>
                            <th style="width: 12%; color: #566a7f; font-weight: 600;">Status</th>
                            <th style="width: 80px; text-align: center; color: #566a7f; font-weight: 600;">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0" id="ebookTableBody">
                        @forelse($ebooks as $ebook)
                            <tr style="height: 60px;">
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
                                    <div style="max-width: 350px;">
                                        <strong class="d-block mb-0"
                                            style="font-size: 0.9rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"
                                            title="{{ $ebook->title }}">{{ $ebook->title }}</strong>
                                        <small class="text-muted d-block"
                                            style="font-size: 0.75rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"
                                            title="{{ strip_tags($ebook->description) }}">{{ strip_tags($ebook->description) }}</small>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <div style="max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; font-size: 0.85rem;"
                                        title="{{ $ebook->creator->name ?? '-' }}">{{ $ebook->creator->name ?? '-' }}</div>
                                </td>
                                <td class="py-2">
                                    <span class="badge bg-dark" style="font-size: 0.75rem;">Archived</span>
                                </td>
                                <td class="py-2 text-center">
                                    <div class="dropdown d-inline-block">
                                        <button type="button"
                                            class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="{{ route('admin.ebooks.show', $ebook->id) }}">
                                                <i class="ti ti-eye me-2"></i> {{ __('admin.actions.view_details') }}
                                            </a>
                                            <a class="dropdown-item" href="{{ route('admin.ebooks.edit', $ebook->id) }}">
                                                <i class="ti ti-pencil me-2"></i> {{ __('admin.actions.edit') }}
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('admin.ebooks.destroy', $ebook->id) }}" method="POST"
                                                style="display: none;" id="delete-archived-ebook-{{ $ebook->id }}">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <a class="dropdown-item text-danger" href="javascript:void(0);"
                                                onclick="if(confirm('{{ __('admin.actions.delete_confirm') }}')) document.getElementById('delete-archived-ebook-{{ $ebook->id }}').submit();">
                                                <i class="ti ti-trash me-2"></i> {{ __('admin.actions.delete') }}
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr id="noDataRow">
                                <td colspan="5" class="text-center py-5">
                                    <i class="ti ti-archive" style="font-size: 48px; color: #ddd;"></i>
                                    <p class="mt-2 text-muted">No archived ebooks found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Card View -->
            <div id="cardView" class="card-body" style="display: none;">
                <div class="row g-4" id="ebookCardBody">
                    @forelse($ebooks as $ebook)
                        <div class="col-md-6 col-lg-4 col-xl-3 ebook-card">
                            <div class="card h-100 shadow-sm d-flex flex-column border-dark">
                                @if ($ebook->cover_image_url)
                                    <img src="{{ $ebook->cover_image_url }}" class="card-img-top"
                                        alt="{{ $ebook->title }}" style="height: 250px; object-fit: cover;"
                                        onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="bg-label-secondary align-items-center justify-content-center"
                                        style="height: 250px; display: none;">
                                        <i class="ti ti-book" style="font-size: 72px;"></i>
                                    </div>
                                @else
                                    <div class="bg-label-secondary d-flex align-items-center justify-content-center"
                                        style="height: 250px;">
                                        <i class="ti ti-book" style="font-size: 72px;"></i>
                                    </div>
                                @endif
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title mb-0 flex-grow-1" style="max-width: 80%;">
                                            {{ Str::limit($ebook->title, 30) }}</h5>
                                        <div class="dropdown">
                                            <button type="button"
                                                class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.ebooks.show', $ebook->id) }}">
                                                    <i class="ti ti-eye me-2"></i> View
                                                </a>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.ebooks.edit', $ebook->id) }}">
                                                    <i class="ti ti-pencil me-2"></i> Edit
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <form action="{{ route('admin.ebooks.destroy', $ebook->id) }}"
                                                    method="POST" style="display: none;"
                                                    id="delete-ebook-card-{{ $ebook->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <a class="dropdown-item text-danger" href="javascript:void(0);"
                                                    onclick="if(confirm('Delete this ebook?')) document.getElementById('delete-ebook-card-{{ $ebook->id }}').submit();">
                                                    <i class="ti ti-trash me-2"></i> Delete
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="card-text small text-muted mb-3"
                                        style="flex-grow: 1; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">
                                        {{ Str::limit(strip_tags($ebook->description), 100) }}</p>

                                    <!-- Fixed bottom section -->
                                    <div class="mt-auto pt-2">
                                        <div class="d-flex justify-content-between align-items-center mb-2 gap-2">
                                            <span class="badge bg-label-info flex-shrink-0">
                                                <i class="ti ti-file me-1"></i>{{ $ebook->page_count ?? 0 }} pages
                                            </span>
                                            <span class="badge bg-dark">Archived</span>
                                        </div>
                                        <div class="small text-muted d-flex align-items-center">
                                            <i class="ti ti-eye me-1"></i>
                                            <span>{{ number_format($ebook->view_count ?? 0) }} views</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <i class="ti ti-archive" style="font-size: 48px; color: #ddd;"></i>
                            <p class="mt-2 text-muted">No archived ebooks found</p>
                        </div>
                    @endforelse
                </div>
            </div>

            @if ($ebooks->hasPages())
                <div class="card-footer">
                    {{ $ebooks->appends([
                        'per_page' => request('per_page', 10), 
                        'sort_by' => request('sort_by'), 
                        'sort_order' => request('sort_order'),
                        'search' => request('search')
                    ])->links() }}
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
                    localStorage.setItem('ebookView', 'table');

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
                    localStorage.setItem('ebookView', 'card');

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
                const savedView = localStorage.getItem('ebookView') || 'table';
                const currentUrl = new URL(window.location.href);
                const currentPerPage = currentUrl.searchParams.get('per_page');
                const expectedPerPage = savedView === 'card' ? '10' : '6';

                if (!currentPerPage) {
                    currentUrl.searchParams.set('per_page', expectedPerPage);
                    window.history.replaceState({}, '', currentUrl.toString());
                }

                toggleView(savedView);
            });

            // Search functionality
            let searchTimeout;
            document.getElementById('searchEbook')?.addEventListener('keyup', function(e) {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    applyFilters();
                }, 500);
            });

            // Apply filters function
            window.applyFilters = function() {
                const searchTerm = document.getElementById('searchEbook').value;
                const categoryFilter = document.getElementById('filterCategory').value;
                const cityFilter = document.getElementById('filterCity').value;
                
                const currentUrl = new URL(window.location.href);
                
                if (searchTerm) {
                    currentUrl.searchParams.set('search', searchTerm);
                } else {
                    currentUrl.searchParams.delete('search');
                }
                
                if (categoryFilter) {
                    currentUrl.searchParams.set('category_id', categoryFilter);
                } else {
                    currentUrl.searchParams.delete('category_id');
                }
                
                if (cityFilter) {
                    currentUrl.searchParams.set('city_id', cityFilter);
                } else {
                    currentUrl.searchParams.delete('city_id');
                }
                
                currentUrl.searchParams.delete('page');
                window.location.href = currentUrl.toString();
            }

            // Sort functionality
            window.applySorting = function() {
                const sortValue = document.getElementById('sortBy').value;
                const [sortBy, sortOrder] = sortValue.split('_');
                const lastPart = sortValue.split('_').pop();

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
    @endpush
@endsection
