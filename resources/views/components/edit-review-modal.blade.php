{{-- ============================================================
     REUSABLE EDIT REVIEW MODAL COMPONENT
     Usage: @include('components.edit-review-modal', ['rating' => $rating])
     ============================================================ --}}
<style>
    {{-- Button styling untuk modal edit review --}}
    .btn-edit-review {
        padding: 8px 16px !important;
        border: none !important;
        border-radius: 50px !important;
        font-size: 0.85rem !important;
        font-weight: 600 !important;
        cursor: pointer !important;
        transition: all 0.3s ease !important;
        letter-spacing: 0.5px !important;
        text-decoration: none !important;
        text-align: center !important;
        display: inline-block !important;
        background-color: #FF4C61 !important;
        color: white !important;
        border: 1px solid #FF4C61 !important;
    }

    .btn-edit-review:hover {
        background-color: #FF416C !important;
        border-color: #FF416C !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 12px rgba(255, 76, 97, 0.3) !important;
    }

    .btn-edit-review:active {
        transform: translateY(0) !important;
    }
</style>
<div class="modal fade" id="editReviewModal-{{ $rating->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-sm rounded-3">
            <!-- HEADER -->
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Edit Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- FORM -->
            <form method="POST" action="{{ route('user.account.reviews.update', $rating->id) }}">
                @csrf
                @method('PUT')

                <!-- BODY -->
                <div class="modal-body p-4">
                    <!-- Rating -->
                    <div class="mb-3">
                        <label class="form-label fw-medium">Your Rating</label>
                        <select name="rating" class="form-select">
                            <option value="5" {{ $rating->rating == 5 ? 'selected' : '' }}>5 - Excellent</option>
                            <option value="4" {{ $rating->rating == 4 ? 'selected' : '' }}>4 - Very Good</option>
                            <option value="3" {{ $rating->rating == 3 ? 'selected' : '' }}>3 - Average</option>
                            <option value="2" {{ $rating->rating == 2 ? 'selected' : '' }}>2 - Poor</option>
                            <option value="1" {{ $rating->rating == 1 ? 'selected' : '' }}>1 - Terrible</option>
                        </select>
                    </div>

                    <!-- Review Text -->
                    <div class="mb-3">
                        <label class="form-label">Your Review</label>
                        <textarea class="form-control" name="review_text" rows="8" required style="min-height: 200px; resize: vertical;">{{ $rating->review_text }}</textarea>
                    </div>
                </div>

                <!-- FOOTER -->
                <div class="modal-footer border-0 pt-0 pb-4 px-4">
                    <button type="button" class="btn-edit-review" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn-edit-review">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
