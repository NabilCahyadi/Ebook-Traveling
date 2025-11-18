<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EbookCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Get the ebooks for the category.
     */
    public function ebooks(): HasMany
    {
        return $this->hasMany(Ebook::class, 'category_id');
    }
}
