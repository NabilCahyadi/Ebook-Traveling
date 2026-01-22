<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageSection extends Model
{
    protected $fillable = [
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
