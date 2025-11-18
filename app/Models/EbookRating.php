<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EbookRating extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'ebook_id',
        'user_id',
        'rating',
        'review',
        'is_verified_purchase',
        'is_approved',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_verified_purchase' => 'boolean',
        'is_approved' => 'boolean',
    ];

    /**
     * Get the ebook that owns the rating.
     */
    public function ebook()
    {
        return $this->belongsTo(Ebook::class);
    }

    /**
     * Get the user that owns the rating.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
