@extends('layouts.admin')

@section('title', 'Add New FAQ ' . $categoryName)

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Page Header -->
        <div class="mb-4">
            <h4 class="fw-bold py-3 mb-2">
                <span class="text-muted fw-light">Web Setting / FAQ / {{ $categoryName }} /</span> Add New
            </h4>
        </div>

        <!-- Form Card -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">FAQ Information</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route("admin.faqs.{$categorySlug}.store") }}" method="POST">
                            @csrf

                            <!-- Question -->
                            <div class="mb-4">
                                <label for="question" class="form-label">Question <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('question') is-invalid @enderror" 
                                    id="question" name="question" value="{{ old('question') }}" 
                                    placeholder="Enter the question..." maxlength="500" required>
                                @error('question')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Maximum 500 characters</small>
                            </div>

                            <!-- Answer -->
                            <div class="mb-4">
                                <label for="answer" class="form-label">Answer <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('answer') is-invalid @enderror" 
                                    id="answer" name="answer" rows="6" 
                                    placeholder="Enter the answer..." required>{{ old('answer') }}</textarea>
                                @error('answer')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Provide a clear and concise answer</small>
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

                            <!-- Is Active -->
                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" 
                                        name="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Active (Display on website)
                                    </label>
                                </div>
                                <small class="text-muted">Toggle to show/hide this FAQ on the website</small>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-check me-1"></i> Save FAQ
                                </button>
                                <a href="{{ route("admin.faqs.{$categorySlug}.index") }}" class="btn btn-label-secondary">
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
                        <h6 class="mb-3">Creating Effective FAQs</h6>
                        
                        <div class="mb-3">
                            <strong class="d-block mb-2">Questions:</strong>
                            <ul class="small mb-0">
                                <li>Keep it concise and clear</li>
                                <li>Use natural language</li>
                                <li>Focus on one topic per question</li>
                            </ul>
                        </div>

                        <div class="mb-3">
                            <strong class="d-block mb-2">Answers:</strong>
                            <ul class="small mb-0">
                                <li>Be specific and accurate</li>
                                <li>Use simple language</li>
                                <li>Include relevant details</li>
                                <li>Keep it helpful and friendly</li>
                            </ul>
                        </div>

                        <div class="alert alert-info mb-0">
                            <small>
                                <i class="ti ti-bulb me-1"></i>
                                <strong>Tip:</strong> Review existing FAQs in this category to maintain consistency.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
