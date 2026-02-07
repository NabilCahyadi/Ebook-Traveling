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

    /* Star Rating for Edit Modal */
    .star-rating-edit {
        display: flex;
        gap: 6px;
        margin-top: 8px;
    }

    .star-rating-edit .star-icon-edit {
        font-size: 1.4rem;
        color: #d1d5db;
        cursor: pointer;
        transition: color 0.2s ease, transform 0.2s ease;
    }

    .star-rating-edit .star-icon-edit:hover {
        transform: scale(1.1);
    }

    .star-rating-edit .star-icon-edit.active {
        color: #fbbf24;
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
                        <input type="hidden" name="rating" id="edit-rating-input-{{ $rating->id }}" value="{{ $rating->rating }}">
                        <div class="star-rating-edit" data-rating-id="{{ $rating->id }}">
                            <i class="bi bi-star-fill star-icon-edit {{ $rating->rating >= 1 ? 'active' : '' }}" data-rating="1"></i>
                            <i class="bi bi-star-fill star-icon-edit {{ $rating->rating >= 2 ? 'active' : '' }}" data-rating="2"></i>
                            <i class="bi bi-star-fill star-icon-edit {{ $rating->rating >= 3 ? 'active' : '' }}" data-rating="3"></i>
                            <i class="bi bi-star-fill star-icon-edit {{ $rating->rating >= 4 ? 'active' : '' }}" data-rating="4"></i>
                            <i class="bi bi-star-fill star-icon-edit {{ $rating->rating >= 5 ? 'active' : '' }}" data-rating="5"></i>
                        </div>
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

<script>
    // Star Rating Handler for Edit Modal (runs when modal opens)
    document.addEventListener('DOMContentLoaded', function() {
        const starContainers = document.querySelectorAll('.star-rating-edit');

        starContainers.forEach(container => {
            const ratingId = container.dataset.ratingId;
            const stars = container.querySelectorAll('.star-icon-edit');
            const ratingInput = document.getElementById('edit-rating-input-' + ratingId);

            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = parseInt(this.dataset.rating);
                    ratingInput.value = rating;
                    updateEditStars(stars, rating);
                });

                // Hover effect
                star.addEventListener('mouseenter', function() {
                    const hoverRating = parseInt(this.dataset.rating);
                    updateEditStars(stars, hoverRating);
                });
            });

            // Reset to selected rating when mouse leaves
            container.addEventListener('mouseleave', function() {
                updateEditStars(stars, parseInt(ratingInput.value));
            });
        });

        function updateEditStars(stars, rating) {
            stars.forEach(star => {
                const starRating = parseInt(star.dataset.rating);
                if (starRating <= rating) {
                    star.classList.add('active');
                } else {
                    star.classList.remove('active');
                }
            });
        }
    });
</script>
