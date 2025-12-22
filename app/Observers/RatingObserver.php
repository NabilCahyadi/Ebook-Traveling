<?php

namespace App\Observers;

use App\Models\Ebook;
use App\Models\Rating;

class RatingObserver extends BaseObserver
{
    /**
     * Handle the Rating "created" event.
     */
    public function created(Rating $rating)
    {
        $this->updateEbookRating($rating->ebook);
        
        // Log activity
        $this->logActivity('create', $this->getTableName($rating), $rating->id, [
            'ebook_id' => $rating->ebook_id,
            'ebook_title' => $rating->ebook->title ?? 'N/A',
            'rating' => $rating->rating,
            'has_review' => !empty($rating->review_text),
            'data' => $this->getModelData($rating)
        ]);
    }

    /**
     * Handle the Rating "updated" event.
     */
    public function updated(Rating $rating)
    {
        $this->updateEbookRating($rating->ebook);
        
        // Log activity
        $this->logActivity('update', $this->getTableName($rating), $rating->id, [
            'ebook_id' => $rating->ebook_id,
            'ebook_title' => $rating->ebook->title ?? 'N/A',
            'rating' => $rating->rating,
            'changes' => $rating->getChanges(),
            'data' => $this->getModelData($rating)
        ]);
    }

    /**
     * Handle the Rating "deleted" event.
     */
    public function deleted(Rating $rating)
    {
        $this->updateEbookRating($rating->ebook);
        
        // Log activity
        $this->logActivity('delete', $this->getTableName($rating), $rating->id, [
            'ebook_id' => $rating->ebook_id,
            'ebook_title' => $rating->ebook->title ?? 'N/A',
            'rating' => $rating->rating,
            'data' => $this->getModelData($rating)
        ]);
    }

    /**
     * Fungsi utama untuk menghitung ulang rating dan menyimpannya.
     */
    protected function updateEbookRating(Ebook $ebook)
    {
        $averageRating = $ebook->ratings()->avg('rating');
        $totalReviews = $ebook->ratings()->count();

        $stats = $ebook->ratings()
            ->where('is_approved', 1) // <-- Ini penting
            ->selectRaw('COUNT(*) as total_reviews, AVG(rating) as average_rating')
            ->first();

        $ebook->average_rating = round($stats->average_rating ?? 0, 2);
        $ebook->total_reviews = $stats->total_reviews ?? 0;
        $ebook->save();

        // Update kolom di tabel ebooks
        // $ebook->average_rating = round($averageRating, 2);
        // $ebook->total_reviews = $totalReviews;
        // $ebook->save();
    }
}
