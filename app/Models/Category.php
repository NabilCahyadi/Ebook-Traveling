<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'name',
        'slug',
        'description',
        'image',
        'type',
        'icon',
        'color',
        'parent_id',
        'sort_order',
        'is_active',
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    protected $casts = [
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Get the parent category.
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Get the child categories.
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * E-book yang ada di kategori ini.
     */
    public function ebooks()
    {
        return $this->belongsToMany(Ebook::class, 'ebook_categories', 'category_id', 'ebook_id');
    }
}
