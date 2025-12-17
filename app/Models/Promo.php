<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Promo extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $table = 'promos';

    protected $fillable = [
        'name',
        'slug',
        'code',
        'description',
        'type',
        'value',
        'max_usage',
        'max_usage_per_user',
        'current_usage',
        'banner_image',
        'discount_type',
        'discount_value',
        'min_purchase_amount',
        'start_date',
        'end_date',
        'terms_conditions',
        'is_active'
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
        'max_usage' => 'integer',
        'max_usage_per_user' => 'integer',
        'current_usage' => 'integer',
        'min_purchase_amount' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'usage_limit' => 'integer',
        'usage_count' => 'integer',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the conditions for this promo (subscription promo).
     */
    public function conditions(): HasMany
    {
        return $this->hasMany(PromoCondition::class, 'promo_id');
    }

    /**
     * Get the usage records for this promo (subscription promo).
     */
    public function usages(): HasMany
    {
        return $this->hasMany(PromoUserUsage::class, 'promo_id');
    }

    /**
     * Get the ebooks for the promo (ebook promo - old system).
     */
    public function ebooks()
    {
        return $this->belongsToMany(Ebook::class, 'promo_ebooks');
    }

    /**
     * Check if promo is currently active based on date range.
     */
    public function isCurrentlyActive(): bool
    {
        $now = now();
        return $this->is_active
            && $this->start_date <= $now
            && $this->end_date >= $now;
    }

    /**
     * Check if promo has reached max usage limit.
     */
    public function hasReachedMaxUsage(): bool
    {
        if ($this->max_usage === null) {
            return false; // unlimited usage
        }

        return $this->current_usage >= $this->max_usage;
    }

    /**
     * Get usage count for specific user.
     */
    public function getUserUsageCount(string $userId): int
    {
        return $this->usages()->where('user_id', $userId)->count();
    }

    /**
     * Check if user has reached max usage per user limit.
     */
    public function userHasReachedMaxUsage(string $userId): bool
    {
        return $this->getUserUsageCount($userId) >= $this->max_usage_per_user;
    }

    /**
     * Scope a query to only include active promos.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for promos within date range.
     */
    public function scopeAvailable($query)
    {
        $now = now();
        return $query->where('is_active', true)
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now);
    }

    /**
     * Scope for promos by code.
     */
    public function scopeByCode($query, string $code)
    {
        return $query->where('code', $code);
    }


    /**
     * Bagian ini adalah yang TERPENTING.
     * Ini akan otomatis membuat slug dari nama.
     */
    protected static function boot()
    {
        parent::boot();

        // Saat promo baru dibuat
        static::creating(function ($promo) {
            $promo->slug = $promo->generateUniqueSlug($promo->name);
        });

        // Saat nama promo diubah
        static::updating(function ($promo) {
            if ($promo->isDirty('name')) {
                $promo->slug = $promo->generateUniqueSlug($promo->name);
            }
        });
    }

    /**
     * Fungsi untuk membuat slug yang unik.
     * Contoh: "Welcome50 - New User Discount" menjadi "welcome50-new-user-discount"
     */
    public function generateUniqueSlug($name)
    {
        $slug = Str::slug($name); // Mengubah spasi jadi "-", huruf besar jadi kecil
        $originalSlug = $slug;
        $counter = 1;

        // Cek apakah slug sudah ada di database. Jika ya, tambahkan angka.
        while (static::where('slug', $slug)->where('id', '!=', $this->id)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Aksesori untuk memformat periode.
     */
    public function getFormattedPeriodAttribute()
    {
        $startDate = $this->start_date ? \Carbon\Carbon::parse($this->start_date)->locale('id')->translatedFormat('d M Y') : 'Mulai sekarang';
        $endDate = $this->end_date ? \Carbon\Carbon::parse($this->end_date)->locale('id')->translatedFormat('d M Y') : 'Berlaku selamanya';

        return $startDate . ' - ' . $endDate;
    }

    public function getDateRangeAttribute()
    {
        if (!$this->start_date || !$this->end_date) {
            return null;
        }

        return \Carbon\Carbon::parse($this->start_date)->locale('id')->translatedFormat('d F Y') .
            ' - ' .
            \Carbon\Carbon::parse($this->end_date)->locale('id')->translatedFormat('d F Y');
    }

    /**
     * Aksesori untuk mendapatkan URL gambar.
     */
    public function getImageUrlAttribute()
    {
        if ($this->banner_image) {
            return asset($this->banner_image);
        }
        return asset('/images/default-promo.webp');
    }
}
