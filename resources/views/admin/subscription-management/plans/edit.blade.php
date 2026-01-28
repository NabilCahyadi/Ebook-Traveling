@extends('layouts.admin')

@section('title', __('admin.subscription_plans.edit_plan'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">{{ __('admin.menu.dashboard') }} / {{ __('admin.subscription_plans.title') }} /</span> {{ __('admin.actions.edit') }}
            </h4>
            <a href="{{ route('admin.subscription-plans.index') }}" class="btn btn-secondary">
                <i class="bx bx-arrow-back me-1"></i> {{ __('admin.actions.back') }}
            </a>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ __('admin.subscription_plans.edit_plan') }}: {{ $plan->name }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.subscription-plans.update', $plan->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="name">{{ __('admin.subscription_plans.plan_name') }} <span
                                class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $plan->name) }}"
                                placeholder="e.g., Monthly Plan, Annual Plan" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Banner Image Upload -->
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="cover_image">{{ __('admin.subscription_plans.banner_image') }}</label>
                        <div class="col-sm-10">
                            @if ($plan->cover_image)
                                <div class="mb-3" id="currentBannerContainer">
                                    <label class="form-label">{{ __('admin.subscription_plans.current_banner') }}</label>
                                    <div class="border rounded p-2" style="max-width: 600px;">
                                        <div class="position-relative" style="aspect-ratio: 3/1; overflow: hidden; border-radius: 0.375rem; background-color: #f5f5f5;">
                                            <img src="{{ asset('storage/' . $plan->cover_image) }}" alt="Current Banner"
                                                style="width: 100%; height: 100%; object-fit: cover; display: block;">
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <input type="file" class="form-control @error('cover_image') is-invalid @enderror"
                                id="cover_image" name="cover_image" accept="image/*" onchange="previewBanner(event)">
                            @error('cover_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">{{ __('admin.subscription_plans.banner_replace_help') }}</div>

                            <!-- Preview Area for New Image -->
                            <div id="bannerPreview" class="mt-3" style="display: none;">
                                <div class="border rounded p-2" style="max-width: 600px;">
                                    <div class="position-relative" style="aspect-ratio: 3/1; overflow: hidden; border-radius: 0.375rem; background-color: #f5f5f5;">
                                        <img id="bannerPreviewImg" src="" alt="Banner Preview"
                                            style="width: 100%; height: 100%; object-fit: cover; display: block;">
                                    </div>
                                    <button type="button" class="btn btn-sm btn-label-danger mt-2"
                                        onclick="removeBanner()">
                                        <i class="ti ti-x me-1"></i> {{ __('admin.actions.delete') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="description">{{ __('admin.form.description') }}</label>
                        <div class="col-sm-10">
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                rows="3" placeholder="Enter plan description">{{ old('description', $plan->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="price">{{ __('admin.subscription_plans.price') }} (Rp) <span
                                class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control @error('price') is-invalid @enderror" id="price"
                                name="price" value="{{ old('price', $plan->price) }}" min="0" step="0.01"
                                required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">{{ app()->getLocale() == 'id' ? 'Durasi' : 'Duration' }} <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <div class="row g-2">
                                <!-- Category Dropdown -->
                                <div class="col-md-4">
                                    <label for="category_subscription" class="form-label small">{{ app()->getLocale() == 'id' ? 'Kategori' : 'Category' }}</label>
                                    <select class="form-select @error('category_subscription') is-invalid @enderror" 
                                            id="category_subscription" 
                                            name="category_subscription" 
                                            required
                                            onchange="updateDurationLimits()">
                                        <option value="">{{ app()->getLocale() == 'id' ? 'Pilih Kategori' : 'Select Category' }}</option>
                                        <option value="harian" {{ old('category_subscription', $plan->category_subscription ?? '') == 'harian' ? 'selected' : '' }}>{{ app()->getLocale() == 'id' ? 'Harian' : 'Daily' }}</option>
                                        <option value="mingguan" {{ old('category_subscription', $plan->category_subscription ?? '') == 'mingguan' ? 'selected' : '' }}>{{ app()->getLocale() == 'id' ? 'Mingguan' : 'Weekly' }}</option>
                                        <option value="bulanan" {{ old('category_subscription', $plan->category_subscription ?? '') == 'bulanan' ? 'selected' : '' }}>{{ app()->getLocale() == 'id' ? 'Bulanan' : 'Monthly' }}</option>
                                        <option value="tahunan" {{ old('category_subscription', $plan->category_subscription ?? '') == 'tahunan' ? 'selected' : '' }}>{{ app()->getLocale() == 'id' ? 'Tahunan' : 'Yearly' }}</option>
                                    </select>
                                    @error('category_subscription')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Value Input -->
                                <div class="col-md-3">
                                    <label for="duration_value" class="form-label small">
                                        <span id="value_label">{{ app()->getLocale() == 'id' ? 'Nilai' : 'Value' }}</span>
                                        <small class="text-muted" id="value_limit">(max: -)</small>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('duration_value') is-invalid @enderror" 
                                           id="duration_value" 
                                           name="duration_value" 
                                           value="{{ old('duration_value', $durationValue ?? '') }}"
                                           required
                                           oninput="handleDurationInput(this)"
                                           onkeydown="return checkInput(event)"
                                           placeholder="{{ app()->getLocale() == 'id' ? 'Masukkan nilai' : 'Enter value' }}">
                                    @error('duration_value')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Days Display -->
                                <div class="col-md-3">
                                    <label for="days_display" class="form-label small">{{ app()->getLocale() == 'id' ? 'Total Hari' : 'Total Days' }}</label>
                                    <input type="text" 
                                           class="form-control bg-light" 
                                           id="days_display" 
                                           value="{{ old('duration_days', $plan->duration_days) }} {{ app()->getLocale() == 'id' ? 'hari' : 'days' }}"
                                           readonly>
                                </div>
                            </div>
                            <!-- Hidden input for duration_days -->
                            <input type="hidden" name="duration_days" id="duration_days" value="{{ old('duration_days', $plan->duration_days) }}">
                        </div>
                    </div>

                    {{-- Features input hidden as requested --}}
                    @if(false)
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="features">Features</label>
                        <div class="col-sm-10">
                            <textarea class="form-control @error('features') is-invalid @enderror" id="features" name="features" rows="5"
                                placeholder="Enter each feature on a new line">{{ old('features', is_array($plan->features) ? implode("\n", $plan->features) : '') }}</textarea>
                            @error('features')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Enter one feature per line</div>
                        </div>
                    </div>
                    @endif

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="button_text">Button Text</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('button_text') is-invalid @enderror" 
                                id="button_text" name="button_text" value="{{ old('button_text', $plan->button_text) }}" 
                                placeholder="e.g., Get Started, Subscribe Now, Choose Plan">
                            @error('button_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Text that will appear on the button in pricing page (optional)</div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="mayar_payment_link">Mayar Payment Link</label>
                        <div class="col-sm-10">
                            <input type="url" class="form-control @error('mayar_payment_link') is-invalid @enderror" 
                                id="mayar_payment_link" name="mayar_payment_link" value="{{ old('mayar_payment_link', $plan->mayar_payment_link) }}" 
                                placeholder="https://app.mayar.id/payment/...">
                            @error('mayar_payment_link')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Link pembayaran Mayar untuk paket langganan ini (opsional)</div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">{{ __('admin.ebooks.status') }}</label>
                        <div class="col-sm-10">
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                    {{ old('is_active', $plan->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    {{ __('admin.status.active') }} (Available for users to subscribe)
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-10 offset-sm-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-save me-1"></i> {{ __('admin.actions.save') }} {{ __('admin.subscription_plans.title') }}
                            </button>
                            <a href="{{ route('admin.subscription-plans.index') }}" class="btn btn-secondary">
                                {{ __('admin.actions.cancel') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Define category limits and multipliers with proper limits (outside DOMContentLoaded for global access)
            const categoryLimits = {
                'harian': { 
                    max: 7, 
                    multiplier: 1, 
                    label: '{{ app()->getLocale() == "id" ? "Hari" : "Days" }}'
                },
                'mingguan': { 
                    max: 4, 
                    multiplier: 7, 
                    label: '{{ app()->getLocale() == "id" ? "Minggu" : "Weeks" }}'
                },
                'bulanan': { 
                    max: 12, 
                    multiplier: 30, 
                    label: '{{ app()->getLocale() == "id" ? "Bulan" : "Months" }}'
                },
                'tahunan': { 
                    max: Infinity, 
                    multiplier: 365, 
                    label: '{{ app()->getLocale() == "id" ? "Tahun" : "Years" }}'
                }
            };

            const dayLabel = '{{ app()->getLocale() == "id" ? "hari" : "days" }}';

            // Block non-numeric keys and check max on keydown
            function checkInput(evt) {
                // Allow: backspace, delete, tab, escape, enter, and arrows
                if ([8, 9, 13, 27, 46, 37, 38, 39, 40].includes(evt.keyCode)) {
                    return true;
                }
                
                // Allow: Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
                if ((evt.ctrlKey || evt.metaKey) && [65, 67, 86, 88].includes(evt.keyCode)) {
                    return true;
                }
                
                // Block non-numeric (not 0-9)
                if ((evt.keyCode < 48 || evt.keyCode > 57) && (evt.keyCode < 96 || evt.keyCode > 105)) {
                    evt.preventDefault();
                    return false;
                }
                
                // Get the character that will be typed
                const char = evt.key;
                if (!/^\d$/.test(char)) {
                    evt.preventDefault();
                    return false;
                }
                
                // Check if resulting number would exceed max
                const input = evt.target;
                const category = document.getElementById('category_subscription').value;
                if (!category) return true;
                
                const config = categoryLimits[category];
                if (config.max === Infinity) return true; // Yearly is unlimited
                
                // Calculate what the new value would be
                const selectionStart = input.selectionStart;
                const selectionEnd = input.selectionEnd;
                const currentValue = input.value;
                const newValue = currentValue.substring(0, selectionStart) + char + currentValue.substring(selectionEnd);
                const numValue = parseInt(newValue);
                
                if (numValue > config.max) {
                    evt.preventDefault();
                    return false;
                }
                
                return true;
            }

            function handleDurationInput(input) {
                const category = document.getElementById('category_subscription').value;
                if (!category) return;
                
                const config = categoryLimits[category];
                let value = input.value.replace(/[^0-9]/g, ''); // Remove non-numeric
                
                if (value !== '') {
                    let numValue = parseInt(value);
                    
                    // Enforce max limit (except for yearly which is unlimited)
                    if (config.max !== Infinity && numValue > config.max) {
                        numValue = config.max;
                    }
                    
                    // Ensure minimum is 1
                    if (numValue < 1) {
                        numValue = 1;
                    }
                    
                    input.value = numValue;
                }
                
                calculateDurationDays();
            }

            function updateDurationLimits() {
                const category = document.getElementById('category_subscription').value;
                const valueInput = document.getElementById('duration_value');
                const valueLabel = document.getElementById('value_label');
                const valueLimit = document.getElementById('value_limit');
                const daysDisplay = document.getElementById('days_display');
                const hiddenInput = document.getElementById('duration_days');
                
                if (!category) {
                    valueInput.disabled = true;
                    valueInput.value = '';
                    valueLabel.textContent = '{{ app()->getLocale() == "id" ? "Nilai" : "Value" }}';
                    valueLimit.textContent = '(max: -)';
                    daysDisplay.value = '0 ' + dayLabel;
                    hiddenInput.value = '0';
                    return;
                }
                
                valueInput.disabled = false;
                const config = categoryLimits[category];
                
                // Reset value to 1 when category changes
                valueInput.value = 1;
                
                // Update label based on category
                valueLabel.textContent = config.label;
                
                // Update limit text based on category
                if (config.max === Infinity) {
                    valueLimit.textContent = '{{ app()->getLocale() == "id" ? "(tidak terbatas)" : "(unlimited)" }}';
                    valueInput.removeAttribute('max');
                } else {
                    valueLimit.textContent = '(max: ' + config.max + ')';
                    valueInput.setAttribute('max', config.max);
                }
                
                // Recalculate days with the new value (1)
                const totalDays = 1 * config.multiplier;
                daysDisplay.value = totalDays + ' ' + dayLabel;
                hiddenInput.value = totalDays;
            }

            function updateDurationLimitsWithoutReset() {
                const category = document.getElementById('category_subscription').value;
                const valueLabel = document.getElementById('value_label');
                const valueLimit = document.getElementById('value_limit');
                const valueInput = document.getElementById('duration_value');
                
                if (!category) {
                    valueLabel.textContent = '{{ app()->getLocale() == "id" ? "Nilai" : "Value" }}';
                    valueLimit.textContent = '(max: -)';
                    return;
                }
                
                const config = categoryLimits[category];
                valueLabel.textContent = config.label;
                
                if (config.max === Infinity) {
                    valueLimit.textContent = '{{ app()->getLocale() == "id" ? "(tidak terbatas)" : "(unlimited)" }}';
                    valueInput.removeAttribute('max');
                } else {
                    valueLimit.textContent = '(max: ' + config.max + ')';
                    valueInput.setAttribute('max', config.max);
                }
                
                calculateDurationDays();
            }

            function calculateDurationDays() {
                const category = document.getElementById('category_subscription').value;
                const value = parseInt(document.getElementById('duration_value').value) || 0;
                const daysDisplay = document.getElementById('days_display');
                const hiddenInput = document.getElementById('duration_days');
                
                if (!category || !value) {
                    daysDisplay.value = '0 ' + dayLabel;
                    hiddenInput.value = '0';
                    return;
                }
                
                const multiplier = categoryLimits[category].multiplier;
                const totalDays = value * multiplier;
                
                daysDisplay.value = totalDays + ' ' + dayLabel;
                hiddenInput.value = totalDays;
            }

            document.addEventListener('DOMContentLoaded', function() {
                // Calculate duration value from existing duration_days if category exists
                initializeDurationValue();
                
                function initializeDurationValue() {
                    const category = document.getElementById('category_subscription').value;
                    const durationDays = parseInt(document.getElementById('duration_days').value) || 0;
                    
                    if (category && durationDays > 0) {
                        const multiplier = categoryLimits[category].multiplier;
                        const calculatedValue = Math.round(durationDays / multiplier);
                        document.getElementById('duration_value').value = calculatedValue;
                        updateDurationLimitsWithoutReset();
                    } else if (category) {
                        updateDurationLimitsWithoutReset();
                    }
                }

                // Handle paste event to validate pasted content
                const durationInput = document.getElementById('duration_value');
                durationInput.addEventListener('paste', function(evt) {
                    evt.preventDefault();
                    const pastedText = (evt.clipboardData || window.clipboardData).getData('text');
                    const numericValue = pastedText.replace(/[^0-9]/g, '');
                    
                    if (numericValue) {
                        const category = document.getElementById('category_subscription').value;
                        if (category) {
                            const config = categoryLimits[category];
                            let numValue = parseInt(numericValue);
                            
                            // Enforce max limit
                            if (config.max !== Infinity && numValue > config.max) {
                                numValue = config.max;
                            }
                            
                            this.value = numValue;
                            calculateDurationDays();
                        }
                    }
                });
            });

            // Banner image preview
            function previewBanner(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('bannerPreviewImg').src = e.target.result;
                        document.getElementById('bannerPreview').style.display = 'block';
                        // Hide current banner when new one is selected
                        const currentBanner = document.getElementById('currentBannerContainer');
                        if (currentBanner) {
                            currentBanner.style.display = 'none';
                        }
                    };
                    reader.readAsDataURL(file);
                }
            }

            function removeBanner() {
                document.getElementById('cover_image').value = '';
                document.getElementById('bannerPreview').style.display = 'none';
                document.getElementById('bannerPreviewImg').src = '';
                // Show current banner again
                const currentBanner = document.getElementById('currentBannerContainer');
                if (currentBanner) {
                    currentBanner.style.display = 'block';
                }
            }
        </script>
    @endpush
@endsection
