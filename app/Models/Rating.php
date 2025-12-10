<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rating extends Model
{
    protected $table = 'ebook_ratings';

    protected $fillable = [
        'id',
        'user_id',
        'ebook_id',
        'rating',
        'review_title',
        'review_text',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_approved' => 'boolean',
    ];

    /**
     * Get the user that owns the rating.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the ebook that owns the rating.
     */
    public function ebook(): BelongsTo
    {
        return $this->belongsTo(Ebook::class, 'ebook_id');
    }
}
