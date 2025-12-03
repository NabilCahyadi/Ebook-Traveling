<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\Ebook;

class Creator extends Model
{
    use HasFactory;

    protected $keyType = 'string'; // Menggunakan UUID
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'pen_name',
        'bio',
        'avatar',
        'social_media_links',
        'is_active',
    ];

    /**
     * Dapatkan user yang memiliki profil creator ini.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Dapatkan semua ebook dari creator ini.
     */
    public function ebooks(): HasMany
    {
        return $this->hasMany(Ebook::class, 'creator_id');
    }
}
