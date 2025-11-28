@extends('layouts.admin')

@section('title', 'Generate Payment Link')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Payment /</span> Generate Payment Link
        </h4>

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Payment Link Information</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.payment-links.generate') }}" method="POST">
                            @csrf

                            <div class="alert alert-info" role="alert">
                                <h6 class="alert-heading mb-2">
                                    <i class="bx bx-info-circle me-1"></i> Cara Kerja Payment Link
                                </h6>
                                <ul class="mb-0 ps-3">
                                    <li>Admin generate link pembayaran untuk user</li>
                                    <li>Link dikirim ke user via WhatsApp atau email</li>
                                    <li>User klik link dan melakukan pembayaran via Mayar.id</li>
                                    <li>Subscription otomatis aktif setelah pembayaran berhasil</li>
                                </ul>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="user_id">Select User <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('user_id') is-invalid @enderror" id="user_id"
                                    name="user_id" required>
                                    <option value="">Choose a user...</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="plan_id">Subscription Plan <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('plan_id') is-invalid @enderror" id="plan_id"
                                    name="plan_id" required>
                                    <option value="">Choose a plan...</option>
                                    @foreach ($plans as $plan)
                                        <option value="{{ $plan->id }}" data-duration="{{ $plan->duration_days }}"
                                            data-price="{{ $plan->price }}"
                                            {{ old('plan_id') == $plan->id ? 'selected' : '' }}>
                                            {{ $plan->name }} - {{ $plan->duration_days }} days (Rp
                                            {{ number_format($plan->price, 0, ',', '.') }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('plan_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="notes">Notes (Optional)</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3"
                                    placeholder="Add notes for this payment (e.g., request via WhatsApp, promo code used)">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="bx bx-link me-1"></i> Generate Payment Link
                                </button>
                                <a href="{{ route('admin.payment-links.index') }}" class="btn btn-outline-secondary">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Payment Preview</h5>
                        <hr>
                        <div id="preview-info">
                            <div class="mb-3">
                                <small class="text-muted d-block">User</small>
                                <strong id="preview-user">Not selected</strong>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted d-block">Plan</small>
                                <strong id="preview-plan">Not selected</strong>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted d-block">Amount</small>
                                <strong id="preview-amount" class="text-primary">Rp 0</strong>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted d-block">Link Expires In</small>
                                <strong>24 hours</strong>
                            </div>
                        </div>
                        <hr>
                        <div class="alert alert-warning mb-0" role="alert">
                            <small>
                                <i class="bx bx-time me-1"></i>
                                Payment link akan expired dalam 24 jam. Pastikan user segera melakukan pembayaran.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userSelect = document.getElementById('user_id');
            const planSelect = document.getElementById('plan_id');

            userSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const userName = selectedOption.text;
                document.getElementById('preview-user').textContent = userName !== 'Choose a user...' ?
                    userName : 'Not selected';
            });

            planSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const planName = selectedOption.text.split(' - ')[0];
                const price = selectedOption.dataset.price;

                if (planName !== 'Choose a plan...') {
                    document.getElementById('preview-plan').textContent = planName;
                    document.getElementById('preview-amount').textContent = 'Rp ' + new Intl.NumberFormat(
                        'id-ID').format(price);
                } else {
                    document.getElementById('preview-plan').textContent = 'Not selected';
                    document.getElementById('preview-amount').textContent = 'Rp 0';
                }
            });
        });
    </script>
@endpush
