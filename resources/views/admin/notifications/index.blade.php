@extends('layouts.admin')

@section('title', __('admin.notifications.title'))

@section('content')
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">{{ __('admin.notifications.title') }}</h4>
            <p class="text-muted mb-0">{{ __('admin.notifications.description') }}</p>
        </div>
        <div>
            <button type="button" class="btn btn-outline-primary" id="markAllRead">
                <i class="ti ti-mail-opened me-1"></i>
                {{ __('admin.notifications.mark_all_read') }}
            </button>
        </div>
    </div>

    <!-- Notifications Card -->
    <div class="card">
        <div class="card-body">
            @if($notifications->count() > 0)
                <div class="list-group list-group-flush">
                    @foreach($notifications as $userNotification)
                        @php
                            $notification = $userNotification->notification;
                            $iconMap = [
                                'success' => 'ti-check',
                                'info' => 'ti-info-circle',
                                'warning' => 'ti-alert-triangle',
                                'danger' => 'ti-alert-circle',
                                'order' => 'ti-shopping-cart',
                                'user' => 'ti-user',
                                'ebook' => 'ti-book'
                            ];
                            $colorMap = [
                                'success' => 'success',
                                'info' => 'info',
                                'warning' => 'warning',
                                'danger' => 'danger',
                                'order' => 'primary',
                                'user' => 'secondary',
                                'ebook' => 'info'
                            ];
                            $icon = $iconMap[$notification->icon] ?? 'ti-bell';
                            $color = $colorMap[$notification->icon] ?? 'secondary';
                        @endphp
                        
                        <div class="list-group-item list-group-item-action {{ !$userNotification->is_read ? 'bg-label-primary' : '' }}" 
                             data-id="{{ $userNotification->id }}">
                            <div class="d-flex w-100">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar">
                                        <span class="avatar-initial rounded-circle bg-label-{{ $color }}">
                                            <i class="ti {{ $icon }}"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="mb-0 {{ !$userNotification->is_read ? 'fw-bold' : '' }}">
                                            {{ $notification->title }}
                                        </h6>
                                        <div class="d-flex align-items-center">
                                            @if(!$userNotification->is_read)
                                                <span class="badge badge-dot bg-primary me-2"></span>
                                            @endif
                                            <small class="text-muted">{{ $userNotification->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                    <p class="mb-2 text-body">{{ $notification->message }}</p>
                                    <div class="d-flex gap-2">
                                        @if($notification->action_url)
                                            <a href="{{ $notification->action_url }}" class="btn btn-sm btn-outline-primary">
                                                <i class="ti ti-external-link me-1"></i>
                                                {{ __('admin.notifications.view_details') }}
                                            </a>
                                        @endif
                                        @if(!$userNotification->is_read)
                                            <button type="button" class="btn btn-sm btn-outline-secondary mark-as-read" 
                                                    data-id="{{ $userNotification->id }}">
                                                <i class="ti ti-check me-1"></i>
                                                {{ __('admin.notifications.mark_read') }}
                                            </button>
                                        @endif
                                        <button type="button" class="btn btn-sm btn-outline-danger delete-notification" 
                                                data-id="{{ $userNotification->id }}">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $notifications->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="ti ti-bell-off" style="font-size: 4rem; color: var(--bs-gray-400);"></i>
                    <h5 class="text-muted mt-3">{{ __('admin.notifications.no_notifications') }}</h5>
                    <p class="text-muted">{{ __('admin.notifications.no_notifications_desc') }}</p>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Mark single notification as read
        $('.mark-as-read').click(function() {
            const notifId = $(this).data('id');
            const $item = $(this).closest('.list-group-item');
            
            $.ajax({
                url: '/admin/notifications/' + notifId + '/mark-as-read',
                method: 'POST',
                success: function() {
                    $item.removeClass('bg-label-primary');
                    $item.find('.fw-bold').removeClass('fw-bold');
                    $item.find('.badge-dot').remove();
                    $item.find('.mark-as-read').remove();
                    toastr.success('{{ __('admin.notifications.marked_read') }}');
                }
            });
        });

        // Mark all as read
        $('#markAllRead').click(function() {
            $.ajax({
                url: '{{ route('admin.notifications.mark-all-as-read') }}',
                method: 'POST',
                success: function(response) {
                    toastr.success(response.message);
                    location.reload();
                }
            });
        });

        // Delete notification
        $('.delete-notification').click(function() {
            const notifId = $(this).data('id');
            const $item = $(this).closest('.list-group-item');
            
            if (confirm('{{ __('admin.notifications.confirm_delete') }}')) {
                $.ajax({
                    url: '/admin/notifications/' + notifId,
                    method: 'DELETE',
                    success: function(response) {
                        $item.fadeOut(300, function() {
                            $(this).remove();
                            
                            // Check if no notifications left
                            if ($('.list-group-item').length === 0) {
                                location.reload();
                            }
                        });
                        toastr.success(response.message);
                    }
                });
            }
        });
    });
</script>
@endpush
