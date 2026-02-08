@extends('layouts.admin')

@section('title', __('admin.pricing_benefits.title'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ __('admin.pricing_benefits.success_alert') }}</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ __('admin.pricing_benefits.error_alert') }}</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold py-3 mb-2">
                    <span class="text-muted fw-light">{{ __('admin.menu.website_management') }} /</span> {{ __('admin.pricing_benefits.page_title') }}
                </h4>
                <p class="text-muted">{{ __('admin.pricing_benefits.subtitle') }}</p>
            </div>
            <div>
                <a href="{{ route('admin.about-us.create') }}" class="btn btn-primary">
                    <i class="ti ti-plus me-1"></i> {{ __('admin.pricing_benefits.add_new') }}
                </a>
            </div>
        </div>

        <!-- Benefits List -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ __('admin.pricing_benefits.list_benefits') }}</h5>
                <small class="text-muted">{{ __('admin.pricing_benefits.total_benefits', ['count' => $benefits->count()]) }}</small>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="ti ti-info-circle me-2"></i>
                    <strong>{{ __('admin.pricing_benefits.tips_title') }}:</strong> {{ __('admin.pricing_benefits.tips_drag_drop') }}
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="3%"></th>
                                <th width="5%">{{ __('admin.pricing_benefits.order') }}</th>
                                <th width="10%">{{ __('admin.pricing_benefits.icon') }}</th>
                                <th width="20%">{{ __('admin.pricing_benefits.title_column') }}</th>
                                <th width="37%">{{ __('admin.pricing_benefits.description') }}</th>
                                <th width="10%" class="text-center">{{ __('admin.pricing_benefits.status') }}</th>
                                <th width="15%" class="text-center">{{ __('admin.pricing_benefits.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody id="sortable-benefits">
                            @forelse($benefits as $benefit)
                                <tr data-id="{{ $benefit->id }}" style="cursor: move;">
                                    <td class="text-center">
                                        <i class="ti ti-grip-vertical text-muted" style="font-size: 1.2rem;"></i>
                                    </td>
                                    <td>
                                        <span class="badge" style="background-color: rgba(255, 76, 97, 0.16); color: #FF4C61; font-weight: 600;">{{ $benefit->sort_order }}</span>
                                    </td>
                                    <td>
                                        <div class="icon-preview" style="font-size: 2rem; color: #FF4C61;">
                                            <i class="{{ $benefit->icon }}"></i>
                                        </div>
                                    </td>
                                    <td>
                                        <strong>{{ $benefit->title }}</strong>
                                    </td>
                                    <td>
                                        <small>{{ Str::limit($benefit->description, 100) }}</small>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check form-switch d-inline-block">
                                            <input class="form-check-input status-toggle" 
                                                   type="checkbox" 
                                                   data-id="{{ $benefit->id }}" 
                                                   {{ $benefit->status === 'active' ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm btn-icon" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('admin.about-us.edit', $benefit->id) }}">
                                                        <i class="ti ti-edit me-2"></i> {{ __('admin.pricing_benefits.edit') }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li>
                                                    <form action="{{ route('admin.about-us.destroy', $benefit->id) }}" 
                                                          method="POST" 
                                                          class="delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="dropdown-item text-danger delete-btn">
                                                            <i class="ti ti-trash me-2"></i> {{ __('admin.pricing_benefits.delete') }}
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="mb-3">
                                            <i class="ti ti-clipboard-off" style="font-size: 3rem; color: #ddd;"></i>
                                        </div>
                                        <p class="text-muted mb-0">{{ __('admin.pricing_benefits.no_benefits') }}</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Information Card -->
        <!-- <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title mb-3">
                    <i class="ti ti-info-circle me-2"></i>
                    Informasi Icon
                </h5>
                <div class="alert alert-warning mb-3">
                    <i class="ti ti-alert-triangle me-2"></i>
                    <strong>Penting!</strong> Hanya gunakan <strong>Bootstrap Icons</strong> (format: <code>bi bi-nama</code>). 
                    Icon library lain seperti Tabler Icons atau Font Awesome tidak tersedia di halaman pricing.
                </div>
                <p class="mb-2"><strong>Bootstrap Icons</strong> yang tersedia:</p>
                <ul class="mb-3">
                    <li class="mb-2">
                        <code>bi bi-globe-americas</code>, <code>bi bi-book</code>, <code>bi bi-heart</code>
                    </li>
                    <li class="mb-2">
                        <code>bi bi-star</code>, <code>bi bi-award</code>, <code>bi bi-shield-check</code>
                    </li>
                    <li>
                        <code>bi bi-people</code>, <code>bi bi-map</code>, <code>bi bi-lightning</code>
                    </li>
                </ul>
                <a href="https://icons.getbootstrap.com/" target="_blank" class="btn btn-sm btn-primary w-100">
                    <i class="ti ti-external-link me-1"></i> Lihat Semua Bootstrap Icons (2000+)
                </a>
            </div>
        </div> -->
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Initialize Sortable for drag & drop
        const sortable = new Sortable(document.getElementById('sortable-benefits'), {
            animation: 150,
            handle: '.ti-grip-vertical',
            ghostClass: 'sortable-ghost',
            onEnd: function() {
                updateOrder();
            }
        });

        // Update order after drag & drop
        function updateOrder() {
            const benefits = [];
            $('#sortable-benefits tr').each(function(index) {
                const id = $(this).data('id');
                if (id) {
                    benefits.push({
                        id: id,
                        sort_order: index + 1
                    });
                }
            });

            $.ajax({
                url: '{{ route("admin.about-us.update-order") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    benefits: benefits
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        // Update badge numbers
                        $('#sortable-benefits tr').each(function(index) {
                            $(this).find('.badge').text(index + 1);
                        });
                    }
                },
                error: function(xhr) {
                    toastr.error('{{ __('admin.pricing_benefits.update_order_failed') }}');
                }
            });
        }

        // Toggle status
        $(document).on('change', '.status-toggle', function(e) {
            e.preventDefault();
            
            const checkbox = $(this);
            const benefitId = checkbox.data('id');
            const newStatus = checkbox.is(':checked');
            
            // Disable checkbox while processing
            checkbox.prop('disabled', true);
            
            $.ajax({
                url: `/admin/about-us/${benefitId}/toggle-status`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        // Keep the current state
                        checkbox.prop('disabled', false);
                    } else {
                        // Revert on error
                        checkbox.prop('checked', !newStatus);
                        checkbox.prop('disabled', false);
                        alert('{{ __('admin.pricing_benefits.toggle_status_failed') }}');
                    }
                },
                error: function(xhr) {
                    // Revert on error
                    checkbox.prop('checked', !newStatus);
                    checkbox.prop('disabled', false);
                    alert('{{ __('admin.pricing_benefits.toggle_status_failed') }}: ' + (xhr.responseJSON?.message || 'Server error'));
                }
            });
        });

        // Delete confirmation
        $('.delete-btn').on('click', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            
            Swal.fire({
                title: '{{ __('admin.pricing_benefits.delete_confirm_title') }}',
                text: "{{ __('admin.pricing_benefits.delete_confirm_text') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '{{ __('admin.pricing_benefits.delete_confirm_button') }}',
                cancelButtonText: '{{ __('admin.pricing_benefits.cancel') }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>

<style>
    .sortable-ghost {
        opacity: 0.4;
        background-color: #f8f9fa;
    }
    
    #sortable-benefits tr {
        transition: all 0.3s ease;
    }

    .icon-preview {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #fff5f5;
        border-radius: 50%;
    }
</style>
@endpush
