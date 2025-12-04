<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PromoUserUsage extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'promo_user_usage';

    protected $fillable = [
        'promo_id',
        'user_id',
        'subscription_id',
        'original_price',
        'final_price',
        'discount_amount',
    ];

    protected $casts = [
        'original_price' => 'decimal:2',
        'final_price' => 'decimal:2',
        'discount_amount' => 'decimal:2',
    ];

    /**
     * Get the promo that was used.
     */
    public function promo(): BelongsTo
    {
        return $this->belongsTo(Promo::class, 'promo_id');
    }

    /**
     * Get the user who used the promo.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the subscription created with this promo.
     */
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class, 'subscription_id');
    }
}
