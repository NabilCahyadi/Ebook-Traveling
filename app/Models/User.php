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
     */
    public function role()
    {
        return $this->roles()->first();
    }

    /**
     * Get the saved books (wishlist) for the user.
     */
    public function savedBooks()
    {
        return $this->hasMany(UserSavedBook::class);
    }

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
        return $this->hasMany(Payment::class);
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
     * Scope a query to only include customers.
     */
    public function scopeCustomers($query)
    {
        return $query->where('user_type', 'customer');
    }

    /**
     * Scope a query to only include creators.
     */
    public function scopeCreators($query)
    {
        return $query->where('user_type', 'creator');
    }

    /**
     * Scope a query to only include admins.
     */
    public function scopeAdmins($query)
    {
        return $query->whereIn('user_type', ['admin', 'superadmin']);
    }

    // ==================== METHODS ====================

    /**
     * Check if user is admin.
     */
    public function isAdmin()
    {
        return in_array($this->user_type, ['admin', 'superadmin']);
    }

    /**
     * Check if user is member.
     */
    public function isMember()
    {
        return $this->user_type === 'member';
    }

    /**
     * Check if user is creator.
     */
    public function isCreator()
    {
        return $this->user_type === 'creator';
    }

    /**
     * Check if user has active subscription.
     */
    public function hasActiveSubscription()
    {
        return $this->subscriptions()
            ->where('status', 'active')
            ->where('end_date', '>=', now())
            ->exists();
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
}
