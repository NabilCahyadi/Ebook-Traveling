@extends('layouts.admin')

@section('title', 'Trash - Blogs')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">Admin / Blogs /</span> Trash
            </h4>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-secondary">
                    <i class="ti ti-arrow-left me-1"></i> Back to All Blogs
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
                        <h5 class="mb-0"><i class="ti ti-trash me-2"></i>Trash Blogs</h5>
                        <small class="text-muted">Blogs can be restored or deleted</small>
                    </div>
                    <div class="col-md-9">
                        <div class="d-flex gap-2 justify-content-end align-items-center flex-wrap">
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
                            <input type="text" class="form-control" placeholder="Search blog in trash..." id="searchBlog">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table View -->
            <div id="tableView" class="table-responsive text-nowrap">
                <table class="table table-hover align-middle">
                    <thead style="background-color: #fff; border-bottom: 2px solid #dee2e6;">
                        <tr>
                            <th style="width: 60px; color: #566a7f; font-weight: 600;">Image</th>
                            <th style="width: 35%; color: #566a7f; font-weight: 600;">Title</th>
                            <th style="width: 15%; color: #566a7f; font-weight: 600;">Author</th>
                            <th style="width: 15%; color: #566a7f; font-weight: 600;">Deleted At</th>
                            <th style="width: 80px; text-align: center; color: #566a7f; font-weight: 600;">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse($blogs as $blog)
                            <tr style="height: 60px;">
                                <td class="py-2">
                                    @if ($blog->featured_image_url)
                                        <img src="{{ $blog->featured_image_url }}" alt="{{ $blog->title }}"
                                            class="rounded" style="width: 45px; height: 60px; object-fit: cover;"
                                            onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="bg-label-secondary rounded align-items-center justify-content-center"
                                            style="width: 45px; height: 60px; display: none;">
                                            <i class="ti ti-news" style="font-size: 20px;"></i>
                                        </div>
                                    @else
                                        <div class="bg-label-secondary rounded d-flex align-items-center justify-content-center"
                                            style="width: 45px; height: 60px;">
                                            <i class="ti ti-news" style="font-size: 20px;"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="py-2">
                                    <div style="max-width: 300px;">
                                        <strong class="d-block mb-0"
                                            style="font-size: 0.9rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"
                                            title="{{ $blog->title }}">{{ $blog->title }}</strong>
                                        <small class="text-muted d-block"
                                            style="font-size: 0.75rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"
                                            title="{{ strip_tags($blog->excerpt ?? $blog->content) }}">{{ strip_tags($blog->excerpt ?? $blog->content) }}</small>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <div style="max-width: 120px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; font-size: 0.85rem;"
                                        title="{{ $blog->author->name ?? '-' }}">{{ $blog->author->name ?? '-' }}</div>
                                </td>
                                <td class="py-2">
                                    <small class="text-muted">{{ $blog->deleted_at ? $blog->deleted_at->format('d M Y') : '-' }}</small>
                                </td>
                                <td class="py-2 text-center">
                                    <div class="dropdown d-inline-block">
                                        <button type="button"
                                            class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <form action="{{ route('admin.blogs.restore', $blog->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="dropdown-item" 
                                                    onclick="return confirm('Restore this blog?')">
                                                    <i class="ti ti-refresh me-2"></i> Restore
                                                </button>
                                            </form>
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('admin.blogs.force-delete', $blog->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger" 
                                                    onclick="return confirm('Permanently delete this blog? This action cannot be undone!')">
                                                    <i class="ti ti-trash-x me-2"></i> Delete Permanently
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <i class="ti ti-trash" style="font-size: 48px; color: #ddd;"></i>
                                    <p class="mt-2 text-muted">Trash is empty</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Card View -->
            <div id="cardView" class="card-body" style="display: none;">
                <div class="row g-4">
                    @forelse($blogs as $blog)
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
                                            <form action="{{ route('admin.blogs.restore', $blog->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="dropdown-item" 
                                                    onclick="return confirm('Restore this blog?')">
                                                    <i class="ti ti-refresh me-2"></i> Restore
                                                </button>
                                            </form>
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('admin.blogs.force-delete', $blog->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger" 
                                                    onclick="return confirm('Permanently delete this blog? This action cannot be undone!')">
                                                    <i class="ti ti-trash-x me-2"></i> Delete Permanently
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Featured Image dengan bingkai putih -->
                                <div style="background-color: #fff;" class="p-2 rounded">
                                    @if ($blog->featured_image_url)
                                        <img src="{{ $blog->featured_image_url }}" class="card-img-top rounded"
                                            alt="{{ $blog->title }}" style="height: 250px; object-fit: cover;"
                                            onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="bg-label-secondary rounded align-items-center justify-content-center"
                                            style="height: 250px; display: none;">
                                            <i class="ti ti-news" style="font-size: 72px;"></i>
                                        </div>
                                    @else
                                        <div class="bg-label-secondary rounded d-flex align-items-center justify-content-center"
                                            style="height: 250px;">
                                            <i class="ti ti-news" style="font-size: 72px;"></i>
                                        </div>
                                    @endif
                                </div>

                                <div class="card-body d-flex flex-column">
                                    <div class="mb-2">
                                        <h5 class="card-title mb-1">{{ Str::limit($blog->title, 30) }}</h5>
                                        <span class="badge bg-danger">Trashed</span>
                                    </div>
                                    <p class="card-text small text-muted mb-3"
                                        style="flex-grow: 1; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">
                                        {{ Str::limit(strip_tags($blog->excerpt ?? $blog->content), 100) }}</p>

                                    <!-- Fixed bottom section -->
                                    <div class="mt-auto pt-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">
                                                <i class="ti ti-calendar me-1"></i>
                                                {{ $blog->deleted_at ? $blog->deleted_at->diffForHumans() : '-' }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <i class="ti ti-trash" style="font-size: 48px; color: #ddd;"></i>
                            <p class="mt-2 text-muted">Trash is empty</p>
                        </div>
                    @endforelse
                </div>
            </div>

            @if ($blogs->hasPages())
                <div class="card-footer">
                    {{ $blogs->appends(['per_page' => request('per_page', 10)])->links() }}
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
                    localStorage.setItem('blogTrashView', 'table');

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
                    localStorage.setItem('blogTrashView', 'card');

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
                const savedView = localStorage.getItem('blogTrashView') || 'table';
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
            const searchInput = document.getElementById('searchBlog');

            // Real-time search
            if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(filterTable, 300);
                });
            }

            function filterTable() {
                const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';

                const tableBody = document.querySelector('#tableView tbody');
                const cardBody = document.querySelector('#cardView .row');
                
                if (tableBody) {
                    const rows = tableBody.querySelectorAll('tr:not(#noDataRow)');
                    let visibleCount = 0;

                    rows.forEach(row => {
                        const title = row.querySelector('td:nth-child(2) strong')?.textContent.toLowerCase() || '';
                        const description = row.querySelector('td:nth-child(2) small')?.textContent.toLowerCase() || '';
                        const author = row.querySelector('td:nth-child(3)')?.textContent.toLowerCase() || '';
                        
                        const matchesSearch = !searchTerm || 
                            title.includes(searchTerm) || 
                            description.includes(searchTerm) ||
                            author.includes(searchTerm);

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
@endsection
