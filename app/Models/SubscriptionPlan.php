<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscriptionPlan extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $keyType = 'char'; // Karena id adalah char(36) untuk UUID
    public $incrementing = false; // Karena UUID tidak auto-increment

    protected $fillable = [
        'name',
        'slug',
        'description',
        'cover_image',
        'price',
        'duration_days',
        'price_description', // Tambahkan ini
        'features',
        'button_text',       // Tambahkan ini
        'is_featured',       // Tambahkan ini
        'sort_order',        // Tambahkan ini
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'duration_days' => 'integer',
        'features' => 'array',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];

    /**
     * Get the subscriptions for the plan.
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
