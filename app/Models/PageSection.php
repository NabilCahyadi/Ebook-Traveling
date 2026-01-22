<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PageSection extends Model
{
    use HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'page_type',
        'section_title',
        'subsection_title',
        'content',
        'order_index'
    ];

    protected $casts = [
        'order_index' => 'integer',
    ];
}
