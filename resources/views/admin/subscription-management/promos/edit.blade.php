@extends('layouts.admin')

@section('title', __('admin.promos.edit_promo'))

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet" />
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">{{ __('admin.promos.edit_promo') }}</h4>
                <p class="text-muted mb-0">{{ __('admin.promos.update_promo') }}: <strong>{{ $promo->name }}</strong></p>
            </div>
            <a href="{{ route('admin.promos.index') }}" class="btn btn-label-secondary">
                <i class="ti ti-arrow-left me-1"></i> {{ __('admin.promos.back_to_list') }}
            </a>
        </div>

        <!-- Form Card -->
        <div class="row">
            <div class="col-lg-8">
                <form action="{{ route('admin.promos.update', $promo->id) }}" method="POST" id="promoForm">
                    @csrf
                    @method('PUT')

                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">{{ __('admin.promos.basic_information') }}</h5>
                        </div>
                        <div class="card-body">
                            <!-- Name -->
                            <div class="form-group">
                                <label for="name">{{ __('admin.promos.promo_name') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $promo->name) }}"
                                    placeholder="{{ __('admin.promos.promo_name_placeholder') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Code -->
                            <div class="form-group">
                                <label for="code">Promo Code</label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror"
                                    id="code" name="code" value="{{ old('code', $promo->code) }}"
                                    placeholder="e.g., WELCOME50 (leave empty for auto-apply)"
                                    style="text-transform: uppercase;">
                                <small class="form-text text-muted">
                                    Leave empty for automatic discount. Use uppercase letters, numbers, underscore, and
                                    hyphen only.
                                </small>
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                    rows="3" placeholder="Describe this promo...">{{ old('description', $promo->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Discount Settings -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Discount Settings</h5>
                        </div>
                        <div class="card-body">
                            <!-- Type -->
                            <div class="form-group">
                                <label for="type">Discount Type <span class="text-danger">*</span></label>
                                <select class="form-control @error('type') is-invalid @enderror" id="type"
                                    name="type" required>
                                    <option value="">-- Select Type --</option>
                                    <option value="percentage"
                                        {{ old('type', $promo->type) === 'percentage' ? 'selected' : '' }}>Percentage
                                        Discount</option>
                                    <option value="fixed_amount"
                                        {{ old('type', $promo->type) === 'fixed_amount' ? 'selected' : '' }}>Fixed Amount
                                        Discount</option>
                                    <option value="free_trial"
                                        {{ old('type', $promo->type) === 'free_trial' ? 'selected' : '' }}>Free Trial
                                    </option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Value -->
                            <div class="form-group">
                                <label for="value">
                                    <span id="valueLabel">Discount Value</span> <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('value') is-invalid @enderror"
                                        id="value" name="value" value="{{ old('value', $promo->value) }}"
                                        step="0.01" min="0" placeholder="Enter value" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="valueUnit">
                                            <span id="unitLabel">%</span>
                                        </span>
                                    </div>
                                    @error('value')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="form-text text-muted" id="valueHint">
                                    Enter the discount percentage (e.g., 50 for 50% off)
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Date Range & Usage Limits -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Validity & Usage Limits</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="start_date">Start Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                            id="start_date" name="start_date"
                                            value="{{ old('start_date', $promo->start_date->format('Y-m-d')) }}" required>
                                        @error('start_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="end_date">End Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                            id="end_date" name="end_date"
                                            value="{{ old('end_date', $promo->end_date->format('Y-m-d')) }}" required>
                                        @error('end_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="max_usage">Maximum Total Usage</label>
                                        <input type="number"
                                            class="form-control @error('max_usage') is-invalid @enderror" id="max_usage"
                                            name="max_usage" value="{{ old('max_usage', $promo->max_usage) }}"
                                            min="1" placeholder="Leave empty for unlimited">
                                        <small class="form-text text-muted">
                                            Total times this promo can be used by all users
                                            @if ($promo->current_usage > 0)
                                                <br><strong class="text-info">Current usage:
                                                    {{ $promo->current_usage }}</strong>
                                            @endif
                                        </small>
                                        @error('max_usage')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="max_usage_per_user">Max Usage Per User <span
                                                class="text-danger">*</span></label>
                                        <input type="number"
                                            class="form-control @error('max_usage_per_user') is-invalid @enderror"
                                            id="max_usage_per_user" name="max_usage_per_user"
                                            value="{{ old('max_usage_per_user', $promo->max_usage_per_user) }}"
                                            min="1" required>
                                        <small class="form-text text-muted">How many times each user can use this
                                            promo</small>
                                        @error('max_usage_per_user')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Active Status -->
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="is_active" name="is_active"
                                        value="1" {{ old('is_active', $promo->is_active) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_active">
                                        <strong>Active</strong> - Promo is available for use
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Conditions -->
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Conditions (Optional)</h5>
                            <button type="button" class="btn btn-sm btn-primary" id="addCondition">
                                <i class="ti ti-plus"></i> Add Condition
                            </button>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-3">Add conditions to restrict who can use this promo</p>

                            <div id="conditionsContainer">
                                @php
                                    $conditions = old('conditions', $promo->conditions->toArray());
                                @endphp

                                @if (count($conditions) > 0)
                                    @foreach ($conditions as $index => $condition)
                                        @php
                                            $conditionType = is_array($condition)
                                                ? $condition['condition_type']
                                                : $condition->condition_type;
                                            $conditionValue = is_array($condition)
                                                ? $condition['condition_value'] ?? ''
                                                : $condition->condition_value;
                                        @endphp
                                        <div class="condition-row card mb-3">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <label>Condition Type</label>
                                                        <select class="form-control condition-type"
                                                            name="conditions[{{ $index }}][condition_type]">
                                                            <option value="">-- Select Type --</option>
                                                            <option value="new_user"
                                                                {{ $conditionType === 'new_user' ? 'selected' : '' }}>New
                                                                User Only</option>
                                                            <option value="first_subscription"
                                                                {{ $conditionType === 'first_subscription' ? 'selected' : '' }}>
                                                                First Subscription Only</option>
                                                            <option value="subscription_type"
                                                                {{ $conditionType === 'subscription_type' ? 'selected' : '' }}>
                                                                Specific Subscription Type</option>
                                                            <option value="min_price"
                                                                {{ $conditionType === 'min_price' ? 'selected' : '' }}>
                                                                Minimum Price</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6"
                                                        style="{{ in_array($conditionType, ['new_user', 'first_subscription']) ? 'display:none;' : '' }}">
                                                        <label>Value <span class="value-required text-danger"
                                                                style="{{ in_array($conditionType, ['subscription_type', 'min_price']) ? '' : 'display:none;' }}">*</span></label>
                                                        <input type="text" class="form-control condition-value"
                                                            name="conditions[{{ $index }}][condition_value]"
                                                            value="{{ $conditionValue }}"
                                                            placeholder="Enter value (if required)"
                                                            {{ in_array($conditionType, ['subscription_type', 'min_price']) ? 'required' : '' }}>
                                                        <small class="form-text text-muted condition-hint"></small>
                                                    </div>
                                                    <div class="col-md-1 d-flex align-items-end">
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm remove-condition">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <div id="noConditions" class="text-center text-muted py-3"
                                style="{{ count($conditions) > 0 ? 'display:none;' : '' }}">
                                <i class="fas fa-info-circle"></i> No conditions added. Click "Add Condition" to set
                                restrictions.
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.promos.index') }}" class="btn btn-label-secondary">
                                    <i class="ti ti-x me-1"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-check me-1"></i> Update Promo
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Info Sidebar -->
            <div class="col-lg-4">
                <!-- Usage Stats -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="ti ti-chart-bar"></i> Usage Statistics
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>Total Usage:</strong>
                            <h3 class="text-primary">{{ $promo->current_usage }}
                                @if ($promo->max_usage)
                                    / {{ $promo->max_usage }}
                                @endif
                            </h3>
                        </div>

                        @if ($promo->max_usage)
                            <div class="progress mb-3" style="height: 25px;">
                                @php
                                    $percentage = min(100, ($promo->current_usage / $promo->max_usage) * 100);
                                @endphp
                                <div class="progress-bar {{ $percentage >= 100 ? 'bg-danger' : 'bg-success' }}"
                                    role="progressbar" style="width: {{ $percentage }}%">
                                    {{ number_format($percentage, 1) }}%
                                </div>
                            </div>
                        @endif

                        <div class="text-muted small">
                            <i class="fas fa-calendar"></i> Created: {{ $promo->created_at->format('M d, Y') }}<br>
                            <i class="fas fa-clock"></i> Last Updated : {{ $promo->updated_at->diffForHumans() }}
                        </div>
                    </div>
                </div>

                <!-- Help Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="ti ti-help"></i> Help & Tips
                        </h5>
                    </div>
                    <div class="card-body">
                        <h6 class="font-weight-bold">Discount Types:</h6>
                        <ul class="small">
                            <li><strong>Percentage:</strong> Reduces price by % (e.g., 50% off)</li>
                            <li><strong>Fixed Amount:</strong> Reduces price by $ (e.g., $10 off)</li>
                            <li><strong>Free Trial:</strong> Number of free days</li>
                        </ul>

                        <h6 class="font-weight-bold mt-3">Condition Types:</h6>
                        <ul class="small">
                            <li><strong>New User:</strong> Users registered within 7 days</li>
                            <li><strong>First Subscription:</strong> User's first subscription only</li>
                            <li><strong>Subscription Type:</strong> Specific plan types (e.g., "Premium,Pro")</li>
                            <li><strong>Minimum Price:</strong> Order must meet minimum amount</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            let conditionIndex = {{ count($conditions) }};

            // Update value field based on type selection
            $('#type').on('change', function() {
                const type = $(this).val();
                const valueInput = $('#value');
                const unitLabel = $('#unitLabel');
                const valueHint = $('#valueHint');
                const valueLabel = $('#valueLabel');

                switch (type) {
                    case 'percentage':
                        valueLabel.text('Discount Percentage');
                        unitLabel.text('%');
                        valueInput.attr('max', '100');
                        valueInput.attr('placeholder', 'Enter percentage (e.g., 50)');
                        valueHint.text('Enter the discount percentage (0-100). Example: 50 for 50% off');
                        break;
                    case 'fixed_amount':
                        valueLabel.text('Discount Amount');
                        unitLabel.text('$');
                        valueInput.removeAttr('max');
                        valueInput.attr('placeholder', 'Enter amount (e.g., 10.00)');
                        valueHint.text('Enter the discount amount in dollars. Example: 10 for $10 off');
                        break;
                    case 'free_trial':
                        valueLabel.text('Trial Days');
                        unitLabel.text('days');
                        valueInput.attr('max', '365');
                        valueInput.attr('placeholder', 'Enter days (e.g., 30)');
                        valueHint.text('Enter number of free trial days (1-365). Example: 30 for 30 days free');
                        break;
                    default:
                        valueLabel.text('Discount Value');
                        unitLabel.text('-');
                        valueInput.removeAttr('max');
                        valueInput.attr('placeholder', 'Enter value');
                        valueHint.text('Select a discount type first');
                }
            });

            // Uppercase code input
            $('#code').on('input', function() {
                this.value = this.value.toUpperCase();
            });

            // Add Condition
            $('#addCondition').on('click', function() {
                const html = `
        <div class="condition-row card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-5">
                        <label>Condition Type</label>
                        <select class="form-control condition-type" name="conditions[${conditionIndex}][condition_type]" required>
                            <option value="">-- Select Type --</option>
                            <option value="new_user">New User Only</option>
                            <option value="first_subscription">First Subscription Only</option>
                            <option value="subscription_type">Specific Subscription Type</option>
                            <option value="min_price">Minimum Price</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Value <span class="value-required text-danger" style="display:none;">*</span></label>
                        <input type="text" 
                               class="form-control condition-value" 
                               name="conditions[${conditionIndex}][condition_value]"
                               placeholder="Enter value (if required)">
                        <small class="form-text text-muted condition-hint"></small>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-danger btn-sm remove-condition">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;

                $('#conditionsContainer').append(html);
                $('#noConditions').hide();
                conditionIndex++;
            });

            // Remove Condition
            $(document).on('click', '.remove-condition', function() {
                $(this).closest('.condition-row').remove();

                if ($('.condition-row').length === 0) {
                    $('#noConditions').show();
                }
            });

            // Update condition value field based on type
            $(document).on('change', '.condition-type', function() {
                const type = $(this).val();
                const row = $(this).closest('.condition-row');
                const valueCol = row.find('.condition-value').closest('.col-md-6');
                const valueInput = row.find('.condition-value');
                const valueRequired = row.find('.value-required');
                const hint = row.find('.condition-hint');

                switch (type) {
                    case 'new_user':
                    case 'first_subscription':
                        valueCol.hide();
                        valueInput.prop('required', false);
                        valueInput.val('');
                        valueRequired.hide();
                        hint.text('This condition does not require a value');
                        break;
                    case 'subscription_type':
                        valueCol.show();
                        valueInput.prop('required', true);
                        valueInput.attr('placeholder', 'e.g., Premium,Pro');
                        valueRequired.show();
                        hint.text('Enter subscription type names separated by comma');
                        break;
                    case 'min_price':
                        valueCol.show();
                        valueInput.prop('required', true);
                        valueInput.attr('placeholder', 'e.g., 9.99');
                        valueRequired.show();
                        hint.text('Enter minimum price in dollars (e.g., 9.99)');
                        break;
                    default:
                        valueCol.show();
                        valueInput.prop('required', false);
                        valueInput.attr('placeholder', 'Enter value');
                        valueRequired.hide();
                        hint.text('');
                }
            });

            // Form validation
            $('#promoForm').on('submit', function(e) {
                const type = $('#type').val();
                const value = parseFloat($('#value').val());

                if (type === 'percentage' && value > 100) {
                    e.preventDefault();
                    alert('Percentage cannot exceed 100%');
                    return false;
                }

                if (type === 'free_trial' && value > 365) {
                    e.preventDefault();
                    alert('Free trial days cannot exceed 365 days');
                    return false;
                }

                const startDate = new Date($('#start_date').val());
                const endDate = new Date($('#end_date').val());

                if (endDate <= startDate) {
                    e.preventDefault();
                    alert('End date must be after start date');
                    return false;
                }
            });

            // Trigger type change on page load if value exists
            $(document).ready(function() {
                if ($('#type').val()) {
                    $('#type').trigger('change');
                }

                // Update condition hints for existing conditions
                $('.condition-type').each(function() {
                    if ($(this).val()) {
                        $(this).trigger('change');
                    }
                });
            });
        </script>
    @endpush
@endsection
