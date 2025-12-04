<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PromoCondition extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'promo_id',
        'condition_type',
        'condition_value',
    ];

    /**
     * Get the promo that owns this condition.
     */
    public function promo(): BelongsTo
    {
        return $this->belongsTo(Promo::class, 'promo_id');
    }

    /**
     * Available condition types.
     */
    public const TYPE_NEW_USER = 'new_user';
    public const TYPE_FIRST_SUBSCRIPTION = 'first_subscription';
    public const TYPE_SUBSCRIPTION_TYPE = 'subscription_type';
    public const TYPE_MIN_PRICE = 'min_price';

    /**
     * Get all available condition types.
     */
    public static function getConditionTypes(): array
    {
        return [
            self::TYPE_NEW_USER => 'New User (7 days)',
            self::TYPE_FIRST_SUBSCRIPTION => 'First Subscription',
            self::TYPE_SUBSCRIPTION_TYPE => 'Subscription Type',
            self::TYPE_MIN_PRICE => 'Minimum Price',
        ];
    }
}
