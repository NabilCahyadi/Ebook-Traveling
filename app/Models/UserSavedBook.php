<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSavedBook extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'ebook_id',
        'notes',
    ];

    /**
     * Get the user that owns the saved book.
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
