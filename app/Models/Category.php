<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

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
     * Append accessors to JSON
     */
    protected $appends = ['image_url'];

    /**
     * Get the image URL attribute.
     * Supports both external URLs and local storage paths.
     */
    public function getImageUrlAttribute()
    {
        if (empty($this->image)) {
            return asset('images/no-category-image.png');
        }

        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        if (\Illuminate\Support\Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }

        return asset('storage/' . $this->image);
    }

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

    public function ebooks()
    {
        // Tambahkan 'ebook_categories' sebagai parameter kedua
        return $this->belongsToMany(Ebook::class, 'ebook_categories', 'category_id', 'ebook_id')
            ->as('ebook_category')
            ->withPivot('created_at')
            ->withTimestamps(false);
    }
}
