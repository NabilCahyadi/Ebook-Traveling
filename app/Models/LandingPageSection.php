<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPageSection extends Model
{
    protected $fillable = [
        'section_type',
        'section_name',
        'section_title',
        'section_data',
        'reference_id',
        'collection_id',
        'filter_config',
        'card_template',
        'order',
        'is_visible',
        'config'
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'config' => 'array',
        'section_data' => 'array',
        'filter_config' => 'array',
        'order' => 'integer'
    ];

    // Section types constants
    const TYPE_HERO_BANNER = 'hero_banner';
    const TYPE_TOP_CITIES = 'top_cities';
    const TYPE_SUBSCRIPTION_PLANS = 'subscription_plans';
    const TYPE_COLLECTION = 'collection';
    const TYPE_LATEST_BLOGS = 'latest_blogs';

    // Scopes
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    // Relationships
    public function collection()
    {
        return $this->belongsTo(Collection::class, 'reference_id');
    }
}
