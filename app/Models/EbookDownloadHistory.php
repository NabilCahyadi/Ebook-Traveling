<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EbookDownloadHistory extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'ebook_id',
        'is_downloadable',
        'changed_by',
        'notes'
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    protected $casts = [
        'is_downloadable' => 'boolean',
    ];

    /**
     * Relationship dengan Ebook
     */
    public function ebook()
    {
        return $this->belongsTo(Ebook::class, 'ebook_id');
    }

    /**
     * Relationship dengan User (admin yang mengubah)
     */
    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

    /**
     * Scope untuk mendapatkan history terbaru per ebook
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Get status download terbaru untuk ebook tertentu
     */
    public static function getLatestStatus($ebookId)
    {
        $latest = self::where('ebook_id', $ebookId)
            ->orderBy('created_at', 'desc')
            ->first();

        return $latest ? $latest->is_downloadable : false;
    }
}
