<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use App\Models\EbookCategory;
use App\Models\City;
use App\Models\EbookSection;
use App\Models\Rating;
use App\Models\Collection;

class Ebook extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'category_id',
        'city_id',
        'creator_id',
        'title',
        'slug',
        'description',
        'author',
        'publisher',
        'isbn',
        'cover_image',
        'file_url',
        'pdf_file',
        'content_text',
        'preview_content',
        'page_count',
        'language',
        'is_featured',
        'is_free',
        'status',
        'is_active',
        'published_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'id' => 'string',
        'published_at' => 'datetime',
    ];

    /**
     * Append accessors to JSON
     */
    protected $appends = [
        'cover_image_url',
    ];

    /**
     * Boot method untuk handle auto-slug generation dengan unique index
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ebook) {
            if (empty($ebook->slug) && !empty($ebook->title)) {
                $ebook->slug = static::generateUniqueSlug($ebook->title);
            }
        });

        static::updating(function ($ebook) {
            if ($ebook->isDirty('title') && !$ebook->isDirty('slug')) {
                $ebook->slug = static::generateUniqueSlug($ebook->title, $ebook->id);
            }
        });
    }

    /**
     * Generate unique slug with index if duplicate exists
     */
    protected static function generateUniqueSlug($title, $ignoreId = null)
    {
        $slug = \Illuminate\Support\Str::slug($title);
        $originalSlug = $slug;
        $index = 1;

        while (true) {
            // Query tanpa withTrashed() untuk hanya cek ebook yang aktif (non-deleted)
            $query = static::where('slug', $slug);

            if ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            }

            if (!$query->exists()) {
                break;
            }

            $slug = $originalSlug . '-' . $index;
            $index++;
        }

        return $slug;
    }

    /**
     * Get the cover image URL attribute.
     */
    public function getCoverImageUrlAttribute()
    {
        if ($this->cover_image) {
            return Storage::url($this->cover_image);
        }
        return null;
    }

    /**
     * Get the category that owns the ebook.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(EbookCategory::class, 'category_id');
    }

    /**
     * Get the city that owns the ebook.
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    /**
     * Get the sections for the ebook.
     */
    public function sections(): HasMany
    {
        return $this->hasMany(EbookSection::class, 'ebook_id');
    }

    /**
     * Get the ratings for the ebook.
     */
    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class, 'ebook_id');
    }

    /**
     * RELASI BARU: Collections (many-to-many)
     */
    public function collections(): BelongsToMany
    {
        return $this->belongsToMany(Collection::class, 'collection_ebooks')
            ->withPivot('order_index')
            ->withTimestamps();
    }

    /**
     * Dapatkan creator yang membuat ebook ini.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * Blog yang terkait dengan e-book ini.
     */
    public function blogs(): BelongsToMany
    {
        return $this->belongsToMany(Blog::class, 'blog_ebook', 'ebook_id', 'blog_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'ebook_categories');
    }
}
