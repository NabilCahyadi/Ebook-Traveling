<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Blog extends Model
{
    use HasFactory, HasUuids;

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
        'tags' => 'array',
    ];

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
