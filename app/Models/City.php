<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Ebook;

class City extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'country',
        'province',
        'order_index',
        'is_active',
        'is_popular',
        'views_count'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_popular' => 'boolean',
    ];

    public function ebooks(): HasMany
    {
        return $this->hasMany(Ebook::class, 'city_id');
    }

    // Scope untuk kota aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk kota populer
    public function scopePopular($query)
    {
        return $query->where('is_popular', true);
    }

    // Scope untuk urutan
    public function scopeOrdered($query)
    {
        return $query->orderBy('order_index', 'asc');
    }

    protected $keyType = 'string';
    public $incrementing = false;
}
