@extends('layouts.admin')

@section('title', __('admin.promos.title'))

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <div>
                <h4 class="mb-1">{{ __('admin.promos.title') }}</h4>
                <p class="text-muted mb-0">{{ __('admin.promos.description') }}</p>
            </div>
            <a href="{{ route('admin.promos.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i> {{ __('admin.promos.create_promo') }}
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
            <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
                <h5 class="mb-0">{{ __('admin.promos.all_promos') }}</h5>
                <span class="badge bg-label-primary">{{ __('admin.common.total') }}: {{ $promos->total() }}</span>
            </div>
            <div class="card-datatable table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('admin.form.name') }}</th>
                            <th>{{ __('admin.promos.code') }}</th>
                            <th class="d-none d-md-table-cell">{{ __('admin.promos.type') }}</th>
                            <th class="d-none d-md-table-cell">{{ __('admin.promos.value') }}</th>
                            <th class="d-none d-lg-table-cell">{{ __('admin.promos.date_range') }}</th>
                            <th class="d-none d-lg-table-cell">{{ __('admin.promos.usage') }}</th>
                            <th>{{ __('admin.form.status') }}</th>
                            <th>{{ __('admin.common.actions') }}</th>
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
                                        <span class="text-muted">{{ __('admin.promos.auto_apply') }}</span>
                                    @endif
                                </td>
                                <td class="d-none d-md-table-cell">
                                    @if ($promo->type === 'percentage')
                                        <span class="badge bg-label-info"><i class="ti ti-percentage"></i> {{ __('admin.promos.percentage') }}</span>
                                    @elseif($promo->type === 'fixed_amount')
                                        <span class="badge bg-label-success"><i class="ti ti-currency-dollar"></i>
                                            {{ __('admin.promos.fixed') }}</span>
                                    @elseif($promo->type === 'free_trial')
                                        <span class="badge bg-label-warning"><i class="ti ti-gift"></i> {{ __('admin.promos.free_trial') }}</span>
                                    @endif
                                </td>
                                <td class="d-none d-md-table-cell">
                                    <span class="fw-medium">
                                        @if ($promo->type === 'percentage')
                                            {{ $promo->value }}%
                                        @elseif($promo->type === 'fixed_amount')
                                            ${{ number_format($promo->value, 2) }}
                                        @else
                                            {{ $promo->value }} {{ __('admin.promos.days') }}
                                        @endif
                                    </span>
                                </td>
                                <td class="d-none d-lg-table-cell">
                                    <small class="text-muted">
                                        <div><i class="ti ti-calendar-event"></i>
                                            {{ $promo->start_date->format('M d, Y') }}</div>
                                        <div><i class="ti ti-calendar-x"></i> {{ $promo->end_date->format('M d, Y') }}
                                        </div>
                                    </small>
                                </td>
                                <td class="d-none d-lg-table-cell">
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
                                        <span class="badge bg-label-success">{{ __('admin.status.active') }}</span>
                                    @else
                                        <span class="badge bg-label-secondary">{{ __('admin.status.inactive') }}</span>
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
                                    <h5 class="text-muted mb-2">{{ __('admin.promos.no_promos') }}</h5>
                                    <p class="text-muted mb-3">{{ __('admin.promos.create_first_promo') }}</p>
                                    <a href="{{ route('admin.promos.create') }}" class="btn btn-primary">
                                        <i class="ti ti-plus me-1"></i> {{ __('admin.promos.create_promo') }}
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($promos->hasPages())
                <div class="card-footer d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                    <div class="text-muted">
                        {{ __('admin.common.showing_results', ['from' => $promos->firstItem(), 'to' => $promos->lastItem(), 'total' => $promos->total()]) }}
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
                                    '{{ __('admin.status.inactive') }}');
                            }

                            // Show toast notification
                            toastr.success(response.message);
                        }
                    },
                    error: function(xhr) {
                        // Revert checkbox
                        checkbox.prop('checked', !isActive);
                        toastr.error('{{ __('admin.messages.update_failed') }}');
                    }
                });
            });

            // Delete Promo
            function deletePromo(id, name) {
                Swal.fire({
                    title: '{{ __('admin.messages.are_you_sure') }}',
                    html: `{{ __('admin.promos.delete_confirm') }} "<strong>${name}</strong>".<br>{{ __('admin.messages.cannot_undo') }}`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '{{ __('admin.messages.yes_delete') }}',
                    cancelButtonText: '{{ __('admin.actions.cancel') }}',
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
