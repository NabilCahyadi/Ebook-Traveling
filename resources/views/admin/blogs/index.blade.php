@extends('layouts.admin')

@section('title', __('admin.blogs.title'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">{{ __('admin.menu.admin') }} /</span> {{ __('admin.blogs.title') }}
            </h4>
            <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">
                <i class="bx bx-plus me-1"></i> {{ __('admin.blogs.create_blog') }}
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
                <div class="row align-items-center g-3">
                    <div class="col-12 col-md-3">
                        <h5 class="mb-0">{{ __('admin.blogs.all_blogs') }}</h5>
                    </div>
                    <div class="col-12 col-md-9">
                        <div class="d-flex gap-2 justify-content-end align-items-center flex-wrap">
                            <!-- Filter Status -->
                            <select class="form-select form-select-sm" id="status" onchange="applyBlogFilters()" style="width: 130px;">
                                <option value="">{{ __('admin.blogs.all_status') }}</option>
                                <option value="draft" {{ $status == 'draft' ? 'selected' : '' }}>{{ __('admin.status.draft') }}</option>
                                <option value="published" {{ $status == 'published' ? 'selected' : '' }}>{{ __('admin.status.published') }}</option>
                                <option value="scheduled" {{ $status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                <option value="unpublished" {{ $status == 'unpublished' ? 'selected' : '' }}>{{ __('admin.status.unpublished') }}</option>
                            </select>

                            <!-- Filter Category -->
                            <select class="form-select form-select-sm" id="category" onchange="applyBlogFilters()" style="min-width: 120px; max-width: 150px;">
                                <option value="">{{ __('admin.blogs.all_categories') }}</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat }}" {{ $category == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- Search and Bulk Mode Toggle -->
                <div class="d-flex justify-content-between align-items-center mt-3 gap-2">
                    <div class="d-flex gap-2 flex-grow-1" style="max-width: 600px;">
                        <div class="input-group">
                            <span class="input-group-text"><i class="ti ti-search"></i></span>
                            <input type="text" class="form-control" placeholder="{{ __('admin.blogs.search_placeholder') }}" id="searchBlog" 
                                value="{{ $search ?? '' }}" onkeyup="applyBlogFilters()">
                        </div>
                        <select class="form-select" id="perPageBlog" onchange="changeBlogPerPage()" style="width: 130px;">
                            <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10 / page</option>
                            <option value="20" {{ request('per_page', 10) == 20 ? 'selected' : '' }}>20 / page</option>
                            <option value="30" {{ request('per_page', 10) == 30 ? 'selected' : '' }}>30 / page</option>
                            <option value="50" {{ request('per_page', 10) == 50 ? 'selected' : '' }}>50 / page</option>
                            <option value="100" {{ request('per_page', 10) == 100 ? 'selected' : '' }}>100 / page</option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="toggleBulkMode" onclick="toggleBulkMode()">
                        <i class="ti ti-checkbox me-1"></i> Select Multiple
                    </button>
                </div>

                <!-- Bulk Actions Bar -->
                <div id="bulkActionsBar" class="mt-3 p-3 bg-light rounded d-none">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div class="d-flex align-items-center">
                            <span class="me-3"><strong id="selectedCount">0</strong> item(s) selected</span>
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            <!-- Change Status Dropdown -->
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="ti ti-switch-horizontal me-1"></i> Change Status
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" onclick="bulkChangeStatus('draft')"><i class="ti ti-pencil me-2 text-warning"></i>Draft</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="bulkChangeStatus('published')"><i class="ti ti-check me-2 text-success"></i>Published</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="bulkChangeStatus('scheduled')"><i class="ti ti-clock me-2 text-info"></i>Scheduled</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="bulkChangeStatus('unpublished')"><i class="ti ti-eye-off me-2 text-secondary"></i>Unpublished</a></li>
                                </ul>
                            </div>
                            <!-- Delete Button -->
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="bulkDelete()">
                                <i class="ti ti-trash me-1"></i> Move to Trash
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if ($blogs->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="bulk-checkbox-column" style="width: 40px; display: none;">
                                        <input type="checkbox" class="form-check-input" id="selectAll" onclick="toggleSelectAll()">
                                    </th>
                                    <th>{{ __('admin.blogs.image') }}</th>
                                    <th>{{ __('admin.blogs.title') }}</th>
                                    <th>{{ __('admin.blogs.creator') }}</th>
                                    <th>{{ __('admin.blogs.category') }}</th>
                                    <th>{{ __('admin.blogs.status') }}</th>
                                    <th>{{ __('admin.blogs.published') }}</th>
                                    <th>{{ __('admin.actions.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($blogs as $blog)
                                    <tr>
                                        <td class="bulk-checkbox-column" style="display: none;">
                                            <input type="checkbox" class="form-check-input blog-checkbox" 
                                                value="{{ $blog->id }}" onchange="updateBulkActions()">
                                        </td>
                                        <td>
                                            @if ($blog->featured_image)
                                                @php
                                                    // Check if image is external URL or local storage
                                                    $imageUrl = filter_var($blog->featured_image, FILTER_VALIDATE_URL) 
                                                        ? $blog->featured_image 
                                                        : asset('storage/' . $blog->featured_image);
                                                @endphp
                                                <img src="{{ $imageUrl }}"
                                                    alt="{{ $blog->title }}" class="rounded"
                                                    style="width: 60px; height: 60px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                    style="width: 60px; height: 60px;">
                                                    <i class="bx bx-image text-muted fs-4"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <div>
                                                <strong>{{ Str::limit($blog->title, 30) }}</strong>
                                            </div>
                                            <small class="text-muted">{{ Str::limit($blog->slug, 35) }}</small>
                                        </td>
                                        <td>{{ $blog->author->name ?? __('admin.blogs.unknown') }}</td>
                                        <td>
                                            @if ($blog->category)
                                                <span class="badge bg-label-info">{{ $blog->category }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <!-- <td>
                                            <i class="bx bx-show me-1"></i>{{ number_format($blog->view_count) }}
                                        </td> -->
                                        <td>
                                            @if ($blog->status === 'published')
                                                <span class="badge bg-success">{{ __('admin.blogs.published') }}</span>
                                            @elseif($blog->status === 'draft')
                                                <span class="badge bg-warning">{{ __('admin.blogs.draft') }}</span>
                                            @elseif($blog->status === 'scheduled')
                                                <span class="badge bg-info"><i class="ti ti-clock me-1"></i>Scheduled</span>
                                            @elseif($blog->status === 'unpublished')
                                                <span class="badge bg-secondary">{{ __('admin.blogs.unpublished') }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ $blog->status ?: __('admin.blogs.unknown') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($blog->published_at)
                                                {{ $blog->published_at->format('d M Y') }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button"
                                                    class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.blogs.show', $blog->id) }}">
                                                        <i class="ti ti-eye me-2"></i> {{ __('admin.blogs.view') }}
                                                    </a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.blogs.edit', $blog->id) }}">
                                                        <i class="ti ti-pencil me-2"></i> {{ __('admin.blogs.edit') }}
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <form action="{{ route('admin.blogs.destroy', $blog->id) }}"
                                                        method="POST" style="display: none;"
                                                        id="delete-blog-{{ $blog->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <a class="dropdown-item text-danger" href="javascript:void(0);"
                                                        onclick="if(confirm('{{ __('admin.blogs.delete_confirm') }}')) document.getElementById('delete-blog-{{ $blog->id }}').submit();">
                                                        <i class="ti ti-trash me-2"></i> {{ __('admin.blogs.delete') }}
                                                    </a>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $blogs->appends(['status' => $status, 'category' => $category, 'search' => $search, 'per_page' => request('per_page', 10)])->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bx bx-news display-1 text-muted"></i>
                        <p class="mt-3 text-muted">{{ __('admin.blogs.no_blogs_found') }}</p>
                        <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">
                            <i class="bx bx-plus me-1"></i> {{ __('admin.blogs.create_new_blog') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Hidden forms for bulk actions -->
    <form id="bulkActionForm" action="{{ route('admin.blogs.bulk-action') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="action" id="bulkActionType">
        <div id="bulkActionIds"></div>
    </form>
    
    <form id="bulkDeleteForm" action="{{ route('admin.blogs.bulk-delete') }}" method="POST" style="display: none;">
        @csrf
        <div id="bulkDeleteIds"></div>
    </form>

    @push('scripts')
    <script>
        let isBulkMode = false;

        // Filter and Pagination Functions
        function applyBlogFilters() {
            const status = document.getElementById('status').value;
            const category = document.getElementById('category').value;
            const search = document.getElementById('searchBlog').value;
            const perPage = document.getElementById('perPageBlog').value;
            
            let url = new URL(window.location.href);
            url.searchParams.set('status', status);
            url.searchParams.set('category', category);
            url.searchParams.set('search', search);
            url.searchParams.set('per_page', perPage);
            
            window.location.href = url.toString();
        }

        function changeBlogPerPage() {
            applyBlogFilters();
        }

        // Bulk Mode Functions
        function toggleBulkMode() {
            const toggleBtn = document.getElementById('toggleBulkMode');
            isBulkMode = !isBulkMode;
            
            if (isBulkMode) {
                // Activate bulk mode
                document.querySelectorAll('.bulk-checkbox-column').forEach(el => {
                    el.style.display = '';
                });
                document.getElementById('bulkActionsBar').classList.remove('d-none');
                // Change button style to dark
                toggleBtn.classList.remove('btn-outline-secondary');
                toggleBtn.classList.add('btn-dark');
            } else {
                // Deactivate bulk mode
                clearSelection();
                document.querySelectorAll('.bulk-checkbox-column').forEach(el => {
                    el.style.display = 'none';
                });
                document.getElementById('bulkActionsBar').classList.add('d-none');
                // Change button style back to outline
                toggleBtn.classList.remove('btn-dark');
                toggleBtn.classList.add('btn-outline-secondary');
            }
        }

        function toggleSelectAll() {
            const selectAllCheckbox = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.blog-checkbox');
            checkboxes.forEach(cb => cb.checked = selectAllCheckbox.checked);
            updateBulkActions();
        }

        function updateBulkActions() {
            const checkboxes = document.querySelectorAll('.blog-checkbox:checked');
            const selectedCount = document.getElementById('selectedCount');
            const selectAllCheckbox = document.getElementById('selectAll');
            const allCheckboxes = document.querySelectorAll('.blog-checkbox');

            selectedCount.textContent = checkboxes.length;

            // Update "select all" checkbox state
            selectAllCheckbox.checked = checkboxes.length === allCheckboxes.length && allCheckboxes.length > 0;
            selectAllCheckbox.indeterminate = checkboxes.length > 0 && checkboxes.length < allCheckboxes.length;
        }

        function getSelectedIds() {
            const checkboxes = document.querySelectorAll('.blog-checkbox:checked');
            return Array.from(checkboxes).map(cb => cb.value);
        }

        function clearSelection() {
            document.getElementById('selectAll').checked = false;
            document.querySelectorAll('.blog-checkbox').forEach(cb => cb.checked = false);
            updateBulkActions();
        }

        function bulkChangeStatus(status) {
            const ids = getSelectedIds();
            if (ids.length === 0) {
                alert('Please select at least one blog');
                return;
            }

            const statusLabels = {
                'draft': 'Draft',
                'published': 'Published',
                'scheduled': 'Scheduled',
                'unpublished': 'Unpublished'
            };

            if (confirm(`Change status of ${ids.length} blog(s) to "${statusLabels[status]}"?`)) {
                const form = document.getElementById('bulkActionForm');
                document.getElementById('bulkActionType').value = status;
                
                const idsContainer = document.getElementById('bulkActionIds');
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
        }

        function bulkDelete() {
            const ids = getSelectedIds();
            if (ids.length === 0) {
                alert('Please select at least one blog');
                return;
            }

            if (confirm(`Move ${ids.length} blog(s) to trash?`)) {
                const form = document.getElementById('bulkDeleteForm');
                
                const idsContainer = document.getElementById('bulkDeleteIds');
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
        }
    </script>
    @endpush
@endsection
