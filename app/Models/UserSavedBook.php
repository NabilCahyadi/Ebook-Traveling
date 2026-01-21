<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSavedBook extends Model
{
    use HasFactory;

    protected $table = 'user_saved_books';

    protected $fillable = [
        'user_id',
        'ebook_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ebook()
    {
        return $this->belongsTo(Ebook::class, 'ebook_id');
    }
}
