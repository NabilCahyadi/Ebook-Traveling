<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EbookCategory extends Pivot
{
    protected $table = 'ebook_categories';
    
    // No id column - using composite primary key
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;
    
    protected $fillable = [
        'ebook_id',
        'category_id',
        'created_at'
    ];
}
