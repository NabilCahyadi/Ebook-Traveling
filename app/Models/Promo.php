<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Promo extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'code',
        'description',
        'type',
        'value',
        'start_date',
        'end_date',
        'max_usage',
        'max_usage_per_user',
        'current_usage',
        'is_active',
        // Old fields for ebook promo (keep for backward compatibility)
        'discount_type',
        'discount_value',
        'min_purchase',
        'max_discount',
        'usage_limit',
        'usage_count',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
        'max_usage' => 'integer',
        'max_usage_per_user' => 'integer',
        'current_usage' => 'integer',
        // Old fields
        'discount_value' => 'decimal:2',
        'min_purchase' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'usage_limit' => 'integer',
        'usage_count' => 'integer',
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
}
