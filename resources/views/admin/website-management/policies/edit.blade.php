@extends('layouts.admin')

@section('title', 'Edit Section - ' . $pageTypeName)

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Page Header -->
        <div class="mb-4">
            <h4 class="fw-bold py-3 mb-2">
                <span class="text-muted fw-light">{{ __('admin.menu.website_setting') }} / Policy / {{ $pageTypeName }} /</span> Edit Section
            </h4>
        </div>

        <!-- Form Card -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Section Information</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route("admin.policies.{$pageTypeSlug}.update", $section->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Section Title -->
                            <div class="mb-4">
                                <label for="section_title" class="form-label">Section Title</label>
                                <input type="text" class="form-control @error('section_title') is-invalid @enderror" 
                                    id="section_title" name="section_title" value="{{ old('section_title', $section->section_title) }}" 
                                    placeholder="e.g., 1. How to Register" maxlength="255">
                                @error('section_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Main section heading (optional)</small>
                            </div>

                            <!-- Subsection Title -->
                            <div class="mb-4">
                                <label for="subsection_title" class="form-label">Subsection Title</label>
                                <input type="text" class="form-control @error('subsection_title') is-invalid @enderror" 
                                    id="subsection_title" name="subsection_title" value="{{ old('subsection_title', $section->subsection_title) }}" 
                                    placeholder="e.g., 1.1. Via Website" maxlength="255">
                                @error('subsection_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Subsection heading (optional)</small>
                            </div>

                            <!-- Content -->
                            <div class="mb-4">
                                <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('content') is-invalid @enderror" 
                                    id="content" name="content" rows="10" 
                                    placeholder="Enter the content... (Use new lines for list items)" required>{{ old('content', $section->content) }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Plain text content. Use line breaks for list items.</small>
                            </div>

                            <!-- Order Index -->
                            <div class="mb-4">
                                <label for="order_index" class="form-label">Display Order <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('order_index') is-invalid @enderror" 
                                    id="order_index" name="order_index" value="{{ old('order_index', $section->order_index) }}" 
                                    min="0" required>
                                @error('order_index')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Lower numbers appear first</small>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-check me-1"></i> Update Section
                                </button>
                                <a href="{{ route("admin.policies.{$pageTypeSlug}.index") }}" class="btn btn-label-secondary">
                                    <i class="ti ti-x me-1"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Info Sidebar -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="ti ti-info-circle me-2"></i>Section Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted d-block">Page Type</small>
                            <strong>{{ $pageTypeName }}</strong>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block">Created</small>
                            <strong>{{ $section->created_at->format('d M Y, H:i') }}</strong>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block">Last Updated</small>
                            <strong>{{ $section->updated_at->format('d M Y, H:i') }}</strong>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block">Order Index</small>
                            <span class="badge bg-label-secondary">{{ $section->order_index }}</span>
                        </div>

                        <hr>

                        <div class="alert alert-warning mb-0">
                            <small>
                                <i class="ti ti-alert-triangle me-1"></i>
                                Changes will be visible immediately on the website.
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Content Preview -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="ti ti-eye me-2"></i>Content Preview</h5>
                    </div>
                    <div class="card-body">
                        @if($section->section_title)
                        <h6 class="fw-bold">{{ $section->section_title }}</h6>
                        @endif
                        
                        @if($section->subsection_title)
                        <p class="text-muted small mb-2">{{ $section->subsection_title }}</p>
                        @endif
                        
                        <div class="small">
                            @foreach(explode("\n", $section->content) as $line)
                                @if(trim($line))
                                <div class="mb-1">• {{ trim($line) }}</div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
