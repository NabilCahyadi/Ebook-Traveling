@extends('layouts.admin')

@section('title', 'Payment Link Details')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Payment /</span> Payment Link Details
        </h4>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Payment Link Information</h5>
                        <div>
                            @if ($paymentLink->status === 'pending')
                                @if ($paymentLink->isExpired())
                                    <span class="badge bg-danger">Expired</span>
                                @else
                                    <span class="badge bg-warning">Pending Payment</span>
                                @endif
                            @elseif ($paymentLink->status === 'paid')
                                <span class="badge bg-success">Paid</span>
                            @elseif ($paymentLink->status === 'cancelled')
                                <span class="badge bg-secondary">Cancelled</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($paymentLink->status) }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <strong>Invoice Number:</strong>
                            </div>
                            <div class="col-sm-8">
                                <span class="badge bg-label-primary"
                                    style="font-size: 0.9rem;">{{ $paymentLink->invoice_number }}</span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <strong>Payment Link:</strong>
                            </div>
                            <div class="col-sm-8">
                                @if ($paymentLink->payment_url)
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="paymentUrl"
                                            value="{{ $paymentLink->payment_url }}" readonly>
                                        <button class="btn btn-outline-primary" type="button" onclick="copyToClipboard()">
                                            <i class="bx bx-copy me-1"></i> Copy
                                        </button>
                                        <a href="{{ $paymentLink->payment_url }}" target="_blank"
                                            class="btn btn-outline-secondary">
                                            <i class="bx bx-link-external me-1"></i> Open
                                        </a>
                                    </div>
                                    <small class="text-muted">Kirim link ini ke user via WhatsApp atau email</small>
                                @else
                                    <span class="text-danger">Link generation failed</span>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <strong>User:</strong>
                            </div>
                            <div class="col-sm-8">
                                <div class="d-flex flex-column">
                                    <span>{{ $paymentLink->user->name }}</span>
                                    <small class="text-muted">{{ $paymentLink->user->email }}</small>
                                    @if ($paymentLink->user->phone)
                                        <small class="text-muted">{{ $paymentLink->user->phone }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <strong>Plan:</strong>
                            </div>
                            <div class="col-sm-8">
                                <span class="badge bg-label-info">{{ $paymentLink->plan->name }}</span>
                                <div class="mt-1">
                                    <small class="text-muted">{{ $paymentLink->plan->duration_days }} days</small>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <strong>Amount:</strong>
                            </div>
                            <div class="col-sm-8">
                                <strong class="text-primary">Rp
                                    {{ number_format($paymentLink->amount, 0, ',', '.') }}</strong>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <strong>Created At:</strong>
                            </div>
                            <div class="col-sm-8">
                                {{ $paymentLink->created_at->format('d M Y, H:i') }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <strong>Expires At:</strong>
                            </div>
                            <div class="col-sm-8">
                                {{ $paymentLink->expires_at->format('d M Y, H:i') }}
                                @if ($paymentLink->expires_at->isFuture())
                                    <small class="text-warning d-block">
                                        ({{ $paymentLink->expires_at->diffForHumans() }})
                                    </small>
                                @else
                                    <small class="text-danger d-block">
                                        (Expired {{ $paymentLink->expires_at->diffForHumans() }})
                                    </small>
                                @endif
                            </div>
                        </div>

                        @if ($paymentLink->paid_at)
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <strong>Paid At:</strong>
                                </div>
                                <div class="col-sm-8">
                                    {{ $paymentLink->paid_at->format('d M Y, H:i') }}
                                </div>
                            </div>
                        @endif

                        @if ($paymentLink->payment_method)
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <strong>Payment Method:</strong>
                                </div>
                                <div class="col-sm-8">
                                    {{ is_array($paymentLink->payment_method) ? json_encode($paymentLink->payment_method) : $paymentLink->payment_method }}
                                </div>
                            </div>
                        @endif

                        @if ($paymentLink->notes)
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <strong>Notes:</strong>
                                </div>
                                <div class="col-sm-8">
                                    {{ $paymentLink->notes }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            @if ($paymentLink->payment_url && $paymentLink->status === 'pending' && !$paymentLink->isExpired())
                                <button type="button" class="btn btn-primary" onclick="shareViaWhatsApp()">
                                    <i class="bx bxl-whatsapp me-1"></i> Share via WhatsApp
                                </button>
                            @endif

                            <a href="{{ route('admin.payment-links.index') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-list-ul me-1"></i> View All Payment Links
                            </a>

                            <a href="{{ route('admin.payment-links.create') }}" class="btn btn-outline-primary">
                                <i class="bx bx-plus me-1"></i> Generate New Link
                            </a>
                        </div>
                    </div>
                </div>

                @if ($paymentLink->status === 'pending' && !$paymentLink->isExpired())
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Status Check</h6>
                            <p class="text-muted small">Payment link masih aktif. User dapat melakukan pembayaran hingga
                                link expired.</p>
                            <button type="button" class="btn btn-sm btn-outline-info w-100" onclick="checkPaymentStatus()">
                                <i class="bx bx-refresh me-1"></i> Check Status
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function copyToClipboard() {
            const input = document.getElementById('paymentUrl');
            input.select();
            document.execCommand('copy');

            // Show alert
            alert('Payment link copied to clipboard!');
        }

        function shareViaWhatsApp() {
            const url = document.getElementById('paymentUrl').value;
            const userName = '{{ $paymentLink->user->name }}';
            const planName = '{{ $paymentLink->plan->name }}';
            const amount = 'Rp {{ number_format($paymentLink->amount, 0, ',', '.') }}';
            const phone = '{{ $paymentLink->user->phone ?? '' }}';

            const message =
                `Halo ${userName},\n\nBerikut link pembayaran untuk subscription ${planName}:\n\nJumlah: ${amount}\nLink: ${url}\n\nLink berlaku selama 24 jam. Silakan segera lakukan pembayaran.\n\nTerima kasih!`;

            let whatsappUrl = 'https://wa.me/';
            if (phone) {
                // Remove non-digit characters and add country code if needed
                const cleanPhone = phone.replace(/\D/g, '');
                const fullPhone = cleanPhone.startsWith('62') ? cleanPhone : '62' + cleanPhone.replace(/^0/, '');
                whatsappUrl += fullPhone + '?text=';
            } else {
                whatsappUrl += '?text=';
            }

            whatsappUrl += encodeURIComponent(message);
            window.open(whatsappUrl, '_blank');
        }

        function checkPaymentStatus() {
            // Refresh page to check latest status
            window.location.reload();
        }
    </script>
@endpush
