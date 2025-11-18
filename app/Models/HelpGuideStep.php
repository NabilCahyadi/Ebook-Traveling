<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HelpGuideStep extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'help_guide_id',
        'step_number',
        'title',
        'content',
        'image_url',
    ];

    protected $casts = [
        'step_number' => 'integer',
    ];

    /**
     * Get the guide that owns the step.
     */
    public function guide()
    {
        return $this->belongsTo(HelpGuide::class, 'help_guide_id');
    }
}
