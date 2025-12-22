@extends('layouts.admin')

@section('title', 'Edit Subscription Plan')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">Admin / Subscription Plans /</span> Edit
            </h4>
            <a href="{{ route('admin.subscription-plans.index') }}" class="btn btn-secondary">
                <i class="bx bx-arrow-back me-1"></i> Back
            </a>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Subscription Plan: {{ $plan->name }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.subscription-plans.update', $plan->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="name">Plan Name <span
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
                        <label class="col-sm-2 col-form-label" for="cover_image">Banner Image</label>
                        <div class="col-sm-10">
                            @if ($plan->cover_image)
                                <div class="mb-2">
                                    <div class="border rounded p-2" style="max-width: 600px;">
                                        <img src="{{ asset('storage/' . $plan->cover_image) }}" alt="Current Banner"
                                            style="width: 100%; height: auto; border-radius: 0.375rem;">
                                        <small class="text-muted d-block mt-1">Current banner image</small>
                                    </div>
                                </div>
                            @endif

                            <input type="file" class="form-control @error('cover_image') is-invalid @enderror"
                                id="cover_image" name="cover_image" accept="image/*" onchange="previewBanner(event)">
                            @error('cover_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Upload a new banner image to replace the current one (Optional,
                                recommended size: 1200x400px)</div>

                            <!-- Preview -->
                            <div id="bannerPreview" class="mt-3" style="display: none;">
                                <div class="border rounded p-2" style="max-width: 600px;">
                                    <img id="bannerPreviewImg" src="" alt="Banner Preview"
                                        style="width: 100%; height: auto; border-radius: 0.375rem;">
                                    <button type="button" class="btn btn-sm btn-label-danger mt-2"
                                        onclick="removeBanner()">
                                        <i class="ti ti-x me-1"></i> Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="description">Description</label>
                        <div class="col-sm-10">
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                rows="3" placeholder="Enter plan description">{{ old('description', $plan->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="price">Price (Rp) <span
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
                        <label class="col-sm-2 col-form-label" for="duration_days">Duration (Days) <span
                                class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <select class="form-select @error('duration_days') is-invalid @enderror" id="duration_select"
                                        required>
                                        <option value="">Select Duration</option>
                                        <option value="30"
                                            {{ old('duration_days', $plan->duration_days) == 30 ? 'selected' : '' }}>1 Month (30 Days)</option>
                                        <option value="180"
                                            {{ old('duration_days', $plan->duration_days) == 180 ? 'selected' : '' }}>6 Months (180 Days)</option>
                                        <option value="365"
                                            {{ old('duration_days', $plan->duration_days) == 365 ? 'selected' : '' }}>1 Year (365 Days)</option>
                                        <option value="custom"
                                            {{ !in_array(old('duration_days', $plan->duration_days), [30, 180, 365]) ? 'selected' : '' }}>
                                            Custom Duration</option>
                                    </select>
                                    @error('duration_days')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6" id="customDurationDiv"
                                    style="display: {{ !in_array(old('duration_days', $plan->duration_days), [30, 180, 365]) ? 'block' : 'none' }};">
                                    <input type="number" class="form-control" id="custom_duration"
                                        value="{{ !in_array($plan->duration_days, [30, 180, 365]) ? $plan->duration_days : '' }}"
                                        min="1" placeholder="Enter custom days">
                                </div>
                            </div>
                            <!-- Hidden input that will be submitted -->
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
                        <label class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-10">
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                    {{ old('is_active', $plan->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active (Available for users to subscribe)
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-10 offset-sm-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-save me-1"></i> Update Plan
                            </button>
                            <a href="{{ route('admin.subscription-plans.index') }}" class="btn btn-secondary">
                                Cancel
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
