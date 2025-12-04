@extends('layouts.admin')

@section('title', 'Promo Management')

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">Promo Management</h4>
                <p class="text-muted mb-0">Manage subscription promo codes and discounts</p>
            </div>
            <a href="{{ route('admin.promos.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i> Create New Promo
            </a>
        </div>

        <!-- Alert Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="ti ti-check"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="ti ti-x"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Promo List Card -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">All Promos</h5>
                <span class="badge bg-label-primary">Total: {{ $promos->total() }}</span>
            </div>
            <div class="card-datatable table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Type</th>
                            <th>Value</th>
                            <th>Date Range</th>
                            <th>Usage</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($promos as $index => $promo)
                            <tr>
                                <td>{{ $promos->firstItem() + $index }}</td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-medium">{{ $promo->name }}</span>
                                        @if ($promo->description)
                                            <small class="text-muted">{{ Str::limit($promo->description, 50) }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if ($promo->code)
                                        <span class="badge bg-label-secondary">{{ $promo->code }}</span>
                                    @else
                                        <span class="text-muted">Auto-apply</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($promo->type === 'percentage')
                                        <span class="badge bg-label-info"><i class="ti ti-percentage"></i> Percentage</span>
                                    @elseif($promo->type === 'fixed_amount')
                                        <span class="badge bg-label-success"><i class="ti ti-currency-dollar"></i>
                                            Fixed</span>
                                    @elseif($promo->type === 'free_trial')
                                        <span class="badge bg-label-warning"><i class="ti ti-gift"></i> Free Trial</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="fw-medium">
                                        @if ($promo->type === 'percentage')
                                            {{ $promo->value }}%
                                        @elseif($promo->type === 'fixed_amount')
                                            ${{ number_format($promo->value, 2) }}
                                        @else
                                            {{ $promo->value }} days
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <div><i class="ti ti-calendar-event"></i>
                                            {{ $promo->start_date->format('M d, Y') }}</div>
                                        <div><i class="ti ti-calendar-x"></i> {{ $promo->end_date->format('M d, Y') }}
                                        </div>
                                    </small>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <small class="text-muted mb-1">{{ $promo->current_usage }} /
                                            {{ $promo->max_usage ?? '∞' }}</small>
                                        <div class="progress" style="height: 6px;">
                                            @php
                                                $percentage = $promo->max_usage
                                                    ? min(100, ($promo->current_usage / $promo->max_usage) * 100)
                                                    : 0;
                                            @endphp
                                            <div class="progress-bar {{ $percentage >= 100 ? 'bg-danger' : 'bg-primary' }}"
                                                role="progressbar" style="width: {{ $percentage }}%"
                                                aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input toggle-status" type="checkbox"
                                            id="status-{{ $promo->id }}" data-id="{{ $promo->id }}"
                                            {{ $promo->is_active ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status-{{ $promo->id }}"></label>
                                    </div>
                                    @if ($promo->is_active)
                                        <span class="badge bg-label-success">Active</span>
                                    @else
                                        <span class="badge bg-label-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.promos.edit', $promo->id) }}"
                                            class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light"
                                            data-bs-toggle="tooltip" title="Edit">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <button type="button"
                                            class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light"
                                            onclick="deletePromo('{{ $promo->id }}', '{{ $promo->name }}')"
                                            data-bs-toggle="tooltip" title="Delete">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Hidden delete form -->
                                    <form id="delete-form-{{ $promo->id }}"
                                        action="{{ route('admin.promos.destroy', $promo->id) }}" method="POST"
                                        class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <div class="mb-4">
                                        <i class="ti ti-ticket-off" style="font-size: 4rem; color: var(--bs-gray-400);"></i>
                                    </div>
                                    <h5 class="text-muted mb-2">No promos found</h5>
                                    <p class="text-muted mb-3">Create your first promo to get started!</p>
                                    <a href="{{ route('admin.promos.create') }}" class="btn btn-primary">
                                        <i class="ti ti-plus me-1"></i> Create Promo
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($promos->hasPages())
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <div class="text-muted">
                        Showing {{ $promos->firstItem() }} to {{ $promos->lastItem() }} of {{ $promos->total() }} promos
                    </div>
                    <div>
                        {{ $promos->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            // Toggle Status AJAX
            $(document).on('change', '.toggle-status', function() {
                const checkbox = $(this);
                const promoId = checkbox.data('id');
                const isActive = checkbox.is(':checked');
                const badge = checkbox.closest('td').find('.badge');

                $.ajax({
                    url: `/admin/promos/${promoId}/toggle-active`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update badge
                            if (response.is_active) {
                                badge.removeClass('bg-label-secondary').addClass('bg-label-success').text(
                                    'Active');
                            } else {
                                badge.removeClass('bg-label-success').addClass('bg-label-secondary').text(
                                    'Inactive');
                            }

                            // Show toast notification
                            toastr.success(response.message);
                        }
                    },
                    error: function(xhr) {
                        // Revert checkbox
                        checkbox.prop('checked', !isActive);
                        toastr.error('Failed to update status');
                    }
                });
            });

            // Delete Promo
            function deletePromo(id, name) {
                Swal.fire({
                    title: 'Are you sure?',
                    html: `You are about to delete promo "<strong>${name}</strong>".<br>This action cannot be undone.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel',
                    customClass: {
                        confirmButton: 'btn btn-danger me-2',
                        cancelButton: 'btn btn-secondary'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form-' + id).submit();
                    }
                });
            }

            // Initialize tooltips
            document.addEventListener('DOMContentLoaded', function() {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            });
        </script>
    @endpush
@endsection
