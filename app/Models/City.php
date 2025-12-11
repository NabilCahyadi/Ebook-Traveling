<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
// use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Ebook;

class City extends Model
{
    use HasUuids;

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
        'id' => 'string',
    ];

    /**
     * Boot method untuk auto-generate unique slug dengan index
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($city) {
            if (empty($city->slug) && !empty($city->name)) {
                $city->slug = static::generateUniqueSlug($city->name);
            }
        });

        static::updating(function ($city) {
            if ($city->isDirty('name') && !$city->isDirty('slug')) {
                $city->slug = static::generateUniqueSlug($city->name, $city->id);
            }
        });
    }

    /**
     * Generate unique slug with index if duplicate exists
     */
    protected static function generateUniqueSlug($name, $ignoreId = null)
    {
        $slug = \Illuminate\Support\Str::slug($name);
        $originalSlug = $slug;
        $index = 1;

        while (true) {
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
