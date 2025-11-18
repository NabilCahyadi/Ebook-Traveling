<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserReading extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'ebook_id',
        'current_page',
        'total_pages',
        'progress_percentage',
        'last_read_at',
    ];

    protected $casts = [
        'current_page' => 'integer',
        'total_pages' => 'integer',
        'progress_percentage' => 'decimal:2',
        'last_read_at' => 'datetime',
    ];

    /**
     * Get the user that owns the reading.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the ebook.
     */
    public function ebook()
    {
        return $this->belongsTo(Ebook::class);
    }
}
