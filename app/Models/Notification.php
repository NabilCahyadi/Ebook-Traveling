<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'type',
        'title',
        'message',
        'action_url',
        'icon',
    ];

    /**
     * Get the user notifications.
     */
    public function userNotifications()
    {
        return $this->hasMany(UserNotification::class);
    }
}
