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
        'price_description', 
        'features',
        'button_text',       
        'is_featured',       
        'sort_order',        
        'is_active',
        'category_subscription',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'duration_days' => 'integer',
        'features' => 'array', // Pastikan ini ada dan benar
        'is_active' => 'boolean',
        'is_featured' => 'boolean', 
        'sort_order' => 'integer', 
    ];

    const CATEGORIES = [
        'harian' => 'Daily',
        'mingguan' => 'Weekly',
        'bulanan' => 'Monthly',
        'tahunan' => 'Yearly',
    ];

    /**
     * Get the subscriptions for the plan.
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
