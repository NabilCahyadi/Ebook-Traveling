@extends('layouts.admin')

@section('title', 'Edit Contact Info')

@section('content')
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <span class="text-muted fw-light">
                    <a href="{{ route('admin.contact-info.index') }}" class="text-muted">{{ __('admin.menu.website_setting') }} / {{ __('admin.contact_info.title') }}</a> /
                </span> {{ __('admin.actions.edit') }}
            </h4>
            <p class="mb-0">{{ __('admin.contact_info.edit_subtitle') }}</p>
        </div>
        <a href="{{ route('admin.contact-info.index') }}" class="btn btn-label-secondary">
            <i class="ti ti-arrow-left me-1"></i> {{ __('admin.actions.back_to_list') }}
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
            <h5 class="mb-0">{{ __('admin.contact_info.form_title') }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.contact-info.update', $contactInfo->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Contact Type (Read Only) -->
                    <div class="col-md-6 mb-3">
                        <label for="contact_type" class="form-label">{{ __('admin.contact_info.contact_type') }} <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control" 
                               value="{{ ucfirst($contactInfo->contact_type) }}" 
                               readonly 
                               style="background-color: #f5f5f5; cursor: not-allowed;">
                        <!-- Hidden field to maintain contact_type value on submit -->
                        <input type="hidden" name="contact_type" value="{{ $contactInfo->contact_type }}">
                        <!-- <small class="text-muted">Contact type tidak dapat diubah</small> -->
                        @error('contact_type')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Title -->
                    <div class="col-md-6 mb-3">
                        <label for="title" class="form-label">{{ __('admin.contact_info.title_label') }} <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('title') is-invalid @enderror" 
                               id="title"
                               name="title" 
                               value="{{ old('title', $contactInfo->title) }}" 
                               placeholder="{{ __('admin.contact_info.title_placeholder') }}" 
                               required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="col-md-12 mb-3">
                        <label for="description" class="form-label">{{ __('admin.contact_info.description') }}</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description"
                                  rows="3" 
                                  placeholder="{{ __('admin.contact_info.description_placeholder') }}">{{ old('description', $contactInfo->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Link -->
                    <div class="col-md-12 mb-3">
                        <label for="link" class="form-label">{{ __('admin.contact_info.link') }}</label>
                        <input type="text" 
                               class="form-control @error('link') is-invalid @enderror" 
                               id="link"
                               name="link" 
                               value="{{ old('link', $contactInfo->link) }}" 
                               placeholder="{{ __('admin.contact_info.link_placeholder') }}">
                        <small class="form-text text-muted">
                            {{ __('admin.contact_info.link_examples') }}
                        </small>
                        @error('link')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Icon Class -->
                    <div class="col-md-12 mb-3">
                        <label for="icon_class" class="form-label">{{ __('admin.contact_info.icon_class') }}</label>
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
                                   placeholder="{{ __('admin.contact_info.icon_placeholder') }}"
                                   readonly>
                            <button class="btn btn-outline-primary" type="button" id="iconPreviewBtn">
                                <i class="ti ti-search"></i> {{ __('admin.contact_info.browse_icons') }}
                            </button>
                        </div>
                        <small class="form-text text-muted">
                            {{ __('admin.contact_info.icon_help') }}
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
                                {{ __('admin.contact_info.is_active') }}
                            </label>
                        </div>
                        <small class="form-text text-muted">{{ __('admin.contact_info.is_active_help') }}</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-check">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="show_in_contact_page" 
                                   name="show_in_contact_page"
                                   {{ old('show_in_contact_page', $contactInfo->show_in_contact_page) ? 'checked' : '' }}>
                            <label class="form-check-label" for="show_in_contact_page">
                                {{ __('admin.contact_info.show_in_contact_page') }}
                            </label>
                        </div>
                        <small class="form-text text-muted">{{ __('admin.contact_info.show_in_contact_page_help') }}</small>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="ti ti-check me-1"></i> {{ __('admin.actions.update') }}
                    </button>
                    <a href="{{ route('admin.contact-info.index') }}" class="btn btn-label-secondary">
                        {{ __('admin.actions.cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </div>

    @include('admin.contact-info.partials._icon-picker')
@endsection
