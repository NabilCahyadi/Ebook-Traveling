<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Profile;
use App\Models\Role;
use App\Models\UserSavedBook;
use App\Models\Order;
use App\Models\UserReading;
use App\Models\ShoppingCart;
use App\Models\EbookRating;
use App\Models\Subscription;
use App\Models\Payment;
use App\Models\Ebook;
use App\Models\Blog;
use App\Models\UserNotification;
use App\Models\ActionLog;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasUuids, SoftDeletes;

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The data type of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'user_type',
        'avatar',
        'status',
        'preferred_language',
        'google_id',
        'last_login_at',
        'last_login_ip',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
            'password' => 'hashed',
            'last_login_at' => 'datetime',
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
            return asset('images/default-avatar.png'); // Default avatar
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

    // ==================== RELATIONSHIPS ====================

    /**
     * Get the profile for the user.
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * Get the roles for the user.
     */
    public function roles(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles')
            ->using(UserRole::class)
            ->withTimestamps();
    }

    /**
     * Get the first role for the user (for backward compatibility).
     * This is not a relationship, use roles() for relationship.
     */
    public function role()
    {
        // Try to get from relationship first (if already loaded)
        if ($this->relationLoaded('roles') && $this->roles->isNotEmpty()) {
            return $this->roles->first();
        }

        // Otherwise query
        return $this->roles()->first();
    }

    /**
     * Check if user has a specific role.
     */
    public function hasRole(string $roleName): bool
    {
        return $this->roles()->where('name', $roleName)->exists();
    }

    /**
     * Check if user has any of the given roles.
     */
    public function hasAnyRole(array $roles): bool
    {
        return $this->roles()->whereIn('name', $roles)->exists();
    }

    // /**
    //  * Get the saved books (wishlist) for the user.
    //  */
    // public function savedBooks()
    // {
    //     return $this->hasMany(UserSavedBook::class);
    // }

    /**
     * Get the orders for the user.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the reading progress for the user.
     */
    public function readings()
    {
        return $this->hasMany(UserReading::class);
    }

    /**
     * Get the shopping cart items for the user.
     */
    public function cartItems()
    {
        return $this->hasMany(ShoppingCart::class);
    }

    /**
     * Get the ebook ratings for the user.
     */
    public function ratings()
    {
        return $this->hasMany(EbookRating::class);
    }

    /**
     * Get the subscriptions for the user.
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Get the payments for the user.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class)->orderBy('created_at', 'desc');
    }

    /**
     * Get the ebooks created by the user (if creator).
     */
    public function createdEbooks()
    {
        return $this->hasMany(Ebook::class, 'creator_id');
    }

    /**
     * Get the blogs created by the user.
     */
    public function blogs()
    {
        return $this->hasMany(Blog::class, 'author_id');
    }

    /**
     * Get the user notifications.
     */
    public function userNotifications()
    {
        return $this->hasMany(UserNotification::class);
    }

    /**
     * Get the action logs for the user.
     */
    public function actionLogs()
    {
        return $this->hasMany(ActionLog::class);
    }

    // ==================== SCOPES ====================

    /**
     * Scope a query to only include active users.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include free users.
     */
    public function scopeFreeUsers($query)
    {
        return $query->where('user_type', 'free_user');
    }

    /**
     * Scope a query to only include members (paid subscription).
     */
    public function scopeMembers($query)
    {
        return $query->where('user_type', 'member');
    }

    /**
     * Scope a query to only include creators (based on role).
     */
    public function scopeCreators($query)
    {
        return $query->whereHas('roles', function ($q) {
            $q->where('name', 'Creator')->orWhere('slug', 'creator');
        });
    }

    /**
     * Scope a query to only include admins (based on role).
     */
    public function scopeAdmins($query)
    {
        return $query->whereHas('roles', function ($q) {
            $q->whereIn('slug', ['admin', 'superadmin'])
                ->orWhereIn('name', ['Admin', 'Super Admin']);
        });
    }

    // ==================== METHODS ====================

    /**
     * Check if user has admin role.
     * Note: This checks user roles, not user_type.
     * user_type only indicates subscription status (free_user/member).
     */
    public function isAdmin()
    {
        return $this->hasRole('Admin') || $this->hasRole('admin');
    }

    /**
     * Check if user has super admin role.
     */
    public function isSuperAdmin()
    {
        return $this->hasRole('Super Admin') || $this->hasRole('superadmin');
    }

    /**
     * Check if user is member (has paid subscription).
     */
    public function isMember()
    {
        return $this->user_type === 'member';
    }

    /**
     * Check if user is free user.
     */
    public function isFreeUser()
    {
        return $this->user_type === 'free_user';
    }

    /**
     * Check if user is creator (has creator role).
     */
    public function isCreator()
    {
        return $this->hasRole('Creator') || $this->hasRole('creator');
    }

    /**
     * Get user's primary role.
     */
    public function getPrimaryRoleAttribute()
    {
        return $this->roles->first()?->name ?? 'Member';
    }

    /**
     * Get user's reading statistics.
     */
    public function getReadingStats()
    {
        return [
            'total_books_read' => $this->readings->count(),
            'total_pages_read' => $this->readings->sum('last_page'),
            'average_progress' => $this->readings->avg('progress_percentage'),
        ];
    }

    /**
     * Dapatkan profil creator yang terkait dengan user ini.
     */
    public function creator(): HasOne
    {
        return $this->hasOne(Creator::class);
    }

    // ==================== PERMISSION METHODS ====================

    /**
     * Check if user has a specific permission.
     */
    public function hasPermission(string $permissionName): bool
    {
        // Super Admin always has all permissions
        if ($this->isSuperAdmin()) {
            return true;
        }

        // Check through all user roles
        foreach ($this->roles as $role) {
            if ($role->hasPermission($permissionName)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if user has any of the given permissions.
     */
    public function hasAnyPermission(array $permissions): bool
    {
        // Super Admin always has all permissions
        if ($this->isSuperAdmin()) {
            return true;
        }

        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if user has all of the given permissions.
     */
    public function hasAllPermissions(array $permissions): bool
    {
        // Super Admin always has all permissions
        if ($this->isSuperAdmin()) {
            return true;
        }

        foreach ($permissions as $permission) {
            if (!$this->hasPermission($permission)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if user can access management panel.
     */
    public function canAccessPanel(): bool
    {
        // Admin/Super Admin always can access
        if ($this->isAdmin() || $this->isSuperAdmin()) {
            return true;
        }

        // Check panel.access permission
        return $this->hasPermission('panel.access');
    }

    /**
     * Alias for backward compatibility.
     */
    public function canAccessAdmin(): bool
    {
        return $this->canAccessPanel();
    }

    public function hasActiveSubscription(): bool
    {
        return $this->subscriptions()
            ->where('status', 'active')
            ->where('end_date', '>=', now())
            ->exists();
    }

    // ✅ ACCESSOR: ambil subscription aktif terakhir
    public function getCurrentSubscriptionAttribute()
    {
        return $this->latestActiveSubscription()->first();
    }

    // ✅ ACCESSOR: ambil plan aktif
    public function getCurrentPlanAttribute()
    {
        return $this->currentSubscription?->plan;
    }

    // ✅ RELATIONSHIP (tanpa () → untuk eager load)
    public function activeSubscriptions()
    {
        return $this->hasMany(Subscription::class)
            ->where('status', 'active')
            ->where('end_date', '>=', now());
    }

    // ✅ RELATIONSHIP untuk subscription terbaru (bisa dipakai di with())
    public function latestActiveSubscription()
    {
        return $this->hasOne(Subscription::class)
            ->where('status', 'active')
            ->where('end_date', '>=', now())
            ->orderBy('end_date', 'desc');
    }

    public function savedBooks()
    {
        return $this->belongsToMany(Ebook::class, 'user_saved_books', 'user_id', 'ebook_id'); // Pastikan created_at diisi
    }

    public function currentSubscription()
    {
        return $this->hasOne(Subscription::class)
            ->where('status', 'active')
            ->where('end_date', '>=', now())
            ->orderBy('end_date', 'desc');
    }
}
