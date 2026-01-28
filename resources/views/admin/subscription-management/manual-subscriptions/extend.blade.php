@extends('layouts.admin')

@section('title', __('admin.extend_subscription.title'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">{{ __('admin.menu.subscription') }} / {{ __('admin.menu.manual_subscriptions') }} /</span> {{ __('admin.extend_subscription.breadcrumb') }}
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
                        <h5 class="mb-0">{{ __('admin.extend_subscription.title') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info mb-4" role="alert">
                            <h6 class="alert-heading mb-2">
                                <i class="bx bx-info-circle me-1"></i> {{ __('admin.extend_subscription.current_details') }}
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted d-block">{{ __('admin.extend_subscription.user') }}</small>
                                    <strong>{{ $subscription->user->name }}</strong>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted d-block">{{ __('admin.extend_subscription.plan') }}</small>
                                    <strong>{{ $subscription->plan->name }}</strong>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <small class="text-muted d-block">{{ __('admin.extend_subscription.current_end_date') }}</small>
                                    <strong>{{ $subscription->end_date->format('d M Y') }}</strong>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <small class="text-muted d-block">{{ __('admin.extend_subscription.status') }}</small>
                                    <span class="badge bg-success">{{ ucfirst($subscription->status) }}</span>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <small class="text-muted d-block">{{ __('admin.extend_subscription.category') }}</small>
                                    <span class="badge bg-primary" id="current-category" data-category="{{ $subscription->plan->category_subscription ?? '' }}">
                                        {{ translateCategorySubscription($subscription->plan->category_subscription) }}
                                    </span>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <small class="text-muted d-block">{{ __('admin.extend_subscription.remaining_days') }}</small>
                                    <strong id="remaining-days">
                                        @php
                                            $remainingDays = floor(now()->diffInDays($subscription->end_date, false));
                                            $remainingDays = max(0, $remainingDays);
                                        @endphp
                                        {{ $remainingDays }} {{ __('admin.extend_subscription.days') }}
                                    </strong>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('admin.manual-subscriptions.process-extend', $subscription->id) }}"
                            method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label" for="subscription_plan_id">{{ __('admin.extend_subscription.select_plan') }} <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('subscription_plan_id') is-invalid @enderror"
                                    id="subscription_plan_id" name="subscription_plan_id" required>
                                    <option value="">{{ __('admin.extend_subscription.choose_plan') }}</option>
                                    @foreach ($plans as $plan)
                                        <option value="{{ $plan->id }}" 
                                            data-duration="{{ $plan->duration_days }}"
                                            data-price="{{ $plan->price }}"
                                            data-category="{{ $plan->category_subscription }}"
                                            {{ old('subscription_plan_id') == $plan->id ? 'selected' : '' }}>
                                            {{ $plan->name }} - {{ $plan->duration_days }} {{ __('admin.extend_subscription.days') }} (Rp
                                            {{ number_format($plan->price, 0, ',', '.') }}) [{{ translateCategorySubscription($plan->category_subscription) }}]
                                        </option>
                                    @endforeach
                                </select>
                                @error('subscription_plan_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">{{ __('admin.extend_subscription.select_duration') }}</div>
                            </div>

                            <!-- Category Warning Alert -->
                            <div class="alert alert-warning mb-3" id="category-warning" style="display: none;">
                                <h6 class="alert-heading mb-2">
                                    <i class="bx bx-error me-1"></i> {{ __('admin.extend_subscription.different_category_warning') }}
                                </h6>
                                <p class="mb-0">
                                    {!! __('admin.extend_subscription.different_category_text') !!} (<span id="new-category-text"></span>) 
                                    {{ __('admin.extend_subscription.from_current') }} (<span id="old-category-text"></span>).
                                </p>
                                <hr>
                                <p class="mb-0 text-danger">
                                    <i class="bx bx-info-circle me-1"></i>
                                    <strong>{{ __('admin.extend_subscription.days_will_be_lost') }} <span id="lost-days"></span> {{ __('admin.extend_subscription.days_lost_text') }}</strong>
                                </p>
                            </div>

                            <!-- Same Category Info -->
                            <div class="alert alert-success mb-3" id="category-same" style="display: none;">
                                <h6 class="alert-heading mb-2">
                                    <i class="bx bx-check-circle me-1"></i> {{ __('admin.extend_subscription.same_category_info') }}
                                </h6>
                                <p class="mb-0">
                                    {!! __('admin.extend_subscription.same_category_text') !!} (<span id="same-category-text"></span>).
                                    {!! __('admin.extend_subscription.duration_accumulated') !!}
                                </p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="quantity">{{ __('admin.extend_subscription.quantity') }} <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                    id="quantity" name="quantity" min="1" max="12"
                                    value="{{ old('quantity', 1) }}" required>
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">{{ __('admin.extend_subscription.quantity_help') }}</div>
                            </div>

                            <div class="card bg-light-info mb-3" id="extension-summary" style="display: none;">
                                <div class="card-body">
                                    <h6 class="card-title mb-2">{{ __('admin.extend_subscription.extension_summary') }}</h6>
                                    <div class="row">
                                        <div class="col-6">
                                            <small class="text-muted">{{ __('admin.extend_subscription.plan_duration') }}:</small>
                                            <div class="fw-semibold" id="ext-plan-duration">-</div>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">{{ __('admin.extend_subscription.quantity') }}:</small>
                                            <div class="fw-semibold" id="ext-quantity">-</div>
                                        </div>
                                        <div class="col-6 mt-2">
                                            <small class="text-muted">{{ __('admin.extend_subscription.total_extension') }}:</small>
                                            <div class="fw-bold text-primary" id="ext-total-days">-</div>
                                        </div>
                                        <div class="col-6 mt-2">
                                            <small class="text-muted">{{ __('admin.extend_subscription.additional_amount') }}:</small>
                                            <div class="fw-bold text-success" id="ext-total-amount">-</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="bx bx-check me-1"></i> {{ __('admin.extend_subscription.extend_button') }}
                                </button>
                                <a href="{{ route('admin.manual-subscriptions.show', $subscription->id) }}"
                                    class="btn btn-outline-secondary">
                                    {{ __('admin.extend_subscription.cancel') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('admin.extend_subscription.preview_title') }}</h5>
                        <hr>
                        <div class="mb-3">
                            <small class="text-muted d-block">{{ __('admin.extend_subscription.current_end_date') }}</small>
                            <strong>{{ $subscription->end_date->format('d M Y') }}</strong>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">{{ __('admin.extend_subscription.extension_days') }}</small>
                            <strong id="preview-days">-</strong>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">{{ __('admin.extend_subscription.new_end_date') }}</small>
                            <strong id="preview-new-end" class="text-primary">-</strong>
                        </div>
                        <hr>
                        <div class="alert alert-success mb-0" role="alert">
                            <small>
                                <i class="bx bx-info-circle me-1"></i>
                                {{ __('admin.extend_subscription.remain_active') }}
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
        // Translation helper for category subscription
        const categoryTranslations = {
            'harian': '{{ __("admin.category_subscription.harian") }}',
            'mingguan': '{{ __("admin.category_subscription.mingguan") }}',
            'bulanan': '{{ __("admin.category_subscription.bulanan") }}',
            'tahunan': '{{ __("admin.category_subscription.tahunan") }}'
        };

        const daysText = '{{ __("admin.extend_subscription.days") }}';
        const sameAccumulatedText = '{!! __("admin.extend_subscription.same_category_accumulated") !!}';
        const differentReplacedText = '{!! __("admin.extend_subscription.different_category_replaced") !!}';

        document.addEventListener('DOMContentLoaded', function() {
            const planSelect = document.getElementById('subscription_plan_id');
            const quantityInput = document.getElementById('quantity');
            const currentEndDate = new Date('{{ $subscription->end_date->format('Y-m-d') }}');
            const currentCategory = '{{ $subscription->plan->category_subscription ?? '' }}';
            const currentCategoryElement = document.getElementById('current-category');
            const currentCategoryValue = currentCategoryElement ? currentCategoryElement.dataset.category : currentCategory;
            const remainingDays = {{ (int) max(0, floor(now()->diffInDays($subscription->end_date, false))) }};

            function translateCategory(category) {
                return categoryTranslations[category] || category;
            }

            function updatePreview() {
                const selectedOption = planSelect.options[planSelect.selectedIndex];
                const quantity = parseInt(quantityInput.value) || 0;

                // Hide all alerts first
                document.getElementById('category-warning').style.display = 'none';
                document.getElementById('category-same').style.display = 'none';

                if (selectedOption.value && quantity > 0) {
                    const duration = parseInt(selectedOption.dataset.duration);
                    const price = parseFloat(selectedOption.dataset.price);
                    const newCategory = selectedOption.dataset.category;
                    const totalDays = duration * quantity;
                    const totalAmount = price * quantity;

                    // Check if category is the same
                    const isSameCategory = currentCategoryValue === newCategory;

                    // Update summary card
                    document.getElementById('ext-plan-duration').textContent = duration + ' ' + daysText;
                    document.getElementById('ext-quantity').textContent = quantity + 'x';
                    document.getElementById('ext-total-days').textContent = totalDays + ' ' + daysText;
                    document.getElementById('ext-total-amount').textContent = 'Rp ' + new Intl.NumberFormat('id-ID')
                        .format(totalAmount);
                    document.getElementById('extension-summary').style.display = 'block';

                    // Update preview based on category
                    let newEndDate;
                    let previewDaysText;

                    if (isSameCategory) {
                        // Same category: accumulate
                        newEndDate = new Date(currentEndDate);
                        newEndDate.setDate(newEndDate.getDate() + totalDays);
                        previewDaysText = totalDays + ' ' + daysText + ' (+ ' + remainingDays + ' remaining = ' + (totalDays + remainingDays) + ' total)';

                        // Show same category alert
                        document.getElementById('category-same').style.display = 'block';
                        document.getElementById('same-category-text').textContent = translateCategory(newCategory);
                    } else {
                        // Different category: replace (start from now)
                        newEndDate = new Date();
                        newEndDate.setDate(newEndDate.getDate() + totalDays);
                        previewDaysText = totalDays + ' ' + daysText + ' (remaining ' + remainingDays + ' ' + daysText + ' will be lost)';

                        // Show warning alert
                        document.getElementById('category-warning').style.display = 'block';
                        document.getElementById('new-category-text').textContent = translateCategory(newCategory);
                        document.getElementById('old-category-text').textContent = translateCategory(currentCategoryValue);
                        document.getElementById('lost-days').textContent = remainingDays;
                    }

                    document.getElementById('preview-days').textContent = previewDaysText;

                    const options = {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    };
                    document.getElementById('preview-new-end').textContent = newEndDate.toLocaleDateString('en-US', options);

                    // Update alert color based on category
                    const previewAlert = document.querySelector('.col-md-4 .alert');
                    if (previewAlert) {
                        if (isSameCategory) {
                            previewAlert.className = 'alert alert-success mb-0';
                            previewAlert.innerHTML = '<small><i class="bx bx-check-circle me-1"></i> ' + sameAccumulatedText + '</small>';
                        } else {
                            previewAlert.className = 'alert alert-warning mb-0';
                            previewAlert.innerHTML = '<small><i class="bx bx-error me-1"></i> ' + differentReplacedText + '</small>';
                        }
                    }
                } else {
                    document.getElementById('extension-summary').style.display = 'none';
                    document.getElementById('preview-days').textContent = '-';
                    document.getElementById('preview-new-end').textContent = '-';
                }
            }

            planSelect.addEventListener('change', updatePreview);
            quantityInput.addEventListener('input', updatePreview);

            // Initial update if plan is pre-selected
            if (planSelect.value) {
                updatePreview();
            }
        });
    </script>
@endpush
