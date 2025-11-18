<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'role_id',
        'assigned_by',
        'assigned_at',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
    ];

    /**
     * Get the user that owns the role.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the role.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the user who assigned this role.
     */
    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}
