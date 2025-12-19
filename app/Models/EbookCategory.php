<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class EbookCategory extends Pivot
{
    use HasUuids;
    
    protected $table = 'ebook_categories';
    
    // Use UUID for id
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    
    protected $fillable = [
        'id',
        'ebook_id',
        'category_id',
        'created_at'
    ];
}
