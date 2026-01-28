@extends('layouts.admin')

@section('title', __('admin.orders.title'))

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin.menu.dashboard') }}</a></li>
            <li class="breadcrumb-item active">{{ __('admin.orders.title') }}</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><span class="text-muted fw-light">{{ __('admin.orders.title') }} /</span> {{ __('admin.orders.list_title') }}</h4>
            <p class="text-muted mb-0">{{ __('admin.orders.manage_description') }}</p>
        </div>
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

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.orders.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">{{ __('admin.common.status') }}</label>
                    <select name="status" class="form-select">
                        <option value="">{{ __('admin.orders.all_status') }}</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">{{ __('admin.common.search') }}</label>
                    <input type="text" name="search" class="form-control" placeholder="{{ __('admin.orders.search_placeholder') }}" value="{{ request('search') }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button class="btn btn-primary me-2" type="submit">
                        <i class="bx bx-search me-1"></i> {{ __('admin.common.search') }}
                    </button>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                        <i class="bx bx-reset"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Orders List -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>{{ __('admin.orders.order_id') }}</th>
                            <th>{{ __('admin.common.user') }}</th>
                            <th>{{ __('admin.common.total') }}</th>
                            <th>{{ __('admin.common.status') }}</th>
                            <th>{{ __('admin.common.date') }}</th>
                            <th width="100">{{ __('admin.common.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $index => $order)
                            <tr>
                                <td>{{ $orders->firstItem() + $index }}</td>
                                <td>
                                    <span class="fw-semibold">#{{ $order->order_number ?? $order->id }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-2">
                                            <span class="avatar-initial rounded-circle bg-primary">
                                                {{ strtoupper(substr($order->user->name ?? 'U', 0, 1)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <span class="fw-semibold">{{ $order->user->name ?? __('admin.common.unknown') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-semibold">Rp {{ number_format($order->total_amount ?? 0, 0, ',', '.') }}</span>
                                </td>
                                <td>
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
                                </td>
                                <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bx bx-show"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="bx bx-package fs-1 text-muted mb-2"></i>
                                    <p class="mb-0 text-muted">{{ __('admin.orders.no_orders_found') }}</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($orders->hasPages())
                <div class="mt-4">
                    {{ $orders->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
