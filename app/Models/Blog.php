<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Blog extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'featured_image',
        'author_id',
        'category',
        'tags',
        'view_count',
        'status',
        'published_at',
    ];

    protected $casts = [
        'tags' => 'array',
        'view_count' => 'integer',
        'published_at' => 'datetime',
    ];

    /**
     * Append accessors to JSON
     */
    protected $appends = ['featured_image_url'];

    /**
     * Get the featured image URL attribute.
     * Supports both external URLs and local storage paths.
     */
    public function getFeaturedImageUrlAttribute()
    {
        if (empty($this->featured_image)) {
            return asset('images/no-blog-image.png');
        }

        if (filter_var($this->featured_image, FILTER_VALIDATE_URL)) {
            return $this->featured_image;
        }

        if (\Illuminate\Support\Str::startsWith($this->featured_image, ['http://', 'https://'])) {
            return $this->featured_image;
        }

        return asset('storage/' . $this->featured_image);
    }

    /**
     * Get the author of the blog.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Scope a query to only include published blogs.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function ebooks(): BelongsToMany
    {
        return $this->belongsToMany(Ebook::class, 'blog_ebook', 'blog_id', 'ebook_id');
    }
}
