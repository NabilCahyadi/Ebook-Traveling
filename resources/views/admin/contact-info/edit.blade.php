@extends('layouts.admin')

@section('title', 'Edit Contact Info')

@section('content')
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <span class="text-muted fw-light">
                    <a href="{{ route('admin.contact-info.index') }}" class="text-muted">Website Management / Contact Info</a> /
                </span> Edit
            </h4>
            <p class="mb-0">Edit informasi kontak</p>
        </div>
        <a href="{{ route('admin.contact-info.index') }}" class="btn btn-label-secondary">
            <i class="ti ti-arrow-left me-1"></i> Back to List
        </a>
    </div>

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> Please check the form below.
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Form Card -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Contact Information</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.contact-info.update', $contactInfo->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Contact Type -->
                    <div class="col-md-6 mb-3">
                        <label for="contact_type" class="form-label">Contact Type <span class="text-danger">*</span></label>
                        <select class="form-select @error('contact_type') is-invalid @enderror" 
                                id="contact_type" 
                                name="contact_type" 
                                required>
                            <option value="">-- Select Type --</option>
                            <option value="whatsapp" {{ old('contact_type', $contactInfo->contact_type) == 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                            <option value="email" {{ old('contact_type', $contactInfo->contact_type) == 'email' ? 'selected' : '' }}>Email</option>
                            <option value="phone" {{ old('contact_type', $contactInfo->contact_type) == 'phone' ? 'selected' : '' }}>Phone</option>
                            <option value="instagram" {{ old('contact_type', $contactInfo->contact_type) == 'instagram' ? 'selected' : '' }}>Instagram</option>
                            <option value="facebook" {{ old('contact_type', $contactInfo->contact_type) == 'facebook' ? 'selected' : '' }}>Facebook</option>
                            <option value="twitter" {{ old('contact_type', $contactInfo->contact_type) == 'twitter' ? 'selected' : '' }}>Twitter/X</option>
                            <option value="address" {{ old('contact_type', $contactInfo->contact_type) == 'address' ? 'selected' : '' }}>Address</option>
                            <option value="linkedin" {{ old('contact_type', $contactInfo->contact_type) == 'linkedin' ? 'selected' : '' }}>LinkedIn</option>
                            <option value="youtube" {{ old('contact_type', $contactInfo->contact_type) == 'youtube' ? 'selected' : '' }}>YouTube</option>
                            <option value="other" {{ old('contact_type', $contactInfo->contact_type) == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('contact_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Title -->
                    <div class="col-md-6 mb-3">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('title') is-invalid @enderror" 
                               id="title"
                               name="title" 
                               value="{{ old('title', $contactInfo->title) }}" 
                               placeholder="e.g., WhatsApp Support" 
                               required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="col-md-12 mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description"
                                  rows="3" 
                                  placeholder="Enter description (optional)">{{ old('description', $contactInfo->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Link -->
                    <div class="col-md-12 mb-3">
                        <label for="link" class="form-label">Link</label>
                        <input type="text" 
                               class="form-control @error('link') is-invalid @enderror" 
                               id="link"
                               name="link" 
                               value="{{ old('link', $contactInfo->link) }}" 
                               placeholder="e.g., https://wa.me/628123456789 or mailto:support@example.com">
                        <small class="form-text text-muted">
                            Examples: https://wa.me/628xxx, mailto:email@example.com, tel:+6281xxx
                        </small>
                        @error('link')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Icon Class -->
                    <div class="col-md-12 mb-3">
                        <label for="icon_class" class="form-label">Icon Class</label>
                        <div class="input-group">
                            <span class="input-group-text" id="selectedIconPreview">
                                @if($contactInfo->icon_class)
                                    <i class="{{ $contactInfo->icon_class }}"></i>
                                @else
                                    <i class="ti ti-icons"></i>
                                @endif
                            </span>
                            <input type="text" 
                                   class="form-control @error('icon_class') is-invalid @enderror" 
                                   id="icon_class"
                                   name="icon_class" 
                                   value="{{ old('icon_class', $contactInfo->icon_class) }}" 
                                   placeholder="e.g., bi bi-whatsapp or ti ti-brand-whatsapp"
                                   readonly>
                            <button class="btn btn-outline-primary" type="button" id="iconPreviewBtn">
                                <i class="ti ti-search"></i> Browse Icons
                            </button>
                        </div>
                        <small class="form-text text-muted">
                            Click "Browse Icons" to select from available icons
                        </small>
                        @error('icon_class')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Checkboxes -->
                    <div class="col-md-6 mb-3">
                        <div class="form-check">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="is_active" 
                                   name="is_active"
                                   {{ old('is_active', $contactInfo->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Is Active
                            </label>
                        </div>
                        <small class="form-text text-muted">Tampilkan contact info ini</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-check">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="show_in_contact_page" 
                                   name="show_in_contact_page"
                                   {{ old('show_in_contact_page', $contactInfo->show_in_contact_page) ? 'checked' : '' }}>
                            <label class="form-check-label" for="show_in_contact_page">
                                Show in Contact Page
                            </label>
                        </div>
                        <small class="form-text text-muted">Tampilkan di halaman Contact Us</small>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="ti ti-check me-1"></i> Update
                    </button>
                    <a href="{{ route('admin.contact-info.index') }}" class="btn btn-label-secondary">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    @include('admin.contact-info.partials._icon-picker')
@endsection
