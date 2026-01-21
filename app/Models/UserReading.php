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
        'last_page',
        'total_pages',
        'progress_percentage',
        'last_read_at',
    ];

    protected $casts = [
        'last_page' => 'integer',
        'total_pages' => 'integer',
        'progress_percentage' => 'decimal:2',
        'last_read_at' => 'datetime',
    ];

    public function ebook()
    {
        return $this->belongsTo(Ebook::class, 'ebook_id');
    }

    // ✅ RELASI KE USER
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
