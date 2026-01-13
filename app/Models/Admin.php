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
     * Get the permissions for the admin.
     */
    public function permissions()
    {
        return $this->belongsToMany(AdminPermission::class, 'admin_permission', 'admin_id', 'admin_permission_id');
    }

    /**
     * Check if admin has a specific permission.
     */
    public function hasPermission(string $permissionName): bool
    {
        // Superadmin has all permissions
        if ($this->isSuperAdmin()) {
            return true;
        }

        return $this->permissions()->where('name', $permissionName)->exists();
    }

    /**
     * Check if admin has any of the given permissions.
     */
    public function hasAnyPermission(array $permissions): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        return $this->permissions()->whereIn('name', $permissions)->exists();
    }

    /**
     * Check if admin has all of the given permissions.
     */
    public function hasAllPermissions(array $permissions): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        return $this->permissions()->whereIn('name', $permissions)->count() === count($permissions);
    }

    /**
     * Sync permissions for the admin.
     */
    public function syncPermissions(array $permissionIds): void
    {
        $this->permissions()->sync($permissionIds);
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

    /**
     * Get user notifications (pivot table with notification).
     */
    public function userNotifications()
    {
        return $this->hasMany(\App\Models\UserNotification::class, 'user_id');
    }

    /**
     * Get notifications through pivot table.
     */
    public function notifications()
    {
        return $this->belongsToMany(\App\Models\Notification::class, 'user_notifications', 'user_id', 'notification_id')
            ->withPivot('is_read', 'read_at')
            ->withTimestamps();
    }
}
