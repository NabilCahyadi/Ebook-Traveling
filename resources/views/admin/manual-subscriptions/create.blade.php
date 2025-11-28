@extends('layouts.admin')

@section('title', 'Create Manual Subscription')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Subscription / Manual Subscriptions /</span> Create
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
                        <h5 class="mb-0">Subscription Information</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.manual-subscriptions.store') }}" method="POST">
                            @csrf

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
                                <div class="form-text">Select the user who will receive this subscription</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="subscription_plan_id">Subscription Plan <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('subscription_plan_id') is-invalid @enderror" id="subscription_plan_id"
                                    name="subscription_plan_id" required>
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
                                <div class="form-text">Choose the subscription plan</div>
                            </div>

                            <div class="alert alert-info" role="alert">
                                <h6 class="alert-heading mb-2">
                                    <i class="bx bx-info-circle me-1"></i> Information
                                </h6>
                                <ul class="mb-0 ps-3">
                                    <li>Subscription will start immediately upon creation</li>
                                    <li>End date will be calculated based on the selected plan duration</li>
                                    <li>Status will be set to "Active" automatically</li>
                                    <li>User will receive a unique subscription code</li>
                                </ul>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="bx bx-check me-1"></i> Create Subscription
                                </button>
                                <a href="{{ route('admin.manual-subscriptions.index') }}"
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
                        <h5 class="card-title">Subscription Preview</h5>
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
                                <small class="text-muted d-block">Duration</small>
                                <strong id="preview-duration">-</strong>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted d-block">Amount</small>
                                <strong id="preview-amount">Rp 0</strong>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted d-block">Start Date</small>
                                <strong>{{ now()->format('d M Y') }}</strong>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted d-block">End Date</small>
                                <strong id="preview-end-date">-</strong>
                            </div>
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
            const planSelect = document.getElementById('subscription_plan_id');

            // Update preview when user changes
            userSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const userName = selectedOption.text;
                document.getElementById('preview-user').textContent = userName !== 'Choose a user...' ?
                    userName : 'Not selected';
            });

            // Update preview when plan changes
            planSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const planName = selectedOption.text.split(' - ')[0];
                const duration = selectedOption.dataset.duration;
                const price = selectedOption.dataset.price;

                if (planName !== 'Choose a plan...') {
                    document.getElementById('preview-plan').textContent = planName;
                    document.getElementById('preview-duration').textContent = duration + ' days';
                    document.getElementById('preview-amount').textContent = 'Rp ' + new Intl.NumberFormat(
                        'id-ID').format(price);

                    // Calculate end date
                    const startDate = new Date();
                    const endDate = new Date(startDate);
                    endDate.setDate(endDate.getDate() + parseInt(duration));

                    const options = {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    };
                    document.getElementById('preview-end-date').textContent = endDate.toLocaleDateString(
                        'en-US', options);
                } else {
                    document.getElementById('preview-plan').textContent = 'Not selected';
                    document.getElementById('preview-duration').textContent = '-';
                    document.getElementById('preview-amount').textContent = 'Rp 0';
                    document.getElementById('preview-end-date').textContent = '-';
                }
            });
        });
    </script>
@endpush
