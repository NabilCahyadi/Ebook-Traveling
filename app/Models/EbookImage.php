<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EbookImage extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'ebook_id',
        'image_url',
        'caption',
        'sort_order',
        'is_primary',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_primary' => 'boolean',
    ];

    /**
     * Get the ebook that owns the image.
     */
    public function ebook()
    {
        return $this->belongsTo(Ebook::class);
    }
}
