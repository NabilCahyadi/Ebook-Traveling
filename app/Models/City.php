<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    protected $fillable = [
        'name',
        'country',
    ];

    /**
     * Get the ebooks for the city.
     */
    public function ebooks(): HasMany
    {
        return $this->hasMany(Ebook::class, 'city_id');
    }
}
