@extends('layouts.admin')

@section('title', 'Add Section - ' . $pageTypeName)

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Page Header -->
        <div class="mb-4">
            <h4 class="fw-bold py-3 mb-2">
                <span class="text-muted fw-light">{{ __('admin.menu.website_setting') }} / Policy / {{ $pageTypeName }} /</span> Add Section
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
                        <form action="{{ route("admin.policies.{$pageTypeSlug}.store") }}" method="POST">
                            @csrf

                            <!-- Section Title -->
                            <div class="mb-4">
                                <label for="section_title" class="form-label">Section Title</label>
                                <input type="text" class="form-control @error('section_title') is-invalid @enderror" 
                                    id="section_title" name="section_title" value="{{ old('section_title') }}" 
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
                                    id="subsection_title" name="subsection_title" value="{{ old('subsection_title') }}" 
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
                                    placeholder="Enter the content... (Use new lines for list items)" required>{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Plain text content. Use line breaks for list items.</small>
                            </div>

                            <!-- Order Index -->
                            <div class="mb-4">
                                <label for="order_index" class="form-label">Display Order <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('order_index') is-invalid @enderror" 
                                    id="order_index" name="order_index" value="{{ old('order_index', $nextOrder) }}" 
                                    min="0" required>
                                @error('order_index')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Lower numbers appear first. Suggested: {{ $nextOrder }}</small>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-check me-1"></i> Save Section
                                </button>
                                <a href="{{ route("admin.policies.{$pageTypeSlug}.index") }}" class="btn btn-label-secondary">
                                    <i class="ti ti-x me-1"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Help Sidebar -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="ti ti-info-circle me-2"></i>Guidelines</h5>
                    </div>
                    <div class="card-body">
                        <h6 class="mb-3">Creating Policy Sections</h6>
                        
                        <div class="mb-3">
                            <strong class="d-block mb-2">Section Title:</strong>
                            <ul class="small mb-0">
                                <li>Use numbered format (1., 2., etc.)</li>
                                <li>Keep it descriptive</li>
                                <li>Optional - can be left empty</li>
                            </ul>
                        </div>

                        <div class="mb-3">
                            <strong class="d-block mb-2">Subsection Title:</strong>
                            <ul class="small mb-0">
                                <li>Use sub-numbered format (1.1., 1.2., etc.)</li>
                                <li>For detailed breakdown</li>
                                <li>Optional - can be left empty</li>
                            </ul>
                        </div>

                        <div class="mb-3">
                            <strong class="d-block mb-2">Content:</strong>
                            <ul class="small mb-0">
                                <li>Use plain text format</li>
                                <li>Each line becomes a list item</li>
                                <li>Be clear and concise</li>
                            </ul>
                        </div>

                        <div class="alert alert-info mb-0">
                            <small>
                                <i class="ti ti-bulb me-1"></i>
                                <strong>Tip:</strong> Content will be displayed as a list where each line break creates a new bullet point.
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Preview Card -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="ti ti-eye me-2"></i>Page Types</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <span class="badge bg-label-primary me-2">help</span>
                                Help Center
                            </li>
                            <li class="mb-2">
                                <span class="badge bg-label-info me-2">privacy</span>
                                Privacy Policy
                            </li>
                            <li class="mb-2">
                                <span class="badge bg-label-warning me-2">terms</span>
                                Terms & Conditions
                            </li>
                            <li class="mb-2">
                                <span class="badge bg-label-success me-2">shopping</span>
                                Shopping Policy
                            </li>
                            <li>
                                <span class="badge bg-label-danger me-2">payment</span>
                                Payment Policy
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
