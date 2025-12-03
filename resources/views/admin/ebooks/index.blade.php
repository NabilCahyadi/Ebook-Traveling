@extends('layouts.admin')

@section('title', 'Manage Ebooks')

@section('content')

<style>
    .btn .bx-dots-vertical-rounded {
    font-size: 22px; /* default sekitar 18px */
}

</style>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">Admin /</span> Ebooks
            </h4>
            <a href="{{ route('admin.ebooks.create') }}" class="btn btn-primary">
                <i class="bx bx-plus me-1"></i> Add New Ebook
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

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
                                <span class="input-group-text"><i class="bx bx-search"></i></span>
                                <input type="text" class="form-control" placeholder="Search ebooks..." id="searchEbook">
                            </div>

                            <!-- Filter Status -->
                            <select class="form-select" id="filterStatus" style="width: 150px;">
                                <option value="">All Status</option>
                                <option value="published">Published</option>
                                <option value="draft">Draft</option>
                                <option value="archived">Archived</option>
                            </select>

                            <!-- View Toggle -->
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-primary active" id="viewTable"
                                    onclick="toggleView('table')">
                                    <i class="bx bx-table"></i>
                                </button>
                                <button type="button" class="btn btn-outline-primary" id="viewCard"
                                    onclick="toggleView('card')">
                                    <i class="bx bx-grid-alt"></i>
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
                            <th style="width: 25%;">Title</th>
                            <th style="width: 15%;">Author</th>
                            <th style="width: 15%;">Publisher</th>
                            <th style="width: 8%;">Pages</th>
                            <th style="width: 10%;">Status</th>
                            <th style="width: 10%;">Views</th>
                            <th style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0" id="ebookTableBody">
                        @forelse($ebooks as $ebook)
                            <tr data-status="{{ $ebook->status }}">
                                <td>
                                    @if ($ebook->cover_image)
                                        <img src="{{ asset('storage/' . $ebook->cover_image) }}" alt="{{ $ebook->title }}"
                                            class="rounded" style="width: 50px; height: 70px; object-fit: cover;">
                                    @else
                                        <div class="bg-label-secondary rounded d-flex align-items-center justify-content-center"
                                            style="width: 50px; height: 70px;">
                                            <i class="bx bx-book" style="font-size: 24px;"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div>
                                        <strong class="d-block mb-1"
                                            style="font-size: 0.9375rem;">{{ $ebook->title }}</strong>
                                        <small class="text-muted"
                                            style="font-size: 0.8125rem;">{{ Str::limit(strip_tags($ebook->description), 60) }}</small>
                                    </div>
                                </td>
                                <td style="font-size: 0.875rem;">{{ $ebook->author ?? '-' }}</td>
                                <td style="font-size: 0.875rem;">{{ $ebook->publisher ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-label-info"
                                        style="font-size: 0.8125rem;">{{ $ebook->page_count ?? 0 }}</span>
                                </td>
                                <td>
                                    @if ($ebook->status === 'published')
                                        <span class="badge bg-success" style="font-size: 0.8125rem;">Published</span>
                                    @elseif($ebook->status === 'draft')
                                        <span class="badge bg-warning" style="font-size: 0.8125rem;">Draft</span>
                                    @else
                                        <span class="badge bg-secondary" style="font-size: 0.8125rem;">Archived</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="text-muted d-flex align-items-center" style="font-size: 0.875rem;">
                                        <i class="bx bx-show me-1"></i> {{ number_format($ebook->view_count ?? 0) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="{{ route('admin.ebooks.show', $ebook->id) }}">
                                                <i class="bx bx-show me-2"></i> View Details
                                            </a>
                                            <a class="dropdown-item" href="{{ route('admin.ebooks.edit', $ebook->id) }}">
                                                <i class="bx bx-edit me-2"></i> Edit
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('admin.ebooks.destroy', $ebook->id) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this ebook?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="bx bx-trash me-2"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr id="noDataRow">
                                <td colspan="8" class="text-center py-5">
                                    <i class="bx bx-book" style="font-size: 48px; color: #ddd;"></i>
                                    <p class="mt-2 text-muted">No ebooks found</p>
                                    <a href="{{ route('admin.ebooks.create') }}" class="btn btn-sm btn-primary">Add Your
                                        First Ebook</a>
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
                        <div class="col-md-6 col-lg-4 col-xl-3 ebook-card" data-status="{{ $ebook->status }}">
                            <div class="card h-100 shadow-sm">
                                @if ($ebook->cover_image)
                                    <img src="{{ asset('storage/' . $ebook->cover_image) }}" class="card-img-top"
                                        alt="{{ $ebook->title }}" style="height: 250px; object-fit: cover;">
                                @else
                                    <div class="bg-label-secondary d-flex align-items-center justify-content-center"
                                        style="height: 250px;">
                                        <i class="bx bx-book" style="font-size: 72px;"></i>
                                    </div>
                                @endif
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title mb-0">{{ Str::limit($ebook->title, 30) }}</h5>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm btn-icon" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.ebooks.show', $ebook->id) }}">
                                                    <i class="bx bx-show me-2"></i> View
                                                </a>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.ebooks.edit', $ebook->id) }}">
                                                    <i class="bx bx-edit me-2"></i> Edit
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <form action="{{ route('admin.ebooks.destroy', $ebook->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Delete this ebook?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="bx bx-trash me-2"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-muted small mb-2">by {{ $ebook->author ?? 'Unknown' }}</p>
                                    <p class="card-text small text-muted">
                                        {{ Str::limit(strip_tags($ebook->description), 80) }}</p>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div>
                                            <span class="badge bg-label-info"><i class="bx bx-file"></i>
                                                {{ $ebook->page_count ?? 0 }} pages</span>
                                        </div>
                                        <div>
                                            @if ($ebook->status === 'published')
                                                <span class="badge bg-success">Published</span>
                                            @elseif($ebook->status === 'draft')
                                                <span class="badge bg-warning">Draft</span>
                                            @else
                                                <span class="badge bg-secondary">Archived</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="mt-2 small text-muted">
                                        <i class="bx bx-show"></i> {{ number_format($ebook->view_count ?? 0) }} views
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <i class="bx bx-book" style="font-size: 48px; color: #ddd;"></i>
                            <p class="mt-2 text-muted">No ebooks found</p>
                            <a href="{{ route('admin.ebooks.create') }}" class="btn btn-sm btn-primary">Add Your First
                                Ebook</a>
                        </div>
                    @endforelse
                </div>
            </div>

            @if ($ebooks->hasPages())
                <div class="card-footer">
                    {{ $ebooks->links() }}
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            // View toggle
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
                } else {
                    tableView.style.display = 'none';
                    cardView.style.display = 'block';
                    btnTable.classList.remove('active');
                    btnCard.classList.add('active');
                    localStorage.setItem('ebookView', 'card');
                }
            }

            // Load saved view preference
            document.addEventListener('DOMContentLoaded', function() {
                const savedView = localStorage.getItem('ebookView') || 'table';
                toggleView(savedView);
            });

            // Search functionality
            document.getElementById('searchEbook')?.addEventListener('keyup', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                filterEbooks();
            });

            // Filter functionality
            document.getElementById('filterStatus')?.addEventListener('change', filterEbooks);

            function filterEbooks() {
                const searchTerm = document.getElementById('searchEbook').value.toLowerCase();
                const statusFilter = document.getElementById('filterStatus').value;

                // Filter table rows
                const tableRows = document.querySelectorAll('#ebookTableBody tr:not(#noDataRow)');
                let visibleTableCount = 0;

                tableRows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    const status = row.dataset.status;

                    const matchSearch = text.includes(searchTerm);
                    const matchStatus = !statusFilter || status === statusFilter;

                    if (matchSearch && matchStatus) {
                        row.style.display = '';
                        visibleTableCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Filter cards
                const cards = document.querySelectorAll('.ebook-card');
                let visibleCardCount = 0;

                cards.forEach(card => {
                    const text = card.textContent.toLowerCase();
                    const status = card.dataset.status;

                    const matchSearch = text.includes(searchTerm);
                    const matchStatus = !statusFilter || status === statusFilter;

                    if (matchSearch && matchStatus) {
                        card.style.display = '';
                        visibleCardCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });
            }
        </script>
    @endpush
@endsection
