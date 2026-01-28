@extends('layouts.admin')

@section('title', __('admin.ratings.edit_rating') . ' - ' . $ebook->title)

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold py-3 mb-0">
                    <span class="text-muted fw-light">{{ __('admin.ebooks.title') }} / {{ __('admin.ratings.title') }} /</span> {{ __('admin.ratings.edit_rating') }}
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

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.ebooks.ratings.update', [$ebook->id, $rating->id]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- User Info (Read-only) -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('admin.ratings.user') }}</label>
                            <div class="d-flex align-items-center p-3 bg-label-danger rounded">
                                <div class="avatar avatar-sm me-2">
                                    <span class="avatar-initial rounded-circle bg-danger">
                                        {{ substr($rating->user->name ?? 'U', 0, 1) }}
                                    </span>
                                </div>
                                <div>
                                    <div class="fw-medium text-danger">{{ $rating->user->name ?? __('admin.ebooks.unknown') }}</div>
                                    <small class="text-muted">{{ $rating->user->email ?? '-' }}</small>
                                </div>
                            </div>
                        </div>

                        <!-- Rating -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('admin.ratings.rating') }} <span class="text-danger">*</span></label>
                            <div class="rating-input d-flex align-items-center gap-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="rating" id="rating{{ $i }}" 
                                            value="{{ $i }}" {{ old('rating', $rating->rating) == $i ? 'checked' : '' }} required>
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
                                id="review_title" name="review_title" value="{{ old('review_title', $rating->review_title) }}"
                                placeholder="{{ __('admin.ratings.review_title_placeholder') }}">
                            @error('review_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Review Text -->
                        <div class="col-md-12 mb-3">
                            <label for="review_text" class="form-label">{{ __('admin.ratings.review_text') }}</label>
                            <textarea class="form-control @error('review_text') is-invalid @enderror" id="review_text" 
                                name="review_text" rows="4" placeholder="{{ __('admin.ratings.review_text_placeholder') }}">{{ old('review_text', $rating->review_text) }}</textarea>
                            @error('review_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Approval Status -->
                        <div class="col-md-12 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_approved" name="is_approved" 
                                    {{ old('is_approved', $rating->is_approved) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_approved">{{ __('admin.ratings.approved') }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-check me-1"></i> {{ __('admin.ratings.update') }}
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
