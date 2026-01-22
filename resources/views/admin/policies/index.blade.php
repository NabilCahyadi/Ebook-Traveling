@extends('layouts.admin')

@section('title', 'Policy - ' . $pageTypeName)

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Success/Error Messages -->
        <!-- @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
         @endif -->

        <!-- @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif -->

        <!-- Page Header -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <div>
                <h4 class="fw-bold py-3 mb-2">
                    <span class="text-muted fw-light">{{ __('admin.menu.website_setting') }} / Policy /</span> {{ $pageTypeName }}
                </h4>
            </div>
            <div>
                @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission("website.policies-{$pageTypeSlug}.create"))
                <a href="{{ route("admin.policies.{$pageTypeSlug}.create") }}" class="btn btn-primary">
                    <i class="ti ti-plus me-1"></i> Add Section
                </a>
                @endif
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route("admin.policies.{$pageTypeSlug}.index") }}" method="GET">
                    <div class="row g-3">
                        <div class="col-12 col-md-8">
                            <label for="search" class="form-label">{{ __('admin.common.search') }}</label>
                            <input type="text" class="form-control" id="search" name="search"
                                value="{{ request('search') }}" placeholder="Search by title, subsection, or content...">
                        </div>
                        <div class="col-6 col-md-2">
                            <label for="per_page" class="form-label">{{ __('admin.common.per_page') }}</label>
                            <select class="form-select" id="per_page" name="per_page">
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-2 d-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <i class="ti ti-search"></i> <span class="d-none d-sm-inline">{{ __('admin.common.search') }}</span>
                            </button>
                            @if (request()->hasAny(['search']))
                                <a href="{{ route("admin.policies.{$pageTypeSlug}.index") }}" class="btn btn-label-secondary"
                                    title="{{ __('admin.common.clear_filters') }}">
                                    <i class="ti ti-x"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sections Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ $pageTypeName }} Sections</h5>
                <div class="text-muted">Total: {{ $sections->total() }} Sections</div>
            </div>
            <div class="card-body">
                @if ($sections->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover" id="sectionsTable">
                            <thead>
                                <tr>
                                    <th width="80">Order</th>
                                    <th>Section Title</th>
                                    <th>Subsection Title</th>
                                    <th class="d-none d-md-table-cell">Content Preview</th>
                                    <th width="120" class="d-none d-lg-table-cell">{{ __('admin.common.date_created') }}</th>
                                    <th width="80" class="text-center">{{ __('admin.common.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody id="sortableSections">
                                @foreach ($sections as $section)
                                    <tr data-id="{{ $section->id }}" style="cursor: move;">
                                        <td>
                                            @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission("website.policies-{$pageTypeSlug}.edit"))
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="ti ti-grip-vertical text-muted drag-handle" style="cursor: grab; font-size: 1.2rem;" title="Drag to reorder"></i>
                                                <span class="badge bg-label-secondary">{{ $section->order_index }}</span>
                                            </div>
                                            @else
                                            <span class="badge bg-label-secondary">{{ $section->order_index }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div style="max-width: 200px;">
                                                <strong>{{ $section->section_title ?? '-' }}</strong>
                                            </div>
                                        </td>
                                        <td>
                                            <div style="max-width: 200px;">
                                                {{ $section->subsection_title ?? '-' }}
                                            </div>
                                        </td>
                                        <td class="d-none d-md-table-cell">
                                            <div style="max-width: 300px;">
                                                {{ Str::limit($section->content, 80) }}
                                            </div>
                                        </td>
                                        <td class="d-none d-lg-table-cell">
                                            <small class="text-muted">{{ $section->created_at->format('d M Y') }}</small>
                                        </td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow" 
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical ti-md"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission("website.policies-{$pageTypeSlug}.edit"))
                                                    <a href="{{ route("admin.policies.{$pageTypeSlug}.edit", $section->id) }}" class="dropdown-item">
                                                        <i class="ti ti-edit me-2"></i>
                                                        {{ __('admin.common.edit') }}
                                                    </a>
                                                    @endif
                                                    
                                                    @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission("website.policies-{$pageTypeSlug}.delete"))
                                                    <button type="button" class="dropdown-item text-danger delete-section" data-id="{{ $section->id }}">
                                                        <i class="ti ti-trash me-2"></i>
                                                        {{ __('admin.common.delete') }}
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
                        {{ $sections->appends(request()->query())->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="ti ti-file-text ti-xl text-muted mb-3 d-block" style="font-size: 4rem;"></i>
                        <h5 class="text-muted">No sections found</h5>
                        <p class="text-muted">
                            @if (request()->has('search'))
                                No sections match your search criteria.
                            @else
                                Start by creating your first section.
                            @endif
                        </p>
                        @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission("website.policies-{$pageTypeSlug}.create"))
                        <a href="{{ route("admin.policies.{$pageTypeSlug}.create") }}" class="btn btn-primary mt-2">
                            <i class="ti ti-plus me-1"></i> Add First Section
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
            const pageTypeSlug = '{{ $pageTypeSlug }}';
            
            // Initialize SortableJS for drag-drop reordering
            @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission("website.policies-{$pageTypeSlug}.edit"))
            const sortable = new Sortable(document.getElementById('sortableSections'), {
                handle: '.drag-handle',
                animation: 150,
                ghostClass: 'bg-light',
                onEnd: function(evt) {
                    const rows = document.querySelectorAll('#sortableSections tr');
                    const orders = [];
                    
                    rows.forEach((row, index) => {
                        orders.push({
                            id: row.dataset.id,
                            order_index: index + 1
                        });
                    });
                    
                    // Send AJAX request to update order
                    $.ajax({
                        url: '{{ route("admin.policies.{$pageTypeSlug}.update-order") }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            orders: orders
                        },
                        success: function(response) {
                            if (response.success) {
                                // Update badge numbers
                                rows.forEach((row, index) => {
                                    row.querySelector('.badge').textContent = index + 1;
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Gagal memperbarui urutan. Silakan refresh halaman.'
                            });
                        }
                    });
                }
            });
            @endif
            
            // Delete section
            $(document).on('click', '.delete-section', function() {
                const id = $(this).data('id');
                
                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: 'Apakah Anda yakin ingin menghapus section ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/policies/${pageTypeSlug}/${id}`,
                            method: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    // Remove row from table
                                    $(`tr[data-id="${id}"]`).fadeOut(300, function() {
                                        $(this).remove();
                                    });
                                    
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Terhapus!',
                                        text: response.message,
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: xhr.responseJSON?.message || 'Gagal menghapus section.'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
