<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoEbook extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'promo_id',
        'ebook_id',
    ];

    /**
     * Get the promo.
     */
    public function promo()
    {
        return $this->belongsTo(Promo::class);
    }

    /**
     * Get the ebook.
     */
    public function ebook()
    {
        return $this->belongsTo(Ebook::class);
    }
}
