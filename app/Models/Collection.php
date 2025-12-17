<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Ebook;
use App\Models\CollectionItem;

class Collection extends Model
{
    use HasUuids; // Tambahkan trait untuk UUID

    protected $table = 'collections';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'order_index',
        'is_active',
        'order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'id' => 'string'
    ];

    public function ebooks(): BelongsToMany
    {
        return $this->belongsToMany(Ebook::class, 'collection_ebook')
            ->withPivot('order_index')
            ->orderBy('collection_ebook.order_index', 'asc')
            ->withTimestamps();
    }

    public function scopeForHomepage($query)
    {
        return $query->where('is_active', true)
            ->orderBy('order', 'asc')
            ->with(['ebooks' => function ($q) {
                $q->limit(10); // Limit untuk homepage
            }]);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }



    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}
