<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Ebook;
use App\Models\CollectionItem;

class Collection extends Model
{
    protected $table = 'collections';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'order_index',
        'is_active',
        'show_in_homepage'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'show_in_homepage' => 'boolean',
        'id' => 'string'
    ];

    public function ebooks(): BelongsToMany
    {
        return $this->belongsToMany(Ebook::class, 'collection_ebooks')
            ->withPivot('order_index')
            ->orderBy('collection_ebooks.order_index', 'asc')
            ->withTimestamps();
    }

    public function scopeForHomepage($query)
    {
        return $query->where('is_active', true)
            ->where('show_in_homepage', true)
            ->orderBy('order_index', 'asc')
            ->with(['ebooks' => function ($q) {
                $q->limit(10); // Limit untuk homepage
            }]);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeHomepage($query)
    {
        return $query->where('show_in_homepage', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order_index', 'asc');
    }
}
