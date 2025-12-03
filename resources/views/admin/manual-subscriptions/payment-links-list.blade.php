@extends('layouts.admin')

@section('title', 'Payment Links')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">Payment /</span> Payment Links
            </h4>
            <a href="{{ route('admin.payment-links.create') }}" class="btn btn-primary">
                <i class="bx bx-plus me-1"></i> Generate Payment Link
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
                    <div class="col-md-6">
                        <h5 class="mb-0">All Payment Links</h5>
                    </div>
                    <div class="col-md-6">
                        <form method="GET" action="{{ route('admin.payment-links.index') }}">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-search"></i></span>
                                <input type="text" class="form-control" name="search"
                                    placeholder="Search by invoice, user name, or email..." value="{{ $search ?? '' }}">
                                <button type="submit" class="btn btn-primary">Search</button>
                                @if ($search)
                                    <a href="{{ route('admin.payment-links.index') }}"
                                        class="btn btn-outline-secondary">Clear</a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Invoice Number</th>
                            <th>User</th>
                            <th>Plan</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Expires At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($paymentLinks as $link)
                            <tr>
                                <td>
                                    <strong>{{ $link->invoice_number }}</strong>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-semibold">{{ $link->user->name }}</span>
                                        <small class="text-muted">{{ $link->user->email }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-label-info">{{ $link->plan->name }}</span>
                                </td>
                                <td>Rp {{ number_format($link->amount, 0, ',', '.') }}</td>
                                <td>
                                    @if ($link->status === 'pending')
                                        @if ($link->isExpired())
                                            <span class="badge bg-danger">Expired</span>
                                        @else
                                            <span class="badge bg-warning">Pending</span>
                                        @endif
                                    @elseif ($link->status === 'paid')
                                        <span class="badge bg-success">Paid</span>
                                    @elseif ($link->status === 'cancelled')
                                        <span class="badge bg-secondary">Cancelled</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($link->status) }}</span>
                                    @endif
                                </td>
                                <td>{{ $link->created_at->format('d M Y') }}</td>
                                <td>
                                    {{ $link->expires_at->format('d M Y') }}
                                    @if ($link->expires_at->isFuture() && $link->status === 'pending')
                                        <br><small class="text-warning">{{ $link->expires_at->diffForHumans() }}</small>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item"
                                                href="{{ route('admin.manual-subscriptions.payment-link.show', $link->id) }}">
                                                <i class="bx bx-show me-1"></i> View Details
                                            </a>
                                            @if ($link->payment_url && $link->status === 'pending' && !$link->isExpired())
                                                <a class="dropdown-item" href="#"
                                                    onclick="copyLink('{{ $link->payment_url }}'); return false;">
                                                    <i class="bx bx-copy me-1"></i> Copy Link
                                                </a>
                                                <a class="dropdown-item" href="{{ $link->payment_url }}" target="_blank">
                                                    <i class="bx bx-link-external me-1"></i> Open Link
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="bx bx-info-circle mb-2" style="font-size: 2rem;"></i>
                                        <p>No payment links found.</p>
                                        <a href="{{ route('admin.payment-links.create') }}" class="btn btn-sm btn-primary">
                                            Generate First Payment Link
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($paymentLinks->hasPages())
                <div class="card-footer">
                    {{ $paymentLinks->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function copyLink(url) {
            navigator.clipboard.writeText(url).then(function() {
                alert('Payment link copied to clipboard!');
            }, function() {
                // Fallback
                const input = document.createElement('input');
                input.value = url;
                document.body.appendChild(input);
                input.select();
                document.execCommand('copy');
                document.body.removeChild(input);
                alert('Payment link copied to clipboard!');
            });
        }
    </script>
@endpush
