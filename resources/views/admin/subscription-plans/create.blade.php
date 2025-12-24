@extends('layouts.admin')

@section('title', __('admin.subscription_plans.add_plan'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">{{ __('admin.menu.dashboard') }} / {{ __('admin.subscription_plans.title') }} /</span> {{ __('admin.subscription_plans.add_plan') }}
            </h4>
            <a href="{{ route('admin.subscription-plans.index') }}" class="btn btn-secondary">
                <i class="bx bx-arrow-back me-1"></i> {{ __('admin.actions.back') }}
            </a>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ __('admin.subscription_plans.add_plan') }}</h5>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <h6 class="alert-heading mb-1">{{ __('admin.messages.error_title') }}</h6>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('admin.subscription-plans.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="name">{{ __('admin.subscription_plans.plan_name') }} <span
                                class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" placeholder="e.g., Monthly Plan, Annual Plan"
                                required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">{{ __('admin.subscription_plans.name_help') }}</div>
                        </div>
                    </div>

                    <!-- Banner Image Upload -->
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="cover_image">{{ __('admin.subscription_plans.banner_image') }}</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control @error('cover_image') is-invalid @enderror"
                                id="cover_image" name="cover_image" accept="image/*" onchange="previewBanner(event)">
                            @error('cover_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">{{ __('admin.subscription_plans.banner_help') }}</div>

                            <!-- Preview -->
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
                                rows="3" placeholder="Enter plan description">{{ old('description') }}</textarea>
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
                                name="price" value="{{ old('price') }}" min="0" step="0.01" placeholder="0"
                                required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">{{ __('admin.subscription_plans.price_help') }}</div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="duration_days">{{ __('admin.subscription_plans.duration_days') }} <span
                                class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <select class="form-select @error('duration_days') is-invalid @enderror" id="duration_select"
                                        required>
                                        <option value="">{{ __('admin.common.select') }} {{ __('admin.subscription_history.duration') }}</option>
                                        <option value="30" {{ old('duration_days') == 30 ? 'selected' : '' }}>1 {{ __('admin.receipt.month') }} (30 {{ __('admin.receipt.days') }})</option>
                                        <option value="180" {{ old('duration_days') == 180 ? 'selected' : '' }}>6 {{ __('admin.receipt.months') }} (180 {{ __('admin.receipt.days') }})</option>
                                        <option value="365" {{ old('duration_days') == 365 ? 'selected' : '' }}>1 {{ __('admin.receipt.year') }} (365 {{ __('admin.receipt.days') }})</option>
                                        <option value="custom">Custom Duration</option>
                                    </select>
                                    @error('duration_days')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6" id="customDurationDiv" style="display: none;">
                                    <input type="number" class="form-control" id="custom_duration" min="1"
                                        placeholder="Enter custom days">
                                </div>
                            </div>
                            <!-- Hidden input that will be submitted -->
                            <input type="hidden" name="duration_days" id="duration_days" value="{{ old('duration_days') }}">
                        </div>
                    </div>

                    {{-- Features input removed as requested --}}

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="button_text">{{ __('admin.subscription_plans.button_text') }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('button_text') is-invalid @enderror" 
                                id="button_text" name="button_text" value="{{ old('button_text') }}" 
                                placeholder="e.g., Get Started, Subscribe Now, Choose Plan">
                            @error('button_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">{{ __('admin.subscription_plans.button_text_help') }}</div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">{{ __('admin.ebooks.status') }}</label>
                        <div class="col-sm-10">
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                    {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    {{ __('admin.status.active') }} ({{ __('admin.subscription_plans.available_to_subscribe') }})
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-10 offset-sm-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-save me-1"></i> {{ __('admin.subscription_plans.add_plan') }}
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
            document.addEventListener('DOMContentLoaded', function() {
                const durationSelect = document.getElementById('duration_select');
                const hiddenInput = document.getElementById('duration_days');
                const customDiv = document.getElementById('customDurationDiv');
                const customInput = document.getElementById('custom_duration');
                const form = document.querySelector('form');

                // Handle duration change
                durationSelect.addEventListener('change', function() {
                    if (this.value === 'custom') {
                        customDiv.style.display = 'block';
                        customInput.required = true;
                        customInput.focus();
                        hiddenInput.value = ''; // Clear hidden input
                    } else {
                        customDiv.style.display = 'none';
                        customInput.required = false;
                        customInput.value = '';
                        hiddenInput.value = this.value; // Set hidden input to selected value
                    }
                });

                // Update hidden input when custom duration changes
                customInput.addEventListener('input', function() {
                    if (durationSelect.value === 'custom' && this.value) {
                        hiddenInput.value = this.value;
                    }
                });

                // Handle form submission
                form.addEventListener('submit', function(e) {
                    // If custom duration is selected, validate and set hidden input
                    if (durationSelect.value === 'custom') {
                        if (!customInput.value || customInput.value <= 0) {
                            e.preventDefault();
                            alert('Silakan masukkan durasi custom (minimal 1 hari)');
                            customInput.focus();
                            return false;
                        }
                        // Make sure hidden input has the custom value
                        hiddenInput.value = customInput.value;
                    }
                    
                    return true;
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
                    };
                    reader.readAsDataURL(file);
                }
            }

            function removeBanner() {
                document.getElementById('cover_image').value = '';
                document.getElementById('bannerPreview').style.display = 'none';
                document.getElementById('bannerPreviewImg').src = '';
            }
        </script>
    @endpush
@endsection
