@extends('layouts.admin')

@section('title', __('admin.blog_categories.edit_category'))

@section('content')

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold py-3 mb-2">
                <span class="text-muted fw-light">{{ __('admin.menu.admin') }} / {{ __('admin.menu.content_management') }} / {{ __('admin.blog_categories.blog_categories') }} /</span> {{ __('admin.blog_categories.edit') }}
            </h4>
        </div>
        <div>
            <a href="{{ route('admin.blog-categories.index') }}" class="btn btn-secondary">
                <i class="ti ti-arrow-left me-1"></i> {{ __('admin.blog_categories.back_to_list') }}
            </a>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">{{ __('admin.blog_categories.edit_category') }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.blog-categories.update', $blogCategory->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('admin.blog_categories.category_name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $blogCategory->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">{{ __('admin.blog_categories.name_help') }}</small>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('admin.blog_categories.description') }}</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                                name="description" rows="4">{{ old('description', $blogCategory->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">{{ __('admin.blog_categories.description_help') }}</small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="card-title">{{ __('admin.blog_categories.category_settings') }}</h6>

                                <div class="mb-3">
                                    <label class="form-label">{{ __('admin.blog_categories.status') }}</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                            {{ old('is_active', $blogCategory->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            {{ __('admin.blog_categories.active') }}
                                        </label>
                                    </div>
                                    <small class="text-muted">{{ __('admin.blog_categories.active_help') }}</small>
                                </div>

                                <hr>

                                <div class="mb-3">
                                    <label class="form-label">{{ __('admin.blog_categories.current_slug') }}</label>
                                    <div>
                                        <code>{{ $blogCategory->slug }}</code>
                                    </div>
                                    <small class="text-muted">{{ __('admin.blog_categories.slug_auto_update') }}</small>
                                </div>

                                <hr>

                                <div class="mb-0">
                                    <label class="form-label">{{ __('admin.blog_categories.blogs_count') }}</label>
                                    <div>
                                        <span class="badge bg-label-primary">{{ $blogCategory->blogs()->count() }} {{ __('admin.blog_categories.blogs') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-check me-1"></i> {{ __('admin.blog_categories.update_category') }}
                    </button>
                    <a href="{{ route('admin.blog-categories.index') }}" class="btn btn-secondary">
                        {{ __('admin.blog_categories.cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </div>

@endsection
