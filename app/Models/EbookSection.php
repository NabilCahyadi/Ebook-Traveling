<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EbookSection extends Model
{
    protected $fillable = [
        'ebook_id',
        'title',
        'content',
        'order_number',
    ];

    /**
     * Get the ebook that owns the section.
     */
    public function ebook(): BelongsTo
    {
        return $this->belongsTo(Ebook::class, 'ebook_id');
    }
}
