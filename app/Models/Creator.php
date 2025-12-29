<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\Ebook;

class Creator extends Model
{
    use HasFactory, HasUuids;

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
     * Append accessors to JSON
     */
    protected $appends = ['avatar_url'];

    /**
     * Get the avatar URL attribute.
     * Supports both external URLs and local storage paths.
     */
    public function getAvatarUrlAttribute()
    {
        if (empty($this->avatar)) {
            return asset('images/default-creator-avatar.png');
        }

        if (filter_var($this->avatar, FILTER_VALIDATE_URL)) {
            return $this->avatar;
        }

        if (\Illuminate\Support\Str::startsWith($this->avatar, ['http://', 'https://'])) {
            return $this->avatar;
        }

        return asset('storage/' . $this->avatar);
    }

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
