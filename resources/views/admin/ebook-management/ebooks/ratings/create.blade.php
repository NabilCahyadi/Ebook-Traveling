@extends('layouts.admin')

@section('title', __('admin.ratings.add_rating') . ' - ' . $ebook->title)

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold py-3 mb-0">
                    <span class="text-muted fw-light">{{ __('admin.ebooks.title') }} / {{ __('admin.ratings.title') }} /</span> {{ __('admin.ratings.add_rating') }}
                </h4>
                <small class="text-muted">{{ $ebook->title }}</small>
            </div>
            <a href="{{ route('admin.ebooks.ratings.index', $ebook->id) }}" class="btn btn-secondary">
                <i class="ti ti-arrow-left me-1"></i> {{ __('admin.ratings.back_to_ratings') }}
            </a>
        </div>

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.ebooks.ratings.store', $ebook->id) }}" method="POST">
                    @csrf

                    <div class="row">
                        <!-- User Selection -->
                        <div class="col-md-6 mb-3">
                            <label for="user_id" class="form-label">{{ __('admin.ratings.user') }} <span class="text-danger">*</span></label>
                            <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                                <option value="">{{ __('admin.ratings.select_user') }}</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Rating -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('admin.ratings.rating') }} <span class="text-danger">*</span></label>
                            <div class="rating-input d-flex align-items-center gap-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="rating" id="rating{{ $i }}" 
                                            value="{{ $i }}" {{ old('rating') == $i ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="rating{{ $i }}">
                                            <span class="d-flex align-items-center">
                                                {{ $i }} <i class="ti ti-star-filled text-warning ms-1"></i>
                                            </span>
                                        </label>
                                    </div>
                                @endfor
                            </div>
                            @error('rating')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Review Title -->
                        <div class="col-md-12 mb-3">
                            <label for="review_title" class="form-label">{{ __('admin.ratings.review_title') }}</label>
                            <input type="text" class="form-control @error('review_title') is-invalid @enderror" 
                                id="review_title" name="review_title" value="{{ old('review_title') }}"
                                placeholder="{{ __('admin.ratings.review_title_placeholder') }}">
                            @error('review_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Review Text -->
                        <div class="col-md-12 mb-3">
                            <label for="review_text" class="form-label">{{ __('admin.ratings.review_text') }}</label>
                            <textarea class="form-control @error('review_text') is-invalid @enderror" id="review_text" 
                                name="review_text" rows="4" placeholder="{{ __('admin.ratings.review_text_placeholder') }}">{{ old('review_text') }}</textarea>
                            @error('review_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Approval Status -->
                        <div class="col-md-12 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_approved" name="is_approved" 
                                    {{ old('is_approved', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_approved">{{ __('admin.ratings.approved') }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="ti ti-check me-1"></i> {{ __('admin.ratings.submit') }}
                        </button>
                        <a href="{{ route('admin.ebooks.ratings.index', $ebook->id) }}" class="btn btn-label-secondary">
                            {{ __('admin.ratings.cancel') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const submitBtn = document.getElementById('submitBtn');
    
    form.addEventListener('submit', function(e) {
        console.log('Form submitting...');
        console.log('Form action:', form.action);
        console.log('Form method:', form.method);
        
        // Check if rating is selected
        const rating = document.querySelector('input[name="rating"]:checked');
        if (!rating) {
            e.preventDefault();
            alert('Please select a rating!');
            return false;
        }
        
        // Disable submit button
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Submitting...';
    });
});
</script>
@endpush
