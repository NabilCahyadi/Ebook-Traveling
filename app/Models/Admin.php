<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable, HasUuids, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'phone',
        'status',
        'type',
        'last_login_at',
    ];

    /**
     * Admin type constants.
     */
    const TYPE_ADMIN = 'admin';
    const TYPE_SUPERADMIN = 'superadmin';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

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
            return asset('assets/admin/img/avatars/default.jpeg'); // Default avatar
        }

        // Check if it's an external URL
        if (filter_var($this->avatar, FILTER_VALIDATE_URL)) {
            return $this->avatar;
        }

        // Check if starts with http:// or https://
        if (\Illuminate\Support\Str::startsWith($this->avatar, ['http://', 'https://'])) {
            return $this->avatar;
        }

        // Local storage path
        return asset('storage/' . $this->avatar);
    }

    /**
     * Check if admin is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if admin is superadmin.
     */
    public function isSuperAdmin(): bool
    {
        return $this->type === self::TYPE_SUPERADMIN;
    }

    /**
     * Check if admin is regular admin.
     */
    public function isAdmin(): bool
    {
        return $this->type === self::TYPE_ADMIN;
    }

    /**
     * Update last login timestamp.
     */
    public function updateLastLogin(): void
    {
        $this->update(['last_login_at' => now()]);
    }

    /**
     * Get the guard name for the admin.
     */
    public function guardName(): string
    {
        return 'admin';
    }
}
