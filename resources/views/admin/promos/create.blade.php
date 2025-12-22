@extends('layouts.admin')

@section('title', 'Create New Promo')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet" />
    <style>
        /* Subscription Plan Badge Styles */
        .plan-badge {
            display: inline-flex !important;
            align-items: center !important;
            padding: 0.5rem 0.75rem !important;
            margin: 0.25rem 0.25rem 0.25rem 0 !important;
            font-size: 0.875rem !important;
            font-weight: 500 !important;
            line-height: 1.5 !important;
            color: #7367f0 !important;
            background-color: #f8f7ff !important;
            border: 2px solid #7367f0 !important;
            border-radius: 0.5rem !important;
            box-shadow: 0 2px 6px rgba(115, 103, 240, 0.15) !important;
        }

        .remove-plan {
            margin-left: 0.5rem !important;
            cursor: pointer !important;
            font-size: 1rem !important;
            line-height: 1 !important;
            opacity: 0.8 !important;
            color: #7367f0 !important;
        }
        
        .remove-plan:hover {
            opacity: 1 !important;
        }
        
        .selected-plans {
            min-height: 20px !important;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">Create New Promo</h4>
                <p class="text-muted mb-0">Create a new subscription promo code</p>
            </div>
            <a href="{{ route('admin.promos.index') }}" class="btn btn-label-secondary">
                <i class="ti ti-arrow-left me-1"></i> Back to List
            </a>
        </div>

        <!-- Error Messages -->
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Validation Error!</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Form Card -->
        <div class="row">
            <div class="col-lg-8">
                <form action="{{ route('admin.promos.store') }}" method="POST" id="promoForm">
                    @csrf

                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Basic Information</h5>
                        </div>
                        <div class="card-body">
                            <!-- Name -->
                            <div class="form-group">
                                <label for="name">Promo Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}"
                                    placeholder="e.g., Welcome Discount 50%" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Code -->
                            <div class="form-group">
                                <label for="code">Promo Code</label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror"
                                    id="code" name="code" value="{{ old('code') }}"
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
                                    rows="3" placeholder="Describe this promo...">{{ old('description') }}</textarea>
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
                                    <option value="percentage" {{ old('type') === 'percentage' ? 'selected' : '' }}>
                                        Percentage Discount</option>
                                    <option value="fixed_amount" {{ old('type') === 'fixed_amount' ? 'selected' : '' }}>
                                        Fixed Amount Discount</option>
                                    <option value="free_trial" {{ old('type') === 'free_trial' ? 'selected' : '' }}>Free
                                        Trial</option>
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
                                        id="value" name="value" value="{{ old('value') }}" step="0.01"
                                        min="0" placeholder="Enter value" required>
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
                                            value="{{ old('start_date', now()->format('Y-m-d')) }}" required>
                                        @error('start_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="end_date">End Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                            id="end_date" name="end_date" value="{{ old('end_date') }}" required>
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
                                            name="max_usage" value="{{ old('max_usage') }}" min="1"
                                            placeholder="Leave empty for unlimited">
                                        <small class="form-text text-muted">Total times this promo can be used by all
                                            users</small>
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
                                            value="{{ old('max_usage_per_user', 1) }}" min="1" required>
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
                                        value="1" {{ old('is_active', true) ? 'checked' : '' }}>
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
                                @if (old('conditions'))
                                    @foreach (old('conditions') as $index => $condition)
                                        <div class="condition-row card mb-3">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <label>Condition Type</label>
                                                        <select class="form-control condition-type"
                                                            name="conditions[{{ $index }}][condition_type]">
                                                            <option value="">-- Select Type --</option>
                                                            <option value="new_user"
                                                                {{ $condition['condition_type'] === 'new_user' ? 'selected' : '' }}>
                                                                New User Only</option>
                                                            <option value="first_subscription"
                                                                {{ $condition['condition_type'] === 'first_subscription' ? 'selected' : '' }}>
                                                                First Subscription Only</option>
                                                            <option value="subscription_type"
                                                                {{ $condition['condition_type'] === 'subscription_type' ? 'selected' : '' }}>
                                                                Specific Subscription Type</option>
                                                            <option value="min_price"
                                                                {{ $condition['condition_type'] === 'min_price' ? 'selected' : '' }}>
                                                                Minimum Price</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 condition-value-wrapper"
                                                        style="{{ $condition['condition_type'] === 'first_subscription' ? 'display:none;' : '' }}">
                                                        <label>Value <span class="value-required text-danger"
                                                                style="{{ in_array($condition['condition_type'], ['subscription_type', 'min_price', 'new_user']) ? '' : 'display:none;' }}">*</span></label>
                                                        <input type="number"
                                                            class="form-control condition-value condition-value-text"
                                                            name="conditions[{{ $index }}][condition_value_text]"
                                                            value="{{ in_array($condition['condition_type'], ['min_price', 'new_user']) ? $condition['condition_value'] ?? '' : '' }}"
                                                            step="1" placeholder="Enter value"
                                                            style="{{ !in_array($condition['condition_type'], ['min_price', 'new_user']) ? 'display:none;' : '' }}">
                                                        
                                                        <div class="subscription-plan-selector" style="{{ $condition['condition_type'] !== 'subscription_type' ? 'display:none;' : '' }}">
                                                            <select class="form-select condition-plan-selector">
                                                                <option value="">Select subscription plans</option>
                                                                @foreach ($subscriptionPlans as $plan)
                                                                    <option value="{{ $plan->name }}" data-price="{{ number_format($plan->price, 0, ',', '.') }}">
                                                                        {{ $plan->name }} - Rp {{ number_format($plan->price, 0, ',', '.') }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            
                                                            <!-- Selected Plans Display -->
                                                            <div class="selected-plans mt-2">
                                                                @if($condition['condition_type'] === 'subscription_type' && isset($condition['condition_value']))
                                                                    @foreach(explode(',', $condition['condition_value']) as $planName)
                                                                        <span class="plan-badge">{{ $planName }}<span class="remove-plan">&times;</span></span>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                            
                                                            <!-- Hidden inputs for form submission -->
                                                            <div class="plan-inputs"></div>
                                                        </div>
                                                        
                                                        <small class="form-text text-muted condition-hint"></small>
                                                    </div>
                                                    <div class="col-md-1 d-flex align-items-end">
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm remove-condition">
                                                            <i class="ti ti-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <div id="noConditions" class="text-center text-muted py-3"
                                style="{{ old('conditions') ? 'display:none;' : '' }}">
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
                                    <i class="ti ti-check me-1"></i> Create Promo
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Help Sidebar -->
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="ti ti-help"></i> Help & Tips
                        </h5>
                    </div>
                    <div class="card-body">
                        <h6 class="font-weight-bold">Tipe Diskon:</h6>
                        <ul class="small">
                            <li><strong>Persentase:</strong> Mengurangi harga berdasarkan % (contoh: diskon 50%)</li>
                            <li><strong>Nominal Tetap:</strong> Mengurangi harga dengan nominal tetap (contoh: potongan Rp 50.000)</li>
                            <li><strong>Uji Coba Gratis:</strong> Jumlah hari gratis berlangganan</li>
                        </ul>

                        <h6 class="font-weight-bold mt-3">Tipe Kondisi:</h6>
                        <ul class="small">
                            <li><strong>Pengguna Baru:</strong> User yang terdaftar dalam X hari (contoh: 7 untuk 7 hari)</li>
                            <li><strong>Langganan Pertama:</strong> Hanya untuk langganan pertama user (tidak perlu nilai)</li>
                            <li><strong>Tipe Langganan:</strong> Paket langganan tertentu (contoh: "Premium,Pro")</li>
                            <li><strong>Harga Minimum:</strong> Pesanan harus memenuhi minimal harga (contoh: "99000")</li>
                        </ul>

                        <h6 class="font-weight-bold mt-3">Contoh:</h6>
                        <div class="alert alert-info small">
                            <strong>Diskon Selamat Datang:</strong><br>
                            - Kode: WELCOME50<br>
                            - Tipe: Persentase (50%)<br>
                            - Kondisi: Pengguna Baru + Langganan Pertama
                        </div>
                        <div class="alert alert-success small">
                            <strong>Promo Hari Raya:</strong><br>
                            - Kode: HARIRAYA70<br>
                            - Tipe: Persentase (70%)<br>
                            - Kondisi: Harga Min Rp 99.000
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            let conditionIndex = {{ old('conditions') ? count(old('conditions')) : 0 }};

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
                        unitLabel.text('Rp');
                        valueInput.removeAttr('max');
                        valueInput.attr('placeholder', 'Enter amount (e.g., 10000)');
                        valueHint.text('Enter the discount amount in rupiah. Example: 10000 for Rp 10.000 off');
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
                    <div class="col-md-6 condition-value-wrapper" style="display:none;">
                        <label>Value <span class="value-required text-danger" style="display:none;">*</span></label>
                        <input type="number"
                               class="form-control condition-value condition-value-text"
                               name="conditions[${conditionIndex}][condition_value_text]"
                               step="0.01"
                               placeholder="Enter value"
                               style="display:none;">
                        
                        <div class="subscription-plan-selector" style="display:none;">
                            <select class="form-select condition-plan-selector">
                                <option value="">Select subscription plans</option>
                                @foreach ($subscriptionPlans as $plan)
                                    <option value="{{ $plan->name }}" data-price="{{ number_format($plan->price, 0, ',', '.') }}">
                                        {{ $plan->name }} - Rp {{ number_format($plan->price, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                            
                            <!-- Selected Plans Display -->
                            <div class="selected-plans mt-2"></div>
                            
                            <!-- Hidden inputs for form submission -->
                            <div class="plan-inputs"></div>
                        </div>
                        
                        <small class="form-text text-muted condition-hint"></small>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-danger btn-sm remove-condition">
                            <i class="ti ti-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;

                const newRow = $(html);
                $('#conditionsContainer').append(newRow);

                // DO NOT initialize select2 here - it will be initialized when subscription_type is selected

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
                const valueWrapper = row.find('.condition-value-wrapper');
                const textInput = row.find('.condition-value-text');
                const planSelector = row.find('.subscription-plan-selector');
                const valueRequired = row.find('.value-required');
                const hint = row.find('.condition-hint');

                // Hide all first and clear values
                valueWrapper.hide();
                textInput.hide().prop('required', false).val('');
                planSelector.hide();
                valueRequired.hide();
                hint.text('');

                switch (type) {
                    case 'new_user':
                        valueWrapper.show();
                        textInput.show().prop('required', true);
                        textInput.attr('type', 'number').attr('step', '1').attr('min', '1').attr('placeholder', 'e.g., 7');
                        valueRequired.show();
                        hint.text('Enter maximum account age in days (e.g., 7 for users registered within 7 days)');
                        break;
                    case 'first_subscription':
                        // Tetap hide semua
                        hint.text('This condition does not require a value');
                        break;
                    case 'subscription_type':
                        valueWrapper.show();
                        planSelector.show();
                        valueRequired.show();
                        hint.text('Select one or more subscription plans');
                        break;
                        break;
                    case 'min_price':
                        valueWrapper.show();
                        textInput.show().prop('required', true);
                        textInput.attr('type', 'number').attr('step', '1').attr('placeholder', 'e.g., 99000');
                        valueRequired.show();
                        hint.text('Enter minimum price in rupiah (e.g., 99000)');
                        break;
                    default:
                        valueWrapper.show();
                        textInput.show();
                        textInput.attr('type', 'text').attr('placeholder', 'Enter value');
                        valueRequired.hide();
                        hint.text('');
                }
            });

            // Handle subscription plan selection
            $(document).on('change', '.condition-plan-selector', function() {
                const row = $(this).closest('.condition-row');
                const selectedValue = $(this).val();
                const selectedText = $(this).find('option:selected').text();
                const selectedPlansDiv = row.find('.selected-plans');
                const planInputsDiv = row.find('.plan-inputs');
                
                if (selectedValue) {
                    // Get existing plans
                    const existingPlans = [];
                    planInputsDiv.find('input').each(function() {
                        existingPlans.push($(this).val());
                    });
                    
                    // Check if not already selected
                    if (!existingPlans.includes(selectedValue)) {
                        // Add badge
                        const badge = $('<span class="plan-badge"></span>');
                        badge.text(selectedValue);
                        
                        const removeBtn = $('<span class="remove-plan">&times;</span>');
                        removeBtn.on('click', function() {
                            badge.remove();
                            planInputsDiv.find(`input[value="${selectedValue}"]`).remove();
                        });
                        
                        badge.append(removeBtn);
                        selectedPlansDiv.append(badge);
                        
                        // Add hidden input
                        const input = $('<input type="hidden">');
                        input.val(selectedValue);
                        planInputsDiv.append(input);
                    }
                    
                    // Reset selector
                    $(this).val('');
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

                // Process conditions: merge values into single field
                $('.condition-row').each(function(index) {
                    const row = $(this);
                    const conditionType = row.find('.condition-type').val();

                    if (conditionType === 'subscription_type') {
                        // Get all selected plans from hidden inputs
                        const selectedPlans = [];
                        row.find('.plan-inputs input').each(function() {
                            selectedPlans.push($(this).val());
                        });
                        
                        if (selectedPlans.length > 0) {
                            const joinedValue = selectedPlans.join(',');
                            row.append(
                                `<input type="hidden" name="conditions[${index}][condition_value]" value="${joinedValue}">`
                            );
                        }
                    } else if (conditionType === 'min_price' || conditionType === 'new_user') {
                        const textValue = row.find('.condition-value-text').val();
                        if (textValue) {
                            row.append(
                                `<input type="hidden" name="conditions[${index}][condition_value]" value="${textValue}">`
                                );
                        }
                        // Remove the text input name
                        row.find('.condition-value-text').attr('name', '');
                    }
                });
            });

            // Trigger type change on page load if value exists
            $(document).ready(function() {
                if ($('#type').val()) {
                    $('#type').trigger('change');
                }

                // DO NOT initialize select2 for all - it will be done conditionally based on type

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
