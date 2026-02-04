@extends('layouts.admin')

@section('title', __('admin.manual_subscription.create'))

@section('styles')
    <style>
        /* FIXED HERE */
        #user-suggestions,
        #plan-suggestions {
            background-color: #ffffff !important;
            border-radius: 8px;
            margin-top: 4px;
            border: 1px solid #d9dee3;
            position: absolute;
            z-index: 2000 !important;
        }

        /* FIXED HERE – FORCE NON-TRANSPARENT */
        #user-suggestions .list-group-item.list-group-item,
        #plan-suggestions .list-group-item.list-group-item {
            background-color: #ffffff !important;
            border: none;
            border-bottom: 1px solid #f0f2f5;
            padding: 12px 16px;
            cursor: pointer;
            transition: all 0.2s ease;
            color: #212529;
            backdrop-filter: none !important;
        }

        #user-suggestions .list-group-item:last-child,
        #plan-suggestions .list-group-item:last-child {
            border-bottom: none;
        }

        /* Hover Effect */
        #user-suggestions .list-group-item:hover,
        #plan-suggestions .list-group-item:hover {
            background-color: #f0f3ff !important;
            transform: translateX(4px);
        }

        #user-suggestions .list-group-item:first-child,
        #plan-suggestions .list-group-item:first-child {
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        #user-suggestions .list-group-item:last-child,
        #plan-suggestions .list-group-item:last-child {
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
        }

        /* Search input focus */
        #user-search:focus,
        #plan-search:focus {
            border-color: #696cff;
            box-shadow: 0 0 0 0.2rem rgba(105, 108, 255, 0.25);
        }
    </style>
@endsection

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">{{ __('admin.menu.subscription_management') }} / {{ __('admin.menu.manual_subscriptions') }} /</span> {{ __('admin.actions.add') }}
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
                    <h5 class="mb-0">{{ __('admin.manual_subscription.subscription_info') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.manual-subscriptions.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label" for="user_search">{{ __('admin.manual_subscription.select_user') }} <span
                                    class="text-danger">*</span></label>

                            <input type="hidden" id="user_id" name="user_id" value="{{ old('user_id') }}">

                            <div class="position-relative">
                                <input type="text" class="form-control @error('user_id') is-invalid @enderror"
                                    id="user_search" placeholder="{{ __('admin.manual_subscription.search_user') }}"
                                    autocomplete="off" value="{{ old('user_search') }}">

                                <div id="search-loading" class="position-absolute top-50 end-0 translate-middle-y me-3"
                                    style="display: none;">
                                    <div class="spinner-border spinner-border-sm text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>

                                <!-- Suggestions -->
                                <div id="user-suggestions" class="list-group w-100 shadow-lg"
                                    style="display: none; max-height: 300px; overflow-y: auto;"></div>
                            </div>

                            @error('user_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror

                            <div class="form-text">{{ __('admin.manual_subscription.search_hint') }}</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="plan_search">{{ __('admin.manual_subscription.subscription_plan') }} <span
                                    class="text-danger">*</span></label>

                            <input type="hidden" id="subscription_plan_id" name="subscription_plan_id" value="{{ old('subscription_plan_id') }}">

                            <div class="position-relative">
                                <input type="text" class="form-control @error('subscription_plan_id') is-invalid @enderror"
                                    id="plan_search" placeholder="{{ __('admin.manual_subscription.search_plan') }}"
                                    autocomplete="off" value="{{ old('plan_search') }}">

                                <div id="plan-loading" class="position-absolute top-50 end-0 translate-middle-y me-3"
                                    style="display: none;">
                                    <div class="spinner-border spinner-border-sm text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>

                                <!-- Suggestions -->
                                <div id="plan-suggestions" class="list-group w-100 shadow-lg"
                                    style="display: none; max-height: 300px; overflow-y: auto;"></div>
                            </div>

                            @error('subscription_plan_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror

                            <div class="form-text">{{ __('admin.manual_subscription.plan_search_hint') }}</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="quantity">{{ __('admin.manual_subscription.quantity') }} <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                id="quantity" name="quantity" min="1" max="12"
                                value="{{ old('quantity', 1) }}" required>
                            <div class="form-text">{{ __('admin.manual_subscription.quantity_help') }}
                            </div>
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="card bg-light-info mb-3" id="subscription-summary" style="display: none;">
                            <div class="card-body">
                                <h6 class="card-title mb-2">{{ __('admin.manual_subscription.subscription_summary') }}</h6>
                                <div class="row">
                                    <div class="col-6">
                                        <small class="text-muted">{{ __('admin.manual_subscription.plan_duration') }}:</small>
                                        <div class="fw-semibold" id="plan-duration">-</div>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Quantity:</small>
                                        <div class="fw-semibold" id="plan-quantity">-</div>
                                    </div>
                                    <div class="col-6 mt-2">
                                        <small class="text-muted">Total Duration:</small>
                                        <div class="fw-bold text-primary" id="total-duration">-</div>
                                    </div>
                                    <div class="col-6 mt-2">
                                        <small class="text-muted">Total Amount:</small>
                                        <div class="fw-bold text-success" id="total-amount">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <h6 class="alert-heading mb-2"><i class="bx bx-info-circle me-1"></i> Information</h6>
                            <ul class="mb-0 ps-3">
                                <li>Subscription will start immediately upon creation</li>
                                <li>End date will be calculated automatically</li>
                                <li>Status will be "Active"</li>
                                <li>User will receive a unique subscription code</li>
                            </ul>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="bx bx-check me-1"></i> Create Subscription
                            </button>
                            <a href="{{ route('admin.manual-subscriptions.index') }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Preview card -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('admin.manual_subscription.subscription_preview') }}</h5>
                    <hr>
                    <div id="preview-info">
                        <div class="mb-3"><small class="text-muted d-block">{{ __('admin.manual_subscription.user') }}</small><strong id="preview-user">{{ __('admin.manual_subscription.not_selected') }}
                                </strong></div>
                        <div class="mb-3"><small class="text-muted d-block">{{ __('admin.manual_subscription.plan') }}</small><strong id="preview-plan">{{ __('admin.manual_subscription.not_selected') }}
                                </strong></div>
                        <div class="mb-3"><small class="text-muted d-block">{{ __('admin.manual_subscription.duration') }}</small><strong
                                id="preview-duration">-</strong></div>
                        <div class="mb-3"><small class="text-muted d-block">{{ __('admin.manual_subscription.amount') }}</small><strong
                                id="preview-amount">Rp 0</strong></div>
                        <div class="mb-3"><small class="text-muted d-block">{{ __('admin.manual_subscription.start_date') }}
                                </small><strong>{{ now()->format('d M Y') }}</strong></div>
                        <div class="mb-3"><small class="text-muted d-block">{{ __('admin.manual_subscription.end_date') }}</small><strong
                                id="preview-end-date">-</strong></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const userSearchInput = document.getElementById('user_search');
            const userIdInput = document.getElementById('user_id');
            const suggestionsDiv = document.getElementById('user-suggestions');
            const loadingIndicator = document.getElementById('search-loading');

            const planSearchInput = document.getElementById('plan_search');
            const planIdInput = document.getElementById('subscription_plan_id');
            const planSuggestionsDiv = document.getElementById('plan-suggestions');
            const planLoadingIndicator = document.getElementById('plan-loading');

            let searchTimeout;
            let planSearchTimeout;
            let selectedUserId = null;
            let selectedPlanId = null;
            let selectedPlanData = null;

            // USER SEARCH FUNCTIONALITY
            userSearchInput.addEventListener('input', function() {
                const query = this.value.trim();
                clearTimeout(searchTimeout);

                if (query.length < 2) {
                    suggestionsDiv.style.display = 'none';
                    suggestionsDiv.innerHTML = '';
                    userIdInput.value = '';
                    document.getElementById('preview-user').textContent = '{{ __('admin.manual_subscription.not_selected') }}';
                    return;
                }

                loadingIndicator.style.display = 'block';

                searchTimeout = setTimeout(() => {
                    fetch(
                            `{{ route('admin.manual-subscriptions.search-users') }}?q=${encodeURIComponent(query)}`)
                        .then(response => response.json())
                        .then(users => {
                            loadingIndicator.style.display = 'none';
                            displaySuggestions(users);
                        })
                        .catch(() => {
                            loadingIndicator.style.display = 'none';
                            suggestionsDiv.innerHTML =
                                '<div class="list-group-item text-danger">{{ __('admin.messages.error_loading') }}</div>';
                            suggestionsDiv.style.display = 'block';
                        });
                }, 300);
            });

            function displaySuggestions(users) {
                suggestionsDiv.innerHTML = '';

                if (users.length === 0) {
                    suggestionsDiv.innerHTML = '<div class="list-group-item text-muted">{{ __('admin.users.no_users_found') }}</div>';
                    suggestionsDiv.style.display = 'block';
                    return;
                }

                users.forEach(user => {
                    const item = document.createElement('a');
                    item.href = '#';
                    item.className = 'list-group-item list-group-item-action';
                    item.innerHTML = `
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-sm me-2">
                        <span class="avatar-initial rounded-circle bg-label-primary">
                            ${user.name.charAt(0).toUpperCase()}
                        </span>
                    </div>
                    <div>
                        <div class="fw-medium">${user.name}</div>
                        <small class="text-muted">${user.email}</small>
                    </div>
                </div>
            `;

                    item.addEventListener('click', e => {
                        e.preventDefault();
                        selectUser(user);
                    });

                    suggestionsDiv.appendChild(item);
                });

                suggestionsDiv.style.display = 'block';
            }

            function selectUser(user) {
                selectedUserId = user.id;
                userIdInput.value = user.id;
                userSearchInput.value = `${user.name} (${user.email})`;
                suggestionsDiv.style.display = 'none';

                document.getElementById('preview-user').textContent = `${user.name} (${user.email})`;
            }

            // PLAN SEARCH FUNCTIONALITY
            planSearchInput.addEventListener('focus', function() {
                // Load all plans on focus if no search query
                if (this.value.trim() === '') {
                    searchPlans('');
                }
            });

            planSearchInput.addEventListener('input', function() {
                const query = this.value.trim();
                clearTimeout(planSearchTimeout);

                planLoadingIndicator.style.display = 'block';

                planSearchTimeout = setTimeout(() => {
                    searchPlans(query);
                }, 300);
            });

            function searchPlans(query) {
                fetch(`{{ route('admin.manual-subscriptions.search-plans') }}?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(plans => {
                        planLoadingIndicator.style.display = 'none';
                        displayPlanSuggestions(plans);
                    })
                    .catch(() => {
                        planLoadingIndicator.style.display = 'none';
                        planSuggestionsDiv.innerHTML =
                            '<div class="list-group-item text-danger">{{ __('admin.messages.error_loading') }}</div>';
                        planSuggestionsDiv.style.display = 'block';
                    });
            }

            function displayPlanSuggestions(plans) {
                planSuggestionsDiv.innerHTML = '';

                if (plans.length === 0) {
                    planSuggestionsDiv.innerHTML = '<div class="list-group-item text-muted">No plans found</div>';
                    planSuggestionsDiv.style.display = 'block';
                    return;
                }

                plans.forEach(plan => {
                    const item = document.createElement('a');
                    item.href = '#';
                    item.className = 'list-group-item list-group-item-action';
                    item.innerHTML = `
                <div class="d-flex align-items-center justify-content-between">
                    <div class="flex-grow-1">
                        <div class="fw-medium">${plan.name}</div>
                        <small class="text-muted">${plan.duration_days} days • ${plan.category_subscription ? plan.category_subscription.charAt(0).toUpperCase() + plan.category_subscription.slice(1) : 'N/A'}</small>
                    </div>
                    <div class="text-end">
                        <div class="fw-semibold text-success">Rp ${new Intl.NumberFormat('id-ID').format(plan.price)}</div>
                    </div>
                </div>
            `;

                    item.addEventListener('click', e => {
                        e.preventDefault();
                        selectPlan(plan);
                    });

                    planSuggestionsDiv.appendChild(item);
                });

                planSuggestionsDiv.style.display = 'block';
            }

            function selectPlan(plan) {
                selectedPlanId = plan.id;
                selectedPlanData = plan;
                planIdInput.value = plan.id;
                planSearchInput.value = `${plan.name} - ${plan.duration_days} days (Rp ${new Intl.NumberFormat('id-ID').format(plan.price)})`;
                planSuggestionsDiv.style.display = 'none';

                updateSubscriptionSummary();
            }

            // Close dropdowns when clicking outside
            document.addEventListener('click', function(e) {
                if (!userSearchInput.contains(e.target) && !suggestionsDiv.contains(e.target)) {
                    suggestionsDiv.style.display = 'none';
                }
                if (!planSearchInput.contains(e.target) && !planSuggestionsDiv.contains(e.target)) {
                    planSuggestionsDiv.style.display = 'none';
                }
            });

            function updateSubscriptionSummary() {
                const quantityInput = document.getElementById('quantity');

                if (selectedPlanData && quantityInput.value) {
                    const duration = parseInt(selectedPlanData.duration_days);
                    const price = parseFloat(selectedPlanData.price);
                    const quantity = parseInt(quantityInput.value);
                    const planName = selectedPlanData.name;

                    const totalDuration = duration * quantity;
                    const totalAmount = price * quantity;

                    document.getElementById('plan-duration').textContent = duration + ' days';
                    document.getElementById('plan-quantity').textContent = quantity + 'x';
                    document.getElementById('total-duration').textContent = totalDuration + ' days';
                    document.getElementById('total-amount').textContent = 'Rp ' + new Intl.NumberFormat('id-ID')
                        .format(totalAmount);
                    document.getElementById('subscription-summary').style.display = 'block';

                    // Update preview
                    document.getElementById('preview-plan').textContent = planName + ' (' + quantity + 'x)';
                    document.getElementById('preview-duration').textContent = totalDuration + ' days';
                    document.getElementById('preview-amount').textContent = 'Rp ' + new Intl.NumberFormat('id-ID')
                        .format(totalAmount);

                    const startDate = new Date();
                    const endDate = new Date(startDate);
                    endDate.setDate(endDate.getDate() + totalDuration);
                    document.getElementById('preview-end-date').textContent = endDate.toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    });
                } else {
                    document.getElementById('subscription-summary').style.display = 'none';
                    document.getElementById('preview-plan').textContent = '{{ __('admin.manual_subscription.not_selected') }}';
                    document.getElementById('preview-duration').textContent = '-';
                    document.getElementById('preview-amount').textContent = 'Rp 0';
                    document.getElementById('preview-end-date').textContent = '-';
                }
            }

            document.getElementById('quantity').addEventListener('input', updateSubscriptionSummary);

        });
    </script>
@endpush
