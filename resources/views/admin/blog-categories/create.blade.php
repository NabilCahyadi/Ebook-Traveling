@extends('layouts.admin')

@section('title', 'Create Blog Category')

@section('content')

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold py-3 mb-2">
                <span class="text-muted fw-light">Admin / Content Management / Blog Categories /</span> Create
            </h4>
        </div>
        <div>
            <a href="{{ route('admin.blog-categories.index') }}" class="btn btn-secondary">
                <i class="ti ti-arrow-left me-1"></i> Back to List
            </a>
        </div>
    </div>

    <!-- Create Form -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Create New Blog Category</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.blog-categories.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">The category name will be displayed in dropdowns and forms</small>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                                name="description" rows="4">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Optional description for internal reference</small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="card-title">Category Settings</h6>

                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                            {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Active
                                        </label>
                                    </div>
                                    <small class="text-muted">Only active categories will appear in blog forms</small>
                                </div>

                                <hr>

                                <div class="alert alert-info mb-0">
                                    <i class="ti ti-info-circle me-1"></i>
                                    <small>The slug will be automatically generated from the category name</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-check me-1"></i> Create Category
                    </button>
                    <a href="{{ route('admin.blog-categories.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

@endsection
