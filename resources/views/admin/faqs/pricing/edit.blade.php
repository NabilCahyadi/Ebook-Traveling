@extends('layouts.admin')

@section('title', 'Edit FAQ Pricing')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Page Header -->
        <div class="mb-4">
            <h4 class="fw-bold py-3 mb-2">
                <span class="text-muted fw-light">Web Setting / FAQ / Pricing /</span> Edit
            </h4>
        </div>

        <!-- Form Card -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Edit FAQ Information</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.faqs.pricing.update', $faq->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Question -->
                            <div class="mb-4">
                                <label for="question" class="form-label">Question <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('question') is-invalid @enderror" 
                                    id="question" name="question" value="{{ old('question', $faq->question) }}" 
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
                                    placeholder="Enter the answer..." required>{{ old('answer', $faq->answer) }}</textarea>
                                @error('answer')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Provide a clear and concise answer</small>
                            </div>

                            <!-- Order Index -->
                            <div class="mb-4">
                                <label for="order_index" class="form-label">Display Order <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('order_index') is-invalid @enderror" 
                                    id="order_index" name="order_index" value="{{ old('order_index', $faq->order_index) }}" 
                                    min="0" required>
                                @error('order_index')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Lower numbers appear first</small>
                            </div>

                            <!-- Is Active -->
                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" 
                                        name="is_active" {{ old('is_active', $faq->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Active (Display on website)
                                    </label>
                                </div>
                                <small class="text-muted">Toggle to show/hide this FAQ on the pricing page</small>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-check me-1"></i> Update FAQ
                                </button>
                                <a href="{{ route('admin.faqs.pricing.index') }}" class="btn btn-label-secondary">
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
                        <h5 class="mb-0"><i class="ti ti-info-circle me-2"></i>FAQ Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Category</small>
                            <span class="badge bg-label-primary">{{ ucfirst($faq->category) }}</span>
                        </div>
                        
                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Status</small>
                            <span class="badge {{ $faq->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $faq->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Created At</small>
                            <strong>{{ $faq->created_at->format('d M Y, H:i') }}</strong>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Last Updated</small>
                            <strong>{{ $faq->updated_at->format('d M Y, H:i') }}</strong>
                        </div>

                        @if($faq->deleted_at)
                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Deleted At</small>
                            <strong class="text-danger">{{ $faq->deleted_at->format('d M Y, H:i') }}</strong>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="ti ti-list-check me-2"></i>Guidelines</h5>
                    </div>
                    <div class="card-body">
                        <h6 class="mb-3">Creating Effective FAQs</h6>
                        
                        <div class="mb-3">
                            <strong class="d-block mb-2">Questions:</strong>
                            <ul class="small mb-0">
                                <li>Keep it concise and clear</li>
                                <li>Use common terminology</li>
                                <li>Start with question words</li>
                                <li>Focus on one topic</li>
                            </ul>
                        </div>

                        <div class="mb-3">
                            <strong class="d-block mb-2">Answers:</strong>
                            <ul class="small mb-0">
                                <li>Be direct and informative</li>
                                <li>Use simple language</li>
                                <li>Include relevant details</li>
                                <li>Keep it scannable</li>
                            </ul>
                        </div>

                        <div class="alert alert-info mb-0">
                            <small>
                                <i class="ti ti-bulb me-1"></i>
                                <strong>Tip:</strong> Lower order numbers appear first on the pricing page.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
