@extends('layouts.admin')

@section('title', __('admin.orders.detail_title'))

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin.menu.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">{{ __('admin.orders.title') }}</a></li>
            <li class="breadcrumb-item active">{{ __('admin.common.detail') }}</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><span class="text-muted fw-light">{{ __('admin.orders.title') }} /</span> {{ __('admin.orders.detail_title') }}</h4>
            <p class="text-muted mb-0">{{ __('admin.orders.title') }} #{{ $order->order_number ?? $order->id }}</p>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
            <i class="bx bx-arrow-back me-1"></i> {{ __('admin.common.back') }}
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <!-- Order Info -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('admin.orders.order_info') }}</h5>
                    @php
                        $statusColors = [
                            'pending' => 'warning',
                            'processing' => 'info',
                            'completed' => 'success',
                            'cancelled' => 'danger',
                            'refunded' => 'secondary'
                        ];
                        $statusColor = $statusColors[$order->status] ?? 'secondary';
                    @endphp
                    <span class="badge bg-{{ $statusColor }}">{{ ucfirst($order->status) }}</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">{{ __('admin.orders.order_id') }}</label>
                            <p class="fw-semibold mb-0">#{{ $order->order_number ?? $order->id }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">{{ __('admin.orders.order_date') }}</label>
                            <p class="fw-semibold mb-0">{{ $order->created_at->format('d F Y H:i') }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">{{ __('admin.common.total') }}</label>
                            <p class="fw-semibold mb-0 text-primary">Rp {{ number_format($order->total_amount ?? 0, 0, ',', '.') }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">{{ __('admin.orders.payment_method') }}</label>
                            <p class="fw-semibold mb-0">{{ $order->payment_method ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            @if($order->items && $order->items->count() > 0)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('admin.orders.order_items') }}</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('admin.common.item') }}</th>
                                    <th class="text-center">{{ __('admin.common.quantity') }}</th>
                                    <th class="text-end">{{ __('admin.common.price') }}</th>
                                    <th class="text-end">{{ __('admin.common.subtotal') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            <span class="fw-semibold">{{ $item->name ?? __('admin.orders.unknown_item') }}</span>
                                            @if($item->ebook)
                                                <br><small class="text-muted">{{ $item->ebook->title }}</small>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $item->quantity ?? 1 }}</td>
                                        <td class="text-end">Rp {{ number_format($item->price ?? 0, 0, ',', '.') }}</td>
                                        <td class="text-end">Rp {{ number_format(($item->price ?? 0) * ($item->quantity ?? 1), 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end fw-semibold">{{ __('admin.common.total') }}</td>
                                    <td class="text-end fw-bold text-primary">Rp {{ number_format($order->total_amount ?? 0, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <!-- Update Status -->
            @can('orders.manage')
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('admin.orders.update_status') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="row g-3">
                        @csrf
                        <div class="col-md-8">
                            <select name="status" class="form-select">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>{{ __('admin.status.pending') }}</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>{{ __('admin.status.processing') }}</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>{{ __('admin.status.completed') }}</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>{{ __('admin.status.cancelled') }}</option>
                                <option value="refunded" {{ $order->status == 'refunded' ? 'selected' : '' }}>{{ __('admin.status.refunded') }}</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bx bx-refresh me-1"></i> {{ __('admin.orders.update_status') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endcan
        </div>

        <!-- User Info -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('admin.orders.customer_info') }}</h5>
                </div>
                <div class="card-body text-center">
                    <div class="avatar avatar-xl mx-auto mb-3">
                        @if($order->user && $order->user->profile_photo)
                            <img src="{{ asset('storage/' . $order->user->profile_photo) }}" alt="Avatar" class="rounded-circle">
                        @else
                            <span class="avatar-initial rounded-circle bg-primary fs-1">
                                {{ strtoupper(substr($order->user->name ?? 'U', 0, 1)) }}
                            </span>
                        @endif
                    </div>
                    <h5 class="mb-1">{{ $order->user->name ?? __('admin.common.unknown') }}</h5>
                    <p class="text-muted mb-3">{{ $order->user->email ?? '-' }}</p>
                    
                    @if($order->user)
                        <a href="{{ route('admin.users.show', $order->user->id) }}" class="btn btn-outline-primary btn-sm">
                            <i class="bx bx-user me-1"></i> {{ __('admin.actions.view_profile') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
