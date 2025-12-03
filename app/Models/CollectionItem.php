<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollectionItem extends Model
{
    protected $table = 'collection_items';

    protected $fillable = [
        'collection_id',
        'ebook_id',
        'order_index'
    ];

    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }

    public function ebook()
    {
        return $this->belongsTo(Ebook::class);
    }
}
