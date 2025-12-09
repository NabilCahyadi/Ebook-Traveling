<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogCategory extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the blogs for this category.
     */
    public function blogs()
    {
        return $this->hasMany(Blog::class, 'blog_category_id');
    }

    /**
     * Get active categories
     */
    public static function active()
    {
        return static::where('is_active', true)->orderBy('name', 'asc');
    }
}
