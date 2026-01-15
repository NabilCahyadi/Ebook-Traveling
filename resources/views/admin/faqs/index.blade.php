@extends('layouts.admin')

@section('title', 'FAQ ' . $categoryName . ' Management')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold py-3 mb-2">
                    <span class="text-muted fw-light">Web Setting / FAQ /</span> {{ $categoryName }}
                </h4>
            </div>
            <div>
                @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission("website.faqs-{$categorySlug}.create"))
                <a href="{{ route("admin.faqs.{$categorySlug}.create") }}" class="btn btn-primary">
                    <i class="ti ti-plus me-1"></i> Add New FAQ
                </a>
                @endif
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route("admin.faqs.{$categorySlug}.index") }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label for="search" class="form-label">Search</label>
                            <input type="text" class="form-control" id="search" name="search"
                                value="{{ request('search') }}" placeholder="Search by question or answer...">
                        </div>
                        <div class="col-md-2">
                            <label for="per_page" class="form-label">Per Page</label>
                            <select class="form-select" id="per_page" name="per_page">
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <i class="ti ti-search"></i> Search
                            </button>
                            @if (request()->hasAny(['search']))
                                <a href="{{ route("admin.faqs.{$categorySlug}.index") }}" class="btn btn-label-secondary"
                                    title="Clear Filters">
                                    <i class="ti ti-x"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- FAQs Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ $categoryName }} FAQs</h5>
                <div class="text-muted">Total: {{ $faqs->total() }} FAQs</div>
            </div>
            <div class="card-body">
                @if ($faqs->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover" id="faqsTable">
                            <thead>
                                <tr>
                                    <th width="80">Order</th>
                                    <th>Question</th>
                                    <th>Answer</th>
                                    <th width="100">Status</th>
                                    <th width="120">Created</th>
                                    <th width="80" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="sortableFaqs">
                                @foreach ($faqs as $faq)
                                    <tr data-id="{{ $faq->id }}" style="cursor: move;">
                                        <td>
                                            @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission("website.faqs-{$categorySlug}.edit"))
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="ti ti-grip-vertical text-muted drag-handle" style="cursor: grab; font-size: 1.2rem;" title="Drag to reorder"></i>
                                                <span class="badge bg-label-secondary">{{ $faq->order_index }}</span>
                                            </div>
                                            @else
                                            <span class="badge bg-label-secondary">{{ $faq->order_index }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div style="max-width: 300px;">
                                                <strong>{{ Str::limit($faq->question, 80) }}</strong>
                                            </div>
                                        </td>
                                        <td>
                                            <div style="max-width: 400px;">
                                                {{ Str::limit($faq->answer, 80) }}
                                            </div>
                                        </td>
                                        <td>
                                            @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission("website.faqs-{$categorySlug}.edit"))
                                            <div class="form-check form-switch">
                                                <input class="form-check-input status-toggle" type="checkbox" 
                                                    data-id="{{ $faq->id }}" 
                                                    {{ $faq->is_active ? 'checked' : '' }}>
                                            </div>
                                            @else
                                            <span class="badge {{ $faq->is_active ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $faq->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                            @endif
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ $faq->created_at->format('d M Y') }}</small>
                                        </td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow" 
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical ti-md"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission("website.faqs-{$categorySlug}.edit"))
                                                    <a href="{{ route("admin.faqs.{$categorySlug}.edit", $faq->id) }}" class="dropdown-item">
                                                        <i class="ti ti-edit me-2"></i>
                                                        Edit
                                                    </a>
                                                    @endif
                                                    
                                                    @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission("website.faqs-{$categorySlug}.delete"))
                                                    <button type="button" class="dropdown-item text-danger delete-faq" data-id="{{ $faq->id }}">
                                                        <i class="ti ti-trash me-2"></i>
                                                        Delete
                                                    </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $faqs->appends(request()->query())->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="ti ti-help-circle ti-xl text-muted mb-3 d-block" style="font-size: 4rem;"></i>
                        <h5 class="text-muted">No FAQs found</h5>
                        <p class="text-muted">
                            @if (request()->has('search'))
                                No FAQs match your search criteria.
                            @else
                                Start by adding your first FAQ for {{ $categoryName }}.
                            @endif
                        </p>
                        @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission("website.faqs-{$categorySlug}.create"))
                        <a href="{{ route("admin.faqs.{$categorySlug}.create") }}" class="btn btn-primary mt-2">
                            <i class="ti ti-plus me-1"></i> Add First FAQ
                        </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- SortableJS for drag & drop -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    
    <script>
        $(document).ready(function() {
            const categorySlug = '{{ $categorySlug }}';
            
            // Initialize SortableJS for drag-drop reordering
            @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission("website.faqs-{$categorySlug}.edit"))
            const sortable = new Sortable(document.getElementById('sortableFaqs'), {
                handle: '.drag-handle',
                animation: 150,
                onEnd: function(evt) {
                    let orders = [];
                    $('#sortableFaqs tr').each(function(index) {
                        orders.push({
                            id: $(this).data('id'),
                            order_index: index + 1
                        });
                    });

                    // Send AJAX request to update order
                    $.ajax({
                        url: `/admin/faqs/${categorySlug}/update-order`,
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            orders: orders
                        },
                        success: function(response) {
                            if (response.success) {
                                // Update order badges
                                $('#sortableFaqs tr').each(function(index) {
                                    $(this).find('.badge.bg-label-secondary').text(index + 1);
                                });
                                
                                // Show success message
                                showToast('success', response.message);
                            }
                        },
                        error: function(xhr) {
                            showToast('error', 'Failed to update order');
                        }
                    });
                }
            });
            @endif

            // Toggle Status
            $('.status-toggle').on('change', function() {
                const faqId = $(this).data('id');
                const isChecked = $(this).is(':checked');

                $.ajax({
                    url: `/admin/faqs/${categorySlug}/${faqId}/toggle-status`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            showToast('success', response.message);
                        }
                    },
                    error: function(xhr) {
                        // Revert checkbox on error
                        $(this).prop('checked', !isChecked);
                        showToast('error', 'Failed to update status');
                    }
                });
            });

            // Delete FAQ
            $('.delete-faq').on('click', function() {
                const faqId = $(this).data('id');
                const row = $(this).closest('tr');

                if (confirm('Are you sure you want to delete this FAQ?')) {
                    $.ajax({
                        url: `/admin/faqs/${categorySlug}/${faqId}`,
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                row.fadeOut(300, function() {
                                    $(this).remove();
                                    // Update total count
                                    location.reload();
                                });
                                showToast('success', response.message);
                            }
                        },
                        error: function(xhr) {
                            showToast('error', 'Failed to delete FAQ');
                        }
                    });
                }
            });

            // Helper function to show toast messages
            function showToast(type, message) {
                const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
                const alertHtml = `
                    <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                        <strong>${type === 'success' ? 'Success!' : 'Error!'}</strong> ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
                $('.container-xxl').prepend(alertHtml);
                
                // Auto dismiss after 3 seconds
                setTimeout(function() {
                    $('.alert').fadeOut(300, function() {
                        $(this).remove();
                    });
                }, 3000);
            }
        });
    </script>
@endpush
