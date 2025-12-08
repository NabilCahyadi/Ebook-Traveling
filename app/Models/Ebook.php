<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;
use App\Models\EbookCategory;
use App\Models\City;
use App\Models\EbookSection;
use App\Models\Rating;
use App\Models\Collection;

class Ebook extends Model
{
    use HasUuids;

    protected $fillable = [
        'category_id',
        'city_id',
        'title',
        'slug',
        'description',
        'author',
        'cover_image',
        'file_url',
        'page_count',
        'status',
        'is_featured',
        'view_count',
        'read_count',
        'average_rating',
        'total_reviews',
        'creator_id',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'average_rating' => 'decimal:2',
        'is_active' => 'boolean',
        'id' => 'string',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ebook) {
            if (empty($ebook->slug)) {
                $ebook->slug = static::generateUniqueSlug($ebook->title);
            }
        });

        static::updating(function ($ebook) {
            if ($ebook->isDirty('title') && empty($ebook->slug)) {
                $ebook->slug = static::generateUniqueSlug($ebook->title);
            }
        });
    }

    /**
     * Generate a unique slug.
     */
    protected static function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    /**
     * Get the category that owns the ebook.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
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
     * Get the collections that contain the ebook (many-to-many).
     */
    public function collections(): BelongsToMany
    {
        return $this->belongsToMany(Collection::class, 'collection_ebooks')
            ->withPivot('order_index')
            ->withTimestamps();
    }

    /**
     * Get the user who created the ebook.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * Get the order items for the ebook.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'ebook_id');
    }
}
