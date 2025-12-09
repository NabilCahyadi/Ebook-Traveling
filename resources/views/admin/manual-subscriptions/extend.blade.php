@extends('layouts.admin')

@section('title', 'Extend Subscription')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Subscription / Manual Subscriptions /</span> Extend
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
                    <div class="card-header">
                        <h5 class="mb-0">Extend Subscription</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info mb-4" role="alert">
                            <h6 class="alert-heading mb-2">
                                <i class="bx bx-info-circle me-1"></i> Current Subscription Details
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted d-block">User</small>
                                    <strong>{{ $subscription->user->name }}</strong>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted d-block">Plan</small>
                                    <strong>{{ $subscription->plan->name }}</strong>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <small class="text-muted d-block">Current End Date</small>
                                    <strong>{{ $subscription->end_date->format('d M Y') }}</strong>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <small class="text-muted d-block">Status</small>
                                    <span class="badge bg-success">{{ ucfirst($subscription->status) }}</span>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('admin.manual-subscriptions.process-extend', $subscription->id) }}"
                            method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label" for="subscription_plan_id">Select Subscription Plan <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('subscription_plan_id') is-invalid @enderror"
                                    id="subscription_plan_id" name="subscription_plan_id" required>
                                    <option value="">Choose a plan...</option>
                                    @foreach ($plans as $plan)
                                        <option value="{{ $plan->id }}" data-duration="{{ $plan->duration_days }}"
                                            data-price="{{ $plan->price }}"
                                            {{ old('subscription_plan_id') == $plan->id ? 'selected' : '' }}>
                                            {{ $plan->name }} - {{ $plan->duration_days }} days (Rp
                                            {{ number_format($plan->price, 0, ',', '.') }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('subscription_plan_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Select the plan duration to extend</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="quantity">Quantity <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                    id="quantity" name="quantity" min="1" max="12"
                                    value="{{ old('quantity', 1) }}" required>
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Number of subscription periods (e.g., 2 for 2 months if plan is 1
                                    month)</div>
                            </div>

                            <div class="card bg-light-info mb-3" id="extension-summary" style="display: none;">
                                <div class="card-body">
                                    <h6 class="card-title mb-2">Extension Summary</h6>
                                    <div class="row">
                                        <div class="col-6">
                                            <small class="text-muted">Plan Duration:</small>
                                            <div class="fw-semibold" id="ext-plan-duration">-</div>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Quantity:</small>
                                            <div class="fw-semibold" id="ext-quantity">-</div>
                                        </div>
                                        <div class="col-6 mt-2">
                                            <small class="text-muted">Total Extension:</small>
                                            <div class="fw-bold text-primary" id="ext-total-days">-</div>
                                        </div>
                                        <div class="col-6 mt-2">
                                            <small class="text-muted">Additional Amount:</small>
                                            <div class="fw-bold text-success" id="ext-total-amount">-</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="bx bx-check me-1"></i> Extend Subscription
                                </button>
                                <a href="{{ route('admin.manual-subscriptions.show', $subscription->id) }}"
                                    class="btn btn-outline-secondary">
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
                        <h5 class="card-title">Extension Preview</h5>
                        <hr>
                        <div class="mb-3">
                            <small class="text-muted d-block">Current End Date</small>
                            <strong>{{ $subscription->end_date->format('d M Y') }}</strong>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">Extension Days</small>
                            <strong id="preview-days">-</strong>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">New End Date</small>
                            <strong id="preview-new-end" class="text-primary">-</strong>
                        </div>
                        <hr>
                        <div class="alert alert-success mb-0" role="alert">
                            <small>
                                <i class="bx bx-info-circle me-1"></i>
                                The subscription will remain active and the end date will be extended.
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
            const planSelect = document.getElementById('subscription_plan_id');
            const quantityInput = document.getElementById('quantity');
            const currentEndDate = new Date('{{ $subscription->end_date->format('Y-m-d') }}');

            function updatePreview() {
                const selectedOption = planSelect.options[planSelect.selectedIndex];
                const quantity = parseInt(quantityInput.value) || 0;

                if (selectedOption.value && quantity > 0) {
                    const duration = parseInt(selectedOption.dataset.duration);
                    const price = parseFloat(selectedOption.dataset.price);
                    const totalDays = duration * quantity;
                    const totalAmount = price * quantity;

                    // Update summary card
                    document.getElementById('ext-plan-duration').textContent = duration + ' days';
                    document.getElementById('ext-quantity').textContent = quantity + 'x';
                    document.getElementById('ext-total-days').textContent = totalDays + ' days';
                    document.getElementById('ext-total-amount').textContent = 'Rp ' + new Intl.NumberFormat('id-ID')
                        .format(totalAmount);
                    document.getElementById('extension-summary').style.display = 'block';

                    // Update preview
                    document.getElementById('preview-days').textContent = totalDays + ' days';

                    const newEndDate = new Date(currentEndDate);
                    newEndDate.setDate(newEndDate.getDate() + totalDays);
                    const options = {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    };
                    document.getElementById('preview-new-end').textContent = newEndDate.toLocaleDateString('en-US',
                        options);
                } else {
                    document.getElementById('extension-summary').style.display = 'none';
                    document.getElementById('preview-days').textContent = '-';
                    document.getElementById('preview-new-end').textContent = '-';
                }
            }

            planSelect.addEventListener('change', updatePreview);
            quantityInput.addEventListener('input', updatePreview);
        });
    </script>
@endpush
