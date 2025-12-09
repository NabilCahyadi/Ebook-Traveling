<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class CollectionItem extends Model
{
    use HasUuids; // Tambahkan trait untuk UUID

    protected $table = 'collection_ebooks'; // Perbaikan: gunakan nama tabel yang benar

    protected $fillable = [
        'collection_id',
        'ebook_id',
        'order_index'
    ];

    protected $casts = [
        'id' => 'string'
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
