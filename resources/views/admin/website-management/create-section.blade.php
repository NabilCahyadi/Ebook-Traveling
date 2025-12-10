@extends('layouts.admin')

@section('title', 'Add New Section')

@section('content')
    <div class="container-xl">
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">Add New Landing Page Section</h2>
                    <div class="text-muted mt-1">Create a new section for your landing page</div>
                </div>
                <div class="col-auto ms-auto">
                    <a href="{{ route('admin.landing-sections') }}" class="btn btn-outline-secondary">
                        <i class="ti ti-arrow-left"></i> Back to Sections
                    </a>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <form action="{{ route('admin.landing-section.store') }}" method="POST" enctype="multipart/form-data"
                    id="createSectionForm">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Section Details</h3>
                        </div>
                        <div class="card-body">
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Validation Error:</strong>
                                    <ul class="mb-0 mt-2">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <!-- Section Type -->
                            <div class="mb-3">
                                <label class="form-label required">Section Type</label>
                                <select name="section_type" id="sectionType" class="form-select" required>
                                    <option value="">Select Section Type</option>
                                    @foreach ($sectionTypes as $key => $label)
                                        <option value="{{ $key }}"
                                            {{ old('section_type') == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('section_type')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Section Name -->
                            <div class="mb-3">
                                <label class="form-label required">Section Name (Internal)</label>
                                <input type="text" name="section_name" class="form-control"
                                    placeholder="e.g., Homepage Hero, About Us" value="{{ old('section_name') }}" required>
                                <small class="form-hint">This is for admin reference only</small>
                                @error('section_name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Section Title (Optional) -->
                            <div class="mb-3">
                                <label class="form-label">Section Title (Optional)</label>
                                <input type="text" name="section_title" class="form-control"
                                    placeholder="e.g., Our Features" value="{{ old('section_title') }}">
                                <small class="form-hint">Public-facing title that may appear above the section</small>
                                @error('section_title')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Visibility -->
                            <div class="mb-3">
                                <label class="form-check form-switch">
                                    <input type="checkbox" name="is_visible" class="form-check-input"
                                        {{ old('is_visible') ? 'checked' : '' }}>
                                    <span class="form-check-label">Section Visible</span>
                                </label>
                                <small class="form-hint d-block">Enable this to show the section on the landing page</small>
                            </div>

                            <hr class="my-4">

                            <!-- Dynamic Content Area -->
                            <div id="dynamicContent">
                                <div class="text-muted text-center py-5">
                                    <i class="ti ti-cursor-text" style="font-size: 3rem; opacity: 0.3;"></i>
                                    <p class="mt-2">Select a section type above to configure its content</p>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer text-end">
                            <button type="button" class="btn btn-link"
                                onclick="window.location='{{ route('admin.landing-sections') }}'">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="ti ti-device-floppy"></i> Create Section
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .repeater-item {
            border: 1px solid #e6e7e9;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            background: #f8f9fa;
            position: relative;
        }

        .repeater-item .remove-item {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
        }

        .image-preview {
            max-width: 200px;
            max-height: 200px;
            margin-top: 0.5rem;
            border-radius: 4px;
            border: 1px solid #dee2e6;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sectionType = document.getElementById('sectionType');
            const dynamicContent = document.getElementById('dynamicContent');
            const form = document.getElementById('createSectionForm');

            sectionType.addEventListener('change', function() {
                const type = this.value;
                if (!type) {
                    dynamicContent.innerHTML = `
                <div class="text-muted text-center py-5">
                    <i class="ti ti-cursor-text" style="font-size: 3rem; opacity: 0.3;"></i>
                    <p class="mt-2">Select a section type above to configure its content</p>
                </div>
            `;
                    return;
                }

                let html = '';

                switch (type) {
                    case 'hero':
                        html = `
                    <h3 class="mb-3">Hero Section Content</h3>
                    <div class="mb-3">
                        <label class="form-label required">Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Subtitle</label>
                        <textarea name="subtitle" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Button Text</label>
                            <input type="text" name="button_text" class="form-control" placeholder="e.g., Get Started">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Button Link</label>
                            <input type="text" name="button_link" class="form-control" placeholder="e.g., /register">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hero Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(this, 'heroPreview')">
                        <img id="heroPreview" class="image-preview" style="display:none;">
                    </div>
                `;
                        break;

                    case 'about':
                        html = `
                    <h3 class="mb-3">About Section Content</h3>
                    <div class="mb-3">
                        <label class="form-label required">Heading</label>
                        <input type="text" name="heading" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Description</label>
                        <textarea name="description" class="form-control" rows="5" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(this, 'aboutPreview')">
                        <img id="aboutPreview" class="image-preview" style="display:none;">
                    </div>
                `;
                        break;

                    case 'features':
                        html = `
                    <h3 class="mb-3">Features Section Content</h3>
                    <div id="featuresRepeater">
                        ${createFeatureItem(0)}
                    </div>
                    <button type="button" class="btn btn-outline-primary" onclick="addFeatureItem()">
                        <i class="ti ti-plus"></i> Add Feature
                    </button>
                `;
                        break;

                    case 'services':
                        html = `
                    <h3 class="mb-3">Services Section Content</h3>
                    <div id="servicesRepeater">
                        ${createServiceItem(0)}
                    </div>
                    <button type="button" class="btn btn-outline-primary" onclick="addServiceItem()">
                        <i class="ti ti-plus"></i> Add Service
                    </button>
                `;
                        break;

                    case 'testimonial':
                        html = `
                    <h3 class="mb-3">Testimonial Section Content</h3>
                    <div id="testimonialRepeater">
                        ${createTestimonialItem(0)}
                    </div>
                    <button type="button" class="btn btn-outline-primary" onclick="addTestimonialItem()">
                        <i class="ti ti-plus"></i> Add Testimonial
                    </button>
                `;
                        break;

                    case 'cta':
                        html = `
                    <h3 class="mb-3">Call to Action Content</h3>
                    <div class="mb-3">
                        <label class="form-label required">Text</label>
                        <textarea name="text" class="form-control" rows="2" required></textarea>
                        <div class="invalid-feedback">Please provide text for the call to action.</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label required">Button Text</label>
                            <input type="text" name="button_text" class="form-control" required>
                            <div class="invalid-feedback">Please provide button text.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label required">Button Link</label>
                            <input type="text" name="button_link" class="form-control" required>
                            <div class="invalid-feedback">Please provide button link.</div>
                        </div>
                    </div>
                `;
                        break;

                    case 'faq':
                        html = `
                    <h3 class="mb-3">FAQ Section Content</h3>
                    <div id="faqRepeater">
                        ${createFaqItem(0)}
                    </div>
                    <button type="button" class="btn btn-outline-primary" onclick="addFaqItem()">
                        <i class="ti ti-plus"></i> Add FAQ
                    </button>
                `;
                        break;

                    case 'gallery':
                        html = `
                    <h3 class="mb-3">Gallery Section Content</h3>
                    <div class="mb-3">
                        <label class="form-label required">Gallery Images</label>
                        <input type="file" name="images[]" class="form-control" accept="image/*" multiple required onchange="previewMultipleImages(this, 'galleryPreview')">
                        <small class="form-hint">Hold Ctrl/Cmd to select multiple images</small>
                        <div id="galleryPreview" class="mt-2 d-flex flex-wrap gap-2"></div>
                    </div>
                `;
                        break;

                    case 'contact':
                        html = `
                    <h3 class="mb-3">Contact Section Content</h3>
                    <div class="mb-3">
                        <label class="form-label required">Address</label>
                        <textarea name="address" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label required">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label required">Phone</label>
                            <input type="tel" name="phone" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Map Embed Link</label>
                        <textarea name="map_embed" class="form-control" rows="3" placeholder="Paste Google Maps embed code here"></textarea>
                    </div>
                `;
                        break;

                    case 'collection':
                        html = `
                    <h3 class="mb-3">Collection Section Content</h3>
                    <div class="mb-3">
                        <label class="form-label required">Collection</label>
                        <select name="collection_id" class="form-select" required>
                            <option value="">Select Collection</option>
                            @foreach ($collections as $collection)
                                <option value="{{ $collection->id }}">{{ $collection->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Filter Type</label>
                        <select name="filter_type" class="form-select" required onchange="toggleCollectionFilters(this)">
                            <option value="all">All Ebooks</option>
                            <option value="category">By Category</option>
                            <option value="city">By City</option>
                            <option value="language">By Language</option>
                            <option value="latest">Latest Ebooks</option>
                            <option value="popular">Popular Ebooks</option>
                            <option value="top_rated">Top Rated</option>
                        </select>
                    </div>
                    <div class="mb-3" id="categoryFilter" style="display:none;">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-select">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3" id="cityFilter" style="display:none;">
                        <label class="form-label">City</label>
                        <select name="city_id" class="form-select">
                            <option value="">Select City</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3" id="languageFilter" style="display:none;">
                        <label class="form-label">Language</label>
                        <select name="language" class="form-select">
                            <option value="">Select Language</option>
                            <option value="en">English</option>
                            <option value="id">Indonesian</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Card Template</label>
                        <select name="card_template" class="form-select">
                            <option value="default">Default</option>
                            <option value="compact">Compact</option>
                            <option value="grid">Grid</option>
                            <option value="list">List</option>
                        </select>
                    </div>
                `;
                        break;

                    case 'hero_banner':
                    case 'top_cities':
                    case 'subscription_plans':
                    case 'latest_blogs':
                        html = `
                    <div class="alert alert-info">
                        <i class="ti ti-info-circle"></i>
                        This section type has predefined content and doesn't require additional configuration.
                    </div>
                `;
                        break;

                    default:
                        html =
                            '<div class="alert alert-warning">No content configuration available for this section type.</div>';
                }

                dynamicContent.innerHTML = html;
            });

            // Restore selected type on page load if validation failed
            if (sectionType.value) {
                sectionType.dispatchEvent(new Event('change'));
            }
        });

        // Helper functions for repeater items
        function createFeatureItem(index) {
            return `
        <div class="repeater-item" data-index="${index}">
            <button type="button" class="btn btn-sm btn-danger remove-item" onclick="removeRepeaterItem(this)">
                <i class="ti ti-x"></i>
            </button>
            <div class="mb-2">
                <label class="form-label">Icon (Tabler Icon class)</label>
                <input type="text" name="items[${index}][icon]" class="form-control" placeholder="e.g., ti-star">
            </div>
            <div class="mb-2">
                <label class="form-label required">Title</label>
                <input type="text" name="items[${index}][title]" class="form-control" required>
            </div>
            <div class="mb-2">
                <label class="form-label required">Description</label>
                <textarea name="items[${index}][description]" class="form-control" rows="2" required></textarea>
            </div>
        </div>
    `;
        }

        function createServiceItem(index) {
            return createFeatureItem(index); // Same structure
        }

        function createTestimonialItem(index) {
            return `
        <div class="repeater-item" data-index="${index}">
            <button type="button" class="btn btn-sm btn-danger remove-item" onclick="removeRepeaterItem(this)">
                <i class="ti ti-x"></i>
            </button>
            <div class="mb-2">
                <label class="form-label required">Name</label>
                <input type="text" name="items[${index}][name]" class="form-control" required>
            </div>
            <div class="mb-2">
                <label class="form-label required">Position</label>
                <input type="text" name="items[${index}][position]" class="form-control" placeholder="e.g., CEO at Company" required>
            </div>
            <div class="mb-2">
                <label class="form-label required">Message</label>
                <textarea name="items[${index}][message]" class="form-control" rows="3" required></textarea>
            </div>
            <div class="mb-2">
                <label class="form-label">Photo</label>
                <input type="file" name="items[${index}][photo]" class="form-control" accept="image/*" onchange="previewImage(this, 'testimonialPreview${index}')">
                <img id="testimonialPreview${index}" class="image-preview" style="display:none;">
            </div>
        </div>
    `;
        }

        function createFaqItem(index) {
            return `
        <div class="repeater-item" data-index="${index}">
            <button type="button" class="btn btn-sm btn-danger remove-item" onclick="removeRepeaterItem(this)">
                <i class="ti ti-x"></i>
            </button>
            <div class="mb-2">
                <label class="form-label required">Question</label>
                <input type="text" name="items[${index}][question]" class="form-control" required>
            </div>
            <div class="mb-2">
                <label class="form-label required">Answer</label>
                <textarea name="items[${index}][answer]" class="form-control" rows="3" required></textarea>
            </div>
        </div>
    `;
        }

        let itemCounter = 1;

        function addFeatureItem() {
            document.getElementById('featuresRepeater').insertAdjacentHTML('beforeend', createFeatureItem(itemCounter++));
        }

        function addServiceItem() {
            document.getElementById('servicesRepeater').insertAdjacentHTML('beforeend', createServiceItem(itemCounter++));
        }

        function addTestimonialItem() {
            document.getElementById('testimonialRepeater').insertAdjacentHTML('beforeend', createTestimonialItem(
                itemCounter++));
        }

        function addFaqItem() {
            document.getElementById('faqRepeater').insertAdjacentHTML('beforeend', createFaqItem(itemCounter++));
        }

        function removeRepeaterItem(btn) {
            btn.closest('.repeater-item').remove();
        }

        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewMultipleImages(input, containerId) {
            const container = document.getElementById(containerId);
            container.innerHTML = '';

            if (input.files) {
                Array.from(input.files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'image-preview';
                        container.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                });
            }
        }

        function toggleCollectionFilters(select) {
            document.getElementById('categoryFilter').style.display = 'none';
            document.getElementById('cityFilter').style.display = 'none';
            document.getElementById('languageFilter').style.display = 'none';

            switch (select.value) {
                case 'category':
                    document.getElementById('categoryFilter').style.display = 'block';
                    break;
                case 'city':
                    document.getElementById('cityFilter').style.display = 'block';
                    break;
                case 'language':
                    document.getElementById('languageFilter').style.display = 'block';
                    break;
            }
        }

        // Bootstrap form validation
        (function() {
            'use strict';
            const form = document.getElementById('createSectionForm');

            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        })();
    </script>
@endsection
